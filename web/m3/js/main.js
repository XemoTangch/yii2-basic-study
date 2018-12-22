/**
 * Created by jiangm on 2018/10/31.
 */

$(function(){

    $('.index_button_img').on('click', function(){
        location.href = $(this).attr('data-url');
    });


    // 提交表单
    $('.submit').click(function(){
        var form = $('form'),
            is_submit = true,
            success_msg = '报名成功，请等待审核！';
        $.each(form[0], function(k, v){
            if($(v).attr('name') === 'param[t]' && $(v).val() !== '3')
                success_msg = '报名成功！稍后将会有工作人员联系您，请耐心等待。';
            if($(v).attr('name') === 'param[project]') return false;
            if($(v).val() && $(v).val() !== '') return true;
            is_submit = false;
            var _name = $.trim($(v).parent().parent().find('.zs_form_name').text());
            swal('警告', '请您填写'+_name+'后再提交', 'warning');
            return false;
        });
        if(!is_submit) return false;
        // 提交数据
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            success: function(data){
                if(data === 'success'){
                    swal('成功', success_msg, 'success');
                }else{
                    swal('错误', data, 'error');
                }
            },
            error: function(){
                swal('错误', '抱歉，服务器繁忙，请稍后再试', 'error');
            }
        });

    });

});
