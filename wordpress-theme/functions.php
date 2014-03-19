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


//FileTree class

    class Filetree {

        /**
        * Filetree class creates a list downloadable files in a given directory
        *
        * Supports regex and direct-match string rules for file ommittance (blacklist)
        * There is currently no whitelist support, as things quickly get messy mixing blacklisting
        * and whitelisting.
        */

        private $dir;
        private $rules;
        private $settings;
        private $options;

        public function __construct( $options = array() ){
            $this->parse_options($options);
            $this->initialize_class_variables();
        }

        private function parse_options($options){
            $options['base_directory'] = ( isset($options['base_directory']) ) ? rtrim($options['base_directory'], '/') : '';
            $options['document_root'] = ( isset($options['document_root']) ) ? rtrim($options['document_root'], '/').'/' : rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/';
            $options['download_path'] = ( isset($options['download_path']) ) ? rtrim($options['download_path'], '/').'/' : '';
            $options['debug'] = ( isset($options['debug']) ) ? $options['debug'] : FALSE;
            $options['open_directories'] = ( isset($options['open_directories']) && is_bool($options['open_directories']) ) ? $options['open_directories'] : FALSE;
            $options['show_base_directory'] = ( isset($options['show_base_directory']) && is_bool($options['show_base_directory']) ) ? $options['show_base_directory'] : FALSE;
            $this->options = $options;
        }

        private function initialize_class_variables(){
            $options = $this->options;
            $this->dir = new stdclass();
            $this->dir->base = $this->options['base_directory'];
            $this->dir->root = $this->options['document_root'];
            $this->rules = new stdclass();
            $this->rules->regex = array();
            $this->rules->string = array();
            $this->settings = new stdclass();
            $this->settings->download_path = $this->options['download_path'];
            $this->settings->debug = $this->options['debug'];
            $this->settings->open_directories = $this->options['open_directories'];
            $this->settings->recursion_count = 0;
            $this->settings->recursion_limit = 0; //Turned off. Positive value turns limit on.
            $this->settings->show_base_directory = $this->options['show_base_directory'];
            //* Unimplemented: $last_modified = @filemtime($path);
        }

        public function add_rule($rule, $type = 'string'){
            if( $type == 'string' ){
                $this->rules->string[] = $rule;
                $this->debug('success', 'Added rule: '.$rule.' ('.$type.')');
                return TRUE;
            }elseif( $type == 'regex' ){
                $this->rules->regex[] = $rule;
                $this->debug('success', 'Added rule: '.$rule.' ('.$type.')');
                return TRUE;
            }else{
                $this->debug('error', 'Error adding rule: '.$rule.' ('.$type.')');
                return FALSE;
            }
        }

        public function create_tree(){
            $data = $this->recurse($this->dir->base);
            return '<ul class="filetree">'.$data.'</ul>';
        }

        public function verify($file){
            return $this->pass($file);
        }

        private function recurse($path){
            if( ! $this->pass($path) ){ return FALSE; }

            //Expand Directories
            if( is_dir($this->dir->root.$path) ){

                //Return Files
                $listing = scandir($this->dir->root.$path);

                //Recursion in PHP requires a return statement,
                //but a return statement also terminates the loop.
                //So we have to loop, store the results, then return outside the loop.
                $li = array();

                //Recurse for each item (file or directory)
                foreach($listing as $item){

                    //Remove items starting with .
                    if( substr($item, 0, 1) !== '.' ){

                        //Increase recursion count and check against recursion limit
                        $this->settings->recursion_count++;
                        if( $this->settings->recursion_limit == 0 || $this->settings->recursion_count < $this->settings->recursion_limit ){
                            $li[] = $this->recurse($path.'/'.$item);
                        }else{ $this->debug('error', 'Recursion limit reached: '.$this->settings->recursion_limit); }

                    }

                }unset($listing, $item);
                return $this->create_directory($path, $li);
            }

            if( is_file($this->dir->root.$path) ){
                if( is_readable($this->dir->root.$path) ){
                    return $this->create_file($path);
                }else{
                    $this->debug('error', 'File not readable: '.$this->dir->root.$path);
                }
            }
        }

        private function pass($test){
            $return = TRUE;

            if( count($this->rules->string) > 0 ){
                foreach( $this->rules->string as $rule ){
                    if( stripos($test, $rule) !== FALSE ){
                        $return = FALSE;
                        $this->debug('notice', 'Path does not pass rule test. Path: '.$test.' Rule: '.$rule);
                        break;
                    }
                }unset($rule);
            }

            if( count($this->rules->regex) > 0 ){
                foreach( $this->rules->regex as $rule ){
                    if( preg_match($rule, $test) != NULL ){ //Returns 0 on no match, FALSE on error. Weak typing to the rescue.
                        $return = FALSE;
                        $this->debug('notice', 'Path does not pass rule test. Path: '.$test.' Rule: '.$rule.' Regex Error: '.preg_last_error());
                        break;
                    }
                }unset($rule);
            }
            return $return;
        }

        private function create_file($path){
            $info = pathinfo($path);
            if( ! isset($info['filename']) ){ //Pathinfo doesn't include 'filename' key until php 5.2.0
                $dir_end = ( strrpos($path,'/') !== FALSE ) ? strrpos($path,'/')+1 : 0;
                $info['filename'] = substr($path, $dir_end, strrpos(substr($path, $dir_end),'.'));
            }
            if( ! isset($info['extension']) ){
                $info['extension'] = '';
            }

            return '<li class="ft-file ext-'.$info['extension'].'">
                        <a class="file" href="'.$this->settings->download_path.ltrim($path, '/').'" target="blank">'.$info['basename'].'</a>
                    </li>'."\n";
        }

        private function create_directory($path, $li){
            if( $path == NULL ){
                return implode("\n", $li);
            }

            $info = pathinfo($path);
            if( ! isset($info['filename']) ){ //Pathinfo doesn't include 'filename' key until php 5.2.0
                $dir_end = ( strrpos($path,'/') !== FALSE ) ? strrpos($path,'/')+1 : 0;
                $info['filename'] = substr($path, $dir_end, strrpos(substr($path, $dir_end),'.'));
            }

            $class = ($this->settings->open_directories === TRUE) ? 'open' : 'closed';
            return '<li class="ft-directory">
                        <a href="#">'.$info['basename'].'</a>
                        <ul class="filetree '.$class.'">'.implode("\n", $li).'</ul>
                    </li>'."\n";
        }

        private function debug($type, $message){
            if( $this->settings->debug == 'echo' ){
                echo $type, $message, '<br/>';
            }
        }
    }


