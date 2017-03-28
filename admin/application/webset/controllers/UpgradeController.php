<?php
class UpgradeController extends AdminController
{
	private $upgrade_dir = 'http://www.izhancms.com/upgrade/download/';//服务端升级文件目录url
	/**
	 * 版本升级日志
	 * @return null
	 */
	function indexAction ()
	{
		//当前版本信息
		$version_info = get_config('version');
		$plist = $this -> getUpgradeLogModel() -> getPageList();
		$this -> assign('plist',$plist);
		$this -> assign('version',$version_info['mo_version']);
		$this -> display('webset/others/webset_upgrade_index.html');
	}

	/**
	 * 新版本检测
	 * @return NULL
	 */
	function checkAction ()
	{
		//当前版本信息
		$testpatch = isset ( $_GET['testpatch'] ) ? trim($_GET['testpatch']) : '';
		$version_info = get_config('version');
		$this -> assign('version',$version_info['mo_version']);
		$this -> assign('testpatch',$testpatch);
		$this -> display('webset/others/webset_upgrade_check.html');
	}

	/**
	 * 执行跟新升级程序
	 * @return null
	 */
	function updateAction ()
	{
		set_time_limit(1800);
		$batch = isset ( $_GET['patch'] ) ? $_GET['patch'] : '' ;
        if (empty($batch)) {
            $this -> upgradeErrorMsg('400');  
        }
        $version_info = get_config('version');//当前版本信息
        $version = str_replace('.', '', $version_info['mo_version']);
        $update_info = explode('_', $batch);
        if (count($update_info) < 5) {
            $this -> upgradeErrorMsg('400'); 
        }
        
        if ($update_info[3] != $version) {
            $this -> upgradeErrorMsg('400'); 
        }
        
        if ($update_info[2] != 'FREE') {
            if ($update_info[2] != 'FEE') {
                $this -> upgradeErrorMsg('400'); 
            }
            $is_pay = false;
            
            //检查授权接口
			//调用地址
			//http://mainonecms.b2b.mainone.cn/official/os/os/check/domainname/b2b.com
			//@return string 授权状态 1已授权 2未授权
            $server_name = $_SERVER['SERVER_NAME'];
            $pay = file_get_contents("http://www.izhancms.com/official/os/os/check/domainname/$server_name");
            if ($pay == 1) {
                $is_pay = true;
            }
            if (!$is_pay) {
                $this -> upgradeErrorMsg('500'); 
            }
        }
		//解压缩文件
		$upgradezip_url = $this -> getUpdateUrl().$batch; //远程压缩包地址http://izhancms.com/upgrade/download/PATCH_20130415_UTF8.zip
		$upgrade_folder = $this -> getUpgradeFolder();    //D:\wamp\www\mocms\data/upgrade/
		$save_target_path = $upgrade_folder.$batch;       //保存到本地地址
		$upgradezip_source_path = $upgrade_folder.basename($batch,".zip");//解压路径
		$file_size = @file_put_contents($save_target_path, @file_get_contents($upgradezip_url));
		if(!$file_size)
		{
			$this -> upgradeErrorMsg('100');
		}
		$PclZip = new PclZip($save_target_path);
		if($PclZip->extract(PCLZIP_OPT_PATH, $upgradezip_source_path, PCLZIP_OPT_REPLACE_NEWER) == 0)
		{
			$this -> upgradeErrorMsg('200');
		}

		//拷贝文件
		$root_dir = getDirRoot();
		$old_back_dir = $upgradezip_source_path.'/old_back/';//老文件备份目录
		$patch_file_dir = $upgradezip_source_path.'/upload/';//补丁文件目录

		//补丁所有文件
		$patch_file = MoFolder::mergeFileList(MoFolder::recurFolder(trim($patch_file_dir,'/')));
		$back_file = array();
		foreach ($patch_file as $key => $val )
		{
			$back_file[] = str_replace($patch_file_dir,$root_dir,$val);
		}
		MoFolder::copyFile($back_file,$root_dir,$old_back_dir);//备份即将被覆盖的文件

		//拷贝文件成功
		if(MoFolder::copyFolder($patch_file_dir,$root_dir))
		{
			$update_program = DIR_CONTROLLER.'upgrade/controllers/MoupgradeController.php';//升级程序控制器
			if(file_exists($update_program))
			{
				include($update_program);
				$update = new MoupgradeController();
				if(method_exists($update,'mainAction'))
				{
					@$update->mainAction(array('unzip_dir'=>$upgradezip_source_path));//执行主升级程序
				}
				MoFile::del($update_program);
				MoFolder::rm(DIR_CONTROLLER.'upgrade',true);
			}

			//更新版本 写升级日志
			$_version_file = $upgradezip_source_path.'/upgrade/config.php';//升级配置文件目录
			if(file_exists($_version_file))
			{
				$version = get_config('version');
				$_version = include($_version_file);
				isset($_version['mo_version']) ? ($version['mo_version'] = $_version['mo_version']) : '' ;
				isset($_version['mo_release']) ? ($version['mo_release'] = $_version['mo_release']) : '' ;
				$version['mo_update'] = date('Y-m-d');
				set_config('version',"<?php return \n".var_export($version,true).';');
				(isset($_version['log']) && is_array($_version['log']) ) ? ($this -> getUpgradeLogModel() -> create($_version['log'])) : '';
			}
			@admin_log('在线升级程序', '升级了一个补丁包');
			@unlink($save_target_path);//删除下载的补丁包
			echo 'success';
		}
		else
		{
			if(MoFolder::copyFolder($old_back_dir,$root_dir))//拷贝失败则进行还原
				MoFolder::rm($old_back_dir,true);//如果还原成功 则删除备份文件

			@admin_log('在线升级程序', '升级失败');
			@unlink($save_target_path);//删除下载的补丁包
			$this -> upgradeErrorMsg('300');
		}
		exit();
	}

