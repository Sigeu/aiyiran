<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 后台 模块管理 商品展示
 *
 * 文件修改记录：
 * <br>雷少进  2013-01-21 15:55 创建此文件
 * <br>雷少进  2013-07-02 11:14 修改此文件
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   GoodsController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class GoodsController extends AdminController
{
	/**
	 * 商品列表
	 *
	 */
	public function indexAction ()
	{
		//动态搜索条件
		$keywords    = isset($_POST['keywords']) ? trim($_POST['keywords'])   : (isset ( $_GET['keywords'] ) ? trim($_GET['keywords']) : '' );
		$by          = isset($_POST['by'])       ? trim($_POST['by'])         : (isset ( $_GET['by'] )       ? trim($_GET['by']) : 'created' );
		$categroy    = isset($_POST['categroy']) ? intval($_POST['categroy']) : (isset ( $_GET['categroy'] ) ? intval($_GET['categroy']) : '' );
		$orderby     = (isset($_POST['orderby']) && !empty($_POST['orderby'])) ? trim($_POST['orderby']) : ((isset ( $_GET['orderby'] ) && !empty($_GET['orderby'])) ? trim($_GET['orderby']) : 'DESC' );
		$sortid      = isset($_POST['sortid'])   ? intval($_POST['sortid'])   : (isset ( $_GET['sortid'] )   ? intval($_GET['sortid']) : '' );

		$search = array('keywords'=>$keywords,'by'=>$by,'categroy'=>$categroy,'orderby'=>$orderby,'sortid'=>$sortid);//搜索条件
		$sql = $this -> getGoodsModel() -> getSql($search);
		$plist = $this -> getGoodsModel() -> getPageList(array('sql'=>$sql,'search'=>$search));

		$this -> assign('categroy',$this -> getCategoryTree());
		$this -> assign('sort',$this -> getGoodsSortModel() -> getGoodsSortTree());
		$this -> assign('search',$search);
		$this -> assign('plist',$plist);
		$this -> display('modules/goods/modules_goods_index.html');
	}

	/**
	 * 商品添加
	 *
	 */
	public function addAction ()
	{
		
		$userinfo = $_SESSION['userinfo'];//用户登陆信息
		if(!empty($_POST))
		{
			//商品基本信息
			$info['goodssn']	= 'SN:'.time().rand(1000,9999);
			$info['goodsname']	= isset($_POST['goodsname'])  ? trim($_POST['goodsname']) : '' ;
			$info['subname']	= isset($_POST['subname'])    ? trim($_POST['subname']) : '' ;
			$info['categoryid'] = isset($_POST['categoryid']) ? intval($_POST['categoryid']) : 0 ;
			$info['sortid']		= isset($_POST['sortid'])     ? intval($_POST['sortid']) : 0 ;
			$info['brandid']	= isset($_POST['brandid'])    ? intval($_POST['brandid']) : 0 ;
			$info['typeid']		= isset($_POST['typeid'])     ? intval($_POST['typeid']) : 0 ;
			$info['userid']		= $userinfo['id'];
			$info['isbest']		= isset($_POST['isbest'])     ? intval($_POST['isbest']) : 2 ;
			$info['isnew']		= isset($_POST['isnew'])      ? intval($_POST['isnew']) : 2 ;
			$info['ishot']		= isset($_POST['ishot'])      ? intval($_POST['ishot']) : 2 ;
			$info['isspecial']	= isset($_POST['isspecial'])  ? intval($_POST['isspecial']) : 2 ;
			$info['title']   	= isset($_POST['title'])      ? trim($_POST['title']) : '' ;
			$info['keywords']	= isset($_POST['keywords'])   ? trim($_POST['keywords']) : '' ;
			$info['brief']		= isset($_POST['brief'])      ? trim($_POST['brief']) : '' ;
			$info['content']	= isset($_POST['content'])    ? $_POST['content'] : '' ;
			$info['marketprice']	= isset($_POST['marketprice'])  ? round(floatval($_POST['marketprice']),2) : 0 ;
			$info['shopprice']		= isset($_POST['shopprice'])    ? round(floatval($_POST['shopprice']),2) : 0 ;
			$info['unit']			= isset($_POST['unit'])         ? trim($_POST['unit']) : '' ;
			$info['publishtime']	= isset($_POST['publishtime'])  ? trim($_POST['publishtime']) : '1997-01-01' ;
			$info['publishopt']		= isset($_POST['publishopt'])   ? intval($_POST['publishopt']) : 2 ;

			$info['alowpower']		= isset($_POST['alowpower']) && !empty($_POST['alowpower']) ? implode(',',$_POST['alowpower']) : '-1' ;
			$info['iscomment']		= isset($_POST['iscomment']) ? ($_POST['iscomment']) : 1 ;
			$info['goodstpl']		= isset($_POST['goodstpl'])  ? trim($_POST['goodstpl']) : '' ;
			$info['modification']	= time();
			$info['created']		= time();

			$goods_id = $this -> getGoodsModel() -> create($info);
			

			//Tag标签接口     
			$tag_name = $info['keywords'];
			if (!empty($tag_name))
			{
				$this -> getTagModel() -> addTags(2,$goods_id,$tag_name);
			}
			
			//搜索关键词接口
			$this->getSearchModel()->searchAdd(2,$info['categoryid'],$goods_id,$info['goodsname'],$info['brief'],$info['content'],$info['keywords'],$info['created']);
				

			//关联商品
			$goods_ids = isset($_POST['relationid']) ? $_POST['relationid'] : array() ;
			$relation = isset($_POST['relation']) ? intval($_POST['relation']) : 1 ;
			$link_model = $this -> getGoodsLinkGoodsModel();
			foreach ($goods_ids as $val )
				$link_model->create(array('goodsid'=>$goods_id,'relgoodsid'=>$val,'relation'=>$relation));

			//属性值
			$attr = isset($_POST['attr']) ? $_POST['attr'] : array() ;
			$attr_model = $this -> getGoodsAttrValueModel();
			foreach ($attr as $key => $val )
			{
				if(empty($val)) continue;
				$attr_model->create(array('attrid'=>$key,'value'=>(is_array($val) ? implode(',',$val) : $val),'goodsid'=>$goods_id));
			}

			//商品相册
// 			$this -> uploadGoodsAlbum($goods_id);
			$this -> uploadGoodsPhoto($goods_id);
			admin_log('添加商品', '添加了商品:'.$info['goodsname']);

			//跳转
			if($goods_id)
			{
				//即时生成HTML文件
				if($info['publishopt'] ==1)
				{
					$good = $this->getGoodsModel()->find(array('goodsid'=>$goods_id),false,'categoryid,created');
					$category = $this->getGoodsModel()->getCatgoryName($good['categoryid']);
					$time = date("Y/m/d",$good['created']);
					$path = '../html/'.$category.'/'.$time.'/';
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
					$filename = "goods_". $goods_id .".html";
					$static = file_get_contents(HOST_NAME . "goods/Goods/info/id/$goods_id/up_click/0");
					echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'goods/Goods/info/id/' . $goods_id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
					$text = ob_get_contents();
					ob_end_clean();
					$con = fopen($filename, "w");
					fwrite ($con,$text);
					fclose ($con);
					@rename($filename, $path . $filename);
				}

				$this->dialog('/modules/goods/index');
			}
			else
				$this->dialog('/modules/goods/index','error','添加失败');
		}
		$category		= $this -> getCategoryTree();                                      //获取商品栏目
		$goods_sort		= $this -> getGoodsSortModel() -> getGoodsSortTree();              //获取商品分类
		$goods_brand	= $this -> getGoodsBrandModel() -> findAll();                      //获取品牌
		$goods_type		= $this -> getGoodsTypeModel() -> findAll(array('status'=>1));     //获取商品类型
		$member_group	= $this -> getMemberGroupModel() -> findAll(array('status'=>1));   //获取前台可用的会员分组
		$style_dir		= $this -> getHomeStyleDir();                                      //前台模板目录
		$content_tpl	= MoFolder::readFileByPrefix($style_dir,'content_');
		              //内容页模板
		//$content_tpl = filterArrByStr($content_tpl , 'article' , false);

		$this -> assign('category',$category);		                         //栏目
		$this -> assign('goods_sort',$goods_sort);	                         //商品分类
		$this -> assign('goods_brand',$goods_brand);                         //商品品牌
		$this -> assign('goods_type',$goods_type);                           //商品类型
		$this -> assign('member_group',$this -> getRanks($member_group,6));  //会员类型
		$this -> assign('content_tpl',$content_tpl);                         //内容页模板

		$allow_type = $this -> getAllowType(1);

		//上传配置
		$setting = array
		(
			'limit'       =>  10,
			'type'        =>  $allow_type,
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		
		$this -> assign('categroyid',isset($_GET['categroyid']) ? $_GET['categroyid'] : 0);
		$this -> display('modules/goods/modules_goods_add.html');
	}

	protected function getAllowType ($type=1)
	{
		$allow_type = $this -> getSystemModel() -> getConfigByKey(array('mo_picturetype','mo_filetype','mo_mediatype'));
		switch ($type)
		{
			case '2'://flash
				$allow_type = array('swf');
				break;
			case '3'://音频视屏
				$allow_type = explode('|',$allow_type['mo_mediatype']);
				break;
			case '4'://其他
				$allow_type = explode('|',$allow_type['mo_filetype']);
				break;
			default://图片
				$allow_type = explode('|',$allow_type['mo_picturetype']);
		}
		return $allow_type;
	}

	/**
	 * 获取系统设置model
	 * @return SystemModel object
	 */
	public function getSystemModel ()
	{
		return D('SystemModel','webset','admin');
	}

	/**
	 * 获取行列式的角色列表
	 * @param $col列数
	 * @return array()
	 */
	 function getRanks ($list=array(),$col=3)
	 {
		if(!empty($list))
		{
			$list = array_chunk($list,$col,true);
			$last = array_pop($list);
			$count = count($last);
			if($count < $col)
			{
				for ($i=0;$i<($col-$count);$i++)
				{
					$last[] = array();
				}
			}
			$list[] = $last;
		}
		return $list;
	 }

	/**
	 * 商品修改
	 *
	 */
	public function editAction ()
	{
		$id = $this -> getParams('id','');//修改商品的ID
		if(!$id) $this -> dialog('','error','参数有误');

		$info           = $this -> getGoodsModel() -> find(array('goodsid'=>$id));            //基本信息
		$info['alowpower'] = explode(',',$info['alowpower']);
		$goods_linkid   = $this -> getGoodsLinkGoodsModel() -> findAll(array('goodsid'=>$id));//关联商品的ID
		$ids = array(0);
		if(!empty($goods_linkid)) foreach ($goods_linkid as $key => $val ) $ids[] = $val['relgoodsid'];
		$goods_link     = $this -> getGoodsModel() -> findAll(array('in'=>array('goodsid'=>implode(',',$ids))),null,'goodsid,goodsname');
		$category		= $this -> getCategoryTree();                   //栏目
		$goods_sort		= $this -> getGoodsSortModel() -> getGoodsSortTree();                 //分类
		$goods_brand	= $this -> getGoodsBrandModel() -> findAll();                         //品牌
		$goods_type		= $this -> getGoodsTypeModel() -> findAll(array('status'=>1));        //类型
		$member_group	= $this -> getMemberGroupModel() -> findAll(array('status'=>1));      //会员组
		$style_dir		= $this -> getHomeStyleDir();                                         //前台模板目录
		$content_tpl	= MoFolder::readFileByPrefix($style_dir,'content_'); 
		//$content_tpl = filterArrByStr($content_tpl , 'article' , false);                 //内容模板
		$album = $this -> getGoodsAlbumModel() ->findAll(array('goodsid'=>$id));

		$allow_type = $this -> getAllowType(1);
		$setting = array
		(
			'limit'       =>  10,
			'type'        =>  $allow_type,
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$this -> assign('setting',$setting);
		
		$this -> assign('album',$album);
		$this -> assign('info',$info);
		$this -> assign('relation',isset($goods_linkid[0]['relation']) ? $goods_linkid[0]['relation'] : 1);
		$this -> assign('goods_link',$goods_link);
		$this -> assign('category',$category);		//栏目
		$this -> assign('goods_sort',$goods_sort);	//商品分类
		$this -> assign('goods_brand',$goods_brand);//商品品牌
		$this -> assign('goods_type',$goods_type);//商品类型
		$this -> assign('member_group',$this -> getRanks($member_group,6));//会员类型
		$this -> assign('content_tpl',$content_tpl);//内容也模板
		$this -> display('modules/goods/modules_goods_edit.html');
	}

	/**
	 * 商品提交修改
	 *
	 */
	public function doeditAction ()
	{
		//接收要修改记录的ID
		$id = $this -> post('id');
		if(!$id) $this -> dialog('','error','参数有误');
		$userinfo = $_SESSION['userinfo'];//用户登陆信息

		//更新商品基本信息
		$info['goodsname']	 = isset($_POST['goodsname']) ? $_POST['goodsname'] : '' ;
		$info['subname']	 = isset($_POST['subname']) ? $_POST['subname'] : '' ;
		$info['categoryid']	 = isset($_POST['categoryid']) ? intval($_POST['categoryid']) : 0 ;
		$info['sortid']	     = isset($_POST['sortid']) ? intval($_POST['sortid']) : 0 ;
		$info['brandid']	 = isset($_POST['brandid']) ? intval($_POST['brandid']) : 0 ;
		$info['typeid']	     = isset($_POST['typeid']) ? intval($_POST['typeid']) : 0 ;
		$info['userid']		 = $userinfo['id'];
		$info['isbest']      = isset($_POST['isbest']) ? intval($_POST['isbest']) : 2 ;
		$info['isnew']       = isset($_POST['isnew']) ? intval($_POST['isnew']) : 2 ;
		$info['ishot']       = isset($_POST['ishot']) ? intval($_POST['ishot']) : 2 ;
		$info['isspecial']   = isset($_POST['isspecial']) ? intval($_POST['isspecial']) : 2 ;
		$info['title']	 = isset($_POST['title']) ? trim($_POST['title']) : '' ;
		$info['keywords']	 = isset($_POST['keywords']) ? trim($_POST['keywords']) : '' ;
		$info['brief']	     = isset($_POST['brief']) ? trim($_POST['brief']) : '' ;
		$info['content']	 = isset($_POST['content']) ? trim($_POST['content']) : '' ;
		$info['marketprice'] = isset($_POST['marketprice']) ? round(floatval($_POST['marketprice']),2) : 0 ;
		$info['shopprice']	 = isset($_POST['shopprice']) ? round(floatval($_POST['shopprice']),2) : 0 ;
		$info['unit']	     = isset($_POST['unit']) ? trim($_POST['unit']) : '' ;
		$info['publishtime'] = isset($_POST['publishtime']) ? trim($_POST['publishtime']) : '1997-01-01' ;
		$info['publishopt']	 = isset($_POST['publishopt']) ? intval($_POST['publishopt']) : 2 ;
		$info['alowpower']   = isset($_POST['alowpower']) && !empty($_POST['alowpower']) ? implode(',',$_POST['alowpower']) : '-1' ;
		$info['iscomment']	 = isset($_POST['iscomment']) ? intval($_POST['iscomment']) : 1 ;
		$info['goodstpl']	 = isset($_POST['goodstpl']) ? trim($_POST['goodstpl']) : '' ;
		$info['modification']	= time();
		$this -> getGoodsModel() -> update(array('goodsid'=>$id),$info);
		
		//Tag标签接口
		$this -> getTagModel() -> updateTags(2,$id,$info['keywords']);
		error_reporting(0);
		//搜索关键词接口
		$this->getSearchModel()->searchUpdate($info['categoryid'],$id,$info['goodsname'],$info['brief'],$info['content'],$info['keywords']);
			

		//关联商品 全部删除后在重新插入
		$goods_ids = isset($_POST['relationid']) ? $_POST['relationid'] : array() ;
		$relation = isset($_POST['relation']) ? intval($_POST['relation']) : 1 ;
		$link_model = $this -> getGoodsLinkGoodsModel();
		$link_model -> delete(array('goodsid'=>$id));
		foreach ($goods_ids as $val )
			$link_model->create(array('goodsid'=>$id,'relgoodsid'=>$val,'relation'=>$relation));

		//更新属性值 全部删除后在重新插入
		$attr = isset($_POST['attr']) ? $_POST['attr'] : array() ;
		$attr_model = $this -> getGoodsAttrValueModel();
		$attr_model -> delete(array('goodsid'=>$id));
		foreach ($attr as $key => $val )
		{
			if(empty($val)) continue;
			$attr_model->create(array('attrid'=>$key,'value'=>(is_array($val) ? implode(',',$val) : $val),'goodsid'=>$id));
		}

		//商品相册处理
		$save_path = getFileSavePath('goods');
		$album_model = $this -> getGoodsAlbumModel();
		$old_photo = isset($_POST['old_photo']) ? $_POST['old_photo'] : array() ;

		if(!$old_photo)//全部删除
		{
			$del_photo = $album_model->findAll(array('goodsid'=>$id));
		}
		else //部分删除
		{
			$del_photo = $album_model->findAll(array('goodsid'=>$id,'notin'=>array('albumid'=>implode(',',$old_photo))));
			// 更新ALT注释信息
			foreach ($_POST['alt'] as $kk=>$vv)
			{
				$album_model->update(array('albumid'=>$kk), array('alt'=>$vv));
			}
		}
		foreach ($del_photo as $key => $val )
		{
			$album_model->delete(array('albumid'=>$val['albumid']));
			@unlink($save_path['base'].DIRECTORY_SEPARATOR.$val['photo']);
		}
		$this -> uploadGoodsPhoto($id);
		admin_log('修改商品', '修改了商品:'.$info['goodsname']);
		//跳转
		if($id)
		{
			//编辑生成HTML文件
			if($info['publishopt'] ==1)
			{
				$good = $this->getGoodsModel()->find(array('goodsid'=>$id),false,'categoryid,created');
				$category = $this->getGoodsModel()->getCatgoryName($good['categoryid']);
				$time = date("Y/m/d",$good['created']);
				$path = '../html/'.$category.'/'.$time.'/';
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
				$filename = "goods_". $id .".html";
				$static = file_get_contents(HOST_NAME . "goods/Goods/info/id/$id/up_click/0");
				echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'goods/Goods/info/id/' . $id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
				$text = ob_get_contents();
				ob_end_clean();
				$con = fopen($filename, "w");
				fwrite ($con,$text);
				fclose ($con);
				@rename($filename, $path . $filename);
			}
			$this->dialog('/modules/goods/index');
		}
		else
			$this->dialog('/modules/goods/index','error','更新失败');
	}

	/**
	 * 商品删除
	 *
	 */
	public function delAction ()
	{
		//$this -> dialog('/modules/goods/index','error','暂不提供删除');
		$id = isset ( $_GET['id'] ) ? intval($_GET['id']) : (isset($_POST['id']) ? implode(',',$_POST['id']) : 0);

		if(!$id) $this -> dialog('','error','参数有误');
		$goods_name = $this -> getGoodsNameByIds($id);
		
		$this -> getGoodsModel() -> delete(array('in'=>array('goodsid'=>$id)));           //删除主表信息
		$this -> getGoodsAttrValueModel() -> delete(array('in'=>array('goodsid'=>$id)));  //删除属性值表信息
		$this -> getGoodsLinkGoodsModel() -> delete(array('in'=>array('goodsid'=>$id)));  //删除商品关联表信息
		$this -> getGoodsAlbumModel()-> delete(array('in'=>array('goodsid'=>$id)));       //删除相册信息
		$this -> getTagModel()->deleteTags(2,$id);			//删除Tag接口
		$this -> getSearchModel()->searchDel(2,$id);			//删除搜索关键词接口
			
		admin_log('删除商品', '删除了商品:'.$goods_name);
		$this -> dialog('/modules/goods/index');
	}

	/**
	 * 移动到
	 */
	 function movetosortAction ()
	 {
		$goodsid = implode(',',$this -> getAjaxGoodsid());
		$sortid = isset($_POST['sortid']) ? intval($_POST['sortid']) : 0 ;
		$res = $this -> getGoodsModel() -> update(array('in'=>array('goodsid'=>$goodsid)),array('sortid'=>$sortid));
		if($res)
			echo 'success';
		else
			echo 'fail';
	 }

	/**
     * 更换属性
	 */
	function updateAttrAction ()
	{
		$goodsid   = implode(',',$this -> getAjaxGoodsid());
		$isbest    = isset($_POST['isbest']) ? intval($_POST['isbest']) : 2 ;
		$isnew     = isset($_POST['isnew']) ? intval($_POST['isnew']) : 2 ;
		$ishot     = isset($_POST['ishot']) ? intval($_POST['ishot']) : 2 ;
		$isspecial = isset($_POST['isspecial']) ? intval($_POST['isspecial']) : 2 ;
		$res = $this -> getGoodsModel() -> update(array('in'=>array('goodsid'=>$goodsid)),array(
			'isbest'=>$isbest,
			'isnew'=>$isnew,
			'ishot'=>$ishot,
			'isspecial'=>$isspecial));
		if($res)
			echo '更换成功';
		else
			echo '更换失败';
	}

	/**
	 * 获取移动。更改属性时的商品ids
	 */
	function getAjaxGoodsid ()
	{
		$temp = array(0);
		$goods_arr = isset($_POST['goodsid']) ? explode(',',$_POST['goodsid']) : array() ;
		foreach ($goods_arr as $val )
		{
			$v = intval($val);
			if($v > 0 ) $temp[] = $v;
		}
		return $temp;
	}

	/**
	 * 商品相册上传
	 * @param 商品ID
	 * @return bool
	 */
	public function uploadGoodsAlbum ($goods_id)
	{
		$flag = 0;
		$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
		$upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'goods','time_name'=>true));
		foreach ($upload_info as $key => $val )
		{
			$info = array(
				'goodsid'   =>$goods_id,
				'photo'		=>$val['path'],
				'created'   =>time()
			);
			($this -> getGoodsAlbumModel() -> create($info)) && ($flag += 1);
		}
		return $flag;
	}

	/**
	 * ajax获取一定条件的商品列表
	 *
	 */
	public function ajaxlistAction ()
	{
		$search['keywords'] = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
		$search['sort'] = isset($_POST['sort']) ? trim($_POST['sort']) : '';
		$search['brand'] = isset($_POST['brand']) ? trim($_POST['brand']) : '';
		$where = array();
		if($search['sort']) $where['sortid'] = $search['sort'];
		if($search['brand']) $where['brandid'] = $search['brand'];
		if($search['keywords']) $where['like'] = array('goodsname'=>$search['keywords']);
		$list = $this->getGoodsModel()->findAll($where,false,'goodsid , goodsname');
		echo json_encode($list);
	}

	/**
	 * 商品属性表单
	 *
	 */
	public function getattrAction ()
	{
		$attr = $this -> getGoodsAttrModel() -> findAll(array('enabled'=>1,'typeid'=>$_POST['typeid']));
		foreach ($attr as $key => $val )
		{
			switch ($val['fieldtype'])
			{
				case 1:
					$html = $this -> getTextHtml($val);
					break;
				case 2:
					$html = $this -> getTextAreaHtml($val);
					break;
				case 3:
					$html = $this -> getEditorHtml($val);
					break;
				case 4:
					$html = $this -> getRadioHtml($val);
					break;
				case 5:
					$html = $this -> getCheckboxHtml($val);
					break;
				case 6:
					$html = $this -> getSelectedHtml($val);
					break;
				default:
					$html = $this -> getTextHtml($val);
			}
			$attr[$key]['html'] = $html;
		}
		$this -> assign('attr',$attr);
		$this -> assign('typeid',$_POST['typeid']);
		echo $this -> fetch('modules/goods/modules_goods_attr.html');
	}

	/**
	 * 商品修改属性表单
	 *
	 */
	public function getEditAttrAction ()
	{
		$attr = $this -> getGoodsAttrModel() -> findAll(array('enabled'=>1,'typeid'=>$_POST['typeid']));
		$attr_value = $this -> getGoodsAttrValueModel() -> findAll(array('goodsid'=>$_POST['goodsid']));
		foreach ($attr as $key => $val )
		{
			$value = array();
			foreach ($attr_value as $vk => $vv )
			{
				if($vv['attrid'] == $val['attrid'])
					$value = $vv;
			}
			switch ($val['fieldtype'])
			{
				case 1:
					$html = $this -> getEditTextHtml($val,$value);
					break;
				case 2:
					$html = $this -> getEditTextAreaHtml($val,$value);
					break;
				case 3:
					$html = $this -> getEditEditorHtml($val,$value);
					break;
				case 4:
					$html = $this -> getEditRadioHtml($val,$value);
					break;
				case 5:
					$html = $this -> getEditCheckboxHtml($val,$value);
					break;
				case 6:
					$html = $this -> getEditSelectedHtml($val,$value);
					break;
				default:
					$html = $this -> getEditTextHtml($val,$value);
			}
			$attr[$key]['html'] = $html;
		}
		$this -> assign('attr',$attr);
		$this -> assign('typeid',$_POST['typeid']);
		echo $this -> fetch('modules/goods/modules_goods_attr.html');
	}

	/**
	 *修改时的属性表单
	 */
	public function getEditTextHtml ($param,$value=array())
	{
		$this -> assign('value',$value);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_text.html');
	}

	public function getEditTextAreaHtml ($param,$value=array())
	{
		$this -> assign('value',$value);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_textarea.html');
	}

	public function getEditEditorHtml ($param,$value=array())
	{
		$this -> assign('value',$value);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_editor.html');
	}

	public function getEditRadioHtml ($param,$value=array())
	{
		$this -> assign('value',$value);
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_radio.html');
	}

	public function getEditCheckboxHtml ($param,$value=array())
	{
		$value['value'] = isset($value['value']) ? explode(',',$value['value']) : array();
		$this -> assign('value',$value);
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_checkbox.html');
	}

	public function getEditSelectedHtml ($param,$value=array())
	{
		$value['value'] = isset($value['value']) ? explode(',',$value['value']) : array();
		$this -> assign('value',$value);
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_edit_selected.html');
	}

	/**
	 * 添加时的属性表单
	 */
	public function getTextHtml ($param)
	{
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_text.html');
	}

	public function getTextAreaHtml ($param)
	{
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_textarea.html');
	}

	public function getEditorHtml ($param)
	{
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_editor.html');
	}

	public function getRadioHtml ($param)
	{
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_radio.html');
	}

	public function getCheckboxHtml ($param)
	{
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_checkbox.html');
	}

	public function getSelectedHtml ($param)
	{
		$param['defaultvalue'] = explode(",",$param['defaultvalue']);
		$this -> assign('param',$param);
		return $this -> fetch('modules/goods/_goods_selected.html');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getGoodsModel ()
	{
		return D('GoodsModel');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getGoodsLinkGoodsModel ()
	{
		return D('GoodsLinkGoodsModel');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getGoodsAttrValueModel ()
	{
		return D('GoodsAttrValueModel');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getGoodsSortModel ()
	{
		return D('GoodsSortModel');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getGoodsBrandModel ()
	{
		return D('GoodsBrandModel');
	}

	/**
	 * 商品表模型
	 *
	 */
	function getCategoryModel ()
	{
		return D('CategoryModel','content','admin');
	}

	/**
	 * 会员分组模型
	 *
	 */
	function getMemberGroupModel ()
	{
		return D('MemberGroupModel','members','admin');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsTypeModel ()
	{
		return D('GoodsTypeModel');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsAlbumModel ()
	{
		return D('GoodsAlbumModel');
	}

	/**
	 * 商品类型表模型
	 *
	 */
	function getGoodsAttrModel ()
	{
		return D('GoodsAttrModel');
	}

	/**
	 * 附件表模型
	 *
	 */
	function getContentResourceModel ()
	{
		return M('ContentResource');
	}

	/**
	 *  后台实例化Tag
	 */
	function getTagModel () 
	{
		return D('Tags','extensions');
	}

	/**
	 * 附件表模型
	 *
	 */
	function getSearchModel ()
	{
		return  D('Search','search','home');;
	}
	
	
	/**
	 * 获取商品栏目
	 */
	function getCategoryTree ()
	{
		$tree = $this -> getCategoryModel() -> getCategoryTree();
//		if($tree)
//		{
//			foreach ($tree as $key => $val )
//			{
//				if($val['model'] != '2')
//					unset($tree[$key]);
//			}
//		}

		return $tree ? $tree : array();
	}

	/**
	 * ajax验证属性的唯一性
	 * @param
	 * @return
	 */
	function ajaxchecksoleAction ()
	{
		$gid = isset($_POST['goods_edit']) ? intval($_POST['goods_edit']) : 0 ;
		$val_id = 'attr_'.$_POST['attr'];
		$res = $this -> getGoodsAttrValueModel() -> find(' attrid = \''.$_POST['attr'].'\' AND `value` = \''.$_POST[$val_id].'\' AND goodsid != \''.$gid.'\' ');
		echo $res ? 'found' : 'notfound';
	}

	/**
	 * 获取商品名称集合
	 * @param
	 * @return
	 */
	function getGoodsNameByIds ($ids)
	{
		$tmp = array();
		$goods = $this -> getGoodsModel() -> findAll(array('in'=>array('goodsid'=>$ids)));
		foreach ($goods as $key => $val )
		{
			$tmp[] = $val['goodsname'];
		}
		return implode('、',$tmp);
	}
	
	/**
	 * 商品图片上传
	 * @param 商品ID
	 * @return bool
	 */
	public function uploadGoodsPhoto ($goods_id)
	{
		$flag = 0;
		$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
		$upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'goods','time_name'=>true));
		foreach ($upload_info as $key => $val )
		{
			$param = array(
					'goodsid' => $goods_id,
					'photo'		=> $val['path'],
					'ext'		=> $val['extension'],
					'width'		=> $val['width'],
					'height'	=> $val['height'],
					'size'		=> $val['size'],
					'self_name'	=> $val['selfname'],
					'alt'	    => $val['alt'],
					'created'   => time()
			);
			($this -> getGoodsAlbumModel() -> create($param)) && ($flag += 1);
		}
		return $flag;
	}
	
	/**
	 *  商品图片修改
	 *  
	 */
	public function editAlbumAction() {
		
		$goods_id = isset($_POST['goods_id'])?$_POST['goods_id']:1;//商品ID
		$albumid = isset($_POST['albumid'])?$_POST['albumid']:1;//修改图片的ID
		$info = isset($_POST['info'])?$_POST['info']:array();//修改图片的信息
		$album_info[1]['selfname'] = $info[0];//图片名
		$album_info[1]['path'] = $info[1];//图片上传路径
		$album_info[1]['isimage'] = $info[2];//是否图片
		$album_info[1]['iswatermark'] = $info[3];//是否水印
		$album_info[1]['size'] = $info[4];//尺寸大小
		
		$upload_info = moUploadAccessory(array('file'=>$album_info,'folder'=>'goods','time_name'=>true));// 上传并制作缩略图
		
		foreach ($upload_info as $key => $val )
		{
			$param = array(
					'goodsid' => $goods_id,
					'photo'		=> $val['path'],
					'ext'		=> $val['extension'],
					'width'		=> $val['width'],
					'height'	=> $val['height'],
					'size'		=> $val['size'],
					'self_name'	=> $val['selfname'],
					'alt'	    => $val['alt'],
					'created'   => time()
			);
			
			$this -> getGoodsAlbumModel() -> update(array('albumid'=>$albumid) , $param);
		}
		
		$flag = $this -> getGoodsAlbumModel()->field('count(albumid) as flag')->where("albumid='{$albumid}'")->select();//用于确定这个图片是否是老图片
		echo $flag[0]['flag'];
		
	}
    
    /**
	 * 批量更新商品排序
	 */
	function sortnumAction ()
	{
		$sortnum = isset ( $_POST['sortnum'] ) ? $_POST['sortnum'] : array();
		$this -> getGoodsModel() ->batchUpdateSortnum($sortnum);
		$this->dialog('/modules/goods/index');
	}
	
	
}