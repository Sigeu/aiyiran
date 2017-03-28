<?php
/* Smarty version 3.1.30, created on 2017-03-07 16:41:30
  from "D:\xampp\htdocs\aiyiran\admin\template\admin\index\init.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58be723a217329_15421834',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e15f64d6df275d6afc862d504c0b5fdbc7c2fafd' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\admin\\index\\init.html',
      1 => 1488876089,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/top_left_nav.html' => 1,
    'file:public/copyright.html' => 1,
  ),
),false)) {
function content_58be723a217329_15421834 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>CMS首页</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css" title="basc"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascB.css" rel="alternate stylesheet" type="text/css" title="bascB"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascG.css" rel="alternate stylesheet" type="text/css" title="bascG"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/bascR.css" rel="alternate stylesheet" type="text/css" title="bascR"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/validator.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/styleswitch.js"><?php echo '</script'; ?>
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
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/floatcheck.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
    var numbers = Math.random();
    var menu='';
    var menuid = $("#menuid").val();
    var submenu = $("#submenu").val();
    var defRightUrl = $("#defRightUrl").val();
    if(submenu=='')
    {
        menu=menuid;
    }else
    {
        menu=submenu;
    }
    
    //默认载入左侧菜单
    $("#leftMain").load("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;
echo $_smarty_tpl->tpl_vars['defLeftMenu']->value;?>
&number="+numbers);
    $("#rightMain").attr('src', "<?php echo $_smarty_tpl->tpl_vars['defRightUrl']->value;?>
");
   
    $.get("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/currentpos?menuid="+menu, function(data){
        $("#current_pos").html(data.substr(0,data.length-3));
    });
    $("#current_pos").data('clicknum', 1);
})
//clientHeight-0; 空白值 iframe自适应高度
function SetCwinHeight(){   
	var iframeid=document.getElementById("rightMain"); //iframe id  
	if (document.getElementById){    
		if (iframeid && !window.opera){     
			if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight){     
				iframeid.height = iframeid.contentDocument.body.offsetHeight;     
				}else if(iframeid.Document && iframeid.Document.body.scrollHeight){     
					iframeid.height = iframeid.Document.body.scrollHeight;     
					}    
			}   
		}  
	}

function _M(menuid, targetUrl,submenu,rightUrl) {
    var numbers = Math.random();
    $("#menuid").val(menuid);
    $("#submenu").val(submenu);
    $("#defRightUrl").val(rightUrl);
    $("#leftMain").load("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
"+targetUrl + "?moduleid="+menuid+"&submenu="+submenu+"&number="+numbers);
    if (rightUrl.indexOf("?") == -1) {//不含“?”
        rightUrl += '?t=' + Math.random();
    } else {
        rightUrl += '&t=' + Math.random();
    }
    $("#rightMain").attr('src', rightUrl);
    //$.get("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/admin/defrighturl",{moduleid:menuid,number:numbers},function(data){
    //   $("#rightMain").attr('src', "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
"+data);
   // });
    
    $('.focus').removeClass();
    $('#_M'+menuid).addClass("focus");
    $.get("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/currentpos?menuid="+submenu, function(data){
        $("#current_pos").html(data.substr(0,data.length-3));
    });
    $("#current_pos").data('clicknum', 1);
}

function _MP(menuid,targetUrl) {
    $("#menuid").val(menuid);
    if (targetUrl.indexOf("?") == -1) {//不含“?”
        targetUrl += '?t=' + Math.random();
    } else {
        targetUrl += '&t=' + Math.random();
    }
    $("#rightMain").attr('src', targetUrl);
    $('.sub_menu').removeClass("focus");
    $('#_MP'+menuid).addClass("focus");
    $.get("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/currentpos?menuid="+menuid, function(data){
        $("#current_pos").html(data.substr(0,data.length-3));
    });
    $("#current_pos").data('clicknum', 1);
}
/*确定按钮*/
function promptOk(){
	
	$('#maker').css('display','none');
	$("#parent").css('display','none');
	$("#adpro").remove();
	right.window.load();
}

function hidmaker(){
	$('#maker').css('display','none');
	$("#parent").css('display','none');
	$("#adpro").remove();
}

function deletedata(url,id){
	right.window.deleteInfor(url,id);
}

/*常用操作跳转*/
function _SC(menuid,targetUrl,topmenu)
{
	var bigmenu='';
    if(topmenu=='' || topmenu==undefined){
        bigmenu=1;
    }else{
        bigmenu=topmenu;
    }
        
    window.location.href = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/init?menuid="+bigmenu+"&submenu="+menuid+"&rightUrl="+targetUrl; 
}

function reinitIframe()
{
	var iframe = document.getElementById("rightMain");
	try
	{
		iframe.height = iframe.contentWindow.document.documentElement.scrollHeight;
	}
	catch (ex)
	{}
}
window.setInterval("reinitIframe()", 500);

<?php echo '</script'; ?>
>
</head>
<body>
<div  id='maker'></div>
<div id='parent'>
</div>
<div class="logo_Nav">
  <div class="mainone">
    <a href="<?php echo $_smarty_tpl->tpl_vars['hostname']->value;?>
" target="_blank"><div class="logo"></div></a>
    <div class="guide"><a href="#" class="guideA"></a>
     <?php $_smarty_tpl->_subTemplateRender("file:public/top_left_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
  </div>
  <div class="state">
    <div class="headPic">
      <p>Hi! <?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['username'];?>
 <?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['rolename'];?>
</p>
      <p>[<a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/login/loginout">退出</a>]&nbsp;[<a href="#" onclick="editPassword();">修改密码</a>]</p>
    </div>
  </div>
  <div class="mainNav">
    <ul><?php echo $_smarty_tpl->tpl_vars['topMenuStr']->value;?>
</ul>
  </div>
  <div class="clearfix"></div>
</div>
<div class="handle">
  <dl>
    <dt>常用操作</dt>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['shortcut'], 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
    <dd><a href="javascript:_SC('<?php echo $_smarty_tpl->tpl_vars['row']->value['parentid'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['linkURL'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['moduleid'];?>
')"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></dd>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    <dd><a href="#" class="last" onclick="shortcut();"><b>+</b> 增加</a></dd>
  </dl>
</div>
<div class="wrap">
  <div class="thumb">
    <div class="skin"><a class="skin1 styleswitch" href="#" rel="basc"></a><a class="skin2 styleswitch" href="#" rel="bascB"></a><a class="skin3 styleswitch" href="#" rel="bascG"></a><a class="skin4 styleswitch" href="#" rel="bascR"></a></div>
    <s></s>当前位置：<span id="current_pos"></span></div>
  <div class="sideNav" id="leftMain"> </div>
  <div class="openClose"><span class="closeBtn"></span> </div>
  <div class="container" style='position:relative;'>
    <iframe name="right" id="rightMain" src="" frameborder="0" scrolling="no"  width="100%" height="100%" onload="javascript:SetCwinHeight()"></iframe>
    <input type="hidden" id="menuid" value="<?php echo $_smarty_tpl->tpl_vars['menuId']->value;?>
">
    <input type="hidden" id="submenu" value="<?php echo $_smarty_tpl->tpl_vars['submenu']->value;?>
" />
    <input type="hidden" id="defRightUrl" value="<?php echo $_smarty_tpl->tpl_vars['defRightUrl']->value;?>
" />
    <div class="foot"><?php $_smarty_tpl->_subTemplateRender("file:public/copyright.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
  </div>
  <div class="clearfix"></div>
</div>



</body>
</html>                                                                                                                                                                                                                                                                                                 
<?php }
}
