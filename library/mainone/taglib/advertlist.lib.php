<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *广告列表标签
 * 
 * 文件修改记录：
 * <br>史天宇  2013-11-5 下午4:25:10 创建此文件 
 * 
 * @author     史天宇 <shitianyu@mail.b2b.cn>  2013-11-5 下午4:25:10
 * @filename   advertlist.lib.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */

class advertlist
{
	function lib_advertlist($datas)
	{
		$dbconfig = get_config('database','default');//得到数据库配置信息

		$order = isset($datas['order']) ? $datas['order'] : "`sort` ASC , `id` DESC";//排序条件
		$from = isset($datas['from']) ? $datas['from'] : '0';//从哪开始
		$limit = isset($datas['row']) ? $datas['row'] : '5';//限制几个
		$limit = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;//每页多少
		$adposid = isset($datas['adposid']) ? $datas['adposid'] : '0';//广告位编号
		$adposidInfo = adposid2info($adposid);//通过广告位ID获取广告位信息
		$adtypeid = $adposidInfo['adtypeid'];//取出广告类型编号
		$condtion = array(1=>1);//永恒条件
		
	    if($adposid)//如果广告位编号不为0
   	    {
	   	  		$condtion = array(
	   	  			'adpositionid' => $adposid,
	   	  		);
	   	}
		$condtion = array_filter($condtion);
		//查出指定广告位限定的广告数据，并按要求排序
		$adver_list = M('Advert')->where($condtion)
		                        ->field('*')
                                ->order($order)
                                ->limit($from.','.$limit)
                                ->select();

         foreach($adver_list as $key => $value)
         {
         	$adver_list[$key]['adimg'] = unserialize(base64_decode($adver_list[$key]['adimg']));//还原格式化数据
         }
         
         return $adver_list;
	}
}
?>
