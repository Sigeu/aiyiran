<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 二维码投放位管理
 * 
 * 文件修改记录：
 * <br>王少辰  2013-9-3 上午08:50:55 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-3 上午08:50:55
 * @filename   QrpositionController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class QrpositionController extends AdminController {

    private $objPositionList;

    public function init()
    {
        $this->objPositionList = M('qrposition');        
        parent::init();
    }
    
    /**
     * 显示二维码投放位列表
     * 
     * @access public
     * @return string
     */
    public function indexAction() {
        $pageInfo = array();//分页信息
        $where    = array();//搜索条件
        $options  = array();//查询配置
        
        $position_name = isset($_GET['name']) ? $_GET['name'] : '';//栏位名称
        //$cid = isset($_GET['cid']) ? $_GET['cid'] : '';//投放栏目
        
        if (isset($position_name)&&!empty($position_name))
        {                
            $where['or'] = " name like '%{$position_name}%' ";            
        }
        
        $pageInfo = array(
            'name' => $position_name,
        );
        $count = $this->objPositionList->findCount($where);//符合条件的投放位个数
        $pagesize = 20;//每页条数
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $field = array('id', 'name');
        $options['limit'] = $from.','.$pagesize;
        $options['where'] = $where;
        $options['order'] = "id DESC";
        
        $list = $this->objPositionList->field($field)->select($options);    //执行搜索后分页操作
        $qrcode_obj = M('qrcode');
        $current_time = time();
        foreach ($list as $key => $val) {
            $deltips = '确认删除？';//删除提示
            $qrcount = $qrcode_obj->findCount(array('position_id' => $val['id']));//该投放位下包含二维码个数
            if ($qrcount) {
                $deltips = '投放位下有二维码数据，如删除投放位则二维码同步删除，确定删除？';
            }
            $list[$key]['deltips'] = $deltips;
            $list[$key]['count'] = $qrcount;
            $pid = $val['id'];
            $code_id = 0;//该投放位可调用的二维码id
            $qrcode = $qrcode_obj->where("position_id = $pid and (time_limit = 0 or (start_time <= $current_time and end_time >= $current_time))")->order('id desc')->getOne();
            if ($qrcode) {
                $code_id = $qrcode['id'];
            }
            $list[$key]['code_id'] = $code_id;
        }
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $pageInfo['page'] = $currpage;
        $this->assign('pageInfo', $pageInfo);
        $this->assign('pagestr', $pagestr);
        $this->assign('list', $list);
        $this->display('extensions/qrposition/qrposition_index.html');
    }

    
    /**
     * 添加二维码投放位
     *
     * @access public
     * @return string
     */
    public function addAction() {
        
        $categoryObj = M('category');
        if(!empty($_POST['qrposition'])) {   
            $param = $_POST['qrposition'];
            $ins = $this->objPositionList->create($param);           //执行添加投放位操作
            if($ins){
                $this->dialog('/extensions/qrposition/index','success','添加成功！');
            }
        } else {
            $this -> display('extensions/qrposition/qrposition_add.html');
        }
    }
    
    
    /**
     * 修改二维码投放位
     *
     * @access public
     * @return string
     */
    public function editAction () {       
        $id = $this->getParams('id');//修改的id  显示模板
        if (isset($id) && !empty($id)) {
            $qrposition = $this->objPositionList->where("id = $id")->getOne();//要修改的记录信息
            if ($qrposition) {
                if (!empty($_POST['qrposition'])) {
                    $param = $_POST['qrposition'];//表单数据
                    $update = $this->objPositionList->update(array('id'=>$id), $param);
                    if ($update) {
                        $this->dialog('/extensions/qrposition/index','success','修改成功！');
                    }
                }
                $this -> assign('qrposition', $qrposition);
                $this -> display('extensions/qrposition/qrposition_edit.html');
            }
        }   
    }
    
    /**
     * 删除二维码投放位
     *
     * @access public
     * @return string
     */
    public function deleteAction() {    
        $ids = $this->getIds('ids');//获取要删除的id字符串
        if (empty($ids)) {
            if(!empty($_GET['id'])) {        //执行单个删除操作
                $ids = $_GET['id'];
            }
        }
        $info = '删除失败，请重试！';
        if(!empty($ids)){
            $qrcode = M('qrcode');
            $del_qrcode = $qrcode->delete(array('in'=>array('position_id'=>$ids)));
            if ($del_qrcode) {
                $del_position = $this->objPositionList->delete(array('in'=>array('id'=>$ids)));
                if($del_position){
                    $info = '删除成功';
                }                   
            } 
        }
        $this->dialog('/extensions/qrposition/index','success',$info);   
    }
    
    //代码调用
    public function callCodeAction(){
    	$id = $this->getParams('id');
        $pid = $this->getParams('pid');
    	$this->assign('id' ,$id);
        $this->assign('pid' ,$pid);
    	$this->display("extensions/qrposition/call_code");
    }
}
