<?php
/**
 * Template Name: Honors By Year
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

                        $year = get_post_meta($post->ID, 'year', TRUE); 

                        if( ! $year ){

                            echo '<p>Currently there are no CELEST Honors or Awards to display for the specified time period.</p>';

                        }else{

                            $data = get_api_data('/api/our-work/honors-and-awards/by-year/'.$year);

                            if( isset($data->honors) && !empty($data->honors) ){

                                $authors = '';

                                foreach($data->honors as $honor){

                                    if( $authors != $honor->authors ){
                                        if( $authors != NULL ){ echo '</ul>'; }
                                        echo '<h2>'.$honor->authors.'</h2>';
                                        echo '<ul class="our-work-list honors">';
                                        $authors = $honor->authors;
                                    }

                                    echo '<li>'.$honor->description.'</li>';

                                }

                            }else{

                                echo '<p>Currently there are no CELEST Honors or Awards to display for the specified time period.</p>';

                            }

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
