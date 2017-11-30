<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/28
 * Time:  22:55
 * Desc:
 */

$this->title = '运营数据统计';
?>

<div class="wrap">
    <nav class="navbar-inverse navbar-fixed-top navbar" id="navbar-homepage">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" id="mobile_btn" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">移动端导航显示</span>
                    <!-- 按钮样式 -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">APP运营数据</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="getChart" href="javascript:;" name="userLouDou">总数统计图</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">用户数据统计图<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户漏斗图</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">活跃用户漏斗图</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">男女分布</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户年龄分布</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户留学国家</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户兴趣爱好</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户小喇叭</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">城市和定位统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" name="userLouDou">用户所在城市</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">定位热点图</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">定位热力图</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">活动数据统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" name="userLouDou">活动类型分布</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">活动排行</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">其他统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" name="userLouDou">板块热度</a></li>
                            <li><a class="getChart" href="javascript:;" name="userLouDou">聊天数统计</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


</div>
<script type="application/javascript">
    $(function(){
        var window_height,window_width;

        // 窗口大小变化事件
        window.onresize = function(){
            window_height = document.documentElement.clientHeight;
            window_width = document.documentElement.clientWidth;
            console.info(window_width+' - '+window_height);
        }

        $('.getChart').on('click', function(){

            // 小屏幕动作
            if(window_width < 768){
                $('#mobile_btn').click();
            }
            
        });
    });
</script>
