<?php
/**
 * The template for displaying all my account pages.
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
 * Template Name: My Account
 */

get_header(); ?>

<?php global $post; ?>
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
    <div class="w-section">
        <div class="w-container">
            <div class="product-accordions w-col w-col-12 w-col-small-12">
                <div id="accordion">
                    <h2 class="" style="text-align: center;">Account Info</h2>
                    <div><?php do_action( 'woocommerce_account_navigation' ); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-section action-menu">
    <div class="w-container subpage-container">
        <div class="my-account-content w-col w-col-12 w-col-small-12">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content('Read the rest of this entry »'); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>