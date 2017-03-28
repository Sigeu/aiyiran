<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  留言
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

class message
{
	function lib_message($datas)
	{
		$dbconfig = get_config('database','default');
		$order = isset($datas['order']) ? $datas['order'] : $dbconfig['prefix'].'message_manage.id';
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$limit = isset($datas['row']) ? $datas['row'] : '1000000';
		$limit = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
		$condtion['ischeck'] =  1;
		$limit = $from.','.$limit;
		//$condtion['id'] = isset($datas['id']) ? $datas['id'] : '';
		$condtion[$dbconfig['prefix'].'message_manage.id'] = isset($datas['id']) ? $datas['id'] : '';// 2013-07-15 10:39 由leishaojin替换了上句
	    $condtion['typeid'] = isset($datas['modelid']) ? $datas['modelid'] : '';
		$condtion = array_filter($condtion);
		//$comment = M('message')->where($condtion)->limit($limit)->order($order)->select();
		$Ftable = $dbconfig['prefix'].'message_'.$condtion['typeid'];
		$list_result = M('message_manage')->where($condtion)
		                        ->field($Ftable.'.*,admin.username as replyer,'.$dbconfig['prefix'].'message_manage.*')
		                        ->join('left join '.$Ftable.' on '.$dbconfig['prefix'].'message_manage.message_id = '.$Ftable.'.id left join '.$dbconfig['prefix'].'admin as admin on replymember = admin.id')
                                ->order($order)
                                ->limit($limit)
                                ->select();
		$obj = D('Comment','comment');
		foreach($list_result as $key=>$value)
		{
			//过滤敏感词信息
			foreach($value as $k => $v)
			{
				$value[$k] = $obj->replacestr($v);
			}
			$list_result[$key] = $value;
		}

		if(!empty($list_result))
			$list_result =$this -> formateUrl($list_result,$datas);
		
		//获取自定义表单设置
		$mess_obj = M("WebConfig");
		$set =$mess_obj->where(array('group_id'=>10))->field('par_name,par_value')->select();
			
		foreach ($set as $sk=>$sv){
			$messageset[$sv['par_name']] = $sv['par_value'];
		}
		
		$list_message = array();
		foreach ($list_result as $key=>$val) {
			if (($val['ischeck']==1 && $messageset['mo_isexamine']==1) || ($messageset['mo_isexamine']==2)) {
				$val['mess_info'] = csubstr($val['mess_info'] , $messageset['mo_word_num'] ,'...');
				$list_message[] = $val;
			}
		}
		return $list_message;

	}

	/**
	 * 格式化留言详细页链接
	 * @param
	 * @return
	 */
	function formateUrl ($info,$datas)
	{
		$tpl = isset($datas['tpl']) && !empty($datas['tpl']) ? '/tpl/'.$datas['tpl'] : '';
		$cid = isset($datas['cid']) && !empty($datas['cid']) ? '/cid/'.$datas['cid'] : '';
		foreach ($info as $key => $val )
		{
			$url = HOST_NAME.'message/message/detail/typeid/'.$val['typeid'].'/id/'.$val['id'].$cid.$tpl;
			$info[$key]['url'] = $url;
		}
		return $info;
	}
}
