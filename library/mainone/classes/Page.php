<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * Page.php
 *
 * 分页工具类
 *
 * @author     王蕊<wangrui@mail.b2b.cn>   2013-1-6 下午2:46:20
 * @filename   Page.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class Page{
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 10;
	// 起始行数
    public $firstRow;
    // 分页总页面数
    protected $totalPages;
    // 总行数
    protected $totalRows;
    // 当前页数
    protected $nowPage;
	// 分页的栏的总页数
    protected $coolPages;
	//是否显示linkpage
	protected $isShowLinkPage = FALSE;
	//是否显示输入页数跳转
	public $isJumpPage = TRUE;
	//是否使用Ajax,默认不使用
	public $AjaxType = FALSE;
	//JavaScript中使用的获取数据方法名
	public $function_name = 'ajax_page';
	// 分页显示定制
   protected $config = array(
                              'header'=>'条记录',
                              'prev'=>'上一页',
                              'next'=>'下一页',
                              'first'=>'首页',
                              'last'=>'末页',
                              'theme'=>' 共<em>%totalRow%</em>%header%，分<em>%totalPage%</em>页显示，当前第<em>%nowPage%</em>页  %first% %upPage% %linkPage% %downPage% %end% %jump%');
    /**
     * 构造函数
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $rollpage  是否显示linkpage条数
     * @param array $parameter  分页跳转的参数
     */
	public function __construct($totalRows,$listRows='',$rollpage='',$parameter=''){
		$this->totalRows = $totalRows;
        $this->parameter = $parameter;
		$this->varPage = 'p';

		if(!empty($listRows)) {
			$this->listRows = intval($listRows);
		}
        if(!empty($rollpage)) {
            $this->rollPage = intval($rollpage);
        }
		$this->isShowLinkPage = empty($this->rollPage)?false:true;
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
		$this->coolPages  = ceil($this->totalPages/$this->rollPage);

        $this->nowPage = 1;
		if (isset($_GET['page'])&&!empty($_GET['page'])){$this->nowPage = $_GET['page'];}
		if (!empty($_GET[$this->varPage])){$this->nowPage = $_GET[$this->varPage];}

        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);

		$upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;

		$upRow = $upRow>0 ? $upRow : '';
		$downRow = $downRow < $this->totalPages ? $downRow : '';

	}
	/**
     * 设置显示样式
     * @access public
     */
	public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
	/**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = $this->varPage;
		$nowCoolPage      = ceil($this->nowPage/$this->rollPage);
		$request_url = $_SERVER['REQUEST_URI'];

		if(strpos($request_url,'?')){
			$url  =  $request_url;
		}else{
			$url  =  $request_url.'?';
		}

        $parse = parse_url($url);

		if(!isset($parse['query']))
			$parse['query'] = '';
		if(is_array($this -> parameter))
		{
			$parse['query'] .= '&'.http_build_query($this -> parameter);
		}

        if(isset($parse['query']))
		{
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }

        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
			if($this->AjaxType)
				$upPage='<a href=javascript:'.$this->function_name.'('.$upRow.');>'.$this->config['prev'].'</a>';//ajax方式
			else
				$upPage='<a href=\''.$url.'&'.$p.'='.$upRow.'\'>'.$this->config['prev'].'</a>';
        }else{
            $upPage='';
        }

        if ($downRow <= $this->totalPages){
			if($this->AjaxType)
				$downPage='<a href=javascript:'.$this->function_name.'('.$downRow.');>'.$this->config['next'].'</a>';//ajax方式
			else
				$downPage='<a href=\''.$url.'&'.$p.'='.$downRow.'\'>'.$this->config['next'].'</a>';
        }else{
            $downPage='';
        }
        // << < > >>
        if($this->nowPage == 1){
            $theFirst = '';
            $prePage = '';
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
			if($this->AjaxType)
				$theFirst = '<a href=javascript:'.$this->function_name.'(1);>'.$this->config['first'].'</a>';//ajax方式
			else
            	$theFirst = '<a href=\''.$url.'&'.$p.'=1\' >'.$this->config['first'].'</a>';
        }
        if($this->nowPage == $this->totalPages){
            $nextPage = '';
            $theEnd='';
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
			if($this->AjaxType)
				$theEnd = '<a href=javascript:'.$this->function_name.'('.$theEndRow.');>'.$this->config['last'].'</a>';//ajax方式
			else
            	$theEnd = '<a href=\''.$url.'&'.$p.'='.$theEndRow.'\' >'.$this->config['last'].'</a>';
        }
        // 1 2 3 4 5
		if($this->isShowLinkPage){
			$linkPage = '';
        	for($i=1;$i<=$this->rollPage;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            //保证linkpage保持当前页不是最后一个
            if($this->nowPage%$this->rollPage ==0 ){
            	$page = ($nowCoolPage-1)*$this->rollPage+$i+$this->rollPage-1;
            }
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
					if($this->AjaxType)
					{
						$linkPage .= '&nbsp;<a href=javascript:'.$this->function_name.'('.$page.');>&nbsp;'.$page.'&nbsp;</a>';//ajax方式
					}
					else
					{
                    	$linkPage .= '&nbsp;<a href=\''.$url.'&'.$p.'='.$page.'\'>&nbsp;'.$page.'&nbsp;</a>';
					}
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= '&nbsp;<span class=\'currentpage\'>'.$page.'</span>';
                }
            }
       	  }
		}
		//jump page
		if($this->isJumpPage){
			$jump = "  <span>跳转至 <select id='jumppage' name='jumppage' onchange='go_page({$this->nowPage});'>";
		    for ($i=1;$i<=$this->totalPages;$i++)
			{
				if ($i == $this->nowPage)
				{
				    $jump .= "<option value='{$i}' selected>{$i}</option>";
				}else
				{
				    $jump .= "<option value='{$i}'>{$i}</option>";
				}
			}
			$jump .= "</select>页 </span>";
			$jump .='<script>function go_page(page){var jumptopage = document.getElementById(\'jumppage\').value;var topage;';
			$jump .='if(jumptopage==page||isNaN(jumptopage)){return false;}else{ ';
			$jump .='if(jumptopage>'.$this->totalPages.'){topage = '.$this->totalPages.'}';
			$jump .='else if(jumptopage<1){topage = 1;}else{topage = jumptopage;}';
			if($this->AjaxType){
				$jump .= $this->function_name.'(topage);';
			}else{
				$jump .='window.location.href = \''.$url.'&'.$p.'=\'+topage;';
			}
			$jump .='}}</script>';

		}
        $pageStr=str_replace(
        array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%linkPage%','%end%','%jump%'),
        array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$linkPage,$theEnd,$jump),$this->config['theme']);
        return $pageStr;
    }

	public function getTotalPages ()
	{
		return $this -> totalPages;
	}

	public function getTotalRows ()
	{
		return $this -> totalRows;
	}

	public function getNowPage ()
	{
		return $this -> nowPage;
	}

}

