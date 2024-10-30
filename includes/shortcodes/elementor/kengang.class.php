<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class ElFooter_Builder_ke_ngang extends Widget_Base
{

    public function get_name()
    {
        return 'el_elfooter_builder_ke_ngang';
    }

    public function get_title()
    {
        return esc_html__('Đừng Kẻ Ngang', 'hmh-footer-builder-for-elementor');
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

        $this->end_controls_section();

    }


    protected function render()
    {   
        $settings = $this->get_settings_for_display();

        echo "<hr style='color:".$settings['color']."; '>";
    }

    protected function content_template()
    {
        ?>
        <?php

    }

    }
Plugin::instance()->widgets_manager->register_widget_type(new ElFooter_Builder_ke_ngang());
