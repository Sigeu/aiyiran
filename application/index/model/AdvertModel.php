<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 负责前台广告的模型类
 * 
 * 文件修改记录：
 * <br>史天宇  2013-11-5 上午10:49:44 创建此文件 
 * 
 * @author     史天宇 <shitianyu@mail.b2b.cn>  2013-11-5 上午10:49:44
 * @filename   AdvertModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */

class AdvertModel extends Model {
	public $pk = "id";//主键
	public $tableName = "advert";//表名
	
	/**
	 * 获取指定广告位的广告类表
	 * @param int $adpositionid 指定广告位
	 */
	public function getAdvertList($adpositionid) {
		$sql = 'SELECT  * FROM ' . $this->tablePrefix . '_advert  WHERE adpositionid = \'' . $adpositionid . '\'    
				ORDER BY sort asc,id desc';//sql语句
		$result = $this->query($sql);//查询广告
		return $result;//返回结果	
	}
}
