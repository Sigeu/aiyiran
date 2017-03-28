<?php
/* Smarty version 3.1.30, created on 2017-01-13 18:51:15
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\cemetery\map.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5878b123de63b1_48776672',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe903dd18ec846b222c8bfb7393398c9de79507a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\cemetery\\map.html',
      1 => 1481531577,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
    'file:public/cemetery_public.html' => 1,
  ),
),false)) {
function content_5878b123de63b1_48776672 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<!-- layer插件 -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/skin/default/layer.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/layer.js"><?php echo '</script'; ?>
>
<style type="text/css">
    .pic{width: 15px; height: 15px;position: relative;left: -22px; top: -1px;
    display: inline-block; cursor: pointer;}
    .pic img{width: 15px; height: 15px;}
</style>

<body>
    <div class="pubBox" >
        <div class="pubtabBox">
<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        $(".f").addClass("on");
    })
<?php echo '</script'; ?>
>
        <?php $_smarty_tpl->_subTemplateRender("file:public/cemetery_public.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


            <form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/map' method='post' id='myform'>
                <div class="TabBoxC">
                    <div>
                        <div class="pubTabel">
                            <table class="tabelLR">
                              
                                <tr>
                                    <th width="180px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>*</font>生成地图：</th>
                                        <td ><input type="text" name="map_name" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['map_name'];?>
"></td>
                                    </td>
                                </tr>

                             
                                <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
                              </table>

                            <div class="map" style="width: 100%; height: 300px;">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
        #allmap{width:370px;height:270px;}
        p{margin-left:5px; font-size:14px;}
    </style>
    <?php echo '<script'; ?>
 type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=UcWpOkDTRFZC7kxTkGCQmwSRNek8kxDf"><?php echo '</script'; ?>
>
    <title>根据关键字本地搜索</title>
</head>
<body>
    <div id="allmap"></div>
    <!-- <p>返回北京市“景点”关键字的检索结果，并展示在地图上</p> -->
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");          
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map}
    });
    local.search("北京市");
<?php echo '</script'; ?>
>


                            </div>

                            <div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;<input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:window.location.href = '<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/cemetery/lists'"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php }
}
