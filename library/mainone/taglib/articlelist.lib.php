<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  文章列表标签
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

class articlelist
{
	function lib_articlelist($datas)
	{
		$dbconfig = get_config('database','default');
		$order = isset($datas['order']) ? $datas['order'] : "istop desc, " . $dbconfig['prefix']."maintable.`sortnum` ASC, " . 'publishtime desc';
		//$order    = isset($datas['order']) ? $datas['order'] : $dbconfig['prefix']."maintable.`sortnum` ASC";
		$from     = isset($datas['from']) ? $datas['from'] : '0';
		$limit    = isset($datas['row']) ? $datas['row'] : '10000000000000';   //由于模型，把数字弄大点，不写sql
		$limit    = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
		$cid      = isset($datas['cid']) ? $datas['cid'] : '';
		$type     = isset($datas['type']) ? $datas['type'] : '';
		$keywords     = isset($datas['keywords']) ? $datas['keywords'] : '';
		$modelid  = isset($datas['modelid']) ? $datas['modelid'] : 1;   //根据获取附表字段的需求，添加modelid参数 2013.9.11 wr
		$condtion = array('model'=>$modelid);

		//获取附表表名
		$attached_tableinfo = M("Model")->field("tablename")->where(array('id'=>$modelid))->getone();
		$attached_tablename = $attached_tableinfo['tablename'];
		if(isset($datas['id'])&&$datas['id']) $condtion = array('in'=>array('id'=>$datas['id']));
	    if($cid)
   	    {
	   	  	if($type == 'parent')
	   	  	{
	   	  		$pid = M('Category')->field('pid')->where(array('id'=>$cid))->getOne();
	   	  		$condtion = array(
	   	  			'categoryid' => $pid['pid'],
	   	  		);
	   	  	}
	   	  	elseif($type == 'all')
	   	  	{
				$arr = getCategoryIds($cid,true);
				$str = implode($arr,',');
				$condtion = array(
						'in'=>array('categoryid' => $str),
				);

	   	  	}
			elseif($type == 'son')
	   	  	{
				$arr = getCategoryIds($cid);
	   	  		$str = implode($arr,',');
	   	  			$condtion = array(
	   	  					'in'=>array('categoryid' => $str),
	   	  		);


	   	  	}
	   	  	else
	   	  	{
				//获取交叉栏目ID
				$cid = getColumncross($cid);
	   	  		$condtion = array(
	   	  			'in'=>array('categoryid' => $cid)
	   	  		);
	   	  	}
		  }

		  $condtion = array_filter($condtion);
		  if($keywords){
         			 $condtion['like'] = array('title'=>$keywords);
		  }

		  $result = M('maintable')->where($condtion)
		                        ->field('IF(sorttype-UNIX_TIMESTAMP() > 0, sorttype-UNIX_TIMESTAMP(), 0) AS istop, '.$dbconfig['prefix'].'maintable.id as mid,categoryid,title,subtitle,thumb,keywords,description,brief,source,sorttype,sortnum,publishopt,publishtime,hits,publishuser,username,updatetime,updateuser,'.$dbconfig['prefix'].'maintable.created,'.$dbconfig['prefix'].'category.id as cid,catname,filepath,columnoption,'.$dbconfig['prefix'].$attached_tablename.'.*')
		                        ->join($dbconfig['prefix'].'category on '.$dbconfig['prefix'].'category.id = '.$dbconfig['prefix'].'maintable.categoryid')
		                        ->join($dbconfig['prefix'].$attached_tablename.' on '.$dbconfig['prefix'].$attached_tablename.'.maintable_id = '.$dbconfig['prefix'].'maintable.id')
                                ->order($order)
                                ->limit($from.','.$limit)
                                ->select();

         foreach($result as $key => $value)
         {
			$contentInput = new ContentInput(1, $value['cid']);
            $new = $contentInput->get($value);
			$result[$key] = array_merge($value, $new);
			$result[$key]['curl'] = getCategoryUrl($value['cid'], $value['filepath'], $value['columnoption'],'category/Category/list', 'contetnlist_$id_1.html');
			$result[$key]['url'] = getArticleUrl($value['mid'], $value['filepath'], $value['publishopt'],'content/Content/index' ,'content_$id_1.html',$value['created']);
         }

         return $result;
	}
}
?>
