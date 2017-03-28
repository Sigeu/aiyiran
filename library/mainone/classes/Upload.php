<?php
class Upload{
    private $allowTypes     = array('gif','jpg','png','bmp');
    public $uploadPath     = null;
    private $maxSize        = 1024000;
    private $msgCode        = null;
	public  $xlq_filetype   = array();
    public function __construct($options = array())
    {
		$this -> setfiletype();
        //取类内的所有变量
        $vars = get_class_vars(get_class($this));
        //设置类内变量
        foreach ($options as $key=>$value)
        {
            if (array_key_exists($key, $vars)) {
                $this->$key = $value;
            }
        }
    }
    public function fileUpload($myfile)
    {
        $name       = $myfile['name'];
        $tmpName    = $myfile['tmp_name'];
        $error      = $myfile['error'];
        $size       = $myfile['size'];

        //检查上传文件的大小 or 类型 and 上传的目录
        if ($error > 0) {
            $this->msgCode = $error;
            return false;
        } elseif (!$this->checkType($name)) {
            return false;
        } elseif (!$this->checkSize($size)) {
            return false;
        } elseif (!$this->checkUploadFolder()) {
            return false;
        }
        $newFile = $this->uploadPath . '/' . $this->randFileName($name);
        //复制文件到上传目录
        if (!is_uploaded_file($tmpName)) {
            $this->msgCode = -3;
            return false;
        } elseif(@move_uploaded_file($tmpName, iconv('utf-8','gbk',$newFile))) {
            $this->msgCode = 0;
            return $newFile;
        } else {
            $this->msgCode = -3;
            return false;
        }
    }
    /**
    * 检查上传文件的大小有没有超过限制
    *
    * @var int $size
    * @return boolean
    */
    private function checkSize($size)
    {
        if ($size > $this->maxSize) {
            $this->msgCode = -2;
            return false;
        } else {
            return true;
        }
    }

    /**
    * 检查上传文件的类型
    *
    * @var string $fileName
    * @return boolean
    */
    private function checkType($fileName)
    {
        $type = pathinfo($fileName,PATHINFO_EXTENSION);
        if($this->allowTypes == '*.*'|| $this->allowTypes == '*')
        {
        	return true;
        }
        else if (is_array($this->allowTypes)&&in_array(strtolower($type),$this->allowTypes))
        {
            return true;
        } else {
            $this->msgCode = -1;
            return false;
        }
    }
    /**
    * 检查上传的目录是否存在,如不存在尝试创建
    *
    * @return boolean
    */
    private function checkUploadFolder()
    {
        if (null === $this->uploadPath) {
            $this->msgCode = -5;
            return false;
        }
        $this->uploadPath = rtrim($this->uploadPath,'/');
        $this->uploadPath = rtrim($this->uploadPath,'\\');
        if (!file_exists($this->uploadPath)) {
            if ($this->Directory($this->uploadPath)) {
                return true;
            } else {
                $this->msgCode = -4;
                return false;
            }
        } elseif(!is_writable($this->uploadPath)) {
            $this->msgCode = -3;
            return false;
        } else {
            return true;
        }
    }

    //添加多层级创建目录 wake1 格式：$up->uploadPath = 'static/uploadfile/member_info';
    public function Directory($dir){
        if(is_dir($dir) || @mkdir($dir,0777)){
           return true;
        }else{
            $this->Directory(dirname($dir));
            if(@mkdir($dir,0777)){
                return true;
            }
        }

    }

    /**
    * 生成随机文件名
    *
    * @var string $fileName
    * @return string
    */
    private function randFileName($fileName)
    {
        $fileext = pathinfo($fileName,PATHINFO_EXTENSION);
        return date('Ymdhis').rand(100, 999).'.'.$fileext;
    }
    /**
    * 取上传的结果和信息
    *
    * @return array
    */
    public function getStatus()
    {
        $messages = array(
            4   => "没有文件被上传",
            3   => "文件只被部分上传",
            2   => "上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值",
            1   => "上传文件超过了php.ini 中upload_max_filesize选项的值",
            0   => "上传成功",
            -1  => "只允许上传".implode('、',$this -> allowTypes)."格式的图片",
            -2  => "文件过大，上传文件不能超过{$this->maxSize}个字节",
            -3  => "上传失败",
            -4  => "建立存放上传文件目录失败，请重新指定上传目录",
            -5  => "必须指定上传文件的路径"
        );
        return array('error'=>$this->msgCode, 'message'=>$messages[$this->msgCode]);
    }

