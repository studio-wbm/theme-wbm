<footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php $img = get_field('logo_couleurs', 'option') ?>
                <?php if(isset($img['url'])) { ?>
                    <img class="logo-footer" src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>">
                <?php } ?>
                <div class="menu-footer">
                    <?php $current_id = get_the_ID();
                    $menu_name = 'footer-menu';
                    $locations = get_nav_menu_locations();
                    //Get the id of 'primary_menu'
                    $menu_id = $locations[ $menu_name ] ;
                    //Returns a navigation menu object.
                    $menuObject = wp_get_nav_menu_object($menu_id);
                    // Retrieves all menu items of a navigation menu.
                    $current_menu = $menuObject->slug;
                    $array_menu = wp_get_nav_menu_items($current_menu);
                    $old_id = -1;
                    $menu_final = [];
                    $menu_sub = [];
                    $id_menu = 0;
                    $id_sub_menu = 0;
                    foreach($array_menu as $navItem) { ?>
                        <a href="<?php print_r($navItem->url); ?>">
                            <?php print_r($navItem->title); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
