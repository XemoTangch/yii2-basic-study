<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/21
 * Time: 14:51
 * Desc:
 */
$this->title = '列表页';
?>
<style type="text/css">
    .list-row {
        height: 15%;
        border:1px solid #000;
        padding:1em;
    }
    .list-col {

    }
    .text-align-right {
        text-align: right;
    }
    .list-padding {
        padding-top: 10px;
    }
    body {
        font-family: '微软雅黑', console;
        font-size: 16px;
    }
</style>
<div class="container">

    <div class="row list-row">
        <div class="row">
            <div class="col-xs-10 list-col">来自话题:React</div>
            <div class="col-xs-2 list-col text-align-right"><svg viewBox="0 0 14 14" class="Icon Icon--remove" width="10" height="10" aria-hidden="true" ><title></title><g><path d="M8.486 7l5.208-5.207c.408-.408.405-1.072-.006-1.483-.413-.413-1.074-.413-1.482-.005L7 5.515 1.793.304C1.385-.103.72-.1.31.31-.103.724-.103 1.385.305 1.793L5.515 7l-5.21 5.207c-.407.408-.404 1.072.007 1.483.413.413 1.074.413 1.482.005L7 8.485l5.207 5.21c.408.407 1.072.404 1.483-.007.413-.413.413-1.074.005-1.482L8.485 7z"></path></g></svg></div>
        </div>
        <div class="row list-padding">
            <div class="col-xs-12 ">基于 react, redux 最佳实践构建的 2048</div>
        </div>
        <div class="row list-padding">
            <div class="col-xs-2">头像</div>
            <div class="col-xs-3">昵称昵称</div>
            <div class="col-xs-6">个人描述</div>
        </div>
        <div class="row list-padding">
            <div class="col-xs-3">图片</div>
            <div class="col-xs-9">文本内容</div>
        </div>
        <div class="row list-padding">
            <div class="col-xs-12">点赞，评论，收藏，分享等按钮</div>
        </div>
    </div>

</div>
