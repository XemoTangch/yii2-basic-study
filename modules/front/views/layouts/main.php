<?php
/**
 * User: jiangm
 * Date: 2017/3/15
 * Time: 15:59
 * Desc: 前台布局
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="北京站 9月9日 上海站9月16日 深圳站9月23日 www.jobshaigui.com" />
    <?=Html::jsFile('@web/common/js/jquery.min.js')?>
    <?=Html::jsFile('@web/common/js/Function.js')?>

    <?=Html::cssFile('@web/front/css/m.css?v=1.1')?>
    <?=Html::cssFile('@web/front/css/mobiscroll.custom-2.5.0.min.css')?>
    <?=Html::jsFile('@web/front/js/mobiscroll.custom-2.5.0.min.js')?>

    <!-- 弹窗插件 -->
    <?=Html::cssFile('@web/common/layer3/mobile/need/layer.css')?>
    <?=Html::jsFile('@web/common/layer3/mobile/layer.js')?>

    <?php $this->head() ?>
</head>
<body>
<img style="position:fixed;left:0px; z-index:-999; opacity: 0;filter: alpha(opacity=0);" src="<?=Url::to('@web/front/images/wx_20170408094200.jpg');?>">
<?php $this->beginBody() ?>

<?= $content ?>
<?php $this->endBody() ?>
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
<?php $this->endPage() ?>

