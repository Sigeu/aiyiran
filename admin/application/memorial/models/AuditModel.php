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
class AuditModel extends Model
{
    public $pk = "id";//主键
    public $tableName = "mo_memorial";//表名

    /**
     * 获取无限级分类
     */
    public function getCategoryTree($pid=0,$t=-1)
    {
        $t++;
        static $cat_temp;
        $data = M('memorial_cat')->findAll(array('pid'=>$pid),'id ASC, name');
        if(!empty($data))
        {
            foreach ($data as $key => $val )
            {
                $val['name'] = str_repeat('&nbsp;',$t*3).'├'.$val['name'];
                $val['level'] = $t+1;
                $cat_temp[] = $val;
                $this -> getCategoryTree($val['id'],$t);
            }
        }
        return $cat_temp;
    }

     /**
     * 获取所有纪念馆
     */
    public function getMemarilaList()
    {
        $data = M('memorial')->select(array('field'=>'id,name'));
        return $data;
    }

    /**
     * 获取所有分类
     */
    public function getCatList()
    {
        $data = M('memorial_cat')->select(array('field'=>'id,name'));
        return $data;
    }
    public function getCatList2()
    {
        $data = M('memorial_cat')->select();
        return $data;
    }

    /**
     * 作品及荣誉搜索
     */
    public function searchHonor($search, $count)
    {
        $sql = "SELECT * FROM `mo_memorial` AS m 
                RIGHT JOIN `mo_memorial_honor` as h 
                ON m.id = h.mid";
        $sql .=" WHERE 1";
        if($search['keywords']) $sql .=" AND h.hname like '%{$search['keywords']}%' ";
        if($search['memorial_id']) $sql .=" AND m.id = {$search['memorial_id']} ";
        if($search['status']) $sql .=" AND h.status = {$search['status']} ";

        #时间区域搜索
        if($search['star'] && $search['end']) $sql .= " AND h.createtime >= '{$search['star']}' AND h.createtime <= '{$search['end']}' ";
        if($search['star'] && empty($search['end'])) $sql .= " AND h.createtime > '{$search['star']}' ";
        if($search['end'] && empty($search['star'])) $sql .= " AND h.createtime < '{$search['end']}' ";

        if($count == true){
            return count($this->query($sql));
        }

        if($count == false){
            if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }

    }

    /**
     * 传记 - 搜索
     */
    public function searchbiog($search, $count)
    {
        $sql = "SELECT * FROM `mo_memorial` AS m 
                RIGHT JOIN `mo_memorial_biography` as h 
                ON m.id = h.mid";
        $sql .=" WHERE 1";
        if($search['keywords']) $sql .=" AND h.bioname like '%{$search['keywords']}%' ";
        if($search['memorial_id']) $sql .=" AND m.id = {$search['memorial_id']} ";
        if($search['status']) $sql .=" AND h.status = {$search['status']} ";

        #时间区域搜索
        if($search['star'] && $search['end']) $sql .= " AND h.createtime >= '{$search['star']}' AND h.createtime <= '{$search['end']}' ";
        if($search['star'] && empty($search['end'])) $sql .= " AND h.createtime > '{$search['star']}' ";
        if($search['end'] && empty($search['star'])) $sql .= " AND h.createtime < '{$search['end']}' ";

        if($count == true){
            return count($this->query($sql));
        }

        if($count == false){
            if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }
    }

    /**
     * 纪念祭文 - 搜索
     */
    public function searcheulogy($search, $count)
    {
        $sql = "SELECT *,c.name AS cname,m.name AS jname FROM `mo_memorial` AS m 
                RIGHT JOIN `mo_memorial_eulogy` as h 
                ON m.id = h.mid 
                LEFT JOIN `mo_memorial_cat` as c
                ON c.id = h.cid";
        $sql .=" WHERE 1";
        if($search['keywords']) $sql .=" AND h.ename like '%{$search['keywords']}%' ";
        if($search['memorial_id']) $sql .=" AND m.id = {$search['memorial_id']} ";
        if($search['status']) $sql .=" AND h.status = {$search['status']} ";
        if($search['cat_id']) $sql .=" AND c.id = {$search['cat_id']} ";

        #时间区域搜索
        if($search['star'] && $search['end']) $sql .= " AND h.createtime >= '{$search['star']}' AND h.createtime <= '{$search['end']}' ";
        if($search['star'] && empty($search['end'])) $sql .= " AND h.createtime > '{$search['star']}' ";
        if($search['end'] && empty($search['star'])) $sql .= " AND h.createtime < '{$search['end']}' ";

        if($count == true){
            return count($this->query($sql));
        }

        if($count == false){
            if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }
    }

    /**
     * 留言审核 - 搜索
     */
    public function searchMessage($search, $count)
    {
        $sql = "SELECT s.id, s.content, s.addtime, s.status, m.name, u.email,u.username AS jname FROM `mo_memorial_comment` AS s 
                    LEFT JOIN `mo_memorial` AS m ON m.id=s.mid 
                    LEFT JOIN `mo_member` AS u ON u.id = s.uid";
        $sql .=" WHERE 1";
        if($search['memorial_id']) $sql .= " AND s.mid = {$search['memorial_id']}";
        if($search['status']) $sql .=" AND s.status = {$search['status']}";
        if($count == true){
            return count($this->query($sql));
        }

        if($count == false){
            if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }

    }

    /**
     * 文章评论 - 搜索
     */
    public function searchComment($search, $count)
    {
        $sql = "SELECT * FROM `mo_wish`";
        $sql .= " WHERE 1";
        if($search['keywords']) $sql .=" AND content like '%{$search['keywords']}%' ";
        if($search['status']) $sql .=" AND status = {$search['status']}";
        if($count == true){
            return count($this->query($sql));
        }

        if($count ==false){
            if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }
    }



}