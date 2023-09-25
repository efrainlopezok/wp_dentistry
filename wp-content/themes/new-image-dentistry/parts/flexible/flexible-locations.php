<div class="section__location" id="location">
    <div class="grid-container grid-container-medium padding-0">
        <h2><?php the_sub_field('title') ?></h2>
        <div class="grid-x align-justify margin-top-3">
            <?php $idsLocations = get_sub_field('locations');
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
