<?php
/**
 *--------------------------------------------------------------------------------------
 * 爱站CMS内容管理系统
 *
 * 其它内容管理系统
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>  2013-07-27 10:34
 * @filename   OthercontentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.izhancms.com)
 * @license    http://www.izhancms.com/license/
 * @version    izhancms 1.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class OthercontentController extends AdminController
{
	/**
	 * 其它内容的内容列表
	 */
	function indexAction ()
	{
		//搜索条件
		$search['keywords']   = isset ( $_POST['keywords'] )   ? trim($_POST['keywords'])     : '';
		$search['orderfield'] = isset ( $_POST['orderfield'] ) ? trim($_POST['orderfield'])   : 'updatetime';
		$search['ordertype']  = isset ( $_POST['ordertype'] )  ? trim($_POST['ordertype'])    : 'DESC';
		$search['categoryid'] = isset ( $_POST['categoryid'] ) ? intval($_POST['categoryid']) : '0';
		$this->assign('search',$search);

		//分页列表
		$other_model = $this -> getOthercontentModel();
		$plist = $other_model->getOtherContentPlist($search);
		$info_list = $plist['list'];
		$info_list = $other_model->formateModelName($info_list);
		$info_list = $other_model->formateCategoryName($info_list);

		$this->assign('list',$info_list);

		//所有栏目信息
		$category = $other_model -> getAllCategoryInfo();
		$this->assign('category',$category);

		//其它模型栏目信息
		$_category = $other_model->getCategoryByOtherModel();
		$this->assign('_category',$_category);

		//渲染页面
		$this ->display('content/othercontent/content_othercontent_index');
	}

	/**
	 * 修改内容
	 * @param
	 * @return
	 */
	function updateAction ()
	{
		$content_modle = $this ->getContentModel();

		//参数判断
		$id  = isset ( $_GET['id'] )  ? $_GET['id']  : 0 ; //信息ID
		$cid = isset ( $_GET['cid'] ) ? $_GET['cid'] : 0 ; //栏目ID
		$mid = isset ( $_GET['mid'] ) ? $_GET['mid'] : 0 ; //模型ID
		if(!$id || !$cid || !$mid)
		{
			$this->dialog('/content/othercontent/index','info',"参数有误");
		}

		//权限判断查询
		$per = $content_modle->getPer(3);//3，修改权限
		if(in_array($cid,$per)||$_SESSION['roleid'] == 1)
		{
			$content = $content_modle->getContent(array('id'=>$id),$mid);
			$content['sorttype'] = ($content['sorttype']-$content['publishtime']) / 3600 /24;
			$ContentForm = new ContentForm($mid);
			$form = $ContentForm->get($content);
			$formvalidator = $ContentForm->formValidator;
			$this->assign('form',$form);
			$this->assign('id',$id);
			$this->assign('formvalidator',$formvalidator);
			$this->display('content/othercontent/content_othercontent_update');
		}
		else
		{
			$this->dialog('/content/othercontent/index','info',"对不起，您没有此操作权限");
		}
	}

	/**
	 * 其它内容模型内容服务类
	 * @return OthercontentModel Object
	 */
	function getOthercontentModel ()
	{
		return D('OthercontentModel');
	}

	/**
	 * 其它内容模型内容服务类
	 * @return OthercontentModel Object
	 */
	function getContentModel ()
	{
		return D('ContentModel');
	}
}