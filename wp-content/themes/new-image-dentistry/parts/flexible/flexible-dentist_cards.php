<div class="full about__dentist dentist-cards">
    <div class="grid-container">
        <div class="grid-container grid-container-medium padding-0">
            <?php $title = get_sub_field('title');
            if (!empty($title)) : ?>
                <h2><?php echo $title; ?></h2>
            <?php endif; ?>
            <div class="grid-x align-justify">
                <?php $idsDentists = get_sub_field('relationship');
                if (!empty($idsDentists)) :
                    $dentists = new WP_Query(array(
                        'post_type' => 'dentists',
                        'post__in' => $idsDentists,
                        'post_status' => 'any',
                        'orderby' => 'post__in',
                    ));
                    if ($dentists->have_posts()) {
                        while ($dentists->have_posts()) {
                            $dentists->the_post();
                            get_template_part('parts/loop', 'dentist');
                        }
                    }
                    wp_reset_postdata();
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>