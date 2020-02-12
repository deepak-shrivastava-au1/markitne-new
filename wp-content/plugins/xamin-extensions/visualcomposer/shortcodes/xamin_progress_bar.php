<?php
// xamin Title
function xaminprogress( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'style_type'		=> '0',
		'progress'   		=> '',
		'tab_title'   		=> '',
		'tab_score'   		=>  '',
		'extra_class'		=> '',
		'position'		=> 'left',
		'css' => '',
		'pro_color'			=> '',
	), $atts ) );

	$css_class = '';

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}


	// features loop
	$pro_out	= '';
	$progress		= (array) vc_param_group_parse_atts( $progress );
	$pro_data	= array();


	foreach ( $progress as $data ) :

	$new_line 				      = $data;
	$new_line['tab_title']	      = isset( $data['tab_title'] ) ? $data['tab_title'] : '';
	$new_line['tab_score']  = isset( $data['tab_score'] ) ? $data['tab_score'] : '';
	$pro_data[] 		      = $new_line;

	endforeach;

	$pro_color = $pro_color ? ' background: ' . $pro_color . ';' : '';

	$out = '';

	if($style_type == 0){
	$out .=	'<div class="iq-services-box wow fadeInUp text-'.$position.' '.$extra_class.' '. esc_attr( $css_class ) .'">';
			foreach ( $pro_data as $line ) :
	$out .=	'<div class="services-content">
					<h6>'.$line['tab_title'].'</h6>
					<span class="progress-value">'.$line['tab_score'].'%</span>
					<div class="iq-progress-bar">
						<span class="position-relative" style="'.$pro_color.'" data-percent="'.$line['tab_score'].'"></span>
					</div>
			</div>';
			endforeach;
	$out .=	'</div>';
	}

	if($style_type == 1){
	$out .=	'<div class="services-content wow fadeInUp progress-style text-'.$position.' '.$extra_class.' '. esc_attr( $css_class ) .'">';
			foreach ( $pro_data as $line ) :
			$out .=	'<div class="progress-content"><div class="progress-value">'.$line['tab_score'].'%</div>
						<div class="progress-title">
							<div class="progress-main">
								<h6>'.$line['tab_title'].'</h6>
							</div>
							<div class="iq-progress-bar">
								<span class="position-relative" style="'.$pro_color.'" data-percent="'.$line['tab_score'].'"></span>
							</div>
						</div>
						</div>';
			endforeach;
	$out .=	'</div>';
	}


	return $out;
}
add_shortcode('xaminprogress','xaminprogress');
?>