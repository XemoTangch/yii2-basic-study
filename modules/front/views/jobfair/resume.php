<?php
/**
 * User: jiangm
 * Date: 2017/3/16
 * Time: 18:26
 * Desc: 保存和修改简历视图
 * @var $jobData object
 * @var $candidate array
 * @var $resumeData object
 * @var $companyData object
 */
use yii\helpers\Url;
$this->title = '新建简历-深圳海外归国人才招聘会';
?>
<h1 class="entered">新建简历</h1>
<article class="entered_li">
    <form id="resume-save" action="<?=Url::toRoute('jobfair/resume');?>" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <div>应聘岗位：</div><?=$companyData['enterprisenamecn'].'-'.$jobData['jobs']?>
            </li>
            <li><div>手机号：</div><?=$candidate['mobile']?></li>
            <li><div>电子邮箱<i>*</i>：</div><input type="text" placeholder="请输入您的电子邮箱" name="email" value="<?=$candidate['email']?$candidate['email']:''?>" /></li>
            <li><div>姓名<i>*</i>：</div><input type="text" placeholder="请输入您的姓名" name="name" value="<?=$resumeData?$resumeData->name:''?>" /></li>
            <li class="resume_sex"><div>性别<i>*</i>：</div>
                <?php if($resumeData){ ?>
                <input  type="radio" name="sex" <?=$resumeData->sex==1?'checked="checked"':''?> value="1" />男
                <input  type="radio" name="sex" <?=$resumeData->sex==2?'checked="checked"':''?> value="2" />女
                <?php }else{ ?>
                    <input  type="radio" name="sex" checked="checked" value="1"/>男
                    <input  type="radio" name="sex" value="2" />女
                <?php } ?>
            </li>

            <li><div>毕业院校<i>*</i>：</div><input type="text" placeholder="请输入您的毕业院校" name="college" value="<?=$resumeData?$resumeData->college:''?>" /></li>
            <li><div>最高学历<i>*</i>：</div>
                <select name="education">
                    <option value="学士" <?=$resumeData&&$resumeData->education == '本科'?'selected="selected"':'';?>>学士</option>
                    <option value="硕士" <?=$resumeData&&$resumeData->education == '硕士'?'selected="selected"':'';?>>硕士</option>
                    <option value="博士" <?=$resumeData&&$resumeData->education == '博士'?'selected="selected"':'';?>>博士</option>
                    <option value="其他" <?=$resumeData&&$resumeData->education == '其他'?'selected="selected"':'';?>>其他</option>
                </select>
            </li>


            <li><div>专业<i>*</i>：</div><input type="text" placeholder="请输入您的专业" name="professional" value="<?=$resumeData?$resumeData->professional:''?>"></li>
            <li><div>感兴趣职位<i>*</i>：</div><input type="text" placeholder="请输入您感兴趣的职位" name="interested_position" value="<?=$resumeData?$resumeData->interested_position:''?>"></li>
            <li><div>工作的城市<i>*</i>：</div><input type="text" placeholder="请输入您当前工作城市" name="job_city" value="<?=$resumeData?$resumeData->job_city:''?>"></li>
            <li class="resume_sex"><div>是否在职<i>*</i>：</div>
                <?php if($resumeData){ ?>
                    <input type="radio" name="is_job" <?=$resumeData->is_job==0?'checked="checked"':''?> value="0" />否
                    <input type="radio" name="is_job" <?=$resumeData->is_job==1?'checked="checked"':''?> value="2" />是
                <?php }else{ ?>
                    <input type="radio" name="is_job" checked="checked" value="0"/>否
                    <input type="radio" name="is_job" value="1" />是
                <?php } ?>
            </li>
            <li><div>简历图片<i>*</i>：</div><input type="file" id="file"  name="Resume[file]" value="" accept="image/*" /></li>


            <li><div>当前公司<i></i>：</div><input type="text" placeholder="请输入您当前公司" name="current_company" value="<?=$resumeData?$resumeData->current_company:''?>"></li>
            <li><div>当前职位<i></i>：</div><input type="text" placeholder="请输入您当前职位" name="current_job" value="<?=$resumeData?$resumeData->current_job:''?>"></li>
            <li><div>任职时间<i></i>：</div><input type="text" placeholder="任期时间" name="work_time_start" id="scroller" value="<?=$resumeData&&$resumeData->work_time?$resumeData->work_time->start_time:''?>">&nbsp;~&nbsp;<input type="text" placeholder="任期时间" name="work_time_end" id="scroller01" value="<?=$resumeData&&$resumeData->work_time?$resumeData->work_time->end_time:''?>"></li>
        </ul>
        <button type="button" class="entered_submit">提交</button>
<!--        <button type="button" class="entered_submit">提交</button>-->
        <input type="hidden" name="jobid" value="<?=$jobData['id']?>" />
        <input type="hidden" name="companyid" value="<?=$companyData['id']?>" />
        <input type="hidden" name="jobs" value="<?=$jobData['jobs']?>" />
        <input type="hidden" name="resumeid" value="<?=$resumeData?$resumeData->resumeid:''?>" />
    </form>
