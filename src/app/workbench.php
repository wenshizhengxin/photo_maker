<?php
/**
 * 描述：
 * Created at 2021/5/14 15:15 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\server\Args;
use think\Db;
use epii\server\Response;
use epii\server\Tools;
use wenshizhengxin\image_synthesizer\libs\AddBackground;
use wenshizhengxin\image_synthesizer\libs\AddFrame;
use wenshizhengxin\preview_photo_maker\libs\Constant;
use wenshizhengxin\preview_photo_maker\libs\Helper;
use wenshizhengxin\preview_photo_maker\libs\Template as LibTemplate;

class workbench extends base
{
    public function index()
    {
        try {
            $fillTypeOptions = [
                ['id' => \wenshizhengxin\image_synthesizer\libs\Constant::FILL_TYPE_INNER, 'name' => '内填充'],
                ['id' => \wenshizhengxin\image_synthesizer\libs\Constant::FILL_TYPE_OUTER, 'name' => '外填充'],
            ];
            $this->assign('fillTypeOptions', $fillTypeOptions);

            $this->adminUiDisplay();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    //随机选中模板
    public function ajax_change_tem()
    {
        $imgId = Args::postVal('imgId');
        if (!$imgId) {
            echo json_encode(array('code' => 0, 'data' => ''), JSON_UNESCAPED_UNICODE);
            exit;
        }

        $list = Db::name(Constant::TABLE_TEMPLATE)
            ->orderRand()
            ->limit(4)
            ->select();
        if ($list) {
            echo json_encode(array('code' => 1, 'data' => $list), JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            echo json_encode(array('code' => 0, 'data' => ''), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function just_make_it()
    {
        try {
            $templateIds = explode(',', Args::params('template_ids/1'));
            $imageId = Args::params('image_id/d', 0);
            $imageUrl = Args::params('image_url/s/1');
            $frameId = Args::params('frame_id/d', 0);

            $templates = Db::name(Constant::TABLE_TEMPLATE)->where('id', 'in', $templateIds)
                ->field('id,template_name,img,position')->select();
            $data = [];
            $timestamp = time();

            $imageUrl2 = '';
            if ($frameId) { // 有添加边框？那先添加边框再说
                $frameWidth = Args::params('frame_width/d', 20);
                $frameFillType = Args::params('frame_fill_type/d', \wenshizhengxin\image_synthesizer\libs\Constant::FILL_TYPE_INNER);
                $frame = Db::name(Constant::TABLE_FRAME)->where('id', $frameId)->find();
                $maker = new AddFrame();
                $maker->addImage($imageUrl);
                $maker->setFillType($frameFillType);
                $maker->setWidth($frameWidth);
                $maker->addFrameImage('lt', Helper::getImageUrl($frame['left_top_img']));
                $maker->addFrameImage('t', Helper::getImageUrl($frame['top_img']));
                $maker->addFrameImage('rt', Helper::getImageUrl($frame['right_top_img']));
                $maker->addFrameImage('r', Helper::getImageUrl($frame['right_img']));
                $maker->addFrameImage('rb', Helper::getImageUrl($frame['right_bottom_img']));
                $maker->addFrameImage('b', Helper::getImageUrl($frame['bottom_img']));
                $maker->addFrameImage('lb', Helper::getImageUrl($frame['left_bottom_img']));
                $maker->addFrameImage('l', Helper::getImageUrl($frame['left_img']));

                $imageUrl2 = $maker->make();
                $imageUrl2 = str_replace(Tools::getRootFileDirectory() . '/', '', $imageUrl2);
            }

            $maker = new AddBackground();

//            $maker->setEndPosition(0, 0);

            foreach ($templates as $template) {
                $template['img_src'] = LibTemplate::getImgSrc($template['img']);
                $row = [
                    'template_id' => $template['id'],
                    'template_name' => $template['template_name'],
                    'template_url' => $template['img'],
                    'image_id' => $imageId,
                    'image_url' => $imageUrl, // 即使生成了边框，添加记录也得按原始图的url来算
                    'frame_id' => $frame['id'] ?? 0,
                    'frame_name' => $frame['frame_name'] ?? '',
                    'create_time' => $timestamp,
                ];
                $maker->addImage($imageUrl2 ?: $imageUrl); // 但是这里得传加边框后的图（如果真有的话）
                $maker->addBackgroundImage($template['img_src']);
                $p = explode(',', $template['position']);
                $maker->setStartPosition($p[0], $p[1]);
                $maker->setEndPosition($p[2], $p[3]);
                $row['result_image_url'] = $maker->make();
                $row['result_image_url'] = str_replace(Tools::getRootFileDirectory() . '/', '', $row['result_image_url']);

                $data[] = $row;
            }

            /************事务开始************/
            Db::startTrans();
            Db::name(Constant::TABLE_LOG_MAKING)->insertAll($data);

            $zip = new \ZipArchive();
            $zipBasename = $timestamp . mt_rand(100, 999) . '.zip';
            $zipPath = Tools::getRootFileDirectory() . '/upload/' . $zipBasename;
            if ($zip->open($zipPath, \ZipArchive::CREATE) === false) {
                throw new \Exception('压缩失败');
            }
            foreach (array_column($data, 'result_image_url') as $file) {
                $file = Tools::getRootFileDirectory() . '/' . $file;
                if (is_file($file) === false) {
                    continue;
                }
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            if (is_file($zipPath) === false) {
                throw new \Exception('zip文件最终未生成');
            }

            Db::commit();
            /************事务结束************/

            Response::success(['url' => 'upload/' . $zipBasename, 'file' => 'upload/' . $zipBasename]);
        } catch (\Exception $e) {
            Db::rollback();
            Response::error($e->getMessage());
        }
    }

    public function download_file()
    {
        try {
            $file = Args::params('file/s/1');
            $path = Tools::getRootFileDirectory() . '/' . $file;
            if (is_file($path) === false) {
                throw new \Exception('文件不存在');
            }
            ob_end_clean();
            header("Content-Type: application/force-download");
            header("Content-Transfer-Encoding: binary");
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=' . basename($path));
            header('Content-Length: ' . filesize($path));
            readfile($path);
            flush();
            ob_flush();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}