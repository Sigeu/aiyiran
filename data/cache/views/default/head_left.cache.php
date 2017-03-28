<?php if(!defined('IN_MAINONE')) exit(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心--纪念馆管理</title>
    <!-- <link rel="stylesheet" href="DsDialog/css/base.css"> -->

</head>
<body>
        <?php include Template::t_include('member/head_top.html');?>

    <div class="wrapW">
            <div class="conLeft_yc">
                <h3 class="h3Com_yc"><span></span>
                <?php if($nav_title['name']) { ?>
                    <?php echo Template::addquote($nav_title['name']);?>纪念馆管理
                <?php } elseif ($nav_title3) { ?>
                    我的消息
                <?php } else { ?>
                    账号设置
                <?php } ?></h3>
                <ul class="jbList_yc">
                    <?php $n=1;foreach($nav AS $k => $v) { $lastIndex= count($nav) == $n;?>
                    <!-- 纪念馆管理导航 -->
                    <?php if($v['cid']==1) { ?>
                        <li><a href="<?php echo Template::addquote($v['url']);?><?php echo $mid;?>" <?php if($v['id']==$sdid) { ?> class="active" <?php } ?>><?php echo Template::addquote($v['name']);?></a></li>
                    <?php } ?>
                    <!-- 账号设置导航 -->
                    <?php if($v['cid']==2) { ?>
                        <li><a href="<?php echo Template::addquote($v['url']);?>" <?php if($v['id']==$sdid) { ?> class="active" <?php } ?>><?php echo Template::addquote($v['name']);?></a></li>
                    <?php } ?>
                    <!-- 系统消息 -->
                    <?php if($v['cid']==3) { ?>
                        <li><a href="<?php echo Template::addquote($v['url']);?>" <?php if($v['id']==$sdid) { ?> class="active" <?php } ?>><?php echo Template::addquote($v['name']);?></a></li>
                    <?php } ?>

                    <?php $n++;} ?>
                </ul>
            </div>
<script type="text/javascript" src="/template/default/member/js/jq.js" ></script>
<script type="text/javascript" src="/template/default/member/js/jquery.form.js" ></script>


<!-- layer插件 -->
<link rel="stylesheet" href="/template/default/member/layer/skin/default/layer.css" type="text/css">
<script src="/template/default/member/layer/layer.js"></script>

<!--插件-->
<!--<link rel="stylesheet" href="/template/default/member/DsDialog/css/base.css" type="text/css">-->
<!--<script src="/template/default/member/DsDialog/js/dsdialog.js"></script>-->

<style>
    #layui-layer1{top: 38%!important;}
</style>
