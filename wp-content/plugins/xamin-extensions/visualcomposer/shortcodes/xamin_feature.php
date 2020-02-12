<?php
// Clients
function xaminfeaturescircle( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
		'features' => '',
		'image' 		=> '',
		'xaminsubtitle_content' => '',
		'logo_image'	=> '',
		'extra_class'   => '',
		'css'   => '',
	 ) );

	$css_class = '';

		$features = $data['features'] ?  $data["features"]  : '';
		$features = vc_param_group_parse_atts( $features );

		$url = $data['logo_image'] ? wp_get_attachment_image_url( $data["logo_image"], 'full') : '';	



		$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

		$css = $data['css'] ?  $data["css"]  : '';

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

	
	$xamin_options = get_option('xamin_options');

    $html = '';
	if( !empty($features) ){

		
			$html .='<div class="xamin-feature-circle wow zoomIn postion-relative '. esc_attr( $css_class ) .' '.$extra_class.'">';
				$html .='<div class="xamin-img">';
				$html .='<ul class="list-inline mb-0">';
						$count = 0;
						foreach ( $features as $data ) {
						
						$html .='<li class="list-inline-item  "><div class="feature-info"><div class="feature-img"><img class="img-fluid client-img" src="'.wp_get_attachment_url($data['image'] ).'" alt="image'.$count.'"></div>
						<h6>'.$data['xaminsubtitle_content'].'</h6></div></li>';
						$count ++;
						}
				$html .='</ul>';
				$html .='<div class="dot-circle">';
					$html .='<div class="effect-circle"></div>';
				$html .='</div>';
				$html .='<div class="main-circle">';
					if( !empty($url) ){
					$html .='<div class="circle-bg">
								<img src="'.$url.'" alt="image">
							</div>';
						}
				$html .='</div>';
			$html .='</div>';
		$html .='</div>';
	}
	return $html;
}
add_shortcode('xaminfeaturescircle', 'xaminfeaturescircle');
?>