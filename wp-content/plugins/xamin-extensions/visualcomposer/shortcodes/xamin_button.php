<?php
// Button
function xaminButton( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
		'link'                    => '',
		'button_position'        => 'left',
		'button_white'		=> '1',
		'extra_class'        => '',
		'css' => '',
		'title_color'		=> '',
		'background_color'		=> '',
	) );

	$css_class = '';

	$link = $data['link'] ? $data["link"] : '';

	$button_white = $data['button_white'] ? $data["button_white"] : '';

	$extra_class = $data['extra_class'] ? $data["extra_class"] : '';

	$button_position = $data['button_position'] ? $data["button_position"] : '';

	$css = $data['css'] ? $data["css"] : '';

	$title_color = $data['title_color'] ? $data["title_color"] : '';

	$background_color = $data['background_color'] ? $data["background_color"] : '';

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
	$background_color = $background_color ? ' style="background: ' . $background_color . ';"' : '';
	
	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}


	$link = ('||'===$link)?'':$link;
	$link = vc_build_link($link);
	$a_href =$link['url'];
	$a_title = $link['title'];


	$out ='';

	$out .='<div class=" text-'.$button_position.' '.$extra_class.' '. esc_attr( $css_class ) .'">';
	if($button_white == 1)
	{
		$out .='<a class="button button-icon" '.$background_color.' href="'. $a_href . '"><span class="btn-effect" '.$title_color.'> '.$a_title.'</span></a>';
	}
	if($button_white == 2)
	{
		$out .='<a class="button white-btn button-icon" href="'. $a_href . '"><span class="btn-effect"> '.$a_title.'</span></a>';
	}
	if($button_white == 3)
	{
		$out .='<a class="button blue-btn button-icon" href="'. $a_href . '"><span class="btn-effect"> '.$a_title.'</span></a>';
	}
	if($button_white == 4)
	{
		$out .='<a class="button border-btn button-icon" href="'. $a_href . '"><span class="btn-effect"> '.$a_title.'</span></a>';
	}
	$out .='</div>';
	return $out;


}
add_shortcode('xaminButton', 'xaminButton');
?>