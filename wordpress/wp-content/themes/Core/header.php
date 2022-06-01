<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= the_title() ?></title>

  <!-- Fav icon -- from ACF options -->
  <link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/favicon.png" />

  <?php wp_head(); ?>

</head>

<?php
$logo = get_field('logo', 'option');
$logo_url = wp_get_attachment_url($logo);
if (!$logo_url && isset($logo['url'])) {
  $logo_url = $logo['url'];
}

$logo = $logo_url;

$couleurFond =
  get_field('couleur_fond', 'option');
$couleurTitres =
  get_field('couleur_titres', 'option');
$couleurBoutons =
  get_field('couleur_boutons', 'option');

$police =
  get_field('selection_police', 'option');



$fontSize =
  get_field('text_font_size', 'option') . "px";
$lineHeight =
  (intval(get_field('text_font_size', 'option')) + 5) . "px";

$style = [];
if (checkArray($police, 'font')) {
  $police = $police['font'];
  $style[] = "--font: $police;";
}
if (!empty($fontSize)) {
  $style[] = "--font-size: $fontSize;";
  $style[] = "--line-height: $lineHeight;";
}

if (!empty($couleurFond)) {
  $style[] = "--background-color: $couleurFond;";
}
if (!empty($couleurTitres)) {
  $style[] = "--secondary-color: $couleurTitres;";
}
if (!empty($couleurBoutons)) {
  $style[] = "--button-color: $couleurBoutons;";
}

$isHomeDisconnected = is_page_template('template-accueil-non-connecte.php');
?>

<body class="page-template" style='<?= implode(' ', $style); ?>'>

  <header class='w-full px-5 xl:px-0 py-2.5 lg:py-5  sticky '>
    <div class='max-site-width mx-auto'>
      <div class=' flex flex-row items-center <?= $isHomeDisconnected ? 'justify-center' : 'justify-between'; ?>'>
        <a href='<?= home_url('/'); ?>' id='logo'><img src='<?= $logo; ?>' alt='' /></a>
        <?php if (!$isHomeDisconnected) :  ?>
          <div id="menu" class='h-full hidden lg:block'>
            <nav id="site-navigation" class="main-navigation">
              <?php
              wp_nav_menu(array(
                'theme_location' => 'primary',
              ));
              ?>
            </nav>
          </div>
          <div id='icon-menu-mobile' class='h-full block lg:hidden'>
            <?php include(locate_template('/assets/icons/icon-menu-mobile.svg')); ?>
            <?php include(locate_template('/assets/icons/icon-close.svg')); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class='menu-mobile-container'></div>
    </div>
  </header>

  <div id='site-content' class="mt-5">