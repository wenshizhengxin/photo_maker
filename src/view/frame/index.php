<!--<section class="content" style="padding: 10px">-->
<!--    <div class="row">-->
<!--        <div class="col-12">-->
<!--            <div class="card card-default">-->
<!--                <div class="card-header">-->
<!--                    <h3 class="card-title">搜索</h3>-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                    <form role="form" data-form="1" data-search-table-id="1" data-title="自定义标题">-->
<!--                        <div class="form-inline">-->
<!---->
<!--                        </div>-->
<!--                        <div class="form-inline">-->
<!--                            <div class="form-group" style="margin-left: 10px">-->
<!--                                <button type="submit" class="btn btn-primary">提交</button>-->
<!--                                <button type="reset" class="btn btn-default">重置</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->


<div class="content">
    <div class="card-body table-responsive" style="padding-top: 0px">
        <a class="btn btn-outline-primary btn-table-tool btn-dialog" data-intop="1" data-area="50%,70%" title="新增"
           href="?app=frame@add&__addons={$__addons}">新增</a>
    </div>
    <div class="card-body table-responsive" style="padding-top: 0px">
        <table data-table="1" data-url="?app=frame@ajax_data&__addons={$__addons}" id="table1" class="table table-hover">
            <thead>
            <tr>

                <th data-field="frame_name">边框名称</th>
                <th data-field="create_time">创建时间</th>
                <th data-field="left_top_img">样图（左上角）</th>
                <th data-formatter="epiiFormatter.btns"
                    data-intop="1"
                    data-area="50%,70%"
                    data-btns="myEdit,del"
                    data-del-url="?app=frame@del&id={id}&__addons={$__addons}"
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
        return '<a class="btn btn-outline-primary btn-sm" data-intop="1" data-area="50%,70%" title="编辑" data-url="?app=frame@detail&id=' + row.wxid + '">示例</a>';
    }

    function myEdit(field_value, row, index, field_name) {
        return '<a class="btn btn-outline-primary btn-sm btn-dialog" data-intop="1" data-area="50%,70%" title="编辑" href="?app=frame@add&id=' + row.id + '&__addons={$__addons}"><i class="fa fa-pencil"></i>编辑</a>';
    }
</script>