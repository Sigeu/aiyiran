<?php
/**
 * MainOneCms ����ԴCMS���ݹ���ϵͳ  (http://www.izhancms.com)
 *
 * Ӧ�ñ�
 *
 * @author     ١�»� <tongxinhua@mail.b2b.cn>
 * @filename   AppModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN:
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */
class AppModel extends Model
{
	public $pk = "id";//����
	public $tableName = "imc_app";//����

	/**
	��ȡӦ���б�
	**/
	public function getAppList($options=array())
	{
		$list = $this->order('id desc')->limit($options)->select();
		return $list;
	}
}