//Presentation display functions

    function create_conference_presentation($pres){

        if( $pres->custom != NULL ){

            return $pres->custom;

        }else{

            $entity_filter = array('authors', 'title', 'event', 'location', 'date');
            foreach( $pres as $key => $val ){
                if( in_array($key, $entity_filter) ){
                    $val = trim($val);
                    $val = htmlentities($val, ENT_COMPAT, 'UTF-8');
                    $pres->$key = $val;
                }
            }unset($key, $val);

            if( $pres->authors != NULL ){
                $authors = ($pres->authors != NULL) ? '<span class="presentation_author">'.$pres->authors.'</span>'  : '';
                $year = ($pres->year != NULL ) ?  ' (<span class="presentation_year">'. $pres->year .'</span>). ' : '';
            }else{
                $authors = '';
                $year = '';
            }

            if( $pres->title == NULL ){ $title = ''; }
            else{
                $punctuation = ( has_punctuation($pres->title) ) ? '' : '.';
                $title = '<span class="presentation_title">'. $pres->title .'</span>'.$punctuation;
            }

            if( $pres->event_prefix == NULL ){ $event_prefix = ' '; }
            else{
                $event_prefix = ' <span class="presentation_event_prefix">'. $pres->event_prefix .'</span> ';
            }

            if( $pres->event == NULL ){ $event = ''; }
            else{
                $punctuation = ($pres->location != NULL || $pres->date != NULL) ? ', ' : '';
                if( $pres->event_type == 'italic' ){
                    $event = '<span class="presentation_event presentation_type_'.$pres->event_type.'"><em>'. $pres->event .'</em></span>'.$punctuation;
                }elseif( $pres->event_type == 'bold' ){
                    $event = '<span class="presentation_event presentation_type_'.$pres->event_type.'"><strong>'. $pres->event .'</strong></span>'.$punctuation;
                }else{
                    $event = '<span class="presentation_event presentation_type_normal">'. $pres->event .'</span>'.$punctuation;
                }
            }

            if( $pres->location == NULL ){ $location = ''; }
            else{
                $punctuation = ($pres->date != NULL) ? ', ' : '';
                $location = ' <span class="presentation_location">'. $pres->location .'</span>'.$punctuation;
            }

            if( $pres->date == NULL ){ $date = ''; }
            else{
                $date = ' <span class="presentation_date">'. $pres->date .'</span>';
            }

            return '<div class="presentation conferencePresentation">'.$authors.$year.$title.$event_prefix.$event.$location.$date.'.</div>';

        }

    }

    function create_nonconference_presentation($pres){

        if( $pres->custom != NULL ){

            return $pres->custom;

        }else{

            $entity_filter = array('authors', 'title', 'event', 'location', 'date');
            foreach( $pres as $key => $val ){
                if( in_array($key, $entity_filter) ){
                    $val = trim($val);
                    $val = htmlentities($val, ENT_COMPAT, 'UTF-8');
                    $pres->$key = $val;
                }
            }unset($key, $val);

            //Determine Author and Year
            if( $pres->authors != NULL ){
                $authors = ($pres->authors != NULL) ? '<span class="presentation_author">'.$pres->authors.'</span>'  : '';
                $year = ($pres->year != NULL ) ?  ' (<span class="presentation_year">'. $pres->year .'</span>). ' : '';
            }else{
                $authors = '';
                $year = '';
            }

            if( $pres->title == NULL ){ $title = ''; }
            else{
                $punctuation = ( has_punctuation($pres->title) ) ? '' : '.';
                $title = '<span class="presentation_title">'. $pres->title .'</span>'.$punctuation;
            }

            if( $pres->event_prefix == NULL ){ $event_prefix = ' '; }
            else{
                $event_prefix = ' <span class="presentation_event_prefix">'. $pres->event_prefix .'</span> ';
            }

            if( $pres->event == NULL ){ $event = ''; }
            else{
                $punctuation = ($pres->location != NULL || $pres->date != NULL) ? ', ' : '';
                if( $pres->event_type == 'italic' ){
                    $event = '<span class="presentation_event presentation_type_'.$pres->event_type.'"><em>'. $pres->event .'</em></span>'.$punctuation;
                }elseif( $pres->event_type == 'bold' ){
                    $event = '<span class="presentation_event presentation_type_'.$pres->event_type.'"><strong>'. $pres->event .'</strong></span>'.$punctuation;
                }else{
                    $event = '<span class="presentation_event presentation_type_normal">'. $pres->event .'</span>'.$punctuation;
                }
            }

            if( $pres->location == NULL ){ $location = ''; }
            else{
                $punctuation = ($pres->date != NULL) ? ', ' : '';
                $location = ' <span class="presentation_location">'. $pres->location .'</span>'.$punctuation;
            }

            if( $pres->date == NULL ){ $date = ''; }
            else{
                $date = ' <span class="presentation_date">'. $pres->date .'</span>';
            }

            return '<div class="presentation nonconferencePresentation">'.$authors.$year.$title.$event_prefix.$event.$location.$date.'.</div>';

        }

    }


