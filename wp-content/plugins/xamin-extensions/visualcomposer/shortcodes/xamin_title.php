<?php
// appino Title
function xamintitle( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'extra_class'  			=> '',
		'text_white'			=> '1',
		'sub_text_white'		=> '1',
		'shadow_margin' 		=> '1',
		'xamin_subtitle_content'=> '',
		'xamintitle_content'	=> '',
		'title_color'			=> '',
		'sub_title_color'		=> '',
		'position'				=> 'left',
		'tag'					=> 'h2',
		'title_content'			=> '',
		'content_color'			=> '',
		'css' 					=> '',
		'delay_time'			=> '',
	), $atts ) );

	$css_class = '';

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
	$sub_title_color = $sub_title_color ? ' style="color: ' . $sub_title_color . ';"' : '';
	$content_color = $content_color ? ' style="color: ' . $content_color . ';"' : '';

	if(!empty($delay_time))
	{
		$delay_time = 'data-wow-delay="'.$delay_time.'s"';
	}

	$out ='';

	if($text_white == 1)
	{
		if($shadow_margin == 1)
		{
		$out .='<div class="title-box wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '. $delay_time .'>';
		}
		if($shadow_margin == 2)
		{
		$out .='<div class="title-box wow fadeInUp title-shadow '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '. $delay_time .'>';
		}
	}
	if($text_white == 2)
	{
		if($shadow_margin == 1)
		{
		$out .='<div class="title-box wow fadeInUp text-white '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '. $delay_time .'>';
		}
		if($shadow_margin == 2)
		{
		$out .='<div class="title-box wow fadeInUp text-white title-shadow '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '. $delay_time .'>';
		}
	}
	if($sub_text_white == 1)
	{
		$out .='<span class="title-design" ' . $sub_title_color . '>'.$xamin_subtitle_content.'</span>';
	}
	if($sub_text_white == 2)
	{
		$out .='<span class="title-design sub-title" ' . $sub_title_color . '>'.$xamin_subtitle_content.'</span>';
	}
		$out .='<'.$tag.' ' . $title_color . '>'.$xamintitle_content.'</'.$tag.'>';
		if(!empty($title_content)){
		$out .='<p ' . $content_color . '>'.$title_content.'</p>';
		}

	$out .='</div>';

	return $out;
}
add_shortcode('xamintitle','xamintitle');
?>