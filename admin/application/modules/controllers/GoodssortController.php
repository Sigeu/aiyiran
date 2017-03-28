<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 模块管理 商品展示 商品分类
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-14 10:47 创建此文件
 * <br>雷少进  2013-01-14 10:47 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodssortController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodssortController extends AdminController
{
	/**
	 * 商品分类列表
	 *
	 */
	public function indexAction ()
	{
		$sort_tree = $this -> getGoodsSortModel()->getGoodsSortTree();
		if($sort_tree)
		{
			foreach ($sort_tree as $key => $val )
				$sort_tree[$key]['goods_numbers'] = $this -> getGoodsModel() -> findCount(array('sortid'=>$val['sortid']));

			$sort_tree = $this -> getGoodsSortModel()->countChildNodeByArray($sort_tree);
		}

		$this -> assign('sort_tree',$sort_tree);
		$this -> display('modules/goods/modules_goodssort_index.html');
	}

	/**
	 * 分类添加
	 *
	 */
	public function addAction ()
	{
		//提交表单
		if(!empty($_POST))
		{
			//表单数据
			$info['pid'] = isset($_POST['pid']) ? intval($_POST['pid']) : 0 ;
			$info['sortname'] = isset($_POST['sortname']) ? trim($_POST['sortname']) : '' ;
			$info['created'] = time();

			//提交入库
			$res = $this -> getGoodsSortModel() -> create($info);
			admin_log('添加商品分类', '添加了商品分类'.$info['sortname']);
			if($res)
				$this -> dialog('/modules/goodssort/index');
			else
				$this -> dialog('/modules/goodssort/index','error','添加失败');
		}

		//添加页面
		$sort_tree = $this -> getGoodsSortModel() -> getGoodsSortTree();
		$this -> assign('sort_tree',$sort_tree);
		$this -> assign('param',array('sortid'=>isset($_GET['sortid']) ? $_GET['sortid'] : ''));
		$this -> display('modules/goods/modules_goodssort_add.html');
	}

	/**
	 * 分类修改
	 *
	 */
	public function editAction ()
	{
		//提交表单修改
		if(isset($_POST['sortid']) && $_POST['sortid'])
		{
			//表单数据
			$info['pid'] = isset($_POST['pid']) ? intval($_POST['pid']) : 0 ;
			$info['sortname'] = isset($_POST['sortname']) ? trim($_POST['sortname']) : '' ;

			//验证
			$child_id = $this -> getGoodsSortModel() -> getChildidByPid($_POST['sortid']);
			array_push($child_id,$_POST['sortid']);
			if(in_array($info['pid'],$child_id))
				$this -> dialog('','error','不能选择自己或自己的子级作为父级');

			//更新
			$res = $this -> getGoodsSortModel() -> update(array('sortid'=>$_POST['sortid']),$info);
			admin_log('修改商品分类', '修改了商品分类'.$info['sortname']);
			if($res)
				$this -> dialog('/modules/goodssort/index');
			else
				$this -> dialog('','error','修改失败');
		}

		//修改页面
		$sortid = isset ( $_GET['sortid'] ) ? intval($_GET['sortid']) : 0 ;
		if(!$sortid) $this -> dialog('','error','参数有误');

		$info = $this -> getGoodsSortModel() -> find(array('sortid'=>$sortid));
		$sort_tree = $this -> getGoodsSortModel() -> getGoodsSortTree();
		$this -> assign('info',$info);
		$this -> assign('sort_tree',$sort_tree);
		$this -> display('modules/goods/modules_goodssort_edit.html');
	}

	/**
	 * 商品分类删除
	 *
	 */
	public function delAction ()
	{
		//要删除的分类ID
		$sortid = isset ( $_GET['sortid'] ) ? intval($_GET['sortid']) : 0 ;
		if(!$sortid) $this -> dialog('/modules/goodssort/index','error','参数错误');

		$model = $this -> getGoodsSortModel();

		//检查默认分类不能删除
		if($model->find(array('sortid'=>$sortid,'isdefault'=>1)))
			$this -> dialog('/modules/goodssort/index','error','默认分类不能删除');

		//查出子ID
		$childs = $model->getChildidByPid($sortid);
		array_push($childs,$sortid);
		$childs = implode(',',$childs);

		//移动要删除分类下的商品到默认分类
		$model -> moveGoodsToDefault($childs);

		//删除分类
		$where = array('in'=>array('sortid'=>$childs,'isdefault'=>2));
		$sort = $model->findAll($where);
		$tmp = array();
		foreach ($sort as $key => $val )
		{
			$tmp[] = $val['sortname'];
		}
		$model -> delete($where);
		admin_log('删除商品分类', '删除了商品分类'.implode('、',$tmp));
		$this -> dialog('/modules/goodssort/index','success','删除成功！');
	}

	/**
	 * 分类跟新排序
	 *
	 */
	public function updateOrderAction ()
	{
		$sort = isset ( $_POST['ordernum'] ) ? $_POST['ordernum'] : array();
		foreach ($sort as $key => $val )
		{
			$this -> getGoodsSortModel() -> update(array('sortid'=>$key),array('ordernum'=>current($val)));
		}
		$this -> dialog('/modules/goodssort/index');
	}

	/**
	 * 商品分类表模型
	 *
	 */
	function getGoodsSortModel ()
	{
		return D('GoodsSortModel');
	}

	/**
	 * 商品分类表模型
	 *
	 */
	function getGoodsModel ()
	{
		return D('GoodsModel');
	}
}