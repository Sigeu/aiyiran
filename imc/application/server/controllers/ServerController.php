<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ServerController.php
 * 
 * IMCenter 单点登录
 * 
 * @author    佟新华<tongxinhua@mail.b2b.cn>   2013-1-4 上午11:18:42
 * @filename   ServerController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class ServerController extends HomeController 
{
	private $App;
	public function init()
	{
		$this->App = D('App');
		parent::init();
	}
	
	/**
	 * 登录
	 */
	public function loginAction()
	{
		$username = Controller::post('username');
		$password = Controller::post('password');		
		$appname = Controller::get('appname');
		$ip = Controller::post('ip');
		$app = $this->App->where(array('appname'=>$appname))->getOne();
		$username = rc4($username ,'DECODE',$app['appkey']);
		$password = rc4($password ,'DECODE',$app['appkey']);
		$ip = base64_decode($ip);
		if(!$appname||!$username||!$password||!$ip)
		{
		  exit('0');
		}
		if(empty($app))
		{
			exit('0');
		}
		$haveUser = M('ImcUsers')->where(array('username'=>$username))->getOne();
		if(empty($haveUser))
		{
			exit('1'); //用户名不存在
		}
		$result = M('ImcUsers')->where(	array('username'=>$username,'password'=>md5($password))
		)->getOne();
		if(!empty($result))
		{
			if($result['status']!=1)
			{
				exit('3'); //用户账号冻结中...
			}
			else
			{
				//更新用户最后登录时间,最后登录IP
				M('ImcUsers')->update(array('id'=>$result['id']),array('lastip'=>$ip,'lastdate'=>time()));
				$list = M('imc_app')->where(array('syslogin'=>1))->order('id desc')->select();
				foreach($list as $key=>$value)
				{
					echo '<script src="'.$value['appurl'].'/user/user/setsession/username/'.rc4($username,'ENCODE',$value['appkey'],1).'"></script>';
				}
				die;
			}
			
		}
		else
		{
			exit('2'); //密码错误
		}
	}

	/**
	 *退出
	 */
	public function loginoutAction()
	{
			
		$appname = Controller::get('appname');
		$code = Controller::post('code');

		$app = $this->App->where(array('appname'=>$appname))->getOne();
		$code = rc4($code ,'DECODE',$app['appkey']);
		
		if($code!='action=loginout')
		{
			exit('0'); //非法操作
		}
		else
		{
			//通知其他应用同步退出
			
			$list = M('imc_app')->where(array('syslogin'=>1))->order('id desc')->select();
			foreach($list as $key=>$value)
			{
				echo '<script src="'.$value['appurl'].'/user/user/unsetSession"></script>';
			}
			exit();
		}
	}
	/**
	判断应用st
	**/
	/*public function getAppSTAction()
	{
		exit($_COOKIE['tong']);
		$appst = Controller::get('st');	
		$appurl = Controller::get('url');
		$arr = parse_url($appurl);
		if($appst == $_COOKIE['st'])
		{
			unset($_COOKIE['st']);//删除ST，防止重复利用
			Session::set('imc_user' , $_COOKIE['imc_user']);
			unset($_COOKIE['imc_user']);
			$list = M('imc_app')->order('id desc')->select();
			foreach($list as $key=>$value)
			{
				echo '<script src="'.$value['appurl'].'/user/user/setsession/username/'.rc4(Session::get('imc_user'),'ENCODE',$value['appkey'],1).'"></script>';
			}
			echo '<script>window.location.href="'.$appurl.'";</script>';die;
			//header('Location:'.$appurl);
		}
		{
			unset($_COOKIE['st']);
			unset($_COOKIE['imc_user']);
			header('Location:'.$appurl);//跳转到应用页面，登录失败
		}
	}

	/*获取各个应用的SEssion*/
	function getsessionAction()
	{
		echo '<script src="http://www.cms.loc/static/js/jquery-1.7.2.js"></script>';
		$url = Controller::get('url');
		$list = M('imc_app')->order('id desc')->select();
		foreach($list as $key=>$value)
		{
			echo '<script type="text/javascript">
					$.ajax({
					  type:"get",
					  url:"'.$value['appurl'].'/user/User/setsession/username/tong",
					  success:function(msg){}
					});
			     </script>';
			//echo '<script src="httP://www.cms.loc/user/user/setsession/username/'.rc4('tong','ENCODE',get_config('imc','key'),1000).'"></script>';
		}
		echo '<script>window.location.href="'.$value['appurl'].'";</script>';die;

    	/*if(Session::get('imc_user'))
    	{
    		$jsondata="{username:'".Session::get('imc_user')."'}";
    		exit($_GET['callback'].'('.$jsondata.')');
    	}
    	else 
    	{
    		$jsondata="{username:''}";
    		exit($_GET['callback'].'('.$jsondata.')');
    	}*/
    	//$jsondata = "{symbol:'aa', price:120}";  echo $_GET['callback'].'('.$jsondata.')'; 
    	 //header('location:http://www.test2.com/casserver/cac/login/getsession?servername="'.$servername.'"&&appname="'.$appname.'"&&session="A"');
    }
	
	

}