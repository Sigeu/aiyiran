<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 控制器基类
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-11 下午6:11:26 创建此文件
 * <br>雷少进  2013-07-20 下午6:11:20 修改此文件
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-11 下午6:11:26
 * @filename   Controller.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: Controller.php 11 2013-08-09 07:40:20Z zhoulifeng $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) exit('Deny access');
abstract class Controller extends Base
{
	/**
	 * 视图实例化变量
	 *
	 * @var object
	 */
	protected static $_view;

	/**
	 * 配置文件内容临时存贮数组
	 *
	 * @var array
	 */
	public static $_config = array();

	/**
	 * 扩展模块实例化对象存贮数组
	 *
	 * @var object
	 */
	public static $_moduleNameArray = array();

	/**
	 * 构造函数
	 *
	 * 用于初始化本类的运行环境,或对基本变量进行赋值
	 * @access public
	 * @return null
	 */
	public function __construct()
	{
		$sessionDir = DIR_CACHE . 'temp';
		date_default_timezone_set(CMS_TIMEZONE);                                           //时区设置,默认为中国(北京时区)
		is_dir($sessionDir) && is_writable($sessionDir) && session_save_path($sessionDir); //设置项目系统session的存放目录
		get_magic_quotes_runtime() && @set_magic_quotes_runtime(0);                        //关闭魔术变量，提高PHP运行效率.

		//将全局变量进行魔术变量处理,过滤掉系统自动加上的'\'.
		if (get_magic_quotes_gpc())
		{
			$_POST    = $this->stripSlashes($_POST);
			$_GET     = $this->stripSlashes($_GET);
			$_SESSION = $this->stripSlashes($_SESSION);
			$_COOKIE  = $this->stripSlashes($_COOKIE);
		}
		$this -> baseInit();
	}

	/**
	 * 初始化 子类重写此方法完成初始化
	 */
	protected function baseInit(){}

	/**
	 * 初始化 子类重写此方法完成初始化
	 * @param
	 * @return
	 */
	protected function init(){}

	/**
	 * 获取并分析$_GET数组某参数值
	 *
	 * 获取$_GET的全局超级变量数组的某参数值,并进行转义化处理，提升代码安全.注:参数支持数组
	 * @access public
	 * @param string $string 所要获取$_GET的参数
	 * @param string $defaultParam 默认参数, 注:只有$string不为数组时有效
	 * @return string    $_GET数组某参数值
	 */
	public static function get($string, $defaultParam = null) {

		return Request::get($string, $defaultParam);
	}

	/**
	 * 获取并分析$_POST数组某参数值
	 *
	 * 获取$_POST全局变量数组的某参数值,并进行转义等处理，提升代码安全.注:参数支持数组
	 * @access public
	 * @param string $string    所要获取$_POST的参数
	 * @param string $defaultParam 默认参数, 注:只有$string不为数组时有效
	 * @return string    $_POST数组某参数值
	 */
	public static function post($string, $defaultParam = null) {

		return Request::post($string, $defaultParam);
	}

	/**
	 * 批量获取$_POST或$_GET数组参数值
	 *
	 * @access public
	 * @param string $optionName 请求类型: post, get, request
	 * @return array
	 */
	public static function requestVars($optionName = 'post') {

		return Request::requestVars($optionName);
	}

	/**
	 * 获取并分析 $_GET或$_POST全局超级变量数组某参数的值
	 *
	 * 获取并分析$_POST['参数']的值 ，当$_POST['参数']不存在或为空时，再获取$_GET['参数']的值。
	 * @access public
	 * @param string $string 所要获取的参数名称
	 * @param string $defaultParam 默认参数, 注:只有$string不为数组时有效
	 * @return string    $_GET或$_POST数组某参数值
	 */
	public static function getParams($string, $defaultParam = null) {

		return Request::getParams($string, $defaultParam);
	}

	/**
	 * 获取PHP在CLI运行模式下的参数
	 *
	 * @access public
	 * @param string $string 参数键值, 注:不支持数组
	 * @param string $defaultParam 默认参数
	 * @return string
	 */
	public static function getCliParams($string, $defaultParam = null)
	{

		return Request::getCliParams($string, $defaultParam);
	}


