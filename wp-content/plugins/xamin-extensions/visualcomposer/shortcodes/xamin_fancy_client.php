<?php
//Fancy Clients
function xaminfancyclient( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'style_type'    => '1',
		'column_type'   => '5',
		'images' 		=> '',
		'extra_class'   => '',
		'css' => '',
	), $atts));

	$css_class = '';

	$Destimonial_Image 	= explode(',', $images);
	$appino_options = get_option('appino_options');

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}


    if($style_type == '1') {
		$html = '';
		if( !empty($Destimonial_Image) ){
			$html .='<div class="container">';
			$html .= '<div class="row fancy-clients  wow fadeIn'. esc_attr( $css_class ) .'">';
				$count = 0;
				foreach ( $Destimonial_Image as $key => $value ) {
					if( !empty($Destimonial_Image[$key]) ){
					$html .='
								<div class="col-lg-2 col-md-3 col-sm-6 text-center '.$extra_class.'">
									<a class="clients-block wow fadeIn" data-wow-delay="0.6s" href="#" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeIn;">
									<img class="img-fluid" src="'.wp_get_attachment_url($Destimonial_Image[$key]).'" alt="image'.$count.'">
									</a>
								</div>';
		        	}
				$count++;
				}
			    $html .='</div>';
			    $html .='</div>';
		}
	}	

	if($style_type == '2') {
		$html = '';
		if( !empty($Destimonial_Image) ){

			$html .='
			<div class="container-visualization wow fadeIn'. esc_attr( $css_class ) .'">';

			    $html .= '
				<ul class="iq-client column-'.$column_type.'">';
				    $count = 0;
					foreach ( $Destimonial_Image as $key => $value ) {
						if( !empty($Destimonial_Image[$key]) ){
						    $html .='
							<li class="iq-client-list '.$extra_class.'">
								<a class="clients-block wow fadeIn" data-wow-delay="0.6s" href="#" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeIn;">
								<img class="img-fluid" src="'.wp_get_attachment_url($Destimonial_Image[$key]).'" alt="image'.$count.'">
								</a>
							</li>';
			            }
					    $count++;
				    }
				$html .= '
				</ul>';

			$html .='
			</div>';
		}
	}


	return $html;
}
add_shortcode('xaminfancyclient', 'xaminfancyclient');
?>