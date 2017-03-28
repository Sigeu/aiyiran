<?php
include "duanxin/TopSdk.php";
/**
 * @author wake1
 */
class Dayu{
     public static function authSms($mobile, $username, $code) {


        self::alidayuConfig($mobile, $username, $code);
    }

    private static function alidayuConfig($mobile, $username, $code) {
        include ('duanxin/top/TopClient.php');
        include ('duanxin/top/request/AlibabaAliqinFcSmsNumSendRequest.php');
        include ('duanxin/top/ResultSet.php');
        include ('duanxin/top/RequestCheckUtil.php');
        include ('duanxin/top/TopLogger.php');
        $c = new \TopClient;
        $c ->appkey = "23562454" ;
        $c ->secretKey = "80877735beeb0f2a6c6919acd86f5089" ;
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "hellow" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "王老师红烧肉" );
//        $req ->setSmsParam( "{name:".$username.",code:".$code."}" );
        $req ->setSmsParam( "{name:'$username',code:'$code'}" );
        $req ->setRecNum($mobile);
        $req ->setSmsTemplateCode( "SMS_33475534" );
        $resp = $c ->execute( $req );
       // print_r($resp);
    }
}




?>