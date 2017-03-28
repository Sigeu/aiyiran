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
 * <br>wake1  2016-11-03 上午18:17:56 创建此文件
 *
 * @author     wake1 2016年11月3日18:18:08

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
class AcerController extends AdminController {

    public $obj; 
    public function init()
    {

        $this->obj = M("memorial_acer");
    }

    /**
     * 元宝钱币管理 - 列表
     */
    public function indexAction()
    {
        $where = array();

        // 分页star
        $count = $this->obj->findCount($where);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = $this->obj->select($options);
        // 分页end

        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign("list", $list);
        $this->display('memorial/acer/index');    
    }

    /**
     * 元宝管理 - 添加
     */
    public function addAction()
    {
        // 统计已添加的规则
        $count = $this->obj->findCount();
        if($count >= 5){
            $this->dialog("/memorial/acer/index",'error','规则数量已超过5个');
        }
        if(!empty($_POST))
        {
            $data = array(
                'money'=>$this->getParams('money'),
                'acer'=>$this->getParams('acer'),
                'sort'=>$this->getParams('sort')
                );
            $result = $this->obj->create($data);
            if($result)
            {
                admin_log('添加规则','添加元宝钱币规则');
                $this->dialog("/memorial/acer/add",'success','操作成功');
            }
        }else{
            $this->display('memorial/acer/add');
        }
    }

