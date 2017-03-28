<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialListController.php
 *
 * 专题列表前台展示
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-11-1 下午1:21:46
 * @filename   SpecialListController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialListController extends HomeController
{
    public static $_base_set;  //专题基本设置

    protected function initView()
    {
        app::loadFile(DIR_BF_ROOT.'base'.DIRECTORY_SEPARATOR.'Template.php');
        self::$_view = Template::getInstance('special_');
        self::$_style = self::$_view -> getStyle('special_');
    }

    public $SpecialModel; //专题模型
    public $SpecialTypeModel; //专题分类模型


	public function init()
	{
		$this->SpecialModel = D('Special');
        $this->SpecialTypeModel = D('SpecialType');
	}

	/**
	 * 管理预览
	 */
	public function indexAction ()
    {
		$cid=0;
		$pid=0;

		$seo = array(
			'title'=>get_mo_config('title'),
			'keywords'=> get_mo_config('keywords'),
			'description'=>get_mo_config('description'),
		);

		$list = $this->SpecialModel->findAll(); //获取专题列表

        foreach ($list as $key=>$val){
            $list[$key]['type_name'] = $this->SpecialTypeModel->find(array('id'=>$val['type_id']), true, 'type_name');
        }

		$hot = $this->SpecialModel->getTenHot(); //获取10条热点高点击专题

		$count = $this->SpecialModel->findCount();

		$pagesize = 20;

		$page = new Page($count, $pagesize);

		$from = $page->firstRow;

		$limit = $from.','.$pagesize;

		$pagestr = $page->show();

        include $this->display('special_list.html');
    }



}
