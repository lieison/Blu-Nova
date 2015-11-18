<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * API
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
 
error_reporting(0);

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);

if ( isset($_GET['key']) )
{
	include_once ROOT .DS. 'includes' .DS. 'functions.php';
	
	$key = $_GET['key'];
	$position = $_GET['view'];
	
	$dg = new dg();
	$cache = $dg->cache('design');
	
	$params = explode(':', $key);
	$user_id = $cache->get($params[0]);
	if ($user_id == false or count($user_id) == 0) return false;
	
	$data = $user_id[$params[1]];
		
	if ( count($data) > 0)
	{
		$product_id = $params[2];
		// get product
		$products = $dg->getProducts();
		for($i=0; $i<count($products); $i++)
		{
			if ($products[$i]->id == $product_id)
			{
				$product = $products[$i];
				break;
			}
		}
		
		if (isset($product))
		{
			$design = $product->design;
			if (count($design))
			{
				$files = array();
				
				if (isset($_GET['type']))
				{
					$file = $_GET['type'];
				}
				else
				{
					$file = 'svg';
				}
				
				$area = $design->area;
				if (isset($area->$position) && $area->$position != '')
				{
					$view 		= json_decode(str_replace("'", '"', $area->$position));	
					$radius 	= str_replace('px', '', $view->radius);					
					$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="'.$view->height.'" width="'.$view->width.'">';
					
					// GET DESIGN OF ORDER
					$vectors 		= json_decode($data['vectors']);
					$items			= $vectors->$position;
					if (count($items) == 0)
					{
						echo 'Design is blank';
						exit;
					}
					
					$items			= json_decode ( json_encode($items), true);
					
					function cmp($a, $b)
					{
						return strcmp($a['zIndex'], $b['zIndex']);						
					}
					usort($items, 'cmp');
					
					$items			= json_decode ( json_encode($items) );
					
					foreach($items as $item)
					{
						
						$top 		= str_replace('px', '', $item->top);
						$left 		= str_replace('px', '', $item->left);
						
						$item->svg 	= str_replace('NS1:xmlns:xlink', '', $item->svg); 	// IF IE
						$item->svg 	= str_replace('xmlns:NS1=""', 'xmlns:xlink', $item->svg); 	// IF IE
						$item->svg 	= str_replace('xmlns:xml', 'xmlns:xlink', $item->svg); 	// IF IE
						$item->svg 	= str_replace('XML/1998/namespace', '1999/xlink', $item->svg); 	// IF IE
						$count = explode('xmlns="http://www.w3.org/2000/svg"', $item->svg);
						if ($count > 1)
							$item->svg 	= str_replace('xmlns="http://www.w3.org/2000/svg"', '', $item->svg, $count); 	// IF IE						
						
						
						if ( isset($item->file) && isset($item->file->type) && $item->file->type == 'image' )
						{
							$item->svg 	= str_replace(' /></g>', '></image></g>', $item->svg); 	// IF IE
							$tempStr = explode('<image', $item->svg);
							$item->svg = $tempStr[0] . '<image'. str_replace('xmlns:xlink="http://www.w3.org/1999/xlink"', '', $tempStr[1]);
							
							preg_match_all("/xlink:href=\"(.*)\">/i", $item->svg, $links);
							
							if (isset($links[1][0]))
							{
								$link 	= str_replace('_thumb', '', $links[1][0]);
								
								if ($file == 'svg' && !empty($_GET['download']))
								{									
									$files[] = $link;
									$string = explode('/', $link);
									$file_name = $string[count($string)-1];									
									$temp = explode($links[1][0], $item->svg);
									if (isset($temp[1]))
									{
										$item->svg = $temp[0].$file_name.$temp[1];
									}									
								}
								else
								{
									$data 	= $dg->openURL($link);
									$base64 = 'data:image/PNG;base64,' . base64_encode($data);
									$temp = explode($links[1][0], $item->svg);
									if (isset($temp[1]))
									{
										$item->svg = $temp[0].$base64.$temp[1];
									}								
								}
							}
						}						
						$dom = new DOMDocument();
						$dom->loadXML($item->svg);
						
						if($item->type == 'team')
						{
							$texts = $dom->getElementsByTagName("text");
							foreach ($texts as $text)
							{						
								if ($text->getAttribute('class') != '')
								{
									$action = '';
									if($text->getAttribute('class') == 'team-number')
									{
										$action = 'number';
									}
									else if($text->getAttribute('class') == 'team-name')
									{
										$action = 'name';
									}
																		
									if ($text->hasChildNodes() && $action != '')
									{
										foreach ($text->childNodes as $tspan) {
											if ($action == 'number')
											{
												$team_number = $tspan->nodeValue;
											}											
											else
											{
												$team_name = $tspan->nodeValue;
											}												
										}
									}
								}
							}
						}
						else if($item->type == 'text1')
						{						
							$texts = $dom->getElementsByTagName("text");
							$count_child = 0;
							$dy = 0;
							foreach ($texts as $text){
								$txt = array();
								if ($text->hasChildNodes()) {
									foreach ($text->childNodes as $tspan) {
										$txt[$count_child] = array();
										$txt[$count_child]['text'] = $tspan->nodeValue;
										$txt[$count_child]['x'] = $tspan->getAttribute('x');
										if ($tspan->getAttribute('dy') > $dy)
											$dy = $tspan->getAttribute('dy');
										$count_child++;										
									}
								}
							}
													
							
							foreach ($texts as $text){								
								$note = $text;
								$parent = $text->parentNode;
								for($i=0; $i< $count_child; $i++)
								{																		
									$elm = $dom->createElement('text', htmlentities($txt[$i]['text']));
									foreach ($note->attributes as $attr)
									{
										if ($attr->nodeName == 'y')
										{
											if ($dy == 0) $dy = $attr->nodeValue;
											$elm->setAttribute($attr->nodeName, $dy * ($i + 1) - ($i * 2));
										}
										else if($attr->nodeName == 'text-anchor')
										{
											//$elm->setAttribute($attr->nodeName, 'start');
										}
										else if($attr->nodeName == 'x')
										{
											if ($txt[$i]['x'] == '0')
											{
												$elm->setAttribute($attr->nodeName, 0);
												$elm->setAttribute('text-anchor', 'start');
											}
											else if ($txt[$i]['x'] == '50%')
											{
												$elm->setAttribute($attr->nodeName, '50%');
												$elm->setAttribute('text-anchor', 'middle');
											}
											else
											{
												$elm->setAttribute($attr->nodeName, '100%');
												$elm->setAttribute('text-anchor', 'end');
											}
										}
										else
										{
											$elm->setAttribute($attr->nodeName, $attr->nodeValue);
										}
									}
									$parent->appendChild($elm);
								}
								$text->parentNode->removeChild($text);
								break;								
							}						
						}						
						
						$x = $dom->getElementsByTagName("svg");
						foreach ($x as $xx){
							$xx->removeAttribute("x");
							$xx->removeAttribute("y");
						}									
						$item->svg = $dom->saveXML();					
						
						if (isset($item->rotate) && $item->rotate != 0)
						{
							$width 		= str_replace('px', '', $item->width);
							$height 	= str_replace('px', '', $item->height);
							$width		= (int) $width/2;
							$height		= (int) $height/2;

							$strsvg 	= str_replace('<svg ', '<svg ', $item->svg);
							
							
							$svgPNG 	= $svg . '<g transform="translate('.($left*10).', '.($top*10).')  rotate('.$item->rotate.' '.($width*10).' '.($height*10).')">'.$strsvg.'</g>';							
							$svg 		.= '<g transform="translate('.$left.', '.$top.')  rotate('.$item->rotate.' '.$width.' '.$height.')">'.$strsvg.'</g>';
						}
						else
						{
							$svg 		.= str_replace('<svg ', '<svg y="'.$top.'" x="'.$left.'" ', $item->svg);
							if (isset($svgPNG))
								$svgPNG		.= str_replace('<svg ', '<svg y="'.$top.'" x="'.$left.'" ', $item->svg);
							else
								$svgPNG		= $svg;
						}
					}					
						
					$svg .= '</svg>';
					$svgPNG .= '</svg>';
					
					$svg 	= str_replace('<?xml version="1.0"?>', '', $svg);
					$svgPNG = str_replace('<?xml version="1.0"?>', '', $svgPNG);										
					
					// create folder of order
					$path = ROOT .DS. 'uploaded' .DS. 'orders';
					if (!file_exists($path))
						mkdir($path, 0755);
					
					if (isset($_GET['order']))
						$order = $_GET['order'];
					else
						$order = $_GET['key'];
					
					$tempPath = explode(':', $order);
					
					$path = $path .DS. $tempPath[1];
					if (!file_exists($path))
						mkdir($path, 0755);
		
		
					$setting 	= $dg->getSetting();					
					include_once(ROOT .DS. 'includes' .DS. 'addons.php');					
					$addons 	= new addons();
					$addons->view('hooks' .DS. 'download');
					
					$file_name = $position .'-'. rand() .'.svg';			
					$dg->WriteFile($path .DS. $file_name, $svg);
					
					
					if ($file == 'svg')
					{
						if (!empty($_GET['download']))
						{							
							// zip files
							if (count($files))
							{
								$ij = 0;								
								foreach($files as $file)
								{
									$string = str_replace($dg->url(), '', $file);
									$string = str_replace('/', DS, $string);
									$string = dirname(ROOT) .DS. $string;
									$array[$ij] = $string;
									$ij++;
								}
								$files = $array;
							}
							$files[] = $path .DS. $file_name;
							
							// zip all file
							$zipname = $path .DS. $position .'-'. $tempPath[1].'.zip';
							$zip = new ZipArchive();
							if ($zip->open($zipname, ZipArchive::CREATE) === TRUE)
							{
								foreach ($files as $file_oput)
								{
									$string = explode(DS, $file_oput);
									$file_name = $string[count($string)-1];
									
									$zip->addFile($file_oput, $file_name);
								}
								$zip->close();
							}
							// download file
							header('Content-Type: application/zip');
							header('Content-disposition: attachment; filename='.$zipname);
							header('Content-Length: ' . filesize($zipname));
							readfile($zipname);
							exit;
							
							//header('Content-type:image/svg+xml');						
							//header('Content-Disposition: attachment; filename="'.$position.'.svg"');
						}
						echo $svg;
					}
					else
					{						
						$dom = new DOMDocument;
						
						$dom->loadXML($svgPNG);
						
						$books = $dom->getElementsByTagName('svg');
						foreach ($books as $book)
						{
							$width 	= $book->getAttribute('width') * 10;
							if ($width > 0)
								$book->setAttribute('width', $width);							
														
							$height 	= $book->getAttribute('height') * 10;
							if ($height > 0)
								$book->setAttribute('height', $height);							
							
							$x 	= $book->getAttribute('x') * 10;
							$book->setAttribute('x', $x);
							
							$y 	= $book->getAttribute('y') * 10;
							$book->setAttribute('y', $y);
						}
												
						$image 	= $dom->getElementsByTagName('image');							
						foreach ($image as $img)
						{
							$width 	= $img->getAttribute('width') * 10;							
							$img->setAttribute('width', $width);
							$height 	= $img->getAttribute('height') * 10;
							$img->setAttribute('height', $height);	
						}
						$svgPNG = $dom->saveXML();						
												
						echo $svgPNG;
					}
					exit;
				}
			}
			else
			{
				echo 'Design not found';
			}
		}
		else
		{
			echo 'Design not found';
		}
	}
	else
	{
		echo 'Design not found';
	}
}
else
{
	echo 'Design not found';
}
?>