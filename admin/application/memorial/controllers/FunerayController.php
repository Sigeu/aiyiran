<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryController.php
 *
 * 陵园管理控制器类
 *
 * @author     月下追魂 <youkaili@mail.b2b.cn>   2016年12月12日18:11:06
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
class FunerayController extends AdminController {

    public function init()
    {

    }

    //用品分类
    public function categoryAction()
    {
        $where = array();

        $count = M('memorial_funeray_cate')->findCount($where);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('memorial_funeray_cate')->select($options);
        // 分页end

        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign("list", $list);

        $this->display('memorial/funeray/category');
    }

    //添加分类
    public function addcategoryAction()
    {
        if(!empty($_POST)){
            $data = array();
            $data['cate'] = Controller::post('cate');
             // 图片上传
            if(isset($_POST['accessory'])){
               $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
               $pic = current($pic);
               $data['pic'] = '/static/uploadfile/style/'.$pic['path'];
            }
            if($data['cate']==""){
                $this->dialog("/memorial/funeray/category",'error','请填写分类名称');
            }
            $result = M('memorial_funeray_cate')->create($data);
            if($result){
                $this->dialog("/memorial/funeray/category",'success','操作成功');
            }else{
                $this->dialog("/memorial/funeray/category",'error','操作失败');
            }
        }else{
                $picSetting = array(
                    'limit'       =>  20,
                    'type'        =>  array('jpg','png','gif'),
                    'iswatermark' =>  true
                );
                $this->assign('picsetting', base64_encode(serialize($picSetting)));
                $this->display('memorial/funeray/addcategory');
            }
    }

    //修改分类
    public function categoryupdateAction()
    {
        if(!empty($_POST)){
            $data = array();
            $id = Controller::post('id');
            $data['cate'] = Controller::post('cate');

             // 图片上传
            if(isset($_POST['accessory'])){
               $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
               $pic = current($pic);
               $data['pic'] = '/static/uploadfile/style/'.$pic['path'];
            }
            $result = M('memorial_funeray_cate')->update(array('id'=>$id), $data);
            if($result){
                $this->dialog("/memorial/funeray/category",'success','操作成功');
            }else{
                $this->dialog("/memorial/funeray/category",'error','操作失败');
            }
        }else{
            $id = Controller::get('id');
            $find = M('memorial_funeray_cate')->where(array('id'=>$id))->getOne();
            $this->assign('find', $find);
            $picSetting = array(
                    'limit'       =>  20,
                    'type'        =>  array('jpg','png','gif'),
                    'iswatermark' =>  true
            );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->display('memorial/funeray/categoryupdate');
        }
    }

    //分类删除
    public function delcateAction()
    {
        $id = $this->getIds("id");
        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_funeray_cate')->delete($where);
        if($result){
            $this->dialog("/memorial/funeray/category",'success','操作成功');
            exit;

        }else{
            $this->dialog("/memorial/funeray/category",'error','操作失败');
            exit;
        }
    }

    //添加商品
    public function addAction()
    {
        if(!empty($_POST)){

            $data = array();
            $data['gname'] = Controller::post('gname');
            $data['price'] = Controller::post('price');
            $data['gtime'] = Controller::post('gtime');
            $data['cid'] = Controller::post('cid');
             // 图片上传
            if(isset($_POST['accessory'])){
               $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
               $pic = current($pic);
               $data['pic'] = '/static/uploadfile/style/'.$pic['path'];
            }

            if($data['cid']==""){
                $this->dialog("/memorial/funeray/lists",'error','请选择商品分类');
            }
            $result = M('memorial_funeray_goods')->create($data);
            if($result){
                $this->dialog("/memorial/funeray/lists",'success','操作成功');
            }else{
                $this->dialog("/memorial/funeray/lists",'error','操作失败');
            }

        }else{
             //获取商品分类
            $cate = M('memorial_funeray_cate')->select();
            $this->assign('cate', $cate);

            $picSetting = array(
                    'limit'       =>  20,
                    'type'        =>  array('jpg','png','gif'),
                    'iswatermark' =>  true
                );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->display('memorial/funeray/add');
        }
    }

    //商品列表
    public function listsAction()
    {
        $where = array();
        $count = M('memorial_funeray_goods')->findCount($where);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $list = M('memorial_funeray_goods')->select($options);
        // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);

        //获取分类
        $cate = M('memorial_funeray_cate')->select();
        foreach ($cate as $key => $value) {
            foreach ($list as $k => $v) {
                if($v['cid']==$value['id']){
                    $list[$k]['cat_name'] = $value['cate'];
                }
            }
        }

        $this->assign("list", $list);

        $this->display('memorial/funeray/lists');
    }

    //商品修改
    public function goodsupdateAction()
    {
        if(!empty($_POST)){
            $data = array();
            $data['id'] = Controller::post('id');
            $data['gname'] = Controller::post('gname');
            $data['cid'] = Controller::post('cid');
            $data['gtime'] = Controller::post('gtime');
              // 图片上传
            if(isset($_POST['accessory'])){
               $pic = moUploadAccessory(array('file'=>$_POST['accessory'],'folder'=>'style','time_name'=>true));
               $pic = current($pic);
               $data['pic'] = '/static/uploadfile/style/'.$pic['path'];
            }
            $result = M('memorial_funeray_goods')->update(array('id'=>$data['id']), $data);
            if($result){
                $this->dialog("/memorial/funeray/lists",'success','操作成功');
            }else{
                $this->dialog("/memorial/funeray/lists",'error','操作失败');
            }
        }else{
            $id = Controller::get('id');
            $find = M('memorial_funeray_goods')->where(array('id'=>$id))->getOne();
            $cate = M('memorial_funeray_cate')->select();
            $this->assign('find', $find);
            $this->assign('cate', $cate);
            $picSetting = array(
                    'limit'       =>  20,
                    'type'        =>  array('jpg','png','gif'),
                    'iswatermark' =>  true
            );
            $this->assign('picsetting', base64_encode(serialize($picSetting)));
            $this->display('memorial/funeray/goodsupdate');
        }
    }

    //商品删除
    public function goodsdelAction()
    {
        $id = $this->getIds("id");
        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_funeray_goods')->delete($where);
        if($result){
            $this->dialog("/memorial/funeray/lists",'success','操作成功');
            exit;

        }else{
            $this->dialog("/memorial/funeray/lists",'error','操作失败');
            exit;
        }
    }   
}