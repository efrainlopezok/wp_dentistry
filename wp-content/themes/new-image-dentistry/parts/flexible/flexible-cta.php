<?php $position = get_sub_field('position') == 'center' ? 'center' : 'left';
$color = get_sub_field('background_section');
?>

<div class="section__cta <?php echo $position; ?>" style="background-color: <?php echo $color; ?>">
    <div class="grid-container padding-0">
        <div class="grid-container grid-container-medium padding-0">
            <div class="grid-x">
                <?php $title = get_sub_field('title');
                if (!empty($title)) : ?>
                    <?php echo $title; ?>
                <?php endif; ?>
                <?php $content = get_sub_field('content');
                if (!empty($content)) : ?>
                    <div class="cta__content"><?php echo $content; ?></div>
                <?php endif; ?>
                <div>
                    <?php $button = get_field('button_label_request', 'options');
                    if (!empty($button)) : ?>
                        <button class="button primary-button"
                                data-open="newPatient"><?php echo $button; ?></button>
                    <?php endif;

                     if( have_rows('buttons') ):
                          while ( have_rows('buttons') ) : the_row();
                              $class = get_sub_field('type_button') == 'primary' ? 'primary-button' : ''; ?>
                              <a href="<?php  the_sub_field('link_button'); ?>" class="button <?php echo $class; ?>">
                                  <?php  the_sub_field('label_button'); ?>
                              </a>
                       <?php   endwhile;
                     endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>