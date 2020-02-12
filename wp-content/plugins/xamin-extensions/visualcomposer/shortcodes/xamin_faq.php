<?php
// Pricing Plan
function xaminFAQ( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title'           => '',
		'description'           => '',
		'faq'       => '',
		
	), $atts ) );
	
	
	
	// features loop
	$faq_out	= '';
	$faq		= (array) vc_param_group_parse_atts( $faq );
	$faq_data	= array();
	
	
	foreach ( $faq as $data ) :
		$new_line 				      = $data;
		$new_line['title']	      = isset( $data['title'] ) ? $data['title'] : '';
		$new_line['description']  = isset( $data['description'] ) ? $data['description'] : '';
		
		$faq_data[] 		      = $new_line;
		
		
	endforeach;
	
	
	$i=1;		
	$out = '';	
	
	$out .='
			<div class="iq-faq">';
			foreach ( $faq_data as $line ) :
				if($i == 1){ $show = "show"; $style="style=display:block"; $adactive="iq-active"; $i++;}else{ $style=""; $show = ""; $adactive="";}

			$out.= '<div class="iq-block '.$adactive.'">
						<a href="javascript:void(0)" class="iq-title">'.$line['title'].'</a>
						<div class="iq-details ">
							<p>'.$line['description'].'</p>
						</div>
					</div>';
			endforeach;	
			$out.= '</div>';
	
	return $out;
	
}
add_shortcode('xaminFAQ', 'xaminFAQ');
?>