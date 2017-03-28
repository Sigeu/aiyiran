<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  热搜词
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


class hotkey
{
	function lib_hotkey($datas)
	{
		$order = isset($datas['order']) ? $datas['order'] : 'nums desc';
		$modelid = isset($datas['modelid']) ? $datas['modelid'] : '1'; //默认是文章
        $dbconfig = get_config('database','default');
		$keywords = M('search')->field('keywords')->order($order)->limit('0,5')->select();//为了效率只取前5个关键词
		$temkey=array();
		$temstr = '';
		
		if($modelid!=2)
		{
			foreach($keywords as $key=>$value)
			{
			   $temkey[] = ' m.`title` LIKE \'%'.$value['keywords'].'%\' ';
			}
			$temstr = implode('or',$temkey);
			$sql = 'SELECT
				m.*,
				c.`catname`,
				c.`id` as cid,
				c.`filepath`,
				c.`columnoption`
				FROM `'.$dbconfig['prefix'].'maintable` AS m
				LEFT JOIN `'.$dbconfig['prefix'].'category` AS c ON m.`categoryid` = c.`id`';
				$sql.='WHERE 1';
				if($temstr)	$sql  .= ' AND ('.$temstr.')';
				if(isset($datas['cid'])&&$datas['cid']) $sql .= ' AND m.`categoryid` in( '.implode(',',getCategoryIds($datas['cid'],true)).') ';
				if(!$temstr) $sql  .= ' ORDER BY m.`hits`,m.`publishtime` DESC ';
				else $sql  .= ' ORDER BY m.`publishtime` DESC ';
				if(isset($datas['row'])&&$datas['row']) $sql  .= ' LIMIT 0,'.$datas['row'].' ';

			$result = M('maintable')->query($sql);
			foreach($result as $key=>$value)
			{
				$result[$key]['url'] = getArticleUrl($value['id'], $value['filepath'], $value['publishopt'],'content/Content/index' ,'content_$id_1.html',$value['created']);
			}
			return $result;
				
		}
		foreach($position as $key=>$value)
		{
			$cidinfo = cid2info($value['cat_id']);
			if($value['model_id']==2)
			{
				include_once 'goods.lib.php';
				$good_obj = new goods();
				$contentInfo = $good_obj->lib_goods(array('id'=>$value['ag_id']));
				$postion[$key]['title'] = $contentInfo['goodsname'];
				$position[$key]['info'] = $contentInfo;

			}
			else
			{
				include_once 'content.lib.php';
				$article_obj = new content();
				$contentInfo = $article_obj->lib_content(array('id'=>$value['ag_id']));
				$postion[$key]['title'] = $contentInfo['title'];
				$position[$key]['info'] = $contentInfo;				
			}
		}
		return $position;
		
	}
}
?>
