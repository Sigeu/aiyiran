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

class MemorialController extends HomeController {

    public $CategoryModel;
    public $person_type;
    public $is_login; //是否登录
    public $nav; //左侧导航
    public $nav_title; //纪念馆左侧大标题
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);

        parent::init();
         if(Session::get('username')==false){
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
        $this->is_login = M('Member')->field('id')->where(array('username'=>Session::get('username')))->getOne();
        if($this->is_login==false){
             $this->is_login = M('Member')->field('id')->where(array('email'=>Session::get('username')))
                                    ->getOne();
             if($this->is_login==false){
                $this->is_login = M('Member')->field('id')->where(array('weibo_uname'=>Session::get('username')))->getOne();
                if($this->is_login==false){
                    $this->showMessage("您还未登录请先登录", '/', 3);die;
                }
             }
        }

        $this->CategoryModel = M('Category');
        $this->person_type = get_config('common','person_type','home'); //纪念类型
        $this->nav = M('memorial_info_left')->where(array('cid'=>1))->
        select(array('limit'=>'0,8')); //左侧导航

        if(Controller::get('mid')){
            //纪念馆左侧大标题
            $this->nav_title = M('memorial')->where(array('id'=>Controller::get('mid')))->getOne();
        }
    }

    //创建纪念馆
    public function createAction()
    {
        $isNav = 2;
        $uid = $this->is_login;
        //判断 session 是否存在用户名检测
        if($this->is_login){
            if(isAjax()){
                $data = array();
                $data['personname'] = Controller::post('personname');
                $data['catid'] = Controller::post('catid');
                $data['name'] = Controller::post('personname');
                $data['is_read'] = Controller::post('is_read');
                $data['style'] = Controller::post('style_id');
                $data['persontype'] = Controller::post('persontype');
                $data['userid'] = $this->is_login['id'];

                //首字母设置写入mysql
                Load::load_class('FirsetPinYin',DIR_BF_ROOT.'classes',0);
                $py = new FirsetPinYin();
                $data['letter'] = $py->getFirstchar($data['name'] );
                //首字母写入结束

                $this->createMessage($data);
                $result = M('memorial')->create($data);
                //创建完纪念馆创建默认相册
                $photo = array();
                $photo['mid'] = $result;
                $photo['name'] = "默认相册";
                $photo['uid'] = $uid['id'];
                $photo['is_default'] = 2; //2是默认相册
                $photo['addtime'] = time();
                M('memorial_photocat')->create($photo);
                //创建个人信息
                $info = array();
                $info['mid'] = $result;
                $info['relationship'] = Controller::post('persontype');
                $info['person'] = Controller::post('personname');
                M('memorial_userinfo')->create($info);
                //创建传记
                $info = array();
                $info['mid'] = $result;
                @M('memorial_biography')->create($info);
                //创建墓志铭立碑人信息管理表主键
                $info = array();
                $info['mid'] = $result;
                @M('memorial_other')->create($info);


                if($result){
                    echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
                }
            }else{
                $person_type = $this->person_type;
                //纪念馆风格
                $type_lists = M('memorial_style')->select();
                include $this->display('member/memorial_view/memorial_create.html');
            }
        }else{
            $this->showMessage("您还未登录请先登录", '/', 3);die;
        }
    }

    //创建纪念馆提示
    public function createMessage($data)
    {
        if(empty($data['personname'])){
            echo json_encode(array('status'=>2, 'msg'=>'逝者姓名不能为空'));exit();
        }
        if(empty($data['catid'])){
            echo json_encode(array('status'=>2, 'msg'=>'请选择纪念馆类型'));exit();
        }

        if($data['is_read']==false){
            echo json_encode(array('status'=>2, 'msg'=>'阅读条款'));exit();
        }
        if(empty($data['style'])){
            echo json_encode(array('status'=>2, 'msg'=>'请选择模板风格'));exit();
        }
        if(empty($data['persontype'])){
            echo json_encode(array('status'=>2, 'msg'=>'请选择与逝者关系'));exit();
        }

    }

     /**
     * 删除纪念馆
     */
    public function delMemorialAction()
    {
        $id = Controller::post('id');
        if(isAjax()){
            $condition = array('id'=>$id);
            $result = M('memorial')->delete($condition);
            if ($result) {
                echo json_encode(array('status' => 1, 'msg' => '删除纪念馆成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'msg' => '删除纪念馆失败'));
                exit();
            }

        }
        return null;
    }



    //我管理的馆
    public function listsAction()
    {
        $isNav = 2;
        $condtion = array(
            'userid'=>$this->is_login['id']
        );
        // 分页star
        $count = M('memorial')->findCount($condtion);
        $pagesize = 12;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condtion;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial')->select($options);
//        p($lists);
//        p($pagestr);
//        p($currpage);
        include $this->display('member/memorial_view/memorial_lists.html');
    }

    //个人资料
    public function infoAction()
    {
        $isNav = 2;

        $sdid =1; //导航选中
        $nav = $this->nav;
        $mid = Controller::get('mid'); //纪念馆id
        $nav_title = $this->nav_title; //左侧标题

        //纪念馆所属
        $m = $this->getMemorial($mid);
        if($m){
            $dataImg = M('memorial')->field('userpic')->where(array('id'=>$mid))->getOne();
            $dataInfo = M('memorial_userinfo')->where(array('mid'=>$mid))->getOne();
            $nation = get_config('common','nation','home'); //民族
            $person_type = get_config('common','person_type','home'); //与逝者关系

            $dataInfo['userpic'] = $dataImg['userpic'];
//            p($dataInfo);die;
            $area = M('area')->where(array('area_type'=>1))->select(); //省份
            $originInfo = array();

            //获取默认时间列表
            $times = $this->getTiemList();
            //出生年月日

            // 默认出生时间戳是0
            if($dataInfo['brithdate']==0){
                $birthYear = date('Y', time());
                $birthMath = date('m', time());
                $birthDay = date('d', time());
            }else{
                $birthYear = date('Y', $dataInfo['brithdate']);
                $birthMath = date('m', $dataInfo['brithdate']);
                $birthDay = date('d', $dataInfo['brithdate']);
            }
            //逝世年月日
            if($dataInfo['dieddate']==0){
                $diedYear = date('Y', time());
                $diedMath = date('m', time());
                $diedDay = date('d', time());
            }else{
                $diedYear = date('Y', $dataInfo['dieddate']);
                $diedMath = date('m', $dataInfo['dieddate']);
                $diedDay = date('d', $dataInfo['dieddate']);
            }

            //籍贯省份循环市区
            if($dataInfo['originp']){
                $originInfo = M('area')->where(array('parent_id'=>$dataInfo['originp']))->select();
            }
            //出生地省份循环市区
            if($dataInfo['brithp']){
                $brithpInfo = M('area')->where(array('parent_id'=>$dataInfo['brithp']))->select();
            }
            //逝世地省份循环市区
            if($dataInfo['diedp']){
                $diedpInfo = M('area')->where(array('parent_id'=>$dataInfo['diedp']))->select();
            }

            //所葬陵园
            $came = M('memorial_cemetery2')->select(array('field'=>'id,title'));
            //墓志铭
            $muzhiming = $this->muzhiming($mid);
            $muzhiming_list = $muzhiming['list']; //列表
            $muzhiming_this = $muzhiming['this']; //当前墓志铭
            //获取立碑人信息
            $libeiren = $this->libeiren();
            include $this->display('member/memorial_view/memorial_info.html');
        }else{
            echo goback('你没有此纪念馆的查看权限');
        }
    }

    public function areaAction(){
       $mid = isset($_GET['id']) ? intval($_GET['id']) : 0 ;
       $area = M('area')->where(array('parent_id'=>$mid))->select();
        echo json_encode($area);exit();
     }

    //获取当前用户拥有的纪念馆
    public function getMemorial($mid)
    {
        $isNav = 2;

        //传进来的纪念馆id
        $mid = Controller::get('mid');
        if($mid){
            $condtion = array(
                'userid'=>$this->is_login['id']
            );
            //用户所属的纪念馆id
            $memorial_user = M('memorial')->field('id')->where($condtion)->select();
            $ids = array();
            $ids = $this->i_array_column($memorial_user, 'id');
            if(in_array($mid,$ids)){
                return true;
            }else{
                return false;
            }
        }else{
            echo goback('访问错误');
        }

    }

    //合并函数
    public function i_array_column($input, $columnKey, $indexKey=null){
        if(!function_exists('array_column')){
            $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
            $indexKeyIsNull            = (is_null($indexKey))?true :false;
            $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
            $result                         = array();
            foreach((array)$input as $key=>$row){
                if($columnKeyIsNumber){
                    $tmp= array_slice($row, $columnKey, 1);
                    $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
                }else{
            $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
        }
        if(!$indexKeyIsNull){
            if($indexKeyIsNumber){
                $key = array_slice($row, $indexKey, 1);
                $key = (is_array($key) && !empty($key))?current($key):null;
                $key = is_null($key)?0:$key;
            }else{
                $key = isset($row[$indexKey])?$row[$indexKey]:0;
            }
        }
        $result[$key] = $tmp;
        }
        return $result;
        }else{
            return array_column($input, $columnKey, $indexKey);
        }
    }

    //获取时间列表
    public function getTiemList()
    {
        $times = array();
        $y = date('Y', time());
        $times['year'] = range(1, $y);
        $times['year'] = array_reverse($times['year']);
        $times['math'] = range(1, 12);
        $times['day'] = range(1, 32);
        return $times;
    }

    //获取所有墓志铭
    public function muzhiming($mid)
    {
        $muzhiming = array();
        $muzhiming['list'] = M('memorial_mumingzhi')->where(array('status'=>1))->select();
        $muzhiming['this'] = M('memorial_other')->where(array('mid'=>$mid))->getOne();
        return $muzhiming;
    }

    //获取所有立碑人信息
    public function libeiren()
    {
        return $muzhiming = M('memorial_steleauthor')->where(array('status'=>1))->select();
    }

    //更新个人信息
    public function updateinfoAction()
    {

        if(isAjax()) {
            $data = array();
            $mid = Controller::post('mid'); //纪念馆id
            $memorial = array();
            //上传头像
            if(!empty($_FILES['userpic']['tmp_name'])){
                Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
                $up = new Upload();
                $up->uploadPath = 'static/uploadfile/member_info';
                $filename = $up->fileUpload($_FILES['userpic']);
                if($filename==false){
                    $message = $up->getStatus();
                    echo json_encode($message);exit();
                }
                $memorial['userpic'] = '/' . $filename;
                M('memorial')->update(array('id' => $mid), $memorial); //修改头像
            }
            //上传头像结束

            //上传头像结束
            $data['person'] = Controller::post('person');
            $data['sex'] = Controller::post('sex');
            $data['nation'] = Controller::post('nation');
            $data['originp'] = Controller::post('originp');
            $data['originc'] = Controller::post('originc');
            $data['origind'] = Controller::post('origind');
            $data['careers'] = Controller::post('careers');
            $data['relationship'] = Controller::post('relationship');
            $data['brith'] = Controller::post('brith'); //生辰：公元
            
            //新增明文 出身日期 和明文实施日期==========================================
            $data['m_year'] = Controller::post('brith_year');
            $data['m_month'] = Controller::post('brith_math');
            $data['m_day'] = Controller::post('brith_day');
    
            $data['d_year'] = Controller::post('died_year');
            $data['d_month'] = Controller::post('died_math');
            $data['d_day'] = Controller::post('died_day');
            //新增明文 出身日期 和明文实施日期==========================================

            //组合时间戳
            $brith_year = Controller::post('brith_year'); //生成：年
            $brith_math = Controller::post('brith_math'); //生成：月
            $brith_day = Controller::post('brith_day'); //生成：日
            $data['brithdate'] = strtotime("$brith_year-$brith_math-$brith_day"); //出生时间戳

            $data['died'] = Controller::post('died'); //忌日：公元
            $died_year = Controller::post('died_year'); //生成：年
            $died_math = Controller::post('died_math'); //生成：月
            $died_day = Controller::post('died_day'); //生成：日
            $data['dieddate'] = strtotime("$died_year-$died_math-$died_day"); //逝世时间戳

            $data['brithp'] = Controller::post('brithp'); //出生地：省
            $data['brithd'] = Controller::post('brithd'); //出生地：市
            $data['brithc'] = Controller::post('brithc'); //出生地：地区

            $data['diedp'] = Controller::post('diedp'); //逝世：省
            $data['diedd'] = Controller::post('diedd'); //逝世：市
            $data['diedc'] = Controller::post('diedc'); //逝世：地区

            $data['cemetery'] = Controller::post('cemetery'); //安葬陵园
            $data['descript'] = Controller::post('descript'); //人物介绍

            $other = array();  //存入关联表中
            $other['epitaph'] = Controller::post('epitaph'); //墓志铭
            $other['steleauthor'] = Controller::post('steleauthor'); //立碑人

            $this->userinfoMess($data);//用户信息提示
            $condition = array(
                'mid' => $mid
            );
            M('memorial_other')->update(array('mid' => $mid), $other);
            $result = M('memorial_userinfo')->update($condition, $data);
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '更新信息成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '更新信息失败'));
                exit();
            }
        }
        return null;

    }

    public function userinfoMess($data)
    {
        if(empty($data['person'])){
            echo json_encode(array('status'=>2, 'message'=>'请填写逝者姓名'));exit();
        }

        if(!$data['person']){
            echo json_encode(array('status'=>2, 'message'=>'用户名称填写错误'));exit();
        }
//        if(!$data['sex']){
//            echo json_encode(array('status'=>2, 'msg'=>'性别有误'));exit();
//        }
//        if(!$data['nation']){
//            echo json_encode(array('status'=>2, 'msg'=>'民族有误'));exit();
//        }
//        if(!$data['originp']){
//            echo json_encode(array('status'=>2, 'msg'=>'户籍省市有误'));exit();
//        }
//        if(!$data['originc']){
//            echo json_encode(array('status'=>2, 'msg'=>'户籍城市有误'));exit();
//        }
//        if(!$data['origind']){
//            echo json_encode(array('status'=>2, 'msg'=>'户籍地区有误'));exit();
//        }
//        if(!$data['careers']){
//            echo json_encode(array('status'=>2, 'msg'=>'职业填写有误'));exit();
//        }
//        if(!$data['relationship']){
//            echo json_encode(array('status'=>2, 'msg'=>'请选择与逝者关系'));exit();
//        }

//        if(!$data['cemetery']){
//            echo json_encode(array('status'=>2, 'msg'=>'请填写安葬陵园'));exit();
//        }
//        if(!$data['descript']){
//            echo json_encode(array('status'=>2, 'msg'=>'请填写个人介绍'));exit();
//        }
    }

    //传记管理
    public function biographyAction()
    {
        $isNav = 2;

        $sdid =2; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题

        if($this->getMemorial($mid)){
            //获取数据
            $condition = array(
                'mid'=>$mid
            );
            $info = M('memorial_biography')->where($condition)->getOne();
            include $this->display('member/memorial_view/memorial_biography.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    //修改传记管理
    public function updateBiographyAction()
    {
        $sdid =2; //导航选中
        if(isAjax()){
            $mid = Controller::post('mid'); //纪念馆id
            $data['bioname'] = Controller::post('bioname');
            $data['biocontent'] = Controller::post('biocontent');
            if(empty($data['bioname'])){
                echo json_encode(array('status'=>2, 'msg'=>'请填写传记标题'));exit();
            }
            if(empty($data['bioname'])){
                echo json_encode(array('status'=>2, 'msg'=>'请填写传记内容'));exit();
            }
            $condition = array(
                'mid'=>$mid
            );
            $result = M('memorial_biography')->update($condition, $data);
            if ($result) {
                echo json_encode(array('status' => 1, 'msg' => '更新信息成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'msg' => '更新信息失败'));
                exit();
            }
        }
        return null;
    }

    //祭文列表
    public function eulogyAction()
    {
        $isNav = 2;

        $sdid =4; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题
        $cname = M('memorial_cat')->where(array('name'=>'纪念祭文'))->getOne();
        $catList = M('memorial_cat')->where(array('pid'=>$cname['id']))->select();
        //获取数据列表

        $condition = array(
            'mid'=>$mid
        );
        // 分页star
        $count = M('memorial_eulogy')->findCount($condition);
        $pagesize = 10;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condition;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $lists = M('memorial_eulogy')->select($options);
        if($this->getMemorial($mid)){
            include $this->display('member/memorial_view/eulogy_lists.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    //祭文修改
    public function eulogyUpdateAction()
    {
        $isNav = 2;

        $sdid =4; //导航选中
        if(isAjax()){
            $id = Controller::post('id');
            if($this->getMemorial($mid)){
                $data = array();
                $data['ename'] = Controller::post('ename');
                $data['cid'] = Controller::post('cid');
                $data['econtent'] = Controller::post('econtent');
                if($data['ename']==""){
                    echo json_encode(array('status' => 2, 'msg' => '祭文标题不能为空'));exit();
                }
                if($data['econtent']==""){
                    echo json_encode(array('status' => 2, 'msg' => '祭文内容不能为空'));exit();
                }
                $condition = array(
                    'id'=>$id
                );
                $result = M('memorial_eulogy')->update($condition, $data);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '更新祭文成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '更新祭文失败'));
                    exit();
                }

            }else{
                echo goback("访问错误");die;
            }
        }else{
            $mid = Controller::get('mid'); //纪念馆id
            $nav = $this->nav; //左侧导航
            $nav_title = $this->nav_title; //左侧标题

            $id = Controller::get('id');
            if($this->getMemorial($mid)){
                $condition = array(
                    'id'=>$id
                );
                $info = M('memorial_eulogy')->where($condition)->getOne();
                $cname = M('memorial_cat')->where(array('name'=>'纪念祭文'))->getOne();
                $catList = M('memorial_cat')->where(array('pid'=>$cname['id']))->select();
                if(empty($catList)){
                    $catList = "";
                }
            }else{
               echo json_encode(array('status' => 2, 'msg' => '访问出错'));
                    exit();
            }
            include $this->display('member/memorial_view/eulogy_update.html');
        }
    }

    //纪念祭文添加
    public function eulogyAddAction()
    {
        $isNav = 2;

        $sdid =4; //导航选中
        $islogin = $this->is_login;
        if(isAjax()){
            $id = Controller::post('mid');
                $data = array();
                $data['ename'] = Controller::post('ename');
                $data['cid'] = Controller::post('cid');
                $data['econtent'] = Controller::post('econtent');
                $data['mid'] = Controller::post('mid'); //所属纪念馆
                $data['uid'] = $islogin['id']; //所属会员id
//                $data['createtime'] = time();

                if($data['ename']==""){
                    echo json_encode(array('status' => 2, 'msg' => '祭文标题不能为空'));exit();
                }
                if($data['econtent']==""){
                    echo json_encode(array('status' => 2, 'msg' => '祭文内容不能为空'));exit();
                }

                $result = M('memorial_eulogy')->create($data);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '添加祭文成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '添加祭文失败'));
                    exit();
                }

        }else {
            $mid = Controller::get('mid'); //纪念馆id
            $nav = $this->nav; //左侧导航
            $nav_title = $this->nav_title; //左侧标题

            if ($this->getMemorial($mid)) {
                $cname = M('memorial_cat')->where(array('name' => '纪念祭文'))->getOne();
                $catList = M('memorial_cat')->where(array('pid' => $cname['id']))->select();
                include $this->display('member/memorial_view/eulogy_add.html');
            } else {
                echo goback("你没有此纪念馆的访问权限");
            }
        }
    }

    //纪念祭文 删除
    public function eulogyDelAction()
    {
        if(isAjax()){
            $id = Controller::post('id');
            if($id){
                $condition = array('id'=>$id);
                $result = M('memorial_eulogy')->delete($condition);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '删除祭文成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '删除祭文失败'));
                    exit();
                }
            }
        }else{
            return null;
        }
    }

    //隐私设置
    public function privacyAction()
    {
        $isNav = 2;

        $sdid =5; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题

        if(isAjax()){
            $data = array();
            $data['isshow'] = Controller::post('isshow');
            $id = Controller::post('mid');
            $condition = array(
                'id'=>$id
            );
            $result = M('memorial')->update($condition, $data);
            if ($result) {
                echo json_encode(array('status' => 1, 'msg' => '编辑隐私设置成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'msg' => '编辑隐私设置失败'));
                exit();
            }
        }

        if($this->getMemorial($mid)){
            $info = M('memorial')->field('isshow')->where(array('id'=>$mid))->getOne();
            include $this->display('member/memorial_view/privacy_lists.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    //留言管理列表
    public function messageAction()
    {
        $isNav = 2;

        $sdid =6; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题

        if(isAjax()){
            $id = Controller::post('id');
            if(id){
                $condition = array('id'=>$id);
                $result = M('memorial_comment')->delete($condition);
                if ($result) {
                    echo json_encode(array('status' => 1, 'msg' => '删除留言成功'));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '删除留言失败'));
                    exit();
                }
            }
        }
        if($this->getMemorial($mid)){
            // 分页star
            $condition = array('mid'=>$mid);
            $count = M('memorial_comment')->findCount($condition);
            $pagesize = 12;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $condition;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $lists = M('memorial_comment')->select($options);

            include $this->display('member/memorial_view/message_lists.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    /**
     * 背景音乐
     */
    public function bgmAction()
    {
        $isNav = 2;

        $sdid =7; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题

        if($this->getMemorial($mid)){
            $auto = M('memorial')->field('auto_play')->where(array('id'=>$mid))->getOne();

            $lists = M('memorial_bgmusic')->where(array('userid'=>$_SESSION['front_login_info']['id'], 'mid'=>$mid))->select();

            //获取歌单
            $music = M('memorial_bgmusic')->where(array('userid'=>$_SESSION['front_login_info']['id'], 'is_list'=>1,  'mid'=>$mid))->select();

        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
        include $this->display('member/memorial_view/bgm_lists.html');
    }

    /**
     * 上传背景音乐
     */
    public function upBgmAction()
    {
        if(isPost()){
            $targetFolder = '/static/uploadfile/music'; // Relative to the root
            $verifyToken = md5('unique_salt' . $_POST['timestamp']);

            if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

                $rename_rules = 'time';
                $tempFile = $_FILES['Filedata']['tmp_name'];
                $name = $_FILES['Filedata']['name'];
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
                $targetFile = rtrim($targetFolder,'/') . '/' . time().'_'.mt_rand(1000,9999);

                // Validate the file type_lists
                $fileTypes = array('mp3'); // File extensions
                $fileParts = pathinfo($_FILES['Filedata']['name']);
                //检测文件大小
                if($_FILES['Filedata']['size'] > 20971520){
                    echo json_encode(array('code'=>201, 'errorMsg'=>'文件内容过大'));exit();
                }
                if (in_array($fileParts['extension'],$fileTypes)) {
                    move_uploaded_file($tempFile, $_SERVER['DOCUMENT_ROOT'].'/'.$targetFile.'.'.$fileParts['extension']);
                    $savepath = $targetFile.'.'.$fileParts['extension'];

                    //获取用户id
                    $is_login = $this->is_login;
                    $uid = $is_login['id'];

                    $data = array();
                    $data['name'] = $name;
                    $data['musicpath'] = $savepath;
                    $data['type'] = 1;
                    $data['status'] = 1;
                    $data['userid'] = $uid;
                    $data['mid'] = Controller::post('mid');
                    if(M('memorial_bgmusic')->create($data)){
                        echo json_encode(array('code'=>200,'savepath'=>$savepath));exit();
                    }else{
                        echo json_encode(array('code'=>201,'网络错误上传失败'));exit();
                    }
                } else {
                    echo json_encode(array('code'=>201,'errorMsg'=>'无效的文件类型。 '));exit();
                }


            }else{
                echo json_encode(array('code'=>201,'errorMsg'=>'token无效 '));exit();
            }

        }

        return null;
    }

    /**
     * 添加至歌单
     */
    public function addMusicListAction()
    {
        $is_login = $this->is_login;
        $uid = $is_login['id'];
        if(isAjax()){
            $id = Controller::post('id');
            $condition = array('id'=>$id, 'userid'=>$uid);
            //先检测歌单是否有内容
            $s = M('memorial_bgmusic')->update(array('userid'=>$uid, 'is_list'=>1), array('is_list'=>2));
            $result = M('memorial_bgmusic')->update($condition, array('is_list'=>1));
            if($result){
                $bgm = M('memorial_bgmusic')->where($condition)->getOne();
                echo json_encode(array('status'=>1, 'data'=>$bgm));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }

    /**
     * 修改背景音乐名称
     */
    public function renameMusicAction()
    {
        $is_login = $this->is_login;
        $uid = $is_login['id'];
        if(isAjax()){
            $id = Controller::post('id');
            $name = Controller::post('name');
            $condition = array('id'=>$id, 'userid'=>$uid);
            $result = M('memorial_bgmusic')->update($condition, array('name'=>$name));
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }

    /**
     * 移除音乐歌单
     */
    public function removeMusicAction()
    {
        $is_login = $this->is_login;
        $uid = $is_login['id'];
        if(isAjax()){
            $id = Controller::post('id');
            $condition = array('id'=>$id, 'userid'=>$uid);
            $result = M('memorial_bgmusic')->update($condition, array('is_list'=>2));
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }

    /**
     * 删除选中歌曲
     */
    public function deleteMusicAction()
    {
        $is_login = $this->is_login;
        $uid = $is_login['id'];
        if(isAjax()){
            $id = Controller::post('id');
            $condition = array('id'=>$id, 'userid'=>$uid);
            $result = M('memorial_bgmusic')->delete($condition);
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }
        }
        return null;
    }


    /**
     * 模板风格列表
     */
    public function styleAction()
    {
        $isNav = 2;

        $sdid =8; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题
        if($this->getMemorial($mid)){
            //获取当前纪念馆的风格
            $info = M('memorial')->field('style')->where(array('id'=>$mid))->getOne();

            $lists = M('memorial_style')->where(array('status'=>1))->select();
            include $this->display('member/memorial_view/style_lists.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    /**
     * 设置模板风格
     */
    public function setStyleAction()
    {
        if(isAjax()){
            $id = Controller::post('id');
            $mid = Controller::post('mid');
            if($id==false){
                echo json_encode(array('status' => 2, 'msg' => '编辑失败1'));exit();
            }
            if($mid==false){
                echo json_encode(array('status' => 2, 'msg' => '编辑失败2'));exit();
            }
            $result = M('memorial')->update(array('id'=>$mid), array('style'=>$id));
            if ($result) {
                    echo json_encode(array('status' => 1));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '设置模板失败'));
                    exit();
            }

        }
        return null;
    }

    /**
     * 相册管理
     */
    public function photoAction()
    {
        $isNav = 2;

        $sdid =9; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题
        $is_login = $this->is_login;
        $uid = $is_login['id'];

        //获取默认相册
        $default = M('memorial_photocat')->where(array('mid'=>$mid,'is_default'=>2))->getOne();

        //获取相册分类列表
        $condition = array('mid'=>$mid,'is_default'=>1);
        $count = M('memorial_photocat')->findCount($condition);
        $pagesize = 12;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $condition;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        $photo_lists = M('memorial_photocat')->select($options);


        if($this->getMemorial($mid)){
            include $this->display('member/memorial_view/photo_lists.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    /**
     * 创建相册
     */
    public function createPhotoAction()
    {
        $isNav = 2;

        $sdid =9; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题
        $is_login = $this->is_login;
        $uid = $is_login['id'];

        if(isAjax()){
            $data = array();
            $data['name'] = Controller::post('name');
            $data['uid'] = $uid;
            $data['mid'] = Controller::post('mid');
            $data['addtime'] = time();
            if($data['name']==""){
                echo json_encode(array('status' => 2, 'message' => '请输入相册名称'));exit();
            }
            if(empty($_FILES['cover']['tmp_name'])){
              echo json_encode(array('status' => 2, 'message' => '请选择上传文件'));exit();
            }
            //上传头像
            Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
            $up = new Upload();
            $up->uploadPath = 'static/uploadfile/member_info';
            $filename = $up->fileUpload($_FILES['cover']);
            if($filename==false){
            $message = $up->getStatus();
              echo json_encode($message);exit();
            }
            //上传头像结束
            $data['cover'] = '/'.$filename; //修改上传路径
            $result = M('memorial_photocat')->create($data);
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '相册分类创建成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '相册分类创建失败'));
                exit();
            }

        }

        if($this->getMemorial($mid)){
            include $this->display('member/memorial_view/photocat_create.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }
    }

    /**
     * 上传照片
     */
    public function photoUploadAction()
    {
        if(isAjax()){
            $data = array();
            $mid = Controller::post('mid');
            $data['name'] = Controller::post('name');
            $data['photo'] = Controller::post('photo');
            $data['pid'] = Controller::post('pid');
            if($mid){
                if($data['name']==""){
                    echo json_encode(array('status' => 2, 'message' => '名称不能为空'));exit();
                }
                if(empty($_FILES['photo']['tmp_name'])){
                    echo json_encode(array('status' => 2, 'message' => '请选择上传文件'));exit();
                }
            }else{
                echo json_encode(array('status' => 2, 'message' => '没权限访问'));
            }
            //上传头像
            Load::load_class('Upload',DIR_BF_ROOT.'classes',0);
            $up = new Upload();
            $up->uploadPath = 'static/uploadfile/member_info';
            $filename = $up->fileUpload($_FILES['photo']);
            if($filename==false){
                $message = $up->getStatus();
                echo json_encode($message);exit();
            }
            //上传头像结束
            $data['photo'] = '/'.$filename; //修改上传路径
            $result = M('memorial_photo')->create($data);
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '照片上传成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '照片上传失败'));
                exit();
            }
        }
        return null;
    }

    /**
     * 修改纪念馆相册属性
     */
    public function updateCateAction()
    {
        if(isAjax()){
            $uid = $this->is_login;
            $uid = $uid['id'];
            $data = array();
            $data['id'] = Controller::post('id');
            $data['name'] = Controller::post('name');
            $data['auth'] = Controller::post('auth');
            $data['uid'] = $uid;
            if($data['name']==""){
                echo json_encode(array('status' => 2, 'message' => '请填写名称'));exit();
            }
            $condition = array('id'=>$data['id']);
            $result = M('memorial_photocat')->update($condition,$data);
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '修改成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '修改失败'));
                exit();
            }

            echo json_encode($_POST);exit;
        }else{
            return null;
        }
    }

    /**
     * 删除相册分类
     */
    public function delPhotoCatAction()
    {
        if(isAjax()){
            $id = Controller::post('id');
            $mid = Controller::post('mid');
            //检测是否有照片
            $isPhoto = M('memorial_photo')->where(array('pid'=>$id))->select();
            //相册里有照片
            if($isPhoto){
//                获取默认相册
                $is_default = M('memorial_photocat')->where(array('mid'=>$mid,'is_default'=>2))->getOne();
                M('memorial_photo')->update(array('pid'=>$id),array('pid'=>$is_default['id']));//修改分类
            }
            //删除相册分类操作
            $result = M('memorial_photocat')->delete(array('id'=>$id));
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '删除成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '删除失败'));
                exit();
            }
        }
        return null;
    }

    /**
     * 刪除照片
     */
    public function delPhotoAction()
    {
        if(isAjax()){
            $id = Controller::post('id');
            //检测是否有照片
            $result = M('memorial_photo')->delete(array('id'=>$id));
            if(count($result)==false){
                echo json_encode(array('status' => 2, 'message' => '删除失敗，未找到照片'));exit();
            }
            if ($result) {
                echo json_encode(array('status' => 1, 'message' => '删除成功'));
                exit();
            } else {
                echo json_encode(array('status' => 2, 'message' => '删除失败'));
                exit();
            }
        }
        return null;
    }

    /**
     * 查看照片列表
     */
    public function photoInfoAction()
    {
        $isNav = 2;

        $sdid =9; //导航选中
        $mid = Controller::get('mid'); //纪念馆id
        $nav = $this->nav; //左侧导航
        $nav_title = $this->nav_title; //左侧标题
        $is_login = $this->is_login;
        $uid = $is_login['id'];

        //如果是默认相册
        if(Controller::get('default')){
            $id = Controller::get('default');
            $condition = array('pid'=>$id);
            $photo_lists = M('memorial_photo')->where($condition)->select();
//            if($uid != $photo_lists[0]['uid']){
//                echo goback('访问错误');
//            }
        }else{
            //相册id
            $id = Controller::get('id');
            $condition = array('pid'=>$id);
            $count = M('memorial_photo')->findCount($condition);
            $pagesize = 12;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from . ',' . $pagesize;
            $options['order'] = 'id desc';
            $options['where'] = $condition;
            $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
            $pagestr = $page->show();
            $photo_lists = M('memorial_photo')->select($options);
        }
        if($this->getMemorial($mid)){
            include $this->display('member/memorial_view/photo_info.html');
        }else{
            echo goback("你没有此纪念馆的访问权限");
        }

    }


    /**
     * 我关注的馆
     */
    public function followAction()
    {
        $isNav = 2;

        $islogin = $this->is_login;
        $uid = $islogin['id'];
        $condition = array(
            'uid'=>$uid
            );
        $follow = M('memorial_follow')->where($condition)->select();
        $mid = array(); //获取所有纪念馆id
        foreach ($follow as $key => $value) {
           $mid[$key] = $value['mid'];
        }
        $str = implode(",", $mid);
        //纪念馆
        $where = array(
            'in'=>array('id'=>$str),
        );
        $follow_info = M('memorial')->where($where)->select();
        include $this->display('member/memorial_view/follow_lists.html');
    }

    //修改音乐播放状态
    public function modMusicAction()
    {
         if(isAjax()){
            $mid = Controller::post('mid');
            $auto = Controller::post('auto');
            if($mid==false){
                echo json_encode(array('status' => 2, 'msg' => '编辑失败1'));exit();
            }
            if($auto==false){
                echo json_encode(array('status' => 2, 'msg' => '编辑失败2'));exit();
            }
            if($auto==1){
                $result = M('memorial')->update(array('id'=>$mid), array('auto_play'=>1));
            }else{
                $result = M('memorial')->update(array('id'=>$mid), array('auto_play'=>2));
            }
            if ($result) {
                    echo json_encode(array('status' => 1));
                    exit();
                } else {
                    echo json_encode(array('status' => 2, 'msg' => '设置模板失败'));
                    exit();
            }

        }
        return null;
    }
}
