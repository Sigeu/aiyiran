<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * PermissionController.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-25 下午3:23:36
 * @filename   PermissionController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class PermissionController extends AdminController
{

	/**
	 *
	 * 菜单（权限）列表
	 */
	function indexAction()
	{
		require_once DIR_BF_ROOT.'classes/Tree.php';
		$tree = new Tree();
		$menu = M('Permission');
		$pageInfo  = array();
		$menu_list = array();
		$where = '';
		$ptype = '';
		
		//排序
		if ($_POST)
		{
			$sort = $_POST['sort'];
			foreach ($sort as $key=>$value)
			{
				$condition = array('id'=>$key);
				$param = array('sort'=>$value[0]);
				
				$menu->update($condition,$param);
			}
		}

		$pageInfo['addUrl'] = "/webset/permission/add";
		if (isset($_GET['ptype']))
		{
            $ptype = $_GET['ptype'];
		}
		if ($ptype==1)
		{
			$where = "ptype=1 ";
		}

		$list = $menu->where($where)->select();
		foreach ($list as $row)
		{
			$row['control'] = "<a href='./edit?id={$row['id']}'>修改</a> | <a href='./del?id={$row['id']}' onclick=\"return confirm('确认要删除吗？')\">删除</a>";
			$menu_list[] = $row;
		}
		$tree -> icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree -> nbsp = '&nbsp;&nbsp;&nbsp;';
		$tree -> init($menu_list);
		$str  = "<tr>
					<td><input type='checkbox' name='items[]' value='\$id' /></td>
					<td><input type='text' name='sort[\$id][]' value='\$sort' size=2 /></td>
					<td >\$id</td>
					<td >\$spacer\$name</td>
					<td >\$notename</td>
					<td >\$appdirectory</td>
					<td >\$module</td>
					<td >\$controller</td>
					<td >\$actionname</td>
					<td >\$data</td>
					<td >\$flag</td>
					<td align='center'>\$control</td>
				</tr>";
		$menustr = $tree -> get_tree(0, $str);


		$this->assign('menustr', $menustr);
		$this->assign('pageInfo', $pageInfo);
		$this->display('webset/permission/permission_list.html');
	}
	/**
	 *
	 * 添加菜单（权限）
	 */
	function addAction()
	{
		require_once DIR_BF_ROOT.'classes/Tree.php';
		$tree = new Tree();
		$menu = M('Permission');

		$pageInfo = array();
		$pageInfo['listUrl'] = "/webset/permission/index";
		$task = $this->getParams('task');
		if ('dosubmit' == $task)
		{
			$info = $_POST['info'];
			foreach ($info as $key=>$value)
			{
				$menuinfo[$key] = trim($value);
			}
			$link = "";
			if (isset($menuinfo['appdirectory']) && !empty($menuinfo['appdirectory']))
			{
				$link .= "/".$menuinfo['appdirectory'];
			}
			if (isset($menuinfo['module']) && !empty($menuinfo['module']))
			{
				$link .= "/".$menuinfo['module'];
			}
			if (isset($menuinfo['controller']) && !empty($menuinfo['controller']))
			{
				$link .= "/".$menuinfo['controller'];
			}
			if (isset($menuinfo['actionname']) && !empty($menuinfo['actionname']))
			{
				$link .= "/".$menuinfo['actionname'];
			}
			if (isset($menuinfo['data']) && !empty($menuinfo['data']))
			{
// 				$link .= "?".$menuinfo['data'];
				$link .= "/".$menuinfo['data'];
			}
			if (isset($link) && !empty($link))
			{
				$menuinfo['link'] = $link;
			}
			if (isset($menuinfo['link']) && !empty($menuinfo['link']))
			{
				$menuinfo['link'] = $menuinfo['link'];
			}
			
			$module = $menu->field('moduleid')->where("id={$menuinfo['parentid']}")->select();
			$moduleid = $module[0]['moduleid'];
			$menuinfo['moduleid'] = $moduleid;
			if (!$moduleid)
			{
				$menuinfo['moduleid'] = $menuinfo['parentid'];
			}
			$menu->create($menuinfo);
			//重新生成缓存
			$this->_cache();
			$this->redirect('./index');
			exit;
		}
		//option
		$menuoption = '';
		$menu_list = array();

		$list = $menu->select();
		foreach ($list as $row)
		{
			if (isset($_GET['parentid']))
			$row['selected'] = $row['id'] == $_GET['parentid'] ? 'selected' : '';
			$menu_list[] = $row;
		}
		$tree -> init($menu_list);
		$str = "<option value='\$id' \$selected>\$spacer\$name</option>";
		$menuoption = $tree -> get_tree(0, $str);


		$this->assign('menuoption', $menuoption);
		$this->assign('pageInfo', $pageInfo);
		$this->display('webset/permission/permission_add.html');
	}

	function editAction()
	{
		require_once DIR_BF_ROOT.'classes/Tree.php';
		$tree = new Tree();
		$menu = M('Permission');
		$pageInfo = array();
		$pageInfo['addUrl'] = "/webset/permission/add";
		$pageInfo['listUrl'] = "/webset/permission/index";

		$id = $this->getParams('id');
		$task = isset($_POST['task'])?$_POST['task']:"";
		if($id)
		{
			if ('dosubmit' == $task)
			{
			    $info = $_POST['info'];
				foreach ($info as $key=>$value)
				{
					$menuinfo[$key] = trim($value);
				}

				$link = "";
				if (isset($menuinfo['appdirectory']) && !empty($menuinfo['appdirectory']))
				{
					$link .= "/".$menuinfo['appdirectory'];
				}
				if (isset($menuinfo['module']) && !empty($menuinfo['module']))
				{
					$link .= "/".$menuinfo['module'];
				}
				if (isset($menuinfo['controller']) && !empty($menuinfo['controller']))
				{
					$link .= "/".$menuinfo['controller'];
				}
				if (isset($menuinfo['actionname']) && !empty($menuinfo['actionname']))
				{
					$link .= "/".$menuinfo['actionname'];
				}
				if (isset($menuinfo['data']) && !empty($menuinfo['data']))
				{
// 					$link .= "?".$menuinfo['data'];
					$link .= "/".$menuinfo['data'];
				}
				if (isset($link) && !empty($link))
				{
					$menuinfo['link'] = $link;
				}
				if ($menuinfo['flag']==1 && isset($menuinfo['link']) && !empty($menuinfo['link']))
				{
					$menuinfo['link'] = $menuinfo['link'];
				}
				$module = $menu->field('moduleid')->where("id={$menuinfo['parentid']}")->select();
				$moduleid = $module[0]['moduleid'];
				$menuinfo['moduleid'] = $moduleid;
				if (!$moduleid)
				{
					$menuinfo['moduleid'] = $menuinfo['parentid'];
				}
//				dump($menuinfo);exit;
				$menu->update("id={$id}", $menuinfo);
			   //重新生成缓存
			   $this->_cache();

				$this->redirect('./index','修改成功');
				exit;
			}

			$recordInfo = $menu->find("id='{$id}'");
			if (!is_array($recordInfo))
			{
				$this->redirect('./index',"参数错误！");
				exit;
			}
			//option
			$menuoption = '';
			$menu_list = array();

			$list = $menu->select();
			foreach ($list as $row)
			{
				$row['selected'] = $row['id'] == $recordInfo['parentid'] ? 'selected' : '';
				$menu_list[] = $row;
			}
			$tree -> init($menu_list);
			$str = "<option value='\$id' \$selected>\$spacer\$name</option>";
			$menuoption = $tree -> get_tree(0, $str);

			$this->assign('recordInfo', $recordInfo);
			$this->assign('menuoption', $menuoption);
		}else
		{
			$this->redirect('./index',"参数错误！");
			exit;
		}
// dump($recordInfo);exit;
		$this->assign('pageInfo', $pageInfo);
		$this->display('webset/permission/permission_edit.html');
	}



	function delAction()
	{
		$menu = M('Permission');

		$id = $_GET['id'];
		$ids = $_POST['items'];
		if ($id)
		{
			$menu->delete("id={$id} or parentid={$id}");
			//重新生成缓存
			$this->_cache();
			$this->redirect('./index',"删除成功！");
			exit;
		}

		if (is_array($ids))
		{
			$idstr = implode(",", $ids);
			$menu -> delete("id in {$idstr}");
			//重新生成缓存
			$this->_cache();
			$this->redirect('./index',"删除成功！");
			exit;
		}
	}
	
	/**
	 * 生成权限缓存列表
	 */
	function _cache()
	{
		$objP = D('Permission');
		$permissionlist = $objP->getPermissionList();
	}



}