<?php $premium = $favoris; ?>
<div class='title title-2 w-full mt-10 lg:mt-20'>
  <?= __('Mes favoris'); ?>
</div>
<div class='mt-5'>
  <?php include(locate_template('/components/premium_small.php')); ?>
</div>
<div class='mt-2.5 lg:mt-5'>
  <a href='<?= home_url('favoris'); ?>'><?= __('Voir tout'); ?></a>
</div>