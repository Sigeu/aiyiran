<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 文件用途说明
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 *
 * 文件修改记录：
 * <br>申静  2013-2-17 上午10:44:07 创建此文件
 *
 * @author     申静<shenjing@mainone.cn>  2013-2-17 上午10:44:07

 * @filename   MessageForm.php  UTF-8
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: MessageForm.php 987 2013-12-02 06:24:40Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      1.0.0
 */
class MessageForm {
	var $modelid;
	var $fields;
	var $formValidator;

	function __construct($modelid) {
	   $this->modelid = $modelid;
	   $modelid = $modelid ? $modelid : 1;
	   $options['where'] =array('modelid'=>$this->modelid,'state'=>1);
	   $options['order'] = 'sort asc';
	   $this->fields = M('attribute')->select($options);

	}
	/**
	 * @param int $flag 区分是会员表单还是留言板表单
	 * @param int $modelid 表单id
	 * @param array $data  修改的时候所用到的默认值
	 */
	public function get($flag,$modelid,$data=array())
	{
		$num = 0;
		$info = array();//声明数组
		//根据分类调取不同默认项
		if($flag == 1){
			$conObj = M("WebConfig");
			$config = $conObj->where(array('group_id'=>10,'par_name'=>'mo_word_num'))->getOne();//留言信息最多字数
			$num = $config['par_value'];
			//$info = $this->messageBase($modelid);
		}else if($flag ==2){

			$info = $this->memberBase($modelid,$data);//调取会员表单的默认项
		}

		foreach($this->fields as $k=>$v) {
			$function = $v['fieldtype'];
			if(!method_exists($this, $function)) continue;
			$value = isset($data[$v['dataname']]) ? htmlspecialchars($data[$v['dataname']], ENT_QUOTES) : '';
			if( $flag ==1) {

				$v['fieldtype'] = 'textarea';
				$form = $this->$function($v,$value,$num);
			}else{

			    $form = $this->$function($v,$value);
			}
			if($form !== false) {
				$info[] = $form;
			}
		}
		return $info;
	}
	/**
	 *分类为表单分类时表单中默认存在用户名，密码，确认密码
	 */
	public function memberBase($modelid,$value)
	{
		if(empty($value)) {

			$value = array(
					  'username' =>'',
					  'password' =>'',
					   'email'   =>'',
					);
		}
        $url = "";
        $info = "";
		$this->getFormValidator('用户名',"请输入4-20位字符，由英文、数字、符号组成",'^[A-Za-z0-9-_]+$',4,20,1,1,1,$modelid,'text','',"请输入4-20位字符，由英文、数字、符号组成",'username',"admin/members/checkregist/checkname?username=\"+$('#username').val()","用户名被禁用或已存在");
		$font = '<font>*</font>';
		$base[0] = '<tr><th width="15%">'.$font .'用户名'.'：</th>
		<td colspan="3"><input type="text" name="info[username]" value="'.$value['username'].'" id="username" class="Iw290"/>
		</td></tr>';
		$this->getFormValidator('密码','请输入4-20位字符，由字母、数字、符号组成','',4,20,2,1,1,$modelid,'password','','请输入4-20位字符，由字母、数字、符号组成','password');
		$base[1] = '<tr><th width="145px"><font>*</font>密码'.'：</th>
		<td colspan="3"><input type="password" name="info[password]" value="'.$value['password'].'" id="password" class="Iw290"/>
		</td></tr>';
		$this->formValidator .= '$("#conform_pwd").formValidator({onshow:"请输入4-20位字符，由字母、数字、符号组成",onfocus:"请输入4-20位字符，由字母、数字、符号组成",oncorrect:"密码一致"}).inputValidator({min:4,max:20,onerror:"重复密码不能为空,请确认"}).compareValidator({desid:"password",operateor:"=",onerror:"重复密码不一致,请确认"})';
		$this->formValidator .= $value['password'] ? ".defaultPassed();" :';';
		$base[2] = '<tr><th width="145px"><font>*</font>确认密码'.'：</th>
		<td colspan="3"><input type="password" name="info[conform_pwd]" value="'.$value['password'].'" id="conform_pwd" class="Iw290"/>
		</td></tr>';
		$this->getFormValidator('电子邮箱','请输入邮箱地址,由@,点号组成','^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$',6,100,1,1,2,$modelid,'text','','请输入正确的邮箱，例：example@example.com','email',"admin/members/checkregist/checkemail?email=\"+$('#email').val()","邮箱被禁用或已使用");
		$base[3] = '<tr><th width="145px"><font>*</font>电子邮箱'.'：</th>
		<td colspan="3"><input type="text" name="info[email]" value="'.$value['email'].'" id="email" class="Iw290"/>
		</td></tr>';
		return $base;
	}
	/**
	 * 分类为留言板分类时表单中默认存在标题，留言人
	 */
	public function messageBase($modelid,$value)
	{

		$this->getFormValidator('标题','请输入1-100个字符','',1,100,2,1,1,$modelid,'text','','请输入1-100个字符','title');
		$font = '<font>*</font>';
		$base[0] = '<tr><th width="145px">'.$font .'标题'.'：</th>
		<td colspan="3"><input type="text" name="info[title]" value="" id="title" class="Iw290"/>
		</td></tr>';
		$this->getFormValidator('提交人','请输入1-15个字符','','',15,2,2,1,$modelid,'text','','请输入提交人','username');
		$base[1] = '<tr><th width="145px">提交人'.'：</th>
		<td colspan="3"><input type="text" name="info[username]" value="" id="username" class="Iw290"/>
		</td></tr>';
		return $base;
	}
	/**
	 * 单文本文框
	 * @param array $fieldinfo  字段信息
	 */
	public function text($fieldinfo,$value)
	{

		extract($fieldinfo);
		$value = $value ? $value : $defaultvalue;
		if($regex||$errortips||$uniqueness||$isnessary||$minval||$maxval)
		{
			$this->getFormValidator($name,$errortips,$regex,$minval,$maxval,$uniqueness,$isnessary,$ismain,$modelid,'text',$value,$fieldtips,$dataname);
		}
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$dataname.']" value="'.$value.'" id="'.$dataname.'" class="Iw290"/>
		</td></tr>';
	}

