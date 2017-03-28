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
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    iZhanCMS 2.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */


class tags  
{

	public function lib_tags($datas)
    {	
    	require_once DIR_ROOT."library/mainone/functions/tagfun.php";
    	$tables   = isset($datas['tables']) ? $datas['tables'] : 'maintable';
    	$field    = isset($datas['field']) ? $datas['field'] : 'id,title,created';
    	$from     = isset($datas['from']) ? $datas['from'] : '0';
    	$limit    = isset($datas['row']) ? $datas['row'] : '100000000';
    	$limit    = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
    	$ids 	  = isset($datas['id']) ? $datas['id'] : '';
    	$dbconfig = get_config('database','default');
    	$where['in'] = $tables == 'maintable' ? array("id"=>$ids) : array('goodsid'=>$ids);
		
        if($tables == 'goods'){
                                
            $sql = 'SELECT '.$field.' FROM '.$dbconfig['prefix'].'goods WHERE goodsid in ('.$ids.') ' .
            			'LIMIT '. $from .',' . $limit;  
            $result = M('goods')->query($sql);
            
            
        }else{
       
       		$result = M($tables)->where($where)
		                        ->field($field)
                                ->limit($from.','.$limit)
                                ->select();
        }
		foreach( $result as $key=>$val )
		{	
			$filepath = $this -> getStaticUrl($val['categoryid']);  // 获取静态文件存放路径名
			if($tables == 'maintable')
			{	
				/**
				 * $filepath 获取静态文章的保存地址
				 * @param  getArticleUrl($id,$filepath,$publishshot,$url='content/Content/index',$urltype='content_$id_1.html',$createTime=0)
				 * 判断是静态还是动态
				 */
				$this -> getCatalogByCategoryid($val['id']);
				
                $result[$key]['url'] = getArticleUrl($val['id'],$filepath,$val['publishopt'],$url='content/Content/index',$urltype="content_".$val['id']."_1.html",$val['created']);
               
                /**
                 *  截取文章thumb缩略图的src属性
                 */
                $result[$key]['thumb'] = object_to_array(json_decode(htmlspecialchars_decode(strval($val['thumb']))));
//				$result[$key]['url'] = HOST_NAME .'content/Content/index/id/'.$val['id']; 
                
			}else{
				
				/**
				 * $filepath 获取静态文章的保存地址
				 * @param  getGoodsUrl($goodsid,$filepath,$publishshot,$url='goods/Goods/info',$urltype='goods_$id.html',$createTime=0)
				 * 判断是静态还是动态
				 */
				$this -> getCatalogByCategoryid($val['goodsid']);    
                $result[$key]['url'] = getGoodsUrl($val['goodsid'],$filepath,$val['publishopt'],$url='goods/Goods/index',$urltype="goods_".$val['goodsid'].".html",$val['created']);
                
//				$result[$key]['url'] = HOST_NAME .'goods/Goods/info/id/'.$val['goodsid'];
				$sql = 'SELECT * FROM `' . $dbconfig['prefix'] . 'goods_album` WHERE goodsid = ' . $val['goodsid'];
				$albums =  M('goods_album')->query($sql);
				$result[$key]['photo'] = $albums?$albums:array(array('photo'=>''));
			}
		}//  var_dump($result);
    	return $result;
	}
	
	//根据已知条件获取栏目静态文件保存路径      
    public function getStaticUrl($categoryid)
    {
        return $this->getCatalogByCategoryid($categoryid);
    }
    
	//根据栏目ID获取栏目文件保存目录
    public function getCatalogByCategoryid($id)
    {
    	$dbconfig = get_config('database','default');
        $sql = "SELECT filepath FROM " .$dbconfig['prefix']."category WHERE id = $id";
        $result = M('category') -> query($sql);
        return $result['0']['filepath'];
    }
}
		