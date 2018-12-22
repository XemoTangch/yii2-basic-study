<?php
/** @var $data array|bool */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <link type="text/css" rel="stylesheet" href="<?=Url::to('@web/front/css/comment.css');?>"/>
    <link type="text/css" rel="stylesheet" href="<?=Url::to('@web/front/css/m.css');?>"/>
    <link type="text/css" rel="stylesheet" href="<?=Url::to('@web/front/css/main.css');?>"/>
    <script src="<?=Url::to('@web/front/js/jquery-1.7.1.min.js');?>" type="text/javascript"></script>
</head>

<body>
<div class="page-swipe">
    <div style="">
        <div id="slider" class="swipe" style="visibility: visible;  z-index:10">
            <div class="swipe-wrap">
                <figure>
                    <a href="#" target="_blank">
                        <div >
                            <img style="width: 100%;height: auto;" src="<?=Url::to('@web/front/images/recruit_bg'.$banner_id.'.png');?>"/>
                          <!--  <div class="image" style="background:url(<?=Url::to('@web/front/images/recruit_bg'.$banner_id.'.png');?>) center no-repeat;background-size: cover"></div> -->
                        </div>
                    </a>
                </figure>

            </div>
<!--            <nav style=" position:relative; z-index:100 ;top: -30px">-->
<!--                <ul id="position">-->
<!--                    <li class=""></li>-->
<!--                    <li class=""></li>-->
<!--                </ul>-->
<!--            </nav>-->
        </div>
    </div>
</div>

<!--<div class="recruit-bg"><img src="img/recruit_bg.png" /></div>-->

<div class="div-search">
    <img src="<?=Url::to('@web/front/images/search.png');?>" class="img-search"/>
    <input type="text" placeholder="搜索企业" class="input-search" name="search-name">
    <img src="<?=Url::to('@web/front/images/search_delete.png');?>" class="img-search-delete"/>
</div>

<div id="content">
<?php if($data): ?>
<?php foreach ($data as $c) : ?>
<div class="div-content">
    <a href="<?=Url::toRoute('jobfair/company?id='.$c['id'])?>">
        <img src="<?=$c['logo']?>" class="img_content"/>
        <div class="div_text">
            <strong class="div-title"><?=$c['enterprisenamecn']?></strong>
            <p class="p-text" style="word-break:break-word;"><?=$c['comdesccn']?></p>
        </div>
    </a>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="div-content" style="margin:10px 4% 0;float:left;">
    参加招聘会企业主要是名企、世界500强、外企等，只有你想不到的，我们会陆续更新。
</div>
<?php endif; ?>
</div>


<div class="cen_top_fs">
    <img src="<?=Url::to('@web/front/images/xl.jpg');?>">
</div>
<div class="zy_bottom">
    <ul>
        <li><a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.imhaigui.android"><img src="<?=Url::to('@web/front/images/banner3.jpg');?>"><span>点击查看 >></span></a></li>
<!--        <li><a href="http://www.careerfrog.com.cn/landing/recruitingsite"><img src="--><?//=Url::to('@web/front/images/pc.jpg');?><!--"><span>点击查看 >></span></a></li>-->
    </ul>

<!--<div class="footer">-->
<!--    <div class="div-previous">-->
<!--        <a href="/html/jobs/ago">-->
<!--            <img src="/static/html/jobs/img/previous_bg.png">-->
<!--            <p>往届回顾</p>-->
<!--        </a>-->
<!--    </div>-->
<!---->
<!--    <div class="div-collect">-->
<!--        <a href="/html/jobs/collection">-->
<!--            <i><img src="/static/html/jobs/img/collect_bg.png"></i>-->
<!--            <p>我的收藏</p>-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->


<script src="<?=Url::to('@web/front/js/swipe.js');?>"></script>
<script src="<?=Url::to('@web/front/js/cookie.js');?>"></script>
<script src="<?=Url::to('@web/front/js/layer.js');?>"></script>
<script>
$(function(){
    // 下一页
    var page = 1;
    Cookies.set('page', 1); //当前页存入cookie
    $('.page-next').click(function(){
        page = parseInt(Cookies.get('page'));
        page += 1;
        $.ajax({
            type: 'GET',
            url: '<?=Url::toRoute('jobfair/index?id='.$banner_id)?>',
            data: {format:"json",page:page,event_id:<?=$banner_id?>},
            dataType: 'json',
            success: function(json){
                layer.closeAll();
                var html = '';
                $.each(json.obj, function(i, v){
                    html += '<div class="div-content">';
                    html += '<a href="<?=Url::toRoute('jobfair/company?id=')?>'+v.id+'">';
                    html += '<img src="'+v.logo+'" class="img_content"/>';
                    html += '<div class="div_text"><strong class="div-title">'+ v.enterprisenamecn +'</strong>';
                    html += '<p class="p-text" style="word-break:break-word;">'+ v.comdesccn +'</p>';
                    html += '</div></a></div>';
                });
                $('#content').append(html);
                Cookies.set('page', page);
            },
            beforeSend: function(xhr, settings){
                layer.open({type: 2,shadeClose:false,shade:'background-color: rgba(0,0,0,.1)'});
            }
        });
    });
    // 搜索
    $('.img-search-delete').click(function(){
        $('.input-search').val('');
    });
    $('.input-search').keypress(function (e) {
        var keycode = e.keyCode;
        var searchName = $(this).val();
        if(keycode == '13') {
            $('.img-search').trigger('click');
        }
    });
    $('.img-search').click(function(){
        var kw = $('.input-search').val();
        if(kw == '') return;
        $.ajax({
            type: 'GET',
            url: '<?=Url::toRoute('jobfair/index?id='.$banner_id)?>',
            data: {kw:kw, format:"json",event_id:<?=$banner_id?>},
            dataType: 'json',
            success: function(json){
                console.log(json);
                layer.closeAll();
                var html = '';
                $.each(json.data, function(i, v){
                    html += '<div class="div-content">';
                    html += '<a href="<?=Url::toRoute('jobfair/company?id=')?>'+v.id+'">';
                    html += '<img src="'+v.logo+'" class="img_content"/>';
                    html += '<div class="div_text"><strong class="div-title">'+ v.enterprisenamecn +'</strong>';
                    html += '<p class="p-text" style="word-break:break-word;">'+ v.comdesccn +'</p>';
                    html += '</div></a></div>';
                });
                html += '<div style="height:60px;width:100%;float:left;"></div>';
                $('#content').html(html);
                $('.div-btn').hide();
            },
            beforeSend: function(xhr, settings){
                layer.open({type: 2,shadeClose:false,shade:'background-color: rgba(0,0,0,.1)'});
            }
        });
    });
    // 幻灯片
//    var slider = Swipe(document.getElementById('slider'), {
//        auto: 3000,
//        continuous: true,
//        callback: function (pos) {
//            var i = bullets.length;
//            while (i--) {
//                bullets[i].className = ' ';
//            }
//            bullets[pos].className = 'on';
//        }
//    });
//    var bullets = document.getElementById('position').getElementsByTagName('li');
});
</script>
    <div style="display:none;">
        <script>
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?711d13b8e20342b0beb999f1a1737eaa";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();
        </script>
    </div>
</body>

</html>