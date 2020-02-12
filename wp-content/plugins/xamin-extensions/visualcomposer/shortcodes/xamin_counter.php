<?php
// Counter
function xamincounter($atts, $content = null) {

	$data = wp_parse_args( $atts, array(
		'counter_title'     => '',
		'counter_postfix'   => '',
		'extra_class'		=> '',
		'counter_content'   => '',
		'openiconic' 		=> '',
		'fontawesome' 		=> '',
		'typicons' 			=> '',
		'entypo' 			=> '',
		'linecons' 			=> '',
		'ionicons' 			=> '',
		'flaticon'	        => '',
		'image'             => '',
		'disble_plus'  => '',
		'disble_percentage'  => '',
		'disble_icon'  => '',
		'counter_type'  => 'Style1',
		'icon_type' => '',
		'css'  => '',
		'title_color'  => '',
		'number_color'  => '',
		'plus_icon_color'  => '',
		'icon_color'  => '',
		'position' => 'left',
	) );

	$css_class = '';

    wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'vc_openiconic' );
	wp_enqueue_style( 'vc_typicons' );
	wp_enqueue_style( 'vc_entypo' );
	wp_enqueue_style( 'vc_linecons' );

	$title_color = $data['title_color'] ?  $data["title_color"]  : '';

	$number_color = $data['number_color'] ?  $data["number_color"]  : '';

	$plus_icon_color = $data['plus_icon_color'] ?  $data["plus_icon_color"]  : '';

	$icon_color = $data['icon_color'] ?  $data["icon_color"]  : '';

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
	$number_color = $number_color ? ' style="color: ' . $number_color . ';"' : '';
	$plus_icon_color = $plus_icon_color ? ' style="color: ' . $plus_icon_color . ';"' : '';
	$icon_color = $icon_color ? ' style="color: ' . $icon_color . ';"' : '';

	$icons ='';
	$icon_f = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'" '. $icon_color .'></i>' : '';
	$icon_o = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'" '. $icon_color .'></i>' : '';
	$icon_t = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'" '. $icon_color .'></i>' : '';
	$icon_e = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'" '. $icon_color .'></i>' : '';
	$icon_l = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'" '. $icon_color .'></i>' : '';
	$icon_i = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'" '. $icon_color .'></i>' : '';
	$icon_fl = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'" '. $icon_color .'></i>' : '';


	$url = $data['image'] ? wp_get_attachment_image_url( $data["image"]) : '';
	$image = '<img src="'. $url .'" alt="fancybox" />';
	if($url)
	{
		$icons = $image;
	}
	else
	{
	    if($icon_o || $icon_f || $icon_t || $icon_e || $icon_l || $icon_i || $icon_fl)
		{
            $icons = ' '.$icon_f.''.$icon_o.''.$icon_t.''.$icon_e.''.$icon_l.''.$icon_i.''.$icon_fl.' ';
        }
	}


	$counter_title = $data['counter_title'] ?  $data["counter_title"]  : '';

	$counter_postfix = $data['counter_postfix'] ?  $data["counter_postfix"]  : '';

	$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

	$disble_plus = $data['disble_plus'] ?  $data["disble_plus"]  : '';

	$disble_percentage = $data['disble_percentage'] ?  $data["disble_percentage"]  : '';

	$disble_icon = $data['disble_icon'] ?  $data["disble_icon"]  : '';

	$icon_type = $data['icon_type'] ?  $data["icon_type"]  : '';

	$counter_content = $data['counter_content'] ?  $data["counter_content"]  : '';

	$counter_type = $data['counter_type'] ?  $data["counter_type"]  : '';

	$position = $data['position'] ?  $data["position"]  : '';

	$css = $data['css'] ?  $data["css"]  : '';
	
	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}
	

	$result = '';

	if($counter_type == "Style1"){

	$result .= '
	<div class="iq-timer style1'. $extra_class .' '. esc_attr( $css_class ) .'   text-'.$position.'">';
		if($data['disble_icon'] == "0")
		{
		
		}
		else{
			$result .= ' '.$icons.' ';
		}
		$result .= '<div class="timer-details">';
				if($data['disble_plus'] == "0" && $data['disble_percentage'] == "0")
				{ 
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .'</span>';
				}
				if($data['disble_plus'] == "0")
				{ 
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .'</span><i class="fa fa-percent" aria-hidden="true" '. $plus_icon_color .'></i>';

				}
				if($data['disble_percentage'] == "0")
				{ 
					$result .= '<span  class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .'</span>
					<i class="fa fa-plus" aria-hidden="true" '. $plus_icon_color .'></i>';
				}
		$result .='<p '. $title_color .'> '. $counter_title .'</p>
		</div>
	</div>';
}
	if($counter_type == "Style2"){

	$result .= '
	<div class="iq-timer style2 '. $extra_class .' '. esc_attr( $css_class ) .'  text-'.$position.'">';
		if($data['disble_icon'] == "0")
		{
		
		}
		else{
			$result .= '<div class="iq-icon"> '.$icons.'</div> ';
		}
		$result .= '<div class="timer-details">';
				if($data['disble_plus'] == "0" && $data['disble_percentage'] == "0")
				{ 
					if($data['icon_type'] == 'iq-image'){
						$result .= '<div class="iq-img"> '.$icons.'</div> ';
					}
					
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span><span class="timer_postfix" '. $number_color .'>'.$counter_postfix.'</span>';
				}
				if($data['disble_plus'] == "0")
				{ 
					if($data['icon_type'] == 'iq-image'){
						$result .= '<div class="iq-img"> '.$icons.'</div> ';
					}
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span><span class="timer_postfix" '. $number_color .'>'.$counter_postfix.'</span><i class="fa fa-percent" aria-hidden="true" '. $plus_icon_color .'></i>';

				}
				if($data['disble_percentage'] == "0")
				{ 
					if($data['icon_type'] == 'iq-image'){
						$result .= '<div class="iq-img"> '.$icons.'</div> ';
					}
					$result .= '<span  class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span><span class="timer_postfix" '. $number_color .'>'.$counter_postfix.'</span>
					<i class="fa fa-plus" aria-hidden="true" '. $plus_icon_color .'></i>';
				}
		$result .='<p '. $title_color .'> '. $counter_title .'</p>
		</div>
	</div>';
}
	if($counter_type == "Style3"){

	$result .= '
	<div class="iq-timer style3 '. $extra_class .' '. esc_attr( $css_class ) .'  text-'.$position.'">';
		if($data['disble_icon'] == "0")
		{
		
		}
		else{
			$result .= '<div class="iq-icon"> '.$icons.'</div> ';
		}
		if($data['icon_type'] == 'iq-image'){
						$result .= '<div class="iq-img"> '.$icons.'</div> ';
					}
		$result .= '<div class="timer-details">';
				if($data['disble_plus'] == "0" && $data['disble_percentage'] == "0")
				{ 
					
					
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span>';
				}
				if($data['disble_plus'] == "0")
				{ 
					
					$result .= '<span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span><i class="fa fa-percent" aria-hidden="true" '. $plus_icon_color .'></i>';

				}
				if($data['disble_percentage'] == "0")
				{ 
					
					$result .= '<span  class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">'. $counter_content .' </span>
					<i class="fa fa-plus" aria-hidden="true" '. $plus_icon_color .'></i>';
				}
		$result .='<p '. $title_color .'> '. $counter_title .'</p>
		</div>
	</div>';
}

    if($counter_type == "Style4"){

		$result .= '
		<div class="iq-timer style4 '. $extra_class .' '. esc_attr( $css_class ) .'  text-'.$position.'">';
		    if($data['disble_icon'] == "0") {
		    } else{
			    $result .= '<div class="iq-icon"> '.$icons.'</div> ';
		    }
	        $result .= '
	        <div class="timer-details">';

	            $result .= '
	            <span class="timer" '. $number_color .' data-to="'. $counter_content .'" data-speed="5000">
	                '. $counter_content .' 
	            </span>';
	            if(!empty($counter_postfix)){
	            	$result .='
	                <span class="timer_postfix" '. $number_color .'>'.$counter_postfix.'</span>';
	            }    
	            $result .='<p '. $title_color .'> '. $counter_title .'</p>';
	        $result .= '
	        </div>
	    </div>';
    }
	return $result;
	
}
add_shortcode('xamincounter','xamincounter');
?>