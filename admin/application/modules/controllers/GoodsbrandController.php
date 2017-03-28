<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 模块管理 商品展示 商品品牌
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-16 16:44 创建此文件
 * <br>雷少进  2013-01-16 16:44 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsbrandController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodsbrandController extends AdminController
{
	/**
	 * 商品品牌列表
	 *
	 */
	public function indexAction ()
	{
		$plist = $this -> getGoodsBrandModel() -> getPageList(array('where'=>' 1 ORDER BY `created` DESC'));
		foreach ($plist['list'] as $key => $val )
			$plist['list'][$key]['goods_numbers'] = $this -> getGoodsModel() -> findCount(array('brandid'=>$val['brandid']));

		$this -> assign('plist',$plist);
		$this -> display('modules/goods/modules_goodsbrand_index.html');
	}

	/**
	 * 商品品牌添加
	 *
	 */
	public function addAction ()
	{
		if(!empty($_POST))
		{
			//品牌logo上传
			$file_arr = $this -> uploadBrand();
			if(isset($file_arr[0]))
				$file_arr = $file_arr[0];
			if(isset($file_arr['path']) && $file_arr['path'])
			{
				 $info['logo'] = $file_arr['path'];
				 $info['alt'] = $file_arr['alt'];
			}

			$info['brandname'] = isset ( $_POST['brandname'] ) ? trim($_POST['brandname']) : '';
			if(empty($info['brandname'])) $this->dialog('/modules/goodsbrand/add','error','品牌名不能为空');
			$info['url'] = isset($_POST['url']) ? trim($_POST['url']) : '' ;
			$info['brief'] = isset($_POST['brief']) ? trim($_POST['brief']) : '' ;
			$info['created'] = time();
			$res = $this -> getGoodsBrandModel() ->create($info);
			admin_log('添加商品品牌', '添加了商品品牌'.$info['brandname']);
			if($res)
				$this->dialog('/modules/goodsbrand/index/p/'.$this -> page);
			else
				$this->dialog('/modules/goodsbrand/index','error','添加失败');
		}

		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  array('jpg','jpeg','gif','png','bmp'),
			'local'		  => true,			  //是否显示本地图库
			'folder'      => true            //是否显示目录浏览
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		$this -> display('modules/goods/modules_goodsbrand_add.html');
	}

	/**
	 * 商品品牌修改
	 *
	 */
	public function editAction ()
	{
		if(isset($_POST['brandid']) && $_POST['brandid'])
		{
			$info['brandname'] = isset ( $_POST['brandname'] ) ? trim($_POST['brandname']) : '';
			if(empty($info['brandname'])) $this->dialog('','error','品牌名不能为空');
			$info['url'] = isset($_POST['url']) ? trim($_POST['url']) : '' ;
			$info['brief'] = isset($_POST['brief']) ? trim($_POST['brief']) : '' ;
			$info['created'] = time();
			if (isset($_POST['logo_alt'])&&!empty($_POST['logo_alt']))
			{
				$logo_alt = $_POST['logo_alt'];
			}
			else {
				$logo_alt = '';
			}

			if(isset($_POST['accessory']))
			{
				//修改LOGO 如果之前有LOGO，则新上传的会覆盖旧的，并且文件名保持旧logo名
				$old_logo = isset ( $_POST['old_logo'] ) ? trim($_POST['old_logo']) : '';	//旧Logo 2013_06/{5C729A4C-43A5-BFFD-9C6A-1315C958172B}.jpg
				$file_arr = $this -> uploadBrand('/static/uploadfile/brand/'.$old_logo);    //上传新LOGO

				if(isset($file_arr[0]))
				{
					$file_arr = $file_arr[0];
					$tmp = explode('/',$file_arr['path']);
					$f1 = array_pop($tmp);
					$f2 = array_pop($tmp);
					$logo_alt = $file_arr['alt'];
				}
				if(isset($file_arr['path']) && ($old_logo != $f2.'/'.$f1))
				{
					$info['logo'] = $f2.'/'.$f1;
					@unlink($file_arr['sp']['base'].'/'.$old_logo);//删除旧logo
				}
			}
			else if($_POST['is_del'] == 1)
			{
				$save_path = getFileSavePath('brand');
				@is_file($save_path['base'].DS.$_POST['old_logo']) && @unlink($save_path['base'].DS.$_POST['old_logo']);
				$info['logo'] = '';
				$logo_alt = '';
			}
			$info['alt'] = $logo_alt;
			admin_log('编辑商品品牌', '编辑了商品品牌'.$info['brandname']);
			$res = $this -> getGoodsBrandModel() ->update(array('brandid'=>$_POST['brandid']),$info);
			if($res)
				$this->dialog('/modules/goodsbrand/index/p/'.$this -> page);
			else
				$this->dialog('/modules/goodsbrand/index','error','更新失败');
		}
		$brandid = isset ( $_GET['brandid'] ) ? intval($_GET['brandid']) : 0 ;
		if(!$brandid) $this->dialog('','error','参数有误');
		$info = $this -> getGoodsBrandModel() -> find(array('brandid'=>$brandid));
		$this -> assign('info',$info);

		$setting = array
		(
			'limit'       =>  2,
			'type'        =>  array('jpg','jpeg','gif','png','bmp'),
			'local'		  => true,			  //是否显示本地图库
			'folder'      => true            //是否显示目录浏览
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);

		$this -> display('modules/goods/modules_goodsbrand_edit.html');
	}

	/**
     * 品牌上传
	 * 上传后的文件名 格式为，8ww99rw9erwejrwriwhri  不带后缀名的
	 */
	public function uploadBrand ($target_name='')
	{
		//品牌logo上传
		$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
		if($accessory)
		{
			$temp[] = current($accessory);
			return moUploadAccessory(array('file'=>$temp,'folder'=>'brand','new_name'=>$target_name,'time_name'=>true));
		}
		return array();
	}

	/**
	 * 商品品牌删除
	 *
	 */
	public function delAction ()
	{
		$brandid = isset ( $_GET['brandid'] ) ? intval($_GET['brandid']) : (isset ( $_POST['brandid'] ) ? implode(',',$_POST['brandid']) : '');
		if(!$brandid) $this->dialog('','error','参数有误');
		$save_path = getFileSavePath('brand');	//存储目录
		$info =  $this -> getGoodsBrandModel() -> findAll(array('in'=>array('brandid'=>$brandid)));
		foreach ($info as $key => $val)
			@unlink($save_path['base'].'/'.$val['logo']);

		$this -> getGoodsBrandModel() -> delete(array('in'=>array('brandid'=>$brandid)));
		$bname = isset ($_GET['bname'])?urldecode($_GET['bname']):'';
		admin_log('删除商品品牌', '删除了商品品牌:' . $bname);
		$this->dialog('/modules/goodsbrand/index');
	}

	public function ajaxcheckAction ()
	{
		echo $this -> getGoodsModel()->findCount(array('in'=>array('brandid'=>$_POST['ids'])));
	}

	/**
	 * 商品品牌表模型
	 *
	 */
	function getGoodsBrandModel ()
	{
		return D('GoodsBrandModel');
	}

	/**
	 * 商品品牌表模型
	 *
	 */
	function getGoodsModel ()
	{
		return D('GoodsModel');
	}
}