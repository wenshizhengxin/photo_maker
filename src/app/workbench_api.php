<?php
/**
 * 描述：
 * Created at 2021/5/14 15:15 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\server\Args;
use epii\ui\upload\AdminUiUpload;
use think\Db;
use epii\server\Response;
use epii\server\Tools;
use wenshizhengxin\image_synthesizer\libs\AddBackground;
use wenshizhengxin\preview_photo_maker\libs\Constant;
use wenshizhengxin\preview_photo_maker\libs\Helper;
use wenshizhengxin\preview_photo_maker\libs\Template as LibTemplate;

class workbench_api extends base_api
{
    public function test()
    {
        $this->success(['time' => time(), 'ip' => $_SERVER['REMOTE_ADDR']]);
    }

    /**
     * 功能：快速构建图片
     * Created at 2021/5/19 15:36 by Temple Chan
     */
    public function quick_make()
    {
        try {
            $result = AdminUiUpload::do_upload(["gif", "jpeg", "jpg", "png"], 1048576 * 8);

            $urlList = $result['url'];
            $pathList = $result['path'];
            $templates = Db::name(Constant::TABLE_TEMPLATE)
                ->orderRand()
                ->limit(4)
                ->select();
            if (!$templates) {
                throw new \Exception('没有模板');
            }

            $timestamp = time();
            $maker = new AddBackground();
            $urlGroups = [];
            foreach (explode(',', $pathList) as $url) {
                $imageUrl = Helper::getImageUrl($url);
                $imagePath = Helper::getImagePath($url);
                if (is_file($imageUrl) == false) {
                    throw new \Exception('上传文件缺失：' . $imageUrl);
                }
                $ugKey = basename($imagePath, PATHINFO_BASENAME);
                $urlGroups[$ugKey] = [];

                foreach ($templates as $template) {
                    $template['img_src'] = Helper::getImageUrl($template['img']);
                    $row = [
                        'template_id' => $template['id'],
                        'template_name' => $template['template_name'],
                        'template_url' => $template['img'],
                        'image_id' => 0,
                        'image_url' => $imageUrl,
                        'create_time' => $timestamp,
                    ];
                    $maker->addImage($imagePath);
                    $maker->addBackgroundImage($template['img_src']);
                    $p = explode(',', $template['position']);
                    $maker->setStartPosition($p[0], $p[1]);
                    $maker->setEndPosition($p[2], $p[3]);
                    $row['result_image_url'] = $maker->make();
                    $row['result_image_url'] = str_replace(Tools::getRootFileDirectory() . '/', '', $row['result_image_url']);

                    $urlGroups[$ugKey][] = $row['result_image_url'];
                    $data[] = $row;
                }
            }

            /************事务开始************/
            Db::startTrans();
            Db::name(Constant::TABLE_LOG_MAKING)->insertAll($data);

            $resultImageUrls = array_column($data, 'result_image_url');

//            $zip = new \ZipArchive();
//            $zipBasename = $timestamp . mt_rand(100, 999) . '.zip';
//            $zipPath = Tools::getRootFileDirectory() . '/upload/' . $zipBasename;
//            if ($zip->open($zipPath, \ZipArchive::CREATE) === false) {
//                throw new \Exception('压缩失败');
//            }
//            foreach (array_column($data, 'result_image_url') as $file) {
//                if (is_file($file) === false) {
//                    continue;
//                }
//                $zip->addFile($file, basename($file));
//            }
//            $zip->close();
//            if (is_file($zipPath) === false) {
//                throw new \Exception('zip文件最终未生成');
//            }

            Db::commit();
            /************事务结束************/

            $this->success(['urls' => $resultImageUrls, 'url_groups' => $urlGroups]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}