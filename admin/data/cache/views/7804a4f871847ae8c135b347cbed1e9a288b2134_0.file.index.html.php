<?php
/* Smarty version 3.1.30, created on 2016-12-16 14:06:12
  from "D:\WWW\jisi2\admin\template\admin\index\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58538454e88965_13776775',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7804a4f871847ae8c135b347cbed1e9a288b2134' => 
    array (
      0 => 'D:\\WWW\\jisi2\\admin\\template\\admin\\index\\index.html',
      1 => 1479691895,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/baseurl.html' => 1,
    'file:public/top_left_nav.html' => 1,
    'file:public/copyright.html' => 1,
  ),
),false)) {
function content_58538454e88965_13776775 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>CMS首页</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.css" />
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
/styleL.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/jquery-1.7.2.js"><?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender("file:public/baseurl.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/pubJq.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/admin.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/styleswitch.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/jquery.artDialog.source.js?skin=blue"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['jspath']->value;?>
/artDialog4.1.6/plugins/iframeTools.source.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
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
//导航菜单
function _MM(menuid) {
    window.location.href = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/init?menuid="+menuid;   
}

//左侧菜单 我要建站 信息统计的链接跳转
function _MP(menuid,targetUrl,topmenu) {
	var bigmenu='';
	if(topmenu=='' || topmenu==undefined){
		bigmenu=1;
	}else{
		bigmenu=topmenu;
	}
	window.location.href = "<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/admin/index/init?menuid="+bigmenu+"&submenu="+menuid+"&rightUrl="+targetUrl; 
}

function nopermission()
{
    alert("对不起，您没有该权限！");
}
<?php echo '</script'; ?>
>
</head>
<body>
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

<!--  版本更新  -->
<div class="handle" id="upgrade-tips" style="display:none"></div>
<div class="wrap">
  <div class="thumb">
    <div class="skin"><a class="skin1 styleswitch" href="#" rel="basc"></a><a class="skin2 styleswitch" href="#" rel="bascB"></a><a class="skin3 styleswitch" href="#" rel="bascG"></a><a class="skin4 styleswitch" href="#" rel="bascR"></a></div>
    <s></s>当前位置：<span>后台首页</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>版权授权：<?php if ($_smarty_tpl->tpl_vars['empower']->value == '2') {?>未授权（<a href="http://www.izhancms.com/category/Category/index/cid/4" target="_blank"><font color="red">点击购买</font></a>）<?php } else { ?>已授权<?php }?>&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['imgpath']->value;?>
/alarm.png" width="16" height="16" alt="播报" style="position: relative;top: 4px;"/><marquee align="left" behavior="scroll" direction="left" scrollamount="4" height="20" width="750" onMouseOut="this.start()" hspace="15" onMouseOver="this.stop()"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['json']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['l']->value['announce_address'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['l']->value['announce_name'];?>
——<?php echo $_smarty_tpl->tpl_vars['l']->value['announce_disc'];?>
</a>&nbsp;&nbsp;<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
</marquee></strong></div>
  <div class="sideNav">
    <dl class="act">
      <dt><a href="#">常用操作</a></dt>
      <dd>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pageInfo']->value['shortcut'], 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
      <a href="javascript:_SC('<?php echo $_smarty_tpl->tpl_vars['row']->value['parentid'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['linkURL'];?>
','<?php echo $_smarty_tpl->tpl_vars['row']->value['moduleid'];?>
')"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</a></a>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      </dd> 
      <dd><a href="#" class="last" onclick="shortcut();"><b>+</b> 增加</a></dd>
    </dl>
  </div>
  <div class="openClose"><span class="closeBtn"></span> </div>
  <div class="container">
    <?php if ($_smarty_tpl->tpl_vars['pageInfo']->value['remind'] != 1) {?>
    <div class="remind"><strong>重要提醒：</strong>系统邮箱服务器未完成配置，无法发送邮件及找回密码，为保证账户安全，请<a href="#" onclick="<?php if (in_array('37',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('37','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/mailset/index','218');<?php } else { ?>nopermission();<?php }?>" >立即配置</a></div>
    <?php }?>
    <br>
      <strong>祭祀项目 - 管理中心</strong>

      <div class="js_content">
        <div class="js_div">
          <div class="js_div2" style="border-right: none;"><img src=""></div>
          <div class="js_div2"><p>今日会员新增数量</p><span>20</span></div>
        </div>

         <div class="js_div">
          <div class="js_div2" style="border-right: none;"><img src=""></div>
          <div class="js_div2"><p>今日纪念馆新增数量</p><span>20</span></div>
        </div>

         <div class="js_div" style="margin-right: 0px;">
          <div class="js_div2" style="border-right: none;"><img src=""></div>
          <div class="js_div2"><p>今日充值总额</p><span>20</span></div>
        </div>
      </div>
    <div class="right" style="width: 100%">
              <div class="pubModG left" style="width:100%;">
          <div class="titG">
            <h6>待审核事项</h6>
          </div>
          <div class="contG">
            <div class="dlG">
              <dl style="width:240px;border-right: solid #ccc 1px;margin-right: 70px;">
                <dd>作品及荣誉&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1241','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/honor/status/3/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['honor']->value;?>
</cite></a></dd>
                <dd>纪念祭文&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1243','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/eulogy/status/3/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['eulogy']->value;?>
</cite></a></dd>
                <dd>背景音乐&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1245','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/moreset/song/status/0/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['bgm']->value;?>
</cite></a></dd>
                <dd>留言&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1247','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/message/status/0/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</cite></a></dd>
              </dl>
              <dl style="width:240px;border-right: solid #ccc 1px;margin-right: 70px;">
                <dd>纪念馆&nbsp;&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('411','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/hall/jinian/status/3/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['memorial']->value;?>
</cite></a></dd>
                <dd>传记&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1242','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/audit/biography/status/0/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['bio']->value;?>
</cite></a></dd>
                <dd>相册&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;待审核 <a href="javascript:;" onclick="_MP('1244','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/memorial/acer/photo/status/0/','409')"><cite><?php echo $_smarty_tpl->tpl_vars['photo_num']->value;?>
</cite></a></dd>
              </dl>
              
              <div class="clearfix"></div>
            </div>
          </div>
        </div> 
    </div>

    <div class="left" style="width:49%">
        <div class="pubModG left" style="width:100%;">
          <div class="titG">
            <h6>信息统计</h6>
          </div>
          <div class="contG">
            <div class="dlG">
              <dl>
                <dt>会员</dt>
                <dd>管理员 <a href="#" onclick="<?php if (in_array('40',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('40','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/adminuser/index');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['admin'];?>
</cite></a> 人</dd>
                <dd>注册会员 <a href="#" onclick="<?php if (in_array('67',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('67','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index','4');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['members'];?>
</cite></a> 人</dd>
                <dd>有效会员 <a href="#" onclick="<?php if (in_array('67',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('67','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/members/member/index/status/1','4');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['activeMember'];?>
</cite></a> 人</dd>
              </dl>
              <dl>
                <dt>信息</dt>
                <dd>信息总数 <cite><a href="#" onclick="<?php if (in_array('51',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('51','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/content/index','2');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['content'];?>
</cite></a></cite> 条</dd>
                <dd>文章总数 <cite><a href="#" onclick="<?php if (in_array('57',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('57','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/content/index/modelid/1','3');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['article'];?>
</cite></a></cite> 条</dd>
                <dd>商品总数 <cite><a href="#" onclick="<?php if (in_array('58',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('58','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/goods/index','3');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['goods'];?>
</cite></a></cite> 个</dd>
              </dl>
              <dl style="width:25%">
                <dt>评论</dt>
                <dd>评论总数 <cite><a href="#" onclick="<?php if (in_array('52',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('52','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/content/comment/index','2');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['comment'];?>
</cite></a></cite> 条</dd>
                <dd>自定义表单信息总数 <cite><a href="#" onclick="<?php if (in_array('62',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('62','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/message/index','3');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['message'];?>
</cite></a></cite> 条</dd>
              </dl>
              <dl>
                <dt>其他</dt>
                <dd>广告位 <cite><a href="#" onclick="<?php if (in_array('65',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('65','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/modules/AdManage/adPosition','3');<?php } else { ?>nopermission();<?php }?>"><cite><?php echo $_smarty_tpl->tpl_vars['counts']->value['adposition'];?>
</cite></a></cite> 个</dd>
              </dl>
              <div class="clearfix"></div>
            </div>
          </div>
        </div> 
        <div class="pubModG left" id="picplayer" style="position:relative;overflow:hidden;width:100%;height:100px; <?php if ($_smarty_tpl->tpl_vars['positon_left']->value == '1') {?> display:none;<?php }?>"></div>
         <div class="pubModG left" style="width:100%;">
          <div class="titG">
            <h6>官方信息</h6>
          </div>
          <div class="contG">
            <div class="ulG">
              <ul>
                <li>爱站官网：<a href="http://corp.b2b.cn" target="_blank">http://www.izhancms.com</a></li>
                <li>必途官网：<a href="http://corp.b2b.cn" target="_blank">http://corp.b2b.cn</a></li>
                <li>必途搜索：<a href="http://www.b2b.cn" target="_blank">http://www.b2b.cn</a></li>
                <li>必途智网：<a href="http://jianzhan.b2b.cn" target="_blank">http://jianzhan.b2b.cn</a></li>
                <li class="last">金榜题名：<a href="http://a.b2b.cn" target="_blank">http://a.b2b.cn</a></li>
              </ul>
            </div>
          </div>
        </div>
        </div>

    <div class="right" style="width:49%">
         <div class="pubModG right" style="width:100%;">
              <div class="titG">
                <h6>程序信息</h6>
              </div>
              <div class="contG">
                <div class="ulG">
                  <ul id="program-info">
                    <li>当前版本程序：<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['version'];?>
 (
                        <?php if ($_smarty_tpl->tpl_vars['sysInfo']->value['version'] >= $_smarty_tpl->tpl_vars['sysInfo']->value['new_version']) {?>已是最新版本<?php } else { ?>最新版本&nbsp;<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['new_version'];?>
&nbsp;
                            <a href="#" onclick="<?php if (in_array('246',$_smarty_tpl->tpl_vars['pageInfo']->value['mypermissionid']) || $_smarty_tpl->tpl_vars['pageInfo']->value['roleid'] == 1) {?>_MP('246','<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/upgrade/check');<?php } else { ?>nopermission();<?php }?>">
                                <font color="red">立即下载</font>
                            </a>
                        <?php }?>)
                    </li>
                    <li>操作系统：<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['os'];?>
 </li>
                    <li>服务器软件：<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['web_server'];?>
</li>
                    <li>PHP语言版本：<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['phpv'];?>
</li>
                    <li>数据库版本：<?php echo $_smarty_tpl->tpl_vars['sysInfo']->value['mysqlv'];?>
</li>
                    <li class="last">程序编码：UTF8</li>
                  </ul>
                </div>
              </div>
            </div>
           

            <div class="pubModG right" id="picplayee" style="position:relative;overflow:hidden;width:100%;height:100px; <?php if ($_smarty_tpl->tpl_vars['positon_right']->value == '1') {?> display:none;<?php }?>"></div>

           
            <div class="pubModG right" style="width:100%;">
              <div class="titG"> 
                <h6>研发团队</h6>
              </div>
              <div class="contG">
                <div class="ulG">
                  <ul>
                    <li class="last">研发团队：铭万研发中心&nbsp;&nbsp;&nbsp;&nbsp;鸣谢：广大 爱站CMS 用户、赞助商！</li>
                  </ul>
                </div>
              </div>
            </div>
    </div>

    <div class="clearfix"></div>
    <div class="foot"><?php $_smarty_tpl->_subTemplateRender("file:public/copyright.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
  </div>    
  <div class="clearfix"></div>
  
</div>
</body>
</html>

<?php echo '<script'; ?>
 type="text/javascript">
//publish_lock function checkUpdate ()
//publish_lock {
//publish_lock 	/*检测跟新升级*/
//publish_lock 	$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/upgrade/tips',function(d){
//publish_lock 		if(d != '')
//publish_lock 			$('#upgrade-tips').html(d).slideDown("slow");
//publish_lock 	});
//publish_lock 	/*$.post('<?php echo $_smarty_tpl->tpl_vars['baseurl']->value;?>
/webset/upgrade/programinfo',function(d){
//publish_lock 		if(d != '')
//publish_lock 			$('#program-info').before(d);
//publish_lock 	});*/
//publish_lock }
//publish_lock setTimeout('checkUpdate();',5000);
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">   //左侧广告位
var p = $('#picplayer');
var arr = [<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lad']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>{url:'<?php echo $_smarty_tpl->tpl_vars['l']->value['imgpath'];?>
',link:'<?php echo $_smarty_tpl->tpl_vars['l']->value['link'];?>
',time:5000,adid:'<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
'},<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
];
initPicPlayer(arr,p.css('width').split('px')[0],p.css('height').split('px')[0]); 

