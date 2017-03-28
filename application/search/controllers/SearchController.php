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

	
	public $searchModel;
	public $search_type;
	public function init()
	{
		$this->searchModel = D('Search');
		parent::init();
        error_reporting(E_ALL & ~E_NOTICE);
		
	}
	
	
	/**
	 *  搜索分页跳转传参
	 */
	public function searchAction()
	{	
		$stat = get_mo_config('mo_sphinx_stat');
		$mid = Controller::getParams('mid'); 											 
		$cid = Controller::getParams('cid'); 											
		$hiddens = Controller::getParams('hiddens'); 
		$keyword = Controller::getParams('keywords'); 
		$search_type = Controller::getParams('search_type'); 
		 
		$this -> redirect(HOST_NAME . 'search/Search/index/mid/'.$mid.'/cid/'.$cid.'/stat/'.$stat.'/keywords/'.$keyword.'/hiddens/'.$hiddens.'/search_type/'.$search_type);
	}
	
	
	/**
	 *  搜索
	 */
	public function indexAction()
	{	
		 if(Controller::getParams('hiddens') == 1 || $_GET['page'])				//触发提交事件防止刷新
		 { 
	    	 $stat = Controller::getParams('stat');										//搜索分支
			 $keyword = urldecode(trim(strip_tags(Controller::getParams('keywords'))));	 	//接收关键词
			 $mid = Controller::getParams('mid'); 											//模型id	 
			 $cid = Controller::getParams('cid'); 											//栏目id	
			 $search_type = Controller::getParams('search_type'); 							//搜索类型
			
			 
			 //模型ID 分支
			 switch($mid)
			 {
			 	case 1 : $modelTab = 'maintable'; break;	//文章
			 	case 2 : $modelTab = 'goods';     break;	//商品
			 	case a : $modelTab = 'special';   break;	//专题
			 	default : $modelTab = 'searchs'; break;	//全文
			 }
			 
			 $this -> searchModel -> updateSql($keyword,time(),$stat,$mid);		//修改点击量
			 $where = !empty($cid) ? " AND catgoryid = '$cid'" : null;			//栏目id过滤
	
			 if(isset($search_type) && $search_type == 1)
			 {	  
			 	 
				$cid = 0;
				$pid = 0;
				$modelid = 0;
				$seo = array(
					'title'=>get_mo_config('title'),
					'keywords'=> get_mo_config('keywords'),
					'description'=>get_mo_config('description'),
				);
				$search_info = get_cache('search_info','common');
				$dosearch = Controller::post('dosearch');
				$keyword = htmlspecialchars(addslashes(urldecode($keyword)));
				
				//有dosearch是防止刷新的
				if($dosearch && isset($search_info[get_client_ip()]) && ((time()-$search_info[get_client_ip()])<=get_mo_config('mo_search_time')))
				{
					closeWindodw('搜索间隔太短，请稍后搜索' );
				}
				else
				{
				    set_cache('search_info',array(get_client_ip()=>time()),'common');
				}
				$searchList = $this->searchModel->search(array('keyword'=> preg_replace('/\;|\#|\%|\"|\'/','',$keyword),'cid'=>$cid,'mid'=>$mid,'search_types' => $search_type));
				
			 }else{
					
				 if(isset($stat) && $stat == 2){
				 	
					 $searchList = $this -> searchModel -> searchResult($cid,$mid,$stat,$modelTab,$where,$keyword,$search_type); 
				 
				 }else{
				 	
					 //sphinx端口，ip
					 $dress = get_mo_config('mo_sphinx_dress');
		    	     $number = get_mo_config('mo_sphinx_number');
					 $datas = array(
					 	
					 	'mid' => $mid,
					 	'cid' => $cid,
					 	'stat' => $stat,
						'where' => $where,
					 	'dress' => $dress,
					 	'number' => $number,
					 	'keyword' => $keyword,
					    'modelTab' => $modelTab, 
					    'search_type' => $search_type,
					 ); 	
					 $searchList = $this -> searchModel -> sphinxSearch($datas);
				 }
			 }
		 }
		 $total = $searchList['total'];
		 $ids   = $searchList['ids']; 
		 include $this->display('search_result.html');
	}
	
	
	/**
	 *	整理搜索初始化数据
	 */
	/*
	public function getresultAction()
	{
	
		$result = $this -> searchModel -> selectInfo(); 
		foreach($result as $r){
			
			$cid = $r['categoryid'];
			$contentid = $r['goodsid'];
			$title = $r['goodsname'];
			$description = $r['brief'];
			$content = $r['content'];
			$keyword = $r['keywords'];
			$created = $r['created'];
		    $searchList = $this -> searchModel -> searchAdd(2,$cid,$contentid,$title,$description,$content,$keyword='',$created);
		}
	}
	*/
	
    /**
	 *	整理搜索初始化数据
	 */
	/*
	public function getresult_articleAction()
	{
	
		$result = $this -> searchModel -> selectInfo_article(); 
		foreach($result as $r){
			
			$cid = $r['categoryid'];
			$contentid = $r['id'];
			$title = $r['title'];
			$description = $r['description'];
			$content = $r['content'];
			$keyword = $r['keywords'];
			$created = $r['created'];
		    $this -> searchModel -> searchAdd(1,$cid,$contentid,$title,$description,$content,$keyword='',$created);
		}
	}
	*/

	//搜索纪念馆
    public function searchs2Action()
    {
        $keywords = urldecode(trim(strip_tags(Controller::getParams('keywords'))));     //接收关键词
        $sel = urldecode(trim(strip_tags(Controller::getParams('sel'))));     //接收关键词
        if(!isset($sel)){
            $sel = 1;
        }
        $seo = array();
        if($sel==1){
            $seo['title'] = "私人纪念馆搜索 - " . $keywords;
        }else if($sel == 2){
            $seo['title'] = "名人纪念馆搜索 - " . $keywords;
        }else{
            $seo['title'] = "私人纪念馆搜索 - " . $keywords;
        }

        include $this->display('search.html');die;
    }
	
}
