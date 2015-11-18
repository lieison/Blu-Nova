<?php
require_once('libraries'.DS.'facebook.php');
	
class Face{
	
	public function __construct($config) 
	{
        
		$this->facebook = new Facebook($config);
		$this->user_id = $this->facebook->getUser();
    }
	
	function login()
	{
		if(!$this->user_id) 
		{
			$params = array(
				'scope' => 'email, public_profile, user_photos, publish_actions'
			);
			return $this->facebook->getLoginUrl($params);
		}
		return false;
	}
	
	function getMe()
	{
		if($this->user_id) 
		{
			try{
				return $this->facebook->api('/me', 'GET');
			}catch(FacebookApiException $e) 
			{
				$this->user_id = null;
				return error_log($e->getMessage());
			} 
		}
	}
	
	function getAllAlbum($limit = 24, $direction = '')
	{	
		if($this->user_id) 
		{
			try{
				$all_albums =  $this->facebook->api('/me/albums?limit='.$limit.$direction,'GET'); 
				//echo '<pre>'; print_r($all_albums); exit;
				$album = array();
				$data = array();
				foreach($all_albums['data'] as $key=>$album)
				{
					if(isset($album['count']))
					{
						$data[$key]['album_id'] = $album['id'];
						$data[$key]['title'] = $album['name'];
						$data[$key]['time'] = $album['created_time'];
						$data[$key]['count'] = $album['count'];
						$cover_photo = $this->getCoverPhoto($album['id']);
						$data[$key]['cover_photo'] = $cover_photo['picture']['data']['url'];
					}
				}
				$album['data'] = $data;
				$album['page'] = array();
				if(isset($all_albums['paging']) && count($all_albums['paging']))
					$album['page'] = $all_albums['paging'];
				return $album;
			} 
			catch(FacebookApiException $e) 
			{
				$this->user_id = null;
				return error_log($e->getMessage());
			} 
		}
	}
	
	//get view Photo. return array(photo_medium + photo_big + photo);
	function getPhoto($photo_id)
	{	
		if($this->user_id) 
		{	
			$data = array();
			$photo = $this->facebook->api('/'.$photo_id,'GET');
			$data['photo_medium'] = $photo['source'];
			$data['photo_big'] = $photo['images'][0]['source'];
			$data['photo'] = $photo['picture'];
			return $data;
		}
	}
	
	//get cover_photo.
	function getCoverPhoto($album_id)
	{	
		if($this->user_id) 
		{	
			return $this->facebook->api('/'.$album_id.'?fields=picture','GET');
		}
	}
	
	//get All Photo in album. return array(photo_id + photo_medium + photo_big + photo);
	function getAllPhoto($album_id, $limit = 24, $direction = '')
	{	
		if($this->user_id) 
		{	
			$data = array();
			$result = array();
			$photos = $this->facebook->api('/'.$album_id.'/photos?limit='.$limit.$direction,'GET');
			
			foreach($photos['data'] as $key=>$photo)
			{
				$data[$key]['photo'] = $photo['picture'];
				$data[$key]['photo_medium'] = $photo['source'];
				$data[$key]['photo_big'] = $photo['images'][0]['source'];
				$data[$key]['time'] = $photo['created_time'];
			}
			$result['data'] = $data;
			$result['page'] = array();
			if(isset($photos['paging']) && count($photos['paging']))
				$result['page'] = $photos['paging'];
			
			return $result;
		}
	}
}
	
?>