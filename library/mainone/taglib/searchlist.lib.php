<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  articeltag
 *
 *
 * @author     冯阳<fengyang@mail.b2b.cn>   2013/9/6 11:12
 * @filename   articeltag.lib  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0c
 *-------------------------------------------------------------------------------------
 */


class searchlist
{

	public function lib_searchlist($datas)
    {

    	 $mid         = isset($datas['mid'])       ?  $datas['mid']       : null;
		 $cid         = isset($datas['cid'])       ?  $datas['cid']       : null;
		 $stat        = isset($datas['stat'])      ?  $datas['stat']      : 0;
		 $ids         = isset($datas['id'])        ?  $datas['id']        : null;
		 $where       = isset($datas['where'])     ?  $datas['where']     : null;
		 $keyword     = isset($datas['keyword'])   ?  $datas['keyword']   : '爱站CMS';
		 $modelTab    = isset($datas['modelTab'])  ?  $datas['modelTab']  : 'searchs';
		 $total        = isset($datas['total'])    ?  $datas['total']     : 1;
		 $fenci        = isset($datas['fenci'])    ?  $datas['fenci']     : '爱站 CMS';
		 $from        = isset($datas['from'])      ?  $datas['from']      : '0';
    	 $limit       = isset($datas['row'])       ?  $datas['row']       : '10000000000000';
    	 $limit       = isset($datas['pagesize'])  ?  $datas['pagesize']  : $limit;
    	 $page        = isset($datas['page'])      ?  $datas['page']      : 1;
	     $types       = isset($datas['type'])      ?  $datas['type']      : 1;

    	 $dbconfig = get_config('database','default');
         
         $result = array();
	     if($types == 1){								//Like搜索

	     	    $searchparam = array( 
	     	    					   'cid' => $cid,
	     	                           'keywords' => $keyword,
	     	                           'startCount' => $from,
	     	    					   'pageSize' => $limit,
	     	                         );
			    //查询商品表
				if(isset($mid)&&$mid==2)
				{	
					$modelid = 2;     //标记按模型的标题搜索
					$result = D('Goods','goods')->getGoodsByKeywords($searchparam);
				}
				//查询文章表
				else if(isset($mid)&&($mid==1 || $mid > 2))
				{
					$modelid = 1;
					$result = D('Content','content')->searchArticleByKeywords($searchparam);
				}
				//查询专题表
				else
				{
					$modelid = 'a';
					$result = D('Special','special')->searchSpecialByKeywords($searchparam);
				}

	     }else if($types == 2){


	     	if(isset($stat) && $stat == 2){				//Mysql搜索

	     		 /**
	     		  *  针对不同的模型有不同的where条件
	     		  */
			     if($mid == 1){							 	 
			 	    $mid_where = "AND (mid > 2 OR mid=1)";
				 }else if(empty($mid)){
				 	$mid_where = '';
				 }else{
				 	$mid_where = "AND mid = '$mid'";
				 }
				
				 /**
				  *  针对new5模板的英文版指定栏目处理
				  */
	     	     if(!empty($cid)){
				 	
				 	$res = getCategoryIds($cid,true);  
				 	$cids = join(',', $res);
				 	$mid_where .= " AND cid in ($cids)";
				 }
				 
				 /**
				  *  匹配查询搜索表
				  */
                 $keywords = D('Search', 'search', 'home')->mysqlSearch($keyword);
                 $words_arr = explode(' ', trim($keywords));
                 $match_where = '';
                 foreach ($words_arr as $words) {
                     if ($match_where) {
                         $match_where .= ' AND ';
                     }
                     $match_where .= "MATCH(keywords,data) AGAINST( '$words' IN BOOLEAN MODE)";
                 }
				 $sqllimit    =  "SELECT * FROM " . $dbconfig['prefix'] ."searchs" . " WHERE $match_where $mid_where LIMIT $from,$limit";
                 $result_all  =  M('searchs') -> query($sqllimit);

			     if(!empty($result_all))
				 {
				 	
					 foreach($result_all as $k=>$row)
					 {
					 	
					 	 /**
					 	  *  每搜索一次后台统计所搜索的词信息
					 	  *  同步添加seo_search表    参数（模型id，分词，结果数，关键词）
					 	  */
//			 			 if($page == 1)   防止点击上一页，下一页刷新页面，重新添加数据
					 	 D('Search','search') -> seosearchPublic($mid,$fenci,$total,$keyword);		

					 	 $searchid = $row['contentid'];
                         
                         //搜索结果处理
					 	 $result[$k]['id'] 	 	     =	$row['contentid'];
                         $result[$k]['mid'] 	 	 =	$row['mid'];
                         $result[$k]['title'] 	 	 =	$row['title'];
                         $result[$k]['subtitle'] 	 =	$row['subtitle'];
                         $result[$k]['created'] 	 =	$row['created'];
                         //搜索结果补充
                         $result[$k]['categoryid'] 	 =	$this->getCatalog11($row['mid'],$row['contentid']);
                         $result[$k]['publishtime']  =	$this->getPublishtime11($row['mid'],$row['contentid']);
                         $result[$k]['publishopt']   =	$this->getPublishopt11($row['mid'],$row['contentid']);
                         $result[$k]['save_catalog'] =	$this->getsave_catalog($row['contentid']);
					 }

				 }else{

					 D('Search','search')-> seosearchPublic($mid,$fenci,$total,$keyword);		
				     return array();
				 }

	     	}else if(isset($stat) && $stat == 1){											//Sphinx搜索

	     		 
	     		 /**
				  *  针对new5模板的英文版指定栏目处理
				  */
	     	     if(!empty($cid)){
				 	
				 	$res = getCategoryIds($cid,true);  
				 	$cids = join(',', $res);
				 	$where['in'] = array('cid' => $cids);
				 }
				 
		         /**
		          *  不同的模型组织不同where条件
		          *  $mid = 1  => 查询maintable表 join article表
		          *  $mid = 2  => 查询goods表
		          *  $mid = 3  => 查询special表
		          *  $mid = 空 => 查询searchs表
		          */
		         switch($mid){

		         	case 1 : $where['in'] = array('id' => $ids); break;
		         	case 2 : $where['in'] = array('goodsid' => $ids); break;
		         	case a : $where['in'] = array('id' => $ids); break;
		         	case null : $where['in'] = array('contentid' => $ids); break;
		         	default : $where['in'] = array('id' => $ids); break;
		         }
		         
		         $result = M($modelTab) -> where($where) -> limit($from.','.$limit) -> select();

		         /**
		          *  全局搜索情况
		          */
	       	 	 if(empty($mid)){

	       	 	 	foreach($result as $k=>$m_id){

	       	 	 		switch($m_id['mid']){

				         	case 1 : $modelTab = 'maintable';  $where['in'] = array('id' => $ids); break;
				         	case 2 : $modelTab = 'goods';	    $where['in'] = array('goodsid' => $ids);    break;
				         	case a : $modelTab = 'special';    $where['in'] = array('id' => $ids);  break;
				         	case $m_id['mid'] > 2 : $modelTab = 'maintable'; $where['in'] = array('id' => $ids);break;
				         	case null : $modelTab = 'searchs';   $where['in'] = array('contentid' => $ids); break;
				         	default : $modelTab = 'searchs';   $where['in'] = array('contentid' => $ids); break;
				        }
	       	 	 	}
	       	 	 	$field = $m_id['mid'] == a ? 'click_num' : 'hits';
	       	 	 	$hits = M($modelTab) -> where($where) -> limit($from.','.$limit) -> select();
	       	 	 	foreach($hits as $count){

	       	 	 		$result[$k]['hits'] = $count[$field];
	       	 	 	}
			     }
		     }

	     }
//	     var_dump($result);
	     
	     
    	 /**
    	  * 搜索结果链接地址、点击量、缩略图补充  
    	  *   sphinx的搜索链接暂时有问题 ，没有可以判断的条件
    	  */
		 foreach($result as $k=>$v)
       	 {     
       	 	 /**
       	 	  *  模型id判断
       	 	  */
       	 	 if(empty($v['mid']))
       	 	 {
       	 	 	$v['mid'] = $modelid;   				  //标题搜索时定义$modelid   用于判断是商品，文章还是专题
       	 	 }
       	 	 if($v['mid'] == 2)
       	 	 {
       	 	 	//$stat表示搜索的类型，1为sphinx，此时商品的id为goodsid, 其它情况为id
       	 	 	if($types == 1 || $stat == 1){  		  // like搜索和sphinx搜索的时候
       	 	 		$id = $v['goodsid'];
       	 	 	}else if($stat == 2){   				  // mysql搜索时
       	 	 		$id = $v['id'];
       	 	 	}
       	 	 }else 
       	 	 {
       	 	 	$id = $v['id'];
       	 	 }
       	 	
             if($v['mid'] == 1){
                //url
                if ($v['publishopt'] == 1)
                {
                    $result[$k]['url']= $this -> getStaticUrl_article($v['categoryid'], $v['publishtime'], $id);
                }else
              {
                    $result[$k]['url'] = HOST_NAME.'content/Content/index/id/'.$id;
                }
                //click
                $content = M('maintable')->where(array('id' => $id)) -> getOne();
                $result[$k]['click'] = $content['hits'];
                //img 
                $result[$k]['thumb'] = object_to_array(json_decode(htmlspecialchars_decode(strval($content['thumb']))));
             }else if($v['mid'] == 2){
                
                //url
                if($v['publishopt'] == 1)
                {
                    $result[$k]['url']= $this -> getStaticUrl_goods($v['categoryid'], $v['created'], $id);
                }else
              {
                    $result[$k]['url'] = HOST_NAME.'goods/Goods/info/id/'.$id;
                }
                //click
                $goods = M('goods')->where(array('goodsid' => $id)) -> getOne();
                $result[$k]['click'] = $goods['hits'];
                //img
                $goods_pic = M('GoodsAlbum')->where(array('goodsid' => $id)) -> getOne();
                $result[$k]['thumb']['src'] = $goods_pic['photo'];
             }else if($v['mid'] == 'a'){
             	
                //url
                if($v['publishopt'] == 1)
                {
                    $result[$k]['url']= $this -> getStaticUrl_special($v['save_catalog']);

                }else
                {
                    $result[$k]['url'] = HOST_NAME.'special/Special/index/id/'.$id;
                }
                //click
                $special = M('special')->where(array('id' => $id)) -> getOne();
                $result[$k]['click'] = $special['click_num'];
                //img
                $result[$k]['src'] = $special['thumb_img'];
             }else{
                //url
                if ($v['publishopt'] == 1)
                {
                    $result[$k]['url']= $this -> getStaticUrl_article($v['categoryid'], $v['publishtime'], $id);
                }else
                {
                    $result[$k]['url'] = HOST_NAME.'content/Content/index/id/'.$id;
                }
                
                //click
                $content = M('maintable')->where(array('id' => $id)) -> getOne();
                $result[$k]['click'] = $content['hits'];
                //img 
                $result[$k]['thumb'] = object_to_array(json_decode(htmlspecialchars_decode(strval($content['thumb']))));
             }
             
             //高亮替换
            $result[$k]['keywords']  = str_replace($keyword,"<font color='red'>".$keyword."</font>",$keyword);
            $result[$k]['title'] 	   = str_replace($keyword,"<font color='red'>".$keyword."</font>",$v['title']);
            $result[$k]['name'] 	   = str_replace($keyword,"<font color='red'>".$keyword."</font>",$v['name']);
            $result[$k]['goodsname']  = str_replace($keyword,"<font color='red'>".$keyword."</font>",$v['goodsname']);
            $result[$k]['subtitle']	= str_replace($keyword,"<font color='red'>".$keyword."</font>",msubstr($v['subtitle'],0,150));
            $result[$k]['guide']		= str_replace($keyword,"<font color='red'>".$keyword."</font>",msubstr($v['guide'],0,150));
            $result[$k]['content']     = str_replace($keyword,"<font color='red'>".$keyword."</font>",msubstr($v['content'],0,150));
            $result[$k]['description'] = str_replace($keyword,"<font color='red'>".$keyword."</font>",msubstr($v['description'],0,150));
       	  } 
    	 return $result;
	}



