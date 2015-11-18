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

class dg{
	
	public function __construct()
	{
		$this->path_data = ROOT .DS. 'data';
		$this->components = ROOT .DS. 'components';
	}
	
	public function url(){
		$pageURL = 'http';
		
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			else
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		$url = explode('tshirtecommerce/', $pageURL);
		
		return $url[0];
	}
	
	function openURL($url)
	{
		if( ini_get('allow_url_fopen') )
		{
			$data = file_get_contents($url);
		}
		else
		{		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch);
			curl_close($ch);
		}
		return $data;
	}
	
	// load language
	public function lang($file = 'lang.ini')
	{
		$file_lang = ROOT .DS. 'data' .DS. 'languages.json';
		$lang = '';
		if (file_exists($file_lang))
		{			
			$languages = json_decode(file_get_contents($file_lang));
			if (count($languages))
			{
				if (isset($_GET['lang']))
				{
					$lang = $_GET['lang'];
					$file_active = 'language_'.$lang.'.ini';
				}
				elseif (isset($_COOKIE['lang']))
				{
					$file_active = 'language_'.$_COOKIE['lang'].'.ini';
					$lang		 = $_COOKIE['lang'];
				}
				
				$check = true;
				if (isset($file_active))
				{
					if (file_exists($this->path_data .DS. $file_active))
					{
						$file = $file_active;
						$check = false;
					}
				}
				
				if($check == true)
				{
					foreach($languages as $language)
					{
						if (isset($language->default) && $language->default == 1)
						{
							if (file_exists(ROOT .DS. 'data' .DS. $language->file))
							{
								$file = $language->file;
								$lang = $language->code;
							}
						}
					}
				}
			}
		}
		$file = $this->path_data .DS. $file;
		setcookie("lang", $lang);
						
		$GLOBALS['lang_active'] = $lang;
		
		if (file_exists($file))
		{
			$data = parse_ini_file($file);
		}
		else
		{
			$data = array();
		}
		
		// update text from extra file
		$lang_plus = $this->path_data .DS. 'lang_plus.ini';
		if (file_exists($lang_plus))
		{
			$langs = parse_ini_file($lang_plus);
			
			if (count($langs))
			{
				foreach($langs as $key => $text)
				{
					if (empty($data[$key]))
					{
						$data[$key] = $text;
					}
				}
			}
		}
		
		return $data;
	}
	
	// load view layout
	public function view($name)
	{
		$file = $this->components .DS. $name. '.php';
		
		if (file_exists($file))
		{
			require_once($file);
		}		
	}
	
	// get products
	public function getProducts()
	{
		$file = $this->path_data .DS. 'products.json';		
		if (file_exists($file))
		{
			$data 		= file_get_contents($file);
			$products 	= json_decode($data);			
			return $products->products;
		}
		else
		{
			return array();
		}
	}
	
	// get attribute of product
	public function getAttributes($attribute)
	{
		if (isset($attribute->name) && $attribute->name != '')
		{
			$attrs = new stdClass();
			
			if (is_string($attribute->name))
				$attrs->name 		= json_decode($attribute->name);
			else
				$attrs->name 		= $attribute->name;
			
			if (is_string($attribute->titles))
				$attrs->titles 		= json_decode($attribute->titles);
			else
				$attrs->titles 		= $attribute->titles;
			
			if (is_string($attribute->prices))
				$attrs->prices 		= json_decode($attribute->prices);
			else
				$attrs->prices 		= $attribute->prices;
			
			if (is_string($attribute->type))
				$attrs->type 		= json_decode($attribute->type);
			else
				$attrs->type 		= $attribute->type;
			
			$html 				= '';
			for ($i=0; $i<count($attrs->name); $i++)
			{
				$html 	.= '<div class="form-group product-fields">';
				$html 	.= 		'<label for="fields">'.$attrs->name[$i].'</label>';
				
				$id 	 = 'attribute['.$i.']';
				$html 	.= 		$this->field($attrs->name[$i], $attrs->titles[$i], $attrs->prices[$i], $attrs->type[$i], $id);
				
				$html 	.= '</div>';
			}
			return $html;
		}
		else
		{
			return '';
		}
	
	}
	
	function field($name, $title, $price, $type, $id)
	{
		$html = '<div class="dg-poduct-fields">';
		switch($type)
		{
			case 'checkbox':
				for ($i=0; $i<count($title); $i++)
				{
					$html .= '<label class="checkbox-inline">';
					$html .= 	'<input type="checkbox" name="'.$id.'['.$i.']" value="'.$i.'"> '.$title[$i];
					$html .= '</label>';
				}
			break;
			
			case 'selectbox':
				$html .= '<select class="form-control input-sm" name="'.$id.'">';
				
				for ($i=0; $i<count($title); $i++)
				{
					$html .= '<option value="'.$i.'">'.$title[$i].'</option>';
				}
				
				$html .= '</select>';
			break;
			
			case 'radio':
				for ($i=0; $i<count($title); $i++)
				{
					$html .= '<label class="radio-inline">';
					$html .= 	'<input type="radio" name="'.$id.'" value="'.$i.'"> '.$title[$i];
					$html .= '</label>';
				}
			break;
			
			case 'textlist':
				$html 		.= '<style>.product-quantity{display:none;}</style><ul class="p-color-sizes list-number col-md-12">';
				for ($i=0; $i<count($title); $i++)
				{
					$html .= '<li>';
					$html .= 	'<label>'.$title[$i].'</label>';
					$html .= 	'<input type="text" class="form-control input-sm size-number" name="'.$id.'['.$i.']">';					
					$html .= '</li>';
				}
				$html 		.= '</ul>';
			break;
		}
		$html	.= '</div>';
		
		return $html;
	}
	
	public function quantity($min = 1, $name = 'Quantity', $name2 = 'minimum quantity: '){
		
		$html = '<div class="form-group product-fields product-quantity">';
		$html .= 	'<label class="col-sm-4">'.$name.'</label>';
		$html .= 	'<div class="col-sm-6">';
		$html .= 		'<input type="text" class="form-control input-sm" value="0" data-count="'.$min.'" name="quantity" id="quantity">';
		$html .= 	'</div>';
		$html .= '</div>';
		
		$html .= '<div class="form-group product-fields>'
			  . '<span class="help-block"><small>'.$name2.$min.'</small></span>'
			  . '</div>';
		
		return $html;
	}
	
	// get products
	public function getSetting()
	{
		$file = $this->path_data .DS. 'settings.json';		
		if (file_exists($file))
		{
			$data 		= file_get_contents($file);			
			$settings 	= json_decode($data);			
			return $settings;
		}
		else
		{
			return array();
		}
	}
	
	/**
	 * Write File
	 *
	 * Writes data to the file specified in the path.
	 * Creates a new file if non-existent.
	 *
	 * @access	public
	 * @param	string	path to file
	 * @param	string	file data
	 * @return	bool
	 */
	public function WriteFile($path, $data)
	{
		if ( ! $fp = fopen($path, 'w'))
		{
			return FALSE;
		}

		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);

		return TRUE;
	}
	
	public function folder($type = 'uploaded')
	{
		$date 	= new DateTime();
		$year	= $date->format('Y');
		$root 	= $type .DS. $year;
		if (!file_exists(ROOT .DS. $root))
			mkdir(ROOT .DS. $root, 0755);
		
		$month 	= $date->format('m');
		$root 	= $root .DS. $month .DS;
		if (!file_exists(ROOT .DS. $root))
			mkdir(ROOT .DS. $root, 0755);
		
		return $root;
	}
	
	// get all file in foder
	public function getFiles($path, $exten = '.txt')
	{
		if (file_exists($path))
		{
			$files = scandir($path);
			if (count($files) == 0)
				return false;
			
			$list = array();
			for($i=0; $i<count($files); $i++)
			{
				if (strpos($files[$i], $exten) > 0)
				{
					$list[] = $files[$i];
				}
			}
			if (count($list) == 0) return false;
			
			return $list;
		}
		else
		{
			return false;
		}
	}
	
	// qrcode
	public function qrcode($text)
	{	
		include_once ROOT .DS. 'includes' .DS. 'libraries' .DS. 'qrcode.php';
		$qr = new qrcode();
		$qr->setText($text);
		
		$image = $qr->getImage(500);
		
		$root = $this->folder();
		
		$file = 'qrcode-'.strtotime("now") . '.png';
		
		$this->WriteFile(ROOT .DS. $root . $file, $image);
		
		return str_replace('\\', '/', $root .DS. $file);
	}
	
	// categories art
	public function categoriestree($return = true)
	{
		$path = ROOT .DS. 'data' .DS. 'categories_art.json';
		$categories = array();
		if (file_exists($path))
		{
			$str	= file_get_contents($path);
			$categories = json_decode($str);
			if (count($categories) > 0)
			{
				$new = array();
				foreach ($categories as $a){
					if ($a->id == 0) continue;
					$new[$a->parent_id][] = $a;
				}
				if (isset($new[0]))
					$tree = $this->createTree($new, $new[0]);
				else
					$tree = $this->createTree($new, $new);
				
				$categories = $tree;
			}
		}
		$all 				= array();
		$all[0]				= new stdClass();
		$all[0]->id 		= 0;
		$all[0]->title 		= 'All Art';
		$all[0]->children 	= array();
		$all[0]->parent_id 	= 0;
			
			
		$categories = array_merge($all, $categories);
		
		if ($return === true)
		{
			return $categories;
			
		}
		else
		{
			echo json_encode($categories);
			exit();
		}
	}
	
	public function createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k=>$l){
			if(isset($list[$l->id])){
				$l->children = $this->createTree($list, $list[$l->id]);
				if ( count($l->children) > 0) $l->isFolder = true;	
			}
			$tree[] = $l;
		} 
		return $tree;
	}
	
	// setup cache
	public function cache($folder = 'design')
	{
		require_once ROOT .DS. 'includes' .DS. 'libraries' .DS. 'phpfastcache.php';
		phpFastCache::setup("storage", "files");
		phpFastCache::setup("path", ROOT .DS. 'cache');
		phpFastCache::setup("securityKey", $folder);
		$cache = phpFastCache();
		
		return $cache;
	}
	
	public function saveDesign()
	{
		$results	= array();
		
		if ( !isset($_COOKIE['design']) )
		{
			$results['error'] = 1;
			$results['login'] = 1;
			$results['msg']	= lang('design_save_login');
			echo json_encode($results);
			exit;
		}
		
		// check user login
		$user = $_COOKIE['design'];
		
		$data = json_decode(file_get_contents('php://input'), true);
		
		$uploaded 	= $this->folder();
		$path		= ROOT .DS. $uploaded;
		
		$temp 		= explode(';base64,', $data['image']);
		$buffer		= base64_decode($temp[1]);
		
		$design 					= array();
		
		if (isset($data['options']))
		{
			$design['options']		= $data['options'];	
		}
		
		$design['vectors']			= $data['vectors'];		
		$design['teams']			= $data['teams'];	
		$design['fonts']			= $data['fonts'];
				
		$designer_id				= $data['designer_id'];
		
		// check design and author
		if ($data['design_file'] != '' && $designer_id == $user && $data['design_key'] != '')
		{
			// override file and update
			$file 			= $data['design_file'];
			
			$path_file		= ROOT .DS. str_replace('/', DS, $file);			
			$key			= $data['design_key'];
			$design['design_id'] 		= $key;
		}
		else
		{
			
			$key 		= strtotime("now"). rand();
			$file 		=  'design-' . $key . '.png';
			
			$path_file	= $path .DS. $file;
			$file		= str_replace('\\', '/', $uploaded) .'/'. $file;
			$file		= str_replace('//', '/', $file);		
			
			$design['design_id'] 		= $key;
		}
		
		
		if ( ! $this->WriteFile($path_file, $buffer))
		{
			$results['error'] = 1;
			$results['msg']	= lang('design_msg_save');
		}
		else
		{
			include_once(ROOT .DS. 'admin' .DS. 'config' .DS. 'config.php');
			$code 	= md5($config['email'].$config['password']);
			if ($user == $code)
			{
				$cache = $this->cache('admin');
			}
			else
			{
				$cache = $this->cache();
			}
			$myDesign = $cache->get($user);
			if ( $myDesign == null )
			{			
				$myDesign = array();
			}
			
			$design['image']			= $file;
			$design['parent_id']		= $data['parent_id'];
			$design['product_id']		= $data['product_id'];
			$design['product_options']  = $data['product_color'];
			
			$design['title']  			= '';
			$design['description']  	= '';
			
			// save design to cache
			$myDesign[$key]	= $design;
			$cache->set($user, $myDesign);
			
			$results['error'] = 0;
			
			$content = array(
				'user_id'=> $user,
				'design_id'=> $key,
				'design_key'=> $key,
				'designer_id'=> $user,
				'design_file'=> $file,					
			);					
			$results['content'] = $content;	

		}
		
		echo json_encode($results);
		exit;
	}
	
	// get price of design
	public function prices($data)
	{
		// get data post
		$product_id		= $data['product_id'];
		$colors			= $data['colors'];
		$print			= $data['print'];		
		$quantity		= $data['quantity'];	
		
		// get attribute
		if ( isset( $data['attribute'] ) )
		{
			$attribute		= $data['attribute'];
		}
		else
		{
			$attribute		= false;
		}
				
		if ($quantity < 1 ) $quantity = 1;
		
		// load product
		$products 		= $this->getProducts();		
		$product 		= false;
		
		for($i=0; $i < count($products); $i++)
		{
			if ($product_id == $products[$i]->id)
			{
				$product = $products[$i];
				break;
			}
		}
		
		if ($product === false)
		{
			echo json_encode( array('error' => 'Product could not be found') );
			exit;
		}
		else
		{
			// load cart
			include_once (ROOT .DS. 'includes' .DS. 'cart.php');
			$cart 		= new dgCart();	
			$post 		= array(
				'colors' 		=> $colors,
				'print' 		=> $print,
				'attribute' 	=> $attribute,
				'quantity' 		=> $quantity,
				'product_id' 	=> $product_id					
			);			
			
			// load setting			
			$setting 		= $this->getSetting();			
			$result 		= $cart->totalPrice($product, $post, $setting);
			
			include_once(ROOT .DS. 'includes' .DS. 'addons.php');					
			$addons 	= new addons();
			$params = array(
				'data' => $data,
				'product' => $product,				
				'setting' => $setting,
				'result' => $result,
			);
			$addons->view('hooks' .DS. 'fields', $params);			
			
			// get cliparts
			$clipartsPrice = array();
			if (isset($data['cliparts']) && count($data['cliparts']) > 0)
			{
				$clipartsPrice = $cart->getPriceArt($data['cliparts']);
			}
			
			$result->cliparts = $clipartsPrice;
			$result->quantity = $quantity;
			
			$total	= new stdClass();
			$total->old = $result->price->base + $result->price->colors + $result->price->prints;
			$total->sale = $result->price->sale + $result->price->colors + $result->price->prints;
				
			if (count($result->cliparts))
			{
				foreach($result->cliparts as $id=>$amount)
				{
					$total->old 	= $total->old + $amount;
					$total->sale 	= $total->sale + $amount;
				}
			}
			
			$total->old 	= ($total->old * $quantity) + $result->price->attribute;
			$total->sale 	= ($total->sale * $quantity) + $result->price->attribute;
			
			$total->old 	= number_format($total->old, 2, '.', ',');
			$total->sale 	= number_format($total->sale, 2, '.', ',');
			
			return $total;
		}	
	}
	
	public function getSVG($post)
	{
		
		$art_id		= $post['clipart_id'];			
		$type		= $post['file_type'];			
		$medium		= $post['medium'];			
		$url		= $post['url'];
		$file_name	= $post['file_name'];
		$colors		= $post['colors'];
						
		$file 	= $url . 'print/' . $file_name;			
		
		include_once (ROOT .DS. 'includes' .DS. 'libraries' .DS. 'svg.php');
					
		$data = array();
		$size = array();
		
		$size['height'] = 100;
		$size['width'] = 100;
		
		$xml = new svg($file, true);
			
		// get width, heigh of svg file
		$width = $xml->getWidth();
		$height = $xml->getHeight();
		
		// calculated width, height
		if($width > $height){
			$newHeight = $size['height'];
			$newWidth = ($size['height'] / $height) * $width;
		}else{
			$newWidth = $size['width'];
			$newHeight = ($size['width'] / $width) * $height;
		}
		
		// set width, height
		$xml->setWidth ($newWidth.'px');
		$xml->setHeight ($newHeight.'px');

		$data['content'] 		= $xml->asXML();
		$data['info']['type'] 	= 'svg';				
		$data['info']['colors'] = json_decode($colors);

		$data['size']['width'] 	= $newWidth . 'px';
		$data['size']['height'] = $newHeight . 'px';
		
		return $data;
	}
	
	// add to cart
	public function addCart($data)
	{
		// get data post
		$product_id		= $data['product_id'];
		$colors			= $data['colors'];
		$print			= $data['print'];		
		$quantity		= $data['quantity'];		
				
		// get attribute
		if ( isset( $data['attribute'] ) )
		{
			$attribute		= $data['attribute'];
		}
		else
		{
			$attribute		= false;
		}
				
		if ($quantity < 1 ) $quantity = 1;
		
		$time = strtotime("now");			
		
		if (isset($data['cliparts']))
		{
			$cliparts = $data['cliparts'];
		}
		else
		{
			$cliparts = false;
		}
		
		$content = array();
		$content['error'] = 1;
		
		// load product
		$products 		= $this->getProducts();		
		$product 		= false;
		
		for($i=0; $i < count($products); $i++)
		{
			if ($product_id == $products[$i]->id)
			{
				$product = $products[$i];
				break;
			}
		}
		
		if ($product === false)
		{
			$content['msg'] = 'Product could not be found';
		}
		else
		{			
			$content['error'] = 0;
			// load cart
			include_once (ROOT .DS. 'includes' .DS. 'cart.php');
			$cart 		= new dgCart();	
			$post 		= array(
				'colors' 		=> $colors,
				'print' 		=> $print,
				'attribute' 	=> $attribute,
				'quantity' 		=> $quantity,
				'product_id' 	=> $product_id					
			);
			
			// load setting			
			$setting 		= $this->getSetting();
			
			$result 		= $cart->totalPrice($product, $post, $setting);
			
			include_once(ROOT .DS. 'includes' .DS. 'addons.php');					
			$addons 	= new addons();
			$params = array(
				'data' => $data,
				'product' => $product,				
				'setting' => $setting,
				'result' => $result,
			);
			$addons->view('hooks' .DS. 'fields', $params);
						
			$result->product	= new stdClass();
			$result->product->name 	= $product->title;
			$result->product->sku 	= $product->sku;
			
			// get cliparts
			$clipartsPrice = array();
			if (isset($data['cliparts']) && count($data['cliparts']) > 0)
			{
				$clipartsPrice = $cart->getPriceArt($data['cliparts']);
			}			
			$result->cliparts = $clipartsPrice;
				
			$total	= new stdClass();			
			$total->old = $result->price->base + $result->price->colors + $result->price->prints;
			$total->sale = $result->price->sale + $result->price->colors + $result->price->prints;
			
			if (count($result->cliparts))
			{
				foreach($result->cliparts as $id=>$amount)
				{					
					$total->old 	= $total->old + $amount;
					$total->sale 	= $total->sale + $amount;				
				}
			}			
			
			if (isset($result->price->attribute))
			{
				$total->old 	= ($total->old * $quantity) + $result->price->attribute;
				$total->sale 	= ($total->sale * $quantity) + $result->price->attribute;
			}
			
			$result->total 	= $total;
			
			// get symbol
			if (!isset($setting->currency_symbol))
				$setting->currency_symbol = '$';
			$result->symbol = $setting->currency_symbol;
			
			// save file image design
			$path = $this->folder();
			$design = array();
			$design['images'] = array();
			if (isset($data['design']['images']['front']))
				$design['images']['front'] 	= $this->createFile($data['design']['images']['front'], $path, 'cart-front-'.$time);
					
			if (isset($data['design']['images']['back']))	
				$design['images']['back'] 	= $this->createFile($data['design']['images']['back'], $path, 'cart-back-'.$time);
				
			if (isset($data['design']['images']['left']))
				$design['images']['left'] 	= $this->createFile($data['design']['images']['left'], $path, 'cart-left-'.$time);
				
			if (isset($data['design']['images']['right']))
				$design['images']['right']	= $this->createFile($data['design']['images']['right'], $path, 'cart-right-'.$time);
						
				
			if (empty($result->options)) $result->options = array();
			
			
			if (isset($data['teams'])) $teams = $data['teams'];
			else $teams = '';
						
			$params = array(
				'data' => $data,
				'result' => $result,
				'design' => $design,
				'setting' => $setting,
			);
			$addons->view('hooks' .DS. 'cart', $params);
			
			// add cart
			$item 	= array(
				'id'      		=> $result->product->sku,
				'product_id'    => $data['product_id'],
				'qty'     		=> $data['quantity'],
				'teams'     	=> $teams,
				'price'   		=> $result->total->sale,
				'prices'   		=> json_encode($result->price),
				'cliparts'   	=> json_encode($result->cliparts),
				'symbol'   		=> $result->symbol,
				'customPrice'   => $result->price->attribute,
				'name'    		=> $result->product->name,
				'time'    		=> $time,
				'options' 		=> $result->options,
			);
			
			$rowid			= md5($result->product->sku . $time);
			$cache			= $this->cache('cart');			
			

			$designs		= array(
				'color' => $data['colors'][key($data['colors'])],
				'images' => $design['images'],
				'vector' => $data['design']['vectors'],
				'fonts' => $data['fonts'],
				'item' => $item
			);
			$cache->set($rowid, $designs);
			
			
			$price_product = $result->total->sale / $quantity;
			$content['product'] = array(
				'rowid'=> $rowid,
				'price'=> $price_product,
				'quantity'=> $quantity,
				'color_hex' => $data['colors'][key($data['colors'])],
				'color_title' => $product->design->color_title[key($data['colors'])],
				'images'=> json_encode($design['images']),
				'teams'=> $teams,
				'options' => $result->options
			);
		}		
		
		return $content;
	}
	
	public function createFile($data, $path, $file)
	{
		$temp 		= explode(';base64,', $data);
		$buffer		= base64_decode($temp[1]);
		
		$path_file 	= ROOT .DS. $path .DS. $file .'.png';
		$path_file	= str_replace('/', DS, $path_file);
		
		if ( $this->WriteFile($path_file, $buffer) === false)
			return '';
		else
			return str_replace('\\', '/', $path .DS. $file .'.png');
	}
	
	public function perpage($width, $height, $proportion)
	{
		$width = $width * $proportion['width'];
		$height = $height * $proportion['height'];
		
		$pagesW = array('0' => 10.5, '1' => 14.8, '2' => 21.0, '3' => 29.7, '4' => 42, '5' => 59.4, '6' => 84.1);
		$pagesH = array('0' => 14.8, '1' => 21, '2' => 29.7, '3' => 42, '4' => 59.4, '5' => 84.1, '6' => 118.9);

		if ($width <= $pagesW[0] && $height <= $pagesH[0])
				return 6;
			
		$size = 6;
		for($i=1; $i<=6; $i++)
		{
			if (($width <= $pagesW[$i] && $height<=$pagesH[$i]) || ($width < $pagesH[$i] && $height < $pagesW[$i]))
			{
				return 6 - $i;
			}
		}
			
		return 0;
	}
}

// get language
function lang($key, $string = false)
{
	$lang = $GLOBALS['lang'];	
	
	if ( isset($lang[$key]) )
	{
		$txt = $lang[$key];
	}
	else
	{
		$txt = '';
	}
	
	if($string === false)
		echo $txt;
	else
		return $txt;
			
}

// get images
function base_url($url)
{
	return $url;
}

function imageURL($src, $site_url = '')
{
	if ($src == '') return '';
	
	if (strpos($src, 'http') !== false)
		return $src;
	
	$url 		= str_replace('//tshirtecommerce', '/tshirtecommerce', $site_url);
	$temp 		= explode('tshirtecommerce/', $url);
	
	return $temp[0].'tshirtecommerce/'.$src;
}

function setValue($data, $key, $default)
{
	if (isset($data->$key))
		return $data->$key;
	else
		return $default;
}

function cssShow($data, $key, $default = 1)
{
	if (isset($data->$key))
		$value = $data->$key;
	else
		$value = $default;
	
	if ($value == 1)
		return '';
	else
		return 'style="display:none;"';
}