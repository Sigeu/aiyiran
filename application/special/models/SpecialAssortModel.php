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


    /*
    * 根据版块创建相应节点
    */
    public function createAssort($secid, $number)
    {
        for ($i=0; $i<$number; $i++) {
            $sql = "INSERT INTO ". $this->tablePrefix."special_assort (secid) VALUES ('$secid')";
            $this->query($sql);
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
            $result[$key]['static_url'] = $this->getStaticUrl($val['categoryid'],$val['publishtime'],$val['id']);
        }
        return $result;
    }

    //根据已知条件获取栏目静态文件保存路径
    public function getStaticUrl($categoryid, $publishtime, $id)
    {
        $catalog = $this->getCatalogByCategoryid($categoryid);
        $time = date("Y/m/d", $publishtime);
        $path = '/html/' . $catalog . '/' . $time . '/content_' . $id . '_1.html';
        return $path;
    }

    //根据节点ID获取全部信息
    public function getArticleByNodeId($node_id)
    {
        $array = $this->find(array('aid'=>$node_id),true,'idlist,order_style,order_type');
        $sql = "SELECT sa.*, mt.* FROM " .$this->tablePrefix ."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.id IN (".$array['idlist'].") AND sa.aid = '$node_id' ORDER BY " . $array['order_style'] . " " . $array['order_type'];
        return $this->query($sql);
    }

    //根据栏目ID获取栏目名称
    public function getCategoryNameById($id)
    {
        $sql = "SELECT catname FROM " .$this->tablePrefix ."category WHERE id = $id";
        $result = $this->query($sql);
        return $result['0']['catname'];
    }

    //根据栏目ID获取栏目文件保存目录
    public function getCatalogByCategoryid($id)
    {
        $sql = "SELECT filepath FROM " .$this->tablePrefix ."category WHERE id = $id";
        $result = $this->query($sql);
        return $result['0']['filepath'];
    }


    //根据节点ID获取展示信息
    public function getCountByNodeId($node_id)
    {
        $arr = $this->find(array('aid'=>$node_id),true,'change_type,category_id,keywords,idlist');

        if($arr['change_type'] == 1) {  //固定栏目
            $sql = "SELECT COUNT(*) AS number FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.categoryid = " .$arr['category_id']." AND sa.aid = '$node_id'";
        }
        else if($arr['change_type'] == 2) {  //关键字
            $sql = "SELECT COUNT(*) AS number FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.title LIKE '%" .$arr['keywords']. "%' AND sa.aid = '$node_id'";
        }
        else { //手动获取 && 其他
            $sql = "SELECT COUNT(*) AS number FROM " .$this->tablePrefix."maintable AS mt,". $this->tablePrefix ."special_assort AS sa WHERE mt.id IN (".$arr['idlist'].") AND sa.aid = '$node_id'";
        }
        $result = $this->query($sql);
        foreach($result AS $val){
			$sum = $val['number'];
		}
        return $sum;
    }



}
