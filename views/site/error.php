<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        抱歉，请求发生错误。如果您认为是服务器错误，请您联系我，谢谢。
    </p>
    <p>
        邮箱地址：jmphper@foxmial.com
    </p>
</div>
