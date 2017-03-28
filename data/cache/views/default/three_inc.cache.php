<?php if(!defined('IN_MAINONE')) exit(); ?>
<div class="three_list">
    <div class="cont_list cont_list5">
        <div class="headline">
            <span class="fl">亲情排行榜<i></i></span>
            <!--<a href="###" class="fr">参看更多<i></i></a>-->
        </div>
        <ul class="">
            <?php $tag_obj = Load::load_tag('memorial');if(!is_object($tag_obj)){halt('tag memorial is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memorial (array('catid'=>'1','field'=>'id,userpic,personname,persontype,family_ranking,click_num','order'=>'click_num desc','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 10*($currentPage-1);$url = $request_url;$pagesize = 10;$subpage = 10;$pagenum = count($count);$page = new Pages(10,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memorial (array('catid'=>'1','field'=>'id,userpic,personname,persontype,family_ranking,click_num','order'=>'click_num desc','return'=>'data','from'=>$from,'pagesize'=>'10',));?>
            <?php $n=1;foreach($data AS $key => $val) { $lastIndex= count($data) == $n;?>
            <?php $key++; ?>
            <?php if($key < 4) { ?>
            <li class="active">
                <em><?php echo $key;?></em>
                <?php } else { ?>
            <li class="">
                <em><?php echo $key;?></em>
                <?php } ?>
                <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($val['id']);?>" target="_blank"><?php echo Template::addquote($val['personname']);?> </a>
                <span>亲情值：<?php echo Template::addquote($val['click_num']);?></span>
            </li>
            <?php $n++;} ?>
            
        </ul>
    </div>
    <div class="cont_list">
        <div class="headline">
            <span class="fl">最新祭拜<i></i></span>
            <!-- <a href="###" class="fr">参看更多<i></i></a> -->
        </div>
        <ul class="">
            <?php $newjibai = newjibai(); php ;?>
            <?php $n=1;foreach($newjibai AS $k => $v) { $lastIndex= count($newjibai) == $n;?>
            <li>
                <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($v['mid']);?>" target="_blank"><?php echo Template::addquote($v['username']);?>祭拜了<?php echo Template::addquote($v['memorial_name']);?>纪念馆 </a>
                <span><?php echo wordTime($v['addtime']);?></span>
            </li>
            <?php $n++;} ?>
        </ul>
    </div>
    <div class="cont_list cont_list3">
        <div class="headline">
            <span class="fl">推荐馆<i></i></span>
            <!-- <a href="###" class="fr">参看更多<i></i></a> -->
        </div>
        <div class="three_tj">
            <!-- 默认先设置为0 功能后续添加 -->
            <?php $tag_obj = Load::load_tag('memo');if(!is_object($tag_obj)){halt('tag memo is exists!');};$getParams = $_GET;if (isset($getParams["page"])) {unset($getParams["page"]);}$params = "";foreach ($getParams as $key => $val) {if (is_string($val)) {$params .= $key."=".$val . "&";}}$request_url = '?&'.$params.'page=$page';$count = $tag_obj -> lib_memo (array('isTop'=>'0','return'=>'data',));$currentPage =  @$_GET["page"] ? $_GET["page"] : 1;$from = 3*($currentPage-1);$url = $request_url;$pagesize = 3;$subpage = 10;$pagenum = count($count);$page = new Pages(3,$pagenum,$url,'page',$currentPage,$subpage);$pagestr = $page->show();$enpagestr = str_replace("首页", "Home", $pagestr);$enpagestr = str_replace("尾页", "Last", $enpagestr);$enpagestr = str_replace("上一页", "Prev", $enpagestr);$enpagestr = str_replace("下一页", "Next", $enpagestr);$pattern = "/第(\s*)(\d*)(\s*)页/i";$replacement = 'Page ${2}';$enpagestr = preg_replace($pattern, $replacement, $enpagestr);$enpagestr = str_replace("共", "Total", $enpagestr);$enpagestr = str_replace("页", "Page", $enpagestr);$pageArr = array(
				"currentPage"=>$page->current_page,
				"pagesize"=>$page->sub_pages,
				"pageNums"=>$page->pageNums,
				"pageUrl"=>$page->pageUrl,
				"count"=>count($count),
				"firstPageUrl"=>$page->firstPageUrl,
				"lastPageUrl"=>$page->lastPageUrl,
				"prewPageUrl"=>$page->prewPageUrl,
				"nextPageUrl"=>$page->nextPageUrl,
			);$data= $tag_obj -> lib_memo (array('isTop'=>'0','return'=>'data','from'=>$from,'pagesize'=>'3',));?>
            <?php $n=1;foreach($data AS $key => $value) { $lastIndex= count($data) == $n;?>
            <a href="/jinian/Jinian/index/mid/<?php echo Template::addquote($value['mid']);?>" target="_blank">
                <img src="<?php echo Template::addquote($value['userpic']);?>" />
                <h5><span><?php echo Template::addquote($value['m_name']);?></span><em><?php echo date('Y-m-d',$value["brithdate"]);?>-<?php echo date('Y-m-d',$value["dieddate"]);?></em></h5>
                <p><?php echo mb_substr($value['descript'],0,15,'utf-8');?></p>
            </a>
            <?php $n++;} ?>
            
        </div>

    </div>
</div>