<?php
/**
 * iZhanCMS 爱站内容管理系统 (http://www.izhancms.com)
 *
 * 文件用途说明
 * 
 * 这里写类的详细说明,这里写类的详细说明,这里写类的详细说明,这里写类的详细说明
 * 这里写类的详细说明,这里写类的详细说明
 * 
 * 文件修改记录：
 * <br>wake1  2016年11月11日18:35:59 创建此文件 
 * <br>wake1  2016年11月11日18:35:59 修改此文件 添加了某某功能
 * 
 * @author     wake1 <alexa456@163.com>  2016年11月11日18:35:59
 * @filename   ${file}  ${encoding} 
 * @copyright  Copyright (c) 2004-${year} Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $$Id$$
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @package    ${class_container}
 * @since      1.0.0
 */

if (!defined('IN_MAINONE')) exit('No permission');
class AuditController extends AdminController {

    public $obj;
    public $audit; #模型名称
    public function init()
    {
        $this->audit = D('Audit');
        $this->obj = M("memorial_audit");
    }

    /**
     * 审核管理 - 列表
     */
    public function indexAction()
    {
        if(self::post("submit")){
            $data = $_POST;
            array_pop($data);
            $sql = '';
            foreach ($data as $key => $value) {
                $sql = "UPDATE `mo_memorial_audit` SET `is_audit` = {$value} WHERE `audit_name` = '{$key}'"; 
                // echo $sql;
                $result = mysql_query($sql); 
            }
            // die;
            if ($result) {
                $this->dialog("/memorial/audit/index",'success','更新成功');
                exit;
            } else {
                $this->dialog("/memorial/audit/index",'error','更新失败');
                exit;
            } 
           
        }else{
            $data = $this->obj->select();
            $this->assign('data', $data);
            $this->display('memorial/audit/index');
        }
    }

    // 逝者资料管理
    public function ziliaoAction()
    {
        $where = array();
        $map = array();
        if(isset($_GET['status'])){
            $where ="mo_memorial_userinfo.status = 0";
            $map = array('status'=>0);
        }

        // 分页star
        $count = M('memorial_userinfo')
                ->field('mo_memorial.name AS jname, mo_memorial_userinfo.*')
                ->join('`mo_memorial` ON mo_memorial.id = mo_memorial_userinfo.mid')
                ->findCount($map);
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $options['limit'] = $from . ',' . $pagesize;
        $options['order'] = 'id desc';
        $options['where'] = $where;
        $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pagestr = $page->show();
        // 分页end


        $list = M('memorial_userinfo')
                ->field('mo_memorial.name AS jname, mo_memorial_userinfo.*')
                ->join('`mo_memorial` ON mo_memorial.id = mo_memorial_userinfo.mid')
                ->select($options);
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign("list", $list);
        
        $this->display('memorial/audit/ziliao');
    }
    /**
     * 逝者资料审核 - 通过
     */
    public function shziliaoyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_userinfo')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 逝者资料审核 - 不通过
     */
    public function shziliaonoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_userinfo')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 逝者资料 - 删除
     */
     public function ziliaodeleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_userinfo')->delete($where);
        if($result){
            admin_log('逝者资料', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/ziliao/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/ziliao/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 作品及荣誉 - 管理
     */
    public function honorAction()
    {
        // 获取所有纪念馆
        $allList = $this->audit->getMemarilaList();

        $search = array(
          'keywords'=>$this->getParams('keywords'), #荣誉名称
          'memorial_id'=>$this->getParams('memorial_id'), #纪念馆id
          'status'=>$this->getParams('status'),
          'star'=>$this->getParams('star'),
          'end'=>$this->getParams('end')
        );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/audit/honor", 'error', '结束时间不能小于开始时间');
          } 
        }
        # 满足条件的总条数
        $count = $this->audit->searchHonor($search, true); 
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->audit->searchHonor($search, false);
       
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('search', $search);
        $this->assign('allList', $allList);
        $this->assign('list', $list);
        $this->display('memorial/audit/honor');
    }

    /**
     * 作品及荣誉 - 通过
     */
    public function honoryesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_honor')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 作品及荣誉 - 不通过
     */
    public function honornoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_honor')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 作品及荣誉 - 删除
     */
    public function honordeleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_honor')->delete($where);
        if($result){
            admin_log('作品及荣誉', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/honor/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/honor/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }


    /**
     * 传记 - 管理
     */
    public function biographyAction()
    {
       
       // 获取所有纪念馆
        $allList = $this->audit->getMemarilaList();

        $search = array(
          'keywords'=>$this->getParams('keywords'), #荣誉名称
          'memorial_id'=>$this->getParams('memorial_id'), #纪念馆id
          'status'=>$this->getParams('status'),
          'star'=>$this->getParams('star'),
          'end'=>$this->getParams('end')
        );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/audit/honor", 'error', '结束时间不能小于开始时间');
          } 
        }

        # 满足条件的总条数
        $count = $this->audit->searchbiog($search, true); 
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->audit->searchbiog($search, false);
       
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('search', $search);
        $this->assign('allList', $allList);
        $this->assign('list', $list);
      
