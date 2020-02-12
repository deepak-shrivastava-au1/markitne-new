<?php
// Slider Box
function xaminBoxslider( $atts, $content = null ) {

	 $data = wp_parse_args( $atts, array(
			'xamintitle_content'  		=> 'Easy to Customize',
			'tag'						=> 'h2',
			'title_color'				=> '',
			'content_color'				=> '',
			'xamin_subtitle' 	        => 'It is a long established fact that a reader will be distracted.',
			'xamin_box_date'            => '2006-2010',
			'xamin_box_resulttitle'        => 'GPA',
			'xamin_box_result'             => '1.0/1.0',
			'image'       				=> '',
			'position' 					=> 'left',
			'delay_time'				=> '',
			'css' 						=> '',
			'number'     		=> -1,
			'desk_number'     	=> '1',
			'lap_number'     	=> '1',
			'tab_number'     	=> '1',
			'mob_number'     	=> '1',
			'arrow'      		=> 'true',
			'dots'      		=> 'false',
			'auto'				=> 'true',
			'loop'				=> 'true',
			'box_data'          => '',
            'type'              => '',  
            'icontype'          => '',
            'fontawesome'       => '',               


		) );

		$css_class = '';

		wp_enqueue_style( 'font-awesome' );

		$icontype = $data['icontype'] ? $data["icontype"]  : '';
		$fontawesome = $data['fontawesome'] ? $data["fontawesome"]  : '';


		$xamintitle_content = $data['xamintitle_content'] ? $data["xamintitle_content"]  : '';

		$tag = $data['tag'] ? $data["tag"] : '';

		$title_color = $data['title_color'] ?  $data["title_color"]  : '';
		$title_color = $title_color ? ' style="color: ' . $title_color . ';"' : '';

        $xamin_subtitle = $data['xamin_subtitle'] ?  $data["xamin_subtitle"]  : '';

        $xamin_box_date = $data['xamin_box_date'] ?  $data["xamin_box_date"]  : '';

        $xamin_box_resulttitle = $data['xamin_box_resulttitle'] ?  $data["xamin_box_resulttitle"]  : '';

        $xamin_box_result = $data['xamin_box_result'] ?  $data["xamin_box_result"]  : '';
		
		$number = $data['number'] ? $data["number"] : '';
		$desk_number = $data['desk_number'] ? $data["desk_number"] : '';
		$lap_number = $data['lap_number'] ? $data["lap_number"] : '';
		$tab_number = $data['tab_number'] ? $data["tab_number"] : '';
		$mob_number = $data['mob_number'] ? $data["mob_number"] : '';
		$arrow = $data['arrow'] ? $data["arrow"] : '';
		$auto = $data['auto'] ? $data["auto"] : '';
		$loop = $data['loop'] ? $data["loop"] : '';
		$dots = $data['dots'] ? $data["dots"] : '';
		$dots = $data['dots'] ? $data["dots"] : '';

		$box_url = $data['image'] ? $data["image"] : '';

		$box_data = $data['box_data'] ?  $data["box_data"]  : '';
		$box_data = vc_param_group_parse_atts( $box_data );

	
		$delay_time = $data['delay_time'] ?  $data["delay_time"]  : '';
		if(!empty($delay_time))
		{
			$delay_time = 'data-wow-delay="'.$delay_time.'s"';
		}

		$position = $data['position'] ? $data["position"] : '';

		$css = $data['css'] ?  $data["css"]  : '';

		if(!empty($css)){
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
	    }


    $out ='';

	 $out .= '
	 <div class="data-science">
	 <div class="owl-carousel testimonial-style '.$delay_time.'" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-margin="30">';
         
	        foreach ( $box_data as $data ) {

				$out .='
		        <div class="iq-boxslider-detail">';

		            $out .='
		            <div class="boxslider-content">
			            <div class="box-detail">';
			                
								if(!empty($data['image'])) {
								    $out .='<img class="arrow-img" src="'.wp_get_attachment_image_url( $data['image'], "full") .'" alt="fancybox" />';
								}

							    $out .= '<'.$data['tag'].' class="title">'.$data['xamintitle_content'].'</'.$tag.'>';
							    $out .= '<p>'.$data['xamin_subtitle'].'</p>';
							    if(!empty($data['xamin_box_date'])) {
							        $out .= '
							        <span class="fa fa-calendar"></span><a href="#">'.$data['xamin_box_date'].'</a>';
							    }
                        $out .='
                        </div>
                    </div>

			        <div class="box-gpa">';

		                if(!empty($data['xamin_box_resulttitle'])) {
				            $out .='<h6>'.$data['xamin_box_resulttitle'].'</h6>';
				        } else {
				        	$out .='<h6>GPA</h6>';
				        }

				        if(!empty($data['xamin_box_result'])) {
				            $out .='<span>'.$data['xamin_box_result'].'</span>';
				        }    
					        
			        $out .='
			        </div>

                </div>';
				
		    }
	$out .='	    
	</div>
	</div>';

    return $out;

}
add_shortcode('xaminBoxslider','xaminBoxslider');
?>