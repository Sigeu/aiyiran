<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 应用入口
 *
 * 配置一些系统基本常量
 *
 * 文件修改记录：
 * <br>王蕊  2013-3-11 上午11:53:07 创建此文件
 *
 * @author     王蕊<wangrui@mail.b2b.cn>  2013-3-11 上午11:53:07
 * @filename   index.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: index.php 11 2013-08-09 07:40:20Z zhoulifeng $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */

define('IN_MAINONE', true);


/**
 * 定义URL的分割符,注:文件，方法命名中不能使用该分割符
 */
//define('URL_SEGEMENTATION', '/');

/**
 * 是否开启自定义URL路由功能(开启:true, 关闭:false, 默认:false)
 */
//define('CUSTOM_URL_ROUTER', true);

/**
 * 定义项目的视图文件格式:(false:php, true:html, 默认:false)
 */
define('SYS_VIEW', true);



define('IN_ADMIN',true);

/**
 * 定义系统时间
 */
define('SYS_TIME', time());

/**
 * 调试(debug)运行模式(开启:true, 关闭:false, 默认:false)
 */
define('SYS_DEBUG', false);

/**
 * 是否开启重写(rewrite)功能(开启:true, 关闭:false, 默认:false)
 * 设置URL的Rewrite功能 REWRITE模式  在开启了Apache的URL_REWRITE模块后，就可以启用REWRITE模式
 */
define('SYS_REWRITE', true);

/**
 * URL模式
 */
define('URL_MODEL', '1');// 普通模式=0 REWRITE模式=1



/**
 * 设置路由伪静态
 * 定义URL后缀,注:只有开启重写(rewrite)时,定义才有效
 */
define('URL_SUFFIX', '.html');



/**
 * 项目根路径
 */
define('DIR_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * 项目静态文件
 */
define('DIR_STATIC', dirname(__FILE__) . '/../static' . DIRECTORY_SEPARATOR);

/**
 * 项目上传目录
 */
define('DIR_UPLOADFILE', dirname(__FILE__) . '/../static/uploadfile' . DIRECTORY_SEPARATOR);

/**
 * 项目上传目录
 */
define('DIR_UPLOAD_TEMP', dirname(__FILE__) . '/../static/uploadfile/temp' . DIRECTORY_SEPARATOR);

/**
 * 基础架构根目录
 */
$dir_bf_root	= dirname(__FILE__) . '/../library/mainone' . DIRECTORY_SEPARATOR;

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
 * 系统根目录
 * 带/
 */
define('DIR_WEB_ROOT', $dir_web_root);



//define('DIR_VIEW', DIR_WEB_ROOT);
define('APPNAME', 'imc');

/**
 * 定义默认模块
 *
 */
define('DEFAULT_MODULE', 'members');



/**
 * 运行基础框架的初始化文件
 */
require_once DIR_BF_ROOT . 'Application.php';

// echo DIR_WEB_ROOT;
// echo APPNAME;
// echo URL_MODEL;
/**
 * 启动网站进程
 */
app::run();