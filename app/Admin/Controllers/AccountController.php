<?php

namespace App\Admin\Controllers;

use App\Helpers\AccUtil;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use ModelForm;

    /**
     * 检查数据合法性
     */
    private function verify($post_data=[],$type='create',&$msg){
        if(empty($post_data)){
            $msg = 'Empty Data';
            return false;
        }

        //检查数据合法性
        $msg = 'Data illegal';

        if($type == 'create' && (!isset($post_data['custno']) || !$post_data['custno']))
        {
            return false;
        }

        if($type == 'modify' && (!isset($post_data['accountno']) || !$post_data['accountno']))
        {
            return false;
        }

        if(!isset($post_data['acctype']) || !$post_data['acctype'])
        {
            return false;
        }

        if(!isset($post_data['accbank']) || !$post_data['accbank'])
        {
            return false;
        }

        if($post_data['acctype'] === '00'){

            if(!isset($post_data['cardno']) || !$post_data['cardno'])
            {
                return false;
            }

            if($type == 'create'){

                if(!isset($post_data['cardname']) || !$post_data['cardname'])
                {
                    return false;
                }

                if(!isset($post_data['idno']) || !$post_data['idno'])
                {
                    return false;
                }

            }

            if(!isset($post_data['mobileno']) || !$post_data['mobileno'])
            {
                return false;
            }

        }
        elseif ($post_data['acctype'] === '01')
        {
            if($type == 'create'){

                if(!isset($post_data['corpname']) || !$post_data['corpname'])
                {
                    return false;
                }

                if(!isset($post_data['corpcode']) || !$post_data['corpcode'])
                {
                    return false;
                }

            }

            if(!isset($post_data['corpaccno']) || !$post_data['corpaccno'])
            {
                return false;
            }
        }

        $msg = 'Data legal';
        return true;
    }

    /**
     * 开户
     *
     * @return Content
     */
    public function create()
    {

        return Admin::content(function (Content $content) {

            $content->header('开户');
            $content->description('业务说明：客户在商户平台注册账号后，由商户平台发起开户请求，账户平台核验信息，并将客户开户信息同步到第三方云数据平台。');

            $content->body(view('admin/account/create'));

        });

    }

    /**
     * 保存
     * @param Request $request
     * @return json
     */
    public function save(Request $request)
    {

        $return = [
            'status'=>'fail',
            'msg'=>'Error'
        ];

        if($request->isMethod('post'))
        {
            $post_data = $request->post();

            $ver_res = $this->verify($post_data,'create',$msg);
            if(!$ver_res){
                $return['msg'] = $msg;
                return response()->json($return);
            }

            //拼装请求报文
            $api_data = [
                'custno'=>$post_data['custno'],
                'acctype'=>$post_data['acctype'],
                'accbank'=>$post_data['accbank'],
                'cardno'=>$post_data['cardno'],
                'cardname'=>$post_data['cardname'],
                'idno'=>$post_data['idno'],
                'mobileno'=>$post_data['mobileno'],
                'corpname'=>$post_data['corpname'],
                'corpcode'=>$post_data['corpcode'],
                'corpaccno'=>$post_data['corpaccno']
            ];

            $request = new AccUtil();
            $resp = $request->acc_api($api_data,'OPEN_ACC',$resp_msg);
            if($resp){
                //TODO
            }else{
                $return['msg'] = $resp_msg;
                return response()->json($return);
            }

        }

        return response()->json($return);
    }

    /**
     * 账户变更
     *
     * @return Content
     */
    public function modify()
    {

        return Admin::content(function (Content $content) {

            $content->header('账户变更');
            $content->description('业务说明：账户变更');

            $content->body(view('admin/account/modify'));

        });

    }
    /**
     * 调修改api
     * @param Request $request
     * @return json
     */
    public function do_modify(Request $request)
    {

        $return = [
            'status'=>'fail',
            'msg'=>'Error'
        ];

        if($request->isMethod('post'))
        {
            $post_data = $request->post();

            $ver_res = $this->verify($post_data,'modify',$msg);
            if(!$ver_res){
                $return['msg'] = $msg;
                return response()->json($return);
            }

            //拼装请求报文
            $api_data = [
                'accountno'=>$post_data['accountno'],
                'acctype'=>$post_data['acctype'],
                'accbank'=>$post_data['accbank'],
                'cardno'=>$post_data['cardno'],
                'mobileno'=>$post_data['mobileno'],
                'corpaccno'=>$post_data['corpaccno']
            ];

            $request = new AccUtil();
            $resp = $request->acc_api($api_data,'ACC_MODIFY',$resp_msg);
            if($resp){
                //TODO
            }else{
                $return['msg'] = $resp_msg;
                return response()->json($return);
            }

        }

        return response()->json($return);
    }

    /**
     * 账户查询
     *
     * @return Content
     */
    public function query()
    {

        return Admin::content(function (Content $content) {

            $content->header('账户查询');
            $content->description('业务说明：账户查询');

            $content->body(view('admin/account/query'));

        });

    }

    /**
     * 调查询api
     * @param Request $request
     * @return json
     */
    public function do_query(Request $request)
    {

        $return = [
            'status'=>'fail',
            'msg'=>'Error'
        ];

        if($request->isMethod('post'))
        {
            $post_data = $request->post();

            if(!isset($post_data['accountno']) || !$post_data['accountno']){
                $return['msg'] = 'Data illegal';
                return response()->json($return);
            }

            //拼装请求报文
            $api_data = [
                'accountno'=>$post_data['accountno']
            ];

            $request = new AccUtil();
            $resp = $request->acc_api($api_data,'ACC_QUERY',$resp_msg);
            if($resp){
                //TODO
            }else{
                $return['msg'] = $resp_msg;
                return response()->json($return);
            }


        }

        return response()->json($return);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Administrator::form(function (Form $form) {

            //工具按钮
            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();
                // 去掉跳转列表按钮
                $tools->disableListButton();
            });

            $form->text('custno', '客户号')->rules('required');
            $form->radio('acctype', '账户类型')->options(['00' => '对私', '01'=> '对公'])->default('00');
            $form->text('accbank', '开户银行')->rules('required');

            $form->text('cardno', '银行卡号')->rules('required');
            $form->text('cardname', '持卡人姓名')->rules('required');
            $form->text('idno', '身份证号码')->rules('required');
            $form->mobile('mobileno','手机号')->rules('required')->options(['mask' => '99999999999']);

            $form->text('corpname', '企业名称')->rules('required');
            $form->text('corpcode', '企业统一信用代码')->rules('required');
            $form->text('corpaccno', '企业银行账号')->rules('required');


        });
    }
}
