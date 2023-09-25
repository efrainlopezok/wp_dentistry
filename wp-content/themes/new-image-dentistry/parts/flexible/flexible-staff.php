<div class="section__team full"
     style="background-color: <?php the_sub_field('background_color'); ?>">
    <div class="grid-container grid-container-medium padding-0">
        <?php the_sub_field('title'); ?>
    </div>
    <div class="grid-container grid-container-medium padding-0">
        <div class="grid-x grid-margin-x">
            <?php $staffIds = get_sub_field('staff');
            if (!empty($staffIds)) :
                $staff = new WP_Query(array(
                    'post_type' => 'our_team',
                    'posts_per_page' => -1,
                    'post__in' => $staffIds,
                    'post_status' => 'any',
                    'orderby' => 'post__in',
                ));
                if ($staff->have_posts()) {


                    while ($staff->have_posts()) {
                        $staff->the_post();
                        $featuredImage = get_attached_img_url();
                        $color = get_sub_field('background_card');
                        $title = get_field('title_team');
                        $location = get_field('location_team');
                        ?>
                        <div class="cell large-4 medium-6 small-12 team">
                            <a href="<?php the_permalink(); ?>">
                                <div class="flip-card-inner">
                                    <div class="flip-card-inner-front"
                                         style="background-image: url('<?php echo $featuredImage; ?>')">
                                    </div>

                                    <div class="cell auto team__content" style="background-color: <?php echo $color; ?>">
                                        <h3><?php the_title(); ?></h3>
                                        <?php if (!empty($title)) : ?>
                                            <h4><?php the_field('title_team'); ?></h4>
                                        <?php endif; ?>
                                        <?php if (!empty($location)) : ?>
                                            <h4 class="location-title"><?php echo $location; ?></h4>
                                        <?php endif; ?>
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <h3 class="position-absolute team__title"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </div>
                    <?php }
                }
                wp_reset_postdata();
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>