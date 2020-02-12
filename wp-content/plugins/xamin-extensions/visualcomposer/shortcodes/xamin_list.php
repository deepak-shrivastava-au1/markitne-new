<?php
// Button
function xaminList( $atts, $content = null ) {

	 $data = wp_parse_args( $atts, array(
			'features' => '',
			'xaminsubtitle_content' => '',
			'openiconic' => '',
			'fontawesome' => '',
			'typicons' => '',
			'entypo' => '',
			'linecons' => '',
			'ionicons' => '',
			'position'		=> 'left',
			'extra_class'		=> '',
			'css'		=> '',
			'text_color'	=> '',
			'icon_color'	=> '',
            ) );

		$css_class = '';

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'vc_openiconic' );
		wp_enqueue_style( 'vc_typicons' );
		wp_enqueue_style( 'vc_entypo' );
		wp_enqueue_style( 'vc_linecons' );

		$icons ='';

		$features = $data['features'] ?  $data["features"]  : '';
		$features = vc_param_group_parse_atts( $features );

		$position = $data['position'] ?  $data["position"]  : '';

		$text_color = $data['text_color'] ?  $data["text_color"]  : '';

		$icon_color = $data['icon_color'] ?  $data["icon_color"]  : '';

		$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

		$css = $data['css'] ?  $data["css"]  : '';

		if(!empty($css)){
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
			}

		$text_color = $text_color ? ' style="color: ' . $text_color . ';"' : '';
		$icon_color = $icon_color ? ' style="color: ' . $icon_color . ';"' : '';

		$out ='';

		$out .= '
		<div class="text-'.$position.' '.$extra_class.' '. esc_attr( $css_class ) .'">
			<ul class="iq-list"  >';
			foreach ( $features as $data ) {

				if($data['type'] == "fontawesome"){
					$data['fontawesome'] ? $data['icon'] = $data['fontawesome'] : '';
					}
					else if($data['type'] == "openiconic"){

					$data['openiconic'] ? $data['icon'] =$data['openiconic'] : '';
					}
					else if($data['type'] == "typicons"){

					$data['typicons'] ? $data['icon'] =$data['typicons'] : '';
					}
					else if($data['type'] == "entypo"){

					$data['entypo'] ? $data['icon'] = $data['entypo'] : '';
					}
					else if($data['type'] == "linecons"){

					$data['linecons'] ? $data['icon'] =$data['linecons'] : '';
					}
					else if($data['type'] == "Ionicons"){

						$data['ionicons'] ? $data['icon'] =$data['ionicons'] : '';
					}

			$out .='<li><i class="'.$data['icon'].'" ' . $icon_color . '></i><span ' . $text_color . '>'.$data['xaminsubtitle_content'].'</span></li>';

			}
			$out .= '</ul>
		</div>';

		return $out;

}
add_shortcode('xaminList', 'xaminList');
?>