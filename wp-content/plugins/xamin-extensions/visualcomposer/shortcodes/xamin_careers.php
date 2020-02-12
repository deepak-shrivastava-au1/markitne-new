<?php
function xamincareer( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style_type'        => '1',
		'number'     		=> -1,
		'category'          => 'All',
		'extra_class'     	=> '',
		'css'     	        => '',
		'sort'       		=> '',
		'order'      		=> 'DESC',
	), $atts ) );

	$css_class = '';

	$args = array(
        'post_type'         => 'xamincareer',
        'post_status'       => 'publish',
        'numberposts'       => $number,
        'orderby'           => $sort,
        'order'             => $order,
        'suppress_filters'  => 0
	);

	$wp_query = new WP_Query($args);

	$recent_posts = get_posts( $args);

	if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

	$i = '';

	$out = '';

	if($style_type == 1) {

		$out .='
		<div class="iq-accordion career-style '. $extra_class .' '. esc_attr( $css_class ) .'">';
			foreach( $recent_posts as $recent ){
			    if($i == 1){ $show = "show"; $style="style=display:block"; $adactive="accordion-active"; $i++;}else{ $style=""; $show = ""; $adactive="";}

			    $out.= '
			    <div class="iq-accordion-block '.$adactive.'">';
				    $out.= '
				    <div class="active-faq clearfix">';
					    $out.= '
					    <div class="container">';
					        $out.= '
					        <div class="row align-items-center">';
						        $out.= '
						        <div class="col-md-9 col-sm-12 ">';
							        $out.= '<a href="javascript:void(0)" class="accordion-title"><span>'.sprintf( esc_html__('%s','xamin'),$recent->post_title).'</span></a>';
						        $out.= '
						        </div>';
							    $out.= '
							    <div class="col-md-3 col-sm-12 text-center text-lg-right text-md-right">';
									$btn_name  = get_post_meta( $recent->ID, 'career_button_name', true);
									$btn_link  = get_post_meta( $recent->ID, 'career_button_link', true);
									if(!empty($btn_name)){
									    $out.= '
									    <a class="button" href="'; if($btn_link) { $out .= $btn_link; } $out.='">';
										    if($btn_name) { $out .= $btn_name; }
									    $out.= '
									    </a>';
									}
							    $out.= '
							    </div>';
						    $out.= '
						    </div>';
						$out.= '
						</div>';
					$out.= '
					</div>';

					$out.= '
					<div class="accordion-details ">
						<p>'.sprintf( esc_html__('%s','xamin'),$recent->post_content).'</p>
					</div>
		        </div>';
			}
		$out.= '
		</div>';

		return $out;
	}

	if($style_type == 2) {

		if($category == 'All') {

			$args_cat	 = array(
		        'post_type'         => 'xamincareer',
		        'post_status'       => 'publish',
		        'numberposts'       => $number,
		        'orderby'           => $sort,
		        'order'             => $order,
		        'suppress_filters'  => 0
			);

	    } else {

	    	$args_cat = array(
		        'post_type'         => 'xamincareer',
		        'post_status'       => 'publish',
		        'tax_query' => array(
			        array(
			            'taxonomy' => 'xamincareer-categories',
			            'field' => 'slug',
			            'terms' => $category
			        )
			    ),
		        'numberposts'       => $number,
		        'orderby'           => $sort,
		        'order'             => $order,
		        'suppress_filters'  => 0
			);

	    }

	    $selected_post = get_posts( $args_cat );

		$out .='
		<div class="iq-accordion career-post-tab '. $extra_class .' '. esc_attr( $css_class ) .'">';
			foreach( $selected_post as $recent ){
			    if($i == 1){ $show = "show"; $style="style=display:block"; $adactive="accordion-active"; $i++;}else{ $style=""; $show = ""; $adactive="";}

			    $out.= '
			    <div class="iq-accordion-block '.$adactive.'">';
				    $out.= '
				    <div class="active-faq clearfix">';
					    $out.= '
					    <div class="container">';
					        $out.= '
					        <div class="row align-items-center">';
						        $out.= '
						        <div class="col-md-12 col-sm-12 ">';
							        $out.= '<a href="javascript:void(0)" class="accordion-title"><span>'.sprintf( esc_html__('%s','xamin'),$recent->post_title).'</span></a>';
						        $out.= '
						        </div>';
						    $out.= '
						    </div>';
						$out.= '
						</div>';
					$out.= '
					</div>';

					$out.= '
					<div class="accordion-details ">
						<p>'.sprintf( esc_html__('%s','xamin'),$recent->post_content).'</p>
					</div>
		        </div>';
			}
		$out.= '
		</div>';

		return $out;
	}

}
add_shortcode('xamincareer', 'xamincareer');
?>