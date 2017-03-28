<?php
class wish
{
    function lib_wish($data)
    {
            $order     = isset($data['order']) ? $data['order'] : 'id desc';
            $keywords     = isset($data['keywords']) ? $data['keywords'] : '';
            $aid     = isset($data['aid']) ? $data['aid'] : ''; //是否是文章留言
            $message     = isset($data['message']) ? $data['message'] : ''; //是否是文章留言

            $from     = isset($data['from']) ? $data['from'] : '0';
            $limit    = isset($data['row']) ? $data['row'] : '10000000000000';   //由于模型，把数字弄大点，不写sql
            $limit    = isset($data['pagesize']) ? $data['pagesize'] : $limit;
            $condtion = array();

            if($keywords){
                 $condtion['like'] = array('title'=>$keywords);
                 $condtion['like'] = array('content'=>$keywords);
            }
            if($aid){
                $condtion['aid'] = $aid;
            }
            
            if($message){ //如果传了参数就变成0
                $condtion['is_message']=0;
            }

            $result = M('wish')->where($condtion)
                            ->order($order)
                            ->limit($from.','.$limit)
                             ->select();

            return $result;
    }
}
