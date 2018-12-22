<?php
/**
 * User: jiangm
 * Date: 2017/3/15
 * Time: 16:41
 * Desc: 企业信息视图
 *
 * @var $companyData
 * @var $jobList
 * @var $candidate
 */
use yii\helpers\Url;
$this->title = $companyData['name_cn'].'-海归人才专场招聘会';
?>

<style>
    .p-number{font-size: 1.2em;color: #a0a1a1;text-align:right;margin-right: 10px;font-weight: bold;display: block;margin-top: 5px;}
    .div-logo{display: inline-block;vertical-align: middle;}
    .div-name{display: inline-block;vertical-align: middle;height: 42px;}
    .div-img-logo{margin-left: 10px;width: 80px;height: 42px;}
    .p-chiness-name{font-size: 1.4em;color: #e69a37;margin-left: 5px;}
    .p-english-name{font-size: 1.1em;color: #000000;margin-left: 5px;}
    .abstract{
        position: relative;display: block;;background: #fefbf6;padding: 4% 0 0 0;margin-top: 10px;
    }
    .abstract p:nth-child(1){color: #e69a37;font-size: 1.4em;margin-left: 2%;}
    .abstract p:nth-child(2){font-size: 1.2em;letter-spacing: 1px;color:#595758;margin-left: 2%;margin-right: 2%;margin-top: 2%;}
    .abstract p:nth-child(3){color: #e69a37;font-size: 1.4em;margin-top: 60px;margin-left: 2%;}
    .abstract hr{border: none;border-top:1px solid #e69a37;margin-left: 2%;margin-right: 2%;}
    .abstract .p-position{color: #595758;margin-left: 2%;}
    .recruit-bg{width: 100%;bottom: 0;margin-top: 25px;}
    .abstract .div-url{background: #efb967;padding: 8px 0 8px 2%;margin-top: 25px;}
    .div-url h4{font-size: 1.1em;color: #ffffff;}
</style>
<p class="p-number">展位号: <?php echo $companyData['exib_number']?></p>

<div class="div-logo">
    <img  src="<?=Url::to($companyData['image'])?>" class="div-img-logo"/>
</div>

<div class="div-name">
    <p class="p-chiness-name"><?php echo $companyData['enterprisenamecn']?></p >
    <p class="p-english-name"><?php echo $companyData['enterprisenameen']?></p >
</div>


<div class="abstract">
    <p class="p-first-abs">企业简介：</p >
    <p><?php echo $companyData['comdesccn']?></p >

    <p>招聘职位</p >
    <hr>
    <p class="p-position"><?php echo $companyData['jobname_string']?></p >

    <div class="div-url">
        <h4>更多的招聘信息请到公司展位上了解</h4>
        <h4><?php echo $companyData['mainpage']?></h4>
    </div>
</div>
<input type="hidden" value="<?=$companyData['id']?>" id="companyid" />
<h2 class="zp_top">职位信息</h2>
<article class="main">
    <?php if($jobList){ ?>
    <?php foreach($jobList as $value){ ?>
    <div class="zp_li">
        <h3><?=mb_substr($value['jobs'], 0, 22,'utf-8')?>
            <?php if($candidate && $value['is_send']){ ?>
                <a class="issend" style="background-color: green;">已投递</a>
            <?php }else{ ?>
            <a class="sendResume" jobs="<?=$value['jobs']?>" jobid="<?=$value['id']?>">投递简历</a>
            <a class="issend" style="background-color: green;display:none;">已投递</a>
            <?php }?>
        </h3>
        <div class="zp_bottom">
            <ul>
                <li>工作地点：<br><span><?=$value['job_address']?></span></li>

            </ul>
            <div class="zp_arrow"></div>
            <div class="zp_duty" style="overflow:hidden;">
                <div>岗位要求：<br><span><?=$value['dcontent']?></span></div>
                <div class="zp_arrow_up"></div>
            </div>
        </div>
    </div>
    <?php } }else{ ?>
        <h4>暂无职位信息</h4>
    <?php } ?>
</article>

<div class="cen_top_fs">
    <img src="<?=Url::to('@web/front/images/xl.jpg');?>">
</div>
<div class="zy_bottom">
    <ul>
        <li><a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.imhaigui.android"><img src="<?=Url::to('@web/front/images/banner3.jpg');?>"><span>点击查看 >></span></a></li>
    </ul>
</div>

<?=$candidate?'':$this->render('mobile.php');?>
<script type="application/javascript">
    $(function(){
        // 职位信息展开和关闭
        $(".zp_arrow").click(function(){
            $(this).next().show(200);
            $(this).hide();
        });
        $(".zp_arrow_up").click(function(){
            $(this).parent().hide();
            $(this).parent().prev().show(200);
        });

        //投递简历操作
        $('.sendResume').click(function(){
            var jobid = $(this).attr('jobid'),
                jobs = $(this).attr('jobs'),
                companyid = $('#companyid').val(),
                _this = $(this);
            $.ajax({
                url: '<?=Url::toRoute('jobfair/send-resume')?>',
                data: {jobid:jobid,jobs:jobs,companyid:companyid,jobs:jobs},
                type: 'post',
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    switch(data.code){
                        case 200:
                            layer.open({content: '简历投递成功',skin: 'msg',time: 2});
                            _this.hide();
                            _this.parent().find('.issend').show();
                            //异步发送邮件给企业
                            $.ajax({
                                url: '<?=Url::toRoute('jobfair/send-mail')?>',
                                data: {jobid: jobid,companyid:companyid,jobs:jobs},
                                type: 'post',
                                dataType: 'json',
                                timeout: 6000,
                                success: function(data){
                                    //console.info(data);
                                }
                            });
                            break;
                        case 1002:
                            // 验证身份弹窗
                            openLogin(jobid,companyid,jobs);

                            break;
                        case 1003:
                            window.location.href = '<?=Url::toRoute('jobfair/resume?jobid=')?>'+jobid+'&jobs='+jobs+'&companyid='+companyid;
                            break;
                        default:
                            layer.open({content: data.message,skin: 'msg',time: 2});
                            break;
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
        });

    });
</script>



