<?php
/*
Template des catégories spécifiques à la FAQ
*/
$cat = get_category_by_slug('probleme-technique');
get_header();

include(locate_template('/components/faq_list.php'));

get_footer();
