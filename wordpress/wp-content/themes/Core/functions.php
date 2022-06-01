<?php

const PREMIUM_TYPE_VIDEO = "PREMIUM_TYPE_VIDEO";
const PREMIUM_TYPE_PODCAST = "PREMIUM_TYPE_PODCAST";
const PREMIUM_TYPE_CONTENT = "PREMIUM_TYPE_CONTENT";

function add_PagePremium()
{

    //flush_rewrite_rules();

    register_post_type('PagePremium', array(
        'label' => __('Page Premium'),
        'supports' => ['comments', 'title', 'editor'],
        'singular_label' => __('Page Premium'),
        'public' => true,
        'show_ui' => true,
        'taxonomies' => array('category', 'post_tag'),
        'rewrite' => array('slug' => 'etape'),
        'menu_icon' => 'dashicons-format-gallery',  // URL de l'image
        'capability_type' => 'post',
        'hierarchical' => true,
        'show_in_rest' => true,
        'rest_base' => 'premium'
    ));
}

add_action('init', 'add_PagePremium');



function namespace_add_custom_types($query)
{

    if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {

        $query->set('post_type', array('post', 'nav_menu_item', 'video', 'pagepremium'));

        return $query;
    }
}


/* DEFAULT TEMPLATE */




if (!function_exists('sparkling_setup')) :

    /**

     * Sets up theme defaults and registers support for various WordPress features.

     *

     * Note that this function is hooked into the after_setup_theme hook, which

     * runs before the init hook. The init hook is too late for some features, such

     * as indicating support for post thumbnails.

     */

    function sparkling_setup()
    {


        // Add default posts and comments RSS feed links to head.

        add_theme_support('automatic-feed-links');



        /**

         * Enable support for Post Thumbnails on posts and pages.

         *

         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails

         */

        add_theme_support('post-thumbnails');



        add_image_size('sparkling-featured', 750, 410, true);

        add_image_size('tab-small', 60, 60, true); // Small Thumbnail



        // This theme uses wp_nav_menu() in one location.

        register_nav_menus(array(

            'primary'      => esc_html__('Primary Menu', 'sparkling'),

            'footer-links' => esc_html__('Footer Links', 'sparkling') // secondary nav in footer

        ));



        // Enable support for Post Formats.

        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));



        // Setup the WordPress core custom background feature.

        add_theme_support('custom-background', apply_filters('sparkling_custom_background_args', array(

            'default-color' => 'F2F2F2',

            'default-image' => '',

        )));



        // Enable support for HTML5 markup.

        add_theme_support('html5', array(

            'comment-list',

            'search-form',

            'comment-form',

            'gallery',

            'caption',

        ));


        /*

         * Add option page by ACF

         */

        if (
            function_exists('acf_add_options_page')
        ) {

            acf_add_options_page();
        }



        /*

         * Let WordPress manage the document title.

         * By adding theme support, we declare that this theme does not use a

         * hard-coded <title> tag in the document head, and expect WordPress to

         * provide it for us.

         */

        add_theme_support('title-tag');
    }

endif; // sparkling_setup

add_action('after_setup_theme', 'sparkling_setup');


/**
 * Enqueue scripts and styles.
 */
