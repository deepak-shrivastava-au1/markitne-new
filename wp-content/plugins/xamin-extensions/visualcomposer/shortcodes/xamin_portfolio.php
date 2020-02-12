<?php
// Our Team
function xaminportfolio($atts, $content = null){    

    extract(shortcode_atts(array(
        'position'	    => 'left',
        'tag'		    => 'h2',
        'extra_class'   => '',
        'number'        => -1,
        'columns_type'  => '2',
        'space_field'   => '',
        'sortby'        => 'date',
        'order'         => 'DESC',
        'css'           => '',
        'masonry_type'  => '0',
        'hover_style'   => '1',
        'delay_time'    => '',
    ), $atts)); 

    $css_class = '';
   
    $args = array(
        'post_type'         => 'portfolio',
        'post_status'       => 'publish',
        'posts_per_page'    => $number, 
        'orderby'           => $sortby,                       
        'order'             => $order,                       
    );

    $wp_query = new WP_Query($args);

    if(!empty($delay_time))
	{
		$delay_time = 'data-wow-delay="'.$delay_time.'s"';
	}
    
    $html ='';

    $html .='<div class="row wow fadeInUp '. esc_attr( $css_class ) .'" '.$delay_time.'>
                <div class="col-sm-12">
                    <div class="iq-masonry-block '.$extra_class.'"  >
                        <div class="isotope-filters isotope-tooltip">';
                        $terms = get_terms( array('taxonomy' => 'portfolio-categories',) );
                        $html .='<button data-filter="" class="active">All<span class="post_no">'. $wp_query->post_count .'</span></button>';
                        foreach($terms as $term) {
                        $html .='<button data-filter=".'. $term->slug .'">'. $term->name .'<span class="post_no">'. $term->count .'</span></button>';
                        }
                $html .='</div>';
                $html .='<div class=" iq-masonry iq-columns-'. $columns_type.' '. $space_field .'" >';
                            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => $number, 'orderby' => $sortby,  'order' => $order );
                            $loop = new WP_Query( $args );
                        
                            while ( $loop->have_posts() ) : $loop->the_post();
                            
                            $term_list = wp_get_post_terms(get_the_ID(), 'portfolio-categories');
                            
                            $slugs=array();
                            foreach($term_list as $term)
                            $slugs[]=$term->slug;

                        $html .='<div class="iq-masonry-item '. implode(' ',$slugs) .' ">';
                            if($hover_style == '1')
                            { 
                            $html .='<div class="iq-portfolio">';
                            }
                            if($hover_style == '2')
                            { 
                            $html .='<div class="iq-portfolio style-two">';
                            }
                            if($masonry_type == 0)
                            {   
                                $portfolio_masonry_image = get_post_meta( get_the_ID(), 'portfolio_masonry_image',true); 
                                
                                $portfolio_masonry_image = wp_get_attachment_image_src( $portfolio_masonry_image, 'full' );
                                
                                
                                $html .='<a href="'. get_permalink() .'"><img src="'.esc_url($portfolio_masonry_image[0]).'" class="img-fluid" alt="portfolio"></a>';
                            }
                            else {
                                $html .='<a href="'. get_permalink() .'" class="iq-portfolio-img">'. get_the_post_thumbnail() .'</a>';
                            }
                                $html .='<div class="iq-portfolio-content  text-'.$position.'">
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
                    $html .='
                        </div>
                    </div>
                </div>
            </div>';  
    return $html;
}
add_shortcode('xaminportfolio','xaminportfolio');
?>