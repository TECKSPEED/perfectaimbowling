<?php function get_product_card($product) { ?>
    <div class="featured-product-container w-col w-col-4 w-col-tiny-12 w-col-small-6 w-col-medium-6">
        <div class="featured-product">
            <a class="featured-product-link" href="<?php echo $product->get_permalink(); ?>">
                <div class="product-image"><?php echo $product->get_image(); ?></div>
                <div class="product-information-container">
                    <h2 class="product-title"><?php echo $product->get_name(); ?></h2>
                    <div class="product-information">
                        <p class="prices">
                            <span class="<?php echo $product->is_on_sale() ? "sale" : "no-sale" ?>">$<?php echo $product->get_regular_price(); ?></span>
                            <?php if ($product->is_on_sale()) { ?>
                                <span class="sale-price"> $<?php echo $product->get_sale_price(); ?></span>
                            <?php } ?>
                        </p>
                        <ul class="stars woocommerce">
                            <?php
                            //Star Rating per product Basis
                            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                $average = $product->get_average_rating();

                                echo '<div class="star-rating">
                                    <span style="width:' . (($average / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __('out of 5', 'woocommerce') . '</span>
                                  </div>';
                            }?>
                        </ul>
                    </div>
                    <p class="view-details-link">View Details</p>
                </div>
            </a>
        </div>
    </div>
<?php } ?>