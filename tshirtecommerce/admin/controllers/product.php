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

defined("UNROOT") or define("UNROOT", "tshirtecommerce\admin");
defined("WC_DIRECTORY") or define("WC_DIRECTORY", "tshirtecommerce");

class Product extends Controllers
{
	
	public function index()
	{	
		$data = array();
		
		$data['title'] 		= 'Products';
		$data['sub_title'] 	= 'Manage';
		
		$dgClass 			= new dg();	
		$products 			= $dgClass->getProducts();	
		
		//sort array().
		$sort = array();
		foreach($products as $key=>$val)
		{
			$count = 0;
			$vl = array();
			foreach($products as $k=>$v)
			{
				if($count <= $k && !isset($sort[$k]))
				{
					$count = $k;
					$vl = $v;
				}
			}
			$sort[$count] = $vl;
		}
		
		// get admin info.
		include_once(ROOT .DS. 'config' .DS. 'config.php');
		$code 			= md5($config['email'] .'design-template'. $config['password']);		
		
		$url_design 	= str_replace('admin/', 'admin-template.php', site_url_ci());
		$url_design 	= $url_design . '?token='.$code;
		
		$data['url_design']	= $url_design;
		$data['products']	= $sort;
		
		$this->view('products', $data);
	}
	
	public function page($segment = 0)
	{
		// get Products.
		$dgClass 			= new dg();	
		$products 			= $dgClass->getProducts();		
		
		if(isset($products))
		{
		
			$search = array();
			foreach($products as $key=>$val)
			{
				if(!empty($_POST['search_product']))
				{
					if(strpos(strtolower($val->title), strtolower($_POST["search_product"])) !== false)
						$search[$key] = $val;
				}else
				{
					$search[$key] = $val;
				}
			}
			
			//sort array().
			$sort = array();
			foreach($search as $key=>$val)
			{
				$count = 0;
				$vl = array();
				foreach($search as $k=>$v)
				{
					if($count <= $k && !isset($sort[$k]))
					{
						$count = $k;
						$vl = $v;
					}
				}
				$sort[$count] = $vl;
			}
			
			$page = array();
			if(isset($_POST['per_page']))
				$perpage = $_POST['per_page'];
			else
				$perpage = 10; 
				
			if($perpage == 'all')
				$perpage = count($sort);
			$j = 1;
			foreach($sort as $key=>$val)
			{
				if($j > $segment && $j <= ($perpage+$segment))
					$page[$key] = $sort[$key];
				$j++;
			}
			
			if($perpage < count($sort))
				$data['page'] = $perpage;
			else
				$data['page'] = 0;
			$data['products'] = $page;
			$data['total'] = count($sort);
			$data['segment'] = $segment;
			include_once(ROOT.DS.'views/product.php');
		}else
		{
			return;
		}
	}
	
	public function edit($id = 0, $error = 2)
	{
		$data = array();
		
		$data['title'] 		= 'Product';
		$data['sub_title'] 	= 'Add';
		$data['cate_checked']	= array();
		
		$is_new = true;
		if ($id > 0)
		{
			$dgClass 			= new dg();	
			$products 			= $dgClass->getProducts();		
			if (count($products) > 0)
			{
				foreach($products as $row)
				{
					if ($row->id == $id)
					{
						$is_new = false;
						$product = $row;
						break;
					}
				}
			}
			$product_cate = $dgClass->getProductCategories();
			$data_cate = array();
			foreach($product_cate as $val)
			{
				if($val->product_id == $id)
					$data_cate[] = $val->cate_id;
			}
			$data['cate_checked'] = $data_cate;
		}
		
		if ($is_new === true)
		{
			$product 		= new stdClass();			
		}
		$data['error']		= $error;
		$data['product']	= $product;
		
		$this->view('edit_product', $data);
	}
	
	public function colors($f = null, $id = null)
	{
		$data = array();
		$dgClass 			= new dg();	
		$colors 			= $dgClass->getColors();
		$data['colors']		= $colors;
		$data['function'] 	= $f;			
		$data['id'] 		= $id;
		
		$this->modal('color', $data);
	}
	
	public function design()
	{
		$data = array();
		$data['position'] 			= $_POST['position'];
		$data['color'] 				= $_POST['color'];
		$data['title'] 				= $_POST['title'];
		$data['number'] 			= $_POST['number'];
		
		$this->modal('design', $data);
	}
	
