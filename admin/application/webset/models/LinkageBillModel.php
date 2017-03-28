<?php
/**
*  -------------------------------------------------
*    LinkageBillModel.php
*
*    系统设置model
*
*   @author		 : huanglike  2012-6-26 11:44:28
*   @version     : 1.0
*   @copyright	 : Copyright (c) 2004-2012 MainOne Technologies Inc. (http://www.b2b.cn)
*  -------------------------------------------------
*/
class LinkageBillModel extends Model
{
    public $pk = "id";
    public $tableName = 'linkage_bill';

    public function getLinkageBill($pid = 0, $t=-1, $id)
	{
		$t++;
		static $bill;
		static $_tmp1;
		static $_tmp2;
        $sql = "SELECT A.*, C.style AS lname FROM ". $this->tablePrefix ."linkage_bill AS A,". $this->tablePrefix ."linkage AS C WHERE A.lin_id = C.linkageid AND A.lin_id = ".$id." AND A.pid = ". $pid . " ORDER BY ordernum ASC, A.id DESC";
        $data = $this->query($sql);

		if(!empty($data))
		{
			foreach ($data as $key => $val)
			{
				$level = $t+1;
				$_tmp1[] = $val['id'];//ID
				$_tmp2[] = $level;//级别深度

				$val['level'] = $level;
				$val['margin_left'] = max(($t-1)*35,0);
				$val['flag'] = 'open';
				$val['class'] = $val['pid'] ? 'level2' : 'level1';
				$bill[$val['id']] = $val;

				if(count($_tmp2) >1 && $val['pid'] != 0)
				{
					$end = end($_tmp2);//数组的组最后一个值  3
					$prev = prev($_tmp2);//上一个   3

					end($_tmp1);  //8
					$prev_id = prev($_tmp1);  //7

					$bill[$prev_id]['flag'] = $end == $prev ? 'no' : 'open';
				}
				$this -> getLinkageBill($val['id'],$t,$id);
			}
		}
		return $bill;
	}

    //判断子菜单是否为末级菜单
    public function includeBill($id)
    {
        $sql = "SELECT id FROM ". $this->tablePrefix ."linkage_bill WHERE pid = ". $id;
        $data = $this->query($sql);
        if(empty($data)) {
            $this->query("DELETE FROM ". $this->tablePrefix ."linkage_bill WHERE id = ". $id);
        }else{
            return true;
        }
    }
    //返回菜单子级菜单ID
    public function getChildren($id)
    {
        $result = $this->query("SELECT id FROM ". $this->tablePrefix ."linkage_bill WHERE pid = ". $id);
        foreach ($result AS $val){
            return $val['id'];
        }
    }

    //把能删的删除掉
    public function doFirst($arr)
    {
        foreach ($arr AS $val){
            $count = 0;
            $row = $this->query("SELECT id FROM ". $this->tablePrefix ."linkage_bill WHERE pid = ". $val);
            if(empty($row)) {
                $this->query("DELETE FROM ". $this->tablePrefix ."linkage_bill WHERE id = ". $val);
                $count ++;
            }
        }
        return $count;
    }



}