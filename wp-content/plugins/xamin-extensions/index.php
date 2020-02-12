<?php 
/*
Plugin Name: Xamin Extensions	
Plugin URI: http://iqonicthemes.com/
Description: xamin plugin provides custom team post type, gallery post type with related functionality.
Author: iqonicthemes
Version: 1.0
Author URI: http://www.goldenmace.com/
Text Domain: xamin_NAME
*/

if( !defined( 'xamin_TH_ROOT' ) ) 
	define('xamin_TH_ROOT', plugin_dir_path( __FILE__ ));

if( !defined( 'xamin_TH_URL' ) ) 
	define( 'xamin_TH_URL', plugins_url( '', __FILE__ ) );

if( !defined( 'xamin_NAME' ) ) 
	define( 'xamin_NAME', 'xamin' );

$xamin_option = get_option('xamin_options');

// Register Team Member custom post type
add_action( 'init', 'xamin_team' );
function xamin_team() {
	$labels = array(
		'name'                  => esc_html__( 'Team Member', 'post type general name', 'xamin' ),
		'singular_name'         => esc_html__( 'Team Member', 'post type singular name', 'xamin' ),
		'featured_image'        => esc_html__( 'Team Member Photo', 'xamin'  ),
		'set_featured_image'    => esc_html__( 'Set Team Member Photo', 'xamin'  ),
		'remove_featured_image' => esc_html__( 'Remove Team Member Photo', 'xamin'  ),
		'use_featured_image'    => esc_html__( 'Use as Team Member Photo', 'xamin'  ),
		'menu_name'             => esc_html__( 'Our Team', 'admin menu', 'xamin' ),
		'name_admin_bar'        => esc_html__( 'Team Member', 'add new on admin bar', 'xamin' ),
		'add_new'               => esc_html__( 'Add New', 'Team Member', 'xamin' ),
		'add_new_item'          => esc_html__( 'Add New Team Member', 'xamin' ),
		'new_item'              => esc_html__( 'New Team Member', 'xamin' ),
		'edit_item'             => esc_html__( 'Edit Team Member', 'xamin' ),
		'view_item'             => esc_html__( 'View Team Member', 'xamin' ),
		'all_items'             => esc_html__( 'All Team Members', 'xamin' ),
		'search_items'          => esc_html__( 'Search Team Member', 'xamin' ),
		'parent_item_colon'     => esc_html__( 'Parent Team Member:', 'xamin' ),
		'not_found'             => esc_html__( 'No Classs found.', 'xamin' ),
		'not_found_in_trash'    => esc_html__( 'No Classs found in Trash.', 'xamin' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'xaminteam' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag')
	);

	register_post_type( 'xaminteam', $args );
}

// Custom taxonomy Team
add_action( 'after_setup_theme', 'xamin_team_taxonomy' );
function xamin_team_taxonomy() {
	register_taxonomy(
		'xaminteam-categories',
		'xaminteam',
		array(
			'label' => esc_html__( 'Team Category', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'xaminteam-tag',
		'xaminteam',
		array(
			'label' => esc_html__( 'Team Tag', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
}


// Register Portfolio custom post type
add_action( 'init', 'xamin_portfolio' );
function xamin_portfolio() {
	$labels = array(
		'name'                  => esc_html__( 'Portfolio', 'post type general name', 'xamin' ),
		'singular_name'         => esc_html__( 'Portfolio', 'post type singular name', 'xamin' ),
		'featured_image'        => esc_html__( 'Portfolio Photo', 'xamin'  ),
		'set_featured_image'    => esc_html__( 'Set Portfolio Photo', 'xamin'  ),
		'remove_featured_image' => esc_html__( 'Remove Portfolio Photo', 'xamin'  ),
		'use_featured_image'    => esc_html__( 'Use as Portfolio Photo', 'xamin'  ),
		'menu_name'             => esc_html__( 'Portfolio', 'admin menu', 'xamin' ),
		'name_admin_bar'        => esc_html__( 'Portfolio', 'add new on admin bar', 'xamin' ),
		'add_new'               => esc_html__( 'Add New', 'Portfolio', 'xamin' ),
		'add_new_item'          => esc_html__( 'Add New Portfolio', 'xamin' ),
		'new_item'              => esc_html__( 'New Portfolio', 'xamin' ),
		'edit_item'             => esc_html__( 'Edit Portfolio', 'xamin' ),
		'view_item'             => esc_html__( 'View Portfolio', 'xamin' ),
		'all_items'             => esc_html__( 'All Portfolio', 'xamin' ),
		'search_items'          => esc_html__( 'Search Portfolio', 'xamin' ),
		'parent_item_colon'     => esc_html__( 'Parent Portfolio :', 'xamin' ),
		'not_found'             => esc_html__( 'No Classs found.', 'xamin' ),
		'not_found_in_trash'    => esc_html__( 'No Classs found in Trash.', 'xamin' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-category',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag','excerpt')
	);

	register_post_type( 'portfolio', $args );
}


// Custom taxonomy Portfolio
add_action( 'after_setup_theme', 'xamin_custom_taxonomy' );
function xamin_custom_taxonomy() {
	register_taxonomy(
		'portfolio-categories',
		'portfolio',
		array(
			'label' => esc_html__( 'Portfolio Category', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'portfolio-tag',
		'portfolio',
		array(
			'label' => esc_html__( 'Portfolio Tag', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
}

// Register Testimonial type custom post
add_action( 'init', 'xamin_testimonial_gallery' );
function xamin_testimonial_gallery() {
	$labels = array(
		'name'               => esc_html__( 'Testimonial', 'post type general name', 'xamin' ),
		'singular_name'      => esc_html__( 'Testimonial', 'post type singular name', 'xamin' ),
		'featured_image'        => esc_html__( 'Photo', 'xamin'  ),
		'set_featured_image'    => esc_html__( 'Set Photo', 'xamin'  ),
		'remove_featured_image' => esc_html__( 'Remove Photo', 'xamin'  ),
		'use_featured_image'    => esc_html__( 'Use as Photo', 'xamin'  ),
		'menu_name'          => esc_html__( 'Testimonial', 'admin menu', 'xamin' ),
		'name_admin_bar'     => esc_html__( 'Testimonial', 'add new on admin bar', 'xamin' ),
		'add_new'            => esc_html__( 'Add New', 'Testimonial', 'xamin' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial', 'xamin' ),
		'new_item'           => esc_html__( 'New Testimonial', 'xamin' ),
		'edit_item'          => esc_html__( 'Edit Testimonial', 'xamin' ),
		'view_item'          => esc_html__( 'View Testimonial', 'xamin' ),
		'all_items'          => esc_html__( 'All Testimonial', 'xamin' ),
		'search_items'       => esc_html__( 'Search Testimonial', 'xamin' ),
		'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'xamin' ),
		'not_found'          => esc_html__( 'No Testimonial found.', 'xamin' ),
		'not_found_in_trash' => esc_html__( 'No Testimonial found in Trash.', 'xamin' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-format-gallery',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag')
	);

	register_post_type( 'testimonial', $args );
}

// Custom taxonomy Testimonial
add_action( 'after_setup_theme', 'xamin_testimonial_taxonomy' );
function xamin_testimonial_taxonomy() {
	register_taxonomy(
		'testimonial-categories',
		'testimonial',
		array(
			'label' => esc_html__( 'Testimonial Category', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'testimonial-tag',
		'testimonial',
		array(
			'label' => esc_html__( 'Testimonial Tag', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
}

// Faqs custom post type
add_action( 'init', 'xamin_career' );
function xamin_career() {
	$labels = array(
		'name'                  => esc_html__( 'Career', 'post type general name', 'xamin' ),
		'singular_name'         => esc_html__( 'Career', 'post type singular name', 'xamin' ),
		'featured_image'        => esc_html__( 'Career Photo', 'xamin'  ),
		'set_featured_image'    => esc_html__( 'Set Career Photo', 'xamin'  ),
		'remove_featured_image' => esc_html__( 'Remove Career Photo', 'xamin'  ),
		'use_featured_image'    => esc_html__( 'Use as Career Photo', 'xamin'  ),
		'menu_name'             => esc_html__( 'Career', 'admin menu', 'xamin' ),
		'name_admin_bar'        => esc_html__( 'Career', 'add new on admin bar', 'xamin' ),
		'add_new'               => esc_html__( 'Add New', 'Career', 'xamin' ),
		'add_new_item'          => esc_html__( 'Add New Career', 'xamin' ),
		'new_item'              => esc_html__( 'New Career', 'xamin' ),
		'edit_item'             => esc_html__( 'Edit Career', 'xamin' ),
		'view_item'             => esc_html__( 'View Career', 'xamin' ),
		'all_items'             => esc_html__( 'All Careers', 'xamin' ),
		'search_items'          => esc_html__( 'Search Career', 'xamin' ),
		'parent_item_colon'     => esc_html__( 'Parent Career:', 'xamin' ),
		'not_found'             => esc_html__( 'No Classs found.', 'xamin' ),
		'not_found_in_trash'    => esc_html__( 'No Classs found in Trash.', 'xamin' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'xamincareer' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-media-text',
		'supports'           => array( 'title', 'editor', 'thumbnail','category','tag')
	);

	register_post_type( 'xamincareer', $args );
}

// Custom taxonomy Faqs
add_action( 'after_setup_theme', 'xamin_custom_faq_taxonomy' );
function xamin_custom_faq_taxonomy() {
	register_taxonomy(
		'xamincareer-categories',
		'xamincareer',
		array(
			'label' => esc_html__( 'Faq Category', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'xamincareer-tag',
		'xamincareer',
		array(
			'label' => esc_html__( 'Faq Tag', 'xamin' ),
			'rewrite' => true,
			'hierarchical' => true,
		)
	);
}

// Redux theme options

if ( !class_exists('ReduxFramework') ) {
    require_once(xamin_TH_ROOT . 'extensions/Redux/ReduxCore/framework.php');
}

// Meta box Options
if ( !class_exists('RW_Meta_Box') ) {
    require_once(xamin_TH_ROOT . 'extensions/meta-box/meta-box.php');
}

if($xamin_option['lazy_load']=="yes"){ 
	// Lazy load
	if ( ! class_exists( 'LazyLoad_Images' ) ) { 
		require_once(xamin_TH_ROOT . 'extensions/lazy-load/lazy-load.php');
	}
}

// Visual Composer Shortcodes Handle
add_action( 'plugins_loaded', 'shortcodes_init' );
function shortcodes_init() {
	foreach( glob( plugin_dir_path( __FILE__ ) . '/visualcomposer/shortcodes/*.php' ) as $filename ) {
		require_once $filename;
	}
}

require_once(xamin_TH_ROOT . 'widget/footer-contact.php');

require_once(xamin_TH_ROOT . 'widget/subscribe.php');

require_once(xamin_TH_ROOT . 'widget/social_media.php');

require_once(xamin_TH_ROOT . 'widget/recent-post.php');

require_once(xamin_TH_ROOT . 'widget/testimonial.php');

require_once(xamin_TH_ROOT . 'widget/pdf.php');

if($xamin_option['cookie']=="yes"){
	require_once(xamin_TH_ROOT . 'extensions/easy-wp-cookie-popup/easy-wp-cookie-popup.php');
}

require_once(xamin_TH_ROOT . 'extensions/xamin-font-icon.php');

require_once(xamin_TH_ROOT . 'extensions/one-click-demo-import/one-click-demo-import.php');

/*---------------------------------------
		iQonic admin enque
---------------------------------------*/
function xamin_enqueue_custom_admin_style() {
	wp_register_style( 'xamin_wp_admin_css', xamin_TH_URL . '/extensions/assets/css/xamin.min.css', false, '1.0.0' );
	wp_enqueue_style( 'xamin_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'xamin_enqueue_custom_admin_style' );
?>