	/**
	 * 页面后退
	 */
	public static function goback($alert='' , $die=false)
	{
		echo "<script>";
		if($alert)
		{
			echo "alert('$alert');";
		}
		echo "history.back();</script>";
		if($die)
		{
		die();
		}
	}


	/**
	 * trigger_error()的简化函数
	 *
	 * 用于显示错误信息. 若调试模式关闭时(即:SYS_DEBUG为false时)，则将错误信息并写入日志
	 * @access public
	 * @param string $message 所要显示的错误信息
	 * @param string $level     日志类型. 默认为Error. 参数：Warning, Error, Notice
	 * @return void
	 */
	public static function halt($message, $level = 'Error') {

		//参数分析
		if (empty($message)) {
			return false;
		}

		//调试模式下优雅输出错误信息
		$trace = debug_backtrace();
		$sourceFile = $trace[0]['file'] . '(' . $trace[0]['line'] . ')';

		$traceString = '';
		foreach ($trace as $key => $t) {
			$traceString .= '#' . $key . ' ' . $t['file'] . '(' . $t['line']
					. ')' . $t['class'] . $t['type'] . $t['function'] . '('
					. implode('.', $t['args']) . ')<br/>';
		}

		//加载,分析,并输出excepiton文件内容
		include_once DIR_BF_ROOT . 'views/html/exception.php';

		if (SYS_DEBUG === false) {
			//写入程序运行日志
			Log::write($message, $level);
		}

		//终止程序
		exit();
	}

	/**
	 * 显示提示信息操作
	 *
	 * 所显示的提示信息并非完全是错误信息。如：用户登陆时用户名或密码错误，可用本方法输出提示信息
	 *
	 * 注：显示提示信息的页面模板内容可以自定义. 方法：在项目视图目录中的error子目录中新建message.html文件,自定义该文件内容
	 * 显示错误信息处模板标签为{$message}
	 *
	 * 本方法支持URL的自动跳转，当显示时间有效期失效时则跳转到自定义网址，若跳转网址为空则函数不执行跳转功能，当自定义网址参数为-1时默认为:返回上一页。
	 * @access public
	 * @param string $message         所要显示的提示信息
	 * @param string $gotoUrl         所要跳转的自定义网址
	 * @param int    $limitTime       显示信息的有效期
	 * @return void
	 */
	public static function showMessage($message, $gotoUrl = null,
			$limitTime = 3) {

		//参数分析
		if (!$message) {
			return false;
		}

		//当自定义跳转网址存在时
		if (!is_null($gotoUrl)) {
			$limitTime = 1000 * $limitTime;
			//分析自定义网址是否为返回页
			if ($gotoUrl == -1) {
				$gotoUrl = 'javascript:history.go(-1);';
				$message .= '<br/><a href="javascript:history.go(-1);" target="_self">如果你的浏览器没反应,请点击这里...</a>';
			} else {
				//防止网址过长，有换行引起跳转变不正确
				$gotoUrl = str_replace(array("\n", "\r"), '', $gotoUrl);
				$message .= '<br/><a href="' . $gotoUrl
						. '" target="_self">如果你的浏览器没反应,请点击这里...</a>';
			}
			$message .= '<script type="text/javascript">function cms_redirect_url(url){location.href=url;}setTimeout("cms_redirect_url(\''
					. $gotoUrl . '\')", ' . $limitTime . ');</script>';
		}

		$messageTemplateFile = DIR_BF_ROOT . 'error/message.php';

		is_file($messageTemplateFile) ? include_once $messageTemplateFile
				: include_once DIR_BF_ROOT . 'views/html/message.php';

		exit();
	}

