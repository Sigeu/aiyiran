<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文章表模型
 *
 * 文件修改记录：
 * <br>史天宇  2013-10-14 11:47 创建此文件
 * <br>史天宇  2013-10-14 11:47 修改此文件
 *
 * @author     史天宇 <shitianyu@mainone.cn>
 * @filename   MaintableModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package	   
 * @since      2.0.0
 */
class MaintableModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "maintable";//表名
	
	/**
	 * 获取相应id记录的分类id
	 * @param int $id  id
	 * @return array()
	 */
	public function getCategoryId($id=0)
	{
		$data = $this->findAll(array('id'=>$id),null,'id,categoryid');
		
		if(!empty($data)) {
			return $data;
		}
		else {
			return false;
		}
	}
}