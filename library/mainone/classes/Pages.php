<?php  
class Pages{  
   public  $each_disNums ;//每页显示的条目数  
   public  $nums;//总条目数  
   public  $current_page;//当前被选中的页  
   public  $sub_pages;//每次显示的页数  
   public  $pageNums;//总页数  
   public  $page_array = array();//用来构造分页的数组  
   public  $subPage_link;//每个分页的链接  
   public  $subPage_type;//显示分页的类型  
   public  $pageVar;//分页变量
   public  $pageUrl = array();//分页的数组,键值是页面，值是链接地址
   public  $firstPageUrl;//首页的链接地址
   public  $lastPageUrl;//尾页的链接地址
   public  $prewPageUrl;//上一页的链接地址
   public  $nextPageUrl; //下一页的链接地址
   /* 
   __construct是SubPages的构造函数，用来在创建类的时候自动运行. 
   @$each_disNums   每页显示的条目数 
   @nums     总条目数 
   @current_num     当前被选中的页 
   @sub_pages       每次显示的页数 
   @subPage_link    每个分页的链接 
   @subPage_type    显示分页的类型 

      当@subPage_type=1的时候为普通分页模式 
   example：   共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页] 
      当@subPage_type=2的时候为经典分页样式 
   example：   当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
   */ 

  function __construct($each_disNums = 10 ,$nums,$subPage_link,$pageVar='page',$current_page=1,$sub_pages =10,$subPage_type = 2)
  {  	
    $this->each_disNums=intval($each_disNums);
    $this->nums=intval($nums); 
	$current_page = @$_GET[$pageVar] ? intval($_GET[$pageVar]) : 1;
    $this->current_page=intval($current_page);  
    $this->sub_pages=intval($sub_pages);  
	$this->pageVar=$pageVar; 
    $this->pageNums=ceil($nums/$each_disNums);

	if($this->current_page>$this->pageNums) {
       $this->current_page = $this->pageNums;
    }
    $this->subPage_link=$subPage_link;   
       
    //echo $this->pageNums."--".$this->sub_pages;  
  }  

  function show()
  {
     return $this->show_SubPages(2); 
  }

  /* 
    __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。 
   */ 
  function __destruct(){  
    unset($each_disNums);  
    unset($nums);  
    unset($current_page);  
    unset($sub_pages);  
    unset($pageNums);  
    unset($page_array);  
    unset($subPage_link);  
    unset($subPage_type); 
	unset($page_var);  
   }  
  
  /* 
    show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页   
   */ 

  function show_SubPages($subPage_type)
  {  
    if($subPage_type == 1)
    {  
      return $this->subPageCss1();  
    }
    elseif ($subPage_type == 2)
    {  
      return $this->subPageCss2();
    }  
   }  

  /* 

    用来给建立分页的数组初始化的函数。 

   */ 

