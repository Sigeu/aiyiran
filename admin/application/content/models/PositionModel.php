<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * PositionModel.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-1-11 下午5:14:14
 * @filename   PositionModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class PositionModel extends Model
{
    public $pk = "pos_id";
    public $tableName = 'position';

    public function getPositionMessage($from, $pagesize) { //推荐位列表
        $sql = "SELECT P.*, C.catname FROM ". $this->tablePrefix ."position AS P,". $this->tablePrefix ."category AS C WHERE P.cat_id = C.id ORDER BY P.pos_id DESC LIMIT ". $from."," . $pagesize;
        $arr = $this->query($sql);
        foreach ($arr AS $key=>$val){
            $arr[$key]['alter_time'] = date("Y-m-d", $val['alter_time']);
        }
        return $arr;
    }

    //栏目列表
    public function getCatList() {
        $sql = "SELECT id,catname FROM ".$this->tablePrefix ."category";
        return $this->query($sql);
    }

    //插入操作
    public function correctPosition($n,$c,$m,$s) {
        $t = time();
        $category_info = cid2info($c);
        $model_id = 0;
        if ($category_info) {
            $model_id = isset($category_info['model']) ? $category_info['model'] : 0;
        }
        $sql = "INSERT INTO ". $this->tablePrefix."position (`model_id`, `name`,cat_id,max_num,alter_time,special) VALUES ('$model_id', '$n','$c','$m','$t','$s')";
        $this->query($sql);
    }

    //更新
    public function updatePosition($id,$n,$c,$m,$s) {
        $category_info = cid2info($c);
        $model_id = 0;
        if ($category_info) {
            $model_id = isset($category_info['model']) ? $category_info['model'] : 0;
        }
        $sql = "UPDATE ". $this->tablePrefix ."position SET `model_id`='$model_id', `name`='$n',cat_id='$c',max_num='$m',special='$s' WHERE pos_id = '$id'";
        $this->query($sql);
    }

    /* 根据ID获取推荐位 */
    public function getPositionById($id) {
        $row = $this->query("SELECT * FROM ". $this->tablePrefix ."position WHERE pos_id = ".$id);
        foreach ($row AS $val){
            $arr = $val;
        }
        return $arr;
    }

    /* 根据ID获取推荐位信息 */
    public function getPositionInfoById($id) {
        $row = $this->query("SELECT * FROM ". $this->tablePrefix ."position_info WHERE id = ".$id);
        foreach ($row AS $val){
            $arr = $val;
        }
        return $arr;
    }

    //根据ID获取对应的推荐位信息
    public function getPositionInfo($id, $from, $pagesize) {
        $sql = "SELECT P.*, C.catname FROM ". $this->tablePrefix ."position_info AS P,". $this->tablePrefix ."category AS C WHERE P.cat_id = C.id AND P.pos_id = $id ORDER BY P.sortby ASC LIMIT ". $from."," . $pagesize;
        $row = $this->query($sql);
        if(count($row) <> 0) {
            return $row;
        }
    }

    //获取统计数据
    public function getPositionNumber($id) {
        $sql = "SELECT COUNT(*) AS number FROM ". $this->tablePrefix ."position_info AS P,". $this->tablePrefix ."category AS C WHERE P.cat_id = C.id AND P.pos_id = $id GROUP BY P.pos_id";
        $result = $this->query($sql);
        if(!empty($result)) {
            foreach($result AS $val){
                $num = $val['number'];
            }
            return $num;
        }
    }

    //根据栏目ID获取模型ID
    public function getModelIdByCatId($id)
    {
        $model = array();
        $result = $this->query("SELECT model FROM ". $this->tablePrefix ."category WHERE id = ".$id);
        foreach ($result AS $val){
            $model = $val['model'];
        }
        return $model;
    }

    //根据文章ID获取文章名称或根据商品ID获取商品名称
    public function getHeadline($id)
    {
        $result = $this->query("SELECT title FROM ". $this->tablePrefix ."maintable WHERE id = ".$id);  //文章
        foreach ($result AS $val){
            $title = $val['title'];
        }

        $goods = $this->query("SELECT goodsname FROM ". $this->tablePrefix ."goods WHERE goodsid = ".$id);  //商品
        foreach ($goods AS $value){
            $good = $value['goodsname'];
        }

        return empty($title) ? $good : $title;  //有可能会出问题、此写法不太严谨
    }





}