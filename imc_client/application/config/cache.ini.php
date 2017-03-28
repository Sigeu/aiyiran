<?php
/**
 * 配置文件
 * 
 */

return array(
		
'lock_ex' => '1', //写入缓存时是否建立文件互斥锁定（如果使用nfs建议关闭）
'cache' => array(
		'file' => array (
		      'type' => 'file',
		      'expire' => 0,
		      'debug' => true,
		      'pconnect' => 0,
		      'autoconnect' => 0
		),
	   'memcache' => array (
		      'hostname' => '210.78.140.2',
		      'port' => 11211,
		      'timeout' => 0,
		      'type' => 'memcache',
		      'expire' => 0,
		      'debug' => true,
		      'pconnect' => 0,
		      'autoconnect' => 0,
	   ),
   ),
);