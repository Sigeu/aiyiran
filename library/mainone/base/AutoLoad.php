<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 自动加载
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>周立峰  2012-12-12 下午3:16:11 创建此文件
 * <br>周立峰  2012-12-12 下午3:16:11 修改此文件 添加了某某功能
 *
 * @author     周立峰 <zhoulifeng@mainone.cn>  2012-12-12 下午3:16:11
 * @filename   AutoLoad.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: AutoLoad.php 194 2013-09-23 08:28:19Z zhoulifeng $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    mainone\base
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) {
    exit();
}

class AutoLoad {

    /**
     * 加载基础类
     *
     * 用于自动加载文件路径
     * @var array
     */
    public static $baseClassArray = array(
    'Request'           => 'base/Request.php',
    'HomeController'    => 'base/HomeController.php',
    'AdminController'   => 'base/AdminController.php',
    'Model'             => 'base/Model.php',
    'SysException'      => 'base/SysException.php',
    'Log'               => 'base/Log.php',
    'DbFactory'         => 'base/DbFactory.php',
    'CacheFactory'      => 'base/CacheFactory.php',

    /*工具类*/
    'Cookie'            => 'classes/Cookie.php',
    'Load'              => 'classes/Load.php',
//  'Session'           => 'classes/Session.php',
    'MoZip'             => 'classes/MoZip.php',
    'PclZip'            => 'classes/PclZip.php',
    'MoFile'            => 'classes/MoFile.php',
    'MoFolder'          => 'classes/MoFolder.php',
    'MoValidator'       => 'classes/MoValidator.php',
    'MoXmlParser'       => 'classes/MoXmlParser.php',
    'ArrayPage'         => 'classes/ArrayPage.php',
    'ZipOrUnzip'        => 'classes/ZipOrUnzip.php',
    'Page'              => 'classes/Page.php',
    'DES'               => 'classes/DES.php',
    'Upload'            => 'classes/Upload.php',
    'Mark'              => 'classes/waterMark.php',
    'ContentForm'       => 'classes/ContentForm.php',
    'ContentValue'      => 'classes/ContentValue.php',
    'ContentInput'      => 'classes/ContentInput.php',
    'MessageForm'       => 'classes/MessageForm.php',
    'Pages'             => 'classes/Pages.php',
    'MoPage'            => 'classes/MoPage.php',
    'ContentPage'       => 'classes/ContentPage.php',
    'IP'                => 'classes/IP.php',
    'Session'           => 'classes/Session.php',
    'Smtp'              => 'classes/Smtp.php',
    'SendEmail'         => 'classes/SendEmail.php',
    'BaseTag'           => 'taglib/BaseTag.php',
    'QRcode'            => 'classes/QRcode.php',
    'PhpAnalysis'       => 'classes/PhpAnalysis.php'
    );

    /**
     * 项目文件的自动加载
     *
     * 系统自动加载核心类库文件(base目录内的文件)及运行所需的controller文件、model文件、widget文件等
     *
     * 注:并非程序初始化时将所有的controller,model等文件都统统加载完,再执行其它.理解本函数前一定要先理解AutoLoad的作用.
     * 当程序运行时发现所需的文件没有找到时,AutoLoad才会被激发,按照index()的程序设计来完成对该文件的加载
     *
     * @access public
     * @param string $className 所需要加载的类的名称,注:不含后缀名
     * @return void
     */
    public static function automation($className) {
        //核心类文件的加载分析
        if (isset(self::$baseClassArray[$className])) {
            //当$className在核心类引导数组中存在时, 加载核心类文件
            app::loadFile(DIR_BF_ROOT . self::$baseClassArray[$className]);
        } elseif (substr($className, -10) == 'Controller') {

//          echo DIR_CONTROLLER . app::$module.'/controllers/' . $className . '.php';
            //controller文件自动载分析
            if (is_file(DIR_CONTROLLER . app::$module.'/controllers/' . $className . '.php')) {
                //当文件在controller根目录下存在时,直接加载.

                app::loadFile(DIR_CONTROLLER . app::$module.'/controllers/' . $className . '.php');
            } else {
                //从controller的名称里获取子目录名称,注:controller文件的命名中下划线'_'相当于目录的'/'.
                $pos = strpos($className, '_');
                if ($pos !== false) {
                    //当$controller中含有'_'字符时
                    $childDirName      = strtolower(substr($className, 0, $pos));
                    $controllerFile     = DIR_CONTROLLER . $childDirName . '/' . $className . '.php';
                    if (is_file($controllerFile)) {
                        //当子目录中所要加载的文件存在时
                        app::loadFile($controllerFile);
                    } else {
                        //当文件在子目录里没有找到时
                        Controller::halt('The File:' . $className .'.php is not exists!');
                    }
                } else {
                    //当controller名称中不含有'_'字符串时
                    Controller::halt('The File:' . $className .'.php is not exists!');
                }
            }
        } else if (substr($className, -5) == 'Model') {
            //modlel文件自动加载分析
            if (is_file(DIR_MODEL . $className . '.php')) {
                //当所要加载的model文件存在时
                app::loadFile(DIR_MODEL . $className . '.php');
            } else {
                //当所要加载的文件不存在时,显示错误提示信息
                Controller::halt('The Model file: ' . $className . ' is not exists!');
            }
        } else if(substr($className, -6) == 'Widget') {
            //加载所要运行的widget文件
            if (is_file(DIR_WIDGET . $className . '.php')) {
                //当所要加载的widget文件存在时
                app::loadFile(DIR_WIDGET . $className . '.php');
            } else {
                Controller::halt('The Widget file: ' . $className . ' is not exists!');
            }
        }else if(substr($className,0,6) == 'Smarty'){
            $fileName = PATH_VENDOR . 'smarty' . DIRECTORY_SEPARATOR.'sysplugins'.DIRECTORY_SEPARATOR.strtolower($className).'.php';
            if (is_file($fileName)) {
                //当所要加载的widget文件存在时
                app::loadFile($fileName);
            } else {
                Controller::halt('The Smarty sysplugins file: ' . $className . ' is not exists!');
            }
            
        } else {
            //分析扩展目录文件
//            if (is_file(DIR_EXTENSION . $className . '.php')) {
                //当扩展目录内文件存在时,则加载文件
//                app::loadFile(DIR_EXTENSION . $className . '.php');
//            } else {
                //支持自定义auto load设置,适用于第三方扩展程序(模块)文件的自动加载
                $autoloadConfigFile = DIR_CONFIG . 'autoload.ini.php';
//                echo $autoloadConfigFile;
                if(!is_file($autoloadConfigFile)) {
                    //当所要加载的文件不存在时,提示错误信息
                    Controller::halt('The File:' . $className .'.php is not exists!');
                }
                //分析自定义自动加载
                $autoloadArray = Controller::getConfig('autoload');
//                echo $autoloadArray;
//                print_r($autoloadArray);
                $autoStatus = false;
                foreach ((array)$autoloadArray as $rules) {
                    //将设置的规则中的*替换为所要加载的文件类名
                    $autoloadFile = str_replace('*', $className, $rules);

                    //当自定义自动加载的文件存在时
                    if (is_file($autoloadFile)) {
                        app::loadFile($autoloadFile);
                        $autoStatus = true;
                        break;
                    }
                }
                //当执行完自定义自动加载规则后,还没有找到所要加载的文件时,提示错误信息
                if ($autoStatus == false) {
                    Controller::halt('The file of class ' . $className .' is not exists!');
                }
//            }
        }
    }
}