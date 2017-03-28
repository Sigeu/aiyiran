<?php
/*
*  -------------------------------------------------
*   @file		: MoPage.php
*   @function	: 分页类 即插即用的类
*   @link		: http://www.izhancms.com
*   @copyright	: 2012-07-6 izhancms Inc
*   @author		: <leishaojin@b2b.mainone.cn>
*   @date		: 2013-07-8
*   @update		:
*  -------------------------------------------------
*/
class MoPage
{
	private $search      = array();	 //搜索条件参数
	private $cur_page    = 1;	     //当前第几页
	private $page_size   = 10;       //默认一页显示10条信息
	private $counts      = 0;		 //总共多少条记录
	private $pages       = 0;		 //总共多少页
	private $page_flag   = 'pg';     //页面标记
	private $show_pages  = 5;        //显示多少个页码
	private $from        = 0;        //查询起始位置
	private $dis_page    = array(1); //显示的页码
	private $page_number = array();  //所有页码
	private $max_page    = 0;        //最大页码
	private $conf;			         //配置
	public  $base_url    = '';
	private $param = array();
	public  $page_style='page';
	function __construct($conf=array())
	{
		/**
		 * 初始化配置分类
		 * @param 配置项允许的配置项有 array('search','counts','page_flag','show_pages','page_size')
		 */
		if(!empty($conf))
		{
			$allow_conf = array('search','counts','page_flag','show_pages','page_size','page_style');
			foreach ($conf as $key => $val)
			{
				if(in_array($key,$allow_conf) && isset($this->$key))
					$this->$key = $val;
			}
		}

		$this->show_pages = intval($this->show_pages);
		if($this->show_pages < 3)
			$this->show_pages = 5;
		$this->page_size = intval($this->page_size);
		if($this->page_size <= 0)
			$this->page_size = 10;
		$this->counts = intval($this->counts);

		$this->setCurrentPage();
		$this->setPages();
		$this->setPage();
		$this->setLimitFrom();
	}

	/**
	 * 设置当前页码
	 */
	private function setCurrentPage()
	{
		if(isset($_REQUEST[$this->page_flag]))
			$this -> cur_page = intval($_REQUEST[$this->page_flag]);

		if($this -> cur_page <= 0)
			$this -> cur_page = 1;
	}

	/**
	 * 计算总共有多少页
	 */
	private function setPages ()
	{
		$this->pages = ceil($this->counts/$this->page_size);
		if(($this -> cur_page > $this->pages) && ($this->pages != 0))
			$this -> cur_page = $this->pages;
	}

	/**
	 * 设置总页码
	 */
	private function setPage ()
	{
		for ($i=1;$i<=$this->pages;$i++)
			$this->page_number[$i] = $i;
		if(!empty($this->page_number))
			$this -> max_page = max($this->page_number);
		$this->splitPageNumber();
	}

	/**
	 * 分页显示页码范围
	 */
	private function splitPageNumber ()
	{
		$this->dis_page = array_slice($this->page_number,0,$this->show_pages,true);
		if($this->pages > $this->show_pages)
		{
			$half = ceil(($this->show_pages - 1)/2);//一半
			$middle = current(array_slice($this->page_number,$half,1,true));//取中间值

			if($this->cur_page > $middle)
			{
				 $from = $this->cur_page - $half -1;
				 $this->dis_page = array_slice($this->page_number,$from,$this->show_pages,true);
			}

			if(max($this->dis_page) == $this -> max_page)
				$this->dis_page = array_slice($this->page_number,-$this->show_pages,$this->show_pages,true);
		}
	}

	/**
	 * 设置查询的起始条件
	 */
	private function setLimitFrom ()
	{
		$this->from = ($this->cur_page -1) * $this->page_size;
	}

	/**
	 * 获取搜索条件
	 */
	public function getSearch ()
	{
		return $this->search;
	}

	/**
	 * 获取当前页
	 */
	public function getPage ()
	{
		return $this->cur_page;
	}

	/**
	 * 获取总页数
	 */
	public function getPages ()
	{
		return $this->pages;
	}

	/**
	 * 获取页码标识
	 */
	public function getPageFlag ()
	{
		return $this->page_flag;
	}

	/**
	 * 获取查询起始条件
	 */
	public function getFrom ()
	{
		return $this->from;
	}

	/**
	 * 获取显示的页码
	 */
	public function getShowsPage ()
	{
		return $this->dis_page;
	}

	/**
	 * 获取所有页码
	 */
	public function getAllPage ()
	{
		return $this->page_number;
	}

	/**
	 * 获取第一页
	 */
	public function getFirst ()
	{
		return 1;
	}

	/**
	 * 获取最后一页
	 */
	public function getEnd ()
	{
		return $this->max_page;
	}

	/**
	 * 获取limit字符串
	 * @param
	 * @return null
	 */
	public function getLimit ()
	{
		return ' LIMIT '.$this->from.','.$this->page_size;
	}

	public function setUrl ($url='',$param=array())
	{
		$this->base_url = $url;
	}

	public function setParam ($param=array())
	{
		$this->param = $param;
	}

	public function getUrl ()
	{
		return $this->base_url;
	}

	public function getParam ()
	{
		return $this->param;
	}

	public function getAllParam ()
	{
		return array_merge($this->getSearch(),$this->getParam());
	}

	/**
	 * 获取大部分的基本信息
	 * @return array
	 */
	public function getPageInfo ()
	{
		return array(
			'page'=>$this->cur_page,
			'pages'=>$this->pages,
			'size'=>$this->page_size,
			'counts'=>$this->counts,
			'flag'=>$this->page_flag,
			'dis'=>$this->dis_page,
			'all'=>$this->page_number,
			'first'=>1,
			'end'=>$this->max_page,
			'url'=>$this->getUrl(),
			'param'=>$this->getAllParam(),
		);
	}
}

//用法
//$p = new MiniPage(array('counts'=>100));
?>