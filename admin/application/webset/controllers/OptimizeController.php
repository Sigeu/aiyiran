<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * FilterController.php
 *
 * 网站设置——性能优化
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   OptimizeController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class OptimizeController extends AdminController
{
    private $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 性能优化
	 */

    public function indexAction()
    {
        $optimize = $this->SystemModel->getSystemParameterSet(6);
        $this->assign('optimize', $optimize);
        $this->display('webset/system/optimize');
    }

    /* 更改操作 */
    public function doneAction()
    {
        $parameter['mo_arcautosp']      = empty($_POST['mo_arcautosp']) ? '' : $_POST['mo_arcautosp'];
        $parameter['mo_arcautosp_sum']  = empty($_POST['mo_arcautosp_sum']) ? '' : $_POST['mo_arcautosp_sum'];
        $parameter['mo_arcautosp_size'] = empty($_POST['mo_arcautosp_size']) ? '' : $_POST['mo_arcautosp_size'];
        $parameter['mo_search_time']    = empty($_POST['mo_search_time']) ? '' : $_POST['mo_search_time'];
        $this->SystemModel->updateParameter($parameter);
        admin_log('性能优化', "性能优化参数设置");  //添加日志
        $this->dialog('/webset/Optimize/index','success','操作成功！');
    }

}