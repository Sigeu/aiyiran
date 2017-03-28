<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SearchModel.php
 *
 * 搜索类Model   sphinx
 *
 *
 * @author     冯阳<fengyang@mail.b2b.cn>   2013-9-20
 * @filename   CategoryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class SearchModel extends Model
{
    public $tableName = 'search';
    public $result;

    /**
     * error
     */
    public function sqlerror($sql)
    {
         $data = $this->query($sql);
                if($data==false){
                    return '未找到相关信息，稍后再试';
        }
        return $data;
    }

    /**
     * @param int $params 私人纪念馆参数
     * @return string 返回值
     */
    public function  search($search, $count)
    {
         $sql = "SELECT cat.name AS cat_name, m.name AS m_name, m.id AS m_id, cat.id AS cat_id, m.*
                        FROM `mo_memorial` AS m
                        LEFT JOIN `mo_memorial_userinfo` AS c
                        ON m.id = c.mid
                        LEFT JOIN `mo_memorial_cat` AS cat
                        ON m.catid = cat.id";
            $sql .=" WHERE 1";
            $sql .=" AND m.catid =1";
            $where = "";
            if($search['where'] == 'all') {
                if($count == false){
                    if($search['limit']) $sql  .= ' ORDER BY m.id DESC LIMIT '.$search['limit'].' ';
                     $data = $this->query($sql);
                }
                if($count == true){
                    $data = count($this->query($sql));
                }
                 return $data;
            }else{
                switch ($where) {
                    case '1':
                            #先祖
                            $map = '0, 1, 2';
                            $sql .=" AND persontype  in ($map)";
                            // echo $sql;die;
                           return $this->query($sql);

                        break;
                    case '2':
                            #姐妹
                            $map = '16, 18';
                            $sql .=" AND persontype  in ($map)";
                           return $this->query($sql);
                        break;
                    case '3':
                            #亲人
                            $map = '20, 21, 22, 23';
                            $sql .=" AND persontype not in ($map)";
                           return $this->query($sql);
                        break;
                    case '4':
                            #友人
                            $map = '21';
                            $sql .=" AND persontype  in ($map)";
                           return $this->query($sql);
                        break;
                    case '5':
                            #同事
                            $map = '22';
                            $sql .=" AND persontype  in ({$map})";
                           return $this->query($sql);
                        break;
                    case '6':
                            #老师
                            $map = '20';
                            $sql .=" AND persontype  in ($map)";
                           return $this->query($sql);
                        break;
                    case '7':
                            #爱人
                            $map = '11, 12';
                            $sql .=" AND persontype  in ($map)";
                           return $this->query($sql);
                        break;
                    case '8':
                            #兄弟
                            $map = '15, 17';
                            $sql .=" AND persontype  in '{$where}'";
                           return $this->query($sql);
                        break;
                    default:
                        return null;
                        break;
                }

            }
    }

    /**
     * 私人
     */
    public function  zimu($where)
    {
         $sql = "SELECT cat.name AS cat_name, m.name AS m_name, m.id AS m_id, cat.id AS cat_id, m.*
                        FROM `mo_memorial` AS m
                        LEFT JOIN `mo_memorial_userinfo` AS c
                        ON m.id = c.mid
                        LEFT JOIN `mo_memorial_cat` AS cat
                        ON m.catid = cat.id";
            $sql .=" WHERE 1";
            $sql .=" AND m.catid =1";
            if($where ) $sql .=" AND letter = '{$where}'";
            $data = $this->query($sql);
            return $data;
    }
    
    /**
     * @param text
     * @return array
     * 私人纪念馆
     */
    public function  input($where, $type, $catid)
    {
         $sql = "SELECT * FROM `mo_memorial`";
            $sql .=" WHERE 1";
            $sql .=" AND catid = {$catid}"; //私人纪念馆
            $sql .=" AND isshow = 1"; //公开状态
            $sql .=" AND status = 1"; //审核通过
            //下标为0的值 = 点击分类
            if($where && $type == 1) $sql .=" AND personname LIKE  '%{$where}%'";  //输入框
            if($where && $type == 2) $sql .=" AND letter = '{$where}'"; //首字母
            if($where && $type == 3) $sql .=" AND persontype = '{$where}'"; //点击分类
            if($where=='fall' && $type == 4) $sql .=" "; //点击所有分类
            if($where==0 && $type==3) $sql .=" AND persontype = '{$where}'";
            $data = $this->query($sql);
            return $data;
    }
    
    /**
     * 名人纪念馆
     */
    public function celebrity($where, $type, $catid)
    {
        $sql = "SELECT m.personname,m.id,m.userpic,u.brithdate,u.dieddate,u.descript,u.m_year,u.d_year
                FROM `mo_memorial` AS m 
                LEFT JOIN `mo_memorial_userinfo` AS u 
                ON m.id = u.mid";
        $sql .=" WHERE 1";
        $sql .=" AND m.catid = {$catid}";
        $sql .=" AND m.isshow = 1"; //公开状态
        $sql .=" AND m.status = 1"; //审核通过
        if($where && $type == 1) $sql .=" AND m.personname LIKE '%{$where}%'"; //输入框
        if($where && $type == 2) $sql .=" AND letter = '{$where}'"; //首字母
    
        $data = $this->query($sql);
        return $data;
    }

    /**
     * 名人纪念馆 搜索 zimu
     */
    public function letter($where)
    {
        $sql = "SELECT m.personname,u.brithdate,u.dieddate,u.descript,m.userpic
                        FROM `mo_memorial` AS m
                        LEFT JOIN `mo_memorial_userinfo` AS u
                        ON m.id = u.mid";
            $sql .= " WHERE 1";
            $sql .=" AND m.catid =2";
            if($where) $sql .= " AND letter = '{$where}'";
            $data = $this->query($sql);
            return $data;
    }

     /**
     * 名人纪念馆 表单名字搜索
     */
    public function celebrit($where)
    {
        $sql = "SELECT m.personname,u.brithdate,u.dieddate,u.descript,m.userpic,u.m_year,u.d_year
                        FROM `mo_memorial` AS m
                        LEFT JOIN `mo_memorial_userinfo` AS u
                        ON m.id = u.mid";
            $sql .= " WHERE 1";
            $sql .=" AND m.catid =2";
            if($where == 'all') {
                    $data = $this->query($sql);
                    // echo $sql;die;
                     return $data;
                }else{
                $sql .= " AND m.personname LIKE  '%{$where}%'";
                $data = $this->query($sql);
            }
            return $data;
    }






    /**
     *   修改点击量+1
     */
    public function updateSql($names,$times,$stat,$sign)
    {
        $result = "update ". $this->tablePrefix ."seo_search set search_count = search_count+1,search_times = ".$times." where search_names = '$names' AND type_id='$stat' AND sign_id='$sign'";
        $this -> query($result);
    }


    /**
     *   sphinx搜索
     */
    public function sphinxSearch($datas = array())
    {

         //引用sphinxAPI文件类
         require_once DIR_ROOT."library/mainone/classes/sphinxapi.php";
         $cl = new SphinxClient();

         $mid       = isset($datas['mid'])       ?  $datas['mid']       : null;
         $cid       = isset($datas['cid'])       ?  $datas['cid']       : null;
         $stat      = isset($datas['stat'])      ?  $datas['stat']      : 0;
         $dress     = isset($datas['dress'])     ?  $datas['dress']     : '192.168.3.170';
         $number    = isset($datas['number'])    ?  $datas['number']    : '9312';
         $keyword   = isset($datas['keyword'])   ?  $datas['keyword']   : '创业';
         $modelTab  = isset($datas['modelTab'])  ?  $datas['modelTab']  : 'searchs';
         $search_type = isset($datas['search_type']) ?  $datas['search_type'] : 1;

         $cl->SetServer($dress,$number);                                //设置IP地址和端口号
         $cl->SetArrayResult( true );
         $cl->SetConnectTimeout(3);                                     //设置超时时间
         $cl->SetMaxQueryTime(2000);                                    //设置最大搜索时间
         $cl->AddQuery($keyword,$modelTab);                             //判断结果数进行分页
         $get_total = $cl->RunQueries();
         $total     = $get_total[0]['total'];

         $result = $cl->Query($keyword,$modelTab);                       //搜索结果
         $words = implode(' ',array_keys($result['words']));
//       if($page == 1)
         $this -> seosearchPublic($mid,$words,$total,$keyword);         //同步添加seo_search表 （模型id，分词，结果数，关键词）
         foreach($result['matches'] as $row)
         $ids .= $row['id'].',';
         $result['ids'] = rtrim($ids,',');
         $result['mid'] = $mid;
         $result['cid'] = $cid;
         $result['stat'] = $stat;
         return $result;
    }


    /**
     *  添加 mo_seo_search 表公共接口
     */
    public function seosearchPublic($mid,$words='',$total,$keyword)             //（模型id，分词，结果数，关键词）
    {
         $mid = $mid == '' ? 0 : $mid;
         $isnot = M('SeoSearch') -> where(array('type_id' => $mid,'search_names' => $keyword)) -> getOne();     //查询是否有这条记录
         if(empty($isnot))
         {
             $time = time();
             $datas = array(

                 'type_id'       => $mid,
                 'search_names'  => $keyword,
                 'search_name'   => $words,
                 'search_count'  => 1,
                 'search_times'  => $time,
                 'search_result' => $total,
             );
             M('SeoSearch') -> create($datas);      //添加一条新的搜索内容
         }else{

             $times = time();
             $update = "update " .$this->tablePrefix ."seo_search set search_count = search_count+1,search_name='$words',search_result='$total',search_times = '$times' where type_id=".$mid." and search_names = '$keyword'";  //同步修改key_id
             $this -> query($update);
         }
         return;
    }


    /**
     *  根据不同模型id查询详细内容
     */
    public function searchDetail($id,$modelTab)
    {
         if($modelTab == 'goods')
         {
             $sql = M($modelTab) -> where('goodsid='.$id) -> select();    //查询搜索详细内容

         }else if($modelTab == 'article'){

             $sql = M($modelTab) -> where('maintable_id='.$id) -> select();    //查询搜索详细内容

         }else{

             $sql = M($modelTab) -> where('id='.$id) -> select();    //查询搜索详细内容
         }
         return $sql;
    }


    /**
     *  mysql搜索 --- 分词
     */
    public function mysqlSearch( $content = '' )
    {

//          ini_set('display_errors', 'On');
//          ini_set('memory_limit', '64M');
//          error_reporting(E_ALL);

            $str = (isset($_POST['source']) ? $_POST['source'] : '');

            $do_fork = $do_unit = true;
            $do_multi = $do_prop = $pri_dict = false;

            $str=$content;
            if($str != '')
            {
                //岐义处理
    //          $do_fork = empty($_POST['do_fork']) ? false : true;
                $do_fork = true;
                //新词识别
                //$do_unit = empty($_POST['do_unit']) ? false : true;
                $do_unit = true;
                //多元切分
                $do_multi = empty($_POST['do_multi']) ? false : true;
                //词性标注
                $do_prop = empty($_POST['do_prop']) ? false : true;
                //是否预载全部词条
                $pri_dict = empty($_POST['pri_dict']) ? false : true;

                $tall = microtime(true);

                //初始化类
                PhpAnalysis::$loadInit = false;
                $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);

                //载入词典
                $pa->LoadDict();

                //执行分词
                $pa->SetSource($str);
                $pa->differMax = $do_multi;
                $pa->unitWord = $do_unit;

                $pa->StartAnalysis( $do_fork );

                $okresult = $pa->GetFinallyResult(' ', $do_prop);
                return $okresult;
            }

    }



    /**
     *  mysql全文搜索结果
     */
    public function searchResult($cid='',$mid,$stat,$modelTab,$where,$keyword,$search_type)     //栏目id, 模型id, 搜索方式，表名，栏目id过滤条件，关键词，分页, 搜索类型
    {
         $arr['mid']       = isset($datas['mid'])       ?  $datas['mid']       : null;
         $arr['cid']       = isset($datas['cid'])       ?  $datas['cid']       : null;
         $arr['stat']      = isset($datas['stat'])      ?  $datas['stat']      : 0;
         $arr['keyword']   = isset($datas['keyword'])   ?  $datas['keyword']   : '创业';
         $arr['modelTab']  = isset($datas['modelTab'])  ?  $datas['modelTab']  : 'searchs';
         $arr['search_type'] = isset($datas['search_type']) ?  $datas['search_type'] : 1;

         if($mid == 1){                              //sql where条件判断
            $mid_where = "AND (mid > 2 OR mid=1)";
         }else if(empty($mid)){
            $mid_where = '';
         }else{
            $mid_where = "AND mid = '$mid'";
         }

        /**
         *  针对new5模板的英文版指定栏目处理
         */
         if(!empty($cid)){

             $res = getCategoryIds($cid,true);
             $cids = join(',', $res);
             $mid_where .= " AND cid in ($cids)";
         }
         $sql    =  "select COUNT(*) as count from " . $this->tablePrefix ."searchs". " WHERE MATCH(keywords,data) AGAINST( '$keyword' IN BOOLEAN MODE) $mid_where";
         $result =  $this -> query($sql);
         $arr['total'] = $result[0]['count'];
         return $arr;
    }



    /**
     *  search表 添加公用接口
     */
    public function searchAdd($modelid,$cid,$contentid,$title,$description,$content,$keyword='',$created='')        //模型id, 栏目id, 信息id，标题，简介，内容，分词，关键词
    {
         $search_content = $title.' '.$description.' '.$content;
         $combine_con = $this -> mysqlSearch($search_content);
         $contents = $combine_con.' '.$title;
         $keyword_new = '';
         if(isset($keyword) && !empty($keyword))
         {
             $kong = explode(',',str_replace('，', ',', $keyword));
             foreach($kong as $val)
             {
                $keyword_new .= $val.' ';
             }
         }
         $data = array(
                'mid' => $modelid,
                'cid' => $cid,
                'contentid' => $contentid,
                'title' => $title,                              /* title : 标题 */
                'keywords' => $keyword_new,                     /* keywords : 关键词 */
                'data' => $contents,                            /* data : 标题 + 简介 + 内容 分词 */
                'subtitle' => $description,                     /* subtitle : 简介 */
                'created' => $created,
          );
         M('searchs') -> create($data);                     //添加数据到搜索关键词表
    }


    /**
     *  search表 修改公用接口
     */
    public function searchUpdate($cid,$id,$title='',$description='',$content='',$keyword='')            //栏目id, 信息id，标题，简介，内容，分词，关键词
    {
         $search_content = $title.' '.$description.' '.$content;
         $contents = $this -> mysqlSearch($search_content);
         $contents = $contents.' '.$title;
         $keyword_new = '';
         if(isset($keyword) && !empty($keyword))
         {
             $kong = explode(',',str_replace('，', ',', $keyword));
             foreach($kong as $val)
             {
                $keyword_new .= $val.' ';
             }
         }
         $mid = 0;
         $catInfo = cid2Info($cid);
         if ($catInfo) {//商品或文章
            $mid = $catInfo['model'];
         } else if (empty($cid)) {//专题
             $mid = 'a';
         }
         M('searchs') -> update(array('contentid'=>$id, 'mid' => $mid),$param=array('cid'=>$cid,'keywords'=>$keyword_new,'title'=>$title,'subtitle'=>$description,'data'=>$contents));
    }


    /**
     *  search表 删除公用接口
     */
    public function searchDel($mid,$id)                                                     //模型id,信息id
    {
        $where = array(
            'in' => array('contentid' => $id)
        );
        if ($mid == 2 || $mid == 'a') {//商品或专题
            $where['mid'] = $mid;
        } else {//文章或内容
            $where['or'] = 'mid = 1 OR mid > 2';
        }
        M('searchs') -> delete($where);                 //删除搜索关键词表里数据
    }

    /*删除无用文章、内容关键词索引*/
    public function deleteUselessSearches () {
        $maintable = M('maintable')->select();
        $ids = '';
        foreach ($maintable as $main) {
            if ($ids) {
                $ids .= ',';
            }
            $ids .= $main['id'];
        }
        $where = array(
            'notin' => array('contentid' => $ids),
            'mid' => 1
        );
        $count = M('searchs')->delete($where);
        var_dump($count);die;
    }

    /**
     *  整理搜索初始化数据
     */
    /*
    public function selectInfo()
    {
        $sql = 'SELECT * FROM ' . $this->tablePrefix .'goods';
        return $this -> query($sql);
    }
    */

    /**
     *  整理搜索初始化数据
     */
    /*
    public function selectInfo_article()
    {
        $sql = 'SELECT m.id,m.categoryid,m.title,m.description,a.content FROM ' . $this->tablePrefix .'maintable as m left join '.$this ->tablePrefix.'article as a on a.maintable_id = m.id';
        return $this -> query($sql);
    }
    */
}