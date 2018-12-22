<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/11/1
 * Time: 10:49
 * Desc: 留学人员成果展示区报名
 */
$title = '百名海外博士深圳行-成果展示报名';
?>
<?php require_once 'header.php';?>
<div class="main">
    <div class="main1">
        <img class="background_img" src="img/page2.jpg" >
        <div class="zs_apply">
            <form action="/index.php/front/bbx/apply" class="zs_form">
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        单位名称 Organization:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[organization]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        电话 Telephone:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[telephone]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        联系人姓名 Name:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[name]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        手机号码 Mobile:
                    </div>
                    <div class="zs_form_input">
                        <input type="number" name="param[mobile]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        邮箱 E-mail:
                    </div>
                    <div class="zs_form_input">
                        <input type="email" name="param[email]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <input type="hidden" name="param[t]" value="2">
                <div class="submit">
                    <img src="img/button_submit.png">
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'foot.php';?>