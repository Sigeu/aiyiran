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

class MessageController extends HomeController {
    public $is_login; //是否登录
    public $nav; //左侧导航

    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);

        parent::init();
         if(Session::get('username')==false){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
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
    }

    //系统消息列表
    public function listsAction()
    {
        $sdid = 13;
        $nav_title3 = '我的消息';
        $nav = $this->nav;
         $condtion = array(
           
        );
        // 分页star
        $count = M('memorial_news')->findCount($condtion);
        $pagesize = 4;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial_news')->select($options);
        include $this->display('member/user_view/lists.html');
    }
}