function theme_scripts()
{
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/styles.css');

    wp_enqueue_script('theme-jquery', get_template_directory_uri() . '/assets/js/vendors/jquery-3.6.0.min.js', array(), '20151215', true);
    wp_enqueue_script('theme-modernizr', get_template_directory_uri() . '/assets/js/vendors/modernizr.min.js', array(), '20151215', true);
    /* wp_enqueue_script('theme-skip-link', get_template_directory_uri() . '/assets/js/vendors/skip-link-focus-fix.js', array(), '20151215', true); */
    wp_enqueue_script('theme-library', get_template_directory_uri() . '/assets/js/library.js', array(), '20151215', true);
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/main.js', array(), '20191111', true);
    wp_localize_script('theme-main', 'datas', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'homeurl' => home_url()
    ));
    wp_localize_script('theme-library', 'datas', array(
        'homeurl' => home_url(),
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// Met a jour certains élément si nécéssaire :
// - Assure le bon réglage des anciens premiums en définissant leur type en fonction des champs remplis
// - On ajoute aux articles un champ content_length, contenant la longueur du contenu.  
// Permet de filtrer les articles par longueur de contenu
function update_theme()
{
    //si le thème n'a pas encore été mis a jour et que ACF est activé
    if (class_exists('ACF')) {
        //Articles
        $article_args = array(
            'post_status' => 'publish',
            'posts_per_page'   => -1
        );

        $articles = new WP_Query($article_args);

        if ($articles->have_posts()) {
            while ($articles->have_posts()) {
                $articles->the_post();
                $length = strlen(get_the_content());
                update_post_meta(get_the_ID(), 'content_length', $length);
            }
            wp_reset_postdata();
        }

        //Premiums
        //met a jour le type de chaque premium en fonction des champs remplis
        $premium_args = array(
            'post_type' => 'pagepremium',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $premiums = new WP_Query($premium_args);

        if ($premiums->have_posts()) {
            while ($premiums->have_posts()) {
                $premiums->the_post();
                update_premium_type(get_the_ID());
            }
            wp_reset_postdata();
        }
    }
}



if (isset($_GET['activated']) && is_admin()) {
    update_theme();
}

// On met a jour le champ content_length, contenant la longueur du contenu à la mise à jour de l'article  
function save_article_content_length($post_id)
{
    $length = strlen(get_the_content($post_id));
    update_post_meta($post_id, 'content_length', $length);
}
add_action('save_post', 'save_article_content_length');


function get_random_faq()
{

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'rand',
        'no_found_rows' => true,
        // On exclut les articles dont le contenu fait plus de 1200 caractères, pour ne pas surcharger l'affichage de la home
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'content_length',
                'value'   => 1200,
                'type'       => 'numeric',
                'compare' => '<',
            ),
        ),
    );

    $query =
        new WP_Query($args);

    return $query->posts[0];
}

//retourne une liste de [$count] premiums
function get_premium_items($count = -1, $params = [], $loadACF = false)
{
    $params['posts_per_page'] = $count;
    return get_premiums($params);
}

//Effectue la requete pour récupérer les premiums
function get_premiums($params = [])
{

    if (empty($params)) {
        $params = [
            'order_by' => 'date',
            'order' => 'DESC',
            'no_found_rows' => true
        ];
    }

    $args = array(
        'post_type' => 'pagepremium',
        'post_status' => 'publish',
        'order_by' => 'date',
        'order' => 'DESC',
    );

    $args = array_merge($args, $params);
    return new WP_Query($args);
}


//renvoie la liste des premiums en JSON
//Appelé par library.js via AJAX
function load_premiums_callback()
{
    $params = rest_sanitize_object($_POST['params']);

    $tax_queries = [];
    if (array_key_exists('categories', $params)) {
        $tax_queries[] =
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $params['categories'],
            );
    }

    if (array_key_exists('tags', $params)) {
        $tax_queries[] =
            array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $params['tags'],
            );
    }

    if (!empty($tax_queries)) {
        $params['tax_query'] = array(
            'relation' => 'OR'
        );
        foreach ($tax_queries as $tax) {
            $params['tax_query'][] = $tax;
        }
    }

    if (array_key_exists('premiumtype', $params)) {

        $params['meta_query'] = array(
            array(
                'key'         => 'type_premium',
                'value'          => $params['premiumtype'],
                'compare'     => 'IN',
            ),
        );
    }

    $premiums = get_premiums($params);
    echo json_encode($premiums);
    wp_die();
}

add_action('wp_ajax_load_premiums', 'load_premiums_callback');
add_action('wp_ajax_nopriv_load_premiums', 'load_premiums_callback');


//renvoie le template de premium en fonction des paramètres
//Appelé par library.js via AJAX pour construire les listes de premium
function show_premiums_template_callback()
{
    $params = rest_sanitize_object($_POST['params']);
    $premiumsList = $params['premiums'];

    if (!is_array($premiumsList) || empty($premiumsList)) {
        $emptyListMessage = $params['empty_list_message'];
        include(locate_template('/components/empty_list_message.php'));
        wp_die();
    }


    $reinsurance = $params['reinsurance'];

    foreach ($premiumsList as $i => $premium) {
        if ($reinsurance && checkArray($reinsurance, 'text') && !empty($reinsurance['text']) && ($i != 0 && $i % 3 == 0)) {
            include(locate_template('/components/reinsurance.php'));
        }
        $premium = WP_Post::get_instance($premium['ID']); //the template needs a WP_Post object
        include(locate_template('/components/premium_small.php'));
    }
    if ($reinsurance && checkArray($reinsurance, 'text') && !empty($reinsurance['text']) && (count($premiumsList) % 3 == 0)) {
        include(locate_template('/components/reinsurance.php'));
    }


    wp_die();
}


