<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * IndexController.php
 * 
 * IMCenter 首页
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-4 上午11:18:42
 * @filename   MemberController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
 
class IndexController extends AdminController 
{
	private $objIMCUser;
	public function init()
	{
		$this->objIMCUser = M('ImcUsers');
		parent::init();
	}
	
	/**
	 * IMC登录
	 */
	
	public function loginimcAction()
	{
		$username = Cookie::get('username_imc');
		
		$this->assign('username_imc',$username);
		$this->display("index/login");	
	}
	
	/**
	 * 用户登录验证
	 */
	public function checkloginAction()
	{
		require_once DIR_ROOT."/../static/js/securimage/securimage.php";
		$securimage = new Securimage();
		$flag = 0;
	
		$task     = $this->getParams('task');
		$username = trim($this->getParams('username_imc'));
		$password = trim($this->getParams('password_imc'));
		$captcha  = trim($this->getParams('captcha_imc'));
		$isremember  = trim($this->getParams('isremember_imc'));
	
	
		if ('dosubmit'==$task)
		{
			//验证码信息
			if ($securimage->check($captcha))
			{
				//查询用户信息
				$userinfo_imc = $this->objIMCUser->find(array('username'=>$username));
				if ($userinfo_imc)
				{
					//如果用户存在，则验证用户是否为IMC管理员
					if ($userinfo_imc['isimc']==1)
					{
						$userid = $userinfo_imc['id'];
						$pwd = $userinfo_imc['password'];
						if ($pwd == md5($password))
						{
							//密码正确，登录成功
							$flag = 10;
							//更新用户登录信息
							$param = array(
									'lastip'   => $this->getClientIP(),  //最后登录ip
									'lastdate' => time(),                //最后登录时间
							);
							$this->objIMCUser->update(array('id'=>$userid),$param);
							 
							$userinfo_imc['lastip'] = $param['lastip'];
							$userinfo_imc['lastdate'] = $param['lastdate'];
							 
							//把用户信息放入session
							$_SESSION['userinfo_imc'] = $userinfo_imc;
							 
	
							if ($isremember)
							{
								//设置cookie
								$cookie_time = 86400*7; //一周
								Cookie::set('username_imc', $username,$cookie_time);
							}else
							{
								Cookie::delete('username_imc');
							}
							 
						}else
						{
							//密码错误
							$flag = 4;
						}
					}else
					{
						//用户非IMC管理员，提示非IMC管理员，不能登录
						$flag = 3;
					}
	
				}else
				{
					//如果用户名错误，则提示用户不存在
					$flag = 2;
				}
			}else
			{
				//提示验证码错误
				$flag = 1;
			}
		}
		//IMC操作日志
		if ($flag==10)
		{
			imc_log("登录IMCenter","成功登录IMCenter");
		}
	
		echo $flag;    //1：验证码错误 2：用户名错误 3：非IMC管理员，不能登录 4：密码错误  10：登录成功
	}

	
	/**
	 * 修改密码
	 * 
	 */
	public function editpwdAction()
	{
		$userinfo = isset($_SESSION['userinfo_imc'])?$_SESSION['userinfo_imc']:array();
		if ($_POST)
		{
		    $password_new = md5(trim($this->getParams('password_new')));
			$this->objIMCUser->update(array('id'=>$userinfo['id']), array('password'=>$password_new));
// 			Session::delete("userinfo_imc");

			//IMC操作日志
			imc_log("修改密码",$userinfo['username']."修改了密码");
			$this->dialog("/index/index/editpwd");
		}
		        		
		$this->assign('userInfo',$userinfo);
		$this->display("index/editpwd");	
	}
	
	/**
	 * 修改密码时验证原密码
	 * 
	 */
	public function checkpwdAction()
	{
		$flag = 0;
		$userinfo = isset($_SESSION['userinfo_imc'])?$_SESSION['userinfo_imc']:array();
		$admininfo = $this->objIMCUser->find(array('id'=>$userinfo['id']));
		$password_old = $admininfo['password'];
		$password = $_GET['password_old'];
		if (md5($password)==$password_old)
		{
			$flag = 1;
		}else 
		{
			$flag = 2;
		}
		echo $flag;
	}

}