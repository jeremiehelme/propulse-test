<?php

/**
 * Template name: Librairie
 */

if (!defined('ABSPATH')) exit;
get_header();

if ($current_user && isset($current_user->ID)) {
	wp_set_current_user($current_user->ID);
}

include(locate_template('/components/library.php'));

get_footer();
