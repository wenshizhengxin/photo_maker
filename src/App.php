<?php

/**
 * Created by PhpStorm.
 * User: Adminstrator
 * Date: 2020/5/21
 * Time: 9:18
 */

namespace wenshizhengxin\preview_photo_maker;

use epii\admin\center\config\Settings;
use epii\admin\center\libs\AddonsApp;
use wenshizhengxin\preview_photo_maker\libs\Constant;

class App extends AddonsApp
{

    public function install(): bool
    {
        // TODO: Implement install() method.
        // 执行sql文件
        $res = $this->execSqlFile(__DIR__ . "/data/sql/install.sql", "epii_");
        if (!$res) {
            return false;
        }
        // 初始化配置
        $initSettings = require __DIR__ . '/data/setting/setting.php';
        foreach ($initSettings as $setting) {
            Settings::set(Constant::ADDONS . '.' . $setting['name'], $setting['value'], 0, 2, $setting['note']);
        }

        // 添加菜单及子菜单
        $pid = $this->addMenuHeader("预览中心");
        if (!$pid) {
            return false;
        }
        $id = $this->addMenu($pid, '工作台', '?app=workbench@index&__addons=' . Constant::ADDONS);
        if (!$id) {
            return false;
        }
        $id = $this->addMenu($pid, '图片列表', '?app=photo@index&__addons=' . Constant::ADDONS);
        if (!$id) {
            return false;
        }
        $id = $this->addMenu($pid, '模板列表', '?app=template@index&__addons=' . Constant::ADDONS);
        if (!$id) {
            return false;
        }
        $id = $this->addMenu($pid, '标签列表', '?app=tag@index&__addons=' . Constant::ADDONS);
        if (!$id) {
            return false;
        }
        $id = $this->addMenu($pid, '尺寸列表', '?app=size@index&__addons=' . Constant::ADDONS);
        if (!$id) {
            return false;
        }

        return true;
    }

    public function update($new_version, $old_version): bool
    {
        // TODO: Implement update() method.
        //        $updateSql = __DIR__ . '/data/update_sql/' . $old_version . '-' . $new_version . '.sql';
        ////        if (is_file($updateSql) === true) {
        ////            $res = $this->execSqlFile($updateSql, "epii_");
        ////            if (!$res) {
        ////                return false;
        ////            }
        ////        }

        return true;
    }

    public function onOpen(): bool
    {
        // TODO: Implement onOpen() method.
        return true;
    }

    public function onClose(): bool
    {
        // TODO: Implement onClose() method.
        return true;
    }
}
