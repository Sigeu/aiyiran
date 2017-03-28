<?php
class cemeinfo
{
    function lib_cemeinfo($data)
    {
            $order     = isset($data['order']) ? $data['order'] : 'id desc';
            $cemetery_id     = isset($data['cemeid']) ? $data['cemeid'] : '';
            $categoryid     = isset($data['categoryid']) ? $data['categoryid'] : '';
            $photo     = isset($data['photo']) ? $data['photo'] : '';
            $from     = isset($data['from']) ? $data['from'] : '0';
            $limit    = isset($data['row']) ? $data['row'] : '10000000000000';   //由于模型，把数字弄大点，不写sql
            $limit    = isset($data['pagesize']) ? $data['pagesize'] : $limit;
            $condition = array();
            if($cemetery_id){
                $condition = array(
                  'cemetery_id'=>$cemetery_id,
                  'categoryid'=>$categoryid
                  );
                  $result = M('maintable')->where($condition)
                            ->order($order)
                            ->limit($from.','.$limit)
                             ->select();
                 return $result;
            }else{
              return null;
            }

             if($photo){
                $condition = array('pid'=>$photo);
                  $result = M('memorial_cemetery2_photo')->where($condition)
                            ->order($order)
                            ->limit($from.','.$limit)
                             ->select();
                foreach ($result as $key => $value) {
                    $result[$key]['photo_url'] = '/static/uploadfile'.$value['photo_url'];
                }
                 return $result;
            }else{
              return null;
            }
          
    }
}