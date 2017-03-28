<?php
/**
 *--------------------------------------------------------------------------------------
 * iZhanCMS 爱站内容管理系统  (http://www.izhancms.com)
 *
 * SpecialtplModel.php
 *
 * 专题服务
 *
 * @author     雷少进<leishaojin@mail.b2b.cn>   2013-01-31 15:06
 * @filename   MsgMessageModel.php  UTF-8
 * @copyright  Copyright (c) 2004-2012 Mainone Technologies Inc. (http://www.b2b.cn)
 * @license    http://www.izhancms.com/license/   iZhanCMS 1.0
 * @version    iZhanCMS 1.0
 * @link       http://www.izhancms.com
 * @link       http://www.b2b.cn
 * @since      1.0.0
 *-------------------------------------------------------------------------------------
 */

class SpecialtplModel extends Model
{
	public $pk = "";
	public $tableName = "";

	/**
	 * 获取专题模板目录配置
	 * @param 目录列表
	 * @return array
	 */
	function getTemplateConf ($folder_list)
	{
		$conf = array();
		foreach ($folder_list as $key => $val )
		{
			$conf[$val] = $this->getTemplateConfByFolder($val);
		}
		return $conf;
	}

	/**
	 * 获取模板配置
	 * @param 模板目录名
	 * @return array();
	 */
	function getTemplateConfByFolder ($folder)
	{
		$_conf = $this->_getTemplateConfByFolder($folder);
		//模板其他配置
		$_conf['folder'] = $folder;//模板目录
		$_conf['cover']  = $this -> getTplhttpUrl($folder).$this->getTplCoverImage($folder);//模板封面
		return $_conf;
	}

	/**
	 * 获取相关模板http 访问路劲
	 * @param 目录名
	 * @return http url
	 */
	function getTplhttpUrl ($folder)
	{
		return $this -> getSpecialTplHttpUrl().$folder.'/';
	}

	/**
	 * 获取专题模板根目录http访问路径
	 * @return  http url
	 */
	function getSpecialTplHttpUrl ()
	{
		return URL_TPL.'special/';
	}

	/**
	 * 获取模板封面图片
	 * @param 模板目录名
	 * @return 图片路径
	 */
	function getTplCoverImage ($folder)
	{
		$img = $this -> getTplFolderImage($folder);
		if(!empty($img))
		{
			return array_shift($img);
		}
		return '';
	}

	/**
	 * 获取模板目录下的图片文件
	 * @param 目录
	 * @return array()
	 */
	function getTplFolderImage ($folder)
	{
		$path = $this->getTplPathByFolder($folder);
		return MoFolder::readFileByPrefix($path,'','jpg');
	}

	/**
	 * 获取模板基本配置
	 * @param 模板目录名
	 * @return array();
	 */
	function _getTemplateConfByFolder ($folder)
	{
		$conf_file = $this->getTemplateConfFile($folder);//模板信息配置文件
		$_conf =array();
		if(is_file($conf_file))
		{
			$_conf = include($conf_file);
		}

		if(!is_array($_conf) || empty($_conf))
		{
			$_conf = $this->writeTplDefaultConf($conf_file);
		}
		return $_conf;
	}

	/**
	 * 写模板默认配置
	 * @param 配置文件完整路径，目录必须存在
	 * @return array() 默认配置
	 */
	function writeTplDefaultConf ($conf_file)
	{
		$conf = $this->getTemplateDefaultConf();
		$this->writeTplConf($conf_file,$conf);
		return $conf;
	}

	/**
	 * 写模板配置
	 * @param
	 * @return null
	 */
	function writeTplConf ($conf_file,$conf)
	{
		$conf_str = '<?php return '.MoFile::varToString($conf).';';
		MoFile::write($conf_file,$conf_str);
		return $conf;
	}

	/**
	 * 更新模板配置文件
	 * @param 目录
	 * @param 配置
	 * @return true
	 */
	function updateTplConf ($folder,$conf)
	{
		$_conf = $this -> _getTemplateConfByFolder($folder);
		$_conf = array_merge($_conf,$conf);
		$conf_file = $this -> getTemplateConfFile($folder);
		$this -> writeTplConf($conf_file,$_conf);
		return true;
	}

