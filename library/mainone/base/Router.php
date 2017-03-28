<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * URL路由信息处理
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-11 下午6:12:32 创建此文件
 * <br>周立峰  2012-12-11 下午6:12:32 修改此文件 添加了某某功能
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-11 下午6:12:32
 * @filename   Router.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: Router.php 1106 2013-12-13 06:44:44Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) {
	exit();
}

abstract class Router {

	/**
	 * 获取当前的module、controller名及action名
	 *
	 * @access public
	 * @return array
	 */
	public static function Request() {

		//网址为传统的url时, 如: index.php?module=module&controller=user&action=add&id=uid
		if (isset($_GET['controller'])) {
			//获取module,controller及action名称
			$moduleName = ($_GET['module'] == true) ? htmlspecialchars(
							trim($_GET['module'])) : DEFAULT_MODULE;
			$controllerName = ($_GET['controller'] == true) ? htmlspecialchars(
							trim($_GET['controller'])) : DEFAULT_CONTROLLER;
			$actionName = (isset($_GET['action']) && $_GET['action'] == true) ? htmlspecialchars(
							trim($_GET['action'])) : DEFAULT_ACTION;
			return array('module' => strtolower($moduleName),
					'controller' => ucfirst(strtolower($controllerName)),
					'action' => strtolower($actionName));
		}

		//分析网址
		if (isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['REQUEST_URI'])) {
			//当项目开启Rewrite设置时
			if (SYS_REWRITE === false) {
				$pathUrlString = strlen($_SERVER['SCRIPT_NAME'])
						> strlen($_SERVER['REQUEST_URI']) ? $_SERVER['SCRIPT_NAME']
						: $_SERVER['REQUEST_URI'];
				$pathUrlString = str_replace($_SERVER['SCRIPT_NAME'], '',
						$pathUrlString);
			} else {
				$pathUrlString = str_replace(
						'/' . ENTRY_SCRIPT_NAME, '',

						$_SERVER['REQUEST_URI']);
				//去掉伪静态网址后缀
				$pathUrlString = str_replace(URL_SUFFIX, '', $pathUrlString);
			}

			//如果网址含有'?'则过滤掉问号及其后面的所有字符串
			$pos = strpos($pathUrlString, '?');
			if ($pos !== false) {
				$pathUrlString = substr($pathUrlString, 0, $pos);
			}
            $filter_str = PATH_RUN_FOLDER;
            if (APPNAME != 'home') {
                $filter_str .= APPNAME . '/';
            }
            $pathUrlString = substr($pathUrlString, strlen($filter_str));
            //提取有用数据
			$urlInfoArray = explode(URL_SEGEMENTATION,
					str_replace('/', URL_SEGEMENTATION, $pathUrlString));
            //$module
            $moduleName = (isset($urlInfoArray[1])
                    && $urlInfoArray[1] == true) ? $urlInfoArray[1]
                    : DEFAULT_MODULE;
            //controller
            $controllerName = (isset($urlInfoArray[2])
                    && $urlInfoArray[2] == true) ? $urlInfoArray[2]
                    : DEFAULT_CONTROLLER;
            //action
            $actionName = (isset($urlInfoArray[3])
                    && $urlInfoArray[3] == true) ? $urlInfoArray[3]
                    : DEFAULT_ACTION;
            if($moduleName!="html"||$moduleName!="static")
            {
                //将网址URL中的参数变量及其值赋值到$_GET数组中
                if (($totalNum = sizeof($urlInfoArray)) > 5)
                {
                    for ($i = 4; $i < $totalNum; $i += 2)
                    {
                        if (!$urlInfoArray[$i]) {
                            continue;
                        }
                        $_GET[$urlInfoArray[$i]] = $urlInfoArray[$i + 1];
                    }
                }
            }
			//删除不必要的变量,清空内存占用
			unset($urlInfoArray);
			return array('module' => strtolower($moduleName),
					'controller' => ucfirst(strtolower($controllerName)),
					'action' => strtolower($actionName));
		}

		//运行环境是否为CLI模式下
		if (PHP_SAPI == 'cli') {
			$moduleName = (isset($_SERVER['argv'][1])
					&& $_SERVER['argv'][1] == true) ? strtolower(
							$_SERVER['argv'][1]) : DEFAULT_MODULE;
			$controllerName = (isset($_SERVER['argv'][2])
					&& $_SERVER['argv'][2] == true) ? ucfirst(
							strtolower($_SERVER['argv'][2]))
					: DEFAULT_CONTROLLER;
			$actionName = (isset($_SERVER['argv'][3])
					&& $_SERVER['argv'][3] == true) ? strtolower(
							$_SERVER['argv'][3]) : DEFAULT_ACTION;

			if (($totalNum = sizeof($_SERVER['argv'])) > 4) {
				for ($i = 4; $i < $totalNum; $i++) {
					//CLI运行环境下参数模式:如 --debug=true, 不支持 -h -r等模式
					if (substr($_SERVER['argv'][$i], 0, 2) == '--') {
						$pos = strpos($_SERVER['argv'][$i], '=');
						if ($pos !== false) {
							$key = substr($_SERVER['argv'][$i], 2, $pos - 2);
							$_SERVER['argv'][$key] = substr(
									$_SERVER['argv'][$i], $pos + 1);
							unset($_SERVER['argv'][$i]);
						}
					}
				}
			}

			return array('module' => $moduleName,
					'controller' => $controllerName, 'action' => $actionName);
		}

		return array('module' => DEFAULT_MODULE,
				'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION);
	}

	/**
	 * URL组装
	 *
	 * @access public
	 * @param string  $route          module,controller与action
	 * @param array   $params         URL路由其它字段
	 * @param boolean $routingMode    网址是否启用路由模式
	 * @return string URL
	 */
	public static function createUrl($route, $params = null, $routingMode = true) {
		if (!$route) {
			return false;
		}

		//module, controller, action的URL组装
		//$url = self::getBaseUrl()
		$url = self::getBaseUrl() . ((SYS_REWRITE === false) ? ENTRY_SCRIPT_NAME . URL_SEGEMENTATION : '');
		if ($routingMode == true) {
			$url .= str_replace('/', URL_SEGEMENTATION, $route);
		} else {
			$route_array = explode('/', $route);
			$url .= '?module=' . trim($route_array[0]) . '&controller='
					. trim($route_array[1]) . '&action='
					. trim($route_array[2]);
			unset($route_array);
		}

		//参数$params变量的键(key),值(value)的URL组装
		if (!is_null($params) && is_array($params)) {
			$paramsUrl = array();
			if ($routingMode == true) {
				foreach ($params as $key => $value) {
					$paramsUrl[] = trim($key) . URL_SEGEMENTATION
							. trim($value);
				}
				$url .= URL_SEGEMENTATION
						. implode(URL_SEGEMENTATION, $paramsUrl)
						. ((SYS_REWRITE === false) ? '' : URL_SUFFIX);
			} else {
				$url .= '&' . http_build_query($params);
			}
		}
                
		return URL_PROTOCOL . str_replace('//', URL_SEGEMENTATION, $url);
	}

	/**
	 * 获取当前的URL
	 *
	 * @access public
	 * @return string  URL
	 */
	public static function getBaseUrl() {
            return str_replace(URL_PROTOCOL, '', HOST_NAME . APPNAME . URL_SEGEMENTATION);
	}
}
