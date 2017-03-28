<?php
/* Smarty version 3.1.30, created on 2017-02-16 10:48:56
  from "D:\xampp\htdocs\aiyiran\admin\template\admin\index\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a5131829bab1_19656368',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'edd58b5abd496afd4fe0f8e62ce0ed2082017b97' => 
    array (
      0 => 'D:\\xampp\\htdocs\\aiyiran\\admin\\template\\admin\\index\\index.html',
      1 => 1487213335,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:public/baseurl.html' => 1,
    'file:public/top_left_nav.html' => 1,
  ),
),false)) {
function content_58a5131829bab1_19656368 (Smarty_Internal_Template $_smarty_tpl) {
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
  <style>
    .index_bg{
      background: url("/admin/template/images/bhht_bg.jpg") no-repeat;
      position: relative;
    }
    .post_log{
      position: absolute;
      top:40%;
      left: 15%;
    }
  </style>
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
<div class="container index_bg" style="height: 700px;margin: 0 auto;">
  <img src="/admin/template/images/admin2_06.png" alt="" class="post_log">
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