    //根据已知条件获取栏目静态文件保存路径      文章
    public function getStaticUrl_article($categoryid, $publishtime, $id)
    {
        $catalog = $this->getCatalogByCategoryid($categoryid);
        $time = date("Y/m/d", $publishtime);
        $path = '/html/' . $catalog . '/' . $time . '/content_' . $id . '_1.html';
        return $path;
    }

    //根据已知条件获取栏目静态文件保存路径      商品
    public function getStaticUrl_goods($categoryid, $created, $id)
    {
        $catalog = $this->getCatalogByCategoryid($categoryid); 
        $time = date("Y/m/d", $created);
        $path = '/html/' . $catalog . '/' . $time . '/goods_' . $id . '.html';
        return $path;
    }

    //根据已知条件获取栏目静态文件保存路径      专题
    public function getStaticUrl_special($sava_catigry)
    {
        $path = '/html/special/' .$sava_catigry. '/index.html';
        return $path;
    }

    //根据栏目ID获取栏目文件保存目录
    public function getCatalogByCategoryid($id)
    {
    	$dbconfig = get_config('database','default');
        $sql = "SELECT filepath FROM " .$dbconfig['prefix']."category WHERE id = $id";
        $result = M('category') -> query($sql);
        return $result['0']['filepath'];
    }