function initPicPlayer(pics,w,h)
{ 
    var selectedItem; //选中的图片 
    var selectedBtn;  //选中的按钮 
    var playID; //自动播放的id 
    var selectedIndex; //选中图片的索引 
    var p = $('#picplayer'); //容器 
    p.text(''); 
    p.append('<div id="piccontent"></div>'); 
    var c = $('#piccontent'); 
    for(var i=0;i<pics.length;i++) 
    { 
        //添加图片到容器中 
        c.append('<a href="javascript:void(0);" url="'+pics[i].link+'" ad-id="'+pics[i].adid+'" site_name="<?php echo $_smarty_tpl->tpl_vars['android']->value[0];?>
" host_name="<?php echo $_smarty_tpl->tpl_vars['android']->value[1];?>
" ip="<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
" ><img id="picitem'+i+'" style="display: none;z-index:'+i+'" src="'+pics[i].url+'" /></a>'); 
    }
    //按钮容器，绝对定位在右下角 
    p.append('<div id="picbtnHolder" style="position:absolute;top:'+(h-25)+'px;width:'+w+'px;height:20px;z-index:10000;"></div>'); 
    var btnHolder = $('#picbtnHolder'); 
    btnHolder.append('<div id="picbtns" style="float:right; padding-right:1px;"></div>'); 
    var btns = $('#picbtns'); 
    for(var i=0;i<pics.length;i++) 
    { 
        //增加图片对应的按钮 
        btns.append('<span id="picbtn'+i+'" style="cursor:pointer; border:solid 1px #ccc;background-color:#eee; display:inline-block;"> '+(i+1)+' </span> '); 
        $('#picbtn'+i).data('index',i); 
        $('#picbtn'+i).click( 
            function(event) 
            { 
                if(selectedItem.attr('src') == $('#picitem'+$(this).data('index')).attr('src')) 
                { 
                    return; 
                } 
                setSelectedItem($(this).data('index')); 
            } 
        ); 
    } 
    btns.append(' '); 

    setSelectedItem(0); 
    //显示指定的图片index 
    function setSelectedItem(index) 
    { 
        selectedIndex = index; 
        clearInterval(playID); 
        if(selectedItem)selectedItem.fadeOut('fast'); 
        selectedItem = $('#picitem'+index); 
        selectedItem.fadeIn('slow'); 
        if(selectedBtn) 
        { 
            selectedBtn.css('backgroundColor','#eee');
            selectedBtn.css('color','#000'); 
        } 
        selectedBtn = $('#picbtn'+index); 
        selectedBtn.css('backgroundColor','#000'); 
        selectedBtn.css('color','#fff'); 
        //自动播放 
        playID = setInterval(function() 
        { 
            var index = selectedIndex+1; 
            if(index > pics.length-1)index=0;
            setSelectedItem(index); 
        },pics[index].time); 
    } 
    
    //图片绑定事件
    jQuery('#piccontent a').live('click',function()
    {
        var _this = jQuery(this); 
        var target_url = _this.attr('url');
        var ad_id = _this.attr('ad-id');  //广告ID
        var site =  _this.attr('site_name');   //网站名称
        var domain = _this.attr('host_name');  //域名
        var ip = _this.attr('ip');  //IP
        var http_url = 'http://www.izhancms.com/official/os/adserving/hitnum?id='+ad_id+"&sitename="+site+"&hostname="+domain+"&siteip="+ip+'&izhan='+Math.random();
        var img_str = '<img src="'+http_url+'" style="display:none" />';
        jQuery('body').append(img_str);
        if (target_url) {
            window.open(target_url);
        }
    });
}
<?php echo '</script'; ?>
>

<!----------右侧广告---------->
<?php echo '<script'; ?>
 type="text/javascript">
var pp = $('#picplayee');
var array = [<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rad']->value, 'l');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['l']->value) {
?>{url:'<?php echo $_smarty_tpl->tpl_vars['l']->value['imgpath'];?>
',link:'<?php echo $_smarty_tpl->tpl_vars['l']->value['link'];?>
',time:5000,adid:'<?php echo $_smarty_tpl->tpl_vars['l']->value['id'];?>
'},<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
];
initPicPlayee(array,pp.css('width').split('px')[0],pp.css('height').split('px')[0]); 

function initPicPlayee(picss,w,h)
{ 
    var selectedItemm;
    var selectedBtnn;
    var playIDD;
    var selectedIndexx;
    var pp = $('#picplayee');
    pp.text(''); 
    pp.append('<div id="piccontentt"></div>'); 
    var c = $('#piccontentt'); 
    for(var i=0;i<picss.length;i++) 
    { 
        c.append('<a href="javascript:void(0);" url="'+picss[i].link+'" ad-id="'+picss[i].adid+'" site_name="<?php echo $_smarty_tpl->tpl_vars['android']->value[0];?>
" host_name="<?php echo $_smarty_tpl->tpl_vars['android']->value[1];?>
" ip="<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
" ><img id="picitemm'+i+'" style="display: none;z-index:'+i+'" src="'+picss[i].url+'" /></a>'); 
    } 
    pp.append('<div id="picbtnHoldee" style="position:absolute;top:'+(h-25)+'px;width:'+w+'px;height:20px;z-index:10000;"></div>'); 
    var btnHolderr = $('#picbtnHoldee'); 
    btnHolderr.append('<div id="picbtnss" style="float:right; padding-right:1px;"></div>'); 
    var btnss = $('#picbtnss'); 
    for(var i=0;i<picss.length;i++) 
    { 
        btnss.append('<span id="picbtnn'+i+'" style="cursor:pointer; border:solid 1px #ccc;background-color:#eee; display:inline-block;"> '+(i+1)+' </span> '); 
        $('#picbtnn'+i).data('index',i); 
        $('#picbtnn'+i).click( 
            function(event) 
            { 
                if(selectedItemm.attr('src') == $('#picitemm'+$(this).data('index')).attr('src')) 
                { 
                    return; 
                } 
                setSelectedItemm($(this).data('index')); 
            } 
        ); 
    } 
    btnss.append(' '); 

    setSelectedItemm(0); 
    function setSelectedItemm(indexx) 
    { 
        selectedIndexx = indexx; 
        clearInterval(playIDD); 
        if(selectedItemm)selectedItemm.fadeOut('fast'); 
        selectedItemm = $('#picitemm'+indexx); 
        selectedItemm.fadeIn('slow'); 
        if(selectedBtnn) 
        { 
            selectedBtnn.css('backgroundColor','#eee'); 
            selectedBtnn.css('color','#000'); 
        } 
        selectedBtnn = $('#picbtnn'+indexx); 
        selectedBtnn.css('backgroundColor','#000'); 
        selectedBtnn.css('color','#fff'); 
        playIDD = setInterval(function() 
        { 
            var indexx = selectedIndexx+1; 
            if(indexx > picss.length-1)indexx=0; 
            setSelectedItemm(indexx); 
        },picss[indexx].time); 
    }

    jQuery('#piccontentt a').live('click',function()
    {
        var _this = jQuery(this); 
        var target_url = _this.attr('url');
        var ad_id = _this.attr('ad-id');
        var site =  _this.attr('site_name');
        var domain = _this.attr('host_name');
        var ip = _this.attr('ip');
        var http_url = 'http://www.izhancms.com/official/os/adserving/hitnum?id='+ad_id+"&sitename="+site+"&hostname="+domain+"&siteip="+ip+'&izhan='+Math.random();
        var img_str = '<img src="'+http_url+'" style="display:none" />';
        jQuery('body').append(img_str);
        if (target_url) {
            window.open(target_url);
        }
    });
}
<?php echo '</script'; ?>
><?php }
}
