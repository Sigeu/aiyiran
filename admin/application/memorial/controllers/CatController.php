<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 纪念馆分类
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>一梦一尘  2016-10-09 上午11:03:16 创建此文件
 *
 * @author     一梦一尘  2016-10-09 上午11:03:16

 * @filename   LinkController.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: LinkController.php 357 2016-10-09 04:09:37Z wangrui $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class CatController extends AdminController {

	public $catObj; //模型对象
	public $audit;
	public function init()
	{

		$this->catObj = M("memorial_cat");
        $this->audit = D('Audit');

	}
	/**
	 * 友情链接列表
	 */
	public function indexAction(){

		$where = array();
		$keyword = $this->getParams('keyword');
		$type = $this->getParams('link_type');

		//查询条件
		$search['keyword'] = $keyword;
		$search['link_type'] = $type;

		if(isset($keyword) && !empty($keyword)){

			$where['like'] = array('name'=>$keyword);//广告位名称
		}

		if(isset($type) && !empty($type)){

			$where['link_type'] = $type;      //栏目类别
		}

		//分页
		$count = $this->catObj->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "sort asc,id asc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = $this->catObj->select($options);

		// 获取所有分类
		$catList = $this->audit->getCatList2();
		
		$this->assign('catList',$catList);
		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('memorial/cat/catlist');
	}

	/**
	 * 添加纪念馆分类
	 * @return null
	 */
	public function addAction()
	{
		//提交表单
		if(!empty($_POST))
		{
			$arr = array
			(
				'name'     => $this->getParams('name'),
				'sort'=> $this->getParams('sort'),
				'pid' => $this->getParams('pid')
			);
			$rs = $this->catObj->create($arr);
			if ($rs)
			{
				 admin_log('添加纪念馆分类','添加'.$arr['name']."纪念馆分类");
				$this->dialog("/memorial/cat/index",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/cat/index",'error','操作失败');
			}
		}else{
		   $catList= $this->audit->getCategoryTree();
		   $this->assign('catList', $catList);
		   $this->display('memorial/cat/add');
		}	
	}

	/**
	 * 添加友情链接
	 * @return null
	 */
	public function updateAction()
	{
		//提交修改
		$edit_id = isset($_POST['id']) ? intval($_POST['id']) : 0 ;
		if($edit_id)
		{
			$keyword = $this->getParams('keyword');
			$page = $this->getParams('page');
			$type = $this->getParams('type');
            $arr = array
			(
				'name'     => $this->getParams('name'),
				'sort'=> $this->getParams('sort')
			);

			//入库跳转
			$rs = $this->catObj->update(array('id'=>$edit_id), $arr);
			if ($rs)
			{
				admin_log('编辑纪念馆分类','编辑'.$arr['name']."纪念馆分类");
				$this->dialog("/memorial/cat/index/page/{$page}",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/cat/index/page/{$page}",'error','操作失败');
			}
		}

		//修改页面
		$id = $this->getParams('id');
		$arr['page'] = $this->getParams('page');
		$infor = $this->catObj->where(array('id'=>$id))->getOne();
		$this->assign('arr',$arr);
		$this->assign('infor',$infor);
		$this->display('memorial/cat/update');

	}

	//删除友情链接
	public function deleteAction() {

		$id = $this->getIds('id');
		$name = urldecode($this->getParams('name'));
		$arr['page'] = $this->getParams('page');

		$where = array(
				'in'=>array('id'=>$id),
		);

		$rs = $this->catObj->delete($where);

		if ($rs) {

			admin_log('纪念馆分类','删除'.$name."纪念馆分类");
			$this->dialog("/memorial/cat/index/page/{$arr['page']}",'success','操作成功');
			exit;
		} else {

			$this->dialog("/memorial/cat/index/page/{$arr['page']}",'error','操作失败');
			exit;
		}
	}

	//友情链接排序
	public function linkSortAction() {

		$sortid = $this->getIds('sort');
		$sortid = explode(',',$sortid);
		$ids = $this->getIds('id');
		$ids = explode(',',$ids);
		$options = array_combine($ids, $sortid);

		//更新排序
		$rs = $this->catObj->updateAll('id','sort',$options,$ids);

		if ($rs) {

			$this->dialog("/memorial/cat/index",'success','更新成功');
		} else {

			$this->dialog("/memorial/cat/index",'error','更新失败');
		}
	}
}