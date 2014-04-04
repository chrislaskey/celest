<?php
/**
 * Template Name: Honors Overview
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

                        $data = get_api_data('/api/our-work/honors-and-awards');

                        if( isset($data->honors) && !empty($data->honors) ){

                            $honors = array();

                            foreach($data->honors as $honor){
                                $honors[] = '<li>'.$honor->description.'</li>';
                            }

                            echo '<ol class="our-work-list honors">'.implode($honors).'</ol>';

                        }else{

                            echo '<p>Currently there are no CELEST Honors or Awards to display for the specified time period.</p>';

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
