<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ModelmanageController.php
 *
 * 模型管理类
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-10 下午6:06:51
 * @filename   ModelmanageController.php  UTF-8 *
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class ModelmanageController extends AdminController
{
	public static $page; //当前页码
	public $myModel; //模型对象

	public function init()
	{
		self::$page =  Controller::get('p') ? Controller::get('p') : Controller::get('page') ;
		self::$page = self::$page ? self::$page : 1;
		$this->myModel = D('My');
		//判断登陆
		//判断权限
	}

	/**
	 * 模型管理首页
	 */
	public function indexAction()
	{
		$urlArr = array(
			'ContentIndexUrl' => $this->createUrl('content/Content/index'),
			'addUrl' => $this->createUrl('content/Modelmanage/add/page/'.self::$page),
			'filedUrl' => $this->createUrl('content/Fieldmanage/index'),
			'delUrl' => $this->createUrl('content/Modelmanage/del/page/'.self::$page),
			'copyUrl' => $this->createUrl('content/Modelmanage/copy/page/'.self::$page),
			'setflagUrl' => $this->createUrl('content/Modelmanage/setflag/page/'.self::$page),
			'updateUrl' => $this->createUrl('content/Modelmanage/update/page/'.self::$page),
			'sxUrl' => $this->createUrl('modules/goodstype/index'),

		);
		//$modellist = $this->myModel->where(array('notin'=>array('id'=>2)))->select();//去除商品模型
		$modellist = $this->myModel->select();//去除商品模型
		$pagesize = 20;
		$page = new Page(count($modellist), $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = 'addtime desc';
		//$options['where'] = array('notin'=>array('id'=>2));
		$list = $this->myModel->select($options);

		$this->assign('pagestr',$page->show());
		$this->assign('modellist',$list);
		$this->assign('urlArr',$urlArr);
		$this->display("content/modelmanage/index");
	}
	/**
	 * 添加模型
	 */
	public function addAction()
	{
		$urlArr = array(
				'checkTableUrl' => $this->createUrl('content/Modelmanage/checkTable'),
				'ContentIndexUrl' => $this->createUrl('content/modelmanage/index'),
				'addsaveUrl' => $this->createUrl('content/Modelmanage/addsave/p/'.self::$page),
		);
		$style_dir = $this -> getStyleDir();
		$index_list = $this->getFile($style_dir,'index_','.html');  //首页
		$list_list = $this->getFile($style_dir,'list_','.html');    //列表页
		$content_list = $this->getFile($style_dir,'content_','.html'); //内容页

		$configArr = $this->import_style_config($this->getStyle()); //配置文件数组
		$this->assign('index_list',$index_list);
		$this->assign('list_list',$list_list);
		$this->assign('content_list',$content_list);
		$this->assign('configArr',$configArr['file']);
		$this->assign('urlArr',$urlArr);
		$this->display("content/modelmanage/add");
	}
	/**
	 * 保存模型
	 */
	public function addsaveAction()
	{
		$arr = array(
			'name'=>Controller::post('modelName'),
			'tablename'=>Controller::post('tableName'),
			'category_template'=>Controller::post('category_template'),
			'list_template'=>Controller::post('list_template'),
			'content_template'=>Controller::post('content_tempalte'),
			'addtime'=>time(),
			'updatetime'=>time()
		);
		$this->myModel->query('BEGIN');
		$this->myModel->query('START TRANSACTION');
		$lastInsertId = $this->myModel->create($arr);
		$flag = $this->myModel->addModel($lastInsertId,$arr['tablename']);

		if($lastInsertId&&$flag)
		{
			admin_log('添加模型', '添加了模型'.Controller::post('modelName'));
			$this->myModel->query('COMMIT');
			$this->myModel->query('END');
		    $this -> dialog('/content/Modelmanage/index/page/'.self::$page,'success','添加成功');
		}
		else
		{
			$this->myModel->query('ROLLBACK');
			$this->myModel->query('END');
			$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','添加失败');
		}
	}
	/**
	 * 设置模型状态
	 */
	function setflagAction()
	{
		$ids = Controller::get('id') ? Controller::get('id') : Controller::post('id');
		$flag = Controller::get('flag') ? Controller::get('flag') : Controller::post('flag');
		if(is_array($ids))
		{
			$ids = implode($ids,',');
			$flag = $this->myModel->update(array('in'=>array('id'=>$ids)),array('flag'=>$flag));
		}
		else
		{
			$flag = $this->myModel->update(array('id'=>$ids),array('flag'=>$flag));
		}
		if($flag)
		{
		    $this -> dialog('/content/Modelmanage/index/page/'.self::$page,'success','操作成功');
		}
		else
		{
			$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','操作失败');
		}
	}

	/**
	 * 删除模型
	 */
	function delAction()
	{
		$ids = Controller::get('id') ? Controller::get('id') : Controller::post('id');
		$type = Controller::get('type') ? Controller::get('type') : Controller::post('type');
		$tablename = Controller::get('tablename') ? Controller::get('tablename') : Controller::post('tablename');
		$ids = is_array($ids) ? implode($ids,',') : $ids;
		//$types = is_array($type) ? implode($type,',') : $type;
		$hasCategory = M("category")->field('model,id')->where(array('in'=>array('model'=>$ids)))->select();
		$no_modelid = array();
		$no_tablename = array();
		$no_modelname = array();
		$ok_modelid = array();
		$ok_tablename = array();
		$ok_modelname = array();
		if(!is_array($tablename))
		{
			$hasContent = M("$tablename")->field('id')->getOne();
			$modelname = M('Model')->field('name,id')->where(array('tablename'=>$tablename))->getOne();

			if(!empty($hasContent))
			{
				$no_modelid[] = $modelname['id'];
				$no_modelname[] = $modelname['name'];
				$no_tablename[] = $tablename;
				$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','模型下有内容不能删除');
			}
			else
			{
				$ok_modelid[] = $modelname['id'];
				$ok_modelname[] = $modelname['name'];
				$ok_tablename[] = $tablename;
			}
		}
		else
		{
			foreach($tablename as $k=>$v)
			{
				$hasContent = M("$v")->field('id')->getOne();
				$modelname = M('Model')->field('name,id')->where(array('tablename'=>$v))->getOne();
				if(!empty($hasContent))//包含内容的
				{
					$no_modelid[] = $modelname['id'];
					$no_modelname[] = $modelname['name'];
					$no_tablename[] = $v;
				}
				else  // 不包含内容的
				{
					$ok_modelid[] = $modelname['id'];
					$ok_modelname[] = $modelname['name'];
					$ok_tablename[] = $v;
				}
			}
		}


		if(!is_array($type)&&$type == 1)//系统模型
		{
			$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','系统模型不能删除');
		}
		elseif(is_array($type) && in_array(1,$type))//包含系统模型
		{
			$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','系统模型不能删除');
		}
		else
		{
			$cids = array();
			if(!empty($hasCategory))//模型下的栏目
			{
				foreach($hasCategory as $key=>$value)
				{
					if(in_array($value['model'],$ok_modelid))
					{
						$cids[] = $value['id'];
					}
				}
				if(!empty($cids))
				{
					$this->myModel->update(array('in'=>array('id'=>implode(',',$cids))),array('model'=>1));//修改栏目模型为文章模型
				}
				//$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','模型下有栏目不能删除');
			}
			$tablename = '';
			if(is_array($ok_tablename)&&!empty($ok_tablename))
			{
				$arr = array();
				foreach($ok_tablename as $key => $value)
				{
					$arr[] = $this->myModel->tablePrefix.$value;
				}
				$tablename = implode(',',$arr);
			}
			$this->myModel->query("BEGIN");
			$this->myModel->query("START TRANSACTION");
			if(!empty($ok_modelid))
			{
				$message = '';
				if(!empty($no_modelname))
				{
					$message = ','.'失败'.count($no_modelname).'条';
					$no_model = implode(',',$no_modelname);
				}
				//if(isset($no_model)) $message = ','.$no_model.'下有内容,不能删除';
				$flag = $this->myModel->delete(array('in'=>array('id'=>implode(',',$ok_modelid)))); //删除model表的记录
				$flag2 = M('field')->delete(array('in'=>array('modelid'=>implode(',',$ok_modelid))));//删除此模型下的字段
				$flag3 = $this->myModel->query("DROP TABLES $tablename");//删除此模型的从表
				$flag4 = $this->myModel->delContent(array('in'=>array('model'=>implode(',',$ok_modelid))));//删除此下的内容
				if($flag&&$flag2&&$flag3&&$flag4)
				{
					admin_log('删除模型', '删除了模型'.implode(',',$ok_modelname));
					$this->myModel->query("COMMIT");
					$this->myModel->query("END");
					$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'info','成功删除'.count($ok_modelid)."条,{$message}");
				}
				else
				{
					$this->myModel->query("ROLLBACK");
					$this->myModel->query("END");
					$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','操作失败');
				}
			}
			else
			{
				$message = '';
				//if(!empty($no_modelname))
				//{
					$message = ','.'失败'.count($no_modelname).'条';
				//	$no_model = implode(',',$no_modelname);
				//}
				//if(!empty($no_modelname))
				//{
					//$no_model = implode(',',$no_modelname);
				//}
				//if($no_model)
				if(!empty($no_modelname))
				{
					//$message = $no_model.'下有内容,不能删除';
					$message = '成功0条,'.'失败'.count($no_modelname).'条';
					$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'info','删除成功'."{$message}");
				}else{
					$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'error','操作失败');
				}
			}

		}
	}

	/**
	 * 修改模型
	 */
	public function updateAction()
	{
		$id = Controller::get('id');
		$modelInfo = $this->myModel->where(array('id'=>$id))->getOne();

		$style_dir = $this -> getStyleDir();
		$index_list = $this->getFile($style_dir,'index_','.html');  //首页
		$list_list = $this->getFile($style_dir,'list_','.html');    //列表页
		$content_list = $this->getFile($style_dir,'content_','.html'); //内容页
		$configArr = $this->import_style_config($this->getStyle()); //配置文件数组

		if(Controller::post('id'))
		{
			$arr = array(
					'name'=>Controller::post('modelName'),
					'tablename'=>Controller::post('tableName'),
					'category_template'=>Controller::post('category_template'),
					'list_template'=>Controller::post('list_template'),
					'content_template'=>Controller::post('content_tempalte'),
					'updatetime'=>time()
			);
			$flag = $this->myModel->update(array('id'=>$id),$arr);
			if($flag)
			{
				admin_log('修改模型', '修改了模型'.Controller::post('modelName'));
				$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'success','修改成功');
			}
			else
			{
				$this -> dialog('','error','操作失败');
			}
		}

		$this->assign('index_list',$index_list);
		$this->assign('list_list',$list_list);
		$this->assign('content_list',$content_list);
		$this->assign('configArr',$configArr['file']);
		$this->assign('modelInfo',$modelInfo);
		$this->display('content/modelmanage/update');
	}
	/**
	 * 复制模型
	 */
	public function copyAction()
	{
		$mid = Controller::get('modelid');
		if(Controller::post('dosubmit') == 1)
		{   
			$array = array(
				'id' => Controller::post('id'),
				'name' => Controller::post('name'),
				'tablename' => Controller::post('tablename'),
				'category_template' => Controller::post('category_template'),
				'list_template' => Controller::post('list_template'),
				'content_template' => Controller::post('content_template'),
				'flag' => 1,//默认开启
				'addtime' => time(),
				'updatetime' => time(),
				'type' => 2,//自定义模型
			);  
			
			admin_log('复制模型', '复制了模型'.Controller::post('name'));
			$lastInsertId = $this->myModel->create($array); //添加模型记录
			$this->myModel->copyFields($mid,$lastInsertId); //复制字段   【 二期修改过 】
			$this->myModel->copyTable(Controller::post('oldid'),$array['tablename']); //复制见表
			$this -> dialog('/content/Modelmanage/index/page/'.self::$page,'success','复制成功');
		}
		else
		{
			$urlArr = array(
				'checkTableUrl' => $this->createUrl('content/Modelmanage/checkTable')
		    );
			$newModelInfo = $this->myModel->getNewModelInfo($mid);
			$this->assign('newModelInfo',$newModelInfo);
			$this->assign('urlArr',$urlArr);
			$this->display('content/modelmanage/copy');
		}
	}
	/**
	 * 获取当前模板风格
	 */
	public function getStyle()
	{
		$style = get_cache('template_style','common','home');
		$style = $style ? $style : DEFAULT_STYLE;
		return $style;
	}
	/**
	 * 获取当前模板目录
	 */
	public function getStyleDir ()
	{
		$home_tpl_style = $this->getStyle();
		$home_tpl_dir = getDirView();
		return $home_tpl_dir.$home_tpl_style;
	}
	/**
	 * 返回以某个字符开头的文件
	 *
	 */
	function getFile($dir='',$pattern='',$ext='.html')
	{
		$list = glob($dir.DS.$pattern.'*'.$ext, GLOB_NOSORT);
		foreach($list as $key => $value)
		{
			$list[$key] = basename($value);
		}
		return $list;
	}

	/**
	 * 检查表是否存在
	 */
	function checkTableAction()
	{
		$tablename = Controller::get('tableName','model');
		$tables = $this->myModel->getTables();
		foreach($tables as $key => $value)
		{
			$arr=array_values($value);
			$tem[] = $arr[0];
		}
		$flag =  in_array($this->myModel->tablePrefix.$tablename, $tem) ? '1' : '0';
		exit($flag);
	}
}