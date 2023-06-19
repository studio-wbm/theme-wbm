<?php get_header(); ?>
<main>
    <?php if( have_rows('blocs') ):
        while ( have_rows('blocs') ) : the_row();
            include('wp-content/themes/wbm/blocs/'. get_row_layout() . '.php');
        endwhile;
    endif; ?>
</main>
<?php get_footer();