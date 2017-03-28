<?php

/**
 *
 * 视图类，用于完成对视图文件(仅限html文件)的编译及加载工作
 *
 */

if (!defined('IN_MAINONE')) {
    exit();
}

class Template extends Base {

    /**
     * 视图实例
     *
     * @var object
     */
    protected static $_instance;

    /**
     * 视图目录
     *
     * @var string
     */
    public $viewDir;

    /**
     * 视图编译缓存目录
     *
     * @var string
     */
    public $compileDir;

    /**
     * 模板标签左侧边限字符
     *
     * @var string
     */
    public $leftDelimiter = '{';

    /**
     * 模板标签右侧边限字符
     *
     * @var string
     */
    public $rightDelimiter = '}';

    /**
     * 模板标签右侧边限字符
     *
     * @var string
     */

    public $tagStartWord =  '{mo:';

    /**
     * 模板标签右侧边限字符
     *
     * @var string
     */

    public $tagEndWord =  '{\/mo:';

    /**
     * 模板的类型：默认模板“defalult”
     *
     * @var string
     */

    public static $template_style = null;

    /**
     * 视图缓存文件
     *
     * @var string
     */
    protected $cacheFile;

    /**
     * 构造函数
     *
     * 初始化运行环境,或用于运行环境中基础变量的赋值
     * @access public
     * @return boolean;
     */
    public function __construct($prefix = '') {

        //定义视图目录及编译目录
        $this->viewDir    = DIR_VIEW;
        self::$template_style = $this->getStyle($prefix);
        $this->compileDir = DIR_CACHE . 'views' .DS. self::$template_style.DIRECTORY_SEPARATOR;
    }

    /**
     * 获取模板的风格
     *
     * @access protected
     * @return string    模板风格
     */
    public  function getStyle($prefix = '') {
    	self::$template_style = get_cache($prefix . "template_style","common");
        if(self::$template_style=="")
    	{
    		self::$template_style = DEFAULT_STYLE;
    		set_cache($prefix . "template_style", DEFAULT_STYLE ,"common");
    	}
    	return self::$template_style;
    }

    /**
     * 获取视图文件的路径
     *
     * @access protected
     * @param string $fileName    视图名. 注：不带后缀
     * @return string    视图文件路径
     */
    protected function getViewFile($fileName) {
        $viewFile = strpos($fileName, ".html") ? $this->viewDir . self::$template_style . "/" .$fileName : $this->viewDir . self::$template_style . "/" .$fileName . '.html' ;
        if(is_file($viewFile))
        {
        	return $viewFile;
        }
        else
        {
			require_once DIR_BF_ROOT . 'Application.php';
			app::display404Error();
        	//trigger_error('The view file: ' . $viewFile . ' is not exists!', E_USER_ERROR);
        }
    }

    /**
     * 获取视图编译文件的路径
     *
     * @access protected
     * @param string $fileName 视图名. 注:不带后缀
     * @return string    编译文件路径
     */
    protected function getCompileFile($fileName) {
		$fileName = pathinfo($fileName);
        return $this->compileDir . $fileName['filename'] . '.cache.php';
    }

    /**
     * 生成视图编译文件
     *
     * @access protected
     * @param string $compileFile 编译文件名
     * @param string $content    编译文件内容
     * @return void
     */
    protected function createCompileFile($compileFile, $content)
	{
        //分析编译文件目录
        $compileDir = dirname($compileFile);
        $this->makeDir($compileDir);
        $content = "<?php if(!defined('IN_MAINONE')) exit(); ?>\r\n" . $content;
        file_put_contents($compileFile, $content);
        return @chmod($compileFile, 0777);
     }
    /**
     * 缓存重写分析
     *
     * 判断缓存文件是否需要重新生成. 返回true时,为需要;返回false时,则为不需要
     * @access protected
     * @param string $viewFile        视图文件名
     * @param string $compileFile    视图编译文件名
     * @return boolean
     */
    protected function isCompile($viewFile, $compileFile) {
        if(!file_exists($compileFile)) return true;
        return (filemtime($compileFile) >= @filemtime($viewFile)) ? false : true;
    }

