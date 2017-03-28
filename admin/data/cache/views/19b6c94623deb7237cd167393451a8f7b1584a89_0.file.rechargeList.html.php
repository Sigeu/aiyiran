<?php
/* Smarty version 3.1.30, created on 2017-03-10 17:35:10
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\order\rechargeList.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58c2734e416ef3_86335080',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '19b6c94623deb7237cd167393451a8f7b1584a89' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\order\\rechargeList.html',
      1 => 1489138509,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58c2734e416ef3_86335080 (Smarty_Internal_Template $_smarty_tpl) {
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
<!-- layer插件 -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/skin/default/layer.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/layer/layer.js"><?php echo '</script'; ?>
>
<!-- 时间日期插件 -->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/laydate.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/need/laydate.css" type="text/css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/laydate/skins/molv/laydate.css" type="text/css">




</head>

<body>
  <div class="pubBox">
      <div class="pubtabBox">
        <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" method='get' id="batch-form">
      
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
              <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                    <th width="10%">用户名</th>
                    <th width="5%">当前账户元宝</th>
                    <th width="5%">已消费元宝</th>
                    <th width="5%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                    </td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['username']) {?>
                      <?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>

                      <?php } else { ?>
                      <?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>

                      <?php }?>
                    </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['point'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['consume_num'];?>
</td>
                    <td>
                   <a href="javascript:;" onclick="messageInfo(<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)" class="last">调节账户</a>
                  </td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>

            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
             </form>          
           </div>
          </div>

    </body>
    </html>
<?php echo '<script'; ?>
>
    function messageInfo(id){
        art.dialog.open('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/inc_recharge/id/'+id,{
            title:'账户调节',
            id:'batchAudit',
            width:'700px',
            height:'300px',
            lock:true,
            ok:function(){
                var iframe = this.iframe.contentWindow;
                var mo_webname = iframe.document.getElementById("mo_webname"); //元宝数量
                var mo_basehost = iframe.document.getElementById("beizhu"); //备注的值
                var point = mo_webname.value;
                var remarks = mo_basehost.value;
//                $("#mo_basehost").val(remarks);

                $.ajax({
                    type: "Post",
                    url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/modrecharge",
                    data: {'id':id,'point':point,'remarks':remarks},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 1) {
                            alert('操作成功');
                            window.location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/order/rechargeList';
                        } else {
                            alert('操作失败');
                            messageInfo(id);
                        };
                    }
                });
                window.top.art.dialog({id:'batchAudit'}).close();
            },
            cancel:function(){
                window.top.art.dialog({id:'batchAudit'}).close();
            }
        });
          //////////////////////////
//        window.top.art.dialog({
//            title:'调节账户',
//            content:'<iframe src="/admin/memorial/order/inc_recharge/id/'+id+'/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
   " width="630px" height="500px" scrolling="yes" frameborder="0"></iframe>',
//            width:'630px',
//            height:'500px',
//            id:'createActivit',
//            cancel:function(){
//                window.top.art.dialog({id:'batchAudit'}).close();
//            }
//        });
    }


    function infoUser(id)
    {
        //iframe层
        layer.open({
            type: 2,
            title: 'layer mobile页',
            shadeClose: true,
//            shade: 0.8,
            area: ['380px', '90%'],
            content: 'http://layer.layui.com/mobile/' //iframe的url
        });
    }
<?php echo '</script'; ?>
><?php }
}
