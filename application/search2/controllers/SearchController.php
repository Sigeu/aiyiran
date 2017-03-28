<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * Search.php
 *
 * 前台搜索控制器类
 *
 * @author     冯阳<fengyang@mail.b2b.cn>   2013-9-27 下午3:38:31
 * @filename   ContentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SearchController extends HomeController {
    public  $searchModel;
    public function init()
    {
        $this->searchModel = D('Search');
        error_reporting(E_ALL & ~E_NOTICE);
    
        parent::init();
    }
    
     /**
     * 名字搜索
     */
    public function inputAction()
    {
         if(isset($_POST['text'])){
             $text = Controller::post('text');
             $type = Controller::post('type');
             $catid = Controller::post('catid');
//             echo $text;die;
            if($type){
                $data = $this->searchModel->input($text, $type, $catid);
                
                if($data){
                    $persontype = get_config('common','person_type_admin','home'); //获取纪念馆类型
                    foreach($data as $key => $value){
                        if($value['persontype']!="" && $value['persontype'] !=null){
                            $data[$key]['persontype_name'] = $persontype[$value['persontype']];
                        }else{
                            $data[$key]['persontype_name'] = '暂无所属类型';
                        }
                        if($value['userpic']=="" or $value['userpic']==null){
                            $data[$key]['userpic'] = "/template/default/member/images/default_max.png";
                        }
                    }
                    echo json_encode(array('status'=>1, 'code'=>'success', 'data'=>$data));exit;
                }else{
                    echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'对不起，没有搜索到相关信息'));exit;
                }
            }else{
                echo "请输入搜索内容";exit;
            }
        }
        $zimu = get_config('common','zimu','home');
       // include $this->display('index_private.html');
    }
    

    /**
     * 名人纪念馆表单名字搜索
     */
    public function celebrityAction()
    {
         if(isset($_POST['text']) && !empty($_POST['text'])){
             $text = trim($_POST['text']);
             $type = Controller::post('type');
             $catid = Controller::post('catid');
            if($text){
                $data = $this->searchModel->celebrity($text, $type, $catid);
                foreach($data as $key => $value){
                   $data[$key]['brithdates'] = substr(date('Y-m-d', $value['brithdate']),0,10);
                   $data[$key]['brithdate'] = substr(date('Y-m-d', $value['brithdate']),0,4);
                   $data[$key]['dieddate'] = substr(date('Y-m-d', $value['dieddate']),0,4);
                   $data[$key]['descript'] = mb_substr($value['descript'], 0, 32, 'utf-8');
                     if($value['userpic']=="" or $value['userpic']==null){
                            $data[$key]['userpic'] = "/template/default/member/images/default_max.png";
                        }
                }
                if($data){
                    echo json_encode(array('status'=>1, 'code'=>'success', 'data'=>$data));exit;
                    // echo $this->dialog("/memorial/acer/index",'success','操作成功');exit();
                }else{
                    echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'对不起，没有搜索到相关信息'));exit;
                }
            }
        }
    }

    /**
     * 搜索框搜索 名字
     */


    public function areaAction(){
       $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
       $area = M('area')->where(array('parent_id'=>$mid))->select();
       if($area){
         echo json_encode(array('status'=>1,'data'=>$area)); exit();
       }else{
         echo json_encode(array('status'=>2,'data'=>'数据没找到')); exit();
       }
     }
}
