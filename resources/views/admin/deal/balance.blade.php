<script data-exec-on-popstate="">
    $(function () {

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

            if(check == false){
                return false;
            }

            $.ajax({
                method: 'POST',
                url: '{{ route('deal-balance') }}',
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
            <h3 class="box-title">余额查询</h3>
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