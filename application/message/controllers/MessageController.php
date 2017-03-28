<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MessageController.php
 *
 * 留言类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   MessageController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class MessageController extends HomeController {

	public  $ContentModel;
	public function init()
	{
		$this->ContentModel = D('Content');
		parent::init();
	}
	/**
	 * 内容页首页
	 */
	public function indexAction()
	{
        $obj = M('MixModel');
		$modelid = Controller::get('id',1);
        $messagemodel = $obj->find(array('id'=>$modelid));
        if (empty($messagemodel)) {
            goback('表单类型参数错误',true);
        }
        if ($messagemodel['state'] != 2) {
            $this->goback('对不起，表单已关闭', true);
        }
        $seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
		$cid=true;
		$pid=0;
		$ismessage = 1;
		$hasYzm = hasYzm('mo_captcha_message');
		$hasYzm = false;
		$flag = 1;
		$num = 3;
		$ContentForm = new MessageForm($modelid);
		$form = $ContentForm->get($flag,$modelid);
		$formvalidator = $ContentForm->formValidator;
		//获取自定义表单设置
		$mess_obj = M("WebConfig");
		$set =$mess_obj->where(array('group_id'=>10))->field('par_name,par_value')->select();
			
		foreach ($set as $sk=>$sv){
			$messageset[$sv['par_name']] = $sv['par_value'];
		}
			
		include $this->display('message.html');
	}

	/**
	 * 添加留言内容
	 */
	public function addAction()
	{
        $modelid = $_POST['modelid'];
        $obj = M('MixModel');
        $messagemodel = $obj->find(array('id'=>$modelid));
        if (empty($messagemodel)) {
            goback('表单类型参数错误',true);
        }
        if ($messagemodel['state'] != 2) {
            goback('对不起，表单已关闭',true);
        }
		$seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
		require_once DIR_ROOT."static/js/securimage/securimage.php";
		$hasYzm = hasYzm('mo_captcha_message');
		//$hasYzm = true;
		if($hasYzm)
		{
			$securimage = new Securimage();
			if (!$securimage->check(Controller::post('code')))
			{
				goback('请输入正确的验证码',true);
			}
		}
		$content = $_POST['info'];
		if(!$content['title'])
		{
			goback('留言标题不能为空',true);
		}
		
		//判断后台设置必填与否
		$obj = M("attribute");
		$leaveCon = $obj->where(array("modelid"=>$modelid,"isnessary"=>1,"dataname"=>"mess_infor"))->select();
		if($leaveCon){
		
			if(!$content['mess_infor'])
			{
				goback('留言内容不能为空',true);
			}
		}

		$cid=true;
		$pid=0;
		$ismessage = 1;
		$modelid = Controller::post('modelid');
		/*敏感词开始*/
		foreach($content as $key=>$value)
		{
			$flag = D('Comment','comment')->isSubmit($value);
			if($flag !== true)
		    {
			   goback($flag.'为敏感词，不能提交',true);
		    }
			else
			{
				continue;
			}
		}
       /*敏感词结束*/

		$Maincontent = array(
			'title'=>$content['title'],
			'username'=>$content['username'],
			'typeid'=>$modelid,
			'leavetime'=>time()
		);
	   /*匿名开始*/
		if(!$Maincontent['username'])
		{
			if(get_mo_config('mo_isanony') == 1)
			{
				$Maincontent['username'] = '匿名';
			}
			else
			{
				goback('不允许匿名评论,请输入留言人',true);
			}
		}
		/*匿名结束*/
		if(get_mo_config('mo_isexamine') == 1)//是否需要审核
		{
			$Maincontent['ischeck'] = 2; //待审
		}
		else
		{
			$Maincontent['ischeck'] = 1; //已通过
		}
		$arr = array();
		if(in_array($key,$arr))
		{
			unset($content['modelid']);
		}
		//$fields =  M('Attribute')->where(array('modelid'=>$modelid))->select();
		//$contentValue = new ContentValue($modelid,$this,$fields);
		//$content = $contentValue->get($content);
		foreach($content as $key=>$value)
		{
			if(is_array($value))
			{
				$content[$key] = implode(';',$value);
			}
		}
		$content['model_id'] = $modelid;
		$FlastInsertId = M('message_'.Controller::post('modelid')) -> create($content);
		if(!$FlastInsertId)
		{
			goback('留言失败');
		}
		else//添加留言附表内容
		{

			/*像主表添加留言信息*/
			$Maincontent['message_id'] = $FlastInsertId;
			
	    	$lastInsertId = M('message_manage') -> create($Maincontent);
			if(!$lastInsertId)
			{
				goback('留言失败',true);
			}
			else
			{
				alert('留言成功',$_SERVER['HTTP_REFERER']);
			}
		}


	}

	/**
	 * 添加留言内容
	 */
	public function cmsaddAction()
	{
		$seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
		require_once DIR_ROOT."static/js/securimage/securimage.php";
		$hasYzm = hasYzm('mo_captcha_message');
		$hasYzm = true;
		if($hasYzm)
		{
			$securimage = new Securimage();
			if (!$securimage->check(Controller::post('code')))
			{
				$this->mydialog($_SERVER['HTTP_REFERER'],'error','请输入正确的验证码');
			}
		}
		$content = $_POST['info'];
		$cid=true;
		$pid=0;
		$ismessage = 1;
		$modelid = Controller::post('modelid');


	   /*匿名开始*/
		if(!$Maincontent['username'])
		{
			if(get_mo_config('mo_isanony') == 1)
			{
				$Maincontent['username'] = '匿名';
			}
			else
			{
				goback('不允许匿名评论,请输入留言人',true);
			}
		}
		/*匿名结束*/
		$Maincontent = array(
			'title'=>$content['title'],
			'username'=>$content['username'],
			'typeid'=>$modelid,
			'leavetime'=>time()
		);
		/*敏感词开始*/
		foreach($content as $key=>$value)
		{
			$flag = D('Comment','comment')->isSubmit($value);
			if($flag !== true)
		    {
				$this->mydialog($_SERVER['HTTP_REFERER'],'error','为敏感词，留言失败');
		    }
			else
			{
				continue;
			}
		}
       /*敏感词结束*/

	   /*匿名开始*/
		if(!$Maincontent['username'])
		{
			if(get_mo_config('mo_isanony') == 1)
			{
				$Maincontent['username'] = '匿名';
			}
			else
			{
				$this->mydialog($_SERVER['HTTP_REFERER'],'error','不允许匿名评论,请输入留言人');
			}
		}

		/*匿名结束*/

		if(get_mo_config('mo_isexamine') == 1)//是否需要审核
		{
			$Maincontent['ischeck'] = 2; //待审
		}
		else
		{
			$Maincontent['ischeck'] = 1; //已通过
		}
		$arr = array();
		if(in_array($key,$arr))
		{
			unset($content['modelid']);
		}
		$fields =  M('Attribute')->where(array('modelid'=>$modelid))->select();
		$contentValue = new ContentValue($modelid,$this,$fields);
		$content = $contentValue->get($content);
		$content['model_id'] = $modelid;
		$FlastInsertId = M('message_'.Controller::post('modelid')) -> create($content);
		if(!$FlastInsertId)
		{
			$this->mydialog($_SERVER['HTTP_REFERER'],'error','留言失败');

		}
		else//添加留言附表内容
		{

			/*像主表添加留言信息*/
			$Maincontent['message_id'] = $FlastInsertId;
	    	$lastInsertId = M('message_manage') -> create($Maincontent);
			if(!$lastInsertId)
			{
				$this->mydialog($_SERVER['HTTP_REFERER'],'error','留言失败');


			}
			else
			{
				$this->mydialog($_SERVER['HTTP_REFERER'],'error','留言成功');
			}
		}


	}
//获取联动菜单
	public function linkageAction()
	{

	    $parentid = $_POST['id'];
		$str = "<option value=''>--请选择--</option>";
		if($parentid != '')
		{
			$data = M('linkage_bill') -> findAll(array('pid'=>$parentid),'ordernum ASC,created DESC','id,lin_id,pid,name');
			foreach($data as $row){
			    $str .=  '<option value="'.$row['id'].'"';
			    $str .= '>'.$row['name'].'</option>';
			}
		}
		echo $str;exit;

	}

    /**
     * 单条留言详细页方法
     * @param
     * @return
     */
	public function detailAction ()
	{
		$typeid= isset ( $_GET['typeid'] ) ? intval($_GET['typeid']) : 0 ;
		$msgid = isset ( $_GET['id'] ) ? intval($_GET['id']) : 0 ;
		$cid    = isset ( $_GET['cid'] ) ? intval($_GET['cid']) : 0 ;
		$tpl    = isset ( $_GET['tpl'] ) ? $_GET['tpl'] : 'msg_detail' ;
		$db_srv = $this -> getMessageManageModel();
		$msg_info  = $db_srv->getMessageExtInfo($typeid,$msgid);
		$msg_reply = $db_srv->getMessageMainInfoById($typeid,$msgid);
		include $this->display($tpl.'.html');
	}

	/**
	 * 会员分组模型
	 *
	 */
	function getMessageManageModel ()
	{
		return D('MessageManageModel');
	}
}
