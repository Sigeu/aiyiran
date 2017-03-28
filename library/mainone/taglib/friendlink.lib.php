<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  友情链接
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

class friendlink
{
	function lib_friendlink($datas)
	{
		$order = isset($datas['order']) ? $datas['order'] : 'sort asc,id desc';
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$limit = isset($datas['row']) ? $datas['row'] : '1000000';
		$limit = $from.','.$limit;
		$condtion = array(1=>1);
		$condtion = array_filter($condtion);
		
		$link = M('Link')->where($condtion)->limit($limit)->order($order)->select();
		
		return $link;
		
	}
}
?>
