<?php

/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 
 * 文件修改记录：
 * <br>冯阳  2013-8-12   下午15:27   创建此文件 
 * 
 * @author     冯阳<fengyang@mainone.cn>   2013-8-12   下午15:27

 * @filename   TagController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: TagController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */

class TagController extends AdminController {
	

	private $getTags;
	public function init()
	{
		$this->getTags = D('Tags');	
		parent::init();
	}

	/*Tag标签列表*/
	public function indexAction()
	{	
		$tag['keyword'] = isset($_GET['keyword']) ? $_GET['keyword'] : '' ;
		$tag['orderby'] = isset($_GET['orderby']) ? $_GET['orderby'] : '' ;
		
		$tag['pai'] = isset($_GET['pai']) ? $_GET['pai'] : '' ;

		$pageInfo = array();
		$where    = array();
		$options  = array();

		$types = isset($_GET['types'])?$_GET['types']:1;

		if($types == 1){
			
			$where['or'] = " sign_id=1 OR sign_id>2 ";
		}else{
			
			$where['sign_id'] = $types;
		}
		
		if (isset($tag['keyword'])&&!empty($tag['keyword']))
		{				
			$where['like'] = array('tag_name'=>$tag['keyword']);			
		}
		
		$pageInfo = array(
			'keyword' => $tag['keyword'],
		);

		/*点击次数和时间的排序判断*/
		if( $tag['orderby'] == 1 && $tag['pai'] == 1 )
		{
			$options['order'] = "tag_times desc";
			
		}else if( $tag['orderby'] == 2  && $tag['pai'] == 1 )
		{
			$options['order'] = "tag_click desc";
			
		}else if( $tag['orderby'] == 1  && $tag['pai'] == 2 ){
		
			$options['order'] = "tag_times asc";
			
		}else if( $tag['orderby'] == 2  && $tag['pai'] == 2 ){
		
			$options['order'] = "tag_click asc";
			
		}else{
		
			$options['order'] = "tag_times desc";
		}
			

		$count = $this->getTags->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;

		$result = $this -> getTags -> select($options);	//执行搜索后关键词查询+分页操作
		
		foreach($result as $key=>$num)
		{	
			$id = $num['id'];
			$count_num =  D('Tags')-> countTags($id);  
			foreach($count_num as $numbers)
			{
				$result[$key]['tag_count'] = $numbers['counts'];  
			}
		}
	
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;
		$this->assign('pageInfo',$pageInfo);
		$this->assign('pagestr',$pagestr);
		$this->assign('list',$result);
		$this->assign('tag',$tag);
		$this->assign('types',$types);
		$this->display('extensions/tag/seo_tag_index.html');
	}


	/*搜索关键词删除*/
    public function deleteAction()
	{		
		
		$types = $_GET['types'];
		
		//执行单个删除操作
	    if(!empty($_GET['did'])){		
			
			M('SeoTag') -> delete(array('id' => $_GET['did'],'sign_id' => $types));
			M('TagInfo') -> delete(array('tag_id' => $_GET['did'],'sign_id' => $types));
			$this->dialog('/extensions/tag/index','success','删除成功！');
		}
		
		//执行批量删除操作
		$ids = $this->getIds('ids');
		if(!empty($ids) && !empty($types)){
			
			M('SeoTag') -> delete(array( 'in' => array('id' => $ids)),array('sign_id' => $types));
			M('TagInfo') -> delete(array( 'in' => array('id' => $ids)),array('sign_id' => $types));
			$this->dialog('/extensions/tag/index','success','批量删除成功！');
		}
			
	}

}