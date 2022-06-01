<?php

/**
 * The Template for displaying all single posts.
 *
 * @package sparkling
 */

if ($current_user && isset($current_user->ID)) {
  wp_set_current_user($current_user->ID);
}
get_header();

if (isset($_GET['ppl'])) {
  var_dump(getallheaders());
}

while (have_posts()) : the_post();

  $premiumType = get_premium_type(get_field('type_premium', get_the_ID()), get_the_ID());

  $pdf = get_pdfs();
  $label_pdf = !empty(get_field('label_bouton_pdf')) ? get_field('label_bouton_pdf') : __("Télécharger le livret", "propulse");
  $files = get_files();


  $premiumArgs = [
    'post__not_in' => [get_the_ID()],
    'posts_per_page' => 3,
    'no_found_rows' => true
  ];

  $idCats = array_column(get_the_category(), 'term_id');
  if (!empty($idCats)) {
    $premiumArgs['tax_query'] = array(
      array(
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $idCats,
      )
    );
  }

  $premiumsList = get_premiums($premiumArgs);
  $premiumsList = $premiumsList->posts;
  // $nextPremium = array_shift($premiumsList);

  if ($premiumType == PREMIUM_TYPE_VIDEO) {
    $video_type = get_video_type(get_field('video_type'));
    $podcastLinked = get_field('podcast_linked');
  }

  if ($premiumType == PREMIUM_TYPE_PODCAST) {
    $videoLinked = get_field('video_linked');
  }
?>
  <div class=' max-site-width mx-auto px-5 lg:px-0'>
    <article id="post-<?php echo the_id(); ?>" class="post-<?php echo the_id(); ?> video type-video status-publish has-post-thumbnail hentry category-videos">

      <!-- bloc video -->
      <?php if ($premiumType == PREMIUM_TYPE_VIDEO) : ?>
        <div class="video-iframe">
          <?php
          include(locate_template("/components/player-$video_type.php"));
          ?>
        </div>
      <?php endif; ?>

      <!-- bloc podcast -->
      <?php if ($premiumType == PREMIUM_TYPE_PODCAST) : ?>
        <div>
          <div class="podcast-iframe">
            <?php
            include(locate_template("/components/player-podcast.php"));
            ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- écouter podcast -->
      <?php if (isset($podcastLinked)) : ?>
        <div class='mt-10 lg:mt-20'>
          <a href='<?= get_permalink($podcastLinked[0]); ?>'><?php _e('Ecouter le podcast de cette vidéo'); ?></a>
        </div>
      <?php endif; ?>

      <!-- voir la vidéo associée -->
      <?php if (isset($videoLinked)) : ?>
        <div class='mt-10 lg:mt-20'>
          <a href='<?= get_permalink($videoLinked[0]); ?>'><?php _e('Voir la vidéo de ce podcast'); ?></a>
        </div>
      <?php endif; ?>



      <div class='mt-10 lg:mt-20'>

        <!-- Titre -->
        <div class="w-full flex gap-x-5 items-center">
          <h1 class="title title-1"><?php echo the_title(); ?></h1>
          <!-- bouton ajout aux favoris -->
          <!-- <img src='<?php bloginfo('template_directory'); ?>/assets/icons/icon-favorite.svg' alt=' ajouter aux favoris' /> -->
        </div>


        <!-- Content -->
        <div class="w-full text mt-5">
          <?php the_content(); ?>
        </div>

        <!-- Voir les commentaires -->
        <?php if (comments_open(get_the_id())) : ?>
          <div class="mt-10 lg:mt-20 text">
            <a href="#comments">
              <?php _e("Voir les commentaires", "propulse"); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <!-- Fichiers -->
      <?php if (!empty($pdf) || !empty($files)) : ?>
        <div class="mt-10 lg:mt-20">
          <div class='title-2'><?php _e("Téléchargements", "propulse"); ?></div>
          <div class='list mt-4 flex flex-col lg:flex-row items-start justify-start gap-x-4 gap-y-4'>

            <?php if (!empty($pdf)) : ?>
              <button>
                <a href='<?php echo $pdf; ?>' target='_blank'><?= $label_pdf; ?><?php include(locate_template('/assets/icons/icon-pdf.svg')); ?></a>
              </button>
            <?php endif; ?>

            <?php if (!empty($files)) : ?>
              <?php foreach ($files as $file) :
                $label_pdf = !empty($file['label_bouton_pdf']) ? $file['label_bouton_pdf'] : __("Télécharger le livret", "propulse");
              ?>
                <button>
                  <a href='<?php echo $file['pdf']['url']; ?>' target='_blank'><?= $label_pdf; ?><?php include(locate_template('/assets/icons/icon-pdf.svg')); ?></a>
                </button>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>


      <!-- Prochains contenus 
      <?php include(locate_template('/components/nextpremium.php')); ?>

      -->

      <!-- Contenu récent : -->

      <?php include(locate_template('/components/related.php')); ?>


      <!-- Commentaires -->
      <?php if (comments_open(get_the_id())) : ?>
        <div id='comments' class="mt-10 lg:mt-20">
          <div class='title-2'><?php _e("Commentaires", "propulse"); ?></div>
          <?php comments_template(); ?>
        </div>
      <?php endif; ?>

      <!-- Mentions -->
      <?php
      $mentions = get_field('mentions_pages_premium', 'option');
      if ($mentions) :
      ?>
        <div class='line mt-10 lg:mt-20'></div>
        <div class="mt-10 text">
          <?php
          echo $mentions;
          ?>
        </div>
      <?php endif; ?>

      <!-- Probleme -->
      <?php
      if (get_category_by_slug('probleme-technique') instanceof WP_Term) : ?>
        <div class='line mt-10 '></div>
        <div class="lg:col-start-2 mt-10 text">
          <a href="<?= home_url('category/probleme-technique'); ?>">
            <?php _e("Vous avez un problème technique ?", "propulse"); ?>
          </a>
        </div>
      <?php endif; ?>
    </article>
  </div>

<?php endwhile;

get_footer(); ?>