<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 商品评论管理
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   CommentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodscmtController extends AdminController
{
	/**
	 * 商品评论管理首页
	 */
	public function indexAction ()
	{
		$pflag = 1;
		if (isset($_GET['tab'])) {
			$pflag = 1;
		}
		elseif (isset($_GET['status'])) {
			$pflag = 2;
		}
		elseif (isset($_GET['is_reply'])) {
			$pflag = 3;
		}
		$this -> assign('pflag',$pflag);
		
		//搜索
		$search['title']     = isset($_POST['title']) ? $_POST['title'] : (isset($_GET['title']) ? $_GET['title'] : (isset($_SESSION['search1']['title'])?$_SESSION['search1']['title']:''));
		$search['modelid']   = isset($_POST['modelid']) ? $_POST['modelid'] : (isset($_GET['modelid']) ? $_GET['modelid'] : (isset($_SESSION['search1']['modelid'])?$_SESSION['search1']['modelid']:'1') );
		$search['status']    = isset($_POST['status']) ? $_POST['status'] : (isset($_GET['status']) ? $_GET['status'] : (isset($_SESSION['search1']['status'])?$_SESSION['search1']['status']:'') );
		$search['is_reply']  = isset($_POST['is_reply']) ? $_POST['is_reply'] : (isset($_GET['is_reply']) ? $_GET['is_reply'] : (isset($_SESSION['search1']['is_reply'])?$_SESSION['search1']['is_reply']:'') );
		
		$_SESSION['search1'] = $search;//查询条件SESSION
		
		$plist = $this -> getCommentModel() -> getGoodsCommentList($search);
		$this -> assign('search',$search);
		$this -> assign('plist',$plist);
		$this -> assign('tab',isset($_REQUEST['tab']) ? $_REQUEST['tab'] : '1');
		$this -> display('content/goodscmt/content_goodscmt_index.html');
	}

	/**
	 * 审核
	 */
	function passfailAction ()
	{
		$status = isset($_POST['s']) ? intval($_POST['s']) : (isset ( $_GET['s'] ) ? intval($_GET['s']) : 2 );
		if(!in_array($status,array(1,2))) $status = 2;

		$ids = implode(',',$this -> getOperateId());
		$this -> getCommentModel() -> update(array('in'=>array('comment_id'=>$ids)),array('comment_status'=>$status));
		admin_log('审核商品评论', '审核了评论('.$this -> getCmtTitleByIds($ids).')的评论状态为'.$this -> getStatus($status));
		$this -> dialog('/content/goodscmt/index');
	}
	/**
	 * 删除
	 */
	public function delAction ()
	{
		$pflag = 1;
		if (isset($_GET['tab'])) {
			$pflag = 1;
		}
		elseif (isset($_GET['status'])) {
			$pflag = 2;
		}
		elseif (isset($_GET['is_reply'])) {
			$pflag = 3;
		}
		$this -> assign('pflag',$pflag);
		

		if ($pflag == 1) {
			$ext_str = '/tab/1';
		} elseif ($pflag == 2) {
			$ext_str = '/status/' . $_SESSION['search1']['status'];
		} elseif ($pflag == 3) {
			$ext_str = '/is_reply/' . $_SESSION['search1']['is_reply'];
		}
		
		$ids = implode(',',$this -> getOperateId());
		$title_str = $this -> getCmtTitleByIds($ids);
		$this -> getCommentModel() -> delete(array('in'=>array('comment_id'=>$ids)));
		admin_log('删除商品评论', '删除了评论('.$title_str.')');
		$this -> dialog('/content/goodscmt/index' . $ext_str);
	}

	/**
	 * 获取批量操作的ID
	 */
	public function getOperateId ()
	{
		$id = isset($_POST['id']) && is_array($_POST['id']) ? $_POST['id'] : (isset ( $_GET['id'] ) ? array(intval($_GET['id'])) : array());
		array_push($id,'0');
		return $id;
	}

	/**
	 * 查看评论
	 */
	public function viewAction ()
	{
		//提交回复
		if(isset($_POST['comment_id']) && $_POST['comment_id'])
		{
			$userinfo = $_SESSION['userinfo'];//用户登陆信息
			$id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0 ;

			$info['reply_content'] = $this -> post('reply_content');
			$info['reply_userid'] = $userinfo['id'];
			$info['reply_time'] = time();
			$info['comment_status'] = $this -> post('comment_status');
			$info['reply_isreply'] = empty($info['reply_content']) ? 2 : 1;

			$res = $this -> getCommentModel() -> update(array('comment_id'=>$id),$info);
			if($res)
				$this -> dialog('/content/goodscmt/index','success','操作成功');
			else
				$this -> dialog('/content/goodscmt/index','success','操作失败');
		}
		
		$pflag = 1;
		if (isset($_GET['tab'])) {
			$pflag = 1;
		}
		elseif (isset($_GET['status'])) {
			$pflag = 2;
		}
		elseif (isset($_GET['is_reply'])) {
			$pflag = 3;
		}
		$this -> assign('pflag',$pflag);

		//查看评论页面
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : '' ;
		if(!$id) $this -> dialog('','error','参数有误');
		$info = $this -> getCommentModel() -> getOneComment($id);
		$ln = $this -> getCommentModel() -> getLastAndNextComment($id);
		$info['comment_content'] = $this -> getMessageModel()->replacestr($info['comment_content']);
		$this -> assign('ln',$ln);
		$this -> assign('info',$info);
		$this -> assign('search' , $_SESSION['search1']);
		$this -> display('content/goodscmt/content_goodscmt_view.html');
	}

	/**
	 * 回复评论
	 * @param
	 * @return
	 */
	public function replyAction ()
	{
		$pflag = 1;
		if (isset($_GET['tab'])) {
			$pflag = 1;
		}
		elseif (isset($_GET['status'])) {
			$pflag = 2;
		}
		elseif (isset($_GET['is_reply'])) {
			$pflag = 3;
		}
		$this -> assign('pflag',$pflag);
		//提交回复
		if(isset($_POST['comment_id']) && $_POST['comment_id'])
		{
			$userinfo = $_SESSION['userinfo'];//用户登陆信息
			$id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0 ;

			$info['reply_content'] = $this -> post('reply_content');
			$info['reply_userid'] = $userinfo['id'];
			$info['reply_time'] = time();
			$info['reply_isreply'] = !empty($info['reply_content']) ? 1 : 2;
			$info['comment_status'] = 1;
			
			if ($pflag == 1) {
				$ext_str = '/tab/1';
			} elseif ($pflag == 2) {
				$ext_str = '/status/' . $_SESSION['search1']['status'];
			} elseif ($pflag == 3) {
				$ext_str = '/is_reply/' . $_SESSION['search1']['is_reply'];
			}

			$res = $this -> getCommentModel() -> update(array('comment_id'=>$id),$info);
			if($res)
				$this -> dialog('/content/goodscmt/index' . $ext_str ,'success','操作成功');
			else
				$this -> dialog('/content/goodscmt/index' . $ext_str ,'error','操作失败');
		}

		//回复评论页面
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : '' ;
		if(!$id) $this -> dialog('','error','参数有误');
		$info = $this -> getCommentModel() -> getOneComment($id);
		$ln = $this -> getCommentModel() -> getLastAndNextComment($id);
		$info['comment_content'] = $this -> getMessageModel()->replacestr($info['comment_content']);
		$this -> assign('ln',$ln);
		$this -> assign('info',$info);
		$this -> assign('search' , $_SESSION['search1']);
		$this -> display('content/goodscmt/content_goodscmt_reply.html');
	}

	function getStatus ($status)
	{
		switch ($status)
		{
			case 1:
				return '通过';
				break;
			case 2:
				return '未通过';
				break;
			case 3:
				return '待审核';
				break;
			default:
				return '未知状态';
		}
	}

	/**
	 * 获取评论的标题字符串连接
	 * @param ids
	 * @return str
	 */
	function getCmtTitleByIds ($ids)
	{
		$tmp = array();
		$_com = $this -> getCommentModel()->findAll(array('in'=>array('comment_id'=>$ids)));
		if($_com)
		{
			foreach ($_com as $key => $val )
			{
				$tmp[] = $val['comment_content'];
			}
		}
		return implode('、',$tmp);
	}

	/**
	 * 获取商品评论表Model
	 */
	public function getCommentModel ()
	{
		return D('CommentModel');
	}

	public function getMessageModel ()
	{
		return D('MessageModel','modules','admin');
	}
}