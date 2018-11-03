<?php
// ------------------------------------------
// Setting theme after setup
// ------------------------------------------
if ( ! function_exists( 'baby_after_setup' ) ) {
    function baby_after_setup() {

        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list' ) );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
        add_theme_support( 'title-tag' );
        //add_theme_support( 'site-logo' );
        add_theme_support( 'custom-logo', array(
                                'height'      => 100,
                                'width'       => 400,
                                'flex-height' => true,
                                'flex-width'  => true,
                                'header-text' => array( 'site-title', 'site-description' ),
                            ) );
        $defaults = array(
            'default-image' => '',
            'default-preset' => 'default',
            'default-position-x' => 'left',
            'default-position-y' => 'top',
            'default-size' => 'auto',
            'default-repeat' => 'repeat',
            'default-attachment' => 'scroll',
            'default-color' => '',
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support( 'custom-background', $defaults );

        $defaults = array(
            'default-image' => '',
            'random-default' => false,
            'width' => 0,
            'height' => 0,
            'flex-height' => false,
            'flex-width' => false,
            'default-text-color' => '',
            'header-text' => true,
            'uploads' => true,
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
            'video' => false,
            'video-active-callback' => 'is_front_page',
        );
        add_theme_support( 'custom-header', $defaults );
        
        add_theme_support( 'woocommerce' );
        register_nav_menus(
            array(
                'top-menu' => esc_html__( 'Top menu', 'saltwp' ),
            )
        );
        add_editor_style('css/style.css');
    }
}
add_action( 'after_setup_theme', 'baby_after_setup' );

/*
 * Check need minimal requirements (PHP and WordPress version)
 */
if ( version_compare( $GLOBALS['wp_version'], '4.3', '<' ) || version_compare( PHP_VERSION, '5.1', '<' ) ) {
    function baby_requirement_notice()
    {
        $message = sprintf( esc_html__( 'BABY theme needs minimal WordPress version 4.3 and PHP 5.3. You are running version WordPress - %s, PHP - %s.<br>Please upgrade need module and try again.', 'baby-store' ), $GLOBALS['wp_version'], PHP_VERSION );
        printf( '<div class="notice-warning notice"><p><strong>%s</strong></p></div>', $message );
    }
    add_action( 'admin_notices', 'baby_requirement_notice' );
}


add_action('wp_enqueue_scripts', 'add_theme_style');
function add_theme_style(){
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', false, '1.1', 'all' );
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '1.1', 'all' );
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, '1.1', 'all' );
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl-coursel/owl.carousel.css', false, '1.1', 'all' );
    wp_enqueue_style('owl-transition', get_template_directory_uri() . '/css/owl-coursel/owl.transitions.css', false, '1.1', 'all' );
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/style.css', false, '1.1', 'all' );
    wp_enqueue_style('style', get_stylesheet_uri() );
    wp_enqueue_style('fw-css', get_template_directory_uri() . '/css/fw.css', false, '1.1', 'all' );

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap/bootstrap.min.js', array(), false, false);
    wp_enqueue_script('owl-coursel', get_template_directory_uri().'/js/owl-coursel/owl.carousel.js', array(), false, false);
    wp_enqueue_script('magnific-popup', get_template_directory_uri().'/js/magnific-popup/jquery.magnific-popup.min.js', array(), false, false);
    wp_enqueue_script('script', get_template_directory_uri().'/js/script.js', array(), false, false);

}


/**
 * Returns product price based on sales.
 * 
 * @return string
 */
function the_dramatist_price_show() {
    global $product;
    if( $product->is_on_sale() ) {
        return $product->get_sale_price();
    }
    return $product->get_regular_price();
}

// add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);
// function custom_variation_price( $price, $product ) {
//     $price = '';
//     $price .= wc_price($product->get_variation_price('min'));
//     return $price;
// }

add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text($button){
    global $product;
    $button = 'hello';
    return $button;
}

// add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );   // < 2.1
// add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );//2.1 +
// function woo_custom_single_add_to_cart_text() {  
//     return __( 'My Button Text', 'woocommerce' );
// }


// Part 1
// Edit Single Product Page Add to Cart
 
add_filter( 'woocommerce_product_single_add_to_cart_text', 'bbloomer_custom_add_cart_button_single_product' );
 
function bbloomer_custom_add_cart_button_single_product( $label ) {
     
    foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
        $product = $values['data'];
        if( get_the_ID() == $product->get_id() ) {
            $label = __('Already in Cart. Add again?', 'woocommerce');
        }
    }
     
    return $label;
 
}
 
// Part 2
// Edit Loop Pages Add to Cart
 
add_filter( 'woocommerce_product_add_to_cart_text', 'bbloomer_custom_add_cart_button_loop', 99, 2 );
 
function bbloomer_custom_add_cart_button_loop( $label, $product ) {
     
    if ( $product->get_type() == 'simple' && $product->is_purchasable() && $product->is_in_stock() ) {
         
        foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
            $_product = $values['data'];
            if( get_the_ID() == $_product->get_id() ) {
                $label = __('Already in Cart. Add again?', 'woocommerce');
            }
        }
         
    }
     
    return $label;
     
}



add_filter('single_add_to_cart_text', 'woo_custom_cart_button_text');
function woo_custom_cart_button_text() { return __('Add Item', 'woocommerce'); }

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_mini_cart_refresh_number');
function wc_mini_cart_refresh_number($fragments){
    ob_start();
    ?>
    <span class="mini-cart-count">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php
        $fragments['.cart .cart-item > span'] = ob_get_clean();
    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_mini_cart_refresh_items');
function wc_mini_cart_refresh_items($fragments){
    ob_start();
    ?>
    <div class="mini-cart-content">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
        $fragments['.cart .dropdown-menu li .media'] = ob_get_clean();
        return $fragments;
}


/* Custom Shoping Cart in the top */
function YOURTHEME_wc_print_mini_cart() {
    ?>
    <div id="YOURTHEME-minicart-top">
        <?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
            <ul class="YOURTHEME-minicart-top-products">
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product = $cart_item['data'];
                // Only display if allowed
                if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 ) continue;
                // Get price
                $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax($_product) : $_product->get_price_including_tax();
                $product_price = apply_filters( 'woocommerce_cart_item_price_html', wc_price($_product->get_price()));
                ?>
                <li class="YOURTHEME-mini-cart-product clearfix">
                    <span class="YOURTHEME-mini-cart-thumbnail">
                        <?php echo $_product->get_image(); ?>
                    </span>
                    <span class="YOURTHEME-mini-cart-info">
                        <a class="YOURTHEME-mini-cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
                            <h4><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></h4>
                        </a>
                        <?php echo apply_filters( 'woocommerce_widget_cart_item_price', '<span class="woffice-mini-cart-price">' . __('Unit Price', 'YOURTHEME') . ':' . $product_price . '</span>', $cart_item, $cart_item_key ); ?>
                        <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="YOURTHEME-mini-cart-quantity">' . __('Quantity', 'woffice') . ':' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul><!-- end .YOURTHEME-mini-cart-products -->
        <?php else : ?>
            <p class="YOURTHEME-mini-cart-product-empty"><?php _e( 'No products in the cart.', 'YOURTHEME' ); ?></p>
        <?php endif; ?>
        <?php if (sizeof( WC()->cart->get_cart()) > 0) : ?>
            <h4 class="text-center YOURTHEME-mini-cart-subtotal"><?php _e( 'Cart Subtotal', 'YOURTHEME' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></h4>
            <div class="text-center">
                <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-default">
                    <i class="fa fa-shopping-cart"></i> <?php _e( 'Cart', 'YOURTHEME' ); ?>
                </a>
                <a href="<?php echo wc_get_checkout_url(); ?>" class="alt checkout btn btn-default">
                    <i class="fa fa-credit-card"></i> <?php _e( 'Checkout', 'YOURTHEME' ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php
}



remove_action('woocommerce_before_main_content','woocommerce_output_content_wrapper');
remove_action('woocommerce_after_main_content','woocommerce_output_content_wrapper_end');

// add_action('woocommerce_before_main_content','custom_woocommerce_output_content_wrapper');
// function custom_woocommerce_output_content_wrapper(){
//     echo '<section class="m-t-0 p-b-40"><div class="container">';
// }

// add_action('woocommerce_before_main_content','custom_woocommerce_output_content_wrapper_end');
// function custom_woocommerce_output_content_wrapper_end(){
//     echo '<section class="m-t-0 p-b-40"><div class="container">';
// }

remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs');
//add_action('woocommerce_single_product_summary','woocommerce_output_product_data_tabs',70);





/**
* Registers a text field setting for Wordpress 4.7 and higher.
**/
function register_my_setting() {
    $args = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
            );
    register_setting( 'general', 'my_option_name', $args ); 
} 
add_action( 'admin_init', 'register_my_setting' );


add_action( 'admin_init', 'register_my_settings_section' );
function register_my_settings_section(){
    add_settings_section(
        'eg_setting_section',
        __( 'Example settings section in reading', 'textdomain' ),
        'wpdocs_setting_section_callback_function',
        'reading'
    );
}
 
/**
 * Settings section display callback.
 *
 * @param array $args Display arguments.
 */
function wpdocs_setting_section_callback_function( $args ) {
    // echo section intro text here
    echo '<p>id: ' . esc_html( $args['id'] ) . '</p>';                         // id: eg_setting_section
    echo '<p>title: ' . apply_filters( 'the_title', $args['title'] ) . '</p>'; // title: Example settings section in reading
    echo '<p>callback: ' . esc_html( $args['callback'] ) . '</p>';             // callback: eg_setting_section_callback_function
    echo '<input type="text" value="default" />';
    do_settings_sections( 'test-settings-section' );
}

add_action('test-settings-section','test_settings_section_callback');
function test_settings_section_callback(){
    echo 'djdj';
}



add_action('admin_init', 'ozhwpe_admin_init');
function ozhwpe_admin_init(){
    register_setting(
        'writings',                 // settings page
        'ozhwpe_options',          // option name
        'ozhwpe_validate_options'  // validation callback
    );
    
    add_settings_field(
        'ozhwpe_notify_boss',      // id
        'Boss Email',              // setting title
        'ozhwpe_setting_input',    // display callback
        'writings',                 // settings page
        'default'                  // settings section
    );

}

// Display and fill the form field
function ozhwpe_setting_input() {
    // get option 'boss_email' value from the database
    $options = get_option( 'ozhwpe_options' );
    $value = $options['boss_email'];
    
    // echo the field
    ?>
<input id='boss_email' name='ozhwpe_options[boss_email]'
 type='text' value='<?php echo esc_attr( $value ); ?>' /> Boss wants to get a mail when a post is published
    <?php
}

// Validate user input
function ozhwpe_validate_options( $input ) {
    $valid = array();
    $valid['boss_email'] = sanitize_email( $input['boss_email'] );
    
    // Something dirty entered? Warn user.
    if( $valid['boss_email'] != $input['boss_email'] ) {
        add_settings_error(
            'ozhwpe_boss_email',           // setting title
            'ozhwpe_texterror',            // error ID
            'Invalid email, please fix',   // error message
            'error'                        // type of message
        );      
    }
    
    return $valid;
}


add_action('admin_menu','register_menu_page');
function register_menu_page(){
    add_menu_page('my menu page','my menu page', 'manage_options','my_menu_page','my_menu_page_function');
}

add_action("admin_init", "display_options_custom");
function display_options_custom(){
    add_settings_section('my_settings_section','my settings section', 'my_settings_section','my_menu_page');
add_settings_field('my_settings_field_one','my settings field_one', 'my_settings_field_one', 'my_menu_page','my_settings_section');
}

function my_menu_page_function(){
    echo 'my custom menu page';
    do_settings_sections('my_menu_page');
    submit_button();
}

function my_settings_section(){
    echo 'my settings_section';
    echo '<input type="text" value="default_section_input" placeholder="default_section_input" />';
}

function my_settings_field_one(){
    echo '<input type="text" value="default_section_input" placeholder="default_section_input" />';   
}

?>


<?php
    function add_new_menu_items()
    {
        add_menu_page(
            "Theme Options",
            "Theme Options",
            "manage_options",
            "theme-options",
            "theme_options_page",
            "", 
            100 
        );

    }

    function theme_options_page()
    {
        ?>
            <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>Theme Options</h1>
            
            <?php
                //we check if the page is visited by click on the tabs or on the menu button.
                //then we get the active tab.
                $active_tab = "header-options";
                if(isset($_GET["tab"]))
                {
                    if($_GET["tab"] == "header-options")
                    {
                        $active_tab = "header-options";
                    }
                    else
                    {
                        $active_tab = "ads-options";
                    }
                }
            ?>
            
            <!-- wordpress provides the styling for tabs. -->
            <h2 class="nav-tab-wrapper">
                <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
                <a href="?page=theme-options&tab=header-options" class="nav-tab <?php if($active_tab == 'header-options'){echo 'nav-tab-active';} ?> "><?php _e('Header Options', 'sandbox'); ?></a>
                <a href="?page=theme-options&tab=ads-options" class="nav-tab <?php if($active_tab == 'ads-options'){echo 'nav-tab-active';} ?>"><?php _e('Advertising Options', 'sandbox'); ?></a>
            </h2>

            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php
                
                    settings_fields("header_section");
                    
                    do_settings_sections("theme-options");
                
                    submit_button(); 
                    
                ?>          
            </form>
        </div>
        <?php
    }

    add_action("admin_menu", "add_new_menu_items");

    function display_options()
    {
        add_settings_section("header_section", "Header Options", "display_header_options_content", "theme-options");
        add_settings_section("header_section1", "Header Second Options", "display_header_options_content1", "theme-options");

        //here we display the sections and options in the settings page based on the active tab
        if(isset($_GET["tab"]))
        {
            if($_GET["tab"] == "header-options")
            {
                add_settings_field("header_logoc", "Logo Url", "display_logo_form_element", "theme-options", "header_section");
                register_setting("header_section", "header_logoe");

                //add a new setting for file upload
                add_settings_field("background_picture", "Picture File Upload", "background_form_element", "theme-options", "header_section");
                //register a callback which will retirve the url to the file and then save the value.
                //register_setting only saves the value attribute of the form field....if you need anything more than that then use the callback to find the value t be stored.
                register_setting("header_section", "background_picture", "handle_file_upload");
            }
            else
            {
                add_settings_field("advertising_code", "Ads Code", "display_ads_form_element", "theme-options", "header_section");      
                register_setting("header_section", "advertising_code");
            }
        }
        else
        {
            add_settings_field("header_logoc", "Logo Url", "display_logo_form_element", "theme-options", "header_section");
            register_setting("header_section", "header_logoe");
            
            add_settings_field("background_picture", "Picture File Upload", "background_form_element", "theme-options", "header_section");
            register_setting("header_section", "background_picture", "handle_file_upload");
        }
        
    }

    function handle_file_upload($options)
    {
        //check if user had uploaded a file and clicked save changes button
        if(!empty($_FILES["background_picture"]["tmp_name"]))
        {
            $urls = wp_handle_upload($_FILES["background_picture"], array('test_form' => FALSE));
            $temp = $urls["url"];
            return $temp;   
        }

        //no upload. old file url is the new value.
        return get_option("background_picture");
    }


    function display_header_options_content(){echo "The header of the theme";}
    function display_header_options_content1(){echo "The header one of the theme";}
    function background_form_element()
    {
        //echo form element for file upload
        ?>
            <input type="file" name="background_picture" id="background_picture" value="<?php echo get_option('background_picture'); ?>" />
            <?php echo get_option("background_picture"); ?>
        <?php
    }
    function display_logo_form_element()
    {
        ?>
            <input type="text" name="header_logo" id="header_logo" value="<?php echo get_option('header_logoe'); ?>" />
        <?php
    }
    function display_ads_form_element()
    {
        ?>
            <input type="text" name="advertising_code" id="advertising_code" value="<?php echo get_option('advertising_code'); ?>" />
        <?php
    }

    add_action("admin_init", "display_options");




add_action( 'init', 'codex_book_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_book_init() {
    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'your-plugin-textdomain' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
        'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
        'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
        'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
    );

    $args = array(
        'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

    register_post_type( 'book', $args );
}



function my_shortcode_handler( $atts, $content ) {
    $a = shortcode_atts( array(
        'attr_1' => 'attribute 1 default',
        'attr_2' => 'attribute 2 default',
        // ...etc
    ), $atts );
    print_r($a);
}
add_shortcode('my_shortcode', 'my_shortcode_handler');

function caption_shortcode( $atts, $content = null ) {
    return '<span class="caption">' . $content . '</span>';
}
add_shortcode( 'caption', 'caption_shortcode' );



class MyNewWidget extends WP_Widget {

    function __construct() {
        // Instantiate the parent object
        parent::__construct( false, 'My New Widget Title' );
    }

    function widget( $args, $instance ) {
        // Widget output
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
    }

    function form( $instance ) {
        // Output admin widget options form
    }
}
function myplugin_register_widgets() {
    register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );


add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'theme-slug' ),
        'id' => 'sidebar-1',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>',
    ) );
}
