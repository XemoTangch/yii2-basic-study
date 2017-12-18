<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/11/3
 * Time: 17:27
 * Desc:
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Javascript Index</title>
</head>
<style type="text/css">
    .table tbody tr td,.table tbody tr th{
        vertical-align: middle;
    }
    .table tbody tr {
        background-color: #f9f9f9;
    }
</style>
<body>

<div class="wrap">

    <div class="container" id="table_demo">
        <div class="row">
            <div class="col-xs-12 text-center"><h2 class="title"></h2></div>
        </div>
        <dvi class="row">
            <div class="col-xs-12">

                <table class="table table-bordered">
                    <colgroup>
                        <col class="col-xs-1">
                        <col class="col-xs-7">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>核心代码</th>
                        <th>描述</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" rowspan="3" class="text">
                            <code>window</code>
                        </th>
                        <td><code>window.onbeforeunload</code></td>
                        <td><a href="/javascript/index?type=onbeforeunload">离开页面时提示</a></td>
                    </tr>
                    <tr>
                        <td><code>window.on</code></td>
                        <td>鼠标悬停在行或单元格上时所设置的颜色</td>
                    </tr>
                    <tr>
                        <td><code>window.on</code></td>
                        <td>鼠标悬停在行或单元格上时所设置的颜色</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </dvi>
    </div>

    
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center"><h2>Javascript 知识点</h2></div>
        </div>
        <dvi class="row">
            <div class="col-xs-12">

                <table class="table table-bordered">
                    <colgroup>
                        <col class="col-xs-1">
                        <col class="col-xs-7">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>核心代码</th>
                        <th>描述</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" rowspan="3" class="text">
                            <code>window</code>
                        </th>
                        <td><code>window.onbeforeunload</code></td>
                        <td><a href="/javascript/index?type=onbeforeunload">离开页面时提示</a></td>
                    </tr>
                    <tr>
                        <td><code>window.on</code></td>
                        <td>鼠标悬停在行或单元格上时所设置的颜色</td>
                    </tr>
                    <tr>
                        <td><code>window.on</code></td>
                        <td>鼠标悬停在行或单元格上时所设置的颜色</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </dvi>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center"><h2>Javascript 对象</h2></div>
        </div>
        <dvi class="row">
            <div class="col-xs-12">

                <table class="table table-bordered">
                    <colgroup>
                        <col class="col-xs-1">
                        <col class="col-xs-7">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>对象</th>
                        <th>方法</th>
                        <th>描述</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row" rowspan="2" class="text">
                            <code>window</code>
                        </th>
                        <td><code>window.onbeforeunload</code></td>
                        <td><a href="/javascript/index?type=onbeforeunload">离开页面时提示</a></td>
                    </tr>
                    <tr>
                        <td><code>window.on</code></td>
                        <td>鼠标悬停在行或单元格上时所设置的颜色</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </dvi>
    </div>
</div>

</body>
<script type="application/javascript">
    $(function(){
        // 页面数据  no2
        var data = {
            knowledge_point: {
                content:[
                    {code:'window.onbeforeunload', desc:'<a href="/javascript/index?type=onbeforeunload">离开页面时提示</a>'},
                    {code:'window.on', desc:'鼠标悬停在行或单元格上时所设置的颜色'},
                    {code:'window.on', desc:'鼠标悬停在行或单元格上时所设置的颜色'},
                ]
            },
            object: {
                window:[
                    {code:'window.onbeforeunload', desc:'<a href="/javascript/index?type=onbeforeunload">离开页面时提示</a>'},
                    {code:'window.on', desc:'鼠标悬停在行或单元格上时所设置的颜色'},
                    {code:'window.on', desc:'鼠标悬停在行或单元格上时所设置的颜色'},
                ]
            },
        };

        

    });
</script>
</html>

