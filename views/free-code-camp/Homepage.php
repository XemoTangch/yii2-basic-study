<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/05
 * Time:  17:59
 * Desc:  个人主页
 */
$this->title = 'Homepage';
?>
<style>
 /* 2017-11-12 no update */
 /* 2017-11-13 no update */
 /* 2017-11-14 no update */

    .div1 {
        
    }
    .margin-top-20{
        margin-top: 20px;
    }
    .margin-top-50{
        margin-top: 50px;
    }
</style>

<div class="wrap">

    <nav class="navbar-inverse navbar-fixed-top navbar" id="navbar-homepage">
        <div class="container-fluid">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">移动端导航显示</span>
                    <!-- 按钮样式 -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">XemoTangch</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about">关于</a></li>
                    <li><a href="#portfolio">作品</a></li>
                    <li><a href="#contact">联系方式</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!-- 主体内容 -->
    <div class="container margin-top-50">

        <div id="about">
            <div class="page-header">
                <h1>ABOUT <small>个人信息</small></h1>
            </div>
            <div class="jumbotron margin-top-20">
                <h1>Hello, world!</h1>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
            </div>
        </div>

        <div id="portfolio">
            <div class="page-header">
                <h1>PORTFOLIO <small>作品集</small></h1>
            </div>
            <div class="jumbotron margin-top-20">
                <h1>Hello, world!</h1>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
            </div>
        </div>

        <div id="contact">
            <div class="page-header">
                <h1>CONTACT <small>联系方式</small></h1>
            </div>
            <div class="jumbotron margin-top-20">
                <h1>Hello, world!</h1>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p>...</p>
                <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
            </div>
        </div>


    </div>
    
</div>
<script type="application/javascript">
    $('body').scrollspy({ target: '#navbar-homepage' });
</script>



