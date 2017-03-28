<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ManageLogController.php
 *
 * 网站管理——日志管理
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   ManageLogController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class ManageLogController extends AdminController
{
    public $LogModel;
	public function init ()
	{
		$this -> LogModel = D('LogModel');
	}

	/**
	 * 日志管理
	 */

    public function indexAction()
    {
        $pageInfo = array();
		$where    = array();
		$options  = array();
		//搜索条件
		$keyword   = $this->getParams('keyword');          //关键字
		$starttime = $this->getParams('starttime');        //开始时间
		$endtime   = $this->getParams('endtime');          //结束时间
		$searchInfo = array('keyword'  => $keyword,'starttime'=> $starttime,'endtime'  => $endtime);

		if (isset($keyword) AND !empty($keyword))
		{
			$where['OR'] = " admin_name like '%{$keyword}%' OR module_name like  '%{$keyword}%' ";
		}

		if (isset($starttime) AND !empty($starttime))
		{
			 $where['compbig']['log_time'] = strtotime($starttime." 00:00:00");
		}

		if (isset($endtime) AND !empty($endtime))
		{
			 $where['compsmall']['log_time'] = strtotime($endtime." 23:59:59");
		}

        $count = $this->LogModel->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
        $options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
        $options['order'] = " log_time DESC";
        $log = $this->LogModel->select($options);
        $currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
        $this->assign('log', $log);
        $this->assign('keyword', $keyword);
        $this->assign('starttime', $starttime);
        $this->assign('endtime', $endtime);
        $this->assign('pageStr',$pagestr);
        $this->display('webset/system/managelog');

    }

    //批量删除日志
    public function delLogAction()
    {
        $ids = $this->getIds('logid');
		if ($ids)
		{
			$condition['in'] = array('log_id'=>$ids);
			$this->LogModel->delete($condition);
		}
        admin_log('删除日志', "删除日志");  //添加日志
        $this -> dialog('/webset/ManageLog/index','success','删除成功！');
    }

    //清空日志
    public function emptyAction()
    {
        $this->LogModel->delete($condition = null);
        admin_log('清空日志', "清空日志");  //添加日志
        $this -> dialog('/webset/ManageLog/index','success','操作成功！');
    }




}