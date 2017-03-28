<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 *  文章标签
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

class article
{
	public $model;
	public $datas;
	public $_result;
	function lib_article($datas)
	{
		$this -> datas = $datas;
		$dbconfig = get_config('database','default');
		$id = isset($datas['id']) ? $datas['id'] : '';
		$arr = array(
				1 => 1, //永真
				$dbconfig['prefix'].'maintable'.'.id'=>$id,
		);
		$condtion = array_filter($arr);
		$this -> model = M('maintable');
		$list_result = $this -> model->where($condtion)
		                        ->field($dbconfig['prefix'].'article.*,'.$dbconfig['prefix'].'maintable.*,'.$dbconfig['prefix'].'category.id as cid,catname,filepath,columnoption')
		                        ->join('left join '.$dbconfig['prefix'].'category on '.$dbconfig['prefix'].'category.id = '.$dbconfig['prefix'].'maintable.categoryid left join '.$dbconfig['prefix'].'article on maintable_id='.$dbconfig['prefix'].'maintable.id')
                                ->getOne();
		$contentInput = new ContentInput(1, $list_result['cid']);
        $list_result = $contentInput->get($list_result);
		$list_result['curl'] = getCategoryUrl($list_result['cid'], $list_result['filepath'], $list_result['columnoption'],'category/Category/index', 'list_$id_1.html');
		$list_result['url'] = getArticleUrl($list_result['id'], $list_result['filepath'], $list_result['publishopt'],'content/Content/index' ,'content_$id_1.html',$list_result['created']);
        return $list_result;
	}
}
?>
