<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * JournalController.php 日志规则
 *
 * IMCenter 用户管理
 *
 * @author     黄利科<huanglike2012@163.com>   2013-03-11 10:01
 * @filename   JournalController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class JournalController extends AdminController
{
    public $JournalModel;
	public function init ()
	{
		$this -> JournalModel = D('JournalModel');
		parent::islogin_imc();
		parent::init();
	}

	/**
	 * 日志列表
	 */
	public function indexAction ()
	{

        $pageInfo = array();
		$where    = array();
		$options  = array();
		//搜索条件
		$keyword   = $this->getParams('keyword');          //关键字
		$starttime = $this->getParams('starttime');        //开始时间
		$endtime   = $this->getParams('endtime');          //结束时间
		$operation = $this->getParams('operation');        //操作项

		//$searchInfo = array('keyword'  => $keyword,'starttime'=> $starttime,'endtime'  => $endtime);

		if (isset($keyword) AND !empty($keyword))
		{
			$where['OR'] = " admin_name like '%{$keyword}%'";
		}

		if (isset($operation) AND !empty($operation))
		{
			$where['OR'] = " operation = '$operation'";
		}

		if (isset($starttime) AND !empty($starttime))
		{
			 $where['compbig']['log_time'] = strtotime($starttime." 00:00:00");
		}

		if (isset($endtime) AND !empty($endtime))
		{
			 $where['compsmall']['log_time'] = strtotime($endtime." 23:59:59");
		}

        $count = $this->JournalModel->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
        $options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
        $options['order'] = " log_time DESC";
        $log = $this->JournalModel->select($options);
        $currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
        $this->assign('log', $log);
        $this->assign('keyword', $keyword);
        $this->assign('starttime', $starttime);
        $this->assign('endtime', $endtime);
        $this->assign('operation', $operation);
        $this->assign('pageStr',$pagestr);
		$this -> display('Journal/journal_list.html');
	}

    /* 删除日志 */
    public function deleteJournalAction()
    {
		$this->JournalModel->delete($condition = null);
        imc_log('删除日志', "清空日志");  //添加日志
        $this -> dialog('/journal/Journal/index','success','操作成功！');
    }

}