<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://cms.b2b.cn)
 *
 * SeoController.php
 * 
 * SEO辅助工具类
 * 
 * 
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-10-17 下午4:02:51
 * @filename   SeoController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version     iZhanCMS 2.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
  
 
class SeoController extends AdminController
{
	
	
	/**
	 * 首页
	 */
	public function indexAction()
	{
		$type = $this->getParams("type");
		
		switch ($type)
		{
			case 1:
				$this->display('extensions/seo/seo_index');
				break;
			case 2:
				$this->display('extensions/seo/seo_index_2');
				break;
			case 3:
				$this->display('extensions/seo/seo_index_3');
				break;
			default:
				$this->display('extensions/seo/seo_index');
				break;
		}
	}
	
	
	
}