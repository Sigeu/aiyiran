<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * GroupController.php
 * 
 * 会员分组控制器类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-21 上午10:37:49
 * @filename   GroupController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class GroupController  extends AdminController
{
	private $objGroup;
	private $status;
	
	public function init()
	{
		$this->objGroup = D('MemberGroup');
		$this->status = array('1'=>'开启','2'=>'关闭');
		$this->assign('status',$this->status);
		parent::init();
	}
	/**
	 * 会员分组列表
	 */
	public function indexAction()
	{
		$list   = array();
		$result = array();
		$objMember = M('Member');
		
		$result = $this->objGroup->order("id DESC")->select();
		foreach ($result as $row)
		{
			$row['membernum'] = $objMember->findCount(array('groupid'=>$row['id'],'isdel'=>0));
			$list[] = $row;
		}
		
		$this->assign('groupList',$list);
		$this->display('members/group/group_list');
	}
	
	/**
	 * 添加会员分组
	 */
	public function addAction()
	{
		$param    = array();
		$formlist = array();
		$categorylist = array();
		$objForm  = D('Form');
		$objDeal  = D('MemberDeal');
		$objGroup = D('MemberGroup');
		$objCategory  = D('Category','content');               //栏目
		$objCatePriv  = D('MemberCatePer','content');          //会员组的栏目权限
		
		//所有栏目列表
		$categorylist = get_cache('category','common');        //所有栏目缓存列表
		if (!$categorylist)
		{
			$categorylist = $objCategory->getCategoryCacheList();
		}
		//会员表单列表
		$formlist = get_cache('memberform','common');
		if (!$formlist)
		{
			$formlist = $objForm->getMemberFormCacheList(); 
		}
		//会员注册协议列表
		$deallist = get_cache('memberdeal','common');
		if (!$deallist)
		{
			$deallist = $objDeal->getMemberDealCacheList(); 
		}
		if ($_POST)
		{
			$param = array(
					'groupname'    => trim($this->getParams('groupname')),
					'registerform' => trim($this->getParams('registerform')),
					'registerdeal' => trim($this->getParams('registerdeal')),
					'status'       => trim($this->getParams('status')),
					'upgrade'      => trim($this->getParams('upgrade')),
					'regverify'    => trim($this->getParams('regverify')),
					'mailverify'   => trim($this->getParams('mailverify')),
					);
			$newid = $this->objGroup->create($param);
			$this->_cache();                        //更新会员组缓存 
            //操作日志   
			admin_log("添加会员分组","添加了会员分组： ".$this->getParams('groupname'));
			
			if ($newid)
			{
				//栏目权限设置
				$arr_priv = isset($_POST['priv'])?$_POST['priv']:array();
				if (isset($arr_priv) && !empty($arr_priv))
				{
					foreach ($arr_priv as $key=>$val)
					{
						foreach ($val as $v)
						{
							$row['groupid'] = $newid;
							$row['categoryid'] = $key;
							$row['permissionid'] = $v;
							$param2[] = $row;
						}
					}
						
					$objCatePriv->addAll($param2);
				}
				$this->dialog('/members/group/index');
				exit();
			}
		}
		
		$this->assign('formList',$formlist);
		$this->assign('dealList',$deallist);
		$this->assign('categoryList',$categorylist);
		$this->display('members/group/group_add');
	}
	
	/**
	 * 修改会员分组
	 */
	public function editAction()
	{
		$param    = array();
		$formlist     = array();
		$categorylist = array();
		$objForm      = D('Form');                              //会员表单
		$objDeal      = D('MemberDeal');                       //会员注册协议
		$objCatePriv  = D('MemberCatePer','content');          //会员组的栏目权限
		$objCategory  = D('Category','content');               //栏目
				
		$groupid = $this->getParams('groupid');
		$condition = array('id'=>$groupid);
		//会员注册表单列表
		$formlist = get_cache('memberform','common');
		if (!$formlist)
		{
			$formlist = $objForm->getMemberFormCacheList(); 
		}
		//会员注册协议列表
		$deallist = get_cache('memberdeal','common');
		if (!$deallist)
		{
			$deallist = $objDeal->getMemberDealCacheList(); 
		}
		
        //会员分组信息
		$groupinfo = $this->objGroup->where($condition)->getOne();      //会员分组基本信息
		$grouppriv = $objCatePriv->getPrivListByGroupId($groupid);      //会员分组栏目权限息
		$categorylist = get_cache('category','common');                 //所有栏目缓存列表
		if (!$categorylist)
		{
			$categorylist = $objCategory->getCategoryCacheList();
		}
		
		if ($_POST)
		{
			$param = array(
					'groupname'    => trim($this->getParams('groupname')),
// 					'registerform' => trim($this->getParams('registerform')),
					'registerdeal' => trim($this->getParams('registerdeal')),
					'status'       => trim($this->getParams('status')),
					'upgrade'      => trim($this->getParams('upgrade')),
					'regverify'    => trim($this->getParams('regverify')),
					'mailverify'   => trim($this->getParams('mailverify')),
					);
			$this->objGroup->update($condition,$param);  //更新会员组基本信息
			$this->_cache();                             //更新会员组缓存
			 
            //操作日志   
			admin_log("修改会员分组","修改了会员分组： ".$groupinfo['groupname']);
			
			//栏目权限设置
			$arr_priv = isset($_POST['priv'])?$_POST['priv']:array();
			if (isset($arr_priv) && !empty($arr_priv))
			{
				foreach ($arr_priv as $key=>$val)
				{
					foreach ($val as $v)
					{
					    $row['groupid'] = $groupid;
					    $row['categoryid'] = $key;
					    $row['permissionid'] = $v;
					    $param2[] = $row;
					}
				}
				
				//更新会员组的栏目权限信息
				$objCatePriv->delete(array('groupid'=>$groupid));
				$objCatePriv->addAll($param2);
			}
			
			$this->dialog('/members/group/index');
			exit;
		}

		$this->assign('groupInfo',$groupinfo);
		$this->assign('groupPriv',$grouppriv);
		$this->assign('categoryList',$categorylist);
		$this->assign('formList',$formlist);
		$this->assign('dealList',$deallist);
		$this->display('members/group/group_edit');
	}
	
	/**
	 * 开启/关闭 会员分组
	 */
	public function isableAction()
	{
		$id = $this->getIds('groupid');
		$state = $this->getParams('state');
		if ($id)
		{
			$condition['in'] = array('id'=>$id);
			$param = array('status'=>$state);
			$this->objGroup->update($condition,$param);  //更新会员组信息
			$this->_cache();                             //更新会员组缓存
			
			//操作日志
			$arr_id = explode(",", $id);
			$names = '';
			foreach ($arr_id as $row)
			{
				$infos = $this->objGroup->find(array('id'=>$row));
				$names .= $infos['groupname']." ";
			}
			
			if ($state==1)
			{
				admin_log("开启会员分组","开启了会员分组： ".$names);
			}else 
			{
     			admin_log("关闭会员分组","关闭了会员分组： ".$names);
			}
			
			$this->redirect($this->createUrl("members/group/index"));
			exit;
		}
	}
	
	
	/**
	 * 删除会员分组
	 */
	public function deleteAction()
	{
		$num = 0;
		$num_ok = 0;
		$num_fail = 0;
		$id = $this->getIds('groupid');
		
		$objMember = M('Member');
		$objLevel  = M('MemberLevel');
		
		$member_result = $objMember->field('groupid')->group('groupid')->select();
		$level_result = $objLevel->field('groupid')->group('groupid')->select();
		$group_arr = explode(',', $id);
		$num = count($group_arr);
		foreach ($member_result as $m)
		{
			$member_group[] = $m['groupid'];
		}
		foreach ($level_result as $le)
		{
			$level_group[] = $le['groupid'];
		}
		
		$groupid_arr = array_diff($group_arr, $member_group,$level_group);
		$ids = implode(',', $groupid_arr);
		$num_ok = count($groupid_arr);
		$num_fail = $num-$num_ok;
		
		if ($ids)
		{
			
			//操作日志
			$names = '';
			foreach ($groupid_arr as $row)
			{
				$infos = $this->objGroup->find(array('id'=>$row));
				$names .= $infos['groupname']." ";
			}
			admin_log("删除会员分组","删除了会员分组： ".$names);
			
		}
		if ($num_fail>0)
		{
			$tip = "成功删除{$num_ok}个会员分组，失败{$num_fail}个";
		}else 
		{
			$tip = "成功删除{$num_ok}个会员分组";
		}
		//删除会员组信息
		$condition['in'] = array('id'=>$ids);
		$this->objGroup->delete($condition);         
		$this->_cache();                             //更新会员组缓存
		
		$this->dialog("/members/group/index",'success',$tip);
		exit;
	}
	
	
	/**
	 * 生成缓存
	 */
	protected function _cache()
	{
		$objLevel = D('MemberLevel');
		$this->objGroup->getGroupCacheList();      //开启的分组
		$this->objGroup->getAllGroupCacheList();   //所有分组
		$objLevel->getGroupLevelCacheList();       //分组-级别  级联数组 
	}
	
}