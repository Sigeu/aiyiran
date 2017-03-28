<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://www.izhancms.cn)
 *
 * SpecialtplController.php
 *
 * 专题模板列表
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

class SpecialtplController extends AdminController
{
	/**
	 * 专题模板
	 */
	public function indexAction()
	{
		$tpl_model = $this -> getSpecialtplModel();
		$tpl_list  = $tpl_model->getTemplateFolder();          //所有模板目录
		$tpl_conf  = $tpl_model->getTemplateConf($tpl_list);   //所有模板目录配置文件

		$this->assign('tpl_conf',$tpl_conf);
		$this->display('extensions/specialtpl/ext_specialtpl_index');
	}

	/**
	 * 查看模板
	 */
	function viewAction ()
	{
		//提交修改
		if(!empty($_POST))
		{
			$tpl_model = $this -> getSpecialtplModel();
			$folder           = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$conf['name']     = isset($_POST['name']) ? $_POST['name'] : '' ;
			$conf['describe'] = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$tpl_model->updateTplConf($folder,$conf);

			//更新模板封面
			if(isset($_POST['thumb']) && !empty($_POST['thumb']))
			{
				$tpl_model->updateTplCover($folder,$_POST['thumb']);
			}

			admin_log('修改专题模板', '修改了专题模板'.$folder);
			$this->dialog('/extensions/specialtpl/index','success','操作成功');
		}

		//查看模板
		$folder    = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tpl_model = $this -> getSpecialtplModel();
		$tpl_conf  = $tpl_model->getTemplateConfByFolder($folder);

		$cover = $tpl_model->getTplCoverImage($folder);
		$this->assign('cover',$cover);
		$this->assign('tpl_conf',$tpl_conf);
                
        $allow_type = $this -> getAllowType(1);
		//上传参数
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
		$this->assign('setting',$setting);
		$this->display('extensions/specialtpl/ext_specialtpl_view');
	}

	/**
	 * 导出模板
	 */
	function exportAction ()
	{
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$tpl_model = $this -> getSpecialtplModel();
	 	$res = $tpl_model->createZipByFolder($folder);
		if($res)
		{
			load::load_class('MoDownload',DIR_BF_ROOT.'classes',0);
			$download = new MoDownload('zip',false);
			if(!$download->downloadfile($res))
			{
				$this -> dialog('/extensions/specialtpl/index','error',$download->geterrormsg());
			}
		}
		else
		{
			$this -> dialog('/extensions/specialtpl/index','error','下载失败');
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