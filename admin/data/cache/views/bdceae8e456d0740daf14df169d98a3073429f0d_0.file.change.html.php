<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:30:01
  from "D:\xampp\htdocs\aiyiran\admin\template\public\advert\change.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2c009318bd5_59785707',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bdceae8e456d0740daf14df169d98a3073429f0d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\public\\advert\\change.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2c009318bd5_59785707 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['n']->value != 1) {
echo '<script'; ?>
 language='javascript' type='text/javascript'><?php }?>
    var content_str = "<link href='<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/mainone_ads.css' type='text/css' rel='stylesheet' /><link href='<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/GG.css' type='text/css' rel='stylesheet' /><style type='text/css'>#mainone_ads_LBGG {width:<?php echo $_smarty_tpl->tpl_vars['ad']->value['width'];?>
px; height:<?php echo $_smarty_tpl->tpl_vars['ad']->value['height'];?>
px;position:relative; overflow:hidden;margin-top:<?php echo $_smarty_tpl->tpl_vars['ad']->value['up'];?>
px;margin-left:<?php echo $_smarty_tpl->tpl_vars['ad']->value['left'];?>
px;}#mainone_ads_picBox { height:<?php echo $_smarty_tpl->tpl_vars['ad']->value['height'];?>
px; width:<?php echo $_smarty_tpl->tpl_vars['ad']->value['width'];?>
px;}#mainone_ads_picBox li{ height:<?php echo $_smarty_tpl->tpl_vars['ad']->value['height'];?>
px;}</style><div class='mainone_ads_LBGG mainone_ads' id='mainone_ads_LBGG'><?php if (0 == 0) {?><ul id='mainone_ads_picBox' style='top:0;'><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['adimg']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><li><a href='<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
'><img width='<?php echo $_smarty_tpl->tpl_vars['ad']->value['width'];?>
' height='<?php echo $_smarty_tpl->tpl_vars['ad']->value['height'];?>
'src='<?php if ($_smarty_tpl->tpl_vars['item']->value) {
if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/static/uploadfile/advert/<?php echo $_smarty_tpl->tpl_vars['item']->value['img']['path'];
} else {
if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/admin/template/images/LB1.png<?php }?>'/></a></li><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
</ul><ul id='mainone_ads_liBox'><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['adimg']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?><li <?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?>class='active'<?php }?>><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</li><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
</ul><?php } else { ?><ul id='mainone_ads_picBox' style='top:0;'><li><a href='#'><img src='<?php if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/admin/template/images/LB1.png'/></a></li><li><a href='#'><img src='<?php if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/admin/template/images/LB1.png'/></a></li><li><a href='#'><img src='<?php if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/admin/template/images/LB1.png'/></a></li><li><a href='#'><img src='<?php if ($_smarty_tpl->tpl_vars['n']->value == 1) {?>../..<?php }?>/admin/template/images/LB1.png'/></a></li></ul><ul id='mainone_ads_liBox'><li class='active'>1</li><li>2</li><li>3</li><li>4</li></ul><?php }?></div>";
	document.write(content_str);
	var xxk = new function(){
		function $id(id){
			return document.getElementById(id);
		}
		this.glide = function(auto,a,b,size,second,fSpeed,point){
			var oSubLi = $id(a).getElementsByTagName('li');
			var sum = oSubLi.length;
			var interval,timeout,Rang;
			var speed = fSpeed;
			var delay = second * 1000;
			var time = 5;
			var a = 0;
			var setValTop = function(s){
				return function(){
					Rang = Math.abs(parseInt($id(b).style[point]));
					$id(b).style[point] = -Math.floor(Rang + (parseInt(s * size) - Rang) * speed) + 'px';
					if(Rang == [(s * size)]){
						clearInterval(interval);
						a = s;
					}
				}
			}
			var setValDown = function(s){
				return function(){
					Rang = Math.abs(parseInt($id(b).style[point]));
					$id(b).style[point] = -Math.ceil(Rang + (parseInt(s * size) - Rang) * speed) + 'px';
					if(Rang == [(s * size)]){
						clearInterval(interval);
						a = s;
					}
				}
			}
			function autoGlide(){
				for(var c = 0; c < sum;c++){
					oSubLi[c].className = '';
				}
				clearInterval(timeout);
				if(a == (parseInt(sum) - 1)){
					for(var c = 0; c < sum;c++){
						oSubLi[c].className = '';
					}
					a = 0;
					oSubLi[a].className = 'active';
					interval = setInterval(setValTop(a),time);
					timeout = setTimeout(autoGlide,delay);
				}else{
					a++;
					oSubLi[a].className = 'active';
					interval = setInterval(setValDown(a),time);
					timeout = setTimeout(autoGlide,delay);
				}
			}
			timeout = setTimeout(autoGlide,delay);
			for(var i = 0;i < sum;i++){
				oSubLi[i].onmouseover = (function(i){
					return function(){
						for(var c = 0;c <sum;c++){
							oSubLi[c].className = '';
						}
						clearInterval(interval);
						clearTimeout(timeout);
						oSubLi[i].className = 'active';
						if(Math.abs(parseInt($id(b).style[point])) > [(size * i)]){
							interval = setInterval(setValTop(i),time);
							this.onmouseout = function(){
								timeout = setTimeout(autoGlide,delay);
							}
						}else if(Math.abs(parseInt($id(b).style[point])) < [(size * i)]){
							interval = setInterval(setValDown(i),time);
							this.onmouseout = function(){
								timeout = setTimeout(autoGlide,delay);
							}
						}
					}
				})(i);
			}
		}
	}
	xxk.glide(true,'mainone_ads_liBox','mainone_ads_picBox',<?php if ($_smarty_tpl->tpl_vars['ad']->value['height'] != '') {
echo $_smarty_tpl->tpl_vars['ad']->value['height'];
} else { ?>171<?php }?>,5,0.1,'top');
<?php if ($_smarty_tpl->tpl_vars['n']->value != 1) {
echo '</script'; ?>
><?php }
}
}
