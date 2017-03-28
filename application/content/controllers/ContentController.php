<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentController.php
 *
 * 内容详细页————前台
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   ContentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class ContentController extends HomeController {

    public  $ContentModel;
    public $url;
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->ContentModel = D('Content');
        $this->url = "/category/Category/index/cid/321";
        parent::init();
    }
    /**
     * 内容页首页
     */
    public function indexAction()
    {
        $id = Controller::get('id'); //当前内容ID
        $model = $this->ContentModel->getModelId($id);//当前内容模型ID
        $content = $this->ContentModel->getContent(array('id'=>$id),$model);//获取内容信息

        //更新点击次数
        update_click('visittime_', $id, 'maintable', 'click', '3600');



        $content = $content[0];
        $cid = $content['categoryid']; //当前栏目ID
        $CatInfo = cid2Info($cid);//都拿过去栏目信息
        //获取上一篇，下一篇内容信息
        $seo = get_metainfo_content($id);
        $preContent = $this->ContentModel->getContent(array('id'=>$id,'cid'=>$cid),$model,'<');
        $nextContent = $this->ContentModel->getContent(array('id'=>$id,'cid'=>$cid),$model,'>');
        if(!empty($preContent))
        {
            $preContentUrl = getArticleUrl($preContent[0]['maintable_id'],$CatInfo['filepath'],$preContent[0]['publishopt'],'content/Content/index','content_$id_1.html',$preContent[0]['created']);
            $preContentName = $preContent[0]['title'];
            $preContent = "<a href='$preContentUrl'>".$preContent[0]['title']."</a>";
        }
        else
        {
            $preContentUrl = '#';
            $preContentName = '没有了';
            unset($preContent);//删除空数组
            $preContent = '没有了';
        }
        if(!empty($nextContent))
        {
            $nextContentUrl = getArticleUrl($nextContent[0]['maintable_id'],$CatInfo['filepath'],$nextContent[0]['publishopt'],'content/Content/index','content_$id_1.html',$nextContent[0]['created']);
            $nextContentName = $nextContent[0]['title'];
            $nextContent = "<a href='$nextContentUrl'>".$nextContent[0]['title']."</a>";
        }
        else
        {
            $nextContentUrl = '#';
            $nextContentName = '没有了';
            unset($nextContent);//删除空数组
            $nextContent ='没有了';
        }

        //以上上一篇，下一篇（完）
        $pid = getPid($cid); //当前内容也顶级栏目ID，用于导航页面的选中
        //判断网站设置是不是自动分页的
        $pageConfig = get_mo_config('mo_arcautosp');
        $pageurl = '';//内容分页连接
        $nextpageurl = '#';//上一页
        $prepageurl = '#';//下一页
        $contentInput = new ContentInput(1, $cid);
        $content = $contentInput->get($content);
        //替换文章关键词
        $content['content'] = $this-> getTagsModel() ->formateTages($content['content'],$cid);

        //查询Tag标签关键词
        $content['keywords'] = $this-> getTagsModel()->GetTagname($id,$model,$cid,$pid);
        
        //获取点击次数
        $click= M('maintable')->field('click')->where(array('id'=>$id))->getOne();
        
        if($pageConfig == 'Y')//开启文章自动分页
        {
            $pageNum = get_mo_config('mo_arcautosp_sum');//多少个字符分一页
            $contentpage = new ContentPage();
            $cpage = intval(Controller::get('cpage',1));//当前页，默认第一页

            $mycontent = $contentpage->get_data($content['content'], $pageNum);
            if(strpos($mycontent,'[page]'))
            {
                $mycontents = array_filter(explode('[page]',$mycontent));
                $countnum = count($mycontents);
                $pageurl = getContentPageUrl($id,$countnum,$content['publishopt'],$CatInfo['filepath'],'content/Content/index/cpage/$cpage','content_$id_$cpage.html',0,$content['created']);

                $nextpage = intval($cpage+1) <= $countnum ? intval($cpage+1) : $countnum;//上一页
                $prepage = intval($cpage-1) < 1 ? 1 : intval($cpage-1); //下一页

                $nextpageurl = getContentPageUrl($id,$countnum,$content['publishopt'],$CatInfo['filepath'],'content/Content/index/cpage/$cpage','content_$id_$cpage.html',$nextpage,$content['created']);

                $prepageurl = getContentPageUrl($id,$countnum,$content['publishopt'],$CatInfo['filepath'],'content/Content/index/cpage/$cpage','content_$id_$cpage.html',$prepage,$content['created']);
                $nextpageurl = $nextpageurl[0];//下一页连接
                $prepageurl = $prepageurl[0];//上一页连接
                $content['content'] = $mycontents[$cpage-1];
            }
        }

        //当前内容模板:先获取本身的，在获取栏目的
        $template = $content['template'] ? $content['template'] : D('Category','category')->getTemplage($content['categoryid'],'contenttpl');

        //浏览权限：得到的是角色ID
        $perArr = $content['readpower'];

        //判断浏览权限，并更新文章点击量
        $username = Session::get('username');
        $groupid = M('member')->field('groupid')->where(array('username'=>$username))->getOne();
        $roleid = !empty($groupid) ?  $groupid['groupid'] : '' ;
        //栏目浏览权限:1：可以浏览，2代表允许评论
        $has_cat_pre = $this->ContentModel->getMemberCatePerModel($cid,$roleid,1);//当前栏目的权限
        //判断是否需要更新点击量
        $up_click = isset($_GET['up_click']) ? (int)($_GET['up_click']) : 1;
        //这部分权限和栏目的权限控制很乱，有问题在改
        if(@$_SESSION['roleid'] && Controller::get('isadmin'))  //后台管理员没有权限
        {
           /*if (!empty($up_click)) {
            $this->ContentModel->updateHits($id);//更新点击量
           }*/
        }
        else if(empty($perArr) && !$has_cat_pre)
        {
           if (!empty($up_click)) {
               $this->ContentModel->updateHits($id);//更新点击量
           }
        }
        elseif($has_cat_pre||in_array($roleid,$perArr))
        {
           if (!empty($up_click)) {
               $this->ContentModel->updateHits($id);//更新点击量
           }
        }
        else
        {
            goback("没有权限",true);
        }
        //$comment = $this->ContentModel->getComment(array('artid'=>$id,'status'=>1));//当前文章的相关评论
        //留言token令牌
        $_token = md5(microtime()+rand(1,10000));
        $_SESSION['_token'] = $_token;
        
        $messageList = $this->getMessage($id);
        include $this->display($template);

    }
    
    //获取文章留言列表
    public function getMessage($id)
    {
        include_once DIR_BF_ROOT."classes/Mypage.php";
        $condition = array('aid'=>$id, 'status'=>1);
        $nums = M('wish')->findCount($condition);
        $page = new Page($nums,10,6);
        $limit = $page->limit();
        $showPage = $page->show(2);
        $lists = M('wish')->where($condition)->order('id desc')->limit($limit)->select();
        $lists = $this->tree($lists);
        $me = array();
        $me['showPage'] = $showPage;
        $me['lists'] = $lists;
        return $me;
    }
    
    //递归遍历我的子回复留言
    public static function tree($array,$child="child", $pid = 0)
    {
        $temp = array();
        foreach ($array as $v) {
            if ($v['pid'] == $pid) {
                $v[$child] = self::tree($array,$child,$v['id']);
                $temp[] = $v;
            }
        }
        return $temp;
    }

    /**
     * 获取文章内容标签替换服务类
     */
    function getTagsModel ()
    {
        return D('getTagsReplaceModel','tags');
    }

    // 陵园首页
    function cemeteryAction()
    {
        $isNav = 1;
        $id = Controller::get('id');
        if($id){
            $condtion = array(
                'id'=>$id
            );
            $content = M('memorial_cemetery2')->where($condtion)->getOne();
            if(!is_array($content)){
                $this->showMessage("参数错误", $this->url, 3);die;
            }
            $lbt = M('memorial_cemetery2_photo')->where(array('pid'=>$content['id']))->select();
            $title = $content['title'];
        }else{
                $this->showMessage("参数错误", $this->url, 3);die;
        }
        
        //陵园名人纪念馆所属数据
        $HallMan = $this->HallMan($id);

        include $this->display('cemetery/cemetery.html');
    }
    
    public function HallMan($id)
    {
        $condition = array('m.status'=>1, 'm.isshow'=>1,'m.cid'=>$id);
        $result = M('memorial')->field('m.id AS mid, m.name, m.userpic, u.brithdate, u.dieddate, u.descript')
                ->join("AS m LEFT JOIN `mo_memorial_cemetery2` 
                    AS c ON m.cid = c.id LEFT JOIN `mo_memorial_userinfo` AS u ON u.mid = m.id")
                ->where($condition)->limit(5)->select();
        foreach ($result as $k=>$v){
            if($v['userpic']){
                if($v['userpic']==""){
                    $result[$k]['userpic']="/template/default/member/images/default_max.png";
                }
            }
        }
        return $result;
    }
    // 关于陵园
    function aboutCemAction()
    {
        $isNav = 2;
        $id = Controller::get('id');
        $info = Controller::get('info');
          if($id && $info){
            $condtion = array(
                'id'=>$id
            );
                $content = M('memorial_cemetery2')->field('title, id')->where($condtion)->getOne();
                if(!is_array($content)) {
                    $this->showMessage("参数错误", $this->url, 3);die;
                }
            if($info==1){
                $description = M('memoriald_cemetery_culture')->field('summary')->where($condtion)->getOne();
                $summary = htmlspecialchars_decode($description['summary']);
            }else if($info==2){
                $description = M('memoriald_cemetery_culture')->field('honor')->where($condtion)->getOne();
                $summary = htmlspecialchars_decode($description['honor']);
            }else if($info==3){
                $description = M('memoriald_cemetery_culture')->field('culture')->where($condtion)->getOne();
                $summary = htmlspecialchars_decode($description['culture']);
            }else{
                $this->showMessage("参数错误", $this->url, 3);die;
            }
        }else{
            $this->showMessage("参数错误", $this->url, 3);die;
        }
        include $this->display('cemetery/about.html');
    }

    // 陵园景观
    public function scenryAction()
    {
        $isNav = 3;

        $id = Controller::get('id');
        if($id){
             $condtion = array(
                'id'=>$id
            );
            $content = M('memorial_cemetery2')->field('title, id')->where($condtion)->getOne();
            // $pohots = M('memorial_cemetery2_photo')->where(array('pid'=>$content['id']))->select();

            $condtion = array('pid'=>$content['id']);
            $nums = M('memorial_cemetery2_photo')->findCount($condtion);
            include_once DIR_BF_ROOT."classes/Mypage.php";
            $page = new Page($nums,20,6);
            $limit = $page->limit();
            $showPage = $page->show(2);
            $pohots = M('memorial_cemetery2_photo')->where($condtion)->limit($limit)->select();

            if(!is_array($content)){
                $this->showMessage("参数错误", $this->url, 3);die;
            }
        }else{
            $this->showMessage("参数错误", $this->url, 3);die;
        }
        include $this->display('cemetery/scenry.html');
    }

    //陵园服务
    public function serverAction()
    {
        $isNav = 4;

        $id = Controller::get('id');
        if($id){
             $condtion = array(
                'id'=>$id
            );
            $content = M('memorial_cemetery2')->field('title, id')->where($condtion)->getOne();
            $description = M('memoriald_cemetery_culture')->field('server')->where($condtion)->getOne();
            if(!is_array($content)){
                $this->showMessage("参数错误", $this->url, 3);die;
            }
            if(!is_array($description)){
                $this->showMessage("参数错误", $this->url, 3);die;
            }
            $summary = htmlspecialchars_decode($description['server']);
        }else{
            $this->showMessage("参数错误", $this->url, 3);die;
        }
        include $this->display('cemetery/server.html');
    }

    //地理位置
    public function mapAction()
    {
        $isNav = 5;

         $id = Controller::get('id');
        if($id){
             $condtion = array(
                'id'=>$id
            );
            $content = M('memorial_cemetery2')->where($condtion)->getOne();
            if(!is_array($content)){
                $this->showMessage("参数错误", $this->url, 3);die;
            }
        }else{
            $this->showMessage("参数错误", $this->url, 3);die;
        }
        include $this->display('cemetery/map.html');
    }

     //资讯
    public function informationAction()
    {
        $isNav = 6;

         $id = Controller::get('id');
         $info = Controller::get('info');
         $field = "0,1,2";
         // var_dump(strpos($field, $info));
        if($id && $info){
            if(strpos($field, $info) != false){
                 $condtion = array(
                    'id'=>$id
                );
                $content = M('memorial_cemetery2')->field('title, id')->where($condtion)->getOne();
                if(!is_array($content)){
                    $this->showMessage("参数错误", $this->url, 3);die;
                }
            }else{
                $this->showMessage("参数错误", $this->url, 3);die;
            }
        }else{
            $this->showMessage("参数错误", $this->url, 3);die;
        }


        include $this->display('cemetery/info.html');
    }


    public function getUrl()
    {
        $request_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];

        if(strpos($request_url,'?')){
            $url  =  $request_url;
            return $url;
        }else{
            $url  =  $request_url.'?';
            return $url;
        }

        if(!isset($parse['query']))
            $parse['query'] = '';

        if(isset($parse['query']))
        {
            parse_str($parse['query'],$params);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }

        return  $url;
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
