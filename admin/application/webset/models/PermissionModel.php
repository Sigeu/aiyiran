<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * PermissionModel.php
 * 
 * 菜单权限Model类
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-26 下午5:58:45
 * @filename   PermissionModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class PermissionModel extends Model
{
	public $pk = "id"; 
	public $tableName = "permission";
	
	
	/**
	 * 
	 * 获取权限或菜单信息
	 */
	function getInfo($options=array())
	{
		$result = $this->select($options);
		if (count($result) == 1)
		{
			$result = $result[0];
		}
		return isset($result)?$result:array();
	}
	/**
	 * 
	 * 得到所有一级菜单
	 */
	function listAllTopMenu()
	{
		$options = array();
		$options['where'] = " parentid=0 and moduleid=0 and status=0 ";
		$options['order'] = " sort asc";
		
		$result = $this->select($options);
		return isset($result)?$result:array();
	}
	
	/**
	 *
	 * 获取模块所有菜单
	 * @param  $moduleid 模块id
	 */
	function listSubMenu($moduleid)
	{
		$result = $this->where("moduleid='{$moduleid}' and ptype=1  and status=0 ")->order("sort,id asc")->select();
	
		return isset($result)?$result:array();
	}
	
	
	/**
	 * 获取当前用户的菜单列表
	 */
	function getSubmenuList($moduleid=1,$headinfo=array())
	{
		$menulist = $this -> listSubMenu($moduleid);
		$leftMenu = array();
		$link = "";
		foreach ($menulist as $row)
		{
			if ($headinfo['roleid']==1 || in_array($row['id'],$headinfo['mypermissionid']))
			{
				if ($row['parentid']==$moduleid) {
					$leftMenu[$row['id']] = $row;
				} else {
					//复数子菜单
					if ($headinfo['roleid']==1 || in_array($row['id'],$headinfo['mypermissionid']))
					{
						if ($row['flag']==1)
						{
							$link = $row['link'];
						}else 
						{
							$appdir = isset($row['appdirectory'])&&!empty($row['appdirectory'])?$row['appdirectory']:APPNAME;
						    $link = HOST_NAME.$appdir."/{$row['module']}/{$row['controller']}/{$row['actionname']}";
						}
						if (isset($row['data']) && !empty($row['data']))
						{
							$link .= "/{$row['data']}";
						}
						$row['linkURL'] = $link;
						$leftMenu[$row['parentid']]['menuchild'][] = $row;
					}
				}
			}
		}
	
		return $leftMenu;
	}
	
	
	/**
	 * 获取当前用户菜单列表中第一个三级菜单
	 */
	
	function getDefSubmenu($moduleid=1,$headinfo=array())
	{
	
		$menulist = $this->getSubmenuList($moduleid,$headinfo);
		$menuarr  = array_slice($menulist,0,1);
		$defmenu = @$menuarr[0]['menuchild'][0];
	
		return $defmenu;
	}
	
	/**
	 *
	 * 获取当前位置
	 * @param  $menuid 菜单id
	 */
	function getPos($menuid=0)
	{
		$row = $this->where("id = {$menuid}")->getOne();
		$str = '';
		if($row['parentid']) {
			$str = $this -> getPos($row['parentid']);
		} elseif ($row['moduleid']) {
			$str = $this -> getPos($row['moduleid']);
		}
		$str .= '<span>'.$row['name'].'</span> -> ';
		return $str;
	}
	
	/**
	 *
	 * 获取模块所有子节点
	 * @param  $moduleid 模块id
	 */
	function getAllSub($moduleid)
	{
		$result = $this->where("moduleid='{$moduleid}' and status=0 ")->order("sort,id asc")->select();
	
		return isset($result)?$result:array();
	}
	
	
	
	function getChild($myid,$arr=array())
	{
		$newarr=array();
		if (is_array($arr))
		{
			foreach ($arr as $row)
			{
				if ($row['parentid'] == $myid)
				{
					$newarr[] = $row;
				}
			}
		}
		return $newarr ? $newarr : false;
	}
	
	/**
	 *
	 * 获取子权限数组
	 * @param string $moduleid
	 * @return array
	 */
	function getPermissionArr($moduleid)
	{
		$arr = array();
		$allsub =  $this->getAllSub($moduleid);
		$child = $this->getChild($moduleid, $allsub);
		if (is_array($child))
		{
			foreach ($child as $key=>$val)
			{
				$arr[$key] = $val;
				$child2 = $this->getChild($val['id'], $allsub);
				if ($child2)
				{
					$arr[$key]['children'] = $child2;
					foreach ($child2 as $key2=>$val2)
					{
						$child3 = $this->getChild($val2['id'], $allsub);
						if ($child3)
						{
							$arr[$key]['children'][$key2]['children'] = $child3;
						}
					}
				}
			}
		}
		return $arr;
	
	}
	
	
	/**
	 * 获取权限列表，生成缓存
	 */
	public function getPermissionList()
	{
		$result = $this->findAll(array('status'=>0));
		foreach ($result as $row)
		{
			$permissionlist[$row['id']] = $row['link'];
		}

		set_cache('permission', $permissionlist,'common');
		return $permissionlist;
	}
	
	/**
	 * 获取所有快捷操作
	 */
	public function getShortCutList()
	{
		$result = $this->findAll(array('status'=>0,'shortcut'=>1));

		return $result;
	}
	
	
	
	
}