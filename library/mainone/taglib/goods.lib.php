<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  商品
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */


class goods
{
	function lib_goods($datas)
	{
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$category = isset($datas['category']) ? $datas['category'] : '';
		$limit = isset($datas['row']) ? $datas['row'] : '100000000';		
		$limit = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
		$dbconfig = get_config('database','default');
		$sql = 'SELECT
		g.*,
		c.`id` as cid ,
		c.`catname` ,
	    c.`filepath` ,
	    c.`columnoption` ,
	    a.`username`,
		s.`sortname`,
		s.`pid`,
		b.`brandname`,
		b.`url` as brandurl,
		b.`logo` as brandlogo,
		t.`typename`
		FROM `'.$dbconfig['prefix'].'goods` AS g
		LEFT JOIN `'.$dbconfig['prefix'].'category` AS c ON g.`categoryid` = c.`id`
		LEFT JOIN `'.$dbconfig['prefix'].'admin` AS a ON g.`userid` = a.`id`
		LEFT JOIN `'.$dbconfig['prefix'].'goods_sort` AS s ON s.`sortid` = g.`sortid`
		LEFT JOIN `'.$dbconfig['prefix'].'goods_brand` AS b ON b.`brandid` = g.`brandid`
		LEFT JOIN `'.$dbconfig['prefix'].'goods_type` AS t ON t.`typeid` = g.`typeid`
		WHERE 1 ';
		if(isset($datas['id'])&&$datas['id']) $sql.= ' AND g.`goodsid` in('.$datas['id'].')';
		if($category) $sql .= " AND g.sortid = {$category}";
		if(isset($datas['cid'])&&$datas['cid']) 
		{
			if(isset($datas['type'])&&$datas['type']=='son')
			{
			    $ids = getCategoryIds($datas['cid']);
				if(!empty($ids))
	   	  		{
	   	  			$str = implode($ids,',');
				}
			    $sql    .= ' AND g.`categoryid` in( '.$str .') ';
			}
			elseif(isset($datas['type'])&&$datas['type']=='all')
			{
			    $ids = getCategoryIds($datas['cid'],true);
				if(!empty($ids))
	   	  		{
	   	  			$str = implode($ids,',');
				}
			    $sql    .= ' AND g.`categoryid` in( '.$str .') ';
			}
			
			else
		    {
			    $sql    .= ' AND g.`categoryid` in( '.$datas['cid'].') ';
			}
		}	
		if(isset($datas['order'])&&$datas['order']) $sql     .= ' ORDER BY '.$datas['order'].'';
		$sql     .= ' limit '.$from.', '.$limit.'';
		//商品信息
		$goodsinfo = M('goods')->query($sql);
		//商品id
		foreach($goodsinfo as $key=>$value)
		{
			$ids[] = $value['goodsid'];
		}
		//查询商品相册信息
		if(isset($ids))
		{
			$goodsalbum = M('goods_album')->where(array('in'=>array('goodsid'=>implode($ids,','))))->select();
		}
		//查询商品属性信息
		if(isset($ids))
		{
			$idstr = implode($ids,',');
			$sql = 'SELECT
					a.`attrid`,
				    a.`attrname`,
					av.`value`,
					av.`goodsid`
					FROM `'.$dbconfig['prefix'].'goods_attr_value` AS av
					LEFT JOIN `'.$dbconfig['prefix'].'goods_attr` AS a ON av.`attrid` = a.`attrid`
					Where av.`goodsid` in('.$idstr.')
					order by a.`ordernum`';
			$goodattr = M('goods_attr')->query($sql);;
		}
		//重组商品信息
		foreach($goodsinfo as $key=>$value)
		{
            $goodsinfo[$key]['photo'] = array();
            $goodsinfo[$key]['image'] = '';
			foreach($goodsalbum as $k => $v)
			{
				if($value['goodsid'] == $v['goodsid'])
				{
					$goodsinfo[$key]['image'][] = $v['photo'];
                    $goodsinfo[$key]['photo'][] = $v;
				}	
			}
			foreach($goodattr as $sonk => $sonv)
			{
				if($value['goodsid'] == $sonv['goodsid'])
				{
					$goodsinfo[$key]['attr'][$sonv['attrname']] = $sonv['value'];
				}
			}
			//防止没有相册或者属性的商品前台标签调用错误
			if(!isset($goodsinfo[$key]['attr']))
			{
				$goodsinfo[$key]['attr'] = array();
			}
		    if(!isset($goodsinfo[$key]['image']))
			{
				$goodsinfo[$key]['image'] = array();
			}
			$goodsinfo[$key]['url'] = getGoodsUrl($value['goodsid'], $value['filepath'], $value['publishopt'],'goods/Goods/info' ,'goods_$id.html',$value['created']);
			$goodsinfo[$key]['curl'] = getGoodsListUrl($value['cid'], $value['filepath'], $value['columnoption'],'goods/Goods/list' ,'goodslist_$id_1.html');
		}
        return $goodsinfo;
	}
}
?>