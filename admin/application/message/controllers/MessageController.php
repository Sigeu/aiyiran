<?php
class MessageController extends AdminController
{
	public function indexAction()
	{
		$objM = M('message');
		$list = $objM -> findLimit('','','',0,10);

		dump($objM);
// 		dump($list);
	}
	
	
	public function index2Action()
	{
	    $objT = D('Message');
// 	    dump($objT);exit;
	    $list = $objT -> findLimit('','','',0,10);
	    $list2 = $objT -> getList();
// 	    dump($objT);exit;	
	    dump($list2);	
	}
	
	public function testsqlAction()
	{
	    $objT = D('Message');
	    
	    $result = $objT->testsql();
	    dump($result);
		
	}
	
}