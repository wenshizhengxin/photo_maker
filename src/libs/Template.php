<?php
/**
 * 描述：
 * Created at 2021/5/11 15:30 by 陈庙琴
 */

namespace wenshizhengxin\preview_photo_maker\libs;


use epii\orm\Db;

class Template
{
    public static function renderTags($id)
    {
        $tags = Db::name(Constant::TABLE_TEMPLATE_TAG)
            ->alias('tt')
            ->leftJoin(Constant::TABLE_TAG . ' t', 'tt.tag_id=t.id')
            ->where('tt.template_id', $id)
            ->select();

        $html = '';
        foreach ($tags as $tag) {
            $html .= '<a class="btn btn-success btn-sm" href="javascript:void(0)">' . $tag['tag_name'] . '</a>&nbsp;';

        }

        return $html;
    }

    public static function getImgSrc($img)
    {
        if (strpos($img, 'http') === 0) { // 传到云端的，不管
            return $img;
        }
        return 'upload/' . str_replace('\\', '/', $img);
    }
}