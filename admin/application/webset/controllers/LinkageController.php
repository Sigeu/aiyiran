<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * LinkageController.php
 *
 * 网站管理——联动菜单
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   LinkageController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class LinkageController extends AdminController
{
    public $LinkageModel;
    public $LinkageBillModel;
	public function init ()
	{
		$this -> LinkageModel = D('LinkageModel');
        $this -> LinkageBillModel = D('LinkageBillModel');
	}

    //联动菜单
    public function indexAction()
    {
		$where    = array();
		$options  = array();

		$keyword  = $this->getParams('keyword');  //关键字

		if (isset($keyword) AND !empty($keyword))
		{
			$where['OR'] = " name like '%{$keyword}%' OR style like '%{$keyword}%'";
		}
        $count = $this->LinkageModel->findCount($where);
		$pagesize = 10;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
        $options['limit'] = $from.','.$pagesize;
        $options['order'] = " linkageid DESC";
		$options['where'] = $where;
        $linkage = $this->LinkageModel->select($options);
        $currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
        $pid = empty($pid) ? 0 : $pid;   //// DT
        $too = empty($too) ? '': $too;
        foreach ($linkage AS $key => $val){
            $linkage[$key]['level'] = $this->LinkageModel->getLevel($pid, $too, $val['linkageid']);  //获取级数
        }
        $this->assign('linkage', $linkage);
        $this->assign('pageStr',$pagestr);
        $this->assign('keyword',$keyword);
        $this->display('webset/system/linkage');
    }

    /* 添加联动菜单 */
    public function addLinkageAction()
    {
        //添加和编辑公用一个HTML页面
        $this->display('webset/system/addlinkage');
    }

    /* 联动菜单更新 */
    public function updateAction()
    {
        $this->dialog("/webset/Linkage/index",'success','更新成功！');
    }

    /* 子菜单更新排序 */
	public function updateOrderAction ()
	{
        $id = empty($_GET['lin']) ? 0 : $_GET['lin'];
		$sort = isset($_POST['ids']) ? array_flip($_POST['ids']) : array();
        if($sort) {
            $row = array_intersect_key($_POST['ordernum'],$sort);
            foreach($row AS $key=>$val){
                $this->LinkageBillModel->update(array('id'=>$key),array('ordernum'=>$val));
            }
        }
		$this->dialog("/webset/Linkage/manageBill/id/$id",'success','更新成功！');
	}

    /* 添加菜单入库 */
    public function insertLinkageAction()
    {
        $act    = empty($_POST['act']) ? '' : $_POST['act'];
        $style  = empty($_POST['style']) ? '' : $_POST['style'];
        $name   = empty($_POST['name']) ? '' : $_POST['name'];
        $global = empty($_POST['isglobal']) ? '' : $_POST['isglobal'];
        $descri = empty($_POST['description']) ? '' : $_POST['description'];
        !empty($act) ? $this->LinkageModel->updateLinkage($name,$global,$descri,$act) : $this->LinkageModel->insertLinkage($style,$name,$global,$descri);
        if(empty($act)) {
            admin_log('添加联动菜单', "添加联动菜单" . $name);
        }else{
            admin_log('修改联动菜单', "修改联动菜单" . $name);  //添加日志
        }
        $this -> dialog('/webset/linkage/index');
    }

    /* 编辑联动菜单 */
    public function editLinkageAction()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $here = $this->LinkageModel->getLinkageById($id);
        $this->assign('here', $here);
        $this->display('webset/system/editlinkage');
    }

    /* 删除菜单 */
    public function deleteLinkageAction()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if($id <> 0) {
            $yellow = $this->LinkageModel->find(array('linkageid'=>$id),false,'name');
            $this->LinkageModel->delete(array('linkageid'=>$id));
            admin_log('删除联动菜单', "删除联动菜单".$yellow['name']);  //添加日志
            $this -> dialog('/webset/linkage/index','success','删除成功！');
        }
        $ids = $this->getIds('linkageid');
        $zol = array();
        $l = $this->LinkageModel->findAll(array('in'=>array('linkageid'=>$ids)));
        foreach ($l AS $val){
            $zol[] = $val['name'];
        }
        $bool = $this->LinkageModel->isGlobalBill($ids);  //判断是否有子目录
        if($bool == true) {
            $this->dialog("/webset/Linkage/index",'fail','系统项不可删除！');
        }
        $condition['in'] = array('linkageid'=>$ids);
        $this->LinkageModel->delete($condition);
        admin_log('删除联动菜单', '删除了联动菜单'. implode(',',$zol));  //添加日志
        $this -> dialog('/webset/linkage/index','success','删除成功！');
    }
                                                                                       ///上面这个删除还有一点问题，应该把子菜单中的关联数据一并删除，否则造成冗余数据，有时间再改
    /* 管理子菜单 */
    public function manageBillAction()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $pid = empty($pid) ? 0 : $pid;
        $t   = empty($t) ? '' : $t;
        $bill = $this->LinkageBillModel->getLinkageBill($pid,$t,$id);
        $this->assign('linkage_id', $id);
        $this->assign('bill', $bill);
        $this->display('webset/system/managebill');
    }

    /* 添加子菜单 */
    public function addChildrenAction()
    {
        $arr['lin_id'] = empty($_POST['prev']) ? '' : intval($_POST['prev']);  //所属联动菜单ID
        $arr['pid']    = empty($_POST['parentid']) ? 0 : intval($_POST['parentid']); //获取父级ID
        $arr['name']   = empty($_POST['name']) ? '' : trim($_POST['name']); //获取子菜单名称
        $arr['created'] = time();
        $insertid = $this->LinkageBillModel->create($arr);
        admin_log('添加联动菜单', "添加子菜单".$_POST['name']);  //添加日志
        if($insertid) echo 1;
    }

    /* 修改子菜单 */
    public function editChildrenAction()
    {
        $id   = empty($_POST['id']) ? 0 : intval($_POST['id']); //主键ID
        $name = empty($_POST['name']) ? '' : trim($_POST['name']); //子菜单名称
        $this->LinkageBillModel->update(array('id'=>$id), array('name'=>$name));
        admin_log('修改联动菜单', "修改子菜单".$name);  //添加日志
    }

    /* 删除子菜单 */
    public function delChildrenAction()
    {
        $id = empty($_GET['id']) ? '' : intval($_GET['id']);
        $lin = empty($_GET['lin']) ? '' : $_GET['lin'];
        $bool = $this->LinkageBillModel->includeBill($id);  //判断是否有子目录
        if($bool == true) {
            $this->dialog("/webset/Linkage/manageBill/id/$lin",'fail','请先移除该目录的子菜单！');
        }
        $yellow = $this->LinkageBillModel->find(array('id'=>$id),false,'name');
        $this->LinkageBillModel->delete(array('id'=>$id));
        admin_log('删除联动菜单', "删除了子菜单". $yellow['name']);  //添加日志
        $this->dialog("/webset/Linkage/manageBill/id/$lin",'success','操作成功！');
    }

    /* 批量删除子菜单 */
	public function deleteAction()
	{
        $ids = $this->getParams('ids');
        $in = implode(",",$ids);
        $zol = array();
        $l = $this->LinkageBillModel->findAll(array('in'=>array('id'=>$in)));
        foreach ($l AS $val){
            $zol[] = $val['name'];
        }
        $num = $this->LinkageBillModel->doFirst($ids); //把能删的删除掉
        $ok = count($ids) - $num; //删除成功的条目
        $id = empty($_GET['id']) ? 0 : $_GET['id'];  //联动菜单ID、做跳转用
        foreach($ids AS $val){
            if($this->LinkageBillModel->includeBill($val)== true AND in_array($this->LinkageBillModel->getChildren($val),$ids) ==false) {
                $this->dialog("/webset/Linkage/manageBill/id/$id",'fail','成功删除'.$num.'条,失败'.$ok.'条');
            }
        }
        $condition['in'] = array('id'=>$in);
        $this->LinkageBillModel->delete($condition);
        admin_log('批量删除联动菜单', "批量删除子菜单". implode(',',$zol));  //添加日志
        $this->dialog("/webset/Linkage/manageBill/id/$id",'success','成功删除'.count($zol).'条数据');
	}




}