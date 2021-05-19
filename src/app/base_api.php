<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/11
 * Time: 10:32
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\admin\center\admin_center_addons_controller;
use epii\admin\center\api\api;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\Close;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;
use epii\server\Tools;
use epii\template\engine\EpiiViewEngine;
use wenshizhengxin\preview_photo_maker\libs\Constant;

class base_api extends api
{
    protected function doAuth(): bool
    {
        return true;
    }

    /**
     * 功能：成功响应
     * Created at 2021/2/23 16:35 by Temple Chan
     * @param string $msg
     * @param string $sufAction
     * @return array|false|string
     */
//    public function success($msg = '成功', $data = [])
//    {
//        exit(json_encode(['code' => 1, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE));
//    }

    /**
     * 功能：失败响应
     * Created at 2021/2/23 16:35 by Temple Chan
     * @param string $msg
     * @return array|false|string
     */
//    public function error($msg = '失败', $data = [])
//    {
//        exit(json_encode(['code' => 0, 'msg' => $msg, 'data' => $data], JSON_UNESCAPED_UNICODE));
//    }
}