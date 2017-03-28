<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  内容标签
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
class content
{
	public $model;
	public $datas;
	public $_result;
	function lib_content($datas)
	{
		$this -> datas = $datas;
		$id = isset($datas['id']) ? $datas['id'] : '';
		$dbconfig = get_config('database','default');
		$modelid =  isset($datas['modelid']) ? $datas['modelid'] : D('Content','content')->getModelId($id);
		$tablename =  D('Content','content')->getTable($modelid);
		$arr = array(
				1 => 1, //永真
				$dbconfig['prefix'].'maintable'.'.id'=>$id,
		);
		$condtion = array_filter($arr);
		$this -> model = M('maintable');
		$list_result = $this -> model->where($condtion)
		                        ->field($dbconfig['prefix'].$tablename.'.*,'.$dbconfig['prefix'].'maintable.*,'.$dbconfig['prefix'].'category.id as cid,catname,filepath,columnoption')
		                        ->join('left join '.$dbconfig['prefix'].'category on '.$dbconfig['prefix'].'category.id = '.$dbconfig['prefix'].'maintable.categoryid left join '.$dbconfig['prefix'].$tablename.' on maintable_id='.$dbconfig['prefix'].'maintable.id')
                                ->getOne();
        if (empty($list_result)) {
            return $list_result;
        }
		$contentInput = new ContentInput(1, $list_result['cid']);
        //$list_result2比$list_result缺少了部分数据
        $list_result2 = $contentInput->get($list_result);
        $list_result = array_merge($list_result, $list_result2);
		$list_result['curl'] = getCategoryUrl($list_result['cid'], $list_result['filepath'], $list_result['columnoption'],'category/Category/index', 'list_$id_1.html');
		$list_result['url'] = getArticleUrl($list_result['id'], $list_result['filepath'], $list_result['publishopt'],'content/Content/index' ,'content_$id_1.html',$list_result['created']);
        return $list_result;
	}

	/*function lib_article($datas)
	{
		$dbconfig = get_config('database','default');
		$order = isset($datas['order']) ? $datas['order'] : $dbconfig['prefix'].'maintable.id desc';
		$limit = isset($datas['row']) ? $datas['row'] : '10';
		$id = isset($datas['id']) ? $datas['id'] : '';
		$arr = array(
				1 => 1, //永真
				'id'=>$id,
		);
		$condtion = array_filter($arr);
		$list_result = M('maintable')->where($condtion)
		                        ->field($dbconfig['prefix'].'maintable.*,'.$dbconfig['prefix'].'category.id as cid,catname,filepath,columnoption')
		                        ->join($dbconfig['prefix'].'category on '.$dbconfig['prefix'].'category.id = '.$dbconfig['prefix'].'maintable.categoryid')
                                ->order($order)
                                ->limit('0,'.$limit)
                                ->select();
        foreach($list_result as $key => $value)
        {

        	$list_result[$key]['url'] = '/';
        	$list_result[$key]['curl'] = getCategoryUrl($value['cid'], $value['filepath'], $value['columnoption'],'category/Category/index', 'list_$id_1.html',$value['created']);
            $list_result[$key]['url'] = getArticleUrl($value['id'], $value['filepath'], $value['publishopt'],'content/Content/index' ,'content_$id_1.html');
        }
        return $list_result;
	}*/
}
?>
