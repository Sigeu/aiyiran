<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * WatermarkController.php
 *
 * 系统设置——水印设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   WatermarkController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class WatermarkController extends AdminController
{
    private $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

    //水印设置
    public function indexAction()
    {
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
        $setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
        $watermark = $this->SystemModel->getSystemParameterSet(8);  //添加水印相关设置
        $this->assign('res', $watermark);
        $this->display('webset/system/watermark');

    }

    /* 更改操作 添加水印 */
    public function addMarkAction()
    {
        /*
        $absolute = getTempPath();
        if(isset($_POST['accessory'])) {
            $arr = $_POST['accessory'];
            foreach ($arr AS $value){
                $logo = $value;
            }
            $name = $logo['savename'];
            $filename = $logo['filename'];
            $temp = $absolute . DS . $filename;
            $uploadfile = dirname($absolute).'/logo/'.$filename;
            if(copy($temp,$uploadfile)) {
                $parameter['mo_markimage_url'] = '/static/uploadfile/logo/'.$filename;
            }
        }
        */

		$root = dirname(realpath(DIR_ROOT));
		$uploadfile = getFileSavePath('logo');
        if(isset($_POST['accessory'])){
			$logo_info = current($_POST['accessory']);
            if(@copy($root.$logo_info['path'], $uploadfile['base']. DS .basename($logo_info['path'])))
			{
                $parameter['mo_markimage_url'] = '/static/uploadfile/logo/'.basename($logo_info['path']);
            }
        }
        $parameter['mo_start_watermark'] = empty($_POST['mo_start_watermark']) ? '' : $_POST['mo_start_watermark'];
        $parameter['mo_watermark_type']  = empty($_POST['mo_watermark_type']) ? '' : $_POST['mo_watermark_type'];
        $parameter['mo_img_diaphaneity'] = empty($_POST['mo_img_diaphaneity']) ? 0 : trim(str_replace("%", "", $_POST['mo_img_diaphaneity']));
        $parameter['mo_img_scaling']     = empty($_POST['mo_img_scaling']) ? 0 : trim(str_replace("%", "", $_POST['mo_img_scaling']));
        $parameter['mo_mark_content']    = empty($_POST['mo_mark_content']) ? '' : $_POST['mo_mark_content'];
        $parameter['mo_word_size']       = empty($_POST['mo_word_size']) ? '' : $_POST['mo_word_size'];
        $parameter['mo_word_color']      = empty($_POST['mo_word_color']) ? '' : $_POST['mo_word_color'];
        $parameter['mo_mark_position']   = empty($_POST['mo_mark_position']) ? '' : $_POST['mo_mark_position'];
        $this->SystemModel->updateParameter($parameter);
        admin_log('水印设置', "修改水印设置参数");  //添加日志
        $this->dialog('/webset/Watermark/index','success','操作成功！');
    }



}