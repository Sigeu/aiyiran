<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * LevelController.php
 * 
 * 会员级别控制器类 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-21 上午10:37:49
 * @filename   levelController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
 
class LevelController  extends AdminController
{
	private $objLevel;
	private $grouplist;
	
	public function init()
	{
		$this->objLevel = D('MemberLevel');
	    $objGroup = D('MemberGroup');
		//会员分组列表（开启的）
		$group = get_cache('membergroup','common');
		if (!$group)
		{
			$group = $objGroup->getGroupCacheList();
		}
		$this->grouplist = $group;
		parent::init();
		
	}
	
	/**
	 * 会员级别列表
	 */
	public function indexAction()
	{
		$where    = array();
		$options  = array();
		$pageInfo = array();
		$allgroup = array();
		$levellist= array();
		$objMember= M('Member');       //会员
	    $objGroup = D('MemberGroup');  //会员分组
		
		//会员组列表（所有）
	    $allgroup = get_cache('allmembergroup','common');
	    if (!$allgroup)
	    {
	    	$allgroup = $objGroup->getAllGroupCacheList();
	    }
	    $pageInfo['allGroup'] = $allgroup;
	    
		//会员级别状态
		$pageInfo['status'] = array('1'=>'开启','2'=>'关闭');
		
		//搜索条件
		$keyword   = $this->getParams('keyword');          //关键字
		$groupid   = $this->getParams('groupid');          //角色id
		$status    = $this->getParams('status');           //会员状态
		
		$searchInfo = array(
				'keyword'  => $keyword,
				'groupid'   => $groupid,
				'status'   => $status,
		);
		//关键字：支持级别名称的搜索
		if (isset($keyword)&&!empty($keyword))
		{
			$where['like'] = array('levelname'=>$keyword);
		}
		
		if (isset($groupid)&&!empty($groupid))
		{
			$where['groupid'] = $groupid;
		}
		
		if (isset($status)&&!empty($status))
		{
			$where['status'] = $status;
		}
		
		$count = $this->objLevel->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;
		$options['order'] = "id DESC";
		
		$result = $this->objLevel->select($options);
		foreach ($result as $row)
		{
			$row['membernum']  = $objMember->findCount(array('levelid'=>$row['id']));
			$groupstatus       = $objGroup->find(array('id'=>$row['groupid']));
			$row['groupstatus']= $groupstatus['status'];
			$levellist[] = $row;
		}
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$pageInfo['page'] = $currpage;
		
		$this->assign('pageInfo',$pageInfo);
		$this->assign('searchInfo',$searchInfo);
		$this->assign('levelList',$levellist);
		$this->assign('pageStr',$pagestr);
		$this->display('members/level/level_list');
	}
	
	/**
	 * 添加会员级别
	 */
	public function addAction()
	{
		if ($_POST)
		{
			$param = array(
					'groupid'   => trim($this->getParams('groupid')),
					'levelname' => trim($this->getParams('levelname')),
					'point'     => trim($this->getParams('point')),
					'status'    => trim($this->getParams('status')),
					);
			$newid = $this->objLevel->create($param);
		    if ($newid)
			{
				//更新会员级别缓存
			    $this->_cache();
               //操作日志   
			    admin_log("添加会员级别","添加了会员级别： ".$this->getParams('levelname'));
			    
				$this->dialog('/members/level/index');
				exit();
			}
		}
		
		$this->assign('groupList',$this->grouplist);
		$this->display('members/level/level_add');
	}
	
	/**
	 * 修改会员级别
	 */
	public function editAction()
	{
		$id = $this->getParams('id');
		$condition = array('id'=>$id);
		
		//搜索条件
		$page    = $this->get('page');
		$status  = $this->get('st');
		$keyword = $this->get('kw');
		$groupid = $this->get('group');
		
		//会员级别信息
		$levelinfo = $this->objLevel->find($condition);
		if ($_POST)
		{
			$param = array(
					'levelname'=> trim($this->getParams('levelname')),
					'point'    => trim($this->getParams('point')),
					'status'   => trim($this->getParams('status')),
					);
			
			$this->objLevel->update($condition,$param);
			$this->_cache();
            //操作日志   
		    admin_log("修改会员级别","修改了会员级别： ".$levelinfo['levelname']);
		    
			$this->dialog("/members/level/index/page/{$page}/keyword/{$keyword}/groupid/{$groupid}/status/{$status}");
			exit;
		}
		
		
		$this->assign('levelInfo',$levelinfo);
		$this->assign('groupList',$this->grouplist);
		$this->display('members/level/level_edit');
	}
	
