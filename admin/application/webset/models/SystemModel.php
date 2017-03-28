<?php
/**
*  -------------------------------------------------
*    SystemModel.php
*
*    系统设置model
*
*   @author		 : huanglike  2012-6-26 11:44:28
*   @version     : 1.0
*   @copyright	 : Copyright (c) 2004-2012 MainOne Technologies Inc. (http://www.b2b.cn)
*  -------------------------------------------------
*/
class SystemModel extends Model
{
    public $pk = "par_id";
    public $tableName = 'web_config';

    //获取系统各种变量参数
    public function getSystemParameterSet($group_id)
    {
        $sql = "SELECT par_name, par_value FROM ". $this->trueTableName ." WHERE group_id = ". $group_id;
        $result = $this->query($sql);
        foreach ($result AS $val){
            $parameter[$val['par_name']] = $val['par_value'];
		}
        return $parameter;
    }

    //系统配置修改
    public function updateParameter($parameter)
    {
        foreach ($parameter AS $key=> $val){
            $this->query('UPDATE '. $this->trueTableName .' SET par_value = "'. $val .'" WHERE par_name = "'. $key .'"');
        }
        return true;
    }

    //
    public function correctFilter($array)
    {
        if($this->updateParameter($array) === true) {
            echo 1;
        }else{
            echo 0;
        }
    }

    //安全设置
    public function getSafeSet() {

    }

	/**
	 * 通过key数组获取配置项
	 * @param $key array() 要获取哪些配置项 array('a','b','c')
	 * @$modle $key string 返回值模式，有两种模式 建议模式 PART ，完整模式 ALL
	 * @return array()
	 */
	function getConfigByKey ($key=array(),$modle='PART')
	{
		if(empty($key))
			$conf = $this -> findAll(array(),false);
		else
			$conf = $this -> findAll(array('in'=>array('par_name'=>'\''.implode('\',\'',$key).'\'')),false);

		$tmp = array();
		foreach ($conf as $key => $val ) $tmp[$val['par_name']] =  $val['par_value'];
		return ('PART' === $modle) ? $tmp : $conf;
	}
}