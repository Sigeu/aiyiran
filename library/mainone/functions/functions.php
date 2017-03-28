<?php
/**
 * --------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * functions.php  扩展函数库
 *
 * 该文件中包含常用工具函数，欢迎大家补充。
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:46:26
 * @filename   functions.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *----------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')) {
	exit('No Permission');
}

/**
 * 过滤掉敏感字符 '、"、\、/
 * @param string $str  要过滤掉字符串
 * @return string 过滤后的字符串
 */
function filterBadStr($str)
{
	return preg_replace('/[\'|"|\\\|\/]/','',$str);
}
/**
 * 获取配置文件信息
 * @param string $filename  配置文件名
 * @param string $item      配置项
 * @param string $app       应用名
 * @return mixed $config    配置内容
 */

function get_config($filename,$item='',$app='')
{
	if (!$filename) return '';

	//配置文件目录
	if (!empty($app))
	{
		$app = strtolower($app);
		$dir_root = str_replace(APPNAME.DS, '', DIR_ROOT);
		if ($app=='home')
		{
			$filePath = $dir_root.DS.'application/config/'.$filename.'.ini.php';
		}else
		{
			$filePath = $dir_root.$app.DS.'application/config/'.$filename.'.ini.php';
		}
	}else
	{
		$filePath = DIR_CONFIG . $filename . '.ini.php';
	}

	if (!is_file($filePath)) return '';

	//获取配置
	$_config = include $filePath;
	if($item)
	{
		return isset($_config[$item]) ? $_config[$item] : '';
	}
	else
	{
		return $_config;
	}

	/*if (!$filename) return false;

	$_config = array();
	if (!isset($_config[$filename]))
	{
		if (isset($app)&&!empty($app))
		{
			$filePath = str_replace(DIR_ROOT, DIR_ROOT.$app.DS, DIR_CONFIG . $filename . '.ini.php');
			$filePath = str_replace(APPNAME.DS, '', $filePath);
			$filePath = str_replace('home'.DS, '', $filePath);
		}else
		{
		    $filePath = DIR_CONFIG . $filename . '.ini.php';
		}
		if (!is_file($filePath))
		{
			halt('The config file:' . $filename . '.ini.php is not exists!');
		}
		$_config[$filename] = include $filePath;
		if (isset($item)&&!empty($item))
		{
			$value = $_config[$filename][$item];
		}else
		{
			$value = $_config[$filename];
		}
	}

	return $value;*/
}

/**
 * 写配置文件
 * @param $filename  支持绝对路径文件的写入和相对各个config目录写入 /admin/application/config/test.php  或者 version
 * @param $data      字符串
 * @param $app       filename为第二种形式时有效
 * @return           int
 */
function set_config($filename,$data='',$app='')
{
	$temp = dirname($filename);
	if(!in_array($temp,array('.','..')) && is_dir($filename))
	{
		$filePath = $filename;
	}
	else if (!empty($app))
	{
		$filePath = str_replace(DIR_ROOT , DIR_ROOT.$app.DS , DIR_CONFIG.$filename.'.ini.php');
		$filePath = str_replace(APPNAME.DS, '', $filePath);
		$filePath = str_replace('home'.DS, '', $filePath);
	}
	else
	{
		$filePath = DIR_CONFIG . $filename . '.ini.php';
	}
	return file_put_contents($filePath,$data);
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
function halt($message, $level = 'Error') {

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
 * 写入缓存，默认为文件缓存，不加载缓存配置。
 * @param $name        缓存名称
 * @param $data        缓存数据
 * @param $filepath    数据路径（模块名称） caches/cache_$filepath/
 * @param $type        缓存类型[file,memcache,apc]
 * @param $datatype	      缓存数据类型caches/cache_$filepath/caches_$datatype 默认是data
 * @param $config      配置名称
 * @param $timeout     过期时间
 * @param $app         应用名
 */
function set_cache($name, $data, $filepath='', $timeout=0,$app='',$type='file', $config='file',$datatype='')
{
	if($config)
	{
		$cacheconfig = get_config('cache','cache');
		$cache = CacheFactory::getInstance($cacheconfig)->getCache($config);
	} else
	{
		$cache = CacheFactory::getInstance()->getCache($type);
	}
	return $cache->set($name, $data, $timeout, $datatype, $filepath,$app);
}

/**
 * 读取缓存，默认为文件缓存，不加载缓存配置。
 * @param string $name       缓存名称
 * @param string $filepath   数据路径（模块名称） caches/cache_$filepath/
 * @param string $app        应用名 admin 用于不同应用的数据共享
 * @param string $type       缓存类型
 * @param string $datatype	  缓存数据类型 caches/cache_$filepath/caches_$datatype 默认是data
 * @param string $config     配置名称
 */
function get_cache($name, $filepath='',$app='', $type='file', $config='file',$datatype='')
{
	if($config)
	{
		$cacheconfig = get_config('cache','cache');
		$cache = CacheFactory::getInstance($cacheconfig)->getCache($config);
	} else
	{
		$cache = CacheFactory::getInstance()->getCache($type);
	}

	return $cache->get($name, '', $datatype, $filepath,$app);
}

/**
 * 删除缓存，默认为文件缓存，不加载缓存配置。
 * @param $name        缓存名称
 * @param $filepath    数据路径（模块名称） caches/cache_$filepath/
 * @param $type        缓存类型[file,memcache]
 * @param $config      配置名称
 * @param $datatype	      缓存数据类型caches/cache_$filepath/caches_$datatype 默认是data
 */
function delete_cache($name, $filepath='', $type='file', $config='file',$datatype='')
{
	if($config) {
		$cacheconfig = get_config('cache','cache');
		$cache = CacheFactory::getInstance($cacheconfig)->getCache($config);
	} else {
		$cache = CacheFactory::getInstance()->getCache($type);
	}
	return $cache->delete($name, '',$datatype='', $filepath);
}

/**
 * 清除缓存，默认为文件缓存，不加载缓存配置。
 * @param $type 缓存类型[file,memcache]
 * @param $config 配置名称
 */
function flush_cache($type='file', $config='file')
{
	if($config) {
		$cacheconfig = get_config('cache','cache');
		$cache = CacheFactory::getInstance($cacheconfig)->getCache($config);
	} else {
		$cache = CacheFactory::getInstance()->getCache($type);
	}
	return $cache->flush();
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 *
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false)
{
    if(function_exists("mb_substr"))
    {
        $slice = mb_substr($str, $start, $length, $charset);
    }elseif(function_exists('iconv_substr'))
    {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice)
        {
            $slice = '';
        }
    }else
    {
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 *
 * 获取客户端IP地址
 */

function get_client_ip()
{
    static $ip = NULL;
    if ($ip !== NULL)
    {
        return $ip;
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    }elseif (isset($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['REMOTE_ADDR']))
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}


/**
* 产生随机字符串
*
* @param    int        $length  输出长度
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789')
{
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)
	{
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
 * 百分之几的几率返回真，即调用100次，大概有几次返回的是真，默认是20%的几率
 * @param $odds 百分之多少
 * return bool
 */
function percentDoAction ($odds = 20)
{
	if(!is_numeric($odds)) $odds = 20;
	$odds = intval($odds);
	if($odds>100) $odds = 100;
	if($odds<0) $odds = 0;
	if((rand(1,$odds) > rand(1,50)) || ($odds == 100))
	return true;
	return false;
}

/**
 * 循环创建目录
 * @param  string  $dir   目录名
 * @param  string  $mode  目录权限
 */
function mk_dir($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode))
    {
        return true;
    }
    if (!mk_dir(dirname($dir), $mode))
    {
        return false;
    }
    return @mkdir($dir, $mode);
}

/**
 * 删除文件夹下所有文件及子文件夹
 * @param string   $dir  目录名
 */
function del_dir($dir)
{
	//删除目录下的文件：
	$dh=opendir($dir);
	if ($dh)
	{
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					@unlink($fullpath);
				} else {
					del_dir($fullpath);
				}
			}
		}

		closedir($dh);
	}
}

