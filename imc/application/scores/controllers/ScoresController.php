<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ScoresController.php 积分规则
 *
 * IMCenter 用户管理
 *
 * @author     leishaojin<leishaojin2012@163.com>   2013-03-11 10:01
 * @filename   ScoresController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class ScoresController extends AdminController
{
	public function init()
	{
		parent::islogin_imc();
		parent::init();
	}

	/**
	 * 积分规则列表
	 */
	public function indexAction ()
	{
		$sql   = $this -> getScoresRuleModel() -> getSql();
		$plist = $this -> getScoresRuleModel() -> getPageList(array('sql'=>$sql));
		$this -> assign('plist',$plist);
		$this -> display('scores/imcenter_scores_index.html');
	}

	/**
	 * 积分规则添加
	 */
	public function addAction ()
	{
		if(!empty($_POST))
		{
			$info['app']         = $this -> post('app');
			$info['ratio1']      = $this -> post('ratio1');
			$info['ratio2']      = $this -> post('ratio2');
			$info['created']     = time();
			$res = $this -> getScoresRuleModel() -> create($info);
			imc_log('设置财富规则', '添加了积分规则ID='.$res);
			if($res)
				$this->dialog('/scores/scores/index','success');
			else
				$this->dialog('','error','添加失败');
		}
		$this -> assign('app',$this -> getAppModel()->getAppList());
		$this -> display('scores/imcenter_scores_add.html');
	}

	/**
	 * 积分规则修改
	 */
	function editAction ()
	{
		//提交跟新
		if(!empty($_POST))
		{
			$info['app']         = $this -> post('app');
			$info['ratio1']      = $this -> post('ratio1');
			$info['ratio2']      = $this -> post('ratio2');
			$res = $this -> getScoresRuleModel() -> update(array('id'=>$_POST['id']),$info);
			imc_log('设置财富规则', '修改积分规则ID='.$_POST['id']);
			if($res)
				$this->dialog('/scores/scores/index','success');
			else
				$this->dialog('','error','修改失败');
		}
		//修改页面
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : 0;
		if(!$id) $this->dialog('','error','参数错误');
		$this -> assign('info',$a = $this -> getScoresRuleModel() -> find(array('id'=>$id)));
		$this -> assign('app',$this -> getAppModel()->getAppList());
		$this -> display('scores/imcenter_scores_edit.html');
	}

	/**
	 * 删除积分规则
	 */
	function delAction ()
	{
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : (isset ( $_POST['id'] ) ? implode(',',$_POST['id']) : '0');
		if(!$id) $this->dialog('','error','参数错误');
		$res = $this -> getScoresRuleModel() ->delete(array('in'=>array('id'=>$id)));
		imc_log('设置财富规则', '删除积分规则ID='.$id);
		if($res)
				$this->dialog('/scores/scores/index','success','删除成功');
			else
				$this->dialog('','error','删除失败');
	}

	/**
	 * 积分规则模型
	 */
	public function getScoresRuleModel ()
	{
		return D('ScoresRuleModel');
	}

	/**
	 * 积分规则模型
	 */
	public function getAppModel ()
	{
		return D('AppModel','app','imc');
	}
}