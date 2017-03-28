<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AjaxController.php
 *
 * ajax验证页面
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-28 下午3:34:23
 * @filename   AjaxController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class AjaxController extends Controller
{
	/**
	 * 会员分组-级别  级联菜单
	 */
	public function levelAction()
	{
		$parentid = $_POST['id'];
		$datas = isset($_POST['datas']) ? trim($_POST['datas']) : '';
		$objLevel = D('MemberLevel','members');
		$str = "<option value=''>请选择会员级别</option>";
		if($parentid != ''){
			$level = $objLevel->getLevelListByGroupId($parentid);
			foreach($level as $row){
			    $str .=  '<option value="'.$row['id'].'"';
			    if (isset($datas) && !empty($datas) && $row['id']==$datas)
			    {
			    	$str .= ' selected ';
			    }
			    $str .= '>'.$row['levelname'].'</option>';
			}
		}
		echo $str;exit;

	}

	/**
	 * 会员分组名称校验
	 */
	public function chkgroupnameAction()
	{
		$data = 0;
		$objGroup = M('MemberGroup');
		$groupname = $_GET['groupname'];
		$groupname_old = isset($_POST['oldvalue'])?$_POST['oldvalue']:"";

		$result = $objGroup->where(array('groupname'=>$groupname))->select();
		if (isset($groupname_old) && $groupname==$groupname_old)
		{
			$data = 1;
		}else 
		{
			if (isset($result)&& !empty($result))
			{
				$data = 2;   //会员组名已存在
			}else
			{
				$data = 1;   //会员组名可以注册
			}
		}

		echo $data;
	}

	/**
	 * 会员级别名称校验（统一会员分组下级别名称不能重复）
	 */
	public function chklevelnameAction()
	{
		$data = 0;
		$objLevel  = M('MemberLevel');
		$levelname = $_GET['levelname'];
		$groupid   = $_GET['groupid'];
		$levelname_old  = isset($_POST['oldvalue'])?$_POST['oldvalue']:"";

		$result = $objLevel->where(array('groupid'=>$groupid,'levelname'=>$levelname))->select();
		if (isset($levelname_old) && $levelname==$levelname_old)
		{
			$data = 1;
		}else
		{
			if (isset($result)&& !empty($result))
			{
				$data = 2;   //同一会员组名下该级别已存在
			}else
			{
				$data = 1;   //该级别可以注册
			}
			
		}
		
		echo $data;
	}

	/**
	 * 用户称校验（所有用户的用户名均不能重复包含前台注册用户、后台管理员、不同系统用户）
	 * @author wr 2013-03-29
	 */
	public function checkusernameAction()
	{
		include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");
		$client = new HproseHttpClient(HOST_NAME."imc/api/server.php");
		
		$data = 0;
		$username = $_GET['username'];
		$result = $client->checkuser($username);
		
		if (isset($result)&& !empty($result))
		{
			$data = 2;   //用户名已存在
		}else
		{
			$data = 1;   //用户名可以注册、添加
		}

		echo $data;
	}


	/**
	 * 角色名称校验
	 */
	public function checkrolenameAction()
	{
		$data = 0;
		$objRole  = M('AdminRole');
		$rolename = $_GET['rolename'];
		$rolename_old = isset($_POST['oldvalue'])?$_POST['oldvalue']:"";
		
		$result = $objRole->where(array('rolename'=>$rolename))->select();
		
		if (isset($rolename_old) && $rolename==$rolename_old)
		{
			$data = 1;
		}else
		{
			if (isset($result)&& !empty($result))
			{
				$data = 2;   //角色名已存在
			}else
			{
				$data = 1;   //该角色可以添加
			}
		}
	
		echo $data;
	}
	
	/**
	 * 使用技巧
	 */
	public function cmstipAction()
	{
		$objMaintable = M("Maintable");
		$result = $objMaintable->findAll(array('categoryid'=>'14'),'publishtime desc','id,title',4);
		$url = HOST_NAME."category/Category/list/cid/";
		$urlArr = array();
		foreach ($result as $row)
		{
			$row['link'] = $url.$row['id'];
			$urlArr[] = $row;
		}
		$jsonStr = json_encode($urlArr);
		echo $jsonStr;
	}

































}