<?php
/* Smarty version 3.1.30, created on 2017-02-16 10:26:09
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\system\safety.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a50dc1bec9b0_69111133',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '64d49ca41d408bfa85b032b3d32895e1203d2e26' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\system\\safety.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a50dc1bec9b0_69111133 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
    <form method="post" id="thisform" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/safety/renew">
    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">验证码设置</a></dt>         
          </dl>
        </div>
        <div class="TabBoxC">
          <div>            
            <div class="pubTabel mt10">
             	<table class="tabelLR">
                  <tr>
                    <th width="160px"> 启用验证码页面：</th>
                    <td><span>
                          <input type="checkbox" name="mo_captcha_reg" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_reg'] == 'Y') {?> checked="true" <?php }?>/>
                          <label>注册页</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="checkbox" name="mo_captcha_log" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_log'] == 'Y') {?> checked="true" <?php }?>/>
                          <label>登录页</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="checkbox" name="mo_captcha_com" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_com'] == 'Y') {?> checked="true" <?php }?>/>
                          <label>评论页</label>
                          </span></td>
                  </tr>  
                   <tr>
                    <th> 验证码类型：</th>
                    <td><span>
                          <input type="radio" name="mo_captcha_type" value="letter" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_type'] == 'letter') {?> checked="true" <?php }?> />
                          <label>字母</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_captcha_type" value="number" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_type'] == 'number') {?> checked="true" <?php }?> />
                          <label>数字</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_captcha_type" value="mix" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_captcha_type'] == 'mix') {?> checked="true" <?php }?> />
                          <label>字母 + 数字</label>
                          </span></td>
                  </tr>   
                  <tr>
                    <th> 随机颜色：</th>
                    <td><span>
                          <input type="radio" name="mo_color_rand" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_color_rand'] == 'Y') {?> checked="true" <?php }?> />
                          <label>是</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_color_rand" value="N" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_color_rand'] == 'N') {?> checked="true" <?php }?> />
                          <label>否</label>
                          </span></td>
                  </tr> 
                  <tr>
                    <th> 随机倾斜度：</th>
                    <td><span>
                          <input type="radio" name="mo_lean_rand" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_lean_rand'] == 'Y') {?> checked="true" <?php }?> />
                          <label>是</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_lean_rand" value="N" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_lean_rand'] == 'N') {?> checked="true" <?php }?> />
                          <label>否</label>
                          </span></td>
                  </tr>                                        
                </table>                
            </div>              
          </div>
        </div>         
        </div>
        <div class="pubtabBox mt10">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">时间设置</a></dt>         
          </dl>
        </div>
        <div class="TabBoxC">
          <div>            
            <div class="pubTabel mt10">
             	<table class="tabelLR">
                  <tr>
                    <th width="160px"> 日期格式：</th>
                    <td>
                      <select name="mo_date_format" style="width:300px;">
                        <option value="年-月-日" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_date_format'] == '年-月-日') {?>selected <?php }?>>年-月-日</option>
                        <option value="年/月/日" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_date_format'] == '年/月/日') {?>selected <?php }?>>年/月/日</option>
                        <option value="年:月:日" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_date_format'] == '年:月:日') {?>selected <?php }?>>年:月:日</option>
                        <option value="月-日-年" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_date_format'] == '月-日-年') {?>selected <?php }?>>月-日-年</option>
                        <option value="月/日/年" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_date_format'] == '月/日/年') {?>selected <?php }?>>月/日/年</option>
                        </select>
                    </td>
                  </tr>  
                   <tr>
                    <th> 时间格式：</th>
                    <td>
                      <select name="mo_time_format" style="width:300px;">
                        <option value="时:分:秒" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_format'] == '时:分:秒') {?>selected <?php }?>>时:分:秒</option>
                        <option value="时-分-秒" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_format'] == '时-分-秒') {?>selected <?php }?>>时-分-秒</option>
                        <option value="时:分" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_format'] == '时:分') {?>selected <?php }?>>时:分</option>
                        <option value="时-分" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_format'] == '时-分') {?>selected <?php }?>>时-分</option>
                        </select>
                    </td>
                  </tr>   
                  <tr>
                    <th> 当地时区：</th>
                    <td>
                    <select name="mo_time_zone" style="width:300px;">
                        <option value="中国北京" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '中国北京') {?>selected <?php }?>>中国北京</option>
                        <option value="中国上海" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '中国上海') {?>selected <?php }?>>中国上海</option>
                        <option value="中国广州" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '中国广州') {?>selected <?php }?>>中国广州</option>
                        <option value="中国香港" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '中国香港') {?>selected <?php }?>>中国香港</option>
                        <option value="泰国曼谷" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '泰国曼谷') {?>selected <?php }?>>泰国曼谷</option>
                        <option value="法国巴黎" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '法国巴黎') {?>selected <?php }?>>法国巴黎</option>
                        <option value="日本东京" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '日本东京') {?>selected <?php }?>>日本东京</option>
                        <option value="新加坡" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '新加坡') {?>selected <?php }?>>新加坡</option>
                        <option value="洛杉玑" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '洛杉玑') {?>selected <?php }?>>美国洛杉玑</option>
                        <option value="美国纽约" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '美国纽约') {?>selected <?php }?>>美国纽约</option>
                        <option value="华盛顿" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '华盛顿') {?>selected <?php }?>>华盛顿</option>
                        <option value="墨西哥" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '墨西哥') {?>selected <?php }?>>墨西哥</option>
                        <option value="夏威夷" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_time_zone'] == '夏威夷') {?>selected <?php }?>>夏威夷</option>
                     </select></td>
                  </tr>                                     
                </table>                
            </div>              
          </div>
        </div>         
        </div>
        <div class="pubtabBox mt10">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">IP黑名单</a></dt>         
          </dl>
        </div>
        <div class="TabBoxC">
          <div>            
            <div class="pubTabel mt10">
             	<table class="tabelLR">
                  <tr>
                    <th width="160px"> 启用IP禁止：</th>
                    <td><span>
                          <input type="radio" name="mo_ip_forbid" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_ip_forbid'] == 'Y') {?> checked="true" <?php }?> />
                          <label>是</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_ip_forbid" value="N" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_ip_forbid'] == 'N') {?> checked="true" <?php }?> />
                          <label>否</label>
                          </span>&nbsp;&nbsp;<span>注：此功能启用，会禁止此IP访问网站前台和后台</span></td>
                  </tr>  
                   <tr>
                    <th style="vertical-align:top;"> 禁止IP：</th>
                    <td><textarea class="Iw450 Ih80" name="mo_forbidden_area" id="mo_forbidden_area"><?php echo $_smarty_tpl->tpl_vars['row']->value['mo_forbidden_area'];?>
</textarea>
                    	<span class="warnBlue"></span></td>
                  </tr>   
                  <tr>
                    <th> 禁IP段：</th>
                    <td><input class="Iw150" name="mo_forbidden_start" type="text" id="mo_forbidden_start" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['mo_forbidden_start'];?>
"/><span>--</span>
                    <input class="Iw150" name="mo_forbidden_end" id="mo_forbidden_end" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['mo_forbidden_end'];?>
"/>
                    	<span class="warnBlue"></span></td>
                  </tr>                             
                </table>                
            </div>              
          </div>
        </div>         
        </div>
        <div class="pubtabBox mt10">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#">其他</a></dt>         
          </dl>
        </div>
        <div class="TabBoxC">
          <div>            
            <div class="pubTabel mt10">
             	<table class="tabelLR">
                  <tr>
                    <th width="160px"> 启用后台管理操作日志：</th>
                    <td><span>
                          <input type="radio" name="mo_admin_log" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_admin_log'] == 'Y') {?> checked="true" <?php }?> />
                          <label>是</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_admin_log" value="N" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_admin_log'] == 'N') {?> checked="true" <?php }?> />
                          <label>否</label>
                          </span></td>
                  </tr>  
                   <tr>
                    <th> 保存错误日志：</th>
                    <td><span>
                          <input type="radio" name="mo_save_error_log" value="Y" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_save_error_log'] == 'Y') {?> checked="true" <?php }?> />
                          <label>是</label>
                          </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                          <input type="radio" name="mo_save_error_log" value="N" <?php if ($_smarty_tpl->tpl_vars['row']->value['mo_save_error_log'] == 'N') {?> checked="true" <?php }?> />
                          <label>否</label>
                          </span></td>
                  </tr>   
                  <tr>
                    <th> 最大失败登录次数：</th>
                    <td><input class="Iw150" name="mo_max_logintime" id="mo_max_logintime" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['mo_max_logintime'];?>
"/></td>
                  </tr>                                                       
                </table>                
            </div>              
          </div>
        </div>         
        </div>
        <div class="pubTabelBot">
          <input type="submit" value="确定" class="btn1" />
          &nbsp;&nbsp;&nbsp;
          <input type="button" value="取消" onclick="location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/safety/index'" class="btn2" />
      </div>
    </div>
    </form>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
$.formValidator.initConfig({formid:"thisform",autotip:true,generalwordwide:true});

$("#mo_forbidden_area").formValidator({onshow:"IP样式如，192.168.3.63,多个IP之间用','隔开",onfocus:"请输入IP地址",oncorrect:"输入正确",empty:true})
.inputValidator({min:10,max:300,onerror:"请输入10-300个字符,多个IP之间用','隔开"}).regexValidator({regexp:['ip4'],datatype:"enum",onerror:"请输入10-300个字符,多个IP之间用','隔开"});

$("#mo_forbidden_start").formValidator({onshow:"例如：192.168.3.0--192.168.3.56",onfocus:"请输入IP地址",oncorrect:"输入正确",empty:true})
.inputValidator({min:10,max:300,onerror:"请输入10-300个字符,多个IP之间用','隔开"}).regexValidator({regexp:['ip4'],datatype:"enum",onerror:"请输入10-300个字符,多个IP之间用','隔开"});

$("#mo_forbidden_end").formValidator({onshow:" ",onfocus:"请输入IP地址",oncorrect:"输入正确",empty:true})
.inputValidator({min:10,max:300,onerror:"请输入10-300个字符,多个IP之间用','隔开"}).regexValidator({regexp:['ip4'],datatype:"enum",onerror:"请输入10-300个字符,多个IP之间用','隔开"});

$("#mo_max_logintime").formValidator({onshow:" ",onfocus:"请输入正整数",oncorrect:"输入正确",empty:true}).inputValidator({min:1,onerror:"请输入正整数"}).regexValidator({regexp:['intege1'],datatype:"enum",onerror:"请输入正整数"});

});
<?php echo '</script'; ?>
><?php }
}
