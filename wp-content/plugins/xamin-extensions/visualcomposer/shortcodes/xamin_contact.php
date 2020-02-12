<?php
// xamin Title
function xaminconatct( $atts, $content = null ) {

	 $data = wp_parse_args( $atts, array(
				'xamintitle_content'  		=> 'Easy to Customize',
				'image'       				=> '',
				'bg_image'					=> '',
				'position' 					=> '',
				'html_content'				=> '',
				'contact_type' 				=> '1',
				'openiconic' 				=> '',
                'fontawesome' 				=> '',
                'typicons' 					=> '',
                'entypo' 					=> '',
				'linecons' 					=> '',
				'ionicons' 					=> '',
				'extra_class'               => '',
				'flaticon'	                => '',
				'tag'						=> 'h2',
				'css'						=> '',
				'title_color'				=> '',
				'icon_color'				=> '',
				'back_color'			=> '',
			) );

		$css_class = '';

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'vc_openiconic' );
		wp_enqueue_style( 'vc_typicons' );
		wp_enqueue_style( 'vc_entypo' );
		wp_enqueue_style( 'vc_linecons' );

		$title_color = $data['title_color'] ? $data["title_color"] : '';

		$icon_color = $data['icon_color'] ? $data["icon_color"] : '';

		$back_color = $data['back_color'] ? $data["back_color"] : '';

		$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
		$icon_color = $icon_color ? ' style="color: ' . $icon_color . '; background: ' . $back_color . ';"' : '';

		$icons ='';
		$icon_f = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'" ' . $icon_color . '></i>' : '';
		$icon_o = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'" ' . $icon_color . '></i>' : '';
		$icon_t = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'" ' . $icon_color . '></i>' : '';
		$icon_e = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'" ' . $icon_color . '></i>' : '';
		$icon_l = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'" ' . $icon_color . '></i>' : '';
		$icon_i = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'" ' . $icon_color . '></i>' : '';
		$icon_fl = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'" ' . $icon_color . '></i>' : '';


		$bg_url = $data['bg_image'] ? wp_get_attachment_image_url( $data["bg_image"], "full") : '';
		$bg_image = '<img class="hover-img" src="'. $bg_url .'" alt="fancybox" />';

		$url = $data['image'] ? wp_get_attachment_image_url( $data["image"]) : '';
		$image = '<img src="'. $url .'" alt="fancybox" />';
		if($url)
		{
			$icons = $image;
		}
		else
		{
		    if($icon_o || $icon_f || $icon_t || $icon_e || $icon_l || $icon_i || $icon_fl)
			{
	            $icons = ' '.$icon_f.''.$icon_o.''.$icon_t.''.$icon_e.''.$icon_l.''.$icon_i.''.$icon_fl.' ';
	        }
		}

		$contact_type = $data['contact_type'] ?  $data["contact_type"]  : '';

		$position = $data['position'] ? $data["position"] : '';

		$tag = $data['tag'] ? $data["tag"] : '';

		$xamintitle_content = $data['xamintitle_content'] ? $data["xamintitle_content"]  : '';

		$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

		$css = $data['css'] ?  $data["css"]  : '';

		if(!empty($css)){
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
			}

		$xamin_option = get_option('xamin_options');


		$out ='';

		$out .='<div class="contact-box d-flex  text-'.$position.' '.$extra_class.' '. esc_attr( $css_class ) .'">';
			$out .=''.$icons.'';
        	$out .='<div class="service-detail">';
			$out .='<'.$tag.' class="mb-2" ' . $title_color . '>'.$xamintitle_content.'</'.$tag.'>';

				switch ($contact_type) {
					case 1:
					$out .='<ul class="list-inline mb-0">';
					if(!empty($xamin_option['email']))
					{
					$out .='<li><a href="mailto:'. esc_html($xamin_option['email']) .'">
					'. esc_attr($xamin_option['email']) .'</a></li>';
					}
					if(!empty($xamin_option['second_email']))
					{
					$out .='<li><a href="mailto:'. esc_html($xamin_option['second_email']) .'">
					'. esc_attr($xamin_option['second_email']) .'</a></li>';
					}
					$out .='</ul>';
					break;

					case 2:
					$out .='<ul class="list-inline mb-0">';
					if(!empty($xamin_option['phone']))
					{
					$out .='<li><a href="tel:'. str_replace(str_split('(),-" '), '',$xamin_option['phone']) .'">
						'. esc_attr($xamin_option['phone']) .'</a></li>';
					}
					if(!empty($xamin_option['second_phone']))
					{
					$out .='<li><a href="tel:'. str_replace(str_split('(),-" '), '',$xamin_option['second_phone']) .'">
						'. esc_attr($xamin_option['second_phone']) .'</a></li>';
					}
					$out .='</ul>';
					break;

					case 3:
					if(!empty($xamin_option['address']))
					{
					$out .='<p class="mb-0">'. esc_attr($xamin_option['address']) .'</p>';
					}
					break;

					case 4:

						$data = $xamin_option['social-media-iq'];

						$out .='<ul>';

						foreach ($data as $key=>$options )
						{

							if($options) {
								$out .='<li class="d-inline"><a href="'.$options.'"><i class="fa fa-'.$key.'"></i></a></li>';
							}
						}
						$out .='</ul>';

					break;

				}

			$out .='</div>';
		$out .='</div>';
	    return $out;

}
add_shortcode('xaminconatct','xaminconatct');
?>