<?php if(!defined('IN_MAINONE')) exit(); ?>

        <link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
        <link rel="stylesheet" type="text/css" href="/template/default/member/css/manage_yc.css"/>
        <?php include Template::t_include('member/head_left.html');?>
        <style>
            .layui-layer-content {
                text-indent: 2em;
                padding: 10px!important;
                font-size: 16px!important;
                line-height: 20px;
                color: #666!important;
            }
        </style>
<div class="conRig_yc">
                <h3 class="dwH3_yc">系统消息</h3>
                
                <table class="table_yc">
                    <thead>
                        <tr>
                            <td><span>信息标题</span></td>
                            <td><span>类型</span></td>
                            <td><span>状态</span></td>
                            <td><span>日期</span></td>
                            <td><span>操作</span></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($lists)) { ?>
                    <?php $n=1;foreach($lists AS $k => $v) { $lastIndex= count($lists) == $n;?>
                        <tr>
                            <td><span><a href="javascript:;"><?php echo Template::addquote($v['title']);?></a></span>
                            <p style="display: none;">11111111111111111111111111111111111111</p>
                            </td>

                            <td><span>

                                系统消息
                            </span></td>
                            <td>
                                <span><?php if($v['status']==2) { ?>
                                已读
                                <?php } else { ?>
                                未读
                                <?php } ?></span>
                            </td>
                            
                            <td><span><?php echo date('Y-m-d H:i:s',$v['addtime']);?></span></td>
                            <td><span><a href="javascript:;" data="<?php echo Template::addquote($v['id']);?>" class="look">查看</a></span></td>
                        </tr>
                    <?php $n++;} ?>
                    <?php } else { ?>
                        <?php echo 没找到信息，稍后再试;?>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="pageF_yc">
                    <?php echo $pagestr;?>
                </div>
            </div>
        </div>
        <div class="wrapS03_yc jbFT_yc">
            <p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
        </div>
    </body>
        <script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
        <script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
        <script type="text/javascript" src="/template/default/member/js/common.js" ></script>

<script>
    $(function () {
        $(".look").click(function () {
            var $this=$(this);

            var id = $(this).attr('data');

                $.ajax({
                    type: "Post",
                    url: "/member/Systeminfo/look",
                    data: {'id':id},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            layer.open({
                                type: 1,
                                skin: 'layui-layer-rim', //加上边框
                                area: ['420px', '240px'], //宽高
                                content: data.content,
                                title: data.title,
                            });
                        }else{
                            layer.msg('查看失败', {icon: 2, offset: '40%'});
                        }
                    }
                });
        });
    });
</script>

<script>
$(function(){
   
});
</script>

</html>
