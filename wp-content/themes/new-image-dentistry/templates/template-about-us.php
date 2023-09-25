<?php
/**
 * Template Name: About us Page
 */
get_header(); ?>


    <!--END of HOME PAGE SLIDER-->

    <!-- BEGIN of main content -->
    <main class="about-page">
        <?php $subtitle = get_field('sub_title');
        if (!empty($subtitle)) : ?>
            <div class="grid-container subtitle transform-top transform-top-about">
                <div class="grid-container grid-container-medium">
                    <div class="grid-x">
                        <h2><?php echo $subtitle; ?></h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="grid-container about__content">
            <div class="grid-container grid-container-medium padding-0">
                <div class="grid-x">
                    <div class="medium-4 about__title">
                        <?php $title = get_field('title_content_about');
                        if (!empty($title)) : ?>
                            <h2><?php echo $title; ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="medium-8 padding-left-3 about__text">
                        <?php $content = get_field('text_content_about');
                        if (!empty($content)) :
                            echo $content;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container about__services">
            <div class="grid-container grid-container-medium">
                <?php $title = get_field('title_services_about');
                if (!empty($title)) : ?>
                    <h2> <?php echo $title; ?></h2>
                <?php endif; ?>
                <div class="grid-x">
                    <?php if (have_rows('repeater_about-us')):
                        while (have_rows('repeater_about-us')) : the_row();
                            $image = get_sub_field('image'); ?>
                            <div class="cell large-auto text-center">
                                <a href="<?php the_sub_field('link') ?>">
                                <?php display_svg($image); ?>
                                 <h3><?php the_sub_field('title'); ?></h3>
                                </a>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
            </div>
        </div>

        <div class="full about__dentist transform-top">
            <div class="grid-container">
                <div class="grid-container grid-container-medium padding-0">
                    <?php $title = get_field('title_dentists_about');
                    if (!empty($title)) : ?>
                        <h2><?php echo $title; ?></h2>
                    <?php endif; ?>
                    <div class="grid-x align-justify">
                        <?php $idsDentists = get_field('our_dentists_about');
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
        <?php get_template_part('/parts/request-appointment') ?>
        <!-- END of main content -->
    </main>
<?php get_footer(); ?>