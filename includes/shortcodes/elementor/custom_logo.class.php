<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class ElFooter_Builder_Custom_logo extends Widget_Base
{

    public function get_name()
    {
        return 'el_elfooter_builder_custom_logo';
    }

    public function get_title()
    {
        return esc_html__('Custom Logo', 'hmh-footer-builder-for-elementor');
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
                'label' => esc_html__( 'Title', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => esc_html__( 'Default description', 'hmh-footer-builder-for-elementor' ),
                'placeholder' => esc_html__( 'Type your description here', 'hmh-footer-builder-for-elementor' ),
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
				],
                'dynamic' => ['active' => true]
			]
        );

        $this->add_control(
            'fontFamily',
            [
                'label' => esc_html__( 'font-family', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'  => esc_html__( 'normal', 'hmh-footer-builder-for-elementor' ),
                    'georgia' => esc_html__( 'georgia', 'hmh-footer-builder-for-elementor' ),
                    'palatino-pinotype'  => esc_html__( 'palatino-pinotype', 'hmh-footer-builder-for-elementor' ),
                    'book-antiqua'  => esc_html__( 'book-antiqua', 'hmh-footer-builder-for-elementor' ),
                    'times-new-roman' => esc_html__( 'times-new-roman', 'hmh-footer-builder-for-elementor' ),
                    'arial'  => esc_html__( 'arial', 'hmh-footer-builder-for-elementor' ),
                    'helvetica'  => esc_html__( 'helvetica', 'hmh-footer-builder-for-elementor' ),
                    'arial-black'  => esc_html__( 'arial-black', 'hmh-footer-builder-for-elementor' ),
                    'impact'  => esc_html__( 'impact', 'hmh-footer-builder-for-elementor' ),
                    'lucida-sans-unicode'  => esc_html__( 'lucida-sans-unicode', 'hmh-footer-builder-for-elementor' ),
                    'tahoma'  => esc_html__( 'tahoma', 'hmh-footer-builder-for-elementor' ),
                    'verdana'  => esc_html__( 'verdana', 'hmh-footer-builder-for-elementor' ),
                    'courier-new'  => esc_html__( 'courier-new', 'hmh-footer-builder-for-elementor' ),
                    'lucida-console'  => esc_html__( 'lucida-console', 'hmh-footer-builder-for-elementor' ),
                    'initial'  => esc_html__( 'initial', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'htmlTag',
            [
                'label' => esc_html__( 'HTML tag', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'p',
                'options' => [
                    'p'  => esc_html__( 'p','hmh-footer-builder-for-elementor'),
                    'h1' => esc_html__( 'h1', 'hmh-footer-builder-for-elementor' ),
                    'h2'  => esc_html__( 'h2', 'hmh-footer-builder-for-elementor' ),
                    'h3'  => esc_html__( 'h3', 'hmh-footer-builder-for-elementor' ),
                    'h4' => esc_html__( 'h4', 'hmh-footer-builder-for-elementor' ),
                    'h5'  => esc_html__( 'h5', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'fontStyle',
            [
                'label' => esc_html__( 'Font Style', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'  => esc_html__( 'normal', 'hmh-footer-builder-for-elementor' ),
                    'italic' => esc_html__( 'italic', 'hmh-footer-builder-for-elementor' ),
                    'oblique'  => esc_html__( 'oblique', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'font style', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => esc_html__( 'left', 'hmh-footer-builder-for-elementor' ),
                    'center' => esc_html__( 'center', 'hmh-footer-builder-for-elementor' ),
                    'right'  => esc_html__( 'right', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );

         $this->add_control(
            'fontWidth',
            [
                'label' => esc_html__( 'Font Weight', 'hmh-footer-builder-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'  => esc_html__( 'normal', 'hmh-footer-builder-for-elementor' ),
                    'bold' => esc_html__( 'bold', 'hmh-footer-builder-for-elementor' ),
                    '100'  => esc_html__( '100', 'hmh-footer-builder-for-elementor' ),
                    '200'  => esc_html__( '200', 'hmh-footer-builder-for-elementor' ),
                    '300'  => esc_html__( '300', 'hmh-footer-builder-for-elementor' ),
                    '400'  => esc_html__( '400', 'hmh-footer-builder-for-elementor' ),
                    '500'  => esc_html__( '500', 'hmh-footer-builder-for-elementor' ),
                    '600'  => esc_html__( '600', 'hmh-footer-builder-for-elementor' ),
                    '700'  => esc_html__( '700', 'hmh-footer-builder-for-elementor' ),
                    '800'  => esc_html__( '800', 'hmh-footer-builder-for-elementor' ),
                    '900'  => esc_html__( '900', 'hmh-footer-builder-for-elementor' ),
                ],
                'dynamic' => ['active' => true]
            ]
        );

         $this->add_control(
            'fontSize',
            [
                'label' => esc_html__( 'Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '24px', 'hmh-footer-builder-for-elementor' ),
                'placeholder' => esc_html__( '24px', 'hmh-footer-builder-for-elementor' ),
            ]
        );

        $this->end_controls_section();

    }


    protected function render()
    {
        
        $settings = $this->get_settings_for_display();
        if (isset($settings['title'])) {
            $html = '<div class="custom-logo custom-logo-alignment-'.$settings['alignment'].'" >';

			$html .= '<'.$settings['htmlTag'];

            $html .=' class="custom-logo-color-'.$settings['color'].' custom-logo-fontfamily-'.$settings['fontFamily'].' custom-logo-fontstyle-'.$settings['fontStyle'].' custom-logo-fontwidth-'.$settings['fontWidth'].' "';
            if ($settings['fontSize']) {
                 $html .= ' style="font-size: '.$settings['fontSize'].' ;" >';
            }
            else{
                 $html .= ' style="" >';
            }
           
            $html .= $settings['title'];
            $html .='</'.$settings['htmlTag'].'>';
            $html .= '</div>';
            echo $html;
        }
    }

    protected function content_template()
    {
        ?>
        <?php

    }

}

    
Plugin::instance()->widgets_manager->register_widget_type(new ElFooter_Builder_Custom_logo());