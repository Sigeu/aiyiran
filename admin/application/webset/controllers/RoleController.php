<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AdminUserController.php
 * 
 * 系统用户角色管理
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
 
 
class RoleController extends AdminController 
{
	private $objPM;
	private $objRole;
	private $status;
	public function init()
	{
		$this->objPM = D("Permission");
		$this->objRole = D("Role");
		$this->status = array('1'=>'开启','2'=>'关闭');
		$this->assign('status',$this->status);
		parent::init();
	}
	
	/**
	 * 系统用户角色列表
	 */
	public function indexAction()
	{
		$list  = array();
		$where = array();
		$search= array();
		//搜索条件
	    $keyword = $this->getParams('keyword');   // 关键字
	    $status  = $this->getParams('status');    //状态
	    
		$search['keyword'] = $keyword;
	    $search['status'] = $status;
	    
		if (isset($keyword) && !empty($keyword))
		{
			$where['like'] = array('rolename'=>$keyword);
		}
		if (isset($status) && !empty($status))
		{
			$where['status'] = $status;
		}
		$count = $this->objRole->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
        $options['where'] = $where;
		$options['order'] = "id DESC";
        
		$list = $this->objRole->select($options);
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		
		$this->assign('roleList',$list);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('searchInfo',$search);
		$this->display('webset/role/role_list');
	}
	
	/**
	 * 系统用户角色添加
	 */
	public function addAction()
	{
		$topmenu  = array();
		$submenus = array();
		$param    = array();
		$objRole  = M('AdminRole');
		$objRP    = M('RolePermission');
		//一级菜单
		$topmenu = $this->objPM -> listAllTopMenu();

		foreach ($topmenu as $row)
		{
			$submenus[$row['id']] = $this->objPM->getPermissionArr($row['id']);
		}
		
		if ($_POST)
		{
			//角色信息
			$param = array(
					'rolename' => $_POST['rolename'],
					'status'   => $_POST['status']
					);
			$newid = $objRole->create($param);
			$this->_cache();    //更新角色缓存文件
			

			//操作日志
			admin_log("添加系统角色","添加了系统角色：".$_POST['rolename']);
			
			//权限信息
			$permissionid = $_POST['permissionid'];
			if ($newid)
			{
				foreach ($permissionid as $p)
				{
					$param2[] = array('roleid'=>$newid,'permissionid'=>$p);
				}
				$objRP->addAll($param2);

				$this->dialog("/webset/role/index");
				exit();
			}
		}
		
		$this->assign('topMenus',$topmenu);
		$this->assign('subMenus',$submenus);
		$this->display('webset/role/role_add');
	}
	
	/**
	 * 系统用户角色修改
	 */
	public function editAction()
	{	
		$id = $this->getParams('id');
		$page = $this->getParams('p');
		$status = $this->getParams('st');
		$keyword = $this->getParams('kw');
		$condition = array('id'=>$id);
		
		//超级管理员角色不能被修改
		if ($id==1)
		{
			$this->dialog("",'info','对不起，您没有此权限');
// 			$this->goback("对不起，该角色不能修改！",true);
			exit;
		}
		$objRole  = M('AdminRole');
		$objRP    = M('RolePermission');
        $permissionlist = array();
		//一级菜单
		$topmenu = $this->objPM -> listAllTopMenu();

		foreach ($topmenu as $row)
		{
			$submenus[$row['id']] = $this->objPM->getPermissionArr($row['id']);
		}
		
	
		//获取当前角色所有权限
		$permissionresult = $objRP->field('permissionid')->where(array('roleid'=>$id))->select();
		foreach ($permissionresult as $row)
		{
			$permissionlist[] = $row['permissionid'];
		}
        //角色信息
		$roleinfo = $this->objRole->find($condition);
	    if ($_POST)
		{
			$param = array(
					'rolename' => $_POST['rolename'],
					'status'   => $_POST['status']
					);
			//权限信息
			$permissionid = $_POST['permissionid'];
			if (isset($permissionid)&& !empty($permissionid))
			{
				//先删除原有权限信息
				$objRP->delete(array('roleid'=>$id));
				//插入新的权限信息
				foreach ($permissionid as $p)
			    {
				    $param2[] = array('roleid'=>$id,'permissionid'=>$p);
			    }
				
			}
			$objRP->addAll($param2);
			
			$this->objRole->update(array('id'=>$id),$param);
			$this->_cache();    //更新角色缓存文件

			//操作日志
			admin_log("修改系统角色","修改了系统角色：".$roleinfo['rolename']);
			
			$this->dialog("/webset/role/index/page/{$page}/status/{$status}/keyword/{$keyword}");
			exit;
		}

		$this->assign('topMenus',$topmenu);
		$this->assign('subMenus',$submenus);
		$this->assign('roleInfo',$roleinfo);
		$this->assign('permissionList',$permissionlist);
		$this->display('webset/role/role_edit');
	}
	
