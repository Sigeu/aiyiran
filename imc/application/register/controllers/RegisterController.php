<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>申静  2013-3-19 下午2:17:25 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-3-19 下午2:17:25

 * @filename   RegisterController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: RegisterController.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class RegisterController extends AdminController
{
	private $objRegist;
	public function init()
	{
		$this->objRegist = M('WebConfig');
		parent::islogin_imc();
		parent::init();
	}
	/**
	 * 注册设置
	 */
   public function indexAction(){
   	 $set = $this->objRegist->select(array('where'=>array('group_id'=>12)));
   	 $result = array();
 
   	 foreach ( $set as $sk=>$sv ) {
   	 	
   	 	$result[$sv['par_name']] = $sv['par_value'];
   	 }

   	 $this -> assign('set',$result);
   	 $this -> display('register/regist_set.html');
   }
   /**
    * 保存设置信息
    */
   public function saveSetAction(){
   	 $id = $this->getIds('id');
   	 $modelObj = M("WebConfig");
   	 $arr =array(
   	 		'mo_forbidname' => $this->getParams('forbidname'),
   	 		'mo_forbidemail' => $this->getParams('forbidemail'),
   	 		'mo_allowemail' => $this->getParams('allowemail'),
   	 		'mo_forbidip' => $this->getParams('forbidip'),
   	 		'mo_allowip' => $this->getParams('allowip'),
   	 		'mo_flag' => $this->getParams('flag'),
   	 		);

     //更新服务器设置
     foreach($arr as $mk=>$mv){	

        $modelObj->update(array('par_name'=>$mk,'group_id'=>12), array('par_value'=>$mv));
     }
   	 	
   	 imc_log('注册设置','修改注册设置');
   	 $this->dialog("/register/register/index");
   }
}