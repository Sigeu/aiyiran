<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * LoginController.php
 *
 * 后台会员登录、退出、修改密码
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-15 上午11:48:40
 * @filename   LoginController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class LoginController extends AdminController {

	/**
	 * 用户登录
	 */
	public function indexAction()
	{
		$username = Cookie::get('username');
			$this->official();

		$this->assign('username',$username);
		$this->display('admin/login/index');
	}

	/**
	 * 用户登录验证
	 */
	public function checkloginAction()
	{
		require_once DIR_ROOT."/../static/js/securimage/securimage.php";
		$securimage = new Securimage();
		$objAdmin   = M('Admin');
		$objRP      = D('RolePermission','webset');
		$objPermission = D('Permission','webset');
		$flag = 0;
		$mypermissionid = array();
		$mylinks        = array();
		$alllinks       = array();

		$task     = $this->getParams('task');
		$username = trim($this->getParams('username'));
		$password = trim($this->getParams('password'));
		$captcha  = trim($this->getParams('captcha'));
		$isremember  = trim($this->getParams('isremember'));


		if ('dosubmit'==$task)
		{
			//验证码信息
			if ($securimage->check($captcha))
			{
              //查询用户信息
			  $userinfo = $objAdmin->find(array('username'=>$username));
			  if ($userinfo)
			  {
			    //如果用户存在，则验证用户状态
			    if ($userinfo['status']==1)
			    {
			    	$userid = $userinfo['id'];
				    $pwd = $userinfo['password'];
				    if ($pwd == md5($password))
				    {
				    	//密码正确，登录成功
				    	$flag = 10;
				    	//更新用户登录信息
				    	$param = array(
				    			'lastloginip'   => $this->getClientIP(),  //最后登录ip
				    			'lastlogintime' => time(),                //最后登录时间
				    			'addition'      => "loginnum=loginnum+1"  //登录次数
				    			);
				    	$objAdmin->update(array('id'=>$userid),$param);

				    	$userinfo['lastloginip'] = $param['lastloginip'];
				    	$userinfo['lastlogintime'] = $param['lastlogintime'];
				    	$userinfo['loginnum'] = $userinfo['loginnum']+1;

				    	//当前用户所有权限
				    	$mypermission = $objRP->getPermissionByRoleId($userinfo['roleid']);
				    	$permissionlist = get_cache('permission','common');
				    	if (!$permissionlist)
				    	{
				    		$permissionlist = $objPermission->getPermissionList();
				    	}
				    	foreach ($permissionlist as $pp)
				    	{
				    		$alllinks[] = $pp;
				    	}
				    	foreach($mypermission as $row)
				    	{
				    		$mypermissionid[] = $row['permissionid'];
				    		$mylinks[] = $permissionlist[$row['permissionid']];
				    	}
				    	$userinfo['mypermissionid'] = $mypermissionid;
				    	$userinfo['mylinks'] = $mylinks;
				    	//把用户信息放入session
				    	$_SESSION['userid'] = $userid;
				    	$_SESSION['roleid'] = $userinfo['roleid'];
				    	$_SESSION['userinfo'] = $userinfo;
				    	$_SESSION['mypermissionid'] = $mypermissionid;
				    	$_SESSION['mylinks'] = $mylinks;
				    	$_SESSION['alllinks'] = $alllinks;


				    	if ($isremember)
				    	{
				    		//设置cookie
				    		$cookie_time = 86400*7; //一周
				    		Cookie::set('username', $username,$cookie_time);
				    	}else
				    	{
				    		Cookie::delete('username');
				    	}

				    }else
				    {
				    	//密码错误
				    	$flag = 4;
				    }
			    }else
			    {
			    	//用户状态关闭，提示账号异常
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

		//添加登录操作日志
		if ($flag==10)
		{
			admin_log("登录后台","成功登录后台");
		}

		echo $flag;    //1：验证码错误 2：用户名错误 3：用户账号异常，请联系总管理员 4：密码错误  10：登录成功
	}


	/**
	 * 用户退出登录
	 */
	public function loginoutAction()
	{
		//添加登录操作日志
		admin_log("退出后台","成功退出后台");

		unset($_SESSION);
		session_destroy();
		$this->dialog('/admin/login/index','success','退出成功');
	}

	/**
	 * 用户修改密码
	 */
	public function editpwdAction()
	{
		$objAdmin = M('Admin');
		$param = array();

		$userinfo = isset($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
		$userid   = $userinfo['id'];
		$username = $userinfo['username'];

		$task = $this->getParams('task');
		$password = trim($this->getParams('password'));
		if('dosubmit'==$task)
		{
			$param['password'] = md5($password);
			$objAdmin->update(array('id'=>$userid), $param);
			//操作日志
			admin_log("修改密码",$username."修改了密码");
			//更新成功后，退出到登录页
// 			unset($_SESSION);
// 			session_destroy();
// 		    $this->dialog('/admin/login/index','success','修改成功');
		}

		$this->assign('username',$username);
		$this->display('admin/login/editpwd');
	}
	
	/**
	 * 找回密码
	 */
	public function findpwdAction()
	{
		$flag = $this->getParams('flag');
		if (10==$flag)
		{
			//用户名、邮箱验证通过后发邮件
			$username = $_POST['username'];
			$email    = $_POST['email'];
			$sendmail_obj = new SendEmail();
			$rs = $sendmail_obj ->sentEmail($username,'','',$email,'3');
			if ($rs)
			{
    			$this->dialog("/admin/login/index","","找回密码邮件已发送至您的邮箱，请登录邮箱查收邮件");
			}else 
			{
				$this->dialog("/admin/login/index","error","系统邮件服务器设置有误，无法发送找回密码邮件");
				
			}
		}
		$this->display("admin/login/findpwd");
	}
	
	/**
	 * 用户是否存在验证
	 */
	public function checkuserAction()
	{
		require_once DIR_ROOT."/../static/js/securimage/securimage.php";
		$securimage = new Securimage();
		$objAdmin   = M('Admin');
		$flag = 0;
	
		$task     = $this->getParams('task');
		$username = trim($this->getParams('username'));
		$email    = trim($this->getParams('email'));
		$captcha  = trim($this->getParams('captcha'));
	
	
		if ('dosubmit'==$task)
		{
			//验证码信息
			if ($securimage->check($captcha))
			{
				//查询用户信息
				$userinfo = $objAdmin->find(array('username'=>$username));
				if ($userinfo)
				{
					//如果用户存在，则验证用户状态
					if ($userinfo['status']==1)
					{
						$userid = $userinfo['id'];
						$useremail = $userinfo['email'];
						if ($email == $useremail)
						{
							//管理员邮箱与账户匹配，验证成功
							$flag = 10;							
	
						}else
						{
							//管理员邮箱与账户不匹配
							$flag = 4;
						}
					}else
					{
						//用户状态关闭，提示账号异常
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
	
		echo $flag;    //1：验证码错误 2：用户名错误 3：用户账号异常，请联系总管理员 4：邮箱与账户不匹配  10：验证成功
	}
}