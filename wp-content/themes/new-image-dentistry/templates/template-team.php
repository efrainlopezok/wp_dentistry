<?php
/**
 * Template Name: Our team Page
 */
get_header(); ?>

<main class="team-page">
    <?php $subtitle = get_field('sub_title');
    if (!empty($subtitle)) : ?>
        <div class="grid-container subtitle transform-top">
            <div class="grid-container grid-container-medium">
                <div class="grid-x grid-margin-x">
                    <h2><?php echo $subtitle; ?></h2>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="full padding-0">
        <?php if (have_rows('team')): ?>
            <?php while (have_rows('team')): the_row(); ?>
                <?php
                if (get_row_layout() == 'staff'):
                    get_template_part('parts/flexible/flexible', 'staff');
                endif;
                ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
<?php get_template_part('parts/request-appointment'); ?>

<?php get_footer(); ?>
