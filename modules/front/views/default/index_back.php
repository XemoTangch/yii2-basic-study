<?php
/**
 * 欢迎界面视图
 */
use yii\helpers\Url;
$this->title = '海归人才专场招聘会';
?>
<div class="content">
    <img class="none01" src="<?=Url::to('@web/front/images/h5_01.png');?>">
    <a style="display:block" href="<?=Url::toRoute('jobfair/index?event_id=2');?>"  event_id='2'><img class="none01" src="<?=Url::to('@web/front/images/h5_02.gif');?>"></a>
    <a href="<?=Url::toRoute('jobfair/index?event_id=3');?>"  event_id='3'><img class="none01" src="<?=Url::to('@web/front/images/h5_03.png');?>"></a>
    <a href="<?=Url::toRoute('jobfair/index?event_id=1');?>"  event_id='1'><img class="none01" src="<?=Url::to('@web/front/images/h5_04.png');?>"></a>
    <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.imhaigui.android" ><img class="none01" src="<?=Url::to('@web/front/images/h5_05.png');?>"></a>
</div>
<!--<div class="con">-->
<!--    <a href="--><?//=Url::toRoute('jobfair/index?event_id=1');?><!--"> </a>-->
<!---->
<!--</div>-->
<!--<div class="con1">-->
<!---->
<!--    <a href="--><?//=Url::toRoute('jobfair/index?event_id=2');?><!--"> </a>-->
<!---->
<!--</div>-->
<!--<div class="con2">-->
<!---->
<!--    <a href="--><?//=Url::toRoute('jobfair/index?event_id=3');?><!--"> </a>-->
<!--</div>-->