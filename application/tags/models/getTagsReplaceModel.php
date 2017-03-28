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
	 *   内链关键词遍历排除重复
	 */
	public function push_links () 
	{
		$linkSql =  M ("seo_link") -> field('link_name') -> where(array('link_stat' => 2)) ->select();	//开启
		return $linkSql;
	}
	
	
	/**
	 *   内链关键词样式替换
	 */
	public function formateTages ($content,$cid) 
	{
		$this->getSeolinkSql = M ("seo_link");
		$linkSql = $this -> getSeolinkSql -> where(array('link_stat' => 2)) ->select();		//开启
		$column_id = array();
		$keywords1  = array();
		$keywords2  = array();		
		
		$getLinknames = $this -> push_links();
		
		$i=0;
		foreach ($linkSql as $key => $sql) 
		{	
			if($i <= 10) 				
			{
				foreach($getLinknames as $linkname)
				{	
					$ascname  = $sql['link_name'];
					$descname = $linkname['link_name'];
					
					/* 循环比较 */
					if($descname != $ascname){
						
						$preg_links = preg_match_all("/$descname/i", $ascname, $matches);
						if($preg_links == 1)
						{
							$sql['link_name'] = $descname;
						}
					}	 
				}
				//拼接样式
				$style  = 'style="';
				$style .= !empty($sql['link_color']) ? 'color:'.$sql['link_color'].';' : '';
				$style .= $sql['link_bold'] == 1 ? 'font-weight:bold' : '';
				$style .= '"';
			 	//$words_count = mb_strlen($sql["link_name"],"utf-8");			
				//判断关键词是否在该栏目
				$arr_column = explode(',',$sql["link_column"]);
				if (in_array($cid , $arr_column)){
					
	    			$keywords1[] = '/'.$sql["link_name"].'/';
					empty($sql["link_address"]) ? $sql['link_address'] = '#' : $sql['link_address'];
					$keywords2[] = '<a href='.$sql["link_address"].' '.$style.'>'.$sql["link_name"].'</a>';
				}
			}else{

				 break;
			}
		} 
		
	    $content = preg_replace($keywords1,$keywords2,$content,2);
	    return $content;
	}
	
	
	
	/**
	 *   前台Tag标签处理
	 */
	public function GetTagname ($id,$sign) 
	{	
		$ids = '';
		$str = '';
		$query = M('TagInfo') -> field('tag_id') -> where(array('info_id' => $id,'sign_id' => $sign)) -> select();
		foreach($query as $tag_ids)
	    {	
			$ids .= $tag_ids['tag_id'].',';
	    }
	    $ids = rtrim($ids,',');
	    $result_tagname = M('SeoTag') -> field('id,sign_id,tag_name') -> where(array('in' => array('id' => $ids))) -> select();
	    foreach($result_tagname as $row)
	    {	
	    	$id = $row['id'];
	    	$tag_name = $row['tag_name'];
	    	$sign_id = $row['sign_id'];
			$str .= "<a href = '".HOST_NAME ."tags/Tags/countclick/id/$id/sign/$sign_id/tagname/$tag_name' style='color:blue;'>" .$row['tag_name'].'</a>,';
	    }
	    $names = trim($str,',');
	    return $names;							//返回Tag标签名
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
