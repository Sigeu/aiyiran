<?php if(!defined('IN_MAINONE')) exit(); ?>
<?php include Template::t_include('head.html');?>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>/bzyp.css" />
<script type="text/javascript" src="<?php echo JS_PATH;?>/public.js" ></script>
<script type="text/javascript">
	$(function(){
		$(".classify span").click(function(){
			$(".classify p").toggleClass("active")
		})
	})
</script>
        <!--**************************************-->		
        <div class="box_cont clearfix">
            <div class="chose_cp clearfix">
            	<div class="have_sel" >
            		<b>已选择：</b> <a href="###" ><?php if($category_name) { ?><?php echo Template::addquote($category_name['sortname']);?><?php } else { ?>所有<?php } ?><i></i></a>
            	</div>
            	<div class="classify clearfix">
            		<b>产品类别：</b>
            		<p>
                    <?php $tag_obj = Load::load_tag('goodssort');if(!is_object($tag_obj)){halt('tag goodssort is exists!');};$data = $tag_obj -> lib_goodssort (array('type'=>'all','order'=>'sortid','return'=>'data',));?>
                        <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?> 
                        <a href="?category=<?php echo Template::addquote($value['sortid']);?>"><?php echo Template::addquote($value["sortname"]);?></a>
                        <?php $n++;} ?>
                    
	            		
            		</p>
            		<span></span>
            	</div>
            </div>	
            <div class="list_szwp clearfix">
            	<ul class="wp_list clearfix">
               <?php $tag_obj = Load::load_tag('goods');if(!is_object($tag_obj)){halt('tag goods is exists!');};$cid = $_GET["cid"];$cidinfo = cid2info($cid);$request_url = getPageUrl($cidinfo,"page");$count = $tag_obj -> lib_goods (array('cid'=>'290','category'=>$category,'order'=>'brandid','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 15*($currentPage-1);$url = $request_url;$pagesize = 15;$subpage = 10;$pagenum = count($count);$page = new Pages(15,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_goods (array('cid'=>'290','category'=>$category,'order'=>'brandid','return'=>'data','from'=>$from,'pagesize'=>'15',));?>
                    <?php if(!empty($data)) { ?>
                    <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?> 

            		<li>
            			<a href="<?php echo Template::addquote($value['url']);?>">
            				<img src="/static/uploadfile/goods/<?php echo Template::addquote($value['photo'][0]['photo']);?>" alt="<?php echo Template::addquote($value["goodsname"]);?>" title="<?php echo Template::addquote($value["goodsname"]);?>" />
            				<p><?php echo Template::addquote($value["goodsname"]);?></p>
            			</a>
            		</li>
                     <?php $n++;} ?>
                        <?php } else { ?>
                      没找到信息，请稍后再试
                     <?php } ?>
                

            	</ul>
            	<div class="page">
		     		<?php echo $pagestr;?>

		     	</div>
                <!-- 分页样式修改 -->
<script type="text/javascript">
  $(".page_jump").remove();
  $(".page a").css("width","50px");
  $(".page .focus").addClass('active');
</script>

            </div>
            <div class="link_exchange">
				<span>友情链接：</span><a href="###">中国民政部</a>  
				<a href="###">中国殡葬协会  </a>  
				<a href="###">国际殡葬协会 </a>  
				<a href="###">中国文明网  </a>  
				<a href="###">中国红十字会  </a>  
				<a href="###">中华慈善总会 </a>  
				<a href="###">中国文化部  </a>  
				<a href="###">清明网  </a>  
				<a href="###">中国历史  </a>  
				<a href="###">39心理网  </a>  
				<a href="###">农历网  </a>  
				<a href="###">安康视窗  </a>  
				<a href="###">徐州民生网</a>  
			</div>
        </div>
        <!--**************************************-->		
<?php include Template::t_include('head_footer.html');?>
