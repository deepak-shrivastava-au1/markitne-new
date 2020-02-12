<?php
// xamin Title
function xaminflinglayer( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'layer_image1'		=> '',
		'layer_image2'		=> '',
		'fling_position'	=> 'left',
		'fling_style'		=> 'style-one',
		'extra_class'		=> '',
	), $atts ) );

		$out =  '';
		$id = rand();
			if($fling_style == "style-one"){
				$out .= '<div class="layer_wrap iq-objects '.$extra_class.' '.$fling_style.' '.$fling_position.'" id="object_'.$id.'">';
							if(wp_get_attachment_image_url($layer_image1, 'full')){
								$out .='<span class="iq-objects-01">
									<img src="'.wp_get_attachment_image_url($layer_image1, 'full').'" alt="drive02">
								</span>';
							}

				$out .= '</div>';
			}
			if($fling_style == "style-two"){
				$out .= '<div class="layer_wrap iq-objects '.$extra_class.' '.$fling_style.'" id="object_'.$id.'">';
							if(wp_get_attachment_image_url($layer_image1, 'full')){
								$out .='<span class="iq-objects-02">
									<img src="'.wp_get_attachment_image_url($layer_image1, 'full').'" alt="drive02">
								</span>';
							}
							if(wp_get_attachment_image_url($layer_image2, 'full')){
								$out .='<span class="iq-objects-03">
									<img src="'.wp_get_attachment_image_url($layer_image2, 'full').'" alt="drive02">
								</span>';
							}

				$out .= '</div>';
			}

		return $out;
}
add_shortcode('xaminflinglayer','xaminflinglayer');
?>