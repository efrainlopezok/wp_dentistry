<?php $class = get_field('open') ? 'open' : ''; ?>
<div class="large-6 medium-12 small-12 location <?php echo $class; ?>">
    <div class="grid-x">
        <?php $featuredImage = get_attached_img_url();
        if (!empty($featuredImage)) : ?>
            <div class="medium-5 small-12 location__image" style="background-image: url('<?php echo $featuredImage; ?>')">
            </div>
        <?php endif; ?>
        <div class="medium-7 small-12 location__content">
            <h3><?php the_title(); ?></h3>
            <div><?php the_content() ?></div>
            <?php $link = get_field('link_on_map');
            if (!empty($link)) : ?>
                <a target="_blank" href="<?php echo $link; ?>" class="button"><?php echo __('View on map'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>