	/**
	 * 系统用户角色删除(只能删除关闭状态的角色)
	 */
	public function deleteAction()
	{
		$num = 0;
		$objRP = M("RolePermission");
		$id = $this->getIds('roleid');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'keyword'   => $this->getParams('keyword'),
				'status'    => $this->getParams('status'),
				);
		
		if ($id)
		{
			$arr_id = explode(",", $id);
			$num = count($arr_id);
			$rolename = '';
			$i = 0;
			foreach ($arr_id as $row)
			{
				$roleinfo = $this->objRole->find(array('id'=>$row));
				if($roleinfo['status']==2)
				{
				    $rolename .= $roleinfo['rolename']." ";
					$this->objRole->delete(array('id'=>$roleinfo['id']));  //删除角色信息
			        $objRP->delete(array("roleid"=>$id)); //删除角色对应的权限信息
					$i++;
				}
			}
			$num_fail = $num-$i;
			//更新角色缓存文件
			$this->_cache();    
			//操作日志
			admin_log("删除系统角色","删除了系统角色： ".$rolename);
			if ($num_fail>0)
			{
				$tip = "成功删除{$i}个系统角色，失败{$num_fail}个";
			}else 
			{
				$tip = "成功删除{$i}个系统角色";
			}
			
			$this->dialog("/webset/role/index/page/{$searchinfo['page']}/keyword/{$searchinfo['keyword']}/status/{$searchinfo['status']}","",$tip);
// 			$this->redirect($this->createUrl("webset/role/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&status={$searchinfo['status']}"));
			exit;
		}else 
		{
			alert("请先选择角色");
			exit;
		}
	}
	
	/**
	 * 系统用户角色 开启/关闭  1:开启 2：关闭
	 */
	public function isableAction()
	{
		$id = $this->getIds('roleid');
		$state = $this->getParams('state');
		$searchinfo = array(
				'page'      => $this->getParams('page'),
				'keyword'   => $this->getParams('keyword'),
				'status'    => $this->getParams('status'),
				);
		
		if ($id)
		{
			$condition['in'] = array('id'=>$id);
			$param['status'] = $state;
			$this->objRole->update($condition,$param);
			$this->_cache();    //更新角色缓存文件
			
			//操作日志
			$arr_id = explode(",", $id);
			$rolename = '';
			foreach ($arr_id as $row)
			{
				$roleinfo = $this->objRole->find(array('id'=>$row));
				$rolename .= $roleinfo['rolename']." ";
			}
			
			if ($state==1)
			{
				admin_log("开启系统角色","开启了系统角色： ".$rolename);
			}else 
			{
     			admin_log("关闭系统角色","关闭了系统角色： ".$rolename);
			}
			
			$this->redirect($this->createUrl("webset/role/index?page={$searchinfo['page']}&keyword={$searchinfo['keyword']}&status={$searchinfo['status']}"));
			exit;
		}else 
		{
			alert("请先选择角色");
			exit;
		}
	}
	
	/**
	 * 系统角色缓存
	 */
	private function _cache()
	{
		$rolelist = $this->objRole->getRoleCacheList();
		set_cache('role', $rolelist,'common');
	}
	
	

}