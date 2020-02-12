<?php

function xamin_subscribe_widgets() {
	register_widget( 'iq_contact_info' );
}
add_action( 'widgets_init', 'xamin_subscribe_widgets' );

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_contact_info extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_contact_info', 
			
			// Widget name will appear in UI
			esc_html('Xamin Subscribe', 'xamin'), 
 
			// Widget description
			array( 'description' => esc_html( 'xamin subscribe. ', 'xamin' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html( 'xamin Subscribe', 'xamin' );
		
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : false;
		
		
		
		//$args['after_widget'];

		/* here add extra display item  */ 
		$iq_contact = isset($instance[ 'iq-contact' ]) ? $instance['iq-contact'] : '';
				
		?>
		<div class="widget">
			<div class="container">
				<div class="row algin-self-center">
					<div class="col-sm-6">
						<?php
						if ( $title ){
							echo ($args['before_title'] . $title . $args['after_title']);
						}
						?>
					</div>
					<div class="col-sm-6">
					<?php		
					$xamin_option = get_option('xamin_options');

					if(isset($xamin_option['xamin_subscribe'])){ 
						$xamin_subscribe = $xamin_option['xamin_subscribe']; 
					}
					
					echo do_shortcode($xamin_subscribe);
					?>
					</div>
				</div>
			</div>
		</div>
		<?php
				
	}
         
	// Widget Backend 
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';		
		?>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>"><?php esc_html_e( 'Title:','xamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','xamin')); ?>" type="text" value="<?php echo esc_html($title,'xamin'); ?>" /></p>
		
		<?php 
							
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/	