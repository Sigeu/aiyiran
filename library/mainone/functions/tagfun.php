<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * tagfun.php
 *
 * 标签函数
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-2-27 下午4:35:57
 * @filename   tagfun.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

/**
 * 获取栏目URL
 * @param int $cid 栏目ID
 * @param string $filepath 栏目首页静态文件存放目录(或外链地址)
 * @param int $columnoption 栏目页选项 1：链接到栏目首页静态页，2：链接到栏目列表第一页，3：链接到栏目首页动态页
 * @param string $url 栏目首页动态页访问地址（不带栏目id）
 * @param string $urltype 栏目列表页访问地址（可为静态可为动态需字符串替换'$cid' => $cid）
 * @param string $columnattr 栏目属性 1：最终列表栏目，2：频道封面，3：外部链接，4：单页栏目
 */
function getCategoryUrl($cid,$filepath,$columnoption,$url='category/Category/index',$urltype='category/Category/list/cid/$cid',$columnattr = 1)
{
	/*
    *$columnattr栏目属性
    *1：最终列表栏目
    *2：频道封面
    *3：外部链接
    *4：单页栏目
    */
	if($columnattr == 3)
	{//外部链接：直接读取外部链接url
	   $resultUrl = $filepath;
	}
	else
	{

		$resultUrl = '';
        /*
        *$columnoption：栏目页选项
        *1：链接到栏目首页静态页
        *2：链接到栏目列表第一页
        *3：链接到栏目首页动态页
        */
		if($columnoption == 1)
		{//首页静态页
			$resultUrl = HOST_NAME.'html/'.$filepath;
		}
		elseif ($columnoption == 2)
		{//栏目列表页
			$urltype = str_replace('$cid', $cid, $urltype);
			$resultUrl = HOST_NAME.$urltype;
		}
		if($columnoption == 3)
		{//栏目首页动态页
			$resultUrl = HOST_NAME.$url.'/cid/'.$cid;
		}
	}
	return $resultUrl;
}
/**
 * 获取文章URL
 * @param int $id 文章ID
 * @param string $filepath 静态文件存放目录
 * @param int $publishshot 浏览类型: 1 连接到默认页，2,列表首页，3，动态浏览
 * @param int $columnoption
 * @param string $url 访问的路径
 */
function getArticleUrl($id,$filepath,$publishshot,$url='content/Content/index',$urltype='content_$id_1.html',$createTime=0)
{
	$resultUrl = '';
	if ($publishshot == 1)
	{
		$urltype = str_replace('$id', $id, $urltype);
		$filepath = $filepath.'/'.date("Y/m/d",$createTime);
		$resultUrl = HOST_NAME.'html/'.$filepath.'/'.$urltype;
	}
	else
	{
		$resultUrl = HOST_NAME.$url.'/id/'.$id;
	}
	return $resultUrl;

}

/**
 *
 * @param string $str  字符串
 * @param int $length  要截取的长度
 * @param string $ext  后缀
 * @param int $start   开始位置
 * @param stirng $charset  字符集
 * @param boolen $suffix  是否要后缀
 * @return string 返回值
 */
function csubstr($str, $length, $ext='...', $start=0,$charset="utf-8", $suffix=true)
{
   if(function_exists("mb_substr"))
   {
       if(mb_strlen($str, $charset) <= $length) return $str;
       $slice = mb_substr($str, $start, $length, $charset);
   }
   else
   {
       $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
       $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
       $re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
       $re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
       preg_match_all($re[$charset], $str, $match);
       if(count($match[0]) <= $length) return $str;
       $slice = join("",array_slice($match[0], $start, $length));
   }
   if($suffix) return $slice.$ext;
   return $slice;
}

