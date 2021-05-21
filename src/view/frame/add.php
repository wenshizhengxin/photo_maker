<form role="form" class="epii" method="post" data-form="1" action="">

    <div class="form-group">
        <label>边框名称：</label>
        <input type="text" class="form-control" name="frame_name" placeholder="请输入边框名称" value="{$frame['frame_name'] ? ""}">
    </div>
    <div class="form-group">
        <label>左上角图片：</label>
        <div data-upload-preview="1" data-input-id="left_top_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="left_top_img" id="left_top_img" placeholder="请输入左上角图片" value="{$frame['left_top_img'] ? ""}"
        data-src="{$frame['left_top_img_url']}">
    </div>
    <div class="form-group">
        <label>上边缘图片：</label>
        <div data-upload-preview="1" data-input-id="top_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="top_img" id="top_img" placeholder="请输入上边缘图片" value="{$frame['top_img'] ? ""}"
        data-src="{$frame['top_img_url']}">
    </div>
    <div class="form-group">
        <label>右上角图片：</label>
        <div data-upload-preview="1" data-input-id="right_top_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="right_top_img" id="right_top_img" placeholder="请输入右上角图片" value="{$frame['right_top_img'] ? ""}"
        data-src="{$frame['right_top_img_url']}">
    </div>
    <div class="form-group">
        <label>右边缘图片：</label>
        <div data-upload-preview="1" data-input-id="right_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="right_img" id="right_img" placeholder="请输入右边缘图片" value="{$frame['right_img'] ? ""}"
        data-src="{$frame['right_img_url']}">
    </div>
    <div class="form-group">
        <label>右下角图片：</label>
        <div data-upload-preview="1" data-input-id="right_bottom_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="right_bottom_img" id="right_bottom_img" placeholder="请输入右下角图片" value="{$frame['right_bottom_img'] ? ""}"
        data-src="{$frame['right_bottom_img_url']}">
    </div>
    <div class="form-group">
        <label>下边缘图片：</label>
        <div data-upload-preview="1" data-input-id="bottom_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="bottom_img" id="bottom_img" placeholder="请输入下边缘图片" value="{$frame['bottom_img'] ? ""}"
        data-src="{$frame['bottom_img_url']}">
    </div>
    <div class="form-group">
        <label>左下角图片：</label>
        <div data-upload-preview="1" data-input-id="left_bottom_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="left_bottom_img" id="left_bottom_img" placeholder="请输入左下角图片" value="{$frame['left_bottom_img'] ? ""}"
        data-src="{$frame['left_bottom_img_url']}">
    </div>
    <div class="form-group">
        <label>左边缘图片：</label>
        <div data-upload-preview="1" data-input-id="left_img"
             data-multiple="0"
             data-mimetype="pdf,jpg,png,jpeg,gif"
             data-maxcount="1"></div>
        <input type="hidden" class="form-control" name="left_img" id="left_img" placeholder="请输入左边缘图片" value="{$frame['left_img'] ? ""}"
        data-src="{$frame['left_img_url']}">
    </div>
    <div class="form-footer">
        <input type="hidden" name="id" value="{$frame['id'] ? 0}">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>