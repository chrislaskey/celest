<?php
/**
 * Template Name: Publications By Year
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

                        $db_type_from_uri = $uri[2] == 'books' ? 'book' : 'peer';
                        $year = get_post_meta($post->ID, 'year', TRUE);

                        if( ! $year ){

                            echo '<p>Currently there are no CELEST Publications to display for the specified time period.</p>';

                        }else{

                            $data = get_api_data('/api/our-work/publications/'.$db_type_from_uri.'/by-year/'.$year);

                            if( isset($data->publications) && count($data->publications > 0) ){

                                if( $type == 'book' ){ $printer = 'create_book_publication'; }
                                else{ $printer = 'create_peer_publication'; }

                                echo '<ol class="our-work-list publications '.$db_type_from_uri.'-publications">';

                                foreach($data->publications as $pub){
                                    echo '<li>'.$printer($pub).'</li>';
                                }

                                echo '</ol>';

                            }else{

                                echo '<p>Currently there are no CELEST Publications to display for the specified time period.</p>';

                            }

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
