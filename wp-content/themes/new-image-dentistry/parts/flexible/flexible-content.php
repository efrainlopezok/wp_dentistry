<div class="grid-container padding-0">
    <div class="grid-container grid-container-medium padding-0">

        <div class="section__content content">
            <?php $title = get_sub_field('title') ?>
            <?php if ($title): ?>
                <h2><?php echo $title; ?></h2>
            <?php endif; ?>
            <div class="grid-x">
                <div class="cell large-auto ">
                    <?php the_sub_field('content') ?>
                    <div class="show-for-large">
                        <?php if (have_rows('buttons')):
                            while (have_rows('buttons')) : the_row();
                                $class = get_sub_field('type_button') == 'primary' ? 'primary-button' : ''; ?>
                                <p><a href="<?php the_sub_field('link_button'); ?>"
                                      class="button <?php echo $class; ?>">
                                        <?php the_sub_field('label_button'); ?></a></p>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>
                <?php
                $gallery_checkbox = get_sub_field('gallery_checkbox');
                $gallery = get_sub_field('gallery');
                if ($gallery && $gallery_checkbox): ?>
                    <div class="cell large-auto gallery__content padding-left-3 text-center">
                        <ul class="list-image">
                            <?php foreach ($gallery as $image): ?>
                                <li>
                                    <img src="<?php echo $image['sizes']['gallery']; ?>"
                                         alt="<?php echo $image['alt']; ?>"/>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="hide-for-large">
                    <?php if (have_rows('buttons')):
                        while (have_rows('buttons')) : the_row();
                            $class = get_sub_field('type_button') == 'primary' ? 'primary-button' : ''; ?>
                            <p><a href="<?php the_sub_field('link_button'); ?>" class="button <?php echo $class; ?>">
                                    <?php the_sub_field('label_button'); ?></a></p>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>