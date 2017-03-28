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
 * <br>申静  2013-1-7 上午11:10:35 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-1-7 上午11:10:35

 * @filename   MailModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: MailModel.php 13 2013-08-09 07:44:39Z zhoulifeng $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class MailModel extends Model
{
	public $pk = "id";
	public $tableName = "mailstate";
	
	/*根据条件搜索邮件信息*/
	function getMails($options=array(),$type){
		
		$str = " state = ".$type;
		
		//拼接sql条件
		if($options['keyword']!="请输入关键字"){
			$str .= " AND (title like '%".$options['keyword']."%' OR reciver like '%".$options['keyword']."%')";
		}
		if($options['starttime']!=""){
			$str .= " AND sendtime >= ".strtotime($options['starttime']);
		}
		
		if($options['endtime']){
			$str .= " AND sendtime <= ".strtotime($options['endtime']);
		}

		$options['where'] = $str;
		$result = $this->select($options);
		
		return $result;
	}
	
	/*邮件模板搜索*/
	function getMailTemplate($options=array()){

		 $str = " 1=1";
	
		if($options['keyword']!="请输入关键字"){
			
		   $str .= " AND theme like '%".$options['keyword']."%'";
		}
		
		if($options['starttime']!=""){
			
			$str .= " AND sendtime >= ".strtotime($options['starttime']);
		}
		
		if($options['endtime']){
			
			$str .= " AND sendtime <= ".strtotime($options['endtime']);
		}

		$result = $this->query(array('where'=>$str));
		
		return $result;
	}
}