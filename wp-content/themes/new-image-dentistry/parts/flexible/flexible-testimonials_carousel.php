<div class="section__testimonials">
    <div class="grid-container">
        <h2><?php the_sub_field('title') ?></h2>
        <div class="grid-x  slick__testimonial">
            <?php $idsTestimonials = get_sub_field('relationship');
            if (!empty($idsTestimonials)) :
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