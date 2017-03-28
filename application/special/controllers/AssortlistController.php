<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * AssortListController.php
 *
 * 专题节点文章内容列表
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-10-20 下午5:38:18
 * @filename   AssortListController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class AssortListController extends HomeController
{
    public static $_base_set;  //专题基本设置

    protected function initView()
    {
        app::loadFile(DIR_BF_ROOT.'base'.DIRECTORY_SEPARATOR.'Template.php');
        self::$_view = Template::getInstance('special_');
        self::$_style = self::$_view -> getStyle('special_');
    }

    public $SpecialModel; //专题模型
	public $SpecialSectionModel; //版块模型
	public $SpecialAssortModel; //节点模型


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
		$cid=0;
		$pid=0;

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']); //节点ID
        $assort_name = $this->SpecialAssortModel->find(array('aid'=>$id),true,'assort_name'); //节点名称
        $seo = get_metainfo_special_assort($zhuan['sid'],$id);
		$hot = $this->SpecialModel->getTenHot(); //获取10条热点高点击专题

        $ban = $this->SpecialAssortModel->find(array('aid'=>$id),true,'secid'); //根据节点ID获取版块ID
        $zhuan = $this->SpecialSectionModel->find(array('id'=>$ban['secid']),true,'sid'); //根据版块ID获取专题ID
        $special_name = $this->SpecialModel->find(array('id'=>$zhuan['sid']),true,'name');  //根据专题ID获取专题名称

        $list = $this->SpecialAssortModel->getInfoByNodeId($id);

        foreach($list AS $key=>$val){
            $list[$key]['category_name'] = $this->SpecialAssortModel->getCategoryNameById($val['categoryid']); //根据栏目ID获取栏目名称
            $list[$key]['static_url'] = $this->SpecialAssortModel->getStaticUrl($val['categoryid'],$val['publishtime'],$val['id']); //静态链接
        }

		$count = $this->SpecialAssortModel->getCountByNodeId($id);

		$pagesize = 20;

		$page = new Page($count, $pagesize);

		$from = $page->firstRow;

		$limit = $from.','.$pagesize;

		$pagestr = $page->show();

        include $this->display('assort_list.html');
    }



}
