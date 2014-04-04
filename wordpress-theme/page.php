<?php

/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

?><?php include(TEMPLATEPATH.'/header.php'); ?>

    <section id="main" class="container clearfix">

        <section id="sidebar" class="five columns alpha">

            <?php include(TEMPLATEPATH.'/sidebar.php'); ?>

        </section>

        <section id="content-container" class="eleven columns omega">

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

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
