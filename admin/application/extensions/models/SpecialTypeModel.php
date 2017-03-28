<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialTypeModel
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013/9/3
 * @filename   SpecialTypeModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialTypeModel extends Model
{
    public $pk = "id";
	public $tableName="special_type";

	/**
	 * 获取专题分类目录结构
	 */
	public function getSpecialAssort($pid=0, $t=-1)
	{
		$t++;
		static $sort_temp;
		$data = $this -> findAll(array('pid'=>$pid),'ordernum ASC,id ASC,created DESC','id,pid,type_name,isdefault,ordernum');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				$val['type_name'] = str_repeat('&nbsp;',$t*3).'├'.$val['type_name'];
				$val['level'] = $t+1;
				$sort_temp[] = $val;
				$this -> getSpecialAssort($val['id'], $t);
			}
		}
		return $sort_temp;
	}

	/**
	 * 遍历各级关系
	 */
	public function countChildNode($array)
	{
		$t1 = $array;
		foreach ($t1 as $key1 => $val1 )
		{
			$t3 = array_slice($t1,$key1+1);
			foreach ($t3 as $key3 => $val3 )
			{
				if(($val1['level'] == $val3['level']) || ($val1['level'] > $val3['level']) )
					break;
				else
					$t1[$key1]['child_id'][] = $val3['id'];
			}
			isset($t1[$key1]['child_id']) ? ($t1[$key1]['child_count'] = count($t1[$key1]['child_id'])) : ($t1[$key1]['child_count'] = 0);

			$t1[$key1]['type_name'] = ltrim(substr($t1[$key1]['type_name'],strpos($t1[$key1]['type_name'],'├')),'├');
			$t1[$key1]['margin_left'] = 35*($t1[$key1]['level']-1);
			$t1[$key1]['class'] = $t1[$key1]['pid'] ? 'level2' : 'level1';
			$t1[$key1]['flag'] = $t1[$key1]['child_count'] ? 'clos' : (!$t1[$key1]['pid'] ? 'open' : 'no');
			$t1[$key1]['show_hide'] = !$t1[$key1]['pid'] ? 'true' : 'none';
		}
		return $t1;
	}

	/**
	 * 判断分类是否关联专题
	 */
    public function aboutSpecial($id)
    {
        $sql = "SELECT id FROM ". $this->tablePrefix."special WHERE type_id = '$id'";
        $result = $this->query($sql);
        if($result) {
            return true;
        }
    }

	/**
	 * 获取子id
	 * @param int $parentid
	 * @return array()
	 */
	public function getChildidByPid($pid)
	{
		$id_arr = $this -> getSpecialAssort($pid);
		$tmp = array();
		if(!$id_arr)
			return $tmp;
		foreach ($id_arr as $key => $val)
		{
			$tmp[] = $val['id'];
		}
		return $tmp;
	}


}
