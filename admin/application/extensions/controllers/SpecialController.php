<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://www.izhancms.cn)
 *
 * SpecialController.php
 *
 * 专题
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-08-16 15:55
 * @filename   SpecialController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    iZhanCMS 2.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SpecialController extends AdminController
{

	public $SpecialModel; //专题模型
	public $SpecialSectionModel; //专题版块模型
	public $SpecialAssortModel; //版块节点模型
    public $SystemModel; //系统设置模型
	public $AdminRoleModel; //管理员模型
	public $MemberGroupModel; //会员模型
    public $SpecialManagerModel; //管理员专题模型
    public $SpecialMemberModel; //会员专题模型

	public $searchModel; //前台搜索模型
	public $tagModel;  //tag标签模型

    public $SpecialtplModel;  //专题皮肤模型

	public function init()
	{
		$this->SpecialModel = D('Special');
        $this->SpecialSectionModel = D('SpecialSection');
        $this->SpecialAssortModel = D('SpecialAssort');
        $this->SystemModel = D('SystemModel','webset');

        $this->AdminRoleModel = D('AdminRoleModel','content');
        $this->MemberGroupModel = D('MemberGroupModel','members');
        $this->SpecialManagerModel = D('SpecialManagerModel');
        $this->SpecialMemberModel = D('SpecialMemberModel');

		$this->searchModel    = D('Search','search','home');
		$this->tagModel       = D('Tags','extensions');
		$this->SpecialtplModel = D('Specialtpl');

	}
	/**
	 * 专题列表
	 */
	public function indexAction ()
	{
        $where = array();
		$pageInfo   = array();
		//$searchInfo = array();

		//搜索条件
		$keyword = $this->getParams('keyword');     //关键字
		$type = $this->getParams('type_id');        //专题分类
        $select = $this->getParams('options');      //搜索方式
        $sequence = $this->getParams('sequence');   //排序方式

		//$searchInfo = array('keyword' => $keyword,'type_id' => $type);

		if (isset($keyword) && !empty($keyword))
		{
			$where['or'] = " name like '%{$keyword}%'";
		}

		if (isset($type) AND !empty($type))
		{
			$where['type_id'] = $type;
		}

		if (!empty($select) AND !empty($sequence))
		{
		    $options['order'] = $select." ".$sequence;
		}
        else
        {
            $options['order'] = "number ASC, created DESC";
        }

		$count = M('Special')->findCount($where);
		$pagesize = 20;
		$page = new Page($count, $pagesize);
		$from = $page->firstRow;
		$options['limit'] = $from.','.$pagesize;
		$options['where'] = $where;

		$sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();
		$list = M('Special')->select($options);

        foreach ($list as $key=>$val){
            $list[$key]['type_name'] = $this->getSpecialAssortModel()->find(array('id'=>$val['type_id']), true, 'type_name');
        }
		$currpage = isset($_GET['p'])?$_GET['p']:1;
		$pagestr = $page->show();
		$this->assign('List',$list);
		$this->assign('sort_tree',$sort_tree);
		$this->assign('keyword',$keyword);
        $this->assign('type',$type);
        $this->assign('select',$select);
		$this->assign('sequence',$sequence);
        $this->assign('pageStr',$pagestr);
		$this->display('extensions/special/special');
	}

    /* 实例化栏目模型 */
	public function getCategoryModel()
	{
		return D('CategoryModel');
	}

	/**
	 * 管理专题
	 */
	public function manageAction ()
    {
        $per = $this->SpecialModel->getPer(1); // 拥有该权限 = 1
        $sid = empty($_GET['sid']) ? 0 : intval($_GET['sid']); //专题ID
		if(in_array($sid,$per) || $_SESSION['roleid'] == 1)
		{
            $special = $this->SpecialModel->find(array('id'=>$sid)); //获取专题信息
            $catList = $this->getCategoryModel()->getCategoryTree(); //栏目列表
            $count = $this->SpecialSectionModel->findAll(array('sid'=>$sid),true,'id'); //获取专题对应版块数量
            $list = $this->SpecialAssortModel->getSectionListWhenAssortContentInside($count);
            $banner = $this->SpecialSectionModel->getBannerList($sid); //根据专题ID获取导航
            $section = $this->SpecialSectionModel->findAll(array('sid'=>$sid),'sortby ASC, id ASC'); //版块、节点信息
            $this->SpecialAssortModel->getNodeBySection($section); //耦合
            $this->assign('special_info',$special);
            $this->assign('banner_list',$banner);
            $this->assign('section_number',count($count));
            $this->assign('section',$section);
            $this->assign('specialid',$sid);
            $this->assign('cat',$catList);
            if(!empty($list)) {
                $this->assign('section_list',implode(',',$list));
            }
            $this->display('extensions/special/special_info');
        }
        else
		{
            $this -> dialog('/extensions/Special/index','info','对不起，您没有此操作权限！');
		}
    }

	/**
	 * 添加、删除、排序 版块
	 */
	public function addSectionAction ()
    {
        $ids = empty($_POST['will']) ? 0 : trim($_POST['will']);  //需要删除的版块IDs
        $condition['in'] = array('id'=>$ids);
        $in['in'] = array('secid'=>$ids);
        $sid = empty($_POST['sid']) ? 0 : intval($_POST['sid']);  //专题ID
        $types = empty($_POST['ther']) ? 0 : $_POST['ther']; //批量添加版块集
        $reorder = empty($_POST['reorder']) ? '' : $_POST['reorder']; //排序值

        $this->SpecialSectionModel->createSectionAndAssort($sid, $types);  //添加
        D('SpecialSection')->delete($condition);  //删除
        D('SpecialAssort')->delete($in);
        $this->SpecialSectionModel->updateReorder($sid, $reorder);  //排序
    }

	/**
	 * 返回专题分类模型
	 */
	function getSpecialAssortModel ()
	{
		return D('SpecialTypeModel');
	}

	/**
	 * 添加专题
	 */
	public function addAction ()
    {
		$sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
		$setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));

		$admin_role = $this->AdminRoleModel->findAll(array('status'=>1));  //管理员列表
		$member_group = $this->MemberGroupModel-> findAll(array('status'=>1)); //会员列表

		$skin_list = $this->SpecialtplModel -> getTemplateSkinFolder('default');//专题模板皮肤列表
		$skin_conf = $this->SpecialtplModel -> getTemplateSkinConf('default', $skin_list);   //所有模板目录配置文件
		$this->assign('skin_conf',$skin_conf);

        $act = empty($_POST['act']) ? '' : $_POST['act'];
        if($act == 'add') {
            $root = dirname(realpath(DIR_ROOT));
            $uploadfile = getFileSavePath('special');
            if(isset($_POST['accessory'])){
                $url = current($_POST['accessory']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['thumb_img'] = '/special/'. basename($url['path']);
                    $base['thumb_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            if(isset($_POST['accessory2'])){
                $url = current($_POST['accessory2']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['banner_img'] = '/special/'. basename($url['path']);
                    $base['banner_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            if(isset($_POST['accessory3'])){
                $url = current($_POST['accessory3']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['back_img'] = '/special/'. basename($url['path']);
                    $base['back_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            $base['name'] = empty($_POST['name']) ? '' : $_POST['name'];

            Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
            $pinyin = new MoPinyin();
            $pinyin_url = $pinyin->toPinyin($base['name']);

            $names = $this->SpecialModel->findAll('',true,'name'); //已存在专题名称
            $already = array();
            foreach($names as $value){
                $already[] = $value['name'];
            }
            if (in_array($_POST['name'], $already) ==true) {
				$this->dialog('/extensions/Special/add','fail','专题名称已存在！');
            }

            $base['type_id'] = empty($_POST['type_id']) ? 0 : $_POST['type_id'];
            $base['guide']  = empty($_POST['guide']) ? '' : $_POST['guide'];
            $base['skin']  = empty($_POST['skin']) ? 0 : $_POST['skin'];
            $base['save_catalog'] = empty($_POST['save_catalog']) ? $pinyin_url : $_POST['save_catalog'];
            $base['click_num'] = empty($_POST['click_num']) ? 0 : $_POST['click_num'];
            $base['stick'] = empty($_POST['stick']) ? 0 : $_POST['stick'];
            $base['publishopt'] = empty($_POST['publishopt']) ? 2 : $_POST['publishopt'];
            $base['seo_title'] = empty($_POST['seo_title']) ? '' : $_POST['seo_title'];
            $base['seo_keywords'] = empty($_POST['seo_keywords']) ? '' : $_POST['seo_keywords'];
            $base['seo_description'] = empty($_POST['seo_description']) ? '' : $_POST['seo_description'];
            $base['created'] = empty($_POST['created']) ? time() : strtotime($_POST['created']);
            $base['alter_time'] = time();
            $specialid = M('Special')->create($base);



            if($_POST['publishopt'] ==1) {  //生成专题静态页
                $path = '../html/special/'.$base['save_catalog'].'/';
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
                $static = file_get_contents(HOST_NAME . "special/Special/index/id/$specialid/unavailable/1");
                echo $static. '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'special/Special/index/id/' . $specialid  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
                $text = ob_get_contents();
                ob_end_clean();
                $con = fopen($filename, "w");
                fwrite ($con,$text);
                fclose ($con);
                @rename($filename, $path . $filename);
            }



            $this->SpecialSectionModel->createSection($specialid); //新建专题、创建三个版块 -----------

			//管理员权限
			$admin = array();
			if(isset($_POST['info']['power']['admin']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['admin'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$admin[$i]['specialid'] = $specialid;
						$admin[$i]['roleid'] = $key;
						$admin[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialManagerModel -> createAll($admin);//管理员权限入库

			//会员权限
			$member = array();
			if(isset($_POST['info']['power']['member']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['member'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$member[$i]['specialid'] = $specialid;
						$member[$i]['groupid'] = $key;
						$member[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialMemberModel -> createAll($member);//会员权限入库

            //Tag标签接口
            if (isset($base['seo_keywords'])&&!empty($base['seo_keywords']))
            {
                $this -> tagModel->addTags('a',$specialid,$base['seo_keywords']);

            }

            //搜索关键词接口
            $this->searchModel->searchAdd('a', 0, $specialid, $base['name'],$base['guide'], $base['seo_description'] ,$base['seo_keywords']);

            $this -> dialog('/extensions/Special/index','success','添加成功！');
        }

		$this -> assign('sort_tree',$sort_tree);
		$this -> assign('setting',$setting);
		$this -> assign('admin_role',$admin_role);
		$this -> assign('member_group',$member_group);
        $this->display('extensions/special/add_special');
    }

	/**
	 * 删除专题
	 */
	public function deleteAction ()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if(isset($id) && !empty($id)) {
            M('Special')->delete(array('id'=>$id));

            //Tag标签接口
            $this->tagModel->deleteTags('a', $id);//（模型id,信息id）删除tag标签表中数据
            //搜索接口
            $this->searchModel->searchDel('a',$id);//（模型id,信息id）删除tag标签表中数据

            $this -> dialog('/extensions/Special/index','success','删除成功！');  //删专题时亦需删版块、
        }
        $ids = $this->getIds('ids');
        $condition['in'] = array('id'=>$ids);
        M('Special')->delete($condition);

        //Tag标签接口
        $this->tagModel->deleteTags('a',$ids);//（模型id,信息id）删除tag标签表中数据
        //搜索接口
        $this->searchModel->searchDel('a', $ids);//（模型id,信息id）删除tag标签表中数据

        $this -> dialog('/extensions/Special/index','success','删除成功！');
    }

	/**
	 * 修改专题
	 */
	public function editAction ()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);  //专题ID  GET获取
		$sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();

		$admin_role = $this->AdminRoleModel->findAll(array('status'=>1));
		$member_group = $this->MemberGroupModel-> findAll(array('status'=>1));
        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
		$setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));
		$manager_permission = $this ->SpecialManagerModel-> getManagerPermissionById($id); //根据ID获取专题管理员权限
		$member_permission = $this ->SpecialMemberModel-> getMemberPermissionById($id);  //根据ID获取专题会员权限

		$skin_list = $this->SpecialtplModel -> getTemplateSkinFolder('default');//专题模板皮肤列表
		$skin_conf = $this->SpecialtplModel -> getTemplateSkinConf('default', $skin_list);   //所有模板目录配置文件
		$this->assign('skin_conf',$skin_conf);

		$row = M('Special')->find(array('id'=>$id));
        $act = empty($_POST['act']) ? '' : $_POST['act'];
        if($act == 'edit') {
            $id = $_POST['specialid'];  //专题ID  POST获得
		    $again = M('Special')->find(array('id'=>$id));
            $names = $this->SpecialModel->findAll('',true,'name'); //已存在专题名称
            $already = array();
            foreach($names as $value){
                $already[] = $value['name'];
            }
            if ((in_array($_POST['name'], $already) == true) && ($_POST['name'] <> $again['name'])) {
				$this->dialog('/extensions/Special/edit/id/$id','fail','专题名称已存在！');
            }
            $root = dirname(realpath(DIR_ROOT));
            $uploadfile = getFileSavePath('special');
            if(isset($_POST['accessory'])){
                $url = current($_POST['accessory']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['thumb_img'] = '/special/'. basename($url['path']);
                    $base['thumb_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['thumb_img'] = empty($_POST['thumb_img']) ? '' : $_POST['thumb_img'];
                $base['thumb_img_alt']  = empty($_POST['thumb_img_alt']) ? '' : $_POST['thumb_img_alt'];
            }
            if(isset($_POST['accessory2'])){
                $url = current($_POST['accessory2']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['banner_img'] = '/special/'. basename($url['path']);
                    $base['banner_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['banner_img'] = empty($_POST['banner_img']) ? '' : $_POST['banner_img'];
                $base['banner_img_alt']  = empty($_POST['banner_img_alt']) ? '' : $_POST['banner_img_alt'];
            }
            if(isset($_POST['accessory3'])){
                $url = current($_POST['accessory3']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['back_img'] = '/special/'. basename($url['path']);
                    $base['back_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['back_img'] = empty($_POST['back_img']) ? '' : $_POST['back_img'];
                $base['back_img_alt']  = empty($_POST['back_img_alt']) ? '' : $_POST['back_img_alt'];
            }

            $base['name'] = $_POST['name'];
            Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
            $pinyin = new MoPinyin();
            $pinyin_url = $pinyin->toPinyin($base['name']);

            $base['type_id'] = $_POST['type_id'];
            $base['guide']  = $_POST['guide'];
            $base['skin']  = empty($_POST['skin']) ? 0 : $_POST['skin'];
            $base['save_catalog'] = empty($_POST['save_catalog']) ? $pinyin_url : $_POST['save_catalog'];
            $base['click_num'] = $_POST['click_num'];
            $base['stick'] = empty($_POST['stick']) ? 0 : $_POST['stick'];
            $base['publishopt'] = empty($_POST['publishopt']) ? '' : $_POST['publishopt'];
            $base['seo_title'] = empty($_POST['seo_title']) ? '' : $_POST['seo_title'];
            $base['seo_keywords'] = empty($_POST['seo_keywords']) ? '' : $_POST['seo_keywords'];
            $base['seo_description'] = empty($_POST['seo_description']) ? '' : $_POST['seo_description'];
            $base['created'] = empty($_POST['created']) ? time() : strtotime($_POST['created']);
            $base['alter_time'] = time();
            M('Special')->update(array('id'=>$id), $base);




            if($_POST['publishopt'] ==1) {  //生成专题静态页
                $path = '../html/special/'.$base['save_catalog'].'/';
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
                $static = file_get_contents(HOST_NAME . "special/Special/index/id/$id/unavailable/1");
                  echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'special/Special/index/id/' . $id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
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
						$admin[$i]['specialid'] = $id;
						$admin[$i]['roleid'] = $key ;
						$admin[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialManagerModel -> delete(array('specialid'=>$id));
			$this -> SpecialManagerModel -> createAll($admin);//管理员权限入库
			//会员权限
			$member = array();
			if(isset($_POST['info']['power']['member']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['member'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$member[$i]['specialid'] = $id;
						$member[$i]['groupid'] = $key ;
						$member[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialMemberModel -> delete(array('specialid'=>$id));
			$this -> SpecialMemberModel -> createAll($member);//会员权限入库

            //Tag标签接口
            $this->tagModel->updateTags('a',$id,$base['seo_keywords']);

            //搜索接口
            $this->searchModel->searchUpdate(0,$id,$base['name'],$base['guide'],$base['seo_description'],$base['seo_keywords']);

            $this -> dialog('/extensions/Special/index','success','修改成功！');
        }

		$this->assign('row',$row);
		$this -> assign('sort_tree',$sort_tree);
		$this -> assign('setting',$setting);
		$this -> assign('admin_role',$admin_role);
		$this -> assign('member_group',$member_group);
		$this -> assign('admin' ,$manager_permission ? $manager_permission[$id] : array());
		$this -> assign('member' ,$member_permission ? $member_permission[$id] : array());
        $this->display('extensions/special/edit_special');
    }

	/**
	 * 更新排序
	 */
    public function updateOrderAction ()
	{
		$sort = isset($_POST['ids']) ? array_flip($_POST['ids']) : array();
		$row = array_intersect_key($_POST['number'], $sort);
		foreach($row AS $key=>$val){
			M('Special')->update(array('id'=>$key),array('number'=>$val));
		}
		$this->dialog("/extensions/Special/index",'success','更新成功！');
	}

	/**
	 * 移动到分类
	 */
    public function moveAction ()
	{
        $type = empty($_GET['moveSpecialId']) ? 0 : $_GET['moveSpecialId'];  //需要移动到的分类ID
        $ids  = empty($_POST['ids']) ? array() : $_POST['ids'];  //需要移动的专题IDs
		$ids = implode($ids,',');
        if($type <> 0 and !empty($ids)) {
            M('Special')->update(array('in'=>array('id'=>$ids)),array('type_id'=>$type));
        }
		$this->dialog("/extensions/Special/index",'success','操作成功！');
	}

	/**
	 * 移动至分类的页面
	 */
    public function moveHtmlAction()
    {
        $sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();
		$this -> assign('sort_tree',$sort_tree);
        $this->display('extensions/special/special_move');
    }

	/**
	 * 拷贝专题
	 */
    public function copyAction ()
	{
		$sort_tree = $this->getSpecialAssortModel()->getSpecialAssort();
        $max = $this->SpecialModel->query("SELECT MAX(id) AS max FROM " .$this->SpecialModel->tablePrefix ."special");

        $allow = $this->SystemModel->find(array('par_id'=>26),false,'par_value'); //允许上传图片类型
		$setting = array('limit'=>2,'local'=>true,'folder'=>true,'type'=>explode('|',$allow['par_value']));
		$setting['setting'] = base64_encode(serialize($setting));

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']); //被复制专题ID
		$manager_permission = $this ->SpecialManagerModel-> getManagerPermissionById($id); //根据ID获取专题管理员权限
		$member_permission = $this ->SpecialMemberModel-> getMemberPermissionById($id);  //根据ID获取专题会员权限
		$row = M('Special')->find(array('id'=>$id));
		$admin_role = $this->AdminRoleModel->findAll(array('status'=>1));
		$member_group = $this->MemberGroupModel-> findAll(array('status'=>1));

		$skin_list = $this->SpecialtplModel -> getTemplateSkinFolder('default');//专题模板皮肤列表
		$skin_conf = $this->SpecialtplModel -> getTemplateSkinConf('default', $skin_list);   //所有模板目录配置文件
		$this->assign('skin_conf',$skin_conf);

        $act = empty($_POST['act']) ? '' : $_POST['act'];
        if($act == 'copy') {
            $root = dirname(realpath(DIR_ROOT));
            $uploadfile = getFileSavePath('special');
            if(isset($_POST['accessory'])){
                $url = current($_POST['accessory']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['thumb_img'] = '/special/'. basename($url['path']);
                    $base['thumb_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['thumb_img'] = empty($_POST['thumb_img']) ? '' : $_POST['thumb_img'];
                $base['thumb_img_alt']  = empty($_POST['thumb_img_alt']) ? '' : $_POST['thumb_img_alt'];
            }
            if(isset($_POST['accessory2'])){
                $url = current($_POST['accessory2']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['banner_img'] = '/special/'. basename($url['path']);
                    $base['banner_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['banner_img'] = empty($_POST['banner_img']) ? '' : $_POST['banner_img'];
                $base['banner_img_alt']  = empty($_POST['banner_img_alt']) ? '' : $_POST['banner_img_alt'];
            }
            if(isset($_POST['accessory3'])){
                $url = current($_POST['accessory3']);
                if(copy($root.$url['path'],$uploadfile['base'] . DS . basename($url['path']))){
                    $base['back_img'] = '/special/'. basename($url['path']);
                    $base['back_img_alt']  = empty($url['alt']) ? '' : $url['alt'];
                }
            }
            else{
                $base['back_img'] = empty($_POST['back_img']) ? '' : $_POST['back_img'];
                $base['back_img_alt']  = empty($_POST['back_img_alt']) ? '' : $_POST['back_img_alt'];
            }

            $preid = $_POST['specialid']; //被复制专题ID

            $base['name'] = $_POST['name'];
            Load::load_class('MoPinyin',DIR_BF_ROOT.'classes',0);
            $pinyin = new MoPinyin();
            $pinyin_url = $pinyin->toPinyin($base['name']);
            $base['type_id'] = $_POST['type_id'];
            $base['guide']  = $_POST['guide'];
            $base['skin']  = empty($_POST['skin']) ? 0 : $_POST['skin'];
            $base['save_catalog'] = empty($_POST['save_catalog']) ? $pinyin_url : $_POST['save_catalog'];
            $base['click_num'] = $_POST['click_num'];
            $base['stick'] = empty($_POST['stick']) ? 0 : $_POST['stick'];
            $base['publishopt'] = empty($_POST['publishopt']) ? '' : $_POST['publishopt'];
            $base['seo_title'] = empty($_POST['seo_title']) ? '' : $_POST['seo_title'];
            $base['seo_keywords'] = empty($_POST['seo_keywords']) ? '' : $_POST['seo_keywords'];
            $base['seo_description'] = empty($_POST['seo_description']) ? '' : $_POST['seo_description'];
            $base['created'] = empty($_POST['created']) ? time() : strtotime($_POST['created']);
            $base['alter_time'] = time();
            $specialid = M('Special')->create($base);



            if($_POST['publishopt'] ==1) {  //生成专题静态页
                $path = '../html/special/'.$base['save_catalog'].'/';
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
                $static = file_get_contents(HOST_NAME . "special/Special/index/id/$specialid/unavailable/1");
                   echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'special/Special/index/id/' . $specialid  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
                $text = ob_get_contents();
                ob_end_clean();
                $con = fopen($filename, "w");
                fwrite ($con,$text);
                fclose ($con);
                @rename($filename, $path . $filename);
            }



            $this->SpecialModel->copySpecial($preid,$specialid); //复制专题、也需要创建对应版块、节点

			//管理员权限
			$admin = array();
			if(isset($_POST['info']['power']['admin']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['admin'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$admin[$i]['specialid'] = $specialid;
						$admin[$i]['roleid'] = $key;
						$admin[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialManagerModel -> createAll($admin);//管理员权限入库

			//会员权限
			$member = array();
			if(isset($_POST['info']['power']['member']))
			{
				$i = 0;
				foreach ($_POST['info']['power']['member'] as $key => $val )
				{
					foreach ($val as $k => $v )
					{
						$member[$i]['specialid'] = $specialid;
						$member[$i]['groupid'] = $key;
						$member[$i]['permissionid'] = $v;
						$i++;
					}
				}
			}
			$this -> SpecialMemberModel -> createAll($member);//会员权限入库

            $this -> dialog('/extensions/Special/index','success','复制成功！');
        }
		$this -> assign('sort_tree',$sort_tree);
        $this -> assign('max', $max[0]['max'] + 1);
		$this -> assign('setting',$setting);
		$this->assign('row',$row);
		$this -> assign('admin_role',$admin_role);
		$this -> assign('member_group',$member_group);
		$this -> assign('admin' ,$manager_permission ? $manager_permission[$id] : array());
		$this -> assign('member' ,$member_permission ? $member_permission[$id] : array());
        $this->display('extensions/special/copy_special');
	}

	/**
	 * 节点自主选取内容
	 */
    public function selectAction()
    {
        $keyword = empty($_GET['keyword']) ? '' : trim($_GET['keyword']);

		if (isset($keyword) && !empty($keyword))
		{
            $sql = "SELECT id, title FROM ".$this->SpecialModel->tablePrefix ."maintable WHERE title like '%{$keyword}%'";
		}else{
            $sql = "SELECT id, title FROM ".$this->SpecialModel->tablePrefix ."maintable";
        }
        $info = $this->SpecialModel->getPageList(array('sql'=>$sql));

        $this->assign('info', $info['list']);
        $this->assign('keyword',$keyword);
        $this->assign('pageStr',$info['pagestr']);
        $this->display('extensions/special/chose_article');
    }

	/**
	 * 节点详情编辑
	*/
    public function assortAction()
    {
        $id = empty($_POST['assort_id']) ? 0 : intval($_POST['assort_id']);  //节点ID
        $info['assort_name'] = empty($_POST['assort_name']) ? '' : $_POST['assort_name']; //节点名称
        $info['change_type'] = empty($_POST['change_type']) ? 0 : $_POST['change_type']; //获取文章列表方式

        if(!empty($_POST['category']) && $_POST['category'] <> 0) { //固定栏目ID
            $info['category_id'] = empty($_POST['category']) ? 0 : $_POST['category']; //栏目ID
            $info['idlist'] = $this->SpecialModel->getArticleIdsByCategory($_POST['category']); //根据栏目ID获取文章ID
        }else if(isset($_POST['keyword']) && !empty($_POST['keyword'])) { //根据文章标题关键字
            $info['keywords'] = empty($_POST['keyword']) ? '' : $_POST['keyword']; //获取文章之关键字
            $info['idlist'] = $this->SpecialModel->getArticleIdsByTitle($_POST['keyword']);
        }else if(isset($_POST['diy']) && !empty($_POST['diy'])) { //自主选择
            $info['idlist'] = empty($_POST['diy']) ? '' : $_POST['diy']; //自主选取
        }
        $info['number'] = empty($_POST['number']) ? 0 : $_POST['number']; //显示内容条数
        $info['order_style'] = empty($_POST['order_style']) ? '' : $_POST['order_style']; //根据排序项
        $info['order_type'] = empty($_POST['order_type']) ? '' : $_POST['order_type']; //排序方式
        $info['is_banner'] = empty($_POST['is_banner']) ? 2 : $_POST['is_banner']; //是否导航显示
        $info['banner'] = empty($_POST['banner']) ? '' : $_POST['banner']; //导航名称
        $info['img_hei'] = empty($_POST['img_hei']) ? 0 : $_POST['img_hei']; //缩略图高
        $info['img_wid'] = empty($_POST['img_wid']) ? 0 : $_POST['img_wid']; //缩略图宽
        $info['title_number'] = empty($_POST['title_number']) ? 0 : $_POST['title_number']; //标题显示字数
        $info['brief_number'] = empty($_POST['brief_number']) ? 0 : $_POST['brief_number']; //简介

        $this->SpecialAssortModel->update(array('aid'=>$id), $info); //编辑节点信息
    }

    /*
     * 节点 - 隐藏
    */
    public function disappearAction()
    {
        $node_id = empty($_POST['node_id']) ? 0 : intval($_POST['node_id']);  //节点ID
		$this -> SpecialAssortModel->update(array('aid'=>$node_id), array('is_show'=> 2)); //隐藏节点
    }

    /*
     * 节点 - 显示
    */
    public function showAction()
    {
        $node_id = empty($_POST['node_id']) ? 0 : intval($_POST['node_id']);  //节点ID
		$this -> SpecialAssortModel->update(array('aid'=>$node_id), array('is_show'=> 1)); //隐藏节点
    }


    /*
     * 专题 - 发布页面
    */
    public function issueAction()
    {
        $ids = $_POST['ids'];
        $in = implode(",", $ids);
		$data = $this->SpecialModel->findAll(array('in'=>array('id'=>$in),'publishopt'=>1),false,'id, save_catalog');
        foreach($data as $key => $val){
            $path = '../html/special/'.$val['save_catalog'].'/';
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
            $static = file_get_contents(HOST_NAME . "special/Special/index/id/$val[id]/unavailable/1");
               echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'special/Special/index/id/' . $val[id]  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
            $text = ob_get_contents();
            ob_end_clean();
            $con = fopen($filename, "w");
            fwrite ($con,$text);
            fclose ($con);
            @rename($filename, $path . $filename);
        }

        $this -> dialog('/extensions/Special/index','success','发布成功！');
    }



}