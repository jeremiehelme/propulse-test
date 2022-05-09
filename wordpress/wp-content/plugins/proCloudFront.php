<?php
/**
 * Created by PhpStorm.
 * User: ctalpaert
 * Date: 03.10.18
 * Time: 10:42
 */

/*
Plugin Name: Pro Cloud Front
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This plugin contains some specific features for AWS CloudFront
Author: Cédric Talpaert
Version: 1.0
Author URI: https://www.propulse-lab.com
*/

function richedit_wp_cloudfront () {
    add_filter('user_can_richedit','__return_true');
}

add_action( 'init', 'richedit_wp_cloudfront', 9 );