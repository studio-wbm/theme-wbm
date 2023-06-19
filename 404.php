<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage spintheme
 * @since spintheme 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="not-found">
            <h1><?php _e( "404"); ?></h1>
            <h2><?php _e( "Cette page n'existe pas !" ); ?></h2>
            <p><a href="<?php echo get_option('home'); ?>"><?php _e( "Retour vers la page d'accueil"); ?></a></p>
        </div>
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();
