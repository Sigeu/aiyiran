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
 * <br>申静  2013-1-11 下午3:04:38 创建此文件 
 * 
 * @author     申静<shenjing@mainone.cn>  2013-1-11 下午3:04:38

 * @filename   message.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: MessageController.php 955 2013-11-28 08:32:44Z shitianyu $
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class MessageController extends AdminController {
	
	public function indexAction(){
		$where = array();
		$search= array();
		
		$mess_obj = M("MixModel");
		$messManage = M("MessageManage");
		
		//搜索条件
		$keyword = $this->getParams('keyword');   // 关键字
		$modelid = $this->getParams('modelid');   //留言类型
		$ischeck = $this->getParams('ischeck');   //是否审核
		$isreplay = $this->getParams('isreplay'); //是否回复
		$lstate = $this->getParams('lstate'); //1 是留言回复列表     2留言审核列表 0 所有留言

		$search['keyword'] = $keyword;
		$search['modelid'] = $modelid;
		$search['ischeck'] = $ischeck;
		$search['isreply'] = $isreplay;
		$search['lstate'] = $lstate;

		if(isset($keyword) && !empty($keyword)){
			
			$where['like'] = array('title'=>$keyword);//关键字查询
		}
		
		if(isset($modelid) && !empty($modelid)){
			
			$where['typeid'] = $modelid;      //留言板类别查询
		}

		if(isset($isreplay) && !empty($isreplay)){
			
			$where['isreply'] =$isreplay;    //留言是否回复查询
		}
		
		if(isset($ischeck) && !empty($ischeck)){
				
			$where['ischeck'] =$ischeck;    //留言是否回复查询
		}
		//回复留言列表
		if(isset($lstate) && $lstate==1){
			
			$where['isreply'] = 2;
            $where['notin'] =array('ischeck'=>3);

		}else if(isset($lstate) && $lstate==2){
			
			$where['ischeck'] = 2;
		}else{
			
			$list_state = 0;
		}

		//分页
		$count = $messManage->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$option['order'] = 'id desc';
		$list = $messManage->select($options);

        //留言分类
        $messagetype = $mess_obj->field('id,name')->select(array('where'=>array('flag'=>1)));
        //整合留言板分类与名称对应
		foreach($messagetype as $mk=>$mv){
			$type[$mv['id']] = $mv['name'];
		}
        $conObj = D("Message");
        foreach ($list as $lk=>$lv){
           if (!isset($type[$lv['typeid']])) {
                unset($list[$lk]);
                continue;
           }
           $list[$lk]['title'] = $conObj->replacestr($lv['title']);
           error_reporting(0);
           $list[$lk]['model'] = isset($type[$lv['typeid']]) ? $type[$lv['typeid']] : '';
        }
       
        $this->assign('lstate',$lstate);
        $this->assign('search',$search);
        $this->assign('roleList',$list);
        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('type',$messagetype);
		$this->assign('list',$list);
		$this->display('modules/message/messagelist');
	}
	//留言板设置信息加载
	public function messageSetAction(){
		$mess_obj = M("WebConfig");
		$set =$mess_obj->where(array('group_id'=>10))->field('par_name,par_value')->select();
	    
	    foreach ($set as $sk=>$sv){
        	$messageset[$sv['par_name']] =$sv['par_value'];
        }
        
		$this->assign('set',$messageset);
		$this->display('modules/message/messageset');
	}
	//留言板设置信息更新
	public function updateSetAction(){
		
		$obj = M("WebConfig");
		
		$arr['mo_max_num'] = $_POST['item'];
		$arr['mo_word_num'] = $_POST['word'];
		$arr['mo_isexamine'] = $_POST['verify'];
		$arr['mo_isanony'] = $_POST['anony'];

        if ($_POST['item'] == "" || $_POST['item'] ==0 || $_POST['word'] == "" || $_POST['word'] ==0) {

            //更新服务器设置
		    foreach($arr as $ak=>$av){
			 
			    $obj->update(array('par_name'=>$ak),array('par_value'=>$av));
		    }
		    
		    admin_log('更新自定义表单设置', '更新自定义表单设置');  //添加日志
			echo 'success';exit;
		}

		//验证是否是数字
		if(!MoValidator::isPositive($_POST['item'])){

			echo '最多条数只能是数字';exit;
		}
		//验证是否是数字
		if(!MoValidator::isPositive($_POST['word'])){

			echo '最多字数只能是数字';exit;
		}
		
		//更新服务器设置
		foreach($arr as $ak=>$av){
			 
			$obj->update(array('par_name'=>$ak),array('par_value'=>$av));
		}
		
		admin_log('更新自定义表单设置', '更新自定义表单设置');  //添加日志
		echo 'success';
	}
	//留言板模板管理
	public function messageModelAction(){
		
		$mess_obj = M("MixModel");
		
		//分页
		$count = $mess_obj->findCount(array('flag'=>1));
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = array('flag'=>1);
		$options['order'] = "id desc";
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		
		$list = $mess_obj->select($options);
        /*message_model表中count字段不靠谱，统计内容数量*/
		foreach ($list as $key => $msg) {
            $result = M('MessageManage')->where(array('typeid'=>$msg['id']))->field('count(*) as total')->getOne();
            $list[$key]['count'] = $result['total'];
        }
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('modules/message/model');
	}
	//添加留言分类页面
	public function addtypeAction() {
		
	    if(!empty($_POST)) {
	    	
	    	$mess_obj = M("MixModel");
	    	$id = $_POST['id'];
	    	$page = $this->getParams('page');
	    	$arr = array(
	    			'name' =>$_POST['name'],
	    			'state' =>$_POST['type'],
	    			'addtime' =>time(),
	    			'count' =>0,
	    			'flag' =>1,
	    	);
	    	$rs =$mess_obj->create($arr);
	    	
	    	$messObj =  D('Form','members','admin');
	    	$result = $messObj->createTable('message_'.$rs,true);
	    	$attr_rs = $messObj->addDefAttr($rs);
	    	if(!$result || !$attr_rs) exit;   //创建表
	    	
	    	if(intval($rs)){
	    		 
	    		admin_log('添加自定义表单分类', '添加'.$_POST['name'].'自定义表单分类');  //添加日志
	    		$mess_obj->update(array('id'=>$rs),array('tablename'=>'message_'.$rs));
	    	
	    		$this->dialog("/modules/message/messageModel/page/1",'success');
	    		exit;
	    		 
	    	}else{
	    		$this->dialog("/modules/message/messageModel/page/1",'error');
	    		exit;
	    	}
	    }
		$this->display('modules/message/addtype');
	}
	//编辑留言分类页面
	public function editorTypeAction() {
		$mess_obj = M("MixModel");
		$id = $this->getParams('id');
		$page = $this->getParams('page');
		
		if(!empty($_POST)) {

			if($id){
				$arr = array(
						'name' => $_POST['name'],
						'state'=>$_POST['type'],
				);
				if($mess_obj->update(array('id'=>$id),$arr)){
			        admin_log('修改自定义表单分类', '修改'.$arr['name'].'自定义表单分类');  //添加日志
					$this->dialog("/modules/message/messageModel/page/{$page}",'success');
				}else{
			
					$this->dialog("/modules/message/messageModel/page/{$page}",'error');
				}
			}
		}else{
			
			$infor = $mess_obj->where(array('id'=>$id))->getOne();
			
			$this->assign('page',$page);
			$this->assign('infor',$infor);
			$this->display('modules/message/addtype');
		}
		
	}
	
	//删除留言板分类
	public function deleteAction(){
		$mess_obj = M("MixModel");
		$messMagnage = M("MessageManage");
		$atrObj = M("Attribute");
		$id = $this->getIds('id');
		$page = $this->getParams('p');
        $name = urldecode($this->getParams('name'));
        
	 if($id){
	 	
		$condition = array(
			'in'     => array('id'=>$id),
		);
		$where['where'] = array(
		    'in'     => array('typeid'=>$id),
		);

		$back_url ="/modules/message/messageModel/page/{$page}";
		
        $messages = $messMagnage->select($where);
        $count = count($messages);

        if(!empty($messages)){

        	$this->dialog($back_url,'error','留言分类下共有'.$count.'条信息，请先删除留言分类下的内容');
        }else{
          //删除分类前先删除数据库
          $dbObj = D('Form','members','admin');
          $result = $dbObj->deleteTable($id);
          $atrObj->delete(array('in'=>array('modelid'=>$id)));
          if (!$result)
          {
          	
          	$this->dialog($back_url,'error','操作失败');
          	exit;
          }
          
          
		  if($mess_obj->delete($condition))
		  {
		  	
		  	admin_log('删除自定义表单分类', '删除'.$name.'自定义表单分类');  //添加日志
			$this->dialog($back_url,'success','操作成功');
		  } else {
		  	
		  	$this->dialog($back_url,'error','操作失败');
		  }
		  
        }
	 }else{
	 	$this->dialog($back_url,'error','请选择删除信息');
	 }
	}
	
	//开启留言板分类
    public function operaAction(){
		$mess_obj = M("MixModel");
		$state = $this->getParams('state');
		$name = urldecode($this->getParams('name'));
		$id = $this->getIds('id');
		$page = $this->getParams('page');
		$opera = "";
		if($state == 2){
		
		   $opera ='开启';
		}else{
		
		   $opera = '关闭';
		}
		if($id){
			
			$condition = array(
					'in'     => array('id'=>$id),
			);

		 if($mess_obj->update($condition,array('state'=>$state)) !== false)
		 {
		 	admin_log($opera.'自定义表单分类', $opera.$name."自定义表单分类");  //添加日志
			$this->redirect($this->createUrl('modules/message/messageModel/page/'.$page));
		 }
	  }
	}
	//关闭留言分类
	public function closeTypeAction(){
		$mess_obj = M("MixModel");
		$name = $this->getParams('name');
		$id = $this->getIds('id');
		$page = $this->getParams('page');
		
		if($id)
		{
			$condition = array(
					'in'     => array('id'=>$id),
			);
			
			if($mess_obj->update($condition,array('state'=>1)) !== false)
			{
				admin_log('关闭自定义表单分类', '关闭'.$name."自定义表单分类");  //添加日志
				$this->redirect($this->createUrl('modules/message/messageModel/page/'.$page));
			}
		}
	}
   //删除留言信息
   public function deleteMessageAction(){
   	   $manObj = M("MessageManage");
   	   
   	   $id = $this->getIds('id');
   	   $pos = strpos($id,',');
   	   
   	   if (!$pos) {
   	   	
   	   	$title = $manObj->where(array('id'=>$id))->field('title')->getOne();
   	   	
   	   }
   	   $page = $this->getParams('page');
   	   $modelid = $this->getParams('modelid');
   	   $ischeck = $this->getParams('ischeck');
   	   $isreply = $this->getParams('isreply');
   	   $keyword = $this->getParams('keyword');
   	   $lstate = $this->getParams('lstate');

   	   $back_url = "/modules/message/index/page/{$page}/lstate/{$lstate}/ischeck/{$ischeck}/keyword/{$keyword}/isreplay/{$isreply}/modelid/{$modelid}";

   	   if($id){
   	   	
   	   	   $condition = array(
   	   	       'in'   =>array('id'=>$id),	
   	   	   );
   	   	   
   	   	   if($manObj->delete($condition) !==false){
   	   	   	
              $opera = isset($title) ? "删除信息".$title['title'] : "删除信息";
              admin_log("删除信息", $opera);  //添加日志
   	   	   	  $this->dialog($back_url,'success','操作成功');
   	   	   }else{
   	   	   	  $this->dialog($back_url,'error','操作失败');
   	   	   }
   	   }
   }
   
  //留言板信息通过审核
  public function passCheckAction(){
  	$manObj = M("MessageManage");
    $state = $this->getParams('state');
    $opear ='';
    $title = array('title'=>"");

  	$id = $this->getIds('id');
  	$pos = strpos($id,',');
  	
    if (!$pos) {
   	   	
   	   	$title = $manObj->where(array('id'=>$id))->field('title')->getOne();
   	}

  	$page = $this->getParams('page');
  	$modelid = $this->getParams('modelid');
  	$ischeck = $this->getParams('ischeck');
  	$isreply = $this->getParams('isreply');
  	$keyword = $this->getParams('keyword');
  	$lstate = $this->getParams('lstate');
  	
  	$back_url = "/modules/message/index/page/{$page}/ischeck/{$ischeck}/lstate/{$lstate}/lkeyword/{$keyword}/isreplay/{$isreply}/modelid/{$modelid}";
    
    if ($state == 1) {
    	
    	$opear = "审核通过";
    }else {
    	
    	$opear = "审核不通过";
    }
    if($id){
    	
    	$condition = array(
    			'in'   =>array('id'=>$id),
    	);

    	if($manObj->update($condition,array('ischeck'=>$state)) !==false){
    	    
    		admin_log($opear,$opear.$title['title']);  //添加日志

    		$this->dialog($back_url,'success','操作成功');
    	}else{
    		$this->dialog($back_url,'error','操作失败');
    	}
    }
  }

  //留言板信息回复
  public function replyAction(){
  	$manObj = M("MessageManage");
  	
  	if(!empty($_POST)) {

  		$id = $this->getIds('curid');
  		$url = $this->getParams('url');
  		$reply_con= $this->getParams('replycon');
  		
  		$name = $this->getParams('title');
  		
  		$msObj = M("Message_".$this->getParams('typeid'));
  		$msObj->update(array('id'=>$this->getIds('msid')), array('title'=>$name));
  		$row =array(
  				'replayinfor' =>$reply_con,
  				'isreply' =>1,
  				'ischeck'=>1,
  				'replytime'=>time(),
  				'replymember'=>$_SESSION['userinfo']['id'],
  				'title' =>$name,
  		);
  		
  		if($manObj->update(array('id'=>$id),$row)){
  		
  			admin_log('回复留言', '回复'.$name);  //添加日志
  			$this->dialog($url,'success','操作成功');
  		}else{
  			$this->dialog($url,'success','操作失败');
  		}
  	}else{

  		$modelObj = M("MixModel");
  		$atrObj= M("Attribute");
  		$linkObj = M("Linkage");
  		
  		$content = "";
  		$id = $this->getIds('id');
  		$parent= $manObj->where(array('id'=>$id))->getOne();
  		
  		$con['page'] = $this->getParams('page');
  		$con['modelid'] = $this->getParams('modelid');
  		$con['ischeck'] = $this->getParams('ischeck');
  		$con['isreply'] = $this->getParams('isreply');
  		$con['keyword'] = $this->getParams('keyword');
  		$con['lstate'] = $this->getParams('lstate');
  		 
  		$back_url = "/modules/message/index/page/{$con['page']}/ischeck/{$con['ischeck']}/lstate/{$con['lstate']}/keyword/{$con['keyword']}/isreplay/{$con['isreply']}/modelid/{$con['modelid']}";
  		//留言分类
  		$messagetype = $modelObj->field('id,name')->select();
  		$type = array();
  		//整合留言板分类与名称对应
  		foreach($messagetype as $mk=>$mv){
  			if($mv['id'] == $parent['typeid'])
  			{
  				$type[$mv['id']] = $mv['name'];
  				break;
  			}
  		}
  		
  		$msObj = M("Message_".$parent['typeid']);
  		
  		$list = $msObj->where(array('id'=>$parent['message_id']))->getOne();
  		$list['leavetime'] = $parent['leavetime'];
  		$list['model'] = $type[$parent['typeid']];
  		
  		//获取附加信息对应的中文名称
  		$names = $atrObj->field('dataname,name,fieldtype')->select(array('where'=>array('modelid'=>$parent['typeid'],'state'=>1)));
  		
  		$conObj = D('Message');
  		
  		foreach ($names as $nk => $nv) {
  			
            if($nv['fieldtype'] =='linkage'){
                $tem = "";
            	$linkId = explode(';',$list[$nv['dataname']]);
            	$linkId = implode(",",$linkId);
            	
            	$data = M('linkage_bill') -> field('name')->select(array('where'=>array('in' =>array('id'=>$linkId))));
            	
            	foreach ($data as $dk=>$dv){
            		
            		$tem .= $dv['name'].";";
            	}
            	
            	$list[$nv['dataname']] = substr($tem,0,-1);
            }
  			$content .="<tr><th>&nbsp; ".$nv['name']."：</th><td colspan='3'><span>";
  		
  			if ($nv['dataname'] == 'title' || $nv['dataname'] == 'mess_infor') {
  					
  				$list[$nv['dataname']] = $conObj->replacestr($list[$nv['dataname']]);
  			}
  		
  			if ($nv['dataname'] == 'title') {
  					
  				$content .= "<input type='text' class='Iw290' value='".$list[$nv['dataname']]."' name='title' disabled>";
  				$content .= "<input type='hidden' value='".$list[$nv['dataname']]."' name='title'>";
  			} else if ($nv['dataname'] == 'mess_infor') {
  					
  					
  				$content .= "<textarea style='width:600px;height:150px;font-size:12px;' disabled>".$list[$nv['dataname']]."</textarea>";
  			}else {
  					
  				$content .=  $list[$nv['dataname']];
  			}
  		
  			$content .="</span></td></tr>";
  		}
  		
  		
  		$this->assign('parent',$parent);
  		$this->assign('replaycon',$parent['replayinfor']);
  		$this->assign('content',$content);
  		$this->assign('url',$back_url);
  		$this->assign('list',$list);
  		$this->display('modules/message/reply');
  	}
  	

  }
  
  //回复留言列表   所有审核通过的留言信息
  public function replyMessageAction(){
  	$manObj = M("MessageManage");
  	
  	$option['where'] = array(
  			         'ischeck'=>1,
  			         'isreply'=>2,
  			         );
  	
  	$option['order'] = "id desc";
  	
  	$list = $manObj->select($option);
  	
  	$this->assign('list',$list);
  	$this->display('modules/message/replyMessage');
  }
 //某个留言分类下的字段
 public function fieldAction(){
 	$flag = $this->getParams('flag');
 	$attrObj = M('Attribute');
 	$id = $this->getIds('id'); //留言板分类Id
    $arr = $this->getDefineArr();
    $where['modelid'] = $id;

    //分页
    $count = $attrObj->findCount($where);
    $pagesize = 20;
    $page = new Page($count, $pagesize);
    $from = $page->firstRow;
    $options['limit'] = $from.','.$pagesize;
    $options['order'] = 'sort asc,id desc';
    $options['where'] = $where;
    $currpage = isset($_GET['p'])?$_GET['p']:1;
    $pagestr = $page->show();
    
 	$list = $attrObj->select($options);

    foreach($list as $lk=>$lv){
    	$list[$lk]['type'] = $arr['type'][$lv['fieldtype']];
    }
    
    $this->assign('flag',$flag);
 	$this->assign('id',$id);
 	$this->assign('pageStr',$pagestr);
 	$this->assign('page',$currpage);
 	$this->assign('list',$list);
 	$this->display('modules/message/field');
 } 
 
 //添加字段
 public function addFieldAction(){
 	$flag = $this->getParams('flag');
 	$page = $this->getParams('page');
 	$obj = $this->getAtrrObj();
 	
 	if(!empty($_POST)) {
 		
 		$form_obj = D('Form','members','admin');
 		$curid = $this->getIds('id');
 		$modelid = $this->getParams('modelid');	
 		$defaultvalue = "";	

 		if($this->getParams('defaultvalue') == ""){
 			
 			$defaultvalue = "";
 		}else{
 			
 			$defaultvalue = $this->getParams('defaultvalue');
 		}

 		//获取需要添加或者更新数据
 		$arr['created'] = time();
 		$arr = array(
 				"name"      => $this->getParams('name'),
 				"dataname"  => $this->getParams('dataname'),
 				"fieldtype" => $_POST["fieldinfo"]['fieldtype'],
 				"fieldtips" => $this->getParams('fieldtips'),
 				"defaultvalue" => $defaultvalue,
 				"minval"    => $this->getParams('minval'),
 				"maxval"    => $this->getParams('maxval'),
 				"regex"     => $this->getParams('regex'),
 				"errortips" => $this->getParams('errortips'),
 				"uniqueness"=> $this->getParams('uniqueness'),
 				"isnessary" => $this->getParams('isnessary'),
 				"ismain"    => $this->getParams('ismain'),
 				"issearch"  => $this->getParams('issearch'),
 		);
 		
 		if($flag == 2)
 		{
 			$type = 'member';
 			 
 		} else {
 			 
 			$type = 'message';
 		}

 		
 		$re = $form_obj->alterTable($modelid,$arr['dataname'],$arr['fieldtype'],$arr['maxval'],$defaultvalue,$type);

 		if($re){
 				$arr['created'] = time();
 				$arr["modelid"] = $this->getParams('modelid');
 				if ($id = $obj->create($arr)) {
 					 
 					admin_log('添加字段', '添加'.$arr['name'].'字段');  //添加日志
 					$this->dialog('/modules/message/field/id/'.$modelid."/flag/$flag/page/{$page}",'success','操作成功');
 					exit;
 				}else{
 		
 					$this->dialog('/modules/message/field/id/'.$modelid."/flag/$flag/page/{$page}",'error','操作失败');
 					exit;
 				}
 		}
 	}else{
 	
 		$fieldArr = include DIR_BF_ROOT.'field'.DS.'fieldArray.php';
 		$fieldPattern = include DIR_BF_ROOT.'field'.DS.'fieldPattern.php';
 		$noShow = include DIR_BF_ROOT.'field/noShow.php'; //添加的时候不显示的字段

		$noShow[] = 'image';
		$noShow[] = 'images';
		$noShow[] = 'file';
		$noShow[] = 'files';

 		$id = $this->getIds('modelid');
 		$this->assign('noShow',$noShow);
 		$this->assign('flag',$flag);
 		$this->assign('page',$page);
 		$this->assign('modelid',$id);
 		$this->assign('fieldArr',$fieldArr);
 		$this->assign('arr',$fieldPattern);
 		$this->display('modules/message/addfile');
 	}
 	
 }
 //检查数据字段是否唯一
 public function checkAction() {
 	 
 	$name = $this->getParams('dataname');
 	$modelid = $this->getParams('modelid');
 	$obj = $this->getAtrrObj();
 	$result = $obj->where(array('modelid'=>$modelid,'dataname'=>$name))->getOne();

 	if(empty($result)) {
 		
 		echo 1;
 	}else{
 		
 		echo 2;
 	}
 }
 //修改字段
 public function editorFieldAction(){
 	$flag = $this->getParams('flag');
 	$obj = $this->getAtrrObj();
 	
 	if(!empty($_POST)) {
 		$form_obj = D('Form','members','admin');
 		$curid = $this->getIds('id');
 		$modelid = $this->getParams('modelid');
 		$page = $this->getParams('page');
 		
 		//获取需要添加或者更新数据
 		$arr['created'] = time();
 		$arr = array(
 				"name"      => $this->getParams('name'),
 				"dataname"  => $this->getParams('dataname'),
 				"fieldtype" => $this->getParams('fieldtype'),
 				"fieldtips" => $this->getParams('fieldtips'),
 				"defaultvalue" => $this->getParams('defaultvalue'),
 				"minval"    => $this->getParams('minval'),
 				"maxval"    => $this->getParams('maxval'),
 				"regex"     => $this->getParams('regex'),
 				"errortips" => $this->getParams('errortips'),
 				"uniqueness"=> $this->getParams('uniqueness'),
 				"isnessary" => $this->getParams('isnessary'),
 				"ismain"    => $this->getParams('ismain'),
 				"issearch"  => $this->getParams('issearch'),
 		);
 		
 		if($flag == 2)
 		{
 			$type = 'member';
 			 
 		} else {
 			 
 			$type = 'message';
 		}
 		
 		//当前修改字段是会员表单字段时修改表结构
 		if($curid){
 		
 			$re = $form_obj->updateTable($modelid,$this->getParams('oldname'),$arr['dataname'],$arr['fieldtype'],$arr['maxval'],$arr['defaultvalue'],$type);
 		}
 		//var_dump($re);
 		if($re)
 		{
 		
 			//更新数据
 			if($obj->update(array('id'=>$curid),$arr)){
 						
 			  admin_log('修改字段', '添加'.$arr['name'].'字段');  //添加日志
 			  $this->dialog("/modules/message/field/id/".$modelid."/flag/$flag/page/{$page}",'success');
 			  exit;
 			}else{
 		
 			  $this->dialog("/modules/message/field/id/".$modelid."/flag/$flag/page/{$page}",'error','操作失败');
 			  exit;
 			}
 		}
 	}else{
 		
 		$infor = array();
 		$fieldArr = include DIR_BF_ROOT.'field'.DS.'fieldArray.php';   //字段类型
 		$fieldPattern = include DIR_BF_ROOT.'field'.DS.'fieldPattern.php';  //字段正则
 		$noShow = include DIR_BF_ROOT.'field/noShow.php'; //添加的时候不显示的字段
 		
 		$id = $this->getIds('modelid');
 		$curid = $this->getIds('curid');
 		$page = $this->getParams('p');
 		
 		if($curid){
 			$infor = $obj->where(array('id'=>$curid))->getOne();
 			$infor['type'] =$fieldArr[$infor['fieldtype']];
 		}
 		
		$noShow[] = 'image';
		$noShow[] = 'images';
		$noShow[] = 'file';
		$noShow[] = 'files';

 		$this->assign('noShow',$noShow);
 		$this->assign('fieldArr',$fieldArr);
 		$this->assign('flag',$flag);
 		$this->assign('page',$page);
 		$this->assign('infor',$infor);
 		$this->assign('modelid',$id);
 		$this->assign('arr',$fieldPattern);
 		$this->display('modules/message/updatefile');
 	}
 	
 }
 
 //删除指定分类下的字段
 public function deleteFileAction(){
 	$str = "";
 	$obj = $this->getAtrrObj();
 	$modelid = $this->getParams('modelid');
 	$curid = $this->getIds('id');
 	$page = $this->getParams('page');
 	$isform = $this->getParams('flag');
 	$name = urldecode($this->getParams('name'));
 	
 	$where = array(
 			'modelid' =>$modelid,
 			'in' =>array('id'=>$curid),
 			);

 	//判断是否有主字段
    $infor = $obj->where(array('ismain'=>1,'modelid'=>$modelid,'in'=>array('id'=>$curid)))->select();
 
    foreach($infor as $ik=>$iv){
    	$str .= $iv['dataname'].',';
    }
    
 	$str = substr($str,0,-1);
 	
 	if(!empty($infor)){
 		
 		$this->dialog('/modules/message/field/id/'.$modelid.'/flag/'.$isform.'/page/'.$page,'error',$str.'是系统字段,不可删除!');
 		exit;
 	}
 	
 	//删除数据库中对应的列信息
 	$formObj =  D('Form','members','admin');
 	$rs = $formObj->deleteClumn($modelid,$curid);
 	
    //删除字段信息
 	if ($obj->delete($where)) {
 		
 		admin_log('删除字段', '删除'.$name.'字段');  //添加日志
 		$this->dialog('/modules/message/field/id/'.$modelid.'/flag/'.$isform.'/page/'.$page,'success','操作成功');
 		exit;
 	}else{
 		
 		$this->dialog('/modules/message/field/id/'.$modelid.'/flag/'.$isform.'/page/'.$page,'success','操作失败');
 		exit;
 	}
 }
  
 //字段的开启/关闭
 public function openOrCloseAction(){
 	//接收参数
 	$obj =$this->getAtrrObj();
 	$id = $this->getIds('id');
 	$page = $this->getParams('page');
 	$modelid = $this->getIds('modelid');
 	$flag = $this->getParams('flag');
 	$state = $this->getParams('state');
 	$name = urldecode($this->getParams('name'));
 	$attr = $obj->field('dataname')->select(array('where'=>array('in'=>array('id'=>$id))));

 	$def_arr = array(
 			 1=>'title',
 			 2=>'username',
 			);
 	
 	
 	if ( $state == 1 ) {
 		
 		$opera = '开启';
 	} else {
 		
 		$opera = "关闭";
 		if(!empty($attr)){
 				
 			foreach($attr as $ak=>$av){
 		
 				if(array_search($av['dataname'],$def_arr)){
 		
 					$this->dialog('/modules/message/field/id/'.$modelid.'/page/'.$page.'/flag/'.$flag,'error','留言人和标题不可关闭');
 					exit;
 				}
 		
 			}
 				
 		}
 	}
 	
    //开启/关闭 字段的可用性
 	if($id){
 		
 		$condition = array(
 				'in'     => array('id'=>$id),
 		);
 	
 		if($obj->update($condition,array('state'=>$state)) !== false)
 		{
 			admin_log($opera.'字段',$opera.$name.'字段');  //添加日志
 			$this->redirect($this->createUrl('modules/message/field/id/'.$modelid.'/page/'.$page.'/flag/'.$flag));
 		}
 	}
 	
 }
 
 //字段排序
 public function fileSortAction(){
 	//创建对像
 	$obj = $this->getAtrrObj();
 	$state = $this->getParams('flag');
 	//获取更新数据
 	$sortid = $this->getIds('sort');
 	$sortid = explode(',',$sortid);
 	$ids = $this->getIds('ids');
 	$ids = explode(',',$ids);
 	$modelid = $this->getIds('modelid');
 	$page = $this->getParams('page');
 	$options = array_combine($ids, $sortid);

    //更新排序
 	$flag = $obj->updateAll('id','sort',$options,$ids);

 	if ($flag){
 		
 		$this->dialog('/modules/message/field/id/'.$modelid.'/page/'.$page.'/flag/'.$state,'success','操作成功');

 	}else{
 		
 		$this->dialog('/modules/message/field/id/'.$modelid.'/page/'.$page.'/flag/'.$state,'error','操作失败');
 	}
 }

 //表单浏览
 public function formBrowseAction(){
 	$flag = $this->getParams('flag');
 	$modelid = $this->getIds('modelid');
 	$obj = $this->getFormObj();
 	$name = $obj->find(array('id'=>$modelid));
    $ContentForm = new MessageForm($modelid);

    $form = $ContentForm->get($flag,$modelid,array());
    
    $formvalidator = $ContentForm->formValidator;

    $this->assign('formvalidator',$formvalidator);
    $this->assign('form',$form);
 	$this->assign('name',$name['name']);
 	$this->display('modules/message/formlist');
 }
 
 //检查唯一
 public function uniqueAction(){
 	$modelid = $this->getParams('modelid');
 	$name = $this->getParams('name');
 	$dataname = $this->getParams('dataname');
 	
 	$options['where'] = array(
 			    'modelid' => $modelid,
 			    'or'=>"name = '".$name ."'or dataname ='". $dataname."'",
 			    );
 	
 	$atr_obj = $this->getAtrrObj();
 	$list = $atr_obj->select($options);
 	
    if(!empty($list)){
    	
    	return 1;
    }else{
    	return 2;
    }
 }
 //添加字段中设置唯一后的验证
 public function checkUniqueAction() {
    $modelid = $this->getParams('modelid');
 	$dataname = $this->getParams('fildname');
	$tem = $this->getParams('tem');

    $model = D("Message");
	$rs = $model->checkUnique($modelid,$dataname,$_GET[$dataname],$tem);
    echo $rs;
 }
 //获取操作对像
 public function getFormObj(){
 	return M('MixModel');
 }
 
 //获取字段表对象
 public function getAtrrObj(){
 	return M("Attribute");
 }
}