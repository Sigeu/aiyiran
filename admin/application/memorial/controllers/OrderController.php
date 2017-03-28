<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentModel.php
 *
 * 内容管理模型类
 *
 * @author     月下追魂<youkaili@mail.b2b.cn>   2017年3月8日17:20:03
 * @filename   HallModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

if (!defined('IN_MAINONE')) exit('No permission');
class OrderController extends AdminController
{
    public $obj;
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->obj = M('member_order');
        parent::init();
    }

    /**
     * 订单列表
     */
    public function orderlistAction()
    {
        // 分页star
        $status = $this->getParams('status', 0);//订单状态
        if(!empty($status)){
            $where = array('status'=>$status);
        }else{
            $where = array();
        }
        $count = $this->obj->findCount($where);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'orderid desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = $this->obj->select($options);
        // 分页end

        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign("list", $list);

        /**
         * 当前筛选参数
         */
        $params = array(
            'status'=>$status
        );
        $this->assign('params', $params);
        $this->display('memorial/order/orderlist');
    }

    /**
     * 删除订单
     */
    public function orderDeleteAction()
    {
        $id = $this->getIds('orderid');
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('orderid'=>$id),
        );

        $rs = $this->obj->delete($where);

        if ($rs) {
            admin_log('订单管理','删除'.$id);
            $this->dialog("/memorial/order/orderlist/page/{$arr['page']}",'success','操作成功');
            exit;
        } else {
            $this->dialog("/memorial/order/orderlist/page/{$arr['page']}",'error','操作失败');
            exit;
        }
    }

    /**
     * 订单详情
     */
    public function orderInfoAction()
    {
        $orderid = Controller::get('orderid');
        $condition = array('orderid'=>$orderid);
        $order = $this->obj
            ->field('mo_member_order.*, m.username, m.email')
            ->join('mo_member AS m ON m.id = `mo_member_order`.userid
        ')->where($condition)->getOne();
        $this->assign('order', $order);
        $this->display('memorial/order/orderInfo.html');
    }

    /**
     * 订单修改
     */
    public function orderConfirmAction()
    {
        $orderid = Controller::post('orderid');
        $orderid = isset($orderid) ? $orderid : 0;
        $remarks = Controller::post('remarks');
        $condition = array(
            'orderid'=>$orderid
        );
        $data = array(
            'status'=>2
        );
        //修改订单备注
        if(!empty($remarks)){
            M('member_order')->update($condition, array('remarks'=>$remarks));

        }

        //获取当前订单的信息
        $order = $this->obj->where(array('orderid'=>$orderid))->getOne();
        if($order){
            $orderinfo = $this->obj->update($condition, $data); //修改订单状态
            if($orderinfo){
                // 修改元宝数量
                // 获取当前的元宝数量然后在其基础上增加
                $point_num = M('member')->field('point')->where(array('id'=>$order['userid']))->getOne();
                $point  = $point_num['point'] + $order['yuanbao_num']; //计算要增加元宝数量
                $acer = M('member')->update(array('id'=>$order['userid']), array('point'=>$point));
                if(!$acer) {
                    $this->dialog("/memorial/order/orderInfo/orderid/$orderid", 'error', '操作失败');
                }else{
                    // 操作账户流水表
                    $data = array(
                        'userid'=>$order['userid'], //用户id
                        'point'=>$order['money'],     //订单的元宝数量
                        'addtime'=>time(), //操作时间
                        'pay_type'=>2, //系统奖励
                    );
                    M('member_water')->create($data);
                    $this->dialog("/memorial/order/orderlist", 'success', '操作成功');
                }
            }
        }
    }

    /**
     * 账户变动记录
     */
    public function annalAction()
    {
        $count = M('member_water')
            ->field('mo_member_water.*, m.username, m.email')
            ->join('mo_member AS m ON m.id = `mo_member_order`.userid')
//            ->where(array('pay_type'=>2))
            ->findCount();
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('member_water')
            ->field('m.username, m.email,mo_member_water.*')
            ->join('mo_member AS m ON m.id = `mo_member_water`.userid')
            ->select($options);
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('annal', $list);
        $this->display('memorial/order/annalList.html');
    }

    /**
     * 账户变动记录删除
     */
    public function annalDeleteAction()
    {
        $id = $this->getIds('id');
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id'=>$id),
        );

        //修改状态为删除，不能直接删除了

        $rs = M('member_water')->delete($where);
        if ($rs) {
            admin_log('充值记录','删除id:'.$id);
            $this->dialog("/memorial/order/annal/page/{$arr['page']}",'success','操作成功');
            exit;
        } else {
            $this->dialog("/memorial/order/annal/page/{$arr['page']}",'error','操作失败');
            exit;
        }
    }

    /**
     * 账户变动记录信息
     */
    public function annalInfoAction()
    {
        $id = $this->getParams('id', 0);
        $info = M('member_water')
            ->field('m.*,m.point AS ss,mo_member_water.*')
            ->join('mo_member AS m ON m.id = `mo_member_water`.userid')
            ->getOne();
        $this->assign('info', $info);
        $this->display('memorial/order/annalInfo.html');
    }

    /**
     * 充值列表
     */
    public function rechargeListAction()
    {
        $condition = array('status=>1');
        $count = M('member')->field('id,username,email,point,consume_num')
            ->where($condition)->findCount();

        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list =M('member')->field('id,username,email,point,consume_num')
            ->where($condition)
            ->select($options);
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('list', $list);
        $this->display('memorial/order/rechargeList.html');
    }

    public function updateRechargeAction()
    {

    }

    public function inc_rechargeAction()
    {
        $id = $this->getParams('id', 0);
//        $arr['page'] = $this->getParams('page');
//
        $condition = array('id'=>$id);
        $info = M('member')->where($condition)->getOne();
        $this->assign('info', $info);
//        if(!$info){
//            $this->dialog("/memorial/order/rechargeList/page/{$arr['page']}",'error','操作失败');
//        }

        $this->display('memorial/order/inc_recharge.html');
    }

    public function modrechargeAction()
    {
        if (isPost()) {
            $id = Controller::post('id');
            $point = intval(Controller::post('point'));
            $point = isset($point) ? $point : 0;
            $remarks = Controller::post('remarks');
            $condition = array('id' => $id);

            //元宝数量不是空的，并且是一个数字
            if (!empty($point) && is_numeric($point)) {
                //获取原来的元宝数量
                $old = M('member')->where($condition)->getOne();
                $data = array();
                // 判断是增加还是减少
                if ($point >0) {
                    $data['point'] = $old['point'] + $point; //老的元宝数量+要增加的数量
                    // 操作账户流水表
                    $liushui = array(
                        'userid'=>$old['id'], //用户id
                        'point'=>$point,     //订单的元宝数量
                        'addtime'=>time(), //操作时间
                        'pay_type'=>2, //系统奖励
                    );
                    M('member_water')->create($liushui);

                } else {
                    $data['point'] = $old['point'] + $point; //老的元宝数量-要减少的数量
                    // 操作账户流水表
                    $liushui = array(
                        'userid'=>$old['id'], //用户id
                        'point'=>$point,     //订单的元宝数量
                        'addtime'=>time(), //操作时间
                        'pay_type'=>3, //系统扣除
                    );
                    M('member_water')->create($liushui);
                }
                $data['remarks'] = $remarks;    //备注
                $result = M('member')->update($condition, $data);
                if ($result) {
                    admin_log('修改用户元宝数量', 'id:' . $id);
                    echo json_encode(array('status'=>1,'msg'=>'操作成功'));
                }
            } else {
                echo json_encode(array('status'=>2,'msg'=>'操作失败'));
            }

        }
    }

    public function consumeAction()
    {

        $count =  M('memorial_buy_goods_record')
            ->findCount();
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'b.id desc';
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('memorial_buy_goods_record')
            ->select();
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('list', $list);
        $this->display('memorial/order/consumeList.html');
    }

    public function consumeDeleteAction()
    {
        $id = $this->getIds('id');
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id'=>$id),
        );
        $rs = M('memorial_buy_goods_record')->delete($where);
        if ($rs) {
            admin_log('消费记录','删除id:'.$id);
            $this->dialog("/memorial/order/consume/page/{$arr['page']}",'success','操作成功');
            exit;
        } else {
            $this->dialog("/memorial/order/consume/page/{$arr['page']}",'error','操作失败');
            exit;
        }
    }

    public function consumeInfoAction()
    {
        $id = $this->getParams('id',0);
        $condition = array('id'=>$id);
        $info = M('memorial_buy_goods_record')
            ->where($condition)
        ->getOne();
        $this->assign('info', $info);
        $this->display('memorial/order/consumeInfo.html');
    }

    //系统消息列表
    public function systemMessageAction()
    {
        $count =  M('memorial_news')
            ->findCount();
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('memorial_news')
            ->select();
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('list', $list);
        $this->display('memorial/order/systemMessage.html');
    }

    /**
     * 删除系统消息
     */
    public function deleteMessagAction()
    {
        $id = $this->getIds('id');
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id'=>$id),
        );
        $rs = M('memorial_news')->delete($where);
        //删除了某条消息
        //对应的也要删除用户的
        if ($rs) {
            admin_log('系统消息','删除id:'.$id);
            $this->dialog("/memorial/order/systemMessage/page/{$arr['page']}",'success','操作成功');
            exit;
        } else {
            $this->dialog("/memorial/order/systemMessage/page/{$arr['page']}",'error','操作失败');
            exit;
        }
    }

    /**
     * 添加系统消息
     */
    public function addSystemMessageAction()
    {
        if(isPost()){
            $data = array();
            $data['title'] = Controller::post('title');
            $data['content'] = Controller::post('content');
            $data['addtime'] = time();
            if(empty($data['title'])){
                $this->dialog("/memorial/order/systemMessage",'error','操作失败');exit();
            }
            if(empty($data['content'])){
                $this->dialog("/memorial/order/systemMessage",'error','操作失败');exit();
            }
            $result = M('memorial_news')->create($data);
            if ($result) {
                admin_log('系统消息','添加id:'.$id);
                $this->dialog("/memorial/order/systemMessage",'success','操作成功');
                exit;
            } else {
                $this->dialog("/memorial/order/systemMessage",'error','操作失败');
                exit;
            }
        }
        $this->display('memorial/order/addSystemMessage.html');
    }


}