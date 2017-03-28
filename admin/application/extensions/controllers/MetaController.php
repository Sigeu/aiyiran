<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://cms.b2b.cn)
 *
 * MetaController.php
 * 
 * 页面Meta设置
 * 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-8-13 上午11:01:14
 * @filename   MetaController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version     iZhanCMS 2.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */ 
 
class MetaController extends AdminController
{
	
	
	/**
	 * Meta设置--首页
	 */
	public function indexAction()
	{
		$seoinfo = array();
		$param   = array();
		$objWebConfig = M('WebConfig');
		if ($_POST)
		{
			$param['mo_title']       = $_POST['mo_title'];
			$param['mo_keywords']    = $_POST['mo_keywords'];
			$param['mo_description'] = $_POST['mo_description'];
			
			foreach ($param as $key=>$val)
			{
				$objWebConfig->update(array('par_name'=>$key), array('par_value'=>$val));
			}
			
		}
		$result = $objWebConfig->where(array('in'=>array('par_name'=>"'mo_title','mo_keywords','mo_description'")))->select();
		foreach ($result as $row)
		{
			$seoinfo[$row['par_name']] = $row['par_value'];
		}
		
		$this->assign('seoInfo',$seoinfo);		
		$this->display('extensions/meta/meta_index');
	}
	
	/**
	 * Meta设置--栏目页
	 */
	public function categoryAction()
	{
		$arr = array();
		$objCategory = D('Category','content');
		$cat_tree = $objCategory -> getCategoryTree();
		$cat_tree = $objCategory -> countChildNodeByArray($cat_tree);
		
		$this -> assign('cat_tree',$cat_tree);
		$this->display('extensions/meta/meta_category');
	}
	
	/**
	 * Meta设置--栏目页meta设置
	 */
	public function setcategoryAction()
	{
		$param = array();
		$objCategory = M('Category');

		$cid = $this->getParams('cid');
		$task = $this->getParams('task');
		
		$categoryinfo = $objCategory->find(array('id'=>$cid),'','id,catname,seo_title,seo_keywords,seo_description');
		
		if ('dosubmit' == $task)
		{
			$param['seo_title']       = $this->getParams('seo_title');
			$param['seo_keywords']    = $this->getParams('seo_keywords');
			$param['seo_description'] = $this->getParams('seo_description');
			
			$objCategory -> update(array('id'=>$cid), $param);
    		$this->dialog("/extensions/meta/category");
		}
		
		$this -> assign('categoryInfo',$categoryinfo);
		$this->display('extensions/meta/meta_category_set');
	}
	
	/**
	 * Meta设置--专题页
	 */
	public function specialAction()
	{
		$where = array();
		$types = array();
		$special  = array();
		$pageInfo = array();
		$searchInfo = array();
		
		$objSpecial     = M('Special');
		$objSpecialType = M('SpecialType');
		
		$task    = $this->getParams('task');
		$typeid  = $this->getParams('typeid');
		$keyword = $this->getParams('keyword');
		$searchInfo['typeid'] = $typeid;
		$searchInfo['keyword'] = $keyword;
		
		
		if (isset($typeid) && !empty($typeid))
		{
    		$where['type_id'] = $typeid;
		}
		if (isset($keyword) && !empty($keyword))
		{
    		$where['like'] = array('name'=>$keyword);
		}
		
		//所有专题分类
		$result = $objSpecialType->select();
		foreach ($result as $row)
		{
			$types[$row['id']] = $row['type_name'];
		}
		
		//所有专题

		$count = $objSpecial->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "id DESC";
		
		$special = $objSpecial->select($options);
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		
		$pageInfo['pageStr'] = $pagestr;
		$pageInfo['page'] = $currpage;
		
		$this->assign('specialType',$types);
		$this->assign('specialList',$special);
		$this->assign('pageInfo',$pageInfo);
		$this->assign('searchInfo',$searchInfo);
		$this->display('extensions/meta/meta_special');
	}
	
	/**
	 * Meta设置--栏目页meta设置
	 */
	public function setspecialAction()
	{
		$param = array();
		$objSpecial     = M('Special');
		$objSpecialType = M('SpecialType');

		$sid = $this->getParams('sid');
		$task = $this->getParams('task');
		
		$specialinfo = $objSpecial->find(array('id'=>$sid),'','id,type_id,name,seo_title,seo_keywords,seo_description');
		$typeinfo = $objSpecialType->find(array('id'=>$specialinfo['type_id']));
		$specialinfo['typename'] = $typeinfo['type_name'];
		if ('dosubmit' == $task)
		{
			$param['seo_title']       = $this->getParams('seo_title');
			$param['seo_keywords']    = $this->getParams('seo_keywords');
			$param['seo_description'] = $this->getParams('seo_description');

			$objSpecial -> update(array('id'=>$sid), $param);
    		$this->dialog("/extensions/meta/special");
		}
		
		$this -> assign('specialInfo',$specialinfo);
		$this->display('extensions/meta/meta_special_set');
	}
	
	
	/**
	 * Meta设置--默认设置
	 */
	public function defaultsetAction()
	{
		$objMeta = M('SeoMeta');
		$type = $this->getParams('type');
		$metainfo = $objMeta->find(array('type'=>$type));
		switch ($type)
		{
			case 1: 
				$template = "extensions/meta/meta_category_default";
				break;
			case 2: 
				$template = "extensions/meta/meta_special_default";
				break;
			case 3: 
				$template = "extensions/meta/meta_special_list_default";
				break;
			case 4: 
				$template = "extensions/meta/meta_content_default";
				break;
			case 5: 
				$template = "extensions/meta/meta_goods_default";
				break;
		}
		$this->assign('type',$type);
		$this->assign('metaInfo',$metainfo);
		$this->display($template);
	}
	
	/**
	 * Meta设置--默认设置
	 * 
	 * 默认设置类型 1：栏目页 2：专题页 3：专题信息列表页 4：内容页 5：商品页
	 */
	public function setmetaAction()
	{
		$param = array();
		$objMeta = M('SeoMeta');
		$type = $this->getParams('type');
		if ($_POST)
		{
			$param = array(
					'type'  => $type,                                   //默认设置类型 1：栏目页 2：专题页 3：专题信息列表页 4：内容页 5：商品页
					'title' => $this->getParams('title'),               //SEO 标题
					'keywords'    => $this->getParams('keywords'),      //SEO 关键词
					'description' => $this->getParams('description'),   //SEO 描述
					);
			$result = $objMeta->find(array('type'=>$type));
			if ($result)
			{
				$objMeta->update(array('id'=>$result['id']), $param);
			}else 
			{
			    $newid = $objMeta->create($param);
			}
		}
		
		$this->dialog("/extensions/meta/defaultset/type/".$type);
		exit;
	}
	
}