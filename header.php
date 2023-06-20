<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage spintheme
 * @since spintheme 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta name="viewport" id="myViewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body class="preload" <?php body_class(); ?>>
    <!-- MENU TOP -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="nav-top">
                        <a href="<?php echo get_home_url() ?>" class="logo-top appear">
                            <?php $img = get_field('logo_couleurs', 'option') ?>
                            <?php if(isset($img['url'])) { ?>
                                <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>">
                            <?php } ?>
                        </a>
                        <div class="menu-top d-md-flex d-none">
                            <?php $current_id = get_the_ID();
                            $menu_name = 'header-menu';
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
                            foreach($array_menu as $navItem) {
                                if (intval($navItem->menu_item_parent) === intval($old_id)) {
                                    $menu_final[$id_menu]['child'][$id_sub_menu] = $navItem;
                                    $id_sub_menu++;
                                } else {
                                    $id_menu++;
                                    $menu_final[$id_menu]['parent'] = $navItem;
                                    $old_id = $navItem->ID;
                                    $id_sub_menu = 0;
                                }
                            }
                            foreach($menu_final as $navItem) {
                                if ($current_id == $navItem['parent']->object_id) { ?>
                                    <a href="<?php echo $navItem['parent']->url ?>"class="item-menu-main current appear <?php print_r($navItem['parent']->classes[0])?>">
                                        <?php echo $navItem['parent']->title ?>
                                        <?php if($navItem['parent']->classes[0] == "sub-menu-item") { ?>
                                            <img src="/wp-content/themes/wbm/assets/images/icons/chevron-bottom.svg" alt="">
                                        <?php } ?>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo $navItem['parent']->url ?>"class="item-menu-main appear <?php print_r($navItem['parent']->classes[0])?>">
                                        <?php echo $navItem['parent']->title ?>
                                        <?php if($navItem['parent']->classes[0] == "sub-menu-item") { ?>
                                            <img src="/wp-content/themes/wbm/assets/images/icons/chevron-bottom.svg" alt="">
                                        <?php } ?>
                                    </a>
                                <?php }
                            } ?>
                        </div>
                        <?php $link = get_field('bouton_header', 'option') ?>
                            <?php if(isset($link['url'])) { ?>
                                <a target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>" class="btn-primary appear d-md-flex d-none">
                                    <?php echo $link['title'] ?>
                                </a>
                            <?php } ?>
                        <!-- <img class="btn-burger d-md-none d-flex" src="/wp-content/themes/wbm/assets/images/icons/menu_black.svg" alt=""> -->
                    </nav>
                </div>
            </div>
        </div>
        <div class="sub-menu">
            <div class="container">
                <div class="row">
                    <?php if( have_rows('sous_menu', 'option') ):
                        while( have_rows('sous_menu', 'option') ) : the_row(); ?>
                            <?php $link =  get_sub_field('lien') ?>
                            <div class="col-6">
                                <a target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>">
                                <div class="wrap-title">
                                    <img src="<?php the_sub_field("image") ?>" alt="" class="bg-img">
                                    <div class="title">
                                        <?php echo $link['title'] ?>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>
        </div>
    </header>
    <div class="space-header">
    </div>

    <!-- MENU MOBILE -->
    <div class="side-menu d-none">
        <div class="wrap-menu">
            <div class="menu-mobile">
                <?php $current_id = get_the_ID();
                $menu_name = 'header-menu';
                $locations = get_nav_menu_locations();
                $menu_id = $locations[ $menu_name ];
                $menuObject = wp_get_nav_menu_object($menu_id);
                $current_menu = $menuObject->slug;
                $array_menu = wp_get_nav_menu_items($current_menu);
                $old_id = -1;
                $menu_final = [];
                $menu_sub = [];
                $id_menu = 0;
                $id_sub_menu = 0;
                foreach($array_menu as $navItem) {
                    if (intval($navItem->menu_item_parent) === intval($old_id)) {
                        $menu_final[$id_menu]['child'][$id_sub_menu] = $navItem;
                        $id_sub_menu++;
                    } else {
                        $id_menu++;
                        $menu_final[$id_menu]['parent'] = $navItem;
                        $old_id = $navItem->ID;
                        $id_sub_menu = 0;
                    }
                }

                foreach($menu_final as $navItem) {
                    if (isset($navItem['child'])) {
                        if ($current_id == $navItem['parent']->object_id) { ?>
                            <div class="item-menu-main current">
                                <?php echo $navItem['parent']->title ?>
                                <img src="/wp-content/themes/oscar/img/icons/triangle.svg" alt="">
                                <div class="sub-menu-mobile">
                                    <?php foreach($navItem['child'] as $navItemSub) { ?>
                                        <a href="<?php echo $navItemSub->url ?>"><?php echo $navItemSub->title ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="item-menu-main">
                                <?php echo $navItem['parent']->title ?>
                                <img src="/wp-content/themes/oscar/img/icons/triangle.svg" alt="">
                                <div class="sub-menu-mobile">
                                    <?php foreach($navItem['child'] as $navItemSub) { ?>
                                        <a href="<?php echo $navItemSub->url ?>"><?php echo $navItemSub->title ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }
                    } else {
                        if ($current_id == $navItem['parent']->object_id) { ?>
                            <a href="<?php echo $navItem['parent']->url ?>"class="item-menu-main current">
                                <?php echo $navItem['parent']->title ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo $navItem['parent']->url ?>"class="item-menu-main">
                                <?php echo $navItem['parent']->title ?>
                            </a>
                        <?php }
                    }
                } ?>
            </div>
            <?php $link = get_field('bouton_header', 'option') ?>
            <?php if(isset($link['url'])) { ?>
                <a target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>" class="btn-primary">
                    <?php echo $link['title'] ?>
                </a>
            <?php } ?>
        </div>
    </div>