// Publication functions

    function create_book_publication($pub){

        if( $pub->custom != NULL ){

            return $pub->custom;

        }else{

            $entity_filter = array('authors', 'article_title', 'editors', 'title', 'pages', 'publisher');
            foreach( $pub as $key => $val ){
                if( in_array($key, $entity_filter) ){
                    $val = trim($val);
                    $val = htmlentities($val, ENT_COMPAT, 'UTF-8');
                    $pub->$key = $val;
                }
            }unset($key, $val);

            if( $pub->authors == NULL ){ $authors = ''; }
            else{
                $authors = '<span class="publication_author">'.$pub->authors.'</span>';
            }

            if( $pub->year == NULL ){ $year = ''; }
            else{
                $year = '<span class="publication_year">'.$pub->year.'</span>';
            }

            if( $pub->article_title == NULL ){ $article_title = ''; }
            else{
                $punctuation = ( has_punctuation($pub->article_title) ) ? ' ' : '. ';
                $article_title = '<span class="publication_article_title">'. $pub->article_title .'</span>'.$punctuation;
            }

            //Get Editors and Publication Title
            if( $pub->title == NULL && $pub->editors == NULL ){ $publication = ''; }
            else{
                //Get Pieces
                $eds = ($pub->multiple_editors == 1 ) ? ' (Eds.)' : ' (Ed.)';
                $editors_punctuation = ($pub->title != NULL) ? ', ' : '';
                $editors = ( $pub->editors != NULL ) ? '<span class="publication_editors">'. $pub->editors. ' '. $eds. '</span>'. $editors_punctuation : '';
                $pubtitle = ($pub->title != '' ) ? '<span class="publication_title"><strong>'. $pub->title .'</strong></span>' : '';
                $publication = 'In ' . $editors . $pubtitle;
                unset($eds, $editors, $pubtitle);
            }

            //Determine if "in press" should be used based on Book vs. Book Title, then by Year
            if( isset($pub->is_author) && $pub->is_author != 1 ){
                $show_in_press = ($pub->year < (date('Y', @mktime())-1) ) ? false : true;
            }else{ $show_in_press = false; }

            //Get Publisher
            if( $pub->city != NULL && $pub->publisher != NULL && $pub->pages == NULL ){

                $in_press = ($show_in_press === true) ? ', in press.' : '.';
                $publisher = '<span class="publication_city">'. $pub->city .'</span>: <span class="publication_publisher">'. $pub->publisher .'</span>'. $in_press;

            }elseif( $pub->city == NULL && $pub->publisher != NULL && $pub->pages == NULL ){

                $in_press = ($show_in_press === true) ? ', in press.' : '.';
                $publisher = '<span class="publication_publisher">'. $pub->publisher .'</span>'. $in_press;

            }elseif( $pub->city == NULL && $pub->publisher != NULL && $pub->pages != NULL ){

                $publisher = '<span class="publication_publisher">'. $pub->publisher .'</span>, <span class="publication_pages">pp.'. $pub->pages .'</span>.';

            }elseif( $pub->city == NULL && $pub->publisher == NULL && $pub->pages != NULL ){

                $publisher = '<span class="publication_pages">pp.'. $pub->pages .'</span>.';

            }elseif( $pub->city != NULL && $pub->publisher != NULL && $pub->pages != NULL ){

                $publisher = '<span class="publication_city">'. $pub->city .'</span>: <span class="publication_publisher">'. $pub->publisher .'</span>, <span class="publication_pages">pp.'. $pub->pages .'</span>.';

            }else{

                $publisher = ($show_in_press === true) ? 'In press.' : '';

            }

            //Get Editors and Publication Title Punctuation
            if( $publication != NULL ){
                $publication .= ( $publisher == 'In press.' ) ? ', ' : '. ';
            }

            //Return Publication
            return '<div class="publication bookPublication">' . $authors . ' (' . $year . '). ' . $article_title . $publication . $publisher . '</div>';

        }

    }

    function create_peer_publication($pub){

        if( $pub->custom != NULL ){

            return $pub->custom;

        }else{

            $entity_filter = array('authors', 'article_title', 'title', 'pages');
            foreach( $pub as $key => $val ){
                if( in_array($key, $entity_filter) ){
                    $val = trim($val);
                    $val = htmlentities($val, ENT_COMPAT, 'UTF-8');
                    $pub->$key = $val;
                }
            }unset($key, $val);

            if( $pub->authors == NULL ){ $authors = ''; }
            else{
                $authors = '<span class="publication_author">'.$pub->authors.'</span>';
            }

            if( $pub->year == NULL ){ $year = ''; }
            else{
                $year = '<span class="publication_year">'.$pub->year.'</span>';
            }

            if( $pub->article_title == NULL ){ $article_title = ''; }
            else{
                $punctuation = ( has_punctuation($pub->article_title) ) ? ' ' : '. ';
                $article_title = '<span class="publication_article_title">'. $pub->article_title .'</span>'.$punctuation;
            }

            $show_in_press = ($pub->year < (date('Y', @mktime())-1)) ? false : true;

            if( $pub->title == NULL && $pub->volume == NULL && $pub->pages == NULL && $show_in_press === TRUE){

                $pubtitle = 'Submitted for publication.';

            }elseif( $pub->title != NULL && $pub->volume == NULL && $pub->pages == NULL ){

                $in_press = ( $show_in_press === TRUE ) ? ', in press.' : '.';
                $pubtitle = '<span class="publication_title"><em>'.$pub->title.'</em></span>'.$in_press;

            }else{

                $title = ($pub->title != NULL ) ? '<span class="publication_title"><em>'.$pub->title.'</em></span>' : '';
                $volume = ($pub->volume != NULL ) ? ', <span class="publication_volume"><strong>'.$pub->volume.'</strong></span>' : '';
                $pages = ($pub->pages != NULL ) ? ', <span class="publication_pages">'.$pub->pages.'</span>' : '';
                $pubtitle = $title.$volume.$pages;
                if( $pubtitle != NULL ){ $pubtitle .= '.'; }
                unset($title, $volume, $pages);

            }

            return '<div class="publication peerPublication">' .$authors.' ('.$year.'). '.$article_title.' '.$pubtitle.'</div>';

        }

    }

/* End of file functions.php */
