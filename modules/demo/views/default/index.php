<?php
use app\components\widget\HelloWidget;
use app\components\widget\Hello2Widget;
?>

<div class="demo-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
<h2>自定义小部件使用</h2>
<?= HelloWidget::widget(['message' => 'Good morning']) ?>

<h2>可在begin和end中使用的小部件</h2>
    content that may contain <tag>'s
    <br/>
<?php Hello2Widget::begin(); ?>
    content that may contain <tag>'s
        <br/>
<?php Hello2Widget::end(); ?>


