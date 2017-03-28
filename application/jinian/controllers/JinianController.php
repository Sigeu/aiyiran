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

class JinianController extends HomeController {
    public $info;
    public $mid;
    public $uid;
    public $guanzhu;
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        parent::init();
        include_once DIR_BF_ROOT."classes/Mypage.php";

        $this->mid = Controller::get('mid');
        $this->uid = $_SESSION['front_login_info']['id'];
        $this->info = M('memorial')->where(array('id'=>$this->mid))->getOne();

         //检测是否已经关注此纪念馆
        $this->guanzhu=M('memorial_follow')->where(array('mid'=>$this->mid,'uid'=>$_SESSION['front_login_info']['id']))->getOne();
        

    }

    //纪念馆首页
    public function indexAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 1;
        //========================= 纪念馆基本信息 ========================================

        // echo "今天:",date('Y-m-d H:i:s'),"<br>";
        // echo "明天:",date('Y-m-d H:i:s',strtotime('+1 day'));

        $mid = $this->mid;
        $info = $this->info; //纪念馆基本信息

        //========================= 隐私判断 ========================================

        //检测头像是否存在
        if($info['userpic']==false){
            $info['userpic'] = "/template/default/member/images/default_min.jpg"; //设置默认头像
        }
        $guanzhu = $this->guanzhu;
        //当前用户我的物品箱子=========================================================================
        $uid = $_SESSION['front_login_info']['id'];
        // if(!$uid){
        //     echo json_encode(array('status'=>2, 'msg'=>'请登录'));exit();
        // }
        $condition = array(
            'uid'=>$uid
            );

        // $mybox = M('memorial_goods_bought')
        //         ->field('m.name, b.id, b.goods_time, b.place, g.*')
        //         ->join(' AS b left join `mo_memorial_funeray_goods` AS g
        //         ON b.goods_id = g.id
        //         LEFT JOIN `mo_memorial` AS m
        //         ON b.mid = m.id')
        //         ->where(array('b.uid'=>$uid))
        //         ->select();

        $option = array('uid'=>$uid);
        //获取本身已经购买上面的数量

        $nums = M('memorial_goods_bought')->findCount($option);
        $pagenum = ceil($nums/6);
        $from = 0;
        $to =  6;
        $limit2 = $from.','.$to;
        $mybox = M('memorial_goods_bought')
                ->field('m.name, b.mid, b.goods_time, b.place, b.id AS goods_id, g.*, b.*')
