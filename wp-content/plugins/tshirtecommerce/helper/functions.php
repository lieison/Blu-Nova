<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-06-03
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */

// get attribute of product
function getAttributes($attribute)
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
			$html 	.= 		field($attrs->name[$i], $attrs->titles[$i], $attrs->prices[$i], $attrs->type[$i], $id);
			
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

function quantity($min = 1, $name = 'Quantity', $name2 = 'minimum quantity: '){
	
	$html = '<div class="form-group product-fields product-quantity">';
	$html .= 	'<label class="col-sm-4">'.$name.'</label>';
	$html .= 	'<div class="col-sm-6">';
	$html .= 		'<input type="text" class="form-control input-sm" value="0" name="quantity" id="quantity">';
	$html .= 	'</div>';
	$html .= 	'<span class="help-block"><small>'.$name2.$min.'</small></span>';
	$html .= '</div>';
	
	return $html;
}