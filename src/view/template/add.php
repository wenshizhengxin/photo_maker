<form role="form" class="epii" method="post" data-form="1" action="">

    <div class="form-group">
        <label>模板名称：</label>
        <input type="text" class="form-control" name="template_name" placeholder="请输入模板名称" value="{$template['template_name'] ? ""}">
    </div>
    <!--    <div class="form-group">-->
    <!--        <label>模板图：</label>-->
    <!--        <div style="width: 100%;user-select: none" data-upload-preview="1" data-input-id="img" data-mimetype="jpg,png,jpeg" data-multiple="0" data-maxcount="1"-->
    <!--             data-url="?app=template@upload_img"></div>-->
    <!--        <input type="hidden" class="form-control" name="img" id="img" value="-->
    <?php //echo $template['img'] ?? '' ?><!--" data-src="-->
    <?php //echo $template['img_src'] ?? '' ?><!--" required readonly>-->
    <!--    </div>-->
    <div class="form-group" id="logo" style="text-align: center; ">
        <label for="class">背景图：</label>
        <div data-upload-preview="1" data-input-id="img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount=1 style="width: 70%; margin: 0 0"></div>
        <input type="hidden"
               name="img"
               id="img"
               value="{? $template['img']}"
               data-src="{? $template['show_url']}">
    </div>

    <div class="form-group">
        <label>尺寸：</label>
        <select class="selectpicker" name="size_id" id="size_id">
            {:options,$sizeOptions,$template['size_id']?}
        </select>
    </div>

    <div class="form-group">
        <label>标签：</label>
        <div style="width: 100%" id="tag-list">
            <?php foreach ($tags as $tag): ?>
                <a id="tag-<?php echo $tag['id'] ?>" class="btn btn-default btn-sm" onclick="changeTags(<?php echo $tag['id'] ?>)" href="javascript:void(0)"><?php echo $tag['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <!--    <div style="min-height: 12rem;"></div>-->
    <div class="form-footer">
        <input type="hidden" name="tag_ids">
        <input type="hidden" name="id" value="{$template['id'] ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<script type="text/javascript" src="http://res.cmq2080.top/index.php?dir=js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
    var tagIds =<?php echo json_encode($template['tag_ids'] ?? [])?>;

    function renderTags(tagIds) {
        $("#tag-list a").removeClass("btn-success").addClass("btn-default");
        for (var i = 0; i < tagIds.length; i++) {
            $("a#tag-" + tagIds[i]).removeClass("btn-default").addClass("btn-success");
        }

        $("input[name='tag_ids']").val(tagIds.join(","));
    }

    renderTags(tagIds);

    function changeTags(id) {
        if (in_array(id, tagIds) === true) { // 去掉
            tagIds = array_delete(tagIds, id);
        } else { // 加上
            tagIds.push(id);
        }

        renderTags(tagIds);
    }

    function in_array(needle, haystack) {
        for (var i = 0; i < haystack.length; i++) {
            if (needle == haystack[i]) {
                return true;
            }
        }

        return false;
    }

    function array_delete(array, needle) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == needle) {
                array.splice(i, 1);
            }
        }

        return array;
    }
</script>