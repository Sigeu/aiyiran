<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 核心类,并初始化框架的基本设置
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-11 下午6:03:47 创建此文件
 * <br>雷少进  2013-07-04 下午5:03:47 修改此文件 统一定义了目录访问和超链访问
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-11 下午6:03:47
 * @filename   Application.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: Application.php 1186 2014-01-14 08:07:13Z guanyang $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone
 * @since      1.0.0
 */

define('PATH_MAINONE'       ,dirname(__FILE__) . DIRECTORY_SEPARATOR);         // D:\server\www\mocms\library\mainone\
define('PATH_WEB'           ,dirname(dirname(PATH_MAINONE)).DIRECTORY_SEPARATOR);   // D:\server\www\mocms\

//网站目录下定义
define('PATH_ADMIN'         ,PATH_WEB.'admin'.DIRECTORY_SEPARATOR);
define('PATH_APPLICATION'   ,PATH_WEB.'application'.DIRECTORY_SEPARATOR);
define('PATH_DATA'          ,PATH_WEB.'data'.DIRECTORY_SEPARATOR);
define('PATH_DOC'           ,PATH_WEB.'doc'.DIRECTORY_SEPARATOR);
define('PATH_HTML'          ,PATH_WEB.'html'.DIRECTORY_SEPARATOR);
define('PATH_IMC'           ,PATH_WEB.'imc'.DIRECTORY_SEPARATOR);
define('PATH_IMC_CLIENT'    ,PATH_WEB.'imc_client'.DIRECTORY_SEPARATOR);
define('PATH_LIBRARY'       ,PATH_WEB.'library'.DIRECTORY_SEPARATOR);
define('PATH_OFFICIAL'      ,PATH_WEB.'official'.DIRECTORY_SEPARATOR);
define('PATH_STATIC'        ,PATH_WEB.'static'.DIRECTORY_SEPARATOR);
define('PATH_TEMPLATE'      ,PATH_WEB.'template'.DIRECTORY_SEPARATOR);
define('PATH_VENDOR'        ,PATH_WEB.'vendor'.DIRECTORY_SEPARATOR);
define('PATH_STATIC_UPLOAD' ,PATH_STATIC.'uploadfile'.DIRECTORY_SEPARATOR);
define('PATH_RUN_FOLDER'    ,app::findRunFolder());//寻找网站运行目录，因为网站可能在二级目录下运行

