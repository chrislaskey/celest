<?php
/**
 * The loop that displays posts
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */
?>
    
    <?php if( !have_posts() ): //If there are no posts to display, such as an empty archive page ?>
        
        <div class="post">
            <h1 class="entry-title">Not Found</h1>
            <div class="entry-content">
                <p>There are currently no posts that fit the requested criteria. From here you can return to the <a href="<?php echo home_url('/'); ?>">homepage</a> or try using the search form below.</p>
                <?php get_search_form(); ?>
            </div>
        </div>
        
    <?php else: ?>

        <h1><?php echo ($page_title = loop_page_title()) ? $page_title : 'News'; ?></h1>
        
        <ul class="posts">
            
            <?php $first = TRUE; ?>
            
            <?php while ( have_posts() ) : the_post(); //Start the Loop ?>
            
            <li <?php post_class( ($first === TRUE) ? 'first' : '' ); ?>>
                
                <h2 class="title post-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                
                <div class="post-header">

                    <span class="post-date"><?php echo get_the_date(); ?></span>

                </div>
                
                <?php if ( is_author() || is_search() ) : //Only display Excerpts for archives & search ?>
                    
                    <div class="post_summary">
                        <?php the_excerpt('Read the rest of this entry &raquo;'); ?>
                        <div class="clear_left"></div>
                    </div>
                    
                <?php else : ?>
                    
                    <div class="post_content">
                        <?php the_content('Read the rest of this entry &raquo;'); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page_link">Pages:', 'after' => '</div>' ) ); ?>
                        <div class="clear_left"></div>
                    </div>
                    
                <?php endif; ?>
                
                <?php if( !is_author() && !is_search() ): ?>
                    
                    <?php
                        
                        $information = array();
                        
                        if( have_comments() || comments_open() ){
                            $comments = trap('comments_popup_link', 'Leave a comment', '1 Comment', '% Comments');
                            $information['comments'] = '<div class="comments_link">Comments: '.$comments.'</div>';
                        }
                        
                        if( $categories = cat_list() ){
                            $information['categories'] = '<div class="categories_list">'.$categories.'</div>';
                        }
                        
                        if( $tags = tag_list() ){
                            $information['tags'] = '<div class="tags_list">'.$tags.'</div>';
                        }
                        
                        if( $information != NULL ){
                            // Disable footer information, uncomment to display it
                            // echo '<div class="post_information">'.implode("<br/>\n\n", $information).'<div class="clear"></div></div>';
                        }
                        
                    ?>
                    
                <?php endif; ?>
                
            </li>
            
            <?php $first = FALSE; ?>
            
            <?php endwhile; ?>
        
        </ul>
    
    <?php endif; ?>
    
    <?php if($wp_query->max_num_pages > 1): //Display navigation to next/previous pages when applicable ?>
        
        <div class="nav-below clearfix">
            <div class="nav-previous"><?php next_posts_link('&laquo; Older posts'); ?></div>
            <div class="nav-next"><?php previous_posts_link('Newer posts &raquo;'); ?></div>
        </div>
        
    <?php endif; ?>
