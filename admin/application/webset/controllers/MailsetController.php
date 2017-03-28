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
 * <br>申静  2013-1-7 上午11:09:13 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-1-7 上午11:09:13

 * @filename   MailsetController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: MailsetController.php 77 2013-08-30 07:51:39Z wangrui $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class MailsetController extends AdminController {
	
    public function indexAction(){
    	$mail_obj = M('WebConfig');
    	//查询出已经配置的服务器信息
    	$mail =$mail_obj->where(array('group_id'=>9))->field('par_name,par_value')->select();
        foreach ($mail as $mk=>$mv){
        	$mailset[$mv['par_name']] =$mv['par_value'];
        }
        
    	$this->assign('mail',$mailset);
    	$this->display('webset/mail/mailset');
    }
    
    //更新邮箱服务器的配置
    public function mailServerAction(){

    	//接收服务器配置信息
    	$mail['mo_send_style'] = $_POST['sendstyle'];
    	$mail['mo_send_user'] = $_POST['name'];
    	$mail['mo_service'] = $_POST['smtpserver'];
    	$mail['mo_service_port'] = $_POST['port'];
    	$mail['mo_mail_account'] = $_POST['mail'];
    	$mail['mo_mail_password'] = $_POST['password'];
        
    	$obj = M("WebConfig");
    	
    	//验证邮箱格式
    	
    	if(!MoValidator::hasEmail($mail['mo_mail_account'])){
    		
    		echo '邮箱格式不正确';exit;
    	}

    	//验证端口号
    	if(!MoValidator::isNonNegative($mail['mo_service_port'])){
    		
    		echo '端口号只能是数字';exit;
    	}
    	
    	//更新服务器设置
        foreach($mail as $mk=>$mv){	
        	
    	    $obj->update(array('par_name'=>$mk),array('par_value'=>$mv));
        }
       admin_log('更新了邮件服务器设置', '邮件服务器设置做了修改');  //添加日志
       echo 'success';
    }
    
    //邮件状态信息
    public function mailstateAction(){

    	 $search = array();

    	 $keyword =$this->getParams('keyword');
    	 $starttime =$this->getParams('starttime');
    	 $endtime =$this->getParams('endtime');

    	 $search = array(
    	 		     'keyword' =>$keyword,
    	             'starttime' =>$starttime,
    	 		     'endtime'   =>$endtime,
    	 		   );
    	//带有搜索条件时的查询
    	 $stateObj = M('mailstate');
         
    	 $where['state']=1;//发送成功邮件状态
    	 //关键字条件
         if(isset($keyword) && !empty($keyword))
         {
            
         	$where['or'] = "title like '%{$keyword}%' or reciver like '%{$keyword}%'";
         }
         //时间条件查询
         
         if(isset($starttime) && !empty($starttime)){
         	
         	$where['compbig']['sendtime'] = strtotime($search['starttime']);
         }
         
         if (isset($endtime)&&!empty($endtime))
         {
         	$where['compsmall']['sendtime'] = strtotime($search['endtime']);
         }
         //分页
    	 $count = $stateObj->findCount($where);
    	 $pagesize = 20;
    	 $page = new Page($count, $pagesize);
    	 $from = $page->firstRow;
    	 $options['limit'] = $from.','.$pagesize;
    	 $options['order'] = "id desc";
    	 $options['where'] = $where;

    	 //发送成功 的邮件
    	 $infor = $stateObj ->field('id,title,reciver,sendtime')->select($options);
    	 $currpage = isset($_GET['p'])?$_GET['p']:1;
    	 $pagestr = $page->show();
    	 
    	 $this->assign('pageStr',$pagestr);
    	 $this->assign('page',$currpage);
    	 $this->assign('search',$search);
    	 $this->assign('infor',$infor);
    	 $this->display('webset/mail/mailstate');
    }
    
    //查看邮件状态信息
    public function checkAction(){
    	$id = $this->getParams('id');
    	$info['state'] = $this->getParams('state');
    	$info['page'] = $this->getParams('p');
    	$info['keyword'] = $this->getParams('keyword');
    	$info['starttime'] = $this->getParams('starttime');
    	$info['endtime'] = $this->getParams('endtime');
    	//当前邮件的状态
    	$mailstate = M("Mailstate");
    	$con = $mailstate->find(array('id'=>$id));
    	
    	$this->assign('info',$info);
    	$this->assign('con',$con);
    	$this->display('webset/mail/mailcheck');
    }
    
    //邮件删除
    public function deleteAction(){
        $str ="";
        $opera = "";
        $mail = M("Mailstate");
        $id = $this->getParams('id');
        $state = $this->getParams('state');
        $page = $this->getParams('p');
 
        $keyword = $this->getParams('keyword');
        $starttime = $this->getParams('starttime');
        $endtime = $this->getParams('endtime');
        if(MoValidator::isPositive($id)){
        
        	//单项删除提交的数据
            $condition =array('id'=>intval($_GET['id']));
        }else if(isset($_GET['column'])){
    	//多项删除提交的数据	
    		foreach($_GET['column'] as $k=>$v){
    			$str .= $v.",";
    		}
    		$id = $_GET['column'][0];

    		$str .=substr($str,0,-1);
    		$condition = array('in'=>array('id'=>$str));
    		
    	}

    	if ($state == 1) {
    		
    		$opera = "删除了已发送邮件";
    		$back_url = '/webset/mailset/mailstate';
    		
    	} else {
    		
    		$opera = "删除了发送失败邮件";
    		$back_url = '/webset/mailset/failMail';
    	}
    	
    	$back_url .="/page/{$page}/keyword/{$keyword}/starttime/{$starttime}/endtime/{$endtime}";
    	
    	if(!empty($condition)){
    		
    		if($mail->delete($condition)){
    			
    			admin_log($opera, $opera);  //添加日志
     			$this->dialog($back_url,'success','删除成功');
    		}else{

    			$this->dialog($back_url,'error','删除失败');
    		}
    		
    	}else{
    		$this->dialog($back_url,'info','参数错误');
    	}
    }
   //发送操作失败邮件
    public function failMailAction(){
    	$search = array();
    	 
    	 $keyword =$this->getParams('keyword');
    	 $starttime =$this->getParams('starttime');
    	 $endtime =$this->getParams('endtime');
    	 
    	 $search = array(
    	 		     'keyword' =>$keyword,
    	             'starttime' =>$starttime,
    	 		     'endtime'   =>$endtime,
    	 		   );
    	//带有搜索条件时的查询
    	 $stateObj = M('mailstate');
         
    	 $where['state']=2;//发送成功邮件状态
    	 //关键字条件
         if(isset($keyword) && !empty($keyword))
         {
            
         	$where['or'] = "title like '%{$keyword}%' or reciver like '%{$keyword}%'";
         }
         //时间条件查询
         
         if(isset($starttime) && !empty($starttime)){
         	
         	$where['compbig']['sendtime'] = strtotime($search['starttime']);
         }
         
         if (isset($endtime)&&!empty($endtime))
         {
         	$where['compsmall']['sendtime'] = strtotime($search['endtime']);
         }
         //分页
    	 $count = $stateObj->findCount($where);
    	 $pagesize = 10;
    	 $page = new Page($count, $pagesize);
    	 $from = $page->firstRow;
    	 $options['limit'] = $from.','.$pagesize;
    	 $options['order'] = "id desc";
    	 $options['where'] = $where;
    	 
    	 //发送成功 的邮件
    	 $infor = $stateObj ->field('id,title,reciver,sendtime')->select($options);
    	 $currpage = isset($_GET['p'])?$_GET['p']:1;
    	 $pagestr = $page->show();
 
    	 $this->assign('pageStr',$pagestr);
    	 $this->assign('page',$currpage);
    	 $this->assign('search',$search);
    	 $this->assign('errinfo',$infor);
    	$this->display('webset/mail/failmail');
    }
    
    //邮件模板
    public function mailTemplateAction(){
    	
    	$temobj = M("Mailtemplate");
    	$search = array();
    	//带有搜索条件时的查询
    	if(!empty($_POST)){
    	
    		 $str = " 1=1";
	
		    if($_POST['keyword']!="请输入关键字"){
		    	
			   $search['keyword'] = $_POST['keyword'];
		       $str .= " AND theme like '%".$_POST['keyword']."%'";
		    }
		
		    if($_POST['starttime']!=""){
		    	
			  $search['starttime'] = $_POST['starttime'];
			  $str .= " AND createtime >= ".strtotime($_POST['starttime']);
		    }
		
		    if($_POST['endtime']){
			
		      $search['endtime'] = $_POST['endtime'];
			  $str .= " AND createtime <= ".strtotime($_POST['endtime']);
		    }

		    $list = $temobj->select(array('where'=>$str));
    	
    	}else{
    	
    		$list = $temobj->select();  //邮件模板的所有数据
    	}
	
    	$this->assign('search',$search);
    	$this->assign('list',$list);
    	$this->display('webset/mail/mailtemplate');
    }
    
    //邮件模板修改
    public function updateTemplateAction(){
    	
    	$temobj = M('Mailtemplate');

    	//加载编辑页信息
    	if(empty($_POST))
    	{
	    	$id = intval($_GET['id']);
	    	
	    	$infor = $temobj->find(array('id'=>$id));
	    	$infor['content'] = $infor['content'];
	    	$this->assign('infor',$infor);
	    	$this->display('webset/mail/updatetemplate');
	    	
    	}else{
    	//更新当前信息
    	    $arr['content'] = htmlspecialchars($_POST['content']);
    	    $arr['theme'] = $_POST['theme'];
			
    	    if($arr['content']=="" || $arr['theme']==""){
    	    	
    	    	$this->dialog('/webset/mailset/updateTemplate/id/'.$_POST['curid'],'info','请填写完整信息');exit;
    	    }
    	    if(intval($_POST['flag']) == 1){
    	    	
    	    	$filname = 'template/public/regmail.html';     //会员注册激活邮件模板
    	    }
    	    if(intval($_POST['flag']) == 2)
    	    {
    	    	$filname = 'template/public/pwdmail.html';     //会员找回密码邮件模板
    	    }
    	    if(intval($_POST['flag']) == 3)
    	    {
    	    	$filname = 'template/public/findpwdmail.html'; //管理员找回密码邮件模板
    	    }
    	    
//     	    $content = str_replace(array('&lt;name&gt;','&lt;link&gt;','&lt;realm&gt;','&lt;pwd&gt;'),array('name','link','<!--{$realm}-->','<!--{$pwd}-->'),$_POST['content']);

    	    $replace_pairs = array(
    	    		'&lt;name&gt;'  => '{name}',
    	    		'&lt;link&gt;'  => '{link}',
    	    		'&lt;realm&gt;' => '<!--{$realm}-->',
    	    		'&lt;pwd&gt;'   => '<!--{$pwd}-->',
    	    		'&lt;password&gt;'   => '{password}',
    	    		'&lt;sitename&gt;'   => '{sitename}'
    	    		);
    	    $content = strtr($_POST['content'], $replace_pairs);
    	    
            $arr['createtime'] = time(); 
			//向指定模板写模板信息
    		if($rs = $temobj->update(array('id'=>$_POST['curid']),$arr)){
    			$fp = fopen($filname, 'w');//以写权限打开文件，并清空文件内容，文件不存在则新建文件，返回文件指针
    			fputs($fp, $content, strlen($content));
    			fclose($fp);
    			
    			admin_log('修改了'.$arr['theme'],'修改了'.$arr['theme']);  //添加日志
    			$this->dialog('/webset/mailset/mailTemplate','success','操作成功');
    		
    		}else{
    			
    			$this->dialog('/webset/mailset/mailTemplate','error','操作失败');
    		}
    		
    	}

    }
     /**
     * 发送邮件
     * @param $userid   int    当前用户id
     * @param $username string 当前的用户名称 
     * @param $senttouser string 发送给谁的邮箱地址
     * @param $flag 1(注册)，2(找回密码)
     */
    public function sentEmailAction() {
    	
            $sent = new SendEmail();
			$sent->sentEmail('wangrui','12','15','jinghappy2012@sohu.com',1);
    }
    
    
}