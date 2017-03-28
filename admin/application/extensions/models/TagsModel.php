<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * TagModel
 * 
 * @author     冯阳<fengyang@mail.b2b.cn>   2013/9/3
 * @filename   TagModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class TagsModel extends Model
{

	public $pk = "id";
	public $tableName="seo_tag";

	
	/**
	 * 添加关键词Tag标签接口
	 * 添加文章、商品、专题时调用
	 * @param  $modelid   模型id
	 * @param  $infoid    信息id
	 * @param  $tagname   tag标签 
	 */
	
	public function addTags($modelid=1,$infoid,$tagname)
	{
		if (!empty($tagname))
		{
			$tagname_arr =array_filter(explode(',',str_replace('，', ',', $tagname)));
			foreach ($tagname_arr as $row)
			{
				$taginfo = $this->find(array('sign_id'=>$modelid,'tag_name'=>$row));
				if ($taginfo)
				{
					//往tag_info 标签-信息id对照表插入数据
						$this->addTagInfo(array('sign_id'=>$modelid,'info_id'=>$infoid,'tag_id'=>$taginfo['id']));
				}else 
				{
					//往seo_tag表中插入数据
					 $param = array(
						'sign_id'   => $modelid,
						'tag_name'  => $row,
						'tag_click' => 0,
						'tag_times' => time(),
				 );
					$tagid = $this->create($param);
					//往tag_info 标签-信息id对照表插入数据
						$this->addTagInfo(array('sign_id'=>$modelid,'info_id'=>$infoid,'tag_id'=>$tagid));
					
				}
			}
		}
	}
	
	
	/**
	 * 修改文章、商品、专题时，调用的tag标签接口
	 * @param  $modelid      模型id
	 * @param  $infoid       信息id
	 * @param  $tagname      关键词（新）
	 */
	public function updateTags($modelid,$infoid,$tagname)
	{
		//获取信息id对应的原来的tagid
		$res_tagid = $this->getTageInfoModel()->field("tag_id")->where(array('sign_id' => $modelid,'info_id'=>$infoid))->select();

		//删除信息id对应的tagid记录
		$this->getTageInfoModel()->delete(array('sign_id' => $modelid,'info_id' => $infoid));
		//插入新的tag标签
		if (!empty($tagname))
		{
			$this->addTags($modelid,$infoid, $tagname);
		}
		
		//删除没有对应信息的tag信息
		if ($res_tagid)
		{
			foreach ($res_tagid as $row)
			{
				$count = $this->getTageInfoModel()->findCount(array('tag_id'=>$row['tag_id']));
				if ($count==0)
				{
					$this->delete(array('id'=>$row['tag_id']));
				}
			}
		}
		
	}
	
	
	/**
	 * 
	 * 删除文章、商品、专题时调用
	 * @param  $modelid   模型id
	 * @param  $infoid    信息id(可能是多条数据)
	 */
	public function deleteTags($modelid=1,$infoid='')
	{
		$infoids = array_filter(explode(',', $infoid));
		foreach ($infoids as $id)
		{
			//获取信息id对应的tagid
			$res_tagid = $this->getTageInfoModel()->field("tag_id")->where(array('info_id'=>$id))->select();
			//删除信息id对应的tagid记录
			$this->getTageInfoModel()->delete(array('sign_id' => $modelid,'info_id' => $id));
			//删除没有对应信息的tag信息
			if ($res_tagid)
			{
				foreach ($res_tagid as $row)
				{
					$count = $this->getTageInfoModel()->findCount(array('tag_id'=>$row['tag_id']));
					if ($count==0)
					{
						$this->delete(array('id'=>$row['tag_id']));
					}
				}
			}
		}
	}
	
	
	/**
	 * 
	 * 统计Tag标签文档数
	 * @param  $infoid    信息id
	 */
	public function countTags($infoid)
	{
		$sql = 'SELECT COUNT(info_id) as counts FROM '.$this->tablePrefix.'tag_info WHERE tag_id = '.$infoid; 
		return $this -> query($sql);
	}
	
	
	private function getTageInfoModel()
	{
		return M("TagInfo");
	}

	/**
	 * 向tag_info表中插入infoid--tagid 的对应关系
	 * @param array $param
	 */
	public function addTagInfo($param)
	{
		if ($param['tag_id'])
		{
			$info_tag = $this->getTageInfoModel()->find($param);
			if (!$info_tag)
			{
				$this->getTageInfoModel()->create($param);
			}
		}
	}
	
}
