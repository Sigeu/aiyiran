<?php

/**
 * Project:     Securimage: A PHP class for creating and managing form CAPTCHA images<br />
 * File:        securimage_show.php<br />
 *
 * Copyright (c) 2011, Drew Phillips
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.<br /><br />
 *
 * If you found this script useful, please take a quick moment to rate it.<br />
 * http://www.hotscripts.com/rate/49400.html  Thanks.
 *
 * @link http://www.phpcaptcha.org Securimage PHP CAPTCHA
 * @link http://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link http://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2012 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
 * @version 3.2RC2 (April 2012)
 * @package Securimage
 *
 */

// Remove the "//" from the following line for debugging problems
// error_reporting(E_ALL); ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/securimage.php';
require_once  'db.php';
$mo_captcha_type = get_mo_config('mo_captcha_type');
if($mo_captcha_type=='letter')
{
	$options['charset'] = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz';
}
else if($mo_captcha_type == 'number')
{
	$options['charset'] = '0123456789';
}
else
{
	$options['charset'] = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz23456789';
}
$mo_color_rand = get_mo_config('mo_color_rand');
if($mo_color_rand == 'Y')
{
	$d='';
	 for($a=0;$a<6;$a++){    //����#FFFFFF������
       $d.=dechex(rand(0,15));//�ۼ����������--dechex()��ʮ���Ƹ�Ϊʮ������
    }
	$options['text_color'] = '#'.$d;
}
else
{
	$options['text_color'] = '#0000CC';
}

$mo_color_rand = get_mo_config('mo_lean_rand');
if($mo_color_rand == 'Y')
{
	$options['perturbation'] =  substr(mt_rand() / mt_getrandmax(),0,3);
}
else
{
	$options['perturbation'] =  0;
}
$img = new Securimage($options);
// You can customize the image by making changes below, some examples are included - remove the "//" to uncomment
//$img->ttf_file        = './Quiff.ttf';
//$img->captcha_type    = Securimage::SI_CAPTCHA_MATHEMATIC; // show a simple math problem instead of text
//$img->case_sensitive  = true;                              // true to use case sensitve codes - not recommended
$img->image_height    = 40;                                // width in pixels of the image
$img->image_width     = 100;                                // a good formula for image size
//$img->image_bg_color  = new Securimage_Color("#0099CC");   // image background color
//$img->text_color      = new Securimage_Color("#EAEAEA");   // captcha text color
$img->num_lines       = 0;                                 // how many lines to draw over the image
$img->code_length     = 4;                                 // The length of the captcha code
//$img->line_color      = new Securimage_Color("#0000CC");   // color of lines over the image
//$img->image_type      = SI_IMAGE_JPEG;                     // render as a jpeg image
//$img->signature_color = new Securimage_Color(rand(0, 64),
//                                             rand(64, 128),
//                                             rand(128, 255));  // random signature color

// see securimage.php for more options that can be set



$img->show();  // outputs the image and content headers to the browser
// alternate use:
// $img->show('/path/to/background_image.jpg');
