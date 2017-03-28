<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://www.izhancms.cn)
 *
 * SpecialassortController.php
 *
 * 专题分类管理列表
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-08-16 15:55
 * @filename   SpecialassortController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    iZhanCMS 2.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SpecialassortController extends AdminController
{
	/**
	 * 专题分类列表
	 */
	public function indexAction ()
	{
        $sort_tree = $this -> getSpecialAssortModel() -> getSpecialAssort();
		if($sort_tree)
		{
			foreach ($sort_tree AS $key => $val ){
				$sort_tree[$key]['special_numbers'] = $this -> getSpecialModel() -> findCount(array('type_id'=>$val['id']));
            }
			$sort_tree = $this -> getSpecialAssortModel() -> countChildNode($sort_tree);
		}
		$this -> assign('sort_tree',$sort_tree);

		$this->display('extensions/special/specialassort');
	}

	/**
	 * 添加分类
	 */
	public function addAction ()
	{
		if(!empty($_POST)){  //提交
			$arr['pid'] = isset($_POST['pid']) ? intval($_POST['pid']) : 0 ;
			$arr['type_name'] = isset($_POST['type_name']) ? trim($_POST['type_name']) : '' ;
			$arr['created'] = time();
			$this->getSpecialAssortModel()->create($arr);
		    $this->dialog('/extensions/Specialassort/index');
		}
        $sort_tree = $this -> getSpecialAssortModel()->getSpecialAssort();
		$this -> assign('param',array('sortid'=>isset($_GET['id']) ? $_GET['id'] : ''));
		$this -> assign('sort_tree',$sort_tree);
		$this->display('extensions/special/add_assort');
	}

	/**
	 * 修改分类
	*/
	public function editAction ()
	{
		if(isset($_POST['sortid']) && $_POST['sortid'])
		{
			//表单数据
			$info['pid'] = isset($_POST['pid']) ? intval($_POST['pid']) : 0 ;
			$info['type_name'] = isset($_POST['type_name']) ? trim($_POST['type_name']) : '' ;

			$child_id = $this->getSpecialAssortModel()->getChildidByPid($_POST['sortid']);///////////
			array_push($child_id,$_POST['sortid']);
			if(in_array($info['pid'],$child_id))
			$this -> dialog('','error','不能选择自己或自己的子级作为父级');

			$this->getSpecialAssortModel()->update(array('id'=>$_POST['sortid']),$info);
		    $this->dialog('/extensions/Specialassort/index');
		}

		$sortid = isset ( $_GET['id'] ) ? intval($_GET['id']) : 0 ;
		$info = $this->getSpecialAssortModel() -> find(array('id'=>$sortid));
		$sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();
		$this -> assign('info',$info);
		$this -> assign('sort_tree',$sort_tree);
		$this->display('extensions/special/edit_assort');
	}

	/**
	 * 删除专题分类
	*/
    public function deleteAction()
    {
        $id = empty($_GET['id']) ? '' : intval($_GET['id']);  //专题分类ID

        $bool = $this->getSpecialAssortModel()->aboutSpecial($id);  //判断是否关联专题
        if($bool == true) {
            $this->dialog('/extensions/Specialassort/index','fail','请先删除此分类下的专题！');
        }
        $this->getSpecialAssortModel()->delete(array('id'=>$id));
        $this->dialog('/extensions/Specialassort/index','success','操作成功！');
    }

	/**
	 * 分类跟新排序
	*/
	public function updateOrderAction ()
	{
		$sort = isset ( $_POST['ordernum'] ) ? $_POST['ordernum'] : array();
		foreach ($sort as $key => $val )
		{
			$this -> getSpecialAssortModel() -> update(array('id'=>$key),array('ordernum'=>current($val)));
		}
		$this->dialog('/extensions/Specialassort/index');
	}

	/**
	 * 返回专题分类模型
	 */
	function getSpecialAssortModel ()
	{
		return D('SpecialTypeModel');
	}

	/**
	 * 返回专题模型
	 */
	function getSpecialModel ()
	{
		return D('SpecialModel');
	}

}