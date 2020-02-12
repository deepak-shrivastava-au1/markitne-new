<?php
// Pricing Plan
function xaminpricing( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'pp_title'           => 'Free',
		'pp_subtitle'		 => 'Feedback System',
		'pp_content'		=>	'It is a long established fact that a reader will be distracted',
		'pp_currecny'		 => '$',
		'pp_price'           => '19',
		'pp_duration'        => '',
		'features'			 => '',
		'title_content'      => '',
		'tab_title'		     => '',
		'pp_btl_label'		 => 'Button',
		'pp_btl_url'		 => '#',
		'position'			=> 'left',
	), $atts ) );

  

    $features_out	= '';
	$features		= (array) vc_param_group_parse_atts( $features );
	$features_data	= array();
    
    foreach ( $features as $data ) :
		$new_line 				      = $data;
		$new_line['tab_title']	      = isset( $data['tab_title'] ) ? $data['tab_title'] : '';		
		$new_line['disble_pcustomer']	   = isset( $data['disble_pcustomer'] ) ? $data['disble_pcustomer'] : '';
		$features_data[] 		      = $new_line;
	endforeach;
        
	$out = '';

	$out .= '
	<div class="iq-pricing text-'.$position.'" >
		<div class="priceing-title " >
			<h2 >'.$pp_currecny.''. $pp_price .'';
			    if(!empty($pp_duration)) {
			        $out .= '<span>/'.$pp_duration.'</span>';
			    }    
	        $out .= '
	        </h2>
			<p class="mb-0">'.$pp_content.'</p>
		</div>
		<div class="priceing-description " >
		<h4 class="title mb-3" >'. $pp_title .'</h4>
		<h5 class="subtitle mb-3" >'. $pp_subtitle .'</h5>
		<ul class="pricing-list">';	
				foreach ( $features_data as $line ) :	
					if($line['disble_pcustomer'] == '0')
					{
						$out .= '<li  class="pricing-features-item disable">
									'.$line['tab_title'].'
								</li>';
					}
					else
					{				
						$out .= '<li>'.$line['tab_title'].'</li>';
					}	
				endforeach;
		$out .='</ul>';
				if($pp_btl_label != '' && $pp_btl_url != '')
				{
				$out .= '<a class="button blue-btn" href="'.esc_url($pp_btl_url).'" role="button">'.esc_html($pp_btl_label).'</a>';
				}
	$out .='</div></div>';
   


	return $out;
}
add_shortcode('xaminpricing', 'xaminpricing');
?>