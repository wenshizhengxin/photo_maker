<?php

namespace wenshizhengxin\preview_photo_maker\app;

use epii\orm\Db;
use epii\server\Args;
use wenshizhengxin\preview_photo_maker\libs\Constant;
use wenshizhengxin\preview_photo_maker\libs\Size as LibSize;
use wenshizhengxin\preview_photo_maker\libs\Tag as LibTag;
use wenshizhengxin\preview_photo_maker\libs\Template as LibTemplate;

class photo extends base
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

            if ($photo_name = Args::params('photo_name')) {
                $where[] = [
                    't.photo_name', 'like', '%' . $photo_name . '%'
                ];
            }

//            $query = Db::name(Constant::TABLE_IMAGE)->alias('t')
//                ->leftJoin(Constant::TABLE_SIZE . ' s', 't.size_id=s.id')
//                ->field('t.*,s.size_name')
//                ->order('t.id desc');
            $query = Db::name(Constant::TABLE_IMAGE);
            return $this->tableJsonData($query, $where, function ($row) {
                $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);

                $row['img_src'] = LibTemplate::getImgSrc($row['url']);//upload_file::getStorageRootDir() . $row['img'];
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
                    'photo_name' => Args::params('photo_name/s/1'),
                    'url' => Args::params('url/s/1'),
                    'description' => Args::params('description/s'),
                ];

                $timestamp = time();

                /************事务开始************/
                Db::startTrans();
                if ($id === 0) { // 新增
                    $insertData['create_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_IMAGE)->insert($insertData, false, true);
                    if (!$res) {
                        throw new \Exception('添加失败');
                    }
                    $id = $res;
                } else { // 修改
                    $insertData['update_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_IMAGE)->where('id', $id)->update($insertData);
                    if (!$res) {
                        throw new \Exception('修改失败');
                    }
                }


                Db::commit();
                /************事务结束************/

                $this->success();
            } else {
                if ($id > 0) {
                    $photo = Db::name(Constant::TABLE_IMAGE)->where('id', $id)->find();
                    $photo['show_url'] = "";

                    $tmp = [];
                    foreach (explode(',', $photo['url']) as $url) {
                        $tmp[] = LibTemplate::getImgSrc($url);
                    }
                    $photo['show_url'] = implode(',', $tmp);

                    $this->assign('photo', $photo);
                }

                $this->adminUiDisplay();
            }
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
    }


    public function set_editing_area()
    {
        try {
            $id = Args::params('id/d', 0);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            } else {
                $template = Db::name(Constant::TABLE_TEMPLATE)->where('id', $id)->find();
                $template['img_src'] = LibTemplate::getImgSrc($template['img']);
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
            $res = Db::name(Constant::TABLE_IMAGE)->where('id', $id)->delete();
            if (!$res) {
                throw new \Exception('删除失败');
            }

            $this->success('删除成功', 'refresh');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
