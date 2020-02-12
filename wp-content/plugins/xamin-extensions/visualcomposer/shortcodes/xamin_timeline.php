<?php
// Timeline
function xamintimeline( $atts, $content = null ) {

	$data = wp_parse_args( $atts, array(
		'xamin_timeline'            => '',
		'xamintitle_content'  		=> 'Easy to Customize',
		'tag'						=> 'h2',
		'title_color'				=> '',
		'xamin_subtitle' 	        => 'Long established',
		'sub_tag'                   => 'span',
		'subtitle_color'			=> '',
        'xamin_box_position'        => 'right',
        'xamin_date'                => '',
        'xamin_address'             => '',
        'xamin_boxlist'             => '',
        'xamin_listtest'            => 'Easy to Customize List',
        'css' 						=> '',
	) );

    $xamintitle_content = $data['xamintitle_content'] ?  $data["xamintitle_content"]  : '';
    $tag = $data['tag'] ?  $data["tag"]  : '';
    $title_color = $data['title_color'] ?  $data["title_color"]  : '';

    $xamin_subtitle = $data['xamin_subtitle'] ?  $data["xamin_subtitle"]  : '';
    $sub_tag = $data['sub_tag'] ?  $data["sub_tag"]  : '';
    $subtitle_color = $data['subtitle_color'] ?  $data["subtitle_color"]  : '';

    $xamin_box_position = $data['xamin_box_position'] ?  $data["xamin_box_position"]  : '';
    
    $xamin_date = $data['xamin_date'] ?  $data["xamin_date"]  : '';

    $xamin_address = $data['xamin_address'] ?  $data["xamin_address"]  : '';

	$xamin_timeline = $data['xamin_timeline'] ?  $data["xamin_timeline"]  : '';
	$xamin_timeline = vc_param_group_parse_atts( $xamin_timeline );

	$xamin_boxlist = $data['xamin_boxlist'] ?  $data["xamin_boxlist"]  : '';
	$xamin_listtest = $data['xamin_listtest'] ?  $data["xamin_listtest"]  : '';

	$css_class = $data['css'] ?  $data["css"]  : '';
	if(!empty($css_class)){
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
	}

	$out = '';	

	$out .= '
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<section class="main-timeline-section '. esc_attr( $css_class ) .'">
			    <div class="conference-center-line"></div>
			    <div class="conference-timeline-content">';

			        foreach ( $xamin_timeline as $data ) {

			        	$out .= '
					    <div class="timeline-article content-'.$data['xamin_box_position'].'-container">
				        	<div class="meta-date"></div>
					        <div class="content-box">

					            <div class="iqtml-top-box">
					        	    <div class="data1">';
					        	        $out .='
					        	        <'.$data['tag'].' style="color: ' . $data['title_color']. ';" class="title">'.$data['xamintitle_content'].'</'.$data['tag'].'>';
					        	       $out .='
					        	        <'.$data['sub_tag'].' style="color: ' . $data['subtitle_color']. ';">'.$data['xamin_subtitle'].'</'.$data['sub_tag'].'>
					        	    </div>
		                            <div class="data2">';
		                                if(!empty($data['xamin_date'])){
			                                $out .='
			                                <span><i class="fa fa-calendar"></i>'.$data['xamin_date'].'</span>';
			                            }
			                            if(!empty($data['xamin_address'])){    
			                                $out .='
						        	        <span><i class="fa fa-map-marker"></i>'.$data['xamin_address'].'</span>';
						        	    }
						        	$out .='        
		                            </div>
					        	</div>';

	                            $xamin_boxlist = vc_param_group_parse_atts( $data['xamin_boxlist'] );

                                foreach ( $xamin_boxlist as $listdata ) {
                                	$out .= '
		                            <ul class="iq-contant">
		                                <li>'.$listdata['xamin_listtest'].'</li>
		                            </ul>';
	                            }

                            $out .= '
					        </div>

					    </div>';

                    }
				$out .= '    
				</div>
		  	</section>
		</div>
	</div>';	
	return $out;
	
}
add_shortcode('xamintimeline', 'xamintimeline');
?>