<?php
/* Smarty version 3.1.30, created on 2017-02-20 10:43:15
  from "D:\xampp\htdocs\aiyiran\admin\template\memorial\hall\biography.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58aa57c31dc655_82038883',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '988f97c9ec9a087aa346bdc148c6faad224b93ab' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\memorial\\hall\\biography.html',
      1 => 1487558553,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58aa57c31dc655_82038883 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body><?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
	<div class="pubBox" >
		<div class="pubtabBox">
		<div class="TabBoxT">
          <dl class="navTab">
             <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/index" class="last">纪念馆列表</a></dd>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/info/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">逝者资料管理</a></dt>
             <dt class="on"><a href="javascript:void(0);">传记管理</a></dt>
             <dt><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/mshow/id/<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">隐私管理</a></dt>
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
			<form action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/biography' method='post' id='myform'>
				<div class="TabBoxC">
					<div>
						<div class="pubTabel">
							<table class="tabelLR">
								<tr>
									<th>传记标题：</th>
									<td>
										<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['bioname'];?>
" class="Iw290" name='bioname' id='bioname'/>&nbsp;<span id='nameTip'></span>
									</td>
								</tr>
                                <tr>
                                  <th>传记详情：</th>
                                  <td><textarea class="Iw450 Ih80" id='content' name='biocontent'><?php echo $_smarty_tpl->tpl_vars['info']->value['biocontent'];?>
</textarea></td>
                                 </tr>
                                </table>
                                <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
"/>
                                <input type="hidden" name="action" value="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
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
    		    width:900,
                height:400,
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
