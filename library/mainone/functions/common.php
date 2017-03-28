<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * common.php   基础函数库（快捷操作）
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-19 下午2:49:07
 * @filename   common.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')) {
	exit('No Permission');
}

/**
* 实例化一个没有模型文件的Model
* @param $name       表名（不包含前缀）
* @param $prefix     表的前缀
* @param $dbconfig   数据库配置文件名 database
* @param $dbsetting  数据库配置名 default/link1
* @return object BaseModel
*/

function M($name,$prefix='',$dbsetting='',$dbconfig='')
{
	static $_model = array();
	$tablename = strtolower(parse_name($name));
	$baseModel = new Model('',$tablename,$dbconfig,$dbsetting,$prefix);
	$_model[$name] = $baseModel;

	return $_model[$name];

}
/**
* 实例化自定义的模型类
* @param $name 文件名
* @param $module 模块名（不同模块间调用）
* @param $app 项目名（home,admin）
* @return object Model
*/

function D($name,$module='',$app='')
{
	static $_model = array();
	if (empty($module))
	{
		$module = app::getModuleName();
	}
	if (empty($app))
	{
		$app = APPNAME;
	}
	$classname =  md5($app.$module.$name);
	if(!isset($_model[$classname]))
	{
	    $_model[$classname] = Load::loadModel($name,$module,$app);
	}
	return $_model[$classname];
}
/**
 * 获取配置文件信息
 * @param string $filename  配置文件名
 * @param string $item      配置项
 * @param string $app       应用名
 * @return mixed $config    配置内容
 */
function C($filename,$item='',$app="")
{
	$value = get_config($filename,$item,$app);

	return $value;
}

/**
* 去除代码中的空白和注释
* @param $content
* @return string
*/

function strip_whitespace($content)
{
    $stripStr = '';
    //分析php源码
    $tokens = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++)
    {
        if (is_string($tokens[$i]))
        {
            $last_space = false;
            $stripStr .= $tokens[$i];
        } else
        {
            switch ($tokens[$i][0])
            {
                //过滤各种PHP注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //过滤空格
                case T_WHITESPACE:
                    if (!$last_space)
                    {
                        $stripStr .= ' ';
                        $last_space = true;
                    }
                    break;
                case T_START_HEREDOC:
                    $stripStr .= "<<<MO\n";
                    break;
                case T_END_HEREDOC:
                    $stripStr .= "MO;\n";
                    for($k = $i+1; $k < $j; $k++)
                    {
                        if(is_string($tokens[$k]) && $tokens[$k] == ';')
                        {
                            $i = $k;
                            break;
                        } else if($tokens[$k][0] == T_CLOSE_TAG)
                        {
                            break;
                        }
                    }
                    break;
                default:
                    $last_space = false;
                    $stripStr .= $tokens[$i][1];
            }
        }
    }
    return $stripStr;
}


/**
 * 字符串命名风格转换
 * type
 * =0 将Java风格转换为C的风格
 * =1 将C风格转换为Java的风格
 * @access protected
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type=0)
{
    if ($type)
    {
        return ucfirst(preg_replace("/_([a-zA-Z])/e", "strtoupper('\\1')", $name));
    } else
    {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}

/**
* JS提示框
* @param $info  提示的信息
* @return $url  跳转的URL （/index.php/seniorqiye/account/pwd）
*/
function alert($info, $url='')
{
	$str = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><script type="text/javascript">alert("'.$info.'");window.location.href="';
	$str .= ($url=='') ? 'javascript:history.back()' : $url;
	$str .= '";</script>';
	echo $str;
}

if(!function_exists("json_encode"))
{
   //json_encode替代函数
   function json_encode($var) {
        switch (gettype($var)) {
            case 'boolean':
                return $var ? 'true' : 'false'; // Lowercase necessary!
            case 'integer':
            case 'double':
                return $var;
            case 'resource':
            case 'string':
                return '"'. str_replace(array("\r", "\n", "<", ">","/"),
                    array('\r', '\n', '<', '>','\/'),
                    $var) .'"';
            case 'array':
                if (empty ($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
                    $output = array();
                    foreach ($var as $v) {
                        $output[] = json_encode($v);
                    }
					$result = '['. implode(', ', $output) .']';
                    return $result;
                }

            case 'object':
                $output = array();
                foreach ($var as $k => $v) {
                    $output[] = json_encode(strval($k)) .':'.json_encode($v);
                }
                return '{'. implode(', ', $output) .'}';
            default:
                return 'null';
        }

     }
 }



 /**
  * 获取系统信息
  */
 function get_sysinfo() {
 	$sys_info['os']             = PHP_OS;
 	$sys_info['zlib']           = function_exists('gzclose');//zlib
 	$sys_info['safe_mode']      = (boolean) ini_get('safe_mode');//safe_mode = Off
 	$sys_info['safe_mode_gid']  = (boolean) ini_get('safe_mode_gid');//safe_mode_gid = Off
//  	$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : L('no_setting');
 	$sys_info['socket']         = function_exists('fsockopen') ;
 	$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
 	$sys_info['phpv']           = phpversion();
 	$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
 	return $sys_info;
 }
