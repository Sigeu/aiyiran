<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MemberController.php
 * 
 * 会员管理控制器类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-21 上午10:37:49
 * @filename   memberController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class MemberController  extends AdminController
{
	private $objMember;
	private $arrStatus;
	private $client;
	public function init()
	{	
		include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");
		$this->objMember = M('Member');
		$this->arrStatus = array('3'=>'待开通','1'=>'已开通','2'=>'已关闭');
		parent::init();
	}
	
	/**
	 * 会员列表
	 */
	public function indexAction()
	{
		$where = array();
		$pageInfo   = array();
		$searchInfo = array();
		$objGroup = D('MemberGroup');
		$objLevel = D('MemberLevel');
		
		//会员组列表（所有）
		$allgroup = get_cache('allmembergroup','common');
		if (!$allgroup)
		{
			$allgroup = $objGroup->getAllGroupCacheList();
		}
		//会员级别列表（所有）
		$alllevel = get_cache('grouplevel','common');
		if (!$alllevel)
		{
			$alllevel = $objLevel->getGroupLevelCacheList();
		}
		
		$state = $this->get('state');
		$pageInfo['state'] = $state;
		
		//搜索条件
		$keyword = $this->getParams('keyword');
		$groupid = $this->getParams('groupid');
		$levelid = $this->getParams('levelid');
		$status  = $this->getParams('status');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');
		if (!isset($status) || empty($status))
		{
			$status = $state;
		}
		
		$searchInfo = array(
				'keyword' => $keyword,
				'groupid' => $groupid,
				'levelid' => $levelid,
				'status'  => $status,
				'endtime' => $endtime,
				'starttime' => $starttime,
				);
		//关键字：支持用户名、登录IP的搜索
		if (isset($keyword)&&!empty($keyword))
		{
			$where['or'] = " username like '%{$keyword}%' or lastloginip like  '%{$keyword}%' ";
		}
		
		if (isset($groupid)&&!empty($groupid))
		{
			$where['groupid'] = $groupid;
		}
		
		if (isset($levelid)&&!empty($levelid))
		{
			$where['levelid'] = $levelid;
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
		$where['isdel']=0;  //正常用户
		$count = $this->objMember->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "id DESC";

		$list = $this->objMember->select($options);
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		
		$pageInfo['pageStr'] = $pagestr;
		$pageInfo['page'] = $currpage;
		
		
		$pageInfo['allGroup']  = $allgroup;
		$pageInfo['allLevel']  = $alllevel;
		$pageInfo['arrStatus'] = $this->arrStatus;
		
		$this->assign('memberList',$list);
		$this->assign('pageInfo',$pageInfo);
		$this->assign('searchInfo',$searchInfo);
		$this->display('members/member/member_list');
	}
	
		
	/**
	 * 修改会员
	 */
	public function editAction()
	{
		$levelStr = '';
		$formarr  = '';
		$pageInfo = array();
		$objGroup = D('MemberGroup');
		$objLevel = D('MemberLevel');
		$objModel = D('Form');
		$id = $this->get('id');
		$memberinfo = $this->objMember->find(array('id'=>$id));
		$groupinfo  = $objGroup->find(array('id'=>$memberinfo['groupid']));
		$modelinfo  = $objModel->find(array('id'=>$groupinfo['registerform']));
		
		$objTable   = M($modelinfo['tablename']);
		
		$objForm  = new MessageForm($groupinfo['registerform']);
		
		$memberinfo_other = $objTable->find(array('model_id'=>$id));
		$formarr = $objForm->userForm($memberinfo_other);
		$formvalidator = $objForm->formValidator;
		
		//搜索条件
		$page    = $this->getParams('page');
		$state   = $this->getParams('state');
		$keyword = $this->getParams('keyword');
		$groupid = $this->getParams('groupid');
		$levelid = $this->getParams('levelid');
		$status  = $this->getParams('status');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');

	    //会员组列表（所有）
	    $allgroup = get_cache('allmembergroup','common');
	    if (!$allgroup)
	    {
	    	$allgroup = $objGroup->getAllGroupCacheList();
	    }
	    //会员级别列表
	    $alllevel = get_cache('allmemberlevel','common');
	    if (!$alllevel)
	    {
	    	$alllevel = $objLevel->getAllLevelCacheList();
	    }
	    
	    $levellist = $objLevel->field("id,levelname")->where(array('groupid'=>$memberinfo['groupid'],'status'=>1))->select();
	    
	    foreach ($levellist as $row)
	    {
	    	$levelArr[$row['id']] = $row['levelname']; 
	    }
	    $mylevel = array($memberinfo['levelid']=>$alllevel[$memberinfo['levelid']]);

	    $level = $mylevel+$levelArr;
	    
	    if ($_POST)
	    {
	    	//更新用户基本信息
	    	$baseinfo = $_POST['baseinfo'];
	    	$param = array(
	    			'levelid'  => $baseinfo['levelid'],
	    			'email'    => $baseinfo['email'],
	    			'status'   => $baseinfo['status'],
	    	);
	    	$param2 = array('email' => $baseinfo['email'],'status' => $baseinfo['status']);
	    		
	    	if(isset($baseinfo['password'])&&!empty($baseinfo['password']))
	    	{
	    		$param['password'] = md5($baseinfo['password']);
	    		$param2['password'] = md5($baseinfo['password']);
	    	}
	    	
	    	//更新用户其他信息(自定义信息)
	    	$otherinfo = $_POST['info'];
	    	foreach ($otherinfo as $key=>$val)
	    	{
	    		if (is_array($val))
	    		{
	    			$otherinfo[$key] = implode(";",$val);
	    		}
	    	}
	    	

	    	//检查应用通信状态
	    	$config_imc = get_config('imc');	
	    	$client2 = new HproseHttpClient($config_imc['server_url']."/imc_client/api/server.php");
	    	$code = rc4('action=check_status', 'ENCODE', $config_imc['key']);
	    	try
	    	{
	    		//通信是否成功
	    		$data = $client2->check_status($code);
	    		//修改应用 用户信息
	    		$client  = new HproseHttpClient($config_imc['server_url']."/imc/api/server.php");
// 	    		dump($client);exit;
				//更新IMC用户表的用户信息（调用IMC的接口）
		    	$client->edituser(array('username'=>$memberinfo['username']),$param2);   //修改IMC用户表的信息
                
		    	//更新用户基本信息
		    	$this->objMember->update(array('id'=>$id),$param);
		    	
		    	//更新用户其他信息(自定义信息)
		    	$objTable->update(array('model_id'=>$id), $otherinfo);
	    		 

		    	//操作日志
		    	admin_log("修改会员信息","修改了会员： ".$memberinfo['username']);

		    	$this->dialog("/members/member/index/page/{$page}/state/{$state}/keyword/{$keyword}/groupid/{$groupid}/levelid/{$levelid}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}");
	    	
	    	}catch (Exception $e)
	    	{
// 	    		echo "<pre>";
// 	    		print_r($e); exit;
	    	    $this->dialog("/members/member/index/page/{$page}/state/{$state}/keyword/{$keyword}/groupid/{$groupid}/levelid/{$levelid}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}",'error','通信不成功，操作失败');
	    	}
	    	
	    }
		
	    $pageInfo['formArr'] = $formarr;
	    $pageInfo['formvalidator'] = $formvalidator;
	    
	    $pageInfo['groupList'] = $allgroup;
	    $pageInfo['levelList'] = $level;
	    $pageInfo['arrStatus'] = $this->arrStatus;
	    
		$this->assign('memberInfo',$memberinfo);
		$this->assign('pageInfo',$pageInfo);
		$this->display('members/member/member_edit');
	}
	
	/**
	 * 开通/关闭 会员
	 */
	public function isableAction()
	{
		$id = $this->getIds('memberid');
		$flag = $this->getParams('flag');
		
		//搜索条件
		$page    = $this->getParams('page');
		$state   = $this->getParams('state');
		$keyword = $this->getParams('keyword');
		$groupid = $this->getParams('groupid');
		$levelid = $this->getParams('levelid');
		$status  = $this->getParams('status');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');
		
		if ($id)
		{

			//检查应用通信状态
			$config_imc = get_config('imc');
			$client2 = new HproseHttpClient($config_imc['server_url']."/imc_client/api/server.php");
			$code = rc4('action=check_status', 'ENCODE', $config_imc['key']);
			try
			{
				//通信是否成功
				$data = $client2->check_status($code);
				//修改应用 用户信息
				$client  = new HproseHttpClient($config_imc['server_url']."/imc/api/server.php");
				//操作日志
				$arr_id = explode(",", $id);
				$names = '';
				$namestr = "'";
				foreach ($arr_id as $row)
				{
					$infos = $this->objMember->find(array('id'=>$row));
					$nameArr[] = $infos['username'];
				}
				$names = implode(" ", $nameArr);
				$namestr .= implode("','", $nameArr);
				$namestr .="'";
				if ($flag == 1)
				{
					admin_log("开通会员","开通了会员： ".$names);
				
					 //更新IMC用户表的用户信息（调用IMC的接口）
					$client->edituser(array('in'=>array('username'=>$namestr)),array("status"=>1));   //修改IMC用户表的信息
				}else
				{
					admin_log("关闭会员","关闭了会员： ".$names);
				}
				
				$condition['in'] = array('id'=>$id);
				$param['status'] = $flag;
				$this->objMember->update($condition, $param);
					
				$this->redirect($this->createUrl("members/member/index?page={$page}&state={$state}&keyword={$keyword}&groupid={$groupid}&levelid={$levelid}&status={$status}&starttime={$starttime}&endtime={$endtime}"));
				
			}catch (Exception $e)
			{
				$this->redirect($this->createUrl("members/member/index?page={$page}&state={$state}&keyword={$keyword}&groupid={$groupid}&levelid={$levelid}&status={$status}&starttime={$starttime}&endtime={$endtime}"));
			}
			
		}else
		{
			alert("请先选择");
			exit;
		}
	}
	
	
	/**
	 * 删除会员
	 */
	public function deleteAction()
	{
		$num = 0;
		$id = $this->getIds('memberid');
		//搜索条件
		$page    = $this->getParams('page');
		$state   = $this->getParams('state');
		$keyword = $this->getParams('keyword');
		$groupid = $this->getParams('groupid');
		$levelid = $this->getParams('levelid');
		$status  = $this->getParams('status');
		$endtime = $this->getParams('endtime');
		$starttime = $this->getParams('starttime');
		
		if ($id)
		{
			//操作日志
			$arr_id = explode(",", $id);
			$num = count($arr_id);
			$names = '';
			foreach ($arr_id as $row)
			{
				$infos = $this->objMember->find(array('id'=>$row));
				$names .= $infos['username']." ";
			}
			admin_log("删除会员","删除了会员： ".$names);
			
			$condition['in'] = array('id'=>$id);
			$this->objMember->delete($condition);	
			
			$arr_id = explode(",", $id);
			$num = count($arr_id);
			$names = '';
			foreach ($arr_id as $row)
			{
				$infos = $this->objMember->find(array('id'=>$row));
				$names .= "'" . $infos['username']."',";
			}
			$condition1['in'] = array('username'=>trim($names , ','));//用来删除IMC用户表的信息
			M('imc_users')->delete($condition1);
			
			$this->dialog("/members/member/index/page/{$page}/state/{$state}/keyword/{$keyword}/groupid/{$groupid}/levelid/{$levelid}/status/{$status}/starttime/{$starttime}/endtime/{$endtime}","success","成功删除{$num}个会员");
// 			$this->redirect($this->createUrl("members/member/index?page={$page}&state={$state}&keyword={$keyword}&groupid={$groupid}&levelid={$levelid}&status={$status}&starttime={$starttime}&endtime={$endtime}"));
			exit;
		}else
		{
			alert("请先选择");
			exit;
		}
	}
	
	
}