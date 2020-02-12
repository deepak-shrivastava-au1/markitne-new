<?php
// appino Title
function xamintec( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
		'openiconic' 				=> '',
		'fontawesome' 				=> '',
		'typicons' 					=> '',
		'entypo' 					=> '',
		'linecons' 					=> '',
		'ionicons' 					=> '',
		'flaticon' 					=> '',
		'image1' 				=> '',
		'openiconic2' 				=> '',
		'fontawesome2' 				=> '',
		'typicons2' 					=> '',
		'entypo2' 					=> '',
		'linecons2' 					=> '',
		'ionicons2' 					=> '',
		'flaticon2' 					=> '',
		'image2' 				=> '',
		'openiconic3' 				=> '',
		'fontawesome3' 				=> '',
		'typicons3' 					=> '',
		'entypo3' 					=> '',
		'linecons3' 					=> '',
		'ionicons3' 					=> '',
		'flaticon3' 					=> '',
		'image3' 				=> '',
		'xamintec_title' 				=> '',
		'tag'					=> 'h2',
		'extra_class'			=> '',
		'css' 				=> '',
		'title_color'		=> '',
		) );

	$css_class = '';

	$css = $data['css'] ?  $data["css"]  : '';

	$tag = $data['tag'] ?  $data["tag"]  : '';

	$title_color = $data['title_color'] ?  $data["title_color"]  : '';

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';


	$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
	}

	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'vc_openiconic' );
	wp_enqueue_style( 'vc_typicons' );
	wp_enqueue_style( 'vc_entypo' );
	wp_enqueue_style( 'vc_linecons' );

	$icons1 ='';
	$icon_f1 = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'"></i>' : '';
	$icon_o1 = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'"></i>' : '';
	$icon_t1 = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'"></i>' : '';
	$icon_e1 = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'"></i>' : '';
	$icon_l1 = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'"></i>' : '';
	$icon_i1 = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'"></i>' : '';
	$icon_fl1 = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'"></i>' : '';

	$url = $data['image1'] ? wp_get_attachment_image_url( $data["image1"]) : '';
	$image1 = '<img src="'. $url .'" alt="tecbox" />';
	if($url)
	{
		$icons1 = $image1;
	}
	else
	{
		if($icon_o1 || $icon_f1 || $icon_t1 || $icon_e1 || $icon_l1 || $icon_i1 || $icon_fl1)
		{
			$icons1 = ' '.$icon_f1.''.$icon_o1.''.$icon_t1.''.$icon_e1.''.$icon_l1.''.$icon_i1.''.$icon_fl1.' ';
		}
	}

	$icons2 ='';
	$icon_f2 = $data['fontawesome2'] ? '<i aria-hidden="true" class="'.$data['fontawesome2'].'"></i>' : '';
	$icon_o2 = $data['openiconic2'] ? '<i aria-hidden="true" class="'.$data['openiconic2'].'"></i>' : '';
	$icon_t2 = $data['typicons2'] ? '<i aria-hidden="true" class="'.$data['typicons2'].'"></i>' : '';
	$icon_e2 = $data['entypo2'] ? '<i aria-hidden="true" class="'.$data['entypo2'].'"></i>' : '';
	$icon_l2 = $data['linecons2'] ? '<i aria-hidden="true" class="'.$data['linecons2'].'"></i>' : '';
	$icon_i2 = $data['ionicons2'] ? '<i aria-hidden="true" class="'.$data['ionicons2'].'"></i>' : '';
	$icon_fl2 = $data['flaticon2'] ? '<i aria-hidden="true" class="'.$data['flaticon2'].'"></i>' : '';

	$url = $data['image2'] ? wp_get_attachment_image_url( $data["image2"]) : '';
	$image2 = '<img src="'. $url .'" alt="tecbox" />';
	if($url)
	{
		$icons2 = $image2;
	}
	else{
		if($icon_o2 || $icon_f2 || $icon_t2 || $icon_e2 || $icon_l2 || $icon_i2 || $icon_fl2)
		{
			$icons2 = ' '.$icon_f2.''.$icon_o2.''.$icon_t2.''.$icon_e2.''.$icon_l2.''.$icon_i2.''.$icon_fl2.' ';
		}
	}

	$icons3 ='';
	$icon_f3 = $data['fontawesome3'] ? '<i aria-hidden="true" class="'.$data['fontawesome3'].'"></i>' : '';
	$icon_o3 = $data['openiconic3'] ? '<i aria-hidden="true" class="'.$data['openiconic3'].'"></i>' : '';
	$icon_t3 = $data['typicons3'] ? '<i aria-hidden="true" class="'.$data['typicons3'].'"></i>' : '';
	$icon_e3 = $data['entypo3'] ? '<i aria-hidden="true" class="'.$data['entypo3'].'"></i>' : '';
	$icon_l3 = $data['linecons3'] ? '<i aria-hidden="true" class="'.$data['linecons3'].'"></i>' : '';
	$icon_i3 = $data['ionicons3'] ? '<i aria-hidden="true" class="'.$data['ionicons3'].'"></i>' : '';
	$icon_fl3 = $data['flaticon3'] ? '<i aria-hidden="true" class="'.$data['flaticon3'].'"></i>' : '';

	$url = $data['image3'] ? wp_get_attachment_image_url( $data["image3"]) : '';
	$image3 = '<img src="'. $url .'" alt="tecbox" />';
	if($url)
	{
		$icons3 = $image3;
	}
	else{
		if($icon_o3 || $icon_f3 || $icon_t3 || $icon_e3 || $icon_l3 || $icon_i3 || $icon_fl3)
		{
			$icons3 = ' '.$icon_f3.''.$icon_o3.''.$icon_t3.''.$icon_e3.''.$icon_l3.''.$icon_i3.''.$icon_fl3.' ';
		}
	}
	
	$xamintec_title = $data['xamintec_title']?$data['xamintec_title']:'';

	$out ='';
	$out .='<div class="tec_box '. $extra_class .''. esc_attr( $css_class ) .'">';
		$out .='<div class="tec_icons clerfix">';
				$out .='<div class="img_icon_one">';
					if(!empty($icons1)){
					$out .='<div class="tec_icon">';
						$out .= $icons1;
					$out .='</div>';
					}
				$out .='</div>';
				$out .='<div class="img_icon_two">';
					if(!empty($icons2)){
					$out .='<div class="tec_icon">';
						$out .= $icons2;
					$out .='</div>';
					}
			$out .='</div>';
		$out .='</div>';
		$out .='<div class="img_icon_three">';
			if(!empty($icons3)){
			$out .='<div class="tec_icon">';
				$out .= $icons3;
			$out .='</div>';
			}
		$out .='</div>';
		if(!empty($xamintec_title)){		
		$out .='<'.$tag.' class="xamintec_title" '.$title_color.'>';
			$out .= $xamintec_title;
		$out .='</'.$tag.'>';
		}
	$out .='</div>';

	return $out;
}
add_shortcode('xamintec','xamintec');
?>