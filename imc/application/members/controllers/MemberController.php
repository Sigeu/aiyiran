<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberController.php
 * 
 * IMCenter 用户管理
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
 
 
class MemberController extends AdminController 
{
	private $objIMCMember;
	private $objIMCApp;
	public function init()
	{
		include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");		
		$this->objIMCMember = M('ImcUsers');
    	$this->objIMCApp    = M("ImcApp");
		parent::islogin_imc();
		parent::init();
	}
	
	/**
	 * 用户列表
	 */
	public function indexAction()
	{
		$pageInfo = array();
		$where    = array();
		$options  = array();
		//会员状态
		$pageInfo['status'] = array('1'=>'开通','2'=>'冻结');
		
		//用户信息
// 		$imcuserinfo = isset($_SESSION['userinfo_imc'])?$_SESSION['userinfo_imc']:array();
// 		if (!$imcuserinfo)
// 		{
// 			$this->redirect($this->createUrl('index/index/loginimc'));
// 			exit;
// 		}
		
		
		//搜索条件
		$type      = $this->getParams('type');             //关键字类型 1：按用户名  2：按电子邮件
		$keyword   = $this->getParams('keyword');          //关键字
		$status    = $this->getParams('status');           //会员状态
		$starttime = $this->getParams('starttime');        //会员创建时间-开始
		$endtime   = $this->getParams('endtime');          //会员创建时间-结束
		$searchInfo = array(
				'type'     => $type,
				'keyword'  => $keyword,
				'status'   => $status,
				'starttime'=> $starttime,
				'endtime'  => $endtime,
				);
		//关键字		
		if (isset($keyword)&&!empty($keyword))
		{
			if ($type == 1)
			{
				$where['like'] = array('username'=>$keyword);
			}else 
			{
				$where['like'] = array('email'=>$keyword);
			}
		}
		//用户状态 1：开通 2：冻结
		if (isset($status)&&!empty($status))
		{
			$where['status'] = $status;
		}
		
		//用户注册时间
		if (isset($starttime)&&!empty($starttime))
		{
			 $where['compbig']['regdate'] = strtotime($starttime." 00:00:00");
		}
		
		if (isset($endtime)&&!empty($endtime))
		{
			 $where['compsmall']['regdate'] = strtotime($endtime." 23:59:59");
		}
		$where['isadmin'] = 0;  //只显示前台用户
		$count = $this->objIMCMember->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "id DESC";
		
		$memberlist = $this->objIMCMember->select($options);
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;
		
		$this->assign('pageInfo',$pageInfo);
		$this->assign('searchInfo',$searchInfo);
		$this->assign('memberList',$memberlist);
		$this->assign('pageStr',$pagestr); 
		
		$this->display('members/member_list');
	}
	
	/**
	 * 用户添加
	 */
	public function addAction()
	{
		if ($_POST)
		{
			$param = array(
			        'username' => $this->getParams('username'),
			        'password' => md5($this->getParams('password')),
			        'email'    => $this->getParams('email'),
			        'status'   => $this->getParams('status'),
			        'appname'  => $this->getParams('appname'),
					'regip'    => get_client_ip(),
					'regdate'  => time()
					);
			$newid = $this->objIMCMember->create($param);
			//IMC操作日志
			imc_log("添加用户","添加了用户： ".$this->getParams('username'));
			if ($newid)
			{
				$this->dialog('/members/member/index');
				exit();
			}			
		}
		$this->display('members/member_add');
	}
	
