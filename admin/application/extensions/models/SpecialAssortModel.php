<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialAssortModel
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013/9/3
 * @filename   SpecialAssortModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialAssortModel extends Model
{

	public $pk = "aid";//主键
	public $tableName="special_assort"; //表


    /*
    * 根据版块创建相应节点
    */
    public function createAssort($secid, $number)
    {
        for ($i=0; $i<$number; $i++) {
            $this->create(array('secid'=>$secid));
        }
    }
	/**
	 * 获取节点信息
	 * @param
	 * @return null
	 */
	public function getNodeBySection (&$select_list)
	{
		$section_model = D('SpecialSection');
		foreach ($select_list as $key => $val )
		{
			$node_info = $this->getContentByNodeId($val['id']);
			$select_list[$key]['info_list'] = $node_info;
		}
	}

	/**
	 * 通过节点配置 获取内容
	 */
	public function getContentByNodeId ($nodeid)
	{
		$node_list = $this->findAll(array('secid'=>$nodeid));
		$temp = array();
		foreach ($node_list as $key => $val)
		{
			$temp[] = array('node_conf'=>$this->find(array('aid'=>$val['aid'])),'info_list'=>$this->getInfoByNodeId($val['aid']));
		}
		return $temp;
	}

    //根据节点ID获取展示信息
    public function getInfoByNodeId($node_id)
    {
        $arr = $this->find(array('aid'=>$node_id),true,'change_type,category_id,keywords,idlist,order_style,order_type,number');

        //$sql = "SELECT sa.*, mt.*, a.content FROM " .$this->tablePrefix ."maintable AS mt,". $this->tablePrefix ."special_assort AS sa,". $this->tablePrefix ."article AS a WHERE mt.id IN (".$arr['idlist'].") AND sa.aid = '$node_id' AND a.maintable_id = mt.id ORDER BY " . $arr['order_style'] . " " . $arr['order_type'] . " LIMIT " . $arr['number'];

                                                            /*  ---------------------------------------------------------------------------
                                                            * * 新sql未关联文章内容、由于数据混乱、关联文章内容常取不到数据 暂使用下面的sql
                                                            * * ---------------------------------------------------------------------------
                                                            */
        if($arr['change_type'] == 1) {  //固定栏目
            $sql = "SELECT sa.*, mt.* FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.categoryid = " .$arr['category_id']." AND sa.aid = '$node_id' ORDER BY mt." .$arr['order_style'] . " " . $arr['order_type'] . " LIMIT " . $arr['number'];
        }
        else if($arr['change_type'] == 2) {  //关键字
            $sql = "SELECT sa.*, mt.* FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.title LIKE '%" .$arr['keywords']. "%' AND sa.aid = '$node_id' ORDER BY mt." .$arr['order_style']. " " .$arr['order_type']. " LIMIT " .$arr['number'];
        }
        else { //手动获取 && 其他
            $sql = "SELECT sa.*, mt.* FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.id IN (".$arr['idlist'].") AND sa.aid = '$node_id' ORDER BY mt." .$arr['order_style'] . " " . $arr['order_type'] . " LIMIT " . $arr['number'];
        }

        $result = $this->query($sql);
        foreach($result as $key=>$val){
            $result[$key]['thumb'] = json_decode($val['thumb'],true);
        }
        return $result;
    }

    ///获取那些设置了内容的节点所在版块ID合集
    public function getSectionListWhenAssortContentInside($number)
    {
        $list = array();
        $find = array();
        foreach($number AS $v){
            $list[] = $v['id'];
        }
        $in = implode(',',$list);
        $sql = "SELECT DISTINCT(secid) FROM " .$this->tablePrefix ."special_assort WHERE secid IN ($in) AND change_type != 0 ";
        $temp = $this->query($sql);
        foreach($temp AS $val){
            $find[] = $val['secid'];
        }
        return $find;
    }


}
