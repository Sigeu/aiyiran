<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * CemeteryModel.php
 *
 * 内容管理模型类
 *
 * @author     月下追魂<youkaili@mail.b2b.cn>   2016年11月15日11:34:34
 * @filename   CemeteryModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class CemeteryModel extends Model
{
    public $pk = "id";//主键
    public $tableName = "memorial_cemetery2";//表名


    /**
     * 列表
     */
    public function lists($search, $count)
    {
        $sql = "SELECT * FROM `".$this -> tablePrefix.$this-> tableName."` AS ce";
        $sql .= " WHERE 1";
        if($search['keywords']) $sql .= " AND ce.title LIKE '%{$search['keywords']}%' ";
        if($search['status'] == 1) $sql .= " AND ce.status = 1 ";
        if($search['status'] == 2) $sql .= " AND ce.status = 2 ";
         #时间区域搜索
        if($search['star'] && $search['end']) $sql .= " AND ce.addtiem >= '{$search['star']}' AND ce.addtiem <= '{$search['end']}' ";
        if($search['star'] && empty($search['end'])) $sql .= " AND ce.addtiem > '{$search['star']}' ";
        if($search['end'] && empty($search['star'])) $sql .= " AND ce.addtiem < '{$search['end']}' ";

        if($count == true){
            return count($this->query($sql));
        }

        if($count == false){
            if($search['limit']) $sql  .= ' ORDER BY ce.id DESC LIMIT '.$search['limit'].' ';
            return $this->query($sql);
        }

        return $result;
    }


    public function addCemetery()
    {
        /**陵园基本信息**/
      $insetData = array();
      $insetData['title'] = trim($_POST['title']);
      $insetData['address'] = trim($_POST['address']);
      $insetData['tel'] = trim($_POST['tel']);
      $insetData['summary'] = trim($_POST['summary']);
      $insetData['status'] = trim($_POST['status']);
      $insetData['map_name'] = trim($_POST['map_name']);
      $insetData['province'] = trim($_POST['province']);
      $insetData['city'] = trim($_POST['city']);

         // 陵园照片
      $tupian = isset($_POST['info']['tupian']) ? $_POST['info']['tupian'] : array();
        if($tupian){
          $upload_info = moUploadAccessory(array('file'=>$tupian,'folder'=>'cemetery_logo','time_name'=>false));
          foreach ($upload_info as $key => $value) {
            $insetData['photo_url'] = '/cemetery_logo/' . $value['path'];
              // M('memorial_cemetery2')->create($insertData);
            }
        }
        $result = M('memorial_cemetery2')->create($insetData);

        /**关于陵园 和陵园服务**/
        $about = array();
        $about['summary'] = trim($_POST['summary']);
        $about['honor'] = trim($_POST['honor']);
        $about['culture'] = trim($_POST['culture']);
        $about['server'] = trim($_POST['server']);
        $about['id'] = $result;
        M('memoriald_cemetery_culture')->create($about);

        /**陵园景观**/
        $tupian2 = isset($_POST['info']['tupian2']) ? $_POST['info']['tupian2'] : array();
          if($tupian2){
            $upload_info = moUploadAccessory(array('file'=>$tupian2,'folder'=>'cemetery_photo','time_name'=>false));
            $insertData = array();
            $insertData['pid'] = $result; #陵园id
            foreach ($upload_info as $key => $value) {
              $insertData['photo_url'] = '/cemetery_photo/' . $value['path'];
              $result = M('memorial_cemetery2_photo')->create($insertData);
            }
      }

      // p($_POST);die;

      return $result;
    }

    /**
     * 更新陵园
     */
    public function getDataById($id)
    {
        $map = array(
        'id'=>$id
        );
        $updata = M($this->tableName)->where($map)->getOne();
        $photo = M($this->tableName . '_photo')->where(array('pid'=>$updata['id']))->select();
        $data = array(
            'updata'=> $updata,
            'photo'=>$photo
            );
        return $data;
    }

    /**
     * 更新陵园数据插入
     */
    public function updateCeme()
    {
        $insertData = array();
        $insertData['title'] = trim($_POST['title']);
        $insertData['address'] = trim($_POST['address']);
        $insertData['tel'] = trim($_POST['tel']);
        $insertData['summary'] = trim($_POST['summary']);
        $insertData['status'] = trim($_POST['status']);
        $insertData['province'] = trim($_POST['province']);
        $insertData['city'] = trim($_POST['city']);

         // 相册
          $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
          if($accessory){
            $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'cemetery_logo','time_name'=>false));
            foreach ($upload_info as $key => $value) {
              $insertData['photo_url'] = '/cemetery_logo/' . $value['path'];
            }
          }

        // 相册更新条件
        $map = array(
             'id'=>trim($_POST['id'])
            );
        $result = M('memorial_cemetery2')->update($map, $insertData);

        return $result;
    }

    public function sceneryUp($id)
    {
          $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array();
          if($accessory){
            $upload_info = moUploadAccessory(array('file'=>$accessory,'folder'=>'cemetery_photo','time_name'=>false));
            $insertData = array();
            $insertData['pid'] = $id; #陵园id
            foreach ($upload_info as $key => $value) {
              $insertData['photo_url'] = '/cemetery_photo/' . $value['path'];
              $result = M('memorial_cemetery2_photo')->create($insertData);
            }
      }
      return $result;
    }



}