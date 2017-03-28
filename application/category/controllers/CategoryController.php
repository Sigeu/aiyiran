<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CategoryController.php
 *
 * 栏目类————前台
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-4 下午3:38:31
 * @filename   ContentController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0 udacity
 *-------------------------------------------------------------------------------------
 */
class CategoryController extends HomeController {

    public  $CategoryModel;
    public function init()
    {
        $this->CategoryModel = D('Category');
        parent::init();
        error_reporting(E_ALL & ~E_NOTICE);

    }
    /**
     * 栏目首页
     */
    public function indexAction()
    {
        $zimu = get_config('common','zimu','home');

        $cid = Controller::get('cid');

        $seo = get_metainfo_category($cid);
        $pid = 0;
        $template = $this->CategoryModel->getTemplage($cid,'indextpl');

        $this->delllAction($cid, $seo);

        include $this->display($template);
    }
    /**
     * 栏目列表页
     */
    public function listAction()
    {
        $cid = Controller::get('cid');
        $pid = getPid($cid);//用列表页导航选中状态:当前栏目的顶级栏目ID
        $seo = get_metainfo_category($cid);
        $template = $this->CategoryModel->getTemplage($cid,'columntpl');
        include $this->display($template);
    }

    /**
     * [delllAction 控制]
     * @param  [type] $cid [description]
     * @return [type]      [description]
     */
    private function delllAction($cid, $seo)
    {
        #名人纪念馆
        if($cid == 306) $this->mingren($seo);

        #私人纪念馆
        if($cid == 305) $this->siren($seo);

        #英烈纪念馆
        if($cid == 307) $this->hero($seo);

        #事件纪念馆
        if($cid == 308) $this->event($seo);

        // 许愿
        if($cid == 313) $this->wish($seo);

        // 姓氏宗祠
        if($cid == 314) $this->surname($seo);

        // 陵园
        if($cid == 321) $this->park($seo);

        // 帮助中心
        if($cid == 281) $this->help($seo);

        //殡仪用品
        if($cid == 290) $this->binyi($seo);

        //关于我们
        if($cid == 53) $this->about($seo);




    }

    public function siren($seo)
    {
        $cid = Controller::get('cid');
        $zimu = get_config('common','zimu','home');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $letter = isset($_GET['letter']) ? trim($_GET['letter']) : '';
        $persontype = isset($_GET['persontype']) ? intval($_GET['persontype']) : 0;

        //获取我的纪念馆
        $uid = $_SESSION['front_login_info']['id'];
        if($uid){
            $memorial_lists = M('memorial')->findAll(array('userid'=>$uid), 'id desc','*',2);
        }
        if($memorial_lists){
            foreach ($memorial_lists as $key => $value) {
                if($value['userpic']==""){
                    $memorial_lists[$key]['userpic'] = "/template/default/images/g_07.png";
                }
            }
        }

        //最新祭拜功能
//        $newjibai = $this->newjibai();

        include $this->display('index_private.html');die;
    }

    //最新祭拜功能
    public function newjibai()
    {
        $result = M('memorial_buy_goods_record')->order('id desc')->limit('0,10')->select();
        foreach($result as $k=>$v){
            if($v){
                $username = M('member')->field('username')
                ->where(array('id'=>$v['uid']))->getOne();
                $result[$k]['username'] = $username['username'];
                if($username['username']==false){
                    $email =  M('member')->field('email')
                    ->where(array('id'=>$v['uid']))->getOne();
                    if($email['email']){
                        $result[$k]['username'] = $email['email'];
                    }else{
                        $result[$k]['username'] = '游客';
                    }
                }
            }
        }
        return $result;
    }

    public function mingren($seo)
    {
            $cid = Controller::get('cid');
        $zimu = get_config('common','zimu','home');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $letter = isset($_GET['letter']) ? trim($_GET['letter']) : '';
        include $this->display('index_celebrity.html');die;
    }

    public function hero($seo)
    {
        $cid = Controller::get('cid');
        $zimu = get_config('common','zimu','home');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $letter = isset($_GET['letter']) ? trim($_GET['letter']) : '';
        include $this->display('index_hero.html');die;
    }

