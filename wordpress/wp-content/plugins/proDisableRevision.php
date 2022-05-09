<?php
/*
Plugin Name: Propulse - Disable Revision
Plugin URI: http://wordpress.org/plugins/
Description: This plugin disable revisions and autosave
Author: Stephane Dupuis
Version: 1.0
Author URI: https://www.domain.tld
*/

/**
 * wp_revisions_to_keep and specific post_types set to 0
 */
add_filter('wp_revisions_to_keep', '__return_zero');
add_filter('wp_page_revisions_to_keep', '__return_zero');
add_filter('wp_post_revisions_to_keep', '__return_zero');
add_filter('wp_pagepremium_revisions_to_keep', '__return_zero');

/**
 * Disable auto save script
 */
add_action('admin_init', 'disable_autosave');
function disable_autosave() {
    wp_deregister_script( 'autosave' );
}

/**
 * Disable revisions by post type
 */
add_action('init', 'disable_revisions');
function disable_revisions() {
    remove_post_type_support('post', 'revisions');
    remove_post_type_support('page', 'revisions');
    remove_post_type_support('pagepremium', 'revisions');
}