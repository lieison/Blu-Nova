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

class User extends Controllers
{
	public $config;
	
	public function index($error = 0)
	{
		$data 	= array();
		switch($error)
		{
			case 1:
				$data['error']	= lang('user_login_sign_up_descirpt', true);
				break;
			case 2:
				$data['error']	= lang('user_add_account_file_temp', true);
				break;
			case 3:
				$data['error']	= lang('user_add_account_file_config', true);
				break;
			case 4:
				$data['error']	= lang('user_login_register_error_msg', true);
				break;			
		}
		// check install
		include_once (ROOT .DS. 'config' .DS. 'config.php');
		if ($config['email'] == 'YOUR_EMAIL' || $config['password'] == 'YOUR_PASSWORD')
		{
			
			$data['title'] = lang('user_login_sign_up', true);
			$this->modal('register', $data);
		}
		else
		{
			// check user login
			$dgClass 				= new dg();
			if($this->session('login') !== false)
			{
				$dgClass->redirect('index.php/dashboard');
			}
			else if(isset($_COOKIE['temail']) && isset($_COOKIE['tpassword']))
			{				
				$dgClass->redirect('index.php/user/autoLogin');				
			}
			
			$data['title'] = lang('user_login_sign_in', true);
			$this->modal('login', $data);
		}
	}
	
	public function autoLogin()
	{
		$dgClass 	= new dg();
		if(empty($_COOKIE['temail']) || empty($_COOKIE['tpassword']))
		{
			setcookie("temail", "", time() - 36000, '/');
			setcookie("tpassword", "", time() - 36000, '/');
			$dgClass->redirect('index.php/user/index');
		}
		
		
		// check login
		if($this->session('login') !== false)
		{
			$dgClass->redirect('index.php/dashboard');
		}
		
		// check created account
		include_once (ROOT .DS. 'config' .DS. 'config.php');
		if ($config['email'] == 'YOUR_EMAIL' || $config['password'] == 'YOUR_PASSWORD')
		{
			$dgClass->redirect('index.php/user/index');
		}
		
		$email 			= $_COOKIE['temail'];
		$password 		= $_COOKIE['tpassword'];
		if($config['email'] == $email && $password == $config['password'])
		{
			$this->set_session('login', true);
			$dgClass->redirect('index.php/dashboard');
		}
		else
		{
			setcookie("temail", "", time() - 36000, '/');
			setcookie("temail", "", time() - 36000);
			setcookie("tpassword", "", time() - 36000, '/');
			setcookie("tpassword", "", time() - 36000);			
			
			$dgClass->redirect('index.php/user/index');
		}
	}
	
	public function login()
	{
		$dgClass 	= new dg();
		
		// check login
		if($this->session('login') !== false)
		{
			$dgClass->redirect('index.php/dashboard');
		}
		
		// check created account
		include_once (ROOT .DS. 'config' .DS. 'config.php');
		if ($config['email'] == 'YOUR_EMAIL' || $config['password'] == 'YOUR_PASSWORD')
		{
			$dgClass->redirect('index.php/user/index');
		}
				
		if(!empty($_POST))
		{
			$email 			= $_POST['email'];
			$password 		= $_POST['password'];
			
			if($config['email'] == $email && $password == $config['password'])
			{
				setcookie('temail', $email, time() + (86400 * 30), '/');
				setcookie('tpassword', $password, time() + (86400 * 30), '/');				
				
				$this->set_session('login', true);
				$dgClass->redirect('index.php/dashboard');
			}
			else
			{
				$dgClass->redirect('index.php/user/index/4');
			}
		}
		else
		{
			$dgClass->redirect('index.php/user/index');
		}		
	}
	
	public function register()
	{
		$dgClass 	= new dg();
		if($this->session('login') !== false)
		{
			$dgClass->redirect('index.php/dashboard');
		}
		
		$error = lang('user_login_register_error_msg', true);
		if(!empty($_POST))
		{
			$email 			= $_POST['email'];
			$password 		= $_POST['password'];
			
			// check install
			include_once (ROOT .DS. 'config' .DS. 'config.php');
			if (($config['email'] != 'YOUR_EMAIL' && $config['password'] != 'YOUR_PASSWORD') || $email == '' || $password == '' )
			{
				$dgClass->redirect('index.php/user/index/1');
			}
						
			// get file
			$file 		= ROOT .DS. 'config' .DS. 'config-temp.php';			
			$content 	= $dgClass->readFile($file);
			if ($content === false)
			{
				$dgClass->redirect('index.php/user/index/2');
			}
			
			$content	= str_replace('YOUR_EMAIL', $email, $content);
			$content	= str_replace('YOUR_PASSWORD', $password, $content);
			$check 		= $dgClass->WriteFile(ROOT .DS. 'config' .DS. 'config.php', $content);
			if ($check === false)
			{
				$dgClass->redirect('index.php/user/index/3');
			}
			
			setcookie('temail', $email, time() + (86400 * 30), '/');
			setcookie('tpassword', $password, time() + (86400 * 30), '/');
			$dgClass->redirect('index.php/user/index/200');
		}
		else
		{
			$dgClass->redirect('index.php/user/index');
		}		
	}
	
	public function logout()
	{
		$dgClass 	= new dg();
				
		setcookie("temail", "", time() - 36000, '/');
		setcookie("tpassword", "", time() - 36000, '/');
				
		$this->unset_session('login');
		$dgClass->redirect('index.php');
	}
}

?>