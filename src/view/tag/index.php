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
                                <label>标签名称：</label>
                                <input type="text" class="form-control" name="tag_name" placeholder="请输入标签名称">
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
        <a class="btn btn-outline-primary btn-table-tool btn-dialog" data-intop="1" data-area="50%,70%" title="新增"
           href="?app=tag@add&__addons={$__addons}">新增</a>
    </div>
    <div class="card-body table-responsive" style="padding-top: 0px">
        <table data-table="1" data-url="?app=tag@ajax_data&__addons={$__addons}" id="table1" class="table table-hover">
            <thead>
            <tr>

                <th data-field="tag_name">标签名称</th>
                <th data-field="status" data-formatter="epiiFormatter.switch"   data-align="center"> 状态</th>
                <th data-field="create_time">添加时间</th>
                <th data-formatter="epiiFormatter.btns"
                    data-intop="1"
                    data-area="50%,70%"
                    data-btns="edit,del"
                    data-edit-url="?app=tag@add&id={id}&__addons={$__addons}"
                    data-edit-title="编辑"
                    data-del-url="?app=tag@del&id={id}&__addons={$__addons}"
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
        return '<a class="btn btn-outline-primary btn-sm" data-url="?app=tag@detail&id=' + row.wxid + '">示例</a>';
    }
</script>