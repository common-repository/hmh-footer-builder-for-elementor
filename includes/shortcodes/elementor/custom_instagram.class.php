<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class ElFooter_Builder_Custom_instagram extends Widget_Base
{

    public function get_name()
    {
        return 'el_elfooter_builder_custom_instagram';
    }

    public function get_title()
    {
        return esc_html__('Custom Instagram', 'hmh-footer-builder-for-elementor');
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
                'placeholder' => esc_html__('Enter Title', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );
        $this->add_control(
            'username',
            [
                'label' => esc_html__('User name', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Enter Your Username', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );
        $this->add_control(
            'number_items',
            [
                'label' => esc_html__('Number items', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Number item you want', 'hmh-footer-builder-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'hmh-footer-builder-for-elementor'),
                'dynamic' => ['active' => true]
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => esc_html__( 'Border Style', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'dark'  => esc_html__( 'Dark', 'hmh-footer-builder-for-elementor' ),
                    'light' => esc_html__( 'Light', 'hmh-footer-builder-for-elementor' ),
                ],
            ]
        );
         $this->add_control(
            'el_class',
            [
                'label' => esc_html__('Custom Css Class', 'hmh-footer-builder-for-elementor'),
                'placeholder' => esc_html__('Your Css class', 'hmh-footer-builder-for-elementor'),
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
        $html='';
        $media_array = $this->scrape_instagram($settings['username'], $settings['number_items']);

        $html .= '<div class="bbfb-instagram '.esc_attr( $settings['el_class'] ).'">';
        if ( !empty( $settings['title'] ) ) :
            $html .= '<h5 class="bbfb-instagram-title bbfb-instagram-'.esc_attr( $settings['color'] ).'-title"> '.esc_html($settings['title']).' </h5>';
        endif;

        $html .= '<div class="bbfb-instagram-row">';
        foreach ( $media_array as $item ) {
            $html .= '<div class="item">';
                $html .= '<a href="' . esc_url( $item['link'] ) . '" target="_blank">';
                //if ( 'on' == $show_likes_comments ) {
                $html .= '<div class="item-info">';
                $html .= '<span class="likes">' . $this->format_number($item['likes']) . '</span>';
                $html .= '<span class="comments">' . $this->format_number($item['comments']) . '</span>';
                $html .= '</div>';
                //}
                $html .= '<img src="' . esc_url( $item['thumbnail'] ) . '" alt="' . esc_html__( 'Instagram', 'tm-trio' ) . '" class="item-image"/>';
                $html .= '</a>';
                $html .= '</div>';
            }
        $html .= '</div>';
        $html .= '</div>';
       echo $html;
    }

    protected function content_template()
    {
        ?>
        <?php

    }
    function scrape_instagram( $username, $number_items ) {

            $username = trim( strtolower( $username ) );

            switch ( substr( $username, 0, 1 ) ) {
                case '#':
                    $url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
                    $transient_prefix = 'h';
                    break;

                default:
                    $url              = 'https://instagram.com/' . str_replace( '@', '', $username );
                    $transient_prefix = 'u';
                    break;
            }

            if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

                $remote = wp_remote_get( $url );

                if ( is_wp_error( $remote ) ) {
                    return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'hmh-footer-builder-for-elementor' ) );
                }

                if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
                    return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'hmh-footer-builder-for-elementor' ) );
                }

                $shards      = explode( 'window._sharedData = ', $remote['body'] );
                $insta_json  = explode( ';</script>', $shards[1] );
                $insta_array = json_decode( $insta_json[0], true );

                if ( ! $insta_array ) {
                    // return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'hmh-footer-builder-for-elementor' ) );
                }

                if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
                    $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
                } elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
                    $images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
                } else {
                    // return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'hmh-footer-builder-for-elementor' ) );
                }

                if ( ! is_array( $images ) ) {
                    // return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'hmh-footer-builder-for-elementor' ) );
                }

                $instagram = array();

                foreach ( $images as $image ) {
                    if ( true === $image['node']['is_video'] ) {
                        $type = 'video';
                    } else {
                        $type = 'image';
                    }

                    $caption = esc_html__( 'Instagram Image', 'hmh-footer-builder-for-elementor' );
                    if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
                        $caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
                    }

                    $instagram[] = array(
                        'description' => $caption,
                        'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
                        'time'        => $image['node']['taken_at_timestamp'],
                        'comments'    => $image['node']['edge_media_to_comment']['count'],
                        'likes'       => $image['node']['edge_liked_by']['count'],
                        'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
                        'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
                        'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
                        'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
                        'type'        => $type,
                    );
                } // End foreach().

                // do not set an empty transient - should help catch private or empty accounts.
                if ( ! empty( $instagram ) ) {
                    $instagram = base64_encode( serialize( $instagram ) );
                    set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
                }
            }

            if ( ! empty( $instagram ) ) {

                $instagram = unserialize( base64_decode( $instagram ) );
                $offset = 0;
                return array_slice( $instagram, $offset, $number_items );;

            } else {

                // return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'hmh-footer-builder-for-elementor' ) );

            }
    }
    
    function format_number( $number ) {
            if ( $number > 999 && $number <= 999999 ) {
                $result = floor( $number / 1000 ) . ' K';
            } elseif ( $number > 999999 ) {
                $result = floor( $number / 1000000 ) . ' M';
            } else {
                $result = $number;
            }

            return $result;
    }

}

    
Plugin::instance()->widgets_manager->register_widget_type(new ElFooter_Builder_Custom_instagram());