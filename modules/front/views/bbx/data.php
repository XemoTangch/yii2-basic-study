<?php
/**
 * 欢迎界面视图
 *
 * @var $signPackage
 * @var $wx_share_info
 */
use yii\helpers\Url;
$this->title = '海归人才专场招聘会';
//var_dump($data);
?>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<table class="table table-striped table-bordered table-hover" >
    <thead>
        <tr role="row" class="heading">
            <?php foreach ($title_arr as $value): ?>
            <th style="width:150px;"><?php echo $value ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $fields): ?>
        <tr class="">
            <?php foreach ($fields as $k => $f): ?>
            <?php if($k == 'actids'):?>
            <?php 
                $_arr = explode(',',$f);
                $_arr_str = '';
                foreach ($_arr as $actid) {
                    switch ($actid) {
                        case '1': $_arr_str .= '深圳 '; break;
                        case '2': $_arr_str .= '北京 '; break;
                        case '3': $_arr_str .= '上海 '; break;
                    }
                }
            ?>
            <td><?php echo $_arr_str ?></td>
            <?php else:?>
            <td><?php echo $f ?></td>
            <?php endif?>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>



