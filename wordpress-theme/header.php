<?php
/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */

    include('functions-head.php');
    
?><!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="icon" type="image/x-icon" href="/favicon.png" />

    <title><?php echo (isset($uri) && count($uri) > 0 ) ? create_page_title($uri) : 'CELEST'; ?></title>

    <link rel="stylesheet" href="<?php echo CL_TEMPLATEPATH; ?>/css/skeleton.css" type="text/css" media="all" charset="utf-8"/>
    <link rel="stylesheet" href="<?php echo CL_TEMPLATEPATH; ?>/css/main.css" type="text/css" media="all" charset="utf-8"/>

    <!-- Internet Explorer support for media queries -->
    <!--[if lt IE 9]>
        <script src="<?php echo CL_TEMPLATEPATH; ?>/javascript/respond.min.js"></script>
    <![endif]-->

    <!-- Start WP Head -->
    <!-- <?php //wp_head(); ?> -->
    <!-- End WP Head -->

    <!-- Page content generated on <?php echo date("F j, Y, g:i:s a", @mktime()); ?> -->

</head>

<body <?php body_class(' page-'.implode(' page-', $uri)); ?>>
