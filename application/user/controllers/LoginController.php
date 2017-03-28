<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * UserController.php
 *
 * 用户登录注册类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   UserController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class LoginController extends HomeController
{
    public $UserModel;

    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->UserModel = D('User','user','home');
        parent::init();
    }

    /*登录首页*/
    public function indexAction()
    {

        if(!Session::get('username'))
        {
            $this->redirect('/');
        }
        else
        {
            //没有会员中心,跳到首页
            //$this->redirect('/');
            //echo "欢迎你:".Session::get('username');
        }
    }

    //登录
    public function loginAction()
    {
        $username = Controller::post('username');
        $password = Controller::post('password');
        $url = $this->getUrl();


        //使用邮箱登录
        if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $username)){
            $this->emailLogin($username, $password);
        }

        if(preg_match("/1[3458]{1}\d{9}$/",$username)){
            $this->phoneLogin($username, $password);
        }
        return false;

        // $userInfo = M('member')->where(array('username'=>$username))->getOne();

        // if(!$userInfo){
        //     $this->showMessage("用户名不存在",$url,3);
        // }
    }

    //单页登录 - 模板
    public function login2Action()
    {
        if(isAjax()){
            $username = Controller::post('username');
            $password = Controller::post('password');
            $saveName = Controller::post('saveName');
            //检测是否保存用户名
            if($saveName==1){
                $this->saveName($username);
            }else{
                unset($_SESSION['saveName']);
            }

            //检测是邮箱登录，还是手机登录
            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $username)){
                $this->emailLogin($username, $password);
            }else if(preg_match("/1[3458]{1}\d{9}$/",$username)){
                $this->phoneLogin($username, $password);
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'用户名或密码错误'));die();
            }
        }
        include $this->display('login2.html');
    }

    //保存用户名
    public function saveName($username)
    {
        $_SESSION['saveName'] = $username;
    }




    //使用邮箱登录
    public function emailLogin($username, $password)
    {
        $url = $this->getUrl();
        $userInfo = M('member')->where(array('email'=>$username))->getOne();

        if(!$userInfo){
            echo json_encode(array('status'=>2, 'msg'=>'用户名或密码错误'));die();
        }
        if($userInfo['password'] != md5($password)){
            echo json_encode(array('status'=>2, 'msg'=>'用户名或密码错误'));die();
        }
        if($userInfo['status'] != 1){
            echo json_encode(array('status'=>2, 'msg'=>'账号冻结中'));die();
        }
        Session::set('front_login_info',$userInfo);
        Session::set('username',$username);
        //如果登录成功，更新用户id
        if($userInfo['id']){
            M('member')->update(array('id'=>$userInfo['id']),array('createip'=>get_client_ip()));
        }
        echo json_encode(array('status'=>1, 'msg'=>'登录成功'));die();
    }

    //手机登录
    public function phoneLogin($username, $password)
    {
        $url = $this->getUrl();
        $userInfo = M('member')->where(array('username'=>$username))->getOne();
        if(!$userInfo){
            echo json_encode(array('status'=>2, 'msg'=>'用户名或密码错误'));die();
        }
        if($userInfo['password'] != md5($password)){
            echo json_encode(array('status'=>2, 'msg'=>'用户名或密码错误'));die();
        }
        if($userInfo['status'] != 1){
            echo json_encode(array('status'=>2, 'msg'=>'账号冻结中'));die();
        }
        Session::set('front_login_info',$userInfo);
        Session::set('username',$username);

        echo json_encode(array('status'=>1, 'msg'=>'登录成功'));die();
    }

    /**
     * 微博登录
     */
    public function weiboLoginAction()
    {

    }
























    public function getUrl()
    {
        $request_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];

        if(strpos($request_url,'?')){
            $url  =  $request_url;
            return $url;
        }else{
            $url  =  $request_url.'?';
            return $url;
        }

        if(!isset($parse['query']))
            $parse['query'] = '';

        if(isset($parse['query']))
        {
            parse_str($parse['query'],$params);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }

        return  $url;
    }


}
