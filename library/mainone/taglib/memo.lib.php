<?php
class memo
{
    function lib_memo($data)
    {
         #获取今天时间
        $now = date("m-d",time());
        #获取今天年份
        $year = date("Y", time());

        $isTop    = isset($data['isTop']) ? $data['isTop'] : ""; //是否推荐
        $keywords    = isset($data['keywords']) ? $data['keywords'] : ""; //搜索关键字
        $letter    = isset($data['letter']) ? $data['letter'] : ""; //字母
        $catid = isset($data['catid']) ? $data['catid'] : "";  //分类
        $order = isset($data['order']) ? $data['order'] : " m.id DESC"; //排序
        $from  = isset($data['from']) ? $data['from'] : '0';  //开始
        $limit = isset($data['pagesize']) ? $data['pagesize'] : '1000'; //显示条数
        $status= isset($data['status']) ? $data['status'] : '1'; //不是1的话都不显示
        $field = isset($data['field']) ? $data['field'] : '*'; //查询字段
        $day   = isset($data['day']) ? $data['day'] : "";

        // 关联
        $userid    = isset($data['userid']) ? $data['userid'] : ''; //所属的用户资料关联id
        $cid    = isset($data['cid']) ? $data['cid'] : ''; //所属的陵园关联id

        $sql = "SELECT {$field},cat.name AS cat_name, m.name AS m_name, m.id AS m_id, cat.id AS cat_id
                FROM `mo_memorial` AS m
                LEFT JOIN `mo_memorial_userinfo` AS c
                ON m.id = c.mid
                LEFT JOIN `mo_memorial_cat` AS cat
                ON m.catid = cat.id";
        $sql .= " WHERE 1";
        if($keywords) $sql .= " AND m.personname LIKE '%{$keywords}%'";
        if($catid) $sql .= " AND m.catid = {$catid}";
        if($status) $sql .= " AND m.status = {$status}";
        if($letter) $sql .= " AND m.letter = '{$letter}'";
        if($isTop) $sql .= " AND m.isTop = '{$isTop}'";
        #查询那年今日的信息
        if($day) $sql .= " AND FROM_UNIXTIME(dieddate, '%m-%d') = '{$now}'
                AND FROM_UNIXTIME(dieddate, '%Y') < {$year}";

        if($order) $sql .= " ORDER BY {$order}";
         $sql .= " LIMIT ".$from.','.$limit;
        $result =joinres($sql);
        if($result){
            foreach($result as $key => $value){
             if($result[$key]['userpic']==false){
                $result[$key]['userpic'] = "/template/default/member/images/default_max.png";
             }
            }
            return $result;
        }else{
            return false;
        }

    }
}