<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/11
 * Time: 10:32
 */

namespace wenshizhengxin\preview_photo_maker\app;


use epii\admin\center\admin_center_controller;
use epii\admin\ui\lib\epiiadmin\jscmd\Alert;
use epii\admin\ui\lib\epiiadmin\jscmd\Close;
use epii\admin\ui\lib\epiiadmin\jscmd\CloseAndRefresh;
use epii\admin\ui\lib\epiiadmin\jscmd\JsCmd;
use epii\admin\ui\lib\epiiadmin\jscmd\Refresh;

class base extends admin_center_controller
{
    /**
     * 功能：成功响应
     * Created at 2021/2/23 16:35 by 陈庙琴
     * @param string $msg
     * @param string $sufAction
     * @return array|false|string
     */
    public function success($msg = '成功', $sufAction = 'close_and_refresh')
    {
        if ($sufAction === 'close') {
            $action = Close::make();
        } else if ($sufAction === 'refresh') {
            $action = Refresh::make();
        } else {
            $action = CloseAndRefresh::make();
        }
        $cmd = Alert::make()->icon('6')->msg($msg)->onOk($action);

        exit(JsCmd::make()->addCmd($cmd)->run());
    }

    /**
     * 功能：失败响应
     * Created at 2021/2/23 16:35 by 陈庙琴
     * @param string $msg
     * @return array|false|string
     */
    public function error($msg = '失败')
    {
        $cmd = Alert::make()->icon('5')->msg($msg)->onOk(null);
        exit(JsCmd::make()->addCmd($cmd)->run());
    }
}