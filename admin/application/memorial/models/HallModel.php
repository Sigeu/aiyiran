<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentModel.php
 *
 * 内容管理模型类
 *
 * @author     月下追魂<youkaili@mail.b2b.cn>   2016年11月15日11:34:34
 * @filename   HallModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class HallModel extends Model
{
    public $pk = "id";//主键
    public $tableName = "mo_memorial";//表名

    public function  getList($count=10)
    {
        $list = $this->findLimit('','','',0,$count);
        
        
        return $list;
    }
    
    public function testsql()
    {
        $sql = "select c.*,m.* from mo_maintable as m left join mo_category as c on m.categoryid=c.id";
        $result = $this->query($sql);
        
        return $result;
        
    }

    /**
     * 获取纪念馆列表数据
     */
    public function getData($search=array(), $count)
    {

        $sql = "SELECT  m.*, c.id AS cid, c.name AS cname FROM `mo_memorial` AS m 
                LEFT JOIN `mo_memorial_cat` AS c 
                ON m.id = c.id";
        $sql .=" WHERE 1";
        if($search['keywords']) $sql .=" AND m.name like '%{$search['keywords']}%' ";
        if($search['categoryid']) $sql .=" AND m.catid = {$search['categoryid']} ";
        if($search['status']) $sql .=" AND m.status = {$search['status']} ";

        #时间区域搜索
        if($search['star'] && $search['end']) $sql .= " AND m.createtime >= '{$search['star']}' AND m.createtime <= '{$search['end']}' ";
        if($search['star'] && empty($search['end'])) $sql .= " AND m.createtime > '{$search['star']}' ";
        if($search['end'] && empty($search['star'])) $sql .= " AND m.createtime < '{$search['end']}' ";
        
        if($count){
            return count($this->query($sql));
        }
        if($count == false){
            if($search['limit']) $sql  .= ' ORDER BY m.id DESC LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }
    }

    /**
     * 获取分类
     */
    public function getCateList()
    {
        $data = M('memorial_cat')->select();
        return $data;
    }


    #获取纪念馆用户资料
    public function getInfo($mid)
    {
        #纪念馆 mid

        $base = array();
        #获取用户信息
        $base['info'] = M('memorial_userinfo')->where(array('mid'=>$mid))->getOne();

        #获取纪念馆信息
        $base['memorial'] = M('memorial')->where(array('id'=>$mid))->getOne();

        return $base;
    }

    #获取用户资料
    public function getInfo2($mid, $id)
    {
        $insetData = array();
        $insetData['person'] = $_POST['person'];
        $insetData['sex'] = $_POST['sex'];
        $insetData['nation'] = $_POST['nation'];
        $insetData['originp'] = $_POST['originp'];
        $insetData['originc'] = $_POST['originc'];
        $insetData['origind'] = $_POST['origind'];
        $insetData['careers'] = $_POST['careers'];
        $insetData['relationship'] = $_POST['relationship'];
        $insetData['brith'] = $_POST['brith'];
        $insetData['died'] = $_POST['died'];
        $insetData['brithp'] = $_POST['brithp'];
        $insetData['brithd'] = $_POST['brithd'];
        $insetData['brithc'] = $_POST['brithc'];
        $insetData['diedp'] = $_POST['diedp'];
        $insetData['diedd'] = $_POST['diedd'];
        $insetData['diedc'] = $_POST['diedc'];
        $insetData['descript'] = $_POST['descript'];
        $insetData['brithdate'] = strtotime($_POST['brithdate']);
        $insetData['dieddate'] = strtotime($_POST['dieddate']);
        $insetData['nationval'] = $_POST['nationval'];
        $insetData['cemetery'] = $_POST['cemetery'];
    
        //明文 日期处理 =====================================================
        $brith = Controller::post('brithdate');
        $brith = explode('-', $brith);
        $insetData['m_year'] = $brith[0];
        $insetData['m_month'] = $brith[1];
        $insetData['m_day'] = $brith[2];
        
        $dieddate = Controller::post('dieddate');
        $dieddate = explode('-', $dieddate);
        $insetData['d_year'] = $dieddate[0];
        $insetData['d_month'] = $dieddate[1];
        $insetData['d_day'] = $dieddate[2];
        //明文 日期处理 =====================================================

        $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
        if($accessory){
            $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'member','time_name'=>false));
            $memberHeader = $upload_info ? (isset($upload_info[0]['path']) ? '/static/uploadfile/member/'.$upload_info[0]['path'] : ''  )  : '';
            $url = $upload_info[0]['sp']['full'].'/'.$upload_info[0]['filename'];
            my_image_resize($url, $url, '185px','185px');

            $url2 = $upload_info[0]['sp']['base'] . '/s/' . $upload_info[0]['path'];
            my_image_resize($url, $url2, '140px','140px');

            M('memorial')->update(array('id'=>$mid),array('userpic'=>$memberHeader));
        }

        $map = array(
            'id'=>$id
            );
        $result = M('memorial_userinfo')->update($map, $insetData);
        M('memorial')->update(array('id'=>$mid), array('cid'=>$insetData['cemetery']));

        return $result;
    }    
}