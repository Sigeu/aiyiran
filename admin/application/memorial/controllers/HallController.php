<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 纪念馆
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
 * @author    class_container
 * @since      1.0.0
 */
if (!defined('IN_MAINONE')) exit('No permission');
class HallController extends AdminController {

  public $HallModel; #模型

  public static $keywords; #要搜索的关键字
  public static $categoryid; #要搜索的分类
  public static $status; #要搜索的状态
  public static $star; #要搜索的开始时间
  public static $end; #要搜索的结束时间
  public static $hallObj;

  public function init()
  {
        error_reporting(E_ALL & ~E_NOTICE);
    
    self::$keywords = urldecode(Controller::getParams('keywords', '')); #搜索内容
    self::$categoryid = urldecode(Controller::getParams('categoryid', '')); #分类搜索
    self::$status = urldecode(Controller::getParams('status', '')); #状态
    self::$star = urldecode(Controller::getParams('star', '')); #开始时间
    self::$end = urldecode(Controller::getParams('end', '')); #结束时间

    $this->HallModel = D('Hall');
    $this->hallObj = M('memorial');
    parent::init();
  }
  /**
   * 纪念馆列表
   */
  public function indexAction(){

        # 列表分类
        $catelist = $this->HallModel->getCateList();

        $search = array(
          'keywords'=>self::$keywords,
          'categoryid'=>self::$categoryid,
          'status'=>self::$status,
          'star'=>self::$star,
          'end'=>self::$end
        );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/hall/index", 'error', '结束时间不能小于开始时间');
          }
        }

        $mcat = M("memorial_cat")->select();
        $mact = mo_array_column($mcat,'name','id');
        # 满足条件的总条数
        $count = $this->HallModel->getData($search, true);
        $pagesize = 10;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->HallModel->getData($search, false);
        foreach ($list as $k=>$v){
            if($v['userid']==0){
                $list[$k]['author'] = "admin";
            }else{
                $author= M('member')->field('username,email')->where(array('id'=>$v['userid']))->getOne();
                if($author['username']){
                    $list[$k]['author'] = $author['username'];
                }else{
                    $list[$k]['author'] = $author['email'];
                }
                
            }
        }
        $this->assign('catelist',$catelist);
        $this->assign('search',$search);
        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('list',$list);
        $this->assign('mact',$mact);
        $this->display('memorial/hall/list');
  }

    /**
    *添加纪念馆
    **/
    public function addhallAction(){
      if(self::post("submit")){
         $updateInfo = array();
         $updateInfo['name'] = trim(self::post('name'));
         $updateInfo['personname'] = trim(self::post('personname'));
         $updateInfo['persontype'] = trim(self::post('persontype'));
         $updateInfo['catid'] = intval(self::post('catid'));
         $updateInfo['style'] = intval(self::post('style'));
         $updateInfo['letter'] = self::post('personname');

          Load::load_class('FirsetPinYin',DIR_BF_ROOT.'classes',0);
          $py = new FirsetPinYin();
          $updateInfo['letter'] = $py->getFirstchar($updateInfo['letter'] );

          if($_SESSION['userinfo']['username']){
             $updateInfo['isadmin'] = $_SESSION['userinfo']['username'];
          }
          // $updateInfo['userid'] = 0;

         $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
          if($accessory){
            $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'member','time_name'=>false));
            $updateInfo['userpic'] = $upload_info ? (isset($upload_info[0]['path']) ? '/static/uploadfile/member/'.$upload_info[0]['path'] : ''  )  : '';
            $url = $upload_info[0]['sp']['full'].'/'.$upload_info[0]['filename'];
            my_image_resize($url, $url, '185px','185px');

          }
          $rs = M('memorial')->create($updateInfo);
          //创建完纪念馆创建默认相册
          $photo = array();
          $photo['mid'] = $rs;
          $photo['name'] = "默认相册";
          // $photo['uid'] = $uid['id'];
          $photo['is_default'] = 2; //2是默认相册
          $photo['addtime'] = time();
          M('memorial_photocat')->create($photo);

         if($rs){
             M('memorial_userinfo')->create(array('mid'=>$rs,'person'=>$updateInfo['personname'],'relationship'=>$updateInfo['persontype']));
                    // M('memorial_other')->create(array('mid'=>$rs));
              admin_log('添加纪念馆','添加'.$updateInfo['name']."纪念馆");
              $this->dialog("/memorial/hall/index",'success','操作成功');
          }else{
             $this->dialog("/memorial/hall/index",'error','操作失败');
          }
      }else{
          $person_type = get_config('common','person_type_admin','home');
          $cemetery = M("memorial_cat")->select(array('field'=>'id,name'));//纪念馆分类
          $style = M("memorial_style")->select(array('field'=>'id,name'));//模板
          $picSetting = array
        (
          'limit'       =>  20,
          'type'        =>  array('jpg','png','gif'),
          'iswatermark' =>  true
        );
          $this->assign('cemetery',$cemetery);//陵园列表
          $this->assign('picsetting', base64_encode(serialize($picSetting)));
          $this->assign('person_type',$person_type);//与逝者关系
          $this->assign('style',$style);//摸版风格
          $this->display('memorial/hall/addhall');
      }
    }

    /**
   * 纪念馆详情--个人信息
   */
     public function infoAction(){
        if(self::post("submit")){
          $mid = $this->getParams('mid'); #纪念馆id
          $id = $this->getParams('id'); #资料id
          $result = $this->HallModel->getInfo2($mid, $id); #获取表单数据
          #修改所属陵园

          if($result){
            $this->dialog("/memorial/hall/index",'success','操作成功');
          }else{
            $this->dialog("/memorial/hall/index",'success','操作成功');
          }

        }else{
          #纪念馆id
          $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
          #用户信息
          $base = $this->HallModel->getInfo($mid);
          #获取陵园列表
          $came = M('memorial_cemetery2')->select(array('field'=>'id,title'));

          $nation = get_config('common','nation','home');
          $person_type = get_config('common','person_type_admin','home');
          $area = M('area')->where(array('area_type'=>1))->select();
          $originInfo = array();
          //籍贯省份循环市区
          if($base['info']['originp']){
              $originInfo = M('area')->where(array('parent_id'=>$base['info']['originp']))->select();
          }
          //出生地省份循环市区
          if($base['info']['brithp']){
              $brithpInfo = M('area')->where(array('parent_id'=>$base['info']['brithp']))->select();
          }
          //逝世地省份循环市区
          if($base['info']['diedp']){
              $diedpInfo = M('area')->where(array('parent_id'=>$base['info']['diedp']))->select();
          }
          

          $picSetting = array
                        (
                          'limit'       =>  20,
                          'type'        =>  array('jpg','png','gif'),
                          'iswatermark' =>  true
                        );

          $this->assign('picsetting', base64_encode(serialize($picSetting)));


          $this->assign('info', $base['info']); #用户信息
          $this->assign('memorial', $base['memorial']); #纪念馆
          $this->assign('mid', $mid); #纪念馆id
          $this->assign('id', $base['info']['id']); #资料id
          $this->assign('nation', $nation); #民族
          $this->assign('person_type',$person_type); #与逝者关系
          $this->assign('area',$area); #省份
            $this->assign('originInfo',$originInfo); //籍贯省份循环市区
            $this->assign('brithpInfo',$brithpInfo); //出生地省份循环市区
            $this->assign('diedpInfo',$diedpInfo); //籍贯省份循环市区
          $this->assign('came',$came); #所有陵园

          $this->display('memorial/hall/info');
        }
     }
     /**
      * 作品及其荣誉
      */
      public function honorAction(){
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $pstatus = array(3=>'待审核',1=>'审核成功',2=>'审核失败');
        $where = array('mid'=>$mid);
        $honorObj = M('memorial_honor');
      $count = $honorObj->findCount($where);
    $pagesize = 20;
    $page = new Page($count, $pagesize);
    $from = $page->firstRow;
    $options['limit'] = $from.','.$pagesize;
    $options['order'] = "id desc";
    $options['where'] = $where;
    $currpage = isset($_GET['p'])?$_GET['p']:1;
    $pagestr = $page->show();
    $list = $honorObj->select($options);
    $this->assign('pageStr',$pagestr);
    $this->assign('page',$currpage);
    $this->assign('list',$list);
        $this->assign('mid',$mid);
        $this->assign('pstatus',$pstatus);
    $this->display('memorial/hall/honor');
      }

      /**
      * 删除作品及其荣誉
      */
      public function dhonorAction(){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $mid = isset($_GET['mid']) ? intval($_GET['mid']) : 0 ;
        $page = $this->getParams('page');
        $where = array(
        'in'=>array('id'=>$id),
    );
    //$rs = M('memorial_honor')->delete($where);
        if ($rs) {
      $this->dialog("/memorial/hall/honor/id/{$mid}/page/{$page}",'success','操作成功');
      exit;
    } else {
      $this->dialog("/memorial/hall/honor/id/{$mid}/page/{$page}",'error','操作失败');
      exit;
    }
      }
      /**
      *作品及其荣誉详情
      */
      public function honorinfoAction(){
        if(self::post("submit")){
            $hid = intval(self::post("hid"));
            $mid = intval(self::post("mid"));
            $info = array();
            $info['hname'] = self::post('hname') ? trim(self::post('hname')) : '';
            $info['hcontent'] = self::post('hcontent');
            $info['stuatus'] = intval(self::post('stuatus'));
            $res = M('memorial_honor')->update(array('id'=>$hid),$info);
            if ($res) {
        $this->dialog("/memorial/hall/honorinfo/id/{$hid}",'success','操作成功');
        exit;
             }else{
        $this->dialog("/memorial/hall/honorinfo/id/{$hid}",'error','操作失败');
        exit;
        }
        }else{
          $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
          $where = array('id'=>$id);
          $rs = M('memorial_honor')->where($where)->getOne();
          $pstatus = array(1=>'待审核',2=>'审核成功',3=>'审核失败');
          $this->assign('info',$rs);
          $this->assign('id',$id);
          $this->assign('pstatus',$pstatus);
      $this->display('memorial/hall/honorinfo');
        }

      }
      /**
   *传记管理
   */
     public function biographyAction(){
       if(self::post("submit")){
        $mid = intval(self::post("mid"));
        $action = trim(self::post("action"));
        $biog = array();
        $biog['bioname'] = trim(self::post('bioname'));
        $biog['biocontent'] = trim(self::post('biocontent'));
        if($action == 'add'){
         $biog['mid'] = $mid;
         $rs = M('memorial_biography')->create($biog);
        }else{
         $rs = M('memorial_biography')->update(array('mid'=>$mid),$biog);
        }
        $this->dialog("/memorial/hall/biography/id/{$mid}",'success','操作成功');
        exit;
       }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $where = array('mid'=>$mid);
        $biography = M('memorial_biography')->where($where)->getOne();
        $action = 'edit';
        if(!$biography){
          $biography = array('bioname'=>'','biocontent'=>'','mid'=>0);
          $action = 'add';
        }
        $this->assign('action',$action);
        $this->assign('info',$biography);
        $this->assign('mid',$mid);
        $this->display('memorial/hall/biography');
       }

     }
     /**
   *隐私设置
   */
     public function mshowAction(){
      if(self::post("submit")){
        $mid = intval(self::post("mid"));
        $isshow = intval(self::post("isshow"));
        $res = M('memorial')->update(array('id'=>$mid),array('isshow'=>$isshow));
        if ($res) {
      $this->dialog("/memorial/hall/mshow/id/{$mid}",'success','操作成功');
      exit;
         }else{
      $this->dialog("/memorial/hall/mshow/id/{$mid}",'error','操作失败');
      exit;
      }
      }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $info = M('memorial')->field('isshow')->where(array('id'=>$mid))->getOne();
        $this->assign('info',$info);
        $this->assign('mid',$mid);
        $this->display('memorial/hall/mshow');
      }

     }
     /**
   *消息管理
   */
     public function messageAction(){
       if(self::post("submit")){

       }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $pstatus = array(1=>'待审核',2=>'审核成功',3=>'审核失败');
        $where = array('mid'=>$mid);
        $messObj = M('memorial_message');
      $count = $messObj->findCount($where);
    $pagesize = 20;
    $page = new Page($count, $pagesize);
    $from = $page->firstRow;
    $options['limit'] = $from.','.$pagesize;
    $options['order'] = "id desc";
    $options['where'] = $where;
    $currpage = isset($_GET['p'])?$_GET['p']:1;
    $pagestr = $page->show();
    $list = $messObj->select($options);
    $this->assign('pageStr',$pagestr);
    $this->assign('page',$currpage);
    $this->assign('list',$list);
        $this->assign('mid',$mid);
        $this->assign('pstatus',$pstatus);
        $this->display('memorial/hall/message');
       }

     }
     /**
   *编辑详细详情
   */
     public function messinfoAction(){
       if(self::post("submit")){
          $hid = intval(self::post("hid"));
          $mid = intval(self::post("mid"));
          $biog = array();
          $biog['message'] = trim(self::post('message'));
          $biog['status'] = trim(self::post('stuatus'));
          $rs = M('memorial_message')->update(array('id'=>$hid),$biog);
          $this->dialog("/memorial/hall/messinfo/id/{$hid}",'success','操作成功');
       }else{
          $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
          $info = M('memorial_message')->where(array('id'=>$mid))->getOne();
          $pstatus = array(1=>'待审核',2=>'审核成功',3=>'审核失败');
          $this->assign('pstatus',$pstatus);
          $this->assign('info',$info);
          $this->assign('mid',$mid);
          $this->display('memorial/hall/messinfo');
       }

     }
     /**
   *删除留言详情
   */
     public function messdelAction(){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $mid = isset($_GET['mid']) ? intval($_GET['mid']) : 0 ;
        $page = $this->getParams('page');
        $where = array(
        'in'=>array('id'=>$id),
    );
    $rs = M('memorial_message')->delete($where);
        if ($rs) {
      $this->dialog("/memorial/hall/message/id/{$mid}/page/{$page}",'success','操作成功');
      exit;
    } else {
      $this->dialog("/memorial/hall/message/id/{$mid}/page/{$page}",'error','操作失败');
      exit;
    }

     }

     /**
   *祭文悼词列表
   */
     public function eulogyAction(){
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $pstatus = array(1=>'待审核',2=>'审核成功',3=>'审核失败');
        $where = array('mid'=>$mid);
        $eulogyObj = M('memorial_eulogy');
      $count = $eulogyObj->findCount($where);
    $pagesize = 20;
    $page = new Page($count, $pagesize);
    $from = $page->firstRow;
    $options['limit'] = $from.','.$pagesize;
    $options['order'] = "id desc";
    $options['where'] = $where;
    $currpage = isset($_GET['p'])?$_GET['p']:1;
    $pagestr = $page->show();
    $list = $eulogyObj->select($options);
    $this->assign('pageStr',$pagestr);
    $this->assign('page',$currpage);
    $this->assign('list',$list);
        $this->assign('mid',$mid);
        $this->assign('pstatus',$pstatus);
        $this->display('memorial/hall/eulogy');
     }
     /**
   *删除祭文悼词
   */
     public function deleuloAction(){
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $mid = isset($_GET['mid']) ? intval($_GET['mid']) : 0 ;
        $page = $this->getParams('page');
        $where = array(
        'in'=>array('id'=>$id),
    );
    $rs = M('memorial_eulogy')->delete($where);
        if ($rs) {
      $this->dialog("/memorial/hall/eulogy/id/{$mid}/page/{$page}",'success','操作成功');
      exit;
    } else {
      $this->dialog("/memorial/hall/eulogy/id/{$mid}/page/{$page}",'error','操作失败');
      exit;
    }
     }
     /**
   *祭文悼词详情
   */
     public function euloinfoAction(){
       if(self::post("submit")){
          $hid = intval(self::post("hid"));
          $mid = intval(self::post("mid"));
          $biog = array();
          $biog['ename'] = trim(self::post('ename'));
          $biog['econtent'] = trim(self::post('econtent'));
          $biog['status'] = intval(self::post('status'));
          $rs = M('memorial_eulogy')->update(array('id'=>$hid),$biog);
          $this->dialog("/memorial/hall/euloinfo/id/{$hid}",'success','操作成功');
       }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $info = M('memorial_eulogy')->where(array('id'=>$mid))->getOne();
        $pstatus = array(1=>'待审核',2=>'审核成功',3=>'审核失败');
        $this->assign('pstatus',$pstatus);
        $this->assign('info',$info);
        $this->assign('mid',$mid);
        $this->display('memorial/hall/euloinfo');
       }

     }
  /**
   * 墓志铭管理
   * @return null
   */

    public function epitaphAction(){
     if(self::post("submit")){
          $mid = intval(self::post("mid"));
          $biog = array();
          $biog['epitaph'] = trim(self::post('epitaph'));
          $rs = M('memorial_other')->update(array('mid'=>$mid),$biog);
          $this->dialog("/memorial/hall/epitaph/id/{$mid}",'success','操作成功');
       }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $info = M('memorial_other')->where(array('mid'=>$mid))->getOne(array('field'=>'epitaph'));
        $epitaphDemo = M('memorial_mumingzhi')->select(array('field'=>'name,content','order'=>'sort asc ,id desc'));
        $this->assign('info',$info);
        $this->assign('epitaphDemo',$epitaphDemo);
        $this->assign('mid',$mid);
        $this->display('memorial/hall/epitaph');
       }
    }
    /**
   * 墓志铭管理
   * @return null
   */

    public function steleauthorAction(){
     if(self::post("submit")){
          $mid = intval(self::post("mid"));
          $biog = array();
          $biog['steleauthor'] = trim(self::post('steleauthor'));
          $rs = M('memorial_other')->update(array('mid'=>$mid),$biog);
          $this->dialog("/memorial/hall/steleauthor/id/{$mid}",'success','操作成功');
       }else{
        $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
        $info = M('memorial_other')->where(array('mid'=>$mid))->getOne(array('field'=>'steleauthor'));
        $steleauthorDemo = M('memorial_steleauthor')->select(array('field'=>'name,content','order'=>'listorder asc ,id desc'));
        $this->assign('info',$info);
        $this->assign('steleauthorDemo',$steleauthorDemo);
        $this->assign('mid',$mid);
        $this->display('memorial/hall/steleauthor');
       }
    }

     /**
   * 城市分类
   */
     public function areaAction(){
       $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
       $area = M('area')->where(array('parent_id'=>$mid))->select();
       $this->assign('area',$area);
       echo $this->fetch('memorial/hall/area.html');
       exit;
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
        'sort' => $this->getParams('sort')
      );
      $rs = $this->catObj->create($arr);
      if ($rs)
      {
         admin_log('添加纪念馆分类','添加'.$arr['name']."纪念馆分类");
        $this->dialog("/memorial/cat/index",'success','操作成功');
      }
      else
      {
        $this->dialog("/memorial/cat/index",'error','操作失败');
      }
    }else{
       $this->display('memorial/cat/add');
    }
  }

  /**
   * 添加友情链接
   * @return null
   */
  public function updateAction()
  {
    //提交修改
    $edit_id = isset($_POST['id']) ? intval($_POST['id']) : 0 ;
    if($edit_id)
    {
      $keyword = $this->getParams('keyword');
      $page = $this->getParams('page');
      $type = $this->getParams('type');
            $arr = array
      (
        'name'     => $this->getParams('name'),
        'sort'=> $this->getParams('sort')
      );



      //入库跳转
      $rs = $this->catObj->update(array('id'=>$edit_id), $arr);
      if ($rs)
      {
        admin_log('编辑纪念馆分类','编辑'.$arr['name']."纪念馆分类");
        $this->dialog("/memorial/cat/index/page/{$page}",'success','操作成功');
      }
      else
      {
        $this->dialog("/memorial/cat/index/page/{$page}",'error','操作失败');
      }
    }

    //修改页面
    $id = $this->getParams('id');
    $arr['page'] = $this->getParams('page');
    $infor = $this->catObj->where(array('id'=>$id))->getOne();
    $this->assign('arr',$arr);
    $this->assign('infor',$infor);
    $this->display('memorial/cat/update');

  }

  /**
   * 纪念馆审核 - 通过
   */
  public function audiAction()
  {
    if(!empty($_POST)){
      $id = $_POST['id'];
      $map = array(
        'id'=>$id
        );
      $data = array(
        'status'=>1
        );
      $result = M('memorial')->update($map, $data);
      if($result){
          echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
      }else{
          echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
      }

    }
  }

  /**
   * 纪念馆审核 - 不通过
   */
  public function noaudiAction()
  {
    if(!empty($_POST)){
      $id = $_POST['id'];
      $map = array(
        'id'=>$id
        );
      $data = array(
        'status'=>2
        );
      $result = M('memorial')->update($map, $data);
      if($result){
          echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'操作成功'));exit;
      }else{
          echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'操作失败'));exit;
      }

    }
  }


  /**
   * 独立的纪念馆审核
   */

  public function jinianAction(){

        # 列表分类
        $catelist = $this->HallModel->getCateList();

        $search = array(
          'keywords'=>self::$keywords,
          'categoryid'=>self::$categoryid,
          'status'=>self::$status,
          'star'=>self::$star,
          'end'=>self::$end
        );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/hall/index", 'error', '结束时间不能小于开始时间');
          }
        }

        # 满足条件的总条数
        $count = $this->HallModel->getData($search, true);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->HallModel->getData($search, false);

        $this->assign('catelist',$catelist);
        $this->assign('search',$search);
        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('list',$list);
        $this->display('memorial/hall/jinian');
  }

  /**
   * 纪念馆删除
   */
  public function deleteHallAction()
  {
    $id = $this->getIds('id');
    $name = urldecode($this->getParams('name'));
    $page = $this->getParams('page');
    $where = array(
        'in'=>array('id'=>$id),
    );
    $map = array(
        'in'=>array('mid'=>$id),
    );
    $result = M('memorial')->delete($where);
    $result2 = M('memorial_userinfo')->delete($map);
    if ($result && $result2) {
      admin_log('删除纪念馆','删除'.$name."纪念馆");
      $this->dialog("/memorial/hall/index/page/{$page}",'success','操作成功');
      exit;
    } else {
      $this->dialog("/memorial/hall/index/page/{$page}",'error','操作失败');
      exit;
    }
  }



}