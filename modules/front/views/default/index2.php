<?php
/**
 * 欢迎界面视图
 *
 * @var $signPackage
 * @var $wx_share_info
 */
use yii\helpers\Url;
$this->title = '海归人才专场招聘会';
?>
<div class="content">
    <img class="none01" src="<?=Url::to('@web/front/images/index_01.png');?>">
    <img class="none01" src="<?=Url::to('@web/front/images/index_02.png');?>">
    <a id="apply" ><img class="none01" src="<?=Url::to('@web/front/images/index_03.png');?>"></a>
    <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.imhaigui.android" ><img class="none01" src="<?=Url::to('@web/front/images/index_04.png');?>"></a>
</div>
<script src="<?=Url::to('@web/front/js/swipe.js');?>"></script>
<script src="<?=Url::to('@web/front/js/cookie.js');?>"></script>
<script src="<?=Url::to('@web/front/js/layer.js');?>"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<?=$candidate?'':$this->render('../jobfair/mobile.php');?>
<script>

    $('#apply').click(function () {
        $(function(){
            $.ajax({
                url: '<?=Url::toRoute('jobfair/apply')?>',
                data: {},
                type: 'post',
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    switch(data.code){
                        case 1002:
                            // 验证身份弹窗
                            openLogin(0,0,0,'apply2');
                            break;
                        case 200:
                            layer.open({content: '验证成功',skin: 'msg',time: 5000});
                            setTimeout(window.location.href = '<?=Url::toRoute('jobfair/homepage2')?>',9000);
                            break;
                        case 1113:
                            window.location.href = '<?=Url::toRoute('jobfair/applyinfo2')?>';
                            break;
                        default:
                            layer.open({content: data.message,skin: 'msg',time: 2});
                            break;
                    }
                },
                error: function(){
                    layer.open({content: '投递失败，请联系工作人员或稍后再试',skin: 'msg',time: 2});
                },
                complete: function(XML, status){
                    if(status == 'timeout'){
                        layer.open({content: '请求超时，请检查您的网络连接',skin: 'msg',time: 2});
                    }
                }
            });
        });
    });

    // 微信分享
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
        ]
    });
    wx.ready(function () {
        var options = {
            title: '<?=$wx_share_info['title']?>',
            desc: '<?=$wx_share_info['desc']?>',
            link: '<?=$wx_share_info['link']?>',
            imgUrl: '<?=$wx_share_info['imgUrl']?>',
            type: '<?=$wx_share_info['type']?>',
            dataUrl: '<?=$wx_share_info['dataUrl']?>',
            success: function () {},
            cancel: function () {}
        };

        wx.onMenuShareTimeline(options);
        wx.onMenuShareAppMessage(options);
    });

</script>