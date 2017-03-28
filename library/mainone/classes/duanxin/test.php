<?php
include "TopSdk.php";

$c = new TopClient;
$c ->appkey = "23562454" ;
$c ->secretKey = "80877735beeb0f2a6c6919acd86f5089" ;
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req ->setExtend( "hellow" );
$req ->setSmsType( "normal" );
$req ->setSmsFreeSignName( "王老师红烧肉" );
$req ->setSmsParam( "{name:'王先生',code:'1231542315135'}" );
$req ->setRecNum( "18232496759" );
$req ->setSmsTemplateCode( "SMS_33475534" );
$resp = $c ->execute( $req );
if($resp){
    echo "发送成功";
}else{
    echo "发送失败";
}