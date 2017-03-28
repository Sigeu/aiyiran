<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CategoryModel.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
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
class GoodsModel extends Model
{
	public $tableName = 'goods';

	/**获取商品信息
	**/
	public function goodsInfo($id)
	{
	 $sql = 'SELECT
		g.*,
		c.`id` as cid ,
		c.`catname` ,
		s.`sortname`,
		s.`pid`,
		b.`brandname`,
		b.`url` as brandurl,
		b.`logo` as brandlogo,
		t.`typename`
		FROM `'.$this->tablePrefix.'goods` AS g
		LEFT JOIN `'.$this->tablePrefix.'category` AS c ON g.`categoryid` = c.`id`
		LEFT JOIN `'.$this->tablePrefix.'goods_sort` AS s ON s.`sortid` = g.`sortid`
		LEFT JOIN `'.$this->tablePrefix.'goods_brand` AS b ON b.`brandid` = g.`brandid`
		LEFT JOIN `'.$this->tablePrefix.'goods_type` AS t ON t.`typeid` = g.`typeid`
		WHERE  g.`goodsid` =' . $id;
		$goodsinfo = $this->query($sql);
	    $sql2 = 'SELECT
			a.`attrid`,
			a.`attrname`,
			av.`value`,
			av.`goodsid`
			FROM `'.$this->tablePrefix.'goods_attr_value` AS av
			LEFT JOIN `'.$this->tablePrefix.'goods_attr` AS a ON av.`attrid` = a.`attrid`
			Where av.`goodsid` in('.$id.')
			order by a.`ordernum`';

		$goodattr = $this->query($sql2);
		foreach($goodsinfo as $key=>$value)
		{

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
		}
		return $goodsinfo[0];

	}

	/*获取商品相册信息*/

	public function goodsAblum($id)
	{
		$goodsalbum = M('goods_album')->where(array('goodsid'=>$id))->select();
			return  $goodsalbum;
	}

	public function updateHits($id)
	{
		$sql = 'UPDATE '.$this->tablePrefix.'goods set `hits`=`hits`+1 where goodsid='.$id;
		$this->query($sql);
	}

	public function getLinkgoodsid($id)
	{
		$sql = 'select * from '.$this->tablePrefix.'goods_link_goods where goodsid='.$id.' or (relgoodsid = '.$id.' and `relation` = 2)';
		$result = $this->query($sql);
		$tem = array();
		foreach($result as $key=>$value)
		{
			if($value['goodsid']!=$id)
			{
				$tem[] = $value['goodsid'];
			}
			if($value['relgoodsid']!=$id)
			{
				$tem[] = $value['relgoodsid'];
			}

		}
		return array_unique($tem);
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
		$pageSize  = isset($_param['pageSize']) ? $_param['pageSize']    : 20;
		$startCount  = isset($_param['startCount']) ? $_param['startCount'] : 0;
		
		if(empty($keywords))
			return array();
		$sql = 'select goodsid,goodsname,subname,categoryid,sortid,brandid,typeid,is_sell,userid,hits,isbest,isnew,ishot,isspecial,keywords,brief,marketprice,shopprice,publishtime,unit,created,publishopt from '.$this->tablePrefix.'goods where is_sell=1 AND ';
		$sql .= 'goodsname like "%'.$keywords.'%"'; 
		if($cid) $sql .= ' AND (categoryid in ('.$cid.'))';
		$sql .= ' LIMIT '. $startCount.','.$pageSize;
		return $this -> query($sql);
	}
	
	/**
	 * @param int $goodsid 商品ID
	 * @return string 返回模板名称
	 */
	 
	public function  getTemplage($goodsid)
	{
		$result = $this->where(array('goodsid'=>$goodsid))->field('goodstpl')->getOne();
		return $result['goodstpl'];
	}
}