<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 模块管理 商品展示 商品类型  字段管理
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-18 11:50 创建此文件
 * <br>雷少进  2013-01-18 11:50 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsfieldController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodsfieldController extends AdminController
{
	/**
	 * 商品类型字段列表
	 *
	 */
	public function indexAction ()
	{
		//接参数
		$id = isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : 0 ;
		if(!$id) $this->dialog('','error','参数有误');

		$plist = $this -> getGoodsAttrModel() -> _getPageList($id);
		//字段列表
		$this -> assign('typeid',$id);
		$this -> assign('plist',$plist);
		$this -> display('modules/goods/modules_goodsfield_index.html');
	}

	/**
	 * 字段添加
	 *
	 */
	public function addAction ()
	{
		if(!empty($_POST))
		{
			//接值
			$info['attrname']		= isset ( $_POST['attrname'] ) ? trim($_POST['attrname']) : '';
			$info['typeid']			= isset($_POST['typeid']) ? intval($_POST['typeid']) : 0 ;
			$info['ordernum']		= 0;
			$info['fieldtype']		= isset($_POST['fieldtype']) ? intval($_POST['fieldtype']) : 1 ;
			$info['fieldtips']		= isset($_POST['fieldtips']) ? trim($_POST['fieldtips']) : '' ;
			$info['defaultvalue']	= isset($_POST['defaultvalue']) ? trim($_POST['defaultvalue']) : '' ;
			$info['minvalue']		= isset($_POST['minvalue']) ? intval($_POST['minvalue']) : '' ;
			$info['maxvalue']		= isset($_POST['maxvalue']) ? intval($_POST['maxvalue']) : '' ;
			$info['uniqueness']		= isset($_POST['uniqueness']) ? intval($_POST['uniqueness']) : 2 ;
			$info['issearch']		= isset($_POST['issearch']) ? intval($_POST['issearch']) : 2 ;
			$info['enabled']		= 1;
			$info['created']		= time();

			//验证
			if(empty($info['attrname']))
				$this->dialog('','error','字段名不能为空');
			if(in_array($info['fieldtype'],array(4,5,6)) && empty($info['defaultvalue']))
				$this->dialog('','error','可选项默认值不能为空');
			if(in_array($info['fieldtype'],array(4,5,6)) && !empty($info['defaultvalue']))
			{
				$arr = array();
				//$_val = preg_split("/\r\n/",$info['defaultvalue']);
				$_val = explode(',',$info['defaultvalue']);
				foreach ($_val as $key => $val )
				{
					if(!empty($val)) $arr[] = trim($val);
				}
				unset($_val);
				$info['defaultvalue'] = implode(',',$arr);
			}

			//入库跳转
			$res = $this -> getGoodsAttrModel() -> create($info);
			admin_log('添加商品属性字段', '添加属性字段'.$info['attrname']);
			if($res)
				$this->dialog('/modules/goodsfield/index/typeid/'.$info['typeid'],'success');
			else
				$this->dialog('','error','添加失败');
		}

		//添加页面
		$this -> assign('typeid',$_GET['typeid']);
		$this -> display('modules/goods/modules_goodsfield_add.html');
	}

	/**
	 * 字段修改
	 *
	 */
	public function editAction ()
	{
		if(isset($_POST['attrid']))
		{
			//接值
			$info['attrname']		= isset ( $_POST['attrname'] ) ? trim($_POST['attrname']) : '';
			$info['fieldtype']		= isset($_POST['fieldtype']) ? intval($_POST['fieldtype']) : 1 ;
			$info['fieldtips']		= isset($_POST['fieldtips']) ? trim($_POST['fieldtips']) : '' ;
			$info['defaultvalue']	= isset($_POST['defaultvalue']) ? trim($_POST['defaultvalue']) : '' ;
			$info['minvalue']		= isset($_POST['minvalue']) ? intval($_POST['minvalue']) : '' ;
			$info['maxvalue']		= isset($_POST['maxvalue']) ? intval($_POST['maxvalue']) : '' ;
			$info['uniqueness']		= isset($_POST['uniqueness']) ? intval($_POST['uniqueness']) : 2 ;
			$info['issearch']		= isset($_POST['issearch']) ? intval($_POST['issearch']) : 2 ;
			$info['created']		= time();

			//验证
			if(empty($info['attrname']))
				$this->dialog('','error','字段名不能为空');
			if(in_array($info['fieldtype'],array(4,5,6)) && empty($info['defaultvalue']))
				$this->dialog('','error','可选项默认值不能为空');
			if(in_array($info['fieldtype'],array(4,5,6)) && !empty($info['defaultvalue']))
			{
				$arr = array();
				//$_val = preg_split("/\r\n/",$info['defaultvalue']);
				$_val = explode(',',$info['defaultvalue']);
				foreach ($_val as $key => $val )
				{
					if(!empty($val)) $arr[] = trim($val);
				}
				unset($_val);
				$info['defaultvalue'] = implode(',',$arr);
			}
			//跟新跳转
			$res = $this -> getGoodsAttrModel() -> update(array('attrid'=>$_POST['attrid']),$info);
			admin_log('修改商品属性字段', '修改属性字段'.$info['attrname']);
			if($res)
				$this->dialog('/modules/goodsfield/index/typeid/'.$_POST['typeid'],'success');
			else
				$this->dialog('','error','跟新失败');
		}
		$attrid = isset ( $_GET['attrid'] ) ? intval($_GET['attrid']) : 0 ;
		if(!$attrid) $this->dialog('','error','参数错误');
		$info = $this -> getGoodsAttrModel() -> find(array('attrid'=>$attrid));
		$this -> assign('info',$info);
		$this -> display('modules/goods/modules_goodsfield_edit.html');
	}

	/**
     * 跟新排序
	 */
	function updateOrderAction ()
	{
		$info = isset($_POST['fileds']) ? $_POST['fileds'] : array() ;
		foreach ($info as $key => $val )
		{
			$this -> getGoodsAttrModel() -> update(array('attrid'=>$key),array('ordernum'=>$val));
		}
		$this->dialog('/modules/goodsfield/index/typeid/'.$_POST['typeid'],'success');
	}

	/**
	 * 字段删除
	 *
	 */
	public function delAction ()
	{
		$typeid = isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : (isset($_POST['typeid']) ? $_POST['typeid'] : 0);
		$attrid = isset ( $_GET['attrid'] ) ? intval($_GET['attrid']) : (isset ( $_POST['attrid'] ) ? implode(',',$_POST['attrid']) : '0');
		if(!$attrid) $this->dialog('','error','参数错误');

		$where = array('in'=>array('attrid'=>$attrid));
		$attrname = $this -> getAttrnameById($attrid);
		$this -> getGoodsAttrModel() -> delete($where);//删除字段表
		$this -> getGoodsAttrValueModel() -> delete(array('in'=>array('attrid'=>$attrid)));//删除对应的字段值表
		admin_log('删除商品属性字段', '删除了属性字段:'.implode(',',$attrname));
		$this->dialog('/modules/goodsfield/index/typeid/'.$typeid);
	}

	/**
	 * 字段开关
	 *
	 */
	public function opencloseAction ()
	{
		$enabled = (isset ( $_GET['enabled'] ) ? $_GET['enabled'] : 1 ) ==1 ? 2 : 1;
		$typeid = isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : (isset($_POST['typeid']) ? $_POST['typeid'] : 0);
		$attrid = isset ( $_GET['attrid'] ) ? intval($_GET['attrid']) : (isset ( $_POST['attrid'] ) ? implode(',',$_POST['attrid']) : '0');
		if(!$attrid) $this->dialog('','error','参数错误');
		$this -> getGoodsAttrModel() -> update(array('in'=>array('attrid'=>$attrid)),array('enabled'=>$enabled));//开启关闭字段

		$status = ($enabled == 1) ? '开启' : '关闭';
		admin_log('设置商品属性字段', '设置了属性字段:'.implode(',',$this -> getAttrnameById($attrid)).'为'.$status.'状态');
		redirect($this->baseurl.'/modules/goodsfield/index/typeid/'.$typeid);
	}

	/**
	 * 获取字段名称
	 * @param
	 * @return
	 */
	function getAttrnameById ($ids)
	{
		$tmp = array();
		$fields = $this -> getGoodsAttrModel() -> findAll(array('in'=>array('attrid'=>$ids)));
		foreach ($fields as $key => $val )
		{
			$tmp[] = $val['attrname'];
		}
		return $tmp;
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsModel ()
	{
		return D('GoodsModel');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsTypeModel ()
	{
		return D('GoodsTypeModel');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsAttrModel ()
	{
		return D('GoodsAttrModel');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsAttrValueModel ()
	{
		return D('GoodsAttrValueModel');
	}
}