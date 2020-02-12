<?php
function xaminServiceBox( $atts, $content = null ) {

	 $data = wp_parse_args( $atts, array(
	 	'style_type'                => '1',
		'xamintitle_content'  		=> 'Easy to Customize',
        'title_tag'					=> 'h2',
        'title_color'				=> '',  
        'xaminsubtitle_content' 	=> 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
        'content_tag'				=> 'p',
        'content_color'				=> '',
        'openiconic' 				=> '',
        'fontawesome' 				=> '',
        'typicons' 					=> '',
        'entypo' 					=> '',
		'linecons' 					=> '',
		'ionicons' 					=> '',
		'flaticon'	                => '',
		'icon_color'				=> '',
		'image'       				=> '',
		'position' 					=> 'left',
		'delay_time'				=> '',
		'shadow_on_hover'           => '',
		'link_title'				=> '',
		'link_url'					=> '',
		'extra_class'               => '',
		'button_enable'             => '',
		'css' 						=> '',
		'xamin_title_step'          => '',
	) );

	$css_class = '';

	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'vc_openiconic' );
	wp_enqueue_style( 'vc_typicons' );
	wp_enqueue_style( 'vc_entypo' );
	wp_enqueue_style( 'vc_linecons' );

	$style_type = $data['style_type'] ? $data["style_type"]  : '';

    $xamintitle_content = $data['xamintitle_content'] ? $data["xamintitle_content"]  : '';

    $title_tag = $data['title_tag'] ? $data["title_tag"] : '';

    $title_color = $data['title_color'] ?  $data["title_color"]  : '';

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';

    $xaminsubtitle_content = $data['xaminsubtitle_content'] ?  $data["xaminsubtitle_content"]  : '';

    $content_tag = $data['content_tag'] ? $data["content_tag"] : '';

    $content_color = $data['content_color'] ?  $data["content_color"]  : '';

	$content_color = $content_color ? ' style="color: ' . $content_color . ';"' : '';

	$position = $data['position'] ? $data["position"] : '';
    
    $shadow_on_hover = $data['shadow_on_hover'] ? $data["shadow_on_hover"] : '';

	$link_title = $data['link_title'] ?  $data["link_title"]  : '';

	$link_url = $data['link_url'] ?  $data["link_url"]  : '';
	
	$button_enable = $data['button_enable'] ?  $data["button_enable"]  : '';

	$xamin_title_step = $data['xamin_title_step'] ? $data["xamin_title_step"]  : '';

    $extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

	$css = $data['css'] ?  $data["css"]  : '';

	$icon_color = $data['icon_color'] ?  $data["icon_color"]  : '';		

	$icon_color = $icon_color ? ' style="color: ' . $icon_color . ';"' : '';

    $out  = "";

	$icons ='';
	$icon_f = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'" '.$icon_color.'></i>' : '';
	$icon_o = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'" '.$icon_color.'></i>' : '';
	$icon_t = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'" '.$icon_color.'></i>' : '';
	$icon_e = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'" '.$icon_color.'></i>' : '';
	$icon_l = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'" '.$icon_color.'></i>' : '';
	$icon_i = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'" '.$icon_color.'></i>' : '';
	$icon_fl = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'" '.$icon_color.'></i>' : '';

	$url = $data['image'] ? wp_get_attachment_image_url( $data["image"],"full") : '';
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

	$delay_time = $data['delay_time'] ?  $data["delay_time"]  : '';
	if(!empty($delay_time))
	{
		$delay_time = 'data-wow-delay="'.$delay_time.'s"';
	}

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
	}

	$out ='';

	if($style_type == 1) {

	    if($data['shadow_on_hover'] == '0'){
			$out ='
			<div class="iq-service-box shadow-on-hover wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
		} else {
	        $out ='
			<div class="iq-service-box wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
		}	
		    $out .= '
		    <div class="fancy-info">	
		        <div class="fancy_img" >'.$icons.'</div>
				<'.$title_tag.' class="mt-4 mb-3 title" '.$title_color.'>'.$xamintitle_content.'</'.$title_tag.'>';
				$out .='<p class="" '.$content_color.'>'.$xaminsubtitle_content.'</p>';	

				if($data['button_enable'] == '0'){
				    $out .='<a class="button btn-simple" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'</span></a>';
				} 
				   
			$out .='
			</div>';
		$out .='
		</div>';
    }

    if($style_type == 2) {

	    $out .='
		<div class="iq-xamin-works '.$extra_class.' text-'.$position.'">
	        <div class="step-img">
				'.$icons.'';
				if(!empty($xamin_title_step)){
					$out .='
					<div class="step-number">'.$xamin_title_step.'</div>';
			    }
			$out .='		
			</div>';

			$out .='
			<'.$title_tag.'>'.$xamintitle_content.'</'.$title_tag.'>';
			if(!empty($xaminsubtitle_content)) {
		        $out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
			}
 
	    $out .='
	    </div>';
    }		
		
	return $out;

}
add_shortcode('xaminServiceBox','xaminServiceBox');
?>