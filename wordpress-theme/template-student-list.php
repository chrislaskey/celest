<?php
/**
 * Template Name: Student List
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

?><?php include(TEMPLATEPATH.'/header.php'); ?>

        <?php the_post(); ?>

        <section id="content" <?php post_class('page'); ?>>

            <h1 class="title page_title"><?php the_title(); ?></h1>

            <div class="post_content">

                <?php the_content(); ?>

                <?php

                    $year = get_post_meta($post->ID, 'year', TRUE);	
                    $data = get_api_data('/api/our-people/students/'.$year);

                    if( empty($data->users) ){

                        echo '<p>There are currently no members to show.</p>';

                    } else {
                    
                        foreach( $data->users as $section => $users ){

                            if( $section == 'postdoc' ){
                                $section = 'Postdoctoral Researcher';
                            }

                            $section = $section . 's';

                            echo '<h2>'.clean_slug($section).'</h2>';

                            echo '<ul class="student-list '.$year.'">';

                            foreach($users as $user){
                                if( $user == 'TBD' ){
                                    continue;
                                }
                                echo '<li>'.$user.'</li>';
                            }
                            
                            echo '</ul>';

                        }

                    }

                ?>

            </div>

        </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>

