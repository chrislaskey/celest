<?php
/**
 * @package WordPress
 * @subpackage CELEST Responsive
 * @since 3.0.0
 */
?>

        </div>
    </div>

    <section id="news-footer">
        <section class="container">
            <section id="news-footer-articles">
                <?php display_news_articles(3); ?>
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

    <!-- Start WP Head -->

    <?php wp_footer(); ?>

    <!-- End WP Head -->

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
