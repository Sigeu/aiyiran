<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AdminUserController.php
 *
 * 系统用户管理
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-4 上午11:18:42
 * @filename   AdminUserController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */


class AdminuserController extends AdminController
{
	private $objAdmin;
	private $client;
	public function init()
	{
		include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");
		$this->client = new HproseHttpClient(get_config('imc','server_url')."/imc/api/server.php");

		$this->objAdmin = D('Admin');
		parent::init();
	}
	/**
	 * 系统用户列表
	 */
	public function indexAction()
	{
		$pageInfo = array();
		$where    = array();
		$options  = array();
		$objRole  = D('Role');
		//角色下拉列表
		$rolelist = get_cache('role','common');
		if (empty($rolelist))
		{
			$rolelist = $objRole->getRoleCacheList();
		}
		//会员状态
		$pageInfo['status'] = array('1'=>'开通','2'=>'关闭');

		//搜索条件
		$keyword   = $this->getParams('keyword');          //关键字
		$roleid    = $this->getParams('roleid');           //角色id
		$status    = $this->getParams('status');           //会员状态
		$starttime = $this->getParams('starttime');        //会员创建时间-开始
		$endtime   = $this->getParams('endtime');          //会员创建时间-结束
		$searchInfo = array(
				'keyword'  => $keyword,
				'roleid'   => $roleid,
				'status'   => $status,
				'starttime'=> $starttime,
				'endtime'  => $endtime,
				);
		//关键字：支持用户名、登录IP的搜索
		if (isset($keyword)&&!empty($keyword))
		{
			$where['or'] = " username like '%{$keyword}%' or lastloginip like  '%{$keyword}%' ";
		}

		if (isset($roleid)&&!empty($roleid))
		{
			$where['roleid'] = $roleid;
		}

		if (isset($status)&&!empty($status))
		{
			$where['status'] = $status;
		}

		if (isset($starttime)&&!empty($starttime))
		{
			 $where['compbig']['createtime'] = strtotime($starttime." 00:00:00");
		}

		if (isset($endtime)&&!empty($endtime))
		{
			 $where['compsmall']['createtime'] = strtotime($endtime." 23:59:59");
		}
		$count = $this->objAdmin->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "id DESC";

		$adminuserlist = $this->objAdmin->select($options);
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;

		$pageInfo['userid'] = $_SESSION['userinfo']['id'];

		$this->assign('pageInfo',$pageInfo);
		$this->assign('searchInfo',$searchInfo);
		$this->assign('roleList',$rolelist);
		$this->assign('userList',$adminuserlist);
		$this->assign('pageStr',$pagestr);

		$this->display('webset/adminuser/adminuser_list');
	}

	/**
	 * 系统用户添加
	 */
	public function addAction()
	{
		$objRole  = D('AdminRole');
		$rolelist = get_cache('role','common');
		if (empty($rolelist))
		{
			$rolelist = $objRole->getRoleCacheList();
		}
		if ($_POST)
		{
			$param = array(
			        'username' => $this->getParams('username'),
			        'password' => md5($this->getParams('password')),
			        'email'    => $this->getParams('email'),
					'mobile'    => $this->getParams('mobile'),
			        'roleid'   => $this->getParams('roleid'),
			        'status'    => $this->getParams('status'),
					'createtime'=> time()
			);
			$newid = $this->objAdmin->create($param);
			if ($newid)
			{
				$param['appname'] = C('imc','appname'); //应用名
				$param['isadmin'] = 1;                  //后台用户标识
			    $imcuserid = $this->client->adduser($param);   //向IMC用户表中插入数据

			    //操作日志
			    admin_log("添加系统用户","添加了 ".$rolelist[$this->getParams('roleid')]." ".$this->getParams('username'));

				$this->dialog('/webset/adminuser/index');
			}
		}
		$this->assign('roleList',$rolelist);
		$this->display('webset/adminuser/adminuser_add');
	}

