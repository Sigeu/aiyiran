<?php
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 站点地图控制器
 * 
 * 这是站点地图类，负责生成sitemap
 *文件为：sitemaps.xml
 * 
 * 文件修改记录：
 * <br>史天宇  2013-10-14 下午5:28:24 创建此文件 
 * 
 * @author     史天宇 <shitianyu@mail.b2b.cn>  2013-10-14 下午5:28:24
 * @filename   SitemapController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 2.0
 * @version    SVN: $Id$
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class SitemapController extends AdminController {
	
	private $getseoSearch;
	private $categoryModel;//分类模型
	private $goodsModel;//商品模型
	private $specialModel;//专题模型
	private $_sitemap;//Sitemap参数
	private $_urlCount = 0;//生成网址的数量
	private $_maxUrlCount = 50000;//最大网址数量
	private $_createFlag = true;//是否继续生成的标记
	private $_dom;//Sitemap xml dom
	private $_urlset;// Sitemap xml dom根节点
	private $_sitemapsSize;//生成的sitemaps.xml文件的字节数
	
	public function init()
	{
		$this->getseoSearch = M('SeoSearch');	
		//得到category的模型
		$this->categoryModel = D('CategoryModel');
		//得到goods的模型
		$this->goodsModel = D('GoodsModel');
		//得到special的模型
		$this->specialModel = D('SpecialModel');
		parent::init();
	}

	/**
	 * Sitemap设置页
	 * */
	
	public function indexAction()
	{	
		$this->assign('urlhost',URL_HOST);//网站主域名
		$this->assign('url_count',2000);//最大网址数量
		$this->assign('changefreq','Hourly');//最大网址数量
		$this->assign('shouye',0.9);//首页页面权重
		$this->assign('lanmu',0.7);//栏目页页面权重
		$this->assign('liebiao',0.6);//列表页页面权重
		$this->assign('neirong',0.5);//内容页页面权重
		$this->assign('zhuanti',0.7);//专题页页面权重
		
		$this->display('extensions/sitemap/seo_sitemap_index.html');//显示sitemap设置页
	}
	/**
	*Sitemap生成功能
	*/
	public function createAction() {
		//每页最大网址数量
		$this->_sitemap['url_count'] = isset($_POST['url_count']) ? $_POST['url_count'] : '';
		//更新频率
		$this->_sitemap['changefreq'] = isset($_POST['changefreq']) ? $_POST['changefreq'] : '';
		//首页页面权重
		$this->_sitemap['shouye'] = isset($_POST['shouye']) ? $_POST['shouye'] : '';
		//栏目页页面权重
		$this->_sitemap['lanmu'] = isset($_POST['lanmu']) ? $_POST['lanmu'] : '';
		//列表页页面权重
		$this->_sitemap['liebiao'] = isset($_POST['liebiao']) ? $_POST['liebiao'] : '';
		//内容页页面权重
		$this->_sitemap['neirong'] = isset($_POST['neirong']) ? $_POST['neirong'] : '';
		//专题页页面权重
		$this->_sitemap['zhuanti'] = isset($_POST['zhuanti']) ? $_POST['zhuanti'] : '';
		
		$_SESSION['sitemap'] = $this->_sitemap;
		//生成 sitemap
		$this->_sitemap();
		//echo $this->_sitemapsSize;
				
	}
	/**
	 *操作成功 
	 */
	public function successAction() {
		$this->assign('url_count',$_SESSION['sitemap']['url_count']);//最大网址数量
		$this->assign('changefreq',$_SESSION['sitemap']['changefreq']);//更新频率
		$this->assign('shouye',$_SESSION['sitemap']['shouye']);//首页页面权重
		$this->assign('lanmu',$_SESSION['sitemap']['lanmu']);//栏目页页面权重
		$this->assign('liebiao',$_SESSION['sitemap']['liebiao']);//列表页页面权重
		$this->assign('neirong',$_SESSION['sitemap']['neirong']);//内容页页面权重
		$this->assign('zhuanti',$_SESSION['sitemap']['zhuanti']);//专题页页面权重
		$this->assign('urlhost',URL_HOST);//网站主域名
		$this->display('extensions/sitemap/seo_sitemap_index.html');//显示sitemap设置页		
	}
	
	/**
	 * 操作失败
	 */
	public function errorAction() {
		$msg = '生成失败';				
		//操作失败
		$this->dialog('/extensions/sitemap/index','error' , $msg);
	}

     /**
	 * Helper function that removes all child nodes of $node recursively
	 * (i.e. including child nodes of the child nodes and so forth).
	 */
	private function _remove_children(&$node) {
	  while ($node->firstChild) {
	    while ($node->firstChild->firstChild) {
	       $node->firstChild->removeChild($node->firstChild->firstChild);
	    }
	    $node->removeChild($node->firstChild);
	  }
	}
	
	/**
	 * 生成 sitemap
	 */
	private function _sitemap() {
		//创建文档对象
		$this->_dom = new DOMDocument ( '1.0' , 'utf-8');
		//加载xml文件
		$this->_dom->load(PATH_WEB . 'sitemaps.xml');
		//根节点
		$this->_urlset = $this->_dom->documentElement;
		
		//删除根节点下所有的子节点
		$this->_remove_children($this->_urlset);
		
		$this->_urlCount = 0;//开始时生成页数为0
		$this->_createFlag = true;//默认可以继续生成页面
		if ($this->_urlCount >= $this->_sitemap['url_count'] || $this->_urlCount >= $this->_maxUrlCount) {
			$this->_createFlag = false;//如果生成数量达到最大网址数量，则停止生成
		}
		
		//生成首页sitemap
		$this->_index_page();
		//生成栏目页sitemap
		$this->_column_page();
		//生成列表页sitemap
		$this->_list_page();
		//生成内容页sitemap
		$this->_content_page();
		//生成商品页sitemap
		$this->_goods_page();
		//生成 专题页sitemap
		$this->_special_page();
		
		//将dom中的所有数据重新保存到sitemaps.xml文件中
		$this->_sitemapsSize = $this->_dom->save(PATH_WEB . 'sitemaps.xml');
		
		//更新成功
		if($this->_sitemapsSize > 0) {
			$this->dialog('/extensions/sitemap/success','success',
					'更新成功');
		}
		else {//更新失败
			$this->dialog('/extensions/sitemap/index','error',
					'更新失败');
		}
	}
	
	/**
	 * 生成一个url项
	 * @param $loc_str string 该条数据的存放地址
	 * @param $lastmod_str string 指该条数据的最新一次更新时间
	 * @param $changefreq_str string 指该条数据的更新频率
	 * @param $priority_str string 用来指定此链接相对于其他链接的优先权比值，此值定于0.0-1.0之间
	 */
	private function _url_item($loc_str , $lastmod_str , $changefreq_str , $priority_str) {
		
		if ($this->_createFlag == true) {//如果需要继续生成页面
			//创建url节点
			$url = $this->_dom->createElement('url');
			//创建loc节点
			$loc = $this->_dom->createElement('loc',$loc_str);
			//创建lastmode节点
			$lastmod = $this->_dom->createElement('lastmod',$lastmod_str);
			//创建changefreq节点
			$changefreq = $this->_dom->createElement('changefreq', $changefreq_str);
			//创建priority节点
			$priority = $this->_dom->createElement('priority' , $priority_str);
				
			//将loc、lastmod、changefreq、priority节点作为子节点，追加到url节点
			$url->appendChild($loc);
			$url->appendChild($lastmod);
			$url->appendChild($changefreq);
			$url->appendChild($priority);
				
			$this->_urlCount++;//生成的页面数量增加1
			if ($this->_urlCount >= $this->_sitemap['url_count'] || $this->_urlCount >= $this->_maxUrlCount) {
				$this->_createFlag = false;//如果生成数量达到最大网址数量，则停止生成
			}
			//将urlset作为子节点追加到根节点
			$this->_dom->documentElement->appendChild($url);
		}
		
	}
	
	/**
	 * 生成 首页sitemap
	 */
	private function _index_page() {
 		$this->_url_item(URL_HOST,date('Y-m-d'),$this->_sitemap['changefreq'],$this->_sitemap['shouye']);
				
	}

	/**
	*生成 栏目页sitemap
	*/
	private function _column_page() {		
		//获取所有栏目id
		$column_id_list = $this->categoryModel->getChildIdList(0);
		if ($column_id_list) {		
            foreach($column_id_list as $key=>$value) {
                $this->_url_item(URL_HOST . 'category/Category/index/cid/' . $value['id'], date('Y-m-d'), $this->_sitemap['changefreq'], $this->_sitemap['lanmu']);
            }
        }
	}

	/**
	*生成 列表页sitemap
	*/
	private function _list_page() {
		//获取所有列表页id
		$list_id_list = $this->categoryModel->getChildIdList2(0);
		if ($list_id_list) {
            foreach($list_id_list as $key=>$value) {
                $this->_url_item(URL_HOST . 'category/Category/list/cid/' . $value['id'], date('Y-m-d'), $this->_sitemap['changefreq'], $this->_sitemap['liebiao']);
            }
        }
	}

	/**
	*生成 内容页sitemap
	*/
	
	private function _content_page() {
		
		//获取所有文章内容页id
		$content_id_list = $this->categoryModel->getContentIdList();
		if ($content_id_list) {		
            foreach($content_id_list as $key=>$value) {
                $this->_url_item(URL_HOST . 'content/Content/index/id/' . $value['content_id'], date('Y-m-d'), $this->_sitemap['changefreq'], $this->_sitemap['neirong']);
            }
        }
	}

	/**
	*生成 商品页sitemap
	*/
	private function _goods_page() {
		//获取所有文章内容页id
		$goods_id_list = $this->goodsModel->getGoodsIdList();
		if ($goods_id_list) {
            foreach($goods_id_list as $key=>$value) {
                $this->_url_item(URL_HOST . 'goods/Goods/info/id/' . $value['goodsid'], date('Y-m-d'), $this->_sitemap['changefreq'], $this->_sitemap['neirong']);
            }
        }
	}
	
	/**
	 *生成 专题页sitemap
	 */
	private function _special_page() {
		//获取所有文章内容页id
		$special_id_list = $this->specialModel->getSpecialIdList();
        if ($special_id_list) {
            foreach($special_id_list as $key=>$value) {
                $this->_url_item(URL_HOST . 'special/special/index/id/' . $value['id'], date('Y-m-d'), $this->_sitemap['changefreq'], $this->_sitemap['zhuanti']);
            }
        }
	}
}