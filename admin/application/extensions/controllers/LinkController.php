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

 * @filename   LinkController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: LinkController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */

class LinkController extends AdminController {
	

    private $getseoLink;
	public function init()
	{
		$this->getseoLink = M('SeoLink');		
		parent::init();
	}

	/*内链关键词列表*/
	public function indexAction()
	{
		//搜索条件
		$search['keyword'] = isset($_GET['keyword']) ? $_GET['keyword'] : '' ;
		$search['orderby'] = isset($_GET['orderby']) ? $_GET['orderby'] : 'desc' ;
		
		$pageInfo = array();
		$where    = array();
		$options  = array();
		
		$keyword = isset($_GET['keyword'])?$_GET['keyword']:'';
	
		if (isset($keyword)&&!empty($keyword))
		{				
			$where['or'] = " link_name like '%{$keyword}%'";			
		}
		
		$pageInfo = array(
			
			'keyword' => $keyword,
			//'link_stat' => 	$link_stat
		);
		
		$count = $this->getseoLink->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "link_times ".$search['keyword'];
		$options['order'] = "link_times ".$search['orderby'];

		$list = $this->getseoLink->select($options);	//执行搜索后关键词查询+分页操作
	
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;
		$this->assign('pageInfo',$pageInfo);
		$this->assign('pagestr',$pagestr);
		$this->assign('list',$list);
		$this->assign('search',$search);
		$this->display('extensions/link/seo_link_index.html');
	}


	/*内链关键词添加*/
    public function addAction()
	{	
		if(isset($_POST['link_column']) && !empty($_POST['link_column'])){
			foreach($_POST['link_column'] as $res){  
				$arr[] = $res; 
			}
			$strIds = implode(',',$arr);
		}else{
			$strIds = '';
		}
		if(!empty($_POST))
		{   
			$getValue = $this -> getseoLink -> field('link_name') -> where(array('link_name' => $_POST['link_name'])) -> getOne();
			if(empty($getValue))
			{
				$link_stat = isset($_POST['link_stat']) ? $_POST['link_stat'] : 0;
				$link_bold = isset($_POST['link_bold']) ? $_POST['link_bold'] : 0;
				$param = array(
					'link_name' => $_POST['link_name'],		
					'link_column' => $strIds,	
					'link_color' => $_POST['link_color'],
					'link_bold' => $link_bold,
					'link_address' => $_POST['link_address'], 
					'link_times' => time(),	
					'link_stat' => $link_stat,				
				);
				$ins = $this->getseoLink->create($param);		  
				$this->dialog('/extensions/link/index','success','添加成功！');			
			}else{
				$this->dialog('/extensions/link/index','success','关键词已添加！');	
			}
		}else{

			$res = new Model();
			$addIt=array();
			$res->recurseQueryTree(0,$addIt,"category",0,"id,pid,catname");
			$res = buildChildParent($addIt);
			$_res = array();
			$this->addSeoCatgoryTree($res,$_res,-1);
			$this->assign('catgory',implode('',$_res));		
			$this->display('extensions/link/seo_link_add.html');
		}
		
	}
	
	/*内链关键词修改*/
    public function editAction()
	{

		$id = $this->getParams('id');		 		//修改的id  显示模板
		$info = $this->getseoLink->find(array('id'=>$id));

		/*栏目列表展示*/
		$res = new Model();
		$addIt=array();
		$res->recurseQueryTree(0,$addIt,"category",0,"id,pid,catname");
		$res = buildChildParent($addIt);
		$_res = array();
		$this->editSeoCatgoryTree($res,$_res,$info['link_column'],-1);
		$this->assign('catgory',implode('',$_res));	
		
		
		/*修改操作*/
        if(!empty($id)){
		    $this -> assign('id',$id);
		    $this -> assign('name',$info['link_name']);
			$this -> assign('address',$info['link_address']);
			$this -> assign('stat',$info['link_stat']);
			$this -> assign('column',$info['link_column']);
			$this -> assign('bold',$info['link_bold']);
			$this -> assign('color',$info['link_color']);
			$this -> display('extensions/link/seo_link_edit.html');	
			die;
        }
		if(isset($_POST['link_column']) && !empty($_POST['link_column'])){
			foreach($_POST['link_column'] as $res){  
				$arr[] = $res; 
			}
			$strIds = implode(',',$arr);
		}
		if($_POST){
			
			$link_stat = $this->getParams('link_stat');	
			if(!$link_stat)
			{
				$link_stat = 1;
			}//var_dump($link_stat);
			$param = array(
				'link_name' => $this->getParams('link_name'),
				'link_address' => $this->getParams('link_address'),
				'link_stat' => $link_stat,
				'link_bold' => $this->getParams('link_bold'),
				'link_color' => $this->getParams('link_color'),
				'link_column' => $strIds
			);	
			$ids = $this->getParams('ids');
			$updAll = $this->getseoLink->update(array('id'=>$ids),$param);
			$this->dialog('/extensions/link/index','success','修改成功！');	       		
		}

		if($this->getParams('stat_id')){
			$stat_id = $this->getParams('stat_id');
			if($_GET['stat'] == 2){
				$updAll = $this->getseoLink->update(array('id'=>$stat_id),$param=array("link_stat"=>2));
			}else{
				$updAll = $this->getseoLink->update(array('id'=>$stat_id),$param=array("link_stat"=>1));
			}
			$this->dialog('/extensions/link/index','success','修改状态成功！');	
		}
	}


