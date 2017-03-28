<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * MoAuthCode.php
 *
 * 验证码类
 *
 *
 * @author     leishaojin<leishaojin2012@163.com>   2012-03-9 16:44
 * @filename   MoAuthCode.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 */

class  MoAuthCode
{
	public $width;//图像宽
	public $height;//图像高
	public $density;//杂质疏密程度
	public $code;//真实的验证码，共用户注册SESSION用
	public $codeLength;//验证码字符个数
	public $fontStyle;//验证码字符个数
	public $color1;
	public $color2;
	public $color3;
	public $fontSize;
	public $X;
	public $Y;
	public $x_offset;

   /**
	* 初始化验证码属性
	* @params1:宽度
	* @params2:高度
	* @params3:验证码的字符的范围有，0-6七种范围
	* @params4:验证码字符的个数
	* @params5:字体文件名称，注意字体路径，你可以传绝对完整路径，也可以直接传当前文件夹下的字体文件名
	* @params6:字体大小
	* @params7:X轴起始位置
	* @params8:Y轴起始位置
	* @params9:字符间距
	*/
	function __construct ($width=80,$height=24,$style=0,$length=4,$fontStylePath='shuzi.ttf',$fontSize=20,$X=5,$Y=20,$x_offset=18)
	{
		$this -> width = $width;
		$this -> height = $height;
		$this -> density = 3;
		$this -> codeLength =  $length;
		$this -> code = strtoupper($this -> getCode($style));
		$this -> fontSize = $fontSize;
		$this -> X = $X;
		$this -> Y = $Y;
		$this -> x_offset = $x_offset;

		//字体路径注意一下
		if(file_exists($fontStylePath))
			$this->fontStyle = $fontStylePath;
		else if(file_exists(dirname(__FILE__).'/'.$fontStylePath))
			$this->fontStyle = dirname(__FILE__).'/'.$fontStylePath;
		else
			$this->fontStyle = '';

		$this->setColor();
	}

	/*
	 *  -------------------------------------------------
	 *   @func:创建验证码图像
	 *  -------------------------------------------------
	 *   @return:验证码资源性的数据
	 *  -------------------------------------------------
	 */
	function createImg ()
	{
		$img = imagecreatetruecolor($this->width,$this->height);//新建一个真彩色图像
		$black = imagecolorallocate($img, 204, 204, 204);//为一幅图像分配颜色
		$weight = imagecolorallocate($img, 255, 255, 255);//为一幅图像分配颜色

		imagefilledrectangle($img, 0, 0, $this->width, $this->height, $black);// 画一矩形并填充
		imagefilledrectangle($img, 1, 1, $this->width-2, $this->height-2, $weight);// 画一矩形并填充
		$x_pos = 5;//X轴开始位置
		$x_offset = 18;//X轴字母间距偏移量

		//如果有艺术字体
		if($this->fontStyle != ''  && function_exists('imagettftext'))
		{
			for ($i=0;$i<$this -> codeLength;$i++)
			{
				$textcolor = imagecolorallocate($img, $this->color1, $this->color2, $this->color3);
				imagettftext($img,$this -> fontSize, rand(-25,25), $this -> X, $this -> Y, $textcolor, $this->fontStyle, $this->code[$i]);
				$this -> X += $this -> x_offset;
				$this->setColor();
			}
		}
		else
		{
			self::__construct(88,28,3,4,'shuzi.ttf',16,7,6,20);
			$this->setColor(array(array(111,111,111)));
			for ($i=0;$i<$this -> density;$i++)
			{
				$textcolor = imagecolorallocate($img, $this->color1, $this->color2, $this->color3);
				imagearc($img, rand(0,100), rand(0,$this->height), rand(1,$this->width), rand(1,$this->width), 0, rand(0,360),$textcolor);
			}

			for ($i=0;$i<$this -> codeLength;$i++)
			{
				$textcolor = imagecolorallocate($img, $this->color1, $this->color2, $this->color3);
				imagestring($img, 5, $this -> X,$this -> Y, $this->code[$i], $textcolor);
				$this -> X += $this -> x_offset;
				$this->setColor();
			}
			//$img = imagerotate($img, 0, 0);
		}
		return $img;
	}

	/*
	 *  -------------------------------------------------
	 *   @func:获取验证码字符
	 *  -------------------------------------------------
	 *   @params1:验证码的字符的范围有，0-6七种范围
	 *  -------------------------------------------------
	 */
	function getCode ( $mode = 0)
	{
		switch ($mode)
		{
			case '1':
				$str = '1234567890';
				break;
			case '2':
				$str = 'abcdefghijklmnopqrstuvwxyz';
				break;
			case '3':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case '4':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				break;
			case '5':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				break;
			case '6':
				$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
				break;
			default:
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
				break;
		}
		$result = '';
		$l = strlen($str);
		for($i = 0;$i < $this -> codeLength;$i++)
		{
			$num = rand(0, $l-1);
			$result .= $str[$num];
		}
		return $result;
	}

	function setColor ($array=array())
	{
		$color = array();
		if(!empty($array))
		{
			$color = $array;
		}
		else
		{
			$color=array(
			array(18,18,244),
			array(229,14,216),
			array(213,143,18),
			array(247,7,7),
			array(5,107,9),
			array(0,0,0),
			array(180,11,205),
			array(255,51,204),
			array(102,102,102)
			);
		}
		list($this->color1,$this->color2,$this->color3) = $color[array_rand($color)];
	}
}

//用法一
//$img =new MoAuthCode();
//$image = $img->createImg();
//echo '<pre>';
//print_r ($img);//输出图像之前，打印此对象，里面肯定有你想用的东东，
//imagepng($image);//把图像以png的格式输出
//imagedestroy($image);//注销图,以免占用资源
//用法二
/*
$img =new MoAuthCode(120,50,0,4,'yinwen.ttf',26,5,35,28);
$image = $img->createImg();
imagepng($image);//把图像以png的格式输出
imagedestroy($image);//注销图,以免占用资源
*/
//当然你也可以稍微动动手，发挥你的想象，制作你想要的任何验证码。比如把随机颜色，随机字体，随机大小，随机倾斜都做成可配置的项。验证码也不过如此。
?>