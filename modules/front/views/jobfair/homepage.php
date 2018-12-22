<?php
/**
 * 欢迎界面视图
 */
use yii\helpers\Url;
$this->title = '海归人才专场招聘会';
?>
<div class="content">
    <img class="none01" src="<?=Url::to('@web/front/images/h5_01.png');?>">
    <a style="display:block" href="<?=Url::toRoute('jobfair/index?event_id=2');?>"  event_id='2'><img class="none01" src="<?=Url::to('@web/front/images/h5_02.png');?>"></a>
    <a href="<?=Url::toRoute('jobfair/index?event_id=2');?>"  event_id='2'><img style="width: 48px;z-index: 1;position: absolute;margin-top: -63px;margin-left: 56px;"  src="<?=Url::to('@web/front/images/move.gif');?>"></a>

    <a href="<?=Url::toRoute('jobfair/index?event_id=3');?>"  event_id='3'><img class="none01" src="<?=Url::to('@web/front/images/h5_03.png');?>"></a>
    <a href="<?=Url::toRoute('jobfair/index?event_id=3');?>"  event_id='3'><img style="width: 48px;z-index: 1;position: absolute;margin-top: -63px;margin-left: 56px;"  src="<?=Url::to('@web/front/images/static.png');?>"></a>


    <a href="<?=Url::toRoute('jobfair/index?event_id=1');?>"  event_id='1'><img class="none01" src="<?=Url::to('@web/front/images/h5_04.png');?>"></a>
    <a href="<?=Url::toRoute('jobfair/index?event_id=1');?>"  event_id='1'><img style="width: 48px;z-index: 1;position: absolute;margin-top: -57px;margin-left: 56px;"  src="<?=Url::to('@web/front/images/static.png');?>"></a>


    <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.imhaigui.android" ><img class="none01" src="<?=Url::to('@web/front/images/h5_05.png');?>"></a>
</div>
<?=$candidate?'':$this->render('mobile.php');?>
<script>
    $(function(){
        // 选择报名区域
        $('.content a').click(function(){
            var event_id = $(this).attr('event_id');
            window.location.href = '<?=Url::toRoute('jobfair/index?event_id=')?>'+event_id;
        });



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
                            openLogin(0,0,0,'apply');
                            break;
                        case 200:
                            //layer.open({content: '验证成功',skin: 'msg',time: 2});
                            break;
                        case 1113:
                            window.location.href = '<?=Url::toRoute('jobfair/applyinfo')?>';
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
</script>