<?php
function xaminMap( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
	    'extra_class'  	       => '',
		'mailchimp_shortcode'  => '',
		'css' 			       => '',
	) );

	$css_class = '';

	$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';
	$mailchimp_shortcode = $data["mailchimp_shortcode"] ?  $data["mailchimp_shortcode"]  : '';
	$css = $data['css'] ?  $data["css"]  : '';

	$xamin_option = get_option('xamin_options');
	$shortcode = $xamin_option['xamin_map'];
    
	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
	}

	$out = "";

    if(!empty($shortcode)) {

		$out .= "<div class='iq-xamin-map'>".	
		        do_shortcode($shortcode)."";
		$out .= "</div>";

    }

	return $out;
}
add_shortcode('xaminMap','xaminMap');
?>