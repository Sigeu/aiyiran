<?php
/* Smarty version 3.1.30, created on 2017-02-20 10:52:53
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\euloinfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa5a05c99de9_97185423',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a28c168e471bc099f9b624d943cf07e58f9aefdf' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\euloinfo.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58aa5a05c99de9_97185423 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
	<div class="pubBox" >
		<div class="pubtabBox">
		
			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/euloinfo' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th>标题：</th>
									<td>
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['ename'];?>
" class="Iw290" name='ename' id='ename'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                                <tr>
                                  <th>内容：</th>
                                  <td><textarea class="Iw450 Ih80" id='content' name='econtent'><?php echo $_smarty_tpl->tpl_vars['info']->value['econtent'];?>
</textarea></td>
                                 </tr>
                                 <tr>
                                  <th>状态：</th>
                                  <td>
                                   <select name="status">
                                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pstatus']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['k']->value == $_smarty_tpl->tpl_vars['info']->value['status']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                   <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                   </select>
                                  </td>
                                 </tr>
                                </table>
                                <input type="hidden" name="hid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
"/>
                                <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['mid'];?>
"/>
							<div class="pubTabelBot"><input type="submit" name="submit" hidefocus="hide" value="确定" class="btn1">&nbsp;&nbsp;&nbsp;</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php echo '<script'; ?>
>
CKEDITOR.replace('content',
    		{   
    		    width:700,
                height:250,
    			toolbar :
    			[
    				//样式       格式      字体    字体大小
    				['Styles','Format','Font','FontSize'],
    				//加粗     斜体，     下划线      穿过线      下标字        上标字
    				['Bold','Italic','Underline','Strike','Subscript','Superscript'],
    				// 数字列表          实体列表            减小缩进    增大缩进
    				['NumberedList','BulletedList','-','Outdent','Indent'],
    				//文本颜色     背景颜色
    				['TextColor','BGColor'],
    				//全屏           显示区块
    				['Maximize', 'ShowBlocks','-', 'Source']
    			]
    		}
    		);
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
