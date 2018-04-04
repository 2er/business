<script data-exec-on-popstate="">
    $(function () {

        //对私对公切换
        $('input[name=acctype]').on('change', function(event) {

            var acctype = $(this).val();
            if(acctype == '00'){
                $('.form-group').has('.cardno,.cardname,.idno,.mobileno').show();
                $('.form-group').has('.corpname,.corpcode,.corpaccno').hide();
            }else if(acctype == '01'){
                $('.form-group').has('.corpname,.corpcode,.corpaccno').show();
                $('.form-group').has('.cardno,.cardname,.idno,.mobileno').hide();
            }
        });

        $('.form-group').has('.corpname,.corpcode,.corpaccno').hide();

        //提交
        $('form').on('submit',function(event){
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                method: 'POST',
                url: '{{ route('account-save') }}',
                data: formData,
                async: false,
                success: function (data) {
                    console.log(data);
                    if(data.status == 'succ'){

                    }else{
                        var html = $('template.param-tpl').html();
                        html = html.replace(new RegExp('__msg__', 'g'), data.msg);

                        var append = $(html);

                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            // var post_data = $(this).serializeArray();
            // for(var i=0;i<post_data.length;i++){
            //     var item = post_data[i];
            //     if(item.name === 'custno'){
            //         if(item.value === ''){
            //
            //         }
            //     }
            //     if(item.name === 'acctype'){
            //         if(item.value === '00'){
            //
            //         }
            //     }
            // }
        })
    });
</script>
<div class="col-md-12"><div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">填写开户信息</h3>
            <div class="box-tools">
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="save" method="post" accept-charset="UTF-8" class="form-horizontal">
            <div class="box-body">
                <div class="fields-group">
                    <div class="form-group  ">
                        <label for="custno" class="col-sm-2 control-label">客户号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="custno" name="custno" value="" class="form-control custno" placeholder="客户号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="acctype" class="col-sm-2 control-label">账户类型</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="acctype" value="00" class="minimal acctype" checked="" style="position: absolute;">&nbsp;对私&nbsp;&nbsp;
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="acctype" value="01" class="minimal acctype" style="position: absolute;">&nbsp&nbsp;对公&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="accbank" class="col-sm-2 control-label">开户银行</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="accbank" name="accbank" value="" class="form-control accbank" placeholder="Input 开户银行">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="cardno" class="col-sm-2 control-label">银行卡号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="cardno" name="cardno" value="" class="form-control cardno" placeholder="Input 银行卡号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="cardname" class="col-sm-2 control-label">持卡人姓名</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="cardname" name="cardname" value="" class="form-control cardname" placeholder="Input 持卡人姓名">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="idno" class="col-sm-2 control-label">身份证号码</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="idno" name="idno" value="" class="form-control idno" placeholder="Input 身份证号码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="mobileno" class="col-sm-2 control-label">手机号</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input style="width: 150px" type="text" id="mobileno" name="mobileno" value="" class="form-control mobileno" placeholder="Input 手机号">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="corpname" class="col-sm-2 control-label">企业名称</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="corpname" name="corpname" value="" class="form-control corpname" placeholder="Input 企业名称">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="corpcode" class="col-sm-2 control-label">企业统一信用代码</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <input type="text" id="corpcode" name="corpcode" value="" class="form-control corpcode" placeholder="Input 企业统一信用代码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group  ">
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
                <input type="hidden" name="_token" value="jEwuGle9jRGOdpsd4EDsts1nVoNSFz34C7jtc4Ff">
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