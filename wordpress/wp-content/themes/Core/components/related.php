	<?php if ($premiumsList && count($premiumsList) > 1 ) : ?>
	  <div class='title title-2 w-full mt-10 lg:mt-20'>
	    <?= __('Contenu récent', "propulse"); ?> :
	  </div>
	  <div class='mt-5 shortlist'>
	    <?php include(locate_template('/components/premium_list.php')); ?>
	  </div>
	  <div class='w-full mt-2.5 lg:mt-5 mb-2.5 lg:mb-5'>
	    <a href='<?= home_url('librairie'); ?>'><?= __('Voir tout'); ?></a>
	  </div>
	<?php endif; ?>