	/**
	 * 更新模板封面
	 * @param 封面图片信息
	 * @return true
	 */
	function updateTplCover ($folder,$thumb)
	{
		$image = current($thumb);
		if(!empty($image))
		{
			$base_name   = basename($image['path']);
			$new_file    = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.$base_name;
			$target_path = $this -> getTplPathByFolder($folder);
			$target_file = $target_path.$base_name;

			if(is_file($new_file))
			{
				$old_img = $this -> getTplFolderImage($folder);
				$res = MoFile::moveFile($new_file,$target_file);
				if(!$res)
				{
					//删除老图片
					foreach($old_img as $val)
					{
						MoFile::unlinkFile($target_path.$val);
					}
				}
			}
		}
		return true;
	}

	/**
	 * 获取模板默认配置
	 */
	private function getTemplateDefaultConf ()
	{
		return array
		(
			'name'     =>'专题模板',
			'version'  =>'',
			'author'   =>'铭万团队',
			'status'   =>'close',
			'describe' =>''
		);
	}

	/**
	 * 获取模板配置文件完整路径名
	 */
	function getTemplateConfFile ($folder)
	{
		return $this->getTemplateConfPath($folder).'config.php';
	}

	/**
	 * 获取完成模板配置文件路径
	 * @param
	 * @return null
	 */
	function getTemplateConfPath ($folder)
	{
		return $this->getTplPathByFolder($folder);
	}

	/**
	 * 获取模板目录
	 * @param 模板目录名
	 * @return 完整的模板目录路径
	 */
	function getTplPathByFolder ($folder)
	{
		return $this->getSpecialFolder().$folder.DIRECTORY_SEPARATOR;
	}

	/**
	 * 获取专题所有模板目录
	 * @return 一维数组目录
	 */
	function getTemplateFolder ()
	{
		return MoFolder::read($this -> getSpecialFolder(),2);
	}

	/**
	 * 获取专题模板根目录
	 * @return path
	 */
	function getSpecialFolder ()
	{
		return PATH_TEMPLATE.'special'.DIRECTORY_SEPARATOR;
	}

	/**
	 * 创建一个压缩包
	 * @param
	 * @return
	 */
	function createZipByFolder ($folder)
	{
		$zip_name = 'special_'.$folder.'_'.date('YmdHis').'.zip';
		$tpl_path = $this -> getSpecialFolder();
		$zip_path = $this -> getTplPathByFolder($folder);

		$zip_target_path = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.$zip_name;
		$zip = new PclZip($zip_target_path);
		$v_list = $zip->create($zip_path,PCLZIP_OPT_REMOVE_PATH, $tpl_path,PCLZIP_OPT_ADD_PATH,'');
        if ($v_list == 0)
		{
           return false;
        }
		return $zip_target_path;
	}

	/**
	 * 获取文件列表
	 * @param 目录名
	 * @return array
	 */
	function getTplFileList ($folder)
	{
		$path = $this->getTplPathByFolder($folder);
		return MoFolder::readFileByPrefix($path,'','html');
	}

	/**
	 * 获取标签帮助配置
	 * @return array 标签帮助文件
	 * @return array 标签帮助文件
	 */
	function getTagHelpFileConf()
	{
		$path = DIR_TAG.'help'.DIRECTORY_SEPARATOR;
		$file = $this -> getTagHelpFile();
		$tmp = array();
		foreach ($file as $val )
		{
			$tmp[rtrim($val,'.php')] = include($path.$val);
		}
		return $tmp;
	}

	/**
	 * 获取标签帮助配置
	 * @return array 标签帮助文件
	 * @return array 标签帮助文件
	 */
	function getTagHelpFile ()
	{
		$path = DIR_TAG.'help'.DIRECTORY_SEPARATOR;
		return MoFolder::readFileByPrefix($path,'','php');
	}

	/**
	 * 获取模板文件内容
	 * @param 目录
	 * @param 文件名
	 * @return 文件内容
	 */
	function getFileContent ($folder,$file)
	{
		$file_path = $this -> getTplPathByFolder($folder).$file;
		return MoFile::read($file_path);
	}

	/**
	 * 更新模板内容
	 * @param 目录
	 * @param 文件名
	 * @param 内容
	 * @return 写入的字节数
	 */
	function updateTplContent ($folder,$filename,$content)
	{
		$file = $this -> getTplPathByFolder($folder).$filename;
		return MoFile::write($file,$content);
	}

	/**
	 * 删除专题模板文件
	 * @param 目录
	 * @param 文件名
	 * @return bool
	 */
	function delTplFile ($folder,$filename)
	{
		$file = $this -> getTplPathByFolder($folder).$filename;
		return MoFile::unlinkFile($file);
	}

	/**
	 * 更新专题模板文件配置
	 * @param 目录
	 * @param 模板文件名
	 * @param 描述
	 * @return bool
	 */
	function updateTplConfInfo ($folder,$filename,$info=array())
	{
		if(!is_array($info))
		{
			return true;
		}

		$conf = $this -> _getTemplateConfByFolder($folder);
		$info = array_merge($info,array('update'=> date('Y-m-d H:i:s')));
		$conf['file'][$filename] = $info;
		$this -> updateTplConf($folder,$conf);
	}

	/**************************************************************/
	/**************************************************************/
	/*********************                      *******************/
	/*********************   模板皮肤相关操作   *******************/
	/*********************                      *******************/
	/**************************************************************/
	/**************************************************************/
	/**
	 * 获取模板皮肤文件夹
	 * @param 模板目录
	 * @return string
	 */
	function getSkinFolder ($folder)
	{
		return $this -> getTplPathByFolder($folder).'skin'.DIRECTORY_SEPARATOR;
	}

	/**
	 * 获取专题皮肤
	 * @param 目录
	 * @return array ()
	 */
	function getTemplateSkinFolder ($folder)
	{
		return MoFolder::read($this -> getSkinFolder($folder),2);
	}

	/**
	 * 获取专题模板皮肤配置
	 * @param
	 * @return
	 */
	function getTemplateSkinConf ($folder,$skin_list)
	{
		$conf = array();
		foreach ($skin_list as $key => $val )
		{
			$conf[$val] = $this->getTemplateSkinConfByFolder($folder,$val);
		}
		return $conf;
	}

	/**
	 * 获取模板皮肤配置
	 * @param
	 * @return
	 */
	function getTemplateSkinConfByFolder ($folder,$skin)
	{
		$_conf = $this->_getTemplateSkinConfByFolder($folder,$skin);
		//模板其他配置
		$_conf['folder'] = $skin;//皮肤目录

		$cover_file = $this->getSkinCoverImage($folder,$skin);
		$_conf['cover']  = $cover_file ? $this -> getTplhttpUrl($folder).'skin/'.$skin.'/'.$cover_file : '';//模板封面
		return $_conf;
	}

	/**
	 * 获取皮肤配置文件
	 * @param 模板目录
	 * @param 皮肤目录
	 * @return array();
	 */
	function _getTemplateSkinConfByFolder ($folder,$skin)
	{
		$conf_file = $this -> getTplSkinConfigFIle($folder,$skin);
		$_conf =array();
		if(is_file($conf_file))
		{
			$_conf = include($conf_file);
		}

		if(!is_array($_conf) || empty($_conf))
		{
			$_conf = array
			(
				'name'     =>'专题皮肤',
				'version'  =>'',
				'author'   =>'铭万团队',
				'describe' =>''
			);
			$this -> writeTplConf($conf_file,$_conf);
		}
		return $_conf;
	}

	/**
	 * 获取皮肤配置文件路径
	 * @param 模板目录
	 * @param 皮肤目录
	 * @return path
	 */
	function getTplSkinConfigFIle ($folder,$skin)
	{
		return $this->getSkinFolder($folder).$skin.DIRECTORY_SEPARATOR.'config.php';
	}

	/**
	 * 获取模板封面图片
	 * @param 模板目录名
	 * @return 图片路径
	 */
	function getSkinCoverImage ($folder,$skin)
	{
		$img = $this -> getSkinFolderImage($folder,$skin);
		if(!empty($img))
		{
			return array_shift($img);
		}
		return '';
	}

	/**
	 * 获取模板目录下的图片文件
	 * @param 目录
	 * @return array()
	 */
	function getSkinFolderImage ($folder,$skin)
	{
		$path = $this->getSkinFolder($folder).$skin;
        $arr = array(
            'jpg',
            'jpeg',
            'png',
            'bmp',
            'gif'
        );
        foreach ($arr as $val) {
            $result = MoFolder::readFileByPrefix($path, '', $val);
            if ($result) {
                return $result;
            }
        }
        return false;
	}

	/**
	 * 创建模板皮肤压缩包
	 * @param 模板目录
	 * @param 皮肤目录
	 * @return path
	 */
	function createSkinZip ($folder,$skin)
	{
		$zip_name = 'special_'.$folder.'_'.$skin.'_'.date('YmdHis').'.zip';
		$skin_path =  $this->getSkinFolder($folder);
		$zip_path = $this->getSkinFolder($folder).$skin.DIRECTORY_SEPARATOR;
		$zip_target_path = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.$zip_name;
		$zip = new PclZip($zip_target_path);
		$v_list = $zip->create($zip_path,PCLZIP_OPT_REMOVE_PATH, $skin_path,PCLZIP_OPT_ADD_PATH,'');
        if ($v_list == 0)
		{
           return false;
        }
		return $zip_target_path;
	}

	/**
	 * 删除模板皮肤
	 * @param 模板目录
	 * @param 皮肤目录
	 * @return bool
	 */
	function delTplSkin ($folder,$skin)
	{
		$skin_path = $this->getSkinFolder($folder).$skin.DIRECTORY_SEPARATOR;
		MoFolder::clearRecur($skin_path,true);
	}

	/**
	 * 更新模板皮肤配置文件
	 * @param 模板目录
	 * @param 皮肤目录
	 * @param 配置
	 * @return bool
	 */
	function updateTplSkinConf ($folder,$skin,$conf)
	{
		$_conf = $this -> _getTemplateSkinConfByFolder($folder,$skin);
		$_conf = array_merge($_conf,$conf);
		$conf_file = $this -> getTplSkinConfigFIle($folder,$skin);
		$this -> writeTplConf($conf_file,$_conf);
		return true;
	}

	/**
	 * 更新模板皮肤文件
	 * @param 模板目录
	 * @param 皮肤目录
	 * @param 缩略图信息
	 * @return true
	 */
	function updateTplSkinCover ($folder,$skin,$thumb)
	{
		$image = current($thumb);
		if(!empty($image))
		{
			$base_name   = basename($image['path']);
			$new_file    = PATH_STATIC_UPLOAD.'temp'.DIRECTORY_SEPARATOR.$base_name;
			$target_path = $this -> getSkinFolder($folder).$skin.DIRECTORY_SEPARATOR;
			$target_file = $target_path.$base_name;

			if(is_file($new_file))
			{
				$old_img = $this -> getSkinFolderImage($folder,$skin);
				$res = MoFile::moveFile($new_file,$target_file);
				if(!$res)
				{
					//删除老图片
					foreach($old_img as $val)
					{
						MoFile::unlinkFile($target_path.$val);
					}
				}
			}else if (is_file($_SERVER['DOCUMENT_ROOT'].$image['path'])) {
                $old_img = $this -> getSkinFolderImage($folder,$skin);
                //删除老图片
                foreach($old_img as $val) {
                        MoFile::unlinkFile($target_path.$val);
                }
                copy($_SERVER['DOCUMENT_ROOT'].$image['path'], $target_file);
            } else {

            } 
		}
		return true;
	}


	/**
	 * 根据皮肤类型获取对应专题数量
	 * @return integer
	 */
    public function getSpecialNumbers($skin)
    {
        $sql = "SELECT COUNT(id) AS number FROM ". $this->tablePrefix ."special WHERE skin = '$skin'";
        $result = $this->query($sql);
        return $result[0]['number'];
    }






}