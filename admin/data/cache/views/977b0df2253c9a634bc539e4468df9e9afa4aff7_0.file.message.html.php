<?php
/* Smarty version 3.1.30, created on 2017-02-20 10:42:08
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\message.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa5780651f50_14132783',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '977b0df2253c9a634bc539e4468df9e9afa4aff7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\message.html',
      1 => 1487558502,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58aa5780651f50_14132783 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleL.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<!--  artdialog插件  -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>

</head>

<body>
  <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
             <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" class="last">纪念馆列表</a></dd>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/info/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">逝者资料管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/biography/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">传记管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">隐私管理</a></dt>
             <dt class="on"><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/message/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">留言管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/eulogy/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">祭文悼词管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/epitaph/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">墓志铭管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/steleauthor/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">立碑人信息</a></dt>
          </dl>
        </div>
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="5%">编号</th>
                  <th width="55%">留言内容</th>
                  <th width="10%">状态</th>
                  <th width="10%">留言用户</th>
                  <th width="10%">创建时间</th>
                  <th width="10%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td>
                  <?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>

                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['message'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['pstatus']->value[$_smarty_tpl->tpl_vars['item']->value['status']];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['createtime'];?>
</td>
                  <td>
                   <a href="javascript:;" onclick="messageInfo(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">详情</a> |
                   <a href="#"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/messdel/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/mid/<?php echo $_smarty_tpl->tpl_vars['item']->value['mid'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
','确认删除？')">删除</a>
                  </td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate">
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
             </form>          
           </div>
          </div>
    <?php echo '<script'; ?>
>
    function messageInfo(id){
	    window.top.art.dialog({title:'留言详情编辑', content:'<iframe src="/admin/memorial/hall/messinfo/id/'+id+'" width="830px" height="200px" scrolling="no" frameborder="0"></iframe>', width:'830px', height:'200px',id:'createActivit'});
    }
    <?php echo '</script'; ?>
>
    </body>
    </html>
<?php }
}
