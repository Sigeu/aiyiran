<?php 
/**
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * 二维码管理
 *
 * 文件修改记录：
 * <br>王少辰  2013-9-2 下午03:49:18 创建此文件 
 * 
 * @author     王少辰 <wangshaochen@mail.b2b.cn>  2013-9-2 下午03:49:18
 * @filename   QrCodeController.php  UTF-8 
 * @copyright  Copyright (c) 2004-2013 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    SVN: $Id: QrcodeController.php 4705 2014-09-30 08:25:30Z wangshaochen $
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @package    class_container
 * @since      2.0.0
 */
class QrcodeController extends AdminController {
    private $objQrcodeList;

    public $typeOptions = array(
        0 => '网址二维码',
        1 => '名片二维码',
        2 => '文本二维码',
        3 => 'app安装二维码',
        4 => 'app下载二维码',
    );//二维码类型
    public function init()
    {
        $this->objQrcodeList = M('qrcode'); 
        parent::init();
    }
    
    /**
     * 显示二维码列表
     * 
     * @access public
     * @return string
     */
    public function indexAction() {
        $pid = $this->getParams('pid');//二维码投放位id
        if (!empty($pid)) {
            $pageInfo = array();
            $where = 'position_id = ' . $pid;
            $count = $this->objQrcodeList->findCount($where);
            $pagesize = 20;
            $page = new Page($count, $pagesize);
            $from = $page->firstRow;
            $options['limit'] = $from.','.$pagesize;
            $options['where'] = $where;
            $options['order'] = "id DESC";
            $list = $this->objQrcodeList->select($options); //执行搜索后关键词查询+分页操作
            foreach ($list as $key => $val) {
                $type = isset($this->typeOptions[$val['type']]) ? $this->typeOptions[$val['type']] : 'error';
                $list[$key]['type'] = $type;//二维码类型
            }
            
            $positionObj = M('qrposition');
            $qrposition = $positionObj->where("id = $pid")->getOne();//所属投放位信息
            $pname = $qrposition['name'];//投放位名称
            
            $currpage = isset($_GET['p'])?$_GET['p']:1;
            $pagestr = $page->show();
            $pageInfo['page'] = $currpage;
            $this->assign('pageInfo', $pageInfo);
            $this->assign('pagestr', $pagestr);
            $this->assign('list', $list);
            $this->assign('pid', $pid);
            $this->assign('pname', $pname);
            $this->display('extensions/qrcode/qrcode_list.html');
        }
    }

    
    /**
     * 添加二维码
     *
     * @access public
     * @return string
     */
    public function addAction() {
        $pid = $this->getParams('pid');
        if(!empty($pid)){
            $allow_type = $this -> getAllowType(1);
            $setting = array(
                'limit'       =>  2,
                'type'        =>  $allow_type,
                'local'       => true,            //是否显示本地图库
                'folder'      => TRUE            //是否显示目录浏览
            );
            $setting['setting'] = base64_encode(serialize($setting));
            $this -> assign('setting',$setting);
            $this -> assign('pid', $pid);
            if (!empty($_POST['qrcode'])) {
                //二维码logo上传
                $logo_path = '';//二维码logo路径
                $qrinfo = array();//某一类型二维码信息
                $common = array();//二维码公共信息
                $param = array();//二维码字段信息
                $file_info = $this -> uploadQrlogo();
                if ($file_info) {
                    $logo_path = 'qrlogo/' . $file_info[0]['path'];//上传后图片路径
                }
                $type = $_POST['qrcode']['common']['type'];//二维码类型
                $type_index = 'web';
                if ($type == 1) {
                    $type_index = 'card';
                }
                
                if ($type == 2) {
                    $type_index = 'text';
                }
                
                $qrinfo = $_POST['qrcode'][$type_index];//二维码类型对应字段信息
                $common = $_POST['qrcode']['common'];
                $param = array_merge($common, $qrinfo);
                $param['position_id'] = $pid;
                $param['logo'] = $logo_path;
                $param['start_time'] = strtotime($param['start_time']);
                $param['end_time'] = strtotime($param['end_time']);
                if ($type == 3) {//app安装
                    $param['web_url'] = HOST_NAME . 'admin/extensions/mobilesite/choseUrl';
                } else if ($type == 4) {//app下载
                    $param['web_url'] = HOST_NAME . 'admin/extensions/mobilesite/choseUrl/download/1';
                }
                $ins = $this->objQrcodeList->create($param);//执行添加二维码操作
                if($ins){
                    $qrcode = $this->createCodeImg ($ins);
                    $this->objQrcodeList->update(array('id'=>$ins), array('code_image' => $qrcode));
                    $this->createJs($ins);
                    $this->dialog("/extensions/qrcode/index/pid/$pid",'success','添加成功！');
                }
            } else {
                $this -> display('extensions/qrcode/qrcode_add.html');
            }
        }
    }
    