	/**
	 * 开启/关闭 会员级别
	 */
	public function isableAction()
	{
		$id = $this->getIds('levelid');
		$state = $this->getParams('state');
		
		//搜索条件
		$page    = $this->get('page');
		$status  = $this->get('status');
		$keyword = $this->get('keyword');
		$groupid = $this->get('groupid');
		
		if ($id)
		{
			$condition['in'] = array('id'=>$id);
			$param['status'] = $state;
			$this->objLevel->update($condition,$param);
			$this->_cache();
			//操作日志
			$arr_id = explode(",", $id);
			$names = '';
			foreach ($arr_id as $row)
			{
				$infos = $this->objLevel->find(array('id'=>$row));
				$names .= $infos['levelname']." ";
			}
				
			if ($state==1)
			{
				admin_log("开启会员级别","开启了会员级别： ".$names);
			}else
			{
				admin_log("关闭会员级别","关闭了会员级别： ".$names);
			}
			$this->redirect($this->createUrl("members/level/index?page={$page}&keyword={$keyword}&groupid={$groupid}&status={$status}"));
			exit;
		}else
		{
			alert("请先选择会员级别");
			exit;
		}
	}
	
	
	/**
	 * 删除会员级别
	 */
	public function deleteAction()
	{
		$num = 0;
		$num_ok = 0;
		$num_fail = 0;
		$objMember = M('Member');
		
		$id = $this->getIds('levelid');
		$levelids = explode(",", $id);
		$num = count($levelids);
		//搜索条件
		$page    = $this->get('page');
		$status  = $this->get('status');
		$keyword = $this->get('keyword');
		$groupid = $this->get('groupid');
		
		//有会员的会员级别
		$result = $objMember->field('levelid')->group('levelid')->select();
		foreach ($result as $row)
		{
			$level1[] = $row['levelid']; 
		}
		$ids = array_diff($levelids, $level1);
		$idstr = implode(',', $ids);
		$num_ok = count($ids);
		$num_fail = $num-$num_ok;
		
		if ($ids)
		{			
			//操作日志
			$names = '';
			foreach ($ids as $dd)
			{
				$infos = $this->objLevel->find(array('id'=>$dd));
				$names .= $infos['levelname']." ";
			}
			admin_log("删除会员级别","删除了会员级别： ".$names);
			
		}
		if ($num_fail>0)
		{
			$tip = "成功删除{$num_ok}个会员级别，失败{$num_fail}个";
		}else 
		{
			$tip = "成功删除{$num_ok}个会员级别";
		}
		
		//删除会员级别
		$condition['in'] = array('id'=>$idstr);
		$this->objLevel->delete($condition);
		$this->_cache();
		
		$this->dialog("/members/level/index/page/{$page}/keyword/{$keyword}/groupid/{$groupid}/status/{$status}",'',$tip);
//		$this->redirect($this->createUrl("members/level/index?page={$page}&keyword={$keyword}&groupid={$groupid}&status={$status}"));
		exit;
		
	}
	
	
	/**
	 * 群发站内信
	 */
	public function messagerAction()
	{
		$this->display('members/level/add');
	}
	
	/**
	 * 生成缓存
	 */
	protected function _cache()
	{
		$objLevel = D('MemberLevel');
		$this->objLevel->getLevelCacheList();         //开启的级别
		$this->objLevel->getAllLevelCacheList();      //所有级别
		$this->objLevel->getGroupLevelCacheList();    //分组-级别  级联数组
	}
	
	
}