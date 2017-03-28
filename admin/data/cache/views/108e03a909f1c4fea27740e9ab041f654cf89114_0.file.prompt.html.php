<?php
/* Smarty version 3.1.30, created on 2016-12-19 12:04:50
  from "D:\xampp\htdocs\aiyiran\admin\template\public\prompt.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58575c6274b194_26988217',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '108e03a909f1c4fea27740e9ab041f654cf89114' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\public\\prompt.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58575c6274b194_26988217 (Smarty_Internal_Template $_smarty_tpl) {
?>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<style type='text/css'>

.message{width:85%;height:50px;line-height:50px;font-size:12px;text-align:center;overflow:hidden}
.prompt {width:400px;border:solid 1px #2E9EE1;margin-bottom:100px;margin-top:100px;z-index:120;}
.prompt1 {width:300px;position:absolute;z-index:120;}
.prompt_text{width:80%;font-size:14px;text-align:center;padding-top:20px;}
.bgdate{background:url(../images/background.png) no-repeat; background-position: -270px 0;display: inline-block;height: 24px;vertical-align: -7px;width: 26px;}

</style>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
 <?php echo '<script'; ?>
>
 
	$(function(){
		
       setTimeout('fun(2)',1000);
       
    });
	
	function fun(num){
        num--;
        if(num==0){
        	var info = $("#hidtype").val();
        	if(info =='success' || info == ''){
        		
                location.href=$("#url").val();
        	}else{
        		
                history.back(-1);
            }
        	
        }else{
            setTimeout('fun('+num+')',1000);
        }
    }
 <?php echo '</script'; ?>
>
 <BODY>
 <div class="pubBox">
 <center>
  <div class="notif prompt">
			<h4><span style='float:left'>提示</span></h4>
			<div class="Ncon">
				<div class="Ncon" style="padding:30px 0px;">
				  <input type="hidden" value='yes' id='change'>
				  <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['param']->value['type'];?>
" id='hidtype'>		
			      <span class="" id="prom_text"><?php echo $_smarty_tpl->tpl_vars['param']->value['str'];?>
</span>	
	            </div>
				<div class="Nsubm">
				<input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;
echo $_smarty_tpl->tpl_vars['param']->value['url'];?>
" id='url'>
				<input class="btn3 confirm" type="button" value="确定" hideFocus="hide"/>
				</div>
		  	</div>
  </div> 
  </center> 
</div>   
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/prompt.js"><?php echo '</script'; ?>
>
 </BODY>
</HTML><?php }
}
