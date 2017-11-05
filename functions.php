<?php
/**
 * perfectaimbowling functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package perfectaimbowling
 */

include("functions-customize.php");
include("functions-product-card.php");
include("functions-woocommerce.php");

if ( ! function_exists( 'perfectaimbowling_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function perfectaimbowling_setup() {

    define('WOOCOMMERCE_USE_CSS', true);
    add_theme_support( 'woocommerce' );
    //add_theme_support( 'wc-product-gallery-zoom' );
    //add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on perfectaimbowling, use a find and replace
	 * to change 'perfectaimbowling' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'perfectaimbowling', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'perfectaimbowling' ),
        'mobile' => esc_html__( 'Mobile Menu', 'perfectaimbowling' ),
		'utility' => __( 'Utility Menu', 'Utility ' ),
		'subnav' => __( 'Sub Nav' ),
	) );
	add_action('wp_enqueue_scripts', 'cssmenumaker_scripts_styles' ); function cssmenumaker_scripts_styles() {
   #wp_enqueue_style( 'cssmenu-styles', get_template_directory_uri() . '/cssmenu/styles.css');
}
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'perfectaimbowling_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // perfectaimbowling_setup
add_action( 'after_setup_theme', 'perfectaimbowling_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function perfectaimbowling_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'perfectaimbowling_content_width', 640 );
}
add_action( 'after_setup_theme', 'perfectaimbowling_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function perfectaimbowling_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'perfectaimbowling' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'perfectaimbowling_widgets_init' );


function breadcrumbs() {
		$post_ID = get_queried_object_id();
		$title = get_the_title();
		$ancestors = get_ancestors($post_ID, 'page');
		$r_ancestor = array_reverse($ancestors);
		$count = count($ancestors); ?>
			
		<ul class="w-hidden-small w-hidden-tiny w-hidden-medium breadcrumb">
			<!-- homepage -->
			<li class="breadcrumb-item breadcrumb-home">
				<a class="breadcrumb-link" href="<?php echo site_url(); ?>">&#xf015;</a>
			</li>
				
			<!-- parent items -->
	  <?php foreach($r_ancestor as $key => $ancestor){ ?>
		<?php if($key > 0) { ?>
				<li class="breadcrumb-item breadcrumb-separator">&#xf105;</i></li>
				<li class="breadcrumb-item">
					<a class="breadcrumb-link" href="<?php echo get_permalink($ancestor)?>"><?php echo get_the_title($ancestor)?></a>
				</li>
		<?php } ?>
	  <?php } ?>
	  
		    <!-- last item  -->
		    <li class="breadcrumb-item breadcrumb-separator">&#xf105;</i></li>
		    <li class="breadcrumb-item">
			    <a class="breadcrumb-link" href="<?php echo get_permalink($post_ID)?>"><?php echo $title;?></a>
		    </li>
		</ul>
<?php } 

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 250, 250 );

/**
 * Enqueue scripts and styles.
 */
