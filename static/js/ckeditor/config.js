/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.filebrowserBrowseUrl = '/template/default/upload/';  
	//config.filebrowserImageBrowseUrl = '/template/default/upload/'; 
	config.width=654;
	config.height=344;
	config.filebrowserUploadUrl = '/static/js/swfupload/simpledemo/upload.php';  
	config.filebrowserImageUploadUrl = '/static/js/swfupload/simpledemo/upload.php';
	config.toolbar_MyToolbar = [ { name: 'document', items : [ 'Source','NewPage','Preview' ] }, { name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] }, { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] }, { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] }, '/', { name: 'styles', items : [ 'Styles','Format' ] }, { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] }, { name: 'insert', items :[ 'Image','Table','HorizontalRule','Smiley'] }, { name: 'links', items : [ 'Link','Unlink'] }];
	config.enterMode = CKEDITOR.ENTER_BR; 
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.font_names='宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;'+ config.font_names;
	//config.defaultLanguage = 'zh-cn' 
	config.font_defaultLabel = '宋体'; 
};
