<?php

/**
 * Template name: Accueil
 */


if (!defined('ABSPATH')) exit;

get_header();

if ($current_user && isset($current_user->ID)) {
	wp_set_current_user($current_user->ID);
}


$fields = get_fields();
$image = "";
if (checkArray($fields, 'image_principale') && checkArray($fields['image_principale'], 'sizes')) {
	$imageUrl = $fields['image_principale']['sizes']['1536x1536'];
}
$titre = get_the_title();
if (checkArray($fields, 'titre')) {
	$titre = $fields['titre'];
}

$premiumsList = get_premiums(array('posts_per_page' => 3, 'no_found_rows' => true));
print_r(count($premiumsList->posts));
$premiumsList = $premiumsList->posts;
// $nextPremium = array_shift($premiumsList);
// $favoris = $nextPremium;

$faq = get_random_faq();

?>
<div class=''>
	<?php include(locate_template('/components/offre.php')); ?>
</div>
<div class='max-site-width mx-auto px-5 mb-5 lg:mb-10 lg:px-0'>


	<?php if (!empty($imageUrl)) : ?>
		<div class='w-full'>
			<img src='<?= $imageUrl; ?>' alt='' />
		</div>
	<?php endif; ?>

	<div class='max-content-width mx-auto'>
		<?php if (!empty($titre)) : ?>
			<div class='title title-1 w-full mt-5 lg:mt-10'>
				<?= $titre; ?>
			</div>
		<?php endif; ?>

		<div class='text w-full mt-2.5 lg:mt-5'>
			<?php the_content(); ?>
		</div>



		<!-- Prochains contenus 

		<?php include(locate_template('/components/nextpremium.php')); ?>

		-->

		<!-- Contenu récent : -->

		<?php include(locate_template('/components/related.php')); ?>


		<!-- favoris 

		<?php include(locate_template('/components/favorite.php')); ?>
		
		-->


		<!-- faq -->
		<?php if ($faq) : ?>
			<div class='w-full mt-10 lg:mt-20'>
				<div class='title title-2 '>
					<?= __('Vous avez une question ?'); ?>
				</div>
				<div class='text bold mt-3.5 lg:mt-5'>
					<?= $faq->post_title; ?>
				</div>
				<div class='text mt-2.5'>
					<?= $faq->post_content; ?>
				</div>

				<div class='mt-3.5 lg:mt-5'>
					<a href='<?= home_url('faq'); ?>'><?= __('Une autre question ?'); ?></a>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>
<?php get_footer(); ?>