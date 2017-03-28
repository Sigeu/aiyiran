<?php
class MessageModel extends Model
{
    public $pk = "id";//主键
	public $tableName = "";//表名
	
	public function getAddInfo($modelid,$id){
		$sql = "SELECT * FROM ".$this->tablePrefix.'message_'.$modelid." WHERE model_id=".$id." LIMIT 0,1";

		$result = $this->query($sql);
		return $result[0];
	}
	/**
	 过滤敏感词
	 * @param string $content 内容
	 * @return string 返回值
	 */
	public function replacestr($content)
	{
		$replacestr = get_mo_config('mo_replacer');
		$type = get_mo_config('mo_replace_type');
		$str = get_mo_config('mo_replacestr');
		if($type==3)
		{
			;
		}
		elseif($type==2)
		{
				
			$repArr = explode(';',$str);
			foreach($repArr as $key=>$value)
			{
				$content = str_replace($value,'',$content);
			}
		}
		else
		{
			$repArr = explode(';',$str);
			foreach($repArr as $key=>$value)
			{
				$content = str_replace($value,$replacestr,$content);
			}
		}
		return $content;//允许提交
	}
	/**
	 *$modelid int //表单id
	 *$dataname  string //字段名
	 *$val string   //需要验证唯一的值
	 *$tem  string  //为空指的是编辑表单
	 *return int 1//唯一  2不唯一

	 */
	public function checkUnique($modelid,$dataname,$v,$tem){

         $sql = "SELECT * FROM `".$this->tablePrefix."member_".$modelid."` WHERE `".$dataname."` ='".$v."'";

         $result = $this->query($sql);

         if($tem != 'add' && $dataname !='email')
		{
			 if(count($result)<= 1) {

				 return 1;//数据唯 一
			 }else{
			 
				 return 2;//数据不唯一
			 }
	    }else{
		    
			if(empty($result)) {
			
			    return 1;
			}else{
			
			   return 2;
			}
		}
	}
}