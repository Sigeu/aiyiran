<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文章评论表Model
 *
 * 文件修改记录：
 * <br>雷少进  2013-02-18 10:48 创建此文件
 * <br>雷少进  2013-02-18 10:48 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   ArtCommentModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class CommentModel extends Model
{
	public $pk = "comment_id";//主键
	public $tableName = "comment";//表名

	 /**
	  * 文章评论分页列表
	  */
	function getCommentList ($search)
	{
		foreach ($search as $key => $val )
			$search[$key] = filterBadStr($val);

		//基础SQL
		$sql = 'SELECT m.title ,m.id AS art_id, mbr.username , cmt.*  FROM 
				`'.$this -> trueTableName.'` AS cmt 
				LEFT JOIN `'.$this -> tablePrefix.'maintable` AS m 
				ON cmt.comment_infoid = m.id  
				LEFT JOIN `'.$this -> tablePrefix.'member` AS mbr 
				ON mbr.id = cmt.comment_userid 
				WHERE cmt.comment_modelid != 2 ';

		if($search['title'])
			$sql .= ' AND ((m.title LIKE \'%'.$search['title'].'%\') OR  (mbr.username LIKE \'%'.$search['title'].'%\')) ';
		if($search['status'])
			$sql .= ' AND cmt.comment_status = \''.$search['status'].'\' ';
		if($search['is_reply'])
			$sql .= ' AND cmt.reply_isreply = \''.$search['is_reply'].'\' ';

		$sql .= ' ORDER BY comment_time DESC ';
		return $this -> getPageList(array('sql'=>$sql,'search'=>$search,'pagesize'=>20));
	}

	 /**
	  * 商品评论列表
	  */
	function getGoodsCommentList ($search)
	{
		foreach ($search as $key => $val )
			$search[$key] = filterBadStr($val);

		//基础SQL
		$sql = 'SELECT g.goodsname AS title ,g.goodsid, mbr.username , cmt.*  FROM 
				`'.$this -> trueTableName.'` AS cmt 
				LEFT JOIN `'.$this -> tablePrefix.'goods` AS g 
				ON cmt.comment_infoid = g.goodsid  
				LEFT JOIN `'.$this -> tablePrefix.'member` AS mbr 
				ON mbr.id = cmt.comment_userid 
				WHERE cmt.comment_modelid = 2 ';

		if($search['title'])
			$sql .= ' AND ((g.goodsname LIKE \'%'.$search['title'].'%\') OR  (mbr.username LIKE \'%'.$search['title'].'%\')) ';
		if($search['status'])
			$sql .= ' AND cmt.comment_status = \''.$search['status'].'\' ';
		if($search['is_reply'])
			$sql .= ' AND cmt.reply_isreply = \''.$search['is_reply'].'\' ';

		$sql .= ' ORDER BY comment_time DESC ';
		return $this -> getPageList(array('sql'=>$sql,'search'=>$search,'pagesize'=>20));
	}

	/**
	 * 获取一条评论
	 */
	function getOneComment ($id)
	{
		$info = $this -> find(array('comment_id'=>$id));
		if($info['comment_modelid'] == '2')
		{
			$res = $this -> query('SELECT g.goodsname AS title,m.username,c.* FROM `'.$this -> trueTableName.'` AS c LEFT JOIN `'.$this -> tablePrefix.'goods` AS g ON c.comment_infoid = g.goodsid LEFT JOIN `'.$this -> tablePrefix.'member` AS m ON m.id = c.comment_userid WHERE c.comment_id = '.$id.'');
		}
		else
		{
			 $res = $this -> query('SELECT a.title,m.username,c.* FROM `'.$this -> trueTableName.'` AS c LEFT JOIN `'.$this -> tablePrefix.'maintable` AS a ON c.comment_infoid = a.id LEFT JOIN `'.$this -> tablePrefix.'member` AS m ON m.id = c.comment_userid WHERE c.comment_id = '.$id.'');
		}
		 return isset($res[0]) ? $res[0] : array();
	}

	/**
     * 获取上一条文章 下一条文章
     * @return array()
     */
	public function getLastAndNextComment ($id)
	{
		$info = $this -> find(array('comment_id'=>$id));
		
		$from1 = ' `'.$this -> trueTableName.'` AS cmt 
				LEFT JOIN `'.$this -> tablePrefix.'maintable` AS m 
				ON cmt.comment_infoid = m.id  
				LEFT JOIN `'.$this -> tablePrefix.'member` AS mbr 
				ON mbr.id = cmt.comment_userid ';
				
		$from2 = '	`'.$this -> trueTableName.'` AS cmt 
				LEFT JOIN `'.$this -> tablePrefix.'goods` AS g 
				ON cmt.comment_infoid = g.goodsid  
				LEFT JOIN `'.$this -> tablePrefix.'member` AS mbr 
				ON mbr.id = cmt.comment_userid ';
		
		
		$search = isset($_SESSION['search'])?$_SESSION['search']:array('title'=>'','status'=>0,'is_reply'=>0);//查询条件
		
		$condition1 = '';//查询条件语句
		if($search['title'])//主题关键字
			$condition1 .= ' AND ((m.title LIKE \'%'.$search['title'].'%\') OR  (mbr.username LIKE \'%'.$search['title'].'%\')) ';
		if($search['status'])//审核状态
			$condition1 .= ' AND cmt.comment_status = \''.$search['status'].'\' ';
		if($search['is_reply'])//回复状态
			$condition1 .= ' AND cmt.reply_isreply = \''.$search['is_reply'].'\' ';
		
		$search2 = isset($_SESSION['search1'])?$_SESSION['search1']:array('title'=>'','status'=>0,'is_reply'=>0);//查询条件
		$condition2 = '';//查询条件语句
		if($search2['title'])//主题关键字
			$condition2 .= ' AND ((g.goodsname LIKE \'%'.$search2['title'].'%\') OR  (mbr.username LIKE \'%'.$search2['title'].'%\')) ';
		if($search2['status'])//审核状态
			$condition2 .= ' AND cmt.comment_status = \''.$search2['status'].'\' ';
		if($search2['is_reply'])//回复状态
			$condition2 .= ' AND cmt.reply_isreply = \''.$search2['is_reply'].'\' ';
		
		if($info['comment_modelid'] == '2')
		{
			$sql ='SELECT max(cmt.`comment_id`) AS `id` 
				   FROM ' . $from2 . ' 
				   WHERE cmt.comment_id < '.$id.'  AND cmt.comment_modelid = 2 ' . $condition2 . '
				   UNION SELECT min(cmt.`comment_id`) AS `id` 
				   FROM ' . $from2 . '
				   WHERE cmt.`comment_id` > '.$id.'  AND cmt.comment_modelid = 2 ' . $condition2;
		}
		else
		{
			$sql ='SELECT max(cmt.`comment_id`) AS `id` 
				   FROM ' . $from1 . '
				   WHERE cmt.`comment_id` < '.$id.' AND cmt.comment_modelid = 1 ' .  $condition1 . '
				   UNION SELECT min(cmt.`comment_id`) AS `id` 
				   FROM ' . $from1 . '
				   WHERE cmt.`comment_id` > '.$id.'  AND cmt.comment_modelid = 1 ' . $condition1;
		}
		
		$tmp = array();
		$ids = $this -> query($sql);
		foreach ($ids as $key => $val )
		{
			if($val['id'])
				$tmp[] = $val['id'];
		}
		$num = count($tmp);
		if($num == 2)
		{
			$r[0] = array('text'=>'上一条','id'=>$tmp[0]);
			$r[1] = array('text'=>'下一条','id'=>$tmp[1]);
		}
		else if($num == 1)
		{
			if($tmp[0] > $id)//点的第一条
			{
				$r[0] = array('text'=>'<font color="#cccccc">上一条</font>','id'=>0);
				$r[1] = array('text'=>'下一条','id'=>$tmp[0]);
			}
			else
			{
				$r[0] = array('text'=>'上一条','id'=>$tmp[0]);
				$r[1] = array('text'=>'<font color="#cccccc">下一条</font>','id'=>0);
			}
		}
		else
		{
			$r[0] = array('text'=>'<font color="#cccccc">上一条</font>','id'=>0);
			$r[1] = array('text'=>'<font color="#cccccc">下一条</font>','id'=>0);
		}
		return $r;
	}

	/**
	 * 获取评论总数
	 * @param array $condition 条件
	 * @author wr 2013.3.19
	 */
	public function getCount($condition=array())
	{
		return $this->findCount($condition);
	}
}