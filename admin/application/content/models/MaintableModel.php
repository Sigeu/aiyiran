<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MaintableModel.php
 *
 * 内容管理主表模型类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-5 下午2:42:36
 * @filename   MaintableModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class MaintableModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "maintable";//表名

    public function getCatgoryName($id) {
        $result = $this->query("SELECT filepath FROM ". $this->tablePrefix ."category WHERE id = ". $id);
        foreach ($result AS $val){
            return $val['filepath'];
        }
    }

	/**
	 * 通过栏目ID获取该栏目下的内容数量
	 * @param
	 * @return
	 */
	public function getContentNumberByColumn ($id)
	{
		return $this -> findCount(array('categoryid'=>$id));
	}


}