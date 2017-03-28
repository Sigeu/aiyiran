<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *手机站点设置
 * 
 * 文件修改记录：
 * <br>王少辰  2013-9-16 上午08:39:39 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-16 上午08:39:39
 * @filename   MobilesiteController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: MobilesiteController.php 4767 2014-10-13 02:55:28Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class MobilesiteController extends AdminController {
    
    public $articleListShowOptions = array(
        1 => array('title' => '缩略图 + 文章标题'),
        2 => array('title' => '发布时间'),
        3 => array('title' => '点击量'),
        4 => array('title' => '文章简介'),
    );
    
    public $productListShowOptions = array(
        1 => array('title' => '缩略图 + 商品名称'),
        2 => array('title' => '商品品牌'),
        3 => array('title' => '商品价格'),
        4 => array('title' => '点击量'),
        5 => array('title' => '商品简介'),
    );
    
    public $articleContentShowOptions = array(
        1 => array('title' => '发布时间'),
        2 => array('title' => '点击量'),
        3 => array('title' => '文章简介 + 详细内容'),
    );
    
    public function baseInit() {
		$base_set = M('MobileWebset')->field('pay')->getOne();
        if (!isset($base_set['pay']) || empty($base_set['pay'])) {
            redirect(URL_HOST.'/admin', "对不起，你还没有购买手机站功能模块", 1);
        }
        parent::baseInit();         
    }
    
    /**
     * 手机站点设置
     * @access public
     * @return string
     */
    public function indexAction() {
        /*
        *获取模板下拉列表数据
        */
        $tpl_model = D('Mobiletpl', 'template');
        $tpl_list  = $tpl_model->getTemplateFolder();//所有模板目录
        $tpl_conf  = $tpl_model->getTemplateConf($tpl_list);   //所有模板目录配置文件
        
        /*
        *设置当前选中模板
        */
        $nowstyle =  get_cache('mobile_template_style','common','home');
        if (!$nowstyle) {
            $nowstyle = 'mobile/default';
        }
        $style_arr = explode('/', $nowstyle);
        $template = end($style_arr);
        
        //获取手机站点基本信息
        $webset = M('MobileWebset')->getOne();
        
        $allow_type = $this -> getAllowType(1);
        //设置logo图片上传插件
        $setting = array(
            'limit'       => 2,
            'type'        => $allow_type,
            'local'       => true,            //是否显示本地图库
            'folder'      => true            //是否显示目录浏览
        );
        $setting['setting'] = base64_encode(serialize($setting));

        $order = array('order' => 'show_order');//排序条件
        
        //搜索设置信息
        $search = M('MobileSearch')->select($order);
        
        //互动设置信息
        $contact =  M('MobileContact')->select();
        
        //导航设置信息
        $header = M('MobileHeader')->select($order);
        
        //首页设置信息
        $index = M('MobileIndex')->select($order);
        
        $category = D('Category', 'content')->getCategoryTree();//栏目下拉列表数据
        $leave =  M('MixModel') -> where('flag = 1') -> select();//留言分类下拉列表数据
        $model = M('categiry');
        $position = M('Position') -> join($model->tablePrefix.'category c on c.id=cat_id')->where('model > 0')->select();//推荐位下拉列表数据
        $goods_position = M('Position') -> join($model->tablePrefix.'category c on c.id=cat_id')->where('model = 2') -> select();//推荐位下拉列表数据
        $article_position = M('Position') -> join($model->tablePrefix.'category c on c.id=cat_id')->where('model != 2') -> select();//推荐位下拉列表数据
        $positions = array(
            1 => $position,
            2 => $article_position,
            3 => $goods_position
        );
        //文章列表显示内容选项
        $article_list_show = $this->manageCheckList ($webset['article_list_show'], $this->articleListShowOptions);
        //产品列表显示内容选项
        $product_list_show = $this->manageCheckList ($webset['product_list_show'], $this->productListShowOptions);
        //文章内容显示内容选项
        $article_content_show = $this->manageCheckList ($webset['article_content_show'], $this->articleContentShowOptions);
        //手机站预览
        //$mobilesite_url = URL_HOST . 'mobile';
        $this -> assign('tpl_conf', $tpl_conf);
        $this -> assign('webset',$webset);
        $this -> assign('setting',$setting);
        $this -> assign('template',$template);
        $this -> assign('search',$search);
        $this -> assign('contact',$contact);
        $this -> assign('leave',$leave);
        $this -> assign('index',$index);
        $this -> assign('positions',$positions);
        $this -> assign('category',$category);
        $this -> assign('article_list',$article_list_show);
        $this -> assign('product_list',$product_list_show);
        $this -> assign('article_content',$article_content_show);
        $this -> assign('header', $header);
        //$this -> assign('mobilesite_url', $mobilesite_url);
        $this->display('extensions/mobilesite/index.html');
    }
    
    public function updateSiteAction () {
        if (isset($_POST) && $_POST) {
            /*
            *替换模板
            */
            if (isset($_POST['site']['template']) && $_POST['site']['template']) {
                $template = $_POST['site']['template'];
                if (empty($template)) {
                    $template = 'default';
                }
                $this->replaceTemplate ($template);
            }
            /*
            *处理手机站主表信息
            */
            if (isset($_POST['site']['base']) && $_POST['site']['base']) {
                $basePrams = $_POST['site']['base'];
                /*
                *文章列表显示信息
                */
                if (isset($basePrams['article_list_show']) && $basePrams['article_list_show']) {
                    $article_list_show = $basePrams['article_list_show'];
                    $basePrams['article_list_show'] = $this->arrToStr($article_list_show);
                }
                /*
                *商品列表显示信息
                */
                if (isset($basePrams['product_list_show']) && $basePrams['product_list_show']) {
                    $product_list_show = $basePrams['product_list_show'];
                    $basePrams['product_list_show'] = $this->arrToStr($product_list_show);
                }
                /*
                *文章内容显示信息
                */
                if (isset($basePrams['article_content_show']) && $basePrams['article_content_show']) {
                    $article_content_show = $basePrams['article_content_show'];
                    $basePrams['article_content_show'] = $this->arrToStr($article_content_show);
                }
                
                /*
                *logo处理
                */
                if (isset($_POST['is_del']) && !empty($_POST['is_del'])) {
                    $basePrams['logo'] = '';
                    $basePrams['logo_alt'] = '';
                }
                
                if (isset($_POST['logo_alt'])) {
                    $basePrams['logo_alt'] = $_POST['logo_alt'];
                }
                if (isset($_POST['accessory'])) {
                    $file_info = $this -> uploadLogo();
                    if ($file_info) {
                        $basePrams['logo'] = 'mobile_logo/' . $file_info[0]['path'];//上传后logo图片路径
                        $basePrams['logo_alt'] = $file_info[0]['alt'];//上传后logo图片alt
                    }
                }
                //更新手机站基本设置
                M('MobileWebset')->update(array('id'=>1), $basePrams);
            }
            
            /*
            *导航设置
            */
            M('MobileHeader')->delete();//清空原有导航数据
            if (isset ($_POST['site']['header']) && $_POST['site']['header']) {
                $headerParams = $_POST['site']['header'];
                 
                if (!is_array($headerParams)) {
                    $headerParams = array();
                }
                //添加新的导航数据
                M('MobileHeader')->addAll($headerParams);
            }
            
            if (isset ($_POST['site']['search']) && $_POST['site']['search']) {
                $searchParams = $_POST['site']['search'];
                if (is_array($searchParams)) {
                /*更新搜索设置*/
                    foreach ($searchParams as $key => $val) {
                        if (is_array($val)) {
                            M('MobileSearch')->update("id=$key", $val);
                        }
                    }
                }
            }
            
            if (isset ($_POST['site']['contact']) && $_POST['site']['contact']) {
                $contactParams = $_POST['site']['contact'];
                if (is_array($contactParams)) {
                /*更新互动设置*/
                    foreach ($contactParams as $key => $val) {
                        if (is_array($val)) {
                            M('MobileContact')->update("id=$key", $val);
                        }
                    }
                }
            }
            
            if (isset ($_POST['site']['index']) && $_POST['site']['index']) {
                $indexParams = $_POST['site']['index'];
                if (is_array($indexParams)) {
                /*更新首页设置*/
                    foreach ($indexParams as $key => $val) {
                        if (is_array($val)) {
                            M('MobileIndex')->update("id=$key", $val);
                        }
                    }
                }
            }
            $this->dialog("/extensions/mobilesite/index",'success','设置成功！');
        } 
    }
    
    /*手机站预览*/
    public function mobileScanAction () {
        $mobilesite_url = URL_HOST . 'mobile';
        $this -> assign('mobilesite_url', $mobilesite_url);
        $this->display('extensions/mobilesite/scan.html');
    }
    
    
    /*
    *处理显示内容(checkbox)选项
    */
    public function manageCheckList ($checked_str, $list_options) {
        $list_checked = explode(',', $checked_str);
        if (empty($list_checked)) {
            $list_checked = array();
        }
        foreach ($list_options as $key => $val) {
            if (in_array($key, $list_checked)) {
                $list_options[$key]['checked'] = 1;
            }else {
                $list_options[$key]['checked'] = 0;
            }
        }
        return $list_options;
    }
    
    
    /**
	 * 替换模板
	 */
	public function replaceTemplate ($stylename) {
		/*暂停当前模板*/
		$nowstyle =  get_cache('mobile_template_style','common','home');
        if (!$nowstyle) {
            $nowstyle = 'moblie/default';
        }
		$oldsetArr = $this->import_style_config($nowstyle, true);
		$this->setFlag($nowstyle, $oldsetArr, 0);
		/*设置新模板使用中*/
        $stylename = 'mobile/'.$stylename;
		$nowsetArr = $this->import_style_config($stylename,true);
		$this->setFlag($stylename, $nowsetArr, 1);
        //更换当前模板
		set_cache('mobile_template_style', $stylename, 'common', 0, "home"); //更新模板样式缓存
	}
    
    /**
	 * 设置模板状态开始
	 * @param string $style
	 * @param string $disable
	 */
	public function setFlag($stylename='default',$nowsetarr=array(),$disable=1)
	{
		if (file_exists($this->import_style_config($stylename,false))) {
			$nowsetarr = empty($nowsetarr) ? $this->import_style_config($stylename,true) : $nowsetarr;
			$nowsetarr['identify'] = $stylename;
			$nowsetarr['disable'] = $disable;
		}
		else {
			$nowsetarr = empty($nowsetarr) ? array('name'=>'未知模板','disable'=>$disable, 'identify'=>$stylename) : $nowsetarr ;
		}
		file_put_contents($this->import_style_config($stylename,false), '<?php return '.var_export($nowsetarr, true).';?>');
	}
    
    /*
    *处理数组为字符串
    *@param array $arr
    *@return string
    */
    public function arrToStr ($arr) {
        $str = '';
        if (is_array($arr)) {
            foreach ($arr as $val) {
                if ($str != '') {
                    $str .= ',';
                }
                $str .= $val;
            }
        }
        return $str;
    }
    
    /**
     * logo上传
     */
    public function uploadLogo () {
        $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
        if($accessory) {
            $temp[] = current($accessory);
            return moUploadAccessory(array('file'=>$temp, 'folder'=>'mobile_logo'));
        }
        return array();
    }
    
    /**
     * 图片上传
     */
    public function upload () {
        $notdelete = array();
        $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
        if($accessory) {
            foreach ($accessory as $key => $val) {
                $temp[0] = $val;
                $info = moUploadAccessory(array('file'=>$temp, 'folder'=>'app'));
                $info = $info ? $info[0] : array();
                if (!$info) {
                    continue;
                }
                $params = array(
                    'name' => $info['selfname'],
                    'path' => $info['path'],
                    'image_alt' => $info['selfname'],
                    'type' => $val['type']
                );
                if (isset($val['id'])) {
                    $notdelete[] = $val['id'];
                    M('appImage')->update(array('id' => $val['id']), $params);
                } else {
                    $imageid = M('appImage')->create($params);
                    $notdelete[] = $imageid;
                }
            }
        }
        $oldids = isset($_POST['oldids']) ? $_POST['oldids'] : array();
        $notdelete = array_merge($notdelete, $oldids);
        $where = array();
        if ($notdelete) {
            $where = array('notin' => array('id' => join(',', $notdelete)));
        }
        M('appImage')->delete($where);
    }
    
    public function appsetAction () {
        if ($_POST) {
           $this->upload();
           $result = $this->createApp ();
           if ($result) {
                $this->dialog("/extensions/mobilesite/appset",'success','修改成功！');
           }
        }
        
        $domain = get_key('domain');
        $domain_name = '';
        if ($domain) {
            $domain_name = isset($domain[0]) ? $domain[0] : '';
        }
        $this -> assign('domain_name', $domain_name);
        
        $app = M('app')->where(array('id' => 1))->getOne();
        $this -> assign('app', $app);
        $status = 0;
        if ($app) {
            $status = isset($app['status']) ? $app['status'] : 0;
            if ($status == 1) {//处理中，再次请求并更新状态
                $data = array('key' => $app['index']);
                $url = 'http://passport.b2b.cn/webservice/mobile/mobileappget.ashx';//生成状态请求url
                //$url = 'http://passport.tc.mainone.cn/webservice/mobile/mobileappget.ashx';//内网生成状态请求url
                $return = $this->sendPost($url, $data);
                if ($return) {
                    $params = array();
                    $android_status = isset($return['android_status']) ? $return['android_status'] : 0;//安卓app生成状态
                    $ios_status = isset($return['ios_status']) ? $return['ios_status'] : 0;//ios app生成状态
                    if ($android_status == 1 || $android_status == 2 || $ios_status == 1 || $ios_status == 2) {//待处理与处理中
                        //$params['status'] = 1;//处理中
                        $status = 1;
                    } else if ($android_status == 4 && $ios_status == 4) {
                        //$params['status'] = 2;//成功
                        $status = 2;
                    } else if ($android_status == 3 || $ios_status == 3) {
                        //$params['status'] = 3;//失败
                        $status = 3;
                    }
                    
                    $params['status'] = $status;
                    if ($status == 2) {//成功后更新url
                        $params['android_url'] = isset($return['android_url']) ? $return['android_url'] : '';
                        $params['ios_url'] = isset($return['ios_url']) ? $return['ios_url'] : '';
                        $params['ios_file_url'] = isset($return['ios_ipaurl']) ? $return['ios_ipaurl'] : '';
                    }
                    M('app')->update(array('id' => 1), $params);
                }
            }
        }
        $status_show = '未生成';
        if ($status == 1) {
            $status_show = '处理中';
        } else if ($status == 2) {
            $status_show = '生成成功';
        } else if ($status == 3) {
            $status_show = '生成失败';
        }
        $this -> assign('status_show', $status_show);
        $appimage = M('appImage')->where(array('type' => 1))->getOne();
        $leadimages = M('appImage')->select(array('where' => array('type' => 2)));
        $startimage = M('appImage')->where(array('type' => 3))->getOne();
        $allow_type = $this -> getAllowType(1);
        //设置logo图片上传插件
        $setting = array(
            'limit'       => 10,
            'type'        => $allow_type,
            'local'       => true,            //是否显示本地图库
            'folder'      => true            //是否显示目录浏览
        );
        $setting['setting'] = base64_encode(serialize($setting));
        $this -> assign('appimage', $appimage);
        $this -> assign('leadimages', $leadimages);
        $this -> assign('startimage', $startimage);
        $this -> assign('setting', $setting);
        $this->display('extensions/mobilesite/appset.html');
    }
    
    function createApp () {
        $name = $this->getParams('name', '');
        
        //$index = $this->getParams('index', '');
        $domain = get_key('domain');
        $domain_name = '';
        if ($domain) {
            $domain_name = isset($domain[0]) ? $domain[0] : '';
        }
        $index = "http://" . $domain_name . "/mobile?m=app";
        
        $cart = $this->getParams('cart', '');
        $sort = $this->getParams('sort', '');
        $center = $this->getParams('center', '');
        
        $index_name = $this->getParams('index_name', '');
        $cart_name = $this->getParams('cart_name', '');
        $sort_name = $this->getParams('sort_name', '');
        $center_name = $this->getParams('center_name', '');
        
        $appimage = M('appImage')->where(array('type' => 1))->getOne();
        $baseurl = URL_STATIC_UPLOAD . 'app/';
        $iconpath = $appimage ?  $baseurl. $appimage['path'] : '';
        $lead = '';
        $leadimages = M('appImage')->select(array('where' => array('type' => 2), 'order' => 'id asc', 'limit' => 10));
        if ($leadimages) {
            foreach ($leadimages as $key => $val) {
                if ($lead) {
                    $lead .= ',';
                }
                $lead .= $baseurl. $val['path'];
            }
        }
        
        $startimage = M('appImage')->where(array('type' => 3))->getOne();
        $startpath = $startimage ?  $baseurl. $startimage['path'] : '';
        $data = array(
            'name' => $name,//app名称
            'index' => $index,//主页地址
            'cart' => $cart,//购物车地址
            'sort' => $sort,//商品分类地址
            'center' => $center,//个人中心地址
            'index_name' => $index_name,//首页名称
            'cart_name' => $cart_name,//购物车名称
            'sort_name' => $sort_name,//商品分类名称
            'center_name' => $center_name,//个人中心名称
            'icon' => $iconpath,//icon图，单张
            'lead' => $lead,//引导图，多张
            'start' => $startpath,//开机页面图。单张
            'type' => 2
        );
        
        $url = 'http://passport.b2b.cn/webservice/mobile/appsend.ashx';//数据传输url
        //$url = 'http://passport.tc.mainone.cn/webservice/mobile/appsend.ashx';//内网数据传输url
        $result = $this->sendPost($url, $data);
        $params = array(
            'id' => 1,
            'name' => $name,
            'index' => $index,
            'cart' => $cart,
            'sort' => $sort,
            'center' => $center,
            'index_name' => $index_name,
            'cart_name' => $cart_name,
            'sort_name' => $sort_name,
            'center_name' => $center_name,
            'status' => 1,//待处理
        );
        $app = M('app')->where(array('id' => 1))->getOne();
        if ($app) {
            $result = M('app')->update(array('id' => 1), $params);
        } else {
            $result = M('app')->create($params);
        }
        return true;
    }
    
    function sendPost($url, $post_data){
        $postData = http_build_query($post_data, '', '&'); 
        $options = array(
            'http' =>array(
                'method'=>"POST",
                'header'=>"Content-type: application/x-www-form-urlencoded ",
                'content' => $postData,
                'timeout' => 15 * 60,
            )
        );
        //创建并返回一个流的资源
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $data = json_decode($result, true);
        return $data;
    }
    
    
    function choseUrlAction () {
        $system = $this->getMobileSystem();
        $url = HOST_NAME;
        $app = M('app')->where(array('id' => 1))->getOne();
        if ($app) {
            if ($system == 1) {//
                $download = $this->getParams('download', 0);
                if ($download == 1) {//下载
                    $url = isset($app['ios_file_url']) ? $app['ios_file_url'] : HOST_NAME;
                } else {//安装
                    $url = isset($app['ios_url']) ? $app['ios_url'] : HOST_NAME;
                }
            } else {
                $url = isset($app['android_url']) ? $app['android_url'] : HOST_NAME;
            }
        }
        $this->redirect($url);
        exit;
    }
    
    function getMobileSystem() {
       $agent = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/ipad/i',$agent) || preg_match('/iphone\s*os/i',$agent)) {
          return 1;//ios
       } else if (preg_match('/android/i',$agent)) {
          return 2;//android
       }
       return 3;//其他
    }


}
