<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/4/3
 * Time: 16:04
 */

namespace App\Helpers;


class AesUtil
{

    //*//
    public static function encrypt($data,$key="",$method='AES-128-ECB')
    {
        if(!$data){
            return false;
        }
        if(!$key){
            $key = env('BUSINESS_AES_KEY');
        }
        return openssl_encrypt($data, $method, $key);
    }

    public static function decrypt($data,$key,$method='AES-128-ECB') {
        if(!$data){
            return false;
        }
        if(!$key){
            $key = env('BUSINESS_AES_KEY');
        }
        return openssl_decrypt($data, $method, $key);
    }
    //*/

}