<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, get_stylesheet_directory() . '/languages' );

	// Remove phone styles for IOS
	add_action( 'wp_head', 'tm_remove_phone_styles' );
	function tm_remove_phone_styles() {
		echo '<meta name="format-detection" content="telephone=no" />';
	}

	// Include scripts and styles for Child Theme
	add_action( 'wp_enqueue_scripts', 'tm_enqueue_assets', 40 );
	function tm_enqueue_assets() {
		global $wp_styles;
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'theme_ie', get_stylesheet_directory_uri() . '/css/ie.css' );
		$wp_styles->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
	}

	//Layot change
	add_filter( 'cherry_layout_content_column', 'tm_content_column' );
	add_filter( 'cherry_layout_sidebar_column', 'tm_sidebar_column' );
	function tm_content_column() {
		return "span9";
	}
	function tm_sidebar_column() {
		return "span3";
	}

	//Change Slider Parameters
	add_filter( 'cherry_slider_params', 'tm_rewrite_slider_params' );
	function tm_rewrite_slider_params( $params ) {

		$params['height'] = "'47.4%'";
		$params['minHeight'] = "'100px'";

		return $params;
	}

	// Include additional files
	include_once( 'options-management.php' );
	include_once( 'shop-functions.php' );
    
    //stickmenu
    add_filter( 'cherry_stickmenu_selector', 'cherry_change_selector' );
     function cherry_change_selector($selector) {
      $selector = 'header .logo_box';
      return $selector;
    }
    
    //Change product on catalog page
    add_action( 'woocommerce_before_shop_loop_item','tm_product_open_wrap', 9);
    function tm_product_open_wrap( ) {
    echo "<a href='" . get_permalink() . "'>";
    }
    add_action( 'woocommerce_before_shop_loop_item','tm_product_close_wrap', 11);
    function tm_product_close_wrap() {
    echo "</a>";
    }
    
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );
    
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 11 );
    
    add_action( 'woocommerce_before_shop_loop_item', 'tm_product_link_wrap', 12);
    function  tm_product_link_wrap() {
    echo '<div class="product-link-wrap">';
    }
    add_action( 'woocommerce_after_shop_loop_item', 'tm_product_link_wrap_after', 99);
    function  tm_product_link_wrap_after() {
    echo '</div>';
    };
    
    add_filter( 'cherry_plugin_owl_items_custom', 'cherry_child_set_owl_items_custom' );
     function cherry_child_set_owl_items_custom( $items_custom ) {
      $items_custom[1] = array( 1200, 1 );
      $items_custom[2] = array( 980, 1 );
      $items_custom[3] = array( 768, 1 );
      $items_custom[4] = array( 480, 1 );
      return $items_custom;
     }

	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');
	function myHelpPointers() {
	//First we define our pointers 
	$pointers = array(
	   	array(
	       'id' => 'xyz1',   // unique id for this pointer
	       'screen' => 'options-permalink', // this is the page hook we want our pointer to show on
	       'target' => '#submit', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("submit_permalink"),
	       'content' => theme_locals("submit_permalink_desc"),
	       'position' => array( 
	                          'edge' => 'top', //top, bottom, left, right
	                          'align' => 'left', //top, bottom, left, right, middle
	                          'offset' => '0 5'
	                          )
	       ),

	    array(
	       'id' => 'xyz2',   // unique id for this pointer
	       'screen' => 'themes', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc"),
	       'position' => array( 
	                          'edge' => 'bottom', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 -10'
	                          )
	       ),

	    array(
	       'id' => 'xyz3',   // unique id for this pointer
	       'screen' => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc_2"),
	       'position' => array( 
	                          'edge' => 'left', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 18'
	                          )
	       )
	    // more as needed
	    );
		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers); 
	};

//Adding cart items counter
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'cherry_child_header_add_to_cart_fragment' );

function cherry_child_header_add_to_cart_fragment( $fragments ) {
	ob_start(); ?>
	<span class="cart-items"><?php echo WC()->cart->cart_contents_count ?></span>
	<?php
	$fragments['span.cart-items'] = ob_get_clean();
	return $fragments;
}

add_filter( 'widget_title', 'cherry_child_get_cart', 10 );
function cherry_child_get_cart( $title ) {

	if ( false === strpos( $title, '%items_num%' ) ) {
		return $title;
	}

	$items_str = '<span class="cart-items">' . WC()->cart->cart_contents_count . '</span>';
	$title = str_replace( '%items_num%', $items_str, $title );
	return $title;
}

?>