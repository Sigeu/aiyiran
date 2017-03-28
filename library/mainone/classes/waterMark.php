<?php

/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * waterMark.php
 *
 * 添加水印类
 *
 * @author     黄利科<wangrui@mail.b2b.cn>   2013-1-16
 * @filename   waterMark.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class Mark
{

    /* 获取当前有效图片水印路径和其他设置 */
    function getMarkInfo()
    {
        $obj = Load::loadModel('SystemModel','webset','admin');
        $info = $obj->find(array('group_id'=> 8));
        return $info;
    }

    /**
     * @param  string $open   水印开关
     * @param  string $option  image:图片水印 word:文字水印
     * @param  string $destination  原图片
     * @param  string $waterfilename  水印图片
     * @param  string $pos  水印位置
     * @param  int    $transparent 0--100  透明度
     * @param  int    $size  字号
     * @param  string $TextColor 文字颜色 （16位进制色值）
     * @param  string $text 文字水印内容
     * @param  string $fontType 字体类型 默认取了宋体
     */
    function addMark($open,$option,$destination,$waterfilename,$pos,$transparent = 50,$size,$TextColor,$text,$fontType)
    {
        if($open =='N') //关闭水印
            return true;
            
        if (!file_exists($destination)) {
            return true;
        }
        if($option =='word') { //文字水印

            $srcInfo = @getimagesize($destination); //获取源图片的宽高
            $srcImg_w  = $srcInfo[0];
            $srcImg_h  = $srcInfo[1];
            $srcim = null;
            switch ($srcInfo[2])  //支持的图片类型
            {
                case 1:
                    $srcim =imagecreatefromgif($destination);
                    break;
                case 2:
                    $srcim =imagecreatefromjpeg($destination);
                    break;
                case 3:
                    $srcim =imagecreatefrompng($destination);
                    break;
                default:
                    return true;
                    break;
            }
            if (empty($srcim)) {
                return true;
            }
            $box = @imagettfbbox($size, 0, $fontType,$text); //获取使用该字体的文本范围
            $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
            $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);

            switch($pos)  //文字水印位置
            {
                case 'lt': //顶部居左
                    $x = +10;
                    $y = +20;
                    break;
                case 'ct': //顶部居中
                    $x = ($srcImg_w - $logow) / 2;
                    $y = +20;
                    break;
                case 'rt': //顶部居右
                    $x = $srcImg_w - $logow - 10;
                    $y = +20;
                    break;
                case 'lc': //左边居中
                    $x = +5;
                    $y = ($srcImg_h - $logoh) / 2;
                    break;
                case 'cc': //图片正中
                    $x = ($srcImg_w - $logow) / 2;
                    $y = ($srcImg_h - $logoh) / 2;
                    break;
                case 'rc': //右边居中
                    $x = $srcImg_w - $logow - 5;
                    $y = ($srcImg_h - $logoh) / 2;
                    break;
                case 'lb': //底部居左
                    $x = +5;
                    $y = $srcImg_h - $logoh - 5;
                    break;
                case 'cb': //底部居中
                    $x = ($srcImg_w - $logow) / 2;
                    $y = $srcImg_h - $logoh - 5;
                    break;
                case 'rb': //底部居右
                    $x = $srcImg_w - $logow - 5;
                    $y = $srcImg_h - $logoh -5;
                    break;
            }

            $dst_img = imagecreatetruecolor($srcImg_w, $srcImg_h); //创建真色彩图像

            imagecopy($dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);  //拷贝图像的一部分

            $rgb = $this->Hex2Rgb($TextColor);  //分析三原色值

            $color = imagecolorallocate($dst_img, $rgb['r'], $rgb['g'], $rgb['b']);

            imagettftext ($dst_img, $size, 0, $x, $y, $color, $fontType,$text);  //do it

            switch ($srcInfo[2])  //输入图像
            {
                case 1:
                    imagegif($dst_img, $destination);
                    break;
                case 2:
                    imagejpeg($dst_img, $destination);
                    break;
                case 3:
                    imagepng($dst_img, $destination);
                    break;
            }

            imagedestroy($dst_img); //销毁图片
            imagedestroy($srcim);  //销毁

        }else //图片水印
        {
            if (!file_exists($waterfilename)) {
                return true;
            }
            $imagetype = array("1"=>"gif","2"=>"jpeg","3"=>"png");
            $image_s = getimagesize($destination);
            $iinfo=getimagesize($destination,$iinfo);
            if (!isset($imagetype[$iinfo[2]])) {
                return true;
            }
            $file ="imagecreatefrom".$imagetype[$iinfo[2]];
            if(!function_exists($file))
                return true;
            $simage = $file($destination);
            $image_d = getimagesize($waterfilename);
            if (!isset($imagetype[$image_d[2]])) {
                return true;
            }
            $file ="imagecreatefrom".$imagetype[$image_d[2]];
            if(!function_exists($file))
                return true;
            $simage1 = $file($waterfilename); // 水印文件
            // 合并2个文件
            switch($pos)
            {
                case 'lt': // 左上
                imagecopymerge($simage,$simage1,0,0,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'lc': // 左中
                imagecopymerge($simage,$simage1,0,($image_s[1]-$image_d[1])/2,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'lb': // 左下
                imagecopymerge($simage,$simage1,0,$image_s[1]-$image_d[1],0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'rt': // 右上
                imagecopymerge($simage,$simage1,$image_s[0]-$image_d[0],0,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'rc': // 右中
                imagecopymerge($simage,$simage1,$image_s[0]-$image_d[0],($image_s[1]-$image_d[1])/2,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'rb': // 右下
                imagecopymerge($simage,$simage1,$image_s[0]-$image_d[0],$image_s[1]-$image_d[1],0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'ct': // 中上
                imagecopymerge($simage,$simage1,($image_s[0]-$image_d[0])/2,0,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'cc': // 正中
                imagecopymerge($simage,$simage1,($image_s[0]-$image_d[0])/2,($image_s[1]-$image_d[1])/2,0,0,$image_d[0],$image_d[1],$transparent);
                break;
                case 'cb': // 中下
                imagecopymerge($simage,$simage1,($image_s[0]-$image_d[0])/2,$image_s[1]-$image_d[1],0,0,$image_d[0],$image_d[1],$transparent);
                break;
            }
            // 输出
            $file ="image".$imagetype[$iinfo[2]];
            $file($simage,$destination);
            imagedestroy($simage);
            imagedestroy($simage1);
        }
    }

    //将16位进制色转换成三原色
    public function Hex2Rgb($hexColor) {

    $color = str_replace('#', '', $hexColor);
    if (strlen($color) > 3) {
    $rgb = array(
    'r' => hexdec(substr($color, 0, 2)),
    'g' => hexdec(substr($color, 2, 2)),
    'b' => hexdec(substr($color, 4, 2))
    );
    } else {
    $color = str_replace('#', '', $hexColor);
    $r = substr($color, 0, 1) . substr($color, 0, 1);
    $g = substr($color, 1, 1) . substr($color, 1, 1);
    $b = substr($color, 2, 1) . substr($color, 2, 1);
    $rgb = array(
    'r' => hexdec($r),
    'g' => hexdec($g),
    'b' => hexdec($b)
    );
    }

    return $rgb;
    }

}


?>