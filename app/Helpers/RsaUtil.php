<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/4/3
 * Time: 15:48
 */

namespace App\Helpers;


class RsaUtil
{
    public static function sign($sign_str){
        //读取私钥文件
        $priKey = file_get_contents(base_path(env('BUSINESS_PRI_KEY')));
        $res = openssl_get_privatekey($priKey);
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($sign_str, $sign, $res);
        //释放资源
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    public static function verify($sign_str,$sign){
        //读取公钥文件
        $pubKey = file_get_contents(base_path(env('BUSINESS_PUB_KEY')));
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        //签名串
        $result = (bool)openssl_verify($sign_str, base64_decode($sign), $res);
        //释放资源
        openssl_free_key($res);
        //返回资源是否成功
        return $result;
    }

    public static function encrypt($str){
        //读取公钥文件
        $pubkey = openssl_pkey_get_public(file_get_contents(base_path(env('BUSINESS_PUB_KEY')))); //公钥

        // 公钥加密
        $encrypt_data = '';
        openssl_public_encrypt($str, $encrypt_data, $pubkey);
        $encrypt_data = base64_encode($encrypt_data);
        return $encrypt_data;
    }

}