<?php
if (!defined('ABSPATH')) exit;
get_header();

if ($current_user && isset($current_user->ID)) {
	wp_set_current_user($current_user->ID);
}

$imageUrl = get_the_post_thumbnail_url();
?>
<div>
	<?php include(locate_template('/components/offre.php')); ?>
</div>
<div class='max-site-width mx-auto px-5 mb-5 lg:mb-10 lg:px-0'>


	<?php if (!empty($imageUrl)) : ?>
		<div class='w-full'>
			<img src='<?= $imageUrl; ?>' alt='' />
		</div>
	<?php endif; ?>

	<div class='max-content-width mx-auto'>

		<div class='title title-1 w-full mt-5 lg:mt-10'>
			<?php the_title(); ?>
		</div>


		<div class='text w-full mt-2.5 lg:mt-5 article-content'>
			<?php the_content(); ?>
		</div>

	</div>
</div>
<?php get_footer(); ?>