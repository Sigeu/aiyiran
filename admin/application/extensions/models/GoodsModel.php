<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 商品模型
 * 
 * 
 * 拥有获取所有商品页id的方法
 * 
 * 文件修改记录：
 * <br>史天宇  2013-10-14 下午5:37:08 创建此文件 
 * 
 * @author     史天宇 <shitianyu@mail.b2b.cn>  2013-10-14 下午5:37:08
 * @filename   GoodsModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */

class GoodsModel extends Model
{
	public $pk = "goodsid";//主键
	public $tableName = "goods";//表名

	/**
	 * 获取所有商品信息列表
	 * @return array()
	 */
	public function getGoodsIdList()
	{
		$data = $this->findAll(null,null,'goodsid,goodsname,created');

		if(!empty($data)) {
			return $data;
		}
		else {
			return false;
		}
	}
}