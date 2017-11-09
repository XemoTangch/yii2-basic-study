<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/1
 * Time:  19:35
 * Desc:
 */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\CommonAsset;

CommonAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style type="text/css">
    html,body{
        height: 100%;
    }
    .wrap {
        min-height: 100%;
        height: auto;
        margin: 0 auto -40px;
        padding: 0 0 60px;
    }
    .footer {
        height: 40px;
        background-color: #f5f5f5;
        border-top: 1px solid #ddd;
        padding-top: 9px;
    }
</style>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Yii2 Study <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


