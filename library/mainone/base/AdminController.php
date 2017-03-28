<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台控制器基类
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-11 下午6:11:26 创建此文件
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-11 下午6:11:26
 * @filename   Controller.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: AdminController.php 4739 2014-10-11 06:00:48Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) exit('Deny access');

abstract class AdminController extends Controller
{
	public $baseurl = '';

	/**
	 * 后台基控制器初始化方法
	 */
	public function baseInit()
	{
		$this->initView();
		$this->baseurl = HOST_NAME.APPNAME;
        $this->assign('baseurl',$this->baseurl);
        $this->assign('hostname',HOST_NAME);
        $this->assign('jspath', HOST_NAME.'static/js');
        $this->assign('csspath',$this->baseurl.'/template/css');
        $this->assign('imgpath',$this->baseurl.'/template/images');
        $this->assign('uploadpath',$this -> getUploadHttpUrl());
        if (!session_id())
        {
        	session_start();
        }
        /*验证当前域名*/
        //$this->checkDomain();
        
        $this->SecurityFilters();
        $this->islogin();
		$this -> init();
	}

	/**
	 * 初始化视图
	 * @return null
	 */
	protected function initView()
	{
		self::$_view = $this->venderModule('smarty');
		//注册函数到smarty
		//self::$_view->register_function('powerbyIzhanExt',"powerbyIzhan");
	}

	/*判断是否需要监控*/
	public function official()
	{
		$offinfo = get_cache('official','common');
		if(isset($offinfo[HOST_NAME]))
		{
			$timed = time()-$offinfo[HOST_NAME];
			if($timed >= 3600*24*30*3) //默认每三个月检查一次
			{
				//调用接口
				 $this->officialStart();
			    //并更新时间
			}
		}
		else
		{
			//调用接口
			//并更新时间
			$this->officialStart();
		}
	}
	/*开始检测*/
	public function officialStart()
	{
		$domainname	= HOST_NAME;
		$ip = urlencode(get_client_ip());
		$product = urlencode('铭万内容管理系统');
		$version =urlencode(get_config('version','mo_version'));
		$domainname = urlencode($_SERVER['SERVER_NAME']);
		require_once "../imc_client/api/imc_client.php";
		$client = new Client();
		$flag = $client->imc_post('http://www.izhancms.com/official/os/os/index/product/'.$product."/ip/{$ip}/version/{$version}/domainname/{$domainname}",3,"&1=1");
		$offinfo = get_cache('official','common');
		$offinfo[HOST_NAME] = time();
		set_cache('official',$offinfo,'common');
	}

	/**
	 * 提示框
	 * @param $url string  //点击确定后转向的地址                 必填项
	 * @param $url string  //在提示框中出现的提示字符，      默认为“操作成功”
	 * @param $type string  //区别是成功类型还是失败类型    成功：success;错误：error; 信息：info; 默认为 （success）
	 */
    public function dialog($url,$type='success',$str='操作成功'){

    	$param['url'] = $url;
    	$param['str'] = $str;
    	$param['type'] = $type ? $type:'success';

    	$this->assign('param',$param);
    	$this->display('public/prompt');
		exit();//防止继续执行
    }



	/**
	 * 引入模板风格配置文件
	 * @param string $style
	 * @param boolen ture:返回成功与失败，false：返回路径
	 */

	function import_style_config($style = 'default',$flag = true)
	{
		return $flag ? include getDirView().$style.DIRECTORY_SEPARATOR.'config.php' :  getDirView().$style.DIRECTORY_SEPARATOR.'config.php';
	}


	/**
	 * 引入标签配置文件
	 * @param boolen ture:返回成功与失败，false：返回路径
	 */

	function import_tag_config($flag = true)
	{
		return $flag ? include DIR_TAG.'config'.DIRECTORY_SEPARATOR.'config.php' :  DIR_TAG.'config'.DIRECTORY_SEPARATOR.'config.php' ;
	}



	/**
	 * 获取操作的id值（包括单项和批量操作）
	 * @param string $item checkbox的name
	 * @return string  id字符串
	 */
	public function getIds($item)
	{
		$id = "";
		$items = $this->getParams($item);
		if ($items)
		{
		    if (is_array($items))
		    {
			    $id = implode(",", $items);
		    }else
		    {
			    $id = $items;
		    }
		}
		return $id;
	}