//超链访问定义
define('URL_PROTOCOL'       ,isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
define('URL_HOST'           ,URL_PROTOCOL.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'].'/'.PATH_RUN_FOLDER : ''));
define('URL_BASE'           ,ltrim(str_replace('\\','/',$_SERVER['SCRIPT_NAME'].'/'),'/'));
define('URL_ENTRY'          ,URL_HOST.URL_BASE);
define('URL_ADMIN_TPL'      ,URL_HOST.'admin/template/');
define('URL_TPL'            ,URL_HOST.'template/');
define('URL_HTML'           ,URL_HOST.'html/');
define('URL_STATIC'         ,URL_HOST.'static/');
define('URL_STATIC_UPLOAD'  ,URL_HOST.'static/uploadfile/');

if (!defined('IN_MAINONE')) {
    exit();
}

/**
 * 定义错误提示级别
 */
defined('SYS_DEBUG') && SYS_DEBUG ? error_reporting(E_ALL):error_reporting(0);

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);//调用此框架前需要先定义常量: 定义临街符.

if (!defined('DIR_BF_ROOT')) define('DIR_BF_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);//定义框架文件所在路径

if (!defined('DIR_SMARTY')) define('DIR_SMARTY', DIR_ROOT . 'vendor/smarty' . DIRECTORY_SEPARATOR);//定义Smarty框架文件所在路径

if (!defined('DIR_CONTROLLER')) define('DIR_CONTROLLER', DIR_ROOT . 'application' . DIRECTORY_SEPARATOR);//项目controller目录的路径

if (!defined('DIR_MODEL')) define('DIR_MODEL', DIR_ROOT . 'application' . DIRECTORY_SEPARATOR);//项目model目录的路径

if (!defined('DIR_VIEW')) define('DIR_VIEW', (APPNAME === 'home')? DIR_ROOT . 'template'. DS: DIR_ROOT .'template' . DS);

if (!defined('DIR_CONFIG')) define('DIR_CONFIG', DIR_ROOT . 'application'.DS.'config' . DIRECTORY_SEPARATOR);//项目config目录的路径

if (!defined('DIR_WIDGET')) define('DIR_WIDGET', DIR_ROOT . 'application' . DIRECTORY_SEPARATOR);//项目widget目录的路径

if (!defined('DIR_DATA')) define('DIR_DATA', DIR_ROOT . 'data'.DS);//项目数据文件存放目录的路径

if (!defined('DIR_CACHE')) define('DIR_CACHE', DIR_ROOT . 'data'.DS.'cache' . DIRECTORY_SEPARATOR);//项目缓存文件存放目录的路径

if (!defined('DIR_LOG')) define('DIR_LOG', DIR_ROOT . 'logs' . DIRECTORY_SEPARATOR);//项目运行日志文件存放目录的路径

if (!defined('DIR_MODULE')) define('DIR_MODULE', DIR_ROOT . 'modules' . DIRECTORY_SEPARATOR);//项目扩展模块目录的路径

if (!defined('DIR_THEME')) define('DIR_THEME', DIR_ROOT . 'themes' . DIRECTORY_SEPARATOR);//模板根目录

if (!defined('DIR_TAG')) define('DIR_TAG', DIR_BF_ROOT . 'taglib' .DIRECTORY_SEPARATOR);//模板根目录

if (!defined('DIR_LANGUAGE')) define('DIR_LANGUAGE', DIR_ROOT . 'application/language' . DIRECTORY_SEPARATOR);//项目语言包文件存放目录的路径




/**
 * 设置是否开启调试模式.开启后,程序运行出现错误时,显示错误信息,便于程序调试.
 * 默认为关闭,如需开启,将下面的false改为true.
 */
if (!defined('SYS_DEBUG')) {
    define('SYS_DEBUG', false);
}

/**
 * 设置URL的Rewrite功能是否开启,如开启后,需WEB服务器软件如:apache或nginx等,要开启Rewrite功能.
 * 默认为关闭,如需开启,只需将false换成true.
 */
if (!defined('SYS_REWRITE')) {
    define('SYS_REWRITE', false);
}

/**
 * 设置日志写入功能是否开启
 * 默认为开启,如需关闭,只需将true换成false.
 */
if (!defined('CMS_LOG')) {
    define('CMS_LOG', true);
}

/**
 * 设置时区,默认时区为东八区(中国)时区.
 * 如需更改时区,将'Asia/ShangHai'设置你所需要的时区.
 */
if (!defined('CMS_TIMEZONE')) {
    define('CMS_TIMEZONE', 'Etc/GMT-8');
}

/**
 * 设置系统默认的module名称,默认为:Index
 * 如需更改,将Index换成所需要的.
 * 注:为提高不同系统平台的兼容性,名称首字母要大写,其余小写.
 */
if (!defined('DEFAULT_MODULE')) {
	define('DEFAULT_MODULE', 'index');
}

/**
 * 设置系统默认的controller名称,默认为:Index
 * 如需更改,将Index换成所需要的.
 * 注:为提高不同系统平台的兼容性,名称首字母要大写,其余小写.
 */
if (!defined('DEFAULT_CONTROLLER')) {
    define('DEFAULT_CONTROLLER', 'Index');
}

/**
 *设置 系统默认的action名称,默认为index
 *如需更改,将index换成所需名称.
 *注:名称要全部使用小写字母.
 */
if (!defined('DEFAULT_ACTION')) {
    define('DEFAULT_ACTION', 'index');
}

/**
 * 定义网址路由的分割符
 * 注：分割符不要与其它网址参数等数据相冲突
 */
if (!defined('URL_SEGEMENTATION')) {
    define('URL_SEGEMENTATION', '/');
}

/**
 * 定义路由网址的伪静态网址的后缀
 * 注：不要忘记了.(点)
 */
if (!defined('URL_SUFFIX')) {
    define('URL_SUFFIX', '.html');
}

/**
 * 定义自定义URL路由规则开关
 */
if (!defined('CUSTOM_URL_ROUTER')) {
    define('CUSTOM_URL_ROUTER', false);
}

/**
 * 定义入口文件名
 */
if (!defined('ENTRY_SCRIPT_NAME')) {
    define('ENTRY_SCRIPT_NAME', 'index.php');
}

/**
 * 定义是否开启视图状态 注：当为true时视图文件格式为html;反之为php
 */
if (!defined('SYS_VIEW')) {
    define('SYS_VIEW', true);
}

/**
 * 项目模板的样式：默认的为“default”
 */
if (!defined('DEFAULT_STYLE')) {
	define('DEFAULT_STYLE', "default");
}

/**
 * 网站域名
 */
define('HOST_NAME',URL_HOST);

// $cur_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
// $lib_dir = dirname($cur_dir) . DIRECTORY_SEPARATOR;
// $install_dir = dirname($lib_dir) .DIRECTORY_SEPARATOR. 'install' .DIRECTORY_SEPARATOR;
// if(is_dir($install_dir) && !is_file($lib_dir.'lock'))
// {
// 	header("Location: ".HOST_NAME."install");
// 	exit();
// }

/**
 * 为保证安全安装完成以后 重命名安装目录
 */
$cur_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$lib_dir = dirname($cur_dir) . DIRECTORY_SEPARATOR;
$root_dir = dirname($lib_dir). DIRECTORY_SEPARATOR;
if(is_dir($root_dir.'install'))
{
	$file_name = substr(md5(microtime().mt_rand(1000,9999)),0,20);
	@rename($root_dir.'install',$root_dir.'install_'.$file_name);
}

/**
 * 加载路由网址分析文件
 */
require_once DIR_BF_ROOT . 'base/Router.php';

/**
 * 加载系统工具函数文件
 */
require_once DIR_BF_ROOT . 'functions/common.php';
require_once DIR_BF_ROOT . 'functions/functions.php';
require_once DIR_BF_ROOT . 'functions/tagfun.php';
header('Content-Type: text/html; charset='.get_config('common','char_set'));
/**
 * 框架核心全局控制类
 *
 * 用于初始化程序运行及完成基本设置
 */
abstract class app
{
	/**
	 * 应用目录
	 * @var string
	 */
	public static $appname;

	/**
	 * 模块(module)
	 *
	 * @var string
	 */
	public static $module;

    /**
     * 控制器(controller)
     *
     * @var string
     */
    public static $controller;

    /**
     * 动作(action)
     *
     * @var string
     */
    public static $action;

    /**
     * 对象注册表
     *
     * @var array
     */
    public static $_objects = array();

    /**
     * 载入的文件名(用于PHP函数include所加载过的)
     *
     * @var array
     */
    public static $_incFiles = array();

    /**
     * 项目运行函数
     *
     * 供项目入口文件(index.php)所调用,用于启动框架程序运行
     * @access public
     * @return object
     */
    public static function run()
	{
        static $_app = array();//定义变量_app
        $url_params  = Router::Request();//分析URL,获取controller和action的名称
        self::$module     = $url_params['module'];
        self::$controller = $url_params['controller'];
        self::$action     = $url_params['action'];
        $appId = self::$module . '_' . self::$controller . '_' . self::$action;
        if (!isset($_app[$appId]))
		{
            //通过实例化及调用所实例化对象的方法,来完成controller中action页面的加载
            $controller = self::$controller . 'Controller';
            $action     = self::$action . 'Action';

            //加载基本文件:Base,Controller基类
            self::loadFile(DIR_BF_ROOT . 'base/Base.php');
            self::loadFile(DIR_BF_ROOT . 'base/Controller.php');
            //加载当前要运行的controller文件
			$control_file = DIR_CONTROLLER . self::$module . '/controllers/' . $controller . '.php';
            if (is_file($control_file))
			{
                self::loadFile($control_file); //当文件在controller根目录下存在时,直接加载.
            }
			else
			{
                //从controller的名称里获取子目录名称,注:controller文件的命名中下划线'_'相当于目录的'/'.
                $pos = strpos($controller, '_');
                if ($pos !== false)
				{
                    //当$controller中含有'_'字符时
                    $childDirName     = strtolower(substr($controller, 0, $pos));
                    $controllerFile   = DIR_CONTROLLER . $childDirName . '/' . $controller . '.php';

                    if (is_file($controllerFile))
					{
                        self::loadFile($controllerFile);//当子目录中所要加载的文件存在时
                    }
					else
					{
                        self::display404Error();//当文件在子目录里没有找到时
                    }
                }
				else
				{
                    self::display404Error();//当controller名称中不含有'_'字符串时
                }
            }

            $appObject = new $controller();//创建一个页面控制对象
            if (method_exists($controller, $action))
			{
                $_app[$appId] = $appObject->$action();
            }
			else
			{
                self::display404Error();//所调用方法在所实例化的对象中不存在时.
            }
        }
        return $_app[$appId];
    }

    /**
     * 显示404错误提示
     *
     * 当程序没有找到相关的页面信息时,或当前页面不存在.
     * @access public
     * @return void
     */
     static function display404Error() {

        //判断自定义404页面文件是否存在,若不存在则加载默认404页面
        is_file(DIR_VIEW . 'error/error404.html') ? self::loadFile(DIR_VIEW . 'error/error404.html') : self::loadFile(DIR_BF_ROOT . 'views/html/error404.php');
        exit();
    }


    /**
     * 获取当前运行的module名称
     *
     * @example $moduleName = app::getModuleName();
     * @access public
     * @return string module名称(字母全部小写)
     */
    public static function getModuleName() {

    	return strtolower(self::$module);
    }


    /**
     * 获取当前运行的controller名称
     *
     * @example $controllerName = app::getControllerName();
     * @access public
     * @return string controller名称(字母全部小写)
     */
    public static function getControllerName() {

        return strtolower(self::$controller);
    }

    /**
     * 获取当前运行的action名称
     *
     * @example $actionName = app::getActionName();
     * @access public
     * @return string action名称(字母全部小写)
     */
    public static function getActionName() {

        return strtolower(self::$action);
    }

    /**
     * 返回唯一的实例(单例模式)
     *
     * 程序开发中,model,module, widget, 或其它类在实例化的时候,将类名登记到注册表数组($_objects)中,当程序再次实例化时,直接从注册表数组中返回所要的对象.
     * 若在注册表数组中没有查询到相关的实例化对象,则进行实例化,并将所实例化的对象登记在注册表数组中.此功能等同于类的单例模式.
     *
     * 注:本方法只支持实例化无须参数的类.如$object = new pagelist(); 不支持实例化含有参数的.
     * 如:$object = new pgelist($total_list, $page);
     *
     * <code>
     * $object = app::singleton('pagelist');
     * </code>
     *
     * @access public
     * @param string $className  要获取的对象的类名字
     * @return object 返回对象实例
     */
    public static function singleton($className) {

        //参数分析
        if (!$className) {
            return false;
        }

        $key = trim($className);

        if (isset(self::$_objects[$key])) {
            return self::$_objects[$key];
        }

        return self::$_objects[$key] = new $className();
    }

    /**
     * 静态加载文件(相当于PHP函数require_once)
     *
     * include 以$fileName为名的php文件,如果加载了,这里将不再加载.
     * @param string $fileName 文件路径,注:含后缀名
     * @return boolean
     */
    public static function loadFile($fileName) {

        //参数分析
        if (!$fileName) {
            return false;
        }

        //判断文件有没有加载过,加载过的直接返回true
        if (!isset(self::$_incFiles[$fileName])) {

            //分析文件是不是真实存在,若文件不存在,则只能...
            if (!is_file($fileName)) {
                //当所要加载的文件不存在时,错误提示
                Controller::halt('The file:' . $fileName . ' not found!');
            }

            include_once $fileName;
            self::$_incFiles[$fileName] = true;
        }

        return self::$_incFiles[$fileName];
    }


    public static function powerby(){
    	return 'Powered by <a href="http://www.izhancms.com/">MainOne CMS</a>.';
    }

    public static function version(){
    	return '1.0.0';
    }


	/**
	 * 格式化路径 把目录分隔符统一转换为同一方向的系统分隔符
	 * 本方法只做转换，不检查目录是否存在，不转换相对路径 比如带./  ../的
	 *
	 * @param $path  要格式化的路径
	 * @param $sprit 返回值末尾是否必须带斜杠 true(返回值末尾有斜杠) false(返回值末尾不带斜杠)
	 * @return string
	 */
	public static function formatPath ($path='',$sprit=true)
	{
		$path = str_replace(array('/','\\') , DIRECTORY_SEPARATOR , $path);
		$path = preg_replace('/\\'.DIRECTORY_SEPARATOR.'{2,}/' , DIRECTORY_SEPARATOR , $path.DIRECTORY_SEPARATOR);
		if($sprit)
			return $path;
		else
			return rtrim($path,DIRECTORY_SEPARATOR);
	}

	/**
	 * 寻找网站的运行目录
	 * @return 如果在根目录则返回空，如果是在二级以上目录上，则返回 erji/ 或者 erji/sanji/
	 */
	public static function findRunFolder ()
	{
		$full = self::formatPath($_SERVER['SCRIPT_FILENAME'],false);
		$base = self::formatPath($_SERVER['DOCUMENT_ROOT']);
		$folder = dirname(str_replace($base ,'',$full));
		if($folder == '.') {
			return '';
        } else {
            $path = str_replace('\\', '/', $folder);
            $arr = explode('/', $path);
            if (APPNAME != 'home' && end($arr) == APPNAME) {
                array_pop($arr);
                if (empty($arr)) {
                    return '';
                }
            }
            return join('/', $arr) . '/';
        }
	}
}



/**
 * 自动加载引导文件的加载
 */
include_once DIR_BF_ROOT . 'base/AutoLoad.php';

/**
 * 调用SPL扩展,注册__autoload()函数.
 */
spl_autoload_register(array('AutoLoad', 'automation'));