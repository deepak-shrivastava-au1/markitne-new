<?php
// wp_query Blog
function consultarecentbblog($atts, $content = null) {

    extract(shortcode_atts(array(
        'number'         => '',
        'desk_number'    => '3',
        'lap_number'     => '3',
		'tab_number'     => '3',
		'mob_number'     => '2',
        'category'       => '',
        'sort'           => '',
        'order'          => 'DESC',
        'arrow'          => 'true',
        'loop'          => 'true',
        'auto'          => 'true',
        'dots'           => 'false',
        'paged'          => '',
        'css'           => '',
        'extra_class'   => '',
        'disble_effect' => '',
    ), $atts));

    $css_class = '';

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => $number,
        'paged'             => $paged,
        'category'          => $category,
        'orderby'           => $sort,
        'order'             => $order,
        'suppress_filters'  => 0
    );

    global $post;
    $wp_query = new WP_Query($args);
    $tot= $wp_query->found_posts ;

     if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}
    
    $xamin_option = get_option('xamin_options');
    ob_start();   

    $html = '';
    // Blog Slider One
    $html .= '
    <div class="xamin-recentblog v1 '.$extra_class.' '. esc_attr( $css_class ) .'">';

        if($desk_number <= "3" && $desk_number != "-1"){
			$html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
		}else{
			$html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="3" data-items-laptop="3" data-items-tab="2" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
        }


        $i=0;
        while ( $wp_query->have_posts() ) : $wp_query->the_post();
        $html .= '
                <div class="item">
                    <div class="consulting-blog">
                        <div class="consult-detail">';
                            if(has_post_thumbnail( $wp_query->ID ))
                            {
                            $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->ID ), "full" );
                            $html .='<img src="'.$full_image[0].'" class="img-fluid center-block" alt="blogimage'.$i.'">';

                                $postcat = get_the_category();
                                if ($postcat) {
                                    $html .='<ul class="list-inline blog-categories">';
                                    foreach($postcat as $cat) {
                                        $html .='<li class="list-inline-item"><a href="'. get_category_link( $cat->cat_ID ) .'">'. $cat->name .'</a></li>';
                                    }
                                    $html .='</ul>';
                                }
                            }
                            if($disble_effect == "0")
                            {

                            }
                            else{
                    $html .='<div class="consult-effect"></div>';
                            }
                $html .='</div>';
                $html .='<div class="main-blog clearfix">';
                            $html .='
                            <div class="blog-details">';

                                $html .='<ul class="list-inline mb-1">';
                                        //post date
                                        $archive_year  = get_the_time('Y',$post->ID);
                                        $archive_month = get_the_time('m',$post->ID);
                                        $archive_day   = get_the_time('d',$post->ID);
                                        $date=date_create($post->post_date);
                                        $html .='<li class="list-inline-item">
                                                <a href="'.esc_url(get_day_link( $archive_year, $archive_month, $archive_day)).'">
                                                    <i class="fa fa-calendar mr-2" aria-hidden="true"></i>
                                                    '.esc_html__(date_format($date,"d M Y"),'xamin').'
                                                </a>
                                                </li>';
                                        //author name
                                        $fname = get_the_author_meta( 'first_name', $post->post_author);
                                        $lname = get_the_author_meta( 'last_name', $post->post_author);
                                        $html .='<li class="list-inline-item"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID',$post->post_author ), get_the_author_meta( 'user_nicename',$post->post_author ) )).'">';
                                        if($fname || $lname){
                                            $html .='<i class="fa fa-user-circle mr-2" aria-hidden="true"></i> '.esc_html__($fname." ".$lname,'xamin');
                                        }else{
                                            $name = get_the_author_meta( 'user_login', $post->post_author);
                                            $html .='<i class="fa fa-user-circle mr-2" aria-hidden="true"></i> '.esc_html__($name,'xamin');
                                        }
                                        $html .='</a></li>';
                                $html .='</ul>';

                            $html .='
                                <a href="'.esc_url(get_permalink($wp_query->ID)).'">
                                <h5>'.sprintf( esc_html__('%s','xamin'),$wp_query->post->post_title).'</h5>
                                </a>';
							if(has_excerpt()):
                        $html .='<p>'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;
                    $html .='</div>';

                    $html .='<div class="blog-button">';
                                if(!empty($xamin_option['blog_btn']))
                                {
                                $html .='<a href="'.esc_url(get_permalink($wp_query->ID)).'"><i aria-hidden="true" class="ion ion-plus"></i></a>';
                                }
                                else
                                {
                                $html .='<a href="'.esc_url(get_permalink($wp_query->ID)).'"><i aria-hidden="true" class="ion ion-plus"></i></a>';
                                }
                    $html .='</div>
                        </div>
                    </div>
                </div>';
                $i++;
            endwhile;
            wp_reset_postdata();
            $html .= '
        </div>
    </div>';
    
    $html .= ob_get_clean();
    return $html;
}
add_shortcode('consultarecentbblog','consultarecentbblog');
?>