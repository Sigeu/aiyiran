<?php 
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-4-26 下午2:26:21 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-4-26 下午2:26:21

 * @filename   SendEmail.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: SendEmail.php 4819 2014-12-23 01:27:10Z wangshaochen $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
header("content-type:text/html; charset=utf-8");
class SendEmail {
   /**
	* 发送邮件
	* @param $userid   int    当前用户id
	* @param $username string 当前的用户名称
	* @param $senttouser string 发送给谁的邮箱地址
	* @param $flag 1(注册)，2(找回密码)
	*/
	public function sentEmail($username,$userid,$memberid,$senttouser,$flag) {
		
		$infor = $this->getMailSet();
	
		if ( $infor['mo_send_style'] == 1) {
	
			$rs = $this->smtpEmail($username,$userid,$memberid,$senttouser,$flag);
		}else{
	
			$rs = $this->mailSent($senttouser,$userid,$memberid,$username, $flag);
		}
		
		return $rs;
	}
	
	/**
	 * smtp发送邮件
	 * @param $userid   int    当前用户id
	 * @param $username string 当前的用户名称
	 * @param $senttouser string 发送给谁的邮箱地址
	 * @param $flag 1(注册)，2(找回密码)
	 */
	public function smtpEmail($username,$userid,$memberid,$senttouser,$flag){
		$link = '';		
		$replace_pairs = array();
		$stateObj = M("Mailstate");
		//邮箱设置信息
		$infor = $this->getMailSet();
		 
		//发送的邮件内容
		$title = $this->getMailContent($flag);
		$seaverName = $_SERVER['SERVER_NAME'];
	
		if ( $flag == 1 ) { //注册时发送邮件
	        $key = base64_encode($userid.",".$memberid);
	        
			$content = file_get_contents(PATH_ADMIN.'template/public/regmail.html');
			$link = "<a href='http://".$seaverName."/user/User/activate/key/".$key."' target='_blank'>http://".$seaverName."/user/User/activate/key/".$key."</a>";
			$replace_pairs = array(
					'{name}' => $username,
					'{link}' => $link,
			);
		}
        if($flag == 2)
        {
        	
			$content = "file_get_contents('".PATH_ADMIN."template/public/pwdmail.html')";
        }
		if ($flag == 3)
		{
			$objAdmin = M('Admin');
        	$password = random(6,"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
        	$sitename = get_mo_config('mo_webname');
	        $objAdmin->update(array('username'=>$username), array('password'=>md5($password)));
			$content = file_get_contents(PATH_ADMIN."template/public/findpwdmail.html");
			$replace_pairs = array(
        			'{name}'     => $username,
        			'{password}' => $password,
        			'{sitename}' => $sitename
        	);
		}

// 		$content = str_replace(array('name','link'),array($username,$link),$content);

		$content = strtr($content, $replace_pairs);
		$smtp = new Smtp($infor['mo_service'],25,true,$infor['mo_mail_account'],$infor['mo_mail_password']);
		$smtp->debug = TRUE;
		$rs = $smtp->sendmail($senttouser, $infor['mo_mail_account'], iconv("UTF-8","GB2312",$title['theme']),iconv("UTF-8","GB2312",$content), "HTML");

		$arr = array(
				'title'   =>$title['theme'],
				'reciver' =>$username,
				'userid'  =>$userid,
				'sendtime'=>time(),
				'mailcontent'=>$content,
				'username'   =>$username,
				'errorinfor' => @file_get_contents(PATH_ADMIN."template/public/bug.txt")
		);
		 
		if ( $rs == true ) {
			
			$arr['state'] = 1;
			$stateObj->create($arr);
		}else {
	
			$arr['state'] = 2;
			$stateObj->create($arr);
		}
		
		return $rs;
		 
	}
	/**
	 * mail()函数发送邮件
	 * @param $senttouser string 发送给谁的邮箱地址
	 * @param $flag 1(注册)，2(找回密码)
	 */
	public function mailSent ($senttouser,$userid,$memberid,$username,$flag) {
		
		$replace_pairs = array();
		
		//邮箱设置信息
		$infor = $this->getMailSet();
	
		//发送的邮件内容
		$title = $this->getMailContent($flag);
		$seaverName = $_SERVER['SERVER_NAME'];
		
		//注册时发送邮件
		if ( $flag == 1 ) { 
			 
			$key = base64_encode($userid.",".$memberid);
	        
			$content = file_get_contents(PATH_ADMIN.'template/public/regmail.html');
			$link = "<a href='http://".$seaverName."/user/User/activate/key/".$key."' target='_blank'>http://".$seaverName."/user/User/activate/key/".$key."</a>";
			
			$replace_pairs = array(
					'{name}' => $username,
					'{link}' => $link,
					);
			
		}
		//会员找回密码邮件
        if ($flag ==2)
        {
			$content = "file_get_contents('".PATH_ADMIN."template/public/pwdmail.html')";
        }
        //管理员找回密码邮件
        if ($flag ==3)
        {
        	$password = random(6,"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
        	$sitename = get_mo_config('mo_webname');
	        M('Admin')->update(array('username'=>$username), array('password'=>md5($password)));
        	$content = file_get_contents(PATH_ADMIN."template/public/findpwdmail.html");
        	$replace_pairs = array(
        			'{name}'     => $username,
        			'{password}' => $password,
        			'{sitname}' => $sitename,
        	);
        	 
		}
		
		$content = strtr($content, $replace_pairs);
// 		$content = str_replace(array('name','link'),array($username,$link),$content);
		$to      = $senttouser;
		$subject = $title['theme'];
		$message = $content;
		$headers = 'To:'.$senttouser. "\r\n";
		$headers .= 'From:'.$infor['mo_mail_account']. "\r\n";
		 
		$rs = mail($to, $subject, $message, $headers);
		
		return $rs;

	}
	/**
	 * 获取邮箱设置信息
	 *
	 */
	public function getMailSet() {
		 
		$mailObj = M("WebConfig");
		 
		$result = $mailObj->select(array('where'=>array('group_id'=>9)));
	
		foreach ($result as $sk => $sv) {
			 
			$infor[$sv['par_name']] = $sv['par_value'];
		}
	
		return $infor;
	}
	/**
	 * 获取邮件发送内容
	 * @param $flag 1.(注册 )2.(找回密码)
	 */
	public function getMailContent ($flag) {
		 
		$conObj = M("Mailtemplate");
		 
		return $conObj->where(array('flag'=>$flag))->field('theme')->getOne();
	}
}
?>