<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 内容管理 栏目管理 栏目列表
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-4 16:53 创建此文件
 * <br>雷少进  2013-01-4 16:53 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   ColumnController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class ColumnController extends AdminController
{
	/**
	 * 栏目管理首页
	 */
	public function indexAction ()
	{
		$this -> getCategoryModel() -> updateColumnModel();
		$cat_temp = $cat_tree = $this -> getCategoryModel() -> getCategoryTree();
		if(is_array($cat_temp) && !empty($cat_temp))
		{
			foreach ($cat_tree as $key => $val )
			{
				if($val['model'] == 2)
					$cat_tree[$key]['cont_num'] = $this ->getGoodsModel() -> findCount(array('categoryid'=>$val['id']));
				else
					$cat_tree[$key]['cont_num'] = $this ->getMaintableModel() -> findCount(array('categoryid'=>$val['id']));
			}
		}
		$cat_tree = $this -> getCategoryModel() -> countChildNodeByArray($cat_tree);

        //判断移动栏目权限
		$hasper = 1;
		if(!in_array('/content/column/moveto',$_SESSION['alllinks']))
		{
			$hasper = 1;
		}
		else
		{
			if(!in_array('/content/column/moveto',$_SESSION['mylinks'])&&$_SESSION['roleid']!=1)
			{
				$hasper = 0;
			}
		}
		$this->assign('hasper',$hasper);
        $this -> assign('cat_tree',$cat_tree);
		$this -> assign('cat_temp',$cat_temp);
		$this -> assign('roleid',isset($_SESSION['roleid']) ? $_SESSION['roleid'] : 0 );
		$this -> assign('mypermissionid',isset($_SESSION['mypermissionid']) ? $_SESSION['mypermissionid'] : array() );
		$this -> assign('model',$this->getMyModel()->select());
		$this -> display('content/column/content_column_index.html');
	}

	/**
	 * 栏目添加
	 *
	 */
	public function addAction()
	{
		//增加栏目提交
		if(isset($_POST['info']))
		{
			//全部的基本信息
			$base = $_POST['info']['base'];
			// p($base);die;
			$base['ordernum'] = 0;
			$base['created'] = time();
			if(trim($base['catname']) == '')
				$this -> dialog('/content/column/add','error','栏目名称不能为空');

			if(trim($base['filepath']) == '')
			{
				if(isset($_POST['pinyin']) || empty($base['filepath']))
				{
					Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
					$pinyin = new MoPinyin();
					$base['filepath'] = $pinyin->toPinyin($base['catname']);
					$base['filepath'] = $this -> checkFilePath($base['filepath']);
				}
			}
			$categoryid = $this -> getCategoryModel() -> create($base);//基本信息入库

            if($_POST['info']['base']['columnoption'] ==1) {  //链接到栏目默认首页
                $path = '../html/'.$base['filepath'].'/';
                $dirs = explode('/',$path);
                $pos = strrpos($path, ".");
                if ($pos === false) {
                    $subamount=0;
                }
                else {
                    $subamount=1;
                }
                for ($c=0; $c < count($dirs) - $subamount; $c++) {
                $thispath="";
                for ($cc=0; $cc <= $c; $cc++) {
                $thispath.=$dirs[$cc].'/';
                }
                if (!file_exists($thispath)) {
                    mkdir($thispath, $mode = 0777);
                    }
                }
                ob_start();
                $filename = "index.html";
                $static = file_get_contents(HOST_NAME . "category/Category/index/cid/$categoryid");  //文章模型
                //$static = file_get_contents(HOST_NAME . "goods/Goods/index/cid/$categoryid");  //商品模型
                echo $static;
                $text = ob_get_contents();
                ob_end_clean();
                $con = fopen($filename, "w");
                fwrite ($con,$text);
                fclose ($con);
                @rename($filename, $path . $filename);
            }

			//管理员权限
			$admin = array();
			if(isset($_POST['info']['power']['admin']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['admin'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$admin[$i]['categoryid'] = $categoryid;
						$admin[$i]['roleid'] = $key ;
						$admin[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> getManagerCatePerModel() -> createAll($admin);//管理员权限入库

			//会员权限
			$member = array();
			if(isset($_POST['info']['power']['member']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['member'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$member[$i]['categoryid'] = $categoryid;
						$member[$i]['groupid'] = $key ;
						$member[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> getMemberCatePerModel() -> createAll($member);//会员权限入库
			$this -> _cache();
			admin_log('添加了新栏目', '增加了新栏目：'.$base['catname']);
			$this -> dialog('/content/column/index');
		}

		$style_dir = $this -> getHomeStyleDir();
		$index_tpl = MoFolder::readFileByPrefix($style_dir,'index_');
		$list_tpl = MoFolder::readFileByPrefix($style_dir,'list_');
		$content_tpl = MoFolder::readFileByPrefix($style_dir,'content_');
		$admin_role = $this -> getAdminRoleModel() -> findAll(array('status'=>1));
		$member_group = $this -> getMemberGroupModel() -> findAll(array('status'=>1));
		$cat_tree = $this -> getCategoryModel() -> getCategoryTree();
		$model = $this -> getTableManageModel() -> findAll(array('flag'=>1));

		$this -> assign('admin_role',$admin_role);
		$this -> assign('member_group',$member_group);
		$this -> assign('cat_tree',$cat_tree);
		$this -> assign('index_tpl',$index_tpl);
		$this -> assign('list_tpl',$list_tpl);
		$this -> assign('content_tpl',$content_tpl);
		$this -> assign('model',$model);
		$this -> assign('param',array('catid'=>isset($_GET['catid']) ? $_GET['catid'] : ''));
		$this -> display('content/column/content_column_add.html');
	}

	/**
	 * 批量栏目添加
	 *
	 */
	public function batchAction ()
	{
		if(isset($_POST['base']['other']))
		{
			$other = $_POST['base']['other'];
			foreach ($other as $key => $val )
			{
				if(!trim($val['catname']))
				{
					unset($other[$key]);
				}
				else
				{
					$tmp = preg_split ('/[\s|\s]+/', $val['child']);
					foreach ($tmp as $k => $v )
						if(empty($v)) unset($tmp[$k]);
					$other[$key]['child'] = $tmp;
				}
			}

			if(empty($other))
			{
				$this -> dialog('/content/column/batch','error','至少填写一个顶级栏目');
			}

			Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
			$pinyin = new MoPinyin();
			//一级栏目批量添加
			foreach ($other as $key => $val )
			{
				$base['catname'] = $val['catname'];
				$base['model'] = $_POST['base']['model'];
				$base['pid'] = 0;
				$base['filepath'] = '';
				$base['indextpl']   = $_POST['base']['indextpl'];
				$base['columntpl']  = $_POST['base']['columntpl'];
				$base['contenttpl'] = $_POST['base']['contenttpl'];
				$base['isnav'] = 1;
				$base['columnoption'] = $_POST['base']['columnoption'];
				$base['dirpath'] = $_POST['base']['dirpath'];
				$base['columnattr'] = 1;
				$base['columncross'] = 1;
				$base['crossid'] = '';
				$base['seo_title'] = '';
				$base['seo_keywords'] = '';
				$base['seo_description'] = '';
				$base['ordernum'] = $val['ordernum'];
				$base['created'] = time();
				$base['filepath'] = $pinyin->toPinyin($base['catname']);
				$base['filepath'] = $this -> checkFilePath($base['filepath']);
				$categoryid = $this -> getCategoryModel() -> create($base);//基本信息入库
				$this -> batchAddMemberPermission($categoryid);
				$this -> batchAddManagePermission($categoryid);
				foreach ($val['child'] as $k => $v )
				{
					$base['catname'] = $v;
					$base['pid'] = $categoryid;
					$base['ordernum'] = 0;
					$base['filepath'] = $pinyin->toPinyin($base['catname']);
					$base['filepath'] = $this -> checkFilePath($base['filepath']);
					$cid = $this -> getCategoryModel() -> create($base);
					$this -> batchAddMemberPermission($cid);
				    $this -> batchAddManagePermission($cid);
				}
				admin_log('添加了新栏目','增加了新栏目：'.$base['catname']);
			}
			$this -> dialog('/content/column/index');
		}
		$model = $this -> getTableManageModel() -> findAll(array('flag'=>1));
		$this -> _cache();

		$style_dir = $this -> getHomeStyleDir();
		$index_tpl = MoFolder::readFileByPrefix($style_dir,'index_');
		$list_tpl = MoFolder::readFileByPrefix($style_dir,'list_');
		$content_tpl = MoFolder::readFileByPrefix($style_dir,'content_');
		$this -> assign('index_tpl',$index_tpl);
		$this -> assign('list_tpl',$list_tpl);
		$this -> assign('content_tpl',$content_tpl);

		$this -> assign('model',$model);
		$this -> assign('for',array(0,1,2,3,4,5,6,7,8,9));
		$this -> display('content/column/content_column_batch.html');
	}

	/**
	 * 批量添加会员组栏目权限
	 */
	function batchAddMemberPermission ($categoryid)
	{
		$member_pre = $this -> getMemberCatePerModel();
		$member_group = $this -> getMemberGroupModel() -> findAll(array('status'=>1));
		foreach ($member_group as $key => $val )
		{
			$member_pre->createAll(array(array('categoryid'=>$categoryid,'groupid'=>$val['id'],'permissionid'=>1),array('categoryid'=>$categoryid,'groupid'=>$val['id'],'permissionid'=>2)));
		}
	}

	/**
	 * 批量添加管理员栏目权限
	 */
	function batchAddManagePermission ($categoryid)
	{
		$manage_pre = $this -> getManagerCatePerModel();
		$admin_role = $this -> getAdminRoleModel() -> findAll(array('status'=>1));
		foreach ($admin_role as $key => $val )
		{
			$info = array();
			$base = array('categoryid'=>$categoryid,'roleid'=>$val['id']);
			for ($i=1;$i<7;$i++)
			{
				$base['permissionid'] = $i;
				$info[] = $base;
			}
			$manage_pre->createAll($info);
		}
	}

	/**
	 * 栏目修改
	 *
	 */
	public function editAction ()
	{
		//提交修改
		if(isset($_POST['id']) && $_POST['id'])
		{
			$categoryid = $_POST['id'];
			//全部的基本信息
			$base = $_POST['info']['base'];
			if(trim($base['catname']) == '') {
				$this -> dialog("/content/column/edit/catid/$categoryid",'error','栏目名称不能为空');
                exit();
            }
			$child_id = $this -> getCategoryModel() -> getChildidByPid($categoryid);
			array_push($child_id,$categoryid);
			if(in_array($base['pid'],$child_id))
			{
				$this -> dialog('/content/column/index','error','不能选择自己或自己的子级作为父级');
				exit();
			}
			if(isset($_POST['pinyin']) || empty($base['filepath']))
			{
				Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
				$pinyin = new MoPinyin();
				$base['filepath'] = $pinyin->toPinyin($base['catname']);
				$base['filepath'] = $this -> checkFilePath($base['filepath']);
			}
			$this -> getCategoryModel() -> update(array('id'=>$categoryid),$base);//基本信息跟新
			admin_log('修改了栏目', '修改了栏目：'.$base['catname']);

            if($_POST['info']['base']['columnoption'] ==1) {  //链接到栏目默认首页
                $path = '../html/'.$base['filepath'].'/';
                $dirs = explode('/',$path);
                $pos = strrpos($path, ".");
                if ($pos === false) {
                    $subamount=0;
                }
                else {
                    $subamount=1;
                }
                for ($c=0; $c < count($dirs) - $subamount; $c++) {
                $thispath="";
                for ($cc=0; $cc <= $c; $cc++) {
                $thispath.=$dirs[$cc].'/';
                }
                if (!file_exists($thispath)) {
                    mkdir($thispath, $mode = 0777);
                    }
                }
                ob_start();
                $filename = "index.html";
                $static = file_get_contents(HOST_NAME . "category/Category/index/cid/$categoryid");  //文章模型
                //$static = file_get_contents(HOST_NAME . "goods/Goods/index/cid/$categoryid");  //商品模型
                echo $static;
                $text = ob_get_contents();
                ob_end_clean();
                $con = fopen($filename, "w");
                fwrite ($con,$text);
                fclose ($con);
                @rename($filename, $path . $filename);
            }

			//管理员权限
			$admin = array();
			if(isset($_POST['info']['power']['admin']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['admin'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$admin[$i]['categoryid'] = $categoryid;
						$admin[$i]['roleid'] = $key ;
						$admin[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}

			$this -> getManagerCatePerModel() -> delete(array('categoryid'=>$categoryid));
			$this -> getManagerCatePerModel() -> createAll($admin);//管理员权限入库

			//会员权限
			$member = array();
			if(isset($_POST['info']['power']['member']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['member'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$member[$i]['categoryid'] = $categoryid;
						$member[$i]['groupid'] = $key ;
						$member[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> getMemberCatePerModel() -> delete(array('categoryid'=>$categoryid));
			$this -> getMemberCatePerModel() -> createAll($member);//会员权限入库
			$this -> _cache();
			$this -> dialog('/content/column/index');
		}
		$catid = isset ( $_GET['catid'] ) ? intval($_GET['catid']) : 0 ;
        $cat_obj = M('category')->where(array('id' => $catid))->getOne();
		if(!$cat_obj) $this -> dialog('/content/column/index','error','参数有误');
		if ($cat_obj['model'] == 2) {
            $content_num = D('Goods', 'modules')->getGoodsNumber (array('categoryid' => $catid));
        }else {
            $content_num = $this -> getMaintableModel()->getContentNumberByColumn($catid);
        }
		$style_dir = $this -> getHomeStyleDir();
		$index_tpl = MoFolder::readFileByPrefix($style_dir,'index_');
		$list_tpl = MoFolder::readFileByPrefix($style_dir,'list_');
		$content_tpl = MoFolder::readFileByPrefix($style_dir,'content_');
		$model = $this -> getTableManageModel() -> findAll(array('flag'=>1));

		$column_info = $this -> getCategoryModel() -> find(array('id'=>$catid));
		$admin_role = $this -> getAdminRoleModel() -> findAll(array('status'=>1));
		$member_group = $this -> getMemberGroupModel() -> findAll(array('status'=>1));
		$cat_tree = $this -> getCategoryModel() -> getCategoryTree();
		$manager_cat_pre = $this -> getManagerCatePerModel() -> getPermissionByCatgoryId($catid);
		$member_cat_pre = $this -> getMemberCatePerModel() -> getPermissionByCatgoryId($catid);

		$this -> assign('index_tpl',$index_tpl);
		$this -> assign('list_tpl',$list_tpl);
		$this -> assign('content_tpl',$content_tpl);
		$this -> assign('model',$model);

		$this -> assign('content_num',$content_num);
		$this -> assign('column_info',$column_info);
		$this -> assign('admin_role',$admin_role);
		$this -> assign('member_group',$member_group);
		$this -> assign('cat_tree',$cat_tree);
		$this -> assign('admin',$manager_cat_pre ? $manager_cat_pre[$catid] : array());
		$this -> assign('member',$member_cat_pre ? $member_cat_pre[$catid] : array());
		$this -> display('content/column/content_column_edit.html');
	}



	/**
	 * 栏目跟新排序
	 *
	 */
	public function updateOrderAction ()
	{
		$column = isset ( $_POST['column'] ) ? array_flip($_POST['column']) : array();
		$ordernum = array_intersect_key($_POST['ordernum'],$column);
		foreach ($ordernum as $key => $val )
		{
			$this -> getCategoryModel() -> update(array('id'=>$key),array('ordernum'=>$val));
		}
		$this -> dialog('/content/column/index');
	}

	/**
	 * 栏目删除
	 *
	 */
	public function delAction ()
	{
		//接栏目ID
		$catid = isset ( $_GET['catid'] ) ? intval($_GET['catid']) : 0 ;
		if(!$catid) $this -> dialog('/content/column/index','error','参数错误');

		//栏目表模型
		$cat_model = $this -> getCategoryModel();

		//寻找子分类
		$childs = $cat_model->getChildidByPid($catid);//子id
		array_push($childs,$catid);
		$childs_str = implode(',',$childs);
		$where = array('in'=>array('categoryid'=>$childs_str));

		//文章信息表模型
		$main_model = $this -> getMaintableModel();
		$goods_model = $this -> getGoodsModel();

		//栏目下信息个数
		$info_count = $main_model->findCount($where)+$goods_model->findCount($where);

		//判断栏目下信息个数是否为0
		if($info_count > 0)
			$this -> dialog('/content/column/index','error','删除失败！栏目下有'.$info_count.'条内容信息，不能删除！');

		//清理信息
		$table_manager_model = $this -> getTableManageModel();
		$manager_pre_model = $this -> getManagerCatePerModel();
		$member_pre_model = $this -> getMemberCatePerModel();
		foreach ($childs as $val)
		{
			$column_info = $cat_model->find(array('id'=>$val),null,'model');
			$model_info  = $table_manager_model -> find(array('id'=>$column_info['model']),null,'tablename');//查出附表模型表名
			$cat_model->deleteSecondTableInfo(array('tablename'=>$model_info['tablename'],'categoryid'=>$val));//删除附表信息
		}

		$tmp = array();
		$_cat = $cat_model->findAll(array('in'=>array('id'=>$childs_str)));
		foreach ($_cat as $key => $val )
		{
			$tmp[] = $val['catname'];
		}

		$cat_model         -> delete(array('in'=>array('id'=>$childs_str)));
		$manager_pre_model -> delete($where);	//删除管理员栏目权限
		$member_pre_model  -> delete($where);	//删除会员栏目权限
		$main_model        -> delete($where);//删除该栏目下的主表信息
		admin_log('删除了栏目', '删除了栏目：'.implode('、',$tmp));
		$this -> _cache();
		$this -> dialog('/content/column/index','success','删除成功！');
	}

	/**
	 * 栏目移动
	 * @param
	 * @return
	 */
	function movetoAction ()
	{
		$model = $this -> getCategoryModel();
		if(isset($_POST) && !empty($_POST))
		{
			$id =isset($_POST['id']) ? intval($_POST['id']) : 0 ;
			$pid =isset($_POST['pid']) ? intval($_POST['pid']) : 0 ;

			$childs = $model->getChildidByPid($id);
			array_push($childs,$id);
			if(!in_array($pid,$childs))
			{
				$model->update(array('id'=>$id),array('pid'=>$pid));
				$this -> assign('tips','移动成功！');
				$this -> display('content/column/content_column_tips.html');
				exit();

			}
			else
			{
				$this -> assign('tips','移动失败，不能选择本身和本身的子集作为父集');
				$this -> display('content/column/content_column_tips.html');
				exit();
			}
		}

		$cid =isset($_GET['cid']) ? intval($_GET['cid']) : 0 ;
		$cat_tree = $model -> getCategoryTree();
		$this -> assign('cat_tree',$cat_tree);
		$this -> assign('cid',$cid);
		$this -> display('content/column/content_column_moveto.html');
	}
	/**
	 * ajax验证目录保存名不能重复
	 */
	public function ajaxcheckpathAction ()
	{
		$editid = isset ( $_POST['editid'] ) ? intval($_POST['editid']) : 0;
		$filepath = isset ( $_POST['filepath'] ) ? trim($_POST['filepath']) : '';
		$where = '`filepath`="'.$filepath.'"';
		if($editid) $where .= ' and `id` != \''.$editid.'\'';
		$rows = $this -> getCategoryModel() -> find($where,null,'id');
		echo !empty($rows) ? 1 : 0;
	}

	/**
	 * 通过栏目名获取唯一目录名拼音
	 */
	public function checkFilePath ($filepath)
	{
		$editid = isset ( $_POST['editid'] ) ? intval($_POST['editid']) : 0;
		$model = $this -> getCategoryModel();
		$where = ' `filepath`="'.$filepath.'" ';
		if($editid)
		{
			$where .= ' AND `id` != `"'.$editid.'"` ';
		}
		while ( $model -> find($where,null,'id') )
		{
			$filepath = $filepath.rand(100,999);
			$where = ' `filepath`="'.$filepath.'" ';
			if($editid)
			{
				$where .= ' AND `id` != `"'.$editid.'"` ';
			}
		}
		return $filepath;
	}

	/**
	 * 栏目表model
	 * @return object
	 */
	public function getCategoryModel ()
	{
		return D('CategoryModel');
	}

	/**
	 * 栏目表model
	 * @return object
	 */
	public function getGoodsModel ()
	{
		return D('GoodsModel','modules','admin');
	}

	/**
	 * 会员分组model
	 * @return object
	 */
	public function getMemberGroupModel ()
	{
		return D('MemberGroupModel');
	}

	/**
	 * 管理员角色Model
	 * @return object
	 */
	public function getAdminRoleModel ()
	{
		return D('AdminRoleModel');
	}

	/**
	 * 管理员栏目权限表model
	 * @return object
	 */
	public function getManagerCatePerModel ()
	{
		return D('ManagerCatePerModel');
	}

	/**
	 * 会员栏目权限表model
	 * @return object
	 */
	public function getMemberCatePerModel ()
	{
		return D('MemberCatePerModel');
	}

	/**
	 * 模型表model
	 * @return object
	 */
	public function getTableManageModel ()
	{
		return D('TableManageModel');
	}

	/**
	 * 模型表MaintableModel
	 * @return object
	 */
	public function getMaintableModel ()
	{
		return D('MaintableModel');
	}

	/**
	 * 模型表model
	 * @return object
	 */
	public function getMyModel ()
	{
		return D('MyModel');
	}

	function getColumnTreeAction ()
	{
		$model_id = $this -> post('model');
		$tree = $this -> getCategoryModel() -> getCategoryTree();
		foreach ($tree as $key => $val )
		{
			if($val['model'] != $model_id)
				unset($tree[$key]);
		}
		echo json_encode($tree);
	}


	/**
	 * 生成缓存
	 * @author wr 2013.5.3
	 */
	protected function _cache()
	{
		$this -> getCategoryModel()->getCategoryCacheList();      //获取所有栏目列表
	}

	function updatecacheAction ()
	{
		$this -> _cache();
		exit();
	}
}