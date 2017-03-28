<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php $n=1;foreach($goods_all AS $k => $v) { $lastIndex= count($goods_all) == $n;?>
                        <li data-goodsid="<?php echo Template::addquote($v['id']);?>" data-mid="<?php echo $mid;?>" data-gname="<?php echo Template::addquote($v['gname']);?>" data-img="<?php echo Template::addquote($v['pic']);?>" data-price="<?php echo Template::addquote($v['price']);?>" onclick="showBuy(this)">
                            <a href="###">
                            <img src="<?php echo Template::addquote($v['pic']);?>" />
                            <h4><?php echo Template::addquote($v['gname']);?></h4>
                            <p><span class="fl"><?php echo Template::addquote($v['gtime']);?>天</span><em class="fr"><?php echo Template::addquote($v['price']);?>元宝</em></p>
                            </a>
                            <div class="goods_info">
                                <h3><?php echo Template::addquote($v['gname']);?></h3>
                                <p><?php echo Template::addquote($v['summary']);?></p>
                                <span>价格：<?php echo Template::addquote($v['price']);?>元宝</span>
                                <em>时效：<?php echo Template::addquote($v['gtime']);?>天</em>
                            </div>
                        </li>
                        <?php $n++;} ?>