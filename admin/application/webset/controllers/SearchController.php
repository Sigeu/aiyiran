<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SafetyController.php
 *
 * 网站设置——安全设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   SafetyController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SearchController extends AdminController
{

	/**
	 *  sphinx设置显示页
	 */

    public function searchAction()
    {
    	
    	$stat = get_mo_config('mo_sphinx_stat');
    	$dress = get_mo_config('mo_sphinx_dress');
    	$number = get_mo_config('mo_sphinx_number');
    	$url = "/webset/search/search/stat/{$stat}";
    	$this->assign('stat',$stat);
    	$this->assign('dress',$dress);
    	$this->assign('number',$number);
    	$this->assign('url',$url);
        $this->display('webset/search/search');
    }
    
    
	/**
	 *  sphinx设置修改页
	 */

    public function searchAddAction()
    {
        $getSearch = M("WebConfig");
        
        $stat = isset($_POST['stat']) && !empty($_POST['stat']) ? $_POST['stat'] : 2;
        $dress = isset($_POST['dress']) && !empty($_POST['dress']) ? $_POST['dress'] : '192.168.3.170';
        $number = isset($_POST['number']) && !empty($_POST['number']) ? $_POST['number'] : '9312';
       
        if($stat == 1){			//开启sphinx
        	
	        $getSearch -> update(array('par_id'=>888),array('par_value' => 1));
	        $getSearch -> update(array('par_id'=>889),array('par_value' => $_POST['dress']));
	        $getSearch -> update(array('par_id'=>890),array('par_value' => $_POST['number']));
	        
        }else{					//关闭sphinx
        	
       		$getSearch -> update(array('par_id'=>888),array('par_value' => 2));
        }
    	$this->dialog('/webset/search/search','success','修改成功！');	
    }
    
}