	/**
	 * 用户修改
	 */
	public function editAction()
	{
		$userid  = $this->getParams('userid');
		$page    = $this->getParams('page');
		$type    = $this->getParams('type');
		$keyword = $this->getParams('keyword');
		$status  = $this->getParams('status');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');
		
		$condition = array('id'=>$userid);
		//用户信息
		$userinfo = $this->objIMCMember->find($condition);
	    if ($_POST)
		{
			$param = array(
					'email'  => $_POST['email'],
					);
			
			if(isset($_POST['password'])&&!empty($_POST['password']))
			{
				$param['password'] = md5($_POST['password']);
			}
			
			//更新对应表的用户信息
			$appname   = trim($_POST['appname']);
			$isadmin   = trim($_POST['isadmin']);
			$username  = trim($_POST['username']);
			
			$appinfo = $this->objIMCApp->find(array('appname'=>$appname));
			$appurl  = $appinfo['appurl'];
// 			$appurl = "http://www.cms.loc";
			//检查应用通信状态
		    $client2 = new HproseHttpClient($appurl."/imc_client/api/server.php");
			$code = rc4('action=check_status', 'ENCODE', $appinfo['appkey']);
			try 
			{
				//通信是否成功
				$data = $client2->check_status($code);
				//修改应用 用户信息
				$client  = new HproseHttpClient($appurl."/admin/api/server.php");
				$client->updateUser(array('username'=>$username),$param,$isadmin);
				//更新imc_users表中用户信息
				$this->objIMCMember->update($condition,$param);
	            
				//IMC操作日志
				imc_log("编辑用户","编辑了用户： ".$userinfo['username']);
				
			}catch (Exception $e)
			{
			    $this->dialog("/members/member/index/page/{$page}/keyword/{$keyword}/type/{$type}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}",'error','通信不成功，操作失败');
// 				exit;
			}
			$this->dialog("/members/member/index/page/{$page}/keyword/{$keyword}/type/{$type}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}");
			exit;
		}
		
		$this->assign('memberInfo',$userinfo);
		$this->display('members/member_edit');
	}
	
	/**
	 * 用户删除
	 */
	public function deleteAction()
	{
		$data =0;
		$num = 0;
		$num_ok = 0;
		$num_fail = 0;
		$names = "";
		$id = $this->getIds('userid');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'type'      => $this->getParams('type'),
				'keyword'   => $this->getParams('keyword'),
				'status'    => $this->getParams('status'),
				'starttime' => $this->getParams('starttime'),
				'endtime'   => $this->getParams('endtime'),
				);
		
