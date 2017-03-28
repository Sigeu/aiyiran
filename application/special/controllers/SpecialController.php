<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialController.php
 *
 * 专题前台展示
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-10-20 下午5:38:18
 * @filename   SpecialController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SpecialController extends HomeController
{
    public static $_base_set;  //专题基本设置

    protected function initView()
    {
        app::loadFile(DIR_BF_ROOT.'base'.DIRECTORY_SEPARATOR.'Template.php');
        self::$_view = Template::getInstance('special_');
        self::$_style = self::$_view -> getStyle('special_');
    }

    public $SpecialModel; //专题模型
	public $SpecialSectionModel; //专题版块模型
	public $SpecialAssortModel; //版块节点模型


	public function init()
	{
		$this->SpecialModel = D('Special');
        $this->SpecialSectionModel = D('SpecialSection');
        $this->SpecialAssortModel = D('SpecialAssort');
	}

	/**
	 * 管理预览
	 */
	public function indexAction ()
    {
        $sid = empty($_GET['id']) ? 0 : intval($_GET['id']); //专题ID
        $real = empty($_GET['unavailable']) ? 0 : intval($_GET['unavailable']); //是否点击量记录
        if($real == 0) {
            $this->SpecialModel->query("UPDATE " .$this->SpecialModel->tablePrefix ."special SET click_num = click_num+1 WHERE id = '$sid'");
        }
		$special = $this->SpecialModel->find(array('id'=>$sid)); //获取专题信息
        $banner = $this->SpecialSectionModel->getBannerList($sid); //根据专题ID获取导航
		$section = $this->SpecialSectionModel->findAll(array('sid'=>$sid,'sortby ASC, id ASC')); //版块、节点信息
        $this->SpecialAssortModel->getNodeBySection($section); //耦合
        $seo = get_metainfo_special($sid);
        include $this->display('special_info.html');
    }



}