function perfectaimbowling_scripts() {
    wp_deregister_script( 'slick-slider-core' );

	wp_enqueue_style( 'perfectaimbowling-style', get_stylesheet_uri() );

    wp_register_style('fontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), null, false);
    wp_enqueue_style('fontAwesome');

    wp_register_style('responsiveTabs', get_stylesheet_directory_uri() . '/assets/css/responsive-tabs.css', array(), null, false);
    wp_enqueue_style('responsiveTabs');

    wp_register_style('lobster-font', 'https://fonts.googleapis.com/css?family=Lobster|Lobster+Two', array(), null, false);
    wp_enqueue_style('lobster-font');

    wp_register_style('perfectaim-webflow', get_stylesheet_directory_uri() . '/assets/css/webflow.css', array(), null, false);
    wp_enqueue_style('perfectaim-webflow');

	wp_register_style('perfectaim-hover', get_stylesheet_directory_uri() . '/assets/css/hover.css', array(), null, false);
	wp_enqueue_style('perfectaim-hover');

    wp_register_style('perfectaim-normalize', get_stylesheet_directory_uri() . '/assets/css/normalize.css', array(), null, false);
    wp_enqueue_style('perfectaim-normalize');

    wp_enqueue_style( 'slick-slider-styles', get_stylesheet_directory_uri() . '/assets/css/slick.css' );

	wp_enqueue_style( 'slick-slider-theme', get_stylesheet_directory_uri() . '/assets/css/slick-theme.css' );


    wp_register_style('perfectaim-custom-styles', get_stylesheet_directory_uri() . '/assets/css/perfectaimbowling.webflow.css', array(), null, false);
    wp_enqueue_style('perfectaim-custom-styles');

	wp_enqueue_script( 'perfectaimbowling-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', false );

	wp_enqueue_script( 'perfectaimbowling-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', false );

    wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), null, false);

    wp_register_script('perfectaimbowling-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js', array('jquery'), null, false);
    wp_enqueue_script('perfectaimbowling-slick');

	wp_register_script('perfectaimbowling-infiniteScroll', get_template_directory_uri() . '/js/infiniteScroll.min.js', array(jquery), null, false );
	wp_enqueue_script('perfectaimbowling-infiniteScroll');

    wp_register_script( 'perfectaimbowling-responsive-tabs', get_template_directory_uri() . '/js/jquery.responsiveTabs.min.js', array('jQuery'), null, false );
    wp_enqueue_script( 'perfectaimbowling-responsive-tabs');

    wp_register_script('perfectaimbowling-jquery-lazyload', get_template_directory_uri(). '/js/jquery.lazy.min.js', array('jquery'), null, false);
    wp_enqueue_script('perfectaimbowling-jquery-lazyload');

    wp_register_script( 'perfectaimbowling-matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array('jquery'), null, false );
    wp_enqueue_script( 'perfectaimbowling-matchHeight');

    wp_register_script('webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js', array(), null, false);
    wp_enqueue_script( 'webfont');

    wp_register_script( 'perfectaimbowling-main', get_template_directory_uri() . '/js/main.js', array('jQuery'), null, false );
    wp_enqueue_script( 'perfectaimbowling-main');

    wp_dequeue_style('jquery-ui.min.css');



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'perfectaimbowling_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function theme_name_scripts() {
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php
    }
    ?></a><?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );

show_admin_bar( false );

function get_newsletter() { ?>
    <div class="w-section newsletter-container">
        <div class="w-container">
            <div class="w-row">
                <div class="w-col-12">
                    <h2 class="home-h2">Catch the latest from the Newsletter!</h2>
                    <?php echo do_shortcode("[mc4wp_form id=\"263\"]"); ?>
                </div>
            </div>
        </div>
    </div>
<?php }

function get_staff_member() { ?>
    <div class="w-section staff-member-container">
        <div class="w-container">
            <div class="w-row">
                <div class="w-col-12">
                    <h2 class="home-h2 staff-member-title">Become a staff member!</h2>
                    <?php $page = get_page_by_title('Become a Staff Member'); ?>
                    <a class="button-alt staff-button" href="<?php echo get_permalink($page->ID); ?>">Learn More</a>
                </div>
            </div>
        </div>
    </div>
<?php }


/**
 * Register our footer widgetized areas.
 *
 */