// 浏览器友好的变量输出
function dump($var, $echo=true, $label=null, $strict=true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict)
    {
        if (ini_get('html_errors'))
        {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else
        {
            $output = $label . print_r($var, true);
        }
    } else
    {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug'))
        {
            $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo)
    {
        echo($output);
        return null;
    }else
    {
        return $output;
    }
}



//生成GUID
function create_guid()
{
	$charid = strtoupper(md5(uniqid(mt_rand(), true)));
	$hyphen = chr(45);
	$uuid = chr(123)
	.substr($charid, 0, 8).$hyphen
	.substr($charid, 8, 4).$hyphen
	.substr($charid,12, 4).$hyphen
	.substr($charid,16, 4).$hyphen
	.substr($charid,20,12)
	.chr(125);
	return $uuid;
}


// 自定义异常处理
function throw_exception($msg,$param=array(), $type='BaseException', $code=0)
{
    if (class_exists($type))
    {
        throw new $type($msg,$param, $code);
    }else
    {
        halt($msg);        // 异常类型不存在则输出错误信息字串
    }
}


// URL重定向
function redirect($url, $msg='', $time=0)
{
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
    {
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    }
    if (!headers_sent())
    {
        // redirect
        if (0 === $time)
        {
            header('Location: ' . $url);
        } else
        {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else
    {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
        {
            $str .= $msg;
        }
        exit($str);
    }
}

/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

/**
 * 模板风格列表
 * @param integer $disable 是否显示停用的{1:是,0:否}
 */
function template_stylelist($disable = 0) {

	$stylelist = glob(getDirView().'*', GLOB_ONLYDIR);
	$stylearr  = array();
	foreach ($stylelist as $key=>$v) {
		$dirname = basename($v);
		if (file_exists($v.DIRECTORY_SEPARATOR.'config.php')) {
			$stylearr[$key] = include $v.DIRECTORY_SEPARATOR.'config.php';
			if (!$disable && !$stylearr[$key]['disable']) {
				unset($stylearr[$key]);
				continue;
			}

                        if (isset($stylearr[$key]['isshow']) && empty($stylearr[$key]['isshow'])) {
				unset($stylearr[$key]);
				continue;
			}
		}
		$stylearr[$key]['identify']=$dirname;
	}
	return $stylearr;
}


/**
 * 记录管理员的操作内容
 *
 * @access  public
 * @param   string      $sn         备注信息
 * @param   string      $module_name    模块名称
 */
function admin_log($module_name, $sn = '')
{
    $open = M('web_config')->query('SELECT par_value FROM '. M('web_config')->trueTableName . ' WHERE par_name = "mo_admin_log"');
    foreach ($open AS $val){
        $on = $val['par_value'];
    }
    if($on =='N') return true;
    $log_info = addslashes($sn);
    $username = $_SESSION['userinfo']['username'];
    $sql = 'INSERT INTO ' . M('admin_log')->trueTableName . ' (log_time, admin_name, log_info, module_name, ip_address) ' .
            " VALUES ('" . time() . "', '$username', '" . stripslashes($log_info) . "', '$module_name', '" . get_client_ip() . "')";
    M('admin_log')->query($sql);
}

/**
 * IMC日志管理
 * @access  public
 */
function imc_log($module_name, $sn = '')
{
    $log_info = addslashes($sn);
    $username = $_SESSION['userinfo_imc']['username'];
    $sql = 'INSERT INTO ' . M('site_log')->trueTableName . ' (log_time, admin_name, remark, operation, ip_address) ' .
            " VALUES ('" . time() . "', '$username', '" . stripslashes($log_info) . "', '$module_name', '" . get_client_ip() . "')";
    M('site_log')->query($sql);
}

/* 返回打水印相关设置 */
function aboutMark()
{
    $sql = "SELECT par_name, par_value FROM ". M('web_config')->trueTableName ." WHERE par_id IN (110,111,113,115,116,117,118,119)";
    $result = M('web_config')->query($sql);
    foreach ($result AS $val){
        $zol[$val['par_name']] = $val['par_value'];
    }
    return $zol;
}


/**
 * 模板文件列表
 * @param string 模板风格：默认DEFAULT_STYLE
 * @return  array 文件列表
 */
function template_filelist($style = DEFAULT_STYLE) {

	$filelist = glob(getDirView().$style.DIRECTORY_SEPARATOR.'*.html', GLOB_NOSORT);
	$fileArr  = array();
	foreach ($filelist as $key=>$v) {
		$filename = basename($v);
		$fileArr[$filename] = filemtime($v);
	}
	asort($fileArr,SORT_NUMERIC);
	$newArr = array_reverse($fileArr);
	foreach ($newArr as $key=>$v) {
		$newArr[$key] = date('Y-m-d H:i:s',$v);
	}
	//array_reverse($fileArr,true);
	return $newArr;
}

/**
 * 模板标签文件列表
 * @return  array 标签列表
 */
function template_taglist($style = DEFAULT_STYLE) {

	$taglist = glob(DIR_TAG.'*.lib.php', GLOB_NOSORT);
	$tagArr  = array();
	foreach ($taglist as $key=>$v) {
		$tagname = basename($v);
		$tagArr[$tagname] = filemtime($v);
	}
	asort($tagArr,SORT_NUMERIC);
	$newArr = array_reverse($tagArr);
	foreach ($newArr as $key=>$v) {
		$newArr[$key] = date('Y-m-d H:i:s',$v);
	}
	return $newArr;
}

/**
 * 获取指定模板目录
 * @param integer $basepath 路径：默认为空
 */

function getDirView($basepath=PATH_RUN_FOLDER)
{

	return getDirRoot($basepath) . 'template'. DIRECTORY_SEPARATOR;
}

/**
 * 获取根指定目录
 * @param integer $basepath
 */

function getDirRoot($basepath=PATH_RUN_FOLDER)
{
	return $basepath ? $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .$basepath . DIRECTORY_SEPARATOR : $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR ;
}



/**
 * 页面刷新
 */
function referrer($alert='' , $die=false)
{
	echo "<script>";
	if($alert)
	{
		echo "alert('$alert');";
	}
	echo "window.location.href=document.referrer;</script>";
	if($die)
	{
		die();
	}
}
/**
 * 页面后退
 * @param $alert 弹出的消息
 * @die 是否停止
 */
function goback($alert='' , $die=false)
{
	echo '<script type="text/javascript" language="javascript" charset="gb2312">';
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
 * 将一个对象转换为数组
 */
function object_to_array($obj)
{
	$_arr = is_object($obj) ? get_object_vars($obj) : array();
	foreach ($_arr as $key => $val)
	{
		$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
		$arr[$key] = $val;
	}
	return $_arr;
}


/**
 * 获取authkey验证
 *
 */
function authkey($str)
{
	$key = C('imc','key');
	$str = rc4($str,$key);
	return md5($str);
}
/**
 * 验证上传安全性
 *
 */
function checkUpload($authkey,$setting)
{
	return authkey($setting)==$authkey;
}


/**
 * 读取upload配置类型
 * @param array $settings 上传配置信息
 */
function getUploadSetting($settings) {
	$args = explode(',',$settings);
	$arr['file_upload_limit'] = intval($args[0]) ? intval($args[0]) : C('common','file_upload_limit');
	$args['1'] = ($args[1]!='') ? $args[1] : get_mo_config('mo_'.$args[5].'type');//从全局设置中去
	$allow_type = explode('|', $args[1]);
	foreach($allow_type as $k=>$v) {
		$v = '*.'.$v;
		$array[$k] = $v;
	}
	$allow_type = implode(';', $array);
	$arr['file_types'] = $allow_type;
	$arr['file_types_post'] = $args[1];
	$arr['has_dir'] = intval($args[2]);
	$arr['has_watermark'] = intval($args[3]); //水印
    $file_size = C('common','file_size')<=2 ? C('common','file_size') : 2;
	$args[4] = intval($args[4])<=2 ? intval($args[4]) : 2;
	$arr['file_size'] = ($args[4]=='') ?  $file_size : ini_get("upload_max_filesize"); //大小
	return $arr;
}

/**
 * 获取全局设置
 */

function get_mo_config($filed)
{
	$config = M('web_config')->where(array('par_name'=>$filed))->getOne();
	return $config['par_value'];
}


/**
 * 上传初始化
 * 初始化上传中需要的参数
 */
function initupload($settings){
	$settings['file_size']=$settings['file_size']*1024;
	if($settings['file_types'] == '*.')
	{
		$settings['file_types'] =  "*.*";
		$settings['file_types_post'] =  "*";
	}
	$init =  'var swfu;
		$(document).ready(function(){
			swfu = new SWFUpload({
			flash_url:"'.HOST_NAME.'static/js/swfupload/swfupload.swf?"+Math.random(),
			flash9_url:"'.HOST_NAME.'static/js/swfupload/swfupload_fp9?"+Math.random(),
			upload_url:"/'.APPNAME.'/dialog/Dialog/save/",
			post_params:{"allowtype":"'.$settings['file_types_post'].'","allowsize":"'.$settings['file_size'].'"},
			file_post_name : "uploadFile",
			file_size_limit:"'.$settings['file_size'].'",
			file_types:"'.$settings['file_types'].'",
			file_types_description:"All Files",
			file_upload_limit:"'.$settings['file_upload_limit'].'",
			custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},

			button_width: 75,
			button_height: 28,
			button_text: "选择文件",
			button_placeholder_id: "mybutton",
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,


			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
		});
	})';
	return $init;
}


/**
 * 返回文件上传 临时目录
 */
function getTempPath ($path='')
{
	if(!$path)
		$path = realpath(DIR_UPLOAD_TEMP);
	return $path;
}

/**
 * 创建并返回附件存放的目录 array(),基础目录，动态目录，完整目录
 */
function getFileSavePath ($path_name,$child_folder='',$base_path='')
{
	if(!$base_path)
	{
		$base_path = realpath(DIR_UPLOADFILE);						//所有文件上传目录
		$base_path = $base_path.'/'.$path_name;		//品牌目录
	}
	$trends_path = date($child_folder);//动态目录名
	$full_path = $base_path.'/'.$trends_path;//完整的目录名
	MoFolder::mkRecur($full_path);							 //创建附件目录
	return array('base'=>$base_path,'trends'=>$trends_path,'full'=>$full_path);
}

function uploadAccessory ($param=array())
{
	//接受处理参数
	$source_arr   = isset($param['file']) ? $param['file'] : array();
	$folder       = isset($param['folder']) ? $param['folder'] : date('Ymd');
	$child_folder = isset($param['child_folder']) ? $param['child_folder'] : 'Y_m';
	$_water_mark  = isset($param['water_mark']) ? $param['water_mark'] : null;
	$isthumb      = isset($param['isthumb']) ? $param['isthumb'] : false;
	$new_name     = isset($param['new_name']) && (count($source_arr) == 1 ) ? $param['new_name'] : '';
	if(!$source_arr) return array();

	//获取目录信息
	$temp = getTempPath();										//临时目录
	$save_path = getFileSavePath($folder,$child_folder);   		//存储目录
	$file = array();

	//判断传的new_name值格式
	$new_name_info = pathinfo($new_name);

	//第一种格式
	$flag = 'empty';

	//第二种格式'brand/234234.jpg'
	if(isset($new_name_info['extension']) && isset($new_name_info['dirname']) && $new_name_info['dirname'] != '.')
		$flag =  'full';

	//第三种格式 'werwerwerwerwerwre'
	if($new_name_info['filename'] != '' && !isset($new_name_info['extension']))
		$flag =  'base_name';

	foreach ($source_arr as $key => $val)
	{
		$temp_file = dirname(realpath(DIR_ROOT)).$val['src'];//临时文件
		$ext = strtolower(substr($val['filename'],strrpos($val['filename'],'.')+1));//后缀

		if($flag === 'empty')
			$new_file_name = $save_path['trends'].'/'.$val['filename'];
		elseif($flag === 'full')
			$new_file_name = $new_name;
		else if ($flag === 'base_name')
			$new_file_name = $save_path['trends'].'/'.$new_name.$ext;

		$target_file = $save_path['base'].DIRECTORY_SEPARATOR.$new_file_name;
		//目标文件
		if(@copy($temp_file,$target_file))//如果移动成功
		{
			//真正的完成图片上传
			$image_info = (isset($val['isimage'])&&$val['isimage']==1) ? getimagesize($target_file) : array();
			$file[] = array
			(
				'selfname'    =>$val['savename'],
				'trends_path' =>$save_path['trends'],
				'path'        =>$new_file_name,
				'width'       =>!empty($image_info) ? $image_info['0'] : '',
				'height'      =>!empty($image_info) ? $image_info['1'] : '',
				'size'        =>ceil($val['size']/1024),
				'extension'   =>$ext,
				'temp'        =>$temp,
				'sp'          =>$save_path,
				'folder'      =>$folder,
			    'filename'    =>$val['filename'],
			);

			//打水印
			if($_water_mark === null)
				$water_mark = ($val['isimage'] && $val['water_mark']) ? true : false;
			else
				$water_mark = $_water_mark;
			if($water_mark)
			{
				$mark = new Mark();
				$mark->addMark($target_file, dirname(realpath(DIR_ROOT)).'/admin/template/images/mark_default.jpg');
			}

			//缩略图
			if($isthumb)
			{
				//暂未实现
			}
		}
	}
	return $file;
}

/**
 * 参数解释
 array(
	'file'         => 二维源文件数组,必须是通过我们的插件提交过来的文件数组,格式如下
						Array
						(
							[accessory] => Array
							(
								[1] => Array
								(
									[selfname] => 0_20110822151201300GTve.jpg
									[path] => /static/uploadfile/temp/{9D3CE96E-D1E3-7631-5077-A27009B7918A}.jpg
									[isimage] => 1
									[iswatermark] => 0
									[size] => 60821
								)
								[2] => Array
								(
									[selfname] => 0_20110822151201300GTve.jpg
									[path] => /static/uploadfile/temp/{9D3CE96E-D1E3-7631-5077-A27009B7918A}.jpg
									[isimage] => 1
									[iswatermark] => 0
									[size] => 60821
								)
							)
						)

	'folder'       => 目标目录，即你要上传到什么地方，这个目录会放在/static/uploadfile/ 下 格式如下
					 goods 或者 brand 或者 ads
	'child_folder' => folder目录下的子目录格式，必须是php date函数格式化日期的形式 格式如下
	                 'Y_d' 或者 'Y-m-d'等 参数如果错误 后果自负
	'water_mark'   => 是否打水印  true 或者 false 强制打水印设置，如此处设置，上传时设置打水印无效
	'isthumb'      => 是否缩略图  tru或者false
	'new_name'     => 自定义文件名，当你的file数组元素只有一个的时候有效，主要是考虑到单张固定图片名上传的需求，也可用于单张图片修改
						第一:不传值时，文件系统自动生成。
						第二:传一个相对于根目录的文件名 /....
	'time_name'    => 文件名格式 true：按时间生成文件名，false或则不设置 则按系统生成
	返回值依然是二维数组形式
	Array
	(
		[0] => Array
			(
				[selfname] => 67328.jpg                                          //图片本身的名字
				[trends_path] => 2013_01										 //子目录名称
				[path] => 2013_01/{72813F11-5494-D4F2-E9A0-66F5303AD0B3}.jpg      //这个就是您想要的信息
				[width] => 1024                                                   //图片宽
				[height] => 768                                                   //图片高
				[size] => 212                                                     //文件大小
				[extension] => jpg                                                //文件扩展名
				[temp] => D:\wamp\www\mocms\static\uploadfile\temp                //临时文件路径
				[sp] => Array                                                     //上传各种路径信息
					(
						[base] => D:\wamp\www\mocms\static\uploadfile\brand
						[trends] => 2013_01
						[full] => D:\wamp\www\mocms\static\uploadfile\brand\2013_01
					)
			)
	)
 )
 */
function moUploadAccessory ($param=array())
{
	//接受处理参数
	$source_arr   = isset($param['file']) ?         $param['file'] : array();
	$folder       = isset($param['folder']) ?       $param['folder'] : date('Ymd');
	$child_folder = isset($param['child_folder']) ? $param['child_folder'] : 'Y_m';
	$_water_mark  = isset($param['water_mark']) ?   $param['water_mark'] : null;
	$isthumb      = isset($param['isthumb']) ?      $param['isthumb'] : false;
	$time_name    = isset($param['time_name']) ?    $param['time_name'] : false ;
	$new_name     = isset($param['new_name']) && (count($source_arr) == 1 ) ? $param['new_name'] : '';
	if(!$source_arr) return array();

	//获取目录信息
	$temp = getTempPath();//临时目录D:\wamp\www\mocms\static\uploadfile\temp
	$save_path = getFileSavePath($folder,$child_folder);//存储目录
	$root = dirname(realpath(DIR_ROOT));//d:\server\www\mocms
	/*
	Array  $save_path
	(
		[base] => D:\wamp\www\mocms\static\uploadfile\accessory
		[trends] => 2013_04
		[full] => D:\wamp\www\mocms\static\uploadfile\accessory\2013_04
	)
	*/

	$file = array();
	foreach ($source_arr as $key => $val)
	{
		$temp_file = $root.$val['path'];//绝对路径临时文件
		$temp_file_ext = strtolower(substr($val['path'],strrpos($val['path'],'.')+1));//临时文件后缀

		//如果自定义文件名为空 或者 自定义文件名后缀不等于临时文件名
		if($new_name == '' || strtolower(substr($new_name,strrpos($new_name,'.')+1)) != $temp_file_ext)
		{
			if($time_name)//使用时间命名
			{
				$time = explode(' ',microtime());
				$_time_name = date('YmdHis',$time[1]).'_'.substr($time[0],strpos('.',$time[0])+2,4).'_'.rand(10,99);
				$new_file_name = $save_path['trends'].'/'.$_time_name.'.'.$temp_file_ext;
			}
			else
			{
				$new_file_name = $save_path['trends'].'/'.basename($val['path']);
			}
			$target_file = $save_path['base'].DIRECTORY_SEPARATOR.$new_file_name;
		}
		else
		{
			$target_file = $root.$new_name;
			$new_file_name = $new_name;
		}
		//echo $temp_file;echo '<br />';//D:\wamp\www\mocms/static/uploadfile/temp/{7C8DE965-F5C0-3C1D-ADEF-29AA211ED87E}.jpg
		//echo $target_file;echo '<br />';//D:\wamp\www\mocms/static/uploadfile/brand/2013_06/{5C729A4C-43A5-BFFD-9C6A-1315C958172B}.jpg

		//目标文件存在
		if(file_exists($target_file))
			@rename($target_file,$target_file.'.bak');

		mk_dir(dirname($temp_file));
		mk_dir(dirname($target_file));

		if(@copy($temp_file,$target_file))//如果移动成功
		{
			if (strpos($temp_file , 'temp')) {
                batchImageZoom($target_file , 640 , 160);//生成中小缩略图
            }
			if(file_exists($target_file.'.bak'))
				@unlink($target_file.'.bak');
			//真正的完成图片上传
			$image_info = (isset($val['isimage'])&&$val['isimage']==1) ? @getimagesize($target_file) : array();
			$file[] = array
			(
				'alt'         =>isset($val['alt']) ? $val['alt'] : '',
				'selfname'    =>$val['selfname'],
				'trends_path' =>$save_path['trends'],
				'path'        =>$new_file_name,
				'width'       =>!empty($image_info) ? $image_info['0'] : '',
				'height'      =>!empty($image_info) ? $image_info['1'] : '',
				'size'        =>ceil($val['size']/1024),
				'extension'   =>$temp_file_ext,
				'temp'        =>$temp,
				'sp'          =>$save_path,
				'folder'      =>$folder,
			    'filename'    =>basename($new_file_name)
			);

			//打水印
			if($_water_mark === null)
				$water_mark = ($val['isimage'] && $val['iswatermark']) ? true : false;
			else
				$water_mark = $_water_mark;

			if($water_mark)
			{
				$mark = new Mark();
				$some = aboutMark();
				$mark->addMark($some['mo_start_watermark'], $some['mo_watermark_type'], $target_file, rtrim(dirname(DIR_WEB_ROOT),'/').$some['mo_markimage_url'], $some['mo_mark_position'], $some['mo_img_diaphaneity'], $some['mo_word_size'],$some['mo_word_color'],$some['mo_mark_content'], DIR_WEB_ROOT.'font/simsun.ttc');
			}

			//缩略图
			if($isthumb)
			{
				//暂未实现
			}
		}
	}
	return $file;
}


/**
 获取有修改权限的栏目数
 * @param int $parentid
 * @param int $t
 * @return array()
 *  * $per 权限ID
 */
function getPerCategoryTree($modelid,$per,$pid=0,$t=-1)
{
	$t++;
	static $cat_temp=array();
	$condtion = array('pid'=>$pid);
	if($modelid)
	{
		$condtion['model'] = $modelid;
	}
	$data = M('category')-> findAll($condtion,'ordernum','id,pid,model,columnattr,catname');
	$perColArr = D('Content','content')->getPer($per);//2,添加权限，3，修改权限
	if(!empty($data))
	{
		foreach ($data as $key => $val )
		{
			if($val['model']!=2)
			{
				$val['catname'] = str_repeat('&nbsp;',$t*3).'├'.$val['catname'];
			    $val['level'] = $t+1;
			    $cat_temp[] = $val;
			}
			getPerCategoryTree($modelid,$per,$val['id'],$t);
		}
	}
	foreach($cat_temp as $key => $val)
	{
        $cat_temp[$key]['flag'] = true;
		if(!in_array($val['id'],$perColArr))
		{
			unset($cat_temp[$key]);
		}
	}
	return $cat_temp;
}

/**
 * 判断是不是合法的json数据
 */
function is_json($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}


/**
* 字符串加密、解密函数
*
*
* @param	string	$txt		字符串
* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
* @param	string	$key		密钥：数字、字母、下划线
* @param	string	$expiry		过期时间
* @return	string
*/
function rc4($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
	$key_length = 4;
	$key = md5($key != '' ? $key : get_config('imc', 'key'));
	$fixedkey = hash('md5', $key);
	$egiskeys = md5(substr($fixedkey, 16, 16));
	$runtokey = $key_length ? ($operation == 'ENCODE' ? substr(hash('md5', microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';
	$keys = hash('md5', substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
	$string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

	$i = 0; $result = '';
	$string_length = strlen($string);
	for ($i = 0; $i < $string_length; $i++){
		$result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
	}
	if($operation == 'ENCODE') {
		return $runtokey . str_replace('=', '', base64_encode($result));
	} else {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	}
}
/*关闭窗口
@params $alert  弹出内容
*/
function closeWindodw($alert='')
{
	echo '<script type="text/javascript" language="javascript" charset="utf-8">';
	if($alert)
	{
		echo "alert('$alert');";
	}

	echo 'var browserName = navigator.appName;
	if (browserName=="Netscape")
	{
	     window.open("", "_self", "");
	     window.close();
	}
	else
	{
		if (browserName == "Microsoft Internet Explorer")
		{
		    window.opener = "whocares";
			window.opener = null;
			window.open("","_top");
			window.close();
		}
	}';
	echo "</script>";


}

/**
 * 整理子父级关系
 * 必须保证每个信息有级别 主键 父ID
 * @param $arr        需要整理的信息
 * @param $level_key  级别的key值，即当前元素是第几级(深度从1开始)元素
 * @param $pk_key	  主键的key值
 * @param $pid_key    父级的key值
 * @param $child_key  将要放子集的key
 * @return 带有子父集关系的N维数组
 */
function buildChildParent ($arr,$level_key='level',$pk_key='id',$pid_key='pid',$child_key='child')
{
	if(empty($arr))
	{
		return array();
	}

	//置键值为主键
	$_arr = array();
	foreach($arr as $key=>$val)
	{
		$_arr[$val[$pk_key]] = $val;
	}
	unset($arr);

	//梳理子父级关系
	$tmp = array();
	foreach($_arr as $key=>$val)
	{
		$tmp[$val[$level_key]][$val[$pk_key]] = $val;
		$tmp[$val[$level_key]][$val[$pk_key]][$child_key] = array();
	}
	krsort($tmp);
	$loop = count($tmp);
	for ($i=$loop;$i>1;$i--)
	{
		$t1 = $tmp[$i];
		unset($tmp[$i]);
		foreach ($t1 as $key => $val )
		{
			$tmp[$i-1][$val[$pid_key]][$child_key][] = $val;
		}
	}
	return !empty($tmp) ? current($tmp) : array();
}

/**
 * 根据过滤字符串过滤字符串数组中的元素
 * @param $arr 字符串数组
 * @param $filter 过滤用字符串
 * @param $flag 过滤方式 true匹配法  false排除法
 */
function filterArrByStr($arr,$filter,$flag=true) {
	$data = array();
	foreach ($arr as $key=>$value) {
		if (stristr($value , $filter) == $flag) {
			$data[] = $value;
		}
	}
	return $data;
}

//获取key内容
function get_key($item='') {
	//key文件目录
    $dir_root = str_replace(APPNAME.DS, '', DIR_ROOT);
    $filePath = $dir_root.DS.'library/mainone/key.php';
	if (!is_file($filePath))  {
        return '';
    }
	//获取key
	$content = file_get_contents($filePath);
    $key="474SRQMyf0Q=";
    $iv="3rSxYqka++A=";
    $crypt=new DES($key,$iv);
    $destr = $crypt->decrypt($content);
    $destr = strtolower($destr);
    $arr = explode('|', $destr);
    $domain = explode(',', $arr[0]);
    $module = explode(',', $arr[1]);
	if($item='domain') {
		return $domain;
	}
	else if ($item='module') {
		return $module;
	}else {
        $key['domain'] = $domain;
        $key['module'] = $module;
        return $key;
    }
}

function ImageCreateFromBMP($filename) {
    if (!$f1 = fopen($filename, "rb"))
        returnFALSE;
    $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));
    if ($FILE['file_type'] != 19778)
        returnFALSE;
    $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' .
            '/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
            '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));
    $BMP['colors'] = pow(2, $BMP['bits_per_pixel']);
    if ($BMP['size_bitmap'] == 0)
        $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
    $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel'] / 8;
    $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
    $BMP['decal'] = ($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
    $BMP['decal']-=floor($BMP['width'] * $BMP['bytes_per_pixel'] / 4);
    $BMP['decal'] = 4 - (4 * $BMP['decal']);
    if ($BMP['decal'] == 4)
        $BMP['decal'] = 0;
    $PALETTE = array();
    if ($BMP['colors'] < 16777216) {
        $PALETTE = unpack('V' . $BMP['colors'], fread($f1, $BMP['colors'] * 4));
    }
    $IMG = fread($f1, $BMP['size_bitmap']);
    $VIDE = chr(0);
    $res = imagecreatetruecolor($BMP['width'], $BMP['height']);
    $P = 0;
    $Y = $BMP['height'] - 1;
    while ($Y >= 0) {
        $X = 0;
        while ($X < $BMP['width']) {
            if ($BMP['bits_per_pixel'] == 24)
                $COLOR = unpack("V", substr($IMG, $P, 3) . $VIDE);
            elseif ($BMP['bits_per_pixel'] == 16) {
                $COLOR = unpack("n", substr($IMG, $P, 2));
                $COLOR[1] = $PALETTE[$COLOR[1] + 1];
            } elseif ($BMP['bits_per_pixel'] == 8) {
                $COLOR = unpack("n", $VIDE . substr($IMG, $P, 1));
                $COLOR[1] = $PALETTE[$COLOR[1] + 1];
            } elseif ($BMP['bits_per_pixel'] == 4) {
                $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));
                if (($P * 2) % 2 == 0)
                    $COLOR[1] = ($COLOR[1] >> 4);

                    else$COLOR[1] = ($COLOR[1] & 0x0F);
                $COLOR[1] = $PALETTE[$COLOR[1] + 1];
            }
            elseif ($BMP['bits_per_pixel'] == 1) {
                $COLOR = unpack("n", $VIDE . substr($IMG, floor($P), 1));
                if (($P * 8) % 8 == 0)
                    $COLOR[1] = $COLOR[1] >> 7;
                elseif (($P * 8) % 8 == 1)
                    $COLOR[1] = ($COLOR[1] & 0x40) >> 6;
                elseif (($P * 8) % 8 == 2)
                    $COLOR[1] = ($COLOR[1] & 0x20) >> 5;
                elseif (($P * 8) % 8 == 3)
                    $COLOR[1] = ($COLOR[1] & 0x10) >> 4;
                elseif (($P * 8) % 8 == 4)
                    $COLOR[1] = ($COLOR[1] & 0x8) >> 3;
                elseif (($P * 8) % 8 == 5)
                    $COLOR[1] = ($COLOR[1] & 0x4) >> 2;
                elseif (($P * 8) % 8 == 6)
                    $COLOR[1] = ($COLOR[1] & 0x2) >> 1;
                elseif (($P * 8) % 8 == 7)
                    $COLOR[1] = ($COLOR[1] & 0x1);
                $COLOR[1] = $PALETTE[$COLOR[1] + 1];
            } else
                returnFALSE;
            imagesetpixel($res, $X, $Y, $COLOR[1]);
            $X++;
            $P+=$BMP['bytes_per_pixel'];
        }
        $Y--;
        $P+=$BMP['decal'];
    }
    fclose($f1);
    return$res;
}

/**
 * 生成缩略图(按百分比)
 * @param String $src_img 源图绝对完整地址{带文件名及后缀名}
 * @param String $dst_img 目标图绝对完整地址{带文件名及后缀名}
 * @param Int $dst_img_w 图片缩放后的宽度
 * @return boolean true：成功  false：失败
 * @author Lee 2014-10-08
 */
function img2thumb($src_img, $dst_img, $dst_img_w) {
    //检查源图是否存在
    if (!is_file($src_img)) {
        return false;
    }
    //检查缩略图的比例
    $check_dst_img_w = filter_var($dst_img_w, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)));
    if (false === $check_dst_img_w) {
        return false;
    }

    //获得源图相关信息
    $srcinfo = getimagesize($src_img);
    //源图宽
    $src_w = $srcinfo[0];
    //源图高
    $src_h = $srcinfo[1];
    //源图类型
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));

    switch($type){
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($src_img);
            break;
        case 'gif':
            $src = imagecreatefromgif($src_img);
            break;
        case 'png':
            $src = imagecreatefrompng($src_img);
            break;
        case 'wbm':
            $src = imagecreatefromwbmp($src_img);
            break;
        case 'bmp':
            $src = ImageCreateFromBMP($src_img);
            break;
    }

    //缩略图宽
    $dst_w = $dst_img_w;
    //缩略图高
    $dst_h = floor($dst_w * ($src_h/$src_w));
    //新建一个真彩色图像
    $dst = imagecreatetruecolor($dst_w, $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if (function_exists('imagecopyresampled')) {
        //重采样拷贝部分图像并调整大小
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    } else {
        //复制新图并调整大小
        imagecopyresized($dst, $src, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    //输出图象到浏览器或文件
    imagejpeg($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}

/**
 * 批量生成缩略图（用于手机站）
 * @param String $src_img 源图绝对完整地址{带文件名及后缀名}
 * @param Float $dst_img_m_w 中图缩放的宽度
 * @param Float $dst_img_s_w 小图缩放的宽度
 * @author Lee 2014-10-08
 */
function batchImageZoom($src_img, $dst_img_m_w = 640, $dst_img_s_w = 320) {
    //将所有的反斜线（\）替换为（/）
    $src_img = str_replace("\\", "/", $src_img);
    $src_arr = explode('/',$src_img);
    $index = array_search('uploadfile', $src_arr);
    $index++;

    $m_image_path = '';
    $s_image_path = '';
    for($i=0;$i<count($src_arr);$i++){
        $m_image_path .= $src_arr[$i].'/';
        $s_image_path .= $src_arr[$i].'/';
        if($i == $index){
            $m_image_path .= 'm/';
            $s_image_path .= 's/';
        }
    }
    $m_image_path = rtrim($m_image_path, '/');
    $s_image_path = rtrim($s_image_path, '/');

    //中图的路径
    mk_dir(dirname($m_image_path));
    //生成中缩略图
    img2thumb($src_img, $m_image_path, $dst_img_m_w);

    //小图的路径
    mk_dir(dirname($s_image_path));
    //生成小缩略图
    img2thumb($src_img, $s_image_path, $dst_img_s_w);
}

/**
 * 判断手机站，是不是通过app访问的
 * @return boolean  true：通过app访问的  false：通过手机浏览器访问的
 * @author Lee 2014-09-30
 */
function isAppVisit() {
    $app_visit = Cookie::get('phone_app_visit');
    if (1 === $app_visit) {
        return true;
    }
    return false;
}
/**
 * 格式化数组 兼容 array_column
 * @return boolean  array
 * @author 一梦一尘
 */

function mo_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull            = (is_null($indexKey))?true :false;
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
        $result                         = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp= array_slice($row, $columnKey, 1);
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                  $key = array_slice($row, $indexKey, 1);
                  $key = (is_array($key) && !empty($key))?current($key):null;
                  $key = is_null($key)?0:$key;
                }else{
                  $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}


/**
 * @传递数据以易于阅读的样式格式化后输出
 * @author wake1
 */
function p($data){
    // 定义样式
    $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
    // 如果是boolean或者null直接显示文字；否则print
    if (is_bool($data)) {
        $show_data=$data ? 'true' : 'false';
    }elseif (is_null($data)) {
        $show_data='null';
    }else{
        $show_data=print_r($data,true);
    }
    $str.=$show_data;
    $str.='</pre>';
    echo $str;
}


/**
 * @获取无限极分类
 * @author wake1
 */
function limitlessLevel($categorys, $level = 0, $parentId = 0) {
        static $limitlessLevelCategorys = array();
        // 从$categorys数组找出所有的顶级分类的分类
        foreach ($categorys as $category) {
            if ($category['pid'] == $parentId) {
                $category['level'] = $level;
                $limitlessLevelCategorys[] = $category;
                // 无限级分类核心代码
                // 找儿子
                limitlessLevel($categorys, $level + 1, $category['id']);
            }
        }
        return $limitlessLevelCategorys;
    }


/**
 * 是否是AJAx提交的
 * @return bool
 * @author wake1
 */
function isAjax(){
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        return true;
    }else{
        return false;
    }
}

/**
 * 是否是GET提交的
 * @author wake1
 */
function isGet(){
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

/**
 * 是否是POST提交
 * @author wake1
 * @return int
 */
function isPost() {
    return ($_SERVER['REQUEST_METHOD'] == 'POST'  && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? 1 : 0;
}


/**
 * join 关联
 */
function joinres($sql)
{
    $result = mysql_query($sql);
    $data = array();
    while($row=mysql_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}


/**
 * 裁切上传完毕的图片
 * @author wake1
 * @param 原图地址
 * @param 要替换的图片名称
 */
function my_image_resize($src_file, $dst_file , $new_width , $new_height) {
        $new_width= intval($new_width);
        $new_height=intval($new_width);
         if($new_width <1 || $new_height <1) {
         echo "params width or height error !";
         exit();
         }
         if(!file_exists($src_file)) {
         echo $src_file . " is not exists !";
         exit();
         }
         // 图像类型
         $type=exif_imagetype($src_file);
         $support_type=array(IMAGETYPE_JPEG , IMAGETYPE_PNG , IMAGETYPE_GIF);
         if(!in_array($type, $support_type,true)) {
         echo "图片的文件类型： only support jpg , gif or png";
         exit();
         }
         //Load image
         switch($type) {
         case IMAGETYPE_JPEG :
         $src_img=imagecreatefromjpeg($src_file);
         break;
         case IMAGETYPE_PNG :
         $src_img=imagecreatefrompng($src_file);
         break;
         case IMAGETYPE_GIF :
         $src_img=imagecreatefromgif($src_file);
         break;
         default:
         echo "Load image error!";
         exit();
         }
         $w=imagesx($src_img);
         $h=imagesy($src_img);
         $ratio_w=1.0 * $new_width / $w;
         $ratio_h=1.0 * $new_height / $h;
         $ratio=1.0;
         // 生成的图像的高宽比原来的都小，或都大 ，原则是 取大比例放大，取大比例缩小（缩小的比例就比较小了）
         if( ($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1)) {
         if($ratio_w < $ratio_h) {
         $ratio = $ratio_h ; // 情况一，宽度的比例比高度方向的小，按照高度的比例标准来裁剪或放大
         }else {
         $ratio = $ratio_w ;
         }
         // 定义一个中间的临时图像，该图像的宽高比 正好满足目标要求
         $inter_w=(int)($new_width / $ratio);
         $inter_h=(int) ($new_height / $ratio);
         $inter_img=imagecreatetruecolor($inter_w , $inter_h);
         //var_dump($inter_img);
         imagecopy($inter_img, $src_img, 0,0,0,0,$inter_w,$inter_h);
         // 生成一个以最大边长度为大小的是目标图像$ratio比例的临时图像
         // 定义一个新的图像
         $new_img=imagecreatetruecolor($new_width,$new_height);
         //var_dump($new_img);exit();
         imagecopyresampled($new_img,$inter_img,0,0,0,0,$new_width,$new_height,$inter_w,$inter_h);
         switch($type) {
         case IMAGETYPE_JPEG :
         imagejpeg($new_img, $dst_file,100); // 存储图像
         break;
         case IMAGETYPE_PNG :
         imagepng($new_img,$dst_file,100);
         break;
         case IMAGETYPE_GIF :
         imagegif($new_img,$dst_file,100);
         break;
         default:
         break;
         }
         } // end if 1
         // 2 目标图像 的一个边大于原图，一个边小于原图 ，先放大平普图像，然后裁剪
         // =if( ($ratio_w < 1 && $ratio_h > 1) || ($ratio_w >1 && $ratio_h <1) )
         else{
         $ratio=$ratio_h>$ratio_w? $ratio_h : $ratio_w; //取比例大的那个值
         // 定义一个中间的大图像，该图像的高或宽和目标图像相等，然后对原图放大
         $inter_w=(int)($w * $ratio);
         $inter_h=(int) ($h * $ratio);
         $inter_img=imagecreatetruecolor($inter_w , $inter_h);
         //将原图缩放比例后裁剪
         imagecopyresampled($inter_img,$src_img,0,0,0,0,$inter_w,$inter_h,$w,$h);
         // 定义一个新的图像
         $new_img=imagecreatetruecolor($new_width,$new_height);
         imagecopy($new_img, $inter_img, 0,0,0,0,$new_width,$new_height);
         switch($type) {
         case IMAGETYPE_JPEG :
         imagejpeg($new_img, $dst_file,100); // 存储图像
         break;
         case IMAGETYPE_PNG :
         imagepng($new_img,$dst_file,100);
         break;
         case IMAGETYPE_GIF :
         imagegif($new_img,$dst_file,100);
         break;
         default:
         break;
        }
    }
}
        // my_image_resize('demo.jpg','11111.jpg','100px','100px');

/**
 * @param $time
 * @return bool|string
 */
function wordTime($time) {
        $time = (int) substr($time, 0, 10);
        $int = time() - $time;
        $str = '';
        if ($int <= 2){
            $str = sprintf('刚刚', $int);
        }elseif ($int < 60){
            $str = sprintf('%d秒前', $int);
        }elseif ($int < 3600){
            $str = sprintf('%d分钟前', floor($int / 60));
        }elseif ($int < 86400){
            $str = sprintf('%d小时前', floor($int / 3600));
        }elseif ($int < 2592000){
            $str = sprintf('%d天前', floor($int / 86400));
        }else{
            $str = date('Y-m-d H:i:s', $time);
        }
        return $str;
 }

function worldge($cid)
{
    return  '/category/Category/list/cid/' . $cid;
}

/**
 * 检测是否是邮箱
 * @param $email
 * @param bool|false $test_mx
 * @return bool
 */
function is_valid_email($email, $test_mx = false)
{
    if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
        if($test_mx)
        {
            list($username, $domain) = split("@", $email);
            return getmxrr($domain, $mxrecords);
        }
        else
            return true;
    else
        return false;
}

/**
 * 过滤input 数据
 * @param $data
 * @return string
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



/**
 *  生成4位随机验证码，并存入缓存
 * @param $len
 * @param null $chars
 * @return string
 */
function getRandomString($len, $chars=null)
{
    if (is_null($chars)){
        $chars = "1234567890";
    }
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
        $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}

/**
 * 获取idp
 * @return string
 */
function getip()
{
        if (isset($_SERVER)) 
        {
                if (isset($_SERVER[HTTP_X_FORWARDED_FOR]) && strcasecmp($_SERVER[HTTP_X_FORWARDED_FOR], "unknown"))//代理
                {
                        $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
                } 
                elseif(isset($_SERVER[HTTP_CLIENT_IP]) && strcasecmp($_SERVER[HTTP_CLIENT_IP], "unknown"))
                {
                        $realip = $_SERVER[HTTP_CLIENT_IP];
                } 
                elseif(isset($_SERVER[REMOTE_ADDR]) && strcasecmp($_SERVER[REMOTE_ADDR], "unknown"))
                {
                        $realip = $_SERVER[REMOTE_ADDR];
                } 
                else
                {
                        $realip = 'unknown';
                }
        } 
        else
        {
                if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
                {
                        $realip = getenv("HTTP_X_FORWARDED_FOR");
                }
                elseif(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
                {
                        $realip = getenv("HTTP_CLIENT_IP");
                } 
                elseif(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                {
                        $realip = getenv("REMOTE_ADDR");
                } 
                else
                {
                        $realip = 'unknown';
                }
        } 
        return $realip;
}

function modifyipcount($ip)
{
        // <-----------------------数据库的连接省略------------------------->
        $query="SELECT * FROM `mo_ip` where ipdata='".$ip."'";
        $result=mysql_query($query);
        $row=mysql_fetch_array($result);
        $iptime=time();
        $day=date('j');
        if(!$row)
        {
                $query="INSERT INTO `mo_ip` (ipdata,iptime) VALUES ('".$ip."','".$iptime."')";
                mysql_query($query);
                $query="SELECT day,todayipcount,allipcount FROM `mo_count`";
                $result=mysql_query($query);
                $row=mysql_fetch_array($result);
                $allipcount=$row['allipcount']+1;
                $todayipcount=$row['todayipcount']+1;
                if($day==$row['day'])
                {
                        $query="UPDATE `mo_count` SET allipcount='".$allipcount."',todayipcount='".$todayipcount."'";
                }
                else
                {
                        $query="UPDATE `mo_count` SET allipcount='".$allipcount."',day='".$day."',todayipcount='1'";
                }
                 mysql_query($query);
        }
        else
        {
                $query="SELECT iptime FROM `mo_ip` WHERE ipdata='".$ip."'";
                $result=mysql_query($query);
                $row=mysql_fetch_array($result);
                $query="SELECT day,todayipcount,allipcount FROM `mo_count`";
                $result=mysql_query($query);
                $row1=mysql_fetch_array($result);
                if($iptime-$row['iptime']>86400)
                {
                                                $query="UPDATE `mo_ip` SET iptime='".$iptime."' WHERE ipdata='".$ip."'";
                 mysql_query($query);
                        $allipcount=$row1['allipcount']+1;
                        if($day==$row1['day'])
                        {
                                $query="UPDATE `mo_count` SET allipcount='".$allipcount."'";
                        }
                        else
                        {
                                $query="UPDATE `mo_count` SET allipcount='".$allipcount."',day='".$day."',todayipcount='1'";
                        }
                         mysql_query($query);
                }
                if($day!=$row1['day'])
                {
                        $query="UPDATE `mo_count` SET day='".$day."',todayipcount='1'";
                         mysql_query($query);
                }        
        }
}

/**
 * 获取剩余时间
 * @param $begin_time
 * @param $end_time
 * @return string
 */
function timediff($begin_time,$end_time){
            if($begin_time < $end_time){
                $starttime = $begin_time;
                $endtime = $end_time;
            }else{
                $starttime = $end_time;
                $endtime = $begin_time;
            }

            //计算天数
            $timediff = $endtime-$starttime;
            $days = intval($timediff/86400);
            //计算小时数
            $remain = $timediff%86400;
            $hours = intval($remain/3600);
            //计算分钟数
            $remain = $remain%3600;
            $mins = intval($remain/60);
            //计算秒数
            $secs = $remain%60;
            //数组的形式返回
            // $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
            //字符串的形式返回
            $res = $days . "天" . $hours . "小时" . $mins . "分钟" . $secs . "秒";
            return $res;
        }

/**
 * 检测图片是否存在
 * @param $url 要显示的图片路径
 * @param 要替换的安全图片
 */

function extends_path($url, $path)
{
    if($url)
    {
        return $url;
    }else{
        return $path;
    }
}


/**
* @desc 检查远程图片是否存在
* @param string $url 图片远程地址
* @return boolean $found 存在为true,否则false
*/
function check_remote_file_exists($url) {
//curl初始化
$curl = curl_init($url);
//不取回数据
curl_setopt($curl, CURLOPT_NOBODY, true);
//发送请求,接收结果
$result = curl_exec($curl);
$found = false;
if ($result !== false) {
//检查http响应码是否为200
$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($statusCode == 200) {
$found = true;
}
}
//关闭curl资源
curl_close($curl);
//返回结果
return $found;
}

/**
 * 最新祭拜 数据
 * @return mixed
 */
function newjibai()
{
    $result = M('memorial_buy_goods_record')->order('id desc')->limit('0,10')->select();
    foreach ($result as $k => $v) {
        if ($v) {
            $username = M('member')->field('username')
                ->where(array('id' => $v['uid']))->getOne();
            $result[$k]['username'] = $username['username'];
            if ($username['username'] == false) {
                $email = M('member')->field('email')
                    ->where(array('id' => $v['uid']))->getOne();
                if ($email['email']) {
                    $result[$k]['username'] = $email['email'];
                } else {
                    $result[$k]['username'] = '游客';
                }
            }
        }
    }
    return $result;
}

/**
 * 显示表情
 * @param $str
 * @return mixed
 */
function ubbReplace($str){ 
    $str = str_replace(">",'<；',$str); 
    $str = str_replace(">",'>；',$str); 
    $str = str_replace("\n",'>；br/>；',$str); 
    $str = preg_replace("[\[em_([0-9]*)\]]","<img src=\"/template/default/images/arclist/$1.gif\" />",$str); 
    return $str; 
}


/**
 * 利用一下 strpos() 函数
 * @param unknown_type $haystack
 * @param unknown_type $needle
 */
function isInString1($haystack, $needle)
{
//防止$needle 位于开始的位置
	$haystack = '-_-!' . $haystack;
	if(strpos($haystack, $needle)) {
		return true;
	}else{
		return false;
	}
}

/**
 * @param $name cookie名称
 * @param $id 文章id
 * @param $table 表id
 * @param $click 表内的点击字段
 * @param $t 禁止时间的时间
 */
function update_click($name, $id, $table, $click, $t)
{
    if(!isset($_COOKIE["$name" . $id])){
        setcookie("$name" . $id, time()+$t); //第一次访问此页面
        //数据库更新
        //进来访问量+1
        $sql = "UPDATE mo_{$table} SET {$click}={$click}+1 WHERE id={$id}";
        M("$table")->query($sql);
    }else if($_COOKIE["$name" . $id] > time()){
        //第二次重复访问 如果 cookie的时间大于我当前的时间
    }else{
        setcookie("$name" . $id, false);
    }
}
