<?php
/* Smarty version 3.1.30, created on 2017-02-08 15:55:15
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\dbm\webset_dbbackup_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589acee314da61_38683773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e3eb5d0910a08065ee390a1de48890b1fea2def3' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\dbm\\webset_dbbackup_index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589acee314da61_38683773 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>内容列表</title>
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
</head>
<body>
<div class="pubBox">
      <div class="pubtabBox">
		<div class="TabBoxT">
			<dl class="navTab">
				<dt class="on" style="width:80px;"><a href="#">数据库列表</a></dt>
				<dd>&nbsp;&nbsp;&nbsp;* 推荐使用mysqldump、phpmyadmin、navicat等专业的mysql工具来备份还原。</dd>
				<dd class="add">
				<a href="javascript:;" onclick="backupAllSite()">整站备份</a>
				</dd>
			</dl>
		</div>
          <div>
            <div class="pubTabelTot">
				<!--  搜索表单  -->
				 <form method="post" id="dbbackup-form" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/index">
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['name'];?>
" name='name' class="Iw215 text-tips" tips="请输入关键字">
				<input type="button" hidefocus="hide" value="搜 索" onclick="javascript:$('#dbbackup-form').submit();" class="btn5">

				</form>
           </div>
			<!--  批量操作表单  -->
		<form method="post" id="backup-form" action="javascript:;" enctype="multipart/form-data">
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="15%">数据库表</th>
                  <th width="15%">记录条数</th>
                  <th width="15%">大小</th>
                  <th width="15%">编码</th>
                  <th width="15%">说明</th>
                  <th width="15%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['table_info']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				<tr>
					<td><input type="checkbox" name="table_name[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['Name'];?>
" /></td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['Name'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['Rows'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['Data_length'];?>
M</td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['Collation'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['l']->value['Comment'];?>
</td>
					<td><a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/backup/name/<?php echo $_smarty_tpl->tpl_vars['l']->value['Name'];?>
/searchname/<?php echo $_smarty_tpl->tpl_vars['search']->value['name'];?>
','你确定备份吗？')">备份</a></td>
				</tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"> <span class="btn5">
             <label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选</label> 
              </span>
			  <input type="button" class="btn5" value="备份" onclick="batchOperate(this)" form-id="backup-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/splitbackup/searchname/<?php echo $_smarty_tpl->tpl_vars['search']->value['name'];?>
" empty-tips="请选择要进行备份的表！" confirm-tips="你确定要备份吗？"/>
            </div>
		</form>
          </div>
        </div>
      </div>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
	/*JS表单搜索,暂时没有用到*/
	function searchTable ()
	{
		var search_val = $("input[name='name']").val();
		//搜索等于空  显示全部
		if (search_val == '')
		{
			$('#search-list tr:gt(0)').show();
			return true;
		}
		var list = $('#search-list tr:gt(0)');
		$.each(list, function(i, n)
		{
			var table_name = $(n).find('td:eq(1)').html();
			var re = new RegExp(search_val,"i");
			if (!re.test(table_name))
			{
			$('#search-list tr:eq('+(i+1)+')').hide().find(':checkbox').attr('checked',false);
			}
		});
	}
	
	//整站备份
	function backupAllSite ()
	{
		$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/isclose',function(d)
		{
			if (d == 'N')
			{
				art.dialog.through({content:'请先关闭网站，在进行整站备份',fixed:true,icon:'warning'},function(){});
			}
			else if (d == 'Y')
			{
				var be_sure = art.dialog.through({content:'你确定要进行整站备份吗',fixed:true,icon:'question'},function()
				{
					//be_sure.button({name: '取消',disabled: true},{name: '确定',disabled: true});
					be_sure.content('正在请求数据...');
					$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/backupall',function(data)
					{
						if(data == 'fail')
							be_sure.content('备份失败');
						else
							be_sure.content('备份成功');
						//be_sure.button({name: '取消',disabled: false},{name: '确定',disabled: false});
						be_sure.time(1);
					});
					return false;
				},function(){
					be_sure.close();
				});
			}
		});
	}
<?php echo '</script'; ?>
><?php }
}
