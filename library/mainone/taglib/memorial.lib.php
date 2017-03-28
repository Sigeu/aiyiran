<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  文章列表标签
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class memorial
{
	function lib_memorial($datas)
	{
    $dearrank    = isset($datas['dearrank']) ? $datas['dearrank'] : ""; //亲情排行
    $keywords    = isset($datas['keywords']) ? $datas['keywords'] : ""; //根据
    $persontype    = isset($datas['persontype']) ? $datas['persontype'] : ""; //根据
    $letter    = isset($datas['letter']) ? $datas['letter'] : ""; //根据
		$order    = isset($datas['order']) ? $datas['order'] : "id desc"; //根据
		$from     = isset($datas['from']) ? $datas['from'] : '0';
    // echo $from;
		$limit    = isset($datas['pagesize']) ? $datas['pagesize'] : '1000';

		$catid    = isset($datas['catid']) ? $datas['catid'] : ''; //纪念馆的类型
    $field = isset($datas['field']) ? $datas['field'] : '*'; //查询字段
    $show = isset($datas['show']) ? $datas['show'] : '1'; //查询是否公开
    $userid = isset($datas['userid']) ? intval($datas['userid']) : 0; //查询某个用户的纪念馆

	    $condtion = array('isshow'=>$show);
        if($catid){
           $condtion['catid'] = $catid;
        }

        //如果存在要对亲情排行的话，替换 order
        if($dearrank){
          $order = 'dear_rank desc';
        }

        if($userid){
           $condtion['userid'] = $userid;
        }

        if($keywords){
          $condtion['like'] = array('personname'=>$keywords);
        }

        if($persontype){
          $condtion['persontype'] = $persontype;
        }

        if($letter){
          $condtion['letter'] = $letter;
        }

        $result = M('memorial')->where($condtion)->field($field)->order($order)->limit($from.','.$limit)->select();
        if($result){
          if(strpos($field,'persontype') !=false){
            $persontype = get_config('common','person_type','home');
          }

          foreach($result as $key => $value){
             if(array_key_exists('persontype',$value)){
                $result[$key]['persontype_name'] = $value['persontype'] ? $persontype[$value['persontype']] : "";
             }
             // if(strpos($field,'userpic') !=false){
             //   $result[$key]['userpic'] = '/static/uploadfile'.$value['userpic'];
             // }
          }
          return $result;

        }else{
          return false;
        }


	}
}
?>
