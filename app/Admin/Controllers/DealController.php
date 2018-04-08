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

class DealController extends Controller
{
    use ModelForm;

    /**
     * 余额查询
     *
     * @return Content
     */
    public function balance()
    {

        return Admin::content(function (Content $content) {

            $content->header('余额查询');
            $content->description('业务说明：余额查询');

            $content->body(view('admin/deal/balance'));

        });

    }

    /**
     * 调余额查询api
     * @param Request $request
     * @return json
     */
    public function show_balance(Request $request)
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
            $resp = $request->acc_api($api_data,'BALANCE',$resp_msg);
            if($resp){
                //TODO
            }else{
                $return['msg'] = $resp_msg;
                return response()->json($return);
            }


        }

        return response()->json($return);
    }

}
