<form role="form" class="epii" method="post" data-form="1" action="">

    <div class="form-group">
        <label>尺寸名称：</label>
        <input type="text" class="form-control" name="size_name" placeholder="请输入尺寸名称" value="{$size['size_name'] ? ""}">
    </div>
    <div class="form-footer">
        <input type="hidden" name="id" value="{$size['id'] ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>