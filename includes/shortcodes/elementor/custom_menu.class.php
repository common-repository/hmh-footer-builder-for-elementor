<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class ElFooter_Builder_Custom_menu extends Widget_Base
{

    public function get_name()
    {
        return 'el_elfooter_builder_custom_menu';
    }

    public function get_title()
    {
        return esc_html__('Custom Menu', 'hmh-footer-builder-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-shortcode';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected $allowed_html = array(
        'strong' => array(
            'style' => array()
        ),
        'span' => array(
            'style' => array()
        ),
        'em' => array(
            'style' => array()
        ),
        'a' => array(
            'href' => array(),
            'style' => array()
        ),
    );

    protected function _register_controls()
    {

		// Content Controls
        $this->start_controls_section(
            'ElFooterBuilder',
            [
                'label' => esc_html__('General', 'hmh-footer-builder-for-elementor')
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Enter empty space height (Note: CSS measurement units allowed).', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );


        $this->add_control(
			'chooseMenu',
			[
				'label' => esc_html__( 'Choose Menu', 'hmh-footer-builder-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->bbfb_get_menu(),
                'dynamic' => ['active' => true]
			]
        );
        
        $this->add_control(
			'style',
			[
				'label' => esc_html__( 'Menu Style', 'hmh-footer-builder-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'list-normal',
				'options' => [
					'inline-large'  => esc_html__( 'inline large', 'hmh-footer-builder-for-elementor' ),
					'inline-normal' => esc_html__( 'inline normal', 'hmh-footer-builder-for-elementor' ),
                    'inline-small'  => esc_html__( 'inline small', 'hmh-footer-builder-for-elementor' ),
                    'list-normal' => esc_html__( 'list normal', 'hmh-footer-builder-for-elementor' ),
				],
                'dynamic' => ['active' => true]
			]
        );
        $this->add_control(
			'color',
			[
				'label' => esc_html__( 'color', 'hmh-footer-builder-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'black',
				'options' => [
					'white'  => esc_html__( 'white', 'hmh-footer-builder-for-elementor' ),
                    'black' => esc_html__( 'black', 'hmh-footer-builder-for-elementor' ),
                    'gray'  => esc_html__( 'gray', 'hmh-footer-builder-for-elementor' ),
                    'light'  => esc_html__( 'light', 'hmh-footer-builder-for-elementor' ),
                    'dark' => esc_html__( 'dark', 'hmh-footer-builder-for-elementor' ),
				],
                'dynamic' => ['active' => true]
			]
        );
         $this->add_control(
            'text_align',
            [
                'label' => esc_html__( 'Text align', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text-left',
                'options' => [
                    'text-left'  => esc_html__( 'Left', 'hmh-footer-builder-for-elementor' ),
                    'text-center' => esc_html__( 'Center', 'hmh-footer-builder-for-elementor' ),
                    'text-right'  => esc_html__( 'Right', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );
        $this->add_control(
            'el_class',
            [
                'label' => esc_html__('Custom Class CSS', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Enter empty space height (Note: CSS measurement units allowed).', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );

        $this->end_controls_section();

    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $allclass = 'custom-menu '.$settings['text_align'].' custom-menu-'.$settings['style'].' custom-menu-'.$settings['color'];
        if (!empty($settings['el_class'])) {
           $allclass .= ' '.$settings['el_class'];
        }

        $nav_menu = wp_get_nav_menu_object($settings['chooseMenu']); // Get menu

        if ( ! $nav_menu ) {
            return;
        }

        if (isset($settings['chooseMenu'])) {
            $html = '<div class="'.$allclass.'">';
			if (  !empty($settings['title']) ) :
				$html .= '<h5 class="custom-menu-title custom-menu-'.esc_attr( $settings['color'] ).'-title"> '.esc_html($settings['title']).' </h5>';
			endif;
            $html .= wp_nav_menu( array( 'menu' => $nav_menu, 'echo' => false ));
            $html .= '</div>';
            echo $html;
        }
    }

    protected function content_template()
    {
        ?>
        <?php

    }

    

    public function bbfb_get_menu() {
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        // Properly format the array.
        $items = array();
        foreach ( $menus as $key => $menu ) {
            $items[$menu->slug] = $menu->name;
        }

        return $items;
    }

}

    
Plugin::instance()->widgets_manager->register_widget_type(new ElFooter_Builder_Custom_menu());