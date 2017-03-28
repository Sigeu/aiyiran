<?php

include "libweibo-master/config.php";

include_once( 'libweibo-master/saetv2.ex.class.php' );

/**
 * @author wake1
 */
    
    //开始授权
    $o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

    $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
  


?>