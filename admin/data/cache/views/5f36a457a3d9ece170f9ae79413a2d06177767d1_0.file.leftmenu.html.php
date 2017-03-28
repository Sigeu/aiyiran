<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:06:15
  from "D:\WWW\jisi2\admin\template\admin\index\leftmenu.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585384577695c5_19016970',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f36a457a3d9ece170f9ae79413a2d06177767d1' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\admin\\index\\leftmenu.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585384577695c5_19016970 (Smarty_Internal_Template $_smarty_tpl) {
?>
    <?php if (count($_smarty_tpl->tpl_vars['leftMenuList']->value) > 0) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['leftMenuList']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
    <dl>
      <dt><a class='act'><?php echo $_smarty_tpl->tpl_vars['m']->value['name'];?>
</a></dt>
      <dd <?php if ($_smarty_tpl->tpl_vars['submenuinfo']->value['parentid'] == $_smarty_tpl->tpl_vars['m']->value['id'] || $_smarty_tpl->tpl_vars['submenuinfo']->value['id'] == $_smarty_tpl->tpl_vars['m']->value['id']) {?>style="display:block;"<?php }?> >
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['m']->value['menuchild'], 'mc');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mc']->value) {
?>
          <a id="_MP<?php echo $_smarty_tpl->tpl_vars['mc']->value['id'];?>
" href="javascript:_MP('<?php echo $_smarty_tpl->tpl_vars['mc']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['mc']->value['linkURL'];?>
');" <?php if ($_smarty_tpl->tpl_vars['submenuinfo']->value['id'] == $_smarty_tpl->tpl_vars['mc']->value['id']) {?>class='sub_menu focus'<?php } else { ?>class='sub_menu'<?php }?> ><?php echo $_smarty_tpl->tpl_vars['mc']->value['name'];?>
</a>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      </dd>
    </dl>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    <?php }?>
    <?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
		/*sideNav dl*/
			$(".sideNav dt a").click(function(){
					var dd=$(this).parent('dt').parent('dl');
					if(dd.hasClass('act')){
						dd.find('dd').slideUp('fast',function(){
							dd.removeClass('act');
						});						
					}else{
						dd.find('dd').slideDown('fast',function(){
							dd.addClass('act');							
						});			
						dd.siblings('dl').removeClass('act').find('dd').slideUp('fast');
					}
				})
			if(navigator.appName == "Microsoft Internet Explorer"){
				if(navigator.appVersion.match(/9./i)!="9."){
						$('input:text').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){										
										$(this).css('border','1px solid #e5e5e5');
						})
						$('select').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){										
										$(this).css('border','1px solid #e5e5e5');
						})
						$('textarea').focus(function(){									
									$(this).css('border','1px solid #59d7ff');
						}).blur(function(){
										$(this).css('border','1px solid #e5e5e5');
						})
				}}

			/*publicBoxTab*/
			var tabs=$(".TabBoxT dt");
			tabs.bind('click',function(){
				$(this).addClass('on').siblings('dt').removeClass('on');
				var cons=$(this).parents('.pubtabBox').find('.TabBoxC>div');
				cons.hide().get($(this).index()).style.display='block';
			})
			/*文字过长不显示*/
			$('.js_show a').hover(function(){
					var s=$(this).attr('cont');
					var pos=$(this).offset();
					var html=$('<div class="showAll"></div>');
					html.text(s);
					$('body').append(html);
					html.css({top:pos.top-25,left:pos.left-10});
				},function(){
						$('.showAll').remove();
					})
})
    <?php echo '</script'; ?>
><?php }
}
