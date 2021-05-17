<section class="content" style="padding: 10px">
    <div class="row">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">搜索</h3>
                </div>
                <div class="card-body">
                    <form role="form" data-form="1" data-search-table-id="1" data-title="自定义标题">
                        <div class="form-inline">

                            <div class="form-group">
                                <label>图片名称：</label>
                                <input type="text" class="form-control" name="photo_name" placeholder="请输入图片名称">
                            </div>

                        </div>
                        <div class="form-inline">
                            <div class="form-group" style="margin-left: 10px">
                                <button type="submit" class="btn btn-primary">提交</button>
                                <button type="reset" class="btn btn-default">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="content">
    <div class="card-body table-responsive" style="padding-top: 0px">
        <a class="btn btn-outline-primary btn-table-tool btn-dialog" data-intop="1" data-area="90%,90%" title="新增"
           href="?app=photo@add&__addons={$__addons}">新增</a>
    </div>
    <div class="card-body table-responsive" style="padding-top: 0px">
        <table data-table="1" data-url="?app=photo@ajax_data&__addons={$__addons}" id="table1" class="table table-hover">
            <thead>
            <tr>
                <th data-field="photo_name">图片名称</th>
                <th data-field="img_src" data-formatter="epiiFormatter.img" data-align="center">logo</th>
                <th data-field="description" data-width="30%">描述</th>
                <!--                <th data-field="tags_desc">标签</th>-->
                <th data-field="create_time">添加时间</th>
                <th data-formatter="epiiFormatter.btns"
                    data-intop="1"
                    data-btns="edit1,del"
                    data-del-url="?app=photo@del&id={id}&__addons={$__addons}"
                    data-del-title="删除"
                >操作
                </th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    function example(field_value, row, index, field_name) {
        return '<a class="btn btn-outline-primary btn-sm" data-url="?app=template@detail&id=' + row.wxid + '">示例</a>';
    }

    function edit1(field_value, row, index, field_name) {
        return "<a class='btn btn-outline-info btn-sm btn-dialog' data-intop=\"1\" data-area=\"90%,90%\" data-title='编辑' href='?app=photo@add&id=" + row.id + "&__addons={$__addons}'><i class='fa fa-pencil-square-o' ></i>编辑</a>";
    }

    // function matching(field_value, row, index, field_name) {
    //     return '<a class="btn btn-outline-primary btn-sm btn-dialog" data-intop="1" data-area="100%,100%" title="随机匹配" href="?app=photo@set_editing_area&id=' + row.id + '&__addons={$__addons}">随机匹配</a>';
    // }

    function setEditingArea(field_value, row, index, field_name) {
        return '<a class="btn btn-outline-primary btn-sm btn-dialog" data-intop="1" data-area="100%,100%" title="设置编辑区域" href="?app=photo@set_editing_area&id=' + row.id + '&__addons={$__addons}">设置区域</a>';
    }


</script>