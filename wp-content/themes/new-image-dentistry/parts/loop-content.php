<?php
$subtitle = get_field('sub_title');
if (!empty($subtitle)) : ?>
    <div class="grid-container subtitle transform-top">
        <div class="grid-container grid-container-medium">
            <div class="grid-x">
                <h2><?php echo $subtitle; ?></h2>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="full padding-0">
    <?php if (have_rows('flexible')): ?>
        <?php while (have_rows('flexible')): the_row();
            get_template_part('parts/flexible/flexible', get_row_layout());
        endwhile; ?>
    <?php endif; ?>
</div>