    /**
     * 修改二维码
     *
     * @access public
     * @return string
     */
    public function editAction() {
        $id = $this->getParams('id');
        if(!empty($id)){
            $allow_type = $this -> getAllowType(1);
            $setting = array(
                'limit'       =>  2,
                'type'        =>  $allow_type,
                'local'       => true,            //是否显示本地图库
                'folder'      => true            //是否显示目录浏览
            );
            $setting['setting'] = base64_encode(serialize($setting));
            $qrcode = $this->objQrcodeList->where("id = $id")->getOne();//要修改的记录信息
            $qrcode_type = $qrcode['type'];
            $pid = $qrcode['position_id'];
            $logo = $qrcode['logo'];
            if (!empty($logo)) {
                $setting['limit'] = 1;
            }
            $qrcode['start_time'] = date('Y-m-d H:i', $qrcode['start_time']);
            $qrcode['end_time'] = date('Y-m-d H:i', $qrcode['end_time']);
            $this -> assign('setting',$setting);
            $this -> assign('qrcode', $qrcode);
            if (!empty($_POST['qrcode'])) {
                //二维码logo上传
                //$logo_path = $_POST['qrcode']['old_logo'];//logo路径默认原logo路径
                $logo_path = isset($_POST['qrcode']['old_logo']) ? $_POST['qrcode']['old_logo'] : '';//logo路径默认原logo路径
                $file_info = $this -> uploadQrlogo();
                if ($file_info) {
                    $logo_path = 'qrlogo/' . $file_info[0]['path'];//上传后logo图片路径
                }
                $param = $_POST['qrcode'];
                
                if (isset ($param['type']) ) {
                    unset($param['type']);
                }
                
                $param['logo'] = $logo_path;
                $param['start_time'] = strtotime($param['start_time']);
                $param['end_time'] = strtotime($param['end_time']);
                if ($qrcode_type == 3) {
                    $param['web_url'] = HOST_NAME . 'admin/extensions/mobilesite/choseurl';
                } else if ($qrcode_type == 4) {
                    $param['web_url'] = HOST_NAME . 'admin/extensions/mobilesite/choseurl/download/1';
                }
                unset($param['old_logo']);//去掉表中不存在的字段
                $ins = $this->objQrcodeList->update(array('id'=>$id), $param);//执行更新二维码操作
                if($ins){
                    $qrcode = $this->createCodeImg ($id);
                    $this->objQrcodeList->update(array('id'=>$id), array('code_image' => $qrcode));
                    $this->createJs($id);
                    $this->dialog("/extensions/qrcode/index/pid/$pid",'success','修改成功！');
                }
            } else {
                $this -> display('extensions/qrcode/qrcode_edit.html');
            }
        }
    }
    
    /**
     * 二维码logo上传
     */
    public function uploadQrlogo () {
        $accessory = isset($_POST['accessory']) ? $_POST['accessory'] : array() ;//附件信息，二维数组
        if($accessory) {
            $temp[] = current($accessory);
            return moUploadAccessory(array('file'=>$temp,'folder'=>'qrlogo'));
        }
        return array();
    }
    
