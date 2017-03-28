<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms 铭万开源CMS内容管理系统  (http://cms.b2b.cn)
 *
 * IssueModel.php
 *
 *
 * @author     黄利科<huanglike@mail.b2b.cn>   2013-1-11 下午5:14:14
 * @filename   IssueModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://cms.b2b.cn/license/   MainOneCms 1.0
 * @version    MainOneCms 1.0
 * @link       http://cms.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class IssueModel extends Model
{
    //模型列表
    public function getAbleModel()
    {
        $sql = "SELECT id, name FROM ".$this->tablePrefix ."model WHERE flag = 1";
        return $this->query($sql);
    }

    //遍历一个文件夹下的所有文件和子文件夹
    public function my_scandir($dir)
    {
        $files = array();
        if ( $handle = opendir($dir) ) {
            while ( ($file = readdir($handle)) !== false )
            {
                if ( $file != ".." && $file != "." )
                {
                    if ( is_dir($dir . "/" . $file) )
                    {
                        $files[$file] = $this-> my_scandir($dir . "/" . $file);
                    }
                    else
                    {
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }

    //删除目录和文件
    public function deleteDirectory($dir)
    {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') continue;
                if (!$this->deleteDirectory($dir . "/" . $item)) {
                    chmod($dir . "/" . $item, 0777);
                    if (!$this->deleteDirectory($dir . "/" . $item)) return false;
                };
            }
        return @rmdir($dir);
    }

    //获取全部栏目
    public function getAllCategory() {
        $sql = "SELECT id, pid, model, filepath FROM ".$this->tablePrefix ."category WHERE model != 2";
        return $this->query($sql);
    }

    //获取全部文章
    public function getAllArticle() {
        $sql = "SELECT m.id, m.publishtime, c.filepath FROM ".$this->tablePrefix ."maintable AS m, ".$this->tablePrefix ."category AS c WHERE m.categoryid = c.id ";
        return $this->query($sql);
    }

    //获取对应栏目内容
    public function getNeedArticle($ids) {
        $sql = "SELECT m.id, m.publishtime, c.filepath FROM ".$this->tablePrefix ."maintable AS m, ".$this->tablePrefix ."category AS c WHERE m.categoryid = c.id AND c.id IN (".$ids.") ";
        return $this->query($sql);
    }
    
    //获取静态页文章
    public function getStaticArticles($cids=null) {
        $sql = "SELECT m.id as id, m.publishtime as publishtime, c.filepath as filepath, mo.tablename as tablename, mo.id as mid FROM ".$this->tablePrefix ."maintable AS m JOIN ".$this->tablePrefix ."category AS c ON m.categoryid = c.id JOIN " . $this->tablePrefix . "model AS mo ON c.model = mo.id WHERE mo.id != 2  AND m.publishopt=1";
        if (!empty($cids)) {
            $sql .= " AND c.id IN (".$cids.") ";
        }
        $articles = $this->query($sql);
        foreach ($articles as $key => $article) {
            if (isset($article['tablename'])) {
                $content = M($article['tablename'])->where(array('maintable_id' => $article['id']))->field('content')->getOne();
                $articles[$key]['content'] = $content['content'];
            }
        }
        return $articles;
    }
    
    //获取商品静态页
    public function getStaticGoods($cids=null) {
        $sql = "SELECT g.goodsid as id, g.created as publishtime, c.filepath as filepath, mo.id as mid FROM ".$this->tablePrefix ."goods AS g JOIN ".$this->tablePrefix ."category AS c ON g.categoryid = c.id JOIN " . $this->tablePrefix . "model AS mo ON c.model = mo.id WHERE mo.id = 2  AND g.publishopt=1";
        if (!empty($cids)) {
            $sql .= " AND c.id IN (".$cids.") ";
        }
        $goods = $this->query($sql);
        return $goods;
    }
    
    
    //获取静态页栏目
    public function getStaticCategories() {
        $sql = "SELECT id, pid, model, filepath FROM ".$this->tablePrefix ."category WHERE columnoption = 1";
        return $this->query($sql);
    }
    
    //获取静态页
    public function getStatics($cids=null) {
        $all =array();
        $articles = array();
        $goods = array();
        $articles = $this->getStaticArticles($cids);
        $goods = $this->getStaticGoods($cids);
        $all = array_merge($articles, $goods);
        return $all;
    }
    
    public function addChildCids($cids) {
        $cid_arr = array();
        $cid_arr = explode(',', $cids);
        $new_cids = array();
        foreach ($cid_arr as $cid) {
            $new_cid = getCategoryIds($cid);
            $new_cids = array_merge($new_cids, $new_cid);
        }
        $new_cids = array_merge($new_cids, $cid_arr);
        $new_cids = array_unique($new_cids);
        $cids = join(',', $new_cids);
        return $cids;
    }


}