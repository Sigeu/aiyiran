<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 负责专题模块的制作
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013/9/3
 * @filename   SpecialModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "special";//表名

	/**
	 * 获取所有专题信息列表
	 */

	public function getSpecialIdList()
	{
		$data = $this->findAll(null,null,'id,name,created');

		if(!empty($data)) {
			return $data;
		}
		else {
			return false;
		}
	}

    public function getArticleIdsByCategory($id)
    {
        $sql = "SELECT id FROM ". $this->tablePrefix ."maintable WHERE categoryid = $id ";

        $result = $this->query($sql); ///
        $arr = array();
		foreach ($result AS $key => $val)
		{
			$arr[] = $val['id'];
		}

        return implode(",", $arr);
    }

    public function getArticleIdsByTitle($keyword)
    {
        $sql = "SELECT id FROM ". $this->tablePrefix ."maintable WHERE title like '%{$keyword}%'";
        $result = $this->query($sql);
        $arr = array();
		foreach ($result AS $key => $val){
			$arr[] = $val['id'];
		}
        return implode(",", $arr);
    }


	/**
	 * 获取此角色的所有权限
	 */
	public function getPer($type)
	{
		$roleid = $_SESSION['roleid'];
		$result = M('special_manager')->field('specialid')->where(array('roleid'=>$roleid,'permissionid'=>$type))->select();
		$tem = array();
		if(!empty($result))
		{
			foreach($result as $key=>$value)
			{
				$tem[] = $value['specialid'];
			}
		}
		return $tem;
	}

    /**
     * 复制专题时 创建相应的版块、节点
     * $oldid  被复制专题ID
     * $newid  新专题ID
     */
    public function copySpecial($oldid, $newid)
    {
        $source_section = M('special_section')->where(array('sid'=>$oldid))->select();  //旧版块
        foreach($source_section as $k2=>$v2)
        {
            $base = array('sid'=>$newid,'sortby'=>$v2['sortby'],'section_type'=>$v2['section_type']);
            $insert_id = M('special_section')->create($base);
            $source_assort = M('special_assort')->where(array('secid'=>$v2['id']))->select();  //旧节点
            foreach($source_assort as $k3=>$v3)
            {
                $param = array('secid'=>$insert_id,'assort_name'=>$v3['assort_name'],'is_show'=>$v3['is_show'],'change_type'=>$v3['change_type'],'category_id'=>$v3['category_id'],'keywords'=>$v3['keywords'],'idlist'=>$v3['idlist'],'number'=>$v3['number'],'order_style'=>$v3['order_style'],'order_type'=>$v3['order_type'],'is_banner'=>$v3['is_banner'],'banner'=>$v3['banner'],'img_hei'=>$v3['img_hei'],'img_wid'=>$v3['img_wid'],'title_number'=>$v3['title_number'],'brief_number'=>$v3['brief_number']);
                M('special_assort')->create($param);
            }
        }

    }




}
