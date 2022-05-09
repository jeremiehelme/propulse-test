<?php

$offre =
  get_field('offre_active', 'option');

$offre_titre =
  get_field('offre_titre', 'option');
$offre_label =
  get_field('offre_label', 'option');
$offre_lien =
  get_field('offre_lien', 'option');
if ($offre) : ?>

  <div class='offre flex flex-col items-center lg:flex-row w-full p-2.5 mb-10 lg:mb-0 max-site-width mx-auto grow'>
    <h2 class='h2 w-full'><?= $offre_titre; ?></h2>
    <button class='btn-secondary w-full lg:w-max mt-2.5 lg:mt-0 shrink lg:min-w-[220px] lg:max-w-[50%]'>
      <a class='flex flex-row justify-between items-center lg:w-full' href='<?= $offre_lien; ?>'>
        <div><?= $offre_label; ?></div>
        <div><?php include(locate_template('/assets/icons/icon-next-offer.svg')); ?></div>
      </a>
    </button>
  </div>

<?php endif; ?>