    /**
     * 删除二维码
     *
     * @access public
     * @return string
     */
    public function deleteAction() {    
        $ids = $this->getIds('ids');//获取要删除的id字符串
        if (empty($ids)) {
            if(!empty($_GET['id'])) {        //执行单个删除操作
                $ids = $_GET['id'];
            }
        }
        $info = '删除失败，请重试！';
        $objQrcode = $this->objQrcodeList->where("id in ( $ids )")->getOne();
        if(!empty($ids)){
            $delAll = $this->objQrcodeList->delete(array('in'=>array('id'=>$ids)));
            if($delAll){
                $info = '删除成功';
            }                   
        }
        $pid = $objQrcode['position_id'];
        $this->dialog("/extensions/qrcode/index/pid/$pid",'success',$info);
    }
    
    
    /**
     * 预览生成的二维码图片
     *
     * @access public
     * @return string
     */
    public function previewAction () {
        $id = $this->getIds('id');//获取要预览的二维码id
        if (!empty($id)) {
            $qrcode = $this->objQrcodeList->where("id = $id")->getOne();//二维码配置信息
            $pid = $qrcode['position_id'];
            $qrposition = M('Qrposition')->where("id = $pid")->getOne();
            $code_image = $qrcode['code_image'];
            $width = $qrposition['width'];
            $path = URL_STATIC_UPLOAD . $code_image;
            echo "<img src = '$path' width='$width' height='$width'/>";
        }
    }
    
    /**
     * 生成js文件
     */
    public function createJs($id){
        $qrcode = $this->objQrcodeList->where("id = $id")->getOne();//二维码配置信息
        $qrpositionObj = M('qrposition');
        $position_id = $qrcode['position_id'];
        $qrposition = $qrpositionObj->where("id = $position_id")->getOne();//投放位信息
        $qrcode['width'] = $qrposition['width'];
        $qrcode['code_image'] = URL_STATIC_UPLOAD . $qrcode['code_image'];
    	$this->assign('qrcode', $qrcode);
    	$content = $this->fetch('public/advert/qrcode.html');
        $path = DIR_WEB_ROOT . '../html/qrcache';
        if (!file_exists($path)) {   
            mkdir($path, 0777);
        }  
    	file_put_contents($path . "/" . $id . '.js', $content);
    }
    
    /**
     * 生成的二维码图片
     *
     * @access public
     * @return string
     */
    public function createCodeImg ($id) {
        if (!empty($id)) {
            $qrcode = $this->objQrcodeList->where("id = $id")->getOne();//二维码配置信息
            $size = false;//不限制大小
            $logo = $qrcode['logo'] ? URL_STATIC_UPLOAD . $qrcode['logo'] : false;//中间那logo图
            $value = $qrcode['web_url'];
            $fornt_color = $qrcode['front_color'] ? $qrcode['front_color'] : '#000000';
            $bg_color = $qrcode['bg_color'] ? $qrcode['bg_color'] : '#ffffff';
            $colors = array($bg_color, $fornt_color);
            if ( $qrcode['type'] == 1 ) {
                $value = "BEGIN:VCARD\nVERSION:3.0". //vcard头信息  
                    "\nFN:{$qrcode['card_name']}".  
                    "\nTEL:{$qrcode['mobile']}".
                    "\nTEL;TYPE=work:{$qrcode['phone']}".   
                    "\nFAX:{$qrcode['fax']}".
                    "\nEMAIL:{$qrcode['email']}".
                    "\nURL:{$qrcode['company_url']}".
                    "\norG:{$qrcode['company_name']}".
                    "\nROLE:{$qrcode['position']}".
                    "\nADR;TYPE=work:{$qrcode['company_address']}".
                    "\nTITLE:{$qrcode['position']}".        
                    "\nEND:VCARD";
            } else if ($qrcode['type'] == 2) {
                $value = $qrcode['text'];
            };
            $errorCorrectionLevel = 'H';
            $matrixPointSize = 10;
            $margin = 1;
            $saveandprint = false;
            $path = DIR_WEB_ROOT . '../static/uploadfile/qrcode';
            if (!file_exists($path)) {   
                mkdir($path, 0777);
            }
            $name = time() . rand(10000,99999) . '.png';
            $path .= '/' . $name;
            $png = QRcode::png($value, $path, $errorCorrectionLevel, $matrixPointSize, $margin, $saveandprint, $colors, $logo, $size);
            return 'qrcode/' . $name;
        }
    }
    
    /**
     * 二维码更新点击量
     */
    public function upclickAction () {
        $id = $this->getParams('id');
        if (empty($id)) {
            echo '0';
            return;
        }
        $qrcode = $this->objQrcodeList->where("id = $id")->getOne();//要修改的记录信息
        $click = $qrcode['click'] + 1;
        $ins = $this->objQrcodeList->update(array('id'=>$id), array('click' => $click));//执行更新二维码操作
        if (empty($ins)) {
            echo '0';
            return;
        }
        echo '1';
    }
}