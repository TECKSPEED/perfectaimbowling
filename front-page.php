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

<?php global $post;
global $product;
?>
<div class="w-section">
    <div class="home-page-slider">
        <?php
            $args = array( 'post_type' => 'homepage-slides', 'posts_per_page' => -1, 'order' => 'ASC' );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="slide slide-container" style="background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>');
                                                            background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>');"/>
                    <div class="hero-container">
                        <div class="slide-content">
                            <h3 class="home-h2"><?php echo get_post_meta($post->ID, 'slide_information_title', true); ?></h3>
                            <p class="hero-supporting-text"><?php echo get_post_meta($post->ID, 'slide_information_sub-title', true); ?></p>
                            <?php if(get_post_meta($post->ID, 'slide_information_link-to-page', true) != ""){ ?>
                                <a class="hero-button" href="<?php echo get_post_meta($post->ID, 'slide_information_link-to-page', true); ?>">
                                    <?php echo get_post_meta($post->ID, 'slide_information_button-text', true); ?>
                                </a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_query();
        ?>
    </div></div>
<?php get_newsletter(); ?>
<div class="w-section">
    <div class="shop-categories">
        <div class="w-container categories">
            <h2 class="home-h2 cat-container-title">Shop by Category</h2>
            <div class="w-row">
                <?php
                $taxonomy = 'product_cat';
                $orderby = 'name';
                $show_count = 1;      // 1 for yes, 0 for no
                $pad_counts = 0;      // 1 for yes, 0 for no
                $hierarchical = 1;      // 1 for yes, 0 for no
                $title = '';
                $empty = 0;

                $args = array(
                    'taxonomy' => $taxonomy,
                    'orderby' => $orderby,
                    'show_count' => $show_count,
                    'pad_counts' => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li' => $title,
                    'hide_empty' => $empty,
                    'parent' => 0,
                );
                $all_categories = get_categories($args);
                foreach ($all_categories as $cat) { ?>
                    <a class="cat-links" href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>">
                        <div class="w-col w-col-4 w-col-medium-4 w-col-small-4 w-col-tiny-12 category-item-container">
                            <div class="category-item  hvr-underline-from-center">
                                <?php
                                $cat_thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                $cat_image =  wp_get_attachment_image_src($cat_thumb_id); ?>
                                <div class="cat-image" style="background-image: url('<?php echo $cat_image[0]; ?>');"></div>
                                <?php
                                if ($cat->category_parent == 0) {
                                    $category_id = $cat->term_id;
                                    echo '<p class="cat-title">' . $cat->name . '</p>';
                                } ?>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
    <div class="w-section best-sellers">
        <h2 class="home-h2-red">Best Sellers</h2>
        <div class="w-container">
            <div class="w-row">
                <div class="slide product-slide-container">
                    <div class="slide-product-content">
						<?php
						$args = array(
							'post_type' => 'product',
							'meta_key' => 'total_sales',
							'orderby' => 'meta_value_num',
							'posts_per_page' => 12,
						);

						$loop = new WP_Query( $args );
						while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <div class="product-slide hvr-underline-from-center">
                                <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <div class="w-col w-col-12">
										<?php if (has_post_thumbnail( $loop->post->ID ))
											echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
										else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image" width="65px" height="115px" />'; ?>
                                        <p class="best-sellers-title"><?php the_title(); ?></p>
                                    </div>
                                </a>
                            </div>
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="w-section">
    <div class="latest-review">
        <div class="w-row">
            <div class="w-col w-col-6 w-col-medium-12 w-col-tiny-12 video-col matchHeight">
                <div class="videoWrapper">
                    <iframe width="300" height="200" src="https://www.youtube.com/embed?max-results=1&controls=0&showinfo=1&rel=0&listType=user_uploads&list=TamerBowling" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
                </div>
            </div>
            <div class="w-col w-col-6 w-col-medium-12 w-col-tiny-12 ball-reviews matchHeight">
                <h2 class="home-h2-red">Perfect Aim Bowling Strikes Again!</h2>
                <p class="video-content"><?php echo get_the_content(); ?></p>
            </div>
        </div>
    </div>
</div>
<?php get_staff_member(); ?>
<?php get_footer(); ?>