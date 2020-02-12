<?php
// Button
function xamin_timer( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'extra_class'     => '',
		'css_editor'      => '',
	), $atts ) );

	$css_class = '';

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}
		
	$out ='';
			
	$out = '<div class="shorttimer '.$extra_class.' '. esc_attr( $css_class ) .'">'; 
				$out .='<div class="expire_date" id="October 24,2019"></div>
						<ul class="example mb-0 pl-0 countdown">
							<li><span class="days">00</span><p class="days_text">Days</p></li>
							
							<li><span class="hours">00</span><p class="hours_text">Hours</p></li>
							
							<li><span class="minutes">00</span><p class="minutes_text">Minutes</p></li>
							
							<li><span class="seconds">00</span><p class="seconds_text">Seconds</p></li>
						</ul>
			</div>';
	return $out;
	
}
add_shortcode('xamin_timer', 'xamin_timer');
?>