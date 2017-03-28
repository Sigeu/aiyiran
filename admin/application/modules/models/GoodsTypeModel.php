<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 商品类型
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-15 10:21 创建此文件
 * <br>雷少进  2013-01-15 10:21 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsTypeModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class GoodsTypeModel extends Model
{
	public $pk = "typeid";//主键
	public $tableName = "goods_type";//表名

	/**
	 * 删除商品类型和关联的属性字段和关联的属性值
	 * @param
	 * @return
	 */
	function clearGoodsType ($typeid)
	{
		$sql = 'DELETE FROM `'.$this -> tablePrefix.'goods_attr_value` WHERE `attrid` IN (SELECT `attrid` FROM `'.$this -> tablePrefix.'goods_attr` WHERE `typeid` IN  ('.$typeid.'))';
		$this -> query($sql);
		$sql  = 'DELETE FROM `'.$this -> tablePrefix.'goods_attr` WHERE `typeid` IN ('.$typeid.')';
		$this -> query($sql);
		$sql  = 'DELETE FROM `'.$this -> tablePrefix.'goods_type` WHERE `typeid` IN ('.$typeid.')';
		$this -> query($sql);
	}
}