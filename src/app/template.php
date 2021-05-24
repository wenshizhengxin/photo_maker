<?php

namespace wenshizhengxin\preview_photo_maker\app;

use epii\orm\Db;
use epii\server\Args;
use epii\server\Response;
use wenshizhengxin\preview_photo_maker\libs\Constant;
use wenshizhengxin\preview_photo_maker\libs\Size as LibSize;
use wenshizhengxin\preview_photo_maker\libs\Tag as LibTag;
use wenshizhengxin\preview_photo_maker\libs\Template as LibTemplate;

class template extends base
{
    public function index()
    {
        try {

            $sizeOptions = LibSize::getOptions([], ['id' => 0, 'name' => '————请选择————']);
            $this->assign('sizeOptions', $sizeOptions);

            $this->adminUiDisplay();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function ajax_data()
    {
        try {
            $where = [];

            if ($template_name = Args::params('template_name')) {
                $where[] = [
                    't.template_name', 'like', '%' . $template_name . '%'
                ];
            }
            if ($size_id = Args::params('size_id')) {
                $where[] = [
                    't.size_id', 'like', '%' . $size_id . '%'
                ];
            }

            $query = Db::name(Constant::TABLE_TEMPLATE)->alias('t')
                ->leftJoin(Constant::TABLE_SIZE . ' s', 't.size_id=s.id')
                ->field('t.*,s.size_name')
                ->order('t.id desc');

            return $this->tableJsonData($query, $where, function ($row) {
                $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
                $row['tags_desc'] = LibTemplate::renderTags($row['id']);
//                $row['img_src'] = upload_file::getStorageRootDir() . $row['img'];
                $row['img_src'] = LibTemplate::getImgSrc($row['img']);
                return $row;
            });
        } catch (\Exception $e) {
        }
    }

    public function add()
    {
        try {
            $id = Args::params('id/d', 0);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $insertData = [
                    'template_name' => Args::params('template_name/s/1'),
                    'size_id' => Args::params('size_id/d/1'),
                    'img' => Args::params('img/s/1'),
                ];

                $timestamp = time();

                /************事务开始************/
                Db::startTrans();
                if ($id === 0) { // 新增
                    $insertData['create_time'] = $timestamp;
                    $res = Db::name('template')->insert($insertData, false, true);
                    if (!$res) {
                        throw new \Exception('添加失败');
                    }
                    $id = $res;
                } else { // 修改
                    $insertData['update_time'] = $timestamp;
                    $res = Db::name('template')->where('id', $id)->update($insertData);
                    if (!$res) {
                        throw new \Exception('修改失败');
                    }
                }

                // 标签变更
                $tagIds = array_filter(explode(',', Args::params('tag_ids')));
                $oldTagIds = Db::name(Constant::TABLE_TEMPLATE_TAG)->where('template_id', $id)->column('tag_id');
                $tmp = array_intersect($tagIds, $oldTagIds);
                $tagIds = array_diff($tagIds, $tmp);
                $oldTagIds = array_diff($oldTagIds, $tmp);
                // 去除旧的
                Db::name(Constant::TABLE_TEMPLATE_TAG)
                    ->where('template_id', $id)
                    ->where('tag_id', 'in', $oldTagIds)
                    ->delete();
                // 添加新的
                $insertData2 = [];
                foreach ($tagIds as $tagId) {
                    $insertData2[] = [
                        'template_id' => $id,
                        'tag_id' => $tagId,
                        'create_time' => $timestamp
                    ];
                }
                Db::name(Constant::TABLE_TEMPLATE_TAG)->insertAll($insertData2);

                Db::commit();
                /************事务结束************/

                $this->success();
            } else {
                if ($id > 0) {
                    $template = Db::name('template')->where('id', $id)->find();
                    $tagIds = Db::name(Constant::TABLE_TEMPLATE_TAG)
                        ->where('template_id', $id)
                        ->distinct(true)
                        ->column('tag_id');
                    $template['tag_ids'] = $tagIds;
                    $template['img_url'] = LibTemplate::getImgSrc($template['img']);

                    $this->assign('template', $template);
                }
//                $tagIds=[1,2];

                $sizeOptions = LibSize::getOptions([], ['id' => 0, 'name' => '————请选择————']);
                $this->assign('sizeOptions', $sizeOptions);
                $tagOptions = LibTag::getOptions(['status' => Constant::TAG_STATUS_ACTIVE]);
                $this->assign('tags', $tagOptions);

                $this->adminUiDisplay();
            }
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
    }

//    public function upload_img()
//    {
//        try {
//            $res = AdminUiUpload::doUpload();
//            exit($res);
//        } catch (\Exception $e) {
//            $this->error($e->getMessage());
//        }
//
//    }

    public function set_editing_area()
    {
        try {
            $id = Args::params('id/d/1');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $positionArr = [
                    Args::params('p1/d', null),
                    Args::params('p2/d', null),
                    Args::params('p3/d', null),
                    Args::params('p4/d', null),
                ];

                foreach ($positionArr as $key => $value) { // 负数归零
                    if ($value === null) {
                        Response::error('数据错误');
                    }
                    $positionArr[$key] = $value >= 0 ? $value : 0;
                }
                $position = implode(',', $positionArr);

                $res = Db::name(Constant::TABLE_TEMPLATE)->where('id', $id)->update(['position' => $position, 'update_time' => time()]);
                if (!$res) {
                    Response::error('设置区域失败');
                }
                Response::success('设置成功');
            } else {
                $template = Db::name(Constant::TABLE_TEMPLATE)->where('id', $id)->find();
                $template['img_src'] = LibTemplate::getImgSrc($template['img']);
                $p = explode(',', $template['position']);
                if (count($p) === 4) {
                    $this->assign('p', $p);
                }
                $this->assign('template', $template);
                $this->display();
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }

    public function del()
    {
        try {
            $id = Args::params('id');
            $res = Db::name('template')->where('id', $id)->delete();
            if (!$res) {
                throw new \Exception('删除失败');
            }

            $this->success();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