function footer_widget_area_1() {

    register_sidebar( array(
        'name'          => 'Footer Area 1',
        'id'            => 'footer-area-1',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="footer-h2">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'footer_widget_area_1' );

function footer_widget_area_2() {

    register_sidebar( array(
        'name'          => 'Footer Area 2',
        'id'            => 'footer-area-2',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="footer-h2">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'footer_widget_area_2' );

function footer_widget_area_3() {

    register_sidebar( array(
        'name'          => 'Footer Area 3',
        'id'            => 'footer-area-3',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="footer-h2">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'footer_widget_area_3' );

function footer_widget_area_4() {

    register_sidebar( array(
        'name'          => 'Footer Area 4',
        'id'            => 'footer-area-4',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="footer-h2">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'footer_widget_area_4' );

function bowling_balls_filter() {

    register_sidebar( array(
        'name'          => 'Bowling Balls Filters',
        'id'            => 'bowling-balls-filter',
        'before_widget' => '<div class="filter-component-container w-col w-col-3 w-col-medium-6 w-col-small-6 w-col-tiny-12">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="woocommerce_sidebar-h2">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'bowling_balls_filter' );

function bowling_bags_filter() {

    register_sidebar( array(
        'name'          => 'Bowling Bags Filters',
        'id'            => 'bowling-bags-filter',
        'before_widget' => '<div class="filter-component-container w-col w-col-3 w-col-medium-6 w-col-small-6 w-col-tiny-12">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="woocommerce_sidebar-h2">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'bowling_bags_filter' );

function bowling_shoes_filter() {

	register_sidebar( array(
		'name'          => 'Bowling Shoes Filters',
		'id'            => 'bowling-shoes-filter',
		'before_widget' => '<div class="filter-component-container w-col w-col-3 w-col-medium-6 w-col-small-6 w-col-tiny-12">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="woocommerce_sidebar-h2">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'bowling_shoes_filter' );

function accessories_filter() {

    register_sidebar( array(
        'name'          => 'Accessories Filters',
        'id'            => 'accessories-filter',
        'before_widget' => '<div class="filter-component-container w-col w-col-3 w-col-medium-6 w-col-small-6 w-col-tiny-12">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="woocommerce_sidebar-h2">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'accessories_filter' );

function shop_filter() {

    register_sidebar( array(
        'name'          => 'Shop Filters',
        'id'            => 'shop-filter',
        'before_widget' => '<div class="filter-component-container w-col w-col-12 w-col-medium-12 w-col-small-12 w-col-tiny-12">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="woocommerce_sidebar-h2">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'shop_filter' );

function woocommerce_active_filter() {

    register_sidebar( array(
        'name'          => 'WooCommerce Active Filters',
        'id'            => 'woocommerce-sidebar-bottom',
        'before_widget' => '<div class="active-filters w-col w-col-12 w-col-small-12">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="woocommerce_active_filter">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'woocommerce_active_filter' );

// Remove Sidebar on all the Single Product Pages

/*function bbloomer_remove_sidebar_product_pages()
{
    if (is_product()) {
        remove_action('woocommerce-sidebar', 'woocommerce_get_sidebar', 10);
    }
}
add_action( 'wp', 'bbloomer_remove_sidebar_product_pages' );*/


// Creates Staff Members Custom Post Type
function staff_members_cpt() {
    $args = array(
        'label' => 'Staff Members',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'staff-members'),
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
    );
    register_post_type( 'staff_members_cpt', $args );
}
add_action( 'init', 'staff_members_cpt' );

function faq_post_type() {
    $labels = array(
        'name'               => 'FAQs',
        'singular_name'      => 'FAQ',
        'menu_name'          => 'FAQ',
        'name_admin_bar'     => 'FAQ',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New FAQ',
        'new_item'           => 'New FAQ',
        'edit_item'          => 'Edit FAQ',
        'view_item'          => 'View FAQ',
        'all_items'          => 'All FAQs',
        'search_items'       => 'Search FAQs',
        'parent_item_colon'  => 'Parent FAQs:',
        'not_found'          => 'No FAQs found.',
        'not_found_in_trash' => 'No FAQs found in Trash.'
    );

    $args = array(
        'public'      => true,
        'labels'      => $labels,
        'description' => 'FAQ Questions for Perfect Aim Bowling'
    );
    register_post_type( 'faq', $args );
}
add_action( 'init', 'faq_post_type' );

function slider_post_type() {
    $labels = array(
        'name'               => 'Homepage Slides',
        'singular_name'      => 'Homepage Slide',
        'menu_name'          => 'Homepage Slides',
        'name_admin_bar'     => 'Homepage Slide',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Homepage Slide',
        'new_item'           => 'New Homepage Slide',
        'edit_item'          => 'Edit Homepage Slide',
        'view_item'          => 'View Homepage Slide',
        'all_items'          => 'All Homepage Slides',
        'search_items'       => 'Search Homepage Slides',
        'parent_item_colon'  => 'Parent Homepage Slides:',
        'not_found'          => 'No Homepage Slides found.',
        'not_found_in_trash' => 'No Homepage Slides found in Trash.'
    );

    $args = array(
        'public'      => true,
        'labels'      => $labels,
        'description' => 'Homepage Slides for Perfect Aim Bowling',
        'supports'    => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields')
    );
    register_post_type( 'homepage-slides', $args );
}
add_action( 'init', 'slider_post_type' );

/**
 * Generated by the WordPress Meta Box Generator at http://goo.gl/8nwllb
 */
class Rational_Meta_Box_2 {
    private $screens = array(
        'homepage-slides',
    );
    private $fields = array(
        array(
            'id' => 'link-to-page',
            'label' => 'Link to page',
            'type' => 'text',
            'options' => array(
                'test',
                'tester',
            ),
        ),
        array(
            'id' => 'title',
            'label' => 'Title',
            'type' => 'text',
        ),
        array(
            'id' => 'sub-title',
            'label' => 'Sub Title',
            'type' => 'text',
        ),
        array(
            'id' => 'button-text',
            'label' => 'Button Text',
            'type' => 'text',
        ),
    );

    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }

    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes() {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'slide-information',
                __( 'Slide Information', 'homepage-slides' ),
                array( $this, 'add_meta_box_callback' ),
                $screen,
                'advanced',
                'default'
            );
        }
    }

    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post ) {
        wp_nonce_field( 'slide_information_data', 'slide_information_nonce' );
        $this->generate_fields( $post );
    }

    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post ) {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'slide_information_' . $field['id'], true );
            switch ( $field['type'] ) {
                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $field['type'] !== 'color' ? 'class="regular-text"' : '',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= $this->row_format( $label, $input );
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    /**
     * Generates the HTML for table rows.
     */
    public function row_format( $label, $input ) {
        return sprintf(
            '<tr><th scope="row">%s</th><td>%s</td></tr>',
            $label,
            $input
        );
    }
    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id ) {
        if ( ! isset( $_POST['slide_information_nonce'] ) )
            return $post_id;

        $nonce = $_POST['slide_information_nonce'];
        if ( !wp_verify_nonce( $nonce, 'slide_information_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                        break;
                    case 'text':
                        $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                        break;
                }
                update_post_meta( $post_id, 'slide_information_' . $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
                update_post_meta( $post_id, 'slide_information_' . $field['id'], '0' );
            }
        }
    }
}
new Rational_Meta_Box_2;


/**
 * Generated by the WordPress Meta Box Generator at http://goo.gl/8nwllb
 */
class Rational_Meta_Box {
    private $screens = array(
        'staff_members_cpt',
    );
    private $fields = array(
        array(
            'id' => 'hometown',
            'label' => 'Hometown',
            'type' => 'text',
        ),
        array(
            'id' => 'home-lanes',
            'label' => 'Home Lanes',
            'type' => 'text',
        ),
        array(
            'id' => 'age',
            'label' => 'Age',
            'type' => 'text',
        ),
        array(
            'id' => 'pap',
            'label' => 'PAP',
            'type' => 'text',
        ),
        array(
            'id' => 'handedness',
            'label' => 'Handedness',
            'type' => 'text',
        ),
        array(
            'id' => 'rev-rate',
            'label' => 'Rev Rate',
            'type' => 'text',
        ),
        array(
            'id' => 'speed',
            'label' => 'Speed',
            'type' => 'text',
        ),
        array(
            'id' => 'tilt',
            'label' => 'Tilt',
            'type' => 'text',
        ),
    );

    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }

    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes() {
        foreach ( $this->screens as $screen ) {
            add_meta_box(
                'bowler-information',
                __( 'Bowler Information', 'Bowler Information' ),
                array( $this, 'add_meta_box_callback' ),
                $screen,
                'side',
                'default'
            );
        }
    }

    /**
     * Generates the HTML for the meta box
     *
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post ) {
        wp_nonce_field( 'bowler_information_data', 'bowler_information_nonce' );
        echo 'All of the details about the bowler';
        $this->generate_fields( $post );
    }

    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post ) {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'bowler_information_' . $field['id'], true );
            switch ( $field['type'] ) {
                default:
                    $input = sprintf(
                        '<input id="%s" name="%s" type="%s" value="%s">',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= '<p>' . $label . '<br>' . $input . '</p>';
        }
        echo $output;
    }

    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id ) {
        if ( ! isset( $_POST['bowler_information_nonce'] ) )
            return $post_id;

        $nonce = $_POST['bowler_information_nonce'];
        if ( !wp_verify_nonce( $nonce, 'bowler_information_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                        break;
                    case 'text':
                        $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                        break;
                }
                update_post_meta( $post_id, 'bowler_information_' . $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
                update_post_meta( $post_id, 'bowler_information_' . $field['id'], '0' );
            }
        }
    }
}
new Rational_Meta_Box;

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );

