<div class='filterslist p-10 lg:pt-0'>
  <div class='flex flex-row justify-between lg:hidden'>
    <div class='bold'>Filtres</div>
    <div class='close'><?php include(locate_template('/assets/icons/icon-close.svg')); ?></div>
  </div>
  <div class='line w-full mt-5 lg:mt-10 mb-2.5 lg:mb-5 lg:hidden'></div>
  <!-- <div class='type favorites flex flex-row justify-between mt-5 lg:mt-10 bold' data-type='favorite' data-value='favorites'>
    Mes favoris
    <div class="checkbox-div">
      <input type="checkbox" value="1" id="checkbox-fav-1" />
      <label for="checkbox-fav-1"></label>
    </div>
  </div>
  <div class='line w-full'></div>
  -->
  <?php if ($terms) : ?>
    <div class='type bold mb-5 mt-5 lg:mt-10'>Catégories</div>
    <?php
    $catSelected = [];
    if (is_array($params['tax_query'])) {
      foreach ($params['tax_query'] as $tax) {
        $catSelected[] = $tax['terms'];
      }
    }
    foreach ($terms as $i => $term) :
      $selected = in_array($term->term_id, $catSelected) ? 'checked' : '';
    ?>
      <div class='category flex flex-row justify-between item mt-5 lg:mt-5' data-type='category' data-value='<?= $term->term_id; ?>'>
        <div class='mr-2.5'><?= $term->name; ?></div>
        <div class="checkbox-div">
          <input type="checkbox" value="1" id="checkbox-cat-<?= $i; ?>" <?= $selected; ?> />
          <label for="checkbox-cat-<?= $i; ?>"></label>
        </div>
      </div>
    <?php
    endforeach;
    ?>
    <div class=' line w-full mt-5 lg:mt-10 mb-5 lg:mb-10'></div>
  <?php endif; ?>

  <?php if ($tags) : ?>
    <div class='type bold mb-5 mt-5 lg:mt-10'>Etiquettes</div>
    <?php
    $tagsSelected = [];
    if (is_array($params['tax_query'])) {
      foreach ($params['tax_query'] as $tax) {
        $tagsSelected[] = $tax['terms'];
      }
    }
    foreach ($tags as $i => $tag) :
      $selected = in_array($tag->term_id, $tagsSelected) ? 'checked' : '';
    ?>
      <div class='tag flex flex-row justify-between item mt-5 lg:mt-5' data-type='tag' data-value='<?= $tag->term_id; ?>'>
        <div class='mr-2.5'><?= $tag->name; ?></div>
        <div class="checkbox-div">
          <input type="checkbox" value="1" id="checkbox-tag-<?= $i; ?>" <?= $selected; ?> />
          <label for="checkbox-tag-<?= $i; ?>"></label>
        </div>
      </div>
    <?php
    endforeach;
    ?>
    <div class=' line w-full mt-5 lg:mt-10 mb-5 lg:mb-10'></div>
  <?php endif; ?>

  <!--<div class='type bold mb-5'>Médias</div>
  <div class='flex flex-row justify-between item mt-5 lg:mt-5' data-type='premiumtype' data-value='PREMIUM_TYPE_VIDEO'>
    <div class='mr-2.5'>Video</div>
    <div class="checkbox-div">
      <input type="checkbox" value="1" id="checkbox-premium-1" />
      <label for="checkbox-premium-1"></label>
    </div>
  </div>
  <div class='flex flex-row justify-between item mt-5 lg:mt-5' data-type='premiumtype' data-value='PREMIUM_TYPE_PODCAST'>
    <div class='mr-2.5'>Podcast</div>
    <div class="checkbox-div">
      <input type="checkbox" value="1" id="checkbox-premium-2" />
      <label for="checkbox-premium-2"></label>
    </div>
  </div>
  <div class='flex flex-row justify-between item mt-5 lg:mt-5' data-type='premiumtype' data-value='PREMIUM_TYPE_CONTENT'>
    <div class='mr-2.5'>Articles</div>
    <div class="checkbox-div">
      <input type="checkbox" value="1" id="checkbox-premium-3" />
      <label for="checkbox-premium-3"></label>
    </div>
  </div>-->
</div>