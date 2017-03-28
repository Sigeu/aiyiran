<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  评论标签
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
class comment
{
	function lib_comment($datas)
	{
		$order = isset($datas['order']) ? $datas['order'] : '';
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$limit = isset($datas['row']) ? $datas['row'] : '1000000';
		$limit = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
		$limit = $from.','.$limit;
		$condtion = array(1=>1);
		$condtion['in'] = isset($datas['status']) ? array('comment_status'=>$datas['status']): array('comment_status'=>'1,3');
		$condtion['comment_infoid'] = isset($datas['id']) ? $datas['id'] : '';
		if(isset($datas['modelid'])&&$datas['modelid']!=2)
		{
			$condtion['notin'] = array('comment_modelid'=>2);
		}
		else
		{
			$condtion['comment_modelid'] = 2;
		}	
		$comment = M('comment')->where($condtion)->limit($limit)->order($order)->select();
		foreach($comment as $key=>$value)
		{
			//过滤敏感词信息
			$comment[$key]['comment_content']=D('Comment','comment')->replacestr($value['comment_content']);
			$comment[$key]['username'] = uid2name($value['comment_userid']) ? uid2name($value['comment_userid']) : '匿名';

			$comment[$key]['replyer'] = uid2admin($value['reply_userid'])  ? uid2admin($value['reply_userid']) : '管理员';

		}
		return $comment;
		
	}
}
?>
