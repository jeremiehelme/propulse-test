<?php //Get only the approved comments
$args = array(
  'status' => 'approve',
  'number' => 10,
  'no_found_rows' => true,
  'order' => 'DESC',
  'order_by' => 'date',
  'post_id' => get_the_id(),
);

// The comment Query
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query($args);

// Comment Loop
if ($comments) {
  foreach ($comments as $comment) { ?>
    <div class='comment flex flex-col mt-5'>
      <div class='flex flex-col lg:flex-row justify-between'>
        <div class='comment-author mt-2.5 lg:mt-0'><?= $comment->comment_author; ?></div>
        <div class='comment-date mt-2.5 lg:mt-0'><?= wp_date(get_option('date_format'), strtotime($comment->comment_date)); ?></div>
      </div>
      <div class='comment-text mt-5'><?= $comment->comment_content; ?></div>
    </div>
  <?php }
} else { ?>
  <div class='mt-5'><?= __('Pas de commentaires', 'domainreference'); ?></div>
<?php
}

$args = array(
  'comment_field' => '<p class="comment-form-comment w-full"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="w-full"></textarea></p>',
  'label_submit' => __('Envoyer'),
  'fields' => apply_filters(
    'comment_form_default_fields',
    array(),
  ),
  'logged_in_as' => ''
);
?>
<div class='mt-5'>
  <?php comment_form($args); ?>
</div>