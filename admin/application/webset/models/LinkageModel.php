<?php
/**
*  -------------------------------------------------
*    LinkageModel.php
*
*    系统设置model
*
*   @author		 : huanglike  2012-6-26 11:44:28
*   @version     : 1.0
*   @copyright	 : Copyright (c) 2004-2012 MainOne Technologies Inc. (http://www.b2b.cn)
*  -------------------------------------------------
*/
class LinkageModel extends Model
{
    public $pk = "linkageid";
    public $tableName = 'linkage';

    /* 插入菜单 */
    public function insertLinkage($style,$name,$global,$descri){
        $sql = "INSERT INTO ". $this->trueTableName ."(style,`name`,isglobal,description) VALUES ('$style','$name','$global','$descri')";
        $this->query($sql);
    }

    public function isGlobalBill($ids)
    {
        $sql = "SELECT isglobal FROM ". $this->trueTableName. " WHERE linkageid IN ($ids)";
        $this->query("DELETE FROM ". $this->trueTableName. " WHERE isglobal = 0 AND linkageid IN ($ids)");
        $result = $this->query($sql);
        if(!empty($result))
        {
            foreach ($result AS $val){
                $arr[] = $val['isglobal'];
            }
            if (in_array(1, $arr)) {
                return true;
            }
        }
    }

    /* 更新 */
    public function updateLinkage($name,$global,$descri,$id) {
        $sql = "UPDATE ". $this->trueTableName ." SET `name`='$name',isglobal='$global',description='$descri' WHERE linkageid = '$id'";
        $this->query($sql);
    }

    /* 根据ID获取菜单 */
    public function getLinkageById($id) {
        $sql = "SELECT * FROM ". $this->trueTableName . " WHERE linkageid = ". $id;
        $result = $this->query($sql);
        foreach ($result AS $val){
            $arr = $val;
        }
        return $arr;
    }

    //获取级数
    public function getLevel($pid = 0, $t=-1, $id)
    {
		$t++;
		static $bill;
		static $_tmp1;
		static $_tmp2;
        $sql = "SELECT A.*, C.style AS lname FROM ". $this->tablePrefix ."linkage_bill AS A,". $this->tablePrefix ."linkage AS C WHERE A.lin_id = C.linkageid AND A.lin_id = ".$id." AND A.pid = ". $pid;
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
				$this -> getLevel($val['id'],$t,$id);
			}
       		return empty($_tmp2) ? 0 : max($_tmp2) - 1;
		}
		return 0;
    }




}