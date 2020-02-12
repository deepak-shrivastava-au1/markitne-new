<?php
// Our Team
function xaminslider($atts, $content = null) {

    extract(shortcode_atts(array(
        'slider_type'      => '0',
        'slider_image'      => '',
        'video_image'       => '',
        'youtube_url'       => '',
        'slider_title'     => '',
        'slider_contant'  => '',
        'image'         => '',
        'slider_btl_url'    => '',
        'slider'        => '',
        'image_slider'      => '',
        'video_slider'      => '',
        'number'        => -1,
        'desk_number'   => '2',
        'lap_number'    => '1',
        'tab_number'    => '1',
        'mob_number'    => '1',
        'loop'          => 'true',
        'auto'          => 'true',
        'sortby'        => 'date',
        'order'         => 'DESC',
        'arrow'         => 'true',
        'dots'          => 'false',
        'tag'           => 'h2',
        'css'           => '',
        'enabal_shadow' => '',
        'position'      => 'left',
        'extra_class'   => '',
    ), $atts));

    $css_class = '';

    if(isset($data))
	{
		$image = $data['image'] ? wp_get_attachment_image_url( $data["image"]) : '';
    }

    if(isset($data))
	{
		$image = $data['video_image'] ? wp_get_attachment_image_url( $data["video_image"]) : '';
	}

	// features loop
    $slider_out	= '';
    $slider		= (array) vc_param_group_parse_atts( $slider );
    $slider_data	= array();

	foreach ( $slider as $data ) :
        $new_line 				      = $data;
        $new_line['slider_type']	      = isset( $data['slider_type'] ) ? $data['slider_type'] : '';
		$new_line['slider_title']	      = isset( $data['slider_title'] ) ? $data['slider_title'] : '';
        $new_line['slider_contant']  = isset( $data['slider_contant'] ) ? $data['slider_contant'] : '';
        $new_line['slider_btl_url']  = isset( $data['slider_btl_url'] ) ? $data['slider_btl_url'] : '';
		if(isset($new_line['image'])){
				$new_line['image']	      = wp_get_attachment_image_url($data['image'],'full');
        }
		$slider_data[] 		      = $new_line;
    endforeach;

    // features loop
    $image_slider_out	= '';
    $image_slider		= (array) vc_param_group_parse_atts( $image_slider );
    $image_slider_data	= array();

	foreach ( $image_slider as $data ) :
        $new_line 				      = $data;
		if(isset($new_line['slider_image'])){
			$new_line['slider_image']	      = wp_get_attachment_image_url($data['slider_image'],'full');
        }
		$image_slider_data[] 		      = $new_line;
    endforeach;

    // features loop
    $video_slider_out	= '';
    $video_slider		= (array) vc_param_group_parse_atts( $video_slider );
    $video_slider_data	= array();

	foreach ( $video_slider as $data ) :
        $new_line 				      = $data;
		if(isset($new_line['video_image'])){
            $new_line['video_image']	      = wp_get_attachment_image_url($data['video_image'],'full');
        }
        $new_line['youtube_url']  = isset( $data['youtube_url'] ) ? $data['youtube_url'] : '';
		$video_slider_data[] 		      = $new_line;
    endforeach;


    if(!empty($css)){
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $atts['css'] );
		}

    $html = '';


    if($slider_type == 0){
    $html .= '
        <div class="row '. esc_attr( $css_class ) .'">
            <div class="col-sm-12">';
                if($desk_number <= "2" && $desk_number != "-1"){
                    $html .= '<div class="owl-carousel owl-services" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="15">';
                }else{
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="15">';
                }
                foreach ($slider_data as $data) :
                    if($enabal_shadow == "0")
                    {
                    $html .='<div class="Consulting-box service-slider '.$extra_class.' text-'.$position.'">';
                    }
                    else{
                    $html .='<div class="Consulting-box '.$extra_class.' text-'.$position.'">';
                    }
                    $html .='<img src="'.$data['image'].'" alt="slider">';

                        $html .='<div class="details-box clearfix">
                                    <div class="consult-details">
                                        <'.$tag.'>'.$data['slider_title'].'</'.$tag.'>
                                        <p class="mb-0">'.$data['slider_contant'].'</p>
                                    </div>
                                    <a href="'.$data['slider_btl_url'].'"><i aria-hidden="true" class="ion ion-plus"></i></a>
                                </div>';
             $html .='</div>';
                endforeach;
        $html .='</div>
            </div>
        </div>';
    }

    if($slider_type == 1){
        $html .= '
        <div class="row '. esc_attr( $css_class ) .'">
            <div class="col-sm-12">';
                if($desk_number <= "2" && $desk_number != "-1"){
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="true" data-loop="'.$loop.'" data-margin="30">';
                }else{
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="true" data-loop="'.$loop.'" data-margin="30">';
                }
                foreach ($image_slider_data as $data) :
                $html .='<div class="Consulting-img '.$extra_class.' text-'.$position.'">';

                    $html .='<img src="'.$data['slider_image'].'" alt="slider">';
                $html .='</div>';
                endforeach;
        $html .='</div>
            </div>
        </div>';
    }

    if($slider_type == 2){
        $html .= '
        <div class="row '. esc_attr( $css_class ) .'">
            <div class="col-sm-12 single-image-shadow">';
                if($desk_number <= "2" && $desk_number != "-1"){
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'" data-items="'.$desk_number.'" data-items-laptop="'.$lap_number.'" data-items-tab="'.$tab_number.'" data-items-mobile="'.$mob_number.'" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
                }else{
                    $html .= '<div class="owl-carousel" data-dots="'.$dots.'" data-nav="'.$arrow.'"  data-items="3" data-items-laptop="3" data-items-tab="3" data-items-mobile="2" data-items-mobile-sm="1" data-autoplay="'.$auto.'" data-loop="'.$loop.'" data-margin="30">';
                }
                foreach ($video_slider_data as $data) :
                $html .='<div class="Consulting-img'.$extra_class.' text-'.$position.'">';

                        $html .='<div class="video-img">';

                            $html .= '<img src="'.$data['video_image'].'" class="img-fluid img-two" alt="#">';
                            $html .= '<div class="consult-video">';
                                $html .= '<a href="'.esc_html($data['youtube_url']).'" class="iq-video popup-youtube"><i class="fas fa-play"></i></a>';
                            $html .= '</div>';

                        $html .= '</div>';
             $html .='</div>';
                endforeach;
        $html .='</div>
            </div>
        </div>';
    }
    return $html;
}
add_shortcode('xaminslider','xaminslider');
?>