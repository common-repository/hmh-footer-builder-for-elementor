<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'HMHFBE_POSTTYPES' ) ) {
	/**
	 * HMHFBE_POSTTYPES Class
	 *
	 * @since	1.0
	 */
	class HMHFBE_POSTTYPES {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			//$this->init();
			add_filter( 'bb_register_posttypes', array( $this, 'register_posttypes' ), 10, 1 );
		}

		public function init() {

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
		
		}

		public function enqueueScripts() {
		
        }
        
		public function register_posttypes($posttypes) {

			if( empty($posttypes) ) {
				$posttypes = array();
			}

			$labels = array(
				'name'               => _x( 'Footer Contents', 'Footer Contents', 'hmh-footer-builder-for-elementor' ),
				'singular_name'      => _x( 'Footer Content', 'Footer Content', 'hmh-footer-builder-for-elementor' ),
				'menu_name'          => esc_html__( 'Footer Builder', 'hmh-footer-builder-for-elementor' ),
				'name_admin_bar'     => esc_html__( 'Footer Content', 'hmh-footer-builder-for-elementor' ),
				'parent_item_colon'  => esc_html__( 'Parent Menu:', 'hmh-footer-builder-for-elementor' ),
				'all_items'          => esc_html__( 'All Footers', 'hmh-footer-builder-for-elementor' ),
				'add_new_item'       => esc_html__( 'Add New Footer Content', 'hmh-footer-builder-for-elementor' ),
				'add_new'            => esc_html__( 'Add New', 'hmh-footer-builder-for-elementor' ),
				'new_item'           => esc_html__( 'New Footer Content', 'hmh-footer-builder-for-elementor' ),
				'edit_item'          => esc_html__( 'Edit Footer Content', 'hmh-footer-builder-for-elementor' ),
				'update_item'        => esc_html__( 'Update Footer Content', 'hmh-footer-builder-for-elementor' ),
				'view_item'          => esc_html__( 'View Footer Content', 'hmh-footer-builder-for-elementor' ),
				'search_items'       => esc_html__( 'Search Footer Content', 'hmh-footer-builder-for-elementor' ),
				'not_found'          => esc_html__( 'Not found', 'hmh-footer-builder-for-elementor' ),
				'not_found_in_trash' => esc_html__( 'Not found in Trash', 'hmh-footer-builder-for-elementor' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Footer Content', 'lamblue' ),
				'description'         => esc_html__( 'Footer Content', 'lamblue' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', ),
				'capability_type' 	  => 'page',
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 13,
				'menu_icon' 		  => HMHFBE_URL . 'assets/admin/images/fb-logo.png',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => true,
			);
			$posttypes[HMHFBE_FOOTER_POSTTYPE] = $args;
			return $posttypes;
		}
        
    }
	
	new HMHFBE_POSTTYPES();
}

