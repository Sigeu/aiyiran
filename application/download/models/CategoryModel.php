<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CategoryModel.php
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
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
class CategoryModel extends Model
{
	public $tableName = 'category';
	/**
	 * 
	 * @param int $cid 栏目ID
	 * @param string $type 获取模板类型：首页，列表页，内容页
	 * @return string 返回值
	 */
	public function  getTemplage($cid,$type)
	{
		$result = $this->where(array('id'=>$cid))->field('columntpl,indextpl,contenttpl')->getOne();
		return $result[$type];		
	}
}