	/**
	 * 获取前台模板目录
	 */
	public function getHomeStyleDir ()
	{
		$home_tpl_dir = getDirView();
		$home_tpl_style = get_cache('template_style','common','home');
		$home_tpl_style = $home_tpl_style ? $home_tpl_style : DEFAULT_STYLE;
		return $home_tpl_dir.$home_tpl_style;
	}

	/**
	 * 获取上传目录的超链接Url
	 */
	public function getUploadHttpUrl ()
	{
		return HOST_NAME.'static'.'/'.'uploadfile';
	}
	/**
	 * 获取默认属性对应的值
	 */
	public function getDefineArr(){

		$arr['type'] =array(
			 'text'=>'单行文本',
			 'textarea'=>'多行文本',
			 'editor'=>'HTML文本',
			 'image'=>'图片上传',
			 'images'=>'多图上传',
			 'linkage'=>'联动类型 ',
			 'checkbox'=>'多选框',
			 'files'=>'多附件',
			 'radio'=>'单选框',
			 'float'=>'小数',
			 'int'=>'整数 ',
			 'file'=>'附件',
			 'datetime'=>'时间与日期',
			 'select'=>'下拉框',

			);

	    $arr['reg']=array(
	    		  1=>array('text'=>'数字','val'=>'/^([+-]?)\d*\.?\d+$/'),
	    		  2=>array('text'=>'整数','val'=>'/^-?[1-9]+\d*$/'),
	    		  3=>array('text'=>'字母','val'=>'/^[A-Za-z]+$/'),
	    		  4=>array('text'=>'数字+字母','val'=>'/^[A-Za-z0-9]+$/'),
	    		  5=>array('text'=>'E-mail','val'=>'/^\w+((-\w+)|(.w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/'),
	    		  6=>array('text'=>'超级链接','val'=>'/^http[s]?:\/\/([\w-]+\.)+[\w-]+([\w-./?%&=]*)?$/'),
	    		  7=>array('text'=>'手机号码','val'=>'/^(13|15|18)[0-9]{9}$/'),
	    		  8=>array('text'=>'电话号码','val'=>'/^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/'),
	    		  9=>array('text'=>'邮政编码','val'=>'/^\d{6}$/'),
	    		  10=>array('text'=>'身份证号','val'=>'/^[1-9]([0-9]{14}|[0-9]{17})$/'),
	    		  );

	   return $arr;
	}

	/**
	 * 系统安检
	 * Security Filters
	 */
	public function SecurityFilters(){
		//获得操作URI
		$http = (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!='off')?'https://':'http://';
		$servername = $_SERVER["SERVER_NAME"];
		$port = $_SERVER["SERVER_PORT"]==80?'':':'.$_SERVER["SERVER_PORT"];
		$url = $http.$servername.$port.$_SERVER["REQUEST_URI"];
		$uri = $_SERVER["REQUEST_URI"];//操作动作

	    //核对权限
		$stra = explode('/', $this->getSelfUrl());

		$roleid = "";
		if(isset($_SESSION['roleid'])){
			$roleid=$_SESSION['roleid'];
		}
		else
		{
			$roleid = "";
		}

		if($roleid==1)
		{
			return true;
		}
		else
		{
			$arrayurl = explode('/', $this->getSelfUrl());

			$module=$arrayurl[count($stra)-3];
			$controller=$arrayurl[count($stra)-2];
			$action=$arrayurl[count($stra)-1];
			$parameter="";
			if(!empty($_POST)||!empty($_GET))
			{
			  $parameter=$this->getParams('addparameter');
			}
            $url="/".$module."/".$controller."/".$action;
		   $allLinks = array();
           if(isset($_SESSION['alllinks'])){
           	 $allLinks=$_SESSION['alllinks'];
           }
           else
           {
           	 $allLinks = array();
           }
			if(!in_array($url, $allLinks))
			{
				return true;
			}
			else
			{

				$myLinks=$_SESSION['mylinks'];
				if(!in_array($url, $myLinks))
				{
					$this->goback("对不起，您没有此操作权限！",true);
					exit;
				}
				else
				{
					return true;
				}
			}

		}
	}

