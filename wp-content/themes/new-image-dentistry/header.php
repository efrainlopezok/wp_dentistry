<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">
    <link rel="stylesheet" href="https://use.typekit.net/osf3aqg.css">
    <?php wp_head(); ?>
	
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151609842-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-151609842-1');
</script>

</head>

<body <?php body_class('no-outline'); ?>>
<?php wp_body_open(); ?>

<!-- <div class="preloader hide-for-medium">
	<div class="preloader__icon"></div>
</div> -->

<!-- BEGIN of header -->
<header class="header">
    <div class="full header__top show-for-large">
        <div class="grid-container menu-grid-container  grid-container-medium padding-0">
            <div class="grid-x">
                <div class="callout clearfix">
                    <ul class="social-menu float-left">
                        <?php if (have_rows('social_menu', 'options')):
                            while (have_rows('social_menu', 'options')) : the_row(); ?>
                                <li>
                                    <a href="<?php the_sub_field('link'); ?>">
                                        <?php the_sub_field('icon'); ?></a>
                                </li>
                            <?php endwhile;
                        endif; ?>
                    </ul>
                    <div class="float-right buttons-group">
                        <?php
                        $link = get_field('parent_forms', 'options');
                        if ($link): ?>
                            <a href="<?php the_field('link_parent_forms', 'options') ?>"><?php echo $link; ?></a>
                        <?php endif; ?>
                        <?php
                        $linkFirst = get_field('find_an_office', 'options');
                        if ($linkFirst):
                            $link_url = get_field('link_find_an_office', 'options'); ?>
                            <a href="<?php echo $link_url; ?>"><?php echo $linkFirst; ?></a>
                        <?php endif; ?>
                        <?php
                        $linkSecond = get_field('phone', 'options');
                        if ($linkSecond): ?>
                            <a class="button blue"
                               href="tel:<?php echo sanitize_number($linkSecond); ?>"><?php echo $linkSecond; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full">
        <?php if (is_front_page()) { ?>
            <div class="section__slider">
                <?php home_slider_template(); ?>
            </div>
        <?php } else { ?>
            <?php if (is_singular('dentists')) {
                $image = get_field('background_image_dentist') ?
                    get_field('background_image_dentist') : get_template_directory_uri() . '/images/team-fon.png';
                $title = get_the_title();
            } elseif (is_singular('our_team')) {
                $image_default = has_post_thumbnail() ?
                    get_attached_img_url(get_the_ID(), 'full_hd') :
                    get_template_directory_uri() . '/images/team-fon.png';
                $image = get_field('second_img_team') ?
                    get_field('second_img_team') : $image_default;
                $title = get_the_title();
            } elseif (is_home()) {
                $image = has_post_thumbnail(get_option('page_for_posts')) ?
                    get_attached_img_url(get_option('page_for_posts'), 'full_hd') :
                    get_template_directory_uri() . '/images/team-fon.png';
                $title = get_the_title(get_option('page_for_posts'));
            } else {
                $image = (has_post_thumbnail()) ?
                    get_attached_img_url(get_the_ID(), 'full_hd') :
                    get_template_directory_uri() . '/images/fon.png';
                $title = get_the_title('');
            } ?>

            <div class="wrapper">
                <div class="default__fon" <?php bg($image); ?>>
                    <div class="grid-container">
                        <div class="grid-container grid-container-medium position-center">
                            <div class="grid-x grid-margin-x">
                                <h1 class="default-title"><?php echo strip_tags($title, '<span>'); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="grid-container full  header__bottom">
            <div class="grid-container grid-container-medium menu-grid-container padding-0">
                <div class="grid-x">
                    <div class="medium-12 large-2 small-12 cell">
                        <div class="logo text-center large-text-left">
                            <div class="hide-for-large">
                                <a href="<?php echo home_url() ?>"><img
                                            src="<?php the_field('mobile_logo', 'options') ?>" alt="logo"></a>
                            </div>
                            <div class="show-for-large"><?php show_custom_logo(); ?></div>
                        </div>
                    </div>
                    <div class="large-10 medium-12 small-12 cell cell__navigation">
                        <?php if (has_nav_menu('header-menu')) : ?>
                            <div class="title-bar hide-for-large" data-responsive-toggle="main-menu"
                                 data-hide-for="large">
                                <button class="menu-icon" type="button" data-toggle aria-label="Menu"
                                        aria-controls="main-menu">
                                    <span></span></button>
                            </div>
                            <nav class="top-bar " id="main-menu">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'header-menu',
                                    'menu_class' => 'menu header-menu',
                                    'items_wrap' => '<ul id="%1$s" class="%2$s" 
                                    data-responsive-menu="accordion large-dropdown" data-submenu-toggle="true" 
                                    data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                                    'walker' => new Foundation_Navigation()
                                )); ?>
                                <div class="nav__bottom grid-container hide-for-large">
                                    <div class="grid-x">
                                        <?php if ($link): ?>
                                            <div class="medium-4 small-4 text-center nav__bottom--cell padding-horizontal-1">
                                                <?php $link = get_field('parent_forms', 'options');
                                                if ($link): ?>
                                                    <a href="<?php the_field('link_parent_forms', 'options') ?>"><?php echo $link; ?></a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>


                                        <?php if ($linkFirst):
                                            $link_url = get_field('link_find_an_office', 'options'); ?>
                                            <div class="medium-4 small-4 text-center nav__bottom--cell padding-horizontal-1">
                                                <a href="<?php echo $link_url; ?>"><?php echo $linkFirst; ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php $button = get_field('button_label_request', 'options');
                                        if (!empty($button)) : ?>
                                            <div class="medium-4 small-4 nav__bottom--cell text-center">
                                                <button data-open="newPatient">
                                                    <?php echo $button; ?></button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="grid-x text-center">
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
                                </div>
                            </nav>
                        <?php endif; ?>
                        <button class="search-button show-for-large" data-open="search"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
</header>
<div class="reveal" id="newPatient" data-reveal>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo do_shortcode('[contact-form-7 id="6" title="New patient appointments"]') ?>
</div>
<div class="reveal" id="search" data-reveal>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php get_template_part('searchform'); ?>
</div>
<!-- END of header -->