	function setfiletype()
    {
        $this->xlq_filetype['chm']='application/octet-stream';
        $this->xlq_filetype['ppt']='application/vnd.ms-powerpoint';
        $this->xlq_filetype['xls']='application/vnd.ms-excel';
        $this->xlq_filetype['doc']='application/msword';
        $this->xlq_filetype['exe']='application/octet-stream';
        $this->xlq_filetype['rar']='application/octet-stream';
        $this->xlq_filetype['js']="javascript/js";
        $this->xlq_filetype['css']="text/css";
        $this->xlq_filetype['hqx']="application/mac-binhex40";
        $this->xlq_filetype['bin']="application/octet-stream";
        $this->xlq_filetype['oda']="application/oda";
        $this->xlq_filetype['pdf']="application/pdf";
        $this->xlq_filetype['ai']="application/postsrcipt";
        $this->xlq_filetype['eps']="application/postsrcipt";
        $this->xlq_filetype['es']="application/postsrcipt";
        $this->xlq_filetype['rtf']="application/rtf";
        $this->xlq_filetype['mif']="application/x-mif";
        $this->xlq_filetype['csh']="application/x-csh";
        $this->xlq_filetype['dvi']="application/x-dvi";
        $this->xlq_filetype['hdf']="application/x-hdf";
        $this->xlq_filetype['nc']="application/x-netcdf";
        $this->xlq_filetype['cdf']="application/x-netcdf";
        $this->xlq_filetype['latex']="application/x-latex";
        $this->xlq_filetype['ts']="application/x-troll-ts";
        $this->xlq_filetype['src']="application/x-wais-source";
        $this->xlq_filetype['zip']="application/zip";
        $this->xlq_filetype['bcpio']="application/x-bcpio";
        $this->xlq_filetype['cpio']="application/x-cpio";
        $this->xlq_filetype['gtar']="application/x-gtar";
        $this->xlq_filetype['shar']="application/x-shar";
        $this->xlq_filetype['sv4cpio']="application/x-sv4cpio";
        $this->xlq_filetype['sv4crc']="application/x-sv4crc";
        $this->xlq_filetype['tar']="application/x-tar";
        $this->xlq_filetype['ustar']="application/x-ustar";
        $this->xlq_filetype['man']="application/x-troff-man";
        $this->xlq_filetype['sh']="application/x-sh";
        $this->xlq_filetype['tcl']="application/x-tcl";
        $this->xlq_filetype['tex']="application/x-tex";
        $this->xlq_filetype['texi']="application/x-texinfo";
        $this->xlq_filetype['texinfo']="application/x-texinfo";
        $this->xlq_filetype['t']="application/x-troff";
        $this->xlq_filetype['tr']="application/x-troff";
        $this->xlq_filetype['roff']="application/x-troff";
        $this->xlq_filetype['shar']="application/x-shar";
        $this->xlq_filetype['me']="application/x-troll-me";
        $this->xlq_filetype['ts']="application/x-troll-ts";
        $this->xlq_filetype['gif']="image/gif";
        $this->xlq_filetype['jpeg']="image/pjpeg";
        $this->xlq_filetype['jpg']="image/pjpeg";
        $this->xlq_filetype['jpe']="image/pjpeg";
        $this->xlq_filetype['ras']="image/x-cmu-raster";
        $this->xlq_filetype['pbm']="image/x-portable-bitmap";
        $this->xlq_filetype['ppm']="image/x-portable-pixmap";
        $this->xlq_filetype['xbm']="image/x-xbitmap";
        $this->xlq_filetype['xwd']="image/x-xwindowdump";
        $this->xlq_filetype['ief']="image/ief";
        $this->xlq_filetype['tif']="image/tiff";
        $this->xlq_filetype['tiff']="image/tiff";
        $this->xlq_filetype['pnm']="image/x-portable-anymap";
        $this->xlq_filetype['pgm']="image/x-portable-graymap";
        $this->xlq_filetype['rgb']="image/x-rgb";
        $this->xlq_filetype['xpm']="image/x-xpixmap";
        $this->xlq_filetype['txt']="text/plain";
        $this->xlq_filetype['c']="text/plain";
        $this->xlq_filetype['cc']="text/plain";
        $this->xlq_filetype['h']="text/plain";
        $this->xlq_filetype['html']="text/html";
        $this->xlq_filetype['htm']="text/html";
        $this->xlq_filetype['htl']="text/html";
        $this->xlq_filetype['rtx']="text/richtext";
        $this->xlq_filetype['etx']="text/x-setext";
        $this->xlq_filetype['tsv']="text/tab-separated-values";
        $this->xlq_filetype['mpeg']="video/mpeg";
        $this->xlq_filetype['mpg']="video/mpeg";
        $this->xlq_filetype['mpe']="video/mpeg";
        $this->xlq_filetype['avi']="video/x-msvideo";
        $this->xlq_filetype['qt']="video/quicktime";
        $this->xlq_filetype['mov']="video/quicktime";
        $this->xlq_filetype['moov']="video/quicktime";
        $this->xlq_filetype['movie']="video/x-sgi-movie";
        $this->xlq_filetype['au']="audio/basic";
        $this->xlq_filetype['snd']="audio/basic";
        $this->xlq_filetype['wav']="audio/x-wav";
        $this->xlq_filetype['aif']="audio/x-aiff";
        $this->xlq_filetype['aiff']="audio/x-aiff";
        $this->xlq_filetype['aifc']="audio/x-aiff";
        $this->xlq_filetype['swf']="application/x-shockwave-flash";
		$this->xlq_filetype['sql']="text/plain";
    }

	function getFileType ($name)
	{
		if(function_exists('mime_content_type'))
			return mime_content_type($name);

		$ext = '';
		$name = pathinfo($name);
		isset($name['extension']) && $ext = $name['extension'];
		if(isset($this->xlq_filetype[$ext]))
			return $this->xlq_filetype[$ext];
		else
			return false;
	}
}
?>
