<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/28
 * Time:  22:55
 * Desc:
 */

use yii\web\View;
use yii\helpers\Html;
use app\assets\CommonAsset;

$this->title = '运营数据统计';
CommonAsset::addCss($this, '@web/imhg/chart-data/js/bootstrap-datetimepicker.min.css');
CommonAsset::addScript($this, '@web/imhg/chart-data/js/bootstrap-datetimepicker.min.js');

$this->registerJsFile('@web/imhg/chart-data/js/echarts.min.js');
$this->registerJsFile('@web/imhg/chart-data/js/ecStat.min.js');
$this->registerJsFile('@web/imhg/chart-data/js/map/js/china.js');
$this->registerJsFile('@web/imhg/chart-data/js/map/js/world.js');
$this->registerJsFile('@web/imhg/chart-data/js/data.js');
//$this->registerJsFile('http://api.map.baidu.com/api?v=2.0&ak=jA8OGGeqTQlRtz4m95YGVez8UaEdLgXe');

?>
<style type="text/css">
    .my-button {
        
    }
</style>

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
                    <li><a id="bra-test" class="getChart" href="javascript:;" chart-name="bar" chart-desc="总量统计可以查看某段时间内，注册用户、活动、海归圈、海谈和创业项目的总数。">总数统计图</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">用户数据统计图<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户漏斗图</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">活跃用户漏斗图</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">男女分布</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户年龄分布</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户留学国家</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户兴趣爱好</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户小喇叭</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">城市和定位统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">用户所在城市</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">定位热点图</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">定位热力图</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">活动数据统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">活动类型分布</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">活动排行</a></li>
                        </ul>
                    </li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;">其他统计<span class="caret"></a>
                        <ul class="dropdown-menu">
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">板块热度</a></li>
                            <li><a class="getChart" href="javascript:;" chart-name="userLouDou">聊天数统计</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container" style="margin-top: 55px;">
        <div class="row" style="margin: 10px;">
            <div class="col-sm-2">
                <div class="input-group date form_date">
                    <input id="start-time" class="form-control" size="16" type="text" value="2017/11/05" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date form_date">
                    <input id="end-time" class="form-control" size="16" type="text" value="2017/12/05" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
            <div class="col-sm-2">
                <select class="form-control" id="city_id">
                    <option value="0" selected="selected">全部城市</option>
                    <option value="2,52" >北京</option>
                    <option value="25,321" >上海</option>
                    <option value="76" >广州</option>
                    <option value="77" >深圳</option>
                    <option value="33,395" >香港</option>
                    <option value="383" >杭州</option>
                    <option value="322" >成都</option>
                    <option value="220" >南京</option>
                    <option value="180" >武汉</option>
                    <option value="-1" >其他</option>
                </select>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4 text-right">
                <button class="btn btn-primary my-button" id="refresh">刷新</button>
                <button class="btn btn-warning my-button" id="reload">重置</button>
            </div>
        </div>

        <div class="row" >
            <div class="col-xs-12 jumbotron" style="padding: 24px 30px;margin: 0px;">
                <p id="chart-desc" style="font-size: 16px;"></p>
                <div id="chart-box" style="width: 100%;height:400px;"></div>
            </div>
        </div>
    </div>
    
</div>
<script type="application/javascript">
    $(function(){
        var window_height,window_width;

        getWindowSize();
        // 窗口大小变化事件
        window.onresize = function(){
            getWindowSize();
        };
        function getWindowSize(){
            window_height = document.documentElement.clientHeight;
            window_width = document.documentElement.clientWidth;
        }

        // 默认图表
        setChart($('#bra-test'));
        // 选择图表
        $('.getChart').on('click', function(){
            
            // 小屏幕动作
            if(window_width < 768){
                $('#mobile_btn').click();
            }

            var domObj = $(this);
            setChart(domObj);

        });

        // 创建图表
        function setChart(domObj, param){
            if(!domObj) return false;
            param = param?param:'';
            var domId = domObj.attr('id'),
                chartName = domObj.attr('chart-name'),
                chart_box_id = 'chart-box', // 图表容器
                url = '/imhg-data/ajax-' + domId,
                chart_desc = domObj.attr('chart-desc');
            $('#chart-desc').html(chart_desc);
            switch (chartName){
                case 'bar': // 柱形图
                    setBar(chart_box_id, url, param);
                    break;
                case 'pie': // 饼图
                    setPie(chart_box_id, url, param);
                    break;
                case 'line': // 折线图
                    setLine(chart_box_id, url, param);
                    break;
                case 'funnel': // 漏斗图
                    setFunnel(chart_box_id, url, param);
                    break;
                case 'map': // 中国地图（分布图）
                    setMap(chart_box_id, url, param);
                    break;
                case 'worldMap': // 世界地图（分布图）
                    setWorldMap(chart_box_id, url, param);
                    break;
                case 'worldWarmMap': // 世界地图（热力图）
                    setWorldWarmMap(chart_box_id, url, param);
                    break;
            }
        }

        // 时间选择
        $('.form_date').datetimepicker({
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            format: 'yyyy/mm/dd',
        });

        // 重置和刷新
        $('#refresh').on('click', function(){
            var start_time = $('#start-time').val(),
                end_time = $('#end_time').val(),
                city_id = $('#city_id').val();

            
        });
        $('#reload').on('click', function(){
            
        });
        
    });
</script>
