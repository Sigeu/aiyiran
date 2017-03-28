<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialSectionModel
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013/9/3
 * @filename   SpecialSectionModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialSectionModel extends Model
{

    /*
    * 根据专题ID获取导航列表
    */
    public function getBannerList($id)
    {
        $array = $this->findAll(array('sid'=>$id),true,'id');
        $arr = array();
		foreach ($array AS $v){
			$arr[] = $v['id'];
		}
        $ids = implode(",", $arr);

        $sql = "SELECT aid, banner FROM ". $this->tablePrefix ."special_assort WHERE is_banner = 1 AND secid IN ($ids)";

        //echo $sql;exit;

        return $this->query($sql);///
    }



}
