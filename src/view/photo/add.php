<form role="form" class="epii" method="post" data-form="1" action="">

    <div class="form-group">
        <label>图片名称：</label>
        <input type="text" class="form-control" name="photo_name" placeholder="请输入图片名称" value="{$photo['photo_name'] ? ""}">
    </div>

    <div class="form-group" id="logo" style="text-align: center; ">
        <label for="class">logo：</label>
        <div data-upload-preview="1"
             data-input-id="url"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount=1 style="width: 70%; margin: 0 0"></div>
        <input type="hidden"
               name="url"
               id="url"
               value="{? $photo['url']}"
               data-src="{? $photo['show_url']}">
    </div>

    <div class="form-group">
        <label>描述：</label>
        <div class="form-group custom-date">
            <textarea name="description" cols="125" rows="5" style="width: 100%;">{$photo['description'] ? ""}</textarea>
        </div>
    </div>

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