<?php
/**
 * The Sidebar containing the primary and secondary widget areas
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

?>

<?php if( ! preg_match('/^\?s/', $uri[0]) ): //If not search ?>

<div class="navigation">

    <h3 class="section"><?php echo get_sidebar_header(); ?></h3>

    <?php

        if( isset($uri[0]) ){

            if( $uri[0] == 'about-us' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_about_us',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_about_us'
                ));

            }elseif( $uri[0] == 'our-people' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_our_people',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_our_people'
                ));

            }elseif( $uri[0] == 'our-work' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_our_work',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_our_work'
                ));

            }elseif( $uri[0] == 'outreach-and-impacts' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_outreach_and_impacts',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_outreach_and_impacts'
                ));

            }elseif( $uri[0] == 'events-and-programs' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_events_and_programs',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_events_and_programs'
                ));

            }elseif( $uri[0] == 'news' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_news',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_news'
                ));

            }elseif( $uri[0] == 'contact-us' ){

                wp_nav_menu( array(
                    'container' => 'false',
                    'fallback_cb' => 'false',
                    'menu_class' => 'sidenav menu_sidenav sidenav menu_sidenav_contact_us',
                    'menu_id' => 'sidenav',
                    'theme_location' => 'sidenav_contact_us'
                ));

            }
        }

    ?>

</div>

<div class="sidebar_search">

    <?php //get_search_form(); ?>

</div>

<?php endif; ?>

<?php if( is_active_sidebar('sidebar-widget-area') ): ?>

    <ul class="widget-area">
        <?php dynamic_sidebar('sidebar-widget-area'); ?>
    </ul>

<?php endif; ?>