    public function event($seo)
    {
        $cid = Controller::get('cid');
        $zimu = get_config('common','zimu','home');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $letter = isset($_GET['letter']) ? trim($_GET['letter']) : '';
        include $this->display('index_event.html');die;
    }

    public function wish($seo)
    {
        // p($GLOBALS);
        $cid = Controller::get('cid');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $lists = M('wish_reply')->select();
        include $this->display('index_wish.html');die;
    }

    public function surname($seo)
    {
            $cid = Controller::get('cid');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        include $this->display('index_hall.html');die;
    }

    public function park($seo)
    {
        $cid = Controller::get('cid');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $province = isset($_GET['province']) ? trim($_GET['province']) : '';
        $city = isset($_GET['city']) ? trim($_GET['city']) : '';

        // 如果地址栏存在省份参数，就可以通过省份参数查询市级数据
        if($province){
             $info = M('area')->where(array('parent_id'=>$province))->select();
             // $citys = "";
             // foreach ($info as $key => $value) {
             //     $citys .= "<option value='".$value['area_id']."'>".$value['area_name']."</option>";
             // }
        }
         // 省份
        $area = M('area')->where(array('area_type'=>1))->select();
        include $this->display('index_park.html');die;
    }

    public function help($seo)
    {
        $cid = Controller::get('cid');
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
        include $this->display('index_help.html');die;
    }

    public function binyi($seo)
    {
        $category_name="";

        $cid = Controller::get('cid');
        $category = isset($_GET['category']) ? intval($_GET['category']) : '';
        if($category){
            $category_name = M('goods_sort')->field('sortname')->where(array('sortid'=>$category))->getOne();
        }
        include $this->display('index_goods.html');die;

    }

    public function about($seo)
    {
        $cid = Controller::get('cid');
        // 获取文章id
        $id = urldecode(trim(strip_tags(Controller::getParams('id'))));     //接收关键词
        if($id){
            $lists = M('maintable')
                ->join('mo_article AS a ON mo_maintable.id = a.maintable_id')
                ->where(array('maintable_id'=>$id))
                ->getOne();
            $content = htmlspecialchars_decode($lists['content']);
            if(!is_array($lists)){
               $this->showMessage("请添加数据", '/', 3);die;
            }
        }else{
            // 默认是网站介绍
            $lists = M('maintable')
            ->join('mo_article AS a ON mo_maintable.id = a.maintable_id')
                ->where(array('maintable_id'=>567))
                ->getOne();
            $content = htmlspecialchars_decode($lists['content']);
            if(!is_array($lists)){
                $this->showMessage("请添加数据", '/', 3);die;
            }
        }
        include $this->display('index_about.html');die;
    }

    //帮助中心终极页
    public function helpContentAction()
    {
        if(isset($_GET['id']) && !empty($_GET)){
            $id = $_GET['id'];
            $condition = array('id'=>$id);
            $content = array();
            $neirong = M('article')->where($condition)->getOne(); //获取内容
            if($neirong==false){ //没有找到文章
                $this->showMessage("请添加数据", '/', 3);die;
            }
            $content['content'] = $neirong['content'];
            $tit = M('maintable')->where(array('id'=>$neirong['maintable_id']))->getOne(); //获取标题
            $content['title'] = $tit['title'];
            //获取上一篇[内容]
            $shang = M('article')->where("id={$neirong['id']}-1")->getOne();
            //获取上一篇标题
            $shang_title = M('maintable')->where("id={$shang['maintable_id']} AND categoryid=281")->getOne();
            if($shang_title==false){
                $shang_title['title'] = "没有了";
                $shang_title['url'] = "javascript:;";
            }else{
                //使用标题的id覆盖内容的id
                $shang_title['url'] = "/category/Category/helpContent/id/{$shang['id']}";
            }

            //下一篇
            $xia = M('article')->where("id={$neirong['id']}+1")->getOne();
            $xia_title = M('maintable')->where("id={$xia['maintable_id']} AND categoryid=281")->getOne();
            if($xia_title==false){
                $xia_title['title'] = "没有了";
                $xia_title['url'] = "javascript:;";
            }else{
                //使用标题的id覆盖内容的id
                $xia_title['url'] = "/category/Category/helpContent/id/{$xia['id']}";
            }
            include $this->display('content_help.html');die;
        }

    }



}