		if ($id)
		{
		   //更新对应表的用户信息
			$arr_id = explode(",", $id);
			$num = count($arr_id);
			foreach ($arr_id as $row)
			{
				$userinfo = $this->objIMCMember->find(array('id'=>$row));
				
				$appname   = $userinfo['appname'];
				$isadmin   = $userinfo['isadmin'];
				$username  = $userinfo['username'];
					
				$appinfo = $this->objIMCApp->find(array('appname'=>$appname));
				$appurl  = $appinfo['appurl'];
				//检查应用通信状态
			    $client2 = new HproseHttpClient($appurl."/imc_client/api/server.php");
				$code = rc4('action=check_status', 'ENCODE', $appinfo['appkey']);
				try 
				{
					$data = $client2->check_status($code);

					$names .= $userinfo['username']." ";
					//删除相应应用 用户
					$client  = new HproseHttpClient($appurl."/admin/api/server.php");
					$client->deleteUser(array('username'=>$username),$isadmin);
					
					//删除IMC用户
					$this->objIMCMember->delete(array('id'=>$row));
					$num_ok++;
				}catch (Exception $e)
				{
					continue;
				}
			}
			$num_fail = $num-$num_ok;
			if ($names)
			{
				//IMC操作日志
				imc_log("删除用户","删除了用户：".$names);
				$this->dialog("/members/member/index/page/{$searchinfo['page']}/keyword/{$searchinfo['keyword']}/type/{$searchinfo['type']}/status/{$searchinfo['status']}/starttime/{$searchinfo['starttime']}/endtime/{$searchinfo['endtime']}",'',"成功删除{$num_ok}个用户,失败{$num_fail}个");
				exit;
			}else 
			{
				$this->dialog("/members/member/index/page/{$searchinfo['page']}/keyword/{$searchinfo['keyword']}/type/{$searchinfo['type']}/status/{$searchinfo['status']}/starttime/{$searchinfo['starttime']}/endtime/{$searchinfo['endtime']}",'',"删除失败");
				exit;
			}
		}else 
		{
			alert("请先选择用户");
			exit;
		}
	}
	
	/**
	 * 用户开通
	 */
	public function enableAction()
	{
		$names = "";
		$id = $this->getIds('userid');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'type'      => $this->getParams('type'),
				'keyword'   => $this->getParams('keyword'),
				'status'    => $this->getParams('status'),
				'starttime' => $this->getParams('starttime'),
				'endtime'   => $this->getParams('endtime'),
				);
		
		if ($id)
		{
			$param['status'] = 1;
// 			$this->objIMCMember->update($condition,$param);
			
			//更新对应表的用户信息
			$arr_id = explode(",", $id);
			foreach ($arr_id as $row)
			{
				$userinfo = $this->objIMCMember->find(array('id'=>$row));
				$names .= $userinfo['username']." ";
				
				$appname   = $userinfo['appname'];
				$isadmin   = $userinfo['isadmin'];
				$username  = $userinfo['username'];
					
				$appinfo = $this->objIMCApp->find(array('appname'=>$appname));
				$appurl  = $appinfo['appurl'];

				//检查应用通信状态
				$client2 = new HproseHttpClient($appurl."/imc_client/api/server.php");
				$code = rc4('action=check_status', 'ENCODE', $appinfo['appkey']);
				try
				{
					$data = $client2->check_status($code);
				
					$names .= $userinfo['username']." ";
					//更新相应应用 用户状态
					$client  = new HproseHttpClient($appurl."/admin/api/server.php");
					$client->updateUser(array('username'=>$username),$param,$isadmin);
					//更新IMC用户状态
					$this->objIMCMember->update(array('id'=>$row),$param);
						
				}catch (Exception $e)
				{
					continue;
				}
			}
			if ($names)
			{
				//IMC操作日志
				imc_log("开通用户","开通了用户：".$names);
			}

			$this->redirect($this->createUrl("members/member/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&type={$searchinfo['type']}&status={$searchinfo['status']}&starttime={$searchinfo['starttime']}&endtime={$searchinfo['endtime']}"));
			exit;
		}else 
		{
			alert("请先选择用户");
			exit;
		}
	}
	
	/**
	 * 用户冻结
	 */
	public function disableAction()
	{
		$names = "";
		$id = $this->getIds('userid');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'type'      => $this->getParams('type'),
				'keyword'   => $this->getParams('keyword'),
				'status'    => $this->getParams('status'),
				'starttime' => $this->getParams('starttime'),
				'endtime'   => $this->getParams('endtime'),
				);
		
		if ($id)
		{
			$param['status'] = 2;
// 			$this->objIMCMember->update($condition,$param);
			
			//更新对应表的用户信息
			$arr_id = explode(",", $id);
			foreach ($arr_id as $row)
			{
				$userinfo = $this->objIMCMember->find(array('id'=>$row));
				$names .= $userinfo['username']." ";
				
				$appname   = $userinfo['appname'];
				$isadmin   = $userinfo['isadmin'];
				$username  = $userinfo['username'];
					
				$appinfo = $this->objIMCApp->find(array('appname'=>$appname));
				$appurl  = $appinfo['appurl'];

				//检查应用通信状态
				$client2 = new HproseHttpClient($appurl."/imc_client/api/server.php");
				$code = rc4('action=check_status', 'ENCODE', $appinfo['appkey']);
				try
				{
					$data = $client2->check_status($code);
				
					$names .= $userinfo['username']." ";
					//更新相应应用 用户状态
					$client  = new HproseHttpClient($appurl."/admin/api/server.php");
					$client->updateUser(array('username'=>$username),$param,$isadmin);
					//更新IMC用户状态
					$this->objIMCMember->update(array('id'=>$row),$param);
				
				}catch (Exception $e)
				{
					continue;
				}
			}
			if ($names)
			{
				//IMC操作日志
				imc_log("冻结用户","冻结了用户：".$names);
			}
			
			$this->redirect($this->createUrl("members/member/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&type={$searchinfo['type']}&status={$searchinfo['status']}&starttime={$searchinfo['starttime']}&endtime={$searchinfo['endtime']}"));
			exit;
		}else 
		{
			alert("请先选择用户");
			exit;
		}
	}
	
	/**
	 * 检验用户名是否存在
	 */
	public function checkusernameAction()
	{
		$data = 0;
		$username = $_GET['username'];
		
		$result = $this->objIMCMember->where(array('username'=>$username))->select();
		if (isset($result)&& !empty($result))
		{
			$data = 2;   //用户名已存在
		}else
		{
			$data = 1;   //用户可以注册、添加
		}

		echo $data;
		
	}	
	
}