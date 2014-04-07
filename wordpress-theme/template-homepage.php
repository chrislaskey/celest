<?php

/**
 * Template Name: Homepage
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

?><?php include(TEMPLATEPATH.'/header.php'); ?>

    <?php if( is_active_sidebar('homepage-widget-area') ): ?>

        <ul class="widget-area">
            <?php dynamic_sidebar('homepage-widget-area'); ?>
        </ul>

    <?php endif; ?>

    <section id="homepage-container" class="container">

        <?php the_post(); ?>

        <?php the_content(); ?>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
