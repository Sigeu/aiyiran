<?php
/* Smarty version 3.1.30, created on 2017-02-08 15:55:12
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\dbm\webset_dbrecover_index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589acee0d7e471_63266641',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64db1240cc89a6eaf9f6fce5d673c56cb2d68659' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\dbm\\webset_dbrecover_index.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589acee0d7e471_63266641 (Smarty_Internal_Template $_smarty_tpl) {
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
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
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
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
</head>
<body>
 <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">数据库还原列表</a></dt>
            <dd>&nbsp;&nbsp;&nbsp;* 推荐使用mysqldump、phpmyadmin、navicat等专业的mysql工具来备份还原。</dd>
			<dd class="add"><a href="javascript:;" onclick="uploadAccessory({'limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','ady_upload':1})">本地导入</a></dd>
			<dd class="add"><a href="javascript:;" onclick="recoverAll()">整站还原</a></dd>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabelTot">
			<!--  搜索表单  -->
			<form method="post" id="dbrecover-form" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/index">
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['name'];?>
" name='name' class="Iw215 text-tips" tips="请输入关键字">&nbsp;&nbsp;备份时间
				<span class="time"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['start'];?>
" class="Iw90" onfocus="WdatePicker()" id="starttime" name="start"></span>&nbsp;至&nbsp;<span class="time"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['end'];?>
" class="Iw90" onfocus="WdatePicker()" id="endtime" name="end"></span>
				<input type="button" hidefocus="hide" onclick="javascript:$('#dbrecover-form').submit();" value="搜 索" class="btn5">
			</form>
            </div>
			<form method="post" id="backup-form" action="javascript:;" enctype="multipart/form-data">
            <div class="pubTabel">
              <table class="tabelTB" id="search-list">
                <tr>
                  <th width="10%">选择</th>
                  <th width="15%">文件名</th>
                  <th width="15%">大小</th>
                  <th width="15%">备份时间</th>
                  <th width="15%">操作</th>
                </tr>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['file_list']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>
				 <tr>
                  <td><input type="checkbox" name="file_name[]" value="<?php echo $_smarty_tpl->tpl_vars['l']->value['file_dir'];?>
@<?php echo $_smarty_tpl->tpl_vars['l']->value['file_name'];?>
" /></td>
                  <td><?php echo $_smarty_tpl->tpl_vars['l']->value['file_name'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['l']->value['file_size'];?>
K</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['l']->value['filec_time'];?>
</td>
                  <td><a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/recover/tbname/<?php echo $_smarty_tpl->tpl_vars['l']->value['file_dir'];?>
@<?php echo $_smarty_tpl->tpl_vars['l']->value['file_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
','你确定要还原该表吗？')">还原</a> / <a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/download/tbname/<?php echo $_smarty_tpl->tpl_vars['l']->value['file_dir'];?>
@<?php echo $_smarty_tpl->tpl_vars['l']->value['file_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
','你确定吗？','false')">下载</a> / <a href="javascript:;" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/delete/tbname/<?php echo $_smarty_tpl->tpl_vars['l']->value['file_dir'];?>
@<?php echo $_smarty_tpl->tpl_vars['l']->value['file_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
','你确定删除该备份吗？')">删除</a></td>
                </tr>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"> 
                <span class="btn5">
                    <label>
                        <input type="checkbox" class="Check-All-Toggle" container-id="search-list" style="position: relative; top: 3px; width: 15px;"/> 全选/反选
                    </label>
                </span>
                <input type="button" class="btn5" value="还原" onclick="batchOperate(this)" form-id="backup-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/recover/<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
" empty-tips="请选择要进行还原的表！" confirm-tips="你确定要还原吗？"/>
			  
			  <input type="button" class="btn5" value="删除" onclick="batchOperate(this)" form-id="backup-form" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/delete/<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
" empty-tips="请选择要进行删除的表！" confirm-tips="你确定要删除吗？"/>
            </div>
		   </form>
          </div>
        </div>
      </div>
    </div>
	<div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">

/*整站还原*/
function recoverAll ()
{
	$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/isclose',function(d)
	{
		if (d == 'N')
		{
			art.dialog.through({content:'请先关闭网站，在进行整站还原',fixed:true,icon:'warning'},function(){});
		}
		else if (d == 'Y')
		{
			var f_tips = art.dialog.open('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/dblist', {
			id: 'recoverID1',
			width:500,
			height:300,
			ok: function () 
			{
				var iframe = this.iframe.contentWindow;
				var file_name = $(iframe.document).find('input:checked').val();
				if(file_name == undefined)
				{
					art.dialog.alert('请选择要还原的备份文件');
					return false;
				}
				else 
				{
					var friend_tips = art.dialog.through({content:'正在请求数据，恢复整站可能需要更长的时间，请耐心等待...'});
					$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/recoverdb',{'file_name':file_name},function(d)
					{
						if(d=='success')
						{
							friend_tips.content('恢复成功');
							friend_tips.time(1);
							art.dialog({id:'recoverID1'}).close();
						}
						else
						{
							friend_tips.content('恢复失败');
							friend_tips.time(1);
							art.dialog({id:'recoverID1'}).close();
						}
						return false;
					});
				}
				return false;
			},
			cancel: true
			});
		}
	});
}

function uploadAccessory (obj)
{	
	$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbbackup/isclose',function(d)
	{
		if (d == 'N')
		{
			art.dialog.through({content:'请先关闭网站，在进行本地导入',fixed:true,icon:'warning'},function(){});
		}
		else if (d == 'Y')
		{
			var option=
			{
				upload_id:'accessory_upload',
				title:'本地导入',
				return_id:'accessory',
				callFunName:'LocalImport',
				setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
				param:obj
			};
			MainOneUpload(option);//调用统一上传方法
		}
	});
}

/**
 * 本地导入功能
 */
function LocalImport ()
{
	var iframe = this.iframe.contentWindow;		//Iframe
	var $iframe = $(iframe.document);           //iframe Jquery对象
	var $data = $iframe.find('.mo-upload-data');//上传后的数据
	var filename = $($data[0]).attr('filename');
	if(filename == undefined)
	{
		art.dialog.tips('上传文件出错啦！');
		return false;
	}
	else
	{
		var t1 = art.dialog.through({content:'正在请求数据，请稍后...',icon:'question',lock:true,fixed:true},function()
		{
			return true;
		});

		$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/dbrecover/localImport',{'filename':filename},function(d)
		{
			t1.close();
			art.dialog.through({content:d,title:'3秒后自动关闭',icon:'question',lock:true,fixed:true,time:3},function()
			{
				return true;
			});
		});
	}
}
<?php echo '</script'; ?>
><?php }
}