    /**
     * 分析创建目录
     */
    protected function makeDir($dirName) {

        //参数分析
        if (!$dirName) {
            return false;
        }
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        } else if (!is_writable($dirName)) {
            //更改目录权限
            chmod($dirName, 0777);
        }
    }




    /**
     * 加载视图文件
     *
     * 加载视图文件并对视图标签进行编译
     * @access protected
     * @param string $viewFile     视图文件及路径
     * @return string                 编译视图文件的内容
     */
    protected function loadViewFile($viewFile)
	{
        //分析视图文件是否存在
        if (!is_file($viewFile))
		{
            trigger_error('The view file: ' . $viewFile . ' is not exists!', E_USER_ERROR);
        }
        $viewContent = file_get_contents($viewFile);
        //编译视图标签
        return $this->handleViewFile($viewContent);
    }


    /**
     * 编译模板内容
     * @access protected
     * @param string $content     编译视图文件html的内容
     * @return string             编译视图文件的php内容
     */
    function handleViewFile($content)
    {
        
    	$regexArray = array
		(
			'/'.$this->leftDelimiter.'\s*include\s+(.+)\s*'.$this->rightDelimiter.'/iU',  //include
			'/'.$this->leftDelimiter.'\s*php\s?(.+)\s*'.$this->rightDelimiter.'/i',             //php语法：如定义常量

			//if else elseif判断开始
			'/'.$this->leftDelimiter.'\s*if\s?+(.+?)\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*elseif\s?+(.+?)\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*else\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*\/if\s*'.$this->rightDelimiter.'/i',
			//if else elseif判断结束

			//for 循环开始
			'/'.$this->leftDelimiter.'for\s+(.+?)'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\/for'.$this->rightDelimiter.'/i',
			//for 循环结束

			//注：for必须放在++  --前面 ，以免发生冲突

			//++ --开始
			'/'.$this->leftDelimiter.'\+\+(.+?)'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\-\-(.+?)'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'(.+?)\+\+'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'(.+?)\-\-'.$this->rightDelimiter.'/i',
			//++ --结束

			//foreach、循环开始
			'/'.$this->leftDelimiter.'\s*foreach\s+(\S+)\s+(\S+)\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*foreach\s+(\S+)\s+(\S+)\s+(\S+)\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*\/foreach\s*'.$this->rightDelimiter.'/i',
			//foreach、循环结束
            
            //while、循环开始
            '/'.$this->leftDelimiter.'\s*while\s?+(.+?)\s*'.$this->rightDelimiter.'/i',
			'/'.$this->leftDelimiter.'\s*\/while\s*'.$this->rightDelimiter.'/i',
            //while、循环结束

			//echo输出
			'/'.$this->leftDelimiter.'([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))'.$this->rightDelimiter.'/',
			'/'.$this->leftDelimiter.'\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))'.$this->rightDelimiter.'/',
			'/'.$this->leftDelimiter.'(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)'.$this->rightDelimiter.'/',
			'/'.$this->leftDelimiter.'(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)'.$this->rightDelimiter.'/',
			'/'.$this->leftDelimiter.'([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)+'.$this->rightDelimiter.'/s',
			//输出结

			//mo标签
			'/'.$this->tagEndWord.'(\w+)\s*'.$this->rightDelimiter.'/i',

			//izhan标签
			'/{\/izhan:(\w+)\s*'.$this->rightDelimiter.'/i',
    	);

    	///替换直接变量输出
    	$replaceArray = array
		(
			"<?php include Template::t_include(\\1);?>",
			"<?php \\1 ;?>",

			//if else elseif判断开始
			"<?php if(\\1) { ?>",
			"<?php } elseif (\\1) { ?>",
			"<?php } else { ?>",
			"<?php } ?>",
			//if else elseif判断结束

			//for 循环
			"<?php for(\\1) { ?>",
			"<?php } ?>",
			//for 结束

			//++ --开始
			"<?php ++\\1; ?>",
			"<?php --\\1; ?>",
			"<?php \\1++; ?>",
			"<?php \\1--; ?>",
			//++ --结束

			//foreach、循环开始
			"<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",
			"<?php \$n=1;foreach(\\1 AS \\2 => \\3) { \$lastIndex= count(\\1) == \$n;?>",
			"<?php \$n++;} ?>",
			//foreach、循环结束
            //while、循环开始
            "<?php while(\\1) { ?>",
			"<?php } ?>",
            //while、循环结束
			//echo输出
			"<?php echo \\1;?>",
			"<?php echo \\1;?>",
			"<?php echo \\1;?>",
			"<?php echo Template::addquote(\\1);?>",
			"<?php echo \\1;?>",
			//echo输出*/
			"",

			//mo标签
			"",
    	);
    	//对标签进行匹配替换
    	$content = preg_replace($regexArray, $replaceArray, $content);
        $content = preg_replace_callback('/{izhan:(\w+)\s*([^}]*)'.$this->rightDelimiter.'/i','self::izhanTagParse',$content);
        $viewContent = preg_replace_callback('/'.$this->tagStartWord.'(\w+)\s*([^}]*)'.$this->rightDelimiter.'/i','self::mo_tag',$content);
        
        
    	return $viewContent;
    }

    /**
     * 转义 // 为 /
     *
     * @param $var	转义的字符
     * @return 转义后的字符
     */
    public static function addquote($var) {
    	return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
    }

	public static function izhanTagParse ($match)
	{
		/*
		iarticlelist  $tagname, $data, $html  '$1','$2', '$0'
		row=\"10\" size=\"10\" pagevar=\"page\" cid=\"400\" type=\"all\" return=\"data\" order=\"hits desc\" thumb='true'
		{izhan:iarticlelist  row=\"10\" size=\"10\" pagevar=\"page\" cid=\"400\" type=\"all\" return=\"data\" order=\"hits desc\" thumb='true'}
		*/
		//匹配解析标签
    	preg_match_all("/([a-z]+)\=[\'\"]?([^\"\']+)[\"\']?/i", stripslashes($match[2]), $matches, PREG_SET_ORDER);
		/*Array   print_r ($matches);
		(
			[0] => Array
				(
					[0] => order="hits desc"
					[1] => order
					[2] => hits desc
				)

			[1] => Array
				(
					[0] => row='3'
					[1] => row
					[2] => 3
				)

			[2] => Array
				(
					[0] => return='data'
					[1] => return
					[2] => data
				)

			[3] => Array
				(
					[0] => thumb='true'
					[1] => thumb
					[2] => true
				)
		)*/
		$datas = array();
		foreach ($matches as $v)
		{
			$datas[$v[1]] = $v[2];
		}
		$mytag_obj = Load::load_tag($match[1]);     //实例化标签类
		$funname = 'lib_'.$match[1];                //默认执行标签的方法名
		$content = '<?php $tag_obj = Load::load_tag(\''.$match[1].'\');';
		$content .= 'if(!is_object($tag_obj)){halt(\'tag '.$match[1].' is exists!\');}';
		$content .= '$result = $tag_obj -> lib_'.$match[1].' ('.self::arr_to_html($datas).');if(is_array($result)){extract($result,EXTR_OVERWRITE);}if(isset($tag_obj)){unset($tag_obj);}?>';
		return $content;
	}
    /**
     * 解析mo标签
     *
     * @param $tagname	标签名称
     * @param $data	        标签参数
     * @param $html	        参数代码 ：加密后作为缓存的键
     * @return 转义后的字符
     */
    public  static function mo_tag($match)
	{  	
	   //"self::mo_tag('$1','$2', '$0')",$tagname, $data, $html
		//三个参数内容
		/*$tagname = contentlist $match[1]
		$data = order=\"hits desc\" row='3' return='data' thumb='true' $match[2]
		$html = {mo:contentlist  order=\"hits desc\" row='3' return='data' thumb='true'} $match[0]*/

		//匹配解析标签
    	preg_match_all("/([a-z]+)\=[\'\"]?([^\"\']+)[\"\']?/i", stripslashes($match[2]), $matches, PREG_SET_ORDER);
		
    	$datas = array();
    	//可视化条件
    	$tagid = md5(stripslashes($match[0]));
		foreach ($matches as $v)
		{
			$datas[$v[1]] = $v[2];
		}
		$return = isset($datas['return']) ? $datas['return'] : "return";
		$tag_obj = "tag_obj";

		$mytag_obj = Load::load_tag($match[1]);     //实例化标签类
		$funname = 'lib_'.$match[1];                //默认执行标签的方法名
		$content = '<?php $'.$tag_obj.' = Load::load_tag(\''.$match[1].'\');';
		$content  = $content . 'if(!is_object($'.$tag_obj.')){halt(\'tag '.$match[1].' is exists!\');};';
		if(isset($datas['pagesize']))
		{
			$pagesize = $datas['pagesize']; //每页显示的条数
			$subpage = isset($datas['pagenum']) ? $datas['pagenum']:10; //每次显示的页码数
			if($subpage<3)
			{
				$subpage = 10;
			}
			$pagevar = isset($datas["pagevar"]) ? $datas["pagevar"] : 'page';//用来接页码
            $pagereturn = isset($datas["pagereturn"]) ? $datas["pagereturn"] : 'pageArr';//返回数组
			unset($datas['pagevar']);
			unset($datas['pagesize']);
			unset($datas['pagenum']);
			unset($datas['pagereturn']);
			if(isset($datas['cid']))
			{
				$content = $content.'$cid = $_GET["cid"];';
				$content = $content.'$cidinfo = cid2info($cid);';
				$content = $content.'$request_url = getPageUrl($cidinfo,"'.$pagevar.'");';
				//$content = $content.'$request_url = \'?&'.$pagevar.'=$page\';';
			}
			else
			{
                            $content .= '$getParams = $_GET;if (isset($getParams["'.$pagevar.'"])) {unset($getParams["'.$pagevar.'"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}';
			    $content = $content.'$request_url = \'?&'."'.".'$params'.".'".$pagevar.'=$page\';';
			}
			$content = $content . '$count'." = $$tag_obj -> lib_{$match[1]} (".self::arr_to_html($datas).");";
			$content = $content . '$currentPage =  @$_GET["'.$pagevar.'"] ? $_GET["'.$pagevar.'"] : 1;';
			$content = $content . '$from = '.$pagesize.'*($currentPage-1);';
			$content = $content . '$url = $request_url;';
			$content = $content . '$pagesize = '.$pagesize.';';
			$content = $content . '$subpage = '.$subpage.';';
                        $content = $content. '$pagenum = '. (isset($datas['dataindex']) && $datas['dataindex'] ? 'count($count["'.$datas["dataindex"].'"]);' : 'count($count);');
			$content = $content .'$page = new Pages('.$pagesize.',$pagenum,$url,\''.$pagevar.'\',$currentPage,$subpage);';
			$content = $content .'$pagestr = $page->show();';
                        $content = $content . '$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = ' . '\'Page ${2}\'' . ';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);';
			$content = $content .'$'.$pagereturn.' = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);';

			$datas['from'] = '$from';
			$datas['pagesize'] = $pagesize;

			$content = $content . '$'.$return.'= $'.$tag_obj.' -> lib_'.$match[1].' ('.self::arr_to_html($datas).');';
			$content = $content . '?>';
		}
		else
		{
			$content = $content . '$'.$return.' = $'.$tag_obj.' -> lib_'.$match[1].' ('.self::arr_to_html($datas).');?>';
		}
    	return $content;
    }

    /**
     * 将标签参数转为数组
     *
     * @param $tagname	标签名称
     * @param $data	        标签参数
     * @param $html	        参数代码 ：加密后作为缓存的键
     * @return 转义后的字符
     */
    public static  function arr_to_html($data)
	{
    	if (is_array($data)) {
    		$content = 'array(';
    		foreach ($data as $key=>$val) {
    			if (is_array($val)) {
    				$content .= "'$key'=>".self::arr_to_html($val).",";
    			} else {
    				if (strpos($val, '$')===0) {
    					$content .= "'$key'=>$val,";
    				} else {
    					$content .= "'$key'=>'".addslashes($val)."',";
    				}
    			}
    		}
    		return $content.')';
    	}
    	return false;
    }
    /**
     * 显示视图文件
     *
     * @access public
     * @param string $fileName    视图名
     * @return void
     */
    public function display($fileName = null) {
    	return $this->fetch($fileName,false);
    }
    /**
     * 引入视图文件
     *
     * @access public
     * @param string $fileName    视图名
     * @return void
     */
    public static function t_include($fileName = null) {
    	$obj = self::$_instance;
    	return $obj->t_fetch($fileName);
    }

    /**
     * 渲染视图文件
     *
     * @access public
     * @param string $fileName    视图名
     * @param string $return      是否有返回值：true，返回文件内容，flase：返回路径
     * @param string $include     是否编译的是引入文件
     * @return void
     */
    public function fetch($fileName,$return=false)
    {

    	//获取视图文件及编译文件
    	$viewFile      = $this->getViewFile($fileName);
    	$compileFile   = $this->getCompileFile($fileName);
    	//分析视图编译文件是否需要重新生成
    	if ($this->isCompile($viewFile, $compileFile))
		{   
    		$viewContent = $this->loadViewFile($viewFile);
            
			//强制加上铭万版权信息
			/*$name = basename($viewFile);
			$mo_izhan_copyright = get_mo_config('mo_izhan_copyright');
			if(strtolower($mo_izhan_copyright) == 'y')
			{
				$viewContent .= powerbyIzhan();
			}*/
    		//重新生成编译缓存文件
    		$this->createCompileFile($compileFile, $viewContent);
    	}
       	if(!$return)
       	{
       		return $compileFile;
       	}
       	else
       	{
	    	//获取视图编译文件内容
	    	ob_start();
	    	include $compileFile;
	    	$content = ob_get_clean();
	    	if($return)
	    	{
	    		return $content;
	    	}
       	}
    }

    /**
     * 渲染视图文件
     *
     * @access public
     * @param string $fileName    视图名
     * @param string $return      是否有返回值：true，返回文件内容，flase：返回路径
     * @param string $include     是否编译的是引入文件
     * @return void
     */
    public function t_fetch($fileName,$return=false)
    {

    	//获取视图文件及编译文件
    	$viewFile      = $this->getViewFile($fileName);
    	$compileFile   = $this->getCompileFile($fileName);
    	//分析视图编译文件是否需要重新生成
    	if ($this->isCompile($viewFile, $compileFile))
		{
    		$viewContent = $this->loadViewFile($viewFile);
    		//重新生成编译缓存文件
    		$this->createCompileFile($compileFile, $viewContent);
    	}
       	if(!$return)
       	{
       		return $compileFile;
       	}
       	else
       	{
	    	//获取视图编译文件内容
	    	ob_start();
	    	include $compileFile;
	    	$content = ob_get_clean();
	    	if($return)
	    	{
	    		return $content;
	    	}
       	}
    }

    /**
     * 单件模式调用方法
     *
     * @access public
     * @var object
     */
     public static function getInstance($prefix = ''){

        if (!self::$_instance instanceof self) {
            self::$_instance = new self($prefix);
        }
        return self::$_instance;
    }
}