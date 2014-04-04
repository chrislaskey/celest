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

                <?php get_template_part( 'loop', 'index' ); ?>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
