<?php

function xamin_pdf() {
    register_widget( 'iq_pdf' );
}
add_action( 'widgets_init', 'xamin_pdf' );

/*-------------------------------------------
		iqonic Contact Information widget
--------------------------------------------*/
class iq_pdf extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'iq_pdf',

			// Widget name will appear in UI
			esc_html('Xamin PDF', 'xamin'),

			// Widget description
			array( 'description' => esc_html( 'Xamin PDF download. ', 'xamin' ), )
		);
	}

	// Creating widget front-end

	public function widget( $args, $instance ) {

		global $wp_registered_sidebars;

        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$pdftitle = ( ! empty( $instance['pdftitle'] ) ) ? $instance['pdftitle'] : esc_html( 'PDF download', 'xamin' );
		$pdflink = ( ! empty( $instance['pdflink'] ) ) ? $instance['pdflink'] : esc_html( 'PDF download', 'xamin' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'title', $title, $instance, $this->id_base );
		$pdftitle = apply_filters( 'pdftitle', $pdftitle, $instance, $this->id_base );
		$pdflink = apply_filters( 'pdflink', $pdflink, $instance, $this->id_base );

		//$args['after_widget'];
		?>

		<div class="widget get-file">
			<?php
			if ( $title ) {
				echo ($args['before_title'] . $title . $args['after_title']);
			}
			?>

			<a href="<?php echo $pdflink; ?>">
				<ul class="list-inline download-item">
				<li class="list-inline-item"><i class="fa fa-file-pdf-o"></i><span class="ml-3"><?php echo $pdftitle; ?></span></li>
				</ul>
			</a>
		</div>

	<?php
	}

	// Widget Backend
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$pdftitle     = isset( $instance['pdftitle'] ) ? esc_attr( $instance['pdftitle'] ) : '';
		$pdflink     = isset( $instance['pdflink'] ) ? esc_attr( $instance['pdflink'] ) : '';
		?>
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>"><?php esc_html_e( 'Title:','xamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','xamin')); ?>" type="text" value="<?php echo esc_html($title,'xamin'); ?>" /></p>

		<p><label for="<?php echo esc_html($this->get_field_id( 'pdftitle','xamin' )); ?>"><?php esc_html_e( 'File Title:','xamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'pdftitle','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'pdftitle','xamin')); ?>" type="text" value="<?php echo esc_html($pdftitle,'xamin'); ?>" /></p>

		<p><label for="<?php echo esc_html($this->get_field_id( 'pdflink','xamin' )); ?>"><?php esc_html_e( 'File Link:','xamin' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'pdflink','xamin' )); ?>" name="<?php echo esc_html($this->get_field_name( 'pdflink','xamin')); ?>" type="text" value="<?php echo esc_html($pdflink,'xamin'); ?>" /></p>

		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['pdftitle'] = sanitize_text_field( $new_instance['pdftitle'] );
		$instance['pdflink'] = sanitize_text_field( $new_instance['pdflink'] );
        return $instance;
	}
}
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/