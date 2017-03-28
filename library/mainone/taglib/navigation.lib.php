<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  导航
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
class navigation
{
   function lib_navigation($datas)
   {
   	  $order = isset($datas['order']) ? $datas['order'] : 'ordernum';
   	  $limit = isset($datas['row']) ? $datas['row'] : '10000000';

   	  $condtion = array(
   	  	'isnav' => 1, //在导航上显示的
   	  );
   	  $result = M('Category')->where($condtion)->order($order)->limit('0,'.$limit)->select();
   	  foreach($result as $key => $value)
   	  {
   	  	 if($value['model'] !=2)
   	  	 {
   	  	 	$result[$key]['url'] = getCategoryUrl($value['id'], $value['filepath'], $value['columnoption'],'category/Category/index');
			if($value['columnattr'] == 3)
				$result[$key]['url'] = $value['filepath'];
   	  	 }
   	  	 else
   	  	 {
   	  	 	$result[$key]['url'] = getCategoryUrl($value['id'], $value['filepath'], $value['columnoption'],'goods/Goods/index');
   	  	 }
   	  }
      return $result;
   }
}
?>