    public function getCatalog11($mid,$id)
    {
    	$dbconfig = get_config('database','default');
    	if($mid == 1)
        $sql = "SELECT categoryid FROM " .$dbconfig['prefix']."maintable WHERE id = $id";
        else if($mid == 2)
        $sql = "SELECT categoryid FROM " .$dbconfig['prefix']."goods WHERE goodsid = $id";
        $result = M('category') -> query($sql);
        return $result['0']['categoryid'];
    }

    public function getPublishtime11($mid,$id)
    {
    	$dbconfig = get_config('database','default');
    	if($mid == 1)
        $sql = "SELECT publishtime FROM " .$dbconfig['prefix']."maintable WHERE id = $id";
        else if($mid == 2)
        $sql = "SELECT publishtime FROM " .$dbconfig['prefix']."goods WHERE goodsid = $id";
        $result = M('category') -> query($sql);
        return $result['0']['publishtime'];
    }

    public function getPublishopt11($mid,$id)
    {
    	$dbconfig = get_config('database','default');
    	if($mid == 1)
        $sql = "SELECT publishopt FROM " .$dbconfig['prefix']."maintable WHERE id = $id";
        else if($mid == 2)
        $sql = "SELECT publishopt FROM " .$dbconfig['prefix']."goods WHERE goodsid = $id";
        else 
       $sql = "SELECT publishopt FROM " .$dbconfig['prefix']."special WHERE id = $id";
        $result = M('category') -> query($sql);
        return $result['0']['publishopt'];
    }

	public function getsave_catalog($id)
    {
    	$dbconfig = get_config('database','default');
        $sql = "SELECT save_catalog FROM " .$dbconfig['prefix']."special WHERE id = $id";
        $result = M('special') -> query($sql);
        return $result['0']['save_catalog'];
    }
}
