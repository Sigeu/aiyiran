<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *墓铭志管理及其其他管理
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>一梦一尘  2016-10-09 上午11:03:16 创建此文件
 *
 * @author     一梦一尘  2016-10-09 上午11:03:16

 * @filename   LinkController.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: LinkController.php 357 2016-10-09 04:09:37Z wangrui $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class MoresetController extends AdminController {

	public $mumingObj; //模型对象
	public function init()
	{

		$this->mumingObj = M("memorial_mumingzhi");
	}
	/**
	 *墓铭志列表
	 */
	public function indexAction(){

		$where = array();
        if(isset($_GET['status'])){
            $where = array(
                'status'=>0,
                );
        }
		$keyword = $this->getParams('keyword');
		$search['keyword'] = $keyword;

		if(isset($keyword) && !empty($keyword)){

			$where['like'] = array('name'=>$keyword);//广告位名称
		}
		//分页
		$count = $this->mumingObj->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "sort asc,id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = $this->mumingObj->select($options);

		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('memorial/moreset/muminglist');
	}

    /**
     * 墓志铭审核 - 通过
     */
    public function mumingyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_mumingzhi')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }
    /**
     * 墓志铭审核 - 不通过
     */
    public function mumingnoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_mumingzhi')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

	/**
	 * 添加纪念馆分类
	 * @return null
	 */
	public function addAction()
	{
		//提交表单
		if(!empty($_POST))
		{
			$arr = array
			(
				'name' => $this->getParams('name'),
				'sort'=> $this->getParams('sort'),
                'content'=> $this->getParams('content')
			);
			$rs = $this->mumingObj->create($arr);
			if ($rs)
			{
				 admin_log('添加悼词参考范例','添加'.$arr['name']."墓铭志");
				$this->dialog("/memorial/moreset/index",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/moreset/index",'error','操作失败');
			}
		}else{
		   $this->display('memorial/moreset/add');
		}	
	}

	/**
	 * 编辑墓铭志
	 * @return null
	 */
	public function updateAction()
	{
		//提交修改
		$edit_id = isset($_POST['id']) ? intval($_POST['id']) : 0 ;
		if($edit_id)
		{
			$page = $this->getParams('page');
			$type = $this->getParams('type');
            $arr = array
			(
				'name'     => $this->getParams('name'),
				'sort'=> $this->getParams('sort'),
                'content'=> $this->getParams('content')
			);

			//入库跳转
			$rs = $this->mumingObj->update(array('id'=>$edit_id), $arr);
			if ($rs)
			{
				admin_log('编辑悼词参考范例','编辑'.$arr['name']."墓铭志");
				$this->dialog("/memorial/moreset/index/page/{$page}",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/moreset/index/page/{$page}",'error','操作失败');
			}
		}

		//修改页面
		$id = $this->getParams('id');
		$arr['page'] = $this->getParams('page');
		$infor = $this->mumingObj->where(array('id'=>$id))->getOne();
		$this->assign('arr',$arr);
		$this->assign('infor',$infor);
		$this->display('memorial/moreset/update');

	}

	//删除墓铭志
	public function deleteAction() {

		$id = $this->getIds('id');
		$name = urldecode($this->getParams('name'));
		$arr['page'] = $this->getParams('page');

		$where = array(
				'in'=>array('id'=>$id),
		);
		$rs = $this->mumingObj->delete($where);

		if ($rs) {

			admin_log('悼词参考范例','删除'.$arr['name']."墓铭志");
			$this->dialog("/memorial/moreset/index/page/{$arr['page']}",'success','操作成功');
			exit;
		} else {

			$this->dialog("/memorial/moreset/index/page/{$arr['page']}",'error','操作失败');
			exit;
		}
	}

	//更新 墓铭志排序
	public function linkSortAction() {

		$sortid = $this->getIds('sort');
		$sortid = explode(',',$sortid);
		$ids = $this->getIds('id');
		$ids = explode(',',$ids);
		$options = array_combine($ids, $sortid);

		//更新排序
		$rs = $this->mumingObj->updateAll('id','sort',$options,$ids);

		if ($rs) {

			$this->dialog("/memorial/moreset/index",'success','更新成功');
		} else {

			$this->dialog("/memorial/moreset/index",'error','更新失败');
		}
	}
    /**
	 *模板风格管理
	 */
	public function styleAction(){

		$where = array();
		$keyword = $this->getParams('keyword');
		$search['name'] = $keyword;
        $styleObj = M('memorial_style');
		//分页
		$count = $styleObj->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "sort asc,id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = $styleObj->select($options);

		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('memorial/moreset/stylelist');
	}
    /**
	 *添加模板风格
	 */
    public function addstyleAction(){
     if(self::post("submit")){
        $insertDate= array();
        $insertDate['name'] = trim(self::post('name'));
        $insertDate['free'] = self::post('free') ? intval(self::post('free')) : 1;
        $insertDate['price'] = $insertDate['free'] == 1 ? 0 : floatval(self::post('price'));
        $insertDate['sort'] = intval(self::post('sort'));
        //处理图片
        if(isset($_POST['accessory'])){
		  $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
	      $pic = current($pic);
		  $insertDate['pic'] = '/style/'.$pic['path'];
		 }
  	     $rs = M('memorial_style')->create($insertDate);
		 if($rs){
		    admin_log('添加祭祀模板风格','添加'.$insertDate['name']."墓铭志");
		   $this->dialog("/memorial/moreset/style",'success','操作成功');
		 }else{
		    $this->dialog("/memorial/moreset/style",'error','操作失败');
		 }
     }else{
       $picSetting = array
		(
			'limit'       =>  1,
			'type'        =>  array('jpg','png','gif'),
			'iswatermark' =>  true
		);
        $this->assign('picsetting', base64_encode(serialize($picSetting)));
      $this->display('memorial/moreset/styleadd');  
     } 
   }
   	//更新 模板排序
	public function stylesortAction() {
		$sortid = $this->getIds('sort');
		$sortid = explode(',',$sortid);
		$ids = $this->getIds('id');
		$ids = explode(',',$ids);
		$options = array_combine($ids, $sortid);
		//更新排序
		$rs = M('memorial_style')->updateAll('id','sort',$options,$ids);
		if ($rs) {
			$this->dialog("/memorial/moreset/style",'success','更新成功');
		} else {

			$this->dialog("/memorial/moreset/style",'error','更新失败');
		}
	}
   //删除 模板删除
   public function styledeleteAction(){
    	$id = $this->getIds('id');
		$name = urldecode($this->getParams('name'));
		$arr['page'] = $this->getParams('page');
		$where = array(
		   'in'=>array('id'=>$id),
		);
		$rs = M('memorial_style')->delete($where);
		if($rs) {
			admin_log('祭祀模板','删除'.$arr['name']."祭祀模板");
			$this->dialog("/memorial/moreset/style/page/{$arr['page']}",'success','操作成功');
			exit;
		} else {
		    $this->dialog("/memorial/moreset/style/page/{$arr['page']}",'error','操作失败');
			exit;
		}
    
   }
   //模板编辑
   public function styleupdateAction(){
    if(self::post("submit")){
        $id = $this->getParams('id');
        $insertDate= array();
        $insertDate['name'] = trim(self::post('name'));
        $insertDate['free'] = self::post('free') ? intval(self::post('free')) : 1;
        $insertDate['price'] = $insertDate['free'] == 1 ? 0 : floatval(self::post('price'));
        $insertDate['sort'] = intval(self::post('sort'));
        //处理图片
        if(isset($_POST['accessory'])){
		  $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
	      $pic = current($pic);
		  $insertDate['pic'] = '/style/'.$pic['path'];
		 }
  	     $rs = M('memorial_style')->update(array('id'=>$id), $insertDate);
		 if($rs){
		    admin_log('编辑祭祀模板风格','编辑'.$insertDate['name']."祭祀模板风格");
		   $this->dialog("/memorial/moreset/style",'success','操作成功');
		 }else{
		    $this->dialog("/memorial/moreset/style",'error','操作失败');
		 }
       
        
    }else{
    //修改页面
	$id = $this->getParams('id');
	$arr['page'] = $this->getParams('page');
	$infor = M('memorial_style')->where(array('id'=>$id))->getOne();
    $infor['pic'] = $infor['pic'] ? '/static/uploadfile'.$infor['pic'] : '/admin/template/images/img_downl.png';
	$picSetting = array
		(
			'limit'       =>  1,
			'type'        =>  array('jpg','png','gif'),
			'iswatermark' =>  true
		);
    $this->assign('picsetting', base64_encode(serialize($picSetting)));
    $this->assign('arr',$arr);
	$this->assign('infor',$infor);
    $this->assign('id',$id);
	$this->display('memorial/moreset/styleupdate');
    }
   }
   //立碑人信息管理
   public function steleauthorAction(){
      
		$where = array();
        if(isset($_GET['status'])){
            $where = array(
                'status'=>0,
                );
        }
		$keyword = $this->getParams('keyword');
		$search['keyword'] = $keyword;

		if(isset($keyword) && !empty($keyword)){

			$where['like'] = array('name'=>$keyword);
		}
		//分页
		$count = M('memorial_steleauthor')->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "listorder asc,id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = M('memorial_steleauthor')->select($options);

		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('memorial/moreset/steleauthor');
   }
   //添加立碑人信息模板
   public function addsteleAction(){
    	//提交表单
		if(!empty($_POST))
		{
			$arr = array
			(
				'name' => $this->getParams('name'),
				'listorder'=> $this->getParams('listorder'),
                'content'=> $this->getParams('content')
			);
			$rs = M('memorial_steleauthor')->create($arr);
			if ($rs)
			{
				 admin_log('立碑人信息模板','添加'.$arr['name']."立碑人信息模板");
				$this->dialog("/memorial/moreset/steleauthor",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/moreset/steleauthor",'error','操作失败');
			}
		}else{
		   $this->display('memorial/moreset/addstele');
		}
   }
  //删除立碑人信息
  public function steledeleteAction(){
    	$id = $this->getIds('id');
		$name = urldecode($this->getParams('name'));
		$arr['page'] = $this->getParams('page');
		$where = array(
		   'in'=>array('id'=>$id),
		);
		$rs = M('memorial_steleauthor')->delete($where);
		if($rs) {
			admin_log('立碑人信息模板','删除'.$name."立碑人信息模板");
			$this->dialog("/memorial/moreset/steleauthor/page/{$arr['page']}",'success','操作成功');
			exit;
		} else {
		    $this->dialog("/memorial/moreset/steleauthor/page/{$arr['page']}",'error','操作失败');
			exit;
		}
  }
  //更新数据立碑人信息模板
  public function steleupdateAction(){
     //提交修改
		$edit_id = isset($_POST['id']) ? intval($_POST['id']) : 0 ;
		if($edit_id){
			$page = $this->getParams('page');
            $arr = array
			(
				'name'     => $this->getParams('name'),
				'listorder'=> $this->getParams('listorder'),
                'content'=> $this->getParams('content')
			);

			//入库跳转
			$rs = M('memorial_steleauthor')->update(array('id'=>$edit_id), $arr);
			if ($rs)
			{
				admin_log('编辑立碑人信息模板','编辑'.$arr['name']."立碑人信息模板");
				$this->dialog("/memorial/moreset/steleauthor/page/{$page}",'success','操作成功');
			}
			else
			{
				$this->dialog("/memorial/moreset/steleauthor/page/{$page}",'error','操作失败');
			}
		}else{
		  	//修改页面
		  $id = $this->getParams('id');
		  $arr['page'] = $this->getParams('page');
		  $infor = M('memorial_steleauthor')->where(array('id'=>$id))->getOne();
		  $this->assign('arr',$arr);
		  $this->assign('infor',$infor);
	 	  $this->display('memorial/moreset/steleupdate'); 
		}
  }
  //立碑人信息模板排序
	public function stelesortAction() {
		$sortid = $this->getIds('listorder');
		$sortid = explode(',',$sortid);
		$ids = $this->getIds('id');
		$ids = explode(',',$ids);
		$options = array_combine($ids, $sortid);
		//更新排序
		$rs = M('memorial_steleauthor')->updateAll('id','listorder',$options,$ids);
		if ($rs) {
			$this->dialog("/memorial/moreset/steleauthor",'success','更新成功');
		} else {

			$this->dialog("/memorial/moreset/steleauthor",'error','更新失败');
		}
	} 
    /**
     * 立碑人审核 - 通过
     */
    public function stelesortyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_steleauthor')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 立碑人审核 - 不通过
     */
    public function stelesortnoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_steleauthor')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }
    
    //背景音乐管理
    public function songAction(){
        $where = array();

        if(isset($_GET['status'])){
            $where = array('status'=>0);
        }
		$keyword = $this->getParams('keyword');
		$search['keyword'] = $keyword;

		if(isset($keyword) && !empty($keyword)){

			$where['like'] = array('name'=>$keyword);
		}
		//分页
		$count = M('memorial_bgmusic')->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['order'] = "id desc";
		$options['where'] = $where;
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$list = M('memorial_bgmusic')->select($options);

		$this->assign('search',$search);
		$this->assign('pageStr',$pagestr);
		$this->assign('page',$currpage);
		$this->assign('list',$list);
		$this->display('memorial/moreset/songlist'); 
    }
     //添加背景音乐
     public function addsongAction(){
        	//提交表单
		if(!empty($_POST))
		{
			$arr = array(
				'name' => $this->getParams('name'),
				'status' => $this->getParams('status'),
			);
           if(isset($_POST['accessory'])){
		     @$pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'song','time_name'=>true));
	         @$pic = current($pic);
		     @$arr['musicpath'] = '/song/'.$pic['path'];
		    }
            $arr['type'] = 1;
			$rs = M('memorial_bgmusic')->create($arr);
			if ($rs){
		        admin_log('背景音乐','添加'.$arr['name']."背景音乐");
				$this->dialog("/memorial/moreset/song",'success','操作成功');
			}else{
				$this->dialog("/memorial/moreset/song",'error','操作失败');
			}
		}else{
           	$picSetting = array(
		    	'limit'       =>  1,
			    'type'        =>  array('mp3'),
			    'iswatermark' =>  true
		    );
           $this->assign('picsetting', base64_encode(serialize($picSetting)));
		   $this->display('memorial/moreset/songadd');
		}
     }

    /**
     * 背景音乐修改
     */
    public function songupdateAction()
    {
    	if(!empty($_POST)){
            $data = array();
            $data['name'] = $this->getParams('name');
            $data['id'] = $this->getParams('id');
            $data['status'] = $this->getParams('status');

            $map = array(
                'id'=>$data['id']
                );
            if(isset($_POST['accessory'])){
                $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'song','time_name'=>true));
                $pic = current($pic);
                $data['musicpath'] = '/song/'.$pic['path'];
            }
            $rs = M('memorial_bgmusic')->update($map, $data);
            if ($rs){
                admin_log('背景音乐','编辑'.$data['name']."背景音乐");
                $this->dialog("/memorial/moreset/song",'success','操作成功');
            }else{
                $this->dialog("/memorial/moreset/song",'error','操作失败');
            }


    	}else{
    		$id = $this->getParams('id');
    		$map = array(
    			'id'=>$id
    			);
    		$findData = M('memorial_bgmusic')->where($map)->getOne();
    		$this->assign('findData', $findData);

            $picSetting = array(
                'limit'       =>  1,
                'type'        =>  array('mp3'),
                'iswatermark' =>  true
            );
           $this->assign('picsetting', base64_encode(serialize($picSetting)));
    		$this->display('memorial/moreset/songupdate');

    	}
    }

    /**
     * 背景音乐 - 删除
     */
    public function songdeleteAction()
    {
        $id = $this->getIds('id');
        $name = urldecode($this->getParams('name'));
        $arr['page'] = $this->getParams('page');
        $where = array(
           'in'=>array('id'=>$id),
        );
        $rs = M('memorial_bgmusic')->delete($where);
        if($rs) {
            admin_log('立碑人信息模板','删除'.$name."立碑人信息模板");
            $this->dialog("/memorial/moreset/song/{$arr['page']}",'success','操作成功');
            exit;
        } else {
            $this->dialog("/memorial/moreset/song/{$arr['page']}",'error','操作失败');
            exit;
        }
    }

    /**
     * 背景音乐 - 不启用
     */
    public function beginAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_style')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'禁用成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'禁用失败'));exit;
          }
        }
    }

    /**
    * 背景音乐 - 启用
    */
    public function endAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_style')->update($map, $data);
          if($result){
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'启用成功'));exit;
          }else{
            echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'启用失败'));exit;
          }
        }
    }
    
}