	/**
	 * 优雅输出print_r()函数所要输出的内容
	 *
	 * 用于程序调试时,完美输出调试数据,功能相当于print_r().当第二参数为true时(默认为:false),功能相当于var_dump()。
	 * 注:本方法一般用于程序调试
	 * @access public
	 * @param array $data         所要输出的数据
	 * @param boolean $option     选项:true或 false
	 * @return array            所要输出的数组内容
	 */
	public static function dump($data, $option = false) {

		//当输出print_r()内容时
		if (!$option) {
			echo '<pre>';
			print_r($data);
			echo '</pre>';
		} else {
			ob_start();
			var_dump($data);
			$output = ob_get_clean();

			$output = str_replace('"', '', $output);
			$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

			echo '<pre>', $output, '</pre>';
		}

		exit;
	}

	/**
	 * 获取当前运行程序的网址域名
	 *
	 * 如：http://www.b2b.cn
	 * @access public
	 * @return string 网址
	 */
	public static function getServerName() {

		//获取网址域名部分.
		$serverName = !empty($_SERVER['HTTP_HOST']) ? strtolower(
						$_SERVER['HTTP_HOST']) : $_SERVER['SERVER_NAME'];
		$serverPort = ($_SERVER['SERVER_PORT'] == '80') ? ''
				: ':' . (int) $_SERVER['SERVER_PORT'];

		//获取网络协议.
		$secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1
				: 0;

		return ($secure ? 'https://' : 'http://') . $serverName . $serverPort;
	}

	/**
	 * 获取当前项目的根目录的URL
	 *
	 * 用于网页的CSS, JavaScript，图片等文件的调用.
	 * @access public
	 * @return string     根目录的URL. 注:URL以反斜杠("/")结尾
	 */
	public static function getBaseUrl() {
		return Router::getBaseUrl();
	}

	/**
	 * 获取当前运行的Action的URL
	 *
	 * @access public
	 * @return string    URL
	 */
	public static function getSelfUrl() {

		return self::createUrl(
				app::getModuleName() . URL_SEGEMENTATION
						. app::getControllerName() . URL_SEGEMENTATION
						. app::getActionName());
	}

	/**
	 * 获取当前Controller内的某Action的URL
	 *
	 * 获取当前控制器(Controller)内的动作(Action)的URL. 注:该网址仅由项目入口文件和控制器(Controller)组成。
	 * @access public
	 * @param string $actionName 所要获取URL的action的名称
	 * @return string    URL
	 */
	public static function getActionUrl($actionName) {

		//参数判断
		if (empty($actionName)) {
			return false;
		}

		return self::createUrl(
				app::getModuleName() . URL_SEGEMENTATION
						. app::getControllerName() . URL_SEGEMENTATION
						. $actionName);
	}

	/**
	 * 网址(URL)跳转操作
	 * 302
	 * @access public
	 * @param string $url 所要跳转的URL
	 * @return void
	 */
	public function redirect($url) {

		//参数分析.
		if (!$url) {
			return false;
		}

		if (!headers_sent()) {
			header("Location:" . $url);
		} else {
			echo '<script type="text/javascript">location.href="' . $url
					. '";</script>';
		}
		exit();
	}

	/**
	 * URL组装
	 *
	 * 组装绝对路径的URL
	 * @access public
	 * @param string    $route          controller与action
	 * @param array     $params         URL路由其它字段
	 * @param boolean   $routingMode    网址是否启用路由模式
	 * @return string   URL
	 */
	public static function createUrl($route, $params = null,
			$routingMode = true) {

		return Router::createUrl($route, $params, $routingMode);
	}

	/**
	 * 类的单例实例化操作
	 *
	 * @access public
	 * @param string $className 所要实例化的类名
	 * @return object 实例化后的对象
	 */
	public static function instance($className) {

		//参数判断
		if (!$className) {
			return false;
		}

		return app::singleton($className);
	}

	/**
	 * 单例模式实例化一个Model对象
	 *
	 * @access public
	 * @param string $modelName 所要实例化的Modle名称
	 * @return object 实例化后的对象
	 */
	public static function model($modelName) {

		if (!$modelName) {
			return false;
		}
		$modelName = ucfirst(trim($modelName)) . 'Model';

		return app::singleton($modelName);
	}

