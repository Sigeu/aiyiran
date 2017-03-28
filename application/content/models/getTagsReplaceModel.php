<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * getTagsReplaceModel.php
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 
 * 
 * @author     冯阳<fengyang@mail.b2b.cn>   2013/8/16 17:05
 * @filename   CategoryModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class getTagsReplaceModel extends Model
{	
	
	/**
	 *   内链关键词样式替换
	 */
	public function formateTages ($content,$cid) 
	{
		$this->getSeolinkSql = M ("seo_link");
		$linkSql = $this -> getSeolinkSql -> where(array('link_stat' => 1)) ->select();		//   1 =》 开启  2  =》 关闭  【开启才替换】
		$column_id = array();
		$keywords1  = array();
		$keywords2  = array();		
		foreach ($linkSql as $key => $sql) 
		{	
			//拼接样式
			$style  = 'style="';
			$style .= !empty($sql['link_color']) ? 'color:'.$sql['link_color'].';' : '';
			$style .= $sql['link_bold'] == 1 ? 'font-weight:bold' : '';
			$style .= '"';
		 	$words_count = mb_strlen($sql["link_name"],"utf-8");			
			//合并栏目ID（数组）
			$column_id = array_merge($column_id,explode(',',$sql["link_column"]));		
			$keywords1[] = '/'.$sql["link_name"].'/';
			$keywords2[] = '<a href='.$sql["link_address"].' '.$style.'>'.$sql["link_name"].'</a>';
		}
		$content = preg_replace($keywords1,$keywords2,$content,2);
		return $content;
	}

	
	/**
	 *   Tag标签获取id
	 */
	function GetTagname ($id) 
	{
		$this->getSeotagSql  = M ("seo_tag");
		$query = $this -> getSeotagSql -> field('key_id,id') -> select();
	    foreach($query as $query_val)
	    {	
	    	$cun = strstr($query_val['key_id'],',');
	    	if($cun != FALSE){
		    	$explode_res = explode(',',$query_val['key_id']);
                $is_no = '';
		    	foreach($explode_res as $res)
		    	{
		    		$arr[$query_val['id']] = $res;	   
		    		$is_no .= array_search($id , $arr); 
		    	}
	    	}else{
	    		$arr[$query_val['id']] = $query_val['key_id'];
	    		$is_no = array_search($id , $arr); 
	    	}
	    }
	    $result = $this -> getSeotagSql -> where(array('id' => $is_no)) -> field('tag_name,id') -> select();
		return $result;							//返回tag表中信息id,tag名称
	}


	/**
	 *	查询Tag表返回id
	 */
	public function selectTag($id)
	{
		$condition['key_id'] = $id;
		$result = M('SeoTag')->find($condition,'','id');
		return $result;
	}
	


}

?>