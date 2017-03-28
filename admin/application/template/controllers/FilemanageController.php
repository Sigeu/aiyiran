<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * FilemanageControlller.php
 * 
 * 模板文件管理类
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-6 下午2:55:29
 * @filename   FileControlller.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');

class FilemanageController extends AdminController
{
	public function init()
	{
		
		//判断登陆
		//判断权限
	}
	/**
	 * 模板文件列表页
	 */
	public function indexAction ()
	{
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		$setting = array
		(
			'limit'       =>  10,
			'type'        =>  array('html'),
			'local'       =>  false,
			'folder'      =>  false,
			'iswatermark' =>  false
		);	
		$setting['setting'] = base64_encode(serialize($setting));
		//重组URl，防止改变路由设置找不到路径
		$nowpage = Controller::get('page',1);
		$pagesize = 20;
		$urlArr = array(
			'delOneUrl' => $this->createUrl('template/Filemanage/deleteOne/page/'.$nowpage),
			'delUrl' => $this->createUrl('template/Filemanage/delete/page/'.$nowpage),    
			'indexUrl' => 	$this->createUrl('template/Filemanage/index'),
			'complateUrl' => $this->createUrl('template/Filemanage/complateConfig/page/'.$nowpage),
			'updateUrl' => $this->createUrl('template/Filemanage/update/page/'.$nowpage),
			'addUrl' => $this->createUrl('template/Filemanage/add/page/'.$nowpage),	
			'previewUrl' => HOST_NAME.'template'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR,
		);
		$hasper = 1;

		if(!in_array('/template/filemanage/uploadTemplate',$_SESSION['alllinks']))
		{
			$hasper = 1;
		}
		else
		{				
			if(!in_array('/template/filemanage/uploadTemplate',$_SESSION['mylinks'])&&$_SESSION['roleid']!=1)
			{
				$hasper = 0;
			}
		}	
		$this->assign('hasper',$hasper);
		$filelist = template_filelist($style);   //文件列表
		//分页开始
		$page = new ArrayPage(count($filelist),$pagesize);
		$pageStr = $page->getArray();
		$pageData = $page->getData($filelist);
		$this->assign('page',$pageStr);
		//分页结束
		
		$configArr = $this->import_style_config($style,true); //引入配置文件的数组
		$this->assign('authkey',authkey('10,html,,,2,file'));
		$this->assign('filelist',$pageData);
		$this->assign('urlArr',$urlArr);
		$this->assign('setting',$setting);
		$this->assign('configArr',$configArr['file']);
		$this->display('template/filemanage/index');
	}
	
	/**
	 * 删除模板文件
	 */
	public function deleteAction()
	{
		$nowpage = Controller::get('page',1);
		$fileArr = Controller::getParams('filename');
		if(!is_array($fileArr))
		{
			$fileArr = array($fileArr);
		}
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		$configArr = $this->import_style_config($style,true); //引入配置文件的数组
		foreach($fileArr as $key => $value)
		{
			$value = strpos($value, '.html') ? $value : $value . '.html';
			if($configArr['file'][$value]['system'] != 1)
			{
				unset($configArr['file'][$value]);
				unlink(getDirView().$style.DIRECTORY_SEPARATOR.$value);
				admin_log('删除模板', '删除了模板'.$value);
			}
			else 
			{
				$this->dialog('/template/Filemanage/index/page/'.$nowpage,'error',$configArr['file'][$value].'为系统模板文件，不能删除');
			}
		}
		file_put_contents($this->import_style_config($style,false), '<?php return '.var_export($configArr, true).';?>');
		$this->dialog('/template/Filemanage/index/page/'.$nowpage,'success','操作成功');
	}
	
	/**
	 * 删除单个模板文件
	 
	public function deleteOneAction()
	{
		$nowpage = Controller::get('page',1);
		$filename = Controller::get('filename');
		$filename = strpos($filename, '.html') ? $filename : $filename . '.html';
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		unlink(getDirView().$style.DIRECTORY_SEPARATOR.$filename);
		$this->update();
		$this->redirect($this->createUrl('template/Filemanage/index/page/'.$nowpage));
	}*/
	
