<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-5-15 上午10:34:09 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-5-15 上午10:34:09

 * @filename   FormController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: FormController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class FormController extends AdminController {
	//注册表单列表
	public function indexAction(){
		$obj = $this->getFormObj();
		$option['where'] = array('flag'=>2);
		$option['order'] = 'id desc';
		$list = $obj->select($option);
		$this->assign('list',$list);
		$this->display('members/form/form_list');
	}
	//添加表单
	public function addFormAction(){
	  
	  if(!empty($_POST))
	  {
		$obj = $this->getFormObj();
		$model_obj = D("Form");
		
		$arr = array(
				'name'=>$this->getParams('name'),
				'addtime'=>time(),
				'forminfor'=>$this->getParams('text'),
				'state'=>$this->getParams('state'),
				'flag'=>2,
		);
		
		$curid = $obj->create($arr);
		
	    if($curid)
	    {
		    $this->_cache();  //更新会员注册表单列表缓存
		 
		    $obj->update(array('id'=>$curid),array('tablename'=>'member_'.$curid));
		    $model_obj->createTable("member_".$curid);//创建表
		    admin_log('添加表单', '添加'.$arr['name']."表单");  //添加日志
		    $this->dialog("/members/form/index",'success');
			
	    }else{
		 
		    $this->dialog("/members/form/index",'error');
	    }
	    
	  }else {
	  	
		$this->display("members/form/add");
	  }
	}
	//编辑表单
	public function editFormAction(){
		
		$id = $this->getIds('id');
		if(!empty($_POST))
		{
		    $obj = $this->getFormObj();
		    $model_obj = D("Form");
		
			$arr = array(
					'name'=>$this->getParams('name'),
					'addtime'=>time(),
					'forminfor'=>$this->getParams('text'),
					'state'=>$this->getParams('state'),
					'flag'=>2,
			);
			
			if($id){
				$arr['tablename'] = 'member_'.$id;
					
				if($obj->update(array('id'=>$id),$arr))
				{
					$this->_cache();  //更新会员注册表单列表缓存
					admin_log('修改表单', '修改'.$arr['name']."表单");  //添加日志
					$this->dialog("/members/form/index",'success');
				}else{
			
					$this->dialog("/members/form/index",'error');
				}
					
			}
		}else{
			
			$infor = array();
			$infor = $this->getFormObj()->where(array('id'=>$id))->getOne();
			
			$this->assign('id',$id);
			$this->assign('infor',$infor);
			$this->display("members/form/editor");
		}
		
	}
	/**
	 * 注册表单删除
	 * 
	 * 1.默认的注册表单不可删除只能修改
	 * 2.当某会员组使用了注册表单时，此会员表单不可以删除
	 * 
	 */
	
	public function  deleteAction()
	{
		$num = 0;
		$num_ok = 0;
		$num_fail = 0;
		$useformlist = array();
		
		$objAtr   = M("Attribute");
		$objMix   = $this->getFormObj();
		$objGroup = M("MemberGroup");
		$objForm  = D("Form");
		
		$id_str = $this->getIds('id');
		$id_arr = explode(',', $id_str);
		$name = urldecode($this->getParams('name'));
		
		$num = count($id_arr);
		//被会员组使用的注册表单
		$useformresult = $objGroup->field('registerform')->group("registerform")->select();
		foreach ($useformresult as $uf)
		{
			$useformlist[] = $uf['registerform'];
		}	
		//当前选中表单中可以删除的注册表单
        $delform_arr = array_diff($id_arr,$useformlist);
        $delform_str = implode(',',$delform_arr);
		$num_ok = count($delform_arr);
		$num_fail = $num-$num_ok;
		
		//操作日志  (删除了***注册表单)
		if ($id_arr)
		{
			$name = '';
			foreach ($id_arr as $id)
			{
				$forminfo = $objMix->find(array('id'=>$id));
				$name .= $forminfo['name'].' ';
			}
		}
		//删除操作提示  （成功删除**条，失败**条）

		if ($num_fail>0)
		{
			$tip = "成功删除{$num_ok}个注册表单，失败{$num_fail}个";
		}else
		{
			$tip = "成功删除{$num_ok}个注册表单";
		}
		
		//删除表单前先删除对应的数据表
		$objForm->deleteTable($delform_str);
		$objAtr->delete(array('in'=>array('modelid'=>$delform_str)));

		if ($objMix->delete(array('in'=>array('id'=>$delform_str))))
		{
			admin_log('删除表单', '删除'.$name.'表单');  //添加日志
			$this->_cache();                           //更新会员注册表单列表缓存
		}
		$this->dialog("/members/form/index",'success',$tip);
		
		
	}
	
	/*删除注册表单（废弃不用）*/
	public function delAction(){
        $baseId = $_GET['id'];
        $num = count($baseId);
        $atrObj = M("Attribute");
		$id = $this->getIds('id');
		$obj = $this->getFormObj();
		$group = M("MemberGroup");
		$userForm = D("Form");
		$name = urldecode($this->getParams('name'));
		if($id)
		{
			
			//表单被分组使用时不允许删除
		    $list = $group->where(array('in'=>array('registerform'=>$id)))->select();
			dump($list);exit;

		    if(is_array($baseId)) {

			foreach ($list as $lk=>$lv) {

				$k = array_search($lv['registerform'],$baseId);

				if ($k !== NULL && $k != false) {

			    	unset($baseId[$k]);
				}
			}
	        }else{ 

		         foreach ($list as $lk=>$lv) {

				 if ($lv['registerform'] == $baseId) {
					
			    	$this->dialog("/members/form/index",'error','失败删除1条');
					exit;
				 }
			     }

		    }

			$infor = $userForm->getUseForm($id);

			foreach ($infor as $ik=>$iv) {
				$i = array_search($iv['id'],$baseId);

				if($i !== NULL && $i !== false) {

					unset($baseId[$i]);
				}
			}
            $succId = count($baseId);
         
			if (is_array($baseId)) {

				$baseId = implode(',',$baseId);
			}

			$condition = array(
					'in'     => array('id'=>$baseId),
			);

			//删除表单前删除对应的数据表
			$tabObj = D("Form");
			$result = $tabObj->deleteTable($baseId);
			$atrObj->delete(array('in'=>array('modelid'=>$baseId)));
			$failNum = $num -$succId;
			$failStr = "";

			if ($failNum) {

				$failStr = ",失败删除".$failNum."条";
			}
			
			if (!$result)
			{
				$this->dialog("/members/form/index",'error','失败删除'.$failNum."条");
				exit;
			}
			//删除表单信息
			if($obj->delete($condition)){
				admin_log('删除表单', '删除'.$name.'表单');  //添加日志
    			$this->_cache();  //更新会员注册表单列表缓存
				$this->dialog("/members/form/index",'success','成功删除'.$succId."条表单".$failStr);
			}else{
				$this->dialog("/members/form/index",'error','失败删除'.$failNum."条");
			}
		}
	}

	//关闭、开启表单
	public function operaAction(){
       $state = $this->get('sate');
       $id = $this->getIds('id');
       $obj = $this->getFormObj();
        
       if ($state ==1) {
       	
           $opera = "关闭表单";	
       }else {
       	 
       	   $opera = "开启表单";
       }
       
       if($id){
	       	$condition = array(
	       			'in'     => array('id'=>$id),
	       	);
	       	
	       	if($obj->update($condition, array('state'=>$state))){
                
	       		admin_log($opera, $opera);  //添加日志
    			$this->_cache();  //更新会员注册表单列表缓存
	       		$this->redirect($this->createUrl('/members/form/index'));
	       	}
       }
	}
	
	//复制表单
	public function copyFormAction(){
		$id = $this->getIds('id');
		$obj = $this->getAtrObj();
		$mObj = D("Form");
		//需要复制的表单及表单属性
		$fields = $obj->where(array('modelid'=>$id))->select();
		$curinfor = $this->getFormObj()->getOne(array('where'=>array('id'=>$id)));

		if ($curinfor['num'] >= 0 && $curinfor['num'] < 10) {
			
			$num = $curinfor['num']+1;
			$curinfor['num'] = "0".$num."";
		} else {
			
			$num = $curinfor['num']+1;
		}

		$curinfor['name'] = $curinfor['name'].$curinfor['num'];
		
		unset($curinfor['id'],$curinfor['def'],$curinfor['tablename'],$curinfor['num']);
		
		$max_id = $this->getFormObj()->create($curinfor);
		//更新数据表名字段
		$this->getFormObj()->update(array('id'=>$max_id),array('tablename'=>'member_'.$max_id));
		$this->getFormObj()->update(array('id'=>$id),array('num'=>$num));
		$mObj->createTable("member_".$max_id);
		$this->_cache();  //更新会员注册表单列表缓存
		//alter table yourtable add(A21 number(10),A22 varchar2(20),A23 varchar2(20));
		if(!empty($fields)){

		  $sql = "";
		  foreach($fields as $fk=>$fv){
			unset($fields[$fk]['id']);
			$fields[$fk]['modelid'] =  $max_id;
			$fields[$fk]['name'] = "'".$fv['name'] ."'";
			$fields[$fk]['dataname'] = "'".$fv['dataname'] ."'";
			$fields[$fk]['fieldtips'] = "'".$fv['fieldtips'] ."'";
			$fields[$fk]['regex'] = "'".$fv['regex'] ."'";
			$fields[$fk]['regkey'] = "'".$fv['regkey'] ."'";
			$fields[$fk]['defaultvalue'] = "'".$fv['regex'] ."'";
			$fields[$fk]['errortips'] = "'".$fv['errortips'] ."'";
			$fields[$fk]['fieldtype'] = "'".$fv['fieldtype'] ."'";
			
			$sql .=$fv['dataname']." ".$fv['fieldtype']."(".$fv['maxval']."),";
		 }

		if($obj->addAll($fields)){
			
			$mObj->alertManyClumn($sql,'member_'.$max_id);//新生成表中添加字段
			
			$this->dialog("/members/form/index",'success','操作成功!');
		}else{
			
			$this->dialog("/members/form/index",'error','操作失败!');
		}
	  }else if($max_id){
    	
	  	$this->dialog("/members/form/index",'success','操作成功!');
	  }else{
	  	
	  	$this->dialog("/members/form/index",'error','操作失败!');
	  }
	}

	//获取操作对像
	public function getFormObj(){
		return M('MixModel');
	}
	//获取属性表对像
	public function getAtrObj(){
		return M('Attribute');
	}
	
	/**
	 * 生成会员注册表单列表缓存(开启状态的缓存，用于添加、修改会员分组会员注册表单下拉列表)
	 * @return  array(id=>name)
	 * @author wr 2013.4.8
	 */
	protected function _cache()
	{
		$objForm = D('Form');
		$objForm->getMemberFormCacheList();       //开启的会员表单
	}
	
}