  function initArray()
  {  
	$nowCoolPage = ceil($this->current_page/$this->sub_pages);
    for($i=0;$i<$this->sub_pages;$i++)
    {  
		$this->page_array[$i] = ($nowCoolPage-1)*$this->sub_pages+$i;
        //保证linkpage保持当前页不是最后一个
		if($this->current_page%$this->sub_pages ==0 ){
			$this->page_array[$i] = ($nowCoolPage-1)*$this->sub_pages+$i+$this->sub_pages-1;
		}
    }  	
    return $this->page_array;  
  }        
  /* 
    construct_num_Page该函数使用来构造显示的条目 
         即使：[1][2][3][4][5][6][7][8][9][10] 
   */ 
  function construct_num_Page()
  {  
    if($this->pageNums < $this->sub_pages)
    {  
      $current_array=array();  
      for($i=0;$i<$this->pageNums;$i++)
      {   
        $current_array[$i]=$i+1;  
      }  
    }
    else
    {  
       $current_array=$this->initArray();  
       if($this->current_page <= 3)
       {  
           for($i=0;$i<count($current_array);$i++)
           {  
             $current_array[$i]=$i+1;  
           }  
       }
       elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1 )
       {  
     	
          for($i=0;$i<count($current_array);$i++)
          {  
             $current_array[$i]=($this->pageNums)-($this->sub_pages)+1+$i;  
          }  
        }
        else
        {  
           for($i=0;$i<count($current_array);$i++)
           {  
             $current_array[$i]=$this->current_page-2+$i;  
           }  
         }  
     }  	
     return $current_array;  
   }  
  /* 
   构造普通模式的分页 
   共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页] 
   */ 

  function subPageCss1()
  {  
   $subPageCss1Str="";  
   //$subPageCss1Str.="共".$this->nums."条记录，";  
   //$subPageCss1Str.="每页显示".$this->each_disNums."条，";  
   //$subPageCss1Str.="当前第".$this->current_page."/".$this->pageNums."页 ";  
   if($this->current_page > 1)
   {  
      
      $firstPageUrl = $this->firstPageUrl=str_replace('$page',"1",$this->subPage_link);  
      $prewPageUrl = $this->prewPageUrl=str_replace('$page',$this->current_page-1,$this->subPage_link);

      $subPageCss1Str.="<a href='$firstPageUrl'>首页</a> ";  
      $subPageCss1Str.="<a  class='decr' href='$prewPageUrl'>上一页</a> ";  
    }
    else 
    {  
      $subPageCss1Str.="<a href='#'>首页</a>  ";  
      $subPageCss1Str.="<a  class='decr' href='#'>上一页</a>  ";  
    }      
    if($this->current_page < $this->pageNums)
    {  
		$lastPageUrl = $this->lastPageUr = str_replace('$page',$this->pageNums,$this->subPage_link);  
        $nextPageUrl = $this->nextPageUrl=str_replace('$page',$this->current_page+1,$this->subPage_link);
	    $lastPageUrl = $subPageCss1Str.=" [<a href='$nextPageUrl'>下一页</a>] ";  
	    $subPageCss1Str.="[<a href='$lastPageUrl'>尾页</a>] ";  
    }
    else 
    {  
       $subPageCss1Str.="[下一页] ";  
       $subPageCss1Str.="[尾页] ";  
    }  
    return $subPageCss1Str;  
   }  

     

     

  /* 

   构造经典模式的分页 

   当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 

   */ 

  function subPageCss2()
  {  
    $subPageCss2Str='<div class="page_go"> <div class="pages mr43">';
	$subPageCss2Str.='<div class="page_jump"> 跳转至
                <input type="text" onblur="javascript:go_page(this);" value="'.$this->current_page.'">
                页 </div>';
	 $subPageCss2Str.='<script>function go_page(obj){var val=$(obj).val();}</script>';
	 $subPageCss2Str.='<script>
					function go_page(obj)
					{
						var val = $(obj).val() - 0;
						if(isNaN(val)||val<1){val = 1;}
						var url = \''.$this->subPage_link.'\';
						if(val>'.$this->pageNums.')
						{
							var url = url.replace(\'$page\','.$this->pageNums.');
						}
						else
						{
							var url = url.replace(\'$page\',val);
						}
                        window.location.href = url;
						
					}
				</script>';
     //$subPageCss2Str.="当前第".$this->current_page."/".$this->pageNums."页 ";  
     if($this->current_page > 1)
     {  
       $firstPageUrl =  $this->firstPageUrl=str_replace('$page',"1",$this->subPage_link);  
       $prewPageUrl =   $this->prewPageUrl = str_replace('$page',$this->current_page-1,$this->subPage_link);

       $subPageCss2Str.="<a  class='decr' href='$firstPageUrl'>首页</a> ";  
       $subPageCss2Str.="<a  class='decr' href='$prewPageUrl'>上一页</a> ";  
    }
    else 
    {  
	  $this->prewPageUrl = "#";
	  $this->firstPageUrl = "#";
      $subPageCss2Str.="<a href='#'>首页</a>  ";  
      $subPageCss2Str.="<a   href='#'>上一页</a>  ";  
    }      
    $a=$this->construct_num_Page();
	$pageUrl = array();
    for($i=0;$i<count($a);$i++)
    {  
       $s=$a[$i];  
	   $pageUrl[$s] = str_replace('$page',$s,$this->subPage_link);  
       if($s == $this->current_page )
       {  
          $subPageCss2Str.= '<a href="'.$pageUrl[$s].'" class="focus">'.$s.'</a>';  
       }
       else
       {  
          $subPageCss2Str.="<a href=".$pageUrl[$s].">".$s."</a>";  
       }  
    }  
	$this->pageUrl = $pageUrl;
    if($this->current_page < $this->pageNums)
    {  
       $lastPageUrl = $this->lastPageUrl=str_replace('$page',$this->pageNums,$this->subPage_link);  

       $nextPageUrl = $this->nextPageUrl=str_replace('$page',$this->current_page+1,$this->subPage_link);

       $subPageCss2Str.=" <a class='decr' href='$nextPageUrl'>下一页</a> ";  
       $subPageCss2Str.="<a class='decr' href='$lastPageUrl'>尾页</a> ";  
    }
    else 
    {  
	   $this->nextPageUrl = '#';
	   $this->lastPageUrl = '#';
       $subPageCss2Str.=" <a  href='#'>下一页</a>  ";  
       $subPageCss2Str.="<a href='#'>尾页</a>  ";  
    }  
    $subPageCss2Str .='</div></div>';  
    return $subPageCss2Str;  
   }  
}  

?>