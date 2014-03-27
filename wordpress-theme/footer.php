<?php
/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */
?>

                </section>
            </section>

        </div>
    </div>

    <section id="news-footer">
        <section class="container">
            <section id="news-footer-articles">

                <?php display_news_articles(3); ?>

                <?php

                    function display_news_articles($total = 3){
                        $i = 0;
                        $per_row = 3;
                        $posts = return_news_posts();
                        if( empty($posts) ){ return; }

                        foreach( $posts as $post ){
                            $i++;
                            $content = process_news_article($post);
                            $class = return_news_articles_class($i, $per_row);
                            print_bucket($content, $class);
                        }
                    }

                    function return_news_posts(){
                        $args = array(
                            'numberposts' => 3,
                            'post_status' => 'publish'
                        );
                        $posts = wp_get_recent_posts($args);
                        // wp_get_recent_posts is supposed to return an array
                        // of objects. But sometimes it returns an array of
                        // arrays. We don't need an object and it's easier to
                        // cast down to an array in PHP.
                        return (array) $posts;
                    }

                    function process_news_article($post){
                        $char_limit = 194;

                        $category = return_news_article_category($post['ID']);

                        $link = '/news/'.$category['slug'].'/'.$post['post_name'];

                        $title = esc_attr($post['post_title']);
                        $chars_remaining = $char_limit - strlen($title);

                        //Remove wordpress pseudo-tags like [caption id=...]
                        $content = preg_replace('/\[.*\]/', '', $post['post_content']);
                        $content = strip_tags($content);
                        $content = break_at_next_word($chars_remaining, $content, $link);

                        return array(
                            'category' => $category['name'],
                            'link'     => $link,
                            'title'    => $title,
                            'content'  => $content
                        );
                    }

                    function return_news_article_category($id){
                        $categories = get_the_category($id);
                        $default = array(
                            'name' => 'Recent News',
                            'slug' => 'recent-news'
                        );

                        if( ! isset($categories[0]) ){ return $default; }
                        if( ! isset($categories[0]->name) ){ return $default; }

                        return array(
                            'name' => $categories[0]->name,
                            'slug' => $categories[0]->slug
                        );
                    }

                    function return_news_articles_class($i, $per_row){
                        if( ($i - 1) % $per_row == 0 ){
                            $class = 'alpha';
                        }elseif( $i % $per_row  === 0 ){
                            $class = 'omega';
                        }else{
                            $class = '';
                        }
                        return $class;
                    }

                    function print_bucket($content, $class = ''){
                        echo '<article class="news-item one-third column '.$class.'">
                                <span class="news-section">'.$content['category'].'</span>
                                <a href="'.$content['link'].'" class="news-title">'.$content['title'].'</a>
                                <span class="news-description">'.$content['content'].'</span>
                             </article>';
                    }

                ?>

            </section>
        </section>
    </section>

    <footer>
        <section class="container">
            <a id="nsf-footer" href="/about-us/nsf-science-of-learning-centers/">A National Science Foundation <span class="highlight">Science of Learning Center</span></a>
            <div class="universities">
                <a href="http://bu.edu">Boston University</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://brandeis.edu">Brandeis University</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.brighamandwomens.org/">Brigham and Women&rsquo;s Hospital</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://harvard.edu">Harvard University</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://mit.edu">Massachussets Institute of Technology</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://neu.edu">Northeastern University</a>
            </div>
        </section>
    </footer>

    <script>
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <script>
        try {
            var pageTracker = _gat._getTracker("UA-11681368-2");
            pageTracker._trackPageview();
        } catch(err) {}
    </script>

</body>
</html>