//                ->field('m.name, b.mid, b.goods_time, b.place, b.id AS goods_id, g.*')
                ->join(' AS b left join `mo_memorial_funeray_goods` AS g
                ON b.goods_id = g.id
                LEFT JOIN `mo_memorial` AS m
                ON b.mid = m.id')->where($option)->limit($limit2)->select();
        
        foreach ($mybox as $key => $value) {
            //已过期
            if($value['goods_time']<time()){
                $mybox[$key]['end_time'] = '已过期';
            }else{
                $mybox[$key]['end_time'] = timediff($value['goods_time'], time());
            }
        }
//        p($mybox);
//        p(time());
//        p($mybox[0]['goods_time']);
//        var_dump(timediff(1487821101, time()));
//
        //计算祭品箱子的摆放纪念堂和过期时间

        //我的物品箱子=========================================================================

        //获取左侧当前用户信息=========================================================================
        $left_info = M('member')->where(array('id'=>$_SESSION['front_login_info']['id']))->getOne();
        if(!$left_info){
            $left_info = false; //如果没有登录的话
        }else{
            if(!$left_info['username']){
                $left_info['username'] = $left_info['email']; //如果没有绑定手机号码，用邮箱显示
            }
            if(!$left_info['user_photo']){
                $left_info['user_photo'] = "/template/default/member/images/default_min.jpg"; //没有头像，使用默认头像
            }
        }

        //进来访问量+1
        update_click('jinian_', $mid, 'memorial', 'click_num', '3600');


//        $sql = "UPDATE `mo_memorial` SET click_num=click_num+1 WHERE id={$this->mid}";
//        mysql_query($sql);
        //========================= 纪念堂已购买祭品展示 ========================================
        $condition = array('uid'=>$_SESSION['front_login_info']['id'],
            'mid'=>$this->mid,
            // 'goods_time'=>
            );
        $times = time();
        $goods = M('memorial_goods_bought')->where("mid=$this->mid AND goods_time>{$times} AND place=1")->select();
        // 歌曲列表
        $getMusicLists = $this->getMusicLists();
        //========================= 纪念馆商品信息 ========================================
        //商品分类
        $goods_list = M('memorial_funeray_cate')->limit(5)->select();

        //全部商品ajax开始
        $goods_all_num = M('memorial_funeray_goods')->findCount(); //总数量
        $goods_all_pagenum = ceil($goods_all_num/6); //一页显示3个
        $goods_all_from = 0;
        $goods_all_to = 6;
        $goods_all_limit = $goods_all_from . ',' . $goods_all_to;
        $goods_all = M('memorial_funeray_goods')->where()->limit($goods_all_limit)->select(); //数据
        //全部商品ajax结束
        $flower = M('memorial_funeray_cate')->select();


        //上香商品ajax开始
        $shang_num = M('memorial_funeray_goods')->findCount(array('cid'=>2)); //总数量
        $shang_pagenum = ceil($shang_num/6); //一页显示一个
        $shang_from = 0;
        $shang_to = 6;
        $shang_limit = $shang_from . ',' . $shang_to;
        $shang = M('memorial_funeray_goods')->where(array('cid'=>2))->limit($shang_limit)->select(); //数据
        //上香商品ajax结束

        //鲜花商品ajax开始
        $xianhua_num = M('memorial_funeray_goods')->findCount(array('cid'=>1)); //总数量
        $xianhua_pagenum = ceil($xianhua_num/6); //一页显示一个
        $xianhua_from = 0;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $xianhua = M('memorial_funeray_goods')->where(array('cid'=>1))->limit($xianhua_limit)->select(); //数据
        //鲜花商品ajax结束

        //点烛ajax开始
        $dian_num = M('memorial_funeray_goods')->findCount(array('cid'=>3)); //总数量
        $dian_pagenum = ceil($dian_num/6); //一页显示一个
        $dian_from = 0;
        $dian_to = 6;
        $dian_limit = $dian_from . ',' . $dian_to;
        $dian = M('memorial_funeray_goods')->where(array('cid'=>3))->limit($dian_limit)->select(); //数据
        //点烛ajax结束

        //祭品ajax开始
        $jiping_num = M('memorial_funeray_goods')->findCount(array('cid'=>4)); //总数量
        $jiping_pagenum = ceil($jiping_num/6); //一页显示一个
        $jiping_from = 0;
        $jiping_to = 6;
        $jiping_limit = $jiping_from . ',' . $jiping_to;
        $jiping = M('memorial_funeray_goods')->where(array('cid'=>4))->limit($jiping_limit)->select(); //数据
        //祭品ajax结束

        //装饰ajax开始
        $zhuangshi_num = M('memorial_funeray_goods')->findCount(array('cid'=>5)); //总数量
        $zhuangshi_pagenum = ceil($zhuangshi_num/6); //一页显示一个
        $zhuangshi_from = 0;
        $zhuangshi_to = 6;
        $zhuangshi_limit = $zhuangshi_from . ',' . $zhuangshi_to;
        $zhuangshi = M('memorial_funeray_goods')->where(array('cid'=>5))->limit($zhuangshi_limit)->select(); //数据
        //装饰ajax结束

 


        //获取纪念馆墓志铭
        $muzhimin = M('memorial_other')->where(array('mid'=>$this->mid))->getOne();

        //获取风格
        $style_id = M('memorial')->field('style')->where(array('id'=>$mid))->getOne();
        $style = M('memorial_style')->where(array('id'=>$style_id['style'],'status'=>1))->getOne();


        //检测纪念馆的音乐是否自动播放
        $auto_play = M('memorial')->field('auto_play')->where(array('id'=>$mid))->getOne();

        //========================= 留言 ========================================
        //留言令牌 [生成一个]
        $set_token = $this->set_token();

        $option = array('mid'=>$mid,'top_id'=>0);
        $nums = M('memorial_comment')->findCount($option);

        /**获取楼层**/
        if(isset($_GET['page']) && $_GET['page'] == 1){
            $floor = 0;
        }else if(isset($_GET['page']) && $_GET['page'] > 1){
            $floor = 7*$_GET['page']-7;
        }else{
            $floor = 0;
        }
        /**获取楼层结束**/

        $page = new Page($nums,7,6);
        $limit = $page->limit();
        $showPage = $page->show(2);
        $lists = M('memorial_comment')->where($option)->order('id desc')->limit($limit)->select();


        $lists = $this->tree($lists);

        //获取用户名
        $f=0;
        foreach ($lists as $key => $value) {
            if($value['uid']){
                $users = M('member')->where(array('id'=>$value['uid']))->getOne();
                if($users['username']){
                    $lists[$key]['username'] = $users['username'];
                }else{
                    $lists[$key]['username'] = $users['email'];
                }
                if($users['user_photo']){
                    $lists[$key]['user_photo'] = $users['user_photo'];
                }else{
                    $lists[$key]['user_photo'] = '/template/default/member/images/default_min.jpg';
                }
            }
            //可视化时间
            if($value['addtime']){
                $lists[$key]['addtime'] = wordTime($value['addtime']);
            }
            //获取楼层
            $lists[$key]['f'] = $floor+=1;
        }
        //获取子留言

        include $this->display('memorial_index.html');
    }

    //我的物品箱子 ajax分页
    public function ajaxjsAction(){
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $uid = $_SESSION['front_login_info']['id'];
        $option = array('uid'=>$uid);
        $from = ($page-1)*6;
        $to =  6;
        $limit2 = $from.','.$to;

        $mybox = M('memorial_goods_bought')
            ->field('m.name, b.mid, b.goods_time, b.place, b.id AS goods_id, g.*')
            ->join(' AS b left join `mo_memorial_funeray_goods` AS g
                ON b.goods_id = g.id
                LEFT JOIN `mo_memorial` AS m
                ON b.mid = m.id')->where($option)->limit($limit2)->select();
        //获取剩余时间
        foreach ($mybox as $key => $value) {
            //已过期
            if($value['goods_time']<time()){
                $mybox[$key]['end_time'] = '已过期';
            }else{
                $mybox[$key]['end_time'] = timediff($value['goods_time'], time());
//                2017/09/20 00:00:00
//                $mybox[$key]['end_time'] = date('Y/m/d H:i:s', $value['goods_time']);
            }
        }
        include $this->display('js_list.html');
    }

    //装饰 ajax分页
    public function zhuangshiAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $zhuangshi = M('memorial_funeray_goods')->where(array('cid'=>5))->limit($xianhua_limit)->select(); //数据

        include $this->display('zhuangshiAjax.html');
    }

    //祭品 ajax分页
    public function jipingAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $jiping = M('memorial_funeray_goods')->where(array('cid'=>4))->limit($xianhua_limit)->select(); //数据

        include $this->display('jipingAjax.html');
    }

    //点烛 ajax分页
    public function dianAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $dian = M('memorial_funeray_goods')->where(array('cid'=>3))->limit($xianhua_limit)->select(); //数据

        include $this->display('dianAjax.html');
    }

    //上香 ajax分页
    public function shangAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $shang = M('memorial_funeray_goods')->where(array('cid'=>2))->limit($xianhua_limit)->select(); //数据

        include $this->display('shangAjax.html');
    }

    //全部商品 ajax分页
    public function goodsAllAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $goods_all = M('memorial_funeray_goods')->where()->limit($xianhua_limit)->select(); //数据

        include $this->display('goodsAllAjax.html');
    }


    //鲜花 ajax分页
    public function xianhuaAjaxAction()
    {
        $mid = Controller::get('mid');
        $page = Controller::get('page');
        $pagenum = Controller::get('pagenum');
        $xianhua_from = ($page-1)*6;
        $xianhua_to = 6;
        $xianhua_limit = $xianhua_from . ',' . $xianhua_to;
        $xianhua = M('memorial_funeray_goods')->where(array('cid'=>1))->limit($xianhua_limit)->select(); //数据

        include $this->display('xianhuaAjax.html');
    }



    //所有商品
    public function goodsAll()
    {
        return $data = M('memorial_funeray_goods')->select();

    }
    public function goodsAll_tplAction()
    {
           // return $data = M('memorial_funeray_goods')->select();

        //获取数据总条数
        if(!$_GET['page']){
            $pages = "0,3";
        }else{
             $pages = "{$_GET['page']},3";
        }
        $nums = M('memorial_funeray_goods')->findCount();
        //引入ajax分页类文件
        include_once "/static/ajaxPage/ajaxPage.class.php";
        $page = new ajaxPage($nums,3); // $m->total('article') 获取 article 表的记录数；10为每页显示十条
        $result = M('memorial_funeray_goods')->limit($pages)->select();
        $arrs = array();
        $arrs['result'] = $result;
        $arrs['page'] = $page->fpage();

        foreach ($arrs['result'] as $key => $value) {
           echo "<li><a href=''><img src='{$value['pic']}' /><a href=''><img src='{$v['pic']}' /><h4>{$v['gname']}</h4><p><span class='fl'>{$v['gtime']}天</span><em class='fr'>{$v['price']}元宝</em></p></a><div class='goods_info'><h3>{$v['gname']}</h3><p>{$v['summary']}</p><span>价格：{$v['price']}元宝</span>
                                <em>时效：{$v['gtime']}天</em>
                            </div></li>";
        }
        print_r($arrs['page']);
    }

    //鲜花商品
    public function xianhua()
    {
    }

    //获取歌曲列表
    public function getMusicLists()
    {
        $uid = $_SESSION['front_login_info']['id'];
        $mid = $this->mid;
        $condition = array(
            'userid'=>$uid,
            'mid'=>$mid,
            'is_list'=>1
        );
        $music = M('memorial_bgmusic')->where($condition)->select();
        return $music;
    }

    //加入关注
    public function caretombAction()
    {
        if($_SESSION['front_login_info']['id']==false){
            echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
        }
        if(Controller::post('mid')){
            $data = array();
            $data['mid'] = Controller::post('mid');
            $data['uid'] = $_SESSION['front_login_info']['id'];
            //检测一下是否已经关注过
            $is=M('memorial_follow')->where($data)->getOne();
            if(is_array($is)){
                echo json_encode(array('status'=>2, 'msg'=>'你已经关注过此纪念馆了'));exit();
            }
            $result = M('memorial_follow')->create($data);
            if($result==false){
                echo json_encode(array('status'=>2, 'msg'=>'关注失败,请稍后重试'));exit();
            }else{
                echo json_encode(array('status'=>1));
            }
        }else{
            echo json_encode(array('status'=>2, 'msg'=>'关注失败'));exit();
        }

    }

    // 取消关注
    public function clearcaretombAction()
    {
        if($_SESSION['front_login_info']['id']==false){
            echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
        }
        if(Controller::post('mid')){
            $data = array();
            $data['mid'] = Controller::post('mid');
            $data['uid'] = $_SESSION['front_login_info']['id'];
            //检测一下是否已经关注过
            $is=M('memorial_follow')->where($data)->getOne();
            if(!is_array($is)){
                echo json_encode(array('status'=>2, 'msg'=>'你还没有关注此纪念馆'));exit();
            }
            $result = M('memorial_follow')->delete($data);
            if($result==false){
                echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
            }else{
                echo json_encode(array('status'=>1, 'msg'=>'操作成功'));exit();
            }

        }else{
            echo json_encode(array('status'=>2, 'msg'=>'操作失败'));exit();
        }
    }

    //简介
    public function introAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 2;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //纪念馆基本信息
          //检测头像是否存在
        if($info['userpic']==false){
            $info['userpic'] = "/template/default/member/images/default_max.png"; //设置默认头像
        }

        //用户信息
        $desc = M('memorial_userinfo')->where(array('mid'=>$mid))->getOne();
        $desc['brithdate']; //出生
        $desc['dieddate']; //死亡
        //籍贯获取省市
        $sheng = M('area')->where(array('area_id'=>$desc['originp']))->getOne();
        $shi = M('area')->where(array('area_id'=>$desc['originc']))->getOne();

        //出生地省市
        $sheng2 = M('area')->where(array('area_id'=>$desc['brithp']))->getOne();
        $shi2 = M('area')->where(array('area_id'=>$desc['brithd']))->getOne();

        //获取墓地
        $cemetery = M('memorial_cemetery2')->field('title')->where(array('id'=>$desc['cemetery']))->getOne();
        include $this->display('memorial_intro.html');
    }

    //传记管理
    public function recordAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 3;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //纪念馆基本信息

        //获取传记
        $bio = M('memorial_biography')->where(array('mid'=>$mid))->getOne();
        $bio['biocontent'] = htmlspecialchars_decode($bio['biocontent']);
        include $this->display('memorial_record.html');
    }

    //传记详细
    public function recordConnAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 3;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //纪念馆基本信息

        //更新访问量
        update_click('record_', $mid, 'memorial_biography', 'click_nums', '3600');

        $bio = M('memorial_biography')->where(array('mid'=>$mid))->getOne();
        $bio['biocontent'] = htmlspecialchars_decode($bio['biocontent']);
        if($bio['biocontent'] == "" || $bio['biocontent'] == ""){
            $bio = null;
        }
