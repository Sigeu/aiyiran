<?php
class park
{
    function lib_park($data)
    {
            $order     = isset($data['order']) ? $data['order'] : 'id desc';
            $keywords     = isset($data['keywords']) ? $data['keywords'] : '';
            $province     = isset($data['province']) ? $data['province'] : '';
            $city     = isset($data['city']) ? $data['city'] : '';

            $from     = isset($data['from']) ? $data['from'] : '0';
            $limit    = isset($data['row']) ? $data['row'] : '10000000000000';   //由于模型，把数字弄大点，不写sql
            $limit    = isset($data['pagesize']) ? $data['pagesize'] : $limit;
            $condtion = array();

            if($keywords){
                 $condtion['like'] = array('title'=>$keywords);
            }

            if($province){
                 $condtion['province'] = $province;
            }

            if($city){
                 $condtion['city'] = $city;
            }

            $result = M('memorial_cemetery2')->where($condtion)
                            ->order($order)
                            ->limit($from.','.$limit)
                             ->select();
            foreach($result as $key => $value){
                    if($value['photo_url']==''){
                        $result[$key]['photo_url'] = '/static/uploadfile/logo/nopic.png';
                    }else{
                        $result[$key]['photo_url'] = '/static/uploadfile'.$value['photo_url'];
                    }
          }

            return $result;
    }
}