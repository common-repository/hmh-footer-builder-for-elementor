<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'HMHFBE_SHORTCODE_SOCIAL' ) ) {
	/**
	 * HMHFBE_SHORTCODE_SOCIAL Class
	 *
	 * @since	1.0
	 */
	class HMHFBE_SHORTCODE_SOCIAL {

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
			
			add_shortcode( HMHFBE_SHORTCODE_SOCIAL, array( $this, 'shortcode' ) );
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
			vc_map( array(
		        'name'                      => esc_html__( 'Social', 'hmh-footer-builder-for-elementor' ),
				'description'				=> esc_html__( 'Show list link socials with icon', 'hmh-footer-builder-for-elementor' ),
		        'base'                      => HMHFBE_SHORTCODE_SOCIAL,
		        'category'                  => esc_html( sprintf( esc_html__( 'by %s', 'hmh-footer-builder-for-elementor' ), HMHFBE_DESIGNER_CATEGORY ) ),
				'icon' 						=> 'icon-' . HMHFBE_SHORTCODE_SOCIAL,
		        'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'       => 'param_group',
						'heading'    => esc_html__( 'Socials', 'tm-trio' ),
						'param_name' => 'socials',
						'params'     => array(
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Icon library', 'hmh-footer-builder-for-elementor' ),
								'value'       => array(
									esc_html__( 'Font Awesome', 'hmh-footer-builder-for-elementor' ) => 'fontawesome',
								),
								'param_name'  => 'icon_lib',
								'description' => esc_html__( 'Select icon library.', 'hmh-footer-builder-for-elementor' ),
								'dependency'  => array( 'element' => 'icon_type', 'value' => array( 'custom' ) ),
							),
							array(
									'type'        => 'iconpicker',
									'heading'     => esc_html__( 'Icon', 'hmh-footer-builder-for-elementor' ),
									'param_name'  => 'icon_fontawesome',
									'value'       => 'fa fa-adjust',
									'settings'    => array(
										'emptyIcon'    => false,
										'iconsPerPage' => 4000,
									),
									'dependency'  => array(
										'element' => 'icon_lib',
										'value'   => 'fontawesome',
									),
									'admin_label' => true,
									'description' => esc_html__( 'Select icon from library.', 'hmh-footer-builder-for-elementor' ),
							),
							array(
								'type'        => 'vc_link',
								'heading'     => esc_html__( 'Link', 'hmh-footer-builder-for-elementor' ),
								'param_name'  => 'link',
							),
						)
					),

					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Style', 'hmh-footer-builder-for-elementor' ),
				        'value'       => array(
							'Default' => '',
							esc_html__( 'Inline Normal', 'hmh-footer-builder-for-elementor' ) => 'inline-normal',
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
						'param_name' => 'social_style',
						'value'      => '',
						'use' => array(
							'border',
							'border-radius',
							'padding',
							'margin',
							'font',
							'display',
						),
						'selector' => '#class# li a',
						'group' => esc_html__( 'Social style', 'hmh-footer-builder-for-elementor' ),
					),
					array(
						'type'       => 'bb_responsive',
						'heading'    => esc_html__( 'Hover style', 'hmh-footer-builder-for-elementor' ),
						'param_name' => 'social_style_hover',
						'value'      => '',
						'use' => array(
							'font',
						),
						'selector' => '#class# li a:hover',
						'group' => esc_html__( 'Social style', 'hmh-footer-builder-for-elementor' ),
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
		public function settings($attr = HMHFBE_SHORTCODE_SOCIAL) {
			return HMHFBE_SHORTCODE_SOCIAL;
		}
		
		public function shortcode( $atts ){

			$atts = shortcode_atts( array(
				'socials' => '',
				'style' => '',
				'color' => '',
				'text_align' => '',
				'el_class' => '',
				'css' => '',
				'social_style' => '',
				'social_style_hover' => '',
			), $atts );
			
			$class_array = array('bbfb-social');
			if(isset($atts[ 'el_class' ]) && !empty($atts[ 'el_class' ])) {
				array_push($class_array, $atts[ 'el_class' ]);
			}
			if(isset($atts[ 'css' ]) && !empty($atts[ 'css' ])) {
				array_push($class_array, BESTBUG_HELPER::vc_shortcode_custom_css_class($atts[ 'css' ]));
			}
			if(isset($atts[ 'social_style' ]) && !empty($atts[ 'social_style' ])) {
				array_push($class_array, BESTBUG_HELPER::get_bbcustom_class($atts[ 'social_style' ]));
			}
			if(isset($atts[ 'social_style_hover' ]) && !empty($atts[ 'social_style_hover' ])) {
				array_push($class_array, BESTBUG_HELPER::get_bbcustom_class($atts[ 'social_style_hover' ]));
			}
			$class_string = apply_filters( 'vc_shortcodes_css_class', implode(' ', $class_array), HMHFBE_SHORTCODE_SOCIAL, $atts );

			extract( $atts );

			$socials = (array) vc_param_group_parse_atts( $socials );

			if(count($socials) <= 0) {
				return;
			}

			$html = '<ul class="'.esc_attr($class_string).' bbfb-social-'.esc_attr( $style ).' bbfb-social-'.esc_attr( $color ).' '.esc_attr( $el_class ).' '.esc_attr( $text_align ).'">';

			foreach ( $socials as $social ) {
				// Get icon
				$icon_class = isset( $social[ 'icon_' . $social['icon_lib'] ] ) ? esc_attr( $social[ 'icon_' . $social['icon_lib'] ] ) : 'icon-default';
				vc_icon_element_fonts_enqueue( $social['icon_lib'] );
				// Get link
				$link_html   = '';
				$link        = vc_build_link( $social['link'] );
				$link_url    = ( isset( $link['url'] ) && ( $link['url'] != '' ) ) ? $link['url'] : '#';
				$link_text   = ( isset( $link['title'] ) && ( $link['title'] != '' ) ) ? $link['title'] : esc_html__( 'Click Me', 'tm-trio' );
				$link_target = ( isset( $link['target'] ) && ( $link['target'] != '' ) ) ? $link['target'] : '_self';
				$link_rel    = ( isset( $link['rel'] ) && ( $link['rel'] != '' ) ) ? $link['rel'] : 'nofollow';

				$html .= '<li class="bbfb-social-item"><a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $link_text ) . '" target="' . esc_attr( $link_target ) . '" rel="' . esc_attr( $link_rel ) . '"><i class="' . esc_attr( $icon_class ) . '"></i></a></li>';
			}

			$html .= '</ul>';

			return $html;
		}
        
    }
	
	new HMHFBE_SHORTCODE_SOCIAL();
}

