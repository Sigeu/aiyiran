<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://www.izhancms.cn)
 *
 * SpecialfileController.php
 *
 * 专题模板文件列表
 *
 *
 * @author     雷少进<leishaojin@mail.b2b.cn>   2013-08-16 15:55
 * @filename   MetaController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    iZhanCMS 2.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SpecialfileController extends AdminController
{
	/**
	 * 查看模板文件列表
	 */
	function filelistAction ()
	{
		$folder    = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';       //当前专题模板目录
		$tpl_model = $this -> getSpecialtplModel();
		$filelist  = $tpl_model->getTplFileList($folder);                    //模板文件列表
		$conf      = $tpl_model->getTemplateConfByFolder($folder);           //模板配置文件
		$file_info = isset($conf['file']) ? $conf['file'] : array();         //文件列表配置
		$tmp       = array();
		foreach($filelist as $val)
		{
			$_tmp = array('filename' => $val);
			if(isset($file_info[$val]))
			{
				$tmp[] = array_merge($_tmp,$file_info[$val]);
			}
			else
			{
				$tmp[] = array_merge($_tmp,array('describe'=>'','update'=>''));
			}
		}

		$setting = array
		(
			'limit'       => 10,
			'type'        => array('html'),
			'local'		  => false,			  //是否显示本地图库
			'folder'      => false            //是否显示目录浏览
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this->assign('setting',$setting);
		$this->assign('folder',$folder);
		$this->assign('filelist',$tmp);
		$this->display('extensions/specialfile/ext_specialfile_filelist');
	}

	/**
	 * 修改模板文件
	 */
	function editAction ()
	{
		$tpl_model   = $this -> getSpecialtplModel();
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
			$this->dialog('/extensions/specialfile/filelist/folder/'.$folder,'success','操作成功');
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
		$this->display('extensions/specialfile/ext_specialfile_edit');
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
			$path = $this -> getSpecialtplModel() -> getTplPathByFolder($folder);
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
		$path = $this -> getSpecialtplModel() -> getTplPathByFolder($folder);
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
		$tpl_model = $this -> getSpecialtplModel();
		foreach ($file as $key => $val )
		{
			$tpl_model->delTplFile($folder,$val);
		}
		$this->dialog('/extensions/specialfile/filelist/folder/'.$folder,'success','操作成功');
	}

	/**
	 * 新建模板文件
	 */
	function newfileAction ()
	{
		$tpl_model   = $this -> getSpecialtplModel();

		//提交新建文件
		if(!empty($_POST))
		{
			$folder      = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$filename    = isset($_POST['filename']) ? $_POST['filename'] : '' ;
			$describe    = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$content     = isset($_POST['content']) ? $_POST['content'] : '' ;
			$tpl_model->updateTplContent($folder,$filename,$content);
			$_conf = array('describe'=>$describe);
			$tpl_model->updateTplConfInfo($folder,$filename,$_conf);
			$this->dialog('/extensions/specialfile/filelist/folder/'.$folder,'success','操作成功');
		}

		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tages       = $tpl_model->getTagHelpFile();
		$tages_conf  = $tpl_model->getTagHelpFileConf();

		$this->assign('tages',$tages);
		$this->assign('tages_conf',json_encode($tages_conf));
		$this->assign('folder',$folder);
		$this->display('extensions/specialfile/ext_specialfile_newfile');
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

		$tpl_model = $this -> getSpecialtplModel();
		$target_path = $tpl_model->getTplPathByFolder($folder);
		foreach ($filelist as $val )
		{
			$source = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.basename($val['path']); //源文件
			$target = $target_path.$val['selfname'];              //目标文件
			if(file_exists($target))
			{
				$target = $target_path.mt_rand(1000,9999).'_'.$val['selfname'];
			}
			MoFile::moveFile($source,$target);
		}
	}

	/**
	 * 获取专题模板模型服务
	 */
	function getSpecialtplModel ()
	{
		return D('SpecialtplModel');
	}
}