<?php

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package sparkling
 */
if (!defined('ABSPATH')) exit;

get_header();

if ($current_user && isset($current_user->ID)) {
	wp_set_current_user($current_user->ID);
}

?>

<div class='mb-10'>
	<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post();
			echo the_content();
		endwhile;
	endif; ?>

</div>
<?php get_footer(); ?>