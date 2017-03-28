<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * TagmanageController.php
 * 
 * 标签管理类
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-10 上午9:49:06
 * @filename   TagmanageController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
if (!defined('IN_MAINONE')||!defined('IN_ADMIN')) exit('No permission');
class TagmanageController extends AdminController
{
	public function init()
	{
		
		//判断登陆
		//判断权限
	}
	/**
	 * 标签列表页
	 */
	public function indexAction ()
	{				
		//重组URl，防止改变路由设置找不到路径
		$nowpage = Controller::get('page',1);
		$pagesize = 20;
		$urlArr = array(
			'delOneUrl' => $this->createUrl('template/Tagmanage/deleteOne/page/'.$nowpage),
			'delUrl' => $this->createUrl('template/Tagmanage/delete/page/'.$nowpage),    
			'indexUrl' => 	$this->createUrl('template/Tagmanage/index/page/'.$nowpage),
			'updateUrl' => $this->createUrl('template/Tagmanage/update/page/'.$nowpage),
			'addUrl' => $this->createUrl('template/Tagmanage/add/page/'.$nowpage),	
		);
		$taglist = template_taglist();   //标签列表
		//分页开始
		$page = new ArrayPage(count($taglist),$pagesize);
		$pageStr = $page->getArray();
		$pageData = $page->getData($taglist);
		$this->assign('page',$pageStr);
		//分页结束
		$configArr = $this->import_tag_config(true); //引入配置文件的数组
		
		$this->assign('taglist',$pageData);
		$this->assign('urlArr',$urlArr);
		$this->assign('configArr',$configArr);
		$this->display('template/tagmanage/index');
	}
	
	/**
	 * 删除标签文件
	 */
	public function deleteAction()
	{
		$nowpage = Controller::get('page',1);
		$tagArr = Controller::getParams('tagname');
		if(!is_array($tagArr))
		{
			$tagArr = array($tagArr);
		}
		$configArr = $this->import_tag_config(true); //引入配置文件的数组
		foreach($tagArr as $key => $value)
		{
			$value = strpos($value, '.lib.php') ? $value : $value . '.lib.php';
			if($configArr[$value]['system'] != 1)
			{
				admin_log('删除标签', '删除了标签'.$value);
				unlink(DIR_TAG.$value);
				unset($configArr[$value]);
			}
			else
			{			
				$this->dialog('/template/Tagmanage/index/page/'.$nowpage,'error','系统标签不能删除');exit;
			}
			
		}
		file_put_contents($this->import_tag_config(false), '<?php return '.var_export($configArr, true).';?>');
		$this->dialog('/template/Tagmanage/index/page/'.$nowpage,'success','删除成功');
	}
	
	
	