	/**
	 * 多行文本
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function textarea($fieldinfo,$value,$num=0)
	{
		extract($fieldinfo);
		$value = $value ? $value : $defaultvalue;
		$maxval = $num ? $num : $maxval;
		if($errortips||$minval||$maxval||$isnessary==1||$num)
		{
			$isunique = 2;
			$this->getFormValidator($name,$errortips,$regex,$minval,$maxval,2,$isnessary,$ismain,$modelid,'textarea',$value,$fieldtips,$dataname);
		}
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		$stat = $isnessary == 1 ? $dataname : '';
		return '<tr><th valign="top">'.$font. $name.'：</th><td colspan="3"><textarea class="Iw450 Ih80" name="info['.$dataname.']" id="'.$stat.'">'.$value.'</textarea></td></tr>';
	}

	/**
	 * HTML文本（编辑器）
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function editor($fieldinfo,$value)
	{
		extract($fieldinfo);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		$value = $value ? $value : $defaultvalue;
		if($errortips||$minval||$maxval||$isnessary==1)
		{
			$this->getFormValidator($name,$errortips,$regex,$minval,$maxval,2,$isnessary,$ismain,$modelid,'editor',$value,$fieldtips,$dataname);
		}
		$str = '<tr>
                  <th>'.$font.$name.'</th>
                  <td colspan="2"><div class="edit_box" style="height:auto"><textarea name="info['.$dataname.']" id="'.$dataname.'">'.$value.'</textarea></div></td>
                </tr>';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/ckeditor/ckeditor.js"></script>';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/FrontIniEditor.js"></script>';
		$str.= '<script>document.ready=init("'.$dataname.'","fail");</script>';
		return $str;
	}
	/**
	 * 单图片
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function image($fieldinfo,$value=array())
	{
		if($value) $value =  object_to_array(json_decode(htmlspecialchars_decode($value)));
		extract($fieldinfo);
		$src		= isset($value['src']) ? $value['src'] : '';
		$savename	= isset($value['savename']) ? $value['savename'] : '';
		$size		= isset($value['size']) ? $value['size'] : '';
		$water_mark = isset($value['water_mark']) ? $value['water_mark'] : '';
		$filename	= isset($value['filename']) ? $value['filename'] : '';
		$font		= $isnessary == 1 ? '<font>*</font>' : '&nbsp;';

		/*if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',1,999,$isnull,2,$ismain,$modelid,'image',$name);
		}*/
		
