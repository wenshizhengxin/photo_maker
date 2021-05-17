<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="http://res.cmq2080.top/index.php?dir=js/jquery-2.1.4.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        .main {
            width: 800px;
            height: 800px;
            margin-left: 50px;
            margin-right: 50px;
            background-color: #000000;
            position: relative;
        }

        .box {
            width: 200px;
            height: 200px;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, 0);
        }

        /*四边*/

        .box .t,
        .box .b,
        .box .l,
        .box .r {
            position: absolute;
            z-index: 1;
            background: #666;
        }

        .box .l,
        .box .r {
            width: 4px;
            height: 100%;
            cursor: col-resize;
        }

        .box .t,
        .box .b {
            width: 100%;
            height: 4px;
            cursor: row-resize;
        }

        .box .t {
            top: 0;
        }

        .box .b {
            bottom: 0;
        }

        .box .l {
            left: 0;
        }

        .box .r {
            right: 0;
        }

        /*四角*/

        .box .tl,
        .box .bl,
        .box .br,
        .box .tr {
            width: 10px;
            height: 10px;
            position: absolute;
            background: #fff;
            border: 1px solid #666;
            z-index: 2;
            cursor: nwse-resize
        }

        .box .tl,
        .box .bl {
            left: -5px;
        }

        .box .tr,
        .box .br {
            right: -5px;
        }

        .box .br,
        .box .bl {
            bottom: -5px;
        }

        .box .tl,
        .box .tr {
            top: -5px;
        }

        .box .tr,
        .box .bl {
            cursor: nesw-resize;
        }

        /*内核*/

        .inner {
            width: 100%;
            height: 100%;
            z-index: 100;
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>
<div class="main">
    <div class="box" id="odiv">
        <!--右边-->
        <span class="r"></span>
        <!--左边-->
        <span class="l"></span>
        <!--上边-->
        <span class="t"></span>
        <!--下边-->
        <span class="b"></span>
        <!--右下角-->
        <span class="br"></span>
        <!--左下角-->
        <span class="bl"></span>
        <!-- 右上角-->
        <span class="tr"></span>
        <!--左上角-->
        <span class="tl"></span>
        <!--<img class="inner" src="https://gss0.bdstatic.com/70cFsjip0QIZ8tyhnq/img/iknow/730-350-0.jpg">-->
        <div class="inner"></div>
    </div>
</div>
<!-- 将边线的缩放也加了 -->
<button style="background:#007bff;color: #ffffff;padding: 0.3rem;border: 0;border-radius: 0.3rem;position: fixed;top: 0;left: 0;"
        onclick="savePosition()">保存
</button>

<script type="text/javascript">
    var x1 = {$p[0] ? 0}, y1 = {$p[1] ? 0}, x2 = {$p[2] ? 100}, y2 = {$p[3] ? 100};
    window.onload = function () {
        var main = document.getElementsByTagName('div')[0];
        main.style.background = "url({$template['img_src']}) no-repeat";

        console.log(main.style.backgroundColor)
        var oDiv = document.getElementsByTagName('div')[1];
        var aSpan = oDiv.getElementsByTagName('span');
        for (var i = 0; i < aSpan.length; i++) {
            dragFn(aSpan[i]);
        }
        console.log("111", oDiv.offsetWidth)

        function dragFn(obj) {
            obj.onmousedown = function (ev) {
                var oEv = ev || event;
                oEv.stopPropagation();
                var oldWidth = oDiv.offsetWidth;
                var oldHeight = oDiv.offsetHeight;
                var oldX = oEv.clientX;
                var oldY = oEv.clientY;
                var oldLeft = oDiv.offsetLeft;

                var oldTop = oDiv.offsetTop;
                document.onmousemove = function (ev) {
                    var oEv = ev || event;
                    let disY = (oldTop + (oEv.clientY - oldY)),
                        disX = (oldLeft + (oEv.clientX - oldLeft));
                    if (disX > oldLeft + oldWidth) {
                        disX = oldLeft + oldWidth
                    }
                    if (disY > oldTop + oldHeight) {
                        disY = oldTop + oldHeight
                    }
                    //                      左上角
                    if (obj.className === 'tl') {
                        oDiv.style.width = oldWidth - (oEv.clientX - oldX) + 'px';
                        oDiv.style.height = oldHeight - (oEv.clientY - oldY) + 'px';
                        oDiv.style.left = oldLeft + (oEv.clientX - oldX) + 'px';
                        oDiv.style.top = oldTop + (oEv.clientY - oldY) + 'px';
                        console.log("左上角：", oDiv.style.left, oDiv.style.top);
                        console.log("右下角：", oldLeft + oldWidth, oldTop + +oldHeight);
                        setValue(oDiv.style.left, oDiv.style.top, oldLeft + oldWidth, oldTop + +oldHeight);
//								console.log("宽：", oDiv.style.width + "高：", oDiv.style.height)
                    }

                    //                      左下角
                    else if (obj.className === 'bl') {
                        oDiv.style.width = oldWidth - (oEv.clientX - oldX) + 'px';
                        oDiv.style.height = oldHeight + (oEv.clientY - oldY) + 'px';
                        oDiv.style.left = oldLeft + (oEv.clientX - oldX) + 'px';
                        oDiv.style.bottom = oldTop + oldHeight + (oEv.clientY - oldY) + 'px';
                        //								oDiv.style.left = disX + 'px';
                        console.log("左上角：", oDiv.style.left, oldTop);
                        console.log("右下角：", oldLeft + oldWidth, oDiv.style.bottom);
                        setValue(oDiv.style.left, oldTop, oldLeft + oldWidth, oDiv.style.bottom);
//								console.log("左下角：", oDiv.style.left ,oDiv.style.bottom)
//								console.log("宽：", oDiv.style.width + "高：", oDiv.style.height)
                    }

                    //                      右上角
                    else if (obj.className === 'tr') {
                        oDiv.style.width = oldWidth + (oEv.clientX - oldX) + 'px';
                        oDiv.style.height = oldHeight - (oEv.clientY - oldY) + 'px';
                        oDiv.style.right = oldLeft + oldWidth + (oEv.clientX - oldX) + 'px';
                        oDiv.style.top = disY + 'px';
                        console.log("左上角：", oldLeft, oDiv.style.top);
                        console.log("右下角：", oDiv.style.right, disY + oldHeight - oEv.clientY + oldY);
                        setValue(oldLeft, oDiv.style.top, oDiv.style.right, disY + oldHeight - oEv.clientY + oldY);
//								console.log("右上角：", oDiv.style.right, oDiv.style.top)
//								console.log("宽：", oDiv.style.width + "高：", oDiv.style.height)
                    }
                    //                      右下角
                    else if (obj.className === 'br') {
                        oDiv.style.width = oldWidth + (oEv.clientX - oldX) + 'px';
                        oDiv.style.height = oldHeight + (oEv.clientY - oldY) + 'px';
                        //                          oDiv.style.right = oldLeft - (oEv.clientX - oldX) + 'px';
                        oDiv.style.right = oldLeft + oldWidth + (oEv.clientX - oldX) + 'px';
                        oDiv.style.bottom = oldTop + oldHeight + (oEv.clientY - oldY) + 'px';
                        console.log("左上角：", oldLeft, oldTop);
                        console.log("右下角：", oDiv.style.right, oDiv.style.bottom);
                        setValue(oldLeft, oldTop, oDiv.style.right, oDiv.style.bottom);
                    }

                };

                document.onmouseup = function () {
                    document.onmousemove = null;
                };
                return false;
            };
        }

        console.log("aaaaaaaa", oDiv.offsetWidth)
        document.getElementById("odiv").onmousedown = function (ev) {
            var oevent = ev || event;
            oevent.preventDefault();

            var distanceX = oevent.clientX - oDiv.offsetLeft;
            var distanceY = oevent.clientY - oDiv.offsetTop;
            //				console.log("宽111", distanceX+"高1111",distanceY)

            document.onmousemove = function (ev) {
                var oevent = ev || event;
                oDiv.style.left = oevent.clientX - distanceX + 'px';
                oDiv.style.top = oevent.clientY - distanceY + 'px';
                console.log("距左：", oDiv.style.left + "距上：", oDiv.style.top)
                console.log("左上", oDiv.style.left, oDiv.style.top);
                console.log("右下", oevent.clientX - distanceX + oDiv.offsetWidth + 'px', oevent.clientY - distanceY + oDiv.offsetHeight + 'px');
                setValue(oDiv.style.left, oDiv.style.top, oevent.clientX - distanceX + oDiv.offsetWidth, oevent.clientY - distanceY + oDiv.offsetHeight)
            };
            document.onmouseup = function () {
                document.onmousemove = null;
                document.onmouseup = null;
            };
        };

        function setValue(a, b, c, d) {
            x1 = a;
            y1 = b;
            x2 = c;
            y2 = d;
            console.log(x1 + "-" + y1 + "-" + x2 + "-" + y2);
        }

        function initDiv(a, b, c, d) {
            setValue(a, b, c, d);
            oDiv.style.width = (c - a) + 'px';
            oDiv.style.height = (d - b) + 'px';
            oDiv.style.left = a + 'px';
            oDiv.style.top = b + 'px';
        }

        initDiv(x1, y1, x2, y2);
    };

    function savePosition() {
        var t = confirm("确定保存吗？");
        if (!t) {
            return;
        }

        $.ajax({
            type: "POST",
            url: window.location.href,
            dataType: "json",
            async: false,
            data: {
                "p1": x1,
                "p2": y1,
                "p3": x2,
                "p4": y2
            },
            success: function (res) {
                alert(res.msg);
            }
        });
    }
</script>
</body>

</html>