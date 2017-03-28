<?php

/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * TagsController.php
 *
 * Tag标签记录点击量
 * 
 * 
 * @author     冯阳<fengyang@mail.b2b.cn>   2013/8/29
 * @filename   TagsController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class TagsController extends HomeController 
{
	
	/**
	 * tag标签记录点击量
	 */
	public function countclickAction()
	{	
		$this -> TagsModel() -> updateSql($id = $_GET['id']);
		$this -> redirect(HOST_NAME . 'tags/Tags/searchclick/id/'.$id.'/sign/'.$_GET['sign'].'/tagname/'.$_GET['tagname']);
	}


	/**
	 * tag标签点击搜索
	 */
	public function searchclickAction()
	{
		$tagname = $_GET['tagname'];  
		$tagname = urldecode($tagname);
		$pid = $_GET['pid'];
		$cid = $_GET['cid'];
		$seo = get_metainfo_category($cid);
		$id_list = $this -> TagsModel() -> gettagId($_GET['id']); 
		if($_GET['sign'] == 1){
		
			include $this->display("tags_articlelist.html");
			
		}else if($_GET['sign'] == 2){
		
			include $this->display("tags_goodslist.html");
		}
	}


	/**
	 * 实例化Model
	 */
	public function TagsModel()
	{
		return  D('TagsModel');
	}
              
}