	/**
	 * 更新模板配置文件
	 */
	public function complateConfigAction()
	{
		$nowpage = Controller::get('page',1);
		$this->update();
		$this->dialog('/template/Filemanage/index/page/'.$nowpage,'success','更新成功');
	}
	
	/**
	 * 修改模板文件 
	 */
	public function updateAction()
	{
		$nowpage = Controller::get('page',1);
		$filename = Controller::get('filename');
		$filename = strpos($filename, '.html') ? $filename : $filename . '.html';
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		$content = file_get_contents(getDirView().$style.DIRECTORY_SEPARATOR.$filename);
		$configArr = $this->import_style_config($style,true); //引入配置文件的数组
		$tagHelpFile = $this->getTagHelpFile(true);
		$urlArr = array(
			'getTagUrl' => $this->createUrl('template/Filemanage/getTagUrl/page/'.$nowpage),
			'saveUrl' => 	$this->createUrl('template/Filemanage/updateSave/page/'.$nowpage),
		);
		$this->assign('urlArr',$urlArr);
		$this->assign('tagHelp',$tagHelpFile);
		$this->assign('filename',$filename);
		$this->assign('fileinfo',!empty($configArr['file'][$filename]) ? $configArr['file'][$filename] : array());
		$this->assign('content',$content);
		$this->display('template/filemanage/update');
		//$this->redirect($this->createUrl('template/Templatemanage/index/page/'.$nowpage));
	}
	/**
	 * 修改模板文件保存
	 */
	public function updateSaveAction()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		
		if(strtolower($_SERVER['REQUEST_METHOD'])=='post')
		{
			$array = array(
				'name' => Controller::post('filename'),
				'content' => $_POST['content'],
			);
			
			
		    $style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
			$configArr = $this->import_style_config($style,true);
			$configArr['file'][$array['name']] = array('describe' =>Controller::post('describe'),'system' => Controller::post('system',0));
			file_put_contents($this->import_style_config($style,false), '<?php return '.var_export($configArr, true).';?>');
			file_put_contents(getDirView().$style.DIRECTORY_SEPARATOR.$array['name'],$array['content']);
		}
		admin_log('修改模板', '修改了模板'.Controller::post('filename'));
		$this->dialog('/template/Filemanage/index/page/'.$nowpage,'success','操作成功');
	}
	
	/**
	 * 添加模板文件:模板页面相同，保存URL不同
	 */
	public function addAction()
	{
		$nowpage = Controller::get('page',1);
		$tagHelpFile = $this->getTagHelpFile(true);		
		$urlArr = array(
		   'getTagUrl' => $this->createUrl('template/Filemanage/getTagUrl/page/'.$nowpage),
		   'saveUrl' => $this->createUrl('template/Filemanage/addSave/page/'.$nowpage),
		   'checkFileNameUrl' => $this->createUrl('template/Filemanage/checkFileName'),
		);
		
		$this->assign('urlArr',$urlArr);
		$this->assign('tagHelp',$tagHelpFile);
		$this->display('template/filemanage/add');
		//$this->redirect($this->createUrl('template/Templatemanage/index/page/'.$nowpage));
	}
	
	/**
	 * 添加保存文件
	 */
	public function addSaveAction()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		
		if(strtolower($_SERVER['REQUEST_METHOD'])=='post')
		{
		 	$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		 	$configArr = $this->import_style_config($style,true);
			$configArr['file'][Controller::post('filename')] = array('describe' => Controller::post('describe'),'system' => 0);
			file_put_contents($this->import_style_config($style,false), '<?php return '.var_export($configArr, true).';?>');
			MoFile::write(getDirView().$style.DIRECTORY_SEPARATOR.Controller::post('filename'), Controller::post('content'));
				
		}
		admin_log('添加模板', '添加了模板'.Controller::post('filename'));
		$this->dialog('/template/Filemanage/index/page/'.$nowpage,'success','操作成功');
		
	}
	/**
	 * 
	 * @return array 标签帮助文件
	 * @return array 标签帮助文件
	 */
	public  function getTagHelpFile($basename=true)
	{
		$tagHelpFile = glob(DIR_TAG.'help'.DIRECTORY_SEPARATOR.'*.php');
		if($basename)
		{
			foreach($tagHelpFile as $key => $value)
			{
				$newtagHelpFile[] = substr(basename($value), 0  ,strpos(basename($value), '.'));
			}		
			return $newtagHelpFile;
		}
		
		return $tagHelpFile;
	}
	
	/**
	 *
	 * 标签帮助
	 */
	public  function getTagUrlAction()
	{
		$tagname = Controller::post('tagname');
		$tagHelpArr = include DIR_TAG.'help'.DIRECTORY_SEPARATOR.$tagname.'.php';
		$params = '';
		foreach($tagHelpArr['params'] as $key => $value)
		{
			$params.= $key.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'<br>';
		}
		$str = "<th valign='top'>&nbsp; <b>标签说明</b>：</th>
                  <td> 
                  <div class='pubTabelBot'> <b>标签名称</b>： ".$tagHelpArr['name']."<br></br><b>标签功能</b>:　".$tagHelpArr['describe']."<br></br>  
				   <b>使用实例</b>：<textarea class='Iw450 Ih80' style='height:100px;' readonly>".$tagHelpArr['example']."</textarea><br></br>
            	   <b>参数说明</b>：<br>".$params."</div>
                  <input type='hidden' id='oldtag' value='".$tagname."'></td>";
		exit($str);
	}
	/**
	 * 验证文件名的合法性
	 * 1:文件存在，0文件不存在
	 */
	public function checkFileNameAction()
	{
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		$filename = Controller::get('filename');
		if(!file_exists(getDirView().$style.DIRECTORY_SEPARATOR.$filename))
		{
			exit('0');
		}
		else
		{
			exit('1');
		}
	}
	
	/**
	 * 上传模板文件
	 * 1:文件存在，0文件不存在
	 */
	public function uploadTemplateAction()
	{
		$filename = $_GET['filename'];
		$savename = $_GET['savename'];
		$fileArr = explode('|',$filename);
		$saveArr = explode('|',$savename);
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		if(!empty($fileArr))
		{
			for($i=0;$i<count($fileArr);$i++)
			{
				if(!file_exists(getDirView().$style.DS.$saveArr[$i]))
				{
					admin_log('上传模板', '上传了模板'.$saveArr[$i]);
					rename(DIR_UPLOAD_TEMP.$fileArr[$i], getDirView().$style.DS.$saveArr[$i]);
				}
				else
				{
					exit($saveArr[$i]);
				}
			}
			$this->update();
			exit('1');
		}
		else
		{
			exit('2');
		}
		
	}
	
	/**
	 * 更新配置文件数组
	 */
	public function update()
	{
		$style  = get_cache('template_style','common','home') ? get_cache('template_style','common','home') : DEFAULT_STYLE;
		$configArr = $this->import_style_config($style,true); //引入配置文件的数组
		$filelist = template_filelist($style);   //文件列表
		$newFileArr = array();
		foreach($filelist as $key=>$value)
		{
			foreach($configArr['file'] as $conkey=>$convalue)
			{
				if($key==$conkey)
				{
					$newFileArr[$key] = !empty($convalue) ? $convalue : array('describe'=> '','system' => 0);
				}
				if(!array_key_exists($key, $configArr['file']))
				{
					$newFileArr[$key] = array('describe'=> '','system' => 0);
				}
			}
		}
		$configArr['file'] = $newFileArr;
		file_put_contents($this->import_style_config($style,false), '<?php return '.var_export($configArr, true).';?>');
	}
	
}