<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ImcController.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-3-12 下午3:38:20
 * @filename   ImcController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 class ImcController extends AdminController
 {

 	public function indexAction()
 	{
 		$pageinfo    = array();
 		$shortcut    = array();
 		$topmenu_str = '';
 		$objRole     = D('Role','webset');
 		$objPM       = D("Permission",'webset');
		$objAdminShortcut = M('AdminShortcut');

 		//用户信息
		$userinfo = isset($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
		$mypermissionid = isset($_SESSION['mypermissionid'])?$_SESSION['mypermissionid']:array();
 		if (!$userinfo)
 		{
 			$this->redirect($this->createUrl('admin/login/index'));
 			exit;
 		}

 		$rolelist = get_cache('role','common');
 		if (empty($rolelist))
 		{
 			$rolelist = $objRole->getRoleCacheList();
 		}
 		$roleid = $userinfo['roleid'];
 		$rolename = $rolelist[$roleid];


 		//一级导航

 		$topmenu_str .= "<li><a href=\"{$this->baseurl}/admin/index\" >后台首页</a></li>";
 		$topmenu = $objPM->listAllTopMenu();

 		foreach ($topmenu as $row)
 		{
 			if ($roleid==1 || in_array($row['id'], $mypermissionid))
 			{
 				$topmenu_str .= "<li><a id=\"_M{$row['id']}\" href=\"javascript:_MM({$row['id']})\" class=\"\">{$row['name']}</a></li>";
 			}else
 			{
 				$topmenu_str .= "<li><a href=\"javascript:alert('没有权限！');\">{$row['name']}</a></li>";
 			}
 		}
    	$topmenu_str .= "<li><a href=\"{$this->baseurl}/admin/imc/index\" class=\"focus\">IMCenter</a></li>";

 		//常用操作
 		$myshortcut = $objAdminShortcut->findAll(array('userid'=>$userinfo['id']));
 		$k = array();
 		if ($myshortcut)
 		{
 			foreach ($myshortcut as $t)
 			{
 				$link = "";
 				$k = $objPM->find(array('id'=>$t['permissionid']));
				if ($k['flag']==1)
				{
					$link = $k['link'];
				}else 
				{
					$appdir = isset($row['appdirectory'])&&!empty($row['appdirectory'])?$row['appdirectory']:APPNAME;
				    $link = HOST_NAME.$appdir."/{$k['module']}/{$k['controller']}/{$k['actionname']}";
				}
				if (isset($k['data']) && !empty($k['data']))
				{
					$link .= "?{$k['data']}";
				}
				$k['linkURL'] = $link;
				$shortcut[] = $k;
 			}
 		}
 		$pageinfo['shortcut'] = $shortcut;

 		$pageinfo['userid']   = $userinfo['id'];
 		$pageinfo['username'] = $userinfo['username'];
 		$pageinfo['rolename'] = $rolename;
 		$pageinfo['roleid']   = $userinfo['roleid'];
 		$pageinfo['defRightUrl']   = HOST_NAME."imc/members/member/index";


 		$this->assign('pageInfo',$pageinfo);
 		$this->assign('topMenuStr',$topmenu_str);
 		$this->assign('url_imc',HOST_NAME."imc");
 		$this->display('admin/imc/index');
 	}


 }