<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<?php
$url = wp_get_attachment_url( get_post_thumbnail_id($product->ID), 'full' );

$attachment_ids = $product->get_gallery_attachment_ids();
?>

<div class="w-container">
    <div class="w-row">
        <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="product-gallery-container w-col w-col-6 w-col-small-12">
                <div class="woocommerce-product-gallery woocommerce-product-gallery--columns-5">
                    <div class="woocommerce-product-gallery__wrapper">
                        <?php
                        /**
                         * woocommerce_before_single_product_summary hook.
                         *
                         * @hooked woocommerce_show_product_sale_flash - 10
                         * @hooked woocommerce_show_product_images - 20
                         */
                        do_action( 'woocommerce_before_single_product_summary' );
                        ?>
                    </div>
                </div>
            </div>
            <div class="product-summary-container w-col w-col-6 w-col-small-12">
                <div class="summary entry-summary">
	                <?php
	                /**
	                 * woocommerce_single_product_summary hook.
	                 *
	                 * @hooked woocommerce_template_single_title - 5
	                 * @hooked woocommerce_template_single_rating - 10
	                 * @hooked woocommerce_template_single_price - 10
	                 * @hooked woocommerce_template_single_excerpt - 20
	                 * @hooked woocommerce_template_single_add_to_cart - 30
	                 * @hooked woocommerce_template_single_meta - 40
	                 * @hooked woocommerce_template_single_sharing - 50
	                 * @hooked WC_Structured_Data::generate_product_data() - 60
	                 */
	                do_action( 'woocommerce_single_product_summary' );
	                ?>
                    <div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>
                </div>
            </div>
            <div class="product-accordions w-col w-col-12 w-col-small-12">
                <div id="accordion">
                    <h2>Description</h2>
                    <div>
                        <?php echo woocommerce_product_description_tab(); ?>
                    </div>
                    <?php if ($product->has_attributes()) { ?>
                        <h2>More Information</h2>
                        <div>
                            <?php echo woocommerce_product_additional_information_tab(); ?>
                        </div>
                    <?php } ?>
                    <?php if(strpos(wc_get_product_category_list(get_the_ID()), 'Bowling Balls')) { ?>
                        <h2>Technical Specs</h2>
                        <div>
                            <table class="technical-specs">
                                <tbody>
                                    <tr>
                                        <th></th>
                                        <th>14lbs</th>
                                        <th>15lbs</th>
                                        <th>16lbs</th>
                                    </tr>
                                    <tr>
                                        <th>RG</th>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_14lbs_rg' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_15lbs_rg' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_16lbs_rg' ); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Diff.</th>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_14lbs_differential' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_15lbs_differential' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_16lbs_differential' ); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mass Bias Diff.</th>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_14lbs_mass_bias_diff' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_15lbs_mass_bias_diff' ); ?></td>
                                        <td><?php echo technical_specs_get_meta( 'technical_specs_16lbs_mass_bias_diff' ); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <?php if(get_post_meta( get_the_ID($product->ID), 'youtube_embed_code_embed_code', true )) { ?>
                        <h2>Videos</h2>
                        <div>
                            <div class="youtube" data-embed="<?php echo get_post_meta( get_the_ID($product->ID), 'youtube_embed_code_embed_code', true ); ?>">
                                <div class="play-button"></div>
                            </div>
                        </div>
                    <?php } ?>
                    <h2>Reviews</h2>
                    <div>
                        <?php echo comments_template(); ?>
                    </div>
                </div>
            </div>
            <div class="w-col w-col-12 w-col-small-12">
                <?php woocommerce_related_products(); ?>
            </div>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

