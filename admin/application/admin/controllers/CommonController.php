<?php
class CommonController extends Controller {



	/**
	 * 分析用户是否登陆
	 */
	public function parse_login($item = false) {

		$login_state = Cookie::get('cms_login_state');

		//ajax页面的登陆判断
		if ($item == true && $login_state == false) {
			exit('或许登陆已过期,请重新登陆!');
		}

		if ($login_state == false) {
			$this->redirect($this->createUrl(app::$module.'/login/index'));
		}

		return true;
	}

	/**
	 * 前函数
	 */
	 public function init() {

		 $this->setLayout('main');

		 return true;
	 }
}