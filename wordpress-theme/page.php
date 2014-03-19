<?php

/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

?><?php include(TEMPLATEPATH.'/header.php'); ?>

        <section id="content">

            <?php the_post(); ?>

            <div <?php post_class('page'); ?>>

                <h1 class="title page_title"><?php the_title(); ?></h1>

                <div class="post_content">
                    <?php the_content(); ?>
                    <?php wp_link_pages( array('before' => '<div class="page-link">Pages: ', 'after' => '</div>') ); ?>
                </div>

            </div>

            <?php comments_template( '', true ); ?>

        </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
