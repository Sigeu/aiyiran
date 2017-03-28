<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CategoryModel.php
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class UserModel extends Model
{
	public $tableName = 'member';

	/**检查是否登录成功
	**/
	public function checkLogin($username,$password)
	{
	    $result = $this->where(array('username'=>$username,'password'=>$password))->getOne();
		if(!empty($result))
		{
			Session::set('username',$username);
			Session::set('uid',$result['id']);
			Session::set('info',$result);
			return true;
		}
		else
		{
			return false;
		}
	}

	/**获取分组信息
	**/
	public function getGruopInfo($groupid)
	{
	    $result = M('member_group')->where(array('id'=>$groupid))->getOne();
		return $result;
	}
    

	/**获取注册时的默认级别信息
	**/
	public function getLevelIdByGroup($groupid)
	{
	    $result = M('member_level')->where(array('groupid'=>$groupid,'status'=>1))->getOne();
		return $result;
	}

    /**获取注册时的状态:并发送激活按钮
	**/
	public function getStatusByGroup($groupid)
	{
	    $groupInfo = $this->getGruopInfo($groupid);
		if($groupInfo['mailverify'])
		{
			return '2';
		}
		else if($groupInfo['regverify'])
		{
			return '3';
		}
		else
		{
			return '1';
		}
		
	}

	  /**获取会员主表表单的附表
	**/
	public function getTableName($modelid)
	{
	    $modelInfo = M('mix_model')->where(array('id'=>$modelid))->getOne();
		return $modelInfo['tablename'];
		
	}

  /**记录登录失败次数
	**/
	public function faillogin($username)
	{
	    $info = M('faillogin')->where(array('username'=>$username,'ip'=>get_client_ip()))->getOne();
		if(empty($info))
		{
			M('faillogin')->create(array('username'=>$username,'ip'=>get_client_ip(),'num'=>1,'logintime'=>time()));
			return array('num'=>1,'logintime'=>time());
		}
		else
		{
			M('faillogin')->update(array('username'=>$username,'ip'=>get_client_ip()),array('addition'=>'num=num+1','logintime'=>time()));
			$num = M('faillogin')->where(array('username'=>$username,'ip'=>get_client_ip()))->getOne();
			return array('num'=>$num['num'],'logintime'=>$num['logintime']);
		}
		return true;
		
	}
	
	
}