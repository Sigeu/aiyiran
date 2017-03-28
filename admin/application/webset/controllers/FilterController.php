<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * FilterController.php
 *
 * 网站设置——过滤设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   FilterController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class FilterController extends AdminController
{
    private $SystemModel;
	public function init ()
	{
		$this -> SystemModel = D('SystemModel');
	}

	/**
	 * 过滤设置
	 */

    public function indexAction()
    {
		$setting = array('limit'=>2,'local'=>false,'folder'=>false,'type'=>array('txt'));
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
        $filter = $this->SystemModel->getSystemParameterSet(5);
        $this->assign('filter', $filter);
        $this->display('webset/system/filter');
    }

    /* 修改顾虑规则 */
    public function correctAction()
    {
       	$root = dirname(realpath(DIR_ROOT));
	$uploadfile = getFileSavePath('keyword');
        $old = $this->SystemModel->find(array('par_name'=>'mo_replacestr'));
        if(isset($_POST['accessory'])){
			$url = current($_POST['accessory']);
            $text = preg_replace('/[\r\n]+/', ';', iconv('GBK', 'UTF-8', file_get_contents($root.$url['path'])));
        }
        if(empty($text)) {
            $arr['mo_replacestr']  = empty($_POST['mo_replacestr']) ? '' : $_POST['mo_replacestr'];
        }else{
            $arr['mo_replacestr']  = $old['par_value'] . $text.';';
        }        
	$arr['mo_replace_type'] = empty($_POST['mo_replace_type']) ? '' : intval($_POST['mo_replace_type']);
        $this->SystemModel->updateParameter($arr);
        admin_log('文字过滤', "修改文字过滤内容");  //添加日志
        $this->dialog('/webset/filter/index','success','操作成功！');
    }

    /* 修改替换内容 */
    public function replacerAction()
    {
        $arr['mo_replacer']   = empty($_POST['ther']) ? '' : $_POST['ther'];
        admin_log('文字过滤', "修改过滤内容为".$_POST['ther']);  //添加日志
        $this->SystemModel->correctFilter($arr);
    }



}