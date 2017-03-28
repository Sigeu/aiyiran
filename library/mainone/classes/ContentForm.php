<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * ContentForm.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-1-29 下午4:36:23
 * @filename   ContentForm.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class ContentForm {
	var $modelid;
	var $fields;
	var $formValidator;
	var $info;
	var $changeModel;
	function __construct($modelid,$categoryid = 0) {
		$this->modelid = $modelid;
		if($categoryid)
		{
			$result = M('category')->field('model')->where(array('id'=>$categoryid))->getOne();
			$modelid = isset($result['model']) ? $result['model'] : 1;
		}
		$modelid = $modelid ? $modelid : 1;
		$this->categoryid = $categoryid;
		$this->changeModel = $modelid;

		$this->fields = M('field')->where(array('modelid'=>$modelid,'flag'=>1))->order('sortid,addtime desc')->select();

	}

	/**
	 * @param array $data  修改的时候所用到的默认值
	 */
	public function get($data=array())
	{
		$this->data = $data;
		if(isset($data['id'])) $this->id = $data['id'];
		$info = array();	
		foreach($this->fields as $k=>$v)
		{
			$function = $v['fieldtype'];	
			$value = isset($data[$v['field']]) ? htmlspecialchars($data[$v['field']], ENT_QUOTES) : '';
			if(!method_exists($this, $function)) continue;		
			$form = $this->$function($value, $v);   	
			if($form !== false) {
				$info[$v['field']] = $form;
			}
		}
		return $info;
	}

	/**
	 * 单文本文框
	* @param string $value     字段值，没有的话取默认值
	* @param array $fieldinfo  字段信息
	 */
	public function text($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,'text',$name,$value);
		}
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/>
		</td></tr>';
	}
	
	
	/**
	 * 整形
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function int($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;

		$errortips = $errortips ? $errortips : "输入格式不正确";
		$this->getFormValidator($field,$errortips,$tips,$emptytips,'/^-?[1-9]+\\\\d*$/',$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,'int',$name,$value);

		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/>
		</td></tr>';
	}
	/**
	 * 小数型
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function float($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		$errortips = $errortips ? $errortips : "输入格式不正确";
		$this->getFormValidator($field,$errortips,$tips,$emptytips,"/^-?([1-9]+\\\\d*.\\\\d+|0\\\\.\\\d*[1-9]\\\\d*)$/",$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,'float',$name,$value);

		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/>
		</td></tr>';
	}
	/**
	 * 多行文本
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function textarea($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$minlength||$maxlength||$isnull==1)
		{
			$isunique = 2;
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,2,$ismain,$modelid,'textarea',$name);
		}
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th valign="top">'.$font. $name.'：</th><td colspan="3"><textarea class="Iw450 Ih80" name="info['.$field.']" id="'.$field.'">'.$value.'</textarea></td></tr>';
	}



	/**
	 * 单选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function radio($value,$fieldinfo)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';',$defaultvalue);  
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th>'.$font. $name.'：</th><td  colspan="3">';
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',1,1,$isnull,2,$ismain,$modelid,'radio',$name);
		}
		foreach($defaultvalue as $k => $v)
		{
			$checkstr =  $v == $value || $k==0 ? 'checked="checked"' : '';
			$str.='<span><input id="'.$field.$k.'" type="radio" name="info['.$field.']"  value="'.$v.'"'. $checkstr.'/><label>'.$v.'</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$str.='<span id="'.$field.'_tips"></span></td></tr>';
		return $str;
	}
	
	
	/**
	 * 下拉框
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function select($value,$fieldinfo)
	{
		extract($fieldinfo);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',1,$maxlength,$isnull,2,$ismain,$modelid,'select',$name);
		}
		$defaultvalue = explode(';',$defaultvalue);
		$str = '<tr><th>'.$font.$name.'：</th><td>	<select  class="Iw290" style="width:162px;" name="info['.$field.']"  id="'.$field.'" style="width:162px;">';
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
	 * 多选框
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function checkbox($value,$fieldinfo)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';',$defaultvalue);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',$minlength,$maxlength,$isnull,2,$ismain,$modelid,'checkbox',$name);
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
			$str.='<input id="'.$field.$k.'" type="checkbox" name="info['.$field.'][]" '.$checkstr.' value="'.$v.'">'.$v.'</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$br;
		}
		$str.='<span id="'.$field.'_tips"></span></td></tr>';
		return $str;
	}
	/**
	 * HTML文本（编辑器）
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function editor($value,$fieldinfo)
	{
		extract($fieldinfo);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if(!$value) $value = $defaultvalue;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',$minlength,$maxlength,$isnull,2,$ismain,$modelid,'editor',$name);
		}
		$str = '<tr>
                  <th>'.$font.$name.'</th>
                  <td colspan="2"><div class="edit_box" style="height:auto"><textarea name="info['.$field.']" id="'.$field.'">'.$value.'</textarea></div></td>
                </tr>';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/ckeditor/ckeditor.js"></script>';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/iniEditor.js"></script>';
		$str.= '<script>$(document).ready(function(){init("'.$field.'", "加载失败");})</script>';
		return $str;
	}
	/**
	 * 单图片
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function image($value=array(),$fieldinfo)
	{
		if($value) $value =  object_to_array(json_decode(htmlspecialchars_decode($value)));
// 		dump($value);
		extract($fieldinfo);
		$src		= isset($value['src']) ? $value['src'] : '';
		$savename	= isset($value['savename']) ? $value['savename'] : '';
		$size		= isset($value['size']) ? $value['size'] : '';
		$iswatermark = isset($value['iswatermark']) ? $value['iswatermark'] : '';
		$filename	= isset($value['filename']) ? $value['filename'] : '';
		$font		= $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$alt		= isset($value['alt']) ? $value['alt'] : '';

		if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',1,999,$isnull,2,$ismain,$modelid,'image',$name);
		}
		$allowtype = get_mo_config('mo_picturetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		if($src)
		{
			//修改的时候老文件信息
			$oldfile='<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$field.'][1][oldfile]" />
			<div style="margin-bottom:10px" class="dis-btn-1 mo_div_'.$field.'">
			<input type="hidden" value="'.$size.'" class="Iw290"  name="info['.$field.'][1][size]" />
			<input type="hidden" value="'.$filename.'" class="Iw290"  name="info['.$field.'][1][filename]" />
			<input type="hidden" value="'.$src.'" class="Iw290"   name="info['.$field.'][1][src]" />
			<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$field.'][1][path]" />
			<input type="hidden" value="'.$savename.'" class="Iw290"  name="info['.$field.'][1][selfname]" /></div>';
			$isupdate = true;
			//如果是修改的话自动验证
		    $str.='<script>$(document).ready(function(){$("#'.$field.'").focus().blur();})</script>';
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
		$str = '<tr><th>'.$font.$name.'：</th><td>'.$oldfile.'<span id=\''.$field.'single-upload'.'\'></span>';

		//图片显示
		$str.='<input type="text" readonly  value="'.$savename.'" class="Iw290" id="'.$field.'_show" name="info['.$field.'][show]"/>&nbsp;&nbsp;';

		//图片ALT注释
    	$str.='图片ALT注释 <input type="text"  value="'.$alt.'" class="Iw150" id="'.$field.'_alt" name="info['.$field.'][1][alt]" maxlength="100"/>&nbsp;&nbsp;';

		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏览" class="btn5" onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$field.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$field.'single-upload\',\'check_id\':\''.$field.'\',\'show_id\':\''.$field.'_show\'})" id="'.$field.'_uploadButton"><input type="hidden" id="'.$field.'" value="'.$isupdate.'" _required='.$isnull.' />&nbsp;&nbsp;&nbsp;<input id="del_button"  type="button" hidefocus="hide" value="删除" class="btn5"  onclick="'.$field.'deleteUpload()"/> </td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$field.'uploadAccessory (obj){var option={upload_id:\''.$field.'\',title:\'图片上传\',return_id:\'info['.$field.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}</script>';

		//删除
		$str.='<script>function '.$field.'deleteUpload (){
		var obj = {\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$field.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$field.'single-upload\',\'check_id\':\''.$field.'\',\'show_id\':\''.$field.'_show\'};
		var option={upload_id:\''.$field.'\',title:\'图片上传\',return_id:\'info['.$field.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj,autoStart: false};
		$(\'#'.$field.'_alt\').val("");
		deleteUpload("dis-btn-1","mo_div_'.$field.'",option);}</script>';
		return $str;
	}
	/**
	 * 单文件
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function file($value,$fieldinfo)
	{
		if($value) $value = object_to_array(json_decode(htmlspecialchars_decode($value)));
		extract($fieldinfo);
		$src = isset($value['src']) ? $value['src'] : '';
		$savename = isset($value['savename']) ? $value['savename'] : '';
		$iswatermark = isset($value['iswatermark']) ? $value['iswatermark'] : '';
		$size = isset($value['size']) ? $value['size'] : '';
		$filename = isset($value['filename']) ? $value['filename'] : '';
		$isimage = isset($value['isimage']) ? $value['isimage'] : '';
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',0,999,$isnull,2,$ismain,$modelid,'image',$name);
		}

		$allowtype = get_mo_config('mo_filetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		if($src)
		{
			//修改的时候老文件信息
			$oldfile='<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$field.'][1][oldfile]" />
			<div style="margin-bottom:10px" class="dis-btn-1 mo_div_'.$field.'">
			<input type="hidden" value="'.$size.'" class="Iw290"  name="info['.$field.'][1][size]" />
			<input type="hidden" value="'.$filename.'" class="Iw290"  name="info['.$field.'][1][filename]" />
			<input type="hidden" value="'.$src.'" class="Iw290"   name="info['.$field.'][1][src]" />
			<input type="hidden" value="'.$src.'" class="Iw290"  name="info['.$field.'][1][path]" />
			<input type="hidden" value="'.$savename.'" class="Iw290"  name="info['.$field.'][1][selfname]" /></div>';
			$isupdate = true;
			//如果是修改的话自动验证
		    $str.='<script>$(document).ready(function(){$("#'.$field.'").focus().blur();})</script>';
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
		$str = '<tr><th>'.$font.$name.'：</th><td>'.$oldfile.'<span id=\''.$field.'single-upload'.'\'></span>';

		//图片显示
		$str.='<input type="text" readonly  value="'.$savename.'" class="Iw290" id="'.$field.'_show" name="info['.$field.'][show]"/>&nbsp;&nbsp;';

		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏览上传" class="btn5" onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$field.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$field.'single-upload\',\'check_id\':\''.$field.'\',\'show_id\':\''.$field.'_show\'})" id="'.$field.'_uploadButton"><input type="hidden" id="'.$field.'" value="'.$isupdate.'" _required='.$isnull.' />&nbsp;&nbsp;&nbsp;<input id="del_button"  type="button" hidefocus="hide" value="删除" class="btn5"  onclick="'.$field.'deleteUpload()"/> </td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$field.'uploadAccessory (obj){var option={upload_id:\''.$field.'\',title:\'文件上传\',return_id:\'info['.$field.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}</script>';

		//删除
		$str.='<script>function '.$field.'deleteUpload (){
		var obj = {\'limit\':\''.$setting['limit'].'\',\'_switch\':\'upload_image\',\'self_id\':\''.$field.'_uploadButton\',\'ady_upload\':1,\'dis_place\':\''.$field.'single-upload\',\'check_id\':\''.$field.'\',\'show_id\':\''.$field.'_show\'};
		var option={upload_id:\''.$field.'\',title:\'文件上传\',return_id:\'info['.$field.']\',	callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj,autoStart: false};
		deleteUpload("dis-btn-1","mo_div_'.$field.'",option);}</script>';
		return $str;
	}
	/**
	 * 多图上传
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function images($value,$fieldinfo)
	{
		global $k;
		extract($fieldinfo);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',$minlength,$maxlength,$isnull,2,$ismain,$modelid,'images',$name);
		}
		$allowtype = get_mo_config('mo_picturetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		$setting = array
		(
			'size'       =>  ini_get('upload_max_filesize')*1024*1024,
			'limit'       =>  $maxlength ? $maxlength : get_mo_config('mo_addon_num'),
			'type'        =>  explode('|',$allowtype),
			'local'       =>  true,
			'folder'      =>  true,
			'iswatermark' =>  true
		);
		$setting['setting'] = base64_encode(serialize($setting));
		$str = '<tr><th>' . $font . $name . '：</th><td>';
		$ady_upload =0; //已经上传的图片个数
		$isupdate = '';
		static $time = 0;//为了保证多图唯一性编号
		if($value)
		{
			$arr = json_decode(htmlspecialchars_decode($value),true);//第二个参数必须为true，因为php无法区分二维数组 强制转为数组
			$k=$maxlength;
			$ady_upload =count($arr);
			
			
			foreach($arr as $key => $value)
			{
				$time++;
				//老图片，点删除按钮不跟着删除
				$str.='<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$field.']['.$k.'][oldfile]" />';

				$str.='<div id="dis-btn-'.$k . '-' .$time. '-form" style="margin-bottom:10px" class="dis-btn-' . $k . '-' .$time. ' mo_div_'.$field.'">';
				
				//老图片，点删除按钮跟着删除
				$str.='<input type="hidden" value="'.$value['size'].'" class="Iw290"  name="info['.$field.']['.$k.'][size]"/>
				<input type="hidden" value="'.$value['filename'].'" class="Iw290"  name="info['.$field.']['.$k.'][filename]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"   name="info['.$field.']['.$k.'][src]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$field.']['.$k.'][path]"/>
				<input type="hidden" value="'.$value['savename'].'" class="Iw290"  name="info['.$field.']['.$k.'][selfname]"/>';
				
				$str .= '</div>';
				
				$str .= '<div id="dis-btn-' . $k . '-' .$time. '" class="dis-btn-' . $k . '-' .$time. '" style="margin-bottom:10px">';

				$str.='<input type="text"  value="'.$value['savename'].'" disabled="desabled" class="Iw290"/>&nbsp;&nbsp;&nbsp;'; //用来显示
				
				$str.='图片ALT注释&nbsp;&nbsp;<input type="text" name="info['.$field.']['.$k.'][alt]" value="'.$value['alt'].'"  class="Iw150" maxlength="100"/>&nbsp;&nbsp;&nbsp;'; //ALT注释显示

				$str.='<input type="button" class="btn5" value="删除" onclick=\'deleteUpload("dis-btn-' . $k . '-' .$time.  '")\' />'; //删除按钮
				
				$str.= '&nbsp;<input type="button" class="btn5" value="浏览" onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'editImages\',\'self_id\':\''.$field.'_uploadButton\',\'cur_id\':\'dis-btn-' . $k . '-' .$time.  '\',\'check_id\':\''.$field.'\'})" />';//浏览按钮

				$str.='</div>';
				
				$k--;
				
				$isupdate .= '*'; //用来验证上传图片的个数
			}
			$str.='<script>$(document).ready(function(){$("#'.$field.'").focus().blur();;})</script>';
		}


		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="添加" class="btn5" 
				onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'uploadImages\',\'self_id\':\''.$field.'_uploadButton\',\'check_id\':\''.$field.'\'})" 
						id="'.$field.'_uploadButton" limit="'.$setting['limit'].'" /><input type="hidden" id="'.$field.'" value="'.$isupdate.'" _required='.$maxlength.' /></td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js?item=' . time() . '"></script><script>function '.$field.'uploadAccessory (obj){var option={upload_id:\''.$field.'\',title:\'图片上传\',return_id:\'info['.$field.']\',callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}getAlreadyUploadNUm();</script>';
		
		return $str;
	}
	
	/**
	 * 多附件
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function files($value,$fieldinfo)
	{
		extract($fieldinfo);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',0,999,$isnull,2,$ismain,$modelid,'files',$name);
		}
		$allowtype = get_mo_config('mo_filetype');
		$isupdate = '';
		$oldfile = '';
		$str = '';
		$setting = array
		(
			'size'       =>  ini_get('upload_max_filesize')*1024*1024,
			'limit'       =>  $maxlength ? $maxlength : get_mo_config('mo_addon_num'),
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
				$str.='<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$field.']['.$k.'][oldfile]"/>';

				$str.='<div style="margin-bottom:10px" class="dis-btn-'.$k.' mo_div_'.$field.'">';
				//老图片，点删除按钮跟着删除
				$str.='<input type="hidden" value="'.$value['size'].'" class="Iw290"  name="info['.$field.']['.$k.'][size]"/>
				<input type="hidden" value="'.$value['filename'].'" class="Iw290"  name="info['.$field.']['.$k.'][filename]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"   name="info['.$field.']['.$k.'][src]"/>
				<input type="hidden" value="'.$value['src'].'" class="Iw290"  name="info['.$field.']['.$k.'][path]"/>
				<input type="hidden" value="'.$value['savename'].'" class="Iw290"  name="info['.$field.']['.$k.'][selfname]"/>';

				$str.='<input type="text" value="'.$value['savename'].'" readonly class="Iw290"/>&nbsp;&nbsp;&nbsp;'; //用来显示

				$str.='<input type="button" class="btn5" value="删除" onclick=\'deleteUpload("dis-btn-'.$k.'")\' />'; //删除按钮
				
				$str.='&nbsp;&nbsp;&nbsp;<input type="button" class="btn5" value="浏览" onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'uploadImages\',\'self_id\':\''.$field.'_uploadButton\',\'check_id\':\''.$field.'\'})" />'; //删除按钮

				$str.='</div>';
				$k--;
				$isupdate.='*'; //用来验证上传图片的个数
			}
			$str.='<script>$(document).ready(function(){$("#'.$field.'").focus().blur();;})</script>';
		}


		//浏览按钮
		$str.='<input type="button" hidefocus="hide" value="浏 览" class="btn5" onclick="'.$field.'uploadAccessory({\'limit\':\''.$setting['limit'].'\',\'_switch\':\'uploadImages\',\'self_id\':\''.$field.'_uploadButton\',\'check_id\':\''.$field.'\'})" id="'.$field.'_uploadButton" limit="'.$setting['limit'].'" /><input type="hidden" id="'.$field.'" value="'.$isupdate.'" _required='.$maxlength.' /></td></tr>';

		//JS
		$str.='<script type="text/javascript" src="'.HOST_NAME.'static/js/mo_upload_file.js"></script><script>function '.$field.'uploadAccessory (obj){var option={upload_id:\''.$field.'\',title:\'附件上传\',return_id:\'info['.$field.']\',callFunName:\'accessoryUpload\',setting:\''.$setting['setting'].'\',param:obj};MainOneUpload(option);}getAlreadyUploadNUm();</script>';
		
		return $str;
	}
	/**
	 * 时间
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function datetime($value,$fieldinfo)
	{
		extract($fieldinfo);
		if($errortips||$tips||$emptytips||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',0,999,$isnull,2,$ismain,$modelid,'datetime',$name);
		}
		$value = $value ? date('Y-m-d',$value) : date('Y-m-d',time());
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<script type="text/javascript" src="'.HOST_NAME.'static/js/My97DatePicker/WdatePicker.js"></script>';
		$str.= '<tr><th width="145px">'.$font .$name.'：</th>
		<td><span class="time"><input type="text" name="info['.$field.']" onfocus="'.$field.'_WdatePicker()" readonly value="'.$value.'" id="'.$field.'" class="Iw150" />
		</span></td></tr>';
		$str.='<script>function '.$field.'_WdatePicker(){var pos = $("#'.$field.'").offset();var mytop=pos.top+28;WdatePicker({position:{top:mytop,left:pos.left}});}</script>';
		return $str;
	}
	/**
	 * 联动菜单
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function linkage($value,$fieldinfo)
	{
		extract($fieldinfo);

		//根据标识名字获取联动顶级ID
		$linkinfo =  M('linkage')->where(array('style'=>$field))->field('linkageid')->getOne();
		$LinkObj = new MylinkAge();
		$tree = $LinkObj -> getTree($linkinfo['linkageid']);
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th>'.$font.$name.'：</th><td id="'.$field.'" >';
		$str.= '<script type="text/javascript" src="'.HOST_NAME.'static/js/linkage.js"></script>';
		$n = $tree['select_level'];
		unset($tree['select_level']);
		$vArr = array();
		if($value) $vArr = explode(';',$value);
		for($i=1; $i<= $n;$i++)
		{
			if($i<$n)
			{
				$js = ' onchange="javascript:linkage(this,\''.$field.'_'.($i+1).'\')"';
			}
			else
			{
				$js = '';
			}
			$str.='<select  class="Iw290" style="width:162px;" name="info['.$field.'][]"  id="'.$field.'_'.$i.'" style="width:162px;" '.$js.'>';
		    $str.='<option value="">--请选择--</option>';
			foreach($tree as $key=>$value)
			{
				if(!empty($vArr))
				{
					$checkstr = !empty($vArr)&&isset($vArr[$i-1])&&$value['id']==$vArr[$i-1] ? ' selected="selected" ' : '';
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
				$str .= '<script>$(document).ready(function() { $("#'.$field.'_'.$i. '").hide();});</script>';
			}
		}
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isnull==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$n,$minlength,$maxlength,$isnull,2,$ismain,$modelid,'linkage',$name);
		}
		$str.= '<span id="'.$field.'_tips"></span></td></tr>';
		return $str;
	}
	/**
	 * 栏目
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function categoryid($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		if(!$errortips) $errortips = "请选择栏目";
		if(!$emptytips) $emptytips = "请选择栏目";
		if(!$tips) $tips = "请选择栏目";
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,'',1,'',1,2,1,$modelid,'categoryid',$name,$value);
		}
		if($_SESSION['roleid'] != 1)
		{
			if(!$value)
			{
				$cat_tree = getPerCategoryTree($this->modelid,2);
			}
			else
			{
				$cat_tree = getPerCategoryTree($this->modelid,3);
			}
		}
		else
		{
			$cat_tree = D('Content','content')->getCategoryTree($this->modelid);

		}

		 $str = '<tr><th width="145px"><font>*</font>' .$name.'：</th>';
		 $str.='<td colspan="3"><select class="Iw290" style="width:302px;" id="'.$field.'"  name="info['.$field.']">';
		 $str.='<option value="">--请选择栏目--</option>';
		 if(isset($cat_tree))
		 {
			 foreach($cat_tree as $k=>$v)
			 {
				$cdis ='';
				if((!$v['flag']&&$this->modelid)||$v['model']==2){$cdis = ' disabled';}
			 	$checkstr = ($v['id'] == $value || $v['id'] == $this->categoryid) ? ' selected="selected" ' : '';
				$disable = $v['columnattr'] != 1 ? ' disabled title="栏目属性为最终频道列表才可以发布文章"' : '';
			 	$str.='<option model="'.$v['model'].'"    value="'.$v['id'].'"'.$checkstr.$disable.$cdis.'>'.$v['catname'].'</option>';
			 }
             foreach($cat_tree as $k=>$v)
			 {
			   $str.='<input type="hidden" value="'.$v['model'].'" id="hidden_model_'.$v['id'].'"/>';
			 }
		 }
		 $str .= '</select>';
		 $str .='<input type="hidden" value="'.$this->changeModel.'" name="modelid" id="modelid"/>';
		 $str .='<input type="hidden" value="'.$this->changeModel.'" name="changeModel" id="changeModel"/>';
		$str.= '</td></tr>';
		/*$str.='<script>';
		$str.='function changeForm(this){
			var obj=$(this);
			var modelid = obj.attr("model");
			var categoryid = obj.val();
			if(modelid!='.$this->modelid.')
			{
				window.location.href="content/Content/chanageForm/categoryid/+"categoryid;
			}
		}';
		$str.='</script>';*/
		return $str;
	}

	/**
	 * 标题
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function title($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,1,$isunique,1,$modelid,'title',$name,$value);
		}
		return '<tr><th width="145px"><font>*</font>' .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/>
		</td></tr>';
	}
	/**
	 * 关键字
	* @param string $value     字段值，没有的话取默认值
	* @param array $fieldinfo  字段信息
	 */
	public function keywords($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$isunique = 2;
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,'keywords',$name,$value);
		}

		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/>
		</td></tr>';
	}

	/**
	 * 多行文本
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function description($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$minlength||$maxlength||$isnull==1)
		{
			$isunique = 2;
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,2,$ismain,$modelid,'description',$name);
		}
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		return '<tr><th valign="top">'.$font. $name.'：</th><td colspan="3"><textarea class="Iw450 Ih80" name="info['.$field.']" id="'.$field.'">'.$value.'</textarea></td></tr>';
	}


	/**
	 * seo-meta 标题
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function seotitle($value,$fieldinfo)
	{
		$str = '';
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,$isunique,1,$modelid,'seotitle',$name,$value);
		}

		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/> ';
		$str .= '&nbsp;&nbsp;<span id="'.$field.'_tips"></span>';
		$str .= "<br/><span>注：页面标题为内容页页面title，为空时根据系统默认设置实现</span></td></tr>";

		return $str;
	}
	/**
	 * seo-meta关键词
	* @param string $value     字段值，没有的话取默认值
	* @param array $fieldinfo  字段信息
	 */
	public function seokeywords($value,$fieldinfo)
	{
		$str = '';
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$pattern||$minlength||$maxlength||$isunique==1)
		{
			$isunique = 2;
			$this->getFormValidator($field,$errortips,$tips.' 多个关键词之间用","隔开',$emptytips,$pattern,$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,'seokeywords',$name,$value);
		}

		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th width="145px">'.$font .$name.'：</th>
		<td colspan="3"><input type="text" name="info['.$field.']" value="'.$value.'" id="'.$field.'" class="Iw290"/> ';
		$str .= '&nbsp;&nbsp;<span id="'.$field.'_tips"></span>';
		$str .= "<br/><span>注：关键词为内容页页面keywords，为空时根据系统默认设置实现</span></td></tr>";

		return $str;
	}

	/**
	 * seo-meta 内容描述
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function seodescription($value,$fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		//if($minlength) $isnull = 1;
		if($errortips||$tips||$emptytips||$minlength||$maxlength||$isnull==1)
		{
			$isunique = 2;
			$this->getFormValidator($field,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,2,$ismain,$modelid,'seodescription',$name);
		}
		$font = $isnull == 1 ? '<font>*</font>' : '&nbsp;';
		$str = '<tr><th valign="top">'.$font. $name.'：</th><td colspan="3"><textarea class="Iw450 Ih80" name="info['.$field.']" id="'.$field.'">'.$value.'</textarea> ';
		$str .= '&nbsp;&nbsp;<span id="'.$field.'_tips"></span>';
		$str .= "<br/><span>注：内容描述为内容页页面description，为空时根据系统默认设置实现</span></td></tr>";

		return $str;
	}
	/**
	 * 排序选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function sorttype($value,$fieldinfo)
	{
		extract($fieldinfo);
		//$defaultvalue = explode(';','默认排序;置顶一周;置顶一月;置顶三月;置顶半年;置顶一年');
		$defaultvalue = array(
			0=>'默认排序',
			7=>'置顶一周',
			30=>'置顶一月',
			90=>'置顶三月',
			180=>'置顶半年',
			360=>'置顶一年',
		);
		$str = '<tr><th>&nbsp;'.$name.'：</th><td>	<select  class="Iw290" style="width:162px;" name="info['.$field.']"  id="'.$field.'" style="width:162px;">';
		foreach($defaultvalue as $k => $v)
		{
			$checkstr =  $k == $value ? 'selected="selected"' : '';
			$str.='<option value="'.$k.'" '.$checkstr.'>'.$v.'</option>';
		}
		$str.='</select></td></tr>';
		return $str;
	}
	/**
	 * 选择模板
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function template($value,$fieldinfo)
	{
		extract($fieldinfo);
		$style_dir = $this -> getStyleDir();
		$content_list = $this->getFile($style_dir,'content_','.html'); //内容页
		//$content_list = filterArrByStr($content_list , 'goods' , false);//过滤掉商品模板
		$configArr = $this->import_style_config($this->getStyle()); //配置文件数组
		$str = '<tr><th><font>*</font>'.$name.'：</th><td>	<select  class="Iw290" style="width:162px;" name="info['.$field.']"  id="'.$field.'" style="width:162px;">';
		foreach($content_list as $k => $v)
		{
			$checkstr =  $v == $value ? 'selected="selected"' : '';
			//$str.='<option value="'.$v.'" '.$checkstr.'>'.$v.'('.@$configArr['file'][$v]['describe'].')</option>';
			$str.='<option value="'.$v.'" '.$checkstr.'>'.$v.'</option>';
		}
		$str.='</select></td></tr>';
		return $str;
	}
	/**
	 * 阅读权限
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function readpower($value,$fieldinfo)
	{
		extract($fieldinfo);
		$result = M('member_group')->where(array('status'=>1))->field('id,groupname')->select();

		$str = '<tr><th>&nbsp;'.$name.'：</th><td>';
		$checkstr = '';
		$kcheckstr = '';
	    if($value)
		{
			$kvalueArr = explode(';',$value);
			$kcheckstr =  in_array(0,$kvalueArr) ? 'checked="checked"' : '';
		}
		//$str.='<input type="checkbox" name="info['.$field.'][]" '.$kcheckstr.'  value="0">开放浏览</input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$checkstr = '';
		foreach($result as $k => $v)
		{
			if($value)
			{
				$valueArr = explode(';',$value);
				$checkstr =  in_array($v['id'],$valueArr) ? 'checked="checked"' : '';
			}
			$br = ($k+1)%5==0 ? "<br>" : '';
			$float = !$br ? ';float:left;display:block' : '';
			$str.='<span style="width:130px'.$float.'"><input type="checkbox" name="info['.$field.'][]" '.$checkstr.' value="'.$v['id'].'">'.$v['groupname'].'</input></span>'.$br;
		}
		$str.='<br><br><span>默认都不勾选，所有会员组均有阅读权限；若有勾选，则只允许被勾选的会员组有阅读权限</span></td></tr>';
		return $str;
	}
	/**
	 * 评论选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function allowcomment($value,$fieldinfo)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';','允许评论;禁止评论');
		$str = '<tr><th><font>*</font>'. $name.'：</th><td colspan="3">';
		foreach($defaultvalue as $k => $v)
		{
			$checkstr =  ($k+1) == $value || $k==0 ? 'checked="checked"' : '';
			$str.='<span><input type="radio" name="info[allowcomment]"  value="'.($k+1).'"'. $checkstr.'/><label>'.$v.'</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$str.='</td></tr>';
		return $str;
	}
	/**
	 * 发布选项
	 * @param string $value     字段值，没有的话取默认值
	 * @param array $fieldinfo  字段信息
	 */
	public function publishopt($value,$fieldinfo)
	{
		extract($fieldinfo);
		$defaultvalue = explode(';','生成HTML;仅动态浏览');
		$str = '<tr><th><font>*</font>'. $name.'：</th><td colspan="3">';
		$checkstr = ' ';
		foreach($defaultvalue as $k => $v)
		{
			if(empty($value)){
				if($k == 1)
				$checkstr = 'checked = "checked"';
			}else{
				$checkstr =  ($k+1) == $value ? 'checked="checked"' : '';
			}
			$str .= '<span><input type="radio" name="info[publishopt]"  value="'.($k+1).'"'. $checkstr.'/><label>'.$v.'</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$str.='<span>注：如需做前台权限控制，请勿选择"生成HTML",否则权限无效!</span></td></tr>';
		return $str;
	}

	/**
	 * 获取验证
	 * @param string $fieldname 字段名字
	 * @param string $ismain    是否是主表
	 * @param array  $modelid   模型id
	 * @param array  $modelid   字段类型
	 */
	public function getFormValidator($fieldname,$errortips,$tips,$emptytips,$pattern,$minlength,$maxlength,$isnull,$isunique,$ismain,$modelid,$fieldtype,$name,$value='')
	{
		$onempty = $isnull==1 ? "onempty:'请输入{$name}'" :  "onempty:' '";
		$onempty = in_array($fieldtype, array('template','categoryid','readpower','linkage','select','checkbox')) ? "onempty:'请选择{$name}'" :  $onempty;
        //为空时不同类型提示不同

		$onshow  = $tips ? "onshow:'{$tips}'" :  'onshow:" "';
		$onshow = !$onshow && in_array($fieldtype, array('template','categoryid','readpower','linkage','select','checkbox')) ? "onshow:'请选择{$name}'" :  $onshow;
		//不同类型提示不同

		$onfocus = in_array($fieldtype, array('template','categoryid','readpower','linkage','select','checkbox')) ? "onfocus:'请选择{$name}'" :  "onfocus:'请输入{$name}'";
		//不同类型提示不同

		$onerror = $errortips ? "onerror:'{$errortips}'" :  'onerror:"输入格式不正确"';
		$oncorrect = "oncorrect:'输入正确'";
		$minlength = intval($minlength) ? intval($minlength) : ($isnull==1?1:0); //必填项最小值为1
		$maxlength = intval($maxlength)? intval($maxlength) : 999; //必填项最小值为1;//最大值默认为999
		//$isnull = intval($minlength) ? 1 : 2; //如果有最小值,则必填项

		$empty = $isnull==1 ?  "empty:false" : "empty:true"; //允许为空
		$onempty = ($isnull==2) ? "onempty:'输入正确'": "onempty:' '"; //非必填项提示输入正确

		//错误提示超过最大值，或者小于最小值
		if($maxlength)
		{
			if(in_array($fieldtype,array('template','readpower','select','checkbox','categoryid')))
			{
				$onerrormax =  "onerrormax:'最多能选择{$maxlength}个'";
			}
			else if(in_array($fieldtype,array('image','images','file','files')))
			{
				$onerrormax =  "onerrormax:'最大上传个数为{$maxlength}个'";
			}
			else
			{
				$onerrormax =  "onerrormax:'最大长度不能超过{$maxlength}个字符'";
			}

		}
		if($minlength)
		{
			if(in_array($fieldtype, array('select','checkbox')))
			{
				$onerrormin =  "onerrormin:'至少选择{$minlength}个'";
			}
			else if(in_array($fieldtype,array('image','images','file','files')))
			{
				$onerrormin =  "onerrormin:'最小上传个数不能低于{$minlength}个'";
			}
			else if(in_array($fieldtype, array('template','linkage','readpower','sortype','categoryid')))
			{
				$onerrormin =  "onerrormin:'请选择{$name}'";
			}
			else
			{
				$onerrormin =  "onerrormin:'最小长度不能低于{$minlength}个字符'";
			}

		}

		//最大值最小值
		$max = $maxlength ? "max:{$maxlength}" : "";
		$min = $minlength ? "min:{$minlength}" : "";
		//唯一性判断
		$unique= $isunique == 1 ? 'ajaxValidator({
						type:"post",
						data:"oldvalue='.$value.'",
						url : "'.HOST_NAME.'admin/content/Fieldmanage/checkUnique/modelid/'.$modelid.'/uniquefield/'.$fieldname.'",
						success : function(data)
						{
							if(data==1)
								return false;
							else
								return true;
						},
						buttons: $(".btn2"),
						error: function(jqXHR, textStatus, errorThrown){onerror: "可能服务器忙，请重试"},
						onerror : "该值不唯一，请重新填写",
						onwait : "正在对唯一性进行合法性校验，请稍候..."
					})' : '';

		//$pattern = $pattern ? 'regexValidator({regexp:"^(\\\\w)+$"})' : ''; //正则验证
		$pattern = $pattern ? 'regexValidator({regexp:"'.trim($pattern,'/').'",'.$onerror.'})' : '';
		//正则验证

		//构建提示层id
		$tipid = '';
		if(in_array($fieldtype, array('select','editor','radio','checkbox','seotitle','seokeywords','seodescription')))
		{
			$tipid= "tipid:'".$fieldname."_tips'";
			$showArr = compact('tipid','onshow','onempty','onerror','oncorrect','empty','onfocus');//将变量存到数组
		}
		else
		{
			$showArr = compact('onshow','onempty','onerror','oncorrect','empty','onfocus');//将变量存到数组
		}
		$inputArr = compact('max','min','onerrormin','onerrormax');//将变量存到数组
		$ShowStr = implode($showArr,',');  //去掉空数组
		$inputStr = implode(array_filter($inputArr),',');//去掉空数组
		//编辑器的验证不同于其他元素
        /*if($fieldtype == 'editor')
		{   $editor='';
			if($minlength||$maxlength||$isnull==1)
			{

				if($isnull==1)
					$return_content='art.dialog.alert("内容不能为空");return false;';
				else
					$return_content= 'return true';
				$editor = '$("form").submit(function(){
					  var topicContent=CKEDITOR.instances.'.$fieldname.'.getData();
					  topicContent = topicContent.replace(/^\\\\s+/g,"");
					  topicContent = topicContent.replace(/\\\\s+$/g,"");
					  topicContent = topicContent.replace(/<.*?>/g,"");
					  if (topicContent=="")
					  {
						 '.$return_content.';
					  }
					  else if (topicContent.length<'.$minlength.'&'.$minlength.')
					  {
						 return false;
					  }
					  else  if (topicContent.length>'.$maxlength.'&'.$maxlength.')
					  {
						 art.dialog.alert("内容长度不能大于'.$maxlength.'");
						 return false;
					  }
					  else{
					    return true;
					  }
					});';
			}
		}*/
		
		//编辑器的验证不同于其他元素
		if($fieldtype == 'editor')
		{
			$pattern = '';
			$inputStr = '';
			$editor = 'functionValidator({
			    fun:function(val,elem){
					var topicContent=CKEDITOR.instances.'.$fieldname.'.getData();
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
		switch($fieldtype)
		{
			case 'checkbox': $obj = '$("'.":checkbox[name='info[".$fieldname."][]']".'")' ; break;
			case 'radio':  $obj = '$("'.":radio[name='info[".$fieldname."]']".'")' ; break;
			case 'linkage':  $obj = "$('#".$fieldname." select:visible')"; break;
			default: $obj = "$('#".$fieldname."')"; break;
		}
		
		$this->formValidator.= $inputStr ? $obj.".formValidator({".$ShowStr."}).inputValidator({".$inputStr."})" : $this->formValidator.$obj.".formValidator({".$ShowStr."})";
		$this->formValidator = $pattern ? $this->formValidator.'.'.$pattern : $this->formValidator;
		$this->formValidator = $unique ? $this->formValidator.'.'.$unique : $this->formValidator;
		$this->formValidator = $fieldtype=='editor' ? $this->formValidator.'.'.$editor : $this->formValidator;
		//$this->formValidator = $value ? $this->formValidator.".defaultPassed()" : $this->formValidator;
		$this->formValidator.=  ";";
		
		if ($fieldtype == 'linkage') {
			$this->formValidator.= "$('#".$fieldname." select').bind('change' , function () { ";
			
			$this->formValidator.= $inputStr ? $obj.".formValidator({".$ShowStr."}).inputValidator({".$inputStr."})" : $this->formValidator.$obj.".formValidator({".$ShowStr."})";
			$this->formValidator = $pattern ? $this->formValidator.'.'.$pattern : $this->formValidator;
			$this->formValidator = $unique ? $this->formValidator.'.'.$unique : $this->formValidator;
			$this->formValidator.=  ";";
					
			$this->formValidator.= " });";
		}	
		
				
	}
	/**
	 * 返回以某个字符开头的文件
	 *
	 */
	function getFile($dir='',$pattern='',$ext='.html')
	{
		$list = glob($dir.DS.$pattern.'*'.$ext, GLOB_NOSORT);
		foreach($list as $key => $value)
		{
			$list[$key] = basename($value);
		}
		return $list;
	}
	/**
	 * 获取当前模板风格
	 */
	public function getStyle()
	{
		$style = get_cache('template_style','common','home');
		$style = $style ? $style : DEFAULT_STYLE;
		return $style;
	}
	/**
	 * 获取当前模板目录
	 */
	public function getStyleDir ()
	{
		$home_tpl_style = $this->getStyle();
		$home_tpl_dir = getDirView();
		return $home_tpl_dir.$home_tpl_style;
	}
	/**
	 * 引入模板风格配置文件
	 * @param string $style
	 * @param boolen ture:返回成功与失败，false：返回路径
	 */

	function import_style_config($style = 'default',$flag = true)
	{
		return $flag ? include getDirView().$style.DIRECTORY_SEPARATOR.'config.php' :  getDirView().$style.DIRECTORY_SEPARATOR.'config.php';
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