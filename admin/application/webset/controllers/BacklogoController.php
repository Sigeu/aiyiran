<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * backlogoController.php
 *
 * 后台logo设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   backlogoController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class BacklogoController extends AdminController
{
    public $logoModel;
    public $SystemModel;
	public function init ()
	{
		$this -> logoModel = D('logoModel');
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 后台LOGO设置
	 */
	public function indexAction()
	{
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
        $setting = array('limit'=>2,'local'=>false,'folder'=>false,'type'=>explode('|','png'));
		$setting['setting'] = base64_encode(serialize($setting));

		$empower = $this->checkLicense(HOST_NAME); //判断授权接口

		$this->assign('empower',$empower);
		$this->assign('setting',$setting);

		$this->display('webset/backstage/logo');
	}

    //上传LOGO
    public function updateLogoAction()
    {
		$root = dirname(realpath(DIR_ROOT));
		$uploadfile = getFileSavePath('logo');

        if($this->checkLicense(HOST_NAME) ==1) {  //已授权
            if(isset($_POST['accessory'])){
                $logo_info = current($_POST['accessory']);
                copy($root.$logo_info['path'], $root.'/admin/template/images/logo.png');
                copy($root.$logo_info['path'], $root.'/admin/template/images/logoB.png');
                copy($root.$logo_info['path'], $root.'/admin/template/images/logoG.png');
                copy($root.$logo_info['path'], $root.'/admin/template/images/logoR.png');
                $this->dialog('/webset/backlogo/index','success','操作成功！');
            }else{
                $this->dialog('/webset/backlogo/index','fail','修改失败！');
            }
        }
    }



}