	public function save()
	{
            
            
            
                
                //ROOT DEL SISTEMA 
                $unroot = str_replace(UNROOT, "", ROOT );
            
            
                //ENTRA LOS DATOS POST DEL PRODUCTO , FORMATO ARRAY 
		$data = $_POST['product'];
                
                
             
                $attributes = array();
               
                //CUENTA LOS CAMPOS
		if (isset($data['fields']) && count($data['fields']) > 0)
		{
			$attributes['name'] 		= array();
			$attributes['prices'] 		= array();
			$attributes['titles'] 		= array();
			$attributes['type'] 		= array();
			$i=0;
			foreach($data['fields'] as $filed)
			{				
				$attributes['name'][$i] 	= $filed['name'];
				$attributes['prices'][$i] 	= $filed['prices'];
				$attributes['titles'][$i] 	= $filed['titles'];
				$attributes['type'][$i] 	= $filed['type'];
				$i++;
			}
		}
                
		unset($data['fields']);
                
		$data['attributes'] = $attributes;
		
		$dgClass 				= new dg();
		$content 				= array('products'=> array());	
                
                $the_new                                = false;
                
		// get id
                
                $id         = null;
             
		if ($data['id'] == 0)
		{
			$id 				= 1;
			$products 			= $dgClass->getProducts();		
			if (count($products) > 0)
			{
				foreach($products as $product)
				{
					if ($product->id > $id)
						$id = $product->id;
				}
				$id = $id + 1;
			}
			$data['id'] = $id;
			
			$products[] = $data;
			$content['products'] = $products;
                        $the_new = true;
   
		}
		else
		{			
			$products 			= $dgClass->getProducts();
			
			$is_new 			= true;
                        
			if (count($products) > 0)
			{
				foreach($products as $product)
				{
					if ($product->id == $data['id'])
					{
						$content['products'][]  = $data;
						$is_new 	= false;
					}
					else
					{
						$content['products'][] = $product;
                                               
					}
				}
			}
			
			if ($is_new === true)
			{
				$products[] = $data;
				$content['products']	= $products;  
			}
                      
                        
		}
                
                
                
                
                if($the_new){
                    
                    
                       
                
                         //ADAPTACION A WOOCOMMERCE
                         require $unroot . 'wp-content/plugins/' . WC_DIRECTORY .  '/save_tshirt.php';
                         
                        $lieson_                                       = new LieisonTshirt($unroot);
                        $post_id                                       = $lieson_->Save_WC($data);
                        $count                                         = count($content['products']) -1 ;
                        $content['products'][$count]['id_post']        = isset($post_id) ? $post_id : 0;
                         
                       
                         //end woocomerces
                }
                else{
                    
                        $dgs = new dg();
                        $id_post = null;
                        
                        
                        foreach ($dgs->getProducts() as $v){
                            if($v->id == $data['id']){
                                $id_post = $v->id_post;
                                $data['id_post'] = $v->id_post ;
                            }
                        }

                        require $unroot . 'wp-content/plugins/' . WC_DIRECTORY .  '/save_tshirt.php';
                        //EN CASO DE EDICION DE PRECIOS U OTRA COSA QUE SEA WOOCOMMERCES
                        $lieson_               = new LieisonTshirt($unroot);
                        $lieson_->Update_WC($data, $id_post);
                        
                        $resing = $content['products'];
                        
                        
                        foreach ($resing as $k=>$pro)
                        {
                            if(is_array($pro)){
                                if($pro['id'] == $data['id']){
                                    $content['products'][$k]['id_post'] = $data['id_post'];
                                }
                            }
                            
                        }
                        
                        
                        
                }
                
                
             //   echo "<pre>" , print_r($data) , "</pre>";
              //  echo "<br>" ;
              //  echo "<pre>" , print_r($content) , "</pre>";
              //  return;
                
                
		
		$content = str_replace('\\\\', '', json_encode($content));
		
		// write file
		$path = dirname(ROOT) .DS. 'data' .DS. 'products.json';
		$check = $dgClass->WriteFile($path, $content);
		
		// update categories.		
		if(isset($_POST['category']))
		{
			$categories = $_POST['category'];
			$data_cate = array();
			$category = $dgClass->getProductCategories();
			if(count($categories))
			{
				$cid = 0;
				if(count($category))
				{
					foreach($category as $val)
					{
						if($val->product_id != $data['id'])
						{
							$data_cate[] = $val;
							if($val->id > $cid)
								$cid = $val->id;
						}
					}
				}
				
				foreach($categories as $val)
				{
					$cid++;
					$catedt = new stdClass();
					$catedt->id = $cid;
					$catedt->product_id = $data['id'];
					$catedt->cate_id = $val;
					$data_cate[] = $catedt;
				}
			}
			else
			{
				if(count($category))
				{
					foreach($category as $val)
					{
						if($val->product_id != $data['id'])
						{
							$data_cate[] = $val;
						}
					}
				}
			}
		}
		else
		{
			$category = $dgClass->getProductCategories();
			if(count($category))
			{
				foreach($category as $val)
				{
					if($val->product_id != $data['id'])
					{
						$data_cate[] = $val;
					}
				}
			}
		}
                

                
              
                
		// write file
                
               
		$path = dirname(ROOT) .DS. 'data' .DS. 'product_categories.json';
		$check = $dgClass->WriteFile($path, json_encode($data_cate));
                

		
		if ($check === false)
			$dgClass->redirect('index.php/product/edit/'.$data['id'].'/0');
		else
			$dgClass->redirect('index.php/product/edit/'.$data['id'].'/1');
                
                
	}
	