	public function get_path_info()
	{
		if( !array_key_exists('PATH_INFO', $_SERVER) )
		{
			$pos = strpos($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);
			$asd = substr($_SERVER['REQUEST_URI'], 0, $pos - 2);
			$asd = substr($asd, strlen($_SERVER['SCRIPT_NAME']) + 2);
			return $pos;
		}
		else
		{
			return trim($_SERVER['PATH_INFO'], '/');
		}
	}

	/**
	 * 判断用户是否登录
	 */
	public function islogin()
	{
		$module     = app::getModuleName();
		$controller = app::getControllerName();
		$action     = app::getActionName();
		$pathinfo   = "/".$module."/".$controller."/".$action;
		//不需要判断登录的页面
		$arr = array("/admin/login/index",
				     "/admin/index/index",
				     "/admin/login/checklogin",
				     "/admin/index/leftmenu",
				     "/admin/index/currentpos",
				     "/dialog/upload/upload",
				     "/modules/admanage/beitou",
				     "/modules/message/checkUnique",
					"/admin/authcode/index",
					"/os/adserving/ipush",
                    "/os/announce/showjson",
                    "/admin/login/checkuser",
                    "/admin/login/findpwd",
                    "/extensions/mobilesite/choseurl",
				    );
// 	   if (($pathinfo !="/admin/login/index") && ($pathinfo !="/admin/index/index") && ($pathinfo !="/admin/login/checklogin") && ($pathinfo !="/admin/index/leftmenu") && ($pathinfo !="/admin/index/currentpos") && ($pathinfo !="/dialog/upload/upload") && ($pathinfo !="/modules/admanage/beitou"))
	   if (!in_array($pathinfo, $arr))
	   {
	   		if (!isset($_SESSION['userid']) || !isset($_SESSION['roleid']) || !$_SESSION['userid'] || !$_SESSION['roleid'])
	   		{
	   			echo "<script>alert('登录超时，请重新登录');top.location='/admin/admin/login/index'</script>";
	   		}
	   }
	}

	/**
	 * IMC管理员是否登录
	 * @author wr 2013.5.6
	 */
	public function islogin_imc()
	{
	    $imcuserinfo = isset($_SESSION['userinfo_imc'])?$_SESSION['userinfo_imc']:array();
		if (!$imcuserinfo)
		{
			$this->redirect($this->createUrl('index/index/loginimc'));
			exit;
		}

	}

	/**
	 * IMC管理员退出
	 * @author wr 2013.5.6
	 */
	public function loginout_imc()
	{
		$appname = APPNAME;
	    if (isset($appname) && $appname!='imc')
	    {
	    	Session::delete("userinfo_imc");
	    }
	}
    
    protected function getAllowType ($type=1)
	{
		$allow_type = D('SystemModel','webset','admin') -> getConfigByKey(array('mo_picturetype','mo_filetype','mo_mediatype'));
		switch ($type)
		{
			case '2'://flash
				$allow_type = array('swf');
				break;
			case '3'://音频视屏
				$allow_type = explode('|',$allow_type['mo_mediatype']);
				break;
			case '4'://其他
				$allow_type = explode('|',$allow_type['mo_filetype']);
				break;
			default://图片
				$allow_type = explode('|',$allow_type['mo_picturetype']);
		}
		return $allow_type;
	}
    
    /**
	 * 判断用户当前域名是否合法
	 */
	public function checkDomain()
	{
        $module     = app::getModuleName();
        $controller = app::getControllerName();
        $action     = app::getActionName();
        $pathinfo   = "/".$module."/".$controller."/".$action;
        $server = $_SERVER['SERVER_NAME'];
        $domain = get_key('domain');
        if (empty($domain) || !in_array($server, $domain)) {
            //域名不对
            unset($_SESSION);
            session_destroy();
            if ($pathinfo == '/admin/login/checklogin') {
                echo 5;
                exit;
            }
        }
	}
}