<?php
// Our Team
function xaminportfolioslider($atts, $content = null) { 

    extract(shortcode_atts(array(
        'number'            => -1,
        'style_type'        => '1',
        'columns_type'      => '2',
        'sortby'            => 'date',
        'order'             => 'DESC',
        'desk_number'       => '1',
        'lap_number'        => '1',
        'tab_number'        => '1',
        'mob_number'        => '1',
        'sort'              => '',
        'arrow'             => 'true',
        'dots'              => 'false',
        'auto'              => 'true',
        'loops'              => 'true',
        'extra_class'       => '',
        'css'               => '',
        'disble_tab'        => '',
        'tag'               => 'h2',
        'position'	        => 'left',
        'delay_time'        => '',
    ), $atts));

    $css_class = '';

    $args = array(
        'post_type'         => 'portfolio',
        'post_status'       => 'publish',
        'posts_per_page'    => $number,
        'orderby'           => $sortby,
        'order'             => $order,
        'suppress_filters'  => 0
    );

   /* if(!empty($desk_number)){ $number = $desk_number; }else{ $desk_number = "-1"; } */

    $wp_query = new WP_Query($args);
    $tot= $wp_query->found_posts ;
    if($tot<=$desk_number){ $desk_number = $tot; $less_post = "less_post"; $loop = "false";}
    if($tot<=$lap_number){ $lap_number = $tot; $less_post = "less_post"; $loop = "false"; }
    if($tot<=$tab_number){ $tab_number = $tot; $less_post = "less_post"; $loop = "false"; }
    if($tot<=$mob_number){ $mob_number = $tot; $less_post = "less_post"; $loop = "false"; }

    $wp_query = new WP_Query($args);

    if(!empty($css)){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
        }

    $i=0;

    if(!empty($delay_time))
	{
		$delay_time = 'data-wow-delay="'.$delay_time.'s"';
	}

    $html ='';

    if($style_type == 1){

    $html .='<div id="features" class="iq-amazing-tab wow fadeInUp '.$extra_class.' '. esc_attr( $css_class ) .' " '.$delay_time.'>';
                if($disble_tab == "0")
                {

                }
                else{
        $html .='<div class="row">
                        <div class="col-lg-12">
                            <ul class="nav  justify-content-center" id="myTab" role="tablist">';
                            $terms = get_terms( array('taxonomy' => 'portfolio-categories',) );

                           $html .='<li><a class="nav-link active show " id="all-tab" data-toggle="tab" href="#all" role="tab" aria-selected="true">All<span class="post_no">'. $wp_query->post_count .'</span></a></li>';

                            foreach($terms as $term) {

                                $html .='<li><a class="nav-link " id="'.$term->slug.'-tab" data-toggle="tab" href=#'.$term->slug .' role="tab">'. $term->name .'<span class="post_no">'. $term->count .'</span></a></li>';

                            }
                            $html .='
                            </ul>
                        </div>
                    </div>';
                }
        $html .='<div class="tab-content ">';

                    $html .='<div class="tab-pane active show" id="all">
                            <div class="row flex-row-reverse">';
                $html .='    <div class="col-lg-12 text-left align-self-center">';

                $html .=' <div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="'.$mob_number.'" data-autoplay="'.$auto.'" data-loop="'.$loops.'" data-margin="30">';

                $args = array( 'post_type' => 'portfolio', 'posts_per_page' => '-1', 'orderby' => $sortby,  'order' => $order );



                            $loop = new WP_Query( $args );

                            while ( $loop->have_posts() ) : $loop->the_post();

                                $term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
                                $slugs=array();
                                foreach($term_list as $term)
                                    $slugs[]=$term->slug;

                                    $html .='
                                    <div class="iq-masonry-item '. implode(' ',$slugs) .'">
                                        <div class="iq-portfolio">
                                            <a href="'. get_permalink() .'" class="iq-portfolio-img">'. get_the_post_thumbnail() .'</a>
                                            <div class="iq-portfolio-content text-'.$position.'">
                                                <div class="details-box clearfix">
                                                    <div class="consult-details">';
                                                $html .='<a href="'. get_permalink() .'">
                                                        <'.$tag.' class="text-hover">'. get_the_title() .'</'.$tag.'>
                                                        </a>
                                                        <p class="mb-0">'.$term->name.'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            endwhile;
                            wp_reset_postdata();


                                $html .='</div></div></div></div>';
                                 $terms = get_terms( array('taxonomy' => 'portfolio-categories',) );

                            foreach($terms as $term) {

                                    $html .='<div class="tab-pane" id="'.$term->slug.'">
                                            <div class="row flex-row-reverse">';
                                $html .='    <div class="col-lg-12 text-left align-self-center">';

                                $html .='<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="'.$mob_number.'" data-autoplay="'.$auto.'" data-loop="'.$loops.'" data-margin="30">';


             $args = array( 'post_type' => 'portfolio', 'posts_per_page' => '-1', 'orderby' => $sortby,  'order' => $order,'tax_query' => array(
                                    array(
                                        'taxonomy' => 'portfolio-categories',
                                        'field'    => 'slug',
                                        'terms'    => $term->slug,
                                    ),
                                ), );



                            $loop = new WP_Query( $args );

                            while ( $loop->have_posts() ) : $loop->the_post();

                                $term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
                                $slugs=array();
                                foreach($term_list as $term)
                                    $slugs[]=$term->slug;

                                    $html .='
                                    <div class="iq-masonry-item '. implode(' ',$slugs) .'">
                                        <div class="iq-portfolio">
                                            <a href="'. get_permalink() .'" class="iq-portfolio-img">'. get_the_post_thumbnail() .'</a>
                                            <div class="iq-portfolio-content text-'.$position.'">
                                                <div class="details-box clearfix">
                                                    <div class="consult-details">';
                                                $html .='<a href="'. get_permalink() .'">
                                                        <'.$tag.' class="text-hover">'. get_the_title() .'</'.$tag.'>
                                                        </a>
                                                        <p class="mb-0">'.$term->name.'</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            endwhile;
                            wp_reset_postdata();
                $html .='</div>
                    </div>
                </div>
            </div>';
        $i++;
    }
    $html .='</div>
    </div>';
}
if($style_type == 2){

    $html .='<div id="features" class="iq-amazing-tab portfolioslider2 wow fadeInUp '.$extra_class.' '. esc_attr( $css_class ) .' " '.$delay_time.'>';
                if($disble_tab == "0")
                {

                }
                else{
        $html .='<div class="row">
                        <div class="col-lg-12">
                            <ul class="nav  justify-content-center" id="myTab" role="tablist">';
                            $terms = get_terms( array('taxonomy' => 'portfolio-categories',) );

                           $html .='<li><a class="nav-link active show " id="all-tab" data-toggle="tab" href="#all" role="tab" aria-selected="true">All<span class="post_no">'. $wp_query->post_count .'</span></a></li>';

                            foreach($terms as $term) {

                                $html .='<li><a class="nav-link " id="'.$term->slug.'-tab" data-toggle="tab" href=#'.$term->slug .' role="tab">'. $term->name .'<span class="post_no">'. $term->count .'</span></a></li>';

                            }
                            $html .='
                            </ul>
                        </div>
                    </div>';
                }
        $html .='<div class="tab-content ">';

                    $html .='<div class="tab-pane active show" id="all">
                            <div class="row flex-row-reverse">';
                $html .='    <div class="col-lg-12 text-left align-self-center">';

                $html .=' <div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="'.$mob_number.'" data-autoplay="'.$auto.'" data-loop="'.$loops.'" data-margin="30">';

                $args = array( 'post_type' => 'portfolio', 'posts_per_page' => '-1', 'orderby' => $sortby,  'order' => $order );



                            $loop = new WP_Query( $args );

                            while ( $loop->have_posts() ) : $loop->the_post();

                                $term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
                                $slugs=array();
                                foreach($term_list as $term)
                                    $slugs[]=$term->slug;

                                    $html .='
                                    <div class="iq-masonry-item '. implode(' ',$slugs) .'">
                                        <div class="iq-portfolio">
                                            <a href="'. get_permalink() .'" class="iq-portfolio-img">'. get_the_post_thumbnail() .'</a>
                                            <div class="iq-portfolio-content text-'.$position.'">
                                                <div class="details-box clearfix">
                                                    <div class="consult-details">';
                                                $html .='<a href="'. get_permalink() .'">
                                                        <'.$tag.' class="text-hover mb-2">'. get_the_title() .'</'.$tag.'>
                                                        </a>';
                            if(has_excerpt()):
                            $html .='<p class="desc mb-0">'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

                            $html .='
                                                        
                                                    </div>

                                                    <div class="mb-0 portfolio-tag"><ul>';
 $args = array(  'post_type' => 'portfolio',
                                            'taxonomy' => 'portfolio-tag',
                                            'orderby' => 'name',
                                            'order'   => 'ASC'
                                        );
                            $postcat = wp_get_post_terms(get_the_ID(), 'portfolio-tag');
                            foreach($postcat as $cat) {
                                    $html .=' <li>'.$cat->name .'</li>';
                                    }
                                                  $html .='</ul></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            endwhile;
                            wp_reset_postdata();


                                $html .='</div></div></div></div>';
                                 $terms = get_terms( array('taxonomy' => 'portfolio-categories',) );

                            foreach($terms as $term) {

                                    $html .='<div class="tab-pane" id="'.$term->slug.'">
                                            <div class="row flex-row-reverse">';
                                $html .='    <div class="col-lg-12 text-left align-self-center">';

                                $html .='<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="'.$mob_number.'" data-autoplay="'.$auto.'" data-loop="'.$loops.'" data-margin="30">';


             $args = array( 'post_type' => 'portfolio', 'posts_per_page' => '-1', 'orderby' => $sortby,  'order' => $order,'tax_query' => array(
                                    array(
                                        'taxonomy' => 'portfolio-categories',
                                        'field'    => 'slug',
                                        'terms'    => $term->slug,
                                    ),
                                ), );



                            $loop = new WP_Query( $args );

                            while ( $loop->have_posts() ) : $loop->the_post();

                                $term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
                                $slugs=array();
                                foreach($term_list as $term)
                                    $slugs[]=$term->slug;

                                    $html .='
                                    <div class="iq-masonry-item '. implode(' ',$slugs) .'">
                                        <div class="iq-portfolio">
                                            <a href="'. get_permalink() .'" class="iq-portfolio-img">'. get_the_post_thumbnail() .'</a>
                                            <div class="iq-portfolio-content text-'.$position.'">
                                                <div class="details-box clearfix">
                                                    <div class="consult-details">';
                                                $html .='<a href="'. get_permalink() .'">
                                                        <'.$tag.' class="text-hover mb-2">'. get_the_title() .'</'.$tag.'>
                                                        </a>';
                            if(has_excerpt()):
                            $html .='<p class="desc mb-0">'.sprintf( esc_html__('%s','xamin'),get_the_excerpt()).'</p>';
                            endif;

                            $html .='
                                                       
                                                    </div>
                                                    
                                                  <div class="mb-0 portfolio-tag"><ul>';
 $args = array(  'post_type' => 'portfolio',
                                            'taxonomy' => 'portfolio-tag',
                                            'orderby' => 'name',
                                            'order'   => 'ASC'
                                        );
                            $postcat = wp_get_post_terms(get_the_ID(), 'portfolio-tag');
                            foreach($postcat as $cat) {
                                    $html .=' <li>'.$cat->name .'</li>';
                                    }
                                                  $html .='</ul></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            endwhile;
                            wp_reset_postdata();
                $html .='</div>
                    </div>
                </div>
            </div>';
        $i++;
    }
    $html .='</div>
    </div>';
}
    return $html;
}
add_shortcode('xaminportfolioslider','xaminportfolioslider');
?>