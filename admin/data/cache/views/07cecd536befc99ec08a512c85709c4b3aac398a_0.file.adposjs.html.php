<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:07:53
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\adposjs.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2bad97f8ad7_72690665',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '07cecd536befc99ec08a512c85709c4b3aac398a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\adposjs.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2bad97f8ad7_72690665 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>留言板管理 </title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/validator.css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(function(){
	$("#copy1").click(function(){
		copyToClipboard($("input[name='action']").val());
	})
	$("#copy2").click(function(){
		copyToClipboard($("input[name='static']").val());
	})
})
function copyToClipboard(txt) {
	if(window.clipboardData) {
		window.clipboardData.clearData();
		clipboardData.setData("Text", txt);
		alert("复制成功！");
		
	} else if(navigator.userAgent.indexOf("Opera") != -1) {
		window.location = txt;
	} else if (window.netscape) {
		try {
		netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		} catch (e) {
		alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");
		}
	var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
	if (!clip) return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
	if (!trans) return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = txt;
		str.data = copytext;
		trans.setTransferData('text/unicode',str,copytext.length*2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip)
		return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
		alert('复制成功');
    }
}
<?php echo '</script'; ?>
>
</head>
<body>
    <div class="pubBox" style='height:550px;'>
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">调用代码</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <div class="pubTabel">
             <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/savePosition" id='myform' method='post'>
              <table class="tabelLR">
                <tr>
                  <th width="145px"></th>
                  <td>
                   <span style='color:#FF9966'>温馨提示：两种广告调用方法：方法一动态调取广告，消耗资源，但可以获得广告的点击数量；广告二静态调取。</span>
                  </td>
                </tr>
                <tr>
                  <th>方法一动态调取：</th>
                  <td><input class="Iw450"  name='action' type="text" value="<?php if ($_smarty_tpl->tpl_vars['id']->value != 0) {
echo '<script'; ?>
 language='javascript' src='{HOST_NAME}index/index/preview/id/<?php echo $_smarty_tpl->tpl_vars['posid']->value;?>
'><?php echo '</script'; ?>
><?php }?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                  <input class="btn6" type="button" hidefocus="hide" value="复制到剪切板" id='copy1'>
                  </td>
                </tr>
                <tr>
                  <th>方法二静态调取：</th>
                  <td><input class="Iw450"  name='static' type="text" value="<?php if ($_smarty_tpl->tpl_vars['id']->value != 0) {
echo '<script'; ?>
 language='javascript' src='{HOST_NAME}html/adcache/<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
.js'><?php echo '</script'; ?>
><?php }?>"/>&nbsp;&nbsp;&nbsp;&nbsp;
                  <input class="btn6" type="button" hidefocus="hide" value="复制到剪切板" id='copy2'>
                  </td>
                </tr>
              </table>
            </div>
           </form>
          </div>
        </div>
      </div>
    </div>
    </body>
    </html><?php }
}
