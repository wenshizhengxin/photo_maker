<?php
/**
 * 描述：
 * Created at 2021/5/21 14:08 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\orm\Db;
use epii\server\Args;
use wenshizhengxin\preview_photo_maker\libs\Constant;
use wenshizhengxin\preview_photo_maker\libs\Helper;

class frame extends base
{
    public function index()
    {
        try {
            $this->adminUiDisplay();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function ajax_data()
    {
        try {
            $where = [];

            if ($frame_name = Args::params('frame_name/s')) {
                $where[] = [
                    'frame_name', 'like', '%' . $frame_name . '%'
                ];
            }

            return $this->tableJsonData('frame', $where, function ($row) {
                $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
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

                    'frame_name' => Args::params('frame_name/s/1'),
                    'left_top_img' => Args::params('left_top_img/s/1'),
                    'top_img' => Args::params('top_img/s/1'),
                    'right_top_img' => Args::params('right_top_img/s/1'),
                    'right_img' => Args::params('right_img/s/1'),
                    'right_bottom_img' => Args::params('right_bottom_img/s/1'),
                    'bottom_img' => Args::params('bottom_img/s/1'),
                    'left_bottom_img' => Args::params('left_bottom_img/s/1'),
                    'left_img' => Args::params('left_img/s/1'),
                ];

                $timestamp = time();

                /************事务开始************/
                Db::startTrans();
                if ($id === 0) { // 新增
                    $insertData['create_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_FRAME)->insert($insertData, false, true);
                    if (!$res) {
                        throw new \Exception('添加失败');
                    }
                } else { // 修改
                    $insertData['update_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_FRAME)->where('id', $id)->update($insertData);
                    if (!$res) {
                        throw new \Exception('修改失败');
                    }
                }
                Db::commit();
                /************事务结束************/

                $this->success();
            } else {
                if ($id > 0) {
                    $frame = Db::name(Constant::TABLE_FRAME)->where('id', $id)->find();
                    $frame['left_top_img_url'] = Helper::getImageUrl($frame['left_top_img']);
                    $frame['top_img_url'] = Helper::getImageUrl($frame['top_img']);
                    $frame['right_top_img_url'] = Helper::getImageUrl($frame['right_top_img']);
                    $frame['right_img_url'] = Helper::getImageUrl($frame['right_img']);
                    $frame['right_bottom_img_url'] = Helper::getImageUrl($frame['right_bottom_img']);
                    $frame['bottom_img_url'] = Helper::getImageUrl($frame['bottom_img']);
                    $frame['left_bottom_img_url'] = Helper::getImageUrl($frame['left_bottom_img']);
                    $frame['left_img_url'] = Helper::getImageUrl($frame['left_img']);
                    $this->assign('frame', $frame);
                }

                $this->adminUiDisplay();
            }
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
    }

    public function del()
    {
        try {
            $id = Args::params('id');
            $res = Db::name(Constant::TABLE_FRAME)->where('id', $id)->delete();
            if (!$res) {
                throw new \Exception('删除失败');
            }

            $this->success();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}