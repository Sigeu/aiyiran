<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-3-18 下午6:31:45 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-3-18 下午6:31:45

 * @filename   AdvertModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: AdvertModel.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class AdvertModel extends Model
{   
    public $pk = "id";//主键
	public $tableName = "advert";//表名
	
	/**
	 * @$time_type   int   广告位的展示方式 1:手动更改2：按上架时间显示一个
	 * @id           int   广告位
	 * @result       array()  获取本广告位下显示的广告
	 * 根据广告类型设置查询不同的广告信息
	 */
	public function getAdvert($time_type,$id){
		$sql = "SELECT * FROM ".$this->tablePrefix."advert WHERE adpositionid=".$id." AND (`timetype`=1 OR (`timetype`=2 AND (`starttime`<=".time()." AND `endtime`>=".time()."))) ";
		if($time_type ==2)
		{
			$sql.=" ORDER BY sort DESC,id DESC";
		}else if($time_type ==1){
			
			$sql.=" ORDER BY id DESC";
		}
		$sql .=' limit 0,1';
		$result =  $this->query($sql);
		if(!empty($result))
		{
			return $result[0];
		}else{
			return array();
		}
		
	}
}