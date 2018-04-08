<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/4/3
 * Time: 16:04
 */

namespace App\Helpers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AccUtil
{
    protected $base_params=[];
    protected $appid;
    protected $key;

    public function __construct()
    {
        $this->base_params['VERSION'] = env('BUSINESS_API_PARAM_VERSION');
        $this->base_params['INSTICODE'] = env('BUSINESS_API_PARAM_INSTICODE');
        $this->appid = env('BUSINESS_API_APPID');
    }

    protected function create_key($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $key = '';
        for ($i=0;$i<$length;$i++)
        {
            $key .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $key;
    }

    protected function data_format($body_data=[],$trxtype='OPEN_ACC'){

        $this->key = $this->create_key(16);
        $trcno = $this->create_key(32);

        $data_str = base64_encode($this->appid).'|'.RsaUtil::encrypt($this->key);

        $upper_data = [
            'VERSION' => env('BUSINESS_API_PARAM_VERSION'),
            'INSTICODE' => env('BUSINESS_API_PARAM_INSTICODE'),
            'REQTIME' => date('YmdHis',time()),
            'TRXTYPE' => $trxtype,
            'TRCNO' => $trcno
        ];
        foreach ($body_data as $body_key => $body_value){
            $upper_key = strtoupper($body_key);
            $upper_data['data'][$upper_key] = $body_value;
        }
        $upper_data['data']['ADDIDATA'] = '';
        $upper_data['data']['RESERVED'] = '';

        $data_str .= '|'.AesUtil::encrypt(json_encode($upper_data)).'|'.RsaUtil::sign(json_encode($upper_data)).'|'.$trcno;
        return $data_str;
    }

    public function acc_api($body_data=[],$trans_type,&$msg){

        $body = $this->data_format($body_data,$trans_type);

        LogUtil::getLogger('acc_api')->info('[req_body]:'.$body);

        try
        {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => env('BUSINESS_API_BASE_URL'),
                // You can set any number of default request options.
                'timeout'  => 2.0,
            ]);

            $r = $client->request('POST', $trans_type, [
                'body' => $body
            ]);

            LogUtil::getLogger('acc_api')->info('[resp_success]:'.print_r($r->getBody()->getContents(),true));

            return $r->getBody()->getContents();

        }
        catch (RequestException  $e)
        {
            $msg = $e->getMessage();

            LogUtil::getLogger('acc_api')->info('[resp_error]:'.$msg);

            /*//
            if ($e->hasResponse()) {
                $msg = $e->getResponse()->getStatusCode();
            }
            //*/
            return false;
        }

    }

}