<?php
// wp_query Blog
function xaminblog($atts, $content = null) {    

    extract(shortcode_atts(array(
        'type'           => '1',
        'number'         => '',
        'desk_number'    => '3',
        'lap_number'     => '3',
		'tab_number'     => '3',
		'mob_number'     => '2',
        'category'       => '',
        'sort'           => '',
        'order'          => 'DESC',
        'arrow'          => 'true',
        'dots'           => 'false',
        'auto'			=> 'true',
		'loop'			=> 'true',
        'paged'          => '',
        'extra_class'   => '',
        'css'   => '',
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

    if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

    global $post;
    $wp_query = new WP_Query($args);
    $tot= $wp_query->found_posts ;
    
    $xamin_option = get_option('xamin_options');
    ob_start();   
    $html = '';

    if($type != '1'){
        $total_pages = $wp_query->max_num_pages;
            if ($total_pages > 1){
                $current_page = max(1, get_query_var('paged'));
                echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'type'            => 'list',
                'prev_text'       => wp_kses('<span aria-hidden="true">'. __( 'Previous page', 'xamin' ) .'</span>','xamin'),
                'next_text'       => wp_kses('<span aria-hidden="true">'. __( 'Next page', 'xamin' ) .'</span>','xamin'),
                ));
            }
        }
   
    // Blog Slider
    if($type == '1'){
        $html .= '
        <div class="xamin-recentblog v1 '.$extra_class.' '. esc_attr( $css_class ) .'">';
           
        if($desk_number <= "3" && $desk_number != "-1"){
			$html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'">';
		}else{
			$html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="3" data-items-laptop="3" data-items-tab="2" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'">';
        }
        
    
            $i=0;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $html .= '      
                <div class="item">
                    <div class="iq-blog-box">';
                        if(has_post_thumbnail( $wp_query->ID ))
						{
                        $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->ID ), "full" );                     
                        $html .='<div class="iq-blog-image clearfix">
                                    <img src="'.$full_image[0].'" class="img-fluid center-block" alt="blogimage'.$i.'">';
                                        
                                        $postcat = get_the_category();
                                        if ($postcat) {
                                            $html .='<ul class="iq-blogtag">';
                                        foreach($postcat as $cat) {
                                            $html .='<li><a href="'. get_category_link( $cat->cat_ID ) .'">'. $cat->name .'</a></li>';
                                        }
                                        $html .='</ul>'; 
                                        }
                                        
                            $html .='</div>';
                        }
                                                   
                $html .='<div class="iq-blog-detail">';
                            $html .='
                            <div class="iq-blog-meta">';                                   
                                //post date
                                $archive_year  = get_the_time('Y',$wp_query->ID);
                                $archive_month = get_the_time('m',$wp_query->ID); 
                                $archive_day   = get_the_time('d',$wp_query->ID);
                                $date=date_create($wp_query->post_date);
                                $html .='<ul><li class="list-inline-item">
                                        '.xamin_time_link().'
                                    </li></ul>';
                                        
                            $html .='
                            </div>
                            <div class="blog-title">
                                <a href="'.esc_url(get_permalink($wp_query->ID)).'">
                                <h4>'.sprintf( esc_html__('%s','xamin'),$wp_query->post->post_title).'</h4>
                                </a>
                            </div>';
							if(has_excerpt()):
                            $html .='<p>'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

							$html .='<div class="blog-button">';                
                                        if(!empty($xamin_option['blog_btn']))
                                        {  
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr($xamin_option['blog_btn']) .'<i class="fa fa-angle-right"             aria-hidden="true"></i></a>';
                                        }
                                        else
                                        { 
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr('Read More', 'xamin') .'<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
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
    }

    // Blog with Two Column
    if($type == '2'){
        $html .= '
        <div class="xamin-recentblog v2 '.$extra_class.' '. esc_attr( $css_class ) .'">
        <div class="row">';
            $i=0;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $html .= '
                <div class="col-lg-6 col-md-6 col-sm-6 xamin-space-bottom">   
                <div class="iq-blog-box">';
                        if(has_post_thumbnail( $wp_query->ID ))
						{
                        $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->ID ), "full" );                     
                        $html .='<div class="iq-blog-image clearfix">
                                    <img src="'.$full_image[0].'" class="img-fluid center-block" alt="blogimage'.$i.'">';
                                    $postcat = get_the_category();
                                        if ($postcat) {
                                            $html .='<ul class="iq-blogtag">';
                                        foreach($postcat as $cat) {
                                            $html .='<li><a href="'. get_category_link( $cat->cat_ID ) .'">'. $cat->name .'</a></li>';
                                        }
                                        $html .='</ul>'; 
                                        }
                            $html .='</div>';
                        }
                                                   
                $html .='<div class="iq-blog-detail">';
                            $html .='
                            <div class="iq-blog-meta">';                                   
                                //post date
                                $archive_year  = get_the_time('Y',$wp_query->ID);
                                $archive_month = get_the_time('m',$wp_query->ID); 
                                $archive_day   = get_the_time('d',$wp_query->ID);
                                $date=date_create($wp_query->post_date);
                                $html .='<ul><li class="list-inline-item">
                                        '.xamin_time_link().'
                                    </li></ul>';
                                        
                            $html .='
                            </div>
                            <div class="blog-title">
                                <a href="'.esc_url(get_permalink($wp_query->ID)).'">
                                <h4>'.sprintf( esc_html__('%s','xamin'),$wp_query->post->post_title).'</h4>
                                </a>
                            </div>';
							if(has_excerpt()):
                            $html .='<p>'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

							$html .='<div class="blog-button">';                
                                        if(!empty($xamin_option['blog_btn']))
                                        {  
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr($xamin_option['blog_btn']) .'<i class="fa fa-angle-right"             aria-hidden="true"></i></a>';
                                        }
                                        else
                                        { 
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr('Read More', 'xamin') .'<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                                        }
                           $html .='</div>
                            </div>
                        </div>
                </div>';
                $i++;
            endwhile;
            wp_reset_postdata();
            $html .= '
        </div></div>';
    }

    // Blog with Three Column
    if($type == '3'){
        $html .= '
        <div class="xamin-recentblog v3 '.$extra_class.' '. esc_attr( $css_class ) .'">
        <div class="row">';
            $i=0;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $html .= '
                <div class="col-lg-4 col-md-6 xamin-space-bottom">   
                <div class="iq-blog-box">';
                        if(has_post_thumbnail( $wp_query->ID ))
						{
                        $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->ID ), "full" );                     
                        $html .='<div class="iq-blog-image clearfix">
                                    <img src="'.$full_image[0].'" class="img-fluid center-block" alt="blogimage'.$i.'">';
                                    $postcat = get_the_category();
                                        if ($postcat) {
                                            $html .='<ul class="iq-blogtag">';
                                        foreach($postcat as $cat) {
                                            $html .='<li><a href="'. get_category_link( $cat->cat_ID ) .'">'. $cat->name .'</a></li>';
                                        }
                                        $html .='</ul>'; 
                                        }
                            $html .='</div>';
                        }
                                                   
                $html .='<div class="iq-blog-detail">';
                            $html .='
                            <div class="iq-blog-meta">';                                   
                                //post date
                                $archive_year  = get_the_time('Y',$wp_query->ID);
                                $archive_month = get_the_time('m',$wp_query->ID); 
                                $archive_day   = get_the_time('d',$wp_query->ID);
                                $date=date_create($wp_query->post_date);
                                $html .='<ul><li class="list-inline-item">
                                        '.xamin_time_link().'
                                    </li></ul>';
                                        
                            $html .='
                            </div>
                            <div class="blog-title">
                                <a href="'.esc_url(get_permalink($wp_query->ID)).'">
                                <h4>'.sprintf( esc_html__('%s','xamin'),$wp_query->post->post_title).'</h4>
                                </a>
                            </div>';
							if(has_excerpt()):
                            $html .='<p>'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

							$html .='<div class="blog-button">';                
                                        if(!empty($xamin_option['blog_btn']))
                                        {  
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr($xamin_option['blog_btn']) .'<i class="fa fa-angle-right"             aria-hidden="true"></i></a>';
                                        }
                                        else
                                        { 
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr('Read More', 'xamin') .'<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                                        }
                           $html .='</div>
                            </div>
                        </div>
                </div>';
                $i++;
            endwhile;
            wp_reset_postdata();
            $html .= '
        </div></div>';
    }

    // Blog with One Column
    if($type == '4'){
        $html .= '
        <div class="xamin-recentblog v4 '.$extra_class.' '. esc_attr( $css_class ) .'">
        <div class="row">';
            $i=0;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $html .= '
                <div class="col-md-12 col-sm-12 xamin-space-bottom">  
                <div class="iq-blog-box">';
                        if(has_post_thumbnail( $wp_query->ID ))
						{
                        $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->ID ), "full" );                     
                        $html .='<div class="iq-blog-image clearfix">
                                    <img src="'.$full_image[0].'" class="img-fluid center-block" alt="blogimage'.$i.'">';
                                    $postcat = get_the_category();
                                        if ($postcat) {
                                            $html .='<ul class="iq-blogtag">';
                                        foreach($postcat as $cat) {
                                            $html .='<li><a href="'. get_category_link( $cat->cat_ID ) .'">'. $cat->name .'</a></li>';
                                        }
                                        $html .='</ul>'; 
                                        }
                            $html .='</div>';
                        }
                                                   
                $html .='<div class="iq-blog-detail">';
                            $html .='
                            <div class="iq-blog-meta">';                                   
                                //post date
                                $archive_year  = get_the_time('Y',$wp_query->ID);
                                $archive_month = get_the_time('m',$wp_query->ID); 
                                $archive_day   = get_the_time('d',$wp_query->ID);
                                $date=date_create($wp_query->post_date);
                                $html .='<ul><li class="list-inline-item">
                                        '.xamin_time_link().'
                                    </li></ul>';
                                        
                            $html .='
                            </div>
                            <div class="blog-title">
                                <a href="'.esc_url(get_permalink($wp_query->ID)).'">
                                <h4>'.sprintf( esc_html__('%s','xamin'),$wp_query->post->post_title).'</h4>
                                </a>
                            </div>';
							if(has_excerpt()):
                            $html .='<p>'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

							$html .='<div class="blog-button">';                
                                        if(!empty($xamin_option['blog_btn']))
                                        {  
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr($xamin_option['blog_btn']) .'<i class="fa fa-angle-right"             aria-hidden="true"></i></a>';
                                        }
                                        else
                                        { 
                                        $html .='<a class="button-link" href="'.esc_url(get_permalink($wp_query->ID)).'">'. esc_attr('Read More', 'xamin') .'<i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                                        }
                           $html .='</div>
                            </div>
                        </div>
                </div>';
                $i++;
            endwhile;
            wp_reset_postdata();
            $html .= '
        </div></div>';
    }
    $html .= ob_get_clean();
    return $html;
}
add_shortcode('xaminblog','xaminblog');
?>