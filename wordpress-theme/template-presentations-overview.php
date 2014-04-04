<?php
/**
 * Template Name: Presentations Overview
 *
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

            <?php the_post(); ?>

            <section id="content" <?php post_class('page'); ?>>

                <h1 class="title page_title"><?php the_title(); ?></h1>

                <div class="post_content">

                    <?php the_content(); ?>

                    <?php

                        $data = get_api_data('/api/our-work/presentations');

                        if( count($data->latest_conference) > 0 ){

                            echo '<h2>Most Recent Conference Presentations</h2>';
                            echo '<ol class="our-work-list presentations conference-presentations">';

                            foreach($data->latest_conference as $pres){
                                echo '<li>'.create_conference_presentation($pres).'</li>';
                            }
                            
                            echo '</ol>';

                        }

                        if( count($data->latest_nonconference) > 0 ){

                            $nonconf_array = array();

                            echo '<h2>Most Recent Non-Conference Presentations</h2>';
                            echo '<ol class="our-work-list presentations nonconference-presentations">';

                            foreach($data->latest_nonconference as $pres){
                                echo '<li>'.create_nonconference_presentation($pres).'</li>';
                            }

                            echo '</ol>';

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
