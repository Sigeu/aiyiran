<?php if(!defined('IN_MAINONE')) exit(); ?>

		<link rel="stylesheet" type="text/css" href="/template/default/member/css/Basc.css"/>
		<link rel="stylesheet" type="text/css" href="/template/default/member/css/account_yc.css"/>
		<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
        <?php include Template::t_include('member/head_top.html');?>
        <div class="wrapW">
        <?php include Template::t_include('member/user_view/user_inc.html');?>
			
			<div class="conRig_yc">
				<h3 class="dwH3_yc">安全设置</h3>
				<dl class="accoDl_yc">
					<dd>上次登录：<em><?php echo Template::addquote($result['createip']);?></em></dd>
					<dd class="clearfix">
						<span class="fl">账号安全系数：<em><?php echo $ss;?></em></span>
						<div class="fl proBox_yc">
							<div class="proccess" style="width: <?php echo $ss;?>%;"></div>
						</div>
					</dd>
				</dl>
				<ul class="accoUl_yc">
					<li>
						<div class="liDC_yc">
							<div class="accItem01">
								<i class="iconI01_yc"></i><span>修改密码</span>
							</div>
							<div class="accItem02">&nbsp;</div>
							<div class="accItem03">
								<a href="javascript:;" class="accAc">修改密码</a>
							</div>
							<div class="accItem04">
								<em class="emSel_yc"></em>
							</div>
						</div>
						<div class="mainBox_yc">
							<div class="passD">
								<span class="passSa"><i>*</i>当前密码：</span><input name="password" type="password" class="passInp"><a href="javascript:;" class="forgetA">忘记密码？</a>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>新密码：</span><input type="password" name="newpassword" class="passInp"><strong class="passStr">密码由6-16个字符组成，包含字母、数字、符号，区分大小写</strong>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>确认密码：</span><input type="password" name="newpassword_confirm" class="passInp">
							</div>
							<div class="passXG">
								<a href="javascript:;" class="success_yc" id="modPass">修改密码</a>
							</div>
						</div>
					</li>

					<!-- 已绑定手机 -->
					<?php if($is_phone) { ?>
					<li>
						<div class="liDC_yc">
							<div class="accItem01">
								<i class="iconI01_yc"></i>
								<span>绑定手机</span>
							</div>
							<div class="accItem02">
								<strong><?php echo Template::addquote($result['username']);?> 可直接使用该手机号码登录</strong>
							</div>
							<div class="accItem03">
								<a href="javascript:;" class="accAc">解除绑定</a>
							</div>
							<div class="accItem04">
								<em class="emSel_yc"></em>
							</div>
						</div>
						<div class="mainBox_yc">
							<div class="passD">
								<span class="passSa"><i>*</i>输入手机号：</span><input name="mobile" type="text" value="<?php echo Template::addquote($result['username']);?>" disabled='disabled' class="passInp"><a href="javascript:;" class="yzm_yc" id="getMobileCode2">获取验证码</a>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>输入短信验证码：</span><input type="text" name="dx_code" class="passInp">
							</div>
							<div class="passXG">
								<input type="hidden" name="bind" value="2">
								<a href="javascript:;" class="success_yc" id="modMobile2">解除绑定</a>
							</div>
						</div>
					</li>
					<!-- 未绑定手机 -->
					<?php } else { ?>
					<li>
						<div class="liDC_yc">
							<div class="accItem01">
								<i class="iconI02_yc"></i>
								<span>绑定手机</span>
							</div>
							<div class="accItem02">
								<strong>没有绑定手机，前去绑定</strong>
							</div>
							<div class="accItem03">
								<a href="javascript:;" class="accAc">绑定</a>
							</div>
							<div class="accItem04">
								<em class="emSel_yc"></em>
							</div>
						</div>
						<div class="mainBox_yc">
							<div class="passD">
								<span class="passSa"><i>*</i>输入手机号：</span><input name="mobile" type="text" class="passInp"><a href="javascript:;" class="yzm_yc" id="getMobileCode">获取验证码</a>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>输入短信验证码：</span><input type="text" name="dx_code" class="passInp">
							</div>
							<div class="passXG">
								<a href="javascript:;" class="success_yc" id="modMobile">绑定</a>
							</div>
						</div>
					</li>
					<?php } ?>

					<!-- 已绑定邮箱 -->
					<?php if($is_email) { ?>
					<li>
						<div class="liDC_yc">
							<div class="accItem01">
								<i class="iconI01_yc"></i><span>绑定邮箱</span>
							</div>
							<div class="accItem02">
								<strong>已绑定 <?php echo Template::addquote($result['email']);?> 邮箱</strong>
							</div>
							<div class="accItem03">
								<a href="javascript:;" class="accAc">解除绑定</a>
							</div>
							<div class="accItem04">
								<em class="emSel_yc"></em>
							</div>
						</div>
						<div class="mainBox_yc">
							<div class="passD">
								<span class="passSa"><i>*</i>输入邮箱地址：</span><input type="text" name="email" disabled="disabled" value="<?php echo Template::addquote($result['email']);?>" class="passInp"><a href="javascript:;" class="yzm_yc" id="getEmailCodeBtn">获取验证码</a>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>输入邮箱验证码：</span><input type="text" name="yx_code" class="passInp">
							</div>
							<div class="passXG">
								<a href="javascript:;" class="success_yc" id="clearEmail">解除绑定</a>
							</div>
						</div>
					</li>
					<?php } else { ?>
					<!-- 未绑定邮箱 -->
					<li>
						<div class="liDC_yc">
							<div class="accItem01">
								<i class="iconI02_yc"></i><span>绑定邮箱</span>
							</div>
							<div class="accItem02">
								<strong>没有绑定邮箱，前去绑定</strong>
							</div>
							<div class="accItem03">
								<a href="javascript:;" class="accAc">绑定</a>
							</div>
							<div class="accItem04">
								<em class="emSel_yc"></em>
							</div>
						</div>
						<div class="mainBox_yc">
							<div class="passD">
								<span class="passSa"><i>*</i>输入邮箱地址：</span><input type="text" name="email" class="passInp"><a href="javascript:;" class="yzm_yc" id="bildEmail">获取验证码</a>
							</div>
							<div class="passD">
								<span class="passSa"><i>*</i>输入邮箱验证码：</span><input type="text" name="yx_code" class="passInp">
							</div>
							<div class="passXG">
								<a href="javascript:;" class="success_yc" id="clearEmail2">绑定</a>
							</div>
						</div>
					</li>
					<?php } ?>

                    <!-- 是否实名认证 -->
                    <?php if($is_real) { ?>
    					<li>
    						<div class="liDC_yc">
    							<div class="accItem01">
    								<i class="iconI01_yc"></i><span>实名认证</span>
    							</div>
    							<div class="accItem02">
    								<strong>已进行实名认证</strong>
    							</div>
    							<div class="accItem03">
    								<a href="javascript:;" class="accAc">
                                    <?php if($is_real['status']==1) { ?>
                                    已通过
                                    {else if $is_real['status']==2}
                                    未通过
                                    <?php } else { ?>
                                    待审核
                                    <?php } ?>
                                    </a>
    							</div>
    							<div class="accItem04">
    								<em class="emSel_yc"></em>
    							</div>
    						</div>
    						<div class="mainBox_yc">
    							<div class="passD">
    								<span class="passSa"><i>*</i>证件类型：</span><select name="" class="zjSel">
                                        <option value="军官证" <?php if($is_real['real_type']=='军官证') { ?>selected=''<?php } ?>
                                        >军官证</option>
    									<option value="身份证" <?php if($is_real['real_type']=='身份证') { ?>selected=''<?php } ?>
                                        >身份证</option>
    								</select>
    							</div>
    							<div class="passD">
    								<span class="passSa"><i>*</i>证件号码：</span><input type="text" value="<?php echo Template::addquote($is_real['id_card']);?>" disabled="disabled" class="passInp">
    							</div>
    							<div class="passD">
    								<span class="passSa"><i>*</i>真实姓名：</span><input type="text" value="<?php echo Template::addquote($is_real['name']);?>" disabled="disabled" class="passInp">
    							</div>
    							<div class="passD">
    								<span class="passSa"><i>*</i>证件正面：</span><img src="<?php echo Template::addquote($is_real['face']);?>" alt="" width="100" height="100">
    							</div>
    							<div class="passD">
    								<span class="passSa"><i>*</i>证件反面：</span><img src="<?php echo Template::addquote($is_real['side']);?>" alt="" width="100" height="100">
    							</div>
    							<!-- <div class="passXG">
    								<a href="javascript:;" class="success_yc">提交</a>
    							</div> -->
    						</div>
    					</li>
                    <?php } else { ?>
                        <li>
                        <form id="form1" method="post" enctype="multipart/form-data">
                            <div class="liDC_yc">
                                <div class="accItem01">
                                    <i class="iconI02_yc"></i><span>实名认证</span>
                                </div>
                                <div class="accItem02">
                                    <strong>没有实名认证，前去认证</strong>
                                </div>
                                <div class="accItem03">
                                    <a href="javascript:;" class="accAc">立即认证</a>
                                </div>
                                <div class="accItem04">
                                    <em class="emSel_yc"></em>
                                </div>
                            </div>
                            <div class="mainBox_yc">
                                <div class="passD">
                                    <span class="passSa"><i>*</i>证件类型：</span><select name="real_type" class="zjSel">
                                        <option value="身份证">身份证</option>
                                        <option value="军官证">军官证</option>
                                    </select>
                                </div>
                                <div class="passD">
                                    <span class="passSa"><i>*</i>证件号码：</span><input type="text" class="passInp" name="id_card">
                                </div>
                                <div class="passD">
                                    <span class="passSa"><i>*</i>真实姓名：</span><input type="text" class="passInp" name="name">
                                </div>
                                <div class="passD">
                                    <span class="passSa"><i>*</i>证件正面：</span><input type="text" placeholder="选择附件" class="passInp" ><a href="javascript:;" class="fileA"><input type="file" class="scInp" name="face">上传</a>
                                </div>
                                <div class="passD">
                                    <span class="passSa"><i>*</i>证件反面：</span><input type="text" placeholder="选择附件" class="passInp" ><a href="javascript:;" class="fileA"><input type="file" class="scInp" name="side">上传</a>
                                </div>
                                <div class="passXG">
                                    <a href="javascript:;" class="success_yc" id="realName">提交</a>
                                </div>
                            </div>
                            </form>
                        </li>
                    <?php } ?>
                    
                    <!-- 是否设置密保 -->
                    <?php if($is_quester) { ?>
                        <li>
                            <form id="form3" method="post" enctype="multipart/form-data">
                            <div class="liDC_yc">
                                <div class="accItem01">
                                    <i class="iconI01_yc"></i><span>安全问题</span>
                                </div>
                                <div class="accItem02">
                                    <strong>已设置安全问题</strong>
                                </div>
                                <div class="accItem03">
                                    <a href="javascript:;" class="accAc">修改</a>
                                </div>
                                <div class="accItem04">
                                    <em class="emSel_yc"></em>
                                </div>
                            </div>
                            <div class="mainBox_yc">
                                <div class="passD">
                                    <span class="passSa">问题一：</span><select name="quester1" class="zjSel">
                                        <?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
                                        <option value="<?php echo Template::addquote($v['id']);?>" <?php if($v['id']==$is_quester['quester1']) { ?>selected=''<?php } ?>
                                        ><?php echo Template::addquote($v['quester']);?></option>
                                        <?php $n++;} ?>
                                    </select><input type="text" name="answer1" value="<?php echo Template::addquote($is_quester['answer1']);?>" placeholder="问题答案" class="passInp passInp2">
                                </div>
                                <div class="passD">
                                    <span class="passSa">问题二：</span><select name="quester2" class="zjSel">
                                        <?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
                                        <option value="<?php echo Template::addquote($v['id']);?>" <?php if($v['id']==$is_quester['quester2']) { ?>selected=''<?php } ?>
                                        ><?php echo Template::addquote($v['quester']);?></option>
                                        <?php $n++;} ?>
                                    </select><input type="text" name="answer2" value="<?php echo Template::addquote($is_quester['answer2']);?>" placeholder="问题答案" class="passInp passInp2">
                                </div>
                                <div class="passD">
                                    <span class="passSa">问题三：</span><select name="quester3" class="zjSel">
                                        <?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
                                        <option value="<?php echo Template::addquote($v['id']);?>"  <?php if($v['id']==$is_quester['quester3']) { ?>selected=''<?php } ?>
                                        ><?php echo Template::addquote($v['quester']);?></option>
                                        <?php $n++;} ?>
                                    </select><input type="text" value="<?php echo Template::addquote($is_quester['answer3']);?>" name="answer3" placeholder="问题答案" class="passInp passInp2">
                                </div>
                                <div class="passXG">
                                    <a href="javascript:;" class="success_yc" id="modQuester">修改</a>
                                </div>
                            </div>
                            </form>
                        </li>
                    <?php } else { ?>
    					<li>
                            <form id="form2" method="post" enctype="multipart/form-data">
    						<div class="liDC_yc">
    							<div class="accItem01">
    								<i class="iconI02_yc"></i><span>安全问题</span>
    							</div>
    							<div class="accItem02">
    								<strong>未设置安全问题</strong>
    							</div>
    							<div class="accItem03">
    								<a href="javascript:;" class="accAc">设置</a>
    							</div>
    							<div class="accItem04">
    								<em class="emSel_yc"></em>
    							</div>
    						</div>
    						<div class="mainBox_yc">
    							<div class="passD">
    								<span class="passSa">问题一：</span><select name="quester1" class="zjSel">
                                        <?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
    									<option value="<?php echo Template::addquote($v['id']);?>"><?php echo Template::addquote($v['quester']);?></option>
    								    <?php $n++;} ?>
    								</select><input type="text" name="answer1" placeholder="问题答案" class="passInp passInp2">
    							</div>
    							<div class="passD">
    								<span class="passSa">问题二：</span><select name="quester2" class="zjSel">
    									<?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
                                        <option value="<?php echo Template::addquote($v['id']);?>" <?php if($k==4) { ?>selected=''<?php } ?>
                                        ><?php echo Template::addquote($v['quester']);?></option>
                                        <?php $n++;} ?>
    								</select><input type="text" name="answer2" placeholder="问题答案" class="passInp passInp2">
    							</div>
    							<div class="passD">
    								<span class="passSa">问题三：</span><select name="quester3" class="zjSel">
    									<?php $n=1;foreach($quester_lists AS $k => $v) { $lastIndex= count($quester_lists) == $n;?>
                                        <option value="<?php echo Template::addquote($v['id']);?>"  <?php if($k==7) { ?>selected=''<?php } ?>
                                        ><?php echo Template::addquote($v['quester']);?></option>
                                        <?php $n++;} ?>
    								</select><input type="text" name="answer3" placeholder="问题答案" class="passInp passInp2">
    							</div>
    							<div class="passXG">
    								<a href="javascript:;" class="success_yc" id="setQuester">提交</a>
    							</div>
    						</div>
                            </form>
    					</li>
                    <?php } ?>
				</ul>
			</div>
		</div>
		<div class="wrapS03_yc jbFT_yc">
			<p>Copyright &copy; <em>2015 - 2016</em> love still All Rights Reserved</p>
		</div>
	</body>
	<script type="text/javascript" src="/template/default/member/js/jquery-1.11.0.min.js" ></script>
