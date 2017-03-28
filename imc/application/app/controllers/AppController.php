<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AppController.php
 * 
 * IMCenter 应用管理管理
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-4 上午11:18:42
 * @filename   AppController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
 
class AppController extends AdminController 
{
	private $App;
	public static $page; //当前页码
	public function init()
	{
		self::$page =  Controller::getParams('page') ? Controller::getParams('page') :1 ;
		$this->App = D('App');
		parent::islogin_imc();
		parent::init();
		parent::init();
	}
	
	/**
	 * 应用列表
	 */
	public function indexAction()
	{

		$urlArr = array(
				'indexUrl' => $this->createUrl('app/App/index/page/'.self::$page),
				'addUrl' => $this->createUrl('app/App/add/page/'.self::$page),
				'editUrl' => $this->createUrl('app/App/edit/page/'.self::$page),
				'delUrl' => $this->createUrl('app/App/del/page/'.self::$page),
			    'checkStatusUrl' => $this->createUrl('app/App/checkStatus'),
		);

		$count = $this->App->getAppList(); //获取应用数量
		$pagesize = 20;
		$page = new Page(count($count), $pagesize);
		$from = $page->firstRow;
		$limit = $from.','.$pagesize;
		$applist = $this->App->getAppList($limit); //获取应用列表

		$this->assign('pagestr',$page->show());
		$this->assign('applist',$applist);
		$this->assign('urlArr',$urlArr);
		$this->display('app/index');
	}
	
	/**
	 * 应用添加
	 */
	public function addAction()
	{
		
		$urlArr = array(
			'indexUrl' => $this->createUrl('app/App/index/page/'.self::$page),
			'appkeyUrl' => $this->createUrl('app/App/appkey'),
		);
		if(Controller::post('dosubmit')==1)
		{
			$arr = array(
			        'appname' => $this->getParams('appname'),
			        'appurl' => $this->getParams('appurl'),
			        'appkey'    => $this->getParams('appkey'),
			        'appip'   => $this->getParams('appip'),
			        'appfile'  => $this->getParams('appfile'),
					'charset'    => $this->getParams('charset'),
					'currency'    => $this->getParams('currency'),
					'syslogin'    => $this->getParams('syslogin'),
					'created'    => time(),
				    'updateuser'  => $_SESSION['userinfo']['username'],
					'updatetime'  => time(),
			);
			$lastInsertId = $this->App->create($arr);
			if ($lastInsertId)
			{
				imc_log("添加应用","添加了应用： ".$this->getParams('appname'));
				$this->dialog('/app/app/index/page/'.self::$page);
				exit();
			}	
			else 
		    {
				$this->dialog('/app/app/index/page/'.self::$page,'error','操作失败');
				exit;
		    }
			
		}
		
		$this->assign('urlArr',$urlArr);
		$this->display('app/add');
	}
	
	/**
	 * 应用修改
	 */
	public function editAction()
	{
		$urlArr = array(
				'indexUrl' => $this->createUrl('app/App/index/page/'.self::$page),
			    'appkeyUrl' => $this->createUrl('app/App/appkey'),
		);
		$id = Controller::get('id');
		$appInfo = $this->App->where(array('id'=>$id))->getOne();
		if(Controller::post('id'))
		{
			$arr = array(
			        'appname' => $this->getParams('appname'),
			        'appurl' => $this->getParams('appurl'),
			        'appkey'    => $this->getParams('appkey'),
			        'appip'   => $this->getParams('appip'),
			        'appfile'  => $this->getParams('appfile'),
					'charset'    => $this->getParams('charset'),
					'currency'    => $this->getParams('currency'),
					'syslogin'    => $this->getParams('syslogin'),
				    'updateuser'  => $_SESSION['userinfo']['username'],
					'updatetime'  => time(),
			);
			$flag = $this->App->update(array('id'=>Controller::post('id')),$arr);
			if ($flag)
			{
				imc_log("编辑应用","编辑了应用： ".$this->getParams('appname'));
				$this->dialog('/app/app/index/page/'.self::$page);
				exit();
			}	
			else 
		    {
				$this->dialog('/app/app/index/page/'.self::$page,'error','操作失败');
				exit;
		    }
		}
		$this->assign('appInfo',$appInfo);
		$this->assign('urlArr',$urlArr);
		$this->display('app/edit');
	}
	
	/**
	 * 用户删除
	 */
	public function delAction()
	{
		$id = Controller::get('id');
		if($id)
		{
			imc_log("删除应用","删除了应用： ".$this->getParams('appname'));
			$this->App->delete(array('id'=>$id));
			$this->dialog('/app/app/index/page/'.self::$page);

		}
		else 
		{
			$this->dialog('/app/app/index/page/'.self::$page,'error','删除失败');
			exit;
		}
	}

	/**
	*生成通讯密钥
	*/
	public function checkUniqueAction()
	{
		$appname = Controller::get('appname');
		$oldvalue = Controller::get('oldvalue');
		if(isset($oldvalue)&&$appname==$oldvalue)
		{
		   exit('1');
		}
		$result = $this->App->where(array('appname'=>$appname))->getOne();
		if(!empty($result))
		{
			exit('2');
		}
		else
		{
			exit('1');
		}
		exit($appname);
	}
    /**
	*生成通讯密钥
	*/
	public function appkeyAction()
	{
		$str = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz0123456789';
		$appkey = '';
		for($i = 1, $len = strlen($str); $i <= 64; ++$i) {
            $appkey .= $str{rand(0, $len - 1)};
        }
		exit($appkey);
	}

	/**
	检查通信状态
	**/

	public function checkStatusAction()
	{
		$appid = Controller::post('id');
		$appInfo = $this->App->where(array('id'=>$appid))->getOne();
		if (!empty($appInfo)) {
			$param = rc4('action=check_status', 'ENCODE', $appInfo['appkey']);
			include(DIR_ROOT."../vendor/hprose/HproseHttpClient.php");
			$client   = new HproseHttpClient($appInfo['appurl']."/imc_client/api/server.php");
			//如果填写ip则通信地址为ip地址，此时绑定了多个虚拟主机有可能出现错误
			if ($data = $client->check_status($param)) 
			{
				exit('1');
			} 
			else 
			{
				exit('0');
			}
			
		} else {
			exit('0');
		}
	}

}