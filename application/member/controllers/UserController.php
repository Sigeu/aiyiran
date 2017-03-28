<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 陵园管理控制器类
 *
 * @author     月下追魂 <youkaili@mail.b2b.cn>   2016年12月12日18:11:06
 * @filename   CemeteryController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class UserController extends HomeController {
    public $is_login; //是否登录
    public $nav; //导航
    static public $safe = 40; //安全数值

    public function init(){
        error_reporting(E_ALL & ~E_NOTICE);

        parent::init();
         if(Session::get('username')==false){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
        $this->is_login = M('Member')->field('id')->where(array('username'=>Session::get('username')))->getOne();
        if($this->is_login==false){
             $this->is_login = M('Member')->field('id')->where(array('email'=>Session::get('username')))
                                    ->getOne();
             if($this->is_login==false){
                $this->is_login = M('Member')->field('id')->where(array('weibo_uname'=>Session::get('username')))->getOne();
                if($this->is_login==false){
                    $this->showMessage("您还未登录请先登录", '/', 3);die;
                }
             }
        }

        $this->nav = M('memorial_info_left')->where(array('cid'=>2))->select(); //左侧导航
    }

    //个人资料
    public function userinfoAction()
    {
        $isNav = 5;
        $sdid =10; //导航选中
        $nav = $this->nav;
        $is_nav = 1;
        //更新提交
        if(isAjax()){
            $data = array();
            $uid = Controller::post('uid');
            //上传头像
            if(!empty($_FILES['user_photo']['tmp_name'])){
                Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
                $up = new Upload();
                $up->uploadPath = 'static/uploadfile/member_info';
                $filename = $up->fileUpload($_FILES['user_photo']);
                if($filename==false){
                    $message = $up->getStatus();
                    echo json_encode($message);exit();
                }
                $data['user_photo'] = '/' . $filename;
                $_SESSION['front_login_info']['user_photo'] = $data['user_photo'];
            }
            //上传头像结束
            //修改头像
            if(isset($_POST['nickname'])){
                $data['nickname'] = Controller::post('nickname');
                if($data['nickname']==""){
                    echo json_encode(array('status' => 2, 'message' => '昵称不能为空'));exit();
                }
                $check = M('member')->where(array('nickname'=>$data['nickname']))->getOne();
                if(is_array($check) && $check['id']!==$uid){
                    echo json_encode(array('status' => 2, 'message' => '昵称已经存在，请更换'));exit();
                }
                //检测昵称是否存在
            }

            $data['name'] = Controller::post('name');
            $data['sex'] = Controller::post('sex');

            //组合时间戳
            $brith_year = Controller::post('brith_year'); //生成：年
            $brith_math = Controller::post('brith_math'); //生成：月
            $brith_day = Controller::post('brith_day'); //生成：日
            $data['birthday'] = strtotime("$brith_year-$brith_math-$brith_day"); //出生时间戳

            //籍贯
            $data['brithp'] = Controller::post('brithp');
            $data['brithd'] = Controller::post('brithd');
            $data['brithc'] = Controller::post('brithc');

            //居住地
            $data['live_sheng'] = Controller::post('live_sheng');
            $data['live_shi'] = Controller::post('live_shi');
            $data['live_diqu'] = Controller::post('live_diqu');



            $result = M('member')->update(array('id'=>$uid), $data);
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '更新信息成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '更新信息失败'));
                exit();
            }

        }else{
            $islogin = $this->is_login; //用户id
            $info = M('member')->where(array('id'=>$islogin['id']))->getOne();
            if($info['user_photo']==false){
                $info['user_photo'] = "/template/default/member/images/tx_yc.png";
            }
            $times = $this->getTiemList(); //获取默认时间列表
            $area = M('area')->where(array('area_type'=>1))->select(); //省份

            //出生年月日 [默认是0 就是用当前时间]
            if($info['birthday']==0){
                $birthYear = date('Y', time());
                $birthMath = date('m', time());
                $birthDay = date('d', time());
            }else{
                $birthYear = date('Y', $info['birthday']);
                $birthMath = date('m', $info['birthday']);
                $birthDay = date('d', $info['birthday']);
            }
            //通过籍贯省份循环市区
            $brithps = M('area')->where(array('parent_id'=>$info['brithp']))->select();

            $places = M('area')->where(array('parent_id'=>$info['live_sheng']))->select();

            include $this->display('member/user_view/userinfo.html');
        }
        return null;
    }

    //获取时间列表
    public function getTiemList()
    {
        $times = array();
        $y = date('Y', time());
        $times['year'] = range(1, $y);
        $times['year'] = array_reverse($times['year']);
        $times['math'] = range(1, 12);
        $times['day'] = range(1, 32);
        return $times;
    }

    /**
     * 城市分类
     */
    public function areaAction(){
        $mid = isset($_POST['id']) ? intval($_POST['id']) : 0 ;
        $area = M('area')->where(array('parent_id'=>$mid))->select();
        echo json_encode($area);exit();
    }

    //安全设置
    public function safeAction()
    {
        $isNav = 5;
        $is_nav = 2;
        $sdid =11; //导航选中
        $nav = $this->nav;
        $islogin = $this->is_login;

        //判断是否绑定手机
        $result = M('member')->where(array('id'=>$islogin['id']))->getOne();
        // 是否是手机号码
        if(preg_match("/1[3458]{1}\d{9}$/", $result['username'])){
            $is_phone = true;
            self::$safe +=15;
        }else{
            $is_phone = false;
            self::$safe -=15;
        }

        //是否绑定邮箱
        if($result['email']){
            $is_email = true;
            self::$safe +=15;
        }else{
            $is_email = false;
            self::$safe -=15;
        }

        //是否实名认证
        $is_real = M('real_name')->where(array('uid'=>$islogin['id']))->getOne();
        if(!is_array($is_real)){
            $is_real = false;
            self::$safe -=15;
        }
            self::$safe +=15;

        //是否设置密保问题
        $is_quester = M('memorial_quester')->where(array('uid'=>$islogin['id']))->getOne();
        if(!is_array($is_quester)){
            $is_quester = false;
            self::$safe -=15;
        }
            self::$safe +=15;
        //获取问题列表
        $quester_lists = M('memorial_quester_lists')->select();
        $ss = self::$safe;

        //获取登录ip
//        p($result['createip']);die;
        include $this->display('member/user_view/safe.html');
    }

    //获取手机验证码 1 【绑定功能】
    public function getPhoneCodeAction()
    {
        if(isAjax()){
            $mobile = Controller::post('mobile');
            if($mobile==""){
                echo json_encode(array('status'=>2,'msg'=>'手机号码不能为空'));exit();
            }
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile) ==false){
                echo json_encode(array('status'=>2,'msg'=>'手机号码格式有误'));exit();
            }
            // 检测手机号码是否存在
            $condtion = array(
                'username'=>$mobile
            );
            $result = M('member')->field('username')->where($condtion)->getOne();
            if(is_array($result)){
                echo json_encode(array('status'=>2,'msg'=>'手机号码已经被绑定'));exit();
            }

            $mobile = trim($mobile);
            $username = "用户：";
            //获取随机数
            unset ($_SESSION['vertiCodeS']);
            $vertiCode = getRandomString(4);
            $_SESSION['vertiCodeS'] = $vertiCode;
            //判断接收到的是手机号码
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile)){
                //一个ip一天只能发送10条短信
                $userip = get_client_ip();
                $this->checkMobileIP($userip);

                $userInfo['mobile'] = $mobile;
                Load::load_class('Dayu',DIR_BF_ROOT.'classes',0);
                $py = new Dayu();
                $py->authSms($mobile, $username, $vertiCode);
                echo json_encode(array('status'=>1, 'msg'=>'发送成功,请注意查收'));exit();
            }
        }
        return null;
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

    //手机验证码核对2 【绑定】
    public function checkMobileAction()
    {
        $islogin = $this->is_login;
        $uid = $islogin['id'];
        if($uid){
            $mobile = Controller::post('mobile');
            $code = Controller::post('dx_code');

            if($mobile==""){
                echo json_encode(array('status'=>2,'msg'=>'手机号码不能为空'));exit();
            }
            if($code==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写验证码'));exit();
            }
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile) ==false){
                echo json_encode(array('status'=>2,'msg'=>'手机号码格式有误'));exit();
            }
            // 检测手机号码是否存在
            $condtion = array(
                'username'=>$mobile
            );
            $result = M('member')->field('username')->where($condtion)->getOne();
            if(is_array($result)){
                echo json_encode(array('status'=>2,'msg'=>'手机号码已经被绑定'));exit();
            }

            $mobile = trim($mobile);
            $code = trim($code);
            if($_SESSION['vertiCodeS']){
                if($_SESSION['vertiCodeS']==$code){
                    unset ($_SESSION['vertiCodeS']);
                    $data = array();
                    $data['username'] = $mobile;
                    $userid = M('member')->update(array('id'=>$uid), $data); //注册本地主表信息
                    if($userid){
                      echo json_encode(array('status'=>5,'msg'=>'手机号码绑定成功'));exit();
                    }else{
                      echo json_encode(array('status'=>5,'msg'=>'手机号码绑定失败'));exit();
                    }
    //            $this->success('验证成功了，跳转并且删除session');
                }else{
                    echo json_encode(array('status'=>2,'msg'=>'验证失败'));exit();
                }
            }else{
                echo json_encode(array('status'=>2,'msg'=>'验证码已失效'));exit();
            }
        }else{
            echo goback('请登录');exit;
        }
    }

    //修改密码
    public function modPassAction()
    {
        if(isAjax()){
            $data = array();
            $data['password'] = Controller::post('password');
            $newpassword = Controller::post('newpassword');
            $newpassword_confirm = Controller::post('newpassword_confirm');

            if(empty($data['password'])){
                echo json_encode(array('status'=>2, 'msg'=>'请完整填写表单'));exit();
            }
            if(empty($newpassword)){
                echo json_encode(array('status'=>2, 'msg'=>'请完整填写表单'));exit();
            }
            if(empty($newpassword_confirm)){
                echo json_encode(array('status'=>2, 'msg'=>'请完整填写表单'));exit();
            }
            if($newpassword !== $newpassword_confirm){
                echo json_encode(array('status'=>2, 'msg'=>'两次密码不一致'));exit();
            }
            if(strlen($data['password']) < 6){
                echo json_encode(array('status'=>2, 'msg'=>'密码长度不能小于6位'));exit();
            }
             if(strlen($newpassword) < 6){
                echo json_encode(array('status'=>2, 'msg'=>'密码长度不能小于6位'));exit();
            }
             if(strlen($newpassword_confirm) < 6){
                echo json_encode(array('status'=>2, 'msg'=>'密码长度不能小于6位'));exit();
            }
            //获取当前用户密码
            $islogin = $this->is_login;
            $result = M('member')->where(array('id'=>$islogin['id']))->getOne();
            if($result){
                if($result['password']!==md5($data['password'])){
                    echo json_encode(array('status'=>2, 'msg'=>'用户密码输入错误'));exit();
                }
                //修改密码
                $data['password'] = md5($newpassword);
                $result = M('member')->update(array('id'=>$islogin['id']), $data);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '密码修改成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '密码修改失败'));
                    exit();
                }

            }else{
                echo goback("请重新登录");exit();
            }


        }
        return null;
    }


    /**
     * =======================手机验证码解除绑定
     */
    //获取手机验证码 1 【解除绑定功能】
    public function getPhoneCode2Action()
    {
        if(isAjax()){
            $islogin = $this->is_login;
            $mobile = Controller::post('mobile');
            if($mobile==""){
                echo json_encode(array('status'=>2,'msg'=>'手机号码不能为空'));exit();
            }
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile) ==false){
                echo json_encode(array('status'=>2,'msg'=>'手机号码格式有误'));exit();
            }

            // 获取当前用户的手机号码
            $condtion = array(
                'username'=>$mobile,
                'id'=>$islogin['id'],
            );
            $result = M('member')->where($condtion)->getOne();
            if($result==false){
                echo json_encode(array('status'=>2,'msg'=>'请核对当前账户的手机号码是否正确'));exit();
            }

            //解除绑定的话，请先查看是否绑定了邮箱，如果没有绑定邮箱，是不能解除手机绑定的
            if($result['email']==false){
                echo json_encode(array('status'=>2,'msg'=>'手机号码已经是当前唯一可用的登录方式'));exit();
            }

            $mobile = trim($mobile);
            $username = "用户：";
            //获取随机数
            unset ($_SESSION['vertiCodeS']);
            $vertiCode = getRandomString(4);
            $_SESSION['vertiCodeS'] = $vertiCode;
            //判断接收到的是手机号码
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile)){
                //一个ip一天只能发送10条短信
                $userip = get_client_ip();
                $this->checkMobileIP($userip);

                $userInfo['mobile'] = $mobile;
                Load::load_class('Dayu',DIR_BF_ROOT.'classes',0);
                $py = new Dayu();
                $py->authSms($mobile, $username, $vertiCode);
                echo json_encode(array('status'=>1, 'msg'=>'发送成功,请注意查收'));exit();
            }
        }
        return null;
    }


    //手机验证码核对2 【解除绑定】
    public function checkMobile2Action()
    {
        $islogin = $this->is_login;
        $uid = $islogin['id'];
        if($uid){
            $mobile = Controller::post('mobile');
            $code = Controller::post('dx_code');

            if($mobile==""){
                echo json_encode(array('status'=>2,'msg'=>'手机号码不能为空'));exit();
            }
            if($code==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写验证码'));exit();
            }
            if(preg_match("/1[3458]{1}\d{9}$/", $mobile) ==false){
                echo json_encode(array('status'=>2,'msg'=>'手机号码格式有误'));exit();
            }
            // 获取当前用户的手机号码
            $condtion = array(
                'username'=>$mobile,
                'id'=>$islogin['id'],
            );
            $result = M('member')->where($condtion)->getOne();
            if($result==false){
                echo json_encode(array('status'=>2,'msg'=>'请核对当前账户的手机号码是否正确'));exit();
            }

            $mobile = trim($mobile);
            $code = trim($code);
            if($_SESSION['vertiCodeS']){
                if($_SESSION['vertiCodeS']==$code){
                    unset ($_SESSION['vertiCodeS']);
                    $data = array();
                    $data['username'] = ''; //解除绑定
                    $userid = M('member')->update(array('id'=>$uid), $data); //更新本地主表信息

                    //更新完毕后要使用邮箱登录
                    Session::set('front_login_info',$result);
                    Session::set('username',$result['email']);
                    if($userid){
                      echo json_encode(array('status'=>5,'msg'=>'解绑手机成功'));exit();
                    }else{
                      echo json_encode(array('status'=>5,'msg'=>'解绑手机失败'));exit();
                    }
    //            $this->success('验证成功了，跳转并且删除session');
                }else{
                    echo json_encode(array('status'=>2,'msg'=>'验证失败'));exit();
                }
            }else{
                echo json_encode(array('status'=>2,'msg'=>'验证码已失效'));exit();
            }
        }else{
            echo goback('请登录');exit;
        }
    }

    /**
     * ========================= 解除邮箱验证码 =============================
     */

    //发送验证 【解绑】
    public function sendEmailCodeAction()
    {
        if(isAjax()){
            $email = Controller::post('email');
            $islogin = $this->is_login;
            if($email==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写你的邮件地址'));exit();
            }


            //判断是不是当前用户的邮箱地址
            $condition = array(
                'id' => $islogin['id'],
                'email' => $email
                );


            $result = M('member')->where($condition)->getOne();
             //解除绑定的话，请先查看是否绑定了手机号，如果没有绑定手机号，是不能解除邮箱绑定的
            if($result['username']==false){
                echo json_encode(array('status'=>2,'msg'=>'邮箱登录已经是当前唯一可用的登录方式'));exit();
            }

            if($result==false){
                echo json_encode(array('status'=>2,'msg'=>'请核对当前账户的邮箱地址是否正确'));exit();
            }
            //发送邮箱验证码
            Load::load_class('email',DIR_BF_ROOT.'classes',0);
            /******************** 配置信息 ********************************/
            $smtpserver = "smtp.163.com";//SMTP服务器
            $smtpserverport =25;//SMTP服务器端口
            $smtpusermail = "alexa456@163.com";//SMTP服务器的用户邮箱
            $smtpemailto = $email;//发送给谁
            $smtpuser = "alexa456";//SMTP服务器的用户帐号
            $smtppass = "jiejiebuaiwo";//SMTP服务器的用户密码
            $mailtitle = "爱依然邮箱解绑邮件";//邮件主题
            $vertiCode = getRandomString(4);
            $mailcontent = "<p>您正在用您的手机在中国清明网上进行邮箱解除绑定，验证码为：".$vertiCode."，如不是本人操作，请联系我们。[爱依然]</p>";//邮件内容
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
                 //将邮箱验证码存入session
                unset ($_SESSION['email_code']);
                $_SESSION['email_code'] = $vertiCode;
                echo json_encode(array('status'=>1,'msg'=>'验证码发送成功，请去邮箱查看'));exit();
            }
        }
        return null;
    }

    //判断验证码 【解绑】
    public function clearEmailAction()
    {
        if(isAjax()){
            $email = Controller::post('email');
            $yx_code = Controller::post('yx_code');
            $islogin = $this->is_login;

            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email) ==fales){
                echo json_encode(array('status'=>2,'msg'=>'请填写正确格式的邮件地址'));exit();
            }
             if($yx_code==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写你的验证码'));exit();
            }
             if($email==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写正确格式的邮件地址'));exit();
            }

            //判断是不是当前用户的邮箱地址
            $condition = array(
                'id' => $islogin['id'],
                'email' => $email
                );
            $result = M('member')->where($condition)->getOne();
            if($result==false){
                echo json_encode(array('status'=>2,'msg'=>'请核对当前账户的邮箱地址是否正确'));exit();
            }

            if($_SESSION['email_code']){
                if($_SESSION['email_code']==$yx_code){
                    unset ($_SESSION['email_code']);
                    $result = M('member')->update(array('id'=>$islogin['id']), array('email'=>''));
                    if($result==false){
                        echo json_encode(array('status'=>2,'msg'=>'维护中..'));exit();
                    }
                    echo json_encode(array('status'=>1,'msg'=>'解绑成功'));exit();
                }else{
                    echo json_encode(array('status'=>2,'msg'=>'验证码有误'));exit();
                }
            }else{
                echo json_encode(array('status'=>2,'msg'=>'验证码已失效，请重新获取'));exit();
            }

        }
        return null;
    }

    /**
     * ************************** 邮件绑定 ************************************
     */
    //发送邮件 【绑定】
    public function bildEmailAction()
    {
        if(isAjax()){
            $email = Controller::post('email');
            $islogin = $this->is_login;

            if($email==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写你的邮件地址'));exit();
            }
            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email) ==fales){
                echo json_encode(array('status'=>2,'msg'=>'请填写正确格式的邮件地址'));exit();
            }

            //发送邮箱验证码
            Load::load_class('email',DIR_BF_ROOT.'classes',0);
            /******************** 配置信息 ********************************/
            $smtpserver = "smtp.163.com";//SMTP服务器
            $smtpserverport =25;//SMTP服务器端口
            $smtpusermail = "alexa456@163.com";//SMTP服务器的用户邮箱
            $smtpemailto = $email;//发送给谁
            $smtpuser = "alexa456";//SMTP服务器的用户帐号
            $smtppass = "jiejiebuaiwo";//SMTP服务器的用户密码
            $mailtitle = "爱依然邮箱解绑邮件";//邮件主题
            $vertiCode = getRandomString(4);
            $mailcontent = "<p>您正在用您的手机在中国清明网上进行邮箱绑定，验证码为：".$vertiCode."，如不是本人操作，请联系我们。[爱依然]</p>";//邮件内容
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
                 //将邮箱验证码存入session
                unset ($_SESSION['email_code']);
                $_SESSION['email_code'] = $vertiCode;
                echo json_encode(array('status'=>1,'msg'=>'验证码发送成功，请去邮箱查看'));exit();
            }
        }
        return null;
    }

    //邮件绑定
    public function clearEmail2Action()
    {
        if(isAjax()){
            $email = Controller::post('email');
            $yx_code = Controller::post('yx_code');
            $islogin = $this->is_login;

            if($email==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写你的邮件地址'));exit();
            }
            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $email) ==fales){
                echo json_encode(array('status'=>2,'msg'=>'请填写正确格式的邮件地址'));exit();
            }
            if($yx_code==""){
                echo json_encode(array('status'=>2,'msg'=>'请填写你的验证码'));exit();
            }


            if($_SESSION['email_code']){
                if($_SESSION['email_code']==$yx_code){
                    unset ($_SESSION['email_code']);
                    $result = M('member')->update(array('id'=>$islogin['id']), array('email'=>$email));
                    if($result==false){
                        echo json_encode(array('status'=>2,'msg'=>'维护中..'));exit();
                    }
                    echo json_encode(array('status'=>1,'msg'=>'邮箱绑定成功'));exit();
                }else{
                    echo json_encode(array('status'=>2,'msg'=>'验证码有误'));exit();
                }
            }else{
                echo json_encode(array('status'=>2,'msg'=>'验证码已失效，请重新获取'));exit();
            }

        }
        return null;
    }


    /**
     * *********************************** 实名认证 ******************************
     */
    public function realNameAction()
    {
        if(isAjax()){
            $islogin = $this->is_login;
            $data = array();
            $data['real_type'] = Controller::post('real_type');
            $data['id_card'] = Controller::post('id_card');
            $data['name'] = Controller::post('name');
            $data['uid'] = $islogin['id'];
            $this->realNameMessage($data);
            $result = M('real_name')->create($data);
            //上传正面照片
            if(!empty($_FILES['face']['tmp_name'])){
                Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
                $up = new Upload();
                $up->uploadPath = 'static/uploadfile/member_info';
                $filename = $up->fileUpload($_FILES['face']);
                if($filename==false){
                    $message = $up->getStatus();
                    echo json_encode($message);exit();
                }
                $face = '/' . $filename;
                M('real_name')->update(array('id'=>$result), array('face'=>$face));
            }
            //上传反面照片
            if(!empty($_FILES['side']['tmp_name'])){
                Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
                $up = new Upload();
                $up->uploadPath = 'static/uploadfile/member_info';
                $filename = $up->fileUpload($_FILES['side']);
                if($filename==false){
                    $message = $up->getStatus();
                    echo json_encode($message);exit();
                }
                $side = '/' . $filename;
                M('real_name')->update(array('id'=>$result), array('side'=>$side));
            }

            if($result){
                echo json_encode(array('status'=>1,'message'=>'实名认证信息，已经提交'));exit();
            }else{
                echo json_encode(array('status'=>2,'message'=>'信息提交失败'));exit();
            }

        }
        return null;
    }

    //实名认证错误提示
    public function realNameMessage($data)
    {
        if($data['real_type']==""){
            echo json_encode(array('status'=>2,'message'=>'证件类型'));exit();
        }
        if($data['id_card']==""){
            echo json_encode(array('status'=>2,'message'=>'身份证号码不能为空'));exit();
        }
        $isIDCard1 = '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/';
        if(preg_match($isIDCard1, $data['id_card']) == false){
            echo json_encode(array('status'=>2,'message'=>'身份证号码格式错误，请认真填写'));exit();
        }
        if($data['name']==""){
            echo json_encode(array('status'=>2,'message'=>'真实姓名不能为空'));exit();
        }
        if(empty($_FILES['face']['tmp_name'])){
            echo json_encode(array('status'=>2,'message'=>'请上传证件正面照片'));exit();
        }
        if(empty($_FILES['side']['tmp_name'])){
            echo json_encode(array('status'=>2,'message'=>'请上传证件反面照片'));exit();
        }
    }

    /**
     * *********************************** 设置安全问题 ******************************
     */
    public function setQuesterAction()
    {
        if(isAjax()){
            $islogin = $this->is_login;
            $data = array();
            $data['quester1'] = Controller::post('quester1');
            $data['answer1'] = Controller::post('answer1');
            $data['quester2'] = Controller::post('quester2');
            $data['answer2'] = Controller::post('answer2');
            $data['quester3'] = Controller::post('quester3');
            $data['answer3'] = Controller::post('answer3');
            $data['uid'] = $islogin['id'];
            $this->questerMessage($data);
            $result = M('memorial_quester')->create($data);
            if($result){
                echo json_encode(array('status'=>1,'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>1,'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }

    //显示错误
    public function questerMessage($data)
    {
        if(empty($data['quester1']) || empty($data['quester2']) || empty($data['quester3'])){
            echo json_encode(array('status'=>2,'msg'=>'请选择问题'));exit();
        }
        if(empty($data['answer1']) || empty($data['answer2']) || empty($data['answer3'])){
            echo json_encode(array('status'=>2,'msg'=>'答案不能为空'));exit();
        }
        if($data['quester1']==$data['quester2']){
            echo json_encode(array('status'=>2,'msg'=>'问题一和问题二不能相同，请更换'));exit();
        }
        if($data['quester1']==$data['quester3']){
            echo json_encode(array('status'=>2,'msg'=>'问题一和问题三不能相同，请更换'));exit();
        }
        if($data['quester2']==$data['quester3']){
            echo json_encode(array('status'=>2,'msg'=>'问题二和问题三不能相同，请更换'));exit();
        }
    }

    //修改密保问题
    public function modQuesterAction()
    {
        if(isAjax()){
            $islogin = $this->is_login;
            $data = array();
            $data['quester1'] = Controller::post('quester1');
            $data['answer1'] = Controller::post('answer1');
            $data['quester2'] = Controller::post('quester2');
            $data['answer2'] = Controller::post('answer2');
            $data['quester3'] = Controller::post('quester3');
            $data['answer3'] = Controller::post('answer3');
            $data['uid'] = $islogin['id'];
            $this->questerMessage($data);
            $result = M('memorial_quester')->update(array('uid'=>$islogin['id']), $data);
            if($result){
                echo json_encode(array('status'=>1,'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2,'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }

    /**
     * 头像设置
     */
    public function cutavatarAction()
    {
        $sdid =10; //导航选中
        $nav = $this->nav;
       $targetFolder = '123'; // Relative to the root

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rename_rules = 'time';
            $tempFile = $_FILES['Filedata']['tmp_name'];
            //$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            $targetFile = rtrim($targetFolder,'/') . '/' . time().'_'.mt_rand(1000,9999);

            // Validate the file type
            $fileTypes = array('mp3','jpg','mp4'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile.'.'.$fileParts['extension']);
                $savepath = $targetFile.'.'.$fileParts['extension'];
                echo json_encode(array('code'=>200,'savepath'=>$savepath));exit();
            } else {
                echo json_encode(array('code'=>201,'errorMsg'=>'无效的文件类型。 '));exit();
            }

        }
        include $this->display('member/user_view/cutavatar.html');
    }

    /**
     * 第三方账号绑定微博
     */
    public function accountboundAction()
    {
        $isNav = 5;
        $is_nav = 3;
        //检测是否绑定微博
        $islogin = $this->is_login;
        $condition = array(
            'id'=>$islogin['id']
            );
        $info_wb = M('member')->where($condition)->getOne();
        if($info_wb['access_token']==NULL && $info_wb['is_weibo']==2){
            $info_wb = false; //没有绑定
            include DIR_BF_ROOT.'/classes/weibo.php';
            $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
            $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
        }else{
            $info_wb = true; //已经绑定
        }

        include $this->display('member/user_view/accountbound.html');
    }

    //回调
    public function callbackAction()
    {
        $islogin = $this->is_login;
        session_start();
        include_once( DIR_BF_ROOT.'/classes/libweibo-master/config.php' );
        include_once( DIR_BF_ROOT.'/classes/libweibo-master/saetv2.ex.class.php' );

        $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;
            try {
                $token = $o->getAccessToken( 'code', $keys ) ;
                } catch (OAuthException $e) {
            }
        }

        if ($token) {
            $_SESSION['token'] = $token;
            setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );

            $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
            $ms  = $c->home_timeline(); // done
            $uid_get = $c->get_uid();
            $uid = $uid_get['uid'];
            $user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

            $data = array(
                'access_token'=>$token['access_token'],
                'is_weibo'=>1,
                );
            $result = M('member')->update(array('id'=>$islogin['id']), $data);
            if($result){
                // echo json_encode(array('status'=>1,'msg'=>'操作成功'));exit();
                 $this->showMessage("操作成功", '/member/User/accountbound', 3);die;

            }else{
                // echo json_encode(array('status'=>2,'msg'=>'操作失败'));exit();
                 $this->showMessage("操作失败", '/member/User/accountbound', 3);die;
            }

        }else{
            echo "授权失败";die;
        }
    }

    /**
     * 微博解除绑定
     */
    public function clearBildAction()
    {
        $islogin = $this->is_login;
        $condition = array(
            'id'=>$islogin['id']
            );
        $result = M('member')->update($condition, array('access_token'=>'','is_weibo'=>2));
        if($result){
            echo json_encode(array('status'=>1,'msg'=>'操作成功'));exit();
        }else{
            echo json_encode(array('status'=>2,'msg'=>'操作失败'));exit();
        }

    }


}
