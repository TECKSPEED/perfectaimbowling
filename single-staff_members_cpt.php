<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package perfectaimbowling
 */

get_header(); ?>

<?php global $post; ?>
<?php
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(5600, 1000), false, '');

$staff_page = get_page_by_title("Staff Members");
?>
    <div class="w-section home-main sub-main" style="
                                                    background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($staff_page->ID); ?>');
                                                    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($staff_page->ID); ?>');
                                                    background-position: 0% 0%, 0px 38%; background-size: cover;">
        <div class="w-container hero-container sub-hero-container">
            <h1 class="hero-h1"><?php the_title(); ?></h1>
            <p class="hero-supporting-text"><?php echo $heroSupportText ?></p>
        </div>
    </div>

    <div class="w-section action-menu">
    <div class="breadcrumb-container">
        <div class="w-container breadcrumbs">
            <?php breadcrumbs(); ?>
        </div>
    </div>
    <div class="w-container subpage-container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="w-col w-col-3 w-col-small-12">
                    <div class="staff-member-image" style="background-image: url('<?php echo the_post_thumbnail_url() ?>')"></div>
                    <div class="bowler-info">
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_age', true)))) : ?>
                            <p class="bowler-age"><span class="bowler-label">Age: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_age', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_hometown', true)))) : ?>
                            <p class="bowler-hometown"><span class="bowler-label">Hometown: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_hometown', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_home-lanes', true)))) : ?>
                            <p class="bowler-homelanes"><span class="bowler-label">Home Lanes: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_home-lanes', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_paps', true)))) : ?>
                            <p class="bowler-pap"><span class="bowler-label">PAP: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_pap', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_handedness', true)))) : ?>
                            <p class="bowler-handedness"><span class="bowler-label">Handedness: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_handedness', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_rev-rate', true)))) : ?>
                            <p class="bowler-rev-rate"><span class="bowler-label">Rev. Rate: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_rev-rate', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_speed', true)))) : ?>
                            <p class="bowler-speed"><span class="bowler-label">Speed: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_speed', true); ?></p>
                        <?php endif ?>
                        <?php if (!(empty(get_post_meta(get_the_ID($query->ID),'bowler_information_tilt', true)))) : ?>
                            <p class="bowler-tilt"><span class="bowler-label">Tilt: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_tilt', true); ?></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="w-col w-col-8 w-col-small-12">
                    <?php the_content('Read the rest of this entry »'); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>

