<?php
/**
 * Footer
 */
?>

<!-- BEGIN of footer -->
<footer class="footer">
    <div class="grid-container grid-container-medium padding-0 footer__top">
        <div class="grid-x grid-margin-x">
            <div class="large-3 medium-6 small-12 cell cell__request">
                <?php $info = get_field('info', 'options');
                if ($info): ?>
                    <img src="<?php echo $info['logo_footer']['link'] ?>" alt="<?php
                    echo $info['logo_footer']['alt'] ?>">
                <?php endif; ?>
                <?php $healthy = get_field('creating_healthy', 'options');
                if ($healthy): ?>
                    <h3><?php echo $healthy['title'] ?></h3>
                    <div><?php echo $healthy['content'] ?></div>
                    <?php $button = get_field('button_label_request', 'options');
                    if (!empty($button)) : ?>
                        <button class="button primary-button" data-open="newPatient">
                            <?php echo $button; ?></button>
                    <?php endif; ?>
                <?php endif; ?>
                <ul class="social-menu">
                    <?php if (have_rows('social_menu', 'options')):
                        while (have_rows('social_menu', 'options')) : the_row(); ?>
                            <li>
                                <a href="<?php the_sub_field('link'); ?>">
                                    <?php the_sub_field('icon'); ?></a>
                            </li>
                        <?php endwhile;
                    endif; ?>
                </ul>
            </div>
            <div class="large-3 medium-6 small-12 cell  cell__locations ">
                <?php $locations = get_field('locations', 'options');
                if ($locations): ?>
                    <h3><?php echo $locations['title'] ?></h3>
                    <?php
                    $locations_relationship = $locations['locations_relationship'];
                    if ($locations_relationship): ?>
                        <ul>
                            <?php foreach ($locations_relationship as $location): ?>
                                <li>
                                    <span><?php echo get_the_title($location->ID); ?></span>
                                    <a href="<?php the_field('link_on_map', $location->ID); ?>">
                                        <?php echo apply_filters('the_content', $location->post_content); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="large-3 medium-6 small-12 cell cell__procedures">
                <?php $procedures = get_field('procedures', 'options');
                if ($procedures): ?>
                    <h3><?php echo $procedures['title'] ?></h3>
                    <?php if (has_nav_menu('procedures')) {
                        wp_nav_menu(array('theme_location' => 'procedures', 'depth' => 1));
                    } ?>
                <?php endif; ?>
            </div>
            <div class="large-3 medium-6 small-12 cell">
                <?php $doctors = get_field('our_doctors', 'options');
                if ($doctors): ?>
                    <h3><?php echo $doctors['title'] ?></h3>
                    <?php $doctors_relationship = $doctors['our_doctors_relationship'];
                    if ($doctors_relationship): ?>
                        <ul class="list_doctors">
                            <?php foreach ($doctors_relationship as $doctor): ?>
                                <li>
                                    <a href="<?php echo get_the_permalink($doctor->ID); ?>">
                                        <?php echo get_the_title($doctor->ID); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $office_hours = get_field('office_hours', 'options');
                if ($office_hours): ?>
                    <div class="cell__hours">
                        <h3><?php echo $office_hours['title'] ?></h3>
                        <div>
                            <?php echo $office_hours['office_hours_content'] ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="grid-container footer__bottom">
        <div class="grid-x grid-margin-x">
            <div class="large-12 medium-12 small-12 cell">
                <?php
                if (has_nav_menu('footer-menu')) {
                    wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'menu_class' => 'footer-menu',
                            'depth' => 1,
                        ));
                }
                ?>
                <?php if ($info): ?>
                    <p><?php echo $info['copyright'] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
</body>
</html>
