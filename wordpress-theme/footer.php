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

                <article class="news-item one-third column alpha">
                    <span class="news-section">Media Publicity</span>
                    <a href="#" class="news-title">NASA Center Innovation Fund features CELEST Research</a>
                    <span class="news-description">The CELEST funded Neuromorphics Lab (CompNet) has been "working with NASA Langley on a Center Innovation Fund (CIF) with ...</span>
                </article>

                <article class="news-item one-third column">
                    <span class="news-section">Media Publicity</span>
                    <a href="#" class="news-title">NASA Center Innovation Fund features CELEST Research</a>
                    <span class="news-description">The CELEST funded Neuromorphics Lab (CompNet) has been "working with NASA Langley on a Center Innovation Fund (CIF) with ...</span>
                </article>

                <article class="news-item one-third column omega">
                    <span class="news-section">Media Publicity</span>
                    <a href="#" class="news-title">NASA Center Innovation Fund features CELEST Research</a>
                    <span class="news-description">The CELEST funded Neuromorphics Lab (CompNet) has been "working with NASA Langley on a Center Innovation Fund (CIF) with ...</span>
                </article>

                <?php //display_news_articles(3); ?>

                <?php

                    function display_news_articles($total = 3){
                        // Display n number of buckets.
                        // For a given bucket:
                        //  - Check if a valid user defined article box exists in position n
                        //  - If not, display a news item.
                        $per_row = 3;
                        for($i = 1; $i <= $total; $i++){
                            if( return_user_defined_article($i) ){
                                $bucket_content = return_user_defined_article($i);
                            }else{
                                $bucket_content = return_news_article();
                            }

                            $class = 'bucket-'.$i;
                            if( $i % $per_row  === 0 ){ $class .= ' last_in_row'; }
                            print_bucket($bucket_content, $class);
                        }
                    }

                    function return_user_defined_article($index){
                        $custom_fields = get_post_custom();
                        $article_position = 'article_position_' . $index;

                        if( ! isset($custom_fields[$article_position]) ){
                            return NULL;    
                        }

                        $user_article = $custom_fields[$article_position][0];
                        if( ! verify_user_defined_article($user_article) ){
                            return NULL;
                        }

                        return $user_article;
                    }

                        function verify_user_defined_article($article_to_test){
                            // Verify a article box contains all required elements using a simple
                            // strpos check. Returns boolean.
                            $required_elements = array(
                                '<h5', '</h5>',
                                '<h3', '</h3>',
                                '<p', '</p>'
                            );
                            foreach( $required_elements as $element ){
                                if( strpos($article_to_test, $element) === FALSE ){ return FALSE; }
                            }
                            return TRUE;
                        }

                    function return_news_article(){
                        static $call_count;
                        if( ! $call_count ){ $call_count = 0; }

                        $args = array(
                            'numberposts' => 1,
                            'offset' => $call_count
                        );
                        $posts = wp_get_recent_posts($args);
                        // wp_get_recent_posts is supposed to return an array
                        // of objects. But sometimes it returns an array of
                        // arrays. We don't need an object and it's easier to
                        // cast down to an array in PHP.
                        $post = (array) $posts[0];
                        $call_count++;

                        return format_news_article($post);
                    }

                        function format_news_article($post){
                            $href = '/news/'.$post['ID'];
                            $title = esc_attr($post['post_title']);
                            $title = '<a href="'.$href.'">'.$title.'</a>';
                            $link = '... <a href="'.$href.'">Learn More</a>';
                            $char_limit = 215 - strlen($title);
                            //Remove wordpress pseudo-tags like [caption id=...]
                            $content = preg_replace('/\[.*\]/', '', $post['post_content']);
                            $content = strip_tags($content);
                            $content = break_at_next_word($char_limit, $content, $link);

                            $article = '<h5>Recent News</h5>';
                            $article .= '<h3>'.$title.'</h3>';
                            $article .= '<p>'.$content.'</p>';

                            return $article;
                        }

                    function print_bucket($bucket_content, $class = ''){
                        echo '<li class="'.$class.'">'.$bucket_content.'</li>'."\n";
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
