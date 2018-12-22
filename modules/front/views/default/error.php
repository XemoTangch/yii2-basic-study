<?php
/**
 * User: jiangm
 * Date: 2017/3/15
 * Time: 14:15
 * Desc: 错误信息页面
 */
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
$this->title = $name;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <div class="container">

        <div class="site-error">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>

            <p>
                服务器处理您的请求时发生错误。
            </p>
            <p>
                如果你认为这是一个服务器错误，请联系我们。谢谢你！
            </p>
            <p>
               <a href="http://www.imhaigui.com/">我是海归网</a>
            </p>

        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
