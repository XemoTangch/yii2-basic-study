<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/8/2
 * Time: 11:38
 * Desc:
 *
 * @var $time
 * @var $date
 * @var $param
 */
$this->title = '时间戳工具';
?>

<form action="" method="post">
    <div class="form-group">
        <label for="param">时间戳或日期</label>
        <input type="text" class="form-control" id="param" name="param" placeholder="时间戳或日期" value="<?=$param?>">
    </div>
    <!-- csrf 防止跨站请求伪造 -->
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <button type="submit" class="btn btn-default">Submit</button>
</form>

<h2>转换结果</h2>
<table class="table table-bordered">
    <tbody>
    <tr>
        <th scope="row">时间戳（秒）</th>
        <td><?=$time?></td>
    </tr>
    <tr>
        <th scope="row">日期</th>
        <td><?=$date?></td>
    </tr>
    </tbody>
</table>