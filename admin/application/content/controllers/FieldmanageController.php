<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * FieldlmanageController.php
 * 
 * 字段管理类 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-24 上午11:29:39
 * @filename   FieldlmanageController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class FieldmanageController extends AdminController
{
	public static $page; //当前页码
	public $fieldModel; //模型对象
	public static $modelid;
	public  $myModel;
	public function init()
	{
		
		self::$page =  Controller::get('p') ? Controller::get('p') : Controller::get('page') ;
		self::$page = self::$page ? self::$page : 1;
		self::$modelid =  Controller::get('modelid');
		$this->fieldModel = D('Field');
		$this->myModel = D('My');
		//判断登陆
		//判断权限
	}

	/**
	 * 字段管理
	 */
	public function indexAction()
	{
		$fieldArr = include DIR_BF_ROOT.'field/fieldArray.php'; //字段
		$urlArr = array(
			'previewUrl' => $this->createUrl('content/Content/preview/page/'.self::$page.'/modelid/'.self::$modelid),
			'addfieldUrl' => $this->createUrl('content/Fieldmanage/add/page/'.self::$page.'/modelid/'.self::$modelid),
			'setOrderIdUrl' => $this->createUrl('content/Fieldmanage/setOrderId/page/'.self::$page.'/modelid/'.self::$modelid),
			'delUrl' => $this->createUrl('content/Fieldmanage/del/page/'.self::$page.'/modelid/'.self::$modelid),
			'setflagUrl' => $this->createUrl('content/Fieldmanage/setflag/page/'.self::$page.'/modelid/'.self::$modelid),
			'updateUrl' => $this->createUrl('content/Fieldmanage/update/page/'.self::$page.'/modelid/'.self::$modelid),
		);
		$fieldlist = $this->fieldModel->where(array('modelid'=>self::$modelid))->select();
		
		$pagesize = 20;
		$page = new Page(count($fieldlist), $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = 'sortid,addtime desc';
		$list = $this->fieldModel->where(array('modelid'=>self::$modelid))->select($options);
		
		$nodisablelist = include DIR_BF_ROOT.'field/noDisabled.php'; //禁止关闭的
		$nodeletelist = include DIR_BF_ROOT.'field/noDelete.php'; //禁止删除的
		$noupdatelist = include DIR_BF_ROOT.'field/noUpdate.php'; //禁止删除的

		$this->assign('pagestr',$page->show());
		$this->assign('urlArr',$urlArr);
		$this->assign('fieldArr',$fieldArr);
		$this->assign('fieldlist',$list);
		$this->assign('nodisablelist',$nodisablelist);
		$this->assign('nodeletelist',$nodeletelist);
		$this->assign('noupdatelist',$noupdatelist);
		$this->display("content/fieldmanage/index");
	}
	/**
	 * 添加字段
	 */
	public function addAction()
	{
		$urlArr = array(
			'addsaveUrl' => $this->createUrl('content/Fieldmanage/save/page/'.self::$page.'/modelid/'.self::$modelid),
			'checkFieldUrl' => $this->createUrl('content/Fieldmanage/checkField/page/'.self::$page.'/modelid/'.self::$modelid),
			'setFieldUrl' => $this->createUrl('content/Fieldmanage/setField/page/'.self::$page.'/modelid/'.self::$modelid),
			'setFlagUrl' => $this->createUrl('content/Fieldmanage/setflagUrl/page/'.self::$page.'/modelid/'.self::$modelid),
			'previewUrl' => $this->createUrl('content/Content/preview/page/'.self::$page.'/modelid/'.self::$modelid),
			'fieldUrl' => $this->createUrl('content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid)
		);
	
		$fieldPattern = include DIR_BF_ROOT.'field'.DS.'fieldPattern.php';
		$fieldArr = include DIR_BF_ROOT.'field'.DS.'fieldArray.php';
		$noShow = include DIR_BF_ROOT.'field/noShow.php'; //添加的时候不显示的字段
		
		$this->assign('urlArr',$urlArr);
		$this->assign('modelid',self::$modelid);
		$this->assign('fieldArr',$fieldArr);
		$this->assign('noShow',$noShow);
		$this->assign('fieldPattern',$fieldPattern);
		$this->display("content/fieldmanage/add");
	}
	/**
	 * 添加字段
	 */
	public function saveAction()
	{
		$field = Controller::post('fieldinfo');
		$field['isnull'] = isset($field['isnull']) ? $field['isnull'] : '2';
		$field['issearch'] = isset($field['issearch']) ? $field['issearch'] : '2';
		$field['isunique'] = isset($field['isunique']) ? $field['isunique'] : '2';
		$field['addtime'] = time();
		$mustDefault = array('select,radio,checkbox,sortype');
		if(in_array($field['fieldtype'],$mustDefault)&&$field['defaultvalue']=='')
		{
			$this -> dialog('','error','下拉框，多选项，单选项必须有默认值');
		}
		$fieldsetArr = $this->getFieldset($field["fieldtype"]);
		$dbtype = $fieldsetArr['fieldtype'];
		$this->fieldModel->query("BEGIN");
		$this->fieldModel->query("START TRANSACTION");
		//$flag = $this->fieldModel->tabaleAddField(self::$modelid ,$field['field'],$dbtype,$field['maxlength'],$field['defaultvalue'],$field['isnull'],$field['isunique']); //从表添加字段
		$flag = $this->fieldModel->tabaleAddField(self::$modelid ,$field['field'],$dbtype,$field['maxlength'],$field['defaultvalue'],$field['fieldtype']); //从表添加字段
		$lastInsertId = $this->fieldModel->create($field);  //字段表添加数据
		if($flag && $lastInsertId)
		{
			$this->fieldModel->query('COMMIT');
			$this->fieldModel->query('END');
			admin_log('添加字段', '添加了字段'.$field['name']);
			$this->dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'success','操作成功');
		}
		else
		{
			$this->fieldModel->query('ROLLBACK');
			$this->fieldModel->query('END');
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error','添加失败');
		}
	}
	/**
	 * 设置字段状态
	 */
	function setflagAction()
	{
		$ids = Controller::get('id') ? Controller::get('id') : Controller::post('id');
		$flag = Controller::get('flag') ? Controller::get('flag') : Controller::post('flag');
		$nodisablelist = include DIR_BF_ROOT.'field/noDisabled.php'; //禁止关闭的
		$fieldname = Controller::get('field') ? Controller::get('field') : Controller::post('field');
		if(is_array($fieldname)&&$flag==2)
		{
			$nodis = array_intersect($nodisablelist, $fieldname);
			if(!empty($nodis))
			{   
				$newArrs = array_flip($nodisablelist);
				foreach($nodis as $key=>$value)
				{
					$names[] = $newArrs[$value];
				}
				$names = implode($names, ',');
				$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error',$names.'是系统字段，不能关闭');
			}
		}
		elseif(in_array($fieldname, $nodisablelist)&&$flag==2)
		{
			$newArr = array_flip($nodisablelist);
		    $name = $newArr[$fieldname];
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error',$name.'是系统字段，不能关闭');
		}
		if(is_array($ids))
		{
			$ids = implode($ids,',');
			$flag = $this->fieldModel->update(array('in'=>array('id'=>$ids)),array('flag'=>$flag));
		}
		else
		{
			$flag = $this->fieldModel->update(array('id'=>$ids),array('flag'=>$flag));
		}
		if($flag)
		{
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'success','操作成功');
		}
		else
		{
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error','操作失败');
		}
	}
	
	/**
	 * 删除字段
	 */
	function delAction()
	{
		$ids = Controller::get('id') ? Controller::get('id') : Controller::post('id');
		$fieldname = Controller::get('field') ? Controller::get('field') : Controller::post('field');
		$nodeletelist = include DIR_BF_ROOT.'field/noDelete.php'; //禁止关闭的
		$fieldname = Controller::get('field') ? Controller::get('field') : Controller::post('field');
		if(is_array($fieldname))
		{
			$nodel = array_keys(array_intersect($nodeletelist, $fieldname));
			if(!empty($nodel))
			{
				$nodel = implode($nodel, ',');			
				$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'info',$nodel.'是系统字段，不能删除');
			}

		}
		elseif(in_array($fieldname, $nodeletelist))
		{
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'info',$fieldname.'是系统字段，不能删除');
		}
		$ids = is_array($ids) ? implode($ids,',') : $ids;
		$this->fieldModel->query("BEGIN");
		$this->fieldModel->query("START TRANSACTION");
		$flag = $this->fieldModel->delete(array('in'=>array('id'=>$ids)));//删除字段
		$flag2 = $this->fieldModel->deleteTableField(self::$modelid , $fieldname);//删除从表中表字段
		if($flag&&$flag2)
		{
			$fieldname = is_array($fieldname) ? implode(',',$fieldname) : $fieldname;
			admin_log('删除字段', '删除了字段'.$fieldname);
			$this->fieldModel->query("COMMIT");
			$this->fieldModel->query("END");
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'success','删除成功');
		}
		else
		{
			$this->fieldModel->query("ROLLBACK");
			$this->fieldModel->query("END");
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error','操作失败');
		}
	}
	/**
	 * 修改字段
	 */
	public function updateAction()
	{
		
		if(Controller::post('dosubmit'))
		{
			
			$newField = Controller::post("fieldinfo");
			$fieldsetArr = $this->getFieldset($newField["fieldtype"]);
	    	$dbtype = $fieldsetArr['fieldtype'];
			$flag = $this->fieldModel->update(array('id'=>$_POST['fieldinfo']['id']),$newField);
		    $flag2 = $this->fieldModel->tabaleupdateField(self::$modelid ,Controller::post('oldfield'),$newField['field'],$dbtype,$newField['maxlength'],$newField['defaultvalue'],$newField['fieldtype']); //从表添加字段
			
			if($flag)
			{
				admin_log('修改字段', '修改了字段'.$newField['field']);
				$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'success','修改成功');
			}
			else
			{
				$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error','操作失败');
			}
		}
		else 
		{
			$id = Controller::get('id');
			$fieldInfo = $this->fieldModel->where(array('id'=>$id))->getOne();
			$fieldArr = include DIR_BF_ROOT.'field'.DS.'fieldArray.php';       //字段类型
			$fieldPattern = include DIR_BF_ROOT.'field'.DS.'fieldPattern.php'; //正则
			$fieldSet = include DIR_BF_ROOT.'field'.DS.'fieldset'.DS.$fieldInfo['fieldtype'].DS.'config.inc.php'; //字段配置
			$nodisablelist = include DIR_BF_ROOT.'field/noDisabled.php'; //禁止关闭的
			$noupdatelist = include DIR_BF_ROOT.'field/noUpdate.php'; //禁止修改的
			/*$tablename = $fieldInfo['issystem'] ? 'maintable' : $this->fieldModel->getTableName(self::$modelid,false);
			$data = M($tablename)->field($fieldInfo['field'])->select();
			if (count($data) != count(array_unique($data))){    //判断是否有重复
				$fieldSet['isunique'] = 2;
			}
			if (in_array('',$data)){    //判断是否有空值
				$fieldSet['isnull'] = 2;
			}*/
			$urlArr = array(
				'updateUrl' => $this->createUrl('content/Fieldmanage/update/page/'.self::$page.'/modelid/'.self::$modelid),
				'checkFieldUrl'=> $this->createUrl('content/Fieldmanage/checkField/page/'.self::$page.'/modelid/'.self::$modelid),
			);
			$this->assign('urlArr',$urlArr);
			$this->assign('fieldInfo',$fieldInfo);
			$this->assign('fieldArr',$fieldArr);
			$this->assign('fieldSet',$fieldSet);
			$this->assign('fieldPattern',$fieldPattern);
			$this->assign('nodisablelist',$nodisablelist);
			$this->assign('noupdatelist',$noupdatelist);
			$this->display('content/fieldmanage/update');
		}
		
	}
	
	/**
	 * 
	 * 更新排序
	 */
	public function setOrderIdAction()
	{
		$sortid = Controller::post('sortid');
		$ids = Controller::post('ids');
		$options = array_combine($ids, $sortid);
		$flag = $this->fieldModel->updateAll('id','sortid',$options,$ids);
		if($flag)
		{
			$this->dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'success','操作成功');
		}
		else
		{
			$this -> dialog('/content/Fieldmanage/index/page/'.self::$page.'/modelid/'.self::$modelid,'error','添加失败');
		}
	}
	
	/**
	 * 检查字段是否存在
	 */
	function checkFieldAction()
	{
		$modelid = Controller::get('modelid');
		$field = Controller::get('field');
		$tablename = $this->fieldModel->getTableName($modelid,false);
		$value = Controller::get('oldf');
		if($value==$field)
		{
			exit('0');
		}
		$fields = $this->fieldModel->getFields($tablename);
		$m_fields = array('categoryid','title','subtitle','thumb','keywords','description','brief','source','sorttype','sortnum','publishopt','publishtime','hits','publishuser','username','updatetime','updateuser','created');//主表字段
		$arr = array();
		foreach($fields as $key => $value)
		{
			$arr[]=$value['Field'];
		}		
		$arr = array_merge($arr,$m_fields);
		$flag =  in_array($field, $arr) ? '1' : '0';
		exit($flag);
	}
	/**
	 * 检查是否唯一
	 */
	function checkUniqueAction()
	{
		$field =Controller::get('uniquefield');
		$value = Controller::get($field);
		$modelid = Controller::get('modelid');
		$oldvalue = Controller::post('oldvalue');
		if($oldvalue==$value)
		{
			exit('0');
		}
		$msg = $this->fieldModel->checkUnique($field,$value,$modelid);
		exit($msg);
	}
	
	/**
	 * 表字段类型设置
	 */
	function setFieldAction()
	{
		$fieldname = Controller::post('fieldname');
		$fieldsetArr = $this->getFieldset($fieldname);
		Controller::ajax('','',$fieldsetArr);
	}
	/**
	 * 获取字段配置数组
	 */
	public function getFieldset($fieldname)
	{
		 return include DIR_BF_ROOT.'field'.DS.'fieldset'.DS.$fieldname.DS.'config.inc.php';
	}
	//获取联动菜单
	public function linkageAction()
	{
	
	    $parentid = $_POST['id'];
		$str = "<option value=''>--请选择--</option>";
		if($parentid != '')
		{
			$data = M('linkage_bill') -> findAll(array('pid'=>$parentid),'ordernum ASC,created DESC','id,lin_id,pid,name');
			foreach($data as $row){
			    $str .=  '<option value="'.$row['id'].'"';
			    $str .= '>'.$row['name'].'</option>';
			}
		}
		echo $str;exit;
	
	}
	
}