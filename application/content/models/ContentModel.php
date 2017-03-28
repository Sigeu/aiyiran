<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CategoryModel.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
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
class ContentModel extends Model
{
	public $tableName = 'maintable';

	/**
	 * @param int $id 内容ID
	 * @return string 返回值
	 */
	public function  getModelId($id)
	{
		$result = $this->where(array($this->tablePrefix.'maintable.id'=>$id))
			           ->join($this->tablePrefix.'category as category on category.id = '.$this->tablePrefix.'maintable.categoryid')
			           ->field('categoryid,model')
			           ->getOne();
		return $result['model'];
	}

	/**
	 * 获取指定模型下面的附表
	 */
	public function getTable($modelid)
	{
		if($modelid)
		{
			$result = M('model')->field('tablename,id')->where(array('id'=>$modelid))->getOne();
		}
		else
		{
			$result = array();
			return '';
		}
		return $result['tablename'];
	}

	/**
	 获取全部内容
	 */
	public function getContent($options=array(),$modelid,$type='=')
	{
		$tablename = $this->getTable($modelid);
		$someCatsql = '';
		if(isset($options['cid']))
		{
			$someCatsql = '  AND categoryid='.$options['cid'];
		}
		if($type=='>')
		{
			$order = ' ORDER BY m.publishtime,m.id ';
		}
		elseif($type=='<')
		{
			$order = ' ORDER BY m.publishtime desc,m.id desc ';
		}
		else
		{
			$order = ' ';
		}
		$sql = 'SELECT
		m.* ,a.*, m.id as maintable_id
		FROM  '.$this -> tablePrefix.'maintable AS m
		LEFT JOIN '. $this -> tablePrefix.$tablename.' AS a ON a.`maintable_id` = m.`id`
		WHERE m.`id`  '.$type .$options['id'] .$someCatsql.$order.' limit 0,1';
		$result = $this->query($sql);
		return $result;
	}
	/**
	获取当前文章的相关评论
	**/

	public function getComment($option=array())
	{
		$comment = M('art_comment')->where($option)->select();
		foreach($comment as $key=>$value)
		{
			$comment[$key]['username'] = uid2name($value['userid']);
			$comment[$key]['replyer'] = uid2name($value['replyerid']);

		}
		return $comment;
	}


	/**
	 * 会员栏目权限ID
	 * @param int or array() $cateid
	 * @return array()
	 * 返回一个三维数组 ，第一维数组的键是栏目ID，第二维数组的键是会员分组ID，第三维数组的值具体的操作权限
	 *	Array
	 *	(
	 *		[1] => Array
	 *		(
	 *			[1] => Array
	 *			(
	 *				[0] => 1
 	 *				[1] => 2
	 *			)
	 *
	 */
	public function getMemberCatePerModel($cateid,$roleid,$type)
	{
		if(!$roleid)
		{
			return false;
		}
		else
		{
		    $result = array();
			$condtion[1] = 1;
			if($cateid) $condtion['categoryid'] = $cateid;
			if($roleid) $condtion['roleid'] = $roleid;
			if($cateid) $condtion['permissionid'] = $type;
		    $tmp = array();
			if(!$cateid)
			$result = M('member_cate_per')->where($condtion)->select();
			if(!empty($result))
			{
				return true;
			}
			else
			{
				return false;
			}

		}

	}

	public function updateHits($id)
	{
		$sql = 'UPDATE '.$this->tablePrefix.'maintable set `hits`=`hits`+1 where id='.$id;
		$this->query($sql);
	}

	/*
	
	public function selectTag($id)
	{
		//$condition['key_id'] = $id;
		//$result = M('SeoTag')->find($condition,'','id');
		$where['in'] = array( 'key_id' => $id );
		$result = M('SeoTag') -> where($where) -> field('id')->select();
		print_r($result);
		return $result;
	}
	*/

	/**
	 * 搜索文章
	 * @param 关键字
	 * @return 文章信息
	 */
	function searchArticleByKeywords ($_param)
	{
		$keywords = isset($_param['keywords']) ? $_param['keywords'] : '';
		$cid      = isset($_param['cid'])      ? $_param['cid']      : 0;
		$pageSize  = isset($_param['pageSize']) ? $_param['pageSize']    : 20;
		$startCount  = isset($_param['startCount']) ? $_param['startCount'] : 0;
		if(empty($keywords))
		{
			return array();
		}
		 
		$sql = 'select id,categoryid,title,subtitle,description,publishtime,hits,created,publishopt  from '.$this->tablePrefix.'maintable where ';
		$sql .= 'title like "%'.$keywords.'%"'; 
		if($cid) $sql .= ' AND (categoryid in ('.$cid.'))';
		$sql .= ' LIMIT '. $startCount.','.$pageSize;     
		return $this -> query($sql);
    }
}