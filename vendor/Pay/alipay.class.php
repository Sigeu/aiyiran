<?php
class alipay 
{  
  private $ordersn;//订单编号
  private $money;//订单金额 
  private $partner;
  private $key;
  private $goodsname;
  private $webSit;
  private $seller_email;
  //支付订单
  public function __construct($money,$ordersn,$goodsname){
    $this->ordersn = $ordersn;
    $this->money = $money;
    $this->goodsname = $goodsname;
    $this->partner = "2088011017233547";
    $this->key = "5vmzih5axsultivpkpws5aucy20y265q";
    $this->seller_email = "shichangbu@mail.b2b.cn";
    $this->webSit = "http://nginx100.com";
  }	
    
    
  //接受参数组成数组 然后返回url
  public function credit_pay(){
	$args = array(
		'subject' 		=> $this->goodsname,
		'body' 			=> $this->goodsname,
		'partner' 		=> $this->partner,
        'seller_id'     => $this->partner,
		'notify_url'    => $this->webSit.'/member/Pay/notify', //通知
		'return_url' 	=> $this->webSit.'/member/Pay/resal', //回调
		'show_url'		=> $this->webSit,
		'_input_charset'=> 'utf-8',
		'out_trade_no' 	=> $this->ordersn,
		'price' 		=>$this->money,
		'quantity' 		=> 1,
        'seller_email' => $this->seller_email,
		'extend_param'	=> 'isv^dz11',
		'service' => 'create_direct_pay_by_user',
		'payment_type' => '1',
	);
    return $this->trade_returnurl($args);  
  } 
  //支付宝获取支付的url 然后提交
 private function trade_returnurl($args) {
	ksort($args);
	$urlstr = $sign = '';
	foreach($args as $key => $val) {
		$sign .= '&'.$key.'='.$val;
		$urlstr .= $key.'='.urlencode($val).'&';
	}
	$sign = substr($sign, 1);
	$sign = md5($sign.$this->key);
	return '<a class="btn btn-orange3" href="https://www.alipay.com/cooperate/gateway.do?'.$urlstr.'sign='.$sign.'&sign_type=MD5">正在跳转支付......</a><script>window.location.href="https://www.alipay.com/cooperate/gateway.do?'.$urlstr.'sign='.$sign.'&sign_type=MD5";</script>';
 }

 //对返回过来的信息进行验证
 public function check_notify(){
    if(!empty($_POST)) {
		$notify = $_POST;
		$location = FALSE;
	}elseif(!empty($_GET)) {
		$notify = $_GET;
		$location = TRUE;
	}else{
	   return [];
	}	
	unset($notify['foxphp_ok']);
	//检查签名
	ksort($notify);
	ksort($notify);
	if(!array_key_exists('sign',$notify)){
      return [];
	}
	$sign = '';
	foreach($notify as $key => $val) {
	  if($key != 'sign' && $key != 'sign_type') $sign .= "&$key=$val";
	}
	if($notify['sign'] != md5(substr($sign,1).$this->key)) {
	   return [];
	}
	return [
	  'ordersn'=>trim($notify['out_trade_no']), 
	  'trade_no'=>trim($notify['trade_no']),
	  'total_fee'=>trim($notify['total_fee']),
	  'status'=>trim($notify['trade_status']) == 'TRADE_SUCCESS'  ? 1 : 0,
	];
	
 }	
}
