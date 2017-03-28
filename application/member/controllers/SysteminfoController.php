<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 系统消息
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

class SysteminfoController extends HomeController {
    public $is_login; //是否登录
    public $nav; //左侧导航
    public static $member_news_ids; //当前用户已经阅读的id

    public function init()
    {
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
        $this->nav = M('memorial_info_left')->where(array('cid'=>3))->select(); //左侧导航
        self::$member_news_ids = M('member')->field('read_news_id')->where(array('id'=>$this->is_login['id']))->getOne();
    }

    //系统消息列表
    public function listsAction()
    {
//        $s1 = '16,16,15,16';
//        $s2 = '16';
//        var_dump(strpos($s1,$s2));die;

        $isNav = 6;
        $sdid = 13;
        $nav_title3 = '我的消息';
        $nav = $this->nav;
         $condtion = array(

        );
        // 分页star
        $count = M('memorial_news')->findCount($condtion);
        $pagesize = 5;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial_news')->select($options);

        /*获取消息的已读和未读状态*/
        $member_news_ids = explode(',', self::$member_news_ids['read_news_id']);
        $news_id = M('memorial_news')->field('id')->select();
        foreach($lists as $key => $value){
            foreach($member_news_ids as $k => $v){
                if($value['id'] == $v){
                    $lists[$key]['status'] = 2;
                }
            }
        }
        /*获取消息的已读和未读状态*/
        include $this->display('member/user_view/lists.html');
    }

    //查看系统消息
    public function lookAction()
    {
        if(isAjax()){
            $id = intval(Controller::post('id'));
            $info = M('memorial_news')->where(array('id'=>$id))->getOne();
            M('memorial_news')->update(array('id'=>$id), array('status'=>1));
            $this->readNewsID($id);
            if($info){
                echo json_encode(array('status'=>1, 'title'=>$info['title'], 'content'=>$info['content']));exit();
            }else{
                echo json_encode(array('status'=>2));exit();
            }

        }
        return null;
    }

    //更新阅读量
    public function readNewsID($id)
    {
        //取出以前的数据
        $uid = $this->is_login['id'];
        $readInfo = M('member')->field('read_news_id')->where(array('id'=>$uid))->getOne();
        //没有阅读消息
        $arr = explode(',', $readInfo['read_news_id']);
        if($readInfo['read_news_id']==""){
            M('member')->update(array('id'=>$uid), array('read_news_id'=>$id));
        }else if(in_array($id, $arr)==false){
            //如果当前消息已经阅读过了不存进去
            $haystack = $readInfo['read_news_id'];
            $ids = $haystack . ',' . $id;
            M('member')->update(array('id'=>$uid), array('read_news_id'=>$ids));
        }
    }
}
