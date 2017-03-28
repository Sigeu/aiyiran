<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 手机站controller
 * 
 * 文件修改记录：
 * <br>王少辰  2013-9-22 下午05:28:08 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-22 下午05:28:08
 * @filename   IndexController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class IndexController extends HomeController
{
    public static $_base_set;           //手机站点基本设置
    public static $_header_set;         //导航设置
    public static $_hid = 0;            //当前选中的导航id（栏目id）
    public static $_hids = array();     //当前所有导航id数组
    
    protected function initView() {
        /*设置模板文件为手机模板文件*/
        app::loadFile(DIR_BF_ROOT.'base'.DIRECTORY_SEPARATOR.'Template.php');
        self::$_view = Template::getInstance('mobile_');
        self::$_style = self::$_view -> getStyle('mobile_');
        
        //初始化手机站点设置
        $this->set();
    }
    
    /*手机站点初始化设置*/
    public function set() {
        self::$_base_set = $this->getBaseSet();             //手机站点基本设置
        self::$_header_set = $this->getHeaderSet();         //导航设置
        self::$_hids = self::$_header_set['header_cids'];
        self::$_hid = $this->getHeaderCid();
        unset(self::$_header_set['header_cids']);
    }
    
    /*
    *得到当前应选中的导航id
    *@param $cid 当前页面所属栏目id
    *@return $hid 
    */
    public function getHeaderCid($cid=0) {
        $hid = 0;  //默认为0，选中导航中的首页
        $hids = self::$_hids;//当前导航栏目id数组
        if (empty($cid)) {
            $cid = Controller::getParams('cid');
        }
        $cid = $cid ? $cid : 0;
        if ($hids && is_array($hids)) {
            /*若当前栏目id在导航中，返回该栏目id*/
            if (in_array($cid, $hids)) {
                $hid = $cid;
                return $hid;
            } else {
                $cate = new getCate();
                $pids = $cate -> getAllPids($cid);//获取当前栏目所有祖辈栏目id
                foreach ($pids as $p) {
                    /*若存在最近的祖辈栏目在导航中，返回该祖辈栏目id*/
                    if (in_array($p, $hids)) {
                        $hid = $p;
                        return $hid;
                    }
                }
            }
        }
        return $hid;
    }
    
    /*
    *获取手机站导航设置信息
    */
    public function getHeaderSet () {
        $order = array('order' => 'show_order asc, id asc');//导航排序
        $header_set = M('MobileHeader')->field('title, cid')->select($order);
        $header_cids = array();//导航栏目id数组
        /*
        *根据导航栏目信息，获取导航栏目链接页面及导航栏目id数组
        */
        foreach ($header_set as $key => $val) {
            $category_info = cid2info($val['cid']);//栏目信息
            $column_attr = $category_info['columnattr'];
            $modelid = $category_info['model'];
            $cid = $val['cid'];
            $header_cids[] = $cid;
            if ($column_attr <= 2) {
                //商品或内容列表
                $url = URL_HOST . 'mobile/index/search/mid/' . $modelid . '/cid/' . $cid;
            }else if ($column_attr == 3) {
                //外部链接
                $url = $category_info['filepath'];
            } else if ($column_attr == 4){
                //单页栏目页
                $url = URL_HOST . 'mobile/index/category/cid/' . $cid;
            }else {
                $url = '';
            }
            $header_set[$key]['url'] = $url;
        }
        $header_set['header_cids'] = $header_cids;
        return $header_set;
    }
    
    /*
    *获取手机站基本设置
    */
    public function getBaseSet () {
        $base_set = M('MobileWebset')->getOne();
        $base_set['logo'] = URL_STATIC_UPLOAD . $base_set['logo'];
        if (!isset($base_set['is_open']) || empty($base_set['is_open'])) {
            redirect(URL_HOST, "手机站尚未开通", 1);
        }
        return $base_set;
    }
    
    /*
    *获取手机站首页模块基本设置
    */
    public function getIndexSet () {
        $order = array('order' => 'show_order asc, id asc');
        $where = array('is_show' => 1);
        $index_set = M('MobileIndex')->field('id, name, source_type, source_id')->where($where)->select($order);
        foreach ($index_set as $key => $val) {
            if ($val['source_type'] == 2) {
                /*若该模块是选取栏目，根据栏目类型设置模块链接地址*/
                $category_info = cid2info($val['source_id']);
                $column_attr = $category_info['columnattr'];
                $modelid = $category_info['model'];
                $cid = $val['source_id'];
                if ($column_attr <= 2) {
                    $url = URL_HOST . 'mobile/index/search/mid/' . $modelid . '/cid/' . $cid;
                }else if ($column_attr == 3) {
                    $url = $category_info['filepath'];
                } else if ($column_attr == 4){
                    $url = $url = URL_HOST . 'mobile/index/category/cid/' . $cid;
                }else {
                    $url = '';
                }
                $index_set[$key]['url'] = $url;
            }
            if ($key <= 3) {
                $position_info = M('Position')->where(array('pos_id' => $val['source_id']))->getOne();
                $index_set[$key]['item_count'] = $position_info['max_num'];
            }
        }
        return $index_set;
    }
    
    /*
    *获取手机站搜索设置信息
    */
    public function getSearchSet () {
        $order = array('order' => 'show_order asc, id asc');
        $where = array('is_show' => 1);
        $search_set = M('MobileSearch')->field('title, id')->where($where)->select($order);
        return $search_set;
    }
    
    /*
    *获取手机站互动凡事设置信息
    */
    public function getContactSet () {
        $where = array('is_show' => 1);
        $contact_set = M('MobileContact')->field('id, setting, setting_type, title')->where($where)->select();
        return $contact_set;
    }
    
    
	/**
	 * 手机网站首页
	 * @param
	 * @return
	 */
	public function indexAction() {
        /* @var String $m *///手机访问方式
        $m = Controller::getParams('m', '');
        if('app' == $m){
            Cookie::set('phone_app_visit', 1, time()+86400*30);
        }
		$seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
        $base_set = self::$_base_set;            //站点设置
        $header_set = self::$_header_set;        //导航设置
        $search_set = $this->getSearchSet();     //搜索设置
        $contact_set = $this->getContactSet();   //互动设置
        $index_set = $this->getIndexSet();       //首页设置
        $hid = 0;                                //导航高亮设置
        include  $this->display('index.html');
	}
    
    
    /**
	 * 手机网站商品、内容搜索，商品列表，内容列表
	 * @param
	 * @return
	 */
    public function searchAction() {
        /*
        *手机站基本信息设置
        */
        $base_set = self::$_base_set;
        $header_set = self::$_header_set;
        $contact_set = $this->getContactSet();
        $hid = self::$_hid;
        $search_set = $this->getSearchSet();
        
        /*
        *要搜索的关键词
        */
        $keywords = Controller::getParams('keywords');
		
        /*
        *搜索类型$mid，1：搜商品，其他：搜文章（内容）
        */ 
        $mid = Controller::getParams('mid');
        $mid = $mid ? $mid : 0;
        
        /*栏目id*/
        $cid = Controller::getParams('cid');
        $cid = $cid ? $cid : 0;
        
        $seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
        if ($cid) {
            /*
            *若存在栏目id，忽略关键字，搜索结果为该栏目下商品或文章列表
            */
            $keywords = '|';
            $seo = seo($cid);//设置该栏目seo信息
        }
        
        $arctile_list_show = explode(',', $base_set['article_list_show']);
        $product_list_show = explode(',', $base_set['product_list_show']);
        include $this->display('mobile_search');
    }
    
    /*
    *搜索结果
    */
    public function searchResultAction() {
        $keywords = Controller::getParams('keywords');//搜索关键字
        $keywords = htmlspecialchars(addslashes(urldecode($keywords)));
		$mid = Controller::getParams('mid');//搜索类型
        $cid = Controller::getParams('cid');//栏目id
		$limit = Controller::getParams('amount');//搜索条数
        $limit_from = Controller::getParams('last');//搜索结果开始位置
        $title_count = Controller::getParams('title_count', 0);//标题字数
        $brief_count = Controller::getParams('brief_count', 0);//简介字数
		$searchList = D('Mobilesearch')->search(
            array(
                'keywords' => preg_replace('/\;|\#|\%|\"|\'/', '', $keywords),
                'mid' => $mid,
                'cid' => $cid,
                'limit' => $limit + 1,
                'limit_from' => $limit_from
            )
        );
        $last = 1;
        $count = count($searchList);
        if ($count > $limit) {
            array_pop($searchList);
            $last = 0;
        }
        /*
        *处理搜索结果为适应js添加到页面的形式
        */
        $list = array(
            'data' => '',
            'is_last' => $last
        );
        foreach ($searchList as $key => $val) {
            $list['data'][$key] = $val;
            /*
            *链接地址
            */
            if ($mid == 2) {
                $id = $val['goodsid'];
                $link = URL_HOST . "mobile/index/goods/id/$id";
            } else {
                $id = $val['id'];
                $link = URL_HOST . "mobile/index/content/id/$id";
            }
            $list['data'][$key]['url'] = $link;
            
            $src = '';//图片路径
            if ($mid == 2) {
                $id = $val['goodsid'];
                /*
                *获得图片路径
                */
                $goodsalbum = M('goods_album')->where(array('goodsid'=>$id))->select();
                if ($goodsalbum) {
                    $src = URL_STATIC_UPLOAD . "goods/" . $goodsalbum[0]['photo'];
                }
                
                /*
                *优惠价
                */
                $list['data'][$key]['shopprice'] = '￥' . $val['shopprice'];
                
                /*
                *品牌
                */
                $brand = M('GoodsBrand')->field('brandname')->where('brandid = ' . $val['brandid'])->getOne();
                $brand_name = $brand ? '[' . $brand['brandname'] . ']' : '';
                $list['data'][$key]['brandid'] = $brand_name;
                
                /*
                *商品简介
                */
                if ($brief_count) {
                    $list['data'][$key]['brief'] =  msubstr($val['brief'], 0, $brief_count, 'utf-8', true);
                }
            } else {
                /*
                *图片路径
                */
                $thumb = json_decode($val['thumb'], true);
                if ($thumb && isset($thumb['src'])) {
                    $src = URL_STATIC_UPLOAD . $thumb['src'];
                }
                
                /*
                *文章描述
                */
                if ($brief_count) {
                    $list['data'][$key]['description'] =  msubstr($val['description'], 0, $brief_count, 'utf-8', true);
                }
            }
            $list['data'][$key]['src'] = $src;
            
            /*
            *点击量
            */
            $list['data'][$key]['hits'] = '点击量：' . $val['hits'];
            /*
            *时间
            */
            $list['data'][$key]['created'] = date('Y-m-d', $val['created']);
            
            /*
            *标题
            */
            if ($title_count) {
                $list['data'][$key]['title'] =  msubstr($val['title'], 0, $title_count, 'utf-8', true);
            }
        }
        echo json_encode($list);
	}
    
    /*
    *单页栏目页
    */
    public function categoryAction() {
        $cid = Controller::getParams('cid');
        $info = cid2info($cid);
        if ($info) {
            /*基本设置*/
            $base_set = self::$_base_set;
            $header_set = self::$_header_set;
            $contact_set = $this->getContactSet();
            $hid = self::$_hid;
            
            /*当前页码*/
            $cpage = intval(Controller::get('cpage',1));
            $size = $base_set['article_content_pagesize'];
            $type = $base_set['article_content_pagetype'] == 1 ? 1 : 1024;
            $page_size = $size * $type;//单页字符数
            $text = $info['content'];
            $contentpage = new ContentPage();
            $mycontent = $contentpage->get_data($info['content'], $page_size);
            $mycontents = array_filter(explode('[page]',$mycontent));
            $info['content'] = empty($mycontents) ? '' : $mycontents[$cpage-1];//当前页内容
            if (empty($info['content'])) {
                $info['content'] = $text;
            }
            /*
            *是否显示查看全文按钮
            */
            $show = true;
            $nextpage = $cpage + 1;
            if ($cpage >= count($mycontents)) {
                $show = false;
            }
            
            $seo = seo($cid);
            include $this->display('category');
        }
    }
    
    /*
    * 查看全文交互
    */
    public function categoryViewMoreAction () {
        $base_set = self::$_base_set;
        $nextpage = Controller::getParams('nextpage');
        $cid = Controller::getParams('cid');
        $info = cid2info($cid);
        $size = $base_set['article_content_pagesize'];
        $type = $base_set['article_content_pagetype'] == 1 ? 1 : 1024;
        $page_size = $size * $type * $nextpage;
        $contentpage = new ContentPage();
        $mycontent = $contentpage->get_data($info['content'], $page_size);
        $mycontents = array_filter(explode('[page]',$mycontent));
        if (empty($mycontents[0])) {
            $mycontents[0] = $info['content'];
        }
        $show = 1;
        if (count($mycontents) <= 1) {
            $show = 0;
        }
        $result = array(
            'show' => $show,
            'content' => $mycontents[0]
        );
        echo json_encode($result);
        return;
    }
    
    
    /*
    *商品详情
    */
    public function goodsAction () {
        $id = Controller::getParams('id');
        $product_info = D('Goods', 'goods')->goodsInfo($id);
        if (!$product_info) {
            return;
        }
        $category_id = $product_info['categoryid'];//当前商品所属栏目
        
        /*
        *权限设置
        */
        $perArr = explode(',',$product_info['alowpower']);
        $username = Session::get('username');
		$groupid = M('member')->field('groupid')->where(array('username'=>$username))->getOne();
		$roleid = !empty($groupid) ?  $groupid['groupid'] : '' ;
		$has_cat_pre = D('Content','content')->getMemberCatePerModel($category_id,$roleid,1);//当前栏目的权限
	    if(@$_SESSION['roleid'] && Controller::get('isadmin')) {
           //$this->ContentModel->updateHits($id);
		}
		else if(!$has_cat_pre&&in_array(-1,$perArr)) {
           D('Goods', 'goods')->updateHits($id);
		}
		else if(in_array($roleid,$perArr)||(in_array(-2,$perArr)&&$roleid)) {
			D('Goods', 'goods')->updateHits($id);
		}
		else {
			goback("没有权限",true);
		}

        /*站点信息设置*/
        $seo = seo($category_id);
        $base_set = self::$_base_set;
        $header_set = self::$_header_set;
        $contact_set = $this->getContactSet();
        $hid = $this->getHeaderCid($category_id);
        
        /*同栏目下商品上一个，下一个*/
        $goods_same_category = M('goods')->select(array('where' => "categoryid = $category_id"));
        $next = '';
        $prev= '';
        foreach ($goods_same_category as $k => $v) {
            if ($v['goodsid'] == $id) {
                $next = isset($goods_same_category[$k+1]) ? $goods_same_category[$k+1]['goodsid'] : '';
                $prev = isset($goods_same_category[$k-1]) ? $goods_same_category[$k-1]['goodsid'] : '';
                break;
            }
        }
        if (empty($next)) {
            $next_link = 'javascript:void(0)';
        } else {
            $next_id = $next + 0;
            $next_link = $next_id ? URL_HOST . 'mobile/index/goods/id/' . $next_id : 'javascript:void(0)';
        }
        
        if (empty($prev)) {
            $prev_link = 'javascript:void(0)';
        } else {
            $prev_id = $prev + 0;
            $prev_link = $prev_id ? URL_HOST . 'mobile/index/goods/id/' . $prev_id : 'javascript:void(0)';
        }
         /*同栏目下商品上一个，下一个 end*/
        
        //商品图片信息
        $goods_picture = M('goods_album')->where(array('goodsid'=>$id))->select();
        include $this->display('goods');
    }
    
    
    /*内容详情*/
    public function contentAction() {
        $id = Controller::getParams('id');
        $model = D('Content','content')->getModelId($id);//当前内容模型ID
        /*获取内容信息*/
		$contents = D('Content','content')->getContent(array('id'=>$id),$model);
        if (!$contents) {
            return;
        }
        $content_info = isset($contents[0]) ? $contents[0] : '';//当前内容信息
        if (!$content_info) {
            return;
        }
        $category_id = @$content_info['categoryid'];//所属栏目id
        
        /*权限控制*/
        $perArr = explode(',',@$content_info['readpower']);
        $username = Session::get('username');
		$groupid = M('member')->field('groupid')->where(array('username'=>$username))->getOne();
		$roleid = !empty($groupid) ?  $groupid['groupid'] : '' ;
		$has_cat_pre = D('Content','content')->getMemberCatePerModel($category_id,$roleid,1);//当前栏目的权限
	    if(@$_SESSION['roleid'] && Controller::get('isadmin')) {
           //D('Content','content')->updateHits($id);
		}
		else if(!$has_cat_pre&&in_array(-1,$perArr)) {
           D('Content','content')->updateHits($id);
		}
		elseif(in_array($roleid,$perArr)||(in_array(-2,$perArr)&&$roleid)) {
           D('Content','content')->updateHits($id);
		}
		else {
			goback("没有权限",true);
		}
        /*权限控制 end*/
        
        /*站点信息*/
        $seo = seo($category_id);
        $base_set = self::$_base_set;
        $header_set = self::$_header_set;
        $contact_set = $this->getContactSet();
        $hid = $this->getHeaderCid($category_id);

        /*上一篇，下一篇*/
        $content_same_category = M('maintable')->field('id, title')->select(array('where' => "categoryid = $category_id"));
        $next = '';
        $prev= '';
        $related = array();
        $count = 0;
        foreach ($content_same_category as $k => $v) {
            if ($v['id'] == $id) {
                $next = isset($content_same_category[$k+1]) ? $content_same_category[$k+1]['id'] : '';
                $prev = isset($content_same_category[$k-1]) ? $content_same_category[$k-1]['id'] : ''; 
            } else {
                if ($count <= 4) {
                    $related[] = $v;
                    $count++;
                }
            }
        }
        if (empty($next)) {
            $next_link = 'javascript:void(0)';
        } else {
            $next_id = $next + 0;
            $next_link = $next_id ? URL_HOST . 'mobile/index/content/id/' . $next_id : 'javascript:void(0)';
        }
        
        if (empty($prev)) {
            $prev_link = 'javascript:void(0)';
        } else {
            $prev_id = $prev + 0;
            $prev_link = $prev_id ? URL_HOST . 'mobile/index/content/id/' . $prev_id : 'javascript:void(0)';
        }
        /*上一篇，下一篇 end*/
        
        /*设置当前页显示信息*/
        $cpage = intval(Controller::get('cpage',1));
        $size = $base_set['article_content_pagesize'];
        $type = $base_set['article_content_pagetype'] == 1 ? 1 : 1024;
        $page_size = $size * $type;
        $text = $content_info['content'];
        if (strlen($content_info['content']) >= $page_size) {
            $contentpage = new ContentPage();
            $mycontent = $contentpage->get_data($content_info['content'], $page_size);
            $mycontents = array_filter(explode('[page]',$mycontent));
            $content_info['content'] = isset($mycontents[$cpage-1]) ? $mycontents[$cpage-1] : '';
        }
        if (empty($content_info['content'])) {
            $content_info['content'] = $text;
        }
        /*查看更多按钮显示设置*/
        $show = true;
        $nextpage = $cpage + 1;
        if ($cpage >= count($mycontents)) {
            $show = false;
        }
        $article_content_show = explode(',', $base_set['article_content_show']);
        include $this->display('content');
    }
    
    
    /*内容详情查看更多ajax互动*/
    public function contentViewMoreAction () {
        $base_set = self::$_base_set;
        $nextpage = Controller::getParams('nextpage');
        $id = Controller::getParams('id');
        $model = D('Content','content')->getModelId($id);//当前内容模型ID
		$contents = D('Content','content')->getContent(array('id'=>$id),$model);//获取内容信息
        $info = $contents[0];
        $size = $base_set['article_content_pagesize'];
        $type = $base_set['article_content_pagetype'] == 1 ? 1 : 1024;
        $page_size = $size * $type * $nextpage;
        if (strlen($info['content']) <= $page_size) {
            $mycontents[0] = $info['content'];
        } else {
            $contentpage = new ContentPage();
            $mycontent = $contentpage->get_data($info['content'], $page_size);
            $mycontents = array_filter(explode('[page]',$mycontent));
        }
        $show = 1;
        if (count($mycontents) <= 1) {
            $show = 0;
        }
        if (empty($mycontents[0])) {
            $mycontents[0] = $info['content'];
        }
        $result = array(
            'show' => $show,
            'content' => $mycontents[0]
        );
        echo json_encode($result);
        return;
    }
    
    
    /*留言*/
    public function addMessageAction() {
        if (isset($_POST['info']) && $_POST['info']) {
        /*若接收到表单数据*/
            $params = $_POST['info'];
            /*敏感词开始*/
            foreach($params as $key=>$value) {
                $flag = D('Comment','comment')->isSubmit($value);
                if($flag !== true) {
                   goback($flag.'为敏感词，不能提交',true);
                }
                else {
                    continue;
                }
            }
           /*敏感词结束*/
           
            /*处理多级或多选字段*/
            foreach($params as $key=>$value) {
				if(is_array($value)) {
					$params[$key] = implode(';',$value);
				}
		    }
            
            /*留言类型id*/
            $modelid = $params['model_id'];
            
            /*对应类型留言表写入*/
            $insert_id = M('message_' . $modelid) -> create($params);
            if(!$insert_id) {
                goback('留言失败');
            }
            
            /*留言管理表写入*/
            unset($params['model_id']);
            $mamage_params = $params;
            $mamage_params['typeid'] = $modelid;
            $mamage_params['message_id'] = $insert_id;
            $mamage_params['leavetime'] = time();
            $manage_id = M('message_manage') -> create($mamage_params);
            if (!$manage_id) {
                goback('留言失败',true);
            }
            alert('留言成功',$_SERVER['HTTP_REFERER']);
        }

       
        $modelid = Controller::get('id',1);//留言类型id
        $obj = M('MixModel');
        $message_category = $obj->find(array('id'=>$modelid));//留言类型
        $name = $message_category['name'];//留言类型title
        
        /*站点设置*/
        $base_set = self::$_base_set;
        $header_set = self::$_header_set;
        $contact_set = $this->getContactSet();
        $hid = 0;
        $seo = array(
			'title'=>$name,
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);
        
        /*留言页面表单及验证规则设置*/
		
		$flag = 1;//留言
		$contentForm = new MessageForm($modelid);
		$form = $contentForm->get($flag,$modelid);//表单
		$formvalidator = $contentForm->formValidator;//验证规则
		include $this->display('message.html');
    } 
}
