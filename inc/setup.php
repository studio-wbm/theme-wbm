<?php
setlocale(LC_ALL, 'fr_FR');

//Theme Setup
function spintheme_setup() {
    load_theme_textdomain('spintheme', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');

    add_theme_support('post-thumbnails');
    add_image_size('full_screen', 1600, 533, true); // Image d'environ deux tiers
}
add_action('after_setup_theme', 'spintheme_setup');

//Load Scripts
function spintheme_scripts() {
    if (!is_admin()) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        wp_dequeue_style('wp-block-library');
        wp_deregister_style('wp-block-library');
    }

    wp_enqueue_style('bootstrap-min', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('slick-css-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css');
    wp_enqueue_style('slick-theme-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css');
    wp_enqueue_style('style-min', get_template_directory_uri() . '/dist/css/main.min.css');

    if (!is_admin()) {
        wp_deregister_script('jquery');
    }

    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.1.min.js', null, null, true);
    wp_enqueue_script('slick-js-min', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', null, null, true);
    wp_enqueue_script('functions', get_template_directory_uri() . '/dist/js/app.min.js', null, null, true);
}
add_action('wp_enqueue_scripts', 'spintheme_scripts');

//Renomme correctement les uploads
function wpc_sanitize_french_chars($filename) {
    $filename = mb_convert_encoding($filename, "UTF-8");
    $char_not_clean = array('/À/', '/Á/', '/Â/', '/Ã/', '/Ä/', '/Å/', '/Ç/', '/È/', '/É/', '/Ê/', '/Ë/', '/Ì/', '/Í/', '/Î/', '/Ï/', '/Ò/', '/Ó/', '/Ô/', '/Õ/', '/Ö/', '/Ù/', '/Ú/', '/Û/', '/Ü/', '/Ý/', '/à/', '/á/', '/â/', '/ã/', '/ä/', '/å/', '/ç/', '/è/', '/é/', '/ê/', '/ë/', '/ì/', '/í/', '/î/', '/ï/', '/ð/', '/ò/', '/ó/', '/ô/', '/õ/', '/ö/', '/ù/', '/ú/', '/û/', '/ü/', '/ý/', '/ÿ/', '/©/');
    $clean = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'copy');
    $friendly_filename = preg_replace($char_not_clean, $clean, $filename);
    $friendly_filename = utf8_decode($friendly_filename);
    $friendly_filename = preg_replace('/\?/', '', $friendly_filename);
    $friendly_filename = strtolower($friendly_filename);
    return $friendly_filename;
}
add_filter('sanitize_file_name', 'wpc_sanitize_french_chars', 10);

//Initialise la session
function start_session() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session');

// Autoriser les fichiers SVG
function wpc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');

//Change default error message on login
function my_custom_error_messages() {
	global $errors;
	$err_codes = $errors->get_error_codes();
    $error = '';
	// Invalid username or password or both.
	if ( in_array( 'invalid_username', $err_codes ) || in_array( 'incorrect_password', $err_codes ) ) {
		$error .= __('<p><strong>ERREUR</strong>: l\'identifiant et le mot de passe ne correspondent pas ou sont incorrect.</p>');
	}
    if ( in_array( 'empty_username', $err_codes ) ) {
		$error .= __('<p><strong>ERREUR</strong>: le champ de l’identifiant est vide</p>');
    }
    if ( in_array( 'empty_password', $err_codes ) ) {
		$error .= __('<p><strong>ERREUR</strong>: le champ du mot de passe est vide.</p>');
	}
	return $error;
}
add_filter( 'login_errors', 'my_custom_error_messages');

// function setupMenu() {
//     remove_menu_page('edit.php');
//     remove_menu_page('edit-comments.php');
// }

// add_action('admin_menu', 'setupMenu');

function custom_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
    register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'custom_menu' );


// START Resorts CPT
$labels = array(
    'name'                => _x( 'Test CPT', 'Post Type General Name'),
    'singular_name'       => _x( 'Test CPT', 'Post Type Singular Name'),
    'menu_name'           => __( 'Test CPT'),
    'all_items'           => __( 'Toutes les Test CPT'),
    'view_item'           => __( 'Voir les Test CPT'),
    'add_new_item'        => __( 'Ajouter un resort'),
    'add_new'             => __( 'Ajouter'),
    'edit_item'           => __( 'Editer le resort'),
    'update_item'         => __( 'Modifier le resort'),
    'search_items'        => __( 'Rechercher un resort'),
    'not_found'           => __( 'Non trouvée'),
    'not_found_in_trash'  => __( 'Non trouvée dans la corbeille'),
);

$args = array(
    'label'               => __( 'Test CPT'),
    'description'         => __( 'Tous sur les Test CPT'),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
    'show_in_rest'        => true,
    'hierarchical'        => false,
    'public'              => true,
    'has_archive'         => false,
    'menu_icon'           => 'dashicons-palmtree',
    'rewrite'			  => array( 'slug' => 'test-cpt'),

);

register_post_type( 'test-cpt', $args );

$cat_test = array(
    'name'              			=> _x( 'Catégories', 'taxonomy general name'),
    'singular_name'     			=> _x( 'Catégorie', 'taxonomy singular name'),
    'search_items'      			=> __( 'Chercher une catégorie'),
    'all_items'        				=> __( 'Toutes les catégories'),
    'edit_item'         			=> __( 'Editer la catégorie'),
    'update_item'       			=> __( 'Mettre à jour la catégorie'),
    'add_new_item'     				=> __( 'Ajouter une nouvelle catégorie'),
    'new_item_name'     			=> __( 'Valeur de la nouvelle catégorie'),
    'separate_items_with_commas'	=> __( 'Séparer avec une virgule'),
    'menu_name'                     => __( 'Catégories'),
);

$args_test = array(
    'hierarchical'      => true,
    'labels'            => $cat_test,
    'show_ui'           => true,
    'show_in_rest'      => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'category' ),
);

register_taxonomy( 'category_test', 'resorts', $args_test );
// FIN Resorts


if( function_exists('acf_add_options_page') ) { 
    acf_add_options_page(); 
}