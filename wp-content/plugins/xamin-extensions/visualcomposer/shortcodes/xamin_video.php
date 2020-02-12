<?php
// Parallax Video
function xaminvideo( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style_type'             => '1',
		'video_image'            => '',
		'video_yt_key'		     => '',
		'icon_color'             => '',
		'icon_bg_color'          => '',
		'extra_class'	         => '',
		'css'                    => '',
	), $atts ) );

	$css_class = '';

	$icon_color = 'style="color:'.$icon_color.'; background-color:'.$icon_bg_color.'"'; 

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

	if(is_numeric($video_image)){
		$video_image = wp_get_attachment_url( $video_image );
	}

	$out = '';

    if($style_type == 1) {
		$out .= '
		<div class="scroll-effect '.$extra_class.' '. esc_attr( $css_class ) .'">';
			if(!empty($video_image)){
				$out .= '<img src="'.$video_image.'" class="img-fluid img-one" alt="#">';
			}
			if(!empty($video_yt_key)){
				$out .= '
				<div class="main-video">';
					$out .= '
					<div class="video-img">';
						$out .= '
						<div class="consult-video video-btn">';
							$out .= '
							<div class="btn-waves">
								<div class="waves wave-1"></div>
								<div class="waves wave-2"></div>
								<div class="waves wave-3"></div>
							</div>';
							$out .= '
							<a href="'.esc_html($video_yt_key).'" class="iq-video popup-youtube">
							    <i class="fa fa-play"></i>
							</a>';
						$out .= '
						</div>';
					$out .= '
					</div>';
				$out .= '
				</div>';
			}
		$out .= '
		</div>';
	}	

	if($style_type == 2) {
		$out .= '
		<div class="iq-video-button '.$extra_class.' '. esc_attr( $css_class ) .'">';
			if(!empty($video_image)){
				$out .= '<img src="'.$video_image.'" class="img-fluid img-one" alt="#">';
			}
			if(!empty($video_yt_key)){
				$out .= '
				<div class="main-video">';
					$out .= '
					<div class="video-img">';
						$out .= '
						<div class="consult-video video-btn">';
							$out .= '
							<div class="btn-waves">
								<div class="waves wave-1"></div>
								<div class="waves wave-2"></div>
								<div class="waves wave-3"></div>
							</div>';
							$out .= '
							<a href="'.esc_html($video_yt_key).'" class="iq-video popup-youtube" '.$icon_color.'>
							    <i class="fa fa-play"></i>
							</a>';
						$out .= '
						</div>';
					$out .= '
					</div>';
				$out .= '
				</div>';
			}
		$out .= '
		</div>';
	}

	return $out;
}
add_shortcode('xaminvideo', 'xaminvideo');
?>