	/*内链关键词删除*/
    public function deleteAction()
	{
		//执行单个删除操作
	    if(!empty($_GET['did'])){		
			
			$condition['in'] = array('id'=>$_GET['did']);
			$del = $this->getseoLink->delete($condition);
			if($del)
			{
				$this->dialog('/extensions/link/index','success','删除成功！');
			}
		}
		
		//执行批量删除操作
		$ids = $this->getIds('ids');
		if(!empty($ids)){
			
			$delAll = $this->getseoLink->delete(array('in'=>array('id'=>$ids)));
			if($delAll)
			{	
				$this->dialog('/extensions/link/index','success','批量删除成功！');
			}		
		}
	}


	/*添加栏目递归循环*/
	public function addSeoCatgoryTree($res,&$tmp,$i=-1,$k=0)
	{
		if(is_array($res) && !empty($res))
		{
			$i++;
			if($k == 0){
				$tmp[] = '<ul class="treeX" id="search-list">';
				
			}else{
				$tmp[] = '<ul class="treeX" style="display:none">';
				
			}
			foreach($res as $key=>$val)
			{ 
				$tmp[] = '<li>';
				$id    = $val['id'];
				$catname = $val['catname'];
				
				if(isset($val['child']) && !empty($val['child']))
				{
					$node='tree_node_OX';
					$tmp[] = '<input type="hidden" value="'.$k.'"  name="sign" id="sign" />';
				}
				else 
				{
					$node='tree_node_CX';
				}
				if($val['level'] == 1)
				{	
					$tmp[] = '<span class="'.$node.'"></span><span><input type="checkbox"  checked=checked name="link_column[]" id="link_column" value='.$id.' >&nbsp;<label>'.$catname.'</label></span>';
				}
				else
				{	
					$tmp[] = str_repeat('<span class="tree_spaceX"></span>',($val['level']-2)).'<span class="tree_branchX"></span><span class="'.$node.'"></span><span><input type="checkbox" checked=checked name="link_column[]" value='.$id.' >&nbsp;<label>'.$catname.'</label></span>';
				}
				if(isset($val['child']) && !empty($val['child']))
				{	
					$this->addSeoCatgoryTree($val['child'],$tmp,$i,1);
				}
				$tmp[] = '</li>';
			}
			$tmp[] = '</ul>';
		}
	}


	/*修改栏目递归循环*/
	public function editSeoCatgoryTree($res,&$tmp,$ids = array(),$i=-1,$k=0)
	{
		is_string($ids) && ($ids = explode(',',$ids));
		
		if(is_array($res) && !empty($res))
		{
			$i++;
			if($k == 0){
				$tmp[] = '<ul class="treeX" id="search-list">';
			}else{
				$tmp[] = '<ul class="treeX" style="display:none">';
			}
			foreach($res as $val)
			{
				$tmp[] = '<li>';
				$id = $val['id'];
				$pid = $val['pid'];
				$catname = $val['catname'];
			
				if(isset($val['child']) && !empty($val['child']))
				{
					$node='tree_node_OX';
				}
				else 
				{
					$node='tree_node_CX';
				}
				if(empty($ids))
				{
					$_checked = '';
					
				}else{
					
					$_checked = in_array($val['id'],$ids) ? 'checked="checked"' : '';
				}
				if($val['level'] == 1)
				{	
					$tmp[] = '<span class="'.$node.'"></span><span><input  '.$_checked.' type="checkbox"  name="link_column[]" value='.$id.'>&nbsp;<label>'.$catname.'</label></span>';
				}
				else
				{
					$tmp[] = str_repeat('<span class="tree_spaceX"></span>',($val['level']-2)).'<span class="tree_branchX"></span><span class="'.$node.'"></span><span><input type="checkbox" '.$_checked.' name="link_column[]"  value='.$id.'>&nbsp;<label>'.$catname.'</label></span>';
				}
				if(isset($val['child']) && !empty($val['child']))
				{	
					$this->editSeoCatgoryTree($val['child'],$tmp,$ids,$i,1);
				}
				$tmp[] = '</li>';
			}
			$tmp[] = '</ul>';
		}
	}

}