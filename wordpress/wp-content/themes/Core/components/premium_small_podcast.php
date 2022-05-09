<div class='thumbnail' class='w-full h-full'>
  <?php
  $thumbnail = get_premium_thumbnail($premium);
  if (isset($thumbnail) && is_array($thumbnail)) :
  ?>
    <picture class="w-full h-full">
      <source srcset="<?= $thumbnail['sizeMax']; ?>" media="(min-width: 1024px)" />
      <source srcset="<?= $thumbnail['sizeLarge']; ?>" media="(min-width: 768px)" />
      <img src="<?= $thumbnail['sizeNormal']; ?>" alt='' class="w-full h-full" />
    </picture>
  <?php endif; ?>
  <div class='btn'><?php include(locate_template('/assets/icons/icon-podcast.svg')); ?></div>
</div>

<div class='premium-title'><?= $premium->post_title; ?></div>
<?php unset($thumbnail); ?>