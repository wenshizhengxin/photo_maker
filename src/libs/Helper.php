<?php
/**
 * 描述：
 * Created at 2021/5/19 15:46 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\libs;


use epii\server\Tools;

class Helper
{
    public static function getImageUrl($url)
    {
        if (strpos($url, 'http') === 0) { // 传到云端的，不管
            return $url;
        }
        return 'upload/' . str_replace('\\', '/', $url);
    }

    public static function getImagePath($path)
    {
        return Tools::getRootFileDirectory() . '/upload/' . str_replace('\\', '/', $path);
    }
}