</article>
<script type="text/javascript">

    $('.entered_submit').click(function() {
        //获取表单数据
        var formData = $('form').serializeArray();
//        console.log(formData);
        var params = new Object(),
            requiredData = {
                name: '姓名',
                email: '邮箱',
                sex: '性别',
                college: '毕业院校',
                education: '最高学历',
                professional:'专业',
                interested_position:'感兴趣职位',
                job_city:'工作的城市',
//                current_company:'当前公司',
//                current_job:'当前职位'
            };
        var verifyOk = true;

        $.each(formData, function(key, value){
            params[value.name] = value.value;
            if(requiredData[value.name] && !value.value){
                layer.open({content: '请输入'+requiredData[value.name],skin: 'msg',time: 2});
                verifyOk = false;
                return false;
            }
            if(value.name == 'email' && !verifyEmail(value.value)){
                layer.open({content: '邮箱格式有误，请重新输入',skin: 'msg',time: 2});
                verifyOk = false;
                return false;
            }
        });

        //任职时间要填写完整
        if((params.work_time_start && !params.work_time_end) || (!params.work_time_start && params.work_time_end)){
            layer.open({content: '请将任职时间填写完整',skin: 'msg',time: 2});
            verifyOk = false;
            return false;
        }
        if(!$('#file').val()){
            layer.open({content: '请上传您的简历图',skin: 'msg',time: 2});
            verifyOk = false;
            return false;
        }

        if(verifyOk == true){
            $("#resume-save").submit();
        }
    });

    //提交简历
    $('.entered_submite').click(function(){
        //获取表单数据
        var formData = $('form').serializeArray();
        console.log(formData);
        var params = new Object(),
            requiredData = {
                name: '姓名',
                email: '邮箱',
                sex: '性别',
                college: '毕业院校',
                education: '最高学历'
            };
        var verifyOk = true;
        $.each(formData, function(key, value){
            params[value.name] = value.value;
            if(requiredData[value.name] && !value.value){
                layer.open({content: '请输入'+requiredData[value.name],skin: 'msg',time: 2});
                verifyOk = false;
                return false;
            }
            if(value.name == 'email' && !verifyEmail(value.value)){
                layer.open({content: '邮箱格式有误，请重新输入',skin: 'msg',time: 2});
                verifyOk = false;
                return false;
            }
        });

        //任职时间要填写完整
        if((params.work_time_start && !params.work_time_end) || (!params.work_time_start && params.work_time_end)){
            layer.open({content: '请将任职时间填写完整',skin: 'msg',time: 2});
            verifyOk = false;
            return false;
        }

        //提交数据
        if(!verifyOk){return false;}
        $.ajax({
            type: 'POST',
            url: '<?=Url::toRoute('jobfair/resume')?>',
            data: formData,
            dataType: 'json',
            timeout: 3000,
            success: function(data){
                if(data.code == 200){
                    //异步发送邮件给企业
                    $.ajax({
                        url: '<?=Url::toRoute('jobfair/send-mail')?>',
                        data: {jobid: '<?=$jobData['id']?>',companyid:'<?=$companyData['id']?>'},
                        type: 'post',
                        dataType: 'json',
                        timeout: 6000,
                        success: function(data){
                            //console.info(data);
                        }
                    });
                    //弹窗
                    layer.open({content: '简历保存并投递成功',btn:'确定', shadeClose:false,yes: function(index){
                        window.location.href = '<?=Url::toRoute('/front/jobfair/company?id='.$companyData['id'])?>';
                    }});
                }else if(data.code == 1001){ //还未验证身份
                    window.location.href = '<?=Url::toRoute('/front/jobfair/company?code='.$companyData['id'])?>';
                }else{
                    layer.open({content: data.message,skin: 'msg',time: 2});
                }
            },
            error: function(){
                layer.open({content: '投递失败，请联系工作人员或稍后再试',skin: 'msg',time: 2});
            },
            complete: function(XML, status){
                if(status == 'timeout'){
                    layer.open({content: '请求超时，请检查您的网络连接',skin: 'msg',time: 2});
                }
            }
        });

    }); //提交简历end

    //时间选择
    $("#scroller").mobiscroll().date();
    $("#scroller01").mobiscroll().date();
    var currYear = (new Date()).getFullYear();
    //初始化日期控件
    var opt = {
        preset: 'date', //日期，可选：date\datetime\time\tree_list\image_text\select
        theme: 'android-ics light', //皮肤样式，可选：default\android\android-ics light\android-ics\ios\jqm\sense-ui\wp light\wp
        display: 'modal', //显示方式 ，可选：modal\inline\bubble\top\bottom
        mode: 'scroller', //日期选择模式，可选：scroller\clickpick\mixed
        lang:'zh',
        dateFormat: 'yyyy-mm-dd', // 日期格式
        setText: '确定', //确认按钮名称
        cancelText: '取消',//取消按钮名籍我
        dateOrder: 'yyyymmdd', //面板中日期排列格式
        dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字
        showNow: false,
        nowText: "今",
        startYear:currYear - 100, //开始年份
        endYear:currYear + 100 //结束年份
        //endYear:2099 //结束年份
    };
    $("#scroller").mobiscroll(opt);
    $("#scroller01").mobiscroll(opt);

</script>
