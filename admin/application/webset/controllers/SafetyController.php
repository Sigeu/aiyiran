<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SafetyController.php
 *
 * 网站设置——安全设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   SafetyController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SafetyController extends AdminController
{
    private $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 安全设置
	 */

    public function indexAction()
    {
        $safesetting = $this->SystemModel->getSystemParameterSet(11);  //获取数据
        $this->assign('row', $safesetting);
        $this->display('webset/system/safety');
    }

    //更新各安全参数
    public function renewAction()
    {
        $row['mo_captcha_reg']     = empty($_POST['mo_captcha_reg']) ? '' : $_POST['mo_captcha_reg'];
        $row['mo_captcha_log']     = empty($_POST['mo_captcha_log']) ? '' : $_POST['mo_captcha_log'];
        $row['mo_captcha_com']     = empty($_POST['mo_captcha_com']) ? '' : $_POST['mo_captcha_com'];
        $row['mo_captcha_type']    = empty($_POST['mo_captcha_type']) ? '' : $_POST['mo_captcha_type'];
        $row['mo_color_rand']      = empty($_POST['mo_color_rand']) ? '' : $_POST['mo_color_rand'];
        $row['mo_lean_rand']       = empty($_POST['mo_lean_rand']) ? '' : $_POST['mo_lean_rand'];
        $row['mo_date_format']     = empty($_POST['mo_date_format']) ? '' : $_POST['mo_date_format'];
        $row['mo_time_format']     = empty($_POST['mo_time_format']) ? '' : $_POST['mo_time_format'];
        $row['mo_time_zone']       = empty($_POST['mo_time_zone']) ? '' : $_POST['mo_time_zone'];
        $row['mo_ip_forbid']       = empty($_POST['mo_ip_forbid']) ? '' : $_POST['mo_ip_forbid'];
        $row['mo_forbidden_area']  = empty($_POST['mo_forbidden_area']) ? '' : $_POST['mo_forbidden_area'];
        $row['mo_forbidden_start'] = empty($_POST['mo_forbidden_start']) ? '' : $_POST['mo_forbidden_start'];
        $row['mo_forbidden_end']   = empty($_POST['mo_forbidden_end']) ? '' : $_POST['mo_forbidden_end'];
        $row['mo_admin_log']       = empty($_POST['mo_admin_log']) ? '' : $_POST['mo_admin_log'];
        $row['mo_save_error_log']  = empty($_POST['mo_save_error_log']) ? '' : $_POST['mo_save_error_log'];
        $row['mo_max_logintime']   = empty($_POST['mo_max_logintime']) ? '' : $_POST['mo_max_logintime'];
        $this -> SystemModel -> updateParameter($row);
        admin_log('安全设置', "修改安全设置参数");  //添加日志
        $this->dialog('/webset/safety/index','success','操作成功！');
    }




}