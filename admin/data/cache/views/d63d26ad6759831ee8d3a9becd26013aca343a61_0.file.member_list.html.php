<?php
/* Smarty version 3.1.30, created on 2017-02-07 17:18:43
  from "D:\xampp\htdocs\aiyiran\admin\template\members\member\member_list.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_589990f32f4473_04846744',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd63d26ad6759831ee8d3a9becd26013aca343a61' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\members\\member\\member_list.html',
      1 => 1486459122,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_589990f32f4473_04846744 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.truncate_cn.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title></title>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/basc.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['csspath']->value;?>
/styleG.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/My97DatePicker/WdatePicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>
<style type="text/css">
 #gray{color:#ccc;text-decoration:none;}
</style>
<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {    
	selectmenu("<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/ajax/level","groupid","levelid","<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
");
      $('#groupid').change(function(){
          var number=$("#groupid :selected").val();
          $.ajax({
                  type:"POST",
                  url:"<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/ajax/level",
                  data:"id="+number,
                  success:function(msg){
                      $("#levelid").html(msg);    
                  }
                  });
      }); 
      
  });
<?php echo '</script'; ?>
>
</head>
<body>
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['state'] == 0) {?>class="on"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/state/0/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/0/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">全部会员</a></dt>
            <dt <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['state'] == 3) {?>class="on"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/state/3/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/3/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">待开通</a></dt>
            <dt <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['state'] == 2) {?>class="on"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/state/2/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/2/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">已关闭</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <form action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index" method="get" id='myForm' name="myForm">
            <input type="hidden" id="state" name="state" value="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['state'];?>
" />
            <input type="hidden" id="page" name="page" value="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
" />
            <div class="pubTabelTot">
              <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
" class="Iw290 text-tips" tips="请输入关键字" style="width:150px;" id="keyword"  name="keyword">
              
              <select class="Iw290" style="width:130px;" id="groupid"  name="groupid">
                   <option value="">请选择会员组</option>
                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'], 'name', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                   <option value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['searchInfo']->value['groupid'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                   <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

               </select>
               <select class="Iw290" style="width:130px;" id="levelid" name="levelid">
                   <option value="">请选择会员级别</option>
               </select>
              
              <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['state'] == 0) {?>
              <select class="Iw290" style="width:130px;" id="status" name="status">
                <option value="">请选择会员状态</option>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['arrStatus'], 'name', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"  <?php if ($_smarty_tpl->tpl_vars['searchInfo']->value['status'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </select>
              <?php }?>              
              &nbsp;&nbsp;注册时间：<span class="time"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
" class="Iw90" onfocus="WdatePicker()" id="starttime" name="starttime"></span>&nbsp;至&nbsp;<span class="time"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
" class="Iw90" onfocus="WdatePicker()" id="endtime" name="endtime"></span>
              <input type="submit" hidefocus="hide" value="搜 索" class="btn5">
            </div>
            <div class="pubTabel">
              <table class="tabelTB" id='search-list'>
                <tr>
                  <th width="6%">选择</th>
                  <th width="15%">用户名</th>
                  <th width="15%">会员级别</th>
                  <th width="12%">会员组</th>
                  <th width="10%">注册时间</th>
                  <th width="12%">状态</th>
                  <th width="15%">最近一次登录时间</th>
                  <th width="15%">操作</th>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['memberList']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <tr>
                  <td><input type="checkbox"  name="memberid[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" /></td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
"><?php if ($_smarty_tpl->tpl_vars['item']->value['username']) {
echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['item']->value['username'],"12","...",'utf8');
} else {
echo $_smarty_tpl->tpl_vars['item']->value['email'];
}?></td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['allLevel'][$_smarty_tpl->tpl_vars['item']->value['groupid']][$_smarty_tpl->tpl_vars['item']->value['levelid']];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['pageInfo']->value['allLevel'][$_smarty_tpl->tpl_vars['item']->value['groupid']][$_smarty_tpl->tpl_vars['item']->value['levelid']],"8","...",'utf8');?>
</td>
                  <td title="<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'][$_smarty_tpl->tpl_vars['item']->value['groupid']];?>
"><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['pageInfo']->value['allGroup'][$_smarty_tpl->tpl_vars['item']->value['groupid']],"8","...",'utf8');?>
</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['createtime'],'%Y-%m-%d');?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['arrStatus'][$_smarty_tpl->tpl_vars['item']->value['status']];?>
</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['lastlogintime'],'%Y-%m-%d %H:%M:%S');?>
</td>
                  <td><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/edit/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/state/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['state'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">修改</a> | 
                  <a href="#" onclick="MoConfirm('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/delete/memberid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/state/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['state'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
','确定删除？');">删除</a> | 
                  <?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?><a href="#" id="gray">开通</a><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/isable/flag/1/memberid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/state/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['state'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">开通</a><?php }?> | 
                  <?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 2) {?><a href="#" id="gray">关闭</a><?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/isable/flag/2/memberid/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/page/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['page'];?>
/state/<?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['state'];?>
/keyword/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['keyword'];?>
/groupid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['groupid'];?>
/levelid/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['levelid'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['status'];?>
/starttime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['starttime'];?>
/endtime/<?php echo $_smarty_tpl->tpl_vars['searchInfo']->value['endtime'];?>
">关闭</a><?php }?></td>
                </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubOperate"><span class="btn5" style="width:80px;"><label><input type="checkbox" class="Check-All-Toggle" container-id="search-list" /> 全选/反选</label></span>
              <input type="button" class="btn5" value="开通"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/isable/flag/1" empty-tips="请选择要开通的会员！" confirm-tips="确定开通？"/>
              <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['state'] != 2) {?>
              <input type="button" class="btn5" value="关闭"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/isable/flag/2" empty-tips="请选择要关闭的会员！" confirm-tips="确定关闭？"/>
              <?php }?>
              <input type="button" class="btn5" value="删除"  onclick="batchOperate(this)" form-id="myForm" container-id="search-list"  form-action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/delete" empty-tips="请选择要删除的会员！" confirm-tips="确定删除？"/>
            </div>
            <div class="pubTabelBot">
              <div class="pageGo"><?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['pageStr'];?>
</div>
            </div>
            <div style='width:100%;text-align:center;'>温馨提示：待开通会员包括已注册未通过邮件激活的会员和已注册管理员未审核的会员</div>
          </div>
          
          <div style="height:100px; display:none"></div>
          <div style="height:100px; display:none"></div>
        </div>
      </div>
    </div>   
</body>
</html><?php }
}
