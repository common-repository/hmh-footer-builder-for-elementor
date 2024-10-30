<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class ElFooter_Builder_Empty_Space extends Widget_Base
{

    public function get_name()
    {
        return 'el_elfooter_builder_empty_space';
    }

    public function get_title()
    {
        return esc_html__('Empty Space', 'hmh-footer-builder-for-elementor');
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
            'height',
            [
                'label' => esc_html__('Height', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Enter empty space height (Note: CSS measurement units allowed).', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => esc_html__('Width', 'hmh-footer-builder-for-elementor'),
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
        if (isset($settings['height']) && !empty($settings['height'])) {
            echo $settings['height'] . $settings['width'];
        }
    }

    protected function content_template()
    {
        ?>
        <?php

    }
}

Plugin::instance()->widgets_manager->register_widget_type(new ElFooter_Builder_Empty_Space());