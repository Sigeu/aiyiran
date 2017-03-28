<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * Page.php
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 
 * 
 * @author     佟新华<tongxinhua@mail.b2b.cn>   2012-12-28 下午6:15:53
 * @filename   Page.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class ArrayPage {
	public $totalnum; // 内容总数
	public $pagesize; // 每页行数
	public $pagenum;  // 分页总数
	public $nowpage;  // 当前页码
	public $first;    // 首页
	public $last;     // 末页
	public $uppage;   // 上一页
	public $nextpage; // 下一页
	public $params;   //  获取当前页面的参数
	
	/**
	 * 构造函数
	 * @access   public
	 * @param  $totalnum int 内容总数
	 * @param  $pagesize int 单页数量
	 * @param  $params   string 获取当前页面的参数   
	 */
	public function __construct($totalnum, $pagesize = 10 , $params = "page") 
	{
		$this->totalnum = $totalnum;
		$this->pagesize = $pagesize;
		$this->params = $params;
		$this->nowpage = Controller::getParams($this->params) ? Controller::getParams($this->params) : 1;
		
	}
	
	/**
	 * 计算
	 */
	public function getArray()
	{
		if ($this->totalnum <= $this->pagesize) // 分页不足一页
		{
			$this->pagenum = 1;
		}
		else
		{
			$this->pagenum = ceil ($this->totalnum / $this->pagesize);
		}
		$this->first = 1;
		$this->last = $this->pagenum;
		$this->uppage = $this->nowpage - 1 <= 1 ? 1 : $this->nowpage - 1;
		$this->nextpage = $this->nowpage + 1 >= $this->pagenum ? $this->pagenum : $this->nowpage + 1;
		return object_to_array($this);
	}
	
	/**
	 * 获取分页数据
	 * @param  $data array 内容总数
	 */
	public function getData($data)
	{
		if(!is_array($data)||empty($data))
		{
			return array();
		}
		else
		{
			$data = array_chunk($data, $this->pagesize ,TRUE);
			return count($data)>$this->nowpage-1 ? $data[$this->nowpage-1] : $data[count($data)-1];
		}
	}
	
	
	
	/**
	 * 返回分页字符串
	 * @access public
	 * @param  string 分页链接:http://xxx.com/id=*【*为分页参数】
	 * @return string 分页字符串
	 */
	public function get_str($link = '', $page = '') 
	{
		$arr = $this->get_arr ( $link, $page );
		$str = '<li><a href="' . $arr ['piror'] . '">上一页</a></li>';
		foreach ( $arr ['lists'] as $key => $value ) 
		{
			$str = $str . '<li><a href="' . $value . '">' . $key . '</a></li>';
		}
		$str = $str . '<li><a href="' . $arr ['next'] . '">下一页</a></li>';
		$str = $str . '<li>共' . $this->page_sum . '页|第' . $this->page . '页</li>';
		return $str;
	}
} 
