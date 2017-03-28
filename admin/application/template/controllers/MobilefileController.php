<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 手机模板文件管理
 * 
 * 文件修改记录：
 * <br>王少辰  2013-9-10 上午10:30:57 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-10 上午10:30:57
 * @filename   MobilefilemanageController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class MobilefileController extends AdminController
{
	/**
	 * 查看模板文件列表
	 */
	public function indexAction ()
	{
		$folder = get_cache('mobile_template_style','common','home');//当前手机模板目录
        if ($folder === false || empty($folder)) {
            //若缓存文件不存在或路径为空，$folder取默认值
            $folder = 'mobile/default';
        }
        $style = 'default';//当前风格,默认default
        $folder_arr = explode('/' , $folder);
        if (count($folder_arr) == 2 && $folder_arr[0] == 'mobile') {
            $style_arr = explode('/' , $folder);
            $style = end($style_arr);//去掉前缀‘mobile/’，取出当前模板风格
        }
        $tpl_model = $this -> getMobiletplModel();
		$files  = $tpl_model->getTplFileList($style);                    //模板文件列表
        $filepath = $tpl_model->getTplPathByFolder($style);
        $filelist = array();
        foreach ($files as $filename) {
            $filelist[$filename] = filemtime($filepath . $filename);
        }
        asort($filelist,SORT_NUMERIC);
        $filelist = array_reverse($filelist);
        $conf      = $tpl_model->getTemplateConfByFolder($style);           //模板配置文件
		$file_info = isset($conf['file']) ? $conf['file'] : array();         //文件列表配置
        $fileinfo = array();
		foreach($filelist as $filename => $filemtime)
		{
            $list['filename'] = $filename;
            $list['update'] = date('Y-m-d H:i:s', (int)$filemtime);
            $list['describe'] = '';
            if (isset($file_info[$filename]) && isset($file_info[$filename]['describe'])) {
                $list['describe'] = $file_info[$filename]['describe'];
            }
            $fileinfo[] = $list;
		}
        $pagesize = 20;
        $page = new ArrayPage(count($fileinfo),$pagesize);
		$pageStr = $page->getArray();
		$pageData = $page->getData($fileinfo);
		$this->assign('page',$pageStr);
		$this->assign('filelist',$pageData);

		$setting = array
		(
			'limit'       => 10,
			'type'        => array('html'),
			'local'		  => false,			  //是否显示本地图库
			'folder'      => false            //是否显示目录浏览
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this->assign('setting',$setting);
		$this->assign('folder',$style);
		$this->display('template/mobilefile/mobilefile_list');
	}

	/**
	 * 修改模板文件
	 */
	function editAction ()
	{
		$tpl_model   = $this -> getMobiletplModel();
		//提交修改文件
		if(!empty($_POST))
		{
			$folder      = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$file        = isset ( $_POST['old_file'] ) ? $_POST['old_file'] : '';
			$filename    = isset($_POST['filename']) ? $_POST['filename'] : '' ;
			$describe    = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$content     = isset($_POST['content']) ? $_POST['content'] : '' ;
			$tpl_model->updateTplContent($folder,$filename,$content);
			if($file != $filename)
			{
				$tpl_model->delTplFile($folder,$file);
			}
			$_conf = array('describe'=>$describe);
			$tpl_model->updateTplConfInfo($folder,$filename,$_conf);
			$this->dialog('/template/mobilefile/index/folder/'.$folder,'success','操作成功');
		}

		$folder      = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$file        = isset ( $_GET['file'] ) ? $_GET['file'].'.html' : '';
		$tages       = $tpl_model->getTagHelpFile();
		$tages_conf  = $tpl_model->getTagHelpFileConf();
		$filecontent = $tpl_model->getFileContent($folder,$file);

		//模板配置
		$conf      = $tpl_model->getTemplateConfByFolder($folder);           //模板配置文件
		$file_info = isset($conf['file']) ? $conf['file'] : array();         //文件列表配置
		$file_conf = isset($file_info[$file]) ? $file_info[$file] : array('describe'=>'','update'=>'');

		$this->assign('folder',$folder);
		$this->assign('file',$file);
		$this->assign('file_conf',$file_conf);
		$this->assign('tages',$tages);
		$this->assign('tages_conf',json_encode($tages_conf));
		$this->assign('filecontent',$filecontent);
		$this->display('template/mobilefile/mobilefile_edit');
	}

	/**
	 * ajax 验证文件名是否合法
	 * @return null
	 */
	function checkfilenameAction ()
	{
		$folder   = isset ( $_GET['folder'] ) ? $_GET['folder'] : '' ;
		$filename = isset ( $_GET['filename'] ) ? $_GET['filename'] : '' ;
		$oldfile  = isset ( $_GET['oldfile'] ) ? $_GET['oldfile'].'.html' : '' ;

		if($filename == $oldfile)
		{
			echo 0;
		}
		else
		{
			$path = $this -> getMobiletplModel() -> getTplPathByFolder($folder);
			if(file_exists($path.$filename))
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	/**
	 * ajax 新建模板文件 验证文件名是否合法
	 * @return null
	 */
	function checknewfilenameAction ()
	{
		$folder   = isset ( $_GET['folder'] ) ? $_GET['folder'] : '' ;
		$filename = isset ( $_GET['filename'] ) ? $_GET['filename'] : '' ;
		$path = $this -> getMobiletplModel() -> getTplPathByFolder($folder);
		if(file_exists($path.$filename))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}

	/**
	 * 删除模板文件
	 */
	function delAction ()
	{
		if(!empty($_POST))
		{
			$folder = isset ( $_POST['folder'] ) ? $_POST['folder'] : '' ;
			$file   = isset ( $_POST['file'] ) ? $_POST['file'] : '' ;
		}
		else
		{
			$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '' ;
			$file   = isset ( $_GET['file'] ) ? array($_GET['file'].'.html') : '' ;
		}
		$tpl_model = $this -> getMobiletplModel();
		foreach ($file as $key => $val )
		{
			$tpl_model->delTplFile($folder,$val);
		}
		$this->dialog('/template/mobilefile/index/folder/'.$folder,'success','操作成功');
	}

	/**
	 * 新建模板文件
	 */
	function newAction ()
	{
		$tpl_model   = $this -> getMobiletplModel();
		//提交新建文件
		if(!empty($_POST))
		{
			$folder      = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$filename    = isset($_POST['filename']) ? $_POST['filename'] : '' ;
			$describe    = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$content     = isset($_POST['content']) ? $_POST['content'] : '' ;
			$tpl_model->updateTplContent($folder, $filename, $content);//修改模板文件
			$_conf = array('describe' => $describe);
			$tpl_model->updateTplConfInfo($folder, $filename, $_conf);//修改配置文件信息
			$this->dialog('/template/mobilefile/index/folder/'.$folder,'success','操作成功');
		}

		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tages       = $tpl_model->getTagHelpFile();
		$tages_conf  = $tpl_model->getTagHelpFileConf();

		$this->assign('tages',$tages);
		$this->assign('tages_conf',json_encode($tages_conf));
		$this->assign('folder',$folder);
		$this->display('template/mobilefile/mobilefile_new');
	}

	/**
	 * ajax 移动上传文件到相应模板目录
	 */
	function uploadtplAction ()
	{
		$filelist = $_POST;
		$folder = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
		if($folder)
			unset($filelist['folder']);

		$tpl_model = $this -> getMobiletplModel();
		$target_path = $tpl_model->getTplPathByFolder($folder);
		foreach ($filelist as $val )
		{
            /*上传文件*/
			$source = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.basename($val['path']); //源文件
			$target = $target_path.$val['selfname'];              //目标文件
			if(file_exists($target))
			{
				$target = $target_path.mt_rand(1000,9999).'_'.$val['selfname'];
			}
			MoFile::moveFile($source,$target);
            
            /*更新配置文件*/
            $filename = $val['selfname'];
			$describe = '' ;
			$_conf = array('describe'=>$describe);
			$tpl_model->updateTplConfInfo($folder,$filename,$_conf);
		}
	}

	/**
	 * 获取专题模板模型服务
	 */
	function getMobiletplModel ()
	{
		return D('MobiletplModel');
	}
}