<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentModel.php
 *
 * 内容管理模型类
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-5 下午2:44:04
 * @filename   ContentModel.php  UTF-8
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
	public $pk = "id";//主键
	public $tableName = "maintable";//表名

	/**
	获取主表内容
	 */
	public function getContentListOnlyMain($search=array(),$count=true)
	{
		$sql = 'SELECT
		m.`id` ,
		m.`title` ,
	    m.`hits` ,
		m.`updatetime` ,
		m.`publishuser`,
		m.sortnum,
		c.`catname`,
		c.`id` as cid,
		c.`model`,
		d.`name` as modelname
		FROM `'.$this -> tablePrefix.'maintable` AS m
		LEFT JOIN `'.$this -> tablePrefix.'category` AS c ON m.`categoryid` = c.`id`
		LEFT JOIN `'.$this -> tablePrefix.'model` AS d ON d.`id` = c.`model`';
		$sql.='WHERE 1 ';
		//$sql .= $this -> getOtherWhere();
		if($search['modelid'])	$sql  .= ' AND c.`model` = '.$search['modelid'].' ';
		if($search['keywords'])	$sql  .= ' AND (m.`title` LIKE \'%'.$search['keywords'].'%\' or c.`catname` LIKE \'%'.$search['keywords'].'%\' or m.`publishuser` LIKE \'%'.$search['keywords'].'%\' ) ';
		if($search['categoryid']){$cid=getCategoryIds($search['categoryid'],true); $sql .= ' AND m.`categoryid` in( '.implode(',',$cid).') ';}
		if($search['order']) $sql .= '  ORDER BY m.`sorttype`-NOW()>0 desc,m.`sortnum` ASC,m.`'.$search['order'].'`';
		if($search['desc'] == 1) $sql  .= ' DESC';
		if($count)
		{
			return count($this->query($sql));
		}
		else
		{
			if($search['limit']) $sql  .= ' LIMIT '.$search['limit'].' ';
			return $this->query($sql);
		}
	}

	//过滤掉文章模型和商品模型
	function getOtherWhere ()
	{
		$where = '';
		if(isset($_GET['addparameter']) && $_GET['addparameter']=='other')
		{
			$where = ' AND (d.id !=1 ) AND (d.id != 2) ';
		}
		return $where;
	}
	/**
	 获取全部内容
	 */
	public function getContent($options=array(),$modelid)
	{
		$tablename = $this->getTable($modelid);
		$sql = 'SELECT
		m.`id` as id,a.`id` as fid,m.* ,a.*
		FROM `'.$this -> tablePrefix.'maintable` AS m
		LEFT JOIN `'.$this -> tablePrefix.$tablename.'` AS a ON a.`maintable_id` = m.`id`
		WHERE m.`id` = ' .$options['id'] ;
		$result = $this->query($sql);
		return $result[0];
	}
	/**
	 * 获取此角色的所有权限
	 */
	function getPer($type)
	{
		$roleid = $_SESSION['roleid'];
		$result = M('manager_cate_per')->field('categoryid')->where(array('roleid'=>$roleid,'permissionid'=>$type))->select();
		$tem = array();
		if(!empty($result))
		{
			foreach($result as $key=>$value)
			{
				$tem[] = $value['categoryid'];
			}
		}
		return $tem;
	}

	/**
	 * 添加和修改时获取的分类树
	 * @param int $parentid
	 * @param int $t
	 * @return array()
	 */
	public function getCategoryTree($modelid=0,$pid=0,$t=-1)
	{
		$condtion = array('pid'=>$pid);
		$t++;
		static $cat_temp=array();
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','model,id,pid,columnattr,catname');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				  $val['catname'] = str_repeat('&nbsp;',$t*3).'├'.$val['catname'];
				  $val['level'] = $t+1;
				  $cat_temp[] = $val;
				$this -> getCategoryTree($modelid,$val['id'],$t);
			}
		}
		foreach($cat_temp as $k=>$v)
		{
			if(($modelid&&$v['model']!=$modelid)||$v['model']==2)
			{
				$cat_temp[$k]['flag']=false;
			}
			else
			{
				$cat_temp[$k]['flag']=true;
			}
		}
		return $cat_temp;

	}
	/**
	 * 获取指定模型下面的栏目列表
	 */
	public function getCategoryList($modelid)
	{
		if($modelid)
		{
			$result = M('category')->field('catname,id')->where(array('model'=>$modelid))->select();
		}
		else
		{
			$result = array();
		}
		return $result;
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
		}
		return $result['tablename'];
	}
	/**
	 * 获取指定模型下面的附表
	 */
	public function getCatename($cid)
	{
		if(is_array($cid))
		{
			$cstr = implode($cid,',');
			$result = M('category')->field('catname,id')->where(array('in'=>array('id'=>$cstr)))->select();
		}
		else
		{
			$result = M('category')->field('catname,id')->where(array('id'=>$cid))->select();
		}
		foreach($result as $key=>$value)
		{
			$tem[] = $value['catname'];
		}
		return $tem;
     }
     /**
      * 通过栏目ID获取模型ID
      */
     public function getMidByCid($cid)
     {
     	if(is_array($cid))
     	{
     		$cstr = implode($cid,',');
     		$result = M('category')->field('model,id')->where(array('in'=>array('id'=>$cstr)))->select();
     	}
     	else
     	{
     		$result = M('category')->field('model,id')->where(array('id'=>$cid))->select();
     	}
     	foreach($result as $key=>$value)
     	{
     		$tem[] = $value['model'];
     	}
     	return $tem;
     }

     /**
      * 获取指定模型信息
      */
     public function getModelList($modelid = 0)
     {
     	$options = array('flag'=>1);
     	if($modelid)
     	{
     		$options['id'] = $modelid;
     	}
     	$result = M('model')->where($options)->select();
     	return $result;
     }

     /**
      * 获取所有信息数量
      * @author wr 2013.3.18
      */
     public function getCount($condition=array())
     {
     	return $this->findCount($condition);
     }

	/**
	 * 批量更新文章排序
	 * @param 一维排序信息 键是
	 * @return null
	 */
	function updateOrder ($orderinfo)
	{
		foreach ($orderinfo as $key => $val )
		{
			$this -> update(array('id'=>$key),array('sortnum'=>$val));
		}
	}
}