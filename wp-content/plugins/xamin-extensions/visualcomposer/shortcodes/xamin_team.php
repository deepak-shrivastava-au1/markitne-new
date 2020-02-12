<?php
// Our Team
function xaminteam($atts, $content = null) {

    extract(shortcode_atts(array(
        'number'        => -1,
        'desk_number'   => '4',
        'lap_number'    => '3',
        'tab_number'    => '3',
        'mob_number'    => '2',
        'loop'          => 'true',
        'sortby'        => 'date',
        'order'         => 'DESC',
        'arrow'         => 'true',
        'dots'          => 'false',
        'auto'			=> 'true',
        'position'		=> 'left',
		'tag'		    => 'h2',
        'css'           => '',
        'extra_class'   => '',
    ), $atts));

    $css_class = '';

    $args = array(
        'post_type'         => 'xaminteam',
        'post_status'       => 'publish',
        'posts_per_page'    => $number,
        'order'             => $order,
        'suppress_filters'  => 0
    );

    if(!empty($desk_number)){ $number = $desk_number; }else{ $desk_number = "-1"; }

    $recent_teams = get_posts( $args);
    $xamin_option = get_option('xamin_options');

    if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}


    $html = '';

    $html .= '
        <div class="row '. esc_attr( $css_class ) .'">
            <div class="col-sm-12">';
                if($desk_number <= "4" && $desk_number != "-1"){
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
                }else{
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="34" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
                }

                    $i=0;
                    foreach( $recent_teams as $recent ){

                    $html .= '
                    <div  class="item '.$extra_class.' text-'.$position.'">
                        <div  class="iq-team">
                                <div class="iq-team-img">';
                                    if(has_post_thumbnail( $recent->ID )){
                                        $full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $recent->ID ), "full" );
                                        $html .='
                                        <img src="'.esc_url($full_image[0]).'" class="img-fluid" alt="#'.$i.'">';
                                    }

                                    $html .= '

                                </div>

                                <div class="iq-share">
                                <div class="slideouticons">

                                    <label class="mainlabel"><i class="fa fa-share-alt"></i></label>
                                    <div class="iconswrapper">
                                        <ul>';
                                        $trainer_facebook   = get_post_meta( $recent->ID, 'xamin_team_facebook', true);
                                        $trainer_twwitter   = get_post_meta( $recent->ID, 'xamin_team_twitter', true);
                                        $trainer_google   = get_post_meta( $recent->ID, 'xamin_team_google', true);
                                        $trainer_github    = get_post_meta( $recent->ID, 'xamin_team_github', true);
                                        $trainer_insta     = get_post_meta( $recent->ID, 'xamin_team_insta', true);
                                            if($trainer_facebook){
                                                $html .='<li><a href="'.esc_url($trainer_facebook).'"><i class="fa fa-facebook-f"></i></a></li>';
                                                }
                                            if($trainer_twwitter){
                                                $html .='<li><a href="'.esc_url($trainer_twwitter).'"><i class="fa fa-twitter"></i></a></li>';
                                            }
                                            if($trainer_google){
                                                $html .='<li><a href="'.esc_url($trainer_google).'"><i class="fa fa-google"></i></a></li>';
                                            }
                                            if($trainer_github){
                                                $html .='<li><a href="'.esc_url($trainer_github).'"><i class="fa fa-github"></i></a></li>';
                                            }
                                            if($trainer_insta){
                                                $html .='<li><a href="'.esc_url($trainer_insta).'"><i class="fa fa-instagram"></i></a></li>';
                                            }
                                            $html .= '
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                                <div class="iq-team-info text-center">';
                                    $html .='
                                    <a><'.$tag.'>'.esc_html($recent->post_title).'</'.$tag.'></a>';
                                    $data = '';
                                    $designation  = get_post_meta( $recent->ID, 'xamin_team_designation', true);
                                    $html .='<span>';
                                    if($designation) { $html .= $designation; }
                                    $html .='</span>';
                $html .='</div>';
                                $i++;
                                $html .='
                        </div>
                    </div>';
                    }
                    $html .='
                </div>
            </div>
        </div>';

    return $html;
}
add_shortcode('xaminteam','xaminteam');
?>