	/**
	 * 修改标签
	 */
	public function updateAction()
	{
		$nowpage = Controller::get('page',1);
		$tagname = Controller::get('tagname');
		$tagname = strpos($tagname, '.lib.php') ? $tagname : $tagname . '.lib.php';
		$content = file_get_contents(DIR_TAG.$tagname);
		$configArr = $this->import_tag_config(true); //引入配置文件的数组
		$urlArr = array(
			'saveUrl' => $this->createUrl('template/Tagmanage/updateSave/page/'.$nowpage),
		);
	
		$this->assign('urlArr',$urlArr);
		$this->assign('tagname',$tagname);
		$this->assign('configArr',!empty($configArr[$tagname]) ? $configArr[$tagname] : array());
		$this->assign('content',$content);
		$this->display('template/tagmanage/update');
		//$this->redirect($this->createUrl('template/Templatemanage/index/page/'.$nowpage));
	}
	/**
	 * 修改标签文件保存
	 */
	public function updateSaveAction()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		
		if(strtolower($_SERVER['REQUEST_METHOD'])=='post')
		{
			$array = array(
				'name' => Controller::post('tagname'),
				'content' => $_POST['content'],
			);
			$configArr = $this->import_tag_config(true);
			$configArr[$array['name']] = array('describe' =>Controller::post('describe'),'system' => Controller::post('system') ? Controller::post('system') : 0 );
			file_put_contents($this->import_tag_config(false), '<?php return '.var_export($configArr, true).';?>');
			file_put_contents(DIR_TAG.$array['name'],$array['content']);
		}
		admin_log('修改标签', '修改了标签'.Controller::post('tagname'));
		$this->dialog('/template/Tagmanage/index/page/'.$nowpage,'success','操作成功');
	}
	
	/**
	 * 添加标签文件
	 */
	public function addAction()
	{
		$nowpage = Controller::get('page',1);
		$urlArr = array(
		   'saveUrl' => $this->createUrl('template/Tagmanage/addSave/page/'.$nowpage),
		   'checkTagNameUrl' => $this->createUrl('template/Tagmanage/checkTagName'),
		   'indexUrl' => $this->createUrl('template/Tagmanage/index/page/'.$nowpage),
		);
		
		$this->assign('urlArr',$urlArr);
		$this->display('template/tagmanage/add');
		//$this->redirect($this->createUrl('template/Templatemanage/index/page/'.$nowpage));
	}
	
	/**
	 * 添加保存文件
	 */
	public function addSaveAction()
	{
		$nowpage = Controller::get('page',1); //（当前页码）
		
		if(strtolower($_SERVER['REQUEST_METHOD'])=='post')
		{
		 	$configArr = $this->import_tag_config(true);
		 	$configArr[Controller::post('tagname')] = array('describe' =>Controller::post('describe'),'system' =>  0 );
			file_put_contents($this->import_tag_config(false), '<?php return '.var_export($configArr, true).';?>');
			MoFile::write(DIR_TAG.Controller::post('tagname'),htmlspecialchars_decode(Controller::post('content')));
				
		}
		admin_log('添加标签', '添加了标签'.Controller::post('tagname'));
		$this->dialog('/template/tagmanage/index/page/'.$nowpage,'success','操作成功');
		
	}
	
	
	
	/**
	 * 验证文件名的合法性
	 * 1:文件存在，0文件不存在
	 */
	public function checkTagNameAction()
	{
		$tagname = Controller::get('tagname');
		if(!file_exists(DIR_TAG.$tagname))
		{
			exit('0');
		}
		else
		{
			exit('1');
		}
	}
	
	
	/*
	*标签向导列表
	*/
	public function guideIndexAction()
	{
		$nowpage = Controller::get('page',1);
		$urlArr = array(
			'indexUrl' => $this->createUrl('template/Tagmanage/guideIndex/page/'.$nowpage),
			'addUrl' => $this->createUrl('template/Tagmanage/guideSave/page/'.$nowpage),
			'updateUrl' => $this->createUrl('template/Tagmanage/guideUpdate/page/'.$nowpage),
			'delUrl' => $this->createUrl('template/Tagmanage/guideDelete/page/'.$nowpage),
		);
		
		$param['pagesize'] = 20;
		$guidelist = M('Guide')->order('created desc')->getPageList($param);
		$this->assign('guidelist',$guidelist);
		$this->assign('urlArr',$urlArr);
		$this->display('template/tagmanage/guide_index');
	}
	/**
	标签修改
	**/
	public function guideUpdateAction()
	{
		$id = Controller::get('id');
		$nowpage = Controller::get('page',1);
		$urlArr = array(
			'indexUrl' => $this->createUrl('template/Tagmanage/guideIndex'),
			'updateUrl' => $this->createUrl('template/Tagmanage/guideUpdate/page/'.$nowpage),
		);
		if(Controller::post('dosubmit')==1)
		{
			$pagesize = Controller::post('pagesize') ? Controller::post('pagesize') :20;	
			if(Controller::post('modelid')!=2)
			{
				$tagfun = 'contentlist';
			}
			else
			{
				$tagfun = 'goods';
			}
			$content = "{mo:$tagfun cid='".Controller::post('cid')."' ";
			$content = Controller::post('content') ? $content.'id="'.Controller::post('content').'" ' : $content;
			$content = Controller::post('ispage')==1 ? $content.'pagesize="'.$pagesize.'" ' : $content;
			$content = Controller::post('rows') ? $content.'rows="'.Controller::post('rows').'" ' : $content;
			$content.= 'order="'.Controller::post('order').' '.Controller::post('ordertype').'"}';
			$content.="{/mo:$tagfun}";
			$arr = array(
				'tagname'=>Controller::post('tagname'),
				'describe'=>Controller::post('describe'),
				'cid'=>Controller::post('cid'),
				'modelid'=>Controller::post('modelid'),
				'content'=>Controller::post('content'),
				'ispage'=>Controller::post('ispage'),
				'rows'=>Controller::post('rows'),
				'pagesize'=>Controller::post('pagesize'),
				'order'=>Controller::post('order'),
				'source'=>$content,
				'ordertype'=>Controller::post('ordertype'),
				'updatetime'=>time()
			);
			$flag = M('Guide')->update(array('id'=>Controller::post('id')),$arr);
			admin_log("修改标签向导","修改了标签向导： ".Controller::post('tagname'));
			if($flag)
			{
				$this->dialog('/template/Tagmanage/guideIndex/page/'.$nowpage,'success','操作成功');
			}
			if($flag)
			{
				$this->dialog('/template/Tagmanage/guideIndex/page/'.$nowpage,'error','操作失败');
			}
			
		}
		else
		{
			$cat_tree = D('CategoryModel','content') ->getCategoryTree();
			$info = M('Guide')->where(array('id'=>$id))->getOne();
			$this->assign('info',$info);
			$this->assign('urlArr',$urlArr);
			$this->assign('cat_tree',$cat_tree);
			$this->display('template/tagmanage/guide_update');
		}
	}
	/**
	标签删除
	**/
	public function guideDeleteAction()
	{
		$nowpage = Controller::get('page',1);
		$id = Controller::getParams('id');
		$tagname = Controller::getParams('tagname');
		if(is_array($id))
		{
			$id = implode(',',$id);
		}
		if(is_array($tagname))
		{
			foreach($tagname as $k => $v)
			{
				$tagname[$k] = urldecode($v);
			}
			$tagname = implode(',',$tagname);
		}	
		else
		{
			$tagname = urldecode($tagname);
		}
		$flag = M('Guide')->delete(array('in'=>array('id'=>$id)));
		if($flag)
		{
			admin_log("删除标签向导","删除了标签向导： ".htmlspecialchars_decode($tagname));
			$this->dialog('/template/tagmanage/guideIndex/page/'.$nowpage,'success','操作成功');
		}
		else
		{
			$this->dialog('/template/tagmanage/guideIndex/page/'.$nowpage,'error','操作失败');
		}
	}
	/**
	 * 标签添加保存
	 */
	public function guideSaveAction()
	{
		$urlArr = array(
			'indexUrl' => $this->createUrl('template/Tagmanage/guideIndex'),
			'addUrl' => $this->createUrl('template/Tagmanage/guideSave'),
		);
		if(Controller::post('dosubmit')==1)
		{
			$pagesize = Controller::post('pagesize') ? Controller::post('pagesize') :20;	
			if(Controller::post('modelid')!=2)
			{
				$tagfun = 'contentlist';
			}
			else
			{
				$tagfun = 'goods';
			}
			$content = "{mo:$tagfun cid='".Controller::post('cid')."' ";
			$content = Controller::post('content') ? $content.'id="'.Controller::post('content').'" ' : $content;
			$content = Controller::post('ispage')==1 ? $content.'pagesize="'.$pagesize.'" ' : $content;
			$content = Controller::post('rows') ? $content.'rows="'.Controller::post('rows').'" ' : $content;
			$content.= 'order="'.Controller::post('order').' '.Controller::post('ordertype').'"}';
			$content.="{/mo:$tagfun}";
			$arr = array(
				'tagname'=>Controller::post('tagname'),
				'describe'=>Controller::post('describe'),
				'cid'=>Controller::post('cid'),
				'modelid'=>Controller::post('modelid'),
				'content'=>Controller::post('content'),
				'ispage'=>Controller::post('ispage'),
				'rows'=>Controller::post('rows'),
				'pagesize'=>Controller::post('pagesize'),
				'order'=>Controller::post('order'),
				'source'=>$content,
				'ordertype'=>Controller::post('ordertype'),
				'created'=>time(),
				'updatetime'=>time()
			);
			$flag = M('Guide')->create($arr);		
			admin_log("添加标签向导","添加了标签向导： ".Controller::post('tagname'));
			if($flag)
			{
				$this->dialog('/template/Tagmanage/guideIndex','success','操作成功');
			}
			if($flag)
			{
				$this->dialog('/template/Tagmanage/guideIndex','error','操作失败');
			}
			
		}
		else
		{
			$cat_tree = D('CategoryModel','content') ->getCategoryTree();
			
			$this->assign('urlArr',$urlArr);
			$this->assign('cat_tree',$cat_tree);
			$this->display('template/tagmanage/guide');
		}
		
	}
	

	/**提取文档**/
	function IDContentAction()
	{
		$ids = Controller::get('ids');
		$cid = Controller::get('cid');
		$mid = Controller::get('mid',1);  //默认提取文章文档
		$keywords = Controller::post('keywords');  //默认提取文章文档
		$options = array(1=>1);
		if($cid)
		{
			$options['categoryid'] = $cid;
		}
		if($mid==2)
		{
			if($keywords)
		    {
			  $options['like'] = array('goodsname'=>$keywords);
		    }
			if($ids)
			{
				$options['notin'] = array('goodsid'=>$ids);
			}
			
			$contentlist = M('goods')->field('goodsid as id,goodsname as title')->where($options)->select();
		}
		else
		{
			if($keywords)
		    {
			  $options['like'] = array('goodsname'=>$keywords);
		    }
			if($ids)
			{
				$options['notin'] = array('id'=>$ids);
			}
			$contentlist = M('maintable')->where($options)->select();
		}
		$this->assign('contentlist',$contentlist);
		$this->assign('ids',$ids);
		$this->assign('cid',$cid);
		$this->assign('mid',$mid);
		$this->assign('keywords',$keywords);
		$this->display('template/tagmanage/IDContent.html');
	}
}