<?php
/* Smarty version 3.1.30, created on 2017-03-07 17:20:38
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\acer\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58be7b666031a5_12105097',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '503692f8bbd5a0cb1f8005b961decea6b2f03126' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\acer\\index.html',
      1 => 1488878436,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58be7b666031a5_12105097 (Smarty_Internal_Template $_smarty_tpl) {
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
            <dt class="on"><a href="#">兑换规则列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/add" class="last">添加规则</a></dd>
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
                  <th>选择</th>
                  <th>产品名称</th>
                  <th>价格</th>
                  <th></th>
                  <th>元宝数量</th>
                  <th>操作</th>
                </tr>     
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td>
                    <input type="checkbox" name="id[]" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' />
                  </td>
                  <td>
                    <input type="text" name="product_name" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_name'];?>
" class="product_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                  </td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
'>
                    <input type="text" style="width: 100px;text-align: center;" name="money" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
' class="money_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" /> 元
                  </td>
                  <td>=</td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['acer'];?>
'>
                    <input type="text" style="width: 100px;text-align: center;" name="acer" value='<?php echo $_smarty_tpl->tpl_vars['item']->value['acer'];?>
' class="acer_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" /> 元宝
                  </td>
                  <td>
                    <a href="javascript:;" class="upajax" class="up_<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" data="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">修改</a> |
                    <a href="javascript:;"  onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/delete/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
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

            <div class="pubOperate"><span class="btn5">
              <label>
              <input type="checkbox" class="Check-All-Toggle" container-id="search-list"/>
                                        全选/反选</label>
              </span> 
             
              <input type="button" class="btn5" value="删除" class="Check-All-Toggle" onclick="batchOperate(this)" form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/delete" empty-tips="请选择要删除的数据" confirm-tips="确认删除？"/>
            </div>
            *最多可添加5条规则

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
 type="text/javascript">
      $(function(){
        $(".upajax").click(function(){
          var id = $(this).attr("data");
          var tr = $(".up_"+id).parent();
          var money = $(".money_"+id).val();
          var acer = $(".acer_"+id).val();
          var product = $('.product_'+id).val();
          // location.href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/updata/id/"+id+"/money/"+money+"/acer/"+acer;
          if(id==""){
            alert("请选择删除id");
          }else{
            $.ajax({
              type: "Post",
              url: "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/updata",
              data: {"id":id, "money":money, "acer":acer, 'product':product},
              dataType: "json",
              success: function(data) {
                  if (data.status == 1) {
                    artDialog({
                      opacity: 0, // 透明度
                      content: data.msg,
                      ok: function () {
                        //点击确定执行回调函数
                      },
                    });
                  } else {
                    artDialog({content: data.msg});
                  };
              }
            });
          }
        
        });
      });
    <?php echo '</script'; ?>
>
<?php }
}
