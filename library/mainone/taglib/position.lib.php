<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  推荐位
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
class position
{
	function lib_position($datas)
	{
		$order = isset($datas['order']) ? $datas['order'] : 'sortby';
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$limit = isset($datas['row']) ? $datas['row'] : '1000000';
		$limit = $from.','.$limit;
		$condtion = array(1=>1);
		$condtion = array_filter($condtion);
		if(isset($datas['id'])&&$datas['id'])
		{
			$condtion['in'] = array('pos_id'=>$datas['id']);
            $position_obj = M('position')->field('cat_id')->where($condtion)->getOne();
            $condtion['cat_id'] = $position_obj['cat_id'];
		}
		$position = M('position_info')->where($condtion)->limit($limit)->order($order)->select();
		foreach($position as $key=>$value)
		{
			$cidinfo = cid2info($value['cat_id']);
			if($value['model_id']==2)
			{
				include_once 'goods.lib.php';
				$good_obj = new goods();
				$contentInfo = $good_obj->lib_goods(array('id'=>$value['ag_id']));
				$position[$key]['title'] = $contentInfo[0]['goodsname'];
				$position[$key]['info'] = $contentInfo[0];

			}
			else
			{
				include_once 'content.lib.php';
				$article_obj = new content();
				$contentInfo = $article_obj->lib_content(array('id'=>$value['ag_id']));
				$position[$key]['title'] = $contentInfo['title'];
				$position[$key]['info'] = $contentInfo;				
			}
		}
		return $position;
		
	}
}
?>
