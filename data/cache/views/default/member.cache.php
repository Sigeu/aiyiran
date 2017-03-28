<?php if(!defined('IN_MAINONE')) exit(); ?>
<div class="login_succee">
                        <h3>用户中心</h3>

                        <a href="/member/Index/index" class="user_head">
                                <img src="<?php echo extends_path($_SESSION['front_login_info']['user_photo'], IMG_PATH.'/wdl_03.png');?>" width="110" height="110" style="display: block;" />
                        </a>
                        <p><span><?php echo Template::addquote($GLOBALS['username']);?></span><a href="/member/User/safe" class="phone"></a><a href="/member/Systeminfo/lists" target="_blank" class="e_mail"></a><a href="/user/User/loginout" class=" logout"></a></p>
                        <a href="/member/Index/index" class="in_my_center">进入个人中心</a>
                        <div class="my_jng">
                            <span>我的纪念馆：</span>
                            <?php $n=1;foreach($memorial_lists AS $k => $v) { $lastIndex= count($memorial_lists) == $n;?>
                                <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($v['id']);?>" target="_blank"><img src="<?php echo Template::addquote($v['userpic']);?>" /></a>
                            <?php $n++;} ?>
                        </div>
                    </div>
