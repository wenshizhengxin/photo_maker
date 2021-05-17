<?php
/**
 * 描述：
 * Created at 2021/5/11 15:04 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\libs;


use epii\orm\Db;

class Tag
{
    public static function getOptions($where = [], $unshiftArray = null)
    {
        $data = Db::name(Constant::TABLE_TAG)
            ->where($where)
            ->field('id,tag_name as name')
            ->select();

        if ($unshiftArray !== null) {
            array_unshift($data, $unshiftArray);
        }

        return $data;
    }
}