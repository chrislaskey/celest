<?php
/**
 * Template Name: User Group
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

                    $group = get_post_meta($post->ID, 'group', TRUE);	
                    $data = get_api_data('/api/our-people/groups/'.$group);

                    if( empty($data->users) ){

                        echo '<p>There are currently no members to show.</p>';

                    } else {
                    
                        echo '<ul class="user-group '.$group.'">';

                        foreach($data->users as $user){
                            echo '<li>'.create_user_group_entry($user).'</li>';
                        }
                        
                        echo '</ul>';
                    }

                ?>

            </div>

        </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>

