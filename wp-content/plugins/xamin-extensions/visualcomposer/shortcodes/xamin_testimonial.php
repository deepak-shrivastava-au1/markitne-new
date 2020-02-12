<?php
// Recent Blog
function xaminblogtestimonial($atts, $content = null) {

    extract(shortcode_atts(array(
		'number'     		=> -1,
		'desk_number'     	=> '1',
		'lap_number'     	=> '1',
		'tab_number'     	=> '1',
		'mob_number'     	=> '1',
        'sort'       		=> '',
		'order'      		=> 'DESC',
		'arrow'      		=> 'true',
		'dots'      		=> 'false',
		'auto'				=> 'true',
		'loop'				=> 'true',
        'style_type'        => '1',
        'text_pos'          => 'left',
        'extra_class'       => '',
        'css' => '',
    ), $atts));

    $css_class = '';

	$args = array(
        'post_type'         => 'testimonial',
        'post_status'       => 'publish',
        'numberposts'       => $number,
        'orderby'           => $sort,
        'order'             => $order,
        'suppress_filters'  => 0
	);

	$wp_query = new WP_Query($args);
	$tot= $wp_query->found_posts ;
    if($tot<=$desk_number){ $desk_number = $tot; $less_post = "less_post"; $loop = "false";}
    if($tot<=$lap_number){ $lap_number = $tot; $less_post = "less_post"; $loop = "false"; }
    if($tot<=$tab_number){ $tab_number = $tot; $less_post = "less_post"; $loop = "false"; }
	if($tot<=$mob_number){ $mob_number = $tot; $less_post = "less_post"; $loop = "false"; }

    $recent_posts = get_posts( $args);
    
    if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}


    if($style_type == '1') {

    $html = '';

            if($desk_number <= 3 && $desk_number != "-1"){
                $html .= '<div class="owl-carousel testimonial-style" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-margin="30">';
            }else{
                $html .= '<div class="owl-carousel testimonial-style" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-margin="30">';
            }
                                foreach( $recent_posts as $recent ){
                                    $html .='
                                    <div class="item text-'.$text_pos.' '.$extra_class.' '. esc_attr( $css_class ) .'">
                                        <div class="iq-testimonial">';
                                                    $html .='
                                            <div class="testimonial-info">';
                                                if(has_post_thumbnail( $recent->ID ))
                                                {
                                                $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $recent->ID ), "full" );
                                                $html .='<img alt="#" class="img-fluid rounded-circle" src="'.$full_image[0].'">';
                                                }
                                                $html .='
                                                <div class="testimonial-name">
                                                    <h5>'.sprintf( esc_html__('%s','xamin'),$recent->post_title).'</h5>';
                                                    $designation  = get_post_meta( $recent->ID, 'xamin_testimonial_designation', true);
                                                    $html .='<span class="sub-title">';
                                                                if($designation) { $html .= $designation; }
                                                    $html .='</span>
                                                </div>
                                            </div>
                                            <p>'.sprintf( esc_html__('%s','xamin'),$recent->post_content).'</p>
                                        </div>
                                    </div>';
                                }
                                $html .= '
                </div>';
        return $html;
    }
    if($style_type == '2') {

        $html = '';
    
                if($desk_number <= 3 && $desk_number != "-1"){
                    $html .= '<div class="owl-carousel our-testimonial" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-margin="30">';
                }else{
                    $html .= '<div class="owl-carousel our-testimonial" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-margin="30">';
                }
                                    foreach( $recent_posts as $recent ){
                                        $html .='
                                        <div class="item text-'.$text_pos.' '.$extra_class.' '. esc_attr( $css_class ) .'">
                                            <div class="iq-testimonial">';
                                                $html .='
                                                <p>'.sprintf( esc_html__('%s','xamin'),$recent->post_content).'</p>
                                                <div class="testimonial-info">';
                                                    if(has_post_thumbnail( $recent->ID ))
                                                    {
                                                    $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $recent->ID ), "full" );
                                                    $html .='<img alt="#" class="img-fluid rounded-circle" src="'.$full_image[0].'">';
                                                    }
                                                    $html .='
                                                    <div class="testimonial-name">
                                                        <h5>'.sprintf( esc_html__('%s','xamin'),$recent->post_title).'</h5>';
                                                        $designation  = get_post_meta( $recent->ID, 'xamin_testimonial_designation', true);
                                                        $html .='<span class="sub-title">';
                                                                    if($designation) { $html .= $designation; }
                                                        $html .='</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                        $html .= '
                </div>';
            return $html;
        }

        if($style_type == '3') {

    $html = '';

            if($desk_number <= 3 && $desk_number != "-1"){
                $html .= '<div class="owl-carousel testimonial-style" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-margin="30">';
            }else{
                $html .= '<div class="owl-carousel testimonial-style" data-dots="'.$dots.'" data-nav="'.$arrow.'"   data-autoplay="'.$auto.'"  data-loop="'.$loop.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-margin="30">';
            }
                                foreach( $recent_posts as $recent ){
                                    $html .='
                                    <div class="item text-'.$text_pos.' '.$extra_class.' '. esc_attr( $css_class ) .'">
                                        <div class="iq-testimonial-userbehavior">';
                                                    $html .='
                                            <div class="testimonial-info">';
                                                if(has_post_thumbnail( $recent->ID ))
                                                {
                                                $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $recent->ID ), "full" );
                                                $html .='<img alt="#" class="img-fluid rounded-circle" src="'.$full_image[0].'">';
                                                }
                                                $html .='
                                                <div class="testimonial-name">
                                                    <h5>'.sprintf( esc_html__('%s','xamin'),$recent->post_title).'</h5>';
                                                    $designation  = get_post_meta( $recent->ID, 'xamin_testimonial_designation', true);
                                                    $html .='<span class="sub-title">';
                                                                if($designation) { $html .= $designation; }
                                                    $html .='</span>
                                                </div>
                                            </div>
                                            <p>'.sprintf( esc_html__('%s','xamin'),$recent->post_content).'</p>
                                        </div>
                                    </div>';
                                }
                                $html .= '
                </div>';
        return $html;
    }

}
add_shortcode('xaminblogtestimonial','xaminblogtestimonial');
?>