<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * TemplateController.php
 *
 * 模板类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2012-12-26 下午2:10:42
 * @filename   TemplateController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class TemplatemanageController extends AdminController
{
	public function init()
	{
		//判断登陆
		//判断权限
	}
	/**
	 * 模板风格列表页
	 */
	public function indexAction ()
	{
		//重组URl，防止改变路由设置找不到路径
		$nowpage = Controller::get('page',1);
		$pagesize = 20;
		$urlArr = array(
			'detailUrl' => $this->createUrl('template/Templatemanage/detail/page/'.$nowpage),
			'exportUrl' => $this->createUrl('template/Templatemanage/export/page/'.$nowpage),
			'replaceUrl' => $this->createUrl('template/Templatemanage/replace/page/'.$nowpage),
			'indexUrl' => 	$this->createUrl('template/Templatemanage/index')
		);
		$stylelist = template_stylelist(1);
		$page = new ArrayPage(count($stylelist),$pagesize);
		$pageStr = $page->getArray();
		$pageData = $page->getData($stylelist);
		$this->assign('page',$pageStr);
		$this->assign('stylelist',$pageData);
		$this->assign('urlArr',$urlArr);
		$this->display('template/manage/index');
	}
	/**
	 * 替换模板
	 */
	public function replaceAction ()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		//暂停当前模板
		$nowstyle =  get_cache('template_style','common','home');
		$oldsetArr = $this->import_style_config($nowstyle,true);
		$this->setFlag($nowstyle,$oldsetArr,0);

		//设置模板使用中
		$stylename = Controller::getParams('name');
		$nowsetArr = $this->import_style_config($stylename,true);
		$this->setFlag($stylename,$nowsetArr,1);
		set_cache('template_style',$stylename,'common',0,"home"); //更新模板样式缓存
		//echo getDirView().$nowstyle.'/'.$nowstyle.'.config.php';
		admin_log('替换模板', '替换了模板'.$nowstyle);
		$this->dialog('/template/Templatemanage/index/page/'.$nowpage,'info',"请检查所有模型中的栏目首页、栏目内容页及栏目列表页， 文章和商品的模板文件在新的模板风格中是否存在，以免出现404错误");
	}

	/**
	 * 查看模板
	 */
	public function detailAction ()
	{
		$stylename = Controller::get('name');
		$nowpage = Controller::get('page',1); //（当前页码）
		$setArr = $this->import_style_config($stylename,true);
		$serArr['identify'] = $stylename;
        $allow_type = $this -> getAllowType(1);
		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  $allow_type,
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this->assign('saveUrl',$this->createUrl('template/Templatemanage/save/page/'.$nowpage));//保存页面url（当前页码）
		$this->assign('setArr',$setArr);
		$this->assign('setting',$setting);
		$this->display('template/manage/detail');
	}
	/**
	 * 保存模板
	 */
	public function saveAction ()
	{

		if(strtolower($_SERVER['REQUEST_METHOD'])=='post')
		{
			$nowpage = Controller::get('page',1); //（当前页码）
			$timedir = date(get_mo_config('mo_addon_savetype'),time());
			$array = array(
				'name' => Controller::post('name'),
				'identify' => Controller::post('identify'),
				'image' => $_POST['info']['thumb'][1]['filename'],
				'describe' => Controller::post('describe'),
				'disable' => $_POST['disable'] == 1  ? 1 : 0,
			);
			$templateDir = DIR_UPLOADFILE.'template'.DS.basename($array['image']);
			if(file_exists(DIR_UPLOAD_TEMP.$array['image']))
			{
				MoFile::moveFile(DIR_UPLOAD_TEMP.$array['image'], $templateDir);
				MoFile::unlinkFile(DIR_UPLOADFILE.'template'.DS.Controller::post('oldimage'));
			}
			else if(file_exists($_SERVER['DOCUMENT_ROOT'].$array['image']))
			{
				@copy($_SERVER['DOCUMENT_ROOT'].$array['image'], $templateDir);
				MoFile::unlinkFile(DIR_UPLOADFILE.'template'.DS.Controller::post('oldimage'));
			}else{

			}
			$array['image'] = basename($array['image']);
			$array = array_merge($this->import_style_config($array['identify'],true),$array);
			file_put_contents($this->import_style_config($array['identify'],false), '<?php return '.var_export($array, true).';?>');
		    admin_log('修改模板', '修改了模板'.Controller::post('name'));
		}
		$this->dialog('/template/Templatemanage/index/page/'.$nowpage,'success','操作成功');
	}

	/**
	 * 导出模板
	 */
	public function exportAction ()
	{
		//$zip = new ZipOrUnzip();
		$style = Controller::get('name');
		$fileDir = getDirView().$style.DIRECTORY_SEPARATOR;
		$fileName = $style.'.zip';
		ob_start();
		//Error_Reporting(0);
		//if($this->isZip($fileDir.$fileName, $fileDir))
		//{
			//$zip -> Zip($fileDir , $fileDir.$fileName);
		//}
		$file =  HOST_NAME.'template/'.$style.'/'.$fileName;
		//header("Content-type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=".$fileName);
		//echo $fileDir.$fileName;die;
		//readfile($fileDir.$fileName);
		//go_back();
	   // ob_end_clean();
	    admin_log('导出模板', '导出了模板'.$style);
        Header("HTTP/1.1 303 See Other");
		Header("Location: $file");

		//header("Content-type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=".$fileName);
		//readfile($fileDir.$fileName);
		//@unlink($fileDir.$fileName); 删除压缩文件
	}


	/**
	 * 设置模板状态开始
	 * @param string $style
	 * @param string $disable
	 */
	public function setFlag($stylename='default',$nowsetarr=array(),$disable=1)
	{
		if (file_exists($this->import_style_config($stylename,false)))
		{
			$nowsetarr = empty($nowsetarr) ? $this->import_style_config($stylename,true) : $nowsetarr;
			$nowsetarr['identify'] = $stylename;
			$nowsetarr['disable'] = $disable;
		}
		else
		{
			$nowsetarr = empty($nowsetarr) ? array('name'=>'未知模板','disable'=>$disable, 'identify'=>$stylename) : $nowsetarr ;
		}
		file_put_contents($this->import_style_config($stylename,false), '<?php return '.var_export($nowsetarr, true).';?>');
	}

	/**
	 * 设置模板状态开始
	 * @param string $zipFile 压缩文件
	 * @param string $dir   模板目录
	 * @param boolen ture:需要重新压缩，false 不需要重新压缩
	 */
	public function isZip($zipFile,$dir)
	{
		return (is_file($zipFile) && (filemtime($zipFile) >= @filemtime($dir))) ? false : true;
	}
}