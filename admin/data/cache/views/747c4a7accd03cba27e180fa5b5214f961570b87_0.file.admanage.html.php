<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:07:36
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\admanage.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2bac8e6e5c9_89230024',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '747c4a7accd03cba27e180fa5b5214f961570b87' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\admanage.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2bac8e6e5c9_89230024 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>广告位管理 </title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
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
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
   $(function(){
	   $(".del").click(function(){
		   var id = $(this).attr('reg');
		   $.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/checkAd','id='+id,function(i){
			  if(i>0){
				  MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/delposition/id/'+id+'/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/category/<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
','此分类下存在广告，如删除分类则广告同步删除，确定删除？')
			  }else{
				  MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/delposition/id/'+id+'/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/category/<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
','确定要删除此广告位吗？')
			  }
		   });
	   })
	   $("#manydel").click(function(){
		   var str='';
		   $("input[name='id[]']:checked").each(function(){
			   str +=$(this).val()+",";
		   });
		   var id = str.substr(0,str.length-1);
		   $.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/checkAd','id='+id,function(i){
			  if(i>0){
				  $(this).attr('confirm-tips',"选择分类下存在广告，如删除分类则广告同步删除，确定删除？")
				  batchOperate($("#manydel"));
			  }else{
				  $(this).attr('confirm-tips',"确认删除？")
				  batchOperate($("#manydel"));
			  }
		   });
		  
	   })
    })
<?php echo '</script'; ?>
>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">广告位列表</a></dt>
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/addposition" class='last'>添加广告位</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
             <div class="pubTabelTot">
              <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/adposition" method='get' id="batch-form">
              <input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" />
                                         投放范围：
              <select class="Iw290" style="width:140px;" name='category'>
                <option value="0">所有栏目</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['search']->value['category'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['catname'];?>
</option>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>        
                                          广告位名称：
              <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['search']->value['keyword'] != '') {
echo $_smarty_tpl->tpl_vars['search']->value['keyword'];
} else { ?>请输入广告名称<?php }?>" class="Iw150 f999 text-tips"  tips="请输入广告名称" value="请输入广告名称" name='keyword'>
              <input type="submit" hidefocus="hide" value="搜 索" class="btn5">
            </div>
            <div class="pubTabel">
             <table class="tabelTB" id='search-list'>
                <tr>
                  <th width="10%">选择</th>
                  <th width="24%">广告位名称</th>
                  <th width="10%">广告类型</th>
                  <th width="15%">投放范围</th>
                  <th width="8%">广告数量</th>
                  <th>操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox" name='id[]' value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
'/></td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['adname'];?>
'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['adname'],10,'...',true);?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['adtypename'];?>
</td>
                  <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['clumnname'];?>
'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['clumnname'],10,'...',true);?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['item']->value['adnum'];?>
</td>                 
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/preview/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/type/<?php echo $_smarty_tpl->tpl_vars['item']->value['adtypeid'];?>
" target="_blank">预览</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/adposjs/adpos/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/type/<?php echo $_smarty_tpl->tpl_vars['item']->value['adtypeid'];?>
">调用代码</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/advert/adpos/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">广告列表</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/addAdvert/adpos/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/state/1/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/category/<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
">添加广告</a> | 
                  <a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/editposition/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['search']->value['keyword'];?>
/category/<?php echo $_smarty_tpl->tpl_vars['search']->value['category'];?>
">修改</a> | 
                  <a class="del" reg='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' href="#">删除</a>
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
              <span class="btn5" style="width:80px;">
              <label>
              <input type="checkbox" class="Check-All-Toggle" container-id="search-list"  /> 全选/反选</label></span>
              <input type="button" class="btn5" value="删除" id='manydel' class="Check-All-Toggle"  form-id="batch-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/delposition" empty-tips="请选择要删除的记录！" confirm-tips="确认删除？"/>
            </div>
            <div class="pubTabelBot">
             <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageStr']->value;?>
</div>
            </div> 
            </form>
          </div>  
        </div>
      </div>
    </div>   
</body>
</html>
<?php }
}
