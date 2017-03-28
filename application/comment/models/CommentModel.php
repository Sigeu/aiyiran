<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CommentModel.php
 *
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 *
 *
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2013-3-11 下午5:22:39
 * @filename   CommentModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class CommentModel extends Model
{
	public $tableName = 'comment';

	/**
	判断是否可以提交
	 * @param string $content 内容
	 * @return string 返回值
	 */
	public function  isSubmit($content)
	{
		if(empty($content))
		{
			return true;
		}
		$replacestr = get_mo_config('mo_replacer');
		$type = get_mo_config('mo_replace_type');
		$str = get_mo_config('mo_replacestr');
		if(!$str||$type!=3)
		{
			return true;//允许提交
		}
		else
		{

			$repArr = explode(';',$str);
			foreach($repArr as $key=>$value)
			{
				if(preg_match('/'.$value.'/',$content,$match))
				{	if(!empty($match))
					{
						return $match[0];//返回敏感词
					}
				}
			}
			//没有敏感词，提交
			return true;
		}
	}

    /**
	  过滤敏感词
	 * @param string $content 内容
	 * @return string 返回值
	 */
	public function replacestr($content)
	{
		$replacestr = get_mo_config('mo_replacer');
		$type = get_mo_config('mo_replace_type');
		$str = get_mo_config('mo_replacestr');
		if($type==3)
		{
			;
		}
		elseif($type==2)
		{

			$repArr = explode(';',$str);
			foreach($repArr as $key=>$value)
			{
				$content = str_replace($value,'',$content);
			}
		}
		else
		{
			$repArr = explode(';',$str);
			foreach($repArr as $key=>$value)
			{
				$content = str_replace($value,$replacestr,$content);
			}
		}
		return $content;//允许提交
	}


}