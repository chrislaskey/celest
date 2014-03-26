<?php
/**
 * Template Name: Redirect
 *
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

$redirect = get_post_meta($post->ID, 'redirect', TRUE);	
if( empty($redirect) ){ $redirect = '/'; }

header('location:'.$redirect);
exit();

/* End of file template-redirect.php */
