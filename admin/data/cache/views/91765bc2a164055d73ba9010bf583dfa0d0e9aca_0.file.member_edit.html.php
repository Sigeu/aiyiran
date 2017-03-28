<?php
/* Smarty version 3.1.30, created on 2017-03-07 14:42:19
  from "D:\xampp\htdocs\aiyiran\admin\template\members\member\member_edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58be564bdb9b50_13640936',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91765bc2a164055d73ba9010bf583dfa0d0e9aca' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\members\\member\\member_edit.html',
      1 => 1478570827,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58be564bdb9b50_13640936 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\xampp\\htdocs\\aiyiran\\vendor\\smarty\\plugins\\modifier.date_format.php';
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
<div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dd><a href="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index" class="last">会员列表</a></dd>
            <dt class="on"><a href="#">编辑会员</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
            <form action="" method="post" id='myForm' name="myForm">
            <div class="pubTabel mt10">
              <div class="theme">基本信息</div>
              <table class="tabelLR">
                <tr class="border">
                  <th width="145">&nbsp;&nbsp;用户名：</td>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['memberInfo']->value['username'];?>
" class="Iw290"  onfocus=this.blur() style='background-color:#eee;color:#aaa' readonly /></td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;登录密码：</th>
                  <td><input type="password" value="" class="Iw290" id="password" name="baseinfo[password]"/></td>
                </tr>
                <tr class="border">
                  <th width="145">&nbsp;&nbsp;确认密码：</td>
                  <td><input type="password" value="" class="Iw290" id="password2"  /></td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;会员组：</th>
                  <td><select class="Iw290" style="width:150px;" disabled>
                          <option value=""><?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['groupList'][$_smarty_tpl->tpl_vars['memberInfo']->value['groupid']];?>
</option>
                      </select></td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;会员状态：</th>
                  <td><select class="Iw290" style="width:150px;" id="status" name="baseinfo[status]">
                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['arrStatus'], 'name', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['memberInfo']->value['status'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                      </select></td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;会员级别：</th>
                  <td><select class="Iw290" style="width:150px;" id="levelid" name="baseinfo[levelid]">
                         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['levelList'], 'name', false, 'id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['memberInfo']->value['levelid'] == $_smarty_tpl->tpl_vars['id']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option>
                          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                      </select></td>
                </tr>
                <tr class="border">
                  <th><font>*</font>电子邮箱：</th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['memberInfo']->value['email'];?>
" class="Iw290" id="email" name="baseinfo[email]"/></td>
                </tr>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['formArr'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
                  <?php echo $_smarty_tpl->tpl_vars['item']->value;?>

                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

              </table>
            </div>
            <div class="pubTabel">
              <div class="theme">其他信息</div>
              <table class="tableX">
                <tr>
                  <th>&nbsp;&nbsp;注册时间：</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['memberInfo']->value['createtime'],'%Y-%m-%d %H:%M:%S');?>
</td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;注册IP：</th>
                  <td><?php echo $_smarty_tpl->tpl_vars['memberInfo']->value['createip'];?>
</td>
                </tr>
                <tr>
                  <th width="160">&nbsp;&nbsp;最近一次登录时间：</td>
                  <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['memberInfo']->value['lastlogintime'],'%Y-%m-%d %H:%M:%S');?>
</td>
                </tr>
                <tr class="border">
                  <th>&nbsp;&nbsp;最近一次登录IP：</th>
                  <td><?php echo $_smarty_tpl->tpl_vars['memberInfo']->value['lastloginip'];?>
</td>
                </tr>
              </table>
            </div>
            <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1">
                <input type="button" hidefocus="hide" value="取消" class="btn2" onclick="javascript:history.back();">
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php echo '<script'; ?>
 type="text/javascript">
  $(document).ready(function() {
    $.formValidator.initConfig({autotip:true,formid:"myForm",onerror:function(msg){}});
    $("#password").formValidator({empty:true,onshow:"若不修改密码则置空",onfocus:"请输入4-20个字符,由字母、数字、符号组成"}).inputValidator({min:4,max:20,onerror:"请输入4-20个字符,由字母、数字、符号组成",onerrormax:"最多输入20个字符"});
    $("#password2").formValidator({empty:true,onshow:"若不修改密码则置空",onfocus:"请输入4-20个字符,由字母、数字、符号组成",oncorrect:"两次输入的密码一致"}).inputValidator({min:4,max:20,onerror:"请输入4-20个字符,由字母、数字、符号组成",onerrormax:"最多输入20个字符"}).compareValidator({desid:"password",operateor:"=",onerror:"两次输入密码不一致"});
    $("#email").formValidator({onshow:"请输入正确的邮箱，例：example@example.com",onfocus:"请输入正确的邮箱，例：example@example.com"}).inputValidator({min:6,max:100,onerror:"请输入正确的邮箱，例：example@example.com"}).regexValidator({regexp:"^([\\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onerror:"输入的邮箱格式不正确"}).ajaxValidator({
        url:"<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/Checkregist/checkEmail",
        success : function(data){
            //alert(data);
            if(data==1) return true;
            if(data==2) return false;
            return false;
        },
        buttons: $("#dosubmit"),
        error: function(XMLHttpRequest, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
        onerror : "该电子邮箱已存在，请重新输入",
        onwait : "正在对电子邮箱进行合法性校验，请稍候..."
        }).defaultPassed();
    <?php echo $_smarty_tpl->tpl_vars['pageInfo']->value['formvalidator'];?>

  });
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
