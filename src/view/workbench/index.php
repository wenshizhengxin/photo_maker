<style>
    #album img {
        max-width: 100%;
        cursor: pointer
    }

    #album a {
        margin-right: 0.5rem;
    }

    #frame_set img {
        max-width: 100%;
        cursor: pointer
    }

    #frame_set a {
        margin-right: 0.5rem;
    }

    #templatelist img {
        max-width: 100%;
        cursor: pointer
    }
</style>

<section class="content" style="padding: 10px">
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">①选择图片</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="image_id">
                    <input type="hidden" name="image_url">
                    <div class="btn-group" style="margin-bottom: 1rem">
                        <!--                        <button class="btn btn-default btn-sm">上传图片</button>-->
                        <button class="btn btn-default btn-sm" onclick="getImages()">从图库中选择</button>
                    </div>
                    <div id="album" style="display: none;">
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                        </div>-->
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                        </div>-->
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                            <div class="col-3">fas</div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">②选择边框（如果需要的话）</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="frame_id" value="">
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="">边框大小：</label>
                            <input type="number" class="form-control" name="frame_width" value="20">
                        </div>
                        <div class="form-group">
                            <label for="">填充方式：</label>
                            <select class="selectpicker" name="frame_fill_type" id="frame_fill_type">
                                {:options,$fillTypeOptions}
                            </select>
                        </div>
                    </div>
                    <div class="btn-group" style="margin-bottom: 1rem">
                        <button class="btn btn-default btn-sm" onclick="getFrames()">从边框库中选择</button>
                    </div>
                    <div id="frame_set" style="display: none;"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">③选择模板</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="template_id" value="">
                    <div class="btn-group" style="margin-bottom: 1rem">
                        <button class="btn btn-success btn-sm" onclick="onSelectTemplate();">随机选择模板</button>
                    </div>
                    <div id="templatelist" style="">
                        <!--                        <td>-->
                        <!--                            <a class="btn  btn-dialog"  title="点击查看图片" data-intop="1" data-area="60%,90%" data-url="https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg">-->
                        <!--                            <img width='22%' height='10%' src='https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg'>-->
                        <!--                            </a>-->
                        <!--                        </td>-->
                        <!--                        <td><img width='22%' height='10%' src='https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg'></td>-->
                        <!--                        <td><img width='22%' height='10%' src='https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg'></td>-->
                        <!--                        <td><img width='22%' height='10%' src='https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg'></td>-->
                        <!--                        <td><img width='22%' height='10%' src='https://wszxstore.blob.core.chinacloudapi.cn/wsoa/uploads/20210513/143712609cc9183c3b2.jpg'></td>-->
                    </div>


                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">④生成预览图</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group">
                        <button onclick="make()" class="btn btn-primary btn-sm">生成</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function getImages(page = 1, limit = 12) {
        $("#album").show();
        $.ajax({
            type: "POST",
            url: "?app=photo@ajax_data&__addons={$__addons}&offset=" + limit * (page - 1) + "&limit=" + limit,
            dataType: "json",
            async: false,
            data: {},
            success: function (res) {
                var rows = res.rows;
                var length = rows.length;
                var total = res.total;
                var html = '';
                for (var i = 0; i < parseInt((length - 1) / 4) + 1; i++) {
                    html += '<div class="row">';
                    for (var j = 0; j < 4; j++) {
                        var index = 4 * i + j;
                        console.log(index);
                        if (index >= length) {
                            break;
                        }
                        html += '<div class="col-3"><img src="' + rows[index].img_src + '" data-id="' + rows[index].id +
                            '" onclick="selectImage(this)"></div>';
                    }
                    html += '</div>';
                }
                html += getPageHtml(total, limit);
                console.log(html);
                $("#album").html(html);
            }
        });
    }

    function getFrames(page = 1, limit = 12) {
        $("#frame_set").show();
        $.ajax({
            type: "POST",
            url: "?app=frame@ajax_data&__addons={$__addons}&offset=" + limit * (page - 1) + "&limit=" + limit,
            dataType: "json",
            async: false,
            data: {},
            success: function (res) {
                var rows = res.rows;
                var length = rows.length;
                var total = res.total;
                var html = '';
                for (var i = 0; i < parseInt((length - 1) / 4) + 1; i++) {
                    html += '<div class="row">';
                    for (var j = 0; j < 4; j++) {
                        var index = 4 * i + j;
                        console.log(index);
                        if (index >= length) {
                            break;
                        }
                        html += '<div class="col-3"><img src="' + rows[index].left_top_img_src + '" data-id="' + rows[index].id +
                            '" onclick="selectFrame(this)"></div>';
                    }
                    html += '</div>';
                }
                html += getPageHtml2(total, limit);
                console.log(html);
                $("#frame_set").html(html);
            }
        });
    }

    function getPageHtml(total, limit = 12) {
        html = '';
        if (total <= limit) { // 不分页
            return html;
        }

        for (i = 0; i < parseInt((total + limit - 1) / limit); i++) {
            page = i + 1;
            html += '<a class="btn btn-primary btn-sm" href="javascript:getImages(' + page + ')">' + page + '</a>';
        }

        return html;
    }

    function getPageHtml2(total, limit = 12) {
        html = '';
        if (total <= limit) { // 不分页
            return html;
        }

        for (i = 0; i < parseInt((total + limit - 1) / limit); i++) {
            page = i + 1;
            html += '<a class="btn btn-primary btn-sm" href="javascript:getFrames(' + page + ')">' + page + '</a>';
        }

        return html;
    }

    function selectImage(obj) {
        if (!confirm("确定选择这张图片吗？")) {
            return;
        }
        var src = $(obj).attr("src");
        var id = $(obj).attr("data-id");
        $("input[name='image_id']").val(id);
        $("input[name='image_url']").val(src);
        alert("已选择图片");
        $("#album div.col-3").css({"border": "0"});
        $(obj).parent().css({"border": "4px solid #F00"});
        // $("#album").hide();
    }

    function selectFrame(obj) {
        if (!confirm("确定选择此边框吗？")) {
            return;
        }
        var src = $(obj).attr("src");
        var id = $(obj).attr("data-id");
        $("input[name='frame_id']").val(id);
        alert("已选择边框");
        $("#frame_set div.col-3").css({"border": "0"});
        $(obj).parent().css({"border": "4px solid #F00"});
        // $("#album").hide();
    }

    function onSelectTemplate() {

        //if(){} 判断是否选中图片
        var imgId = 1;
        $.ajax({
            url: '?app=workbench@ajax_change_tem&__addons={$__addons}',
            type: 'POST',
            dataType: 'json',
            data: {imgId: 1},
            success: function (res) {
                if (res.code == 1) {
                    var rows = data = res.data;
                    var length = data.length;
                    $("#templatelist").empty();
                    var html = '';
                    var tid = '';
                    for (var i = 0; i < parseInt((length - 1) / 4) + 1; i++) {
                        html += '<div class="row">';
                        for (var j = 0; j < 4; j++) {
                            var index = 4 * i + j;
                            console.log(index);
                            if (index >= length) {
                                break;
                            }
                            html += '<div class="col-3"><img src="' + rows[index].img + '" data-id="' + rows[index].id + '"></div>';
                            tid += rows[index].id + ",";
                        }
                        html += '</div>';
                    }
                    console.log(html);
                    // for (var i = 0; i < data.length; i++) {
                    //     html += "<td><img width='280px' height='400px' src='" + data[i]['img'] + "'></td>";
                    //     tid += data[i]['id'] + ",";
                    //     $("#templatelist").html(html);
                    // }
                    $("#templatelist").html(html);
                    tid = tid.substr(0, tid.length - 1);
                    $("input[name='template_id']").val(tid);
                } else {
                    $("#templatelist").html('暂无模板');
                }

                // $('#templatelist').selectpicker('refresh');//刷新

            }
        })
    }


    window.onEpiiInit(function () {
        //onSelectType(1);
        // userChange({ ? $info.u_type 1
    });

    function make() {
        var templateIds = $("input[name='template_id']").val();
        var imageId = $("input[name='image_id']").val();
        var imageUrl = $("input[name='image_url']").val();
        var frameId = $("input[name='frame_id']").val();
        var frameWidth = $("input[name='frame_width']").val();
        var frameFillType = $("#frame_fill_type option:selected").val();
        if (imageUrl.length === 0) {
            alert("请选择图片");
            return;
        }
        if (templateIds.length === 0) {
            alert("请选择模板");
            return;
        }
        $.ajax({
            type: "POST",
            url: "?app=workbench@just_make_it&__addons={$__addons}",
            dataType: "json",
            async: false,
            data: {
                "template_ids": templateIds,
                "image_id": imageId,
                "image_url": imageUrl,
                "frame_id": frameId,
                "frame_width": frameWidth,
                "frame_fill_type": frameFillType
            },
            success: function (res) {
                if (res.code !== 1) {
                    alert(res.msg);
                    return;
                }
                if (res.data.file) {
                    window.location.href = "?app=workbench@download_file&__addons={$__addons}&file=" + res.data.file;
                }
            }
        })
    }
</script>