<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>
<div class="error-404 not-found alignwide mx-auto common-space bottom-footer-padding">
    <div class="page-content text-center">
        <h1><?php _e( '404', 'twentytwenty' ); ?></h1>
        <h2>Page Not Found</h2>
        <p><?php esc_html_e('The page you were looking for could not be found.', 'twentytwentyone'); ?></p>
        <a href="http://webprojects.cloud/wordpress/three-feathers-realty/" class="theme-btn">Go Back Home</a>
        <!-- <?php /* get_search_form(); */ ?> -->
    </div><!-- .page-content -->
</div><!-- .error-404 -->

<?php
get_footer();