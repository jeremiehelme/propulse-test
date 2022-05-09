<?php

/**
 * Template name: faq
 */

if (!defined('ABSPATH')) exit;
get_header();

if ($current_user && isset($current_user->ID)) {
	wp_set_current_user($current_user->ID);
}

$faqList = get_faq_items(4);
?>
<div class='max-site-width mx-auto px-5 mb-5 lg:mb-10 lg:px-0'>

	<div class='max-site-width mx-auto'>
		<div class='title title-1 w-full mt-5 lg:mt-10 mb-5'>
			<?= __('FAQ'); ?>
		</div>


		<div class='text w-full mt-2.5 lg:mt-5'>
			<?php foreach ($faqList as $faq) : ?>
				<div class='faq_item mb-2.5'>
					<div class='line w-full'></div>
					<div class='faq_title mt-5 mb-2.5 flex flex-row items-center justify-between'><?= $faq->post_title; ?><div class='arrow'><?php include(locate_template('/assets/icons/icon-arrow.svg')); ?></div>
					</div>
					<div class='faq_content'><?= $faq->post_content; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>