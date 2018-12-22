<?php
/**
 * User: jiangm
 * Date: 2017/3/16
 * Time: 11:17
 * Desc: 手机号验证
 */
use yii\helpers\Url;
?>
<div id="mobile_captcha" style="display:none;">
    <div class="mobile_captcha_content">
        <input type="number" name="mobile_prefix" value="86" placeholder="国家区号,中国为86" class="entry_mobile">
        <input type="number" name="mobile" value="" placeholder="请输入您的手机号" class="entry_mobile">
        <input type="number" name="captcha" placeholder="请输入验证码" class="entry_yzm">
        <button class="yzm send_captcha" type="button">发送验证码</button>
        <button class="yzm reSend" type="button" style="display:none;">重新发送(<span class="second"></span>)</button>
    </div>
</div>
<script type="application/javascript">
        var secondText = 59;

        //发送验证码
        function sendCaptcha(elem){
            var mobile = elem.find('input[name="mobile"]').val();
            var mobile_prefix = elem.find('input[name="mobile_prefix"]').val();
            //验证
            if(mobile == ''){
                alert('请输入手机号码');
                return false;
            }
            if(mobile_prefix == ''){
                alert('国家区号');
                return false;
            }
            if(!verifyCountyNumber(mobile_prefix)){
                alert('国家区号有误，请重新输入');
                return false;
            }
            if(mobile_prefix == 86 && !verifyPhone(mobile)){
                alert('手机号格式有误，请重新输入');
                return false;
            }

            //发送验证码
            $.ajax({
                data: {mobile: mobile,mobile_prefix: mobile_prefix},
                dataType: 'json',
                type: 'post',
                url: '<?=Url::toRoute('jobfair/captcha?operate=send')?>',
                timeout: 3000,
                success: function(data){
                    if(!data || !data.code) alert('提交失败，请稍后再试');
                    if(data.code == 200){
                        alert('验证码发送成功');
                        elem.find('.reSend').css('background','#696C6E');
                        elem.find('.yzm').hide();
                        elem.find('.second').text(secondText);
                        elem.find('.reSend').show();
                        reSendTime(elem.find('.second'));
                    }else{
                        alert(data.message);
                    }
                },
                error: function(){
                    alert('提交失败，请稍后再试');
                },
                complete: function(XML, status){
                    if(status == 'timeout'){
                        alert('请求超时，请检查您的网络连接');
                    }
                }
            });

        }// 发送验证码 end

        // 倒计时
        function reSendTime(second){
            var t;
            timeCount();
            function timeCount(){
                var num = second.text();
                num--;
                if(num<=0){
                    clearTimeout(t);
                    second.parent().hide();
                    second.parent().prev().show();
                    second.parent().prev().css('background','#368cc9');
                }else{
                    second.text(num);
                    t = setTimeout(function(){
                        timeCount();
                    }, 1000);
                }
            }
        }

        //提交验证身份
        function submitCaptcha(elem, jobid, companyid, jobs, type){
            var params = new Object();
            params['mobile'] = elem.find('input[name="mobile"]').val();
            params['captcha'] = elem.find('input[name="captcha"]').val();
            params['mobile_prefix']= elem.find('input[name="mobile_prefix"]').val();
            params['jobid'] = jobid;
            params['companyid'] = companyid;
            params['jobs'] = jobs;

            if(type){
               var typetxt = 'apply2'
            }else{
                var typetxt = 'validate'
            }
            //验证
            if(params.mobile == ''){
                alert('请输入手机号码');
                return false;
            }
            if(params.captcha == ''){
                alert('请输入验证码');
                return false;
            }
            if(params.mobile_prefix == ''){
                alert('请输入国家区号');
                return false;
            }
            if(params.mobile_prefix == 86 && !verifyPhone(params.mobile)){
                alert('手机号格式有误，请重新输入');
                return false;
            }
            if(!verifyPhoneCode(params.captcha)){
                alert('验证码由4位数字组成，请重新输入');
                return false;
            }
            if(!verifyCountyNumber(params.mobile_prefix)){
                alert('国家区号有误，请重新输入');
                return false;
            }
            //提交
            $.ajax({
                data: params,
                dataType: 'json',
                type: 'post',
                url: '<?=Url::toRoute('jobfair/captcha?operate=')?>'+typetxt,
                timeout: 3000,
                success: function(data){
                    if(!data || !data.code) alert('提交失败，请稍后再试');
                    // 200 成功 202身份验证成功，简历投递失败 1003 已经验证过身份
                    if(data.code == 200 || data.code == 202 || data.code == 1003){
                        //异步发送邮件给企业
                        if(data.code == 200){
                            $.ajax({
                                url: '<?=Url::toRoute('jobfair/send-mail')?>',
                                data: {jobid: jobid,companyid: companyid},
                                type: 'post',
                                dataType: 'json',
                                timeout: 6000,
                                success: function(data){
                                    //console.info(data);
                                }
                            });
                        }

                        layer.open({
                            content: data.message
                            ,shadeClose: false
                            ,btn: '确定'
                            ,yes: function(index){
                                window.location.reload();
                                layer.close(index);
                            }
                        });
                    }else if(data.code == 201){
                        layer.open({
                            content: '身份验证成功，但您还未填写简历，去填写简历吧！'
                            ,shadeClose: false
                            ,btn: ['确定', '取消']
                            ,yes: function(index){
                                window.location.href = '<?=Url::toRoute('jobfair/resume?jobid=')?>'+jobid+'&companyid='+companyid;
                                layer.close(index);
                            }
                        });
                    }else if(data.code == 1113){
                        layer.open({
                            content: '身份验证成功，但您还未报名，去报名吧！'
                            ,shadeClose: false
                            ,btn: ['确定', '取消']
                            ,yes: function(index){
                                window.location.href = '<?=Url::toRoute('jobfair/applyinfo')?>';
                                layer.close(index);
                            }
                        });
                    }else if(data.code == 1114){
                        layer.open({
                            content: '身份验证成功，但您还未报名，去报名吧！'
                            ,shadeClose: false
                            ,btn: ['确定', '取消']
                            ,yes: function(index){
                                window.location.href = '<?=Url::toRoute('jobfair/applyinfo2')?>';
                                layer.close(index);
                            }
                        });
                    }else if(data.code == 208){
                        alert(data.message);
                        window.location.href = '<?=Url::toRoute('jobfair/homepage')?>';
                    }else if(data.code == 209){
                        alert(data.message);
                        window.location.href = '<?=Url::toRoute('jobfair/homepage2')?>';
                    }else if(data.code == 2008){
                        alert(data.message);
                        window.location.href = '<?=Url::toRoute('jobfair/jobfair')?>';

                    }else{
                        alert(data.message);
                    }
                },
                error: function(){
                    alert('提交失败，请稍后再试');
                },
                complete: function(XML, status){
                    if(status == 'timeout'){
                        alert('请求超时，请检查您的网络连接');
                    }
                }
            });

        }//提交验证身份 end

        // 打开验证身份弹窗
        function openLogin(jobid,companyid,jobs,type){
            layer.open({
                title: '身份验证',
                className: 'mobile_captcha',
                content: $('#mobile_captcha').html(),
                btn: '提交验证码',
                shadeClose: true,
                success: function(elem){
                    $(elem).find('.layui-m-layercont').css('padding','0px 30px 50px');
                    $(elem).find('.send_captcha').click(function(){
                        sendCaptcha($(elem));
                    });
                },
                yes: function(index){
                    var elem = $('#layui-m-layer'+index);
                    submitCaptcha(elem,jobid,companyid,jobs,type);
                }
            });
        }
</script>
