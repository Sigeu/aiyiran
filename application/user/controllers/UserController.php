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
class UserController extends HomeController
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


    /*获取用户名并注册本地SESSION；*/
    public function setsessionAction()
    {
        $username = Controller::get('username');
        //setcookie(session_name(), session_id(), time() + 1000000, "/");
        Session::set('username',rc4($username,'DECODE',get_config('imc','key')));
        //$_SESSION['username'] = $username;
        //header('Location:'.$_SERVER['REQUEST_URI']);
    }


    /*登录*/
    public function loginAction()
    {
        //判断来源页面
        if(Session::get('username'))
        {
            $cookieUsername = Controller::get('cookieUsername');
            $type = Controller::get('type',1);
            if($cookieUsername==1)
            {
                Cookie::set('cookieUsername',Session::get('username'));
            }
            $this->redirect(HOST_NAME . 'user/User/index');

        }
        else
        {
            $hasYzm = hasYzm('mo_captcha_log');
            $url = $this->getUrl();

            if(Controller::post('dosubmit')==1)
            {
                require_once DIR_ROOT."static/js/securimage/securimage.php";
                if($hasYzm)
                {
                    $securimage = new Securimage();
                    if (!$securimage->check(Controller::post('code')))
                    {
                        goback('请输入正确的验证码',true);
                    }
                }
                $username = Controller::post('username');
                $password = Controller::post('password');

                //使用邮箱登录
                if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $username)){
                    $this->emailLogin($username, $password);
                }

                $cookieUsername = Controller::post('cookieUsername',2);
                //判断现在可不可以登录,是否失败次数过多
                $logininfo = M('faillogin')->where(array('username'=>$username,'ip'=>get_client_ip()))->getOne();
                $max_num = get_mo_config('mo_max_logintime');
                if(time()-$logininfo['logintime']<60&&$max_num-$logininfo['num']<=0)   //在有效时间内的失败
                {
                    $this->showMessage("你登录失败次数过多,60秒后在试",$url,3);
                }
                $userInfo = M('member')->where(array('username'=>$username))->getOne();

                if(!$userInfo){
                  $this->showMessage("用户名不存在",$url,3);
                }
                if($userInfo['password'] != md5($password)){

                  //记录登录次数
                    $logininfo = M('faillogin')->where(array('username'=>$username,'ip'=>get_client_ip()))->getOne();
                    $max_num = get_mo_config('mo_max_logintime');
                    if(time()-$logininfo['logintime']<60&&!empty($logininfo))   //在有效时间内的失败
                    {
                        $num = $this->UserModel->faillogin($username); //更新失败次数
                        $now_num = $max_num-$num['num']>=0 ? $max_num-$num['num'] : 0;  //剩余的次数
                        if($now_num<=0)
                        {
                            $this->showMessage("密码错误,60秒后在试",$url,3);
                        }
                        else
                        {
                            $this->showMessage("密码错误,你还有".($now_num)."次机会",$url,3);
                        }
                    }
                    else//不在有效时间内的失败,将失败次数设为1
                    {
                        M('faillogin')->delete(array('username'=>$username,'ip'=>get_client_ip()));
                        $this->UserModel->faillogin($username); //更新失败次数
                        $this->showMessage("密码错误,你还有".($max_num-1)."次机会",$url,3);
                    }
                }
                if($userInfo['status'] != 1){
                  $this->showMessage("账号冻结中..",$url,3);
                }

                if($userInfo['loginnum'] == 0) {//如果是会员第一次登陆
                    $loginflag = ' 第一次登陆';
                }else{
                    $loginflag = '';
                }
                //更新用户最后登录时间,最后登录IP
                M('member')->update(array('username'=>$username),array('lastloginip'=>get_client_ip(),'lastlogintime'=>time(),'loginnum'=>$userInfo['loginnum']+1));
                //删除登录失败次数
                M('faillogin')->delete(array('username'=>$username,'ip'=>get_client_ip()));
                Session::set('front_login_info',$userInfo);
                Session::set('username',$username);

                $this->showMessage("登录成功".$loginflag,$url,3);


          }else{
                include $this->display('index.html');
         }
        }

    }

    //使用邮箱登录
    public function emailLogin($username, $password)
    {
        $url = $this->getUrl();
        $userInfo = M('member')->where(array('email'=>$username))->getOne();

        if(!$userInfo){
            $this->showMessage("用户名不存在",$url,3);
        }
        if($userInfo['password'] != md5($password)){
            $this->showMessage("密码错误",$url,3);
        }
        if($userInfo['status'] != 1){
            $this->showMessage("账号冻结中..",$url,3);
        }
        Session::set('front_login_info',$userInfo);
        Session::set('username',$username);

        $this->showMessage("登录成功".$loginflag,$url,3);
    }

    /*获取用户名并注册本地SESSION；*/
    public function loginoutAction()
    {

        unset($_SESSION['front_login_info']);
        unset($_SESSION['username']);
        $this->showMessage("安全退出",'/user/user/index');
    }


    /*退出删除session；*/
    public function unsetSessionAction()
    {
        $_SESSION['username'] = '';
        unset($_SESSION['username']);
    }

    /*注册*/
    public function registAction()
    {
        $userip = get_client_ip();
        $groupid = Controller::getParams('groupid',1);

        $groupInfo = $this->UserModel->getGruopInfo($groupid);
        $registerdeal = $groupInfo['registerdeal'];
        if($groupInfo['status']!='1')
        {
            goback($groupInfo['groupname'].'已经关闭,暂不能注册',true);
        }
        $modelid = $groupInfo['registerform'];

        if(Controller::post('dosubmit')==1)
        {

            // $userInfo = $_POST['info']; old

            $userInfo = $_POST;

            //判断接收到的是邮箱还是手机号码
            if(preg_match("/1[3458]{1}\d{9}$/",$userInfo['UserNo'])){
                $userInfo['mobile'] = Controller::post('UserNo');
                //手机注册方法
                // goback('手机注册',true);
                $this->checkCode($userInfo);
            }else if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $userInfo['UserNo'])){
                $userInfo['email'] = Controller::post('UserNo');
                // 检测验证码
                if($_SESSION['code'] != strtoupper(Controller::post('VerifyCode'))){
                    echo json_encode(array('status'=>1,'msg'=>'请输入正确的验证码'));exit();
                }

//                goback('邮箱注册',true);
                $this->emailRegister($userInfo);
            }else{
                goback('请输入用户名或者手机号码',true);
            }

            p($userInfo);die;

            $userflag = $this->checkName($userInfo['username']);
            if($userflag==2)
            {
                goback('用户已经存在或被禁用',true);
            }
            $emailflag = $this->checkEmail($userInfo['email']);
            if($emailflag==2)
            {
                goback('邮箱已存在',true);
            }
            $levelInfo = $this->UserModel->getLevelIdByGroup($groupid);
            $status = $this->UserModel->getStatusByGroup($groupid);
            $db_status = $status;
            if($db_status==2)
            {
                $db_status=3;
            }
            $MainTableUser = array(
                'username'=>$userInfo['username'],
                'password'=>md5($userInfo['password']),
                'email'=>isset($userInfo['email'])?$userInfo['email']:'',
                'groupid' =>$groupid,
                'levelid' =>$levelInfo['id'],
                'createtime'=>time(),
                'createip' =>get_client_ip(),
                'status' =>$db_status,
            );
            $mid = $this->UserModel->create($MainTableUser); //注册本地主表信息


            $tablename = $this->UserModel->getTableName($modelid);

            foreach($userInfo as $key=>$value)
            {
                if(is_array($value))
                {
                    $userInfo[$key] = implode(';',$value);
                }
            }
            $userInfo['model_id'] = $mid;
            $fid = M("$tablename")->create($userInfo); //注册本地副表信息
            if($mid && $fid)
            {
                //发送邮件
                if($status==2)
                {
                    $sendmail_obj = new SendEmail();
                    $sendmail_obj ->sentEmail($userInfo['username'],$iid,$mid,$userInfo['email'],'1');
                    $this->showMessage('注册成功,请去邮箱激活账号', URL_HOST);
                }
                $this->showMessage('注册成功', URL_HOST . 'user/user/login');
            }
            else
            {
                goback('注册失败',true);
            }

        }
        else
        {
            $flag = $this->getParams('flag');
            $ContentForm = new MessageForm($modelid);
            $form = $ContentForm->get(2,$modelid);
            $formvalidator = $ContentForm->formValidator;
            include $this->display('register.html');
        }
    }

    //邮箱注册
    public function emailRegister($userInfo)
    {

        $password = Controller::post("UserPassword");
        $confirm_password = Controller::post("confirm_password");
        $groupid = Controller::post("groupid");
        $email = test_input($userInfo['email']);    //这里的邮箱是从上级方法出来的，不是表单过来的数据
        $userip = get_client_ip();
        if(empty($email)){
            goback('邮箱名不能为空',true);
        }
        if(empty($password)){
            goback('密码不能为空',true);
        }
        if(strlen($password) < 6){
            goback('密码不能小于6位',true);
        }
        if(empty($confirm_password)){
            goback('重复密码不能为空',true);
        }
        if($password !== $confirm_password){
            goback('两次密码不一致',true);
        }
        //验证邮箱是否存在
        $condtion = array(
            'email'=>$email
        );
        $result = M('member')->field('email')->where($condtion)->getOne();
        if(is_array($result)){
            echo json_encode(array('status'=>2,'msg'=>'邮箱名已经存在'));exit();
        }
        $UserData = array(
            'password'=>md5($password),
            'groupid'=>$groupid,
            'email'=>$email,
            'createip'=>$userip,
            'createtime'=>time(),
            'status'=>1,
            'levelid'=>2

        );

        $userid = $this->UserModel->create($UserData); //注册本地主表信息
        if($userid){
            //发送邮箱激活
            $sendmail_obj = new SendEmail();
            $sendmail_obj ->sentEmail($email,$userid,$userid,$email,'1');

            //设置登录状态
            $userInfo = M('member')->where(array('id'=>$userid))->getOne();
            Session::set('front_login_info',$userInfo);
            Session::set('username',$email);
            echo json_encode(array('status'=>3,'msg'=>'注册成功，请去邮箱激活账号'));exit();
        }else{
            goback('注册失败',true);
        }
    }
    //鼠标移出验证邮箱
    public function checkEmailMobileAction()
    {
    }

    /**
     * 获取手机验证码
     */
    public function isPhoneAction()
    {
        $mobile = Controller::post('mobile');
        // 检测手机号码是否存在
        $condtion = array(
            'username'=>$mobile
        );
        $result = M('member')->field('username')->where($condtion)->getOne();
        if(is_array($result)){
            echo json_encode(array('status'=>2,'msg'=>'手机号码已经存在'));exit();
        }

        $mobile = trim($mobile);
        $username = "用户：";
        //获取随机数
        unset ($_SESSION['vertiCodeS']);
        $vertiCode = getRandomString(4);
        $_SESSION['vertiCodeS'] = $vertiCode;
        //判断接收到的是手机号码
        if(preg_match("/1[3458]{1}\d{9}$/", $mobile)){
            //点击之后60秒内不允许再次发送
            $this->checktime();
            //一个ip一天只能发送10条短信
            $userip = get_client_ip();
            $this->checkMobileIP($userip);

            $userInfo['mobile'] = $mobile;
            Load::load_class('Dayu',DIR_BF_ROOT.'classes',0);
            $py = new Dayu();
            $py->authSms($mobile, $username, $vertiCode);
            echo json_encode(array('status'=>1, 'msg'=>'发送成功'));exit();
        }
        //是邮箱
        $pattern="/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
        if(preg_match($pattern, $mobile)){
            echo json_encode(array('status'=>2));exit();
        } else{
            echo json_encode(array('status'=>3));exit();
        }
    }
    //60秒限制时间
    public function checktime(){

        //第一次发送手机号码
        if(!isset($_COOKIE['nowTime'])){
            $now = time();
            setcookie("nowTime",$now, time()+60); //存储60秒的时间戳
        }else{
            echo json_encode(array('status'=>2, 'msg'=>'请60秒后再次发送'));exit();
        }

    }

    //限制ip请求次数
    public function checkMobileIP($userip){
        $result = M('check_mobile')->where(array('ip'=>$userip))->getOne();
        if($result['num']>9){
            echo json_encode(array('status'=>2, 'msg'=>'超出当日请求次数'));exit();
        }
        //第一次请求存入ip
        if(!is_array($result)){
            $data = array();
            $data['ip'] = $userip;
            M('check_mobile')->create($data);
        }else{
            $num = $result['num']+1;
            M('check_mobile')->update(array('id'=>$result['id']), array('num'=>$num));
        }
    }

    /**
     * 验证手机验证码
     */
    public function checkCode($userInfo)
    {
        $mobile = Controller::post('UserNo');
        $mobile = trim($mobile);
        $code = Controller::post('VerifyCode');
        $code = trim($code);
        if($_SESSION['vertiCodeS']){
            if($_SESSION['vertiCodeS']==$code){
                unset ($_SESSION['vertiCodeS']);
                $data = array();
                $userip = get_client_ip();
                $data['username'] = Controller::post('UserNo');
                $data['password'] = md5(Controller::post('UserPassword'));
                $data['createip']=$userip;
                $data['createtime']=time();
                $data['status'] = 1;
                $data['levelid'] = 2;
                $userid = $this->UserModel->create($data); //注册本地主表信息
                if($userid){
                    //设置登录状态
                    $userInfo = M('member')->where(array('id'=>$userid))->getOne();
                    Session::set('front_login_info',$userInfo);
                    Session::set('username',$mobile);
                  echo json_encode(array('status'=>5,'msg'=>'注册成功'));exit();
                }else{
                  echo json_encode(array('status'=>5,'msg'=>'注册失败'));exit();
                }
//            $this->success('验证成功了，跳转并且删除session');
            }else{
                echo json_encode(array('status'=>2,'msg'=>'验证失败'));exit();
            }
        }else{
            echo json_encode(array('status'=>2,'msg'=>'验证码已失效'));exit();
        }

    }

    /**
     * 激活用户
     */
    public function activateAction(){

        $cObj = M('ImcUsers');
        $mObj = M("Member");
        $id = explode(",",base64_decode($this->getParams('key')));
        $crs = $cObj->update(array('id'=>$id[0]),array('status'=>1));
        $mrs = $mObj->update(array('id'=>$id[1]),array('status'=>1));

        if ($crs && $mrs){

            echo "<script>alert('用户激活成功');window.location.href='http://".$_SERVER['SERVER_NAME']."';</script>";
        } else {

            echo "<script>alert('用户激活失败');window.location.href='http://".$_SERVER['SERVER_NAME']."';</script>";
        }
    }
    /*注册协议*/
    function registerdealAction()
    {
        $id = Controller::get('id');
        $registerdealInfo = M('Registdeal')->where(array('id'=>$id))->getOne();
        $registerdeal = $registerdealInfo['content'];
        include $this->display('registerdeal.html');
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

    public function getPattern($ip)
    {
        $ip = explode("\r\n",$ip);
        foreach($ip as $k=>$v)
        {
            if(strpos($v,'*'))
            {
                $ip[$k] = '/^'.str_replace('*','\\d+',$v).'$/';
            }
            else
            {
                $ip[$k] = '/^'.$v.'$/';
            }
            preg_match_all($ip[$k],get_client_ip(),$match);
            if(!empty($match[0]))
            {
                return false; //被限制的
            }
        }   //var_Dump($ip);die;
        return true;

    }


    /******************************************以下为拷贝*************************/
    //获取用用户名设置，检测当前用户名是否可用
    public function checkName($username='')
    {

        $reg = $this->checkFobrbid();
        $forbid = preg_match('/^('.$reg.')$/ui',$username);

        if ($forbid == 1) {
            return 2; //用户禁用exit;

        }
        $rs = $this->checkNameUnique($username);
        if ($rs == 1) {

            return 1;//唯 一
        }else{

            return 2; //用户已经存在
        }
    }


    /**
     * 检查用户名是否被禁止
     */
    public function checkFobrbid() {

        $set = $this->getSet();//注册设置信息

        $str = str_replace(',',"|",$set['mo_forbidname']);

        $j = 0;
        $reg = '';
        for ( $i = 0; $i < strlen($str); $i++) {

            if($str[$i] == "*" && $j == 0) {

                $reg .= '[\x{4e00}-\x{9fa5}a-zA-Z]{';
                $j++;
            }

            if($str[$i] == "*" && $j != 0) {

                if (@$str[$i+1] != "*") {

                    $reg .= $j ."}";
                }else{

                    $j++;
                }
            }

            if ($str[$i] != "*") {

                $reg .= $str[$i];
                $j = 0;
            }
        }

        return $reg;
    }
    /**
     * 检查用户邮箱是否被使用
     */
    public function checkEmail($email='') {

        $set = $this->getSet();//注册设置信息

        $forbidEmail = explode("\r",$set['mo_forbidemail']);
        $isnull = in_array(substr($email,strpos($email,"@")),$forbidEmail);

        if ($isnull) {

            return 2;//被禁止

        }
        if ($set['mo_flag'] == 2)
        {

          $user = M('member')->select(array('where'=>array('email'=>$email)));

        } else {

            return 1;//没有被使用

        }

        if (empty($user)) {

            return 1;//没有使用

        } else {

            return 2;//已被使用

        }
    }
    /**
     * 检查用用户名是否唯 一
     * @param string $name
     * @return 1//唯 一 2//用户已存在
     */
    public function checkNameUnique($name) {

        $user = M('member')->select(array('where'=>array('username'=>$name)));

        if (empty($user)) {

            return 1;  //唯 一
        }else {

            return 2; //用户已存在
        }
    }
    /*
     * return $result array   关于注册信息的注册设置
    */
    public function getSet() {

        $result = array();
        $configObj = M("WebConfig");

        $arr = $configObj->select(array('where'=>array('group_id'=>12)));

        foreach ($arr as $ak=>$av) {

            $result[$av['par_name']] = $av['par_value'];
        }

        return $result;
    }

    /**
     * 获取用户登录信息
     */
    function getUserLoginInfoAction ()
    {
        $login_info = isset($_SESSION['front_login_info']) ? $_SESSION['front_login_info'] : '';
        if(isset($login_info['id']) && isset($login_info['username']))
        {
            ob_start();
            include $this->display('_logo_info.html');
            $text = ob_get_contents();
            ob_end_clean();
            echo $text;
        }
        else
        {
            echo '';
        }
    }

    /**
     * 注册
     */
    public function registerAction()
    {
        $userip = get_client_ip();
        $groupid = Controller::getParams('groupid',1);
        $hasYzm = hasYzm('mo_captcha_reg');
        $groupInfo = $this->UserModel->getGruopInfo($groupid);
        $registerdeal = $groupInfo['registerdeal'];
        if($groupInfo['status']!='1')
        {
            goback($groupInfo['groupname'].'已经关闭,暂不能注册',true);
        }
        $modelid = $groupInfo['registerform'];
        if(Controller::post('dosubmit')==1)
        {
//            require_once DIR_ROOT."/static/js/securimage/securimage.php";
//            if($hasYzm)
//            {
//                $securimage = new Securimage();
//                if (!$securimage->check(Controller::post('VerifyCode')))
//                {
//                    goback('请输入正确的验证码',true);
//                }
//            }
            if($_SESSION['code'] != Controller::post('VerifyCode')){
                goback('请输入正确的验证码',true);

            }

            // $userInfo = $_POST['info']; old
            $userInfo = $_POST;
            //判断接收到的是邮箱还是手机号码
            if(preg_match("/1[3458]{1}\d{9}$/",$userInfo['username'])){
                $userInfo['mobile'] = $userInfo['username'];
            }else{
                $userInfo['email'] = $userInfo['username'];
            }

            if(!$userInfo['username'])
            {
                goback('用户名不能为空',true);
            }
            if(!$userInfo['password'])
            {
                goback('密码不能为空',true);
            }
            if($userInfo['password'] !== $userInfo['confirm_password']){
                goback('两次密码不一致', true);
            }
            if(!$userInfo['email'])
            {
             goback('邮箱不能为空',true);
            }
            $userflag = $this->checkName($userInfo['username']);
            if($userflag==2)
            {
                goback('用户已经存在或被禁用',true);
            }
            $emailflag = $this->checkEmail($userInfo['email']);
            if($emailflag==2)
            {
                goback('邮箱已存在',true);
            }
            // 如果存在邮箱数组
            if(isset($userInfo['email'])){

            }

        }
        else
        {
            $flag = $this->getParams('flag');
            $ContentForm = new MessageForm($modelid);
            $form = $ContentForm->get(2,$modelid);
            $formvalidator = $ContentForm->formValidator;
            include $this->display('register.html');
        }
    }

    //注册成功跳转的模板
    public function successgoAction()
    {
        include $this->display('succee.html');
    }

    //找回密码
    public function restPassword2Action()
    {
            $error = "";
            $username = Controller::post('username');
            $code = Controller::post('code');
            if($username==""){
                $error = "不能为空";
                include $this->display('find_password.html');die;
            }
            $pattern="/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
            if(preg_match("/1[3458]{1}\d{9}$/", $username)){
                //手机号码找回密码

            }else if(preg_match($pattern, $username)){
                //邮箱密码找回

            }else{
                $error = "格式不正确";
                include $this->display('find_password.html');
            }

            if($code==""){
                $error2="不能为空";
                include $this->display('find_password.html');die;
            }else{

            }
            include $this->display('find_password.html');
    }

    public function restPasswordAction()
    {
        include $this->display('find_password.html');
    }

    public function restPassAction()
    {
        if(isAjax()){
            $username = Controller::post('username');
            if($username==""){
                echo json_encode(array('status'=>2, 'msg'=>'不能为空'));exit();
            }

            //邮箱
            $pattern="/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
            if(preg_match($pattern, $username)){
                //检测是否存在用户
                $userInfo = M('member')->where(array('email'=>$username))->getOne();
                if(is_array($userInfo)){
                    $this->checkeemailmiao();// 限制60秒在发送邮件
                    //发送邮箱验证码=======================================================
                    Load::load_class('email',DIR_BF_ROOT.'classes',0);
                    /******************** 配置信息 ********************************/
                    $smtpserver = "smtp.163.com";//SMTP服务器
                    $smtpserverport =25;//SMTP服务器端口
                    $smtpusermail = "alexa456@163.com";//SMTP服务器的用户邮箱
                    $smtpemailto = $username;//发送给谁
                    $smtpuser = "alexa456";//SMTP服务器的用户帐号
                    $smtppass = "jiejiebuaiwo";//SMTP服务器的用户密码
                    $mailtitle = "爱依然邮箱解绑邮件";//邮件主题
                    $vertiCode = getRandomString(4);
                    $mailcontent = "<p>您正在使用爱依然网站的密码找回，验证码为：".$vertiCode."，如不是本人操作，请联系我们。[爱依然]</p>";//邮件内容
                    $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
                    //************************ 配置信息 ****************************
                    $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
                    //这里面的一个true是表示使用身份验证,否则不使用身份验证.
                    $smtp->debug = false;//是否显示发送的调试信息
                    $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
                    //发送邮箱激活
                    if($state ==""){
                        echo json_encode(array('status'=>2,'msg'=>'验证码发送失败，请稍后重试'));exit();
                    }else{

                        $resu = M(member)->update(array('email'=>$username), array('email_code'=>$vertiCode));
                        if($resu){
                            echo json_encode(array('status'=>1,'msg'=>'验证码发送成功，请去邮箱查看'));exit();
                        }
                    }
                    //发送邮箱验证码结束=======================================================

                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'用户名不存在'));exit();
                }

            }else if(preg_match("/1[3458]{1}\d{9}$/",$username)){
                // echo json_encode(array('status'=>2, 'msg'=>'我是手机号码'));exit();

                //检测是否存在此号码
                $info = M('member')->where(array('username'=>$username))->getOne();
                if($info){
                    //调用发送手机号码的方法
                        $back = $this->sendMobile($info);
                        if($back){
                            echo json_encode(array('status'=>1, 'msg'=>'发送成功，请注意查收'));exit();
                        }else{
                            echo json_encode(array('status'=>2, 'msg'=>'数据格式有误,发送失败'));exit();
                        }
                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'用户名不存在'));exit();
                }
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'格式有误'));exit();
            }
        }
        return null;
    }

    //找回密码的发送手机号码
    public function sendMobile($info)
    {
        $mobile = trim($info['username']);
        $username = "用户：";
        //获取随机数
        $vertiCode = getRandomString(4);
        //存入数据库
        M('member')->update(array('username'=>$info['username']), array('phone_code'=>$vertiCode));
        //判断接收到的是手机号码
        if(preg_match("/1[3458]{1}\d{9}$/", $mobile)){
            //一个ip一天只能发送10条短信
            $userip = get_client_ip();
            $this->checkMobileIP($userip);

            //点击之后60秒内不允许再次发送
            $this->checktime();


            $userInfo['mobile'] = $mobile;
            Load::load_class('Dayu',DIR_BF_ROOT.'classes',0);
            $py = new Dayu();
            $py->authSms($mobile, $username, $vertiCode);
            return true;
        }else{
            return false;
        }
    }

    //60秒时间限制邮箱发送
    public function checkeemailmiao(){
        //第一次发送邮件找回密码
        if($_COOKIE['restEmail']==false){
            $now = time();
            setcookie("restEmail",$now, time()+60); //存储60秒的时间戳
        }else{
            echo json_encode(array('status'=>2, 'msg'=>'请60秒后再次发送'));exit();
        }
    }

    //找回密码页面1 验证邮箱验证码
    public function checkEmailCodeAction()
    {
        if(isAjax()){
            $code = Controller::post('code');
            $username = Controller::post('username');
            if($code=="" || $code==0){
                echo json_encode(array('status'=>2, 'msg'=>'验证码不能为空'));exit();
            }

            //检测是邮箱还是手机号码
            $pattern="/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
            //============================= 邮箱校验code ================================================
            if(preg_match($pattern, $username)){
                //再次检测是否存在用户
                $userInfo = M('member')->where(array('email'=>$username))->getOne();
                if(!$userInfo){
                    echo json_encode(array('status'=>2, 'msg'=>'账号有误，刷新页面重试'));exit();
                }

                //检测是否正确
                $result = M('member')->where("email = '{$username}' AND email_code = {$code}")->getOne();
                if($result){
                    // 验证成功删除 email_code
                    M('member')->update(array("id = {$userInfo}"), array('email_code'=>''));
                    $_SESSION['rest_pwd_email'] = $username;
                    echo json_encode(array('status'=>1, 'msg'=>'验证成功,即将跳转..'));exit();
                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'验证码不正确'));exit();
                }
            //============================= 手机校验code ================================================
            }else if(preg_match("/1[3458]{1}\d{9}$/",$username)){
                 //再次检测是否存在用户
                $userInfo = M('member')->where(array('username'=>$username))->getOne();
                if(!$userInfo){
                    echo json_encode(array('status'=>2, 'msg'=>'账号有误，刷新页面重试'));exit();
                }
                //检测是否正确
                $result = M('member')->where("username = '{$username}' AND phone_code = {$code}")->getOne();
                if($result){
                    // 验证成功删除 email_code
                    M('member')->update(array("id = {$userInfo}"), array('phone_code'=>''));
                    $_SESSION['rest_pwd_email'] = $username;
                    echo json_encode(array('status'=>1, 'msg'=>'验证成功,即将跳转..'));exit();
                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'验证码不正确'));exit();
                }
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'格式有误'));exit();
            }



        }
        return null;
    }



    //进入到设置密码阶段 - 模板
    public function setPasswordAction()
    {
        if($_SESSION['rest_pwd_email']){
            include $this->display('find_password2.html');
        }else{
            $this->showMessage('访问有误', URL_HOST . '/');
        }
    }

    //设置密码访问方法
    public function setPassworddAction()
    {
        if(isAjax()){
            $password = Controller::post('password');
            $password_cofirm = Controller::post('password_cofirm');
            if($password==""){
                echo json_encode(array('status'=>2, 'msg'=>'密码不能为空'));exit();
            }
            if(strlen($password)<6){
                echo json_encode(array('status'=>2, 'msg'=>'密码长度不能小于6位'));exit();
            }

            if($password_cofirm==""){
                echo json_encode(array('status'=>3, 'msg'=>'重复密码不能为空'));exit();
            }
            if($password_cofirm !== $password){
                echo json_encode(array('status'=>3, 'msg'=>'两次密码不一致'));exit();
            }

            if($_SESSION['rest_pwd_email']){
                $email = $_SESSION['rest_pwd_email'];
                //设置密码
                $password = md5($password);
                $result = M('member')->update(array('email'=>$email), array('password'=>$password));
                unset($_SESSION['rest_pwd_email']);
                if($result){
                    echo json_encode(array('status'=>1, 'msg'=>'设置成功，即将跳转'));exit();
                }else{
                    echo json_encode(array('status'=>3, 'msg'=>'密码修改失败'));exit();
                }
            }

        }
        return null;
    }

    //进入到设置密码阶段3 - 模板
    public function find_passwordAction()
    {
        include $this->display('find_password3.html');
    }

    public function getCode2Action()
    {
        include_once DIR_BF_ROOT."classes/MyCode.php";
        $obj = MyCode::getCode(array("width"=>100,"length"=>4,"colour"=>"#f0f0f0"));

        $a=$obj->show();
    }

}
