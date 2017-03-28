<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 商品
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-15 11:28 创建此文件
 * <br>雷少进  2013-01-15 11:28 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class GoodsModel extends Model
{
	public $pk = "goodsid";//主键
	public $tableName = "goods";//表名

	function getSql ($search=array())
	{
		$sql = 'SELECT
		g.`goodsid` ,
		g.`goodsname` ,
        g.`sortnum` ,
		g.`isbest` ,
		g.`isnew` ,
		g.`ishot` ,
		g.`isspecial` ,
		g.`hits` ,
		g.`modification` ,
		c.`catname` ,
		a.`username`,
		gs.`sortname`
		FROM `'.$this -> tablePrefix.'goods` AS g
		LEFT JOIN `'.$this -> tablePrefix.'category` AS c ON g.`categoryid` = c.`id`
		LEFT JOIN `'.$this -> tablePrefix.'admin` AS a ON g.`userid` = a.`id`
		LEFT JOIN `'.$this -> tablePrefix.'goods_sort` AS gs ON g.`sortid` = gs.`sortid`
		WHERE 1 ';
		if($search['keywords'])	$sql    .= ' AND g.`goodsname` LIKE \'%'.$search['keywords'].'%\' ';
		if($search['categroy']) $sql    .= ' AND g.`categoryid` = '.$search['categroy'].' ';
		if($search['sortid']) $sql      .= ' AND g.`sortid` = '.$search['sortid'].' ';
		if($search['by']) $sql          .= ' ORDER BY  g.`'.$search['by'].'` '.$search['orderby'].' ';
        return $sql;
	}
    
    /**
	 * 批量更新排序
	 * @param 排序信息 键是主键ID  值是排序值
	 * @return null
	 */
	function batchUpdateSortnum ($sortnum)
	{
		if(!empty($sortnum))
		{
			foreach ($sortnum as $key => $val )
			{
				$this -> update(array('goodsid'=>$key),array('sortnum'=>$val));
			}
		}
	}

	/**
	 * 获取商品总数
	 * @param $where 可选参数 sql条件
	 * return int 商品总数
	 */
	function getGoodsNumber ($where=array())
	{
		return $this -> findCount($where);
	}

	/**
	 * 获取商品总数
	 * @param $condition 可选参数 sql条件
	 * return int 商品总数
	 */
	function getCount($condition=array())
	{
		return $this -> findCount($condition);
	}

    //获取栏目名称
    public function getCatgoryName($id) {
        $result = $this->query("SELECT filepath FROM ". $this->tablePrefix ."category WHERE id = ". $id);
        foreach ($result AS $val){
            return $val['filepath'];
        }
    }


}