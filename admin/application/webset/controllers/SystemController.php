<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SystemController.php
 *
 * 系统设置——站点设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   SystemController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SystemController extends AdminController
{
    public $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 系统设置
	 */
	public function indexAction()
	{
        //echo "<pre>";print_r($_SESSION);
        //admin_log('测试操作', '测试备注');  //添加日志

        $parameter = $this->SystemModel->getSystemParameterSet(1);  //获取系统变量参数
        
		$template = template_stylelist(1);  //遍历模板信息
		$this->assign('template',$template);
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
		$setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this -> assign('is_license',$this -> checkLicense(HOST_NAME));
        $this->assign('parameter', $parameter);
        $this->assign('tittle','站点设置');
		$this->display('webset/system/website');
	}

    //修改配置
    public function updateParameterAction()
    {

        $parameter['mo_logo_alt']     = empty($_POST['mo_logo_alt']) ? '' : $_POST['mo_logo_alt'];
		$root = dirname(realpath(DIR_ROOT));
		$uploadfile = getFileSavePath('logo');
        if(isset($_POST['accessory']))
		{
			$logo_info = current($_POST['accessory']);
            if(copy($root.$logo_info['path'],$uploadfile['base'] . DS . basename($logo_info['path'])))
			{
                $parameter['mo_logo_dir'] = '/logo/'. basename($logo_info['path']);
            }
            $parameter['mo_logo_alt'] = $logo_info['alt'];
        }

        $parameter['mo_webname']     = empty($_POST['mo_webname']) ? '' : $_POST['mo_webname'];
        $parameter['mo_basehost']    = empty($_POST['mo_basehost']) ? '' : $_POST['mo_basehost'];
        $parameter['mo_title']       = empty($_POST['mo_title']) ? '' : $_POST['mo_title'];
        $parameter['mo_keywords']    = empty($_POST['mo_keywords']) ? '' : $_POST['mo_keywords'];

        $parameter['mo_beian']       = empty($_POST['mo_beian']) ? '' : $_POST['mo_beian'];
        $parameter['mo_description'] = empty($_POST['mo_description']) ? '' : $_POST['mo_description'];
        $parameter['mo_powerby']     = empty($_POST['mo_powerby']) ? '' : $_POST['mo_powerby'];
        $parameter['mo_shut_down']   = empty($_POST['mo_shut_down']) ? '' : $_POST['mo_shut_down'];
        $parameter['mo_shut_reason'] = empty($_POST['mo_shut_reason']) ? '' : $_POST['mo_shut_reason'];

		isset($_POST['mo_izhan_copyright'])
		&&(in_array($_POST['mo_izhan_copyright'],array('Y','N')))
		&&($parameter['mo_izhan_copyright'] = $_POST['mo_izhan_copyright']);

        admin_log('网站设置', "修改站点设置");  //添加日志
        $this->SystemModel->updateParameter($parameter);
		$this -> clearCompileCache();
        $this -> dialog('/webset/system/index','success','操作成功！');

    }

	/**
	 * 清除模板编译缓存
	 */
	function clearCompileCache ()
	{
		$compile_path = PATH_DATA.'cache'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
		$file = MoFolder::recurFolder($compile_path);
		$files = MoFolder::mergeFileList($file,MoFolder::READ_FILE);
		foreach ($files as $key => $val )
		{
			@unlink($val);
		}
	}
}