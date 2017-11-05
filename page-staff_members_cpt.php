<?php
/**
 * The template for displaying all staff members.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package perfectaimbowling
 *
 * Template Name: Staff Members
 */

get_header(); ?>

<?php global $post; ?>
<?php
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(5600, 1000), false, '');

$query = new WP_Query(array(
    'post_type' => 'staff_members_cpt',
    'post_status' => 'publish',
    'posts_per_page' => -1,
));
?>
    <div class="w-section home-main sub-main" style="
                                                    background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($post->ID); ?>');
                                                    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($post->ID); ?>');
                                                    background-position: 0% 0%, 0px 38%; background-size: cover;">
        <div class="w-container hero-container sub-hero-container">
            <h1 class="hero-h1"><?php the_title(); ?></h1>
            <p class="hero-supporting-text">Rolling from every inch of the earth!</p>
        </div>
    </div>

    <div class="w-section action-menu">
    <div class="breadcrumb-container">
        <div class="w-container breadcrumbs">
            <?php breadcrumbs(); ?>
        </div>
    </div>
    <div class="w-container subpage-container">
        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <a href="<?php echo the_permalink($query->ID); ?>">
                    <div class="staff-member w-col w-col-4 w-col-medium-4 w-col-large-4">
                        <div class="staff-member-image" style="background-image: url('<?php echo the_post_thumbnail_url() ?>')"></div>
                        <h2 class="home-h2-red"><?php echo the_title(); ?></h2>
                        <div class="bowler-info">
                            <p class="bowler-age"><span class="bowler-label">Age: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_age', true); ?></p>
                            <p class="bowler-hometown"><span class="bowler-label">Hometown: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_hometown', true); ?></p>
                            <p class="bowler-homelanes"><span class="bowler-label">Home Lanes: </span> <?php echo get_post_meta(get_the_ID($query->ID),'bowler_information_home-lanes', true); ?></p>
                        </div>
                        <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                        <p class="view-details-link">Read More</p>
                    </div>

                </a>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>
    </div>
<?php get_footer(); ?>