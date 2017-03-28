<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 手机站controller
 * 
 * 文件修改记录：
 * <br>王少辰  2013-10-12 上午11:12:08 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-10-12 上午11:12:08
 * @filename   SearchModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class MobilesearchModel extends Model
{
	/**
	 * @param int $params 参数
	 * @return string 返回值
	 */
	public function  search($params=array())
	{
		$modelid = 0;
		$cid_str = '';
		$searchlist = array();
		$searchparam = array();
		
		$searchparam['keywords'] = $params['keywords'] ? array_filter(explode(' ',$params['keywords'])) : array();   // array()
		
		if(isset($params['cid'])&&$params['cid'])
		{
			$cid_arr = getCategoryIds($params['cid'],true);
			$cid_str = implode(",", $cid_arr);
			$modelid =  D('Category','category')->getModelidByCatgoryid($params['cid']); //获取搜索栏目的模型ID
        }

		if(isset($params['mid'])&&$params['mid'])
		{
			$modelid =  $params['mid'];
            $searchparam['mid'] = $modelid;
		}
		
		if (isset($cid_str) && !empty($cid_str))
		{
			$searchparam['cid'] = $cid_str;               // string
		}

		if (isset($params['limit']) && $params['limit'])
		{
			$searchparam['limit'] = $params['limit'];     // int
		}
                
                if (isset($params['limit_from']) && $params['limit_from'])
		{
			$searchparam['limit_from'] = $params['limit_from'];     // int
		}
		
		//查询商品表
		if(isset($modelid)&&$modelid==2)
		{
			$searchlist = $this->getGoodsByKeywords($searchparam);//搜索商品
		}
		//查询文章表
		else
		{
			$searchlist = $this->searchArticleByKeywords($searchparam);
		}
		
		return $searchlist;
	}
    
    /**
	 * 搜索查询商品
	 * @param 关键字
	 * @return 商品信息
	 */
	function getGoodsByKeywords ($_param)
	{
		$keywords = isset($_param['keywords']) ? $_param['keywords'] : '';
		$cid      = isset($_param['cid'])      ? $_param['cid']      : 0;
		$limit    = isset($_param['limit'])    ? $_param['limit']    : 0;
        $limit_from    = isset($_param['limit_from']) ? $_param['limit_from'] : 0;
		
		if(empty($keywords))
			return array();
		$sql = 'select goodsid, goodsname,subname,categoryid,sortid,brandid,typeid,is_sell,userid,hits,isbest,isnew,ishot,isspecial,keywords,brief,marketprice,shopprice,publishtime,unit,created from '.$this->tablePrefix.'goods where is_sell=1';
		if ($keywords[0] != '|') $sql .= ' AND (goodsname like \'%'.implode('%\' or goodsname like \'%',$keywords).'%\')';
		if($cid) $sql .= ' AND (categoryid in ('.$cid.'))';
		if($limit) $sql .= " LIMIT $limit_from, $limit";
        
        /*
        *若当前操作为搜索，调用搜索记录接口，写入搜索记录
        */
        if(empty($cid)) {
            $sql_count = 'select count(*) as total from '.$this->tablePrefix.'goods where is_sell=1';
            if ($keywords[0] != '|') {
                $sql_count .= ' AND (goodsname like \'%'.implode('%\' or goodsname like \'%',$keywords).'%\')';
            }
            $result = $this -> query($sql_count);
            $total = $result[0]['total'];
            if (is_array($keywords)) {
                $keywords = implode(',', $keywords);
            }
            D('Search','search')->seosearchPublic($_param['mid'], '', $total, $keywords);
        }
		return $this -> query($sql);
	}
    
    /**
	 * 搜索文章
	 * @param 关键字
	 * @return 文章信息
	 */
	function searchArticleByKeywords ($_param)
	{
		$keywords = isset($_param['keywords']) ? $_param['keywords'] : '';
		$cid      = isset($_param['cid'])      ? $_param['cid']      : 0;
		$limit    = isset($_param['limit'])    ? $_param['limit']    : 0;
        $limit_from    = isset($_param['limit_from']) ? $_param['limit_from']    : 0;
		if(empty($keywords))
		{
			return array();
		}
		$sql = 'select id,categoryid,title,subtitle,description,publishtime, thumb, hits,created  from '.$this->tablePrefix.'maintable where ';
		if($keywords[0] != '|') {
            $sql .= '(title like \'%'.implode('%\' or title like \'%',$keywords).'%\')';
            if ($cid) {
                $sql .= ' AND ';
            }
        }
		if($cid) $sql .= '(categoryid in ('.$cid.'))';
		if($limit) $sql .= " LIMIT $limit_from,".$limit;
        
        /*
        *若当前操作为搜索，调用搜索记录接口，写入搜索记录
        */
        if(empty($cid)) {
            $sql_count = 'select count(*) as total from '.$this->tablePrefix.'maintable where ';
            if ($keywords[0] != '|') {
                $sql_count .= '(title like \'%'.implode('%\' or title like \'%',$keywords).'%\')';
            }
            $result = $this -> query($sql_count);
            $total = $result[0]['total'];
            if (is_array($keywords)) {
                $keywords = implode(',', $keywords);
            }
            D('Search','search')->seosearchPublic($_param['mid'], '', $total, $keywords);
        }
        
		return $this -> query($sql);
	} 
}