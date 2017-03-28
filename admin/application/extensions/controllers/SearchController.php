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
 * <br>冯阳  2013-8-12   下午15:27   创建此文件 
 * 
 * @author     冯阳<fengyang@mainone.cn>   2013-8-12   下午15:27
 * @filename   searchController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: searchController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @search       http://www.izhancms.com 
 * @search       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */

class SearchController extends AdminController {
	
	private $getseoSearch;
	public function init()
	{
		$this->getseoSearch = M('SeoSearch');		
		parent::init();
	}

	/*搜索关键词列表*/
	public function indexAction()
	{	
		
		$search['keyword'] = isset($_GET['keyword']) ? $_GET['keyword'] : '' ;
		$search['orderby'] = isset($_GET['orderby']) ? $_GET['orderby'] : '' ;
		$search['pai'] = isset($_GET['pai']) ? $_GET['pai'] : '' ;

		$pageInfo = array();
		$where    = array();
		$options  = array();

		$types = isset($_GET['types'])?$_GET['types']:0;
		
		$stat = get_mo_config('mo_sphinx_stat');
		
		$where['type_id'] = $types;			// 搜索类型     0 => 全文，1 => 文章，2 => 商品，3 => 专题
		
//		var_dump($where);
		if (isset($search['keyword'])&&!empty($search['keyword']))
		{				
			$where['like'] = array('search_names'=>$search['keyword']);			
		}
		
		$pageInfo = array(
			'keyword' => $search['keyword'],
		);
		
		/*搜索次数和时间的排序判断*/
		if( $search['orderby'] == 1 && $search['pai'] == 1 )
		{
			$options['order'] = "search_times desc";
			
		}else if( $search['orderby'] == 2  && $search['pai'] == 1 )
		{
			$options['order'] = "search_count desc";
			
		}else if( $search['orderby'] == 1  && $search['pai'] == 2 ){
		
			$options['order'] = "search_times asc";
			
		}else if( $search['orderby'] == 2  && $search['pai'] == 2 ){
		
			$options['order'] = "search_count asc";
			
		}else{
		
			$options['order'] = "search_times desc";
		}

		$count = $this->getseoSearch->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$list = $this->getseoSearch->select($options);	//执行搜索后关键词查询+分页操作
//		var_dump($list);
		
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;
		$this->assign('pageInfo',$pageInfo);
		$this->assign('pagestr',$pagestr);
		$this->assign('list',$list);
		$this->assign('search',$search);
		$this->assign('types',$types);
		$this->display('extensions/search/seo_search_index.html');
	}


	/*搜索关键词添加*/
    public function addAction()
	{
		 $this->display('extensions/search/seo_search_add.html');
	}
	

	/*搜索关键词删除*/
    public function deleteAction()
	{		
		//执行单个删除操作
	    if(!empty($_GET['did'])){		
			
			$condition['in'] = array('id'=>$_GET['did']);
			$del = $this->getseoSearch->delete($condition);
			if($del)
			{
				$this->dialog('/extensions/search/index','success','删除成功！');
			}
			
		}
		//执行批量删除操作
		$ids = $this->getIds('ids');	
		if(!empty($ids)){
			
			$delAll = $this->getseoSearch->delete(array('in'=>array('id'=>$ids)));
			if($delAll)
			{	
				$this->dialog('/extensions/search/index','success','批量删除成功！');
			}		
		}
	}
	
	
	/*搜索关键词更新*/
    public function updateAction()
	{		
		$id = $_GET['id'];
		$types = $_GET['types'];
		$search_result = M('SeoSearch') -> field('search_result') -> where(array('id' => $id,'type_id' => $types)) -> find(); 
		$this->dialog('/extensions/search/index','success','更新成功！');
	}

}