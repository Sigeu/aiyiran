<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * TagsModel.php
 * 
 * 
 * @author     冯阳<fengyang@mail.b2b.cn>   2013/8/16 17:05
 * @filename   TagsModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class TagsModel extends Model
{	

	/**
	 *	修改点击量+1
	 */
	public function updateSql($id) 
	{
		$result = "update ". $this->tablePrefix ."seo_tag set tag_click = tag_click+1 where id = $id";
		mysql_query($result);
	}

	

	/**
	 *	获取Tag表里文章ID
	 */
	public function gettagId($id)
	{
		$sql = M('TagInfo') -> where(array('tag_id' => $id)) -> field('info_id')-> select();
		$keyids = '';
		foreach($sql as $infos)
		{
			$keyids .= $infos['info_id'].',';
		}
		$sql = trim($keyids,',');
		return $sql;
	}
	
}