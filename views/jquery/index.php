<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/07
 * Time:  22:06
 * Desc:
 */

$this->title = 'Jquery List';
?>

<div class="container" style="min-height: 100%;">
    <div class="row">
        <div class="col-xs-12 text-center"><h2><?=$this->title?></h2></div>
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
                    <td><a href="/jquery/index?type=onbeforeunload">离开页面时提示</a></td>
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
