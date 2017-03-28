<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  商品类别
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

class goodssort
{

	function lib_goodssort($datas)
	{
	  $order = isset($datas['order']) ? $datas['order'] : 'sortid';
   	  $limit = isset($datas['row']) ? $datas['row'] : '10000000';
   	  $type = isset($datas['type']) ? $datas['type'] : 'all';
   	  $id = isset($datas['id']) ? $datas['id'] : '';
   	  $condtion = array(1=>1);
   	  if($id)
   	  {
   	  	if($type == 'parent')
   	  	{
   	  		$pid = M('goods_sort')->field('pid')->where(array('sortid'=>$id))->getOne();
   	  		$condtion = array(
   	  			'sortid' => $pid['pid'],
   	  		);
   	  	}
   	  	elseif($type == 'son')
   	  	{
   	  		$id = M('goods_sort')->field('sortid')->where(array('pid'=>$id))->select();
   	  		foreach($id as $key=>$value)
   	  		{
   	  			$arr[] = $value['sortid'];
   	  		}
   	  		if(!empty($arr))
   	  		{
   	  			$str = implode($arr,',');
   	  			$condtion = array(
   	  					'in'=>array('sortid' => $str),
   	  			);
   	  		}
   	  	}
   	  	else
   	  	{
   	  		$condtion = array(
   	  			'sortid' => $id,
   	  		);
   	  	}

   	  }
   	  else
   	  {
   	  	if($type == 'top')
   	  	{
   	  		$condtion = array(
   	  				'pid'=>0,
   	  		);
   	  	}
   	  	if($type == 'all')
   	  	{
   	  		;
   	  	}
   	  }
   	  $result = M('goods_sort')->where($condtion)->order($order)->limit('0,'.$limit)->select();
   	  //var_Dump($result);
   	  return $result;
   }

}
?>
