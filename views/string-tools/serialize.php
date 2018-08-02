<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/8/1
 * Time: 14:41
 * Desc:
 *
 * @var $content
 * @var $un_serialize
 */
$this->title = '串行化工具';
?>

<div>
    <form action="" method="post">
        <textarea name="content" id="content" cols="30" rows="10" placeholder="请输入串行化文本"><?=$content?></textarea>
        <!-- csrf 防止跨站请求伪造 -->
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <br/>
        <input type="submit" value="提交">
    </form>
</div>

<br/>

<samp>
<?php
echo '<pre>';
print_r($un_serialize);
echo '</pre>';
?>
</samp>
