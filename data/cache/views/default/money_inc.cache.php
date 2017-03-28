<?php if(!defined('IN_MAINONE')) exit(); ?>
<div class="conLeft_yc">
                <h3 class="h3Com_yc"><span></span>资金管理</h3>
                <dl class="moneyDl">
                    <dd>
                        账号：<em><?php echo Template::addquote($yuanbao['username']);?></em>
                    </dd>
                   <!--  <dd>
                        账户余额：<span class="greenS"><em>300,300.00</em>元</span><a href="javascript:;" class="moneyA fr">充值金额</a>
                    </dd> -->
                    <dd>
                        元宝：<em class="greenS"><?php echo Template::addquote($yuanbao['point']);?></em><a href="/member/Recharge/online" class="moneyA fr">充值元宝</a>
                    </dd>
                </dl>
                <ul class="jbList_yc">
                    <li><a href="/member/Recharge/consumption" <?php if($is_nav==1) { ?>class="active"<?php } ?>
                    >消费记录</a></li>
                    <li><a href="/member/Recharge/recording" <?php if($is_nav==2) { ?>class="active"<?php } ?>>充值记录</a></li>
                    <li><a href="/member/Recharge/online" <?php if($is_nav==3) { ?>class="active"<?php } ?>>在线充值</a></li>
                </ul>
            </div>