<?php
/** @var $data array|bool */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>海归人才专场招聘会</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" type="text/css" href="<?=Url::to('@web/front/css/mm.css');?>" />
		<script src="<?=Url::to('@web/front/js/jquery-1.7.1.min.js');?>" type="text/javascript"></script>
	</head>

	<body>

		<div class="content">
			<img src="<?=Url::to('@web/front/images/sign_bgv1.png');?>">
		</div>

		<div class="div-input-bg">
			<img src="<?=Url::to('@web/front/images/input_bg.png');?>">
		</div>
		<form id="apply-save" action="<?=Url::toRoute('jobfair/applyinfo');?>" method="post" enctype="multipart/form-data" >
		<div class="data-input">

			<div class="input-comment">
				<p class="p-comment">姓名</p>
				<input type="text " id="name" name="name" placeholder="请填写您的姓名 " class="wx">
			</div>

			<div class="input-comment">
				<p class="p-comment">电话</p>
				<em style="font-size: 15px;margin-left: 10px;"><?=$candidate['mobile']?></em>
			</div>

			<div class="input-comment">
				<p class="p-comment">邮箱</p>
				<input type="text " id="email" name="email" placeholder="请填写您的邮箱 " class="wx">
			</div>

			<div class="input-comment">
				<p class="p-comment">求职城市<b class="b-select">（可多选）</b></p>

				<ul>
					<!-- 此处因为 上海北京 结束 默认选中深圳-->
					<!--
					<li class="first">北京<img src="<?=Url::to('@web/front/images/check_false.png');?>" id="first" /></li>
					<li class="second">上海<img src="<?=Url::to('@web/front/images/check_false.png');?>" id="second"/></li>
					-->
					<li class="three">深圳<img src="<?=Url::to('@web/front/images/check_true.png');?>" id="three"/></li>

				</ul>

			</div>

		</div>
		</form>

		<div class="footer ">
			<a id="submit-key" ><img src="<?=Url::to('@web/front/images/submit_btn.png');?>"></a>
		</div>

		<script>

            $(function() {
                var beijing = false;
                $(".first").click(function() {
                    if(beijing) {
                        beijing = false;
                        $("#first").attr('src', '<?=Url::to('@web/front/images/check_false.png');?>');
                    } else {
                        beijing = true;
                        $("#first").attr('src', '<?=Url::to('@web/front/images/check_true.png');?>');
                    }
                })



                var shanghai = false;
                $(".second").click(function() {
                    if(shanghai) {
                        shanghai = false;
                        $("#second").attr('src', '<?=Url::to('@web/front/images/check_false.png');?>');
                    } else {
                        shanghai = true;
                        $("#second").attr('src', '<?=Url::to('@web/front/images/check_true.png');?>');
                    }
                })



                var shenzhen = true;
                $(".three").click(function() {
                    if(shenzhen) {
                        shenzhen = false;
                        $("#three").attr('src', '<?=Url::to('@web/front/images/check_false.png');?>');
                    } else {
                        shenzhen = true;
                        $("#three").attr('src', '<?=Url::to('@web/front/images/check_true.png');?>');
                    }
                })



			$('#submit-key').click(function(){
				//获取表单数据

				var name = $('#name').val();
				var email = $('#email').val();

                if(!beijing && !shanghai && !shenzhen){
                    layer.open({content: '请选择至少一个城市',skin: 'msg',time: 2});
                    return false;
                }
                beijing = beijing?1:0;
                shanghai = shanghai?1:0;
                shenzhen = shenzhen?1:0;
				if(!name){
					layer.open({content: '姓名必填',skin: 'msg',time: 2});
					return false;
				}
				if(!email || !verifyEmail(email)){
					layer.open({content: '邮箱格式有误，请重新输入',skin: 'msg',time: 2});
					return false;
				}
				$.ajax({
					url: '<?=Url::toRoute('jobfair/applyinfo')?>',
					data: {name:name,email:email,beijing:beijing,shanghai:shanghai,shenzhen:shenzhen},
					type: 'post',
					dataType: 'json',
					timeout: 3000,
					success: function(data){
						console.log(data);
						switch(data.code){
							case 200:
								layer.open({
									content: '您已报名成功<br>可前往各地分站投递简历'
									,shadeClose: false
									,btn: '确定'
									,yes: function(index){
										window.location.href = '<?=Url::toRoute('jobfair/homepage')?>';
										layer.close(index);
									}
								});

								break;
							case 1113:
								window.location.href = '<?=Url::toRoute('jobfair/applyinfo')?>';
								break;
							default:
								layer.open({content: data.message,skin: 'msg',time: 2});
								break;
						}
					},
					error: function(){
						layer.open({content: '报名失败，请联系工作人员或稍后再试',skin: 'msg',time: 2});
					},
					complete: function(XML, status){
						if(status == 'timeout'){
							layer.open({content: '请求超时，请检查您的网络连接',skin: 'msg',time: 2});
						}
					}
				});


			});

            })


		</script>

	</body>

</html>