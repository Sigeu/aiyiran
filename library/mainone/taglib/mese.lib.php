<?php
class mese
{
    function lib_mese($data)
    {

        $new    = isset($datas['new']) ? $datas['new'] : ""; //最新祭拜
        $options['order'] = 'id desc';

        if($new){
            //通用底部的 最新祭拜
            $result = M('memorial_comment')->limit('10')->select($options);

        }else{
            //首页底部的最新追思留言
            $result = M('memorial_comment')->limit('10')->select($options);
        }

       
        return $result;
    }
}