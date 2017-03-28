<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 积分规则表
 *
 * @author     雷少进 <leishaojin@mail.b2b.cn>
 * @filename   ScoresRuleModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class ScoresRuleModel extends Model
{
	public $pk = "id";//主键
	public $tableName = "scores_rule";//表名

	/**
	 * 获取积分规则列表sql
	 *
	 */
	function getSql ()
	{
		return 'SELECT sr.*,ia.appname,ia.currency FROM `'.$this -> tablePrefix.'scores_rule` AS sr LEFT JOIN `'.$this -> tablePrefix.'imc_app` AS ia ON sr.app = ia.id';
	}
}