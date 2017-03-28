<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * GoodsController.php
 *
 * 商品详细类————前台
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class GoodsController extends HomeController {

    public  $CategoryModel;
    public  $GoodsModel;
    public function init()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        
        $this->CategoryModel = D('Category','category');
        $this->GoodsModel = D('Goods');
        parent::init();
    }
    /**
     * 商品栏目首页
     */
    public function indexAction()
    {

        $cid = Controller::get('cid');
        $pid = 0;
        $model = 2;//商品默认为2

        $seo = get_metainfo_category($cid);
        $template = $this->CategoryModel->getTemplage($cid,'indextpl');
        include $this->display($template);
    }
    /**
     * 商品栏目列表页
     */
    public function listAction()
    {
        $cid = Controller::get('cid');
        $model = 2;//商品默认为2
        $pid = getPid($cid); //用列表页导航选中状态:当前栏目的顶级栏目ID
        $template = $this->CategoryModel->getTemplage($cid,'columntpl');
        $seo = get_metainfo_category($cid);
        include $this->display($template);
    }
    
    /**
     * 浏览量高的商品列表页
     */
    public function topListAction() {
        include $this->display('list_5.html');
    }

    /**
     * 商品详细页
     */
    public function infoAction()
    {
        $id = Controller::get('id');
        if(empty($id)){
            $this->showMessage("参数错误", '/category/Category/index/cid/290', 3);die;
        }
        $model = 2;//商品默认为2
        $goodslinkid = $this->GoodsModel->getLinkgoodsid($id);
        include_once DIR_TAG.'goods.lib.php';
        $goodsLink = array(); //此商品的关联商品
        if(!empty($goodslinkid))
        {
            $obj=new Goods();
            $goodsLink = $obj->lib_goods(array('id'=>implode(',',array_values($goodslinkid))));
        }
        else  //凑凑合合吧
        {
            //获取本分类下的默认的10个商品
            $sql = 'select goodsid from '. M('Goods')->tablePrefix.'goods where sortid in (select sortid from '. M('Goods')->tablePrefix.'goods where goodsid = '.$id.') and goodsid!='.$id.' limit 0,10';
            $goodsLinkid = M('Goods')->query($sql);
            $obj=new Goods();
            $tem = array();
            foreach($goodsLinkid as $k => $v)
            {
                $tem[] = $v['goodsid'];
            }
            if(!empty($tem))
            {
                $goodsLink = $obj->lib_goods(array('id'=>implode(',',$tem)));
            }
        }
        $goods = $this->GoodsModel->goodsInfo($id);
        if(!is_array($goods)){
            $this->showMessage("参数错误", '/category/Category/index/cid/290', 3);die;
        }
        $cid = $goods['categoryid'];    //当前栏目ID
        $pid = getPid($cid);            //当前内容也顶级栏目ID，用于导航页面的选中

        
        //替换商品关键词 
        $goods['content'] = $this->getTagsModel()->formateTages($goods['content'],$cid);


        //Tag标签搜索地址id
        $goods['keywords'] = $this->getTagsModel()->GetTagname($id,$model,$cid,$pid);  
        
        
        $perArr = explode(',',$goods['alowpower']);

        //判断浏览权限，并更新文章点击量
        $username = Session::get('username');
        $groupid = M('member')->field('groupid')->where(array('username'=>$username))->getOne();
        $roleid = !empty($groupid) ?  $groupid['groupid'] : '' ;
        //栏目浏览权限:1：可以浏览，2代表允许评论
        $has_cat_pre = D('Content','content')->getMemberCatePerModel($cid,$roleid,1);//当前栏目的权限

        //这部分权限和栏目的权限控制很乱，有问题在改
        if(@$_SESSION['roleid'] && Controller::get('isadmin'))  //后台管理员没有权限
        {
           //$this->ContentModel->updateHits($id);//更新点击量
        }
        else if(!$has_cat_pre&&in_array(-1,$perArr))  //有栏目权限
        {
           $this->GoodsModel->updateHits($id);//更新点击量
        }
        elseif(in_array($roleid,$perArr)||(in_array(-2,$perArr)&&$roldeid))//有角色的权限
        {
            $this->GoodsModel->updateHits($id);//更新点击量
        }
        else
        {
            goback("没有权限",true);
        }
        $seo = get_metainfo_goods($id);
        $template = $this->GoodsModel->getTemplage($id);
        $template = "content_product.html";
        $goodsablum = $this->GoodsModel->goodsAblum($id);

        foreach ($goodsablum as $key => $value) {
            $goodsablum[$key]['photo'] = "/static/uploadfile/goods/" . $value['photo'];
        }
        include $this->display($template);
    }


    /**
     * 获取文章内容标签替换服务类
     */
    function getTagsModel () 
    {
        return D('getTagsReplaceModel','tags');
    }


    /**
     * 获取殡仪用品商品页面
     */
    function funerayAction()
    {
        
    }

}