        $this->display('memorial/audit/biography');
    }

    /**
     * 传记审核 - 通过
     */

    public function biographyyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['mid'];
          $map = array(
            'mid'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_biography')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 传记审核 - 不通过
     */

    public function biographynoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['mid'];
          $map = array(
            'mid'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_biography')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 传记审核 - 删除
     */
    public function biographydeleteAction()
    {
        $id = $this->getIds("mid");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('mid' => $id)
            );
        $result = M('memorial_biography')->delete($where);
        if($result){
            admin_log('传记审核', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/biography/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/biography/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }


    /**
     * 祭文悼词 - 管理
     */
    public function eulogyAction()
    {
        // 获取所有纪念馆
        $allList = $this->audit->getMemarilaList();

        //获取所有分类
        $catList = $this->audit->getCatList();

        $search = array(
          'keywords'=>$this->getParams('keywords'), #荣誉名称
          'memorial_id'=>$this->getParams('memorial_id'), #纪念馆id
          'cat_id'=>$this->getParams('cat_id'), #分类id
          'status'=>$this->getParams('status'),
          'star'=>$this->getParams('star'),
          'end'=>$this->getParams('end')
        );

        if($search['star'] && $search['end']){
          if($search['end'] < $search['star']){
            $this->dialog("/memorial/audit/honor", 'error', '结束时间不能小于开始时间');
          } 
        }

        # 满足条件的总条数
        $count = $this->audit->searcheulogy($search, true); 
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->audit->searcheulogy($search, false);
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('search', $search);
        $this->assign('allList', $allList);
        $this->assign('catList', $catList);
        $this->assign('list', $list);
        
        $this->display('memorial/audit/eulogy');
    }

    /**
     * 祭文悼词 - 通过
     */
    public function eulogyyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id 
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_eulogy')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 祭文悼词 - 不通过
     */
    public function eulogynoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_eulogy')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 祭文悼词 - 删除
     */
    public function eulogydeleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_eulogy')->delete($where);
        if($result){
            admin_log('祭文悼词管理', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/eulogy/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/eulogy/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 留言审核
     */
    public function messageAction()
    {
           // 获取所有纪念馆
        $allList = $this->audit->getMemarilaList();
        $search = array(
          'memorial_id'=>$this->getParams('memorial_id'), #纪念馆id
          'status'=>$this->getParams('status'), #状态码
        );

            # 满足条件的总条数
        $count = $this->audit->searchMessage($search, true); 
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->audit->searchMessage($search, false);

       // // 结束代码区域
       //  $where = array();
       //  $map = array();
       //  if(isset($_GET['status'])){
       //      $where ="mo_memorial_message.status = 0";
       //      $map = array('status'=>0);
       //  }

       //  // 分页star
       //   $count = M('memorial_message')
       //          ->field('mo_memorial.name AS jname, mo_memorial_message.*')
       //          ->join('`mo_memorial` ON mo_memorial.id = mo_memorial_message.mid')
       //          ->findCount($map);
       //  $pagesize = 20;
       //  $page = new Page($count, $pagesize);
       //  $from = $page->firstRow;
       //  $options['limit'] = $from . ',' . $pagesize;
       //  $options['where'] = $where;
       //  $currpage = isset($_GET['p']) ? $_GET['p'] : 1;
       //  $pagestr = $page->show();
       //   $list = M('memorial_message')
       //          ->field('mo_memorial.name AS jname, mo_memorial_message.*')
       //          ->join('`mo_memorial` ON mo_memorial.id = mo_memorial_message.mid')
       //          ->select($options);
       //  // 分页end
        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('search', $search);
        $this->assign("list", $list);
        $this->assign("allList", $allList);
        $this->display('memorial/audit/message');
    }

    /**
     * 留言审核 - 删除
     */
    public function messagedeleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('memorial_comment')->delete($where);
        if($result){
            admin_log('留言审核', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/message/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/message/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 留言审核 - 通过
     */
    public function messageyesAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('memorial_comment')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 留言审核 - 不通过
     */
    public function messagenoAction()
    {
        if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('memorial_comment')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 文章评论 - 列表
     */
    public function commentAction()
    {
        $search = array(
          'keywords'=>$this->getParams('keywords'), #纪念馆id
          'status'=>$this->getParams('status'), #状态码
        );

            # 满足条件的总条数
        $count = $this->audit->searchComment($search, true); 
        $pagesize = 20;
        $page = new Page($count, $pagesize);
        $from = $page->firstRow;
        $search['limit'] = $from . ',' . $pagesize;

        # 数据列表
        $currpage = isset($_GET['p'])?$_GET['p']:1;
        $pagestr = $page->show();
        $list = $this->audit->searchComment($search, false);
        foreach ($list as $key => $value) {
          if($value['content']){
            $list[$key]['content'] = csubstr($value['content'],40);
            $list[$key]['title'] = csubstr($value['title'],20);
          }
        }

        $this->assign("pageStr", $pagestr);
        $this->assign("page", $currpage);
        $this->assign('search', $search);
        $this->assign("list", $list);
        $this->display('memorial/audit/comment');
    }

    /**
     * 文章评论 - 删除
     */
    public function commentdeleteAction()
    {
        $id = $this->getIds("id");
        $arr['page'] = $this->getParams('page');

        $where = array(
            'in'=>array('id' => $id)
            );
        $result = M('wish')->delete($where);
        if($result){
            admin_log('文章评论', '删除id为：' . $id . '数据成功');
            $this->dialog("/memorial/audit/comment/page/{$arr['page']}",'success','删除成功');
            exit;
        }else{
            $this->dialog("/memorial/audit/comment/page/{$arr['page']}",'error','删除失败');
            exit;
        }
    }

    /**
     * 文章评论 - 审核通过
     */
    public function commentyesAction()
    {
      if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>1
            );
          $result = M('wish')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

    /**
     * 文章评论 - 审核不通过
     */
    public function commentnoAction()
    {
      if(!empty($_POST)){
          $id = $_POST['id'];
          $map = array(
            'id'=>$id
            );
          $data = array(
            'status'=>2
            );
          $result = M('wish')->update($map, $data);
          if($result){
              echo json_encode(array('status'=>1, 'code'=>'success', 'msg'=>'审核成功'));exit;
          }else{
              echo json_encode(array('status'=>2, 'code'=>'error', 'msg'=>'审核失败'));exit;
          }

        }
    }

}