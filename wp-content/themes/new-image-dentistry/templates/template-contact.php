<?php
/**
 * Template Name: Contact us Page
 */
get_header(); ?>


    <!--END of HOME PAGE SLIDER-->

    <!-- BEGIN of main content -->
    <main class="contact-page">
        <?php $subtitle = get_field('sub_title');
        if (!empty($subtitle)) : ?>
            <div class="grid-container subtitle transform-top">
                <div class="grid-container grid-container-medium">
                    <div class="grid-x">
                        <h2><?php echo $subtitle; ?></h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="section__location">
            <div class="grid-container grid-container-medium padding-0">
                <h2><?php the_field('title_contact'); ?></h2>
                <div class="grid-x grid-margin-x align-justify margin-top-3">
                    <?php $idsLocations = get_field('location_contact');
                    if (!empty($idsLocations)) :
                        $locations = new WP_Query(array(
                            'post_type' => 'location',
                            'post__in' => $idsLocations,
                            'post_status' => 'any',
                            'orderby' => 'post__in',
                        ));
                        if ($locations->have_posts()) {
                            while ($locations->have_posts()) {
                                $locations->the_post();
                                get_template_part('parts/loop', 'location');
                            }
                        }
                        wp_reset_postdata();
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <div class="full section__feedback">
            <div class="grid-container">
                <div class="grid-container grid-container-medium padding-0">
                    <h2><?php the_field('title_feedback'); ?></h2>
                    <div class="grid-x">
                        <?php echo do_shortcode('[contact-form-7 id="195" title="Send us a message"]'); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part('/parts/request-appointment') ?>
        <!-- END of main content -->
    </main>
<?php get_footer(); ?>