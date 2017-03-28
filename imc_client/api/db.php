<?php
define('IN_MAINONE', true);
define('DS', DIRECTORY_SEPARATOR);
/**
 * 定义系统时间
*/
define('SYS_TIME', time());

/**
 * 调试(debug)运行模式(开启:true, 关闭:false, 默认:false)
*/
define('SYS_DEBUG', true);

/**
 * 项目根路径
*/
define('DIR_ROOT', dirname(__FILE__) .'../..'. DIRECTORY_SEPARATOR);

/**
 * 基础架构根目录
*/
$dir_bf_root	= dirname(__FILE__) . '/../../library/mainone' . DIRECTORY_SEPARATOR;
$dir_web_root  	= dirname(__FILE__) . DIRECTORY_SEPARATOR;
$dir_bf_root 	= str_replace(array('\\', '//'), '/', $dir_bf_root);
$dir_web_root 	= str_replace(array('\\', '//'), '/', $dir_web_root);
$dir_bf_root 	= (substr($dir_bf_root, -1) == '/') ? $dir_bf_root : $dir_bf_root . DIRECTORY_SEPARATOR;
$dir_web_root  	= (substr($dir_web_root, -1) == '/') ? $dir_web_root : $dir_web_root . DIRECTORY_SEPARATOR;

/**
 * 基础架构根目录
 * library/mainone/
 */
define('DIR_BF_ROOT', $dir_bf_root);
/**
 * 项目config目录的路径
 */
if (!defined('DIR_CONFIG')) {
	define('DIR_CONFIG', DIR_ROOT . 'application'.DS.'config' . DIRECTORY_SEPARATOR);
}
/**
 * 系统根目录
 * 带/
*/
define('DIR_WEB_ROOT', $dir_web_root);
define('APPNAME', 'imc');


include_once '../../library/mainone/base/Base.php';
include_once '../../library/mainone/base/Log.php';
include_once '../../library/mainone/base/Model.php';
include_once '../../library/mainone/base/DbFactory.php';
include_once '../../library/mainone/db/DbMysql.php';
include_once '../../library/mainone/classes/Load.php';
include_once '../../library/mainone/functions/common.php';
include_once '../../library/mainone/functions/functions.php';
include_once '../../library/mainone/functions/tagfun.php';





































