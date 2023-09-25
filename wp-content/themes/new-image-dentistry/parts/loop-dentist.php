<div class="large-6 medium-12 small-12 dentist">
    <div class="grid-x">
        <?php $featuredImage = get_attached_img_url();
        if (!empty($featuredImage)) : ?>
            <div class="medium-5 dentist__image"
                 style="background-image: url('<?php echo $featuredImage; ?>')">
            </div>
        <?php endif; ?>
        <div class="medium-7 dentist__content">
            <h3><?php the_title(); ?></h3>
            <div><?php the_excerpt() ?></div>
            <?php $link = get_the_permalink();
            if (!empty($link)) : ?>
                <a target="_blank" href="<?php echo $link; ?>" class="button"><?php echo __('Learn more'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>