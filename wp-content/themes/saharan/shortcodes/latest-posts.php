<?php
$html.='<div class="posts-carousel">';

		foreach ( $postslist as $post ) {
			$html.='<div class="item-col">';
				$html.='<div class="post-wrapper">';
					$html.='<div class="post-thumb">';
						$html.='<a href="'.get_the_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $imagesize).'</a>';

					$html.='</div>';
					$html.='<div class="post-info">';
						$html.='<div class="post-header">';
						$html.='<h3 class="post-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
						$html.='<span class="post_date"><i class="fa fa-clock-o"></i><span class="month">'.get_the_date('F', $post->ID).'</span><span class="day">'.get_the_date('d', $post->ID).'</span>, <span class="year">'.get_the_date('Y', $post->ID).'</span></span>';
						
						$html.='</div>';
						$html.='<div class="post-excerpt">';
							if(function_exists('road_excerpt_by_id')){
								$html.=road_excerpt_by_id($post, $length = $atts['length']);
							}
						$html.='</div>';
					$html.='</div>';
				$html.='</div>';
			$html.='</div>';

		}
$html.='</div>';
?>