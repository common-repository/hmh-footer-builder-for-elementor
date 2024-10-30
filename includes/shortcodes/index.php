<?php
include 'menu.class.php';
include 'social.class.php';
include 'instagram.class.php';

add_action('elementor/widgets/widgets_registered', function () {
    include_once('elementor/index.php');
});
