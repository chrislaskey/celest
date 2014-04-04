<?php
/**
 * Template Name: Publications Overview
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

                        $data = get_api_data('/api/our-work/publications');

                        if( count($data->latest_book) > 0 ){

                            echo '<h2>Most Recent Books and Book Chapters</h2>';
                            echo '<ol class="our-work-list publications book-publications">';

                            foreach($data->latest_book as $pub){
                                echo '<li>'.create_book_publication($pub).'</li>';
                            }
                            
                            echo '</ol>';

                        }

                        if( count($data->latest_peer) > 0 ){

                            $nonconf_array = array();

                            echo '<h2>Most Recent Peer-Reviewed Publications</h2>';
                            echo '<ol class="our-work-list publications peer-publications">';

                            foreach($data->latest_peer as $pub){
                                echo '<li>'.create_peer_publication($pub).'</li>';
                            }

                            echo '</ol>';

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