	/**
	 * 系统用户修改
	 */
	public function editAction()
	{
		

		$rolelist = array();
		$userinfo = array();

		$userid  = $this->getParams('userid');
		$page    = $this->getParams('page');
		$keyword = $this->getParams('keyword');
		$roleid  = $this->getParams('role');
		$status  = $this->getParams('st');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');
		
		//只有admin用户自己可以修改自己的信息
		if ($_SESSION['userinfo']['id']!=1 && $userid==1)
		{
			$this->dialog("",'info','对不起，您没有此权限');
			exit;
		}

		$objRole  = D('AdminRole');
		$rolelist = get_cache('role','common');
		if (empty($rolelist))
		{
			$rolelist = $objRole->getRoleCacheList();
		}


		$condition = array('id'=>$userid);
		$userinfo = $this->objAdmin->find($condition);
		$username = $userinfo['username'];
	    if ($_POST)
		{
			$param = array(
					'email'  => $_POST['email'],
					'mobile'  => $_POST['mobile'],
					'status' => isset($_POST['status'])?$_POST['status']:$userinfo['status'],
					'roleid' => isset($_POST['roleid'])?$_POST['roleid']:$userinfo['roleid'],
					);
			$param2 = array(
					'email'  => $_POST['email'],
					'mobile'  => $_POST['mobile'],
					'status' => isset($_POST['status'])?$_POST['status']:$userinfo['status'],
					);

			if(isset($_POST['password'])&&!empty($_POST['password']))
			{
				$param['password'] = md5($_POST['password']);
				$param2['password'] = md5($_POST['password']);
			}
			$this->objAdmin->update($condition,$param);         //修改CMS管理员表的信息

			//操作日志
			admin_log("修改系统用户信息","修改了系统用户：".$username);

			if ($userid!=1)
			{
			    $this->client->edituser(array('username'=>$username),$param2);   //修改IMC用户表的信息
			}
			$this->dialog("/webset/adminuser/index/page/{$page}/keyword/{$keyword}/roleid/{$roleid}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}");
			exit;
		}

		$this->assign('userInfo',$userinfo);
		$this->assign('roleList',$rolelist);
		$this->display('webset/adminuser/adminuser_edit');
	}

	/**
	 * 系统用户删除
	 */
	public function deleteAction()
	{
		$num = 0;
		$id = $this->getIds('userid');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'keyword'   => $this->getParams('keyword'),
				'roleid'    => $this->getParams('roleid'),
				'status'    => $this->getParams('status'),
				'starttime' => $this->getParams('starttime'),
				'endtime'   => $this->getParams('endtime'),
				);

		if ($id)
		{
			//操作日志
			$arr_id = explode(",", $id);
			$num = count($arr_id);
			$username = '';
			foreach ($arr_id as $row)
			{
				$userinfo = $this->objAdmin->find(array('id'=>$row));
				$username .= $userinfo['username']." ";
			}
			admin_log("删除系统用户","删除了系统用户： ".$username);

			$condition['in'] = array('id'=>$id);
			$this->objAdmin->delete($condition);

			$this->dialog("/webset/adminuser/index/page/{$searchinfo['page']}/keyword/{$searchinfo['keyword']}/roleid/{$searchinfo['roleid']}/status/{$searchinfo['status']}/starttime/{$searchinfo['starttime']}/endtime/{$searchinfo['endtime']}",'',"成功删除{$num}个系统用户");
// 			$this->redirect($this->createUrl("webset/adminuser/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&roleid={$searchinfo['roleid']}&status={$searchinfo['status']}&starttime={$searchinfo['starttime']}&endtime={$searchinfo['endtime']}"));
			exit;
		}else
		{
			alert("请先选择用户");
			exit;
		}
	}


	/**
	 * 系统用户 开通/关闭  1：开通  2：关闭
	 */
	public function isableAction()
	{
		$id = $this->getIds('userid');
		$state = $this->getParams('state');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'keyword'   => $this->getParams('keyword'),
				'roleid'    => $this->getParams('roleid'),
				'status'    => $this->getParams('status'),
				'starttime' => $this->getParams('starttime'),
				'endtime'   => $this->getParams('endtime'),
				);

		if ($id)
		{
			//操作的用户名
			$arr_id = explode(",", $id);
			$username = '';
			foreach ($arr_id as $row)
			{
				$userinfo = $this->objAdmin->find(array('id'=>$row));
				$username .= $userinfo['username']." ";
			}

			$condition['in'] = array('id'=>$id);
			$param['status'] = $state;
			$this->objAdmin->update($condition,$param);

			//操作日志
			if ($state==1)
			{
				admin_log("开通系统用户","开通了系统用户： ".$username);
			}else
			{
     			admin_log("关闭系统用户","关闭了系统用户： ".$username);
			}
// 			$this->dialog("/webset/adminuser/index/page/{$searchinfo['page']}/keyword/{$searchinfo['keyword']}/roleid/{$searchinfo['roleid']}/status/{$searchinfo['status']}/starttime/{$searchinfo['starttime']}/endtime/{$searchinfo['endtime']}");
// 			$this->dialog("/webset/adminuser/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&roleid={$searchinfo['roleid']}&status={$searchinfo['status']}&starttime={$searchinfo['starttime']}&endtime={$searchinfo['endtime']}");
			$this->redirect($this->createUrl("webset/adminuser/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&roleid={$searchinfo['roleid']}&status={$searchinfo['status']}&starttime={$searchinfo['starttime']}&endtime={$searchinfo['endtime']}"));
			exit;
		}else
		{
			alert("请先选择用户");
			exit;
		}
	}

}