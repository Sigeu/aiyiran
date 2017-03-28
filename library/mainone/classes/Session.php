<?php

/**
 * session class file
 *
 * 处理session操作
 * 
 */

if (!defined('IN_MAINONE')) {
    exit();
}

class Session extends Base {
	private $lifetime=1800;
	private $objSession;

    /**
     * 构造函数
     *
     * @access public
     * @return void
     */
    public function __construct() {
    	$this->objSession = M("Session");
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
        session_start();
//         register_shutdown_function(array($this,'close'));
    }
    /**
     * session_set_save_handler  open方法
     * @param $save_path
     * @param $session_name
     * @return true
     */
    public function open($save_path, $session_name) {
    
    	return true;
    }
    /**
     * session_set_save_handler  close方法
     * @return bool
     */
    public function close() {
    	return $this->gc($this->lifetime);
    }
    /**
     * 读取session_id
     * session_set_save_handler  read方法
     * @return string 读取session_id
     */
    public function read($id) {
    	$r = $this->objSession->find(array('sessionid'=>$id),'','data');
    	return $r ? $r['data'] : '';
    }
    /**
     * 写入session_id 的值
     *
     * @param $id session
     * @param $data 值
     * @return mixed query 执行结果
     */
    public function write($id, $data) {
    	$uid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
    	$roleid = isset($_SESSION['roleid']) ? $_SESSION['roleid'] : 0;
    	$groupid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : 0;
    	$m = isset(app::$module) ? app::$module : '';
    	$c = isset(app::$controller) ? app::$controller : '';
    	$a = isset(app::$action) ? app::$action : '';
    	if(strlen($data) > 255) $data = '';
    	$ip = get_client_ip();
    	$sessiondata = array(
    			'sessionid'=>$id,
    			'userid'=>$uid,
    			'ip'=>$ip,
    			'lastvisit'=>SYS_TIME,
    			'roleid'=>$roleid,
    			'groupid'=>$groupid,
    			'm'=>$m,
    			'c'=>$c,
    			'a'=>$a,
    			'data'=>$data,
    	);
    	return $this->objSession->create($sessiondata);
    }
    /**
     * 删除指定的session_id
     *
     * @param $id session
     * @return bool
     */
    public function destroy($id) {
    	return $this->objSession->delete(array('sessionid'=>$id));
    }
    /**
     * 删除过期的 session
     *
     * @param $maxlifetime 存活期时间
     * @return bool
     */
    public function gc($maxlifetime) {
    	$expiretime = SYS_TIME - $maxlifetime;
    	return $this->objSession->delete("`lastvisit`<$expiretime");
    }

    /**
     * 设置session变量的值
     *
     * @access public
     * @param string $key    session变量名
     * @param string $value    session值
     * @return void
     */
    public static function set($key, $value) {

        $_SESSION[$key]=$value;
    }

    /**
     * 获取某session变量的值
     *
     * @access public
     * @param string $key    session变量名
     * @return mixted
     */
    public static function get($key) {

        if (!isset($_SESSION[$key])) {
            return false;
        }

        return $_SESSION[$key];
    }

    /**
     * 删除某session的值
     *
     * @access public
     * @return boolean
     */
    public static function delete($key) {

        if (!isset($_SESSION[$key])){
            return false;
        }
        unset($_SESSION[$key]);

        return true;
    }

    /**
     * 清空session值
     *
     * @access public
     * @return void
     */
    public static function clear(){

        $_SESSION = array();
    }

    /**
     * 注销session
     *
     * @access public
     * @return void
     */
    public static function destory() {

        if (session_id()){
            unset($_SESSION);
            session_destroy();
        }
    }

    /**
     * 当浏览器关闭时,session将停止写入
     *
     * @access public
     * @return void
     */
//     public static function close(){

//         if (session_id()) {
//             session_write_close();
//         }
//     }

    /**
     * 获取session id 名称
     *
     * @access public
     * @return string
     */
    public static function get_name() {

        return session_name();
    }

    /**
     * 获取session id
     *
     * @access public
     * @return string
     */
    public static function get_id( ){

        return session_id();
    }

    /**
     * 设置session_name.
     *
     * @access public
     * @return void
     */
    public function setName($value) {

        session_name($value);
    }

    /**
     * 设置session_id.
     *
     * @param string $id
     * @return void
     */
    public static function set_id($id){

        session_id($id);
    }

    /**
     * 设置session文件的存放路径.
     *
     * @access public
     * @param string $value    session文件所存放的路径
     * @return void
     */
    public static function set_save_path($value) {

        if (!is_dir($value)) {
            Controller::halt('The path:' . $value . ' is not a valid directory!');
        }

        session_save_path($value);
    }

    /**
     * 获取session文件存放路径.
     *
     * @access public
     * @return void
     */
    public static function get_session_path() {

        return session_save_path();
    }

    /*
     * 检验session_start是否开启.
     *
     * @return void
     */
    public static function is_start() {

        return session_id() ? true : false;
    }

    /**
     * 检验session里有该session值.
     *
     * @param string $key
     * @return mixted
     */
    public static function is_set($key){

        if (!session_id()){
            return false;
        }

        return isset($_SESSION[$key]);
    }

    /**
     * 检验session有效时间.
     *
     * @access public
     * @return intger
     */
    public static function getTimeout() {

        return (int)ini_get('session.gc_maxlifetime');
    }

    /**
     * 设置session有最大存活时间.
     *
     * @param string $value
     * @return void
     */
    public static function setTimeout($value) {

        ini_set('session.gc_maxlifetime',$value);
    }
}