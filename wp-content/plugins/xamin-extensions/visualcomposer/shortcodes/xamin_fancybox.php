<?php
// xamin Title
function xaminFancybox( $atts, $content = null ) {

	 $data = wp_parse_args( $atts, array(
				'xamintitle_content'  		=> 'Easy to Customize',
				'xaminsubtitle_content' 	=> 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
				'image'       				=> '',
				'bg_image'					=> '',
				'position' 					=> 'left',
				'html_content'				=> '',
				'style_type' 				=> '0',
				'icon_size'                 => 'default',
				'openiconic' 				=> '',
                'fontawesome' 				=> '',
                'typicons' 					=> '',
                'entypo' 					=> '',
				'linecons' 					=> '',
				'ionicons' 					=> '',
				'extra_class'               => '',
				'flaticon'	                => '',
				'tag'						=> 'h2',
				'css' 						=> '',
				'text_white'				=> '1',
				'circle_effect'				=> '',
				'circle_backgroundeffect'	=> '',
				'circle_type'				=> '0',
				'title_color'				=> '',
				'content_color'				=> '',
				'icon_color'				=> '',
				'icon_bg_color'             => '',
				'icon_bgcolor_option'       => '',
				'delay_time'				=> '',
				'link_title'				=> '',
				'link_url'					=> '',
				'arrow_image'				=> '',
				'arrowbackground_image'		=> '',
				'link_style'				=> '',
				'bg_style_enable'			=> '1',
				'bg_img'					=> '',
				'iconimg_option'            => 'default',
				'number_effect'             => '',
				'xamin_number'              => '0',
				'box_hover_effect'          => 'none',
				'icon_type'                 => 'iq-icon',
				'content_margin'            => 'default', 

			) );

		$css_class = '';

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'vc_openiconic' );
		wp_enqueue_style( 'vc_typicons' );
		wp_enqueue_style( 'vc_entypo' );
		wp_enqueue_style( 'vc_linecons' );

		$title_color = $data['title_color'] ?  $data["title_color"]  : '';

		$link_style = $data['link_style'] ?  $data["link_style"]  : '';
		$bg_style_enable = $data['bg_style_enable'] ?  $data["bg_style_enable"]  : '';

		$content_color = $data['content_color'] ?  $data["content_color"]  : '';

		$icon_bgcolor_option = $data['icon_bgcolor_option'] ?  $data["icon_bgcolor_option"]  : '';

		$icon_color = $data['icon_color'] ?  $data["icon_color"]  : '';

		$icon_size = $data['icon_size'] ?  $data["icon_size"]  : '';

		$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';
		$content_color = $content_color ? ' style="color: ' . $content_color . ';"' : '';

		$icon_color = $icon_color ? ' style="color: ' . $icon_color . ';"' : '';

        $out  = "";

		if($data['icon_bgcolor_option'] == "0") {

			$iconcolor = $data['icon_color'] ?  $data["icon_color"]  : '';
            $icon_bgcolor = $data['icon_bg_color'] ?  $data["icon_bg_color"]  : '';	
		    $icon_devor = 'style="color:'.$iconcolor.'; background-color:'.$icon_bgcolor.'"'; 
          
            $icons ='';
			$icon_f = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'" '.$icon_devor.'></i>' : '';
			$icon_o = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'" '.$icon_devor.'></i>' : '';
			$icon_t = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'" '.$icon_devor.'></i>' : '';
			$icon_e = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'" '.$icon_devor.'></i>' : '';
			$icon_l = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'" '.$icon_devor.'></i>' : '';
			$icon_i = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'" '.$icon_devor.'></i>' : '';
			$icon_fl = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'" '.$icon_devor.'></i>' : '';
			

		} else {

			$icons ='';
			$icon_f = $data['fontawesome'] ? '<i aria-hidden="true" class="'.$data['fontawesome'].'" '.$icon_color.'></i>' : '';
			$icon_o = $data['openiconic'] ? '<i aria-hidden="true" class="'.$data['openiconic'].'" '.$icon_color.'></i>' : '';
			$icon_t = $data['typicons'] ? '<i aria-hidden="true" class="'.$data['typicons'].'" '.$icon_color.'></i>' : '';
			$icon_e = $data['entypo'] ? '<i aria-hidden="true" class="'.$data['entypo'].'" '.$icon_color.'></i>' : '';
			$icon_l = $data['linecons'] ? '<i aria-hidden="true" class="'.$data['linecons'].'" '.$icon_color.'></i>' : '';
			$icon_i = $data['ionicons'] ? '<i aria-hidden="true" class="'.$data['ionicons'].'" '.$icon_color.'></i>' : '';
			$icon_fl = $data['flaticon'] ? '<i aria-hidden="true" class="'.$data['flaticon'].'" '.$icon_color.'></i>' : '';

		}

		


		$bg_url = $data['bg_image'] ? wp_get_attachment_image_url( $data["bg_image"], "full") : '';
		if($bg_url)
		{
		$bg_image = '<img class="hover-img" src="'. $bg_url .'" alt="fancybox" />';
		}

		$arrow_url = $data['arrow_image'] ? wp_get_attachment_image_url( $data['arrow_image'], "full") : '';
		if($arrow_url)
		{
		$arrow_image = '<img class="arrow-img" src="'. $arrow_url .'" alt="fancybox" />';
		}

		$arrowbackground_image_url = $data['arrowbackground_image'] ? wp_get_attachment_image_url( $data['arrowbackground_image'], "full") : '';
		if($arrowbackground_image_url)
		{
		$arrowbackground_image = '<img class="arrowbackground_image-img" src="'. $arrowbackground_image_url .'" alt="fancybox" />';
		}

		$bg_img_url = $data['bg_img'] ? wp_get_attachment_image_url( $data['bg_img'], "full") : '';
		if($bg_img_url)
		{
		$bg_img = '<img class="bg_img-img" src="'. $bg_img_url .'" alt="fancybox" />';
		}

			
	

		$url = $data['image'] ? wp_get_attachment_image_url( $data["image"],"full") : '';
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

		$delay_time = $data['delay_time'] ?  $data["delay_time"]  : '';
		if(!empty($delay_time))
		{
			$delay_time = 'data-wow-delay="'.$delay_time.'s"';
		}

		$style_type = $data['style_type'] ?  $data["style_type"]  : '';

		$position = $data['position'] ? $data["position"] : '';

		$tag = $data['tag'] ? $data["tag"] : '';

		$xamintitle_content = $data['xamintitle_content'] ? $data["xamintitle_content"]  : '';

		$xaminsubtitle_content = $data['xaminsubtitle_content'] ?  $data["xaminsubtitle_content"]  : '';

		$extra_class = $data['extra_class'] ?  $data["extra_class"]  : '';

		$css = $data['css'] ?  $data["css"]  : '';

		$circle_effect = $data['circle_effect'] ?  $data["circle_effect"]  : '';

		$circle_backgroundeffect = $data['circle_backgroundeffect'] ?  $data["circle_backgroundeffect"]  : '';

		$circle_type = $data['circle_type'] ?  $data["circle_type"]  : '';

		$text_white = $data['text_white'] ?  $data["text_white"]  : '';

		$link_title = $data['link_title'] ?  $data["link_title"]  : '';

		$iconimg_option = $data['iconimg_option'] ?  $data["iconimg_option"]  : '';

		$link_url = $data['link_url'] ?  $data["link_url"]  : '';

		$number_effect = $data['number_effect'] ?  $data["number_effect"]  : '';

		$xamin_number = $data['xamin_number'] ?  $data["xamin_number"]  : '';

		$box_hover_effect = $data['box_hover_effect'] ?  $data["box_hover_effect"]  : '';

		$icon_type = $data['icon_type'] ?  $data["icon_type"]  : '';

		$content_margin = $data['content_margin'] ?  $data["content_margin"]  : '';

		if(!empty($css)){
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
			}

		$out ='';



	if($style_type == 0)
	{
		$out .='
		<div class="service-box wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '.$delay_time.'>
				'.$icons.'
                <div class="service-detail align-self-center">';
					if($text_white == 1)
					{
					$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					}
					if($text_white == 2)
					{
					$out .='<'.$tag.' class="text-white mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					}
					if(!empty($xaminsubtitle_content))
					{
					$out .='<p '.$content_color.'>'.$xaminsubtitle_content.'</p>';
					}
		$out .='</div>
        </div>';
	    return $out;
	}

	if($style_type == 1)
	{
		$out .='<div class="xamin-services wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
					if(isset($bg_image))
					{
					$out .='<div>
						'.$bg_image.'
						</div>';
					}
			$out .='<div class="services-detail">';
					if(isset($icons))
					{
					$out .='<div>
						'.$icons.'
						</div>';
					}
			$out .='<'.$tag.' class="mb-1" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
					$out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
					}
			$out .='</div>
				</div>';
		return $out;
	}

	if($style_type == 2)
	{

		if($data['circle_effect'] == "0") {

			if($circle_type == 0) {
				$out .='
				<div class="consult-services xamin-circle right wow fadeInUp '.$box_hover_effect.' '.$icon_size.' '.$extra_class.' text-'.$position.'" '.$delay_time.'>'; //Main div open
				    if(isset($arrow_image)) { 
					    $out .= '<div class="arrow_img"> '.$arrow_image.'</div>';//Main div open
			        } 

			} else {

		        $out .='
		        <div class="consult-services xamin-circle wow fadeInUp '.$box_hover_effect.'  '.$icon_size.' '.$extra_class.' text-'.$position.'" '.$delay_time.'>'; //Main div open
		    }

		} else{
			
			$out .='<div class="consult-services wow fadeInUp '.$content_margin.' '.$box_hover_effect.' '.$icon_size.' '.$extra_class.' text-'.$position.'" '.$delay_time.'>'; //Main div open
		}
				$out .='
				<div class="circle-effect">
					'.$icons.'
				</div>';

				$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';

				if(!empty($xaminsubtitle_content)) {
			        $out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
				}

				if($data['number_effect'] == "0") {

					if(!empty($xamin_number)) {

					    $out .= '<span class="number">'.$xamin_number.'</span>';
					}  
	                
				}

		$out .='
		</div>'; //Main div close
		return $out;
	}

	if($style_type == 3)
	{
		$out ='<div class="xamin-award wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>
					<div class="award-img">
					'.$icons.'
					</div>
					<'.$tag.' class="mt-3" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
				$out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
					}
			$out .='</div>';
		return $out;
	}
	if($style_type == 4)
	{
		if($data['circle_effect'] == "0")
		{
			if($circle_type == 0)
			{
				$out .='<div class="xamin-process xamin-circle right wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>'; if(isset($arrow_image)) { 
					$out .= '<div class="arrow_img"> '.$arrow_image.'</div>';
					 }
			}
			else {
				$out .='<div class="xamin-process xamin-circle wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
			}
		}
		else{
			$out .='<div class="xamin-services wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
		}
				$out .='<div class="circle-effect">
					'.$icons.'
				</div>';
				$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
				$out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
					}
			$out .='</div>';
		return $out;
	}

	if($style_type == 5)
	{
		if($bg_style_enable == 1){
		$out ='<div class="fancy_service wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>
					<div class="hover-effect"></div>
					<div class="fancy-info">

					'.$icons.'
					
					<'.$tag.' class="mt-4 mb-3 title" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
				$out .='<p class="" '.$content_color.'>'.$xaminsubtitle_content.'</p>
					<a class="link-btn" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'<i class="ion-ios-arrow-right"></i></span></a>
					</div>';
					}
			$out .='</div>';
		}
		if($bg_style_enable == 2){
		$out ='<div class="fancy_service style2 wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>

		'; if(isset($bg_img)) { 
					$out .= '<div class="bg_img"> '.$bg_img.'</div>';
					 }
					
					$out .= ' <div class="fancy_block"><div class="fancy-info">

					
					
					<'.$tag.' class="mt-4 mb-3 title" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
				$out .='<p class="" '.$content_color.'>'.$xaminsubtitle_content.'</p>';
				if($link_style == 1){
					$out .='<a class="button" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'</span></a>';
					}
					if($link_style == 2){
					$out .='<a class="link-btn" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'<i class="ion-ios-arrow-right"></i></span></a>';
					}
					if($link_style == 3){
					$out .='<a class="button white-btn" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'</span></a>';
					}
					if($link_style == 4){
					$out .='<a class="button blue-btn" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'</span></a>';
					}
					if($link_style == 5){
					$out .='<a class="button border-btn" href="'. $link_url . '"><span class="btn-effect"> '.$link_title.'</span></a>';
					}
					$out .='</div>
					<div class="fancy_img" >'.$icons.'</div> </div>';
					}
			$out .='</div>';
		}
		return $out;
	}

	if($style_type == 6)
	{
		$out .='<div class="xamin-analytics wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
					
					if(isset($icons))
					{
					$out .='<div class="analytics-icon">
						'.$icons.'
						</div>';
					}
			$out .='<div class="analytics-detail">';
					
			$out .='<'.$tag.' class="mb-1" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
					$out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
					}
			$out .='</div>
				</div>';
		return $out;
	}

	if($style_type == 7) {

		$out .='
		<div class="xamin-client wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
					
			if(isset($icons)) {
			    $out .='
			    <div class="client-icon">
				    '.$icons.'
				</div>';
			}

			$out .='
			<div class="client-detail">';
					
			$out .='<'.$tag.' class="mb-1" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
			if(!empty($xaminsubtitle_content)) {
			    $out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
			}
			$out .='
			</div>
		</div>';

		return $out;
	}

	if($style_type == 8)
	{
		if($data['circle_effect'] == "0")
		{
			if($circle_type == 0)
			{
				$out .='<div class="consult-services xamin-square right wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'> '; if(isset($arrow_image)) { 
					$out .= '<div class="arrow_img"> '.$arrow_image.'</div>';
					 }
			}
			else {
				$out .='<div class="consult-services xamin-square wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
			}
		}
		else{
			$out .='<div class="consult-services   xamin-square wow fadeInUp '.$extra_class.' text-'.$position.'" '.$delay_time.'>';
		}
				if($circle_backgroundeffect == 0)
			{
				$out .='<div class="square-effect bg">
					'.$icons.'';
					 if(isset($arrowbackground_image)) { 
					$out .= '<div class="arrowbg_img"> '.$arrowbackground_image.'</div>';
					 }
				$out .='</div>';
			}
			else{
				$out .='<div class="square-effect">
					'.$icons.'
				</div>';
			}
				$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					if(!empty($xaminsubtitle_content))
					{
				$out .='<p class="mb-0">'.$xaminsubtitle_content.'</p>';
					}
			$out .='</div>';
		return $out;
	}

	if($style_type == 9)
	{
		$out .='
		<div class="fancybox-userbehavior wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '.$delay_time.'>';
			
			    $out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
				if(!empty($xaminsubtitle_content)) {
					$out .='<p>'.$xaminsubtitle_content.'</p>';
				}

				if(isset($icons)) {
				    $out .='<div class="analytics-icon">'.$icons.'</div>';
				}

		$out .='
        </div>';
	    return $out;
	}

	if($style_type == 10)
	{
		$out .='
		<div class="servicebox-userbehavior wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '.$delay_time.'>
	        <div class="service-box-icon">
	            '.$icons.'
	        </div>
            <div class="service-box-detail">';
				$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
				if(!empty($xaminsubtitle_content)) {
				    $out .='<p>'.$xaminsubtitle_content.'</p>';
				}
		    $out .='
		    </div>
        </div>';
	    return $out;
	}

	if($style_type == 11)
	{
		$out .='
		<div class="servicebox-datascience wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '.$delay_time.'>';
		    if($iconimg_option == 'yes'){
		    	$out .='
		        <div class="service-box-icon">
		            '.$icons.'
		        </div>';
		    }
		        
		    $out .='    
            <div class="service-box-detail">';
				$out .='<'.$tag.' class="data-title" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
				if(!empty($xaminsubtitle_content)) {
				    $out .='<p>'.$xaminsubtitle_content.'</p>';
				}

			    $out .='
			    <a class="link-btn" href="'. $link_url . '">
			        <span class="btn-effect"> '.$link_title.'<i class="ion-ios-arrow-right ml-2"></i></span>
			    </a>';
		    $out .='
		    </div>
        </div>';
	    return $out;
	}

	if($style_type == 12)
	{
		$out .='
		<div class="fancybox-visualization-service wow fadeInUp '.$extra_class.' text-'.$position.' '. esc_attr( $css_class ) .'" '.$delay_time.'>';
                
                if($icon_type == "iq-icon") {
	                $out .= '
			        <div class="icon-bg">
					    '.$icons.'
					</div>';
				} else {
					$out .= '<div class="box-image">'.$icons.'</div>';
				}

				$out.= '	
                <div class="service-detail align-self-center">';
					if($text_white == 1)
					{
					$out .='<'.$tag.' class="mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					}
					if($text_white == 2)
					{
					$out .='<'.$tag.' class="text-white mb-2" '.$title_color.'>'.$xamintitle_content.'</'.$tag.'>';
					}
					if(!empty($xaminsubtitle_content))
					{
					$out .='<p '.$content_color.'>'.$xaminsubtitle_content.'</p>';
					}
		$out .='</div>
        </div>';
	    return $out;
	}


}
add_shortcode('xaminFancybox','xaminFancybox');
?>