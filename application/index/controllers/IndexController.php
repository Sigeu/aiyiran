<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * IndexController.php
 *
 * 前台首页
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class IndexController extends HomeController
{
	public function init()
	{
        error_reporting(E_ALL & ~E_NOTICE);
		parent::init();
	}

	/**
	 * 网站前台首页
	 * @param
	 * @return
	 */
	public function indexAction()
	{
        /*判断是否跳转需要跳转到手机版*/
        //手机站是否开通
        if (isset($GLOBALS['is_mobile_open']) && !empty($GLOBALS['is_mobile_open'])) {
            //是否用手机浏览
            if ($GLOBALS['is_mobile_scan']) {
                //用户是否已切换到电脑版
                $edition = isset($_SESSION['webset_edition']) ? $_SESSION['webset_edition'] : 'mobile';
                if (!empty($edition) && $edition == 'mobile') {
                    redirect(URL_HOST . 'mobile', "您在用手机浏览，正在帮您跳转到手机版页面", 1);
                }
            }
        }
		$cid=0;
	    $pid=0;
		$ip = get_client_ip();
		$seo = array
		(
			'title'       =>get_mo_config('mo_title'),
			'keywords'    =>get_mo_config('mo_keywords'),
			'description' =>get_mo_config('mo_description'),
		);

        /**
         * 那年今日
         */

        // #获取今天时间
        // $now = date("m-d",time());
        // #获取今天年份
        // $year = date("Y", time());
        // #获取今天日期
        // // SELECT * FROM `mo_memorial_userinfo` WHERE FROM_UNIXTIME(dieddate, '%m-%d')='11-23';
        // $map = " FROM_UNIXTIME(dieddate, '%m-%d') = '{$now}'
        //         AND FROM_UNIXTIME(dieddate, '%Y') < {$year} ";
        // $result = M('memorial_userinfo')->where($map)->select();

        //引入微博接口
        include DIR_BF_ROOT.'/classes/weibo.php';
        $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
        $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL2 );

        //获取我的纪念馆
        $uid = $_SESSION['front_login_info']['id'];
        if($uid){
            $memorial_lists = M('memorial')->findAll(array('userid'=>$uid), 'id desc','*',2);
        }
        if($memorial_lists){
            foreach ($memorial_lists as $key => $value) {
                if($value['userpic']==""){
                    $memorial_lists[$key]['userpic'] = "/template/default/images/g_07.png";
                }
            }
        }

        /**
         * 在线追思
         */
        $online = M('memorial')->field('id,name,userpic,catid')->limit('5')->select();
        foreach ($online as $key => $value) {
            if($value['userpic']==""){
                $online[$key]['userpic'] = "/template/default/member/images/default_max.png";
            }
        }

		/*热门搜索 【首页搜索框下面的几个链接】*/

		include  $this->display('index.html');
	}

     //回调微博接口
    public function callbackAction()
    {
        include_once( DIR_BF_ROOT.'/classes/libweibo-master/config.php' );
        include_once( DIR_BF_ROOT.'/classes/libweibo-master/saetv2.ex.class.php' );

        $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL2;
            try {
                $token = $o->getAccessToken( 'code', $keys ) ;
                } catch (OAuthException $e) {
            }
        }
        if ($token) {
            $_SESSION['token'] = $token;
            setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );

            $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
            $ms  = $c->home_timeline(); // done
            $uid_get = $c->get_uid();
            $uid = $uid_get['uid'];
            $user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

            //先检测此微博用户是否绑定账号了没有 【如果绑定账号了，吧账号存入session】
            $condition = array(
                'access_token'=>$token['access_token']
                );
            $result = M('member')->where($condition)->getOne();
            if($result){
                // 【微博用户第二次登录】没有绑定账户的状态 【存在token】【is_weibo=2】
                if($result['access_token']!="" && $result['is_weibo']==2){
                    $result['user_photo']=$user_message['profile_image_url'];//覆盖头像url
                    Session::set('front_login_info',$result); //存入session
                    Session::set('username',$user_message['screen_name']); //微博用户名存入session
                    $this->showMessage("登录成功，使用微博登录", '/member/Index/index', 3);die;


                    //【微博用户绑定了账号来使用微博登录】 【is_weibo=1】
                }else if($result['access_token']!="" && $result['is_weibo']==1){
                    $result['user_photo']=$user_message['profile_image_url'];//覆盖头像url
                    Session::set('front_login_info',$result); //存入session
                    if($result['username']){
                        Session::set('username',$result['username']);
                    }else{
                        Session::set('username',$result['email']);
                    }
                    $this->showMessage("登录成功，使用绑定账号的微博登录", '/member/Index/index', 3);die;
                }else{
                    $this->showMessage("登录错误", '/', 3);die;
                }
            }else{
                // p($user_message);die;
                //此微博用户没有绑定账号，把微博账号存入数据库 【微博用户第一次登录】
                $UserData = array(
                    'groupid'=>24,
                    'email'=>'',
                    'createip'=>$userip,
                    'createtime'=>time(),
                    'access_token'=>$token['access_token'], //秘钥
                    'weibo_uname'=>$user_message['screen_name'], //微博名称
                    'weibo_photo'=>$user_message['profile_image_url'], //微博头像
                    'status'=>1
                );
                    $result = M('member')->create($UserData); //注册登录的微博信息
                    $UserData['user_photo']=$user_message['profile_image_url'];//覆盖头像url
                    Session::set('front_login_info',$UserData); //存入session
                    Session::set('username',$user_message['screen_name']); //微博用户名存入session
                if($result){
                    //【没有绑定账号，就用微博的用户名登录】
                    $this->showMessage("登录成功，使用微博第一次登录", '/member/Index/index', 1);
                    echo '<script>window.close();</script>';
                }else{
                     $this->showMessage("登录失败", '/', 3);die;
                }
            }

        }else{
            echo "授权失败";die;
        }
    }

    /*手机版与电脑版切换*/
    public function changeEditionAction () {
        /*获得切换版本参数*/
        $edition = isset($_GET['ed']) ? $_GET['ed'] : '';

        /*验证参数*/
        if (!empty($edition) && $edition != 'mobile') {
            $edition = '';
        }
        /*若当前为电脑访问*/
        if (empty($GLOBALS['is_mobile_scan'])) {
            $edition = '';
        }

        if (!isset($_SESSION['webset_edition'])) {
            session_start();
        }
        $_SESSION['webset_edition'] = $edition;
        redirect(URL_HOST . $edition, "正在切换，请稍后...", 0);
    }

	function itestAction ()
	{
		include  $this->display('itest.html');
	}

	/**
	 * 动态调 用
	 */
	public function previewAction(){
		$posObj = M("Adposition");
		$typeObj = M("Adtype");
		$advertObj = M("Advert");
		$posid= $_GET['id'];
		$pos = "";
		$tem = "";
		$add = "";
		$flash = 0;
		$object = '';

		$posInfo = $posObj->where(array('id'=>$posid))->field('adtypeid,adsize,pos,fontnum,adpos')->getOne();//广告位设置的id
		$ad = array();
		$time_style = $typeObj->getOne(array('where'=>array('id'=>$posInfo['adtypeid'])));

		if($posid)
		{
			if($time_style['adtime'] == 2){          //广告类型设置为手动设置时按排序取最前一条的广告

				$ad = $advertObj->getOne(array('where'=>array('adpositionid'=>$posid),'order'=>array('sort asc,id desc')));
			}else if($time_style['adtime'] == 1){    //广告类型设置为“按上架时间显示一个"取最后添加的一条广告

				$ad = $advertObj->getOne(array('where'=>array('adpositionid'=>$posid),'order'=>array('id desc')));
			}

			//对宽高，链接的整合
			$tem = explode(',',$posInfo['adsize']);
			$ad['width'] = $tem[0];
			$ad['height'] = $tem[1];
			$ad['pos'] = $posInfo['pos'];

			//对上边距与左边距的操作
			$adpos = explode(",",$posInfo['adpos']);
			$ad['left'] = $adpos[1];
			$ad['up'] = $adpos[0];

			if(!empty($ad)){
				$ad['adimg'] = unserialize(base64_decode($ad['adimg']));

				if (isset($ad['adimg'][0]['img']['filename']) && substr($ad['adimg'][0]['img']['filename'],strrpos($ad['adimg'][0]['img']['filename'],'.')+1) == "swf")
				{

					$flash = 1;

				}
				$object = "<object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$ad['width']."' height='".$ad['height']."'><param name='movie' value='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><!--[if !IE]>--><object type='application/x-shockwave-flash' data='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' width='".$ad['width']."' height='".$ad['height']."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object>";
			}
			if ($time_style['typefilename']=='couplet'){

			    $adimg = $ad['adimg'];

				foreach ($adimg as $ak=>$av) {
					$t = $ak == 0 ? "mainone_ads_dl_left" : "mainone_ads_dl_right" ;
					if (!isset($av['img']['path'])) {

						$av['img']['path'] = "";
					}
					$add .= "<div class='mainone_ads_dl ".$t."'><a href='".$av['link']."' title='".$av['font']."' target='_blank'>";

					if($flash)
					{
						$add .="<object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$ad['width']."' height='".$ad['height']."'><param name='movie' value='/static/uploadfile/advert/".$av['img']['path']."' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><!--[if !IE]>--><object type='application/x-shockwave-flash' data='/static/uploadfile/advert/".$av['img']['path']."' width='".$ad['width']."' height='".$ad['height']."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object>";
					}else{

						$add .= "<img src='/static/uploadfile/advert/".$av['img']['path']."' width='".$ad['width']."' height='".$ad['height']."' />";
					}
					$add .="</a><span class='mainone_ads_dl_closebtn'><img src='/static/advert/images/close_btn.jpg' /></span></div>";


				}

				$tem = $time_style['attribute'] == 1 ? 0 : 1 ;

			}else if ($time_style['typefilename'] == 'change') {

				$adimg = $ad['adimg'];
				$tem = $ad['height'] ? $ad['height'] : 171;
				$add = "<div class='mainone_ads_LBGG' id='mainone_ads_LBGG'><ul id='mainone_ads_picBox' style='top:0px;'>";
				$m ="";
				$t ="";
			    foreach ($adimg as $ak=>$av) {
					$m .= "<li><a href='".$av['link']."'  target='_blank'><img src='/static/uploadfile/advert/".$av['img']['path']."' alt='".$av['font']."' width='".$ad['width']."' height='".$ad['height']."'/></a></li>";
					$num = $ak+1;
					$active = $num ==1 ?"active":'';
					$t .= " <li class='".$active."'>".$num."</li>";
				}
				$add .=$m."</ul><ul id='mainone_ads_liBox'>".$t."</ul></div>";

			}else if ($time_style['typefilename'] == 'adwindow') {
					if ($ad['pos'] == 1) {

						$pos = "left:0;";
					} else if ($ad['pos'] == 2) {

						$pos = "right:0;";
					}
					if($flash){

						$tem = $object;
					}else{
						$tem = "<img src='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' alt='".$ad['adimg'][0]['img']['font']."'width='".$ad['width']."' height='".$ad['height']."'/>";
					}

			}else if ($time_style['typefilename'] == 'turnup') {
					if ($ad['pos'] == 1) {

						$add = "mainone_ads_q_bevel2";
						$pos = "/static/advert/images/bevel2_2.png";
					} else if ($ad['pos'] == 2) {

						$pos ="/static/advert/images/bevel2.png";
					}
					$tem = '';
		    }else if ($time_style['typefilename'] == 'back') {

					$add = HOST_NAME;
					$tem =$flash;
			}else if ($time_style['typefilename'] == 'word') {

					$add = $this->fontStr($ad,$time_style,$posInfo);
					if ($add &&  $time_style['wordeffect'] ==2) {

						$content ="var str1 =\"<link href='[css]/mainone_ads.css' type='text/css' rel='stylesheet' /><link href='[css]/GG.css' type='text/css' rel='stylesheet' /><style type='text/css'>#mainone_ads_WZGG{[width]px;height:[height]px;margin-left:[left]px;margin-top:[up]px;}</style><div id='mainone_ads_WZGG'>".$add."</div>\";document.write(str1);";
					}
					$tem = '';
			}else if ($time_style['typefilename'] == 'fullscreen') {

					$tem = $time_style['closeeffect'];
					$add = '/static/advert/images';
					if($flash){
						if($tem == 2){

							$thisHeight = 100;
							$thisWidth = 100;
						}else if ($tem == 3){

							$thisHeight = 179;
							$thisWidth = 250;
						}else{
							$thisHeight = $ad['height'];
							$thisWidth = $ad['width'];
						}
                       $object = "<object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$ad['width']."' height='".$ad['height']."'><param name='movie' value='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><!--[if !IE]>--><object type='application/x-shockwave-flash' data='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' width='".$thisHeight."' height='".$thisWidth."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='7.0.70.0' /><param name='expressinstall' value='Scripts/expressInstall.swf' /><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object>";
					}else{

						$object = "<img src='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' alt='".$av['font']."'width='".$ad['width']."' height='".$ad['height']."'/>";
					}
			}else if ($time_style['typefilename'] == 'float'){

				    if($flash){

				      $tem = $object;
				    }else{

				      $tem = "<img src='/static/uploadfile/advert/".$ad['adimg'][0]['img']['path']."' alt='".$ad['adimg'][0]['img']['font']."'width='".$ad['width']."' height='".$ad['height']."'/>";
				    }
				      $add="";
			}else{
				$tem = '';
			}

			if(empty($adimg) && !isset($adimg))
			{
			    $adimg = $ad['adimg'][0];
			}
		}

        if (!isset($content)) {

            $content = file_get_contents("static/advert/html/".$time_style['typefilename'].".html");
        }

        $content = str_replace(
        		array('[link]','[font]','[path]','[width]','[height]','[css]','[pos]','[add]','[up]','[left]','[id]','[tem]','[object]'),
        		@array($adimg['link'],$adimg['font'],$adimg['img']['path'],$ad['width'],$ad['height'],"/static/advert/css",$pos,$add,$ad['up'],$ad['left'],$ad['id'],$tem,$object),
        		$content);
	    echo $content;

	}
	/**
	 * 获取广告位id
	 */
	public function getPosId($id) {
		$advertObj = M("Advert");
		$position = $advertObj->where(array('id'=>$id))->field('adpositionid')->getOne();
		return $position['adpositionid'];
	}

	/**
	 * 文字广告调用
	 * @param $ad array  文字信息
	 * @param $time_style array 广告位类型设置
	 * @param $size array  广告位大小
	 * @return $str 文字字符串
	 */
	public function fontStr($ad,$time_style,$size){
		$str="";
		if(!empty($ad['adimg'])){
			if($time_style['typefilename'] == 'word'){
				//根据广告类型不同是否设置轮播效果
				if($time_style['wordeffect'] ==1)
				{

					$num = round($ad['height']/24);  //每块显示多少条
					$block = ceil(count($ad['adimg'])/$num);  //数组个数

					//拼接动态内容的字符串
					for($i=1;$i<=$block;$i++){
						$m = $i-1;
						$str .= "marqueeContent[$m] =\"";
						$start = ($i*$num)-($num-1);

						for($j=$start-1;$j<$i*$num;$j++){
							if(isset($ad['adimg'][$j]['link']))
							{
								$str .= "<a href='".$ad['adimg'][$j]['link']."' target='_blank'>".substr($ad['adimg'][$j]['font'],0,$size['fontnum'])."</a>";
							}
						}
						$str .="\";";
					}

				}else{
					foreach($ad['adimg'] as $fk=>$fv)
					{
						$str .="<a href='".$fv['link']."' target='_blank'>".substr($fv['font'],0,$size['fontnum'])."</a>";
					}
				}
			}
		}
		return $str;
	}

    /**
	 * 二维码动态调用
	 */
	public function qrcodePreviewAction(){
		$position_id = $_GET['id'];
		if ($position_id) {
            $qrcode_obj = M('qrcode');
            $current_time = time();
            $qrcode = $qrcode_obj->where("position_id = $position_id and (time_limit = 0 or (start_time <= $current_time and end_time >= $current_time))")->order('id desc')->getOne();
            if (!$qrcode) {
                return;
            }
            $qrcode['code_image'] = URL_STATIC_UPLOAD . $qrcode['code_image'];
            $qrposition_obj = M('qrposition');
            $qrposition = $qrposition_obj->where("id = $position_id")->getOne();
            $qrcode['width'] = $qrposition['width'];
            if ($qrcode) {
                $content = file_get_contents("static/advert/html/qrcode.html");
                $content = str_replace(
                        array('[link_url]','[code_image]','[width]', '[url]'),
                        @array($qrcode['link_url'],$qrcode['code_image'],$qrcode['width'], URL_HOST . 'admin/extensions/qrcode/upclick/id/' . $qrcode['id']),
                        $content);
            }
            echo $content;
        }
	}

}
