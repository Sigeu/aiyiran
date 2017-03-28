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

class iarticlelist extends BaseTag
{
	public  $defaultParam = array(
		'size'     => '10',     //每页多少条
		'pagevar'  => 'page',   //page变量标示符
		'showpage' => '10',     //显示多少个页码
		'cid'      => '0',      //栏目ID
		'type'     => '',       //类型son(子集栏目)  ''(本身栏目)  all(本身加子集栏目)
		'return'   => 'data',   //数据返回接收变量
		'order'    => '',       //排序
		'thumb'    => 'false',  //是否调取缩略图
	);

	/**
	 * 调取文章列表
	 * @param
	 * @return
	 */
	function lib_iarticlelist($datas)
	{
		$param    = $this -> mergeDefaultParam($datas);         //合并过滤参数
		if(!$param['cid'])
			return array();

		$cids = $this -> getCidByType($param['type'],$param['cid']);
		$base_sql = $this -> getBaseSqlByParam($param,$cids);//获取不带limit的基本sql
		$count = count($this -> query($base_sql));
		$page = new MoPage(array(
			'counts'=>$count,
			'page_size'=>$param['size'],
			'page_flag'=>$param['pagevar'],
			'showpage' =>$param['showpage']
		));
		$sql = $base_sql.$page->getLimit();
		$res = $this -> query($sql);

		$p_info = $page->getPageInfo();
		if(!empty($res))
		{
			$res = $this -> formateExtInfo($res,$param['cid']);
			$page_url = $this -> foreachPageUrl($param['cid'],$page);
			$p_info['url'] = $page_url;
		}

		//格式化缩略图
		if($param['thumb'] = 'true')
		{
			foreach ($res as $key => $val )
			{
				!empty($res[$key]['thumb']) && ($thumb_tmp = json_decode($res[$key]['thumb']));
				$obj = $data[0]['thumb'];
				$res[$key]['thumb'] = $this -> obj2Array($thumb_tmp);
			}
		}

		//格式化url
		$res = $this -> formateUrl($res);

		return array($param['return']=>$res,'page'=>$p_info);
	}

	function formateUrl ($data)
	{
		foreach ($data as $key => $value )
		{
			$data[$key]['curl'] = getCategoryUrl($value['cid'], $value['filepath'], $value['columnoption'],'category/Category/list', 'contetnlist_$id_1.html');
			$data[$key]['url'] = getArticleUrl($value['id'], $value['filepath'], $value['publishopt'],'content/Content/index' ,'content_$id_1.html',$value['created']);
		}
		return $data;
	}

	/**
	 * 格式化对象到数组
	 * @param
	 * @return
	 */
	function obj2Array($obj)
	{
		$ret = array();
		foreach($obj as $key =>$value)
		{
			if(gettype($value) == 'array' || gettype($value) == 'object')
			{
				$ret[$key] = $this -> obj2Array($value);
			}
			else
			{
				$ret[$key] = $value;
			}
		}
		return $ret;
	}

	/**
	 * 格式化分页url
	 * @param 信息
	 * @param 分页信息
	 * @return
	 */
	function foreachPageUrl ($cid,$page)
	{
		$category = $this -> getCategoryById($cid,'filepath,columnoption');
		$pages = $page->getShowsPage();
		$page_flag = $page->getPageFlag();
		$url = array();
		foreach ($pages as $key => $val )
		{
			$url[$key] = getCategoryUrl($cid,$category['filepath'],$category['columnoption']).'/'.$page_flag.'/'.$val;
		}
		return $url;
	}

	/**
	 * 格式化扩展表信息
	 * @param
	 * @return
	 */
	function formateExtInfo ($info,$cid)
	{
		$category = $this -> getCategoryById($cid,'model');
		$_model = $this -> getModelById($category['model'],'tablename');
		if(empty($_model)) return $info;
		$table_name = $_model['tablename'];

		$tmp_id = array();
		foreach ($info as $key => $val)
		{
			$tmp_id[] = $val['id'];
		}

		$ext_info = $this -> getBatchExtTableInfo($table_name,$tmp_id);
		foreach ($info as $key => $val )
		{
			if(isset($ext_info[$val['id']]))
			{
				$ext_info_tmp = $ext_info[$val['id']];
				unset($ext_info_tmp['id']);
				$info[$key] = array_merge($info[$key],$ext_info_tmp);
			}
		}
		return $info;
	}

	/**
	 * 获取不带limit的基础sql
	 * @param  标签条件
	 * @param  栏目ID集合
	 * @return
	 */
	private function getBaseSqlByParam ($param,$cids)
	{
		$sql = 'SELECT * FROM `'.$this->tablePrefix.'maintable` WHERE `categoryid` IN ('.implode(',',$cids).')';

		$sql .= ' ORDER BY `updatetime` DESC ';
		if($param['order'])
		{
			$sql .= ','.$param['order'];
		}
		return $sql;
	}

	/**
	 * 通过标签type和cid获取cid数组集合
	 * @param
	 * @return
	 */
	private function getCidByType ($type,$cid)
	{
		switch ($type)
		{
			case 'son':
				$ids = $this -> getChildCategoryIds($cid);
				break;
			case 'all':
				$ids = $this -> getChildCategoryIds($cid);
				$ids[] = $cid;
				break;
			default:
				$ids[] = $cid;
		}
		return $ids;
	}
}