	/**
	 * 加载并单例模式实例化扩展模块.
	 *
	 * 注：这里所调用的扩展模板要放在项目extension目录里的modules子目录中
	 * @access public
	 * @param string $moduleName     模块名称
	 * @return object                扩展模块的实例化对象
	 */
	public static function module($moduleName) {

		//参数判断.
		if (!$moduleName) {
			return false;
		}

		if (!isset(self::$_moduleNameArray[$moduleName])) {
			//加载扩展模块的引导文件
//			$module_file = DIR_MODULE . $moduleName . DIRECTORY_SEPARATOR;
			$module_file = DIR_SMARTY . $moduleName . DIRECTORY_SEPARATOR;

//			echo $module_file;
			$_module_name = ucfirst(strtolower($moduleName));
			$module_file .= $_module_name . 'Module.php';

			self::import($module_file);
			self::$_moduleNameArray[$moduleName] = self::instance(
					$_module_name);
		}

		return self::$_moduleNameArray[$moduleName];
	}
    	/**
	 * 加载并单例模式实例化扩展模块.
	 *
	 * 注：这里所调用的扩展模板要放在项目extension目录里的modules子目录中
	 * @access public
	 * @param string $moduleName     模块名称
	 * @return object                扩展模块的实例化对象
	 */
	public static function venderModule($moduleName) {

		//参数判断.
		if (!$moduleName) {
			return false;
		}

		if (!isset(self::$_moduleNameArray[$moduleName])) {
			//加载扩展模块的引导文件
//			$module_file = DIR_MODULE . $moduleName . DIRECTORY_SEPARATOR;
			$module_file = PATH_VENDOR . $moduleName . DIRECTORY_SEPARATOR;
            
			$_module_name = ucfirst(strtolower($moduleName));
			$module_file .= $_module_name . '.class.php';
			self::import($module_file);
			self::$_moduleNameArray[$moduleName] = self::instance(
					$_module_name);
		}

		return self::$_moduleNameArray[$moduleName];
	}
	/**
	 * 静态加载文件
	 *
	 * 相当于inclue_once()
	 * @access public
	 * @param string $fileName 所要加载的文件
	 * @return void
	 */
	public static function import($fileName) {

		//参数判断
		if (!$fileName) {
			return false;
		}

		//判断文件是不是工具类目录里
		$fileUrl = ((strpos($fileName, '/') !== false)
				|| (strpos($fileName, '\\') !== false)) ? realpath($fileName)
				: realpath(DIR_BF_ROOT . 'classes/' . $fileName . '.php');

		return app::loadFile($fileUrl);
	}

	/**
	 * 静态加载项目设置目录(config目录)中的配置文件
	 *
	 * 加载项目设置目录(config)中的配置文件,当第一次加载后,第二次加载时则不再重新加载文件
	 * @access public
	 * @param string $fileName 所要加载的配置文件名 注：不含后缀名
	 * @return mixed    配置文件内容
	 */
	public static function getConfig($fileName) {

		if (!$fileName) {
			return false;
		}

		if (!isset(self::$_config[$fileName])) {
			$filePath = DIR_CONFIG . $fileName . '.ini.php';

			if (!is_file($filePath)) {
				self::halt(
						'The config file:' . $fileName
								. '.ini.class is not exists!');
			}
			self::$_config[$fileName] = include $filePath;
		}

		return self::$_config[$fileName];
	}

	/**
	 * 分析视图缓存
	 *
	 * @access public
	 * @param string $cacheId 缓存ID
	 * @param integer $lifetime 缓存周期
	 * @return void
	 */
	public function cache($cacheId = null, $lifetime = null) {

		return self::$_view->cache($cacheId, $lifetime);
	}

	/**
	 * 视图变量赋值操作
	 *
	 * @access public
	 * @param mixted $keys 视图变量名
	 * @param string $value 视图变量值
	 * @return mixted
	 */
	public function assign($keys, $value = null) {

		return self::$_view->assign($keys, $value);
	}

