<?php
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('IN_MAINONE') || define('IN_MAINONE', true);

defined('DIR_ROOT') || define('DIR_ROOT', dirname(__FILE__) .'/../../..'. DIRECTORY_SEPARATOR);



/**
 * �����ܹ���Ŀ¼
*/
$dir_bf_root	= DIR_ROOT . '/library/mainone' . DIRECTORY_SEPARATOR;
$dir_web_root  	= dirname(__FILE__) . DIRECTORY_SEPARATOR;
$dir_bf_root 	= str_replace(array('\\', '//'), '/', $dir_bf_root);
$dir_web_root 	= str_replace(array('\\', '//'), '/', $dir_web_root);
$dir_bf_root 	= (substr($dir_bf_root, -1) == '/') ? $dir_bf_root : $dir_bf_root . DIRECTORY_SEPARATOR;
$dir_web_root  	= (substr($dir_web_root, -1) == '/') ? $dir_web_root : $dir_web_root . DIRECTORY_SEPARATOR;

/**
 * �����ܹ���Ŀ¼
 * library/mainone/
 */
defined('DIR_BF_ROOT') || define('DIR_BF_ROOT', $dir_bf_root);

/**
 * ��ĿconfigĿ¼��·��
 */
 defined('DIR_CONFIG') || define('DIR_CONFIG', DIR_ROOT . 'application/config' . DIRECTORY_SEPARATOR);

/**
 * ϵͳ��Ŀ¼
 * ��/
*/
 defined('DIR_WEB_ROOT') || define('DIR_WEB_ROOT', $dir_web_root);


include_once DIR_ROOT.'/library/mainone/base/Base.php';
include_once DIR_ROOT.'library/mainone/base/Model.php';
include_once DIR_ROOT.'library/mainone/base/DbFactory.php';
include_once DIR_ROOT.'library/mainone/db/DbMysql.php';
include_once DIR_ROOT.'library/mainone/classes/Load.php';
include_once DIR_ROOT.'library/mainone/functions/common.php';
include_once DIR_ROOT.'library/mainone/functions/functions.php';





































