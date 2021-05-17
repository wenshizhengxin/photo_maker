<form role="form" class="epii" method="post" data-form="1" action="">

    <div class="form-group">
        <label>标签名称：</label>
        <input type="text" class="form-control" name="tag_name" placeholder="请输入标签名称" value="{$tag['tag_name'] ? ""}">
    </div>
    <div class="form-group">
        <label for="class">用户状态：</label><br>
        <select class="selectpicker" id="class" name="status">
            {:options,$status_arr,$tag['status']?"1"}
        </select>
    </div>
    <div class="form-footer">
        <input type="hidden" name="id" value="{$tag['id'] ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>