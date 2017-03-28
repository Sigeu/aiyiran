<?php if(!defined('IN_MAINONE')) exit(); ?>

                    <?php $n=1;foreach($mybox AS $k => $v) { $lastIndex= count($mybox) == $n;?>
                        <!-- 如果祭品有纪念馆所属 -->
                        <?php if($v['place']==2) { ?>
                        <li  goods_id="<?php echo Template::addquote($v['goods_id']);?>" mid="<?php echo $mid;?>" onclick="fangzhi(<?php echo Template::addquote($v['goods_id']);?>,<?php echo $mid;?>);">
                            
                        <a href="javascript:;">
                        <?php } else { ?>
                        <li goods_id="<?php echo Template::addquote($v['goods_id']);?>" mid="<?php echo $mid;?>" >
                        <a href="javascript:;" style="cursor: default;">
                        <?php } ?>
                                <span><img src="<?php echo Template::addquote($v['pic']);?>" width="120" height="120" /></span>
                                <h3><?php echo Template::addquote($v['gname']);?></h3>
                                <p class="jb_who">
                                    <?php if($v['place']!=2) { ?>
                                        已摆放到<?php echo Template::addquote($v['name']);?>纪念堂
                                        <p class="reman" id="conn_">剩余时间：<?php echo Template::addquote($v['end_time']);?></p>
                                    <?php } else { ?>
                                        未摆放
                                    <?php } ?>
                                </p>

                                <!-- <p class="reman">剩余时间：22天22小时55分钟26秒</p> -->
                            </a>
                        </li>
                    <?php $n++;} ?>


