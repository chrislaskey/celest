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
			'id'	=> '',
			'align'	=> 'alignnone',
			'width'	=> '',
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
