<?php
// Clients
function xaminclient( $atts, $content = null ) {
 	
	extract(shortcode_atts(array(
		'style_type'    => '1',
		'hover_effect_style' => 'default',
		'images' 		=> '',
		'hover_effct'	=> '',
		'background_shadow' => '',
		'number'     	=> -1,
		'desk_number1'  => '',
		'desk_number'   => '6',
		'lap_number'    => '3',
		'tab_number'    => '3',
		'mob_number'    => '2',
    	'sort'       	=> '',
		'order'      	=> 'ASC',
		'arrow'      	=> 'true',
		'dots'      	=> 'false',
		'client_bg_shadow' => '',
		'extra_class'   => '',
		'css'   => '',
	), $atts));

	$css_class = '';

	if($background_shadow == "0"){
		$client_bg_shadow = "client-bg-shadow";
	}

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

	$Destimonial_Image 	= explode(',', $images);
	$appino_options = get_option('appino_options');
 
    $html = '';

    if($style_type == 1){
		
		if( !empty($Destimonial_Image) ){
			$html .= '
			<div class="col-sm-12 '. esc_attr( $css_class ) .'">';

				if($desk_number <= "6" && $desk_number != "-1") {
					$html .= '<div class="owl-carousel client-logo '.$client_bg_shadow.'" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="true" data-loop="true" data-margin="30">';
				} else {
					$html .= '<div class="owl-carousel client-logo '.$client_bg_shadow.'" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="6" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="true" data-loop="true" data-margin="30">';
				}

					$count = 0;
					foreach ( $Destimonial_Image as $key => $value ) {
						if( !empty($Destimonial_Image[$key]) ){
							$html .='
							<div class="item '.$extra_class.'">';
								if($hover_effct == "0") {
									$html .='<div class="clients-box hover-effct">';
								}
								else{
									$html .='<div class="clients-box">';
								}
							        $html .='
							        <img class="img-fluid client-img" src="'.wp_get_attachment_url($Destimonial_Image[$key]).'" alt="image'.$count.'">';
								$html .='
								</div>';
							$html .='
							</div>';
			        	}
					    $count++;
					}
					
				$html .= '
				</div>
			</div>';
		}
    }

    if($style_type == 2){
		
		if( !empty($Destimonial_Image) ){
			$html .= '
			<div class="col-sm-12 '. esc_attr( $css_class ) .'">';

				if($desk_number <= "6" && $desk_number != "-1") {
					$html .= '<div class="owl-carousel client-logo '.$client_bg_shadow.'" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="true" data-loop="true" data-margin="30">';
				} else {
					$html .= '<div class="owl-carousel client-logo '.$client_bg_shadow.'" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="6" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="true" data-loop="true" data-margin="30">';
				}

					$count = 0;
					foreach ( $Destimonial_Image as $key => $value ) {
						if( !empty($Destimonial_Image[$key]) ){
							$html .='
							<div class="item '.$extra_class.'">';
							    if($hover_effect_style == "box-shadow"){
                                    $html .='<div class="clients-box box-shadow">';
							    } elseif($hover_effect_style == "hover-effect") {
                                    $html .='<div class="clients-box hover-effct">';
							    } else {
									$html .='<div class="clients-box">';
								}
							        $html .='
							        <img class="img-fluid client-img" src="'.wp_get_attachment_url($Destimonial_Image[$key]).'" alt="image'.$count.'">';
								$html .='
								</div>';
							$html .='
							</div>';
			        	}
					    $count++;
					}
					
				$html .= '
				</div>
			</div>';
		}
    }		

	return $html;
}
add_shortcode('xaminclient', 'xaminclient');
?>