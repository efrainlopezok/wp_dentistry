<div class="grid-container padding-0">
    <div class="grid-container grid-container-medium padding-0">
        <div class="grid-x">
            <div class="section__accordion">
                <?php if (have_rows('repeater_accordion')): ?>
                    <div class="vertical menu accordion-menu" data-accordion data-allow-all-closed="true">
                        <?php
                        $count = 1;
                        while (have_rows('repeater_accordion')) : the_row(); ?>
                            <li class="accordion-item <?php if ($count === 1) echo 'is-active'; ?> "
                                data-accordion-item>
                                <a href="#" class="accordion-title"><?php the_sub_field('title'); ?></a>
                                <div class="accordion-content" data-tab-content>
                                    <?php the_sub_field('content'); ?>
                                </div>
                            </li>
                            <?php
                            $count++;
                        endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>