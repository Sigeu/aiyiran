<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 负责专题模块的制作
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013/9/3
 * @filename   SpecialModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialModel extends Model
{

	/**
	 * 获取10条热点专题
	 */

	public function getTenHot()
	{
        $sql = "SELECT id, name FROM " .$this->tablePrefix ."special ORDER BY click_num DESC LIMIT 10";
		$data = $this->query($sql);
		return $data;
	}

    public function getArticleIdsByTitle($keyword)
    {
        $sql = "SELECT id FROM ". $this->tablePrefix ."maintable WHERE title like '%{$keyword}%'";
        $result = $this->query($sql);
        $arr = array();
		foreach ($result AS $key => $val){
			$arr[] = $val['id'];
		}
        return implode(",", $arr);
    }


	/**
	 * 搜索查询商品
	 * @param 关键字
	 * @return 商品信息
	 */
	function searchSpecialByKeywords ($_param)
	{

		$keywords = isset($_param['keywords']) ? $_param['keywords'] : '';
		$cid      = isset($_param['cid'])      ? $_param['cid']      : 0;
		$pageSize  = isset($_param['pageSize']) ? $_param['pageSize']    : 20;
		$startCount  = isset($_param['startCount']) ? $_param['startCount'] : 0;

		if(empty($keywords))
			return array();
		$sql = 'select id,name,guide,created,publishopt from '.$this->tablePrefix.'special where ';
		$sql .= 'name like "%'.$keywords.'%"'; 
		if($cid) $sql .= ' AND (categoryid in ('.$cid.'))';
		$sql .= ' LIMIT '. $startCount.','.$pageSize;
		return $this -> query($sql);
	}


}
