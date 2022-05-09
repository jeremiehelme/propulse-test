<?php
if ($premium instanceof WP_Post) :
  $pFields = get_fields($premium->ID);
  $premiumType = '';
  if (isset($pFields['type_premium'])) {
    $premiumType = get_premium_type($pFields['type_premium'], $premium->ID);
  }
  $class = get_class_for_premium_type($premiumType);
?>
  <a href='<?= get_permalink($premium) ?>' class="premium-small premium-<?= $class; ?>">
    <?php
    switch ($premiumType) {
      case PREMIUM_TYPE_PODCAST:
        include(locate_template('/components/premium_small_podcast.php'));
        break;
      case PREMIUM_TYPE_VIDEO:
        include(locate_template('/components/premium_small_video.php'));
        break;
      case PREMIUM_TYPE_CONTENT:
        include(locate_template('/components/premium_small_content.php'));
        break;
      default:
        include(locate_template('/components/premium_small_content.php'));
        break;
    } ?>
  </a>
<?php endif; ?>