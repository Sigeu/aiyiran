<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 陵园管理控制器类
 *
 * @author     月下追魂 <youkaili@mail.b2b.cn>   2016年11月15日11:34:34
 * @filename   CemeteryController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

if (!defined('IN_MAINONE')) exit('No permission');
class CemeteryController extends AdminController {
    public $Cemetery; #模型

    public static $keywords; #要搜索的关键字
    public static $star;
    public static $end;
    public static $status;
    public static $modelid;
    public static $modelid2;
  public static $modelUrl;



    public function init()
    {
    self::$modelUrl =  get_cache('modelUrl','common');

        self::$keywords = urldecode(Controller::getParams('keywords', '')); #搜索内容
        self::$star = urldecode(Controller::getParams('star', '')); #搜索内容
        self::$end = urldecode(Controller::getParams('end', '')); #搜索内容
        self::$status = urldecode(Controller::getParams('status', '')); #搜索内容
        $this->Cemetery = D('Cemetery');
        self::$modelid =  9;
        self::$modelid2 =  1;

    }

    /**
     * 创建陵园
     */
    public function listsAction()
    {
        $search = array(
            'keywords'=>self::$keywords,
            'star'=>self::$star,
            'end'=>self::$end,
            'status'=>self::$status,
            );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/cemetery/lists", 'error', '结束时间不能小于开始时间');
          }
        }

        # 满足条件的总条数
        $count = $this->Cemetery->lists($search, true);
        $pagesize = 10;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $lists = $this->Cemetery->lists($search, false);


        $this->assign('pageStr',$pagestr);
        $this->assign('page',$currpage);
        $this->assign('lists', $lists);
        $this->assign('search', $search);
        $this->display('memorial/cemetery/lists');
    }

    /**
     * 添加陵园
     */
    public function addAction()
    {
        self::$modelid = self::$modelid ? self::$modelid : 0;
        $ContentForm = new ContentForm(self::$modelid);
        $form = $ContentForm->get();

        foreach ($form as $key => $value) {
          if($key == 'tupian' || $key == 'tupian2'){
            $for[$key] = $value;
          }else{
            unset($form[$key]);
          }
        }
        // p($form);
        if(self::post("submit")){
           if(empty($_POST['title'])) $this->dialog("/memorial/cemetery/add",'error','陵园名称不能为空');
           #添加陵园信息
           $result = $this->Cemetery->addCemetery();
           if($result){
             admin_log('陵园管理', '添加陵园为：' . self::post('title') . '数据成功');
             $this->dialog("/memorial/cemetery/add",'success','添加陵园成功');die;
           }else{
             $this->dialog("/memorial/cemetery/add",'error','添加陵园失败');die;
           }
        }
        /**陵园景观**/
        $picSetting = array
            (
                'limit'       =>  20,
                'type'        =>  array('jpg','png','gif'),
                'iswatermark' =>  true
            );

          // 省份
        $area = M('area')->where(array('area_type'=>1))->select();
        $this->assign('area',$area); #省份
          // 省份
        $this->assign('picsetting', base64_encode(serialize($picSetting)));


        $this->assign('form',$form);
        $this->display('memorial/cemetery/add');
    }

    /**
     * 添加时候的陵园风景
     */
    public function addupphotosAction()
    {
        echo  json_encode(123);exit;
    }

    /**
     * 更新基本信息陵园
     */
    public function updateAction()
    {
        if(self::post('submit')){
           if(empty($_POST['title'])) $this->dialog("/memorial/cemetery/update",'error','陵园名称不能为空');
            $page = $this->getParams('page');
            $id = $this->getParams('id');
            $result = $this->Cemetery->updateCeme();
            if($result){
              admin_log('陵园管理', '更新陵园为：' . self::post('title') . '数据成功');
              $this->dialog("/memorial/cemetery/update/id/{$id}/page/{$page}",'success','编辑陵园成功');die;
           }else{
              $this->dialog("/memorial/cemetery/update/id/{$id}/page/{$page}",'error','编辑陵园失败');die;
           }
        }else{
            $id = $this->getParams('id');
            $updata = $this->Cemetery->getDataById($id);

            //获取省市信息
              $area = M('area')->where(array('area_type'=>1))->select();
              // 市
              $originInfo = array();
                if($updata['updata']['province']){
                    $originInfo = M('area')->where(array('parent_id'=>$updata['updata']['province']))->select();
              }
            //获取省市信息

            $picSetting = array
            (
                'limit'       =>  20,
                'type'        =>  array('jpg','png','gif'),
                'iswatermark' =>  true
            );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->assign('updata', $updata['updata']);
            $this->assign('originInfo',$originInfo); #市区
            $this->assign('area', $area);
            $this->assign('photo', $updata['photo']);
            $this->assign('id', $id);
            $this->display('memorial/cemetery/update');
        }
    }

    /**
     * 异步删除陵园logo
     */
    public function delpicAction()
    {
        $id = $this->getParams("id");
        $map = array(
            'id'=>$id
            );
        $up = array(
          'photo_url'=>''
          );
        $result = M('memorial_cemetery2')->update($map, $up);
        if($result){
            admin_log('墓地管理相册', '删除id为：' . $id . '数据成功');
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'删除成功'));exit;
        }else{
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'删除失败'));exit;

        }
    }

    /**
     * 陵园 - 删除
     */
    public function deleteAction()
    {
        $id = $this->getIds("id");

        $page = $this->getParams('page');
        $title = $this->getParams('title');
        $where = array(
        'in'=>array('id'=>$id),
        );
      $rs = M('memorial_cemetery2')->delete($where);
      if ($rs) {
        admin_log('陵园管理', '删除陵园为：' . $title . '数据成功');
        $this->dialog("/memorial/cemetery/lists/page/{$page}",'success','操作成功');exit;
      } else {
        $this->dialog("/memorial/cemetery/lists/page/{$page}",'error','操作失败');exit;
      }
    }


    /**
     * 关于陵园
     */
    public function aboutAction()
    {
      if(self::post('submit')){
        $insertData = array();
        $insertData['summary'] = trim(self::post('summary'));
        $insertData['honor'] = trim(self::post('honor'));
        $insertData['culture'] = trim(self::post('culture'));
        $id = trim(self::post('id'));

        // 能否找到当前信息
        $result = M('memoriald_cemetery_culture')->where(array('id'=>$id))->getOne();
        if($result == NULL){
          $result = M('memoriald_cemetery_culture')->create($insertData);
          if($result){
            admin_log('关于陵园', '添加id为：' . $id . '数据成功');
             $this->dialog("/memorial/cemetery/about/id/{$id}",'success','操作成功');die;
           }else{
             $this->dialog("/memorial/cemetery/about/id/{$id}",'error','操作失败');die;
           }

        }
        if($result){
          $map = array(
            'id'=>$id
            );
          $result = M('memoriald_cemetery_culture')->update($map, $insertData);
          if($result){
            admin_log('关于陵园', '编辑id为：' . $id . '数据成功');

             $this->dialog("/memorial/cemetery/about/id/{$id}",'success','操作成功');die;
           }else{
             $this->dialog("/memorial/cemetery/about/id/{$id}",'error','操作失败');die;
           }
        }

      }else{
        $id = $this->getParams('id');
        $data = M('memoriald_cemetery_culture')->where(array('id'=>$id))->getOne();
        $this->assign('id', $id);
        $this->assign('data', $data);
        $this->display('memorial/cemetery/about');
      }
    }


    /**
     * 陵园景观
     */
    public function sceneryAction()
    {
      $id = $this->getParams('id');
      if(self::post('submit')){
        $id = self::post('id');
        $result = $this->Cemetery->sceneryUp($id);

        if($result){
             admin_log('陵园景观', '添加陵园景数据成功');
             $this->dialog("/memorial/cemetery/scenery/id/{$id}",'success','编辑陵园景观成功');die;
           }else{
             $this->dialog("/memorial/cemetery/scenery/id/{$id}",'error','编辑陵园景观失败');die;
        }

      }else{
        $map = array(
          'pid'=>$id
          );
        $photo = M('memorial_cemetery2_photo')->where($map)->select();
        $picSetting = array
            (
                'limit'       =>  20,
                'type'        =>  array('jpg','png','gif'),
                'iswatermark' =>  true
            );
        $this->assign('picsetting', base64_encode(serialize($picSetting)));
        $this->assign('photo', $photo);
        $this->assign('id', $id);
        $this->display('memorial/cemetery/scenery');
      }
    }

    /**
     * 陵园景观 - 删除
     */
    public function sceneryDelAction()
    {
        $id = $this->getParams("id");
        $map = array(
            'id'=>$id
            );
        $result = M('memorial_cemetery2_photo')->delete($map);
        if($result){
            admin_log('删除陵园景观', '删除id为：' . $id . '数据成功');
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'删除成功'));exit;
        }else{
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'删除失败'));exit;

        }
    }


    /**
     * 陵园服务
     */
    public function serverAction()
    {
      $id = $this->getParams('id');
      if(self::post('submit')){
        $insertData = array();
        $insertData['server'] = $this->getParams('server');
        $map = array(
          'id'=>$id
          );
        $result = M('memoriald_cemetery_culture')->update($map, $insertData);
        if($result){
            admin_log('更新陵园服务', '更新id为：' . $id . '数据成功');
            $this->dialog("/memorial/cemetery/server/id/{$id}",'success','操作成功');die;
          }else{
             $this->dialog("/memorial/cemetery/server/id/{$id}",'error','操作失败');die;
        }
      }else{
         $data = M('memoriald_cemetery_culture')->where(array('id'=>$id))->getOne();
         $this->assign('data', $data);
         $this->assign('id', $id);
         $this->display('memorial/cemetery/server');
      }
    }

    /**
     * 生成地图
     */
    public function mapAction()
    {
      $id = $this->getParams('id');
      if(self::post('submit')){
        $insertData = array();
        $insertData['map_name'] = $this->getParams('map_name');
        $map = array(
          'id'=>$id
          );
        $result = M('memorial_cemetery2')->update($map, $insertData);
        if($result){
            admin_log('更新陵园地图', '更新地图名称：'.$insertData['map_name'].'数据成功');
            $this->dialog("/memorial/cemetery/map/id/{$id}",'success','操作成功');die;
          }else{
             $this->dialog("/memorial/cemetery/map/id/{$id}",'error','操作失败');die;
        }
      }
      $data = M('memorial_cemetery2')->where(array('id'=>$id))->getOne();
      $this->assign('data', $data);
      $this->assign('id', $id);
      $this->display('memorial/cemetery/map');
    }


    /**
     * 陵园资讯
     */
    public function newsAction()
    {
        //获取所有陵园
        $lists = M('memorial_cemetery2')->field('id, title')->select();
        // 添加陵园资讯
        self::$modelid2 = self::$modelid2 ? self::$modelid2 : 0;
        $ContentForm2 = new ContentForm(self::$modelid2);
        $form2 = $ContentForm2->get();
        $urlArr = array(
              'addsaveUrl' => $this->createUrl('content/Content/addsave/mid/'.self::$modelid2),
              'indexUrl'=>$this->createUrl('/content/Content/index/page/'.self::$modelUrl)
            );
        // foreach ($form2 as $key => $value) {
        //   if($key =='categoryid'){
        //     unset($form2[$key]);
        //   }
        // }
        $this->assign('lists',$lists);
        $this->assign('urlArr',$urlArr);
        $this->assign('form2',$form2);
        $this->display('memorial/cemetery/news');
    }



}