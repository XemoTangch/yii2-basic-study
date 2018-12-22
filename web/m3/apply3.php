<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/11/1
 * Time: 10:49
 * Desc: 参会人员报名
 */
$title = '百名海外博士深圳行-参会报名';
?>
<?php require_once 'header.php';?>
<div class="main">
    <div class="main1">
        <img class="background_img" src="img/page3.jpg" >
        <div class="zs_apply" style="top:15%;">
            <h1>参会人员报名</h1>
            <form action="/index.php/front/bbx/apply" class="zs_form">
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        姓名 Name:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[name]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        性别 Gender:
                    </div>
                    <div class="zs_form_radio">
                        <input id="sex_man" type="radio" name="param[sex]" value="1" required checked>
                        <label for="sex_man">
                            男
                        </label>
                        <input id="sex_woman" type="radio" name="param[sex]" value="2" required>
                        <label for="sex_woman">
                            女
                        </label>
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
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        最高学历 Education:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[education]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        留学国家 Country:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[country]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        毕业院校 University:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[university]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        所学专业 Major:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[major]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name">
                        研究领域 Study Field:
                    </div>
                    <div class="zs_form_input">
                        <input type="text" name="param[study_field]" required>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item">
                    <div class="zs_form_name" style="width: 100%;">
                        项目名称 Project（如有）:
                    </div>
                    <div class="zs_form_text">
                        <textarea name="param[project]"></textarea>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zs_form_item" style="color: #5F5D5E;line-height: 15px;font-size: 10px;">
                    感谢您报名2019年百博行，您的报名资料将会进入审核阶段，稍后会有工作人员联系您进一步提交相关资料，请您留意邮箱，谢谢。
                </div>

                <input type="hidden" name="param[t]" value="3">
                <div class="submit">
                    <img src="img/button_submit.png">
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'foot.php';?>