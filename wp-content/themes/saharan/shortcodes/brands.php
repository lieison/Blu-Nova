<?php
$html .= '<div class="brands-carousel">';
	foreach($road_opt['brand_logos'] as $brand) {
		if(is_ssl()){
			$brand['image'] = str_replace('http:', 'https:', $brand['image']);
		}
		$html .= '<div>';
		$html .= '<a href="'.$brand['url'].'" title="'.$brand['title'].'">';
			$html .= '<img src="'.$brand['image'].'" alt="'.$brand['title'].'" />';
		$html .= '</a>';
		$html .= '</div>';
	}
$html .= '</div>';
?>