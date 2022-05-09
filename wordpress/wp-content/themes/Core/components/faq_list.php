<div class='max-site-width mx-auto px-5 mb-5 lg:mb-10 lg:px-0'>

  <div class='max-site-width mx-auto'>
    <div class='title title-1 w-full mt-5 lg:mt-10 mb-5'>
      <?= __('FAQ'); ?> - <?= $cat->name; ?>
    </div>

    <?php if (have_posts()) : ?>
      <div class='text w-full mt-2.5 lg:mt-5'>
        <?php while (have_posts()) : the_post(); ?>
          <div class='faq_item mb-2.5'>
            <div class='line w-full'></div>
            <div class='faq_title mt-5 mb-2.5 flex flex-row items-center justify-between'><?php the_title(); ?><div class='arrow'><?php include(locate_template('/assets/icons/icon-arrow.svg')); ?></div>
            </div>
            <div class='faq_content'><?php the_content(); ?></div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</div>