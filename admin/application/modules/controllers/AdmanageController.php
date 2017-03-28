<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>申静  2013-2-21 下午6:15:18 创建此文件
 *
 * @author     申静<shenjing@mainone.cn>  2013-2-21 下午6:15:18

 * @filename   AdManageController.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: AdmanageController.php 604 2013-11-11 08:52:41Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class AdmanageController extends AdminController {
	private $adtype;           //广告类型
	private $position;         //广告位
	private $advert;           //广告
	public function init()
	{
        error_reporting(E_ALL & ~E_NOTICE);
        
        $this->advert = M('Advert');
		$this->position = M('Adposition');
		$this->adtype = M('Adtype');
		parent::init();
	}

	//广告类型
	public function indexAction(){
		$list = $this->adtype->order('id desc')->select();

		$this->assign('list',$list);
		$this->display('modules/admanage/adtype');
	}

	//广告效果设置
	public function setAction(){
		$types = array();
		$id = $this->getIds('id');
		$options['where'] = array('id'=>$id);
		$infor = $this->adtype->getOne($options);
		$infor['adtype'] = explode(',',$infor['adtype']);

		foreach($infor['adtype'] as $k=>$v){
			$types[] = $v;
		}

		$this->assign('types',$types);
		$this->assign('infor',$infor);
		$this->display('modules/admanage/infor');
	}

	//更新设置
    public function updateSetAction(){
    	$id = $this->getIds('id');
    	$arr = $_POST;
    //	$arr['adtype'] = implode(',',$arr['adtype']);

    	if($this->adtype->update(array('id'=>$id), $arr)){

    		admin_log('修改广告类型', '修改'.$arr['typename'].'广告类型');  //添加日志
    		$this->dialog('/modules/admanage/index','success','操作成功');
    		exit;
    	}else{
    		$this->dialog('/modules/admanage/index','error','操作失败');
    		exit;
    	}
    }
    //开启/关闭 广告类型
    public function openOrCloseAction(){
    	$id = $this->getIds('id');
        $state = $this->getParams('state');
        $name = urldecode($this->getParams('name'));

        if ( $state == 1 ) {

        	$opera = "开启".$name."广告类型";
        } else {

        	$opera = "关闭".$name."广告类型";
        }

    	if($id)
    	{
    		$condition = array(
    				'in'     => array('id'=>$id),
    		);

    		if($this->adtype->update($condition,array('state'=>$state)) !== false)
    		{

    			admin_log($opera, $opera);  //添加日志
    			$this->redirect($this->createUrl('modules/admanage/index'));
    		}
    	}
    }

    //广告位列表
    public function adPositionAction(){
    	$where = array();
    	$keyword = $this->getParams('keyword');
    	$category = $this->getParams('category');
    	//查询条件
    	$search['keyword'] = $keyword;
    	$search['category'] = $category;

    	if(isset($keyword) && !empty($keyword)){

    		$where['like'] = array('adname'=>$keyword);//广告位名称
    	}

    	if(isset($category) && !empty($category)){

    		$where['useclumn'] = $category;      //栏目类别
    	}
    	//分页
		$count = $this->position->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = $this->position->select($options);
        $category = $this->allClumn();//所有栏目

        $this->assign('search',$search);
        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('category',$category);
    	$this->assign('list',$list);
    	$this->display('modules/admanage/admanage');
    }
    /**
     * 添加广告位
     */
    public function addpositionAction(){

    	if(!empty($_POST)) {
    		$page = $this->getParams('page');
    		$keyword = $this->getParams('keyword');
    		$adtypeid = $this->getParams('category');
    		$adtype = explode(',', $this->getParams('adtypeid'));
    		$clumn = explode(',', $this->getParams('useclumn'));
    		$arr = array(
    				'adname'    =>$this->getParams('adname'),
    				'adsize'    =>$this->getParams('width').",".$this->getParams('height'),
    				'adpos'     =>$this->getParams('up').",".$this->getParams('left'),
    				'pos'      =>$this->getParams('pos'),
    				'addescript'=>$this->getParams('addescript'),
    		);
    		$arr['adtypeid'] = $adtype[0];
    		$arr['adtypename'] = $adtype[1];
    		if($this->getParams('fontnum'))
    		{
    			$arr['fontnum'] = $this->getParams('fontnum');
    		}
    		//选择栏目与不限栏目时的处理
    		if(is_array($clumn) && !empty($clumn) && isset($clumn[1])){
    		
    			$arr['useclumn']  = $clumn[0];
    			$arr['clumnname'] = substr($clumn[1],strpos($clumn[1],'├')+3);//投放栏目
    		}else{
    		
    			$arr['clumnname'] = "不限栏目";
    		}
    		$result = $this->position->create($arr);
    		admin_log('添加广告位', '添加'.$arr['adname']."广告位");  //添加日志
    		if($result){
    		
    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$adtypeid/keyword/$keyword",'success','操作成功');
    			exit;
    		}else{
    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$adtypeid/keyword/$keyword",'error','操作失败');
    			exit;
    		}
    	}else{
    		$effect = $this->adtype->select(array('where'=>array('state'=>1)));//广告类型
    		$cat_obj = D('CategoryModel','content','admin');
    		$category = $cat_obj->getCategoryTree();
    		//分页及条件
    		$search['page'] = $this->getParams('page');
    		$search['category'] = $this->getParams('category');
    		$search['keyword'] = $this->getParams('keyword');
    		
    		$this->assign('search',$search);
    		$this->assign('category',$category);
    		$this->assign('effect',$effect);
    		$this->display('modules/admanage/addposition');
    	}
    	
    }
    /**
     * 更新广告位
     */
    public function editPositionAction(){
    	
    	$id = $this->getIds('id');
    	$page = $this->getParams('page');
    	$keyword = $this->getParams('keyword');
    	$adtypeid = $this->getParams('category');
    	
    	if(!empty($_POST)) {
    		$adtype = explode(',', $this->getParams('adtypeid'));
    		$clumn = explode(',', $this->getParams('useclumn'));
    		
    		$arr = array(
    				'adname'    =>$this->getParams('adname'),
    				'adsize'    =>$this->getParams('width').",".$this->getParams('height'),
    				'adpos'     =>$this->getParams['up'].",".$this->getParams['left'],
    				'pos'      =>$this->getParams('pos'),
    				'addescript'=>$this->getParams('addescript'),
    		);
    		
    		if(!$id){
    			$arr['adtypeid'] = $adtype[0];
    			$arr['adtypename'] = $adtype[1];
    		}
    		if($this->getParams('fontnum'))
    		{
    			$arr['fontnum'] = $this->getParams('fontnum');
    		}
    		//选择栏目与不限栏目时的处理
    		if(is_array($clumn) && !empty($clumn) && isset($clumn[1])){
    		
    			$arr['useclumn']  = $clumn[0];
    			$arr['clumnname'] = substr($clumn[1],strpos($clumn[1],'├')+3);//投放栏目
    		}else{
    		
    			$arr['clumnname'] = "不限栏目";
    		}

    		$result = $this->position->update(array('id'=>$id), $arr);
    		admin_log('修改广告位', '更新'.$arr['adname']."广告位");  //添加日志
    		
    		//更新广告位静态调用代码
    		$arr_advert = $this->advert->findAll(array('adpositionid'=>$id));
    		foreach ($arr_advert as $row)
    		{
    			$this->create_js($row, unserialize(base64_decode($row['adimg'])));
    		}
  
    		if($result){
    		
    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$adtypeid/keyword/$keyword",'success','操作成功');
    			exit;
    		}else{
    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$adtypeid/keyword/$keyword",'error','操作失败');
    			exit;
    		}
    		
    	}else{
    		$infor = array();
    		
    		$adtypeid = $this->position->getOne(array("where"=>array('id'=>$id)));
    		$effect = $this->adtype->getOne(array('where'=>array('id'=>$adtypeid['adtypeid'])));//广告类型
    		$cat_obj = D('CategoryModel','content','admin');
    		$category = $cat_obj->getCategoryTree();
    		//分页及条件
    		$search['page'] = $page;
    		$search['category'] = $this->getParams('category');
    		$search['keyword'] = $keyword;
    		print_R($search['category']);
    		//更新广告位时当前广告位信息
    		if($id){
    			$infor = $this->position->where(array('id'=>$id))->getOne();
    			if($infor['adsize'])
    			{
    				$size = explode(',',$infor['adsize']);
    				$infor['width'] = $size[0];
    				$infor['height'] = $size[1];
    			}
    			if($infor['adpos'])
    			{
    				$pos =  explode(',',$infor['adpos']);
    				$infor['up'] = $pos[0];
    				$infor['left'] = $pos[1];
    			}
    		}
    		$this->assign('infor',$infor);
    		$this->assign('search',$search);
    		$this->assign('category',$category);
    		$this->assign('effect',$effect);
    		$this->display('modules/admanage/editposition');
    		
    	}
    }
    /**
     * 广告位删除
     */
    public function delPositionAction(){
    	$str = '0';
    	$title = "";
    	$page = $this->getIds('page');
    	$keyword = $this->getParams('keyword');
    	$category = $this->getParams('category');
    	$ids = $this->getIds('id');
    	$ads = $this->advert->where(array('in'=>array('adpositionid'=>$ids)))->field('id')->select();

        foreach($ads as $idk=>$idv){
        	$str .=",".$idv['id'];
        }

        $pos = strpos($ids,',');

        if (!$pos) {

        	$title = $this->position->where(array('id'=>$ids))->field('adname')->getOne();
        	$title = $title['adname'];
        }

    	if($ids){
    		$where = array(
    				'in'=>array('id'=>$ids),
    				);

    		if($this->position->delete($where))
    		{
    			$this->advert->delete(array('in'=>array('adpositionid'=>$ids)));
    			$this->delete_js($str);
    			admin_log('删除广告位', '删除'.$title."广告位");  //添加日志

    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$category/keyword/$keyword",'success','操作成功');
    		}else{

    			$this->dialog("/modules/admanage/adPosition/page/$page/category/$category/keyword/$keyword",'success','操作失败');
    		}
    	}

    }
    /**
     * 检查指定广告位下的广告是否存在
     */
    public function checkAdAction(){
    	$id = $this->getIds('id');
    	$num = count($this->advert->where(array('in'=>array('adpositionid'=>$id)))->select());
    	echo $num;
    }
    /**
     * 指定广告位下的广告列表
     */
    public function advertAction(){
    	$adpos = $this->getIds('adpos');     //广告位id
        $pos = $this->position->where(array('id'=>$adpos))->field('adtypename,clumnname')->getOne();
        //分页
        $count = $this->advert->findCount(array('adpositionid'=>$adpos));
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from.','.$pagesize;
        $options['order'] = "sort asc,id desc";
        $options['where'] = array('adpositionid'=>$adpos);
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->advert->select($options);

        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('pos',$pos);
        $this->assign('list',$list);
    	$this->assign('adpos',$adpos);
    	$this->display("modules/admanage/advert");
    }
    /**
     * 添加广告页面页面
     */
    public function addAdvertAction()
	{
		if(!empty($_POST)) {
			//接收基本参数
			$arr['adtitle']      = $this->getParams('adtitle');
			$arr['adpositionid'] = $this->getParams('adpos');
			$arr['timetype']     = $this->getParams('timetype');
			$arr['addtime']      = time();
			$arr['starttime']    = strtotime($this->getParams('starttime'));
			$arr['endtime']      = strtotime($this->getParams('endtime'));
			$arr['sort']         = 0;
			$arr['clicknum']     = 0;
			
			//处理广告信息
			$adimg = isset($_POST['adimg']) ? $_POST['adimg'] : array() ;				//图片集
			$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;	//附件集
			foreach ($adimg as $key1 => $val1 )
			{
				foreach ($accessory as $key2 => $val2 )
				{
					if($val1['img'] == $val2['path'])
					{
						$upload_img = moUploadAccessory(array('file'=>array($val2),'folder'=>'advert','time_name'=>true));//上传图片
						$upload_img = current($upload_img);
						unset($upload_img['sp'],$upload_img['temp']);
						$adimg[$key1]['img'] = $upload_img;
					}
				}
				if(empty($adimg[$key1]['img']))
					$adimg[$key1]['img'] = array();
			
			}
			$arr['adimg'] = base64_encode(serialize($adimg));//格式化数据储存到数据库
			//数据入库
			if($id=$this->advert->create($arr))
			{
				$arr['id'] = $id;
				$this->create_js($arr,$adimg);
				$this->position->update(array('id'=>$arr['adpositionid']),array('addition'=>array('adnum'=>'adnum+1')));
			
				admin_log('添加广告', '添加'.$arr['adtitle'].'广告');  //添加日志
				$this->dialog("/modules/admanage/advert/adpos/".$arr['adpositionid']);
			}
			else
				$this->dialog("/modules/admanage/advert/adpos/".$arr['adpositionid'],'error','操作失败');
			
		}else{
			
			$backUrl = "/modules";
			$state = $this->getParams('state');//1表示返回广告位列表页，2表示返回广告列表页
			$keyword = $this->getParams('keyword');
			$category = $this->getParams('category');
			$page  = $this->getParams('page');
			$adpos = $this->getIds('adpos');
			
			if ($state ==1) {
			
				$backUrl .="/admanage/adPosition";
				if (isset($keyword) && $keyword !="") {
			
					$backUrl .= "/keyword/".$keyword;
				}
			
				if (isset($category) && $category !="") {
			
					$backUrl .= "/category/".$category;
				}
			
				$backUrl .="/p/".$page;
			
			} else if ($state == 2) {
			
				$backUrl .= "/admanage/advert/adpos/".$adpos;
			}
			
			$infor = $this->position->where(array('id'=>$adpos))->getOne();//当前广告位信息
			$type  = $this->adtype->where(array('id'=>$infor['adtypeid']))->getOne();
			$infor['adnum'] = $type['adnum'];
			$infor['adtime'] = $type['adtime'];
			$infor['typefilename']=$type['typefilename'];
			$type = explode(',', $type['adtype']);
			
			$this->assign('backUrl',$backUrl);
			$this->assign('page',$page);
			$this->assign('adpos',$adpos);
			$this->assign('type',$type);
			$this->assign('infor',$infor);
			$allowtype = get_mo_config('mo_picturetype');

			$setting = array
			(
					'limit'       =>  2,
					'type'        =>  explode("|",$allowtype),
					'local'       =>true,
					'folder'      =>true,
			);
			$setting['setting'] = base64_encode(serialize($setting));
			$this -> assign('setting',$setting);
			$this -> assign('adpos',$adpos);
			
			$this->display("modules/admanage/addAdvert");
		}
		
    }
	/**
     * 修改广告页面
     */
    public function editorAdvertAction()
	{
		$id = $this->getIds('id');//当前要修改的id
       if(!empty($_POST)) {
       	
       	$rubbish = isset($_POST['rubbish']) ? unserialize(base64_decode($_POST['rubbish'])) : array() ;
       	if($id)
       	{
       		$this->getParams('starttime');
       		$this->getParams('endtime');
       		//接收基本参数
       		$page                = $this->getParams('page');
       		$arr['adtitle']      = $this->getParams('adtitle');
       		$arr['adpositionid'] = $this->getParams('adpos');
       		$arr['timetype']     = $this->getParams('timetype');
       		$arr['starttime']    = strtotime($this->getParams('starttime'));
       		$arr['endtime']      = strtotime($this->getParams('endtime'));
       	
       		//处理广告信息
       		$adimg     = isset($_POST['adimg']) ? $_POST['adimg'] : array() ;
       		$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;
       	
       		foreach ($adimg as $key1 => $val1 )
       		{
       			if($val1['img'] == '' && $val1['old_img'] != '')
       			{
       				$adimg[$key1] = unserialize(base64_decode($val1['old_img']));
       				$adimg[$key1]['link'] = $val1['link'];
       				$adimg[$key1]['font'] = $val1['font'];
       			}
       			else
       			{
       				foreach ($accessory as $key2 => $val2 )
       				{
       					if($val1['img'] == $val2['path'])
       					{
       						$upload_img = moUploadAccessory(array('file'=>array($val2),'folder'=>'advert','time_name'=>true));//上传图片
       						$upload_img = current($upload_img);
       						unset($upload_img['sp'],$upload_img['temp']);
       						$adimg[$key1]['img'] = $upload_img;
       	
       						//继续装载垃圾图片
       						$tmp = unserialize(base64_decode($adimg[$key1]['old_img']));
       						if(isset($tmp['img']) && is_array($tmp['img']) && !empty($tmp['img']))
       							$rubbish[] = $tmp['img']['folder'].'/'.$tmp['img']['path'];
       					}
       				}
       				if(empty($adimg[$key1]['img']))
       					$adimg[$key1]['img'] = array();
       			}
       			unset($adimg[$key1]['old_img']);
       		}
       	
       		$arr['adimg'] = base64_encode(serialize($adimg));
       	
       		//跟新入库 更新JS文件
       		if($this->advert->update(array('id'=>$id), $arr))
       		{
       			$arr['id'] = $id;
       			$this->clearRubbishImg($rubbish);
       			$this->create_js($arr,$adimg);
       	
       			admin_log('修改广告', '修改'.$arr['adtitle'].'广告');  //添加日志
       			$this->dialog('/modules/admanage/advert/adpos/'.$arr['adpositionid'].'/page/'.$page);
       		}
       		else
       			$this->dialog('/modules/admanage/advert/adpos/'.$arr['adpositionid'].'/page/'.$page,'error','操作失败');
       	}
       	else
       		$this->dialog('','error','参数错误');
       }else{
       	
       	if($id){
       	$rubbish_img = array();
       	//基本参数
       	$page  = $this->getParams('page'); //当前页
       	$adpos = $this->getIds('adpos');   //当前广告位ID
       	$infor = $this->position->where(array('id'=>$adpos))->getOne();			  //当前广告位信息
       	$type  = $this->adtype->where(array('id'=>$infor['adtypeid']))->getOne(); //广告位类型
       	
       	//广告位类型参数处理
       	$infor['adtime']       = $type['adtime'];
       	$infor['typefilename'] = $type['typefilename'];
       	$_type                 = explode(',', $type['adtype']);
       	
       	//广告位数据处理
       	$curinfor = $this->advert->where(array('id'=>$id))->getOne();
       	$curinfor['adimg'] = unserialize(base64_decode($curinfor['adimg']));//还原格式化数据
       	foreach ($curinfor['adimg'] as $key => $val )
       		$curinfor['adimg'][$key]['old_img'] = (is_array($val['img']) && !empty($val['img'])) ? base64_encode(serialize($val)) : '';
      
       	//广告数目增减处理
       	$current_adimg_num = count($curinfor['adimg']);//当前广告图片信息
       	$poor = $type['adnum'] - $current_adimg_num;//系统设定可添加广告数目和现有广告数目的差
       	if($poor > 0)
       	{
       		for ($i=0;$i<$poor;$i++)
       			array_push($curinfor['adimg'],array('link'=>'','font'=>'','img'=>array(),'old_img'=>''));
       	}
       	if($poor < 0 )
       	{
       	$poor = abs($poor);
       	for ($i=0;$i<$poor;$i++)
       	{
       	$tmp = array_pop($curinfor['adimg']);
       	if(is_array($tmp['img']) && !empty($tmp['img']))
       	$rubbish_img[] = $tmp['img']['folder'].'/'.$tmp['img']['path'];
       	}
       	}
       	$allowtype = get_mo_config('mo_picturetype');
			//渲染页面
       	$setting = array
       	(
       	'limit'       =>  2,
       	'type'        =>  explode("|",$allowtype),
       	'local'       =>true,
       	'folder'      =>true,
       	);
     
       			$setting['setting'] = base64_encode(serialize($setting));
       			$this -> assign('setting',$setting);
       	
       			$this->assign('rubbish',base64_encode(serialize($rubbish_img)));
       			$this->assign('curinfor',$curinfor);
       			$this->assign('page',$page);
       			$this->assign('id',$id);
       			$this->assign('adpos',$adpos);
       					$this->assign('authkey',authkey('1,jpg|jpeg|gif|png|bmp,1,0,3,picture'));
       					$this->assign('type',$_type);
			$this->assign('infor',$infor);
       				$this->display("modules/admanage/editor_advert");
		}
       			else
       					$this->dialog('','error','参数错误');
       }

			
    }

    /**
     * 保存修改广告
     */
    public function updateAdvertAction()
	{
		$id = $this->getIds('id');
		$rubbish = isset($_POST['rubbish']) ? unserialize(base64_decode($_POST['rubbish'])) : array() ;
		if($id)
		{
			$this->getParams('starttime');
			$this->getParams('endtime');
			//接收基本参数
			$page                = $this->getParams('page');
			$arr['adtitle']      = $this->getParams('adtitle');
			$arr['adpositionid'] = $this->getParams('adpos');
			$arr['timetype']     = $this->getParams('timetype');
			$arr['starttime']    = strtotime($this->getParams('starttime'));
			$arr['endtime']      = strtotime($this->getParams('endtime'));

			//处理广告信息
			$adimg     = isset($_POST['adimg']) ? $_POST['adimg'] : array() ;
			$accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;

			foreach ($adimg as $key1 => $val1 )
			{
				if($val1['img'] == '' && $val1['old_img'] != '')
				{
					$adimg[$key1] = unserialize(base64_decode($val1['old_img']));
					$adimg[$key1]['link'] = $val1['link'];
					$adimg[$key1]['font'] = $val1['font'];
				}
				else
				{
					foreach ($accessory as $key2 => $val2 )
					{
						if($val1['img'] == $val2['path'])
						{
							$upload_img = moUploadAccessory(array('file'=>array($val2),'folder'=>'advert','time_name'=>true));//上传图片
							$upload_img = current($upload_img);
							unset($upload_img['sp'],$upload_img['temp']);
							$adimg[$key1]['img'] = $upload_img;

							//继续装载垃圾图片
							$tmp = unserialize(base64_decode($adimg[$key1]['old_img']));
							if(isset($tmp['img']) && is_array($tmp['img']) && !empty($tmp['img']))
								
								$rubbish[] = $tmp['img']['folder'].'/'.$tmp['img']['path'];
						}
					}
					if(empty($adimg[$key1]['img']))
						$adimg[$key1]['img'] = array();
				}
				unset($adimg[$key1]['old_img']);
				
			}

			$arr['adimg'] = base64_encode(serialize($adimg));

			//跟新入库 更新JS文件
			if($this->advert->update(array('id'=>$id), $arr))
			{
				$arr['id'] = $id;
				$this->clearRubbishImg($rubbish);
				$this->create_js($arr,$adimg);

				admin_log('修改广告', '修改'.$arr['adtitle'].'广告');  //添加日志
				$this->dialog('/modules/admanage/advert/adpos/'.$arr['adpositionid'].'/page/'.$page);
			}
			else
				$this->dialog('/modules/admanage/advert/adpos/'.$arr['adpositionid'].'/page/'.$page,'error','操作失败');
		}
		else
			$this->dialog('','error','参数错误');

    }

	/**
	 * 删除垃圾广告图片
	 */
	function clearRubbishImg ($rubbish)
	{
		if($rubbish)
		{
			$upload_path = realpath(DIR_UPLOADFILE);
			foreach ($rubbish as $key => $val )
			{
				@unlink($upload_path.'/'.$val);
			}
		}
	}
    /**
     * 生成js文件
     */
    public function create_js($ad,$adimg){
    	$str = "";
    	$ad['adimg'] = unserialize(base64_decode($ad['adimg']));
    	$position = $this->position->getOne(array('where'=>array('id'=>$ad['adpositionid'])));
    	$size = explode(',',$position['adsize']);
    	$adpos = explode(',',$position['adpos']);
        $type = $this->adtype->getOne(array('where'=>array('id'=>$position['adtypeid'])));

    	$ad['width'] = $size[0];
    	$ad['height'] = $size[1];
        $ad['pos'] = $position['pos'];
        $ad['up'] = $adpos[0];
        $ad['left'] = $adpos[1];

        $str = $this->fontStr($ad,$type,$position);

    	if($type['typefilename']=='couplet' || $type['typefilename']=='change'){

    		$this->assign('adimg',$adimg);
    	}else{
    		$this->assign('adimg',$adimg[0]);
    	}

    	$this->assign('str',$str);
    	$this->assign('ad',$ad);
    	$this->assign('type',$type);
    	$this->assign('n',1);//图片路径与预览图片路径的区分
    	$content = $this->fetch('public/advert/'.$type['typefilename'].'.html');
        if (!is_dir('../html/adcache')) {
            mkdir('../html/adcache', 0755);
        }
    	file_put_contents("../html/adcache/".$ad['id'].'.js',$content);
    }

    /**
     * 广告删除
     */
    public function delAdvertAction(){
    	$id = $this->getIds('id');
    	$adpos = $this->getIds('adpos');
    	$page = $this->getParams('page');
    	$num = count(explode(',',$id));
    	$name = urldecode($this->getParams('name'));

    	if($id){
    		$where = array(
    				'in'=>array('id'=>$id),
    		);
    		$rs = $this->advert->delete($where);
    		$this->delete_js($id);
    		if($rs){

    			$this->position->update(array('id'=>$adpos),array('addition'=>array('adnum'=>'adnum-'.$num)));

    			admin_log('删除广告', '删除'.$name.'广告');  //添加日志
    			$this->dialog("/modules/admanage/advert/adpos/$adpos/page/$page");
    		}else{
    			$this->dialog("/modules/admanage/advert/adpos/$adpos/page/$page",'error','操作失败');
    		}
    	}
    }
    /**
     * 删除静态文件
     * @param $ids string (用逗号分隔的广告的id号)
     *
     */
    public function delete_js($ids){
    	$ids = explode(',',$ids);

    	foreach($ids as $ik=>$iv){
    		$path = "../html/adcache/".$iv.'.js';
    		if(file_exists($path)){
    			unlink ($path);
    		}
    	}
    }
    /**
     * 广告排序
     */
    public function advertSortAction(){
    	$sortid = $this->getIds('sort');
 	    $sortid = explode(',',$sortid);
 	    $ids = $this->getIds('ids');
 	    $ids = explode(',',$ids);
 	    $adpos = $this->getIds('adpos');
 	    $page = $this->getParams('page');
 	    $options = array_combine($ids, $sortid);
 	    //更新排序
 	    $flag = $this->advert->updateAll('id','sort',$options,$ids);

 	    if($flag){

 	    	$this->dialog("/modules/admanage/advert/adpos/$adpos/page/$page");
 	    }else{
 	    	$this->dialog("/modules/admanage/advert/adpos/$adpos/page/$page",'error','操作失败');
 	    }
    }
    /**
     * 预览广告效果
     */
    public function previewAction(){
    	$str = "";
    	$flash = 0;
    	$id = $this->getIds('id');
    	$typeid = $this->getIds('type');
    	$ad = array();
    	$time_style = $this->adtype->getOne(array('where'=>array('id'=>$typeid)));
    	$size = $this->position->field('adsize,pos,fontnum,adpos')->getOne(array('where'=>array('id'=>$id)));

    	if($time_style['adtime']){

          if($time_style['adtime'] == 2){          //广告类型设置为手动设置时按排序取最前一条的广告

          	$ad = $this->advert->getOne(array('where'=>array('adpositionid'=>$id),'order'=>array('sort desc,id desc')));
          }else if($time_style['adtime'] == 1){    //广告类型设置为“按上架时间显示一个"取最后添加的一条广告

          	$ad = $this->advert->getOne(array('where'=>array('adpositionid'=>$id),'order'=>array('addtime desc')));
          }
          if(!empty($ad)){
          	$ad['adimg'] = unserialize(base64_decode($ad['adimg']));
            if (isset($ad['adimg'][0]['img']['filename']) && substr($ad['adimg'][0]['img']['filename'],strrpos($ad['adimg'][0]['img']['filename'],'.')+1) == "swf")
            {
            	
            	$flash = 1;
            	
            }
          }
          
          //对宽高，链接的整合
          $tem = explode(',',$size['adsize']);
          $ad['width'] = $tem[0];
          $ad['height'] = $tem[1];
          $ad['pos'] = $size['pos'];

          //对上边距与左边距的操作
          $adpos = explode(",",$size['adpos']);
          $ad['left'] = $adpos[1];
          $ad['up'] = $adpos[0];

          $str = $this->fontStr($ad,$time_style,$size);

          $this->assign('flash',$flash);
          $this->assign('str',$str);
          $this->assign('ad',$ad);

          if($time_style['typefilename']=='couplet' || $time_style['typefilename']=='change'){

          	@$this->assign('adimg',$ad['adimg']);
          }else{

          	@$this->assign('adimg',$ad['adimg'][0]);
          }

    	}
    	$this->assign('type',$time_style);//广告类型设置
    	$this->display('public/advert/'.$time_style['typefilename']);
    }
    /**
     * 文字广告调用
     * @param $ad array  文字信息
     * @param $time_style array 广告位类型设置
     * @param $size array  广告位大小
     * @return $str 文字字符串
     */
    public function fontStr($ad,$time_style,$size){
    	$str="";
     if(!empty($ad['adimg'])){
    	if($time_style['typefilename'] == 'word'){
    		//根据广告类型不同是否设置轮播效果
    		if($time_style['wordeffect'] ==1)
    		{

    			$num = round($ad['height']/24);  //每块显示多少条
    			$block = ceil(count($ad['adimg'])/$num);  //数组个数

    			//拼接动态内容的字符串
    			for($i=1;$i<=$block;$i++){
    				$m = $i-1;
    				$str .= "marqueeContent[$m] =\"";
    				$start = ($i*$num)-($num-1);

    				for($j=$start-1;$j<$i*$num;$j++){
    					if(isset($ad['adimg'][$j]['link']))
    					{
    						$str .= "<a href='".$ad['adimg'][$j]['link']."' target='_blank'>".substr($ad['adimg'][$j]['font'],0,$size['fontnum'])."</a>";
    					}
    				}
    				$str .="\";";
    			}

    		}else{
    			foreach($ad['adimg'] as $fk=>$fv)
    			{
    				$str .="<a href='".$fv['link']."' target='_blank'>".substr($fv['font'],0,$size['fontnum'])."</a>";
    			}
    		}
    	}
     }
    	return $str;
    }
    //代码调用
    public function adposjsAction(){
    	$obj = D("Advert");
    	$adpos = $this->getIds('adpos');
    	$typeid = $this->getIds('type');
    	$type = $this->adtype->getOne(array('id'=>$typeid));
        $ad = $obj->getAdvert($type['adtime'],$adpos);

        if(empty($ad)){

        	$ad['id'] = 0;
        }

        $this->assign('posid',$adpos);
    	$this->assign('id',$ad['id']);
    	$this->display("modules/admanage/adposjs");
    }
    //显示背投页面
    public function beiTouAction(){
    	$id = $this->getParams('id');
    	$width = $this->getParams('width');
    	$height = $this->getParams('height');
    	$flash = $this->getParams('flash');
    	if(!$id){
    		exit;
    	}
    	if($id){
    		$infor = $this->advert->getOne(array('where'=>array('id'=>$id)));
    		$infor['adimg'] = unserialize(base64_decode($infor['adimg']));
    	}

    	$this->assign('width',$width);
    	$this->assign('height',$height);
    	$this->assign('flash',$flash);
    	$this->assign('infor',$infor);
    	$this->assign('adimg',$infor['adimg'][0]);
    	$this->display('public/advert/beitou');
    }
   /**
    * 获取所有的广告类型
    */
    public function allType(){
    	return $this->adtype->select();
    }
    /**
     * 获取所有栏目
     */
    public function allClumn(){
    	$cat_obj = D('CategoryModel','content','admin');
    	$category = $cat_obj->getCategoryTree();
    	return $category;
    }

}