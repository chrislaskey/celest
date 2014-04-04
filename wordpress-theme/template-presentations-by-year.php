<?php
/**
 * Template Name: Presentations By Year
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

                        $type = $uri[2];
                        $year = get_post_meta($post->ID, 'year', TRUE);

                        if( ! $year ){

                            echo '<p>Currently there are no CELEST Presentations to display for the specified time period.</p>';

                        }else{

                            $data = get_api_data('/api/our-work/presentations/'.$type.'/by-year/'.$year);

                            if( isset($data->presentations) && count($data->presentations > 0) ){

                                if( $type == 'conference' ){ $printer = 'create_conference_presentation'; }
                                else{ $printer = 'create_nonconference_presentation'; }

                                echo '<ol class="our-work-list presentations '.$type.'-presentations">';

                                foreach($data->presentations as $pres){
                                    echo '<li>'.$printer($pres).'</li>';
                                }

                                echo '</ol>';

                            }else{

                                echo '<p>Currently there are no CELEST Presentations to display for the specified time period.</p>';

                            }

                        }

                    ?>

                </div>

            </section>

        </section>

    </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