add_action('wp_ajax_show_premiums_template', 'show_premiums_template_callback');
add_action('wp_ajax_nopriv_show_premiums_template', 'show_premiums_template_callback');



function get_faq_items($count = 999)
{
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'order_by' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $count,
        'no_found_rows' => true
    );
    $query =
        new WP_Query($args);
    return $query->posts;
}



function my_acf_json_save_point()
{
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');



function checkArray($array, $field)
{
    return !empty($array) && array_key_exists($field, $array);
}






//A la sauvegarde d'un Premium
//Si les champs vidéo liée ou podcast lié sont rempli
//Met à jour le champ correspondant du premium lié
add_action('acf/save_post', 'my_acf_save_post');
function my_acf_save_post($post_id)
{
    $videoPremiumLinked = get_field('video_linked', $post_id);
    $podcastPremiumLinked = get_field('podcast_linked', $post_id);

    if ($videoPremiumLinked) {
        //mettre à jour le champ podcast_linked du premium Vidéo choisi
        update_field('podcast_linked', $post_id, $videoPremiumLinked[0]);
    } else {
        update_field('podcast_linked', null, $videoPremiumLinked[0]);
    }

    if ($podcastPremiumLinked) {
        //mettre à jour le champ video_linked du premium Vidéo choisi
        update_field('video_linked', $post_id, $podcastPremiumLinked[0]);
    } else {
        update_field('video_linked', null, $videoPremiumLinked[0]);
    }
}


//renvoi le type du player vidéo à utiliser en fonction de la configuration du Premium video
//defaut : provideo
function get_video_type($type)
{
    if (!empty($type)) {
        return $type;
    }

    $type = 'provideo';

    if (trim(get_field('provideo_iframe')) != '') {
        $type = 'provideo';
    } else if (!empty(get_field('id_video_vimeo')) || !empty(get_field('video_vimeo_url'))) {
        $type = 'vimeo';
    } else if (!empty(get_field('id_video_youtube'))) {
        $type = 'youtube';
    }

    return $type;
}


/**
 * Extracts the youtube id from a youtube url.
 * Returns false if the url is not recognized as a youtube url.
 */
function youtube_id_from_url($url)
{
    $pattern =
        '%^# Match any youtube URL
                (?:https?://)?  # Optional scheme. Either http or https
                (?:www\.)?      # Optional www subdomain
                (?:             # Group host alternatives
                  youtu\.be/    # Either youtu.be,
                | youtube\.com  # or youtube.com
                  (?:           # Group path alternatives
                    /embed/     # Either /embed/
                  | /v/         # or /v/
                  | /watch\?v=  # or /watch\?v=
                  )             # End path alternatives.
                )               # End host alternatives.
                ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                $%x';
    $result = preg_match($pattern, $url, $matches);
    if ($result) {
        return $matches[1];
    }
    return false;
}

/**
 * Extracts the vimeo id from a vimeo url.
 * Returns false if the url is not recognized as a vimeo url.
 */
function vimeo_id_from_url($url)
{
    if (preg_match('#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $url, $m)) {
        return $m[1];
    }
    return false;
}


//Déduire le type d'un premium selon les champs ACF rempli
//Utile pour les anciens site, ou le champ type_premium n'est pas rempli
function get_premium_type($type, $ID)
{
    if (!empty($type)) {
        return $type;
    }

    return update_premium_type($ID);
}

function update_premium_type($ID)
{
    $type = PREMIUM_TYPE_CONTENT;

    if (!empty(get_field('provideo_iframe', $ID)) || !empty(get_field('id_video_vimeo', $ID)) || !empty(get_field('video_vimeo_url', $ID)) || !empty(get_field('id_video_youtube', $ID))) {
        //exception si vimeo == 000, alors on considère que c'est un premium de type contenu
        if (get_field('id_video_vimeo', $ID) == '000' || get_field('video_vimeo_url', $ID) == '000' || get_field('id_unique_link_video', $ID) == '000') {
            $type = PREMIUM_TYPE_CONTENT;
        } else {
            $type = PREMIUM_TYPE_VIDEO;
        }
    } else if (!empty(get_field('iframe_podcast', $ID))) {
        $type = PREMIUM_TYPE_PODCAST;
    }
    update_field('type_premium', $type, $ID);
    return $type;
}


function get_class_for_premium_type($premiumType)
{
    switch ($premiumType) {
        case PREMIUM_TYPE_VIDEO:
            $premiumType = "video";
            break;
        case PREMIUM_TYPE_PODCAST:
            $premiumType = "podcast";
            break;
        case PREMIUM_TYPE_CONTENT:
            $premiumType = "content";
            break;
        default:
            $premiumType = "video";
            break;
    }

    return $premiumType;
}



//ACF : champs video et podcast liés
function my_acf_fields_relationship_query($args, $field, $post_id)
{
    if ($field['key'] == 'field_61f242df8c597') {
        //champ pdcast lié, n'affiher que les premium podcast
        $args['meta_query'] = array(
            array(
                'key'         => 'type_premium',
                'value'          => PREMIUM_TYPE_PODCAST,
                'compare'     => 'IN',
            ),
        );
    }

    if ($field['key'] == 'field_620bceac2e1f5') {
        //champ vidéo liée, n'affiher que les premium video
        $args['meta_query'] = array(
            array(
                'key'         => 'type_premium',
                'value'          => PREMIUM_TYPE_VIDEO,
                'compare'     => 'IN',
            ),
        );
    }



    return $args;
}
add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);


//retourne les terms (catégorie) à utiliser dans les filtres de la librairie
//exclue les catégories séléctionnées comme cachées dans les options du thème
function get_terms_for_filter()
{
    $termsArgs = array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    );
    $excludedCats = get_field('excluded_categories', 'option');
    if (!empty($excludedCats)) {
        $termsArgs['exclude'] =  $excludedCats;
    }

    return get_terms($termsArgs);
}


//récupère les PDF d'une page premium
//inclus les autres champs pdf utilisés dans certains thèmes (link_pdf, pdf)
function get_pdfs()
{
    $pdf = get_field('fichier_pdf');
    if (empty($pdf)) {
        $pdf = get_field('link_pdf');
    }
    if (empty($pdf)) {
        $pdf = get_field('pdf');
    }
    if (is_array($pdf) && array_key_exists('url', $pdf)) {
        $pdf = $pdf['url'];
    }

    return $pdf;
}


function get_files()
{
    $files = get_field('ajouter_fichiers_pdf');
    if ($files) {
        $files = array_filter($files, function ($file) {
            return is_array($file) && array_key_exists('pdf', $file) && !empty($file['pdf']);
        });
    }

    return $files;
}

//retourne un tableau de thumbnails par taille pour un premium
function get_premium_thumbnail($premium)
{

    if (get_field('premium_thumbnail', $premium->ID) && !empty(get_field('premium_thumbnail', $premium->ID))) {
        $value = get_field('premium_thumbnail', $premium->ID);
    }
    //si la miniature n'a pas été remplie, on vérifie l'ancien champ thumbnail
    else if (get_field('thumbnail', $premium->ID) && !empty(get_field('thumbnail', $premium->ID))) {
        $value = get_field('thumbnail', $premium->ID);
    }

    //si la thumbnail n'a pas été remplie, on vérifie l'ancien champ miniature
    else if (get_field('miniature_video', $premium->ID) && !empty(get_field('miniature_video', $premium->ID))) {
        $value = get_field('miniature_video', $premium->ID);
    }

    //si lancien champ miniature n'a pas été rempli, on vérifie le champ poster
    else if (get_field('poster_video', $premium->ID) && !empty(get_field('poster_video', $premium->ID))) {
        $value = get_field('poster_video', $premium->ID);
    }


    //array
    if (isset($value) && is_array($value) && checkArray($value, 'sizes')) {
        $thumbnail = [
            "sizeMax" => $value['sizes']['1536x1536'],
            "sizeLarge" => $value['sizes']['large'],
            "sizeNormal" => $value['sizes']['medium_large']
        ];
    } else if (is_numeric($value)) {
        $thumbnail = [
            "sizeMax" => wp_get_attachment_image_src($value, '1536x1536')[0],
            "sizeLarge" => wp_get_attachment_image_src($value, 'large')[0],
            "sizeNormal" => wp_get_attachment_image_src($value, 'medium')[0]
        ];
    } else if (isset($value)) {
        $thumbnail = [
            "sizeMax" => $value,
            "sizeLarge" => $value,
            "sizeNormal" => $value
        ];
    }

    return $thumbnail;
}
