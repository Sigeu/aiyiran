<?php
/* Smarty version 3.1.30, created on 2017-02-14 16:08:14
  from "D:\xampp\htdocs\aiyiran\admin\template\modules\admanage\infor.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a2baeee794c8_26165403',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c935a16f38b1b7f16e7245f3cf8afbf82e75abee' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\modules\\admanage\\infor.html',
      1 => 1478570825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/head_admin.html' => 1,
  ),
),false)) {
function content_58a2baeee794c8_26165403 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:public/head_admin.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>
  $(function(){
     $.formValidator.initConfig({formid:"form",autotip:true,generalwordwide:true});
     $("#typename").formValidator({empty:false,onshow:"请输入1-100个字符",onfocus:"请输入1-100个字符",oncorrect:"输入正确"})
	.inputValidator({min:1,max:100,onerror:"请输入1-100个字符"}).defaultPassed();

     $(".cancel").click(function(){
	    window.location.href = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/index";
	 })
  })
<?php echo '</script'; ?>
>
<body>
<div class="pubBox">
      <div class="pubtabBox">
        <div class="TabBoxT">
          <dl class="navTab">
            <dt class="on"><a href="#"><?php echo $_smarty_tpl->tpl_vars['infor']->value['typename'];?>
</a></dt>
          </dl>
        </div>
        <div class="TabBoxC">
          <div >
            <div class="pubTabel" id='parent'> 
             <form   id="form" action='<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/admanage/updateSet' method='post'>
              <table class="tabelLR">
                <tr>
                  <th width="200px"><font>*</font> 广告位文件名：</th>
                  <td>
                  <input type='hidden' name='id' value='<?php echo $_smarty_tpl->tpl_vars['infor']->value['id'];?>
'>
                  <input type='hidden' name='typefilename' value='<?php echo $_smarty_tpl->tpl_vars['infor']->value['typefilename'];?>
'>
                  <input type="text" name='typefilename' value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['typefilename'];?>
" class="Iw290"  onfocus=this.blur() style='background-color:#eee;color:#aaa' readonly /></td>
                </tr>
                <tr>
                  <th><font>*</font> 广告位名称：</th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['typename'];?>
" name='typename' id='typename' class="Iw290"/></td>
                </tr>
                <?php if ($_smarty_tpl->tpl_vars['infor']->value['attribute'] != 0) {?>
                <tr>
                  <th><font>*</font> 属性：</th>
                  <td><span>
                    <input type="radio" value='1' name='attribute' <?php if ($_smarty_tpl->tpl_vars['infor']->value['attribute'] == 1) {?>checked<?php }?>/>
                    <label>固定位置</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='attribute' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['attribute'] == 2) {?>checked<?php }?>/>
                    <label>随屏滚动</label>
                    </span></td>
                </tr>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['infor']->value['adposition'] != 0) {?>
                <tr>
                  <th>&nbsp; 是否设置广告位位置：</th>
                  <td><span>
                    <input type="radio" name='adposition' value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adposition'] == 1) {?>checked<?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='adposition' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adposition'] == 2) {?>checked<?php }?>/>
                    <label>否</label>
                    </span></td>
                </tr>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordnum'] != 0) {?>
                <tr>
                  <th>&nbsp; 是否设置文字广告显示字数：</th>
                  <td><span>
                    <input type="radio" name='wordnum' value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordnum'] == 1) {?>checked<?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='wordnum' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordnum'] == 2) {?>checked<?php }?>/>
                    <label>否</label>
                    </span></td>
                </tr>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordeffect'] != 0) {?>
                <tr>
                  <th>&nbsp; 文字广告效果：</th>
                  <td><span>
                    <input type="radio" name='wordeffect' value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordeffect'] == 1) {?>checked<?php }?>/>
                    <label>轮播</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='wordeffect' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['wordeffect'] == 2) {?>checked<?php }?>/>
                    <label>无效果</label>
                    </span></td>
                </tr>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['infor']->value['closeeffect'] != 0) {?>
                <tr>
                  <th>&nbsp; 关闭后效果：</th>
                  <td><span>
                    <input type="radio" name='closeeffect' value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['closeeffect'] == 1) {?>checked<?php }?>/>
                    <label>嵌入</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='closeeffect' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['closeeffect'] == 2) {?>checked<?php }?>/>
                    <label>翻卷</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span>
                    <input type="radio" name='closeeffect' value='3' <?php if ($_smarty_tpl->tpl_vars['infor']->value['closeeffect'] == 3) {?>checked<?php }?>/>
                    <label>弹窗</label></span>
                    </td>
                </tr>
                <?php }?>
                <tr>
                  <th>&nbsp; 是否设置广告尺寸：</th>
                  <td><span>
                    <input type="radio" name='adsize' value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adsize'] == 1) {?>checked<?php }?>/>
                    <label>是</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='adsize' value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adsize'] == 2) {?>checked<?php }?>/>
                    <label>否</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 广告位下的广告：</th>
                  <td><span>
                    <input type="radio" name='adtime'  value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adtime'] == 2) {?>checked<?php }?> />
                    <label>手动更改</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='adtime'  value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['adtime'] == 1) {?>checked<?php }?> />
                    <label>按上架时间显示一个</label>
                    </span>&nbsp;&nbsp;<span class="warnBlue">温馨提示：全部列出适用于图片轮播类型的广告位，仅显示一张会根据广告位列表的广告下架时间自动替换。</span>
                  </td>
                </tr>
                <tr>
                  <th>&nbsp; 广告位可使用类型：</th>
                  <td><span>
                    <input type="checkbox" name='adtype[]' disabled value='1' <?php if (in_array('1',$_smarty_tpl->tpl_vars['types']->value)) {?>checked<?php }?>/>
                    <label>图片</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="checkbox" name='adtype[]' disabled value='2' <?php if (in_array('2',$_smarty_tpl->tpl_vars['types']->value)) {?>checked<?php }?>/>
                    <label>flash</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="checkbox" name='adtype[]' disabled value='3' <?php if (in_array('3',$_smarty_tpl->tpl_vars['types']->value)) {?>checked<?php }?>/>
                    <label>文字</label>
                    </span></td>
                </tr>
                <tr>
                  <th>&nbsp; 一次最多添加广告图片数量：</th>
                  <td><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['infor']->value['adnum'];?>
" name='adnum' class="Iw45" <?php if ($_smarty_tpl->tpl_vars['infor']->value['typefilename'] != 'change' && $_smarty_tpl->tpl_vars['infor']->value['typefilename'] != 'word') {?>disabled<?php }?>>&nbsp;张</td>
                </tr>
                <tr>
                  <th>&nbsp; 状态：</th>
                  <td><span>
                    <input type="radio" name='state'  value='1' <?php if ($_smarty_tpl->tpl_vars['infor']->value['state'] == 1) {?>checked<?php }?>/>
                    <label>开启</label>
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <input type="radio" name='state'  value='2' <?php if ($_smarty_tpl->tpl_vars['infor']->value['state'] == 2) {?>checked<?php }?>/>
                    <label>关闭</label>
                    </span></td>
                </tr>
              </table>      
              <div class="pubTabelBot">
                <input type="submit" hidefocus="hide" value="确定" class="btn1" id="sub">
                <input type="button" hidefocus="hide" value="取消" class="btn2 cancel">
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html><?php }
}