	public function unpublish($id = 0)
	{
		$dgClass 				= new dg();
		
		if ($id > 0)
		{
			$products 			= $dgClass->getProducts();				
			if (count($products) > 0)
			{
				$content 		= array('products'=> array());
				foreach($products as $product)
				{
					if ($product->id == $id)
					{
						$product->published = 0;
					}
					$content['products'][] = $product;
				}
			}
			$path = dirname(ROOT) .DS. 'data' .DS. 'products.json';
			$check = $dgClass->WriteFile($path, json_encode($content));
		}
		
		
		$dgClass->redirect('index.php/product');
	}
	
	public function publish($id = 0)
	{
		$dgClass 				= new dg();
		
		if ($id > 0)
		{
			$products 			= $dgClass->getProducts();				
			if (count($products) > 0)
			{
				$content 		= array('products'=> array());
				foreach($products as $product)
				{
					if ($product->id == $id)
					{
						$product->published = 1;
					}
					$content['products'][] = $product;
				}
			}
			$path = dirname(ROOT) .DS. 'data' .DS. 'products.json';
			$check = $dgClass->WriteFile($path, json_encode($content));
		}
		
		
		$dgClass->redirect('index.php/product');
	}
	
	public function Copy($id = '')
	{
		// get id product copy
		if(isset($_POST['ids']) && $_POST['ids'] != '')
		{
			$ids = $_POST['ids'];
		}
		else
		{
			if ($id != '' && (int) $id > 0)
				$ids = array($id);
			else
				$ids = array();
		}
		
		//get data product.
		$dgClass 				= new dg();
		$products 				= $dgClass->getProducts();
		$categories 			= $dgClass->getProductCategories();
		
		$content 				= array();
		$content['products'] 	= $products;
		
		// copy products.
		if(count($ids) > 0)
		{
			$product_id = 1;
			$category_id = 1;
			if (count($products) > 0)
			{	
				foreach($ids as $id)
				{
					// copy products.
					$data	= array();
					foreach($products as $product)
					{
						if ($product->id > $product_id)
							$product_id = $product->id;
							
						if ($product->id == $id)
						{
							$data	= (array) $product;
						}
					}
					if(count($data))
					{
						$product_id = $product_id + 1;
						$data['id'] = $product_id;
						$data['sku'] = 'copy'.$product_id;
						$data['title'] = '(copy) '.$data['title'];
						$content['products'][] = (object) $data;
					}
					
					// copy categories.
					if(count($categories))
					{
						foreach($categories as $category)
						{
							if ($category->id > $category_id)
								$category_id = $category->id;
						}	
						foreach($categories as $category)
						{
							$category_data	= array();
							$cate_id = '';
							if ($category->product_id == $id)
							{
								$cate_id = $category->cate_id;
								$category_data	= (array) $category;
							}
							if(count($category_data))
							{
								$category_id = $category_id + 1;
								$category_data['id'] = $category_id;
								$category_data['product_id'] = $product_id;
								$category_data['cate_id'] = $cate_id;
								$categories[] = (object) $category_data;
							}
						}
					}
				}
				
				$content = json_encode($content);
				$path = dirname(ROOT) .DS. 'data' .DS. 'products.json';
				$check = $dgClass->WriteFile($path, $content);
				$path = dirname(ROOT) .DS. 'data' .DS. 'product_categories.json';
				$check = $dgClass->WriteFile($path, json_encode($categories));
				
				$dgClass->redirect('index.php/product');
			}
		}
			
		$dgClass->redirect('index.php/product');
	}
	
