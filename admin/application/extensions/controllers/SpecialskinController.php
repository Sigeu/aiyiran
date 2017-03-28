<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://www.izhancms.cn)
 *
 * SpecialskinController.php
 *
 * 专题模板皮肤列表
 *
 *
 * @author     雷少进<leishaojin@mail.b2b.cn>   2013-08-23 2013-08-23
 * @filename   MetaController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    iZhanCMS 2.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SpecialskinController extends AdminController
{
	/**
	 * 专题皮肤
	 */
	public function skinlistAction()
	{
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : 'default' ;
		$tpl_model = $this -> getSpecialtplModel();
		$skin_list = $tpl_model->getTemplateSkinFolder($folder);//专题模板皮肤列表
		$skin_conf = $tpl_model->getTemplateSkinConf($folder,$skin_list);   //所有模板目录配置文件

        foreach ($skin_conf as $key=>$val){
            $skin_conf[$key]['special_number'] = $tpl_model->getSpecialNumbers($val['version']);
        }
		$this->assign('folder',$folder);
		$this->assign('skin_conf',$skin_conf);
		$this->display('extensions/specialskin/ext_specialskin_skinlist');
	}

	/**
	 * 导出模板皮肤
	 */
	function exportAction ()
	{
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$skin   = isset ( $_GET['skin'] ) ? $_GET['skin'] : '';
		$tpl_model = $this -> getSpecialtplModel();
	 	$res = $tpl_model->createSkinZip($folder,$skin);
		if($res)
		{
			load::load_class('MoDownload',DIR_BF_ROOT.'classes',0);
			$download = new MoDownload('zip',false);
			if(!$download->downloadfile($res))
			{
				$this -> dialog('/extensions/specialskin/skinlist/folder/'.$folder,'error',$download->geterrormsg());
			}
		}
		else
		{
			$this -> dialog('/extensions/specialskin/skinlist/folder/'.$folder,'error','下载失败');
		}
	}

	/**
	 * 查看皮肤
	 */
	function viewAction ()
	{
		//提交修改
		$tpl_model = $this -> getSpecialtplModel();
		if(!empty($_POST))
		{
			$folder           = isset ( $_POST['folder'] ) ? $_POST['folder'] : '';
			$skin             = isset ( $_POST['skin'] ) ? $_POST['skin'] : '';
			$conf['name']     = isset($_POST['name']) ? $_POST['name'] : '' ;
			$conf['describe'] = isset($_POST['describe']) ? $_POST['describe'] : '' ;
			$tpl_model->updateTplSkinConf($folder,$skin,$conf);

			//更新模板封面
			if(isset($_POST['thumb']) && !empty($_POST['thumb']))
			{
				$tpl_model->updateTplSkinCover($folder,$skin,$_POST['thumb']);
			}

			admin_log('修改专题模板皮肤', '修改了专题模板皮肤'.$folder.'/'.$skin);
			$this->dialog('/extensions/specialskin/skinlist/folder'.$folder,'success','操作成功');
		}

		//查看模板
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$skin   = isset ( $_GET['skin'] ) ? $_GET['skin'] : '';

		$skin_list = $tpl_model->getTemplateSkinFolder($folder);//专题模板皮肤列表
		$skin_conf = $tpl_model->getTemplateSkinConf($folder,$skin_list);
		$skin_conf = $skin_conf[$skin];

		$cover = $tpl_model->getSkinCoverImage($folder,$skin);
		$this->assign('cover',$cover);
		$this->assign('folder',$folder);
		$this->assign('skin_conf',$skin_conf);
                
        $allow_type = $this -> getAllowType(1);
		//上传参数
		$setting = array
		(
			'limit'       =>  2,
			'type'        => $allow_type,
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true,
			'time_name'   =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this->assign('setting',$setting);
		$this->display('extensions/specialskin/ext_specialskin_view');
	}

	/**
	 * 删除模板皮肤
	 */
	function delAction ()
	{
		$folder = isset ( $_GET['folder'] ) ? $_GET['folder'] : '';
		$skin   = isset ( $_GET['skin'] ) ? $_GET['skin'] : '';

		$this -> getSpecialtplModel()->delTplSkin($folder,$skin);
		$this->dialog('/extensions/specialskin/skinlist/folder/'.$folder,'success','操作成功');
	}

	/**
	 * 获取专题模板模型服务
	 */
	function getSpecialtplModel ()
	{
		return D('SpecialtplModel');
	}
}