    /**
     * 元宝管理 - 删除
     */
    public function deleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = $this->obj->delete($where);
        if($result){
            admin_log('元宝钱币管理', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/acer/index/page/{$arr['page']}",'success','删除成功');
            exit;

        }else{
            $this->dialog("/memorial/acer/index/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 元宝管理 - 修改
     */
    public function updataAction()
    {
        if(!empty($_POST)){
            $id = $_POST['id'];
            $data = array(
                'money'=>$this->getParams('money'),
                'acer'=>$this->getParams('acer'),
                'product_name'=>$this->getParams('product')
                );
        $result = $this->obj->update(array('id'=>$id), $data);

        if($result){
            admin_log('编辑元宝钱币管理','编辑id为：'.$id."祭祀模板风格");
            echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'修改成功'));exit;
            // echo $this->dialog("/memorial/acer/index",'success','操作成功');exit();
        }else{
            echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'修改失败'));exit;
        }

        }    

    }

    /**
     * 模板风格列表
     */
    public function stylelistAction()
    {
        $where = array();

        // 分页star
        $count = M('memorial_style')->findCount($where);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('memorial_style')->select($options);
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign("list", $list);
        $this->display('memorial/acer/stylelist');
    }

    /**
     * 添加模板风格
     */
    public function styleaddAction()
    {
        if(!empty($_POST)){
           $data = array();
           $data['name'] = trim(self::post('name'));
           $data['free'] = self::post('price') ? intval(trim(self::post('free'))) : 1;
           $data['price'] = $data['free'] == 1 ? 0 : floatval(self::post('price'));
           $data['sort'] = intval(self::post('sort'));

           // 图片上传
           if(isset($_POST['accessory'])){
               $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
               $pic = current($pic);
               $data['pic'] = '/style/'.$pic['path'];
            }
         $rs = M('memorial_style')->create($data);
         if($rs){
            admin_log('添加祭祀模板风格','添加'.$data['name']."墓铭志");
           $this->dialog("/memorial/moreset/style",'success','操作成功');
         }else{
            $this->dialog("/memorial/moreset/style",'error','操作失败');
         }

        }else{
        $picSetting = array
        (
            'limit'       =>  20,
            'type'        =>  array('jpg','png','gif'),
            'iswatermark' =>  true
        );
        $this->assign('picsetting', base64_encode(serialize($picSetting)));
        $this->display('memorial/acer/styleadd');
        }
    }

    /**
     * 模板风格修改
     */
    public function styleupdateAction()
    {
        if(!empty($_POST)){

        }else{
            $id = $this->getParams('id');
            $arr['page'] = $this->getParams('page');

            $map = array(
                'id'=>$id
                );
            $findData = M('memorial_style')->where($map)->getOne();
            $this->assign('arr', $arr);
            $this->assign('findData',$findData);
            $this->display('memorial/acer/styleupdate');
        }
        return;
    }

    /**
     * 相册管理 - 列表
     */
    public function photoAction()
    {
        // 首页过来的未审核数据
        if(isset($_GET['status'])){
            $where = array();
            $sql =("SELECT p.id, c.name AS cname, cover, uid, photo, status, p.name AS pname FROM 
                `mo_memorial_photocat` AS c INNER JOIN 
                `mo_memorial_photo` AS p ON c.id = p.pid where `status` = 0");
            $data = joinres($sql);
            $count = count($data);
            $pagesize = 20;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $where;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $this->assign('pageStr', $pagestr);
            $this->assign('page', $currpage);
            $this->assign('list', $data);
            $this->display('memorial/acer/photo');
        }else{
            $where = array();
            $sql =("SELECT p.id, c.name AS cname, cover, uid, photo, status, p.name AS pname FROM 
                `mo_memorial_photocat` AS c INNER JOIN 
                `mo_memorial_photo` AS p ON c.id = p.pid");
            $data = joinres($sql);
            $count = count($data);
            $pagesize = 20;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $where;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $this->assign('pageStr', $pagestr);
            $this->assign('page', $currpage);
            $this->assign('list', $data);
            $this->display('memorial/acer/photo');
        }
    }
    /**
     * 添加相册分类
     */
    public function photocataddAction()
    {
        if(isPost()){
            if(empty($_POST['name'])){
                $this->dialog("/memorial/acer/photo",'error','数据填写错误请重新填写');
            }
            $data = array();
            $data['name'] = $_POST['name'];
            $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
          if($accessory){
            $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'js_photo','time_name'=>false));
            $data['cover'] = $upload_info ? (isset($upload_info[0]['path']) ? '/js_photo/'.$upload_info[0]['path'] : ''  )  : '';
          }
          $result = M('memorial_photocat')->create($data);
          if($result){
                admin_log('相册管理','添加'.$data['name']."相册分类成功");
                $this->dialog("/memorial/acer/photo",'success','操作成功');
            }else{
                $this->dialog("/memorial/acer/photo",'error','操作失败');
            }
        }else{
            $picSetting = array
            (
                'limit'       =>  20,
                'type'        =>  array('jpg','png','gif'),
                'iswatermark' =>  true
            );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->display('memorial/acer/photocatadd');
        }
    }

    /**
     * 上传照片
     */
    public function photoaddAction()
    {
        if(isPost()){
            if(empty($_POST['name'])){
                $this->dialog("/memorial/acer/photoadd",'error','数据填写错误请重新填写');
            }
            $data = array();
            $data['name'] = $this->getParams('name');
            $data['pid'] = $this->getParams('pid');

            $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
            if($accessory){
                $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'js_photo2','time_name'=>false));
                  foreach ($upload_info as $key => $value) {
                    $data['photo'] = '/js_photo2/' . $value['path'];
                     $result= M('memorial_photo')->create($data);
                }
            }

            // 是否审核
            $isAudit = M('memorial_audit')->where(array('audit_name'=>'mo_memorial_photo'))->getOne();
            // 不开启审核就是通过
            if($isAudit['is_audit'] == 2){
                $data['status'] = 1;
            }
          // $result = M('memorial_photo')->create($data);
          if($result){
                admin_log('相册管理','添加'.$data['name']."相册照片成功");
                $this->dialog("/memorial/acer/photo",'success','操作成功');
            }else{
                $this->dialog("/memorial/acer/photo",'error','操作失败');
            }

        }else{
            $picSetting = array
            (
                'limit'       =>  20,
                'type'        =>  array('jpg','png','gif'),
                'iswatermark' =>  true
            );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));

            $catList = M("memorial_photocat")->select();
            $this->assign('catList', $catList);
            $this->display('memorial/acer/photoadd');
        }
    }

    /**
     * 相册删除 
     */
    public function photodelAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');
        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_photo')->delete($where);
        if($result){
            admin_log('相册管理', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/acer/photo/page/{$arr['page']}",'success','删除成功');
            exit;

        }else{
            $this->dialog("/memorial/acer/photo/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 相册修改
     */
    public function photoupdateAction()
    {
        if(isPost()){
            $data = array();
            $data['id'] = $this->getParams('id');
            $data['name'] = $this->getParams('name');
            $data['pid'] = $this->getParams('pid');

            $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
            if($accessory){
                $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'js_photo2','time_name'=>false));
                $data['photo'] = $upload_info ? (isset($upload_info[0]['path']) ? '/js_photo2/'.$upload_info[0]['path'] : ''  )  : '';
            }
            $map = array(
                'id'=>$data['id']
                );
            $result = M('memorial_photo')->update($map, $data);
            if($result){
                admin_log('相册管理', '编辑：' . $data['name'] . '数据成功');
                $this->dialog("/memorial/acer/photo",'success','编辑成功');
                exit;
            }else{
                $this->dialog("/memorial/acer/photo",'error','编辑失败');
                exit;
            }
        }else{
            $id = $this->getIds('id');
            $map = array(
                'id'=>$id
                );
            //获取当前照片
            $data = M('memorial_photo')->getOne($map);
            $this->assign('findData', $data);

            //获取所有照片分类
            $cat = M('memorial_photocat')->select();
            $this->assign('cat', $cat);

            $picSetting = array
                (
                    'limit'       =>  20,
                    'type'        =>  array('jpg','png','gif'),
                    'iswatermark' =>  true
                );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->display('memorial/acer/photoupdate');
        }
    }

    /**
   * 相册管理审核 - 通过
   */
    public function passAction()
      {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_photo')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
   * 相册管理审核 - 不通过
   */
    public function nopassAction()
      {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_photo')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 列表预览
     */
        public function yulanAction()
      {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_photo')->getOne($map);
          if($result){
              echo json_encode(array('status'=>1, 'data'=>$result, 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'data'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    public function photoinfoAction()
    {
        $id = $this->getIds('id');
        $map = array(
            'id'=>$id
            );
        $result = M('memorial_photo')->where($map)->select();
        // p($result);die;
        $this->assign('img',$result[0]['photo']);
        $this->assign('name',$result[0]['name']);
        $this->display('memorial/acer/photoinfo');
    }

    
}