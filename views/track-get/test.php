<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/12/22
 * Time:  12:01
 * Desc:
 */
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<!--单号输入框。-->
<input type="text" id="YQNum" maxlength="50"/>
<!--用于调用脚本方法的按钮。-->
<input type="button" value="TRACK" onclick="doTrack()"/>
<!--用于显示查询结果的容器。-->
<div id="YQContainer"></div>

<button onclick="getName()">aaaa</button>

<!--脚本代码可放于页面底部，等到页面最后执行。-->
<script type="text/javascript" src="//www.17track.net/externalcall.js"></script>
<script type="text/javascript">
    function doTrack() {
        var num = document.getElementById("YQNum").value;
        if(num===""){
            alert("Enter your number.");
            return;
        }
        YQV5.trackSingle({
            //必须，指定承载内容的容器ID。
            YQ_ContainerId:"YQContainer",
            //可选，指定查询结果高度，最大为800px，默认为560px。
            YQ_Height:560,
            //可选，指定运输商，默认为自动识别。
            YQ_Fc:"0",
            //可选，指定UI语言，默认根据浏览器自动识别。
            YQ_Lang:"zh-cn",
            //必须，指定要查询的单号。
            YQ_Num:num
        });
    }

    function getName(){
        var name = $('#YQContainer').find('.text-uppercase').html();
        console.info(name);
    }

</script>
</body>
</html>
