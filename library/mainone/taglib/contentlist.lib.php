<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  内容列表标签
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
class contentlist
{
	function lib_contentlist($datas)
	{
		$dbconfig = get_config('database','default');
		//$order = isset($datas['order']) ? $datas['order'] : $dbconfig['prefix']."maintable.`sorttype`-NOW() desc";
		$order = isset($datas['order']) ? $datas['order'] : $dbconfig['prefix']."maintable.`sortnum` ASC";
		$from = isset($datas['from']) ? $datas['from'] : '0';
		$limit = isset($datas['row']) ? $datas['row'] : '1000000000';
		$limit = isset($datas['pagesize']) ? $datas['pagesize'] : $limit;
		$cid = isset($datas['cid']) ? $datas['cid'] : '';
		$cidInfo = cid2Info($cid);
		$cmodel = $cidInfo['model'];
		$type = isset($datas['type']) ? $datas['type'] : '';
		$condtion = array(1=>1);
		if(isset($datas['id'])&&$datas['id'])
			$condtion['in'][$dbconfig['prefix'].'maintable.id']=$datas['id'];
		if($cmodel)
		{
			$condtion['model'] = $cmodel;
		}
		elseif(isset($datas['modelid'])&&$datas['modelid'])
		{
			$condtion['model'] = $datas['modelid'];
		}
		else
		{
			;
		}
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
	   	  		if(!empty($arr))
	   	  		{
	   	  			$str = implode($arr,',');
	   	  			$condtion['in']['categoryid']=$str;
	   	  		}
	   	  	}
			elseif($type == 'son')
	   	  	{
				$arr = getCategoryIds($cid);
	   	  		if(!empty($arr))
	   	  		{
	   	  			$str = implode($arr,',');
	   	  			$condtion['in']['categoryid']=$str;
	   	  		}
	   	  	}
	   	  	else
	   	  	{
				//获取交叉栏目
				$cid = getColumncross($cid);
	   	  		$condtion['in']['categoryid']=$cid;
	   	  	}
	   	  }
		  $condtion = array_filter($condtion);
		  $result = M('maintable')->where($condtion)
		                        ->field($dbconfig['prefix'].'maintable.*,'.$dbconfig['prefix'].'category.id as cid,catname,filepath,columnoption')
		                        ->join($dbconfig['prefix'].'category on '.$dbconfig['prefix'].'category.id = '.$dbconfig['prefix'].'maintable.categoryid')
                                ->order($order)
                                ->limit($from.','.$limit)
                                ->select();

         foreach($result as $key => $value)
         {
            $contentInput = new ContentInput(1, $value['cid']);
            $new = $contentInput->get($value);
			$result[$key] = array_merge($value, $new);
            $result[$key]['curl'] = getCategoryUrl($value['cid'], $value['filepath'], $value['columnoption'],'category/Category/list', 'contetnlist_$id_1.html');
            $result[$key]['url'] = getArticleUrl($value['id'], $value['filepath'], $value['publishopt'],'content/Content/index' ,'content_$id_1.html',$value['created']);
            $result[$key]['content'] = '';
            $sql = 'SELECT m.tablename FROM ' . $dbconfig['prefix'] . 'category c JOIN ' . $dbconfig['prefix'] . 'model m ON c.model=m.id WHERE c.id='. $value['cid'];
            $table = M('category')->query($sql);
            if ($table) {
                $content = M($table[0]['tablename'])->field('content')->where(array('maintable_id' => $value['id']))->getOne();
                if ($content) {
                    $result[$key]['content'] = $content['content'];
                }
            }
         }
         return $result;
	}
}
?>
