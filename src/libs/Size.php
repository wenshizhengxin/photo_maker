<?php
/**
 * 描述：
 * Created at 2021/5/11 14:19 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\libs;


use epii\orm\Db;

class Size
{
    public static function getOptions($where = [], $unshiftArray = null)
    {
        $data = Db::name(Constant::TABLE_SIZE)
            ->where($where)
            ->field('id,size_name as name')
            ->select();

        if ($unshiftArray !== null) {
            array_unshift($data, $unshiftArray);
        }

        return $data;
    }
}