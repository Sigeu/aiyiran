<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 商品属性表
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-18 14:23 创建此文件
 * <br>雷少进  2013-01-18 14:23 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsAttrModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class GoodsAttrModel extends Model
{
	public $pk = "attrid";//主键
	public $tableName = "goods_attr";//表名

	/**
	 * 获取分页列表
	 */
	function _getPageList ($typeid)
	{
		$sql = 'SELECT * FROM `'.$this -> trueTableName.'` WHERE `typeid` = \''.$typeid.'\' ORDER BY `ordernum` ASC,created DESC';
		return $this -> getPageList(array('sql'=>$sql));
	}
}