<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/11
 * Time: 10:58
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\orm\Db;
use epii\server\Args;
use wenshizhengxin\preview_photo_maker\libs\Constant;

class tag extends base
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

            if ($tag_name = Args::params('tag_name')) {
                $where[] = [
                    'tag_name', 'like', '%' . $tag_name . '%'
                ];
            }


            return $this->tableJsonData(Constant::TABLE_TAG, $where, function ($row) {
                $row['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
                $data['status'] = $row['status'] == '1' ? "1" : "0";
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
                    'tag_name' => Args::params('tag_name/s/1'),
                    'status' => Args::params('status/d'),
                ];
                // 验证输入
                $res = $this->validateData($insertData, $id);
                if ($res !== '') {
                    throw new \Exception($res);
                }

                $timestamp = time();

                /************事务开始************/
                Db::startTrans();
                if ($id === 0) { // 新增
                    $insertData['create_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_TAG)->insert($insertData, false, true);
                    if (!$res) {
                        throw new \Exception('添加失败');
                    }
                } else { // 修改
                    $insertData['update_time'] = $timestamp;
                    $res = Db::name(Constant::TABLE_TAG)->where('id', $id)->update($insertData);
                    if (!$res) {
                        throw new \Exception('修改失败');
                    }
                }
                Db::commit();
                /************事务结束************/

                $this->success();
            } else {
                if ($id > 0) {
                    $tag = Db::name(Constant::TABLE_TAG)->where('id', $id)->find();
                    $this->assign('tag', $tag);
                }

                $this->assign("status_arr", [["value" => "1", "text" => "启用"], ["value" => "0", "text" => "停用"]]);
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
            $res = Db::name(Constant::TABLE_TAG)->where('id', $id)->delete();
            if (!$res) {
                throw new \Exception('删除失败');
            }

            $this->success();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function validateData($insertData, $id = 0)
    {
        $data = Db::name(Constant::TABLE_TAG)
            ->where('tag_name', $insertData['tag_name'])
            ->where('id', '<>', $id)
            ->value('id');
        if ($data) {
            return '标签名称已存在';
        }

        return '';
    }
}