<script data-exec-on-popstate="">
    $(function () {

        //对私对公切换
        $('input[name=acctype]').on('change', function(event) {

            var acctype = $(this).val();
            if(acctype == '00'){
                $('.form-group').has('.cardno,.mobileno').show();
                $('.form-group').has('.corpaccno').hide();
            }else if(acctype == '01'){
                $('.form-group').has('.corpaccno').show();
                $('.form-group').has('.cardno,.mobileno').hide();
            }
        });

        $('.form-group').has('.corpaccno').hide();

        //提交
        $('form').on('submit',function(event){
            event.preventDefault();
            var formData = new FormData(this);

            var check = true;

            //账户号
            if (formData.get('accountno').length == 0) {
                $('.form-group').has('.accountno').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.accountno').removeClass('has-error has-feedback');
                check = check && true;
            }

            //账户类型
            if (formData.get('acctype') != '00' && formData.get('acctype') != '01') {
                $('.form-group').has('.acctype').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.acctype').removeClass('has-error has-feedback');
                check = check && true;
            }

            //开户银行
            if (formData.get('accbank').length == 0) {
                $('.form-group').has('.accbank').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.accbank').removeClass('has-error has-feedback');
                check = check && true;
            }

            //银行卡号
            if (formData.get('acctype') == '00' && formData.get('cardno').length == 0) {
                $('.form-group').has('.cardno').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.cardno').removeClass('has-error has-feedback');
                check = check && true;
            }

            //手机号
            var mobile = formData.get('mobileno');
            var reg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
            if (formData.get('acctype') == '00' && (mobile.length == 0 || !reg.test(mobile))) {
                $('.form-group').has('.mobileno').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.mobileno').removeClass('has-error has-feedback');
                check = check && true;
            }

            //企业银行账号
            if (formData.get('acctype') == '01' && formData.get('corpaccno').length == 0) {
                $('.form-group').has('.corpaccno').addClass('has-error has-feedback');
                check = false;
            }else{
                $('.form-group').has('.corpaccno').removeClass('has-error has-feedback');
                check = check && true;
            }

            if(check == false){
                return false;
            }

            $.ajax({
                method: 'POST',
                url: '{{ route('account-modify') }}',
                data: formData,
                async: false,
                success: function (data) {
                    console.log(data);
                    if(data.status == 'succ'){
                        var html = $('template.param-tpl-success').html();
                        html = html.replace(new RegExp('__msg__', 'g'), '提交成功，等待审核！');

                        var append = $(html);
                        $('div.box-info').before(append);

                        setTimeout(function(){
                            $('.close').click();
                        },3000)

                    }else{
                        var html = $('template.param-tpl-error').html();
                        html = html.replace(new RegExp('__msg__', 'g'), data.msg);

                        var append = $(html);
                        $('div.box-info').before(append);

                        setTimeout(function(){
                            $('.close').click();
                        },3000)
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        })
    });
</script>
<div class="col-md-12"><div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">填写账户变更信息</h3>
            <div class="box-tools">
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="doedit" method="post" accept-charset="UTF-8" class="form-horizontal">
            <div class="box-body">
                <div class="fields-group">
                    <div class="form-group">
                        <label for="accountno" class="col-sm-2 control-label">账户号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="accountno" name="accountno" value="" class="form-control accountno" placeholder="账户号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="acctype" class="col-sm-2 control-label">账户类型</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="acctype" value="00" class="minimal acctype" checked="" style="position: absolute;">&nbsp;对私&nbsp;&nbsp;
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="acctype" value="01" class="minimal acctype" style="position: absolute;">&nbsp;对公&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="accbank" class="col-sm-2 control-label">开户银行</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="accbank" name="accbank" value="" class="form-control accbank" placeholder="Input 开户银行">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cardno" class="col-sm-2 control-label">银行卡号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="cardno" name="cardno" value="" class="form-control cardno" placeholder="Input 银行卡号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobileno" class="col-sm-2 control-label">手机号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input style="width: 150px" type="text" id="mobileno" name="mobileno" value="" maxlength="11" class="form-control mobileno" placeholder="Input 手机号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="corpaccno" class="col-sm-2 control-label">企业银行账号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="corpaccno" name="corpaccno" value="" class="form-control corpaccno" placeholder="Input 企业银行账号">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Submit">提交</button>
                    </div>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>

</div>

<template class="param-tpl-error">
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        __msg__
    </div>
</template>

<template class="param-tpl-success">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        __msg__
    </div>
</template>