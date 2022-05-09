<?php

$params = [
  'order_by' => 'date',
  'order' => 'DESC',
  'paged' => 1,
  'posts_per_page' => 9
];

$term =
  $wp_query->get_queried_object();

if (!empty($term) && $term instanceof WP_Term) {
  $params['tax_query'] = array(
    array(
      'taxonomy' => 'category',
      'field' => 'term_id',
      'terms' => $term->term_id,
    )
  );
  $categories = $term->term_id;
}

$hideSearchBar = get_field('hide_search_bar', 'option') == 'true';

$premiums = get_premiums($params);
$nbPages = $premiums->max_num_pages;
$foundPosts = $premiums->found_posts;
$premiumsList = $premiums->posts;


$terms = get_terms_for_filter();
$tags =
  get_terms(array(
    'taxonomy' => 'post_tag',
    'hide_empty' => false,
  ));


$reinsurance = [];
$reinsurance['text'] = get_field('text_reinsurance', 'option');
$reinsurance['author'] = get_field('text_author', 'option');

$empty_list_message = get_field('empty_list_message', 'option');
if (empty($empty_list_message)) {
  $empty_list_message = __("Aucun élément correspondant, merci de modifier vos critères de recherche");
}
?>

<script type='text/javascript'>
  let filters = {
    order_by: '<?= $params['order_by']; ?>',
    order: '<?= $params['order']; ?>',
    paged: <?= $params['paged']; ?>,
    posts_per_page: <?= $params['posts_per_page']; ?>,
    max_num_pages: <?= $nbPages; ?>,
    tags: [],
    favorites: false,
    premiumtype: [],
    s: '',
    reinsurance: {
      text: '<?= $reinsurance['text']; ?>',
      author: '<?= $reinsurance['author']; ?>'
    },
    empty_list_message: '<?= $empty_list_message; ?>',
    categories: [<?= $categories; ?>]
  };
</script>

<div id='library' class='max-site-width mx-auto  mb-5 lg:mb-10 '>

  <?php if (!$hideSearchBar) : ?>
    <div class='flex flex-col lg:flex-row w-full h-auto lg:items-center justify-between max-content-width mx-auto'>

      <div class='px-5 lg:px-0 lg:mr-5 w-full flex-grow max-content-width'>
        <input id='search' type='text' class='search w-full' placeholder="Rechercher" />
      </div>
      <div class="relative flex-grow w-full mt-2.5 px-5 lg:px-0 lg:mt-0 lg:mr-5">
        <button class='btn-filters flex flex-row justify-between items-center w-full'>Filtres<?php include(locate_template('/assets/icons/icon-filters.svg')); ?></button>
        <?php include(locate_template('/components/filters_list.php')); ?>
      </div>

      <div class='orderlist mt-5 lg:mt-0'>
        <div class='order-label px-5 lg:px-0'>Trier par</div>
        <div class='orders w-full mt-2.5 lg:mt-0'>
          <div class='order' data-order='DESC' data-orderby='date'>
            Le plus récent
          </div>
          <div class='order' data-order='ASC' data-orderby='date'>
            Le moins récent
          </div>
          <!--
					<div class='order' data-order='DESC' data-orderby='view'>
						Le plus de vues
					</div>
					-->
        </div>
      </div>
    </div>
  <?php endif; ?>
  <div class='max-content-width mx-auto px-5 lg:px-0'>

    <div class='results-label mt-10 lg:mt-10 bold'><span id='results-count'><?= $foundPosts; ?></span> résultats</div>


    <?php if ($premiumsList) : ?>
      <div id='results-list' class='mt-5'>
        <?php include(locate_template('/components/premium_list.php')); ?>
      </div>
      <div id='pagination' class='mt-10 lg:mt-20 mx-auto <?= $nbPages <= 1 ? 'hidden' : 'block'; ?>'>
        <div class='flex flex-row justify-between'>
          <div class='btn-prev'><?php include(locate_template('/assets/icons/icon-prev.svg')); ?></div>
          <div class='current'>1/<?= $nbPages; ?></div>
          <div class='btn-next'><?php include(locate_template('/assets/icons/icon-next.svg')); ?></div>
        </div>


      <?php endif; ?>

      </div>
  </div>