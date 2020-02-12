<?php
// Fancy List
function consulfancyList( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
 		'style_type'        => '0',
		'features'          => '',
		'position'	        => 'left',
		'tag'		        => 'h2',
		'image'	            => '',
		'extra_class'       => '',
		'xamintitle_content' => 'Easy to Customize',
		'fancylist_content' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
		'openiconic'        => '',
		'fontawesome'       => '',
		'typicons'          => '',
		'entypo'            => '',
		'linecons'          => '',
		'ionicons'          => '',
		'title_color'	    => '',
		'list_text_color'	=> '',
		'icon_color'	    => '',
		'delay_time'		=> '',
		'effect_on_hover'   => '',
    ) );

	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'vc_openiconic' );
	wp_enqueue_style( 'vc_typicons' );
	wp_enqueue_style( 'vc_entypo' );
	wp_enqueue_style( 'vc_linecons' );

	$icons ='';

	$style_type = $data['style_type'] ?  $data["style_type"]  : '';

	$position = $data['position'] ?  $data["position"]  : '';

	$tag = $data['tag'] ?  $data["tag"]  : '';

	$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

	$xamintitle_content = $data['xamintitle_content'] ?  $data["xamintitle_content"]  : '';

	$fancylist_content = $data['fancylist_content'] ?  $data["fancylist_content"]  : '';

	$title_color = $data['title_color'] ?  $data["title_color"]  : '';

	$list_text_color = $data['list_text_color'] ?  $data["list_text_color"]  : '';

	$icon_color = $data['icon_color'] ?  $data["icon_color"]  : '';

    $effect_on_hover = $data['effect_on_hover'] ?  $data["effect_on_hover"]  : '';

	$delay_time = $data['delay_time'] ?  $data["delay_time"]  : '';
	if(!empty($delay_time))
	{
		$delay_time = 'data-wow-delay="'.$delay_time.'s"';
	}

	$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
	$list_text_color = $list_text_color ? ' style="color: ' . $list_text_color . ';"' : '';
	$icon_color = $icon_color ? ' style="color: ' . $icon_color . ';"' : '';

	$url = $data['image'] ? wp_get_attachment_image_url( $data["image"], "full") : '';
	$image = '<img class="fancy-list-img" src="'. $url .'" alt="fancy-list" />';

	$features = $data['features'] ?  $data["features"]  : '';
	$features = vc_param_group_parse_atts( $features );

	$out ='';

	if($style_type == 0) {

		$out .='
		<div class="service-box wow fadeInUp  text-'.$position.' '.$extra_class.'" '. $delay_time .'>
			'.$image.'
			<div class="service-detail align-self-center">';
			    $out .= '<'.$tag.' '.$title_color.' class="mb-2">'.$xamintitle_content.'</'.$tag.'>';
				$out .= '<p>'.$fancylist_content.'</p>';
				$out .= '
				<div class="text-left">';
					$out .= '
					<ul class="iq-list">';
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
				            $out .='<li><i class="'.$data['icon'].'" ' . $icon_color . '></i><span ' . $list_text_color . '>'.$data['xaminsubtitle_content'].'</span></li>';
				        }
					$out .= '
					</ul>';
				$out .= '
				</div>';
			$out .= '
			</div>';
	    $out .= '
	    </div>';
	}

	if($style_type == 1) {

		if($data['effect_on_hover'] == '0'){

            $out .='<div class="service-boxon-shodow wow fadeInUp  text-'.$position.' '.$extra_class.'" '. $delay_time .'>';

		} else {

			$out .='<div class="service-box style2 wow fadeInUp  text-'.$position.' '.$extra_class.'" '. $delay_time .'>';

		}

		    $out .=' '.$image.'
			<div class="service-detail align-self-center">';
				$out .= '<'.$tag.' '.$title_color.' class="mb-2 title">'.$xamintitle_content.'</'.$tag.'>';
				$out .= '<p class="content">'.$fancylist_content.'</p>';
				$out .= '
				<div class="text-left">';
					$out .= '
					<ul class="iq-list">';
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
						    $out .='<li><i class="'.$data['icon'].'" ' . $icon_color . '></i><span ' . $list_text_color . '>'.$data['xaminsubtitle_content'].'</span></li>';
						}
					$out .= '
					</ul>';
				$out .= '
				</div>';
		    $out .= '
		    </div>';
	    $out .= '
	    </div>';
	}

	return $out;

}
add_shortcode('consulfancyList', 'consulfancyList');
?>