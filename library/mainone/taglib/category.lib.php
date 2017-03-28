<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  栏目标签
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

class category
{
   function lib_category($datas)
   {
   	  $order = isset($datas['order']) ? $datas['order'] : 'ordernum';
   	  $limit = isset($datas['row']) ? $datas['row'] : '1000000';
   	  $type = isset($datas['type']) ? $datas['type'] : 'all';
   	  $cid = isset($datas['cid']) ? $datas['cid'] : '';
   	  $struct = isset($datas['struct']) ? $datas['struct'] : 'norelation';
   	  $condtion = array(1=>1);
   	  if($cid)
   	  {
   	  	if($type == 'parent')
   	  	{
   	  		$pid = M('Category')->field('pid')->where(array('id'=>$cid))->getOne();
   	  		$condtion = array(
   	  			'id' => $pid['pid'],
   	  		);
   	  	}
   	  	elseif($type == 'son')
   	  	{
   	  		$arr = getCategoryIds($cid);
   	  		if(!empty($arr))
   	  		{
   	  			$str = implode($arr,',');
   	  			$condtion = array(
   	  					'in'=>array('id' => $str),
   	  			);
   	  		}
                } else if ($type == 'child') {
                    $arr = getChildCategoryIds($cid);
                    if(!empty($arr))
                    {
                            $str = implode($arr,',');
                            $condtion = array(
                                            'in'=>array('id' => $str),
                            );
                    }else {
                        $condtion = array(1=>0);
                    }
                }
   	  	else
   	  	{
   	  		$condtion = array(
   	  			'in'=>array('id' => $cid)
   	  		);
   	  	}

   	  }
   	  else
   	  {
   	  	if($type == 'top')
   	  	{
   	  		$condtion = array(
   	  				'pid'=>0,
   	  		);
   	  	}
   	  	if($type == 'all')
   	  	{
   	  		;
   	  	}
   	  }

   	  $result = M('Category')->where($condtion)->order($order)->limit('0,'.$limit)->select();
      foreach($result as $key=>$value)
      {
   	  	$result[$key]['url'] = getCategoryUrl($value['id'], $value['filepath'], $value['columnoption'],'category/Category/list','contetnlist_$id_1.html');
      }

	  if($struct === 'relation')
	  {
		$result = $this ->formateParentChild($result);
	  }

   	  return $result;
   }

   /**
	 * 格式化成子父级关系的数据结构
	 * @param递归出来的分类信息
	 * @return array()父子级关系的N维数组
	 */
	function formateParentChild($data)
	{
		if(empty($data))
			return array();
		$first = array();
		foreach($data as $key1 => $val1)
		{
			if($val1['pid'] == 0)
				$first[] = $val1;
		}

		foreach($first as $key2 => $val2)
		{
			foreach($data as $key3 => $val3)
			{
				if($val2['id'] == $val3['pid'])
				{
					$first[$key2]['child'][$key3] = $val3;

					foreach($data as $key4 => $val4)
					{
						if($val4['pid'] == $first[$key2]['child'][$key3]['id'])
						{
							$first[$key2]['child'][$key3]['child'][$key4] = $val4;
						}
					}
					!isset($first[$key2]['child'][$key3]['child']) && ($first[$key2]['child'][$key3]['child'] = array());
				}
			}
			!isset($first[$key2]['child']) && ($first[$key2]['child'] = array());
		}
		return $first;
	}
}
?>