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

    <div id="top-sections-container">
        <div id="top-sections">

            <header>

                <ul id="nav" class="container">
                    <li><a class="home" href="/">Home</a></li>
                    <li><a class="about-us" href="/about-us">About Us</a></li>
                    <li><a class="our-people" href="/our-people">Our People</a></li>
                    <li class="selected"><a class="our-work" href="/our-work">Our work</a></li>
                    <li><a class="outreach-and-impacts" href="/outreach-and-impacts">Outreach &amp; Impacts</a></li>
                    <li><a class="events-and-programs" href="/events-and-programs">Events &amp; Programs</a></li>
                    <li><a class="news" href="/news">News</a></li>
                    <li><a class="contact"  href="/contact">Contact</a></li>
                </ul>

                <section id="nav-mobile" class="container">
                    <form action="" method="post">  
                        <select>
                            <option value="">Navigation</option>
                            <option value="">&nbsp;</option>
                            <option value="/">Home</option>
                            <option value="/about-us">About Us</option>
                            <option value="/our-people">Our People</option>
                            <option value="/our-work">Our Work</option>
                            <option value="/outreach-and-impacts">Outreach &amp; Impacts</option>
                            <option value="/events-and-programs">Events &amp; Programs</option>
                            <option value="/news">News</option>
                            <option value="/contact">Contact</option>
                        </select>
                    </form>
                </section>

            </header>

            <section id="logo-section">
                <div id="logo-content" class="container">
                    <a id="logo" href="/">CELEST</a>
                    <div id="logo-subheader">
                        <span id="subheader-celest">Center of Excellence for Learning in Education, Science and Technology</span>
                        <span id="subheader-nsf">A National Science Foundation Science of Learning Center</span>
                    </div>
                </div>
            </section>

            <section id="main" class="container clearfix">
                <section id="sidebar" class="five columns alpha">
                    <?php include(TEMPLATEPATH.'/sidebar.php'); ?>
                </section>

                <section id="content-container" class="eleven columns omega">
