<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/8/1
 * Time: 14:41
 * Desc:
 *
 * @var $tool_list
 */

$this->title = '工具首页';
?>

<?php foreach($tool_list as $value):?>
    <div>
        <a href="<?=$value->url;?>">[<?=$value->class;?>]::<?=$value->name;?></a>
    </div>
<?php endforeach;?>

