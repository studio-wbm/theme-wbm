<?php get_header(); ?>
<main>
    <section class="banner-page">
        <h1>
            <?php the_title() ?>
        </h1>
    </section>
    <?php if( have_rows('blocs') ):
        while ( have_rows('blocs') ) : the_row();
            include('wp-content/themes/wbm/blocs/'. get_row_layout() . '.php');
        endwhile;
    endif; ?>

    <div class="wrap-breadcumb">
        <div class="container">
            <?php if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb('<p id="breadcrumbs">','</p>');
            } ?>
        </div>
    </div>
</main>
<?php get_footer();

