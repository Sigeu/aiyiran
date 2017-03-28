<?php
class CheckregistController extends AdminController{

	private $objIMCMember;
	private $objIMCApp;
    public function init()
	{
		include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");		
		$this->objIMCMember = M('ImcUsers');
    	$this->objIMCApp    = M("ImcApp");
		//parent::islogin_imc();
		parent::init();
	}

	//获取用用户名设置，检测当前用户名是否可用
	public function checkNameAction() {
		
		$username = $this->getParams('username');
		
		$reg = $this->checkFobrbid();
		$forbid = preg_match('/^('.$reg.')$/ui',$username);

		if ($forbid == 1) {
			echo 2; //用户禁用exit;
			exit;
		}
		
		$rs = $this->checkName($username);

		if ($rs == 1) {
			
			echo 1;//唯 一
		}else{
			
			echo 2; //用户已经存在
		}
		
	   
	}
	/**
	 * 检查用户名是否被禁止
	 */
	public function checkFobrbid() {
		
		$set = $this->getSet();//注册设置信息

		$str = str_replace(',',"|",$set['mo_forbidname']);

		$j = 0;
		$reg = '';
		for ( $i = 0; $i < strlen($str); $i++) {
			
			if($str[$i] == "*" && $j == 0) {
	
				$reg .= '[\x{4e00}-\x{9fa5}a-zA-Z]{';
				$j++;
			}
			
			if($str[$i] == "*" && $j != 0) {
				
				if (@$str[$i+1] != "*") {
					
					$reg .= $j ."}";
				}else{
					
					$j++;
				}
			}
			
			if ($str[$i] != "*") {
				
				$reg .= $str[$i];
				$j = 0;
			}
		}

		return $reg;
	}
	/**
	 * 检查用户邮箱是否被使用
	 */
	public function checkEmailAction() {
		
		$email = $this->getParams('email');
		$set = $this->getSet();//注册设置信息

		$forbidEmail = explode("\r",$set['mo_forbidemail']);
		$isnull = in_array(substr($email,strpos($email,"@")),$forbidEmail);
		
		if ($isnull) {
			
			echo 2;//被禁止
			exit;
		}
		if ($set['mo_flag'] == 2) 
		{
			
		  $user = $this->objIMCMember->select(array('where'=>array('email'=>$email)));
		  
		} else {
			
			echo 1;//没有被使用
			exit;
		}
		
		if (empty($user)) {
			
			echo 1;//没有使用
			exit;
		} else {
			
			echo 2;//已被使用
			exit;
		}
	}
	/**
	 * 检查用用户名是否唯 一
	 * @param string $name
	 * @return 1//唯 一 2//用户已存在
	 */
	public function checkName($name) {
		
		$user = $this->objIMCMember->select(array('where'=>array('username'=>$name)));

		if (empty($user)) {
			
			return 1;  //唯 一 
		}else {
			
			return 2; //用户已存在
		}
	}
	/*
	 * return $result array   关于注册信息的注册设置
	*/
	public function getSet() {

		$result = array();
		$configObj = M("WebConfig");

		$arr = $configObj->select(array('where'=>array('group_id'=>12)));
	
		foreach ($arr as $ak=>$av) {

			$result[$av['par_name']] = $av['par_value'];
		}

		return $result;
	}
}