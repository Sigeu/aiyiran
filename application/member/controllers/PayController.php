<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 陵园管理控制器类
 *
 * @author     月下追魂 <youkaili@mail.b2b.cn>   2016年12月12日18:11:06
 * @filename   CemeteryController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class PayController extends HomeController {

    public $CategoryModel;
    public $person_type;
    public $is_login; //是否登录
    public $nav; //左侧导航
    public $nav_title; //纪念馆左侧大标题

    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        parent::init();
        if(Session::get('username')==false){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }

    }

    public function chongzhiAction()
    {
        $data = array();
        $uid = $_SESSION['front_login_info']['id'];
        if(!$uid){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
        $acer_id = Controller::post('id'); //元宝钱币的主键id
        $acer_info = M('memorial_acer')->where(array('id'=>$acer_id))->getOne(); //获取充值商品信息
        if(!$acer_info){
            echo "<script> alert('充值商品有误，请稍后再试') </script>";die;
        }

        $data['ordersn'] = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); //生成订单
        $data['money'] = $acer_info['money']; //商品价格
        $data['payid'] = 1; //支付类型 及时
        $data['ordertime'] = time(); //订单生成时间
        $data['goods_name'] = $acer_info['acer']; //元宝数量
        $data['userid'] = $uid;
        $data['yuanbao_num'] = $acer_info['acer']; //元宝数量
        $data['product_name'] = $acer_info['product_name']; //产品名称
        $result = M('member_order')->create($data); //创建订单
        if($result){
            echo json_encode(array('msg'=>$data['ordersn']));exit();
        }else{

        }
    

    }

    //跳转支付
    public function goPayAction()
    {
        $ordersn = Controller::get('ordersn');
        if(!$ordersn){
            $this->showMessage("有误", '/', 3);die;
        }
        $info = M('member_order')->where(array('ordersn'=>$ordersn))->getOne();
        if(!$info){
            $this->showMessage("有误", '/', 3);die;
        }
        include(DIR_WEB_ROOT.'vendor/Pay/alipay.class.php');
        $alipay = new alipay($info['money'],$info['ordersn'],$info['goods_name']);
        $code = $alipay->credit_pay();
        // $this->assign('code', $code);
        include $this->display('member/money_view/goPay.html');
    }

    //通知
    public function notifyAction()
    {
        include(DIR_WEB_ROOT.'vendor/Pay/alipay.class.php');
        $ordersn = isset($_REQUEST['out_trade_no']) ? trim($_REQUEST['out_trade_no']) : ''; //支付流水号
        $total_fee = trim($_REQUEST['total_fee']); //支付状态
        $alipay = new alipay($total_fee,$ordersn,'');
        $retuenRes = $alipay->check_notify();
        if(count($retuenRes) == 0){
            echo "fail";
            exit;
        }
           
        if($retuenRes['status'] != 1){
            echo "fail";
            exit;
        }

    }

    //返回
    public function resalAction()
    {
        include(DIR_WEB_ROOT.'vendor/Pay/alipay.class.php');
        $ordersn = isset($_REQUEST['out_trade_no']) ? trim($_REQUEST['out_trade_no']) : ''; //支付流水号
        $total_fee = trim($_REQUEST['total_fee']); //支付状态
        $alipay = new alipay($total_fee,$ordersn,'');
        $retuenRes = $alipay->check_notify(); 
        if(count($retuenRes) == 0){
            $this->showMessage("有误", '/', 3);die;
         }  

         //支付成功
        if($retuenRes['status']==1){
            $info = M('member_order')->where(array('ordersn'=>$ordersn))->getOne();
            if($info['status']==1 && $info['money']==$retuenRes['total_fee']){
                $result = M('member_order')->update(array('ordersn'=>$ordersn), array('status'=>2,'paytime'=>time(),'trade_no'=>$retuenRes['trade_no']));
                $sql = "UPDATE `mo_member` SET point=point+{$info['yuanbao_num']} WHERE id={$info['uid']}";
                mysql_query($sql);

                // 操作账户流水表
                $data = array(
                    'username'=>$order['userid'], //用户id
                    'point'=>$order['money'],     //订单的元宝数量
                    'addtime'=>time(), //操作时间
                    'pay_type'=>1, //在线充值
                );
                M('member_water')->create($data);
                if($sql){
                    echo "支付成功..";die;
                }
            }
        }
    }

    

}