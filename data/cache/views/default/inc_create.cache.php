<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php if($GLOBALS['username']) { ?>
<a href="/member/memorial/create" target="_blank" class="set_up"></a>
<?php } else { ?>
<a href="/user/Login/login2" target="_blank" class="set_up"></a>
<?php } ?>