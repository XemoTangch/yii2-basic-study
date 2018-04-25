<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/4/25
 * Time: 17:32
 * Desc: 登录页面
 */

?>

<form action="/authentication/login" method="post">
    <div class="form-group">
        <label for="username">用户名：</label>
        <input type="text" class="form-control" name="username" placeholder="请输入用户名" required="required" />
    </div>
    <div class="form-group">
        <label for="password">密码：</label>
        <input type="password" class="form-control" name="password" placeholder="请输入密码" required="required" />
    </div>
    <!-- csrf 防止跨站请求伪造 -->
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <button type="submit" class="btn btn-default">Submit</button>
</form>
