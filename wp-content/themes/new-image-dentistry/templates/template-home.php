<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

    <div class="grid-container section__general transform-top">
        <div class="grid-container grid-container-medium">
            <div class="grid-x">
                <div class="medium-5 small-12 padding-right-2">
                    <?php
                    $title = get_field('title_information');
                    if (!empty($title)) :
                        echo $title;
                    endif; ?>
                </div>
                <div class="medium-7 small-12">
                    <?php $text = get_field('content_information');
                    if (!empty($text)) : ?>
                        <p><?php echo $text; ?></p>
                    <?php endif; ?>
                    <?php $button = get_field('button_label_information');
                    if (!empty($button)) : ?>
                        <a href="<?php the_field('button_link_information') ?>" class="button">
                            <?php echo $button; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-container section__services">
        <div class="grid-container grid-container-medium padding-0">
            <div class="grid-x">
                <?php
                if (have_rows('repeater_services')):
                    while (have_rows('repeater_services')) : the_row();
                        $image = get_sub_field('image'); ?>
                        <div class="medium-6 service">
                            <a href="<?php the_sub_field('link'); ?>">
                                <div class="grid-x align-middle service__item">
                                    <div class="medium-4 small-4 service__img">
                                        <?php display_svg($image); ?>
                                    </div>
                                    <div class="cell-auto service__title">
                                        <h4>
                                            <?php the_sub_field('title'); ?>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="full section__dentists">
        <div class="grid-container grid-container-medium padding-0">
            <h2><?php the_field('title_dentists') ?></h2>
        </div>
        <div class="grid-container padding-0 dentist__block">
            <div class="grid-x">
                <div class="grid-container-medium grid-container dentists__slider">
                    <?php
                    $ids = get_field('our_dentists');
                    if (!empty($ids)) :
                        $dentists = new WP_Query(array(
                            'post_type' => 'dentists',
                            'post__in' => $ids,
                            'post_status' => 'any',
                            'orderby' => 'post__in',
                        ));
                        if ($dentists->have_posts()) {
                            while ($dentists->have_posts()) {
                                $dentists->the_post(); ?>
                                <div class="cell">
                                    <div class="grid-x grid-margin-x align-middle">
                                        <?php $image = get_field('second_featured_image');
                                        if (!empty($image)) : ?>
                                            
                                            <div class="medium-5 small-12 align-center dentists__img">
                                                <?php 
                                                /* grab the url for the full size featured image */
                                                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
                                                if ($featured_img_url != '') {
                                                    $img_feature = $featured_img_url;
                                                }else{
                                                    $img_feature = $image['url'];
                                                }
                                                ?>
                                                <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $img_feature; ?>"
                                                     alt="<?php echo $image['alt']; ?>" data-no-lazy="">
                                                     </a>
                                            </div>
                                            
                                        <?php else : ?>
                                            <div class="dentists__img--empty"></div>
                                        <?php endif; ?>
                                        <div class="cell medium-auto small-12 dentists__content">
                                            <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <?php $excerpt = get_field('excerpt_dentist');
                                            if (!empty($excerpt)) : ?>
                                                <p><?php echo $excerpt; ?></p>
                                            <?php endif; ?>
                                            <a href="<?php the_permalink(); ?>" class="button">
                                                <?php echo __('Learn more') ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                        wp_reset_postdata();
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php $image = get_field('background_image') ?>
        <div class="full background--section" <?php bg($image, 'full_hd'); ?>>
            <div class="grid-container padding-0 margin-top-3">
                <div class="grid-x grid-margin-x align-justify">
                    <?php if (have_rows('repeater_information')):
                        while (have_rows('repeater_information')) :
                            the_row();
                            $image = get_sub_field('image'); ?>
                            <div class="medium-6 cell">
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"
                                     data-no-lazy="">
                                <h4><?php the_sub_field('title'); ?></h4>
                                <div> <?php the_sub_field('content'); ?></div>
                                <?php $count = count(get_sub_field('buttons_repeater')) > 1 ?
                                    'align-justify' : 'align-center'; ?>
                                <div class="grid-x grid-margin-x buttons-group <?php echo $count ?>">
                                    <?php if (have_rows('buttons_repeater')):
                                        while (have_rows('buttons_repeater')) :
                                            the_row();
                                            $button = get_sub_field('show_in_mobile') ? '' : 'hide-for-small-only'; ?>
                                            <a href="<?php the_sub_field('button_link'); ?>" class="button
                                                <?php echo $button; ?>">
                                                <?php the_sub_field('button_label'); ?>
                                            </a>
                                        <?php
                                        endwhile;
                                    endif; ?>
                                </div>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="section__testimonials">
        <div class="grid-container">
            <h2><?php the_field('title_testimonials') ?></h2>
            <div class="grid-x  slick__testimonial">
                <?php $idsTestimonials = get_field('testimonials_relationship');
                if (!empty($ids)) :
                    $testimonials = new WP_Query(array(
                        'post_type' => 'testimonials',
                        'post__in' => $idsTestimonials,
                        'post_status' => 'any',
                        'orderby' => 'post__in',
                    ));
                    if ($testimonials->have_posts()) {
                        while ($testimonials->have_posts()) {
                            $testimonials->the_post(); ?>
                            <div class=" cell">
                                <img src="<?php echo get_template_directory_uri() . '/images/stars.png' ?>"
                                     alt="starts" data-no-lazy='true'>
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_content() ?></p>
                                <span><?php the_field('author'); ?></span>
                            </div>
                        <?php }
                    }
                    wp_reset_postdata();
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="section__location" id="location">
        <div class="grid-container grid-container-medium padding-0">
            <h2><?php the_field('title_locations') ?></h2>
            <div class="grid-x align-justify margin-top-3">
                <?php $idsLocations = get_field('locations_relationship');
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
<?php get_template_part('parts/request-appointment'); ?>
    <!-- END of main content -->

<?php get_footer(); ?>