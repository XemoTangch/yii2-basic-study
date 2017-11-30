<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>APP运营数据分析</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=2.0"/>
    <style>
        body,div,dl,dt,dd,ul,h1,h2,h3,h4,h5,h6,pre,ul,li,code,form,fieldset,legend,input,textarea,p,blockquote,th,td,a{margin:0;padding:0; text-decoration: none; font-size:14px;}
        body{background-color: #efeff4;font-family:"Helvetica Neue","Segoe UI",Tahoma,Arial,"Hiragino Sans GB",STHeiti,"Microsoft Yahei","WenQuanYi Micro Hei",sans-serif; line-height: 120%;margin:0px auto;}
        .main_top ul{margin: 0;list-style:none; }
        img{border:0px;}
        i,em{font-style:normal}
        h5{ color: #8f8f94;  font-size: 14px; margin: 20px 0 10px; text-indent: 20px;}
        .main_top a{color:#8f8f94; text-decoration: none; font-size:12px;}
        .main_top ul{text-indent:5px;padding:10px 0; overflow: hidden; background: #fff;  }
        .main_li{max-width:1200px; margin:0 auto; overflow: hidden}
        .main_li  li{padding-right: 20px;}
        .main_text{max-width:1200px; overflow: hidden}
        .main_cen{padding-top: 220px;}
        h4{background: #fff; height: 40px; line-height: 40px; margin:15px 0; text-indent: 20px;box-shadow: 0 2px 3px #ccc;}
        h3{background: #fff; height: 40px; line-height: 40px;text-indent: 10px; margin-bottom:1px; box-shadow: 0 2px 3px #ccc;  font-size:16px;}
        h2{text-align: center; height: 45px; font-size: 18px; line-height: 45px; background: #fff;  border-bottom: 1px solid #ccc; position: fixed; top:0px; left:0px; width:100%; z-index: 888}
        .main_mar{ }
        .main_20px{display: block; padding:0 20px 10px;}
        .chart {width: 98%;overflow: hidden;padding : 10px;margin-bottom: 10px;border: 1px solid #e3e3e3;
            -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        }
        .main_top{width:100%; position: fixed; top:46px; left:0px; z-index: 999}
        .main_l{margin:0 auto;width:96%;}

        .datainp{ width:25%; padding-left:1%; height:30px; border:1px #A5D2EC solid;}
        .wicon{background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAQCAYAAADj5tSrAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNi8xNS8xNGnF/oAAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAAAoElEQVQ4jWPceOnNfwYqAz9dYRQ+E7UtwAaGjyUsDAyYYUgJ2HT5LXZLcEmSCnA6duOlN///////H0bDALl8dPH/////Z8FuNW6Qtvw2nL3lyjsGBgYGhlmRqnj1kGwJuqHIlhJlCXq8EOITEsdqCXLEbbr8FisfFkTo+vBZRFZwERNEFFkCiw90nxJtCalxQmzegltCzVyP1RJq5HZ8AABuNZr0628DMwAAAABJRU5ErkJggg=="); background-repeat:no-repeat; background-position:right center;}
        .tb_button{
            color: #fff;
            border: 1px solid #1e7db9;
            box-shadow: 0 1px 2px #8fcaee inset,0 -1px 0 #497897 inset,0 -2px 3px #8fcaee inset;
            background: -webkit-linear-gradient(top,#42a4e0,#2e88c0);
            width: 40px;
            line-height: 30px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            margin-left:5px;
            position: relative;
            overflow: hidden;
        }

        .main_top li{float:left; margin-left:5px; width:115px;}
        @media only screen and (max-width: 359px){
            .main_top li{width: 96px;}
            .main_top li a{font-size: 10px;}
            .main_cen {padding-top:217px;}
            .datainp{width:38%;}
        }
        @media screen and (min-width: 410px) and (max-width: 800px) {
            .main_top li{width: 123px;}
            .main_top li a{font-size: 13px;}
            .main_cen {padding-top:210px;}
            .datainp{width:38%;}
        }
        @media screen and (min-width: 900px){
            .main_cen {padding-top:147px;}
            .main_top li a{font-size: 13px;}
            .main_top li{width:125px;}
            .main_top >div >div{display: initial;}
        }
    </style>
    <!-- 引入 echarts.js -->
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/static/html/data/js/echarts.min.js"></script>

    <script type="text/javascript" src="/static/html/data/js/ecStat.min.js"></script>
    <script type="text/javascript" src="/static/html/data/js/dataTool.min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jA8OGGeqTQlRtz4m95YGVez8UaEdLgXe"></script>
    <script type="text/javascript" src="/static/html/data/js/bmap.min.js"></script>

    <script src="/static/html/data/js/map/js/china.js"></script>
    <script src="/static/html/data/js/map/js/world.js"></script>
    <script src="/static/html/data/js/jquery.jedate.min.js"></script>
    <script src="/static/html/data/js/data.js?v=1.8"></script>
    <link href="/static/html/data/css/jedate.css" type="text/css" rel="stylesheet">
</head>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<h2>APP运营数据分析</h2>
<div class="main_top" style="background: #fff;">
    <ul style="border-bottom: 1px solid #ccc;">
        <li><a href="#li01">总量统计</a></li>
        <li><a href="#li02">用户漏斗图</a></li>
        <li><a href="#li14">活跃用户漏斗图</a></li>
        <li><a href="#li03">用户所在城市</a></li>
        <li><a href="#li13">app定位热点图</a></li>
        <li><a href="#li15">app定位热力图</a></li>
        <li><a href="#li04">活动类型分布</a></li>
        <li><a href="#li05">活动排行</a></li>
        <li><a href="#li06">板块热度</a></li>
        <li><a href="#li07">男女分布</a></li>
        <li><a href="#li08">用户年龄分布</a></li>
        <li><a href="#li12">用户年龄分布柱状图</a></li>
        <li><a href="#li09">用户留学国家</a></li>
        <li><a href="#li10">用户兴趣爱好</a></li>
        <li><a href="#li11">用户小喇叭</a></li>
        <li><a href="#li16">app所有聊天数统计</a></li>
    </ul>
    <div style="border-bottom: 1px solid #ccc;padding: 10px 20px;">
        <div>时间: <input class="datainp wicon date_start" id="date_start" type="text" placeholder="开始日期"  readonly> -
            <input class="datainp wicon date_end" id="date_end" type="text" placeholder="结束日期"  readonly></div>
        用户类型: <select class="datainp wicon date_start" style="background-image:none;" name="type" id="type">
            <option value="0" selected="selected">所有用户</option>
            <option value="1" >认证用户</option>
        </select>
        <input type="button" class="tb_button" value="刷新" >
        <input type="button" class="tb_button" value="重置" >
    </div>

</div>

<div class="main_l">

    <div id="li01" class="main_cen">
        <h4><p class="main_mar">总量统计（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">总量统计可以查看某段时间内，用户、活动、海归圈、海谈和创业项目的总数。</span></p>
        <div id="allNumber" class="chart" method="setBar" ajax="/html/data/AjaxAllNumber" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li02" class="main_cen">
        <h4><p class="main_mar">用户漏斗图（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">用户漏斗图可以查看某段时间内，注册用户（基数）、认证用户、付费用户和加v用户的总数。</span></p>
        <!--        <div class="main_20px">-->
        <!--            <input class="datainp wicon date_start"  type="text" placeholder="开始日期" value=""  readonly> --->
        <!--            <input class="datainp wicon date_end"  type="text" placeholder="结束日期"   readonly>-->
        <!--            <input type="button" class="tb_button" value="刷新图表" >-->
        <!--            <input type="button" class="tb_button" value="重置图表" >-->
        <!--        </div>-->
        <div id="userFunnel" class="chart" method="setFunnel" ajax="/html/data/AjaxUserFunnel" style="height:600px;width:95%;" ></div>
    </div>

    <div id="li14" class="main_cen">
        <h4><p class="main_mar">活跃用户漏斗图（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">用户漏斗图可以查看某段时间内，注册用户（基数）、活跃用户（一周内登录3次的用户）的总数。</span></p>
        <div id="setFunnelLively" class="chart" method="setFunnelLively" ajax="/html/data/AjaxUserFunnelLively" style="height:600px;width:95%;" ></div>
    </div>

    <div id="li03" class="main_cen">
        <h4><p class="main_mar">用户所在城市热点图（可以选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">用户所在城市热点图可以查看某段时间内，用户所在城市的分布和用户量靠前的城市(紫圈越大数量越多，在地图中滚动鼠标滚轴可以缩放查看)。</span></p>
        <div id="cityMap" class="chart" method="setMap" ajax="/html/data/AjaxUserCity"  style="height:600px;width:95%;" ></div>
    </div>

    <div id="li13" class="main_cen">
        <h4><p class="main_mar">app定位热点图（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="location" class="chart" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li15" class="main_cen">
        <h4><p class="main_mar">app定位热力图（可以选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">按用户最后登录时间来筛选数据。</span></p>
        <div id="location_warm" class="chart" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li04" class="main_cen">
        <h4><p class="main_mar">活动类型分布（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="activityType" class="chart" method="setPie" ajax="/html/data/AjaxActivityType"  style="height:550px;width:95%;" ></div>
    </div>

    <div id="li05" class="main_cen">
        <h4><p class="main_mar">活动排行（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">因为活动标题太长，图标x轴标题显示不全，可以移动到该条柱形图上查看详细。</span></p>
        <div id="rankList" class="chart" method="setBar" ajax="/html/data/AjaxRankList" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li06" class="main_cen">
        <h4><p class="main_mar">板块热度（可以选择时间段，不能选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px">板块热度数据是通过板块的接口调用量来统计的。</span></p>
        <div id="moduleHot" class="chart" method="setPie" ajax="/html/data/AjaxModuleHot" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li07" class="main_cen">
        <h4><p class="main_mar">男女分布（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userSex" class="chart" method="setPie" ajax="/html/data/AjaxSexPie" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li08" class="main_cen">
        <h4><p class="main_mar">用户年龄分布（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userAge" class="chart" method="setPie" ajax="/html/data/AjaxUserAgePie" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li12" class="main_cen">
        <h4><p class="main_mar">用户年龄分布柱状图（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userAgeBar" class="chart" method="setBar" ajax="/html/data/AjaxUserAgeBar" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li09" class="main_cen">
        <h4><p class="main_mar">用户留学国家（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userCountry" class="chart" method="setPie" ajax="/html/data/AjaxCountryPie" style="height:600px;width:95%;" ></div>
    </div>

    <div id="li10" class="main_cen">
        <h4><p class="main_mar">用户兴趣爱好（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userInterest" class="chart" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li11" class="main_cen">
        <h4><p class="main_mar">用户小喇叭（不能选择时间段，可以选择用户类型）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="userHorn" class="chart" style="height:550px;width:95%;" ></div>
    </div>

    <div id="li16" class="main_cen">
        <h4><p class="main_mar">app所有聊天数统计（可以选择时间段）</p></h4>
        <p class="main_text"><span class="main_20px"></span></p>
        <div id="allChat" class="chart" style="height:550px;width:95%;" ></div>
    </div>

</div>

</body>
<script type="text/javascript">

    // 显示图表
    function initTable(data){
        // 初始化统计数据
        // app总量统计
        setBar('allNumber', '/html/data/AjaxAllNumber', data);
        // 用户漏斗
        setFunnel('userFunnel', '/html/data/AjaxUserFunnel', data);
        // 活跃用户漏斗
        setFunnel('setFunnelLively', '/html/data/AjaxUserFunnelLively', data);

        // 用户城市分布
        setMap('cityMap', '/html/data/AjaxUserCity', data);

        // 用户性别分布
        setPie('userSex', '/html/data/AjaxSexPie', data);
        //用户年龄分布柱状
        setBar('userAgeBar', '/html/data/AjaxUserAgeBar', data);
        // 用户年龄分布
        setPie('userAge', '/html/data/AjaxUserAgePie', data);
        // 用户留学国家分布
        setPie('userCountry', '/html/data/AjaxCountryPie', data);
        // 用户兴趣爱好
        setPie('userInterest', '/html/data/AjaxInterestPie', data);
        // 用户小喇叭
        setPie('userHorn', '/html/data/AjaxHornPie', data);
        // 活动分类分布
        setPie('activityType', '/html/data/AjaxActivityType', data);

        // 活动排行
        setBar('rankList', '/html/data/AjaxRankList', data);

        // 板块热度
        setPie('moduleHot', '/html/data/AjaxModuleHot', data);

        // app定位热点图
        setWorldMap('location', '/html/data/AjaxLocation', data);
        // app定位热力图
        setWorldWarmMap('location_warm', '/html/data/AjaxLocationWarm', data);

        // app所有聊天统计
        setLine('allChat', '/html/openfire/AjaxChat', data);
    }
    initTable('');

    // 时间选择
    function initTime(){
        $("#date_start").jeDate({
            format:"YYYYMMDD",
            isTime:false,
            isinitVal:true,
            initAddVal:[-14],
        })
        $("#date_end").jeDate({
            format:"YYYYMMDD",
            isTime:false,
            isinitVal:true,
            initAddVal:[0],
        });
        $("#date_start").val('<?=$stime?>');
        $("#date_end").val('<?=$etime?>');
    }
    initTime();
    // 图表刷新
    $('.tb_button').click(function(){
        var value = $(this).val(),
            data = new Object(),
            stime = $(this).parent().find('.date_start'),
            etime = $(this).parent().find('.date_end');
        if(value == '刷新'){
            data['stime'] = stime.val();
            data['etime'] = etime.val();
            //by lzm 增加用户类型
            data['type']  = $('#type').val();
            //by lzm 增加用户类型
            if(data['stime'] && data['etime'] && data['stime'] > data['etime']) {alert('开始日期不能大于结束日期'); return false;}
        }else if(value == '重置'){
            initTime();
            data = '';
        }
        initTable(data);

    });
</script>
</html>