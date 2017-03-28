<?php if(!defined('IN_MAINONE')) exit(); ?>
 <div class="conLeft_yc">
                <h3 class="h3Com_yc"><span></span>账号设置</h3>
                <ul class="jbList_yc">
                    <li><a href="/member/User/userinfo" <?php if($is_nav==1) { ?>class="active"<?php } ?>>个人资料</a></li>
                    <li><a href="/member/User/safe/" <?php if($is_nav==2) { ?>class="active"<?php } ?>>安全设置</a></li>
                    <li><a href="/member/User/accountbound" <?php if($is_nav==3) { ?>class="active"<?php } ?>>第三方账号绑定</a></li>
                </ul>
            </div>