		$allowtype = get_mo_config('mo_picturetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		if($src)
		{
			//修改的时候老文件信息
			$oldfile='<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$dataname.'][1][oldfile]" />
			<div style="margin-bottom:10px" class="dis-btn-1 mo_div_'.$dataname.'">
			<input type="hidden" value="'.$size.'" class="Iw290"  name="info['.$dataname.'][1][size]" />
			<input type="hidden" value="'.$filename.'" class="Iw290"  name="info['.$dataname.'][1][filename]" />
			<input type="hidden" value="'.$src.'" class="Iw290"   name="info['.$dataname.'][1][src]" />
			<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$dataname.'][1][path]" />
			<input type="hidden" value="'.$savename.'" class="Iw290"  name="info['.$dataname.'][1][selfname]" /></div>';
			$isupdate = true;
			//如果是修改的话自动验证
		    $str.='<script>$(document).ready(function(){$("#'.$dataname.'").focus().blur();</script>';
		}
		//上传部分代码
		$setting = array
		(
			'limit'       =>  2,
			'size'       =>  intval(ini_get('upload_max_filesize'))*1024*1024,
			'type'        =>  explode('|',$allowtype),
			'local'		  => true,			  //是否显示本地图库
			'folder'      => true,             //是否显示目录浏览
			'iswatermark' => true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		//图片上传信息隐藏域
		$str = '<tr><th>'.$font.$name.'：</th><td>'.$oldfile.'<span id=\''.$dataname.'single-upload'.'\'></span>';

		//图片显示
		$str.='<input type="text" readonly  value="'.$savename.'" class="Iw290" id="'.$dataname.'_show" name="info['.$dataname.'][show]"/>&nbsp;&nbsp;';

		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏览上传" class="btn5" onclick="'.$dataname.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$dataname.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$dataname.'single-upload\',\'check_id\':\''.$dataname.'\',\'show_id\':\''.$dataname.'_show\'})" id="'.$dataname.'_uploadButton"><input type="hidden" id="'.$dataname.'" value="'.$isupdate.'" _required='.$isnessary.' />&nbsp;&nbsp;&nbsp;<input  type="button" hidefocus="hide" value="删除" class="btn5"  onclick="'.$dataname.'deleteUpload()"/> </td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$dataname.'uploadAccessory (obj){var option={upload_id:\''.$dataname.'\',title:\'图片上传\',return_id:\'info['.$dataname.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}</script>';

		//删除
		$str.='<script>function '.$dataname.'deleteUpload (){
		var obj = {\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$dataname.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$dataname.'single-upload\',\'check_id\':\''.$dataname.'\',\'show_id\':\''.$dataname.'_show\'};
		var option={upload_id:\''.$dataname.'\',title:\'图片上传\',return_id:\'info['.$dataname.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj,autoStart: false};
		deleteUpload("dis-btn-1","mo_div_'.$dataname.'",option);}</script>';
		return $str;
	}


	/**
	 * 多图上传
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */

	public function images($fieldinfo,$value)
	{
		global $k;
		extract($fieldinfo);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		if($fieldtips||$errortips||$isnessary==1||$regex||$maxval||$minval)
		{
			$this->getFormValidator($name,$errortips,'',0,999,2,$isnessary,$ismain,$modelid,'image','',$fieldtips,$dataname.'_filename');
		}
		$allowtype = get_mo_config('mo_picturetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		$setting = array
		(
			'size'       =>  ini_get('upload_max_filesize')*1024*1024,
			'limit'       =>  $maxval ? $maxval : 20, //默认最大上传10张图片
			'type'        =>  explode('|',$allowtype),
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$str = '<tr><th>'.$font.$name.'：</th><td>';
		$ady_upload =0; //已经上传的图片个数
		$isupdate = '';
		if($value)
		{
			$arr = json_decode(htmlspecialchars_decode($value),true);//第二个参数必须为true，因为php无法区分二维数组 强制转为数组
			$k=$maxlength;
			$ady_upload =count($arr);
			foreach($arr as $key => $value)
			{
				//老图片，点删除按钮不跟着删除
				$str.='<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][oldfile]"/>';

				$str.='<div style="margin-bottom:10px" class="dis-btn-'.$k.' mo_div_'.$dataname.'">';
				//老图片，点删除按钮跟着删除
				$str.='<input type="hidden" value="'.$value['size'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][size]"/>
				<input type="hidden" value="'.$value['filename'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][filename]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"   name="info['.$dataname.']['.$k.'][src]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][path]"/>
				<input type="hidden" value="'.$value['savename'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][selfname]"/>';

				$str.='<input type="text" value="'.$value['savename'].'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;'; //用来显示

				$str.='<input type="button" class="btn5" value="删除" onclick=\'deleteUpload("dis-btn-'.$k.'","mo_div_'.$dataname.'")\' />'; //删除按钮

				$str.='</div>';
				$k--;
				$isupdate.='*'; //用来验证上传图片的个数
			}
			$str.='<script>$(document).ready(function(){$("#'.$dataname.'").focus().blur();</script>';
		}
		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏 览" class="btn5" onclick="'.$dataname.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'uploadImages\',\'self_id\':\''.$dataname.'_uploadButton\',\'check_id\':\''.$dataname.'\'})" id="'.$dataname.'_uploadButton" limit="'.$setting['limit'].'" /><input type="hidden" id="'.$dataname.'" value="'.$isupdate.'" _required='.$maxval.' /></td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$dataname.'uploadAccessory (obj){var option={upload_id:\''.$dataname.'\',title:\'多图上传\',return_id:\'info['.$dataname.']\',callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}getAlreadyUploadNUm();</script>';

		return $str;
	}
	/**
	 * 多选框
	 * @param array $fieldinfo  字段信息
	 */
    public function checkbox($fieldinfo,$value)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';',$defaultvalue);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		if($fieldtips||$errortips||$isnessary==1||$regex||$maxval||$minval)
		{
			$this->getFormValidator($name,$errortips,'',1,999,2,$isnessary,$ismain,$modelid,'checkbox','',$fieldtips,$dataname);
		}
		$str = '<tr><th>'.$font.$name.'：</th><td colspan=2>';
		$checkstr = '';
		foreach($defaultvalue as $k => $v)
		{
			if($value)
			{
				$arr = explode(';', $value);
				$checkstr =  in_array($v,$arr) ? 'checked="checked"' : '';
			}
			$br = ($k+1)%5==0 ? "<br>" : '';
			$str.='<input id="'.$dataname.$k.'" type="checkbox" name="info['.$dataname.'][]" '.$checkstr.' value="'.$v.'" />'.$v.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$br;
		}
		$str.='<span id="'.$dataname.'_tips"></span></td></tr>';
		return $str;
	 }

	/**
	 * 多附件
	 * @param array $fieldinfo  字段信息
	 */
	public function files($fieldinfo,$value)
	{
		extract($fieldinfo);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		 if($fieldtips||$errortips||$isnessary==1||$regex)
		{
			$this->getFormValidator($name,$errortips,'',0,999,2,$isnessary,$ismain,$modelid,'files','',$fieldtips,$dataname);
		}
		$allowtype = get_mo_config('mo_filetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		$setting = array
		(
			'size'       =>  ini_get('upload_max_filesize')*1024*1024,
			'limit'       =>  $maxval ? $maxval : 20, //默认最大上传10张图片
			'type'        =>  explode('|',$allowtype),
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$str = '<tr><th>'.$font.$name.'：</th><td>';
		$ady_upload =0; //已经上传的图片个数
		$isupdate = '';
		if($value)
		{
			$arr = json_decode(htmlspecialchars_decode($value),true);//第二个参数必须为true，因为php无法区分二维数组 强制转为数组
			$k=$maxlength;
			$ady_upload =count($arr);
			foreach($arr as $key => $value)
			{
				//老图片，点删除按钮不跟着删除
				$str.='<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][oldfile]"/>';

				$str.='<div style="margin-bottom:10px" class="dis-btn-'.$k.' mo_div_'.$dataname.'">';
				//老图片，点删除按钮跟着删除
				$str.='<input type="hidden" value="'.$value['size'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][size]"/>
				<input type="hidden" value="'.$value['filename'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][filename]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"   name="info['.$dataname.']['.$k.'][src]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][path]"/>
				<input type="hidden" value="'.$value['savename'].'" class="Iw290"  name="info['.$dataname.']['.$k.'][selfname]"/>';

				$str.='<input type="text" value="'.$value['savename'].'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;'; //用来显示

				$str.='<input type="button" class="btn5" value="删除" onclick=\'deleteUpload("dis-btn-'.$k.'","mo_div_'.$dataname.'")\' />'; //删除按钮

				$str.='</div>';
				$k--;
				$isupdate.='*'; //用来验证上传图片的个数
			}
			$str.='<script>$(document).ready(function(){$("#'.$dataname.'").focus().blur();</script>';
		}
		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏 览" class="btn5" onclick="'.$dataname.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'uploadImages\',\'self_id\':\''.$dataname.'_uploadButton\',\'check_id\':\''.$dataname.'\'})" id="'.$dataname.'_uploadButton" limit="'.$setting['limit'].'" /><input type="hidden" id="'.$dataname.'" value="'.$isupdate.'" _required='.$maxval.' /></td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$dataname.'uploadAccessory (obj){var option={upload_id:\''.$dataname.'\',title:\'多附件上传\',return_id:\'info['.$dataname.']\',callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}getAlreadyUploadNUm();</script>';

		return $str;
	}

	/**
	 * 单选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function radio($fieldinfo,$value)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';',$defaultvalue);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th>'.$font. $name.'：</th><td  colspan="3">';

		foreach($defaultvalue as $k => $v)
		{
			$checkstr =  $v == $value || $k==0 ? 'checked="checked"' : '';
			$str.='<span><input id="'.$dataname.$k.'" type="radio" name="info['.$dataname.']"  value="'.$v.'"  '. $checkstr.'/><label>'.$v.'</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$str.='<span id="'.$dataname.'_tips"></span></td></tr>';
		return $str;

	}
	
	/**
	 * 联动菜单
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function linkage($fieldinfo,$value)
	{
		extract($fieldinfo);
// 		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isnull==1)
// 		{
//  			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',$minlength,'',2,2,$ismain,$modelid,'linkage',$name);
//  		}

		//根据标识名字获取联动顶级ID
		$linkinfo =  M('linkage')->where(array('style'=>$dataname))->field('linkageid')->getOne();

		$LinkObj = new MylinkAge();
		$tree = $LinkObj -> getTree($linkinfo['linkageid']);

		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th>'.$font.$name.'：</th><td id="'.$dataname.'" >';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/linkage.js"></script>';
		$n = $tree['select_level'];
		unset($tree['select_level']);
		$vArr = array();
		if($value) $vArr = explode(';',$value);
		for($i=1; $i<=$n;$i++)
		{
			if($i<$n)
			{
				$js = ' onchange="javascript:Prelinkage(this,\''.$dataname.'_'.($i+1).'\')"';
			}
			else
			{
				$js = '';
			}
	
			$str.='<select  class="Iw290" style="width:162px;" name="info['.$dataname.'][]"  id="'.$dataname.'_'.$i.'" style="width:162px;" '.$js.'>';
		    $str.='<option value="">--请选择--</option>';
			foreach($tree as $key=>$value)
			{
				if(!empty($vArr))
				{
					$checkstr = !empty($vArr)&&$value['id']==@$vArr[$i-1] ? ' selected="selected" ' : '';
					if($value['level']== $i)
					{
					    $str.='<option value="'.$value['id'].'" '.$checkstr.'>'.$value['name'].'</option>';
					}
				}
				else
				{
					if($value['level'] == 1&&1== $i)
					{
						$str.='<option value="'.$value['id'].'" >'.$value['name'].'</option>';
					}
				}

			}
			$str.='</select>&nbsp;&nbsp;&nbsp;';
			
			if ($i > 1) {
				$str .= '<script>$(document).ready(function() { $("#'.$dataname.'_'.$i. '").hide();});</script>';
			}
		}
		
		$str.= '<span id="'.$dataname.'_tips"></span></td></tr>';
		if($errortips||$minval||$maxval||$isnessary==1)
		{
			$this->getFormValidator($name,$errortips,'',$minval,$maxval,2,$isnessary,$ismain,$modelid,'link',$n,$fieldtips,$dataname);
		}
		
		return $str;
	}
	/**
	 * 数字型
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function float($fieldinfo,$value)
	{
		extract($fieldinfo);
		$value = $value ? $value : $defaultvalue;

	    $this->getFormValidator($name,$errortips,'^[0-9]+\\\.{1}[0-9]+$',$minval,$maxval,$uniqueness,$isnessary,$ismain,$modelid,'float','',$fieldtips,$dataname);

		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$dataname.']" value="'.$value.'" id="'.$dataname.'" class="Iw290"/>
		</td></tr>';
	}

	/**
	 * 整数
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function int($fieldinfo,$value)
	{
		extract($fieldinfo);
		$value = intval($value)? $value : $defaultvalue;
		if($minval) $isnessary = 1;

		if($minval || $maxval){

			$str = $minval.','.$maxval;
		}else{
			$str = '0,9999';
		}

	    $this->getFormValidator($name,$errortips,'^\\\d{'.$str.'}$',$minval,$maxval,$uniqueness,$isnessary,$ismain,$modelid,'int','',$fieldtips,$dataname);

		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$dataname.']" value="'.$value.'" id="'.$dataname.'" class="Iw290"/>
		</td></tr>';
	}
	/**
	 * 单文件
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function file($fieldinfo,$value)
	{
		if($value) $value = object_to_array(json_decode(htmlspecialchars_decode($value)));
		extract($fieldinfo);
		$src = isset($value['src']) ? $value['src'] : '';
		$savename = isset($value['savename']) ? $value['savename'] : '';
		$water_mark = isset($value['water_mark']) ? $value['water_mark'] : '';
		$size = isset($value['size']) ? $value['size'] : '';
		$filename = isset($value['filename']) ? $value['filename'] : '';
		$isimage = isset($value['isimage']) ? $value['isimage'] : '';
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		if($fieldtips||$errortips||$isnessary==1||$regex)
	    {
	        $this->getFormValidator($name,$errortips,'',0,999,2,$isnessary,$ismain,$modelid,'file','',$fieldtips,$dataname);
	    }

		$allowtype = get_mo_config('mo_filetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		if($src)
		{
			//修改的时候老文件信息
			$oldfile='<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$dataname.'][1][oldfile]" />
			<div style="margin-bottom:10px" class="dis-btn-1 mo_div_'.$dataname.'">
			<input type="hidden" value="'.$size.'" class="Iw290"  name="info['.$dataname.'][1][size]" />
			<input type="hidden" value="'.$filename.'" class="Iw290"  name="info['.$dataname.'][1][filename]" />
			<input type="hidden" value="'.$src.'" class="Iw290"   name="info['.$dataname.'][1][src]" />
			<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$dataname.'][1][path]" />
			<input type="hidden" value="'.$savename.'" class="Iw290"  name="info['.$dataname.'][1][selfname]" /></div>';
			$isupdate = true;
			//如果是修改的话自动验证
		    $str.='<script>$(document).ready(function(){$("#'.$dataname.'").focus().blur();</script>';
		}
		//上传部分代码
		$setting = array
		(
			'limit'       =>  2,
			'size'       =>  intval(ini_get('upload_max_filesize'))*1024*1024,
			'type'        =>  explode('|',$allowtype),
			'local'		  => true,			  //是否显示本地图库
			'folder'      => true,             //是否显示目录浏览
			'iswatermark' => true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		//图片上传信息隐藏域
		$str = '<tr><th>'.$font.$name.'：</th><td>'.$oldfile.'<span id=\''.$dataname.'single-upload'.'\'></span>';

		//图片显示
		$str.='<input type="text" readonly  value="'.$savename.'" class="Iw290" id="'.$dataname.'_show" name="info['.$dataname.'][show]"/>&nbsp;&nbsp;';

		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏览上传" class="btn5" onclick="'.$dataname.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$dataname.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$dataname.'single-upload\',\'check_id\':\''.$dataname.'\',\'show_id\':\''.$dataname.'_show\'})" id="'.$dataname.'_uploadButton"><input type="hidden" id="'.$dataname.'" value="'.$isupdate.'" _required='.$isnessary.' />&nbsp;&nbsp;&nbsp;<input  type="button" hidefocus="hide" value="删除" class="btn5"  onclick="'.$dataname.'deleteUpload()"/> </td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$dataname.'uploadAccessory (obj){var option={upload_id:\''.$dataname.'\',title:\'文件上传\',return_id:\'info['.$dataname.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}</script>';

		//删除
		$str.='<script>function '.$dataname.'deleteUpload (){
		var obj = {\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$dataname.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$dataname.'single-upload\',\'check_id\':\''.$dataname.'\',\'show_id\':\''.$dataname.'_show\'};
		var option={upload_id:\''.$dataname.'\',title:\'文件上传\',return_id:\'info['.$dataname.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj,autoStart: false};
		deleteUpload("dis-btn-1","mo_div_'.$dataname.'",option);}</script>';
		return $str;
	}

	/**
	 * 时间与日期
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function datetime($fieldinfo,$value)
	{
		extract($fieldinfo);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';

		$value = $value ? $value : $defaultvalue;
		if($errortips||$isnessary==1||$minval||$maxval)
		{
			$this->getFormValidator($name,$errortips,'','','',2,$isnessary,$ismain,$modelid,'datatime','',$fieldtips,$dataname);
		}
		$str = '<script type="text/javascript" src="'.HOST_NAME.'static/js/My97DatePicker/WdatePicker.js"></script>';
		$str.= '<tr><th width="145px">'.$font.$name.'：</th>
		<td><span class="time"><input type="text" name="info['.$dataname.']" onfocus="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\'})" readonly value="'.$value.'" id="'.$dataname.'" class="Iw150" />
		</span></td></tr>';
		return $str;
	}
	/**
	 * 下拉框
	 * @param array $fieldinfo  字段信息
	 */
	public function select($fieldinfo,$value)
	{

		extract($fieldinfo);
		$font = $isnessary == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$minval||$maxval||$isnessary==1)
		{
			$this->getFormValidator($name,$errortips,'',$minval,$maxval,2,$isnessary,$ismain,$modelid,'int','',$fieldtips,$dataname);
		}
		$defaultvalue = explode(';',$defaultvalue);
		$str = '<tr><th>'.$font.$name.'：</th><td>	<select  class="Iw290" style="width:162px;" name="info['.$dataname.']"  id="'.$dataname.'" style="width:162px;">';
		$str.='<option value="">--请选择--</option>';
		foreach($defaultvalue as $k => $v)
		{
			$checkstr =  $v == $value ? 'selected="selected"' : '';
			$str.='<option value="'.$v.'" '.$checkstr.'>'.$v.'</option>';
		}
		$str.='</select></td></tr>';
		return $str;

	}

	/**
	 * 获取验证
	 * @param string $fieldname 字段名字
	 * @param string $ismain    是否是主表
	 * @param array  $modelid   模型id
	 * @param array  $modelid   字段类型
	 */
	public function getFormValidator($name,$errortips,$pattern,$minlength,$maxlength,$uniqueness,$isnessary,$ismain,$modelid,$fieldtype,$value='',$fieldtips,$dataname,$url="",$info="")
	{

		$onempty = $isnessary == 1 ? "onempty:'请填写{$name}'" :  'empty:true';
		$onempty = in_array($fieldtype, array('template','categoryid','readpower','select','checkbox')) ? "onempty:'请选择{$name}'" :  $onempty;
		//为空时不同类型提示不同

		$onshow  = $fieldtips ? "onshow:'{$fieldtips}'" :  '';
		$onshow = !$onshow && in_array($fieldtype, array('template','categoryid','readpower','select','checkbox')) ? "onshow:'请选择{$name}'" :  $onshow;
		//不同类型提示不同

		$onfocus  = $fieldtips ? "onfocus:'{$fieldtips}'" :  '';
		$onfocus = !$onfocus && in_array($fieldtype, array('template','categoryid','readpower','select','checkbox')) ? "onshow:'请选择{$name}'" :  $onfocus;
		//不同类型提示不同

		$onerror = $errortips ? "onerror:'{$errortips}'" :  "onerror:''";
		$oncorrect = "oncorrect:'输入正确'";

	    $minlength = $isnessary==1 && intval($minlength) ==0 ? 1: $minlength;

		$minlength = intval($minlength) ? intval($minlength) : 0; //必填项最小值为1
		$maxlength = intval($maxlength) ? intval($maxlength) : 9999;//最大值默认为999

		$isnull = intval($minlength) ? 1 : 2; //如果有最小值,则必填项

		//错误提示超过最大值，或者小于最小值
		$onerrormax = in_array($fieldtype, array('template','readpower','select','checkbox','categoryid')) ? "onerrormax:'".$errortips."'" : "onerrormax:'".$errortips."'";
		$onerrormin = in_array($fieldtype, array('template','readpower','select','checkbox','categoryid')) ? "onerrormin:'".$errortips."'" : "onerrormin:'".$errortips."'";

		//最大值最小值
		$max = "max:{$maxlength}";
		$min = "min:{$minlength}";

	    if ($url != "") {

	    	$url = '"'.HOST_NAME.$url;
	    }else if($uniqueness == 1){

	        $tem = $value =='' ? 'add' :'';
		    $url = '"'.HOST_NAME.'admin/modules/message/checkUnique?modelid='.$modelid.'&&fildname='.$dataname.'&&tem='.$tem.'"';
			$info = $name."已存在";
		}else {

	    	$url = '"'.'"';
	    }
		//唯一性判断
		$unique= $uniqueness == 1 ? 'ajaxValidator({
						type:"get",
						url : '.$url.',
						success : function(data)
						{
							if(data == 2)
								return false;
							else
								return true;
						},
						buttons: $(".btn2"),
						error: function(jqXHR, textStatus, errorThrown){onerror: "可能服务器忙，请重试"},
						onerror : "'.$info.'",
						onwait : "正在对唯一性进行合法性校验，请稍候..."
					})' : '';

		$pattern = $pattern ? 'regexValidator({regexp:"'.trim($pattern,'/').'",'.$onerror.'})' : ''; //正则验证
		$showArr = compact('onshow','onempty','onerror','oncorrect','empty','onfocus');//将变量存到数组
		$inputArr = compact('max','min','onerrormin','onerrormax');//将变量存到数组

		$ShowStr = implode(array_filter($showArr),',');  //去掉空数组
		$inputStr = implode(array_filter($inputArr),',');//去掉空数组

		//编辑器的验证不同于其他元素
		if($fieldtype == 'editor')
		{
			$pattern = '';
			$inputStr = '';
			$editor = 'functionValidator({
			    fun:function(val,elem){
					var topicContent=CKEDITOR.instances.'.$name.'.getData();
					topicContent = topicContent.replace(/^\s+/g,"");
					topicContent = topicContent.replace(/\s+$/g,"");
					topicContent = topicContent.replace(/<.*?>/g,"");
			         if (topicContent=="")
		 	         {
			        	 return "内容不能为空";
		 	         }
					 if (topicContent.length<'.$minlength.')
			         {
			        	 return "内容长度不能小于'.$minlength.'";
			         }
			         if (topicContent.length>'.$maxlength.')
			         {
			        	 return "内容长度不能大于'.$maxlength.'";
			         }
					return true;
				}
			})';
		}

		//不同类型的元素不同的获取对象方法
		$obj = $fieldtype == "checkbox" ?   '$("'.":checkbox[name='info[".$dataname."][]']".'")' : "$('#".$dataname."')";
		if ($fieldtype == 'link') {
				$obj = "$('#".$dataname." select').slice(0, $value)";
				$this->formValidator.= $obj.".formValidator({".$ShowStr."}).inputValidator({".$inputStr."})";
				$this->formValidator = $pattern ? $this->formValidator.'.'.$pattern : $this->formValidator;
				$this->formValidator = $unique ? $this->formValidator.'.'.$unique : $this->formValidator;
				$this->formValidator.=  ";";
		}
		else {
			$this->formValidator.= $obj.".formValidator({".$ShowStr."}).inputValidator({".$inputStr."})";
			$this->formValidator = $pattern ? $this->formValidator.'.'.$pattern : $this->formValidator;
			$this->formValidator = $unique ? $this->formValidator.'.'.$unique : $this->formValidator;
			$this->formValidator = $fieldtype=='editor' ? $this->formValidator.'.'.$editor : $this->formValidator;
			//$this->formValidator = $value ? $this->formValidator.".defaultPassed()" : $this->formValidator;
			$this->formValidator.=  ";";
		}

	}

	public function userForm($data=array(),$flag=2)
	{
		$num = 0;
		$info = array();
		foreach($this->fields as $k=>$v) {
			$function = $v['fieldtype'];
			if(!method_exists($this, $function)) continue;
			$value = isset($data[$v['dataname']]) ? htmlspecialchars($data[$v['dataname']], ENT_QUOTES) : '';
			if( $flag ==1) {

				$v['fieldtype'] = 'textarea';
				$form = $this->$function($v,$value,$num);
			}else{

				$form = $this->$function($v,$value);
			}

			if($form !== false) {
				$info[] = $form;
			}
		}
		return $info;

	}
}
class MylinkAge
{
	public static $tree = array();
	public static $n;
	function __construct()
	{
		self :: $tree = array();
		self :: $n = 0;
		self :: $tree['select_level'] = 1;//初始化
	}

	public static function getTree($lin_id=0 ,$pid = 0,$i=0)
	{
		$i++;
		$data = M('linkage_bill') -> findAll(array('lin_id'=>$lin_id,'pid'=>$pid),'ordernum ASC,created DESC','id,lin_id,pid,name');
		if(!empty($data))
		{
			foreach ($data as $key => $val )
		    {
				$val['level'] = $i;
				self::$tree[] = $val;
				if( $i >= self::$tree['select_level']) self::$tree['select_level'] = $i;
				self::getTree($val['lin_id'],$val['id'],$i);
		    }
		}

		return self::$tree;
	}

}