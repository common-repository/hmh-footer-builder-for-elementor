<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'HMHFBE_SHORTCODE_MENU' ) ) {
	/**
	 * HMHFBE_SHORTCODE_MENU Class
	 *
	 * @since	1.0
	 */
	class HMHFBE_SHORTCODE_MENU {

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		public function init() {
			
			add_shortcode( HMHFBE_SHORTCODE_MENU, array( $this, 'shortcode' ) );
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->vc_shortcode();
			}

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
			// wp_enqueue_style( 'css', BESTBUG_RPPRO_URL . '/assets/admin/css/style.css' );
			// wp_enqueue_script( 'js', BESTBUG_RPPRO_URL . '/assets/admin/js/script.js', array( 'jquery' ), '1.0', true );
		}

		public function enqueueScripts() {
			// wp_enqueue_style( 'css', BESTBUG_RPPRO_URL . '/assets/css/style.css' );
			// wp_enqueue_script( 'js', BESTBUG_RPPRO_URL . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
		}
        
		public function vc_shortcode() {
			$style = esc_html__('Style', 'hmh-footer-builder-for-elementor');
			vc_map( array(
		        'name'                      => esc_html__( 'Menus', 'hmh-footer-builder-for-elementor' ),
				'description'				=> esc_html__( 'Show menu of wordpress', 'hmh-footer-builder-for-elementor' ),
		        'base'                      => HMHFBE_SHORTCODE_MENU,
		        'category'                  => esc_html( sprintf( esc_html__( 'by %s', 'hmh-footer-builder-for-elementor' ), HMHFBE_DESIGNER_CATEGORY ) ),
				'icon' 						=> 'icon-' . HMHFBE_SHORTCODE_MENU,
		        'allowed_container_element' => 'vc_row',
		        'params'                    => array(
					array(
						"type"        => "textfield",
						"class"       => "",
						"heading"     => esc_html__( 'Title', 'hmh-footer-builder-for-elementor' ),
						"param_name"  => "title",
						"value"       => "",
						'admin_label' => true,
					),
					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Choose Menu', 'hmh-footer-builder-for-elementor' ),
				        'value'       => $this->bbfb_get_menu(),
				        'param_name'  => 'menu',
						'admin_label' => true,
						'save_always' => true,
			        ),
					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Menu Style', 'hmh-footer-builder-for-elementor' ),
				        'value'       => array(
							'Default' => '',
							esc_html__( 'Inline Large', 'hmh-footer-builder-for-elementor' ) => 'inline-large',
							esc_html__( 'Inline Normal', 'hmh-footer-builder-for-elementor' ) => 'inline-normal',
							esc_html__( 'Inline Small', 'hmh-footer-builder-for-elementor' ) => 'inline-small',
							esc_html__( 'List Normal', 'hmh-footer-builder-for-elementor' ) => 'list-normal',
						),
				        'param_name'  => 'style',
						'admin_label' => true,
						'save_always' => true,
			        ),
					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Color', 'hmh-footer-builder-for-elementor' ),
				        'value'       => array(
							esc_html__( 'Dark', 'hmh-footer-builder-for-elementor' ) => 'dark',
							esc_html__( 'Light', 'hmh-footer-builder-for-elementor' ) => 'light',
						),
				        'param_name'  => 'color',
						'admin_label' => true,
						'save_always' => true,
			        ),
					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Text align', 'hmh-footer-builder-for-elementor' ),
				        'value'       => array(
							'Default' => '',
							esc_html__( 'Left', 'hmh-footer-builder-for-elementor' ) => 'text-left',
							esc_html__( 'Center', 'hmh-footer-builder-for-elementor' ) => 'text-center',
							esc_html__( 'Right', 'hmh-footer-builder-for-elementor' ) => 'text-right',
						),
				        'param_name'  => 'text_align',
						'admin_label' => true,
						'save_always' => true,
			        ),
					
					array(
						"type"        => "textfield",
						"class"       => "",
						"heading"     => esc_html__( 'Custom Class CSS', 'hmh-footer-builder-for-elementor' ),
						"param_name"  => "el_class",
					),
					
					array(
						'type'       => 'bb_responsive',
						'heading'    => esc_html__( 'Normal', 'hmh-footer-builder-for-elementor' ),
						'param_name' => 'menu_style',
						'value'      => '',
						'use' => array(
							'padding',
							'margin',
							'border',
							'font',
							'display',
						),
						'selector' => '#class# li a',
						'group' => esc_html__( 'Menu Style', 'hmh-footer-builder-for-elementor' ),
					),
					array(
						'type'       => 'bb_responsive',
						'heading'    => esc_html__( 'Hover style', 'hmh-footer-builder-for-elementor' ),
						'param_name' => 'menu_style_hover',
						'value'      => '',
						'use' => array(
							'border',
							'font',
						),
						'selector' => '#class# li a:hover',
						'group' => esc_html__( 'Menu Style', 'hmh-footer-builder-for-elementor' ),
					),
					array(
						'type'       => 'bb_responsive',
						'heading'    => esc_html__( 'Heading style', 'hmh-footer-builder-for-elementor' ),
						'param_name' => 'heading_style',
						'value'      => '',
						'use' => array(
							'padding',
							'margin',
							'border',
							'font',
							'display',
						),
						'selector' => '#class# .bbfb-menu-title',
						'group' => esc_html__( 'Heading style', 'hmh-footer-builder-for-elementor' ),
					),
					
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'CSS', 'hmh-footer-builder-for-elementor' ),
						'param_name' => 'css',
						'group' => esc_html__( 'Design Options', 'hmh-footer-builder-for-elementor' ),
					),
		        ),
		    ) );
        }
		public function settings($attr = HMHFBE_SHORTCODE_MENU) {
			return HMHFBE_SHORTCODE_MENU;
		}
		
		public function bbfb_get_menu() {
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
			// Properly format the array.
			$items = array();
			foreach ( $menus as $menu ) {
				$items[ $menu->name ] = $menu->slug;
			}

			return $items;
		}
		
		public function shortcode( $atts ){

			$atts = shortcode_atts( array(
				'title' => '',
				'menu' => '',
				'style' => '',
				'color' => '',
				'text_align' => '',
				'el_class' => '',
				'css' => '',
				'menu_style' => '',
				'menu_style_hover' => '',
				'heading_style' => '',
			), $atts );

			extract( $atts );

			$nav_menu = wp_get_nav_menu_object( $menu ); // Get menu

			if ( ! $nav_menu ) {
				return;
			}
			
			$class_array = array('bbfb-menu');
			if(isset($atts[ 'el_class' ]) && !empty($atts[ 'el_class' ])) {
				array_push($class_array, $atts[ 'el_class' ]);
			}
			if(isset($text_align) && !empty($text_align)) {
				array_push($class_array, $text_align);
			}
			if(isset($style) && !empty($style)) {
				array_push($class_array, 'bbfb-menu-'.$style);
			}
			if(isset($color) && !empty($color)) {
				array_push($class_array, 'bbfb-menu-'.$color);
			}
			if(isset($css) && !empty($css)) {
				array_push($class_array, BESTBUG_HELPER::vc_shortcode_custom_css_class($css));
			}
			if(isset($menu_style) && !empty($menu_style)) {
				array_push($class_array, BESTBUG_HELPER::get_bbcustom_class($menu_style));
			}
			if(isset($menu_style_hover) && !empty($menu_style_hover)) {
				array_push($class_array, BESTBUG_HELPER::get_bbcustom_class($menu_style_hover));
			}
			if(isset($heading_style) && !empty($heading_style)) {
				array_push($class_array, BESTBUG_HELPER::get_bbcustom_class($heading_style));
			}
			$class_string = apply_filters( 'vc_shortcodes_css_class', implode(' ', $class_array), HMHFBE_SHORTCODE_MENU, $atts );

			$html = '<div class="'.$class_string.'">';
			if ( !empty( $title ) ) :
				$html .= '<h5 class="bbfb-menu-title bbfb-menu-'.esc_attr( $color ).'-title"> '.esc_html($title).' </h5>';
			endif;
			$html .= wp_nav_menu( array( 'menu' => $nav_menu, 'echo' => false ));
			$html .= '</div>';
			
			$html = apply_filters( 'vc_shortcode_output', $html, $this, $atts );
			return $html;
		}
        
    }
	
	new HMHFBE_SHORTCODE_MENU();
}

