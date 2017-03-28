<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 手机模板管理controller
 * 
 * 文件修改记录：
 * <br>王少辰  2013-9-10 上午10:27:31 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-10 上午10:27:31
 * @filename   MobiletemplatemanageController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */

class MobiletemplateController extends AdminController
{
	/**
	 * 手机模板
	 */
	public function indexAction()
	{
		$tpl_model = $this -> getMobiletplModel();
		$tpl_list  = $tpl_model->getTemplateFolder();          //所有模板目录
		$tpl_conf  = $tpl_model->getTemplateConf($tpl_list);   //所有模板目录配置文件
		$pagesize = 20;
        $page = new ArrayPage(count($tpl_list),$pagesize);
		$pageStr = $page->getArray();
		$pageData = $page->getData($tpl_conf);
		$this->assign('page',$pageStr);
		$this->assign('tpl_conf',$pageData);
		$this->display('template/mobiletpl/mobiletpl_index');
	}

	/**
	 * 查看模板
	 */
	public function viewAction ()
	{
		//提交修改
		if(!empty($_POST))
		{
			$tpl_model = $this -> getMobiletplModel();
			$folder           = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$conf['name']     = isset($_POST['name']) ? $_POST['name'] : '' ;
			$conf['describe'] = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$tpl_model->updateTplConf($folder,$conf);

			//更新模板封面
			if(isset($_POST['thumb']) && !empty($_POST['thumb']))
			{
				$tpl_model->updateTplCover($folder,$_POST['thumb']);
			}

			admin_log('修改手机模板', '修改了手机模板'.$folder);
			$this->dialog('/template/mobiletemplate/index','success','操作成功');
		}
        
		//查看模板
		$folder    = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tpl_model = $this -> getMobiletplModel();
		$tpl_conf  = $tpl_model->getTemplateConfByFolder($folder);

		$cover = $tpl_model->getTplCoverImage($folder);
		$this->assign('cover',$cover);
		$this->assign('tpl_conf',$tpl_conf);

		//上传参数
        $allow_type = $this -> getAllowType(1);
		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  $allow_type,
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true,
			'time_name'   =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this->assign('setting', $setting);
		$this->display('template/mobiletpl/mobiletpl_view');
	}

	/**
	 * 导出模板
	 */
	function exportAction ()
	{
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tpl_model = $this -> getMobiletplModel();
	 	$res = $tpl_model->createZipByFolder($folder);
		if($res)
		{
			load::load_class('MoDownload',DIR_BF_ROOT.'classes',0);
			$download = new MoDownload('zip',false);
			if(!$download->downloadfile($res))
			{
				$this -> dialog('/template/mobiletemplate/index','error',$download->geterrormsg());
			}
		}
		else
		{
			$this -> dialog('/template/mobiletemplate/index','error','下载失败');
		}
	}
    
    /**
	 * 替换模板
	 */
	public function replaceAction ()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		//暂停当前模板
		$nowstyle =  get_cache('mobile_template_style','common','home');
        if (!$nowstyle) {
            $nowstyle = 'moblie/default';
        }
		$oldsetArr = $this->import_style_config($nowstyle, true);
		$this->setFlag($nowstyle, $oldsetArr, 0);
		//设置模板使用中
		$stylename = Controller::getParams('name');
        $stylename = 'mobile/'.$stylename;
		$nowsetArr = $this->import_style_config($stylename,true);
		$this->setFlag($stylename, $nowsetArr, 1);
		set_cache('mobile_template_style', $stylename, 'common', 0, "home"); //更新模板样式缓存
		admin_log('替换手机模板', '替换了手机模板'.$nowstyle);
		$this->dialog('/template/mobiletemplate/index/page/'.$nowpage,'info',"请检查所有模型中的栏目首页、栏目内容页及栏目列表页， 文章和商品的模板文件在新的模板风格中是否存在，以免出现404错误");
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
	 * 获取手机模板模型服务
	 */
	function getMobiletplModel ()
	{
		return D('MobiletplModel');
	}
}