<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 控制器基类
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-11 下午6:11:26 创建此文件
 * <br>周立峰  2012-12-11 下午6:11:26 修改此文件 添加了某某功能
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-11 下午6:11:26
 * @filename   Controller.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: HomeController.php 607 2013-11-11 09:45:18Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) exit('Deny access');
abstract class HomeController extends Controller
{
    static protected $_style;
	/**
	 * 后台基控制器初始化方法
	 */
	public function baseInit()
	{
		$this->initView();
		$this->setpath();
		$this->setvar();
		$this->blackIP();
		$this->shut_down();
		$this -> init();
		$this->getUserInfo(); //获取用户信息
	}

	/**
	 * 初始化视图
	 *
	 * @return null
	 */
	protected function initView()
	{
		app::loadFile(DIR_BF_ROOT.'base'.DIRECTORY_SEPARATOR.'Template.php');
		self::$_view = Template::getInstance();
        self::$_style = self::$_view -> getStyle();
	}

	/**
	 * 设置网站关闭
	 */
	public function shut_down()
	{
		if(get_mo_config('mo_shut_down') == 'Y')
		{
			$reson = get_mo_config('mo_shut_reason') ? get_mo_config('mo_shut_reason') : '网站关闭中....';
			exit($reson);
		}
	}

	/**
	 * 定义网站资源访问路径
	 */
	public function setpath()
	{
		define('JS_PATH',    HOST_NAME.'template/'.self::$_style.'/js');
		define('CSS_PATH',   HOST_NAME.'template/'.self::$_style.'/css');
		define('IMG_PATH',   HOST_NAME.'template/'.self::$_style.'/images');
		define('UPLOAD_PATH',HOST_NAME.'static/uploadfile');
		define('PUBLIC_JS_PATH',HOST_NAME.'static/js');
	}

	/**
	 * 设置全局变量：模板调用为:{CSS_PATH}.....
	 */
	public function setvar()
	{
		define('CHAR_SET',get_config('common','char_set'));
		//初始化会员信息，测试用
		session_start();
		$GLOBALS['username'] = Session::get('username');
		$GLOBALS['cookieUsername'] = Cookie::get('cookieUsername');
        $GLOBALS['is_mobile_scan'] = is_mobile();
        //手机站是否开通
        $base_set = M('MobileWebset')->getOne();
        $is_open = 0;
        if (isset($base_set['is_open']) && !empty($base_set['is_open'])) {
            $is_open = 1;
        }
        $GLOBALS['is_mobile_open'] = $is_open;
	}

	/**
	 * 渲染模板
	 */
	function display($template="index")
	{
		return parent::display($template);
	}

    /**
	 * 提示框
	 * @param $url string  //点击确定后转向的地址                 必填项
	 * @param $url string  //在提示框中出现的提示字符，      默认为“操作成功”
	 * @param $type string  //区别是成功类型还是失败类型    成功：success;错误：error; 信息：info; 默认为 （success）
	 */
    public function mydialog($url,$type='success',$str='操作成功')
    {
    	$param['url'] = $url;
    	$param['str'] = $str;
    	$param['type'] = $type;
		include $this->display('dialog.html');
		exit();//防止继续执行
    }
    
    
    
    public function artdialog($url,$info='操作成功',$okval="确定",$type='success')
    {
    	$url = ($url=='')?'javascript:history.back()':$url;
    	$param['url'] = $url;
    	$param['info'] = $info;
    	$param['type'] = $type;
    	$param['okval'] = $okval;
		include $this->display('dialog.html');
		exit();//防止继续执行
    }

	/*IP黑名单*/
	function blackIP()
	{
		$ip = get_client_ip();
		$type = get_mo_config('mo_ip_forbid');

		if($type =='Y')
		{
			$ips = get_mo_config('mo_forbidden_area');
			$start = get_mo_config('mo_forbidden_start');
			$end = get_mo_config('mo_forbidden_end');
			$ipArr = explode(",",$ips);
			$startnum = substr($start,strrpos($start,'.')+1);//截取网段
			$endnum = substr($end,strrpos($end,'.')+1);//截取网段
			$yell = substr($ip,strrpos($ip,'.')+1);          //获取用户IP末位
  			//$ipnum = substr($ip,0,strrpos($ip,'.')+1);//截取网段
			$some_ip = substr($ip,0,strrpos($ip,'.'));//截取网段
			$some_start = substr($start,0,strrpos($start,'.'));//截取网段

			if(in_array($ip,$ipArr))
			{
				exit("你已经被此网站拉黑!");
			}
			elseif($yell>= $startnum AND $yell <= $endnum AND strcmp($some_ip,$some_start)==0)
			{
				exit("你已经被此网站拉黑!");
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}

	/*搜索时间间隔*/
	function searchDis()
	{
		if($isset($search_info[get_client_ip()])&&time()-$search_info[get_client_ip()]<=get_mo_config('mo_search_time'))
		{
			$_GLOBAL['searchDisabled'] = true;
			//goback('搜索间隔太短，请稍后搜索',true );
			//echo "<script>alert('搜索间隔太短，请稍后搜索');window.top.opener = null;window.close(); </script>";
		}
		else
		{
		    set_cache('search_info',array(get_client_ip()=>time()),'common');
		}

	}

	//获取用户信息
	function getUserInfo()
	{
       return $info_inc = M('member')->where(array('id'=>65))->getOne();
	}
}