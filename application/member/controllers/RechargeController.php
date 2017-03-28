<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 充值控制器类
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

class RechargeController extends HomeController {
    public $is_login; //是否登录

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
    }

    //资金管理 - 当前用户的元宝数量
    public function userInfo()
    {
        $condtion = array(
            'id'=>$_SESSION['front_login_info']['id']
            );
        $yuanbao = M('member')->where($condtion)->getOne();
        if(!$yuanbao['username']){
            $yuanbao['username'] = $yuanbao['email'];
        }
        return $yuanbao;
    }

    //在线充值
    public function onlineAction()
    {
        $isNav = 3;
        $is_nav = 3;

        //获取商品的列表
        $goods = M('memorial_acer')->select();

        //元宝数量
        $yuanbao = $this->userInfo();

        include $this->display('member/money_view/online.html');
    }

    //充值记录
    public function recordingAction()
    {
        $isNav = 3;

        $is_nav = 2;
        $condtion = array(
            'userid'=>$this->is_login['id'],
            'status'=>2
        );
        // 分页star
        $count = M('member_order')->findCount($condtion);
        $pagesize = 12;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'orderid desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('member_order')->select($options);
         //元宝数量
        $yuanbao = $this->userInfo();


        include $this->display('member/money_view/recording.html');
    }

    //消费记录
    public function consumptionAction()
    {
        $isNav = 3;

        $is_nav = 1;
        $condtion = array(
            'uid'=>$this->is_login['id']
        );
        // 分页star
        $count = M('memorial_buy_goods_record')->findCount($condtion);
        $pagesize = 5;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial_buy_goods_record')->select($options);

         //元宝数量
        $yuanbao = $this->userInfo();


        include $this->display('member/money_view/consumption.html');
    }




    /**
     * 贡献的祭品==================================================================================
     */
    public function sacrificeAction()
    {
        $isNav = 4;

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
        $pagesize = 5;
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
        include $this->display('member/recording_view/sacrifice.html');
    }

    /**
     * 撤销祭品
     */
    public function clearJipinAction()
    {
        if(isAjax()){
            $id = intval(Controller::post('id'));
        }
        return null;
    }

    /**
     * 发布的留言
     */
    public function messageAction()
    {
        $isNav = 4;

        if(isset($_POST['id'])){
            $id = Controller::post('id');
            $condtion = array(
                'uid'=>$this->is_login['id'],
                'id'=>$id
                );
            $result = M('memorial_comment')->delete($condtion);
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }else{
            $is_nav = 2;
            $condtion = array(
                'uid'=>$this->is_login['id'],
                'aid'=>0
            );
            // 分页star
            $count = M('memorial_comment')->findCount($condtion);
            $pagesize = 5;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $condtion;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $lists = M('memorial_comment')->select($options);

            foreach ($lists as $key => $value) {
                if($value['mid']){
                    $info = M('memorial')->field('personname')->where(array('id'=>$value['mid']))->getOne();
                }
                $lists[$key]['memorial_name'] = $info['personname'];
            }
        }

        include $this->display('member/recording_view/message.html');
    }

    /**
     * 我的评论
     */
    public function commentAction()
    {
        $isNav = 4;
        if(isset($_POST['id'])){
            $id = Controller::post('id');
            $condtion = array(
                'uid'=>$this->is_login['id'],
                'id'=>$id
                );
            $result = M('memorial_comment')->delete($condtion);
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }else{
            $is_nav = 3;
            $condtion = "uid = {$this->is_login['id']} AND aid !=0";

            // 分页star
            $count = M('memorial_comment')->findCount($condtion);
            $pagesize = 5;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $condtion;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $lists = M('memorial_comment')->select($options);

            foreach ($lists as $key => $value) {
                if($value['mid']){
                    $info = M('memorial')->field('personname')->where(array('id'=>$value['mid']))->getOne();
                }
                $lists[$key]['memorial_name'] = $info['personname'];
            }
            include $this->display('member/recording_view/comment.html');
        }
    }


}
