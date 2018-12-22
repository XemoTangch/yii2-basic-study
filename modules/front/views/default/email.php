<?php
/**
 * User: jiangm
 * Date: 2017/3/30
 * Time: 17:41
 * Desc: 邮件模板
 */
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<style>
    table {
        border-collapse:collapse;
        border:1px solid #dddddd;
    }
    td {
        border:1px solid #dddddd; padding:5px;
    }
</style>
<body>
<table width="720" style="margin:0 auto;" border="0" cellspacing="0" cellpadding="0" >
    <tbody>
    <tr style="background: #f9f9f9"><td style="font-weight: bold;">投递岗位名称</td><td><?=$data['jobData']['jobs']?></td></tr>
    <tr><td style="font-weight: bold;">姓名</td><td><?=$data['resumeData']->name?></td></tr>
    <tr style="background: #f9f9f9"><td style="font-weight: bold;">性别</td><td><?=$data['resumeData']->sex==1?'男':'女';?></td></tr>
    <tr><td style="font-weight: bold;">电话</td><td><?=$data['resumeData']->mobile?></td></tr>
    <tr style="background: #f9f9f9"><td style="font-weight: bold;">邮箱地址</td><td><?=$data['resumeData']->email?></td></tr>
    <tr><td style="font-weight: bold;">毕业院校</td><td><?=$data['resumeData']->college?></td></tr>
    <tr style="background: #f9f9f9"><td style="font-weight: bold;">最高学历</td><td><?=$data['resumeData']->education?></td></tr>
    <tr><td style="font-weight: bold;">当前公司</td><td><?=$data['resumeData']->current_company?$data['resumeData']->current_company:'未填写';?></td></tr>
    <tr style="background: #f9f9f9"><td style="font-weight: bold;">当前职位</td><td><?=$data['resumeData']->current_job?$data['resumeData']->current_job:'未填写';?></td></tr>
    <tr><td style="font-weight: bold;">任职时间</td><td><?=$data['resumeData']->work_time?$data['resumeData']->work_time['start_time'].'至'.$data['resumeData']->work_time['end_time']:'未填写';?></td></tr>
    <tr style="background: #f9f9f9;"><td style="font-weight: bold;" colspan="2">更多信息您可以登陆后台进行查看，后台地址：<?=Url::toRoute('/ccadmin', true)?>，登陆账号、密码和招聘官网http://jobshaigui.com/的一样。</td></tr>
    </tbody>
</table>
</body>
</html>