/**
* 可以统计中文字符串长度的函数
* @param $str 要计算长度的字符串
* @param $type 计算长度类型，0(默认)表示一个中文算一个字符，1表示一个中文算两个字符
*
*/
function abslength($str)
{
    if(empty($str))
	{
        return 0;
    }
    if(function_exists('mb_strlen'))
	{
        return mb_strlen($str,'utf-8');
    }
    else
	{
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}
/**
 * 通过栏目ID获取栏目信息
 * @param int $cid
 *  return Array
	(
		[id] => 394
		[pid] => 0
		[catname] => 政策法规
		[model] => 1
		[filepath] => zhengcefagui
		[indextpl] => index_shmz.html
		[columntpl] => list_bj.html
		[contenttpl] => content_xwjh.html
		[isnav] => 1
		[columnoption] => 3
		[dirpath] => 1
		[columnattr] => 1
		[columncross] => 1
		[crossid] =>
		[ordernum] => 0
		[seo_title] =>
		[seo_keywords] =>
		[seo_description] =>
		[created] => 1372905725
		[content] =>
	)
 */
function cid2info($cid)
{
	$result = M('category')->where(array('id'=>$cid))->getOne();
	return $result;
}

/**
 * 通过广告位ID获取广告位信息
 * @param int $adposid
 *  return Array
 (
 [id] => 115
 [adname] => '首页主广告'
 [adtypeid] => 3
 [useclumn] => 0
 [adsize] => 618,276
 [addescript] => '这是用于展示的首页主广告'
 [adtypename] => '轮播广告'
 [clumnname] => '不限栏目'
 [fontnum] => 0
 [adnum] => 3
 [adpos] => 118,210
 [pos] => 1
 )
 */
function adposid2info($adposid)
{
	$result = M('adposition')->where(array('id'=>$adposid))->getOne();
	return $result;
}

/**
 * 通过栏目ID获取栏目的名字
 *  @param int $cid 栏目ID
 */

function cid2name($cid)
{
	$result = cid2info($cid);
	return $result['catname'];
}

/**
 * 获取logo
 */
function logo()
{
	$file = get_mo_config('mo_logo_dir');
	$_file = app::formatPath(PATH_STATIC_UPLOAD.$file,false);
	if(is_file($_file))
		return UPLOAD_PATH.$file;
	else
		return URL_ADMIN_TPL.'images/default_logo.png';
}

/**
 * 获取logo alt
 */
function logoAlt()
{
    $logo_alt = get_mo_config('mo_logo_alt');
	return $logo_alt ? $logo_alt : '';
}

/**
 * 获取域名
 */
function host()
{
	$host = get_mo_config('mo_basehost');
	return $host ? $host : URL_HOST;
}

/**
 *获取某个栏目下"更多"的URL
 **  @param int $type 类型:默认为空（文章的最多）,goods(商品最多)
 **  @param int $cid 栏目ID
 */
function getMoreUrl($cid,$type='')
{
	if($cid)
	{
		$url='';
		$urltype='';
		if($type=='goods')
		{
			//$url='goods/Goods/list';
			//$urltype = 'goodslist_$cid_1.html';
			//$urltype='goods/Goods/index';
			$urltype = 'category/Category/list/cid/$cid';//商品和文章使用相同的形式
			$url='category/Category/index';

		}
		else
		{
			$urltype = 'category/Category/list/cid/$cid';
			$url='category/Category/index';
			//$urltype='contetnlist_$cid_1.html';
		}
		$categoryInfo = cid2info($cid);
		if(!empty($categoryInfo))
		{
          $moreurl = getCategoryUrl($categoryInfo['id'], $categoryInfo['filepath'], $categoryInfo['columnoption'],$url,$urltype,$categoryInfo['columnattr']);
		  return $moreurl;
		}
		else
		{
			return HOST_NAME;
		}
	}

}
/**
 *获取某个栏目下"分页"的URL
 **  @param int $type 类型:默认为空（文章的最多）,goods(商品最多)
 **  @param int $cid 栏目ID
 */
function getPageUrl($cidinfo,$pagevar='page')
{
	if($cidinfo['id'])
	{
		$url='';
		$urltype='';
		if($cidinfo['model']==2)
		{
			//$url='goods/Goods/index/'.$pagevar.'/$page';
			//$urltype='goods/Goods/list/'.$pagevar.'/$page';
			//$urltype = 'goodslist_$cid_$page.html';
			$url='category/Category/index/'.$pagevar.'/$page';//商品和文章使用了相同的列表和栏目形式
			//$urltype='contetnlist_$cid__$page.html';
			$urltype = 'category/Category/list/cid/$cid/'.$pagevar.'/$page';
		}
		else
		{
			$url='category/Category/index/'.$pagevar.'/$page';
			//$urltype='contetnlist_$cid__$page.html';
			$urltype = 'category/Category/list/cid/$cid/'.$pagevar.'/$page';
		}
		if(!empty($cidinfo))
		{
          $moreurl = getCategoryUrl($cidinfo['id'], $cidinfo['filepath'], $cidinfo['columnoption'],$url,$urltype);
		  return $moreurl;
		}
		return '';

	}
}
/**
 *获取某个内容下"分页"的URL

 */
function getContentPageUrl($id,$count,$publishshot,$filepath,$url='content/Content/index/cpage/$cpage',$urltype='content_$id_$cpage.html',$currentpage=0,$created)
{

	if($currentpage)
	{
		$url = str_replace('$cpage',$currentpage,$url);
		$urltype = str_replace('$cpage',$currentpage,$urltype);
		$pageurl[] = getArticleUrl($id,$filepath,$publishshot,$url,$urltype,$created);
	}
	else
	{
		for($i=1;$i<=$count;$i++)
	    {
			$url = str_replace('$cpage',$i,$url);
			$urltype = str_replace('$cpage',$i,$urltype);
			$pageurl[] = getArticleUrl($id,$filepath,$publishshot,$url,$urltype,$created);
	    }
	}
	return $pageurl;
}

/**
 * 获取商品URL
 * @param int $id 栏目ID
 * @param string $filepath 静态文件存放目录
 * @param int $type 浏览类型: 1 连接到默认页，2,列表首页，3，动态浏览
 * @param int $columnoption
 * @param string $url 访问的路径
 */
function getGoodsListUrl($cid,$filepath,$columnoption,$url='goods/Goods/index',$urltype='goodslist_$cid_1.html')
{
    $resultUrl = '';
	if($columnoption == 1)
	{
		$resultUrl = HOST_NAME.'html/'.$filepath;
	}
	elseif ($columnoption == 2)
	{
		$urltype = str_replace('$cid', $cid, $urltype);
		$resultUrl = HOST_NAME.'html/'.$filepath.DS.$urltype;
	}
    else if($columnoption == 3) {
		$resultUrl = HOST_NAME.$url.'/cid/'.$cid;
	}
	return $resultUrl;
}

/**
 * 获取商品URL
 * @param int $id 商品ID
 * @param string $filepath 静态文件存放目录
 * @param int $publishshot 浏览类型: 1 连接到默认页，2,列表首页，3，动态浏览
 * @param int $columnoption
 * @param string $url 访问的路径
 */
function getGoodsUrl($goodsid,$filepath,$publishshot,$url='goods/Goods/info',$urltype='goods_$id.html',$createTime=0)
{
	if ($publishshot == 1)
	{
		$urltype = str_replace('$id', $goodsid, $urltype);
		$filepath = $filepath.'/'.date("Y/m/d",$createTime);
		$resultUrl = HOST_NAME.'html/'.$filepath.'/'.$urltype;
	}
	else
	{
		$resultUrl = HOST_NAME.$url.'/id/'.$goodsid;
	}
	return $resultUrl;
}
/**
**获取内容的发布状态
**/

function getContentInfo($id,$type=1)
{
	if($type==2)
	{
		$result = M('goods')->where(array('goodsid'=>$id))->getOne();
	}
	else
	{
		$result = M('maintable')->where(array('id'=>$id))->getOne();
	}
	return $result;
}
/**
获取当前栏目的的子ID
*/
function getCategoryIds($pid=0,$have=false,$t=-1)
{
	$obj = new getCate();
	return $obj->getCategoryIds($pid,$have,$t);
}

/**
获取当前栏目的一级子ID
*/
function getChildCategoryIds($pid=0)
{
	$obj = new getCate();
	return $obj->getChildCategoryIds($pid);
}

/**
获取当前栏目的的顶级
*/
function getPid($sid=0)
{
	$obj = new getCate();
	return $obj->getPid($sid);
}

/* 返回距离现在时间的格式，如1秒前,1分前,1小时前,1天前,1周前*
* 话说$time是一个时间戳
*/
 function maktimes($time)
 {
    $t=time()-$time;
     $f=array(
         '31536000'=> '年',
         '2592000' => '个月',
         '604800'  => '星期',
         '86400'   => '天',
         '3600'    => '小时',
         '60'      => '分钟',
         '1'       => '秒'
     );
     foreach ($f as $k=>$v){
        if (0 !=$c=floor($t/(int)$k)){
             return $c.$v.'前';
         }
     }
   }

/**
 * 通过栏目ID获取栏目信息
 * @param int $cid
 */
function uid2info($uid)
{
	$result = M('member')->where(array('id'=>$uid))->getOne();
	return $result;
}
/**
 * 通过栏目ID获取栏目信息
 * @param int $cid
 */
function uid2admininfo($uid)
{
	$result = M('admin')->where(array('id'=>$uid))->getOne();
	return $result;
}

/*获取当前栏目seo
* @param int $cid
*/
function seo($cid)
{
	$catInfo = cid2Info($cid);
	$seo = array(
		'title'=> $catInfo['seo_title'] ? $catInfo['seo_title'] : $catInfo['catname'],
		'keywords'=> $catInfo['seo_keywords'],
		'description'=> $catInfo['seo_description'],
	);
	return $seo;
}
/**
 * 通过栏目ID获取用户名
 *  @param int $cid 用户ID
 */
function uid2name($uid)
{
	$result = uid2info($uid);
	return $result['username'];
}
/**
 * 通过栏目ID获取栏目的名字
 *  @param int $cid 栏目ID
 */
function uid2admin($cid)
{
	$result = uid2admininfo($cid);
	return $result['username'];
}

function getCategoryTree($pid=0,$t=-1,$modelid=0,$str=true)
{
	$obj = new getCate();
	return $obj->getCategoryTree($pid,$t,$modelid,$str);
}

/*获取栏目数
$t 获取几级
*/
function getCateTree($pid=0,$t=1)
{
	$obj = new getCate();
	return $obj->getCateTree($pid);
}
function hasYzm($html)
{
	return "Y"==get_mo_config($html);
}
/**
获取交叉栏目ID
**/
function getColumncross($cid)
{
	$categoryList = M('category')->field('columncross,id,crossid,catname')->where(array('in'=>array('id'=>$cid)))->select();
	foreach($categoryList as $key => $value)
	{
		if($value['columncross']==1)
		{
			continue;
		}
		elseif($value['columncross']==2)//自动获取同名栏目
		{
			$someName = M('category')->field('id,catname')->where(array('catname'=>$value['catname']))->select();
			foreach($someName as $sk => $sv)
			{
				$cid = $cid . ','.$sv['id'];
			}
		}
		else
		{
			if($value['crossid'])
			{
				$cid = $cid . ',' .$value['crossid'];
			}
		}
	}
	$cid = implode(array_unique(explode(',',$cid)),',');//去重
	return $cid;
}

/*获取版权信息*/
function powerby()
{
  // return get_mo_config('mo_powerby').'&nbsp;&nbsp;<a href="http://www.izhancms.com" target="_blank" style="color:#707070"><font style="color:#707070">版权所有爱站CMS Powered by izhanCMS </font><img src="'.URL_ADMIN_TPL.'images/default_logo.png" height="25"/></a>';
   return get_mo_config('mo_powerby');
}

/*获取版权信息*/
function powerbyIzhan()
{
   return '<div style="width:100%;clear:both;margin-bottom:0px"><center><a href="http://www.izhancms.com" target="_blank" style="color:#707070"><font style="color:#707070">版权所有爱站CMS Powered by izhanCMS </font><img src="'.URL_ADMIN_TPL.'images/default_logo.png" height="20"/></a></center><div>';
}

/*获取版权信息*/
function beian()
{
   return get_mo_config('mo_beian');
}

/*获取网站描述*/
function description()
{
   return get_mo_config('mo_description');
}
//获取文件大小
function getRealSize($size)
{
	$kb = 1024;         // Kilobyte
	$mb = 1024 * $kb;   // Megabyte
	$gb = 1024 * $mb;   // Gigabyte
	$tb = 1024 * $gb;   // Terabyte

	if($size < $kb)
	{
		return $size." B";
	}
	else if($size < $mb)
	{
		return round($size/$kb,2)." KB";
	}
	else if($size < $gb)
	{
		return round($size/$mb,2)." MB";
	}
	else if($size < $tb)
	{
		return round($size/$gb,2)." GB";
	}
	else
	{
		return round($size/$tb,2)." TB";
	}
}

/**
 避免多次调用静态变量不能释放
 */
 class getCate
 {
	 static $cat_temp=array();
	 static $pid;
         static $pids=array();
	 static $catTree=array();
	 static $categoryTree=array();
	 function __construct()
	 {
		self::$cat_temp = array();
		self::$pid = array();
		self::$catTree = array();
		self::$categoryTree = array();
	 }
	 /**
	 获取一个栏目的所有子栏目ID
	 **/
	 static function  getCategoryIds($pid=0,$have=false,$t=-1)
	 {
		$t++;
		$condtion = array('pid'=>$pid);
		if($have) self::$cat_temp[] = $pid;
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','id,pid');
		foreach ($data as $key => $val )
		{
			self::$cat_temp[] = $val['id'];
			self::getCategoryIds($val['id'],$have,$t);
		}
		self::$cat_temp = array_filter(array_unique(self::$cat_temp));
		return self::$cat_temp;
	  }

    /**
	 获取一个栏目的一级子栏目ID
	 **/
	 static function  getChildCategoryIds ($pid=0) {
		$condtion = array('pid'=>$pid);
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','id,pid');
                $childIds = array();
		foreach ($data as $key => $val )
		{
			$childIds[] = $val['id'];
		}
		$childIds = array_filter(array_unique($childIds));
		return $childIds;
	  }

	  /**
	  获取一个栏目的顶级栏目
	   **/
	 static function  getPid($sid=0)
	 {
		$condtion = array('id'=>$sid);
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','pid');

		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				if($val['pid']!=0)
				{
					self::$pid = $val['pid'];
					self::getPid($val['pid']);
				}
				else
				{
					self::$pid = $sid;
				}
			}
		}
		return self::$pid;
	  }


           /**
           * 获取一个栏目的所有上级栏目
	   **/
	 static function  getAllPids($sid=0)
	 {
		$condtion = array('id'=>$sid);
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','pid');

		if (!empty($data)) {
			foreach ($data as $key => $val ) {
                            self::$pids[] = $val['pid'];
                            if ($val['pid'] != 0) {
                                self::getAllPids($val['pid']);
                            }
			}
		}
		return self::$pids;
	  }

	//获取栏目数
	 public function getCategoryTree($pid=0,$t=-1,$modelid=0,$str=true)
	 {
		$condtion = array('pid'=>$pid);
		$t++;
		$data = M('category')-> findAll($condtion,'ordernum ASC,created DESC','model,id,pid,columnattr,catname');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
// 				if($val['model']!=2)   //前台搜索，栏目不能显示商品栏目，所以注释此代码，若对其他应用有影响，再做修改 2013.9.11 wr
// 			    {
				  $val['catname'] =  $str ? str_repeat('&nbsp;',$t*3).'├'.$val['catname'] : $val['catname'];
				  $val['level'] = $t+1;
				  self::$categoryTree[] = $val;
// 				}
				self::getCategoryTree($val['id'],$t,$modelid,$str);
			}
		}
		foreach(self::$categoryTree as $k=>$v)
		{
			if($modelid&&$v['model']!=$modelid)
			{
				self::$categoryTree[$k]['flag']=false;
			}
			else
			{
				self::$categoryTree[$k]['flag']=true;
			}
		}
		return self::$categoryTree;
	}

	  //可以指定获取几级栏目
	 public static function getCateTree($pid=0,$t=1,$i=0)
	 {
		$i++;
		static $catTree;
		$data = M('category') -> findAll(array('pid'=>$pid),'ordernum ASC,created DESC','id,pid,model,catname');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
			{
				if($i<=$t&&$t)
				{
					$val['level'] = $i;
					self::$catTree[] = $val;
					self::getCateTree($val['id'],$t,$i);
				}

			}
		}
		return self::$catTree;
	 }
}




		/**
		 * 获取网站meta信息
		 *
		 * @author  wr     2013-8-22
		 * @return  $seo   array 网站meta信息
		 */
		function get_metainfo_home()
		{
		 	$seo = array(
		 			'title'       =>get_mo_config('mo_title'),
		 			'keywords'    =>get_mo_config('mo_keywords'),
		 			'description' =>get_mo_config('mo_description'),
		 	        );

		 	return $seo;
		}

		/**
		 *
		 * @param  int    $type  1：栏目页 2：专题页 3：专题信息列表页 4：内容页 5：商品页
		 * @return array  $metainfo_default
		 */
		function get_metainfo_default($type=1)
		{
			$metainfo_default = array();
			$objSeoMeta  = M('SeoMeta');

			$metainfo_default = $objSeoMeta->where(array('type'=>$type))->getone();  //默认设置的meta信息

			return $metainfo_default;
		}


		/**
		 * 获取栏目页meta信息
		 *
		 * @author  wr     2013-8-22
		 * @param   $cid   int  栏目id
		 * @return  $metainfo_category   array 栏目页meta信息
		 *
		 */
		function get_metainfo_category($cid)
		{
			$objCategory = M('Category');
			$metainfo_category = array(
                            'title' => '',
                            'keywords' => '',
                            'description' => ''
                        );

			$categoryinfo = $objCategory->where(array('id'=>$cid))->getone();             //当前栏目信息

			$metainfo_category_default = get_metainfo_default(1);                         //栏目默认meta信息
			$metainfo_home = get_metainfo_home();                                         //获取网站首页meta信息

			$arr = array(                                                                 //替换默认设置里的变量
					'{category_name}'   =>$categoryinfo['catname'],
					'{home_title}'      =>$metainfo_home['title'],
					'{home_keywords}'   =>$metainfo_home['keywords'],
					'{home_description}'=>$metainfo_home['description']
					);
			if (empty($categoryinfo['seo_title']))
			{
				$metainfo_category['title'] = strtr($metainfo_category_default['title'], $arr);
			}else
			{
				$metainfo_category['title'] = $categoryinfo['seo_title'];
			}
			if (empty($categoryinfo['seo_keywords']))
			{
				$metainfo_category['keywords'] = strtr($metainfo_category_default['keywords'], $arr);
			}else
			{
				$metainfo_category['keywords'] = $categoryinfo['seo_keywords'];
			}
			if (empty($categoryinfo['seo_description']))
			{
				$metainfo_category['description'] = strtr($metainfo_category_default['description'], $arr);
			}else
			{
				$metainfo_category['description'] = $categoryinfo['seo_description'];
			}
			return $metainfo_category;
		}

		/**
		 * 获取专题页meta信息
		 * @author  wr    2013-8-22
		 * @param  int    $sid 专题id
		 * @return array  $metainfo_special
		 */
		function get_metainfo_special($sid)
		{
			$objSpecial  = M('Special');
			$metainfo_special = array();

			$specialinfo = $objSpecial->where(array('id'=>$sid))->getone();             //当前栏目信息

			$metainfo_special_default = get_metainfo_default(2);                        //专题默认meta信息
			$metainfo_home = get_metainfo_home();                                       //获取网站首页meta信息

			$arr = array(                                                               //替换默认设置里的变量
					'{special_name}'   =>$specialinfo['name'],
					'{home_title}'      =>$metainfo_home['title'],
					'{home_keywords}'   =>$metainfo_home['keywords'],
					'{home_description}'=>$metainfo_home['description']
			);
			if (empty($specialinfo['seo_title']))
			{
				$metainfo_special['title'] = strtr($metainfo_special_default['title'], $arr);
			}else
			{
				$metainfo_special['title'] = $specialinfo['seo_title'];
			}
			if (empty($specialinfo['seo_keywords']))
			{
				$metainfo_special['keywords'] = strtr($metainfo_special_default['keywords'], $arr);
			}else
			{
				$metainfo_special['keywords'] = $specialinfo['seo_keywords'];
			}
			if (empty($specialinfo['seo_description']))
			{
				$metainfo_special['description'] = strtr($metainfo_special_default['description'], $arr);
			}else
			{
				$metainfo_special['description'] = $specialinfo['seo_description'];
			}
			return $metainfo_special;
		}

		/**
		 * 获取节点内容列表页meta信息
		 * @author  wr    2013-8-23
		 * @param  int    $sid    专题id
		 * @param  int    $nodeid 节点id
		 * @return array  $metainfo_special
		 */
		function get_metainfo_special_assort($sid,$nodeid)
		{
            $objSpecial  = M('Special');
            $objSpecialAssort  = M('SpecialAssort');

			$metainfo_special = array();

			$specialinfo = $objSpecial->where(array('id'=>$sid))->getone();             //当前专题信息
            $specialassortinfo = $objSpecialAssort->where(array('aid'=>$nodeid))->getone();

			$metainfo_special_default = get_metainfo_default(3);                        //专题默认meta信息
			$metainfo_home = get_metainfo_home();                                       //获取网站首页meta信息

			$arr = array(                                                               //替换默认设置里的变量
					'{special_name}'    =>$specialinfo['name'],
					'{node_name}'       =>$specialassortinfo['assort_name'],
					'{home_title}'      =>$metainfo_home['title'],
					'{home_keywords}'   =>$metainfo_home['keywords'],
					'{home_description}'=>$metainfo_home['description']
			);

            $yellow = get_metainfo_special($sid);

            if (empty($specialinfo['seo_title']))
            {
                $metainfo_special['title'] = $specialassortinfo['assort_name'].'_'.$specialinfo['name'].'_'.$metainfo_home['title'];
            }else
            {
                $metainfo_special['title'] = $specialassortinfo['assort_name'].'_'.$specialinfo['seo_title'];
            }
            if (empty($specialinfo['seo_keywords']))
            {
                $metainfo_special['keywords'] = $specialassortinfo['assort_name'].'_'.$specialinfo['name'].'_'.$metainfo_home['keywords'];
            }else
            {
                $metainfo_special['keywords'] = $specialassortinfo['assort_name'].'_'.$specialinfo['seo_keywords'];
            }
            if (empty($specialinfo['seo_description']))
            {
                $metainfo_special['description'] = $specialassortinfo['assort_name'].'_'.$specialinfo['name'].'_'.$metainfo_home['description'];
            }else
            {
                $metainfo_special['description'] = $specialassortinfo['assort_name'].'_'.$specialinfo['seo_description'];
            }

			return $metainfo_special;
		}

		/**
		 * 获取内容页meta信息
		 *
		 * @author  wr    2013-8-23
		 * @param  int   $aid  文章id
		 * @return array $metainfo
		 */
		function get_metainfo_content($aid)
		{
			$metainfo = array();
			$metainfo_category = array();
			$objContent = M('Maintable');
			$contentinfo = $objContent->where(array('id'=>$aid))->getone();

			$cid = $contentinfo['categoryid'];
			$catname = cid2name($cid);                                   //所属栏目名称

			$metainfo_content_default  = get_metainfo_default(4);        //内容页默认meta信息
			$metainfo_category         = get_metainfo_category($cid);    //栏目页meta信息
			$metainfo_home             = get_metainfo_home();            //获取网站首页meta信息

			$arr = array(                                        //替换默认设置里的变量
					'{article_name}'        => $contentinfo['title'],
					'{category_name}'       => $catname,
					'{category_title}'      => $metainfo_category['title'],
					'{category_keywords}'   => $metainfo_category['keywords'],
					'{category_description}'=> $metainfo_category['description'],
					'{home_title}'          => $metainfo_home['title'],
					'{home_keywords}'       => $metainfo_home['keywords'],
					'{home_description}'    => $metainfo_home['description']
					);
			if (empty($contentinfo['seotitle']))
			{
				$metainfo['title'] = strtr($metainfo_content_default['title'], $arr);
			}else
			{
				$metainfo['title'] = $contentinfo['seotitle'];
			}
			if (empty($contentinfo['keywords']))
			{
				$metainfo['keywords'] = strtr($metainfo_content_default['keywords'], $arr);
			}else
			{
				$metainfo['keywords'] = $contentinfo['keywords'];
			}
			if (empty($contentinfo['description']))
			{
				$metainfo['description'] = strtr($metainfo_content_default['description'], $arr);
			}else
			{
				$metainfo['description'] = $contentinfo['description'];
			}
			return $metainfo;
		}

		/**
		 * 获取商品页meta信息
		 *
		 * @author  wr    2013-8-23
		 * @param  int   $gid  商品id
		 * @param  int   $cid  栏目id
		 * @return array $metainfo
		 */
		function get_metainfo_goods($gid)
		{
			$metainfo = array();
			$metainfo_category = array();
			$objGoods = M('Goods');
			$goodsinfo = $objGoods->where(array('goodsid'=>$gid))->getone();
			$brandinfo = M("GoodsBrand")->findAll();
			$sortinfo  = M("GoodsSort")->findAll();
            $brandArr = array();
            $sortArr = array();
			foreach ($brandinfo as $row)
			{
				$brand[$row['brandid']] = $row['brandname'];
				$brandArr[] = $brand;
			}
			foreach ($sortinfo as $row2)
			{
				$sort[$row2['sortid']] = $row2['sortname'];
				$sortArr[] = $sort;
			}

			$cid = $goodsinfo['categoryid'];
			$catname = cid2name($cid);                           //所属栏目名称

			$metainfo_goods_default = get_metainfo_default(5);   //商品页默认meta信息
			$metainfo_category = get_metainfo_category($cid);    //栏目页meta信息
			$metainfo_home = get_metainfo_home();                //获取网站首页meta信息

			$arr = array(                                        //替换默认设置里的变量
					'{goods_name}'          => $goodsinfo['goodsname'],
					'{goods_brand}'         => empty($brandArr) ? '' : $brandArr[$goodsinfo['brandid']],
					'{goods_sort}'          => empty($sortArr) ? '' : $sortArr[$goodsinfo['sortid']],
					'{category_name}'       => $catname,
					'{category_title}'      => $metainfo_category['title'],
					'{category_keywords}'   => $metainfo_category['keywords'],
					'{category_description}'=> $metainfo_category['description'],
					'{home_title}'          => $metainfo_home['title'],
					'{home_keywords}'       => $metainfo_home['keywords'],
					'{home_description}'    => $metainfo_home['description']
					);
			if (empty($goodsinfo['title']))
			{
				$metainfo['title'] = strtr($metainfo_goods_default['title'], $arr);
			}else
			{
				$metainfo['title'] = $goodsinfo['title'];
			}
			if (empty($goodsinfo['keywords']))
			{
				$metainfo['keywords'] = strtr($metainfo_goods_default['keywords'], $arr);
			}else
			{
				$metainfo['keywords'] = $goodsinfo['keywords'];
			}
			if (empty($goodsinfo['brief']))
			{
				$metainfo['description'] = strtr($metainfo_goods_default['description'], $arr);
			}else
			{
				$metainfo['description'] = $goodsinfo['brief'];
			}
			return $metainfo;
		}

	  /*判断是否属手机*/
	  function is_mobile() {
	      $user_agent = @$_SERVER['HTTP_USER_AGENT'];
	      $mobile_agents = array("zunewp", "cldc", "ericsson", "240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
	      $is_mobile = false;
	      foreach ($mobile_agents as $device) {
	              if (stristr($user_agent, $device)) {
	                      $is_mobile = true;
	                      return $is_mobile;
	              }
	      }
	      return $is_mobile;
	  }

	  /**
	   * 得到 商品 分类 栏目
	   */
	  function get_goods_column() {
	  	$objCate = M('Category');
	  	$goodscolumns = $objCate->where(array('model'=>2))->select();
	  	return $goodscolumns;
	  }

    /*
    *截取带有html标签的字符串
    *@params $str 要截取的字符串
    *@params $lentgh 要截取的长度
    *@params $ext 后缀
    */
    function htmlTagSubstr ($str, $length, $ext='...') {
        $contentpage = new ContentPage();
        $mycontent = $contentpage->get_data($str, $length);
        $mycontents = array_filter(explode('[page]',$mycontent));
        $ext = (strlen($mycontents[0]) <= $length) ? '' : $ext;
        return $mycontents[0] . $ext;
    }

    /**
     * 获取指定栏目父id的栏目子id列表
     * @params $pid 指定的栏目父id
     */
    function getIdListByPid($pid = 0) {
    	$objCate = M('Category');
    	$list = $objCate->field('id,catname')->where(array('pid'=>$pid))->order('id asc')->select();
    	return $list;
    }

    /**
     * 获取指定栏目id的推荐位列表
     * @params $cat_id 指定的栏目id
     */
    function getPositionByCatid($cat_id = 0) {
    	$objPosition = M('Position');
    	$list = $objPosition->field('pos_id,name')->where(array('cat_id'=>$cat_id))->order('pos_id asc')->select();
    	return $list;

    }
