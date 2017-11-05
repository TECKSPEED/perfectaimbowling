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
 *
 * Template Name: FAQ
 */

get_header(); ?>

<?php global $post;

$query = new WP_Query(array(
    'post_type' => 'faq',
    'post_status' => 'publish',
    'posts_per_page' => -1,
));
?>
<?php
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(5600, 1000), false, '');
?>
    <div class="w-section home-main sub-main" style="
                                                    background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo $src[0]; ?>');
                                                    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo $src[0]; ?>');
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
        <?php if ($query->have_posts()) : ?>
            <div class="product-accordions w-col w-col-12 w-col-small-12">
                <div id="accordion">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <h2><?php echo the_title(); ?></h2>
                            <div>
                               <?php echo the_content(); ?>
                            </div>
                <?php
                    endwhile;
                    wp_reset_query();
                ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php get_footer(); ?>