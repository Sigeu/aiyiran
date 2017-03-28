<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CommentController.php
 *
 * 评论类————前台
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   CommentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class CommentController extends HomeController {
    public $is_login; //是否登录
    public  $CommentModel;
    public function init()
    {
        include "/vendor/WxPayPubHelper/WxPayPubHelper.php";
        
        $this->CommentModel = D('Comment','comment');
        parent::init();
        error_reporting(E_ALL & ~E_NOTICE);

        //检测是否登录
        $this->is_login = M('Member')->field('id')->where(array('username'=>Session::get('username')))->getOne();
        if($this->is_login==false){
             $this->is_login = M('Member')->field('id')->where(array('email'=>Session::get('username')))
                                    ->getOne();
             if($this->is_login==false){
                 $this->showMessage("您还未登录请先登录", '/', 3);die;
             }
        }
    }


    /*添加评论*/
    public function addAction()
    {
        /*1:检查敏感词；确定是否可以提交表单 */
        $uid = M('Member')->field('id')->where(array('username'=>Session::get('username')))->getOne();
        $flag = $this->CommentModel->isSubmit(Controller::post('comment_content'));
        $comment = array(
            'comment_infoid'=>Controller::post('comment_infoid'),
            'comment_modelid'=>Controller::post('comment_modelid'),
            'comment_userid'=>$uid['id'],
            'comment_content'=>Controller::post('comment_content'),
            'comment_status'=>3,
            'comment_time'=>time()
        );
        if($flag === true)
        {
            $ok = $this->CommentModel->create($comment);
            if($ok) referrer();
            else goback('评论失败');
        }
        else
        {
            goback($flag.'为敏感词，评论失败');
        }

    }

    //星空许愿添加
    public function addwishAction()
    {
        //是否登录
        $uid = $_SESSION['front_login_info']['id'];
        if($uid == false){
            echo json_encode(array('status'=>2,'msg'=>'请登录'));exit();
        }
        //获取用户名
        $username = M('member')->field('username')->where(array('id'=>$uid))->getOne();
        if($username['username']==false){
            $username['username'] = M('member')->field('email')->where(array('id'=>$uid))->getOne();
        }

         $flag = $this->CommentModel->isSubmit(Controller::post('comment_content'));
         $comment = array(
            'title'=>Controller::post('comment_title'),
            'content'=>Controller::post('comment_content'),
            'is_open' => Controller::post('is_open'),
            'username'=>$username['username'],
            'addtime'=>time(),
            'userPhoto'=>$_SESSION['front_login_info']['user_photo']
        );
         if(empty($comment['title'])){
             echo json_encode(array('status'=>2,'msg'=>'标题不能为空'));exit();
         }
         if(empty($comment['content'])){
            echo json_encode(array('status'=>2,'msg'=>'内容不能为空'));exit();
         }

         if($flag === true)
        {
            $ok = M('wish')->create($comment);
//            if($ok) referrer();
//            else goback('评论失败');
             if($ok){
                 $content = array();
                 $addtime  = M('wish')->field('addtime')->where(array('id'=>$ok))->getOne();
                 $content['addtime'] = date("Y/m/d H:i", $addtime['addtime']);
                 $content['title']    = $comment['title'];
                 $content['content']  = $comment['content'];
                 $content['username'] = $comment['username'];
                 $content['is_open']  = $comment['is_open'];
                 echo json_encode(array('status'=>1,'msg'=>'许愿成功','data'=>$content));exit();

             }else{
                 echo json_encode(array('status'=>2,'msg'=>'许愿失败'));exit();
             }
        }
        else
        {
            goback($flag.'为敏感词，评论失败');
        }
    }

    //回复留言
    public function ajaxwishAction()
    {
        if(isAjax()){
            if(!$_SESSION['front_login_info']['id']){
                echo json_encode(array('status'=>2,'msg'=>'请登录后重试'));exit();
            }
            //获取用户名 star
            $uid = $_SESSION['front_login_info']['id'];
            $users = M('member')->where(array('id'=>$uid))->getOne();
            $data = array();
            if($users['username']){
                $data['username'] = $users['username'];
            }else{
                $data['username'] = $users['email'];
            }
            //获取用户名 end
            
            $data['title'] = Controller::post('title');
            $data['content'] = Controller::post('content');
            $data['time'] = time();
            $data['pid'] = Controller::post('pid');
            $data['is_message'] = 1; //文章留言
            $data['aid'] = Controller::post('aid');
    

            $result = M('wish')->create($data);
            if($result){
                echo json_encode(array('status'=>1,'msg'=>'发布成功'));exit();
            }else{
                echo json_encode(array('status'=>2,'msg'=>'发布失败'));exit();
            }
        }else{
            return null;
        }
        
    }

    //文章留言
    public function detailAction()
    {
        if(!$_SESSION['front_login_info']['id']){
            echo json_encode(array('status'=>2,'msg'=>'请登录后重试'));exit();
        }
         $uid = M('Member')->field('id')->where(array('id'=>$_SESSION['front_login_info']['id']))->getOne();
         if($uid==false){
            echo json_encode(array('status'=>2,'msg'=>'请登录后重试'));exit();
         }
        $_token = Controller::post('_token');
        //令牌验证
       if($_token != $_SESSION['_token']){
           echo json_encode(array('status'=>2,'msg'=>'表单只能提交一次，不能重复提交！'));exit();
       }
        $_SESSION['_token'] = array();

        $flag = $this->CommentModel->isSubmit(Controller::post('comment_content'));
        $comment = array(
            'title'=>Controller::post('title'),
            'content'=>Controller::post('comment_content'),
            'username'=>Session::get('username'),
            'aid'=>Controller::post('aid'), //文章id
            'is_message'=>1,
            'addtime'=>time()
        );
        if(empty($comment['title'])){
            echo json_encode(array('status'=>2,'msg'=>'标题不能为空'));exit();
        }
        if(empty($comment['content'])){
            echo json_encode(array('status'=>2,'msg'=>'内容不能为空'));exit();
        }

        if($flag === true)
        {
            $ok = M('wish')->create($comment);
//            if($ok) referrer();
//            else goback('评论失败');
            if($ok){
                $content = array();
                $addtime  = M('wish')->field('addtime')->where(array('id'=>$ok))->getOne();
                $content['addtime'] = date("Y/m/d H:i", $addtime['addtime']);
                $content['content']  = $comment['content'];
                $content['username'] = $comment['username'];
                echo json_encode(array('status'=>1,'msg'=>'留言成功','data'=>$content));exit();
            }else{
                echo json_encode(array('status'=>2,'msg'=>'留言失败'));exit();
            }
        }
        else
        {
            goback($flag.'为敏感词，评论失败');
        }
    }

    public function pay1Action()
    {
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();
        //设置统一支付接口参数
        //设置必填参数
        $unifiedOrder->setParameter("body","图有利充值");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = 'wx0673e06ca2aa08e9'."$timeStamp";
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
        $unifiedOrder->setParameter("total_fee","1");//总金额
        $unifiedOrder->setParameter("notify_url", 'http://caohongda.var365.cn/index.php/comment/Comment/notify');//通知地址 
        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型

        $unifiedOrderResult = $unifiedOrder->getResult();
//         var_dump($unifiedOrder);
        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL") 
        {
            //商户自行增加处理流程
            echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
        }
        elseif($unifiedOrderResult["result_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
            echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
        }
        elseif($unifiedOrderResult["code_url"] != NULL)
        {
            //从统一支付接口获取到code_url
            $code_url = $unifiedOrderResult["code_url"];
            //商户自行增加处理流程
            //......
        }
        include $this->display('pay1.html');
        
    }
    //查询订单
    public function orderQueryAction()
    {  
        //退款的订单号
    	if (!isset($_POST["out_trade_no"]))
    	{
    		$out_trade_no = " ";
    	}else{
    	    $out_trade_no = $_POST["out_trade_no"];
    		//使用订单查询接口
    		$orderQuery = new OrderQuery_pub();
    		//设置必填参数
    		//appid已填,商户无需重复填写
    		//mch_id已填,商户无需重复填写
    		//noncestr已填,商户无需重复填写
    		//sign已填,商户无需重复填写
    		$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
    		//非必填参数，商户可根据实际情况选填
    		//$orderQuery->setParameter("sub_mch_id","XXXX");//子商户号  
    		//$orderQuery->setParameter("transaction_id","XXXX");//微信订单号
    		
    		//获取订单查询结果
    		$orderQueryResult = $orderQuery->getResult();
    		
    		//商户根据实际情况设置相应的处理流程,此处仅作举例
    		if ($orderQueryResult["return_code"] == "FAIL") {
    			$this->error($out_trade_no);
    		}
    		elseif($orderQueryResult["result_code"] == "FAIL"){
//     			$this->ajaxReturn('','支付失败！',0);
    			$this->error($out_trade_no);
    		}
    		else{
    		     $i=$_SESSION['i'];
    		     $i--;
    		     $_SESSION['i'] = $i;
    		      //判断交易状态
    		      switch ($orderQueryResult["trade_state"])
    		      {
    		          case SUCCESS: 
                          echo json_encode(array('data'=>'支付成功', 'status'=>1));exit();
    		              break;
    		          case REFUND:
                          echo json_encode(array('data'=>'超时关闭订单2：','status'=>2));exit();    		              
    		              break;
    		          case NOTPAY:
    		            //   $this->error("超时关闭订单：".$i);
                          echo json_encode(array('data'=>'超时关闭订单1：'.$i));exit();
//     		              $this->ajaxReturn($orderQueryResult["trade_state"], "支付成功", 1);
    		              break;
    		          case CLOSED:
    		              echo json_encode(array('data'=>'超时关闭订单1：'.$i));exit();
    		              break;
    		          case PAYERROR:
    		            //   $this->error("支付失败".$orderQueryResult["trade_state"]);
                          echo json_encode(array('data'=>'支付失败'.$orderQueryResult["trade_state"]));exit();
    		              break;
    		          default:
                          echo json_encode(array('data'=>'未知失败'.$orderQueryResult["trade_state"]));exit();
    		              break;
    		      }
    		     }	
    	}
    }
    public function notifyAction()
    {
        //使用通用通知接口
        $notify = new Notify_pub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
//          var_dump($xml);
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($xml == ''){
		  exit('您没有权限操作');
		}
		if(!$xml){
		   exit('您没有权限操作');	
		}
		$result = $this->responseFormate($xml);
	    return $result;
            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }


    }
























