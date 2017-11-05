<?php

add_filter('aws_searchbox_markup', 'aws_searchbox_markup');

function aws_searchbox_markup( $markup ) {
    $pattern = '/(<input\s*type=\"text\".*?\/>)/i';
    $markup = preg_replace( $pattern, '${1}<input class="aws-search-button" type="submit" value="Search"/>', $markup );
    return $markup;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'perfectaim_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'perfectaim_wrapper_end', 10);

function perfectaim_wrapper_start() { ?>
    <?php if (!(is_single())) { ?>
        <?php if (is_product_category() or is_shop()) {
                $shop_page = get_page_by_title("Shop");?>
            <div class="w-section home-main sub-main" style="
                background-image: -webkit-linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($shop_page->ID); ?>');
                background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo get_the_post_thumbnail_url($shop_page->ID); ?>');
                background-position: 0% 0%, 0px 38%; background-size: cover; background-repeat: no-repeat;">
                <div class="w-container hero-container sub-hero-container">
                    <?php if (is_shop()) { ?>
                        <h1 class="hero-h1">Shop</h1>
                        <p class="hero-supporting-text">Browse all of our latest products!</p>
                    <?php } else { ?>
                        <h1 class="hero-h1"><?php single_cat_title(); ?></h1>
                        <div class="hero-supporting-text"><?php wpautop( do_action( 'woocommerce_archive_description' ) )?></div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <?php woocommerce_breadcrumb(); ?>
    <?php if (!(is_single()) and (!(has_term( 'Closeout Items', 'product_cat')))) { ?>
        <div class="w-row">
            <div class="w-col product-filter-section w-col w-col-12 w-col-small-12">
                <div class="product-accordions product-filter-accordion w-col w-col-12 w-col-small-12">
                    <div id="accordion">
                        <h2 class="filter-title">Filter</h2>
                        <div>
                            <div class="w-container">
                                <?php if (is_shop()){
                                    dynamic_sidebar('shop-filter');
                                } else if(strpos(wc_get_product_category_list(get_the_ID()), 'Bowling Balls')) {
                                    dynamic_sidebar('bowling-balls-filter');
                                } else if (strpos(wc_get_product_category_list(get_the_ID()), 'Bowling Bags')) {
                                    dynamic_sidebar('bowling-bags-filter');
                                } else if (strpos(wc_get_product_category_list(get_the_ID()), 'Bowling Shoes')) {
                                    dynamic_sidebar('bowling-shoes-filter');
                                } else if (strpos(wc_get_product_category_list(get_the_ID()), 'Accessories')) {
                                    dynamic_sidebar('accessories-filter');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="w-container product-subpage-container">
            <div class="w-col w-col-12">
            <?php if(is_shop() or is_product_category() or is_archive() or is_ca) {
                    dynamic_sidebar('woocommerce-sidebar-bottom');
                } ?>
<?php }

function perfectaim_wrapper_end() {
    if(is_shop() or is_product_category() or is_archive()) {
        dynamic_sidebar('woocommerce-sidebar-bottom');
    }
    echo '</div></div>';
}

/* define what my breadcrumbs will look like */
add_filter( 'woocommerce_breadcrumb_defaults', 'perfectaim_woocommerce_breadcrumbs' );
function perfectaim_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '<li class="breadcrumb-item breadcrumb-separator">&#xf105;</i></li>',
        'wrap_before' => '<div class="breadcrumb-container"><div class="w-container product-breadcrumbs"><ul class="w-hidden-small w-hidden-tiny breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</ul></div></div>',
        'before'      => '<li class="breadcrumb-item">',
        'after'       => '</li>',
        'home'        => '&#xf015;',
    );
}

/* remove breadcrumbs before main content */
add_action( 'init', 'remove_wc_breadcrumbs_before_main_content' );
function remove_wc_breadcrumbs_before_main_content() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

function cat_product_card($product) { ?>
<div class="featured-product-container w-col w-col-4 w-col-small-12 w-col-medium-4">
    <div class="featured-product">
        <a class="featured-product-link" href="<?php echo $product->get_permalink(); ?>">
            <?php if (strpos(wc_get_product_category_list($product->ID),"Closeout Items")) { ?>
                <div class="corner-ribbon shadow orange">Closeout!</div>
            <?php } ?>
            <div class="product-image"><?php echo $product->get_image(); ?></div>
            <div class="product-information-container">
                <h2 class="product-title"><?php echo $product->get_name(); ?></h2>
                <div class="product-information">
                    <p class="prices">
                        <?php echo $product->get_price_html() ?>
                        <!--<span class="<?php /*echo $product->is_on_sale() ? "sale" : "no-sale" */?>">$<?php /*echo $product->get_regular_price(); */?></span>
                        <?php /*if ($product->is_on_sale()) { */?>
                            <span class="sale-price"> $<?php /*echo $product->get_sale_price(); */?></span>
                        --><?php /*} */?>
                    </p>
                    <ul class="stars woocommerce">
                        <?php
                        //Star Rating per product Basis
                        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                            $average = $product->get_average_rating();

                            echo '<div class="star-rating"><span style="width:' . (($average / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __('out of 5', 'woocommerce') . '</span></div>';
                        }?>
                    </ul>
                </div>
            </div>
        </a>
    </div>
</div>
<?php }

function cross_sell_product($product) { ?>
    <div class="cross-sell-product-container w-col w-col-12 w-col-small-12 w-col-medium-12">
        <a class="featured-product-link" href="<?php echo $product->get_permalink(); ?>">
            <div class="product-image w-col w-col-4 w-col-small-12 w-col-tiny-12"><?php echo $product->get_image(); ?></div>
            <div class="w-col w-col-8">
                <div class="product-information-container">
                    <h2 class="product-title"><?php echo $product->get_name(); ?></h2>
                    <div class="product-information">
                        <p class="prices">
                            <span class="<?php echo $product->is_on_sale() ? "sale" : "no-sale" ?>">$<?php echo $product->get_regular_price(); ?></span>
                            <?php if ($product->is_on_sale()) { ?>
                                <span class="sale-price"> $<?php echo $product->get_sale_price(); ?></span>
                            <?php } ?>
                        </p>
                        <p class="view-details-link-cart">View Details</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php }

function product_finder_module() { ?>
    <?php
        $bestsellersargs = array(
            'post_type'     => 'product',
            'post_status'   => 'publish',
            'posts_per_page'=> 3,
            'order'         => 'DESC',
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
);

        $newreleasesargs = array(
            'post_type'     => 'product',
            'post_status'   => 'publish',
            'posts_per_page'=> 3,
            'orderby'       => 'date',
            'order'         => 'DESC'
);

        $mostreviewsargs = array(
            'post_type'     => 'product',
            'post_status'   => 'publish',
            'posts_per_page'=> 6,
            'order'         => 'DESC',
            'meta_key'      => '_wc_average_rating',
            'orderby'       => 'meta_value_num',
);
     ?>
    <div class="w-section featured-products-container">
    <div class="w-container">
        <div class="w-row">
            <div class="w-col w-col-12">
                <h2 class="home-h2">Find the right product for you!</h2>
                <?php woocommerce_product_finder( array( 'use_category' => false,
                                                         'search_attributes' => array('color', 'coverstock', 'finish', 'flare-potential', 'lane-condition',
                                                                                      'weight', 'brand', 'bag-color', 'bag-style', 'shoe-holder', 'shoe-size-capacity',
                                                                                      'handle-type', 'denier', 'wheel-size', 'bag-size')) ) ?>
            </div>
        </div>
        <div class="w-row">
            <div id="tabs">
                <ul class="tab tabs-grouped">
                    <li class="individual-tab"><a href="#tab-1">Best Sellers</a></li>
                    <li class="individual-tab"><a href="#tab-2">Recently Added</a></li>
<!--                    <li class="individual-tab"><a href="#tab-3">Most Reviewed</a></li>-->
                </ul>
                <div id="tab-1" class="w-col w-col-12">
                    <?php
                    $featured_query = new WP_Query( $bestsellersargs );
                    if ($featured_query->have_posts()) :
                        while ($featured_query->have_posts()) :
                            $featured_query->the_post();
                            $product = wc_get_product( $featured_query->post->ID ); ?>
                            <?php get_product_card($product) ?>
                        <?php endwhile;
                    else: ?>
                        <p>
                            <?php _e( 'No Products' ); ?>
                        </p>
                    <?php endif;
                    wp_reset_query(); // Remember to reset
                    ?>
                </div>
                <div id="tab-2" class="w-col w-col-12">
                    <?php
                    $featured_query = new WP_Query( $newreleasesargs );
                    if ($featured_query->have_posts()) :
                        while ($featured_query->have_posts()) :
                            $featured_query->the_post();
                            $product = wc_get_product( $featured_query->post->ID ); ?>
                            <?php get_product_card($product) ?>
                        <?php endwhile;
                    else: ?>
                    <p>
                        <?php _e( 'No Products' ); ?>
                    </p>
                    <?php endif;
                    wp_reset_query(); // Remember to reset
                    ?>
                </div>
                <!--<div id="tab-3" class="w-col w-col-12">
                    <?php
/*                    $featured_query = new WP_Query( $mostreviewsargs );
                    if ($featured_query->have_posts()) :
                        while ($featured_query->have_posts()) :
                            $featured_query->the_post();
                            $product = wc_get_product( $featured_query->post->ID ); */?>
                            <?php /*get_product_card($product) */?>
                        <?php /*endwhile;
                    else: */?>
                        <p>
                            <?php /*_e( 'No Products' ); */?>
                        </p>
                    <?php /*endif;
                    wp_reset_query(); // Remember to reset
                    */?>
                </div>-->
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php
// remove default sorting dropdown
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//remove Sale! text everywhere
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

//add_action( 'woocommerce_before_add_to_cart_button', 'echo_qty_front_add_cart' );

//function echo_qty_front_add_cart() {
//    echo '<div class="qty">Qty: </div>';
//}

/**
 * Generated by the WordPress Meta Box generator
 * at http://jeremyhixon.com/tool/wordpress-meta-box-generator/
 */

function youtube_embed_code_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function youtube_embed_code_add_meta_box() {
	add_meta_box(
		'youtube_embed_code-youtube-embed-code',
		__( 'YouTube Embed Code', 'youtube_embed_code' ),
		'youtube_embed_code_html',
		'post',
		'normal',
		'default'
	);
	add_meta_box(
		'youtube_embed_code-youtube-embed-code',
		__( 'YouTube Embed Code', 'youtube_embed_code' ),
		'youtube_embed_code_html',
		'product',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'youtube_embed_code_add_meta_box' );

function youtube_embed_code_html( $post) {
	wp_nonce_field( '_youtube_embed_code_nonce', 'youtube_embed_code_nonce' ); ?>

	<p>Place the entire YouTube embed code here. This is used to enter a video into the video accordion</p>

	<p>
		<label for="youtube_embed_code_embed_code"><?php _e( 'Embed Code', 'youtube_embed_code' ); ?></label><br>
		<input type="text" name="youtube_embed_code_embed_code" id="youtube_embed_code_embed_code" style="width:100%" value="<?php echo youtube_embed_code_get_meta( 'youtube_embed_code_embed_code' ); ?>">
	</p><?php
}

function youtube_embed_code_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['youtube_embed_code_nonce'] ) || ! wp_verify_nonce( $_POST['youtube_embed_code_nonce'], '_youtube_embed_code_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['youtube_embed_code_embed_code'] ) )
		update_post_meta( $post_id, 'youtube_embed_code_embed_code', esc_attr( $_POST['youtube_embed_code_embed_code'] ) );
}
add_action( 'save_post', 'youtube_embed_code_save' );

/*
	Usage: youtube_embed_code_get_meta( 'youtube_embed_code_embed_code' )
*/

/**
 * Generated by the WordPress Meta Box generator
 * at http://jeremyhixon.com/tool/wordpress-meta-box-generator/
 */

function technical_specs_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function technical_specs_add_meta_box() {
	add_meta_box(
		'technical_specs-technical-specs',
		__( 'Technical Specs', 'technical_specs' ),
		'technical_specs_html',
		'post',
		'normal',
		'default'
	);
	add_meta_box(
		'technical_specs-technical-specs',
		__( 'Technical Specs', 'technical_specs' ),
		'technical_specs_html',
		'product',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'technical_specs_add_meta_box' );

function technical_specs_html( $post) {
	wp_nonce_field( '_technical_specs_nonce', 'technical_specs_nonce' ); ?>

	<p>Fill the RG, Differential, and Mass Bias Diff together</p>

	<p>
		<label for="technical_specs_14lbs_rg"><?php _e( '14lbs RG', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_14lbs_rg" id="technical_specs_14lbs_rg" value="<?php echo technical_specs_get_meta( 'technical_specs_14lbs_rg' ); ?>">
	</p>	<p>
		<label for="technical_specs_15lbs_rg"><?php _e( '15lbs RG', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_15lbs_rg" id="technical_specs_15lbs_rg" value="<?php echo technical_specs_get_meta( 'technical_specs_15lbs_rg' ); ?>">
	</p>	<p>
		<label for="technical_specs_16lbs_rg"><?php _e( '16lbs RG', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_16lbs_rg" id="technical_specs_16lbs_rg" value="<?php echo technical_specs_get_meta( 'technical_specs_16lbs_rg' ); ?>">
	</p>	<p>
		<label for="technical_specs_14lbs_differential"><?php _e( '14lbs Differential', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_14lbs_differential" id="technical_specs_14lbs_differential" value="<?php echo technical_specs_get_meta( 'technical_specs_14lbs_differential' ); ?>">
	</p>	<p>
		<label for="technical_specs_15lbs_differential"><?php _e( '15lbs Differential', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_15lbs_differential" id="technical_specs_15lbs_differential" value="<?php echo technical_specs_get_meta( 'technical_specs_15lbs_differential' ); ?>">
	</p>	<p>
		<label for="technical_specs_16lbs_differential"><?php _e( '16lbs Differential', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_16lbs_differential" id="technical_specs_16lbs_differential" value="<?php echo technical_specs_get_meta( 'technical_specs_16lbs_differential' ); ?>">
	</p>	<p>
		<label for="technical_specs_14lbs_mass_bias_diff"><?php _e( '14lbs Mass Bias Diff', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_14lbs_mass_bias_diff" id="technical_specs_14lbs_mass_bias_diff" value="<?php echo technical_specs_get_meta( 'technical_specs_14lbs_mass_bias_diff' ); ?>">
	</p>	<p>
		<label for="technical_specs_15lbs_mass_bias_diff"><?php _e( '15lbs Mass Bias Diff', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_15lbs_mass_bias_diff" id="technical_specs_15lbs_mass_bias_diff" value="<?php echo technical_specs_get_meta( 'technical_specs_15lbs_mass_bias_diff' ); ?>">
	</p>	<p>
		<label for="technical_specs_16lbs_mass_bias_diff"><?php _e( '16lbs Mass Bias Diff', 'technical_specs' ); ?></label><br>
		<input type="text" name="technical_specs_16lbs_mass_bias_diff" id="technical_specs_16lbs_mass_bias_diff" value="<?php echo technical_specs_get_meta( 'technical_specs_16lbs_mass_bias_diff' ); ?>">
	</p><?php
}

function technical_specs_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['technical_specs_nonce'] ) || ! wp_verify_nonce( $_POST['technical_specs_nonce'], '_technical_specs_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['technical_specs_14lbs_rg'] ) )
		update_post_meta( $post_id, 'technical_specs_14lbs_rg', esc_attr( $_POST['technical_specs_14lbs_rg'] ) );
	if ( isset( $_POST['technical_specs_15lbs_rg'] ) )
		update_post_meta( $post_id, 'technical_specs_15lbs_rg', esc_attr( $_POST['technical_specs_15lbs_rg'] ) );
	if ( isset( $_POST['technical_specs_16lbs_rg'] ) )
		update_post_meta( $post_id, 'technical_specs_16lbs_rg', esc_attr( $_POST['technical_specs_16lbs_rg'] ) );
	if ( isset( $_POST['technical_specs_14lbs_differential'] ) )
		update_post_meta( $post_id, 'technical_specs_14lbs_differential', esc_attr( $_POST['technical_specs_14lbs_differential'] ) );
	if ( isset( $_POST['technical_specs_15lbs_differential'] ) )
		update_post_meta( $post_id, 'technical_specs_15lbs_differential', esc_attr( $_POST['technical_specs_15lbs_differential'] ) );
	if ( isset( $_POST['technical_specs_16lbs_differential'] ) )
		update_post_meta( $post_id, 'technical_specs_16lbs_differential', esc_attr( $_POST['technical_specs_16lbs_differential'] ) );
	if ( isset( $_POST['technical_specs_14lbs_mass_bias_diff'] ) )
		update_post_meta( $post_id, 'technical_specs_14lbs_mass_bias_diff', esc_attr( $_POST['technical_specs_14lbs_mass_bias_diff'] ) );
	if ( isset( $_POST['technical_specs_15lbs_mass_bias_diff'] ) )
		update_post_meta( $post_id, 'technical_specs_15lbs_mass_bias_diff', esc_attr( $_POST['technical_specs_15lbs_mass_bias_diff'] ) );
	if ( isset( $_POST['technical_specs_16lbs_mass_bias_diff'] ) )
		update_post_meta( $post_id, 'technical_specs_16lbs_mass_bias_diff', esc_attr( $_POST['technical_specs_16lbs_mass_bias_diff'] ) );
}
add_action( 'save_post', 'technical_specs_save' );


/**
 * Add the field to the checkout
 */
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function referrer_checkout_options(){

    $args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'staff_members_cpt',
        'post_status'      => 'publish' );

    $posts = get_posts( $args );
    $staff_names = wp_list_pluck( $posts, 'post_title', 'ID' );
    return $staff_names;
}

function my_custom_checkout_field( $checkout ) {

    echo '<div id="my_custom_checkout_field"><h3>' . __('How did you find us?') . '</h3>';

    woocommerce_form_field( 'referrer', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Referrer'),
        'required'      => true,
        ), $checkout->get_value( 'referrer' ));

    echo '</div>';

}

//* Process the checkout
 add_action('woocommerce_checkout_process', 'wps_select_checkout_field_process');
 function wps_select_checkout_field_process() {
     global $woocommerce;
    // Check if set, if its not set add an error.
    if ($_POST['referrer'] == "")
     wc_add_notice( 'Please fill out the referrer field', 'error' );
 }

//* Update the order meta with field value
 add_action('woocommerce_checkout_update_order_meta', 'wps_select_checkout_field_update_order_meta');
 function wps_select_checkout_field_update_order_meta( $order_id ) {
   if ($_POST['referrer']) update_post_meta( $order_id, 'referrer', esc_attr($_POST['referrer']));
 }


//* Display field value on the order edition page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wps_select_checkout_field_display_admin_order_meta', 10, 1 );
function wps_select_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('Referrer').':</strong> ' . get_post_meta( $order->id, 'referrer', true ) . '</p>';
}
//* Add selection field value to emails
add_filter('woocommerce_email_order_meta_keys', 'wps_select_order_meta_keys');
function wps_select_order_meta_keys( $keys ) {
	$keys['Referrer'] = 'referrer';
	return $keys;

}

/**
 * only copy opening php tag if needed
 * Displays shipping estimates for WC shipping rates
 */
function sv_shipping_method_estimate_label( $label, $method ) {
	$label .= '<br /><small>';
	switch ( $method->method_id ) {
		case 'flat_rate':
			$label .= 'Est delivery: 2-4 days';
			break;
		case 'free_shipping':
			$label .= 'Est delivery: 4-7 days';
			break;
		case 'international_delivery':
			$label .= 'Est delivery: 7-10 days';
			break;
		default:
			$label .= 'Est delivery: 3-5 days';
	}

	$label .= '</small>';
	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'sv_shipping_method_estimate_label', 10, 2 );


add_action('add_to_cart_redirect', 'resolve_dupes_add_to_cart_redirect');

function resolve_dupes_add_to_cart_redirect($url = false) {

     // If another plugin beats us to the punch, let them have their way with the URL
     if(!empty($url)) { return $url; }

     // Redirect back to the original page, without the 'add-to-cart' parameter.
     // We add the `get_bloginfo` part so it saves a redirect on https:// sites.
     return get_bloginfo('wpurl').add_query_arg(array(), remove_query_arg('add-to-cart'));

}


function buildSelect($tax){
	$terms = get_terms($tax);
	$x = '<select name="'. $tax .'">';
	$x .= '<option value="">Select '. ucfirst($tax) .'</option>';
	foreach ($terms as $term) {
	   $x .= '<option value="' . $term->slug . '">' . $term->name . '</option>';
	}
	$x .= '</select>';
	return $x;
}

/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

/**
 * Get current users preference
 * @return int
 */
function jc_get_products_per_page(){

    global $woocommerce;

    $default = 24;
    $count = $default;
    $options = jc_get_products_per_page_options();

    // capture form data and store in session
    if(isset($_POST['jc-woocommerce-products-per-page'])){

        // set products per page from dropdown
        $products_max = intval($_POST['jc-woocommerce-products-per-page']);
        if($products_max != 0 && $products_max >= -1){

            if(is_user_logged_in()){

                $user_id = get_current_user_id();
                $limit = get_user_meta( $user_id, '_product_per_page', true );

                if(!$limit){
                    add_user_meta( $user_id, '_product_per_page', $products_max);
                }else{
                    update_user_meta( $user_id, '_product_per_page', $products_max, $limit);
                }
            }

            $woocommerce->session->jc_product_per_page = $products_max;
            return $products_max;
        }
    }

    // load product limit from user meta
    if(is_user_logged_in() && !isset($woocommerce->session->jc_product_per_page)){

        $user_id = get_current_user_id();
        $limit = get_user_meta( $user_id, '_product_per_page', true );

        if(array_key_exists($limit, $options)){
            $woocommerce->session->jc_product_per_page = $limit;
            return $limit;
        }
    }

    // load product limit from session
    if(isset($woocommerce->session->jc_product_per_page)){

        // set products per page from woo session
        $products_max = intval($woocommerce->session->jc_product_per_page);
        if($products_max != 0 && $products_max >= -1){
            return $products_max;
        }
    }

    return $count;
}
add_filter('loop_shop_per_page','jc_get_products_per_page');

/**
 * Fetch list of avaliable options
 * @return array
 */
function jc_get_products_per_page_options(){
    $options = apply_filters( 'jc_products_per_page', array(
        12 => __('12', 'woocommerce'),
        24 => __('24', 'woocommerce'),
        48 => __('48', 'woocommerce'),
        96 => __('96', 'woocommerce'),
        -1 => __('All', 'woocommerce')
    ));

    return $options;
}

/**
 * Display dropdown form to change amount of products displayed
 * @return void
 */
function jc_woocommerce_products_per_page(){

    $options = jc_get_products_per_page_options();

    $current_value = jc_get_products_per_page();
    ?>
    <div class="products-per-page">
        <span style="display:inline-block">Products Per Page:</span>
        <form style="display:inline-block" action="" method="POST" class="woocommerce-products-per-page">
            <select name="jc-woocommerce-products-per-page" onchange="this.form.submit()">
            <?php foreach($options as $value => $name): ?>
                <option value="<?php echo $value; ?>" <?php selected($value, $current_value); ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
            </select>
        </form>
    </div>
    <?php
}

add_action('woocommerce_before_shop_loop', 'jc_woocommerce_products_per_page', 25);