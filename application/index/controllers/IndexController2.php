<?php
/**
 *--------------------------------------------------------------------------------------
 * MainOneCms ����ԴCMS���ݹ���ϵͳ  (http://www.izhancms.com)
 *
 * CategoryModel.php
 * 
 * ����д�����ϸ˵��,����д�����ϸ˵��,����д�����ϸ˵��,����д�����ϸ˵��
 * 
 * 
 * @author     ١�»�<tongxinhua@mail.b2b.cn>   2013-3-11 ����5:22:39
 * @filename   CategoryModel.php  UTF-8 
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com 
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */
class IndexController extends HomeController 
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction() 
	{
		$cid=0;
	    $pid=0;
		$seo = array(
			'title'=>get_mo_config('mo_webname'),
			'keywords'=>get_mo_config('mo_keywords'),
			'description'=>get_mo_config('mo_description'),
		);

		include  $this->display('index.html');
	}
	/**
	 * 动态调 用
	 */
	public function previewAction(){
		$posObj = M("Adposition");
		$typeObj = M("Adtype");
		$advertObj = M("Advert");
		$posid= $_GET['id'];
		$pos = "";
		$tem = "";
		$add = "";
		
		$posInfo = $posObj->where(array('id'=>$posid))->field('adtypeid,adsize,pos,fontnum,adpos')->getOne();//广告位设置的id
		$ad = array();
		$time_style = $typeObj->getOne(array('where'=>array('id'=>$posInfo['adtypeid'])));

		if($posid)
		{
			if($time_style['adtime'] == 2){          //广告类型设置为手动设置时按排序取最前一条的广告
			
				$ad = $advertObj->getOne(array('where'=>array('adpositionid'=>$posid),'order'=>array('sort desc,id desc')));
			}else if($time_style['adtime'] == 1){    //广告类型设置为“按上架时间显示一个"取最后添加的一条广告
			
				$ad = $advertObj->getOne(array('where'=>array('adpositionid'=>$posid),'order'=>array('addtime desc')));
			}
			
			if(!empty($ad)){
				$ad['adimg'] = unserialize(base64_decode($ad['adimg']));
			}

			//对宽高，链接的整合
			$tem = explode(',',$posInfo['adsize']);
			$ad['width'] = $tem[0];
			$ad['height'] = $tem[1];
			$ad['pos'] = $posInfo['pos'];
		
			//对上边距与左边距的操作
			$adpos = explode(",",$posInfo['adpos']);
			$ad['left'] = $adpos[1];
			$ad['up'] = $adpos[0];
			
			if ($time_style['typefilename']=='couplet'){
				
				$adimg = $ad['adimg'];
				$tem = $time_style['attribute'] == 1 ? false : true ;
				
				foreach ($adimg as $ak=>$av) {
					$t = $ak == 0 ? "dl_left" : "dl_right" ;
					$add .= "<div class='dl ".$t."'><a href='".$av['link']."' title='".$av['font']."' target='_blank'><img src='/static/uploadfile/advert/".$av['img']['path']."' width='".$ad['width']."' height='".$ad['height']."' /></a><span class='dl_closebtn'><img src='".IMG_PATH."/close_btn.jpg' /></span></div>";
				}
				
			}else if ($time_style['typefilename'] == 'change') {
				
				$adimg = $ad['adimg'];				
				$tem = $ad['height'] ? $ad['height'] : 171; 
				$add = "<div class='LBGG' id='LBGG'><ul id='picBox' style='top:0px;'>";
				$m ="";
				$t ="";
			    foreach ($adimg as $ak=>$av) {
					$m .= "<li><a href='".$av['link']."'  target='_blank'><img src='static/uploadfile/advert/".$av['img']['path']."' alt='".$av['font']."' width='".$ad['width']."' height='".$ad['height']."'/></a></li>";
					$num = $ak+1;
					$active = $num ==1 ?"active":'';
					$t .= " <li class='".$active."'>".$num."</li>";
				}
				$add .=$m."</ul><ul id='liBox'>".$t."</ul></div>";
				
			}else if ($time_style['typefilename'] == 'adwindow') {
					if ($ad['pos'] == 1) {
						
						$pos = "left:0;";
					} else if ($ad['pos'] == 2) {
						echo 
						$pos = "right:0;";
					}
			}else if ($time_style['typefilename'] == 'turnup') {
					if ($ad['pos'] == 1) {
					
						$add = "q_bevel2";
						$pos = IMG_PATH."/bevel2_2.png";
					} else if ($ad['pos'] == 2) {
						
						$pos =IMG_PATH."/bevel2.png";
					}
		    }else if ($time_style['typefilename'] == 'back') {
					
					$add = HOST_NAME;
			}else if ($time_style['typefilename'] == 'word') {
					
					$add = $this->fontStr($ad,$time_style,$posInfo);
					if ($add &&  $time_style['wordeffect'] ==2) {
						
						$content ="var str1 =\"<link href='[css]/basc.css' type='text/css' rel='stylesheet' /><link href='[css]/GG.css' type='text/css' rel='stylesheet' /><style type='text/css'>#WZGG{[width]px;height:[height]px;margin-left:[left]px;margin-top:[up]px;}</style><div id='WZGG'>".$add."</div>\";document.write(str1);";
					}
			}else if ($time_style['typefilename'] == 'fullscreen') {
					
					$tem = $time_style['closeeffect'];
					$add = IMG_PATH;
			}
			
			if(empty($adimg) && !isset($adimg))
			{
			    $adimg = $ad['adimg'][0];
			}
		}
        if (!isset($content)) {
        	
            $content = file_get_contents("/static/advert/html/".$time_style['typefilename'].".html");
        }
        $content = str_replace(
        		array('[link]','[font]','[path]','[width]','[height]','[css]','[pos]','[add]','[up]','[left]','[id]','[tem]'),
        		@array($adimg['link'],$adimg['font'],$adimg['img']['path'],$ad['width'],$ad['height'],CSS_PATH,$pos,$add,$ad['up'],$ad['left'],$ad['id'],$tem),
        		$content
        		);
	    echo $content;
        
	}
	
	/**
	 * 获取广告位id
	 */
	public function getPosId($id) {
		$advertObj = M("Advert");
		$position = $advertObj->where(array('id'=>$id))->field('adpositionid')->getOne();
		return $position['adpositionid'];
	}
	/**
	 * 文字广告调用
	 * @param $ad array  文字信息
	 * @param $time_style array 广告位类型设置
	 * @param $size array  广告位大小
	 * @return $str 文字字符串
	 */
	public function fontStr($ad,$time_style,$size){
		$str="";
		if(!empty($ad['adimg'])){
			if($time_style['typefilename'] == 'word'){
				//根据广告类型不同是否设置轮播效果
				if($time_style['wordeffect'] ==1)
				{
					 
					$num = round($ad['height']/24);  //每块显示多少条
					$block = ceil(count($ad['adimg'])/$num);  //数组个数
	
					//拼接动态内容的字符串
					for($i=1;$i<=$block;$i++){
						$m = $i-1;
						$str .= "marqueeContent[$m] =\"";
						$start = ($i*$num)-($num-1);
							
						for($j=$start-1;$j<$i*$num;$j++){
							if(isset($ad['adimg'][$j]['link']))
							{
								$str .= "<a href='".$ad['adimg'][$j]['link']."' target='_blank'>".substr($ad['adimg'][$j]['font'],0,$size['fontnum'])."</a>";
							}
						}
						$str .="\";";
					}
					 
				}else{
					foreach($ad['adimg'] as $fk=>$fv)
					{
						$str .="<a href='".$fv['link']."' target='_blank'>".substr($fv['font'],0,$size['fontnum'])."</a>";
					}
				}
			}
		}
		return $str;
	}
}
