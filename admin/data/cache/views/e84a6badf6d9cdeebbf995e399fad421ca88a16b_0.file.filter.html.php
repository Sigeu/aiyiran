<?php
/* Smarty version 3.1.30, created on 2017-02-16 10:26:10
  from "D:\xampp\htdocs\aiyiran\admin\template\webset\system\filter.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a50dc2604e38_21241319',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e84a6badf6d9cdeebbf995e399fad421ca88a16b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\webset\\system\\filter.html',
      1 => 1478570826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a50dc2604e38_21241319 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/mo_upload.js"><?php echo '</script'; ?>
>
<body>
    <div class="notif width445" id="so" style="display:none;" >
      <div class="Ncon">
        <div class="Ncont">
          <textarea name="mo_replacer" id="mo_replacer" class="mtb5"><?php echo $_smarty_tpl->tpl_vars['filter']->value['mo_replacer'];?>
</textarea>
        </div>
      </div>
    </div>

    <div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="javascript:void(0)">文字过滤设置</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div>
          <form method="POST" id="thisform" action="<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/Filter/correct" >
            <div class="pubTabel">
              <table class="tabelLR">
                <tr>
                  <th width="145px" style="vertical-align:top"><font>*</font> 敏感词：</th>
                  <td>
                    <table>
                        <tbody>
                            <tr>
                                <td width="45%" valign="top" rowspan="2" style="border-bottom:0px;">
                                <textarea name="mo_replacestr" id="mo_replacestr" style="height:120px;" class="Iw450 Ih80"><?php echo $_smarty_tpl->tpl_vars['filter']->value['mo_replacestr'];?>
</textarea></td>
                                <td valign="top"  style="border-bottom:0px;"><span class="warnBlue" id="mo_replacestrTip"></span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="border-bottom:0px;"><span id="single-upload"></span>
                                <input class="btn5" type="button" value="敏感词导入" name="accessory" onclick="uploadAccessory({'limit':'<?php echo $_smarty_tpl->tpl_vars['setting']->value['limit'];?>
','_switch':'brand','self_id':'uploadButton','ady_upload':1,
                  'dis_place':'single-upload'});" handle="single-upload" id="uploadButton"/>
                  <br /><br />（导入文件格式要求：txt文本，每行一个敏感词）
                            </td>
                                </tr>         
                        </tbody>
                    </table>
                    </td>
                </tr>
                <tr>
                  <th style="vertical-align:top;"> 过滤方式：</th>
                  <td><span>
                    <input type="radio" value="1" checked="true" name="mo_replace_type" <?php if ($_smarty_tpl->tpl_vars['filter']->value['mo_replace_type'] == 1) {?> checked="true" <?php }?>/>
                    <label>替换成"<?php echo $_smarty_tpl->tpl_vars['filter']->value['mo_replacer'];?>
"显示</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;<a class="Cf60" href="javascript:void(0)" onclick="go();">编辑替换文本</a><br/>
                    <span>
                    <input type="radio" value="2" name="mo_replace_type" <?php if ($_smarty_tpl->tpl_vars['filter']->value['mo_replace_type'] == 2) {?> checked="true" <?php }?>/>
                    <label>直接去除不显示</label>
                    </span><br/>
                    <span>
                    <input type="radio" value="3" name="mo_replace_type" <?php if ($_smarty_tpl->tpl_vars['filter']->value['mo_replace_type'] == 3) {?> checked="true" <?php }?>/>
                    <label>不能提交，提示有非法字符</label>
                    </span></td>
                </tr>
              </table>
              <div class="pubTabelBot">
                <input type="submit" value="确定" class="btn1" />
                <input type="button" onclick="location.href='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/Filter/index'" value="取消" class="btn2" />
              </div>
            </div>   
           </form>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">

function uploadAccessory (obj)
{	
	var option=
	{
		upload_id:'accessory_upload',
		title:'文本上传',
		return_id:'accessory',
		callFunName:'accessoryUpload',
		setting:'<?php echo $_smarty_tpl->tpl_vars['setting']->value['setting'];?>
',
		param:obj
	};
	MainOneUpload(option);//调用统一上传方法
}
$(document).ready(function(){
$.formValidator.initConfig({formid:"thisform",autotip:true,generalwordwide:true});

$("#mo_replacestr").formValidator({onshow:"多个敏感词之间用';'隔开",onfocus:"多个敏感词之间用';'隔开",oncorrect:"输入正确"})
.inputValidator({min:2,max:300,onerror:"请输入2-300个字符，多个敏感词之间用';'隔开"});
});

function go ()
{	
	var move = art.dialog.through(
	{
		content: document.getElementById('so'),
		     id: 'yellow',
		  title: '编辑替换文本',
            width:'100px',
            height:'60px',
		 button: 
			[
				{
					name: '确定',
					callback: function () 
					{
                        var top = art.dialog.top;
                        var reg = new RegExp("[\\u4E00-\\u9FA5\\uF900-\\uFA2D]+","ig");
						var ther = top.document.getElementById("mo_replacer").value;
                        if(!reg.test(ther) && ther.length < 301 && ther.length > 1)
                        {
                            $.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/Filter/replacer',{'ther':ther},function(d)
						    {
                            window.top.art.dialog.alert('操作成功');
							move.close();
							location.reload();
							return true;
						    });
                        }else {
                            window.top.art.dialog.alert('请输入2-300个字符，由数字、字符组成');
                        }
                        return false;
					},
					focus: true
				},
				{
					name: '取消',
					callback: function () 
					{
						return true;
					}
				}
			]
	});
}

<?php echo '</script'; ?>
><?php }
}
