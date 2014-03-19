<?php
/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */


//Definitions
    if( ! defined('CL_TEMPLATEPATH') ){ define('CL_TEMPLATEPATH', '/wp-content/themes/celest-responsive'); }


//Wordpress Overrides and Content Registrations
    remove_filter('the_content', 'wptexturize');
    add_shortcode('wp_caption', 'cl_img_caption_shortcode');
    add_shortcode('caption', 'cl_img_caption_shortcode');

    register_nav_menus(array(
        'main' => 'Main Menu',
        'sidenav_about_us' => 'Sidenav About Us Menu',
        'sidenav_our_people' => 'Sidenav Our People Menu',
        'sidenav_our_work' => 'Sidenav Our Work Menu',
        'sidenav_outreach_and_impacts' => 'Sidenav Outreach and Impacts Menu',
        'sidenav_events_and_programs' => 'Sidenav Events and Programs Menu',
        'sidenav_news' => 'Sidenav News Menu',
        'sidenav_contact_us' => 'Sidenav Contact Us Menu',
    ));

    register_sidebar(array(
        'name' => 'Sidebar Widget Area',
        'id' => 'sidebar-widget-area',
        'description' => 'The primary sidebar widget area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));


//Core function overrides via Hooks
    function cl_img_caption_shortcode($attr, $content = null) {

        // Allow plugins/themes to override the default caption template.
        $output = apply_filters('img_caption_shortcode', '', $attr, $content);
        if ( $output != '' )
            return $output;

        extract(shortcode_atts(array(
            'id'    => '',
            'align' => 'alignnone',
            'width' => '',
            'caption' => ''
        ), $attr));

        if ( 1 > (int) $width || empty($caption) )
            return $content;

        if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

        $id_name = substr($id, strpos($id, '"')+1, (strrpos($id, '"')-strlen($id)));
        $post_id = substr($id_name, 11);
        list($medium_source, $medium_width, $medium_height) = wp_get_attachment_image_src($post_id, 'medium');

        return '<div '.$id.' class="wp-caption '.esc_attr($align).'" style="width: '.(2+(int)$width).'px">
                    <div class="wp-caption-image">
                        '.do_shortcode($content).'
                        <span class="details">
                            <span class="medium_source">'.$medium_source.'</span>
                            <span class="medium_width">'.$medium_width.'</span>
                            <span class="medium_height">'.$medium_height.'</span>
                        </span>
                    </div>
                    <p class="wp-caption-text">'.$caption.'</p>
                </div>';
    }


//API Functions
  
    function get_api_data($uri){
        $url = 'http://'.$_SERVER['SERVER_NAME'].$uri;
        $raw_result = simple_curl($url);
        return json_decode($raw_result);
    }


//General Functions

    function trap($function, $args = ''){
        //This is a work-around for an absurd API.
        //Many WordPress functions only echo values instead of returning
        //Using output buffers this function returns the value as a value
        if( function_exists($function) ){
            ob_start();
            call_user_func($function, $a);
            $return = ob_get_contents();
            ob_end_clean();
            return $return;
        }else{ return FALSE; }
    }

    function page_number(){
        global $paged;
        return ($paged > 0) ? $paged : NULL;
    }

    function create_uri_array($uri_string){
        $adjustments = array(
            'news-and-events' => 'News & Events'
        );
        if( $uri_string ){
            $uri = explode( "/", $uri_string );     //Create Array
            $uri = array_filter($uri);              //Remove Empty Values
            $uri = array_values($uri);              //Reset Keys
            foreach($uri as $key => $val ){         //Remove any extensions (.php, query strings etc)
                if( strpos($val, '.') !== false ){
                    $uri[$key] = substr($val, 0, strpos($val, '.'));
                }
                if( isset($adjustments[$val]) ){
                    $uri[$key] = $adjustments[$val];
                }
                if( strpos($val, '?s') === 0 ){
                    $uri[$key] = 'search';
                }
            }unset($key, $val);
            return $uri;
        }else{ return false; }
    }

    function wp_breadcrumbs($limit = NULL, $echo = TRUE){
        // if( strpos($_SERVER['REQUEST_URI'], '?') === FALSE ){ $request_uri = $_SERVER['REQUEST_URI']; }
        // else{ $request_uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')); }
        $uri = create_uri_array($_SERVER['REQUEST_URI']);
        $uri_depth = count($uri);
        $uri = ($uri_depth >= 4) ? array_slice($uri, 0, 4) : $uri;
        $url = '/';
        $separator = '&nbsp;&nbsp;&gt;&nbsp;&nbsp;';
        $breadcrumbs = array();
        $replacements = array('?s' => 'Search');
        $substr_replacements = array('bama' => 'BA/MA');

        $breadcrumbs[] = ($uri_depth > 0) ? '<a class="home" href="/">Home</a>' : '<a class="home" href="/">Home</a>';
        for($i = 0; $i <= ($uri_depth-1); $i++){
            $url .= $uri[$i].'/';

            foreach($replacements as $key=>$val){
                if( strpos(strtolower($uri[$i]), $key) !== FALSE ){ $uri[$i] = $val; }
            }unset($key, $val);

            foreach($substr_replacements as $key=>$val){
                if( strpos(strtolower($uri[$i]), $key) !== FALSE ){ $uri[$i] = str_replace($key, $val, $uri[$i]); }
            }unset($key, $val);

            if( $i == ($uri_depth-1) ){ $breadcrumbs[] = '<span class="last">'.clean_slug($uri[$i]).'</span>'; }
            else{ $breadcrumbs[] = '<a href="'.$url.'">'.clean_slug($uri[$i]).'</a>'; }
        }unset($i);

        if( is_numeric($limit) ){ $breadcrumbs = array_slice($breadcrumbs, 0, $limit); }

        if( $echo === TRUE ){ echo (count($breadcrumbs) > 0) ? '<div id="breadcrumbs">'.implode($separator, $breadcrumbs).'</div>' : ''; }
        else{ return (count($breadcrumbs) > 1) ? '<div id="breadcrumbs">'.implode($separator, $breadcrumbs).'</div>' : ''; }
    }

    function clean_slug($slug){
        return ucwords( trim( strtr( strtr( $slug, "-", " " ), "_", " " ) ) );
    }


//WordPress functions from default theme

    if( !function_exists('cat_list') ){

        function cat_list() {
            return term_list('category', ', ', 'Categories: %s', 'Also posted in %s');
        }

    }

    if( !function_exists('tag_list') ){

        function tag_list() {
            return term_list( 'post_tag', ', ', 'Tags: %s', 'Also tagged %s');
        }

    }

    if( !function_exists('term_list') ){

        /**
         * Updated v.1.0.1
         * CL
         */

        function term_list($taxonomy, $glue = ', ', $text = '', $also_text = '') {

            global $post, $wp_query;
            $current_term = $wp_query->get_queried_object();
            $terms = wp_get_object_terms($post->ID, $taxonomy);

            // If we're viewing a Taxonomy page..
            if ( isset( $current_term->taxonomy ) && $taxonomy == $current_term->taxonomy ) {

                // Remove the term from display.
                foreach ( $terms as $key => $term ) {
                    if ( $term->term_id == $current_term->term_id ) {
                        unset( $terms[$key] );
                        break;
                    }
                }

                // Change to Also text as we've now removed something from the terms list.
                $text = $also_text;

            }

            $tlist = array();
            $rel = 'category' == $taxonomy ? 'rel="category"' : 'rel="tag"';
            foreach ( (array) $terms as $term ) {
                $tlist[] = '<a href="' . get_term_link( $term, $taxonomy ) . '" title="' . esc_attr( sprintf('View all posts in %s', $term->name ) ) . '" ' . $rel . '>' . $term->name . '</a>';
            }

            if ( ! empty( $tlist ) )
                return sprintf( $text, join( $glue, $tlist ) );
            return '';
        }

    }


//Functions for interacting with CI Access library

    function user_verify($verb, $type, $arguments){
        if( ! class_exists('Services_JSON') ){
            include($_SERVER['DOCUMENT_ROOT'] . '/site-wordpress/wp-includes/class-json.php');
        }
        $json = new Services_JSON;

        $uri = array();
        $uri[] = $verb;
        $uri[] = $type;
        $uri[] = $arguments;
        $result = simple_curl('http://'.$_SERVER['SERVER_NAME'].'/login/verify/'.implode('/', $uri), TRUE);
        return $json->decode($result) === TRUE;
    }

    function user_require($verb, $type, $arguments, $redirect = ''){
        if( user_verify($verb, $type, $arguments) ){ return TRUE; }
        $redirect = ($redirect != '' ) ? $redirect : '/login/restricted'.$_SERVER['REQUEST_URI'];
        header('location:'.$redirect); exit();
    }


//Private pages functions

    function the_title_trim($title){
        //Filter out the Private: title
        $pattern[] = '/Private:/';
        $replacement[] = '<span class="wp-title-private">Private:</span>'; // Enter some text to put in place of Private:
        return preg_replace($pattern, $replacement, $title);
    }
    add_filter('the_title', 'the_title_trim');

    function redirect_private_posts($posts, &$wp_query){
        //Catch private pages and redirect
        //Code modified from http://wordpress.stackexchange.com/a/11942

        //Remove filter now, so that on subsequent post querying we don't get involved!
        remove_filter('the_posts', 'redirect_private_posts', 5, 2);

        if( ! ($wp_query->is_page && empty($posts)) ){
            return $posts; // bail, not page with no results
        }

        if( ! empty($wp_query->query['page_id']) ){
            $page = get_page($wp_query->query['page_id']);
        }else{
            $page = get_page_by_path($wp_query->query['pagename']);
        }

        if ( $page && $page->post_status == 'private' ) {
            header('location:/help/private-pages/?from='.$_SERVER['REQUEST_URI']);
            exit();
        }

    }
    if( ! is_admin() ){ add_filter('the_posts', 'redirect_private_posts', 5, 2); }

