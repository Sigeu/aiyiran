<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentController.php
 *
 * 内容管理类
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   ContentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class ContentController extends AdminController
{
	public static $page; //当前页码
	public static $keywords; //关键字
	public static $desc; //升降
	public static $order; //排序
	public static $categoryid; //栏目ID
	public static $modelid;
	public  $contentModel;
	public  $maintableModel;
	public static $modelUrl;
	public  $searchModel;
	public  $tagModel;
	
	public function init()
	{
		self::$page =  Controller::get('p') ? Controller::get('p') : Controller::get('page') ;
		self::$page = self::$page ? self::$page : 1;
		self::$keywords = urldecode(Controller::getParams('keywords','')); //防止汉字乱码
		self::$desc = Controller::getParams('desc','1');//默认降序
		self::$order = Controller::getParams('order','created');//最后发布时间
		self::$categoryid = Controller::getParams('categoryid','');
		self::$modelid =  Controller::getParams('mid');
		self::$modelUrl =  get_cache('modelUrl','common');
		$this->contentModel = D('Content');
		$this->maintableModel = D('Maintable');
		$this->searchModel    = D('Search','search','home');
		$this->tagModel       = D('Tags','extensions');
		parent::init();
		//判断登陆
		//判断权限
	}

	/**
	 * 内容管理首页
	 */
	public function indexAction()
	{
		$urlArr = array(
				'indexUrl' => $this->createUrl('content/Content/index/page/'.self::$page),
				'addUrl' => $this->createUrl('content/Content/add/page/'.self::$page),
				'updateUrl' => $this->createUrl('content/Content/update/page/'.self::$page),
				'detailUrl' => $this->createUrl('content/Content/detail/page/'.self::$page),
				'replaceUrl' => $this->createUrl('content/Content/replace/page/'.self::$page),
				'delUrl' => $this->createUrl('content/Content/del/page/'.self::$page),
				'columnUrl' => $this->createUrl('content/Column/index'),
				'moveHtmlUrl' => $this->createUrl('content/Content/moveCategory'),//移动页面
				'moveUrl' => $this->createUrl('content/Content/move/page/'.self::$page),//移动处理
				'updateorderUrl' => $this->createUrl('content/Content/updateorder/page/'.self::$page),
		);
		$search = array();
		$categoryList = $this->contentModel->getCategoryTree(self::$modelid); //获取本模型下面的栏目
		foreach($categoryList as $k=>$v)
		{
			if($v['model']==2)
			{
				$cat_temp[$k]['flag']=false;
			}
			else
			{
				$categoryList[$k]['flag']=true;
			}
		}
		//判断弹出层的权限
		$hasper = 1;
		if(!in_array('/content/content/movecategory',$_SESSION['alllinks']))
		{
			$hasper = 1;
		}
		else
		{
			if(!in_array('/content/content/movecategory',$_SESSION['mylinks'])&&$_SESSION['roleid']!=1)
			{
				$hasper = 0;
			}

		}
		$search = array(
			'keywords'=>self::$keywords,
			'categoryid'=>self::$categoryid,
			'order'=>self::$order,//最后修改时间
			'desc'=>self::$desc//默认降序
		);
		$search['modelid'] = self::$modelid;
		set_cache('modelUrl', self::$modelid,'common');
		$count = $this->contentModel->getContentListOnlyMain($search,true);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$search['limit'] = $from.','.$pagesize;
		$list = $this->contentModel->getContentListOnlyMain($search,false);
		$this->assign('hasper',$hasper);
		$this->assign('categoryList',$categoryList);
		$this->assign('pagestr',$page->show());
		$this->assign('urlArr',$urlArr);
		$this->assign('list',$list);
		$this->assign('search',$search);
		$this->display("content/content/index");
	}
	/**
	 * 添加内容
	 */
	public  function addAction()
	{
		self::$modelid = self::$modelid ? self::$modelid : 0;
		$urlArr = array(
			'addsaveUrl' => $this->createUrl('content/Content/addsave/page/'.self::$page.'/mid/'.self::$modelid),
			'indexUrl'=>$this->createUrl('/content/Content/index/page/'.self::$page.'/mid/'.self::$modelUrl)
		);
		$ContentForm = new ContentForm(self::$modelid);
		$form = $ContentForm->get();
		$formvalidator = $ContentForm->formValidator;
		$this->assign('urlArr',$urlArr);
		$this->assign('form',$form);
		$this->assign('formvalidator',$formvalidator);
		$this->assign('categoryid',isset($_GET['categoryid']) ? $_GET['categoryid'] : 0);
		$this->display('content/content/add');
	}
	/**
	 * 保存添加内容
	 */
	public  function addsaveAction()
	{
		self::$modelid = self::$modelid ? self::$modelid : 1;
		$mainkey = array('categoryid','title','subtitle','seotitle','keywords','description','source','username','thumb','hits','sorttype','publishopt','publishtime');
		$content = $_POST['info'];
		$ContentValue = new ContentValue(self::$modelid,$this);
		$content['sorttype'] = strtotime('+ '.$content['sorttype'].' days',strtotime($content['publishtime']));
		$content = $ContentValue->get($content);
		$mainArr = array();
		foreach ($mainkey as $key=>$value)
		{
			if(isset($content[$value]))
			{
				$mainArr[$value] = $content[$value];
				unset($content[$value]);

			}
		}
		/*主表内容*/
		$mainArr['updatetime'] = $mainArr['publishtime'];
		$mainArr['created'] = time();
		$userinfo = $_SESSION['userinfo'];
		$mainArr['publishuser'] = $userinfo['username'];
		$mainArr['updateuser'] = $userinfo['username'];
		/**wake1 star**/
		$cemetery_id = Controller::post('cemetery_id');
		if(isset($cemetery_id)){
			$mainArr['cemetery_id'] = $cemetery_id;
		}
		/**wake1 end**/
		$maintalbeId = M('maintable')->create($mainArr);

		if(!$maintalbeId)
		{
			$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'error','添加失败');
		}
		/*附表内容*/
		$tablename = M('model')->field('tablename')->where(array('id'=>self::$modelid))->getOne();
		$content['maintable_id'] = $maintalbeId;

		$contentId = M($tablename['tablename'])->create($content);


		if(!$contentId)
		{
			$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'error','附表内容添加失败');
		}
		else
		{
            if($_POST['info']['publishopt'] == 1) {  //即时生成静态文件
                $article = $this->maintableModel->find(array('id'=>$maintalbeId),false,'categoryid,publishtime');
                $category = $this->maintableModel->getCatgoryName($article['categoryid']);
                $time = date("Y/m/d",$article['publishtime']);
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

                //若开启文章自动分页
                $pageConfig = get_mo_config('mo_arcautosp');
                $countnum = 1;
                if($pageConfig == 'Y') {
                    $pageNum = get_mo_config('mo_arcautosp_sum');//多少个字符分一页
                    $contentpage = new ContentPage();
                    $mycontent = $contentpage->get_data($content['content'], $pageNum);
                    $mycontents = array_filter(explode('[page]',$mycontent));
                    $countnum = count($mycontents);
                }
                for ($i=1;$i<=$countnum;$i++) {
                    ob_start();
                    $filename = 'content_'. $maintalbeId . '_' . $i . '.html';
                    $static = file_get_contents(HOST_NAME . "content/Content/index/id/$maintalbeId/cpage/$i/up_click/0");
                    echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'content/Content/index/id/' . $maintalbeId  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
                    $text = ob_get_contents();
                    ob_end_clean();
                    $con = fopen($filename, "w");
                    fwrite ($con,$text);
                    fclose ($con);
                    @rename($filename, $path . $filename);
                }
            }
	        //Tag标签接口
	        if (isset($mainArr['keywords'])&&!empty($mainArr['keywords']))
	        {
	        	$this -> tagModel->addTags(self::$modelid,$maintalbeId,$mainArr['keywords']);
	        
	        }
	        
	        //搜索关键词接口
	        $this->searchModel->searchAdd(self::$modelid,$mainArr['categoryid'],$maintalbeId,$mainArr['title'],$mainArr['description'],$content['content'],$mainArr['keywords']);
        
			admin_log('添加内容', '添加了内容'.$mainArr['title']);
			$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'success','添加成功');
		}
	}

	/**
	 * 查看内容
	 */
	public function detailAction()
	{
		echo "<script>alert('等前台做了再说吧');window.top.opener = null;window.close(); </script>";
	}
	/**
	 * 删除内容
	 这部分需求很奇葩，所以有些没用的东西没有注释，修改请注意
	 */
	public function delAction()
	{
		$ids = Controller::getParams('id');
		$cid = Controller::getParams('cid');
		$mid = Controller::getParams('mid') ? Controller::getParams('mid') : 0;
        if(is_array($ids)&&is_array($cid)&&$mid)
		{
			$Cinfo = array_combine($ids, $cid);
			$Minfo = array_combine($ids, $mid);
		}
		else
		{
			$Cinfo = array($ids=>$cid);
			$Minfo = array($ids=>$mid);
		}
		if($_SESSION['roleid'] == 1)
		{
			$array = array();
			foreach($Minfo as $key=>$value) /*把数组处理，相同模型下的内容一次性删除，节省效率*/
			{
				if(!empty($array[$value]))
				{
					array_push($array[$value], $key);
				}else{
					$array[$value] = array();
					array_push($array[$value],$key);
				}
			}
			foreach($array as $key=>$value) //循环删除多表数据
			{
				$tablename = $this->contentModel->getTable($key);//附表表名
				$delstr = implode($value, ',');
				$titles = M('maintable')->where(array('in'=>array('id'=>$delstr)))->field('title')->select();
				foreach($titles as $k=>$v)
				{
					$tem[] = $v['title'];
				}
				$titles = implode(',',$tem);
				admin_log('删除内容', '删除了'.$titles);
				//有外键关联 ，先删除附表内容
				M("{$tablename}")->delete(array('in'=>array('maintable_id'=>$delstr)));//删除附表数据
				$this->maintableModel->delete(array('in'=>array('id'=>$delstr))); //删除主表数据

				//Tag标签接口
				$this->tagModel->deleteTags($mid,$delstr);//（模型id,信息id）删除tag标签表中数据
				//搜索接口
				$this->searchModel->searchDel($mid,$delstr);//（模型id,信息id）删除tag标签表中数据

			}
			$count = count($ids);
			$this->dialog('/content/Content/index/mid/'.self::$modelUrl .'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'success',"成功删除{$count}条内容");
		}
		else
		{
			$per = $this->contentModel->getPer(4);//5，代表删除的权限
			$carrid=array();
			$noarrcid=array();
			$array = array();
			foreach($Cinfo as $key=>$value)
			{
				if(in_array($value,$per))
				{
					$carrid[] = $key; //权限通过可以删除的文章
				}
				else
				{
					$noarrcid[] = $value; //没有删除权限的栏目
				}
			}
			foreach($Minfo as $key=>$value) /*把数组处理，相同模型下的内容一次性删除，节省效率*/
			{
				if(!empty($array[$value]))
				{
					array_push($array[$value], $key);
				}else{
					$array[$value] = array();
					array_push($array[$value],$key);
				}
			}

			$count = count($ids); //总共要删除的内容条数
			$nocount  = count($noarrcid); //没有权限删除文章
			$okcount = $count-$nocount;
			$message = '';
			
			if($nocount)
			{
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl .'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'info',"对不起，您没有此操作权限");
			}
			else
			{
				foreach($array as $key=>$value) //循环删除多表数据
			    {
					$arrid = array_intersect($value, $carrid);//交叉取得有权限的文章
					$tablename = $this->contentModel->getTable($key);//附表表名
					$delstr = implode($arrid, ',');
					$titles = M('maintable')->where(array('in'=>array('id'=>$delstr)))->field('title')->select();
					foreach($titles as $k=>$v)
					{
						$tem[] = $v['title'];
					}
				    $titles = implode(',',$tem);
			        admin_log('删除内容', '删除了'.$titles);
					//有外键关联 ，先删除附表内容
					M("{$tablename}")->delete(array('in'=>array('maintable_id'=>$delstr)));//删除附表数据
					$this->maintableModel->delete(array('in'=>array('id'=>$delstr))); //删除主表数据
					admin_log('删除内容', '删除了'.$okcount.'条内容');
					$this->dialog('/content/Content/index/mid/'.self::$modelUrl .'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'success',"成功删除{$okcount}条内容 ");
			    }
			}

		}
	}

	/**
	 * 修改内容
	 */
	public function updateAction()
	{
		$per = $this->contentModel->getPer(3);//3，修改权限
		$categoryid = Controller::get('cid');
		if(in_array($categoryid,$per)||$_SESSION['roleid'] == 1)
		{
			if(Controller::post('dopost'))
			{
				$content = $_POST['info'];
				$id = Controller::post('id');
				$mainkey = array('categoryid','title','subtitle','seotitle','keywords','description','source','username','thumb','hits','sorttype','publishopt','publishtime');
				$ContentValue = new ContentValue(self::$modelid,$this);
				$content['sorttype'] = strtotime('+ '.$content['sorttype'].' days',strtotime($content['publishtime']));
				$content = $ContentValue->get($content);
				$mainArr = array();
				foreach ($mainkey as $key=>$value)
				{
					if(isset($content[$value]))
					{
						$mainArr[$value] = $content[$value];
						unset($content[$value]);
					}
				}
				/*主表内容*/
				$mainArr['updatetime'] = time();
				$userinfo = $_SESSION['userinfo'];
				$mainArr['updateuser'] = $userinfo['username'];
                $flag = M('maintable')->update(array('id'=>$id),$mainArr);
				if(!$flag)
				{
					$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'error','修改失败');
				}
				/*附表内容*/
				$tablename = M('model')->field('tablename')->where(array('id'=>self::$modelid))->getOne();
				$content2 = $content;
                unset($content2['seotitle']);
                $flag2 = M($tablename['tablename'])->update(array('maintable_id'=>$id),$content2);
				if(!$flag2)
				{
					$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'error','附表内容修改失败');
				}
				else
				{
					//Tag标签接口
					$this->tagModel->updateTags(self::$modelid,$id,$mainArr['keywords']);

					//搜索接口
					$this->searchModel->searchUpdate($mainArr['categoryid'],$id,$mainArr['title'],$mainArr['description'],$content['content'],$mainArr['keywords']);//（模型id,栏目id,信息id，标题，内容，关键词，url地址）
					
                    //更新静态页面
                    if($mainArr['publishopt'] == 1) {
                        $article = $this->maintableModel->find(array('id'=>$id),false,'categoryid,publishtime');
                        $category = $this->maintableModel->getCatgoryName($article['categoryid']);
                        $time = date("Y/m/d",$article['publishtime']);
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

                        //若开启文章自动分页
                        $pageConfig = get_mo_config('mo_arcautosp');
                        $countnum = 1;
                        if($pageConfig == 'Y') {
                            $pageNum = get_mo_config('mo_arcautosp_sum');//多少个字符分一页
                            $contentpage = new ContentPage();
                            $mycontent = $contentpage->get_data($content['content'], $pageNum);
                            $mycontents = array_filter(explode('[page]',$mycontent));
                            $countnum = count($mycontents);
                        }
                        for ($i=1;$i<=$countnum;$i++) {
                            ob_start();
                            $filename = 'content_'. $id . '_' . $i . '.html';
                            $static = file_get_contents(HOST_NAME . "content/Content/index/id/$id/cpage/$i/up_click/0");
                            echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'content/Content/index/id/' . $id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
                            $text = ob_get_contents();
                            ob_end_clean();
                            $con = fopen($filename, "w");
                            fwrite ($con,$text);
                            fclose ($con);
                            @rename($filename, $path . $filename);
                        }
                    }
					admin_log('修改内容', '修改了'.$mainArr['title']);
					$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page,'success','修改成功');
				}
			}
			else
			{
				$urlArr = array(
					'updateSaveUrl' =>  $this->createUrl('content/Content/update/page/'.self::$page.'/mid/'.self::$modelid),
				);
				$id = Controller::get('id');
				$content = $this->contentModel->getContent(array('id'=>$id),self::$modelid);

				$content['sorttype'] = ($content['sorttype']-$content['publishtime']) / 3600 /24;
				$ContentForm = new ContentForm(self::$modelid);
				$form = $ContentForm->get($content);
				$formvalidator = $ContentForm->formValidator;
				$this->assign('form',$form);
				$this->assign('id',$id);
				$this->assign('urlArr',$urlArr);
				$this->assign('formvalidator',$formvalidator);
				$this->display('content/content/update');

			}
		}
		else
		{
			$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'info',"对不起，您没有此操作权限");
		}

	}
	/**
	 * 移动文章
	 */
	public function moveCategoryAction()
	{
        $modelid = Controller::get('modelid');
		$per = $this->contentModel->getCategoryTree(self::$modelid);
                foreach ($per as $key => $val) {
                    if ($val['model'] != $modelid) {
                        $per[$key]['flag'] = false;
                    }
                }
		$this->assign('per',$per);
		$this->display('content/content/category_move.html');
	}
	/**
	 * 移动文章
	 //批量操作，有一条内容没有权限就没有成功，这部分需求很奇葩，后期修改请注意，没用的操作就不删除了，方便后面需求修改
	 */
	public function moveAction()
	{
		$moveCategoryId = Controller::get('moveCategoryId');
		$moveModelId = D('Content','content')->getMidByCid($moveCategoryId);
		$ids = Controller::get('id');
		$cid = Controller::get('cid');
		$mid = Controller::get('mid');
		$Cinfo = array_combine($ids, $cid); //合并为数组
		$Minfo = array_combine($ids, $mid); //合并为数组
		$arrid = array();
		if($_SESSION['roleid'] == 1)//管理员不用判断权限
		{
			foreach($Minfo as $key=>$value) //寻找相同的模型，只有模型相同才可以移动
			{
				if($moveModelId[0] == $value)
				{
					$arrid[] = $key;
				}
			}
			$count = count($ids); //总共要移动的内容条数
			$okcount  = count($arrid); //可以移动的内容条数
			$message = '';
			if($count-$okcount>0) $message = "　有".($count-$okcount)."条内容因为模型不同，没有成功";
			if($okcount>0)
			{
				$str = implode($arrid, ',');
				$this->maintableModel->update(array('in'=>array('id'=>$str)),array('categoryid'=>$moveCategoryId));
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'success',"成功移动{$okcount}条内容 {$message}");
			}
			else
			{
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'info',"{$message}");
			}
		}
		else
		{
			$per = $this->contentModel->getPer(5);//5，代表移动的权限
			$carrid=array();
			$noarrcid = array();
			$marrid = array();
			foreach($Cinfo as $key=>$value)
			{
				if(in_array($value,$per))
				{
					$carrid[] = $key; //权限通过可以移动的文章
				}
				else
				{
					$noarrcid[] = $value; //没有移动权限的栏目
				}
			}
			foreach($Minfo as $key=>$value) //寻找相同的模型，只有模型相同才可以移动
			{
				if($moveModelId[0] == $value)
				{
					$marrid[] = $key;//模型相同可以移动的文章
				}
			}

			if(count($noarrcid)>0)
			{
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'info',"对不起，你没有此操作权限");
			}
			$arrid = array_intersect($carrid, $marrid);//权限，模型都满足才可以移动
			$count = count($ids); //总共要移动的内容条数
			$okcount  = count($arrid); //可以移动的内容条数
			$message = '';
			//if($count-$okcount>0) $message = "　有".($count-$okcount)."条内容因为模型不同或者没有权限，没有成功";
			if($count-$okcount>0) $message = "　有".($count-$okcount)."条内容因为模型不同，没有成功";
			if($okcount>0)
			{
				$str = implode($arrid, ',');
				$this->maintableModel->update(array('in'=>array('id'=>$str)),array('categoryid'=>$moveCategoryId));
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'success',"成功移动{$okcount}条内容　{$message}");
			}
			else
			{
				$this->dialog('/content/Content/index/mid/'.self::$modelUrl.'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'info',"{$message}");

			}
		}
	}
	/**
	 * 预览表单
	 */
	public  function previewAction()
	{
		$page = Controller::get('page');
		$modelid = Controller::get('modelid');
        if (empty($modelid)) {
            $modelid = self::$modelid;
        }
		$ContentForm = new ContentForm(Controller::get('modelid'));
		$form = $ContentForm->get();
		//$formvalidator = $ContentForm->formValidator;
		$this->assign('page',$page);
		$this->assign('modelid',$modelid);
		$this->assign('form',$form);
		//$this->assign('formvalidator',$formvalidator);
		$this->display('content/content/preview');
	}
	/**
	 * 预览表单变化
	*/
	public  function chanageFormAction()
	{
		self::$modelid = self::$modelid ? self::$modelid : 0;
		$urlArr = array(
			'addsaveUrl' => $this->createUrl('content/Content/addsave/page/'.self::$page.'/mid/'.self::$modelid),
			'indexUrl'=>$this->createUrl('/content/Content/index/page/'.self::$page.'/mid/'.self::$modelUrl)
		);
		$categoryid = Controller::get('categoryid');
		$ContentForm = new ContentForm(0,$categoryid);
		$form = $ContentForm->get();
		$formvalidator = $ContentForm->formValidator;
		$this->assign('form',$form);
		$this->assign('urlArr',$urlArr);
		$this->assign('formvalidator',$formvalidator);
		$this->display('content/content/add');
	}
	/**
	 * 更新文档
	 */
	public function replaceAction()
	{
		if(Controller::post('dosubmit') == 1)
		{

		}
		else
		{
			$urlArr = array(
				'changeCategory' => $this->createUrl('content/Content/changeCategory'),
			);
			$modelList = $this->contentModel->getModelList(self::$modelid); //模型列表
			$categoryList = $this->contentModel->getCategoryTree(self::$modelid); //栏目列表
			$this->assign('categoryList',$categoryList);
			$this->assign('modelList',$modelList);
			$this->assign('modelid',self::$modelid);
			$this->assign('urlArr',$urlArr);
			$this->display('content/content/replace');

		}
	}

	/**
	 * 更换栏目表单
	 */
	public function changeCategoryAction()
	{
		$modelid = Controller::post('changeId');
		$mycategoryList = $this->contentModel->getCategoryTree($modelid);
		$this->assign('mycategoryList',$mycategoryList);
		$html = $this->fetch('content/content/categoryForm.html');
		exit($html);
	}

	/**
	 * 更新排序
	 */
	function updateorderAction ()
	{
		$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : array() ;
		$this->contentModel->updateOrder($orderby);
		$this->dialog('/content/Content/index/mid/'.self::$modelUrl .'/page/'.self::$page.'/keywords/'.self::$keywords.'/categoryid/'.self::$categoryid.'/order/'.self::$order.'/desc/'.self::$desc,'success',"操作成功");
	}
    
    public function ajaxGetTemplateAction () {
        $id = $this->getParams('id', 0);
        $categoryObj = M('category')->where(array('id' => $id))->getOne();
        $template = '';
        if ($categoryObj) {
            $template = $categoryObj['contenttpl'];
        }
        //echo json_encode($template);
        echo $template;
    }
}