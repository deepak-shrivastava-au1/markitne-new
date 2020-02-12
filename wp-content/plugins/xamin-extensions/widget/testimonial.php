<?php

function xamin_testimonail_widgets() {
	register_widget( 'iq_testimonail' );
}
add_action( 'widgets_init', 'xamin_testimonail_widgets' );

/*-------------------------------------------
		iqonic Contact Information widget 
--------------------------------------------*/
class iq_testimonail extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'iq_testimonail', 
			
			// Widget name will appear in UI
			esc_html('Xamin Testimonail', 'xamin'), 
 
			// Widget description
			array( 'description' => esc_html( 'xamin testimonail. ', 'xamin' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html( 'Recent Post', 'xamin' );
		
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 1;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;	
		
		
		//$args['after_widget'];

		/* here add extra display item  */ 
		
	
		$iq_contact = isset($instance[ 'iq-contact' ]) ? $instance['iq-contact'] : '';
				
		?>

		<div class="testimonail-widget-menu widget">

			<div class="owl-carousel" data-dots="true" data-nav="false"   data-autoplay="true"  data-loop="true"  data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="30">


			<?php			
			$args = array( 'post_type' => 'testimonial', 'posts_per_page' => $number, );
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
			?>

			<div class="testimonial-info">
				<?php the_content(); ?>
				<?php				
				if($iq_contact){		
					foreach($iq_contact as $iq_contacts){
					?>
					<div class="post-img">
						<?php
						if($iq_contacts == "image"){
						?> 
							<?php the_post_thumbnail ('thumbnail'); ?>
						<?php
						}
						?> 
						<div class="testimonial-name">
						<h5><?php the_title(); ?></h5><span class="sub-title">
						<?php $designation  = get_post_meta( get_the_ID(), 'xamin_testimonial_designation', true); ?>
						<?php if($designation) { echo esc_html($designation); } ?>
						</span>
						</div>
					</div>
					<?php	
					}
				}
				?>
				
			</div>
						
		<?php
		endwhile;
		?>
			</div>	
		</div>
		<?php					
	}
         
	// Widget Backend 
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		
		if ( isset( $instance[ 'iq-contact' ] ) ) {
			$iq_contact = $instance[ 'iq-contact' ];
			foreach($iq_contact as $iq_contacts){
				
				if($iq_contacts == "image"){ $ch_image = "checked"; }
			}	
		}
		
		?>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>"><?php esc_html_e( 'Title:','xamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','xamin')); ?>" type="text" value="<?php echo esc_html($title,'xamin'); ?>" /></p>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'number','xamin' )); ?>"><?php esc_html_e( 'Number of posts to show:','xamin' ); ?></label>
		<input class="tiny-text" id="<?php echo esc_html($this->get_field_id( 'number','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number','xamin' )); ?>" type="number" step="1" min="1" value="<?php echo esc_html($number,'xamin'); ?>" size="3" /></p>
		
        <p>
 		<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'iq-contact','xamin')); ?>" name="<?php echo esc_html($this->get_field_name( 'iq-contact[]','xamin' )); ?>" value="image" <?php if(isset($ch_image)) echo esc_html($ch_image,'xamin'); ?>>
        <label for="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>"><?php echo esc_html('Image', 'xamin'); ?></label></br /> 
        </p>
		<?php 
							
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['iq-contact'] = $new_instance['iq-contact'];
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/	