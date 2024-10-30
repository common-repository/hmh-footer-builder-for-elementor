<?php
/*
Plugin Name: HMH Footer Builder for Elementor
Description: Easy way to create any footers you can imagine.
Author: Hameha
Version: 1.0
Author URI: https://codecanyon.net/user/bestbug/portfolio
Text Domain: hmh-footer-builder-for-elementor
Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


defined( 'HMHFBE_DESIGNER_VERSION' ) or define('HMHFBE_DESIGNER_VERSION', '1.0') ;
defined( 'HMHFBE_DESIGNER_CATEGORY' ) or define('HMHFBE_DESIGNER_CATEGORY', 'Footer Builder') ;

defined( 'HMHFBE_URL' ) or define('HMHFBE_URL', plugins_url( '/', __FILE__ )) ;

defined( 'HMHFBE_PATH' ) or define('HMHFBE_PATH', basename( dirname( __FILE__ ))) ;
defined( 'HMHFBE_TEXTDOMAIN' ) or define('HMHFBE_TEXTDOMAIN', plugins_url( '/', __FILE__ )) ;

// SHORTCODE
defined( 'HMHFBE_SHORTCODE_MENU' ) or define('HMHFBE_SHORTCODE_MENU', 'bbfb_menus') ;
defined( 'HMHFBE_SHORTCODE_INSTAGRAM' ) or define('HMHFBE_SHORTCODE_INSTAGRAM', 'bbfb_instagram') ;
defined( 'HMHFBE_SHORTCODE_SOCIAL' ) or define('HMHFBE_SHORTCODE_SOCIAL', 'bbfb_social') ;

// PREFIX
defined( 'HMHFBE_PREFIX' ) or define('HMHFBE_PREFIX', 'bb_fb_') ;

//SLUG
defined( 'HMHFBE_PAGESLUG' ) or define('HMHFBE_PAGESLUG', 'bb_footer_builder') ;

defined( 'HMHFBE_DEFAULT_FOOTER' ) or define('HMHFBE_DEFAULT_FOOTER', 'bbfb_default_footer') ;
defined( 'HMHFBE_POST_TYPES' ) or define('HMHFBE_POST_TYPES', 'bbfb_post_types') ;

defined( 'HMHFBE_FOOTER_POSTTYPE' ) or define('HMHFBE_FOOTER_POSTTYPE', 'bbfb_content') ;

defined( 'HMHFBE_METABOX_FOOTER' ) or define('HMHFBE_METABOX_FOOTER', '_bb_footer') ;
defined( 'HMHFBE_METABOX_MAX_WIDTH' ) or define('HMHFBE_METABOX_MAX_WIDTH', '_bb_footer_max_width') ;


/**
 * HMHFBE_FOOTER_BUILDER_CLASS Class
 *
 * @since	1.0
 */
class HMHFBE_FOOTER_BUILDER_CLASS {
	
	/**
	 * Constructor
	 *
	 * @return	void
	 * @since	1.0
	 */
	function __construct() {
		// Load core
		if(!class_exists('BESTBUG_CORE_CLASS')) {
			include_once 'bestbugcore/index.php';
		}
			
		BESTBUG_CORE_CLASS::support('vc-params');
		BESTBUG_CORE_CLASS::support('options');
		
		if(is_admin()) {
			include_once 'includes/admin/index.php';
		}
		BESTBUG_CORE_CLASS::support('posttypes');
		include_once 'includes/index.php';
		include_once 'includes/shortcodes/index.php';
		
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		// Load enqueueScripts
		if(is_admin()) {
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
		
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links') );
	}

	public function adminEnqueueScripts() {
		BESTBUG_CORE_CLASS::adminEnqueueScripts();
		wp_enqueue_style( 'bbfb', HMHFBE_URL . '/assets/admin/css/admin.css', array(), HMHFBE_DESIGNER_VERSION  );
	}

	public function enqueueScripts() {
		BESTBUG_CORE_CLASS::enqueueScripts();
		
		wp_enqueue_style( 'bbfb', HMHFBE_URL . '/assets/css/bbfb.css', array(), HMHFBE_DESIGNER_VERSION );
		wp_enqueue_script( 'bbfb-builder', HMHFBE_URL . '/assets/js/script.js', array( 'jquery' ), HMHFBE_DESIGNER_VERSION, true );

		$footer_name = '';

		if (bb_option(HMHFBE_PREFIX . 'display_by_fsettings') != '' && bb_option(HMHFBE_PREFIX . 'display_by_fsettings') == 'yes') {
			$footer_name = HMHFBE_FILTER::get_footer_by_own_settings();
		} else {
			$footer_name = HMHFBE_FILTER::get_footer_by_global_settings();
		}

		if(!$footer_name) {
			return;
		}

		$footer = get_page_by_path( $footer_name, OBJECT, HMHFBE_FOOTER_POSTTYPE );

		if(!$footer) {
			return;
		}
		if(function_exists('icl_object_id')) {
			$post_id = HMHFBE_HELPER::ml_get_the_content($footer->ID);
			$footer_tmp = new WP_Query( array( 'post_type' => HMHFBE_FOOTER_POSTTYPE, 'p' => $post_id ) );
			if(isset($footer_tmp->posts[0])) {
				$footer = $footer_tmp->posts[0];
			}
		}

		$custom_css = get_post_meta( $footer->ID , '_wpb_shortcodes_custom_css', true );

		$selector = '#bb-footer-inside-' . $footer_name;
		$maxWidth = get_post_meta( $footer->ID , HMHFBE_METABOX_MAX_WIDTH, true );

		if(!$maxWidth) {
			$selector = '.bb-footer-inside';
			$maxWidth = bb_option(HMHFBE_PREFIX . 'max_width');
		}
		if($maxWidth) {
			if(is_numeric($maxWidth)) {
				if($maxWidth <= 100) {
					$maxWidth .= '%';
				} else {
					$maxWidth .= 'px';
				}
				$custom_css .= $selector . ' { max-width: ' . $maxWidth . '; }';

			} else {
				$custom_css .= $selector . ' { max-width: ' . $maxWidth . '; }';
			}
		}

		wp_add_inline_style( 'bbfb', $custom_css );
	}
	
	public function loadTextDomain() {
		load_plugin_textdomain( HMHFBE_TEXTDOMAIN, false, HMHFBE_PATH . '/languages/' );
	}
	
	public function add_action_links ( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'admin.php?page=bb_footer_builder' ) . '">Settings</a>',
		);
		return array_merge( $mylinks, $links );
	}
}
new HMHFBE_FOOTER_BUILDER_CLASS();
