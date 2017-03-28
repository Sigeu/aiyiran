<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 模块管理 商品展示 商品类型
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-14 18:40 创建此文件
 * <br>雷少进  2013-01-14 18:40 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodstypeController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodstypeController extends AdminController
{
	/**
	 * 商品类型列表
	 *
	 */
	public function indexAction ()
	{
		//类型分页列表
		$plist = $this -> getGoodsTypeModel() -> getPageList(array('where'=>'status=1 ORDER BY `created` DESC'));
		foreach ($plist['list'] as $key => $val )
			$plist['list'][$key]['attr_number'] = $this -> getGoodsModel() -> findCount('typeid='.$val['typeid']);

		$this -> assign('plist',$plist);
		$this -> display('modules/goods/modules_goodstype_index.html');
	}

	/**
	 * 类型添加
	 *
	 */
	public function addAction ()
	{
		//提交表单
		if(!empty($_POST))
		{
			//表单数据
			$info['typename'] = isset($_POST['typename']) ? trim($_POST['typename']) : '' ;
			if(empty($info['typename']))
				$this -> dialog('','error','属性名不能为空');
			$info['status'] = 1;
			$info['attr_type'] = '';
			$info['created'] = time();
			admin_log('添加商品属性', '添加商品属性'.$info['typename']);
			//提交入库
			$res = $this -> getGoodsTypeModel() -> create($info);
			if($res)
				$this -> dialog('/modules/goodstype/index');
			else
				$this -> dialog('','error','添加失败');
		}
		//添加页面
		$this -> display('modules/goods/modules_goodstype_add.html');
	}

	/**
	 * 类型修改
	 *
	 */
	public function editAction ()
	{
		//提交表单修改
		if(isset($_POST['typeid']) && $_POST['typeid'])
		{
			//表单数据
			$info['typename'] = isset($_POST['typename']) ? trim($_POST['typename']) : '' ;
			if(empty($info['typename']))
				$this -> dialog('','error','属性名不能为空');
			admin_log('修改商品属性', '修改商品属性'.$info['typename']);
			//更新
			$res = $this -> getGoodsTypeModel() -> update(array('typeid'=>$_POST['typeid']),$info);;
			if($res)
				$this -> dialog('/modules/goodstype/index');
			else
				$this -> dialog('','error','修改失败');
		}

		//修改页面
		$typeid = isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : 0 ;
		if(!$typeid) $this -> dialog('','error','参数有误');
		$info = $this -> getGoodsTypeModel() -> find(array('typeid'=>$typeid));
		$this -> assign('info',$info);
		$this -> display('modules/goods/modules_goodstype_edit.html');
	}

	/**
	 * 类型删除
	 *
	 */
	public function delAction ()
	{
		//接参
		$typeid = isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : (isset($_POST['typeid']) ? $_POST['typeid'] : '') ;
		is_array($typeid) && $typeid=implode(',',$typeid);
		if(!$typeid) $this -> dialog('','error','参数错误');

		//判断该属性下是否有商品
		//if($this -> getGoodsModel() -> findCount(array('in'=>array('typeid'=>$typeid))))
		//	$this -> dialog('','error','删除失败！该属性下有商品存在，不能删除！');

		//删除
		$type_list = $this -> getGoodsTypeModel()->findAll(array('in'=>array('typeid'=>$typeid)));
		$tmp = array();
		foreach ($type_list as $key => $val )
		{
			$tmp[] = $val['typename'];
		}
		$this -> getGoodsTypeModel() -> clearGoodsType($typeid);
		admin_log('删除商品属性' , '删除商品属性'.implode('、' ,$tmp));
		$this -> dialog('/modules/goodstype/index');
	}

	function ajaxcheckAction ()
	{
		echo $this -> getGoodsModel()->findCount(array('in'=>array('typeid'=>$_POST['ids'])));
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
}