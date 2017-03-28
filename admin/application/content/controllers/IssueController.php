<?php
/**
 * MainOneCms 铭万开源CMS内容管理系统  (http://cms.b2b.cn)
 *
 * 后台 内容管理 发布设置  更新静态文件
 *
 * @author     黄利科 <huanglike@mail.b2b.cn>
 * @filename   IssueController.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://cms.b2b.cn/license/   MainOneCms 1.0
 * @version    SVN:
 * @link       http://cms.b2b.cn
 * @link       http://www.b2b.cn
 * @package
 * @since      1.0.0
 */

class IssueController extends AdminController
{
    public $IssueModel;
	public function init ()
	{
		$this -> IssueModel = D('IssueModel');
	}
	/**
	 * 发布设置
	 */
	public function indexAction ()
	{
		$this->display('content/issue/index');
	}

    /* 生成首页 */
    public function createIndexAction ()
    {
        ob_start();
        $filename = "index.html";
		@unlink("../" . $filename);
        $static = file_get_contents("http://$_SERVER[HTTP_HOST]");
        echo $static . '<script type="text/javascript">
document.write( "<img src=\'"http://' . $_SERVER[HTTP_HOST]  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
        $text = ob_get_contents();
        ob_end_clean();
        $content = fopen($filename, "w");
        fwrite ($content,$text);
        fclose ($content);
        $size = floor(filesize($filename) / 1024);
        if(file_exists("../" . $filename)) {
            @unlink("../" . $filename);
        }
        @rename($filename, "../" . $filename);
        $this->dialog('/content/issue/index','success',"首页更新成功！此次更新：". $size ." KB");
    }

    /* 生成内容页 */
	public function contentAction ()
	{
        $model = $this->IssueModel->getAbleModel();  //模型列表
        $cat = $this -> getCategoryModel() -> getCategoryTree();
        $this->assign('cat', $cat);
        $this->assign('model', $model);
		$this->display('content/issue/change');
	}

	public function getCategoryModel ()
	{
		return D('CategoryModel');
	}

    /* 生成栏目页 */
	public function columnAction ()
	{
        $model = $this->IssueModel->getAbleModel();  //模型列表
        $cat = $this -> getCategoryModel() -> getCategoryTree();
        $this->assign('cat', $cat);
        $this->assign('model', $model);
		$this->display('content/issue/update');
	}

    //批量更新栏目静态页
    public function updateAllCategoryAction()
    {
        $whole = $this->IssueModel->getStaticCategories(); //获取全部需要静态页的栏目
        foreach ($whole AS $val){
            $path = '../html/'.$val['filepath'].'/';
            $dirs = explode('/',$path);
            $pos = strrpos($path, ".");
            if ($pos === false) {
                $subamount=0;
            }
            else {
                $subamount=1;
            }
            for ($c=0; $c < count($dirs) - $subamount; $c++) {
                $thispath="";
                for ($cc=0; $cc <= $c; $cc++) {
                    $thispath.=$dirs[$cc].'/';
                }
                if (!file_exists($thispath)) {
                    @mkdir($thispath, $mode = 0777);
                }
            }
            ob_start();
            $filename = "index.html";
            $static = file_get_contents(HOST_NAME . "category/Category/index/cid/$val[id]");
            echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'category/Category/index/cid/' . $val[id]  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
            $text = ob_get_contents();
            ob_end_clean();
            $con = fopen($filename, "w");
            fwrite ($con,$text);
            fclose ($con);
            @rename($filename, $path . $filename);
        }
        $this->dialog('/content/issue/column','success',"更新成功！");
    }

    //批量更新文章、内容静态页
    public function updateAllArticleAction()
    {
        $all = $this->IssueModel->getStatics();
        foreach ($all AS $val){
            $time = date("Y/m/d",$val['publishtime']);
            $path = '../html/'.$val['filepath'].'/'.$time.'/';
            $dirs = explode('/',$path);
            $pos = strrpos($path, ".");
            if ($pos === false) {
                $subamount=0;
            }
            else {
                $subamount=1;
            }
            for ($c=0; $c < count($dirs) - $subamount; $c++) {
                $thispath="";
                for ($cc=0; $cc <= $c; $cc++) {
                    $thispath.=$dirs[$cc].'/';
                }
                if (!file_exists($thispath)) {
                    @mkdir($thispath, $mode = 0777);
                }
            }
            if ($val['mid'] != 2) {
                $page_count = $this->getArticlePageCount ($val['content']);
                $this->updateStaticArticle ($val['id'], $path, $page_count);
            } else {
                $this->updateStaticGoods ($val['id'], $path);
            }
        }
        $this->dialog('/content/issue/content','success',"更新成功！");
    }


    //更新选中的一些栏目下的文章
    public function updateOneCategoryAction() {
        $upchild = $_POST['change'];
        $cids = $_POST['ray'];
        if (!empty($upchild)) {
            $cids = $this->IssueModel->addChildCids($cids);
        }
        $need = $this->IssueModel->getStatics($cids); //获取相应栏目文章
        foreach ($need AS $val){
            $time = date("Y/m/d",$val['publishtime']);
            $path = PATH_HTML .$val['filepath'].'/'.$time.'/';
            $dirs = explode('/',$path);
            $pos = strrpos($path, ".");
            if ($pos === false) {
                $subamount=0;
            }
            else {
                $subamount=1;
            }
            for ($c=0; $c < count($dirs) - $subamount; $c++) {
                $thispath="";
                for ($cc=0; $cc <= $c; $cc++) {
                    $thispath.=$dirs[$cc].'/';
                }
                if (!file_exists($thispath)) {
                    @mkdir($thispath, $mode = 0777);
                }
            }
            
            if ($val['mid'] != 2) {
                $page_count = $this->getArticlePageCount ($val['content']);
                $this->updateStaticArticle ($val['id'], $path, $page_count);
            } else {
                $this->updateStaticGoods ($val['id'], $path);
            }
        }
        $this->dialog('/content/issue/content','success',"更新成功！");
    }
    
    //ajax模型联动栏目
    public function ajaxAction () {
        $ajax = $_REQUEST['m'] ? $_REQUEST['m'] : 0;
        $cat = $this->getCategoryModel()->getCategoryTree();
        $result = '';
        foreach ($cat AS $value){
            $temp = '';
            if(($value['model'] <> $ajax) AND ($ajax <> 0)){
                $temp = ' disabled ';
            }
            $result .="<option value=". $value['id'] . $temp .">" . $value['catname'] ."</option>";
        }
        $str = "<option value='0'>不限栏目</option>";
        if(empty($result)) {
            echo $result;exit();
        }else{
            echo $str.$result;exit;
        }
    }
    
    public function updateStaticArticle ($id, $path, $countnum=null) {
        if (empty($countnum)) {
            return;
        }
        for ($i=1;$i<=$countnum;$i++) {
            ob_start();
            $filename = 'content_'. $id . '_' . $i . '.html';
            $static = file_get_contents(HOST_NAME . "content/Content/index/id/$id/cpage/$i/up_click/0");
            echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'content/Content/index/id/' . $id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
            $text = ob_get_contents();
            ob_end_clean();
            $con = fopen($filename, "w");
            fwrite ($con,$text);
            fclose ($con);
            @rename($filename, $path . $filename);
        }
    }
    
    public function updateStaticGoods ($id, $path) {
        ob_start();
        $filename = "goods_". $id .".html";
        $static = file_get_contents(HOST_NAME . "goods/Goods/info/id/$id");
        
        echo $static . '<script type="text/javascript">
document.write( "<img src=\'' .HOST_NAME . 'goods/Goods/info/id/' . $id  . '\' style=\'display:none\'/>" );//访问动态地址
</script>';
        
        $text = ob_get_contents();
        ob_end_clean();
        $con = fopen($filename, "w");
        fwrite ($con,$text);
        fclose ($con);
        @rename($filename, $path . $filename);
    }
    
    public function getArticlePageCount ($content = '') {
        $countnum = 1;
        $pageConfig = get_mo_config('mo_arcautosp');
        if($pageConfig == 'Y') {
            $pageNum = get_mo_config('mo_arcautosp_sum');//多少个字符分一页
            $contentpage = new ContentPage();
            $mycontent = $contentpage->get_data($content, $pageNum);
            $mycontents = array_filter(explode('[page]',$mycontent));
            $countnum = count($mycontents);
            $countnum = empty($countnum) ? 1 : $countnum;
        }
        return $countnum;;
    }
}