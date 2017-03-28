<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 推荐位管理
 *
 * @author     黄利科 <huanglike@mail.b2b.cn>
 * @filename   PositionController.php
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class PositionController extends AdminController
{

    public $PositionModel;
    public $PositionInfoModel;
    public $SystemModel;
	public function init ()
	{
		$this -> PositionModel = D('PositionModel');
        $this -> PositionInfoModel = D('PositionInfoModel');
        $this -> SystemModel = D('SystemModel','webset');
	}
	/**
	 * 推荐位管理
	 */
	public function indexAction()
	{
        $where = array();
        $count = $this->PositionModel->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
        $pos = $this->PositionModel->getPositionMessage($from, $pagesize);  //获取推荐位列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
        $this->assign('pos', $pos);
        $this->assign('pageStr',$pagestr);
		$this->display('content/position/position_manage');
	}

	public function getCategoryModel ()
	{
		return D('CategoryModel');
	}

    /* 添加推荐位--页面 */
    public function addPositionAction()
    {
        $cat = $this -> getCategoryModel() -> getCategoryTree();
        $this->assign('cat', $cat);
        $this ->display('content/position/position_add');
    }

    /* 批量删除推荐位信息 */
    public function deleteAllInfoAction()
    {
        $ids = $this->getIds('ids');
        $zol = array();
        $l = $this->PositionInfoModel->findAll(array('in'=>array('id'=>$ids)));
        foreach ($l AS $val){
            $zol[] = $val['headline'];
        }
        $pid = !empty($_GET['pid']) ? intval($_GET['pid']) : 0;
        $cid = !empty($_GET['cid']) ? intval($_GET['cid']) : 0;
		if ($ids)
		{
			$condition['in'] = array('id'=>$ids);
			$this->PositionInfoModel->delete($condition);
		}
        admin_log('批量删除推荐位信息', "批量删除了推荐位信息:". implode(',',$zol));  //添加日志
        $this->dialog("/content/position/positionInfo/pid/$pid/catid/$cid",'success','删除成功！');
    }

    /* 更新排序 */
	public function updateOrderAction ()
	{
        $pid = !empty($_GET['pid']) ? intval($_GET['pid']) : 0;
        $cid = !empty($_GET['cid']) ? intval($_GET['cid']) : 0;
		$sort = isset($_POST['ids']) ? array_flip($_POST['ids']) : array();
		$row = array_intersect_key($_POST['sortby'], $sort);
		foreach($row AS $key=>$val){
			$this->PositionInfoModel->update(array('id'=>$key),array('sortby'=>$val));
		}
		$this->dialog("/content/position/positionInfo/pid/$pid/catid/$cid",'success','更新成功！');
	}

    /* 推荐位添加--入库 */
    public function insertPositionAction()
    {
        $n = empty($_POST['name']) ? '' : $_POST['name'];
        $c = empty($_POST['cat_id']) ? '' : $_POST['cat_id'];
        $m = empty($_POST['max_num']) ? '' : $_POST['max_num'];
        $s = empty($_POST['special']) ? '' : $_POST['special'];
        $act = empty($_POST['act']) ? '' : $_POST['act'];
        empty($act) ? $this->PositionModel->correctPosition($n,$c,$m,$s) : $this->PositionModel->updatePosition($act,$n,$c,$m,$s);
        if(empty($act)) {
            admin_log('添加推荐位', "添加推荐位".$n);  //添加日志
        }else{
            admin_log('修改位操作', "修改推荐位".$n);  //添加日志
        }
        $this -> dialog('/content/position/index','success','操作成功！');
    }

    /* 编辑推荐位 */
    public function editPositionAction()
    {
        $id = intval($_GET['id']);
        $result = $this->PositionModel->getPositionById($id); //根据ID得到信息
        $this->assign('result', $result);
        $cat = $this -> getCategoryModel() -> getCategoryTree();
        $this->assign('cat', $cat);
        $this->display('content/position/position_edit');
    }

    /* 删除推荐位 */
    public function delPositionAction()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if($id <> 0) {
            $yellow = $this->PositionModel->find(array('pos_id'=>$id),false,'name');
            $this->PositionModel->delete(array('pos_id'=>$id));
            admin_log('删除推荐位', "删除了推荐位".$yellow['name']);  //添加日志
            $this->dialog('/content/position/index','success','删除成功！');
        }
        $ids = $this->getIds('posid');
        $zol = array();
        $l = $this->PositionModel->findAll(array('in'=>array('pos_id'=>$ids)));
        foreach ($l AS $val){
            $zol[] = $val['name'];
        }
		if ($ids)
		{
			$condition['in'] = array('pos_id'=>$ids);
			$this->PositionModel->delete($condition);
		}
        admin_log('删除推荐位', "删除了推荐位". implode(',',$zol));  //添加日志
        $this->dialog('/content/position/index','success','删除成功！');
    }

    /* 推荐位信息管理 */
    public function PositionInfoAction()
    {
        $where = array();
        $pid = !empty($_GET['pid']) ? intval($_GET['pid']) : 0;
        $cid = !empty($_GET['catid']) ? intval($_GET['catid']) : 0;  //获取相关联的栏目ID
        $count = $this->PositionModel->getPositionNumber($pid);
		$pagesize = 10;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
        $info = $this->PositionModel->getPositionInfo($pid, $from, $pagesize);
        $currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
        $this->assign('info', $info);
        $this->assign('posid',$pid);
        $this->assign('catid',$cid);
        $this->assign('pageStr',$pagestr);
        $this->display('content/position/position_info');
    }

    /* 编辑推荐位信息 */
    public function positionInfoEditAction()
    {
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
        $setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);        $id = intval($_GET['id']);
        $pid = !empty($_GET['pid']) ? intval($_GET['pid']) : 0;
        $cid = !empty($_GET['cid']) ? intval($_GET['cid']) : 0;
        $some = $this->PositionModel->getPositionInfoById($id);
        $this->assign('some', $some);
        $this->assign('posid',$pid);
        $this->assign('catid',$cid);
        $this->display('content/position/position_info_edit');
    }

    /* 编辑推荐位信息操作 */
    public function editPositionInfoAction()
    {
        $id  = empty($_POST['id']) ? 0 : $_POST['id'];
        $pid = !empty($_POST['pid']) ? intval($_POST['pid']) : 0;
        $cid = !empty($_POST['cid']) ? intval($_POST['cid']) : 0;
        $param = array('headline' => $_POST['headline'],'pos_info' => $_POST['pos_info']);
        if (isset($_POST['logo_alt']))
        {
        	$param['alt'] = $_POST['logo_alt'];
        }
		$root = dirname(realpath(DIR_ROOT));
		$uploadfile = getFileSavePath('position');
        if(isset($_POST['accessory'])){
			$logo_info = current($_POST['accessory']);
			$old_logo = isset ( $_POST['old_logo'] ) ? trim($_POST['old_logo']) : '';
            if(@copy($root.$logo_info['path'], $uploadfile['base']. DS .basename($logo_info['path']))){
              $param = array(
                'headline' => $_POST['headline'],
                'pos_info' => $_POST['pos_info'],
                'alt'      => $logo_info['alt'],
                'pos_img'  => '/static/uploadfile/position/'.basename($logo_info['path'])
                );
              //删除旧logo
              @unlink($root.$old_logo);//删除旧logo
            }
        }else if ($_POST['is_del'] == 1)
        {
        	@is_file($root.$_POST['old_logo']) && @unlink($root.$_POST['old_logo']);
        	$param['pos_img'] = '';
        	$param['alt'] = '';
        }
        $condition = array('id'=>$id);
        $this->PositionInfoModel->update($condition,$param);
        admin_log('编辑推荐位信息', "修改推荐位信息:".$_POST['headline']);  //添加日志
        $this->dialog("/content/position/positionInfo/pid/$pid/catid/$cid",'success','操作成功！');
    }

    /* 删除推荐位信息 */
    public function deletePositionInfoAction()
    {
        $id = intval($_GET['id']);
        $pid = !empty($_GET['pid']) ? intval($_GET['pid']) : 0;
        $cid = !empty($_GET['cid']) ? intval($_GET['cid']) : 0;
        $yellow = $this->PositionInfoModel->find(array('id'=>$id),false,'headline');
        $this->PositionInfoModel->delete(array('id'=>$id));
        admin_log('删除推荐位信息', "删除推荐位信息:".$yellow['headline']);  //添加日志
        $this->dialog("/content/position/positionInfo/pid/$pid/catid/$cid",'success','删除成功！');
    }

    public function pmdAction()  //跑马灯
    {
        $this->display('content/position/paomadeng');
    }

    public function hdpAction()  //幻灯片
    {
        $this->display('content/position/huandengpian');
    }

    /* 展示推荐信息 */
    public function chosePositionInfoAction()
    {
        $pageInfo = array();
		$options  = array();

		$keyword  = $this->getParams('keyword');  //关键字
        $posid  = $this->getParams('id');         //推荐位ID
        $catid  = $this->getParams('catid');      //栏目ID

        if($this->PositionInfoModel->query("SELECT goodsid FROM ".$this->PositionInfoModel->tablePrefix ."goods WHERE categoryid = $catid ")) {
            $where = "SELECT mg.goodsid AS id, mg.goodsname AS headline FROM " .$this->PositionInfoModel->tablePrefix ."goods AS mg WHERE mg.categoryid = $catid AND mg.goodsid NOT IN (SELECT ag_id FROM ". $this->PositionInfoModel->tablePrefix ."position_info WHERE pos_id = $posid)";
            if (isset($keyword) AND !empty($keyword)){
                $where .= " AND goodsname like '%{$keyword}%'";
            }
            $count = "SELECT COUNT(mg.goodsname) FROM " .$this->PositionInfoModel->tablePrefix ."goods AS mg WHERE mg.categoryid = $catid AND mg.goodsid NOT IN (SELECT ag_id FROM ". $this->PositionInfoModel->tablePrefix ."position_info WHERE pos_id = $posid)";
        }else{
            $where = "SELECT mt.id, mt.title AS headline FROM " .$this->PositionInfoModel->tablePrefix ."maintable AS mt WHERE mt.categoryid = $catid AND mt.id NOT IN (SELECT ag_id FROM ". $this->PositionInfoModel->tablePrefix ."position_info WHERE pos_id = $posid)";
            if (isset($keyword) AND !empty($keyword)){
                $where .= " AND title like '%{$keyword}%'";
            }
            $count = "SELECT COUNT(mt.title) FROM " .$this->PositionInfoModel->tablePrefix ."maintable AS mt WHERE mt.categoryid = $catid AND mt.id NOT IN (SELECT ag_id FROM ". $this->PositionInfoModel->tablePrefix ."position_info WHERE pos_id = $posid)";
        }
        $info = $this->PositionInfoModel->getPageList(array('sql'=>$where));

        $this->assign('posid',$posid);
        $this->assign('catid',$catid);
        $this->assign('info', $info['list']);
        $this->assign('keyword',$keyword);
        $this->assign('pageStr',$info['pagestr']);
        $this->display('content/position/chose_position_info');
    }

    /* 批量添加推荐信息 */
    public function addPositionInfoAction()
    {
        $ids = $this->getIds('pos_ids');  //文章ID、商品ID
        $pieces = explode(",", $ids);
        $catid = $this->getParams('catid');  //栏目ID
        $posid = $this->getParams('id');  //推荐位ID
        foreach($pieces AS $id){
          if($id <> NULL){
              $sql = 'INSERT INTO '. $this->PositionInfoModel->tablePrefix . 'position_info(cat_id, ag_id, pos_id, model_id, alter_time, headline) ' . " VALUES ('$catid','$id','$posid', '" . $this->PositionModel->getModelIdByCatId($catid) . "','" . time() . "', '" . $this->PositionModel->getHeadline($id) . "')";
              $this->PositionInfoModel->query($sql);
          }
        }
        admin_log('批量添加推荐信息', "批量添加推荐位信息");  //添加日志

    }







}