//        $sql = "UPDATE `mo_memorial_biography` SET click_nums=click_nums+1 WHERE mid=".$bio['mid'];
//        mysql_query($sql);
        include $this->display('memorial_record_detail.html');
    }

    //祭文
    public function funeralAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 5;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //纪念馆基本信息
        // $funeral = M('memorial_eulogy')->where(array('mid'=>$mid))->select();
        $condtion = array('mid'=>$mid);
        $nums = M('memorial_eulogy')->findCount($condtion);

        $page = new Page($nums,20,6);
        $limit = $page->limit();
        $showPage = $page->show(2);
        $funeral = M('memorial_eulogy')->where($condtion)->limit($limit)->select();

        foreach ($funeral as $key => $value) {
            $funeral[$key]['econtent'] = htmlspecialchars_decode($value['econtent']);
            $funeral[$key]['comments'] = M('memorial_comment')->findCount(array('aid'=>$value['id']));
        }
        include $this->display('memorial_funeral.html');
    }

    //祭文悼词
    public function funeralConnAction()
    {
        $isNav = 5;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info;
        if(isAjax()){
            if($_SESSION['front_login_info']['id']==false){
                echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
            }else{
                $content = Controller::post('content');
                $token_form = Controller::post('token_form');
                $VerifyCode = Controller::post('VerifyCode');
                $mid = Controller::post('mid');

                $data = array();
                $data['content'] = $content;
                $data['uid'] = $_SESSION['front_login_info']['id'];
                $data['addtime'] = time();
                $data['mid'] = $mid;
                $data['page_type'] = 1;     //页面类型1 表示纪念祭文
                $data['aid'] = Controller::post('aid'); //当前纪念祭文的文章id
                if(empty($content)){
                    echo json_encode(array('status'=>2, 'msg'=>'请填写内容'));exit();
                }
                if($this->valid_token2()==false){
                    echo json_encode(array('status'=>2, 'msg'=>'token error，请不要重复提交！'));exit();
                }else{
                    $result = M('memorial_comment')->create($data);
                    if($result){
                        echo json_encode(array('status'=>1, 'msg'=>'留言成功'));exit();
                    }else{
                        echo json_encode(array('status'=>2, 'msg'=>'留言失败，请重试'));exit();
                    }
                }
            }
        }else{
            //令牌 [没有的话生成一个]
            if(!isset($_SESSION['token_form2']) || $_SESSION['token_form2']=='') {
                $_SESSION['token_form2'] = md5(microtime(true));
            }

            $id = Controller::get('id'); //祭文id

            //阅读次数
            update_click('record_', $id, 'memorial_eulogy', 'click_nums', '3600');
//            $sql = "UPDATE `mo_memorial_eulogy` SET click_nums=click_nums+1 WHERE id=$id";
//            mysql_query($sql);

            /**获取楼层**/
            if(isset($_GET['page']) && $_GET['page'] == 1){
                $floor = 0;
            }else if(isset($_GET['page']) && $_GET['page'] > 1){
                $floor = 7*$_GET['page']-7;
            }else{
                $floor = 0;
            }
            /**获取楼层结束**/

            $funeral_info = M('memorial_eulogy')->where(array('id'=>$id))->getOne();
            $funeral_info['econtent'] = htmlspecialchars_decode($funeral_info['econtent']);
            //获取留言列表
            $option = array('mid'=>$mid,'aid'=>$id,'page_type'=>1,'top_id'=>0);
            $nums = M('memorial_comment')->findCount($option);

            $page = new Page($nums,7,6);  //相册最多显示50条
            $limit = $page->limit();
            $showPage = $page->show(2);
            $lists = M('memorial_comment')->where($option)->order('id desc')->limit($limit)->select();
            //获取留言者信息
            $lists = $this->tree($lists);
            foreach ($lists as $key => $value) {
                if($value['uid']){
                    $users = M('member')->where(array('id'=>$value['uid']))->getOne();
                    if($users['username']){
                        $lists[$key]['username'] = $users['username'];
                    }else{
                        $lists[$key]['username'] = $users['email'];
                    }
                    if($users['user_photo']){
                        $lists[$key]['user_photo'] = $users['user_photo'];
                    }
                }
                if($value['addtime']){
                    $lists[$key]['addtime'] = wordTime($value['addtime']);
                }
                //获取楼层
                $lists[$key]['f'] = $floor+=1;
            }
            include $this->display('memorial_record_funeral.html');
        }
    }

    /**
     * 回复纪念悼文 huifu
     */
    public function repJinianDaowenAction()
    {
       if(isAjax()) {
           if($_SESSION['front_login_info']['id']==false){
               echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
           }else {

               $content = Controller::post('content');
               $top_id = Controller::post('top_id');
               $mid = Controller::post('mid');

               $data = array();
               $data['content'] = $content;
               $data['uid'] = $_SESSION['front_login_info']['id'];
               $data['addtime'] = time();
               $data['mid'] = $mid;
               $data['top_id'] = $top_id;
               $data['page_type'] = 1; //1表示是纪念祭文的数据

//             获取用户信息
               $users = M('member')->where(array('id'=>$data['uid']))->getOne();
               if($users['username']){
                   $data['username'] = $users['username'];
               }else{
                   $data['username'] = $users['email'];
               }
               $data['user_pic'] = $users['user_photo'];
               if (empty($content)) {
                   echo json_encode(array('status' => 2, 'msg' => '请填写回复内容'));
                   exit();
               }

               $result = M('memorial_comment')->create($data);
               if ($result) {
                   echo json_encode(array('status' => 1, 'msg' => '留言回复成功'));
                   exit();
               } else {
                   echo json_encode(array('status' => 2, 'msg' => '留言回复失败，请重试'));
                   exit();
               }
           }

       }else{
           return null;
       }
    }

    //相册
    public function albumListsAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 4;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //基本信息

        // $condition = array(
        //     'mid'=>$mid
        //     );
        //获取相册分类
        // $photo_cat = M('memorial_photocat')->where($condition)->select();

        $option = array('mid'=>$mid);
        $nums = M('memorial_photocat')->findCount($option);

        $page = new Page($nums,50,6);  //相册最多显示50条
        $limit = $page->limit();
        $showPage = $page->show(2);
        $photo_cat = M('memorial_photocat')->where($option)->limit($limit)->select();


        //获取相册里面的照片数量
        foreach ($photo_cat as $k => $v) {
            if($v['id']){
                $count = M('memorial_photo')->findCount(array('pid'=>$v['id']));
                $photo_cat[$k]['count'] = $count;
            }
        }
        include $this->display('memorial_albumLists.html');
    }

    //照片
    public function albumAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 4;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //基本信息


        //获取当前相册信息
        $id = Controller::get('id');

        $photo_cat = M('memorial_photocat')->where(array('id'=>$id))->getOne();
        // $photo = M('memorial_photo')->where(array('pid'=>$id))->select();
        $condtion = array(
            'pid'=>$id
        );
        $nums = M('memorial_photo')->findCount($condtion);

        $page = new Page($nums,50,6);  //相册最多显示50条
        $limit = $page->limit();
        $showPage = $page->show(2);
        $photo = M('memorial_photo')->where($condtion)->limit($limit)->select();

        //点击量
        $realip=getip();
        // p($realip);die;
        modifyipcount($realip);
        $sql = "UPDATE `mo_memorial_photocat` SET click_nums=click_nums+1 WHERE id=$id";
        mysql_query($sql);
        include $this->display('memorial_album.html');
    }

    //祭拜记录
    public function worshipAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 6;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //基本信息
            //购买的商品记录读取
        if(!is_numeric($mid)){
            return false;
        }
        $condition = array(
            'mid'=> $mid,
        );
        $nums = M('memorial_buy_goods_record')->findCount($condition);

        $page = new Page($nums,15,6);
        $limit = $page->limit();
        $showPage = $page->show(2);
        $lists = M('memorial_buy_goods_record')->where($condition)->limit($limit)->select();
        include $this->display('memorial_worship.html');
    }


    /**
     * 追思留言==========================================================================================
     */
    public function commentAction()
    {
        $this->PrivacySafe($this->mid);
        $isNav = 7;
        $guanzhu = $this->guanzhu;

        $mid = $this->mid;
        $info = $this->info; //基本信息

        //令牌 [生成一个]

        $set_token = $this->set_token();
    
     

        $option = array('mid'=>$mid);
        $nums = M('memorial_comment')->findCount($option);
        
//        获取楼层
        if(isset($_GET['page']) && $_GET['page'] == 1){
            $floor = 0;
        }else if(isset($_GET['page']) && $_GET['page'] > 1){
            $floor = 7*$_GET['page']-8;
        }else{
            $floor = 0;
        }
//        获取楼层结束

        $page = new Page($nums,7,6);
        $limit = $page->limit();
        $showPage = $page->show(2);
        $lists = M('memorial_comment')->where($option)->order('id desc')->limit($limit)->select();


        $lists = $this->tree($lists);

        //获取用户名
        $f=0;
        foreach ($lists as $key => $value) {
            if($value['uid']){
                $users = M('member')->where(array('id'=>$value['uid']))->getOne();
                if($users['username']){
                    $lists[$key]['username'] = $users['username'];
                }else{
                    $lists[$key]['username'] = $users['email'];
                }
                if($users['user_photo']){
                    $lists[$key]['user_photo'] = $users['user_photo'];
                }else{
                    $lists[$key]['user_photo'] = '/template/default/member/images/default_min.jpg';
                }
            }
            //可视化时间
            if($value['addtime']){
                $lists[$key]['addtime'] = wordTime($value['addtime']);
            }
            //获取楼层
            $lists[$key]['f'] = $floor+=1;
        }
        //获取子留言
        include $this->display('memorial_comment.html');
    }
    //递归遍历我的子回复留言
    public static function tree($array,$child="child")
    {
        $temp = array();
        foreach ($array as $v) {
            $option  = array("top_id"=>$v['id']);
            $v[$child] = M("memorial_comment")->where($option)->select();
            $temp[] = $v;
        }
        return $temp;
    }
    
    //验证来源表单
    public function commentInsertAction()
    {
        if($_SESSION['front_login_info']['id']==false){
            echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
        }else{

            $content = Controller::post('content');
            $token_form = Controller::post('token_form');
            $VerifyCode = Controller::post('VerifyCode');
            $mid = Controller::post('mid');

            $data = array();
            $data['content'] = $content;
            $data['uid'] = $_SESSION['front_login_info']['id'];
            $data['addtime'] = time();
            $data['mid'] = $mid;
            if(empty($content)){
                echo json_encode(array('status'=>2, 'msg'=>'请填写内容'));exit();
            }
            if($this->valid_token($token_form)==false){
                echo json_encode(array('status'=>2, 'msg'=>'token error，请不要重复提交！'));exit();
            }else{
                $_SESSION['token_form'] = array();
                $result = M('memorial_comment')->create($data);
                if($result){
                    echo json_encode(array('status'=>1, 'msg'=>'留言成功'));exit();
                }else{
                    echo json_encode(array('status'=>2, 'msg'=>'留言失败，请重试'));exit();
                }
            }
        }
    }

    //验证表单令牌
    public function valid_token($token_form) {
        if($token_form == $_SESSION['token_form']){
            return true;
        }else{
            return false;
        }
    }

    public function valid_token2() {
        $return = Controller::post('token_form2') === Controller::post('token_form2') ? true : false;
        $this->set_token();
        return $return;
    }

    public function set_token() {
        return $_SESSION['token_form'] = md5(microtime(true));
    }
    
    
    public function get_token() {
        return $_SESSION['token_form'];
    }

     /**
     * 追思留言 结束==========================================================================================
     */
     
     //回复追思留言
     public function commentInsert2Action()
     {
         if($_SESSION['front_login_info']['id']==false){
             echo json_encode(array('status'=>2, 'msg'=>'请先登录'));exit();
         }else {
    
             $content = Controller::post('content');
             $top_id = Controller::post('top_id');
             $mid = Controller::post('mid');
    
             $data = array();
             $data['content'] = $content;
             $data['uid'] = $_SESSION['front_login_info']['id'];
             $data['addtime'] = time();
             $data['mid'] = $mid;
             $data['top_id'] = $top_id;
             
//             获取用户信息
             $users = M('member')->where(array('id'=>$data['uid']))->getOne();
                if($users['username']){
                    $data['username'] = $users['username'];
                }else{
                    $data['username'] = $users['email'];
                }
                $data['user_pic'] = $users['user_photo'];
             
             if (empty($content)) {
                 echo json_encode(array('status' => 2, 'msg' => '请填写回复内容'));
                 exit();
             }
             
                 $result = M('memorial_comment')->create($data);
                 if ($result) {
                     echo json_encode(array('status' => 1, 'msg' => '留言回复成功'));
                     exit();
                 } else {
                     echo json_encode(array('status' => 2, 'msg' => '留言回复失败，请重试'));
                     exit();
                 }
         }
     }

     //纪念馆商品购买
    public function goodsBuyAction()
    {
        if(isAjax()){
            $goods_id = Controller::post('goods_id'); //商品id
            $goods_num = intval(Controller::post('goods_num')); //商品的数量
            if(empty($goods_id)){
                echo json_encode(array('status'=>2, 'msg'=>'放置失败'));exit();
            }
            $uid = $_SESSION['front_login_info']['id'];
            if($uid==false){
                echo json_encode(array('status'=>2, 'msg'=>'还未登录'));exit();
            }
            $mid = Controller::post('mid');
            //检测这个用户是否有这个纪念馆的权限

            //获取商品信息
            $info = $this->getGoodsInfo($goods_id);
            $data = array();
            $data['uid'] = $uid;
            $data['mid'] = $mid;
            $data['goods_id'] = $goods_id;
            $data['goods_num'] = $goods_num;
            $data['addtime'] = time();
            //商品到期时间
            $end = "+".$info['gtime']." day";
            $riqi = date('Y-m-d H:i:s',strtotime($end));
            //反转成时间戳
            $data['goods_time'] = strtotime($riqi);
            $data['goods_img'] = $info['pic'];
            //扣除元宝数量======================================================
            //要支付的元宝数量
            $clearYuanbao = $info['price'] * $goods_num;
            //检测余额
            $yue = M('member')->where(array('id'=>$uid))->getOne();
            if($yue['point'] < $clearYuanbao){
                echo json_encode(array('status'=>2, 'msg'=>'元宝数量不足..'));exit();
            }

            $sql = "UPDATE `mo_member` SET point = point - {$clearYuanbao} WHERE id={$uid}";
            $buy = mysql_query($sql);

            /**
             * 添加已消费元宝到 member 表中
             */
            //取出当前已消费元宝数量
            $consume_pas = M('member')->field('consume_num')->where(array('id'=>$uid))->getOne();
            $consume = $consume_pas['consume_num'] + $clearYuanbao;
            M('member')->update(array('id'=>$uid), array('consume_num'=>$consume));
            // end

            //扣除元宝数量======================================================
            if(!$buy){
                echo json_encode(array('status'=>2, 'msg'=>'购买失败，code line：580'));exit();
            }

                // 商品购买记录=================================
                $name = M('memorial')->where(array('id'=>$mid))->getOne();
                $mname = $name['name'];
                if($_SESSION['front_login_info']['username']){
                    $buyUsername = $_SESSION['front_login_info']['username'];
                }else{
                    $buyUsername = $_SESSION['front_login_info']['email'];
                }
                $this->buyGoodsRecord($info['gname'], $goods_num, $uid, $mid, time(), $buyUsername, $mname, $clearYuanbao, $goods_id);
                //记录使用商品放置到了纪念馆==========================


            $bid = array();
            for ($i=0; $i < $goods_num; $i++) {
                $result = M('memorial_goods_bought')->create($data);

                $bid[] = $result;
            }
            if(!$result){
                echo json_encode(array('status'=>2, 'msg'=>'购买失败'));exit();
            }else{
                echo json_encode($bid);exit();
            }



            //检测是否已经购买过此商品
            // $isBuy = M('memorial_goods_bought')->where(array('uid'=>$uid, 'goods_id'=>$goods_id))->getOne();
            // if($isBuy){
            //     //如果购买过此商品，更新商品数量
            //     // $isUp = M('memorial_goods_bought')->where(array('id'=>$isBuy['id']), array('goods_num'=>"goods_num+{$goods_num}"));
            //     $sql = "UPDATE `mo_memorial_goods_bought` SET goods_num=goods_num+$goods_num WHERE id={$isBuy['id']}";
            //     $isUp = mysql_query($sql);
            //     if(!$isUp){
            //         echo json_encode(array('status'=>2, 'msg'=>'再次购买失败'));exit();
            //     }else{
            //         echo json_encode(array('status'=>1, 'msg'=>$result));exit();
            //     }
            // }else{
            //     $result = M('memorial_goods_bought')->create($data); //第一次购买此商品
            //     if(!$result){
            //         echo json_encode(array('status'=>2, 'msg'=>'购买失败'));exit();
            //     }else{
            //         echo json_encode(array('status'=>1, 'msg'=>$result));exit();
            //     }
            // }

        }
        return null;
    }

    //获取商品信息
    public function getGoodsInfo($goods_id){
        $goods_id = intval($goods_id);
        return $info = M('memorial_funeray_goods')->where(array('id'=>$goods_id))->getOne();
    }

    //放置商品记录商品位置
    public function goodsPlaceAction()
    {
        if(isAjax()){

            //检测是否是当前纪念馆的所有者================================================
            $uid = $_SESSION['front_login_info']['id'];
            $mid = intval(Controller::post('mid')); //纪念馆id
            $bid = intval(Controller::post('bid')); //已购买商品的主键id

                //是否是这个用户购买的此物品
                $thisUser = M('memorial_goods_bought')->where(array('uid'=>$uid, 'id'=>$bid))->getOne();
                // $thisUser = M('memorial')->where(array('userid'=>$uid, 'id'=>$mid))->getOne();
                if(!$thisUser){
                    echo json_encode(array('status'=>2, 'msg'=>'操作失败，请先登录'));exit();
                }
            //检测是否是当前纪念馆的所有者================================================

            $data = array();
            $data['goods_x'] = Controller::post('x3');
            $data['goods_y'] = Controller::post('y3');

            $condition = array('id'=>$bid);
            $result = M('memorial_goods_bought')->update($condition, array('goods_x'=>$data['goods_x'], 'goods_y'=>$data['goods_y'], 'place'=>1));
            if(!$result){
                echo json_encode(array('status'=>2, 'msg'=>'商品修改位置失败'));exit();
            }

        }
        return null;
    }

    //我的物品箱子放置到纪念馆
    public function placeGoods2Action()
    {
        if(isAjax()){
            $goods_id = Controller::post('goods_id');
            //获取我的物品，检测是否属于当前登录的用户
            $uid = $_SESSION['front_login_info']['id'];
            $mid = Controller::post('mid');
            $condition = array(
                'id'=>$goods_id,
                'uid'=>$uid,
                );
            $data = array();
            $data['mid'] = $mid;
            $data['place'] = 1;
            $result = M('memorial_goods_bought')->update($condition, $data);
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'success'));
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'放置失败'));
            }

        }
        return null;
    }

    //检测是否是此人购买的此商品
    public function checkBuy()
    {
        $uid = $_SESSION['front_login_info']['id'];
       //是否是这个用户购买的此物品
        $thisUser = M('memorial_goods_bought')->where(array('uid'=>$uid, 'id'=>$bid))->getOne();
        // $thisUser = M('memorial')->where(array('userid'=>$uid, 'id'=>$mid))->getOne();
        if($thisUser){
            return true;
        }else{
            return false;
        }
    }

    //我的祭品箱
    public function myCaseAction()
    {


    }
    //放置商品到纪念馆
    public function placeGoodsAction()
    {
        $uid = $_SESSION['front_login_info']['id'];
        if(!$uid){
            echo json_encode(array('status'=>2, 'msg'=>'物品放置失败'));exit();
        }
        if(isAjax()){
            $goods_id = Controller::post('goods_id');
            $mid = Controller::post('mid');
            $result = M('memorial_goods_bought')->update(array('uid'=>$uid, 'id'=>$goods_id),
                array('place'=>1, 'mid'=>$mid)
                );
            if($result){
                echo json_encode(array('status'=>1, 'msg'=>'success'));exit();
            }else{
                echo json_encode(array('status'=>2, 'msg'=>'物品放置失败'));exit();
            }

        }
        return null;

    }

    //购买的商品记录插入
    public function buyGoodsRecord($gname='', $num=0, $uid=0, $mid=0, $addtime=0, $username='', $mname='', $clearYuanbao=0, $goods_id=0)
    {
        $data = array();
        $data['gname'] = $gname;
        $data['num'] = $num;
        $data['uid'] = $uid;
        $data['mid'] = $mid;
        $data['addtime'] = $addtime;
        $data['username'] = $username;
        $data['memorial_name'] = $mname;
        $data['price'] = $clearYuanbao;
        $data['goods_id'] = $goods_id;

        M('memorial_buy_goods_record')->create($data);
    }




    public function ajax_viewAction()
    {
        include $this->display('ajax.html');
    }


    public function ajaxAction()
    {
       $page = intval($_POST['pageNum']);

        $result = mysql_query("select id from `mo_member`");
        $total = mysql_num_rows($result);//总记录数

        $pageSize = 6; //每页显示数
        $totalPage = ceil($total/$pageSize); //总页数

        $startPage = $page*$pageSize;
        $arr['total'] = $total;
        $arr['pageSize'] = $pageSize;
        $arr['totalPage'] = $totalPage;
        $query = mysql_query("select * from `mo_member` order by id asc limit $startPage,$pageSize");
        while($row=mysql_fetch_array($query)){
             $arr['list'][] = array(
                'id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email']
             );
        }
        //print_r($arr);
        echo json_encode($arr);
    }

    public function ajax_tplAction()
    {
        include $this->display('ajax_tpl.html');
    }

    public function ajax_pageAction()
    {
        //获取数据总条数
        $nums = M('member')->findCount();
        //引入ajax分页类文件
        include_once "/static/ajaxPage/ajaxPage.class.php";
        $page = new ajaxPage($nums,3); // $m->total('article') 获取 article 表的记录数；10为每页显示十条
        $result = M('member')->limit($page->limit)->select();
        print_r($result);
        p($page->fpage());

    }


    //纪念馆隐私设置
    public function PrivacySafe($mid)
    {
        $result = M('memorial')->field('isshow')->where(array('id'=>$mid))->getOne();
        if($result == null){
            $error = "访问错误，点击返回首页 ";
            include $this->display('PrivacySafe.html');die;
        }

        //如果有访问限制
        if($result['isshow']==2){
            //如果用户登录存在，判断是否是此馆所有者
            if($_SESSION['front_login_info']['id']){
                $uid = $_SESSION['front_login_info']['id'];
                $uinfo = M('memorial')->field('userid')->where(array('id'=>$mid))->getOne();
                if($uinfo['userid'] != $uid){
                    $error  ="管理员设置了仅馆主可见，您可去看看 ";
                    include $this->display('PrivacySafe.html');die;
                }
            }else{
                $error  ="管理员设置了仅馆主可见，您可去看看 ";
                include $this->display('PrivacySafe.html');die;
            }
        }
    }

}
