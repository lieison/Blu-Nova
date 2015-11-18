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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <title>Download File Design</title>
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
	.container.loading{opacity: 0.2;}
	svg{max-width: 100%;height: auto;}
	@media print {
		body .container {visibility: hidden;height: 1px; overflow: hidden;}
		body a{display:none;}
		#download-pdf{
			background-color: white;
			height: 100%;
			width: 100%;
			position: fixed;
			top: 0;
			left: 0;
			margin: 0;
			padding: 0;
			visibility: visible;
			display: block!important;
		}
	}
	</style>
  </head>
  <body>
    <div class="container">
		<div class="row">
			<center><h4>Download File Design</h4></center>
		</div>
		
		<div class="row">
			<?php if ( empty($_GET['key']) || empty($_GET['view']) ) { ?>
				<div class="col-md-12 alert alert-danger" role="alert">
					<strong>Design Not Found!</strong>
				</div>
			<?php }else{				
				$key = $_GET['key'];
				$position = $_GET['view'];
				
				include_once ROOT .DS. 'includes' .DS. 'functions.php';
				
				$dg = new dg();			
				$data = array();			
				
				if (empty($_GET['idea']))
				{
					$file = 'download.php';
					$cache = $dg->cache('cart');
					$data = $cache->get($key);
				}
				else
				{
					$file = 'download_idea.php';
					$cache = $dg->cache('design');
					$params = explode(':', $key);
					$user_id = $cache->get($params[0]);
					
					if ($user_id != false && count($user_id[$params[1]]) > 0)
					{
						$data = $user_id[$params[1]];
					}					
				}
				
				$file = $dg->url().'tshirtecommerce/'.$file;
				
				if ( count($data) > 0)
				{
					$download_pdf = file_get_contents($file.'?key='.$key.'&view='.$position.'&type=pdf');
				?>
				<div class="col-sm-6 col-md-6">
					<?php if (isset($data['images'][$position])) { ?>
					<center>
					<img src="<?php echo $data['images'][$position]; ?>" width="400" class="img-responsive" alt="Responsive image">
					</center>
					<?php }else{ ?>
					<img src="<?php echo $data['image']; ?>" class="img-responsive" alt="Responsive image">
					<?php } ?>
					<span style="display:none;" id="download-png">
					<?php echo file_get_contents($file.'?key='.$key.'&view='.$position.'&type=png'); ?>
					</span>					
					<hr />
					<center>Click to download: 
						<!--
						<a href="<?php echo $file; ?>?key=<?php echo $key; ?>&view=<?php echo $position; ?>&download=1"><strong>SVG</strong></a>
						 or 
						 -->
						<a href="#" onclick="window.print();"><strong>PDF</strong></a>
						 or 
						<a href="#" onclick="downloadPNG('<?php echo $position; ?>')"><strong>PNG</strong></a>
						
						<hr />
						<strong>Note: Download file PDF only works on Chome. </strong>
						<br />
						<a href="https://youtu.be/yJ9qMW28O_Q" target="_blank" class="btn btn-primary">View Video Guide</a>
						
					</center>
				</div>
				
				<div class="col-sm-6 col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">Design detail <small class="text-danger">(Click font name to download and install font to your computer)</small></div>
						<div class="panel-body">
							<?php
							
							if (isset($data['vector']))
								$vectors 		= json_decode($data['vector']);			
							else
								$vectors 		= json_decode($data['vectors']);
							
							$items			= $vectors->$position;
							$items			= json_decode ( json_encode($items), true);
							
							if (count($items))
							{
								foreach($items as $item)
								{
									echo '<div class="row col-md-6">';
									if ($item['type'] == 'text')
									{
										$font = $item['fontFamily'];
										echo "<link href='http://fonts.googleapis.com/css?family=".str_replace(' ', '+', $font)."' rel='stylesheet' type='text/css'>";
										echo '<p><strong>Add text:</strong></p>';
										
										echo '<p>'.$item['svg'].'</p>';
										
										echo '<p>Font name: <a title="click here to download font" target="_blank" href="https://www.google.com/fonts/specimen/'.str_replace(' ', '+', $font).'"><strong>'.$font.'</strong></a></p>';
										
										if (isset($item['color']))
											echo '<p>Color: <strong>'.$item['color'].'</strong></p>';
										
										if (isset($item['outlineC']) && isset($item['outlineW']))
											echo '<p>Outline: <strong>'.$item['outlineC'].' '.$item['outlineW'].'px</strong></p>';
									}
									else
									{
										echo '<p><strong>Add art:</strong></p>';
										echo '<p>'.$item['svg'].'</p>';										
									}
																	
									echo '<p>Width: '.$item['width'].'</p>';									
									echo '<p>Height: '.$item['height'].'</p>';									
									echo '<p>Top: '.$item['top'].'</p>';									
									echo '<p>Left: '.$item['left'].'</p>';									
									echo '<p>Rotate: '.$item['rotate'].'</p>';
									
									echo '</div>';
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php 
				}
				else
				{
					echo '<div class="col-md-12 alert alert-danger" role="alert"><strong>Design Not Found!</strong></div>';
				}	
			} ?>
		</div>
	</div>
	
	<span style="display:none;" id="download-pdf">
		<center>
			<?php echo $download_pdf; ?>
		</center>
	</span>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
	function downloadPNG(view)
	{		
		var mySVG = document.getElementById('download-png').innerHTML;
				
		var mySrc 	= 'data:image/svg+xml,'+encodeURIComponent(mySVG);
 		
		var img = new Image();

		$('.container').addClass('loading');
		img.onload = function(){	
			var canvas = document.createElement("canvas");
			canvas.width = img.width;
			canvas.height = img.height;    
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0);		
			var dataURL = canvas.toDataURL("image/png");			
			var link = document.createElement('a');
			link.href = dataURL;
			link.download = view+'.png';
			document.body.appendChild(link);
			link.click();
			$('.container').removeClass('loading');
		}
		img.src = mySrc;
	}
	</script>
  </body>
</html>