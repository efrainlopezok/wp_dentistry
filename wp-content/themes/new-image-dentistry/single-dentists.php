<?php
/**
 * Single Dentist
 *
 * Loop container for single post content
 */
get_header(); ?>
<main class="main-content content dentist-content">
        <?php $subtitle = get_field('sub_title');
        if (!empty($subtitle)) : ?>
            <div class="grid-container subtitle transform-top">
                <div class="grid-container grid-container-medium">
                    <div class="grid-x">
                        <h2><?php echo $subtitle; ?></h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <div class="grid-container grid-container-medium">
        <div class="grid-x grid-margin-x">
            <!-- BEGIN of post content -->
            <div class="large-8 medium-8 small-12 cell">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                             <div class="entry__content clearfix">
                                <?php the_content( '', true ); ?>
                            </div>
                         </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <!-- END of post content -->

            <!-- BEGIN of sidebar -->
            <div class="large-4 medium-4 small-12 cell sidebar">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div title="<?php the_title_attribute(); ?>" class="entry__thumb">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </div>
                <?php endif; ?>
<!--                --><?php //get_sidebar( 'right' ); ?>
            </div>
            <!-- END of sidebar -->
        </div>
    </div>
</main>
<?php get_template_part('parts/request-appointment'); ?>

<?php get_footer(); ?>
