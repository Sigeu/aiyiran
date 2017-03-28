<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * backadController.php
 *
 * 后台广告设置
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2012-12-26 10:27:36
 * @filename   backadController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class BackadController extends AdminController
{
    public $backstageModel;
	public function init ()
	{
		$this->backstageModel = D('backstageModel');
	}

	/**
	 * 后台广告设置
	 */
	public function indexAction()
	{
        $obj = M("ServeAdposition");  //推送广告位
        $status = $obj->findAll(array(),null,'status');
        foreach($status AS $val){  //广告位状态
            $sta[] = $val['status'];
        }
		$useskill_json = @file_get_contents("http://izhancms.com/official/os/adserving/ipush");
		$skill = json_decode($useskill_json,true);
        foreach ($skill['1'] AS $lkey=> $lval){   //左侧广告
            $lad[] = unserialize(base64_decode($lval['adimg']));
        }
        foreach ($lad AS $lk=>$lv){
            $llink[] = $lv['imgpath'];
        }

        foreach ($skill['2'] AS $rkey=> $rval){   //右侧广告
            $rad[] = unserialize(base64_decode($rval['adimg']));
        }
        foreach ($rad AS $rk=>$rv){
            $rlink[] = $rv['imgpath'];
        }

		$empower = $this->checkLicense(HOST_NAME); //判断授权接口

		$this->assign('status',$sta);
		$this->assign('empower',$empower);
		$this->assign('lad',$llink['0']);
		$this->assign('rad',$rlink['0']);
		$this->display('webset/backstage/index');
	}

	/**
	 * 修改广告设置
	 */
	public function updateAction()
	{
        $left  = empty($_POST['leftad']) ? 1 : $_POST['leftad'];
        $right = empty($_POST['rightad']) ? 1 : $_POST['rightad'];
        $obj = M("ServeAdposition");  //推送广告位

        if($this->checkLicense(HOST_NAME) ==1) { //已授权
            $obj->update(array('id'=>1),array('status'=>$left));  //左侧广告
            $obj->update(array('id'=>2),array('status'=>$right));  //右侧广告
            $this -> dialog('/webset/backad/index','success','操作成功！');
        }

	}


}