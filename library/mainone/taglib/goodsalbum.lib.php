<?php 
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  商品相册
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

class goodsalbum
{
	
	function lib_goodsalbum($datas)
	{
	  $order = isset($datas['order']) ? $datas['order'] : 'albumid desc';
   	  $limit = isset($datas['row']) ? $datas['row'] : '10000000';
   	  $id = isset($datas['id']) ? $datas['id'] : '';
   	  $condtion = array(1=>1);
   	  if($id)
   	  {
   	  		$condtion = array(
   	  			'goodsid' => $id,
   	  		);
   	  }
   	  $result = M('goods_album')->where($condtion)->order($order)->limit('0,'.$limit)->select();
   	  //var_Dump($result);
   	  return $result;
   }
	
}
?>
