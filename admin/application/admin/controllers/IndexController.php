<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * IndexController.php  后台首页控制器类
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2012-12-21 上午11:19:11
 * @filename   IndexController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class IndexController extends AdminController
{
	private $objPM;
    public $empowerModel;

	public function init()
	{
		$this->islogin();
		$this->objPM = D("Permission",'webset');
		$this->empowerModel = D('empowerModel');
	}

	/**
	 *  后台首页
	 */
	public function indexAction()
	{
		$objAdminShortcut = M('AdminShortcut');
		$objPM       = D("Permission",'webset');
		$objRole     = D('Role','webset');
		$pageinfo    = array();
		$topmenu_str = '';
// 		$flag_left   = 0;       //是否有左侧菜单
// 		$defLeftMenu = '';      //默认左侧菜单
		$counts      = array(); //信息统计
		$shortcut    = array(); //常用操作
		//用户信息
		$userinfo = isset($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
		$mypermissionid = isset($_SESSION['mypermissionid'])?$_SESSION['mypermissionid']:array();
		if (!$userinfo)
		{
			$this->redirect($this->createUrl('admin/login/index'));
			exit;
		}

		$rolelist = get_cache('role','common');
		if (empty($rolelist))
		{
			$rolelist = $objRole->getRoleCacheList();
		}
		$roleid = $userinfo['roleid'];
		$rolename = $rolelist[$roleid];


		//一级导航

		$topmenu_str .= "<li><a href=\"{$this->baseurl}/admin/index\" class=\"focus\" >后台首页</a></li>";
		$topmenu = $this->objPM->listAllTopMenu();

		foreach ($topmenu as $row)
		{
			if ($roleid==1 || in_array($row['id'], $mypermissionid))
			{
			    $topmenu_str .= "<li><a id=\"_M{$row['id']}\" href=\"javascript:_MM({$row['id']})\" class=\"\">{$row['name']}</a></li>";
			}else
			{
				$topmenu_str .= "<li><a href=\"javascript:alert('没有权限！');\">{$row['name']}</a></li>";
			}
		}
		/*if ($roleid==1)
		{
			$topmenu_str .= "<li><a href=\"{$this->baseurl}/admin/imc/index\" class=\"\">IMCenter</a></li>";
		}else
		{
			$topmenu_str .= "<li><a href=\"javascript:alert('没有权限！');\" class=\"\" >IMCenter</a></li>";
		}*/

		//左侧菜单（默认显示网站管理的左侧菜单，如果没有该模块权限则不显示）---已换成常用操作
// 		$menuid = 1;
// 		if ($roleid==1 || in_array($menuid, $mypermissionid))
// 		{
// 		    $defLeftMenu = "/admin/index/leftmenu?moduleid={$menuid}";
// 		    $flag_left   = 1;
// 		}

		//常用操作
		$myshortcut = $objAdminShortcut->findAll(array('userid'=>$userinfo['id']));
		$k = array();
		if ($myshortcut)
		{
			foreach ($myshortcut as $t)
			{
				$link = "";
				$k = $objPM->find(array('id'=>$t['permissionid']));
				if ($k['flag']==1)
				{
					$link = $k['link'];
				}else
				{
					$appdir = isset($row['appdirectory'])&&!empty($row['appdirectory'])?$row['appdirectory']:APPNAME;
					$link = HOST_NAME.$appdir."/{$k['module']}/{$k['controller']}/{$k['actionname']}";
				}
				if (isset($k['data']) && !empty($k['data']))
				{
					$link .= "?{$k['data']}";
				}
				$k['linkURL'] = $link;
				$shortcut[] = $k;
			}
		}
		$pageinfo['shortcut'] = $shortcut;

		/*信息统计*/

		//管理员
		$objAdmin = D('Admin','webset');
		$counts['admin'] = $objAdmin->getCount();

		//注册会员
		$objMember = D('Member','members');
		$counts['members'] = $objMember->getCount();

		//有效会员
		$counts['activeMember'] = $objMember->getCount(array('status'=>1));

        /* 轮播显示授权公告 */
		//$ann_json = @file_get_contents("http://www.izhancms.com/official/os/announce/showJson");
		//$json = json_decode($ann_json,true);
        if(empty($json)) {
            $json = array('0' => array('announce_name' => "程序定制，让业务随网而动！",'announce_disc'=>"想满足企业在运营过程中对功能的个性化需要吗？想解决企业因业务发展产生的特殊需求吗？请选择爱站程序定制，让企业跟上需求跟上潮流！"), '1' => array('announce_name' => "定制个性化模板",'announce_disc'=>"想拥有个性化前端界面吗？想拥有目前最火爆的前端界面效果吗？请选择爱站模板定制，给您带来源源不断的惊喜！"),'2' => array('announce_name' => "购买商业授权",'announce_disc'=>"购买商业授权，拥有使用爱站CMS进行商业运营的合法权益！去版权、去广告，我的网站我做主！"),'3' => array('announce_name' => "爱站CMS论坛",'announce_disc'=>"爱站CMS用户讨论沟通专区"));
        }
        $this->assign('json',$json);

		//文章总数
		$objContent = D('Content','content');
		$counts['article'] = $objContent->getContentListOnlyMain(array('modelid'=>'1','keywords'=>'','categoryid'=>'','order'=>'','desc'=>''),true);

		//商品总数
		$objGoods = D('Goods','modules');
		$goods = $objGoods->getCount();
		$counts['goods'] = $goods;

		//信息总数
		$content = $objContent->getCount();
		$counts['content'] = $content+$goods;

		//评论总数
		$objComment = D('Comment','content');
		$counts['comment'] = $objComment->getCount();

		//留言总数
		$objMessage = M('MessageManage');
		$counts['message'] = $objMessage->findCount();

		//广告位总数
		$objAdposition = M('Adposition');
		$counts['adposition'] = $objAdposition->findCount();

		//$empower = $this->checkLicense(HOST_NAME); //判断授权接口
		//$this->assign('empower',$empower);

        /* 首页推送广告位状态 */
        /*$appobj = M("ServeAdposition");  //广告位实例化
        $status = $appobj->findAll(array(),null,'status');
        $sta = array();
        foreach($status AS $val){  //广告位状态
            $sta[] = $val['status'];
        }
        if($this->checkLicense(HOST_NAME) ==1 && $sta['0']==2) {
            $this->assign('positon_left', 1);  //左侧推送广告位将消失
        }

        if($this->checkLicense(HOST_NAME) ==1 && $sta['1']==2) {
            $this->assign('positon_right', 1);  //右侧同理
        }*/

        //获取站点名称和域名
        $ray = M('WebConfig');
        $ios = $ray->findAll(array('in'=>array('par_name'=>'\'mo_basehost\',\'mo_webname\'')),false,'par_value');
        foreach($ios AS $val){
            $android[] = $val['par_value'];
        }
        $this->assign('android', $android);
        $this->assign('ip', get_client_ip());

		/* 广告推送 */
		//$useskill_json = @file_get_contents("http://www.izhancms.com/official/os/adserving/ipush");
		//$skill = json_decode($useskill_json,true);

        //左侧广告位消失
        if(empty($skill['1'])) {
            $lad = array('0' => array('imgpath' => URL_ADMIN_TPL . "images/default/ad1.png"), '1' => array('imgpath' => URL_ADMIN_TPL . "images/default/ad2.png"));
        }else{
            foreach ($skill['1'] AS $key=> $val){   //左侧广告
                //$tmp = $lad[$key] = unserialize(base64_decode($val['adimg']));
                //$lad[$key]['imgpath'] = "http://www.izhancms.com/static/uploadfile/".$tmp['imgpath'];
                //$lad[$key]['id'] = $val['id'];
            }
        }

        //右侧推送广告位将消失
        if(empty($skill['2'])) {
            $rad = array('0' => array('imgpath' => URL_ADMIN_TPL . "images/default/ad3.png"), '1' => array('imgpath' => URL_ADMIN_TPL . "images/default/ad4.png"));
        }else{
            foreach ($skill['2'] AS $k=> $v){   //右侧广告
                //$so = $rad[$k] = unserialize(base64_decode($v['adimg']));
                //$rad[$k]['imgpath'] = "http://www.izhancms.com/static/uploadfile/".$so['imgpath'];
                //$rad[$k]['id'] = $v['id'];
            }
        }

        $this->assign('lad',$lad);
		$this->assign('rad',$rad);

		/*程序信息*/
		$sysinfo = get_sysinfo();
		$sysinfo['mysqlv'] = $ray->_db->version();
		$version_info = get_config('version');  //当前版本
        $new_version = '';
		//$new_version = trim(@file_get_contents('http://jianzhan.b2b.cn/upgrade/download/version.txt')); //最新版本
        $sysinfo['version'] = $version_info['mo_version'];
        $sysinfo['new_version'] = $new_version;
        
        /*首页--重要提醒*/
        $smtp_server = get_mo_config('mo_service');     //smtp服务器
        $smtp_port   = get_mo_config('mo_service_port');       //smtp服务器端口
        $smtp_user   = get_mo_config('mo_mail_account');       //发送邮件用户名称
        $smtp_password = get_mo_config('mo_mail_password'); //发送邮件邮箱密码
        
        if (!empty($smtp_server) && !empty($smtp_port) &&!empty($smtp_user) &&!empty($smtp_password))
        {
        	$pageinfo['remind'] = 1;
        }else{
            $pageinfo['remind'] = 0;  
        }

        /**后台首页待处理事项star**/
        #相册审核
        $photo_num = M('memorial_photo')->where(array('status'=>0))->select();
        $photo_num = count($photo_num);
        $this->assign('photo_num', $photo_num);

        #纪念馆审核
        $memorial = M('memorial')->where(array('status'=>3))->select();
        $memorial = count($memorial);
        $this->assign('memorial', $memorial);

        #逝者资料审核
        $memorial = M('memorial')->where(array('status'=>0))->select();
        $memorial = count($memorial);
        $this->assign('memorial2', $memorial);

        #背景音乐审核
        $bgm = M('memorial_bgmusic')->where(array('status'=>0))->select();
        $bgm = count($bgm);
        $this->assign('bgm', $bgm);

        #逝者资料审核
        $userinfo2 = M('memorial_userinfo')->where(array('status'=>0))->select();
        $userinfo2 = count($userinfo2);
        $this->assign('userinfo2', $userinfo2);

        #作品荣誉审核
        $honor = M('memorial_honor')->where(array('status'=>3))->select();
        $honor = count($honor);
        $this->assign('honor', $honor);

        #传记审核
        $bio = M('memorial_biography')->where(array('status'=>0))->select();
        $bio = count($bio);
        $this->assign('bio', $bio);

        #祭文悼词审核
        $eulogy = M('memorial_eulogy')->where(array('status'=>3))->select();
        $eulogy = count($eulogy);
        $this->assign('eulogy', $eulogy);


        #留言审核
        $msg = M('memorial_message')->where(array('status'=>0))->select();
        $msg = count($msg);
        $this->assign('msg', $msg);

        


        /**后台首页待处理事项end**/
        
        
// 		$pageinfo['flag']     = $flag_left;
		$pageinfo['userid']   = $userinfo['id'];
		$pageinfo['username'] = $userinfo['username'];
		$pageinfo['rolename'] = $rolename;
		$pageinfo['roleid']   = $userinfo['roleid'];
		$pageinfo['mypermissionid'] = $mypermissionid;

		$this->assign('pageInfo',$pageinfo);
        $this->assign('empower',1);
		$this->assign('sysInfo',$sysinfo);
		$this->assign('counts',$counts);
		$this->assign('topMenuStr',$topmenu_str);
// 		$this->assign("defLeftMenu", $defLeftMenu);
		$this->display('admin/index/index');
	}

	/**
	 * 后台主框架布局
	 */
	public function initAction()
	{
		$pageinfo = array();
		$shortcut = array();
		$objPM    = D("Permission",'webset');
		$objRole  = D('Role','webset');
		$objAdminShortcut = M('AdminShortcut');

		//用户信息
		$userinfo = isset($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
		$mypermissionid = isset($_SESSION['mypermissionid'])?$_SESSION['mypermissionid']:array();

		if (!$userinfo)
		{
			$this->redirect($this->createUrl('admin/login/index'));
			exit;
		}

		$rolelist = get_cache('role','webset');
		if (empty($rolelist))
		{
			$rolelist = $objRole->getRoleCacheList();
		}
		$roleid   = $userinfo['roleid'];
		$rolename = $rolelist[$roleid];
		$pageinfo['username'] = $userinfo['username'];
		$pageinfo['rolename'] = $rolename;

		$menuid     = isset($_GET['menuid'])?$_GET['menuid']:1;
		$submenu    = isset($_GET['submenu'])?$_GET['submenu']:'';
		$defRightUrl= isset($_GET['rightUrl'])?$_GET['rightUrl']:'';

		//默认三级菜单信息
		$defsubmenu  = $objPM->getDefSubmenu($menuid,$userinfo);
		$submenu     = !empty($submenu)?$submenu:$defsubmenu['id'];
		$defRightUrl = !empty($defRightUrl)?$defRightUrl:$defsubmenu['linkURL'];
		$topmenu_str = '';
		$targetURL = "/admin/index/leftmenu";
		$topmenu_str .= "<li><a href=\"".$this->baseurl."/admin/index\" class=\"\" >后台首页</a></li>";
		//一级菜单
		$topmenu = $objPM -> listAllTopMenu();

		foreach ($topmenu as $row)
		{
			if (!empty($menuid) && $menuid==$row['id'])
			{
				$css = "focus";
			}else
			{
				$css="";
			}
			if ($roleid==1 || in_array($row['id'], $mypermissionid))
			{
				//默认三级菜单信息
				$currsubmenu = $objPM->getDefSubmenu($row['id'],$userinfo);
				$submenu_c   = $currsubmenu['id'];
				$RightUrl_c  = $currsubmenu['linkURL'];

                $topmenu_str .= "<li><a id=\"_M{$row['id']}\" href=\"javascript:_M({$row['id']}, '{$targetURL}',{$submenu_c},'{$RightUrl_c}')\" class=\"{$css}\">{$row['name']}</a></li>";
			}else
			{
				$topmenu_str .= "<li><a href=\"javascript:alert('没有权限！');\" class=\"{$css}\">{$row['name']}</a></li>";
			}
		}
		/*if ($roleid==1)
		{
			//$topmenu_str .= "<li><a href=\"{$this->baseurl}/admin/imc/index\" class=\"\">IMCenter</a></li>";
		}else
		{
			//$topmenu_str .= "<li><a href=\"javascript:alert('没有权限！');\" class=\"\" >IMCenter</a></li>";
		}*/

		$defLeftMenu = "/admin/index/leftmenu?moduleid={$menuid}&submenu={$submenu}";

		//常用操作
		$myshortcut = $objAdminShortcut->findAll(array('userid'=>$userinfo['id']));
		$k = array();
		if ($myshortcut)
		{
			foreach ($myshortcut as $t)
			{
				$link = "";
				$k = $objPM->find(array('id'=>$t['permissionid']));
				if ($k['flag']==1)
				{
					$link = $k['link'];
				}else
				{
					$appdir = isset($row['appdirectory'])&&!empty($row['appdirectory'])?$row['appdirectory']:APPNAME;
				    $link = HOST_NAME.$appdir."/{$k['module']}/{$k['controller']}/{$k['actionname']}";
				}
				if (isset($k['data']) && !empty($k['data']))
				{
					$link .= "?{$k['data']}";
				}
				$k['linkURL'] = $link;
				$shortcut[] = $k;
			}
		}
		$pageinfo['shortcut'] = $shortcut;

		$this->assign('menuId', $menuid);
		$this->assign('submenu', $submenu);
		$this->assign("defLeftMenu", $defLeftMenu);
		$this->assign("defRightUrl", $defRightUrl);
		$this->assign('topMenuStr',$topmenu_str);
		$this->assign('pageInfo',$pageinfo);
		$this->display('admin/index/init');
	}

	/**
	 * 左侧菜单
	 */
	public function leftmenuAction()
	{
		$userinfo = isset($_SESSION['userinfo'])?$_SESSION['userinfo']:array();
		$moduleid = isset($_REQUEST['moduleid'])?$_REQUEST['moduleid']:1;
		$submenu  = isset($_GET['submenu'])?$_GET['submenu']:'';
		$submenuinfo = array();

		if (!$userinfo)
		{
			exit;
		}

		if ($submenu)
		{
			$submenuinfo = $this->objPM->field('id,parentid')->where("id='{$submenu}'")->order("sort,id asc")->select();
			$submenuinfo = isset($submenuinfo)?$submenuinfo[0]:array();
		}
		$leftMenu = $this->objPM->getSubmenuList($moduleid,$userinfo);
		$this->assign('leftMenuList',$leftMenu);
		$this->assign("submenuinfo", $submenuinfo);
		$this->display('admin/index/leftmenu');
	}

	/**
	 * 显示当前位置
	 */
	function currentposAction()
	{
		$menuID = $_REQUEST['menuid'];
		$menuPos = $this->objPM->getPos($menuID);
		echo $menuPos;
		exit;
	}

	/**
	 * 网站地图
	 */
	public function mapAction()
	{
		$maplist = array();
		$tops = array();
		//用户信息
		$userinfo = $_SESSION['userinfo'];
		$roleid   = $userinfo['roleid'];
		$mypermissionid = $_SESSION['mypermissionid'];
		if (!$userinfo)
		{
			$this->redirect($this->createUrl('admin/login/index'));
			exit;
		}
		$topmenu = $this->objPM->listAllTopMenu();

		foreach ($topmenu as $row)
		{
			$tops[$row['id']] = $row;
			if ($roleid==1 ||in_array($row['id'], $mypermissionid))
			{
				$maplist[$row['id']] = $this->objPM->getSubmenuList($row['id'],$userinfo);
			}
		}

		$this->assign('tops',$tops);
		$this->assign('mapList',$maplist);
		$this->display('admin/index/map.html');
	}

	/**
	 * 常用操作
	 */
	public function shortcutAction()
	{
		$param        = array();
		$myshortcut   = array();
		$shortcutlist = array();
		$adminshortcut= array();

		$userinfo = $_SESSION['userinfo'];
		$roleid   = $userinfo['roleid'];
		$userid   = $userinfo['id'];
		$mypermissionid   = $_SESSION['mypermissionid'];
		$objPermission    = D('Permission','webset');
		$objAdminShortcut = M('AdminShortcut');
		if ($_POST)
		{
			if (!empty($_POST['shortcut']))
			{
				foreach ($_POST['shortcut'] as $t)
				{
					$arr['userid'] = $userid;
					$arr['permissionid'] = $t;
					$arr['createtime'] = time();
					$param[] = $arr;
				}
				//先删除之前的常用操作记录
				$objAdminShortcut->delete(array('userid'=>$userid));
				//插入到管理员常用操作表
				$objAdminShortcut->addAll($param);
			}else
			{
				$objAdminShortcut->delete(array('userid'=>$userid));
			}
		}

		//常用操作列表（权限内的）
		$result = $this->objPM->getShortCutList();
		foreach ($result as $row)
		{
			if ($roleid==1 || in_array($row['id'], $mypermissionid))
			{
				$shortcutlist[] = $row;
			}
		}
		//当前用户已设置的常用操作
		$result2 = $objAdminShortcut->findAll(array('userid'=>$userid));
		foreach ($result2 as $row2)
		{
			$myshortcut[] = $row2['permissionid'];
		}

		$this->assign('shortcutList',$shortcutlist);
		$this->assign('myShortcut',$myshortcut);
		$this->display('admin/index/shortcut');
	}
}