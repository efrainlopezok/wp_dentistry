<?php
/**
 * Template Name: Dental Procedure Page
 * Template Post Type: procedures, page
 */
get_header(); ?>
    <main class="procedure-page">
        <?php get_template_part('parts/loop-content'); ?>
    </main>
<?php get_template_part('parts/request-appointment'); ?>

    <!-- END of main content -->

<?php get_footer(); ?>