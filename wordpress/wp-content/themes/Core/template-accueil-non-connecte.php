<?php

/**
 * Template name: Accueil non connecté
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
$titre = '';
if (checkArray($fields, 'titre')) {
	$titre = $fields['titre'];
}
$ps = '';
if (checkArray($fields, 'ps')) {
	$ps = $fields['ps'];
}
$meg = '';
if (checkArray($fields, 'mise_en_garde')) {
	$meg = $fields['mise_en_garde'];
}


?>
<div class='mb-10 max-site-width mx-auto px-5 mb-5 lg:mb-10 lg:px-0'>

	<?php if (!empty($imageUrl)) : ?>
		<div class='w-full'>
			<img src='<?= $imageUrl; ?>' alt='' />
		</div>
	<?php endif; ?>

	<div class='max-content-width mx-auto mt-5 lg:mt-10'>
		<?php if (!empty($titre)) : ?>
			<div class='title title-1 w-full '>
				<?= $titre; ?>
			</div>
		<?php endif; ?>

		<div class='text w-full mt-2.5 lg:mt-5'>
			<?= the_content(); ?>
		</div>


		<?php if (!empty($ps)) : ?>
			<div class='line w-full my-5 lg:my-10'></div>
			<div class='text w-full italic'>
				<?= $ps; ?>
			</div>
			<div class='line w-full my-5 lg:my-10'></div>
		<?php endif; ?>

		<?php if (!empty($meg)) : ?>
			<div class='text w-full mt-5 lg:mt-10 color-secondary'>
				<p class='color-secondary'>Mises en garde</p>
				<?= $meg; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer(); ?>