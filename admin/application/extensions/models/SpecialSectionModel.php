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

        return $this->query($sql);///////
    }


    /*
    * 根据专题创建三个版块、再根据三个版块分别创建对应的节点
    */
    public function createSection($sid)
    {
        $insert_id = array();

        //默认版块顺序为 两栏、三栏、一栏
        $insert_id[1] = $this->create(array('sid'=>$sid,'section_type'=>2));
        $insert_id[2] = $this->create(array('sid'=>$sid,'section_type'=>3));
        $insert_id[0] = $this->create(array('sid'=>$sid,'section_type'=>1));

        for ($i=0; $i<7; $i++) {  //两栏
            $sql = "INSERT INTO ". $this->tablePrefix."special_assort (secid) VALUES ('$insert_id[1]')";
            $this->query($sql);
        }

        for ($i=0; $i<8; $i++) {  //三栏
            $sql = "INSERT INTO ". $this->tablePrefix."special_assort (secid) VALUES ('$insert_id[2]')";
            $this->query($sql);
        }

        for ($i=0; $i<4; $i++) {  //一栏
            $sql = "INSERT INTO ". $this->tablePrefix."special_assort (secid) VALUES ('$insert_id[0]')";
            $this->query($sql);
        }
    }

    /*
    * 批量添加版块和节点
    */
    public function createSectionAndAssort($sid, $types)
    {
        $arr = explode(',', $types);
        array_shift($arr);
        foreach ($arr as $val)
        {
            $insert_id = $this->create(array('sid'=>$sid,'section_type'=>$val));
            if($val == 1) {
                for ($i=0; $i<4; $i++) {
                    M('special_assort')->create(array('secid'=>$insert_id));
                }
            }else if($val == 2) {
                for ($i=0; $i<7; $i++) {
                    M('special_assort')->create(array('secid'=>$insert_id));
                }
            }else if($val == 3) {
                for ($i=0; $i<8; $i++) {
                    M('special_assort')->create(array('secid'=>$insert_id));
                }
            }
        }
    }

    /*
    * 排序
    */
    public function updateReorder($sid, $reorder)
    {
        $arr = explode(',', $reorder);
        $list = $this->findAll(array('sid'=>$sid),'sortby ASC, id ASC','id');
        foreach($list AS $key => $val){
            $first = array_shift($arr);
		    $this->update(array('id'=>$val['id']), array('sortby'=>$first));
        }
    }


}
