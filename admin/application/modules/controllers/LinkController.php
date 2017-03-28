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
 * <br>申静  2013-4-27 上午11:03:16 创建此文件
 *
 * @author     申静<shenjing@mainone.cn>  2013-4-27 上午11:03:16

 * @filename   LinkController.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: LinkController.php 357 2013-10-22 04:09:37Z wangrui $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class LinkController extends AdminController {

	public $linkObj; //模型对象
	public function init()
	{

		$this->linkObj = M("Link");
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
		$count = $this->linkObj->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "sort asc,id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = $this->linkObj->select($options);

		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('modules/link/linklist');
	}

	/**
	 * 添加友情链接
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
				'link_type'=> $this->getParams('link_type'),
				'com_url'  => $this->getParams('com_url'),
				'member'   => $this->getParams('member'),
				'introduce'=> $this->getParams('introduce')
			);

			if(($arr['link_type'] == 1) && isset($_POST['accessory']))
			{
				$logo = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'frind_link','time_name'=>true));
				$logo = current($logo);
				$arr['logo'] = $logo['path'];
				$arr['alt'] = $logo['alt'];
			}
			$rs = $this->linkObj->create($arr);
			if ($rs)
			{
				admin_log('添加友情链接','添加'.$arr['name']."友情链接");
				$this->dialog("/modules/link/index",'success','操作成功');
			}
			else
			{
				$this->dialog("/modules/link/index",'error','操作失败');
			}
		}
		$allowtype = get_mo_config('mo_picturetype');
		//添加页面
		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  explode("|",$allowtype),
			'local'       =>  true,
			'folder'      =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this->display('modules/link/add');
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

			//基本信息
			$info = array
			(
				'name'     => $this->getParams('name'),
				'com_url'  => $this->getParams('com_url'),
				'link_type'=> $this->getParams('link_type'),
				'member'   => $this->getParams('member'),
				'introduce'=> $this->getParams('introduce'),
				'alt'=> $this->getParams('logo_alt'),
			);

			//图片处理
			if(($info['link_type'] == 1) && isset($_POST['accessory']))
			{
				$param = array('file'=>$_POST['accessory'],'folder'=>'frind_link','time_name'=>true);
				if(!empty($_POST['old_logo']))
					$param['new_name'] = '/static/uploadfile/frind_link/'.$_POST['old_logo'];

				$logo = moUploadAccessory($param);
				$logo = current($logo);
				
				$info['alt'] = $logo['alt'];
				
				$logo = explode('/',$logo['path']);
				$f1 = array_pop($logo);
				$f2 = array_pop($logo);
				$info['logo'] =$f2.'/'.$f1;
				
			}
			else if($info['link_type'] == 2)
			{
				$info['logo'] = '';
				$save_path = getFileSavePath('frind_link');
				@is_file($save_path['base'].DS.$_POST['old_logo']) && @unlink($save_path['base'].DS.$_POST['old_logo']);
			}

			//入库跳转
			$rs = $this->linkObj->update(array('id'=>$edit_id), $info);
			if ($rs)
			{
				admin_log('编辑友情链接','编辑'.$info['name']."友情链接");
				$this->dialog("/modules/link/index/keyword/{$keyword}/page/{$page}/link_type/{$type}",'success','操作成功');
			}
			else
			{
				$this->dialog("/modules/link/index/keyword/{$keyword}/page/{$page}/link_type/{$type}",'error','操作失败');
			}
		}

		//修改页面
		$id = $this->getParams('id');
		$arr['keyword'] = $this->getParams('keyword');
		$arr['type'] = $this->getParams('link_type');
		$arr['page'] = $this->getParams('page');
		$infor = $this->linkObj->where(array('id'=>$id))->getOne();
		$allowtype = get_mo_config('mo_picturetype');
		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  explode("|",$allowtype),
			'local'       =>  true,
			'folder'      =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this->assign('arr',$arr);
		$this->assign('infor',$infor);
		$this->display('modules/link/update');

	}

	//删除友情链接
	public function deleteAction() {

		$id = $this->getIds('id');
		$name = urldecode($this->getParams('name'));
		$arr['keyword'] = $this->getParams('keyword');
		$arr['type'] = $this->getParams('link_type');
		$arr['page'] = $this->getParams('page');

		$where = array(
				'in'=>array('id'=>$id),
		);

		$rs = $this->linkObj->delete($where);

		if ($rs) {

			admin_log('删除友情链接','删除'.$name."友情链接");
			$this->dialog("/modules/link/index/keyword/{$arr['keyword']}/page/{$arr['page']}/link_type/{$arr['type']}",'success','操作成功');
			exit;
		} else {

			$this->dialog("/modules/link/index/keyword/{$arr['keyword']}/page/{$arr['page']}/link_type/{$arr['type']}",'error','操作失败');
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
		$rs = $this->linkObj->updateAll('id','sort',$options,$ids);

		if ($rs) {

			$this->dialog("/modules/link/index",'success','更新成功');
		} else {

			$this->dialog("/modules/link/index",'error','更新失败');
		}
	}
}