<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('ROOT')) exit('No direct script access allowed');

// load all addon
class addons extends dg{
	
	public $base_url 	= '';
	public $lang 		= array();
	
	public function __construct($url = '')
	{
		if ($url == '')
		{
			$this->base_url = $this->url();
		}
		else
		{
			$this->base_url = $url;
		}
		$this->base_url .= 'tshirtecommerce/';
		
		// get language default
		$langcode = '';
		$file_lang = dirname(ROOT) .DS. 'data' .DS. 'languages.json';
		if (file_exists($file_lang))
		{			
			$languages = json_decode(file_get_contents($file_lang));
			if (count($languages))
			{
				foreach($languages as $language)
				{
					if (isset($language->default) && $language->default == 1)
					{
						if (file_exists(ROOT .DS. 'data' .DS. $language->file))
						{
							$langcode = $language->code;
						}
					}
				}
			}
		}
		
		// get language
		$path 		= dirname(ROOT) .DS. 'addons' .DS. 'admin' .DS. 'language' .DS;
		$files 		= $this->getFiles($path, '.ini');
				
		if ($files != false)
		{
			if ($langcode != '')
			{
				for($i=0; $i<count($files); $i++)
				{
					$file = $path . $langcode .DS. $files[$i];
					if (file_exists($file))
						$lang = parse_ini_file($file);
					else
						$lang = parse_ini_file($path . $files[$i]);
					$this->lang = array_merge($this->lang, $lang);
				}
			}
			else
			{
				for($i=0; $i<count($files); $i++)
				{
					$lang = parse_ini_file($path . $files[$i]);
					$this->lang = array_merge($this->lang, $lang);
				}
			}
		}
	}
	
	public function __($text)
	{
		if (isset($this->lang[$text]))
			return $this->lang[$text];
		else
			return '';
	}
	
	// load css
	public function css()
	{
		$url 	= $this->base_url . 'addons/admin/css/';
		$path 	= dirname(ROOT) .DS. 'addons' .DS. 'admin' .DS. 'css' .DS;
		
		$files 		= $this->getFiles($path, '.css');
		
		if ($files === false) return '';
		
		$csss 		= '';
		for($i=0; $i<count($files); $i++)
		{
			$csss 	.= '<link type="text/css" href="'.$url.$files[$i].'" rel="stylesheet" media="all"/>';
		}
		
		return $csss;
	}
	
	// load js
	public function js($admin = false)
	{
		$url 	= $this->base_url . 'addons/admin/js/';
		$path 	= dirname(ROOT) .DS. 'addons' .DS. 'admin' .DS. 'js' .DS;
		
		$files 		= $this->getFiles($path, '.js');
		if ($files === false) return '';
		
		$jss 		= '';
		for($i=0; $i<count($files); $i++)
		{
			$jss 	.= '<script type="text/javascript" src="'.$url.$files[$i].'"></script>';
		}
		
		return $jss;
	}
	
	// load text editer option
	public function view($type, $addons = '', $data = '')
	{
		$path 		= dirname(ROOT) .DS. 'addons' .DS. 'admin' .DS. $type .DS;		
		$files 		= $this->getFiles($path, '.php');
		if ($files === false) return;
				
		for($i=0; $i<count($files); $i++)
		{
			include_once($path . $files[$i]);
		}
	}
}

?>