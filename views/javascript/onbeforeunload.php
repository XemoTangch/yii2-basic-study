<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/11/7
 * Time: 11:01
 * Desc:
 */

?>

<h3>离开此页都会有提示，提交表单不会提示</h3>
<form method="post" action="/javascript/index" onsubmit="return destroy()" >
    <input type="submit" value="提交"  />
</form>


<script type="text/javascript">
    window.onbeforeunload = function() {
        return "确认离开当前页面吗？未保存的数据将会丢失";
    }

    /**
     *提交表单前销毁提醒事件
     */
    function destroy(){
        window.onbeforeunload = null;
    }
</script>