<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 用户注册协议
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-1-22 下午3:57:12 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-1-22 下午3:57:12

 * @filename   RegistController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: RegistController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class RegistController extends AdminController {
	//注册协议列表
	public function indexAction(){
		$regObj = $this->getObj();
		$groups = $this->getGroups();

		$list = $regObj->select(array('order'=>'id desc'));

		
		$this->assign('list',$list);
		$this->display('members/regist/regist_list');
	}
	//添加注册协议
    public function addregistAction(){
  
    	if(!empty($_POST)) {
    		
    		$regObj = $this->getObj();
    		$arr = array(
    				'content'=>$this->getParams('content'),
    				'iseffect'=> $this->getParams('state'),
    				'name'=>$this->getParams('name'),
    		);
    		 
    		if($regObj->create($arr)){
    		
    			$this->_cache();  //更新注册协议列表缓存
    			admin_log('添加协议', '添加'.$arr['name'].'协议');  //添加日志
    			$this->dialog('/members/Regist/index','','操作成功!');
    		}else{
    			$this->dialog('/members/Regist/index','error','操作失败!');
    		}
    	}else {
    		
    		$this->display('members/regist/addregist');
    	}
    	
    }
	//编辑协议
	public function editorRegistAction(){
		
		$regObj = $this->getObj();
// 		$id = $this->getIds('id');
		$id = $this->getParams('id');
		$infor = $regObj->find(array('id'=>$id));
		
		if (!empty($_POST)) {
    		$arr = array(
    				'content'=>$this->getParams('content'),
    				'iseffect'=> $this->getParams('state'),
    				'name'=>$this->getParams('name'),
    		);
			
			if($regObj->update(array('id'=>$id),$arr)){
			
				$this->_cache();  //更新注册协议列表缓存
				admin_log('修改协议', '修改'.$arr['name'].'协议');  //添加日志
				$this->dialog('/members/Regist/index','success','操作成功!');
			}else{
				$this->dialog('/members/Regist/index','success','操作失败!');
			}
		}
	
	        $this->assign('id',$id);
	    	$this->assign('infor',$infor);
	    	$this->display('members/regist/editor');
	}
   
    //获取会员组
    public function getGroups(){
    	$groupObj = M('MemberGroup');
    	 
    	$groups = $groupObj->select();
    	return $groups;
    }
    //删除协议
    public function deleteAction(){
    	$regObj =$this->getObj();
    	$delId = $_GET['id'];
    	$total = count($delId);
    	$id = $this->getIds('id');
        $group = M("MemberGroup");
        $name = urldecode($this->getParams('name'));

    	if($id){

    		$groups = $group->field('id,registerdeal')->select(array('where'=>array('in'=>array('registerdeal'=>$id))));

            if( is_array($delId)){

			  foreach ($groups as $gk=>$gv) {

    			$k=array_search($gv['registerdeal'],$delId);

    			if($k !== NULL && $k !==false) {
			
    				unset($delId[$k]);
    			}
    		  }
			}else{
			
			  foreach ($groups as $k=>$v) {

    			if($v['registerdeal'] == $delId) {

    				$this->dialog('/members/Regist/index','error','失败删除1条协议');
					exit;
    			}
    		  }
			}

            $sucNum = count($delId);
    		if(is_array($delId)) {
    		   
    			$id = implode(',',$delId);
    		}

    		$condition = array(
    				'in'   =>array('id'=>$id),
    		);
    		
    		$failNum = $total-$sucNum;
    		$failStr = '';
    		
    		if($failNum){

    			$failStr = ",失败".$failNum."条";
    		}
    		
    		if($regObj->delete($condition)){

    			$this->_cache();  //更新注册协议列表缓存
    			admin_log('删除协议', '删除'.$name.'协议');  //添加日志
    			$this->dialog('/members/Regist/index','','成功删除'.$sucNum."条协议".$failStr);
    		}else{
    			
    			$this->dialog('/members/Regist/index','error','失败删除'.$failNum.'条');
    		}
    	}
    }
    //开启,关闭
    public function openOrCloseAction()
    {
    	$regObj = $this->getObj();
    	$state = $this->getParams('state');
    	$id = $this->getIds('id');
    	
    	if ($state == 1) {

    		$opera = "开启协议";
    	}else {
    		
    		$opera = "关闭协议";
    	}
    	
    	if($id){
    		$condition = array(
    				'in'   =>array('id'=>$id),
    		);
    		if($regObj->update($condition, array('iseffect'=>$state))){
    			
    			$this->_cache();  //更新注册协议列表缓存
    			admin_log($opera , $opera);  //添加日志
    			$this->redirect($this->createUrl("members/Regist/index"));
    		}
    	}
    }

    public function checkTitleAction() {
	    $regObj = $this->getObj();
		$id = $this->getParams('id');
		$name = $this->getParams('name');
		
        $where['where']['name'] = $name;
        
        if($id) {
        	$where['where']['notin'] = array('id'=>$id);
        }
        	
		$list = $regObj->getOne($where);

		if (empty($list)){

		    echo 1;  //协议不存在
		} else {
		    echo 2; //协议名称存在
		}
	}
    //获取注册对像
    public function getObj(){
    	return M('Registdeal');
    }
    
    
    /**
     * 生成注册协议列表缓存(开启状态的缓存，用于添加、修改会员分组注册协议下拉列表)
     * @return  array(id=>name)
     * array (5 => '找回密码协议',30 => '注册协议', ),
     * 
     * @author wr 2013.4.8
     */
    protected function _cache()
    {
    	$objDeal = D('MemberDeal');
    	$objDeal->getMemberDealCacheList();       //开启的注册协议
    }
}