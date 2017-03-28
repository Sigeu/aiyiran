<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * UpgradeLogModel.php
 *
 * 系统角色Model类
 *
 * @author     leishaojin<leishaojin@mail.b2b.cn>   2013-03-26 10:34
 * @filename   UpgradeLogModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class UpgradeLogModel extends Model
{
	public $pk = "id";
	public $tableName = "upgrade_log";
}