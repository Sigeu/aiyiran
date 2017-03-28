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

class IndexController extends HomeController {
    public $is_login;
    public $click_nav;
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);

        parent::init();
        if(Session::get('username')==false){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
        $this->is_login = M('Member')->field('id')->where(array('username'=>Session::get('username')))->getOne();
        if($this->is_login==NULL){
             $this->is_login = M('Member')->field('id')->where(array('email'=>Session::get('username')))
                                    ->getOne();
             if($this->is_login==NULL){
                 $this->is_login = M('Member')->field('id')->where(array('weibo_uname'=>Session::get('username')))->getOne();
                if($this->is_login==NULL){
                    $this->showMessage("您还未登录请先登录", '/', 3);die;
                }
             }
        }
    }

    public function indexAction()
    {
        $isNav = 1;
        // p($_SESSION);die;
        // $info_inc = $this->getUserInfo();
        //我创建的纪念馆
        $islogin = $this->is_login;
        $condition = array(
            'userid'=>$islogin['id']
        );
        $memorial_lists = M('memorial')->field('id,userpic,name,click_num')->where($condition)->select();

        /**
         * fid 关注的主键
         *
         */
        $follow = $this->follow();

        //获取用户信息顶部导航使用
        // $userinfo = M('member')->where(array('id'=>$islogin['id']))->getOne();

        //元宝数量
        $yuanbao = M('member')->field('point')->where(array('id'=>$islogin['id']))->getOne();

        /**未读消息 star**/
            //所有消息
            $nums = M('memorial_news')->findCount();
            //已读消息
            $readInfo = M('member')->field('read_news_id')->where(array('id'=>$islogin['id']))->getOne();
            $arr = explode(',', $readInfo['read_news_id']);
            if($arr[0]==""){

            }else{
                //未读消息等于 所有减去已读消息
                $read = count($arr);
                $nums = $nums - $read;
            }


        /**未读消息 end**/


        //我的祭拜记录
        $sacrifice = $this->sacrifice();

        include $this->display('member/member_index.html');
    }

    /**
     * 我关注的馆
     */
    public function follow()
    {
        $islogin = $this->is_login;
        $uid = $islogin['id'];
        $condition = array(
            'uid'=>$uid
            );
        $follow = M('memorial_follow')->where($condition)->select();
        $mid = array(); //获取所有纪念馆id
        foreach ($follow as $key => $value) {
           $mid[$key] = $value['mid'];
        }
        $str = implode(",", $mid);
        //纪念馆
        $where = array(
            'in'=>array('id'=>$str),
        );
        //获取所有关注的纪念馆信息
       $follow_info = M('memorial')->where($where)->select();
       foreach ($follow_info as $k => $v) {
            if($v['userid']){
               $username =  M('member')->where(array('id'=>$v['userid']))->getOne();
               if($username['username']){
                    $follow_info[$k]['fllow_name'] = $username['username'];
               }else{
                    $follow_info[$k]['fllow_name'] = $username['email'];
               }
            }
       }
       return $follow_info;
    }

    /**
     * 取消关注
     */
    public function cancelAction()
    {
        if(isAjax()){
            $fid = Controller::post('id');
            if($fid){
                $condition = array('id'=>$fid);
                $result = M('memorial_follow')->delete($condition);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '取消关注成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '取消关注失败'));
                    exit();
                }
            }
        }else{
            return null;
        }

    }

     /**
     * 贡献的祭品==================================================================================
     */
    public function sacrifice()
    {
        $is_nav = 1;
        $condtion = "b.place = 1 AND b.uid = {$this->is_login['id']} GROUP BY b.goods_id";

        // 分页star
        $count = M('memorial_goods_bought')
                ->field('b.*, m.name, g.gname, count(b.goods_id) AS gnums')
                ->join(' AS b LEFT JOIN mo_memorial AS m
                        ON b.mid = m.id
                        LEFT JOIN mo_memorial_funeray_goods AS g
                        ON b.goods_id = g.id
                    ')
                ->findCount($condtion);
        $pagesize = 10;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial_goods_bought')
                ->field('b.*, m.name, g.gname, count(b.goods_id) AS gnums')
                ->join(' AS b LEFT JOIN mo_memorial AS m
                        ON b.mid = m.id
                        LEFT JOIN mo_memorial_funeray_goods AS g
                        ON b.goods_id = g.id
                    ')
                 ->where($condtion)
                 ->select();
        return $lists;
    }


}