	/**
	 * 显示当前页面的视图内容
	 *
	 * @access public
	 * @param string $fileName 视图名称
	 * @return void
	 */
	public function display($fileName = null) {
		return self::$_view->display($fileName);
	}

	/**
	 * 返回前页面的视图内容
	 *
	 * @access public
	 * @param string $fileName 视图名称
	 * @return void
	 */
	public function fetch($fileName = null) {
		return self::$_view->fetch($fileName,true);
	}

	/**
	 * 加载视图文件的widget
	 *
	 * @access public
	 * @param string  $widgetName 所要加载的widget名称
	 * @param array   $params 参数
	 * @return boolean
	 */
	public static function widget($widgetName, $params = null) {

		if (!$widgetName) {
			return false;
		}
		$widgetName = ucfirst(trim($widgetName)) . 'Widget';
		app::singleton($widgetName)->renderContent($params);
		return true;
	}

	/**
	 * 加载并显示视图内容
	 *
	 * 相当于include 代码片段，当$return为:true时返回代码代码片段内容,反之则显示代码片段内容
	 * @access public
	 * @param string  $fileName  视图片段文件名称
	 * @param array   $_data     视图模板变量，注：数组型
	 * @param boolean $return    视图内容是否为返回，当为true时为返回，为false时则为显示. 默认为:false
	 * @return mixed
	 */
	public function render($fileName, $_data = array(), $return = false) {

		return self::$_view->render($fileName, $_data, $return);
	}

	/**
	 * Ajax调用返回
	 *
	 * 返回json数据,供前台ajax调用
	 * @param array $data    返回数组,支持数组
	 * @param string $info    返回信息, 默认为空
	 * @param boolean $status    执行状态 : true/false 或 1/0
	 * @return string
	 */
	public function ajax($status = true, $info = null, $data = array()) {

		$result = array();
		$result['status'] = $status;
		$result['info'] = !is_null($info) ? $info : '';
		$result['data'] = $data;

		header("Content-Type:text/html; charset=utf-8");
		exit(json_encode($result));
	}

	/**
	 * stripslashes()的同功能操作
	 *
	 * @access protected
	 * @param string $string     所要处理的变量
	 * @return mixed            变量
	 */
	protected static function stripSlashes($string) {

		//参数分析.
		if (!$string) {
			return false;
		}

		if (!is_array($string)) {
			return stripslashes($string);
		}

		foreach ($string as $key => $value) {
			$string[$key] = self::stripSlashes($value);
		}

		return $string;
	}



	/**
	 * 获取客户端的IP
	 * @return string
	 */
	public function getClientIP(){
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			return getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			return getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			return getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			return $_SERVER['REMOTE_ADDR'];
		}
	}

	/**
	 * 检查授权
	 * @param
	 * @return
	 */
	function checkLicense ($domain)
	{
		return 1;
		/*
		$domain = str_replace('http://','',$domain);
		$domain = str_replace('https://','',$domain);
		$domain = str_replace('www.','',$domain);
		$checkurl = 'http://www.izhancms.com/official/os/os/check/domainname/'.$domain;

		$status = @file_get_contents($checkurl);
		if(intval($status) == 1)
		{
			return 1;
		}
		else
		{
			return 2;
		}
		*/
	}


	/**
	 * 生成验证码
	 * @param
	 * @return
	 */
	function createAuthCode ()
	{
		/*
		MoAuthCode Object
		(
			[width] => 80
			[height] => 24
			[density] => 3
			[code] => LHAZ
			[codeLength] => 4
			[fontStyle] => D:\wamp\www\mocms\library\mainone\classes/shuzi.ttf
			[color1] => 0
			[color2] => 0
			[color3] => 0
			[fontSize] => 20
			[X] => 77
			[Y] => 20
			[x_offset] => 18
		)
		*/
		include DIR_BF_ROOT.'classes'.DS.'MoAuthCode.php';
		$img =new MoAuthCode();
		$_SESSION['__MO_AUTHCODE'] = $img->code;
		$image = $img->createImg();
		imagepng($image);//把图像以png的格式输出
		imagedestroy($image);//注销图,以免占用资源
	}
}