<script type="text/javascript" src="/template/default/member/js/jquery.form.js" ></script>

	<script type="text/javascript" src="/template/default/member/js/html5shiv.js" ></script>
	<script type="text/javascript" src="/template/default/member/js/common.js" ></script>
	<script type="text/javascript">
		$(function(){
			$(".emSel_yc,.accAc").click(function(){
				var $parL=$(this).parents(".liDC_yc");
				var $parM=$(this).parents(".liDC_yc").siblings(".mainBox_yc");
				var $parMD=$parM.css("display");
				$(".liDC_yc").removeClass("active");
				$parL.addClass("active");
				$(".mainBox_yc").stop().slideUp();
				$parM.stop().slideDown();
				if($parMD=="none"){
					$parM.stop().slideDown();
					$parL.addClass("active");
				}else{
					$parM.stop().slideUp();
					$parL.removeClass("active");
				}
			});
		});
	</script>


<script type="text/javascript">
	$(function(){
		//修改密码
		$("#modPass").click(function(){
			var password = $("input[name='password']").val();
			var newpassword = $("input[name='newpassword']").val();
			var newpassword_confirm = $("input[name='newpassword_confirm']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/modPass",
                data: {'password':password, 'newpassword':newpassword, 'newpassword_confirm':newpassword_confirm},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

		//获取验证码 1
		$("#getMobileCode").click(function(){
			var mobile = $("input[name='mobile']").val();
			var dx_code = $("input[name='dx_code']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/getPhoneCode",
                data: {'mobile':mobile, 'dx_code':dx_code},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

		//提交手机验证码验证 2
		$("#modMobile").click(function(){
			var mobile = $("input[name='mobile']").val();
			var dx_code = $("input[name='dx_code']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/checkMobile",
                data: {'mobile':mobile, 'dx_code':dx_code},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});


		//获取验证码解除绑定 1
		$("#getMobileCode2").click(function(){
			var mobile = $("input[name='mobile']").val();
			var dx_code = $("input[name='dx_code']").val();
			var bind = $("input[name='bind']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/getPhoneCode2",
                data: {'mobile':mobile, 'dx_code':dx_code, 'bind':bind},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

		//提交手机验证码验证解除绑定 2
		$("#modMobile2").click(function(){
			var mobile = $("input[name='mobile']").val();
			var dx_code = $("input[name='dx_code']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/checkMobile2",
                data: {'mobile':mobile, 'dx_code':dx_code},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        var index = layer.alert(data.msg, {icon: 1,offset: '40%',
                            yes: function(index, layero){
                       			 location.reload();
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                        });
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});
		//====================================邮箱解绑==========================================================

		//发送解绑邮件
		$("#getEmailCodeBtn").click(function(){
			var email = $("input[name='email']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/sendEmailCode",
                data: {'email':email},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});


		//解除邮件绑定
		$("#clearEmail").click(function(){
			var email = $("input[name='email']").val();
			var yx_code = $("input[name='yx_code']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/clearEmail",
                data: {'email':email, 'yx_code':yx_code},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                        location.reload();
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

		/************************************* 邮箱绑定开始 ***********************************/
		//发送绑定邮件
		$("#bildEmail").click(function(){
			var email = $("input[name='email']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/bildEmail",
                data: {'email':email},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.msg(data.msg);
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

		//邮件验证码绑定
		$("#clearEmail2").click(function(){
			var email = $("input[name='email']").val();
			var yx_code = $("input[name='yx_code']").val();
			 $.ajax({
                type: "Post",
                url: "/member/User/clearEmail2",
                data: {'email':email, 'yx_code':yx_code},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        layer.alert(data.msg, {icon: 1});
                        location.reload();
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
		});

        /************************************* 邮箱绑定结束 ***********************************/

        /************************************* 实名认证开始 ***********************************/
        $("#realName").click(function(){
            var real_type = $("select[name='real_type']  option:selected").text();
            var id_card = $("input[name='id_card']").val();
            var name = $("input[name='name']").val();
            var face = $("input[name='face']").val();
            var side = $("input[name='side']").val();
            $("#form1").ajaxSubmit({
                type: "Post",
                url: "/member/User/realName",
                data: {'real_type':real_type, 'id_card':id_card, 'name':name, 'face':face, 'side':side},
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                         var index = layer.alert(data.message, {icon: 1,offset: '40%',
                            yes: function(index, layero){
                                window.location.href='/member/User/safe/';
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                        });
                    } else {
                        layer.msg(data.message);
                        return false;
                    }
                }
            });
        });
		/************************************* 实名认证结束 ***********************************/

        /************************************* 设置安全问题开始 ***********************************/
        $("#setQuester").click(function(){
            $("#form2").ajaxSubmit({
                type: "Post",
                url: "/member/User/setQuester",
                data: $("form2").serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                         var index = layer.alert(data.msg, {icon: 1,offset: '40%',
                            yes: function(index, layero){
                                window.location.href='/member/User/safe/';
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                        });
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
        });

        //修改安全问题
        $("#modQuester").click(function(){
            $("#form3").ajaxSubmit({
                type: "Post",
                url: "/member/User/modQuester",
                data: $("form3").serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                         var index = layer.alert(data.msg, {icon: 1,offset: '40%',
                            yes: function(index, layero){
                                window.location.href='/member/User/safe/';
                                layer.close(index); //如果设定了yes回调，需进行手工关闭
                            }
                        });
                    } else {
                        layer.msg(data.msg);
                        return false;
                    }
                }
            });
        });

        /************************************* 设置安全问题结束 ***********************************/

		
	});
</script>
</html>