	/**
	 * 执行升级过程中可能出现的错误
	 * @param
	 * @return
	 */
	private function upgradeErrorMsg ($code)
	{
		$msg = array(
			'100'=>'下载升级文件失败',
			'200'=>'解压缩升级文件失败',
			'300'=>'拷贝升级文件失败',
            '400'=>'参数有误',
			'500'=>'该版本需要授权',
		);
		echo $msg[$code];
		exit();
	}

	/**
	 * ajax获取可用的升级文件列表json数据
	 * @param
	 * @return array
	 */
	function getPacthListAction ()
	{
		echo json_encode($this ->_getPacthList());
		exit();
	}

	private function _getPacthList ()
	{
		$testpatch = isset($_POST['testpatch']) ? trim($_POST['testpatch']) : '' ;
		$list_file = $testpatch ? $testpatch.'.txt': 'list.txt';
		$version_info = get_config('version');//当前版本信息
		$upgrade_url = $this -> getUpdateUrl();//服务端升级文件目录url
		//服务端所有升级包文件列表
		//$patch_list_str = @file_get_contents($upgrade_url);
		$patch_list_str = @file_get_contents($upgrade_url.$list_file);
		preg_match_all("/(PATCHMO_[\w_]+\.zip)/", $patch_list_str, $patch_list);
        $patch_list = $patch_list[1];
        $version = str_replace('.', '', $version_info['mo_version']);
        foreach ($patch_list as $key => $val )
		{
			if(trim($val) == '')  {
                unset($patch_list[$key]);
                continue;
            }
            $update_info = explode('_', $val);
            if (!isset($update_info[3])) {
                unset($patch_list[$key]);
                continue;
            }
            if ($update_info[3] != $version) {
                unset($patch_list[$key]);
                continue;
            }
		}

		if($patch_list)
		{
			foreach ($patch_list as $key => $val)
			{
				if($this -> getUpgradeLogModel()->find(array('patch_name'=>$val)))
					unset($patch_list[$key]);
			}
		}
		return $patch_list;
	}

	/**
	 * 首页升级提示信息 ajax操作
	 */
	function tipsAction ()
	{
		$c_version = get_config('version');//当前版本信息
		$s_version = $this -> getServerVersionAction();//服务端版本信息
		$pacth_list = $this -> _getPacthList();
		if(!empty($pacth_list))
		{
			$this -> assign('Info',array('c_version'=>$c_version['mo_version'],'s_version'=>$s_version,'u_time'=>$c_version['mo_update']));
			$str = $this -> fetch('webset/others/webset_upgrade_tips.html');
		}
		else
			$str = '';
		echo $str;
		exit();
	}

	/**
	 * 主页程序信息
	 * @param
	 * @return
	 */
	function programinfoAction ()
	{
		$c_version = get_config('version');//当前版本信息
		$s_version = $this -> getServerVersionAction();//服务端版本信息
		echo '<li>当前程序版本：'.$c_version['mo_version'].'（最新版本'.$s_version.' <a href="http://www.izhancms.com/category/Category/index/cid/1" target="_blank" class="f60">立即下载</a>）</li>';
	}

	/**
	 * 获取铭万官网CMS版本号
	 */
	function getServerVersionAction ()
	{
		$url = $this -> getUpdateUrl().'version.txt';
		$version = trim(@file_get_contents($url));
		$version ? '' : ($version = 'v1.0');
		return $version;
	}


	/**
	 * 获取升级文件临时目录,并返回此目录
	 */
	function getUpgradeFolder ()
	{
		$folder = dirname(DIR_ROOT).DIRECTORY_SEPARATOR.'data/upgrade';
		if(!is_dir($folder))
			MoFolder::mkRecur($folder);

		return $folder.DIRECTORY_SEPARATOR;
	}

	/**
	 * 获取服务端升级链接
	 * @return url
	 */
	public function getUpdateUrl ()
	{
		return $this -> upgrade_dir;
	}

	/**
	 * 获取升级日志表Model
	 */
	public function getUpgradeLogModel ()
	{
		return D('UpgradeLogModel');
	}
}