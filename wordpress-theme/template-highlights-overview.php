<?php
/**
 * Template Name: Highlights Overview
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

                    $data = get_api_data('/api/our-work/research-and-outreach-highlights');

                    if( isset($data->highlights) && !empty($data->highlights) ){

                        $highlights = array();
                        foreach($data->highlights as $highlight){
                            $content = $highlight->title;
                            if( $highlight->file_path ){
                                $content .= '<a class="external file-icon file-type-'.$highlight->file_type.'" href="'.$highlight->file_path.'">Download as PDF</a>';
                            }

                            $highlights[] = '<li>'.$content.'</li>';
                        }

                        echo '<ol class="our-work-list highlights">'.implode($highlights).'</ol>';

                    }else{

                        echo '<p>There are no highlights to display for the given year.</p>';

                    }
                ?>
            </div>

        </section>

<?php include(TEMPLATEPATH.'/footer.php'); ?>