	public function delete($id = 0)
	{
            
         
                 
		//get data product.
		$dgClass 				= new dg();
		$products 				= $dgClass->getProducts();
		$categories                             = $dgClass->getProductCategories();
		
       
                
		//get id products
		if(isset($_POST['ids']) && $_POST['ids'] != '')
		{
			$ids = $_POST['ids'];
		}
		else
		{
			if ($id != '' && (int) $id > 0)
				$ids = array($id);
			else
				$ids = array();
		}
                
                
               $data_prod                              = array();
                
               foreach($products as $p){
                    if($p->id == $id){
                        $data_prod = $p;
                    }
                }
                
                if(isset($data_prod->id_post)){
                    
                    
                    $unroot = str_replace(UNROOT, "", ROOT );
                    require $unroot . 'wp-content/plugins/' . WC_DIRECTORY .  '/save_tshirt.php';
                    $lieson     = new LieisonTshirt($unroot);
                    $lieson->Delete_WC($data_prod->id_post);
                    
                }
                
               
		if (count($ids) > 0)
		{	
			//remove products.
			if (count($products) > 0)
			{
				$content['products'] = array();
				foreach($products as $product)
				{
					if (!in_array($product->id, $ids))
					{
						$content['products'][] = $product;
					}
				}
			}
                        
                      
			
			$content = json_encode($content);
			
			$path = dirname(ROOT) .DS. 'data' .DS. 'products.json';
			$dgClass->WriteFile($path, $content);
			
			//remove categories.
			if (count($categories) > 0)
			{
				$category_data = array();
				foreach($categories as $category)
				{
					if (!in_array($category->product_id, $ids))
					{
						$category_data[] = $category;
					}
				}
				$category_data = json_encode($category_data);
			
				$path = dirname(ROOT) .DS. 'data' .DS. 'product_categories.json';
				$dgClass->WriteFile($path, $category_data);
			}
		}
                
                
                
                   
          
                
                
               
                
		
		$dgClass->redirect('index.php/product');
	}
	
	public function category()
	{
		if (isset($_POST['title']))
		{
			$title 		= $_POST['title'];
		}		
		
		if (isset($_POST['cateid']))
		{
			$parent_id 	= $_POST['cateid'];
		}
		
		if (isset($_POST['ids']))
		{
			$ids 	= $_POST['ids'];
		}
		else
		{
			$ids 	= array();
		}
		
		$dgClass = new dg();
		
		if(!empty($title))
		{
			$categories = $dgClass->getCategories();
			$cate_data = array();
			
			$cate_id = 0;
			if($parent_id == '')
				$parent_id = 0;
				
			foreach($categories as $cate)
			{
				$cate_data[] = array(
					'id' => $cate->id,
					'parent_id' => $cate->parent_id,
					'title' => $cate->title
				);
				
				if($cate->id > $cate_id)
					$cate_id = $cate->id;
			}
			
			$cate_data[] = array(
				'id' => $cate_id + 1,
				'parent_id' => $parent_id,
				'title' => $title
			);
			
			$path = dirname(ROOT) .DS. 'data' .DS. 'categories.json';
			$check = $dgClass->WriteFile($path, json_encode($cate_data));
		}
		elseif(count($ids))
		{
			$categories = $dgClass->getCategories();
			$cate_data = array();
			
			foreach($categories as $val)
			{
				if(!in_array($val->id, $ids))
					$cate_data[] = $val;
			}
			$path = dirname(ROOT) .DS. 'data' .DS. 'categories.json';
			$check = $dgClass->WriteFile($path, json_encode($cate_data));
		}
		
		$categories = $dgClass->getCategories();
		$categories = $dgClass->categoriesToTree($categories);
		$data['content'] 	= $dgClass->dispayTree( $categories, 0, array('type'=>'checkbox', 'name'=>'category[]') );				
		$data['list'] 		= '<option value="0">'. lang('product_parent_category', true) . '</option>' . $dgClass->dispayTree( $categories, 0, array('type'=>'select', 'name'=>'') );				
		echo json_encode($data);
		return;
	}	
}

?>
