<?php
/**
 * WooC
 *
 * This file contains functions realted to WooCommerce customizations
 *
 * @package   Core_Functionality
 * @since        1.0.0
 * @Plugin URI: https://github.com/mattry/selflove-core-cunctionality
 * @author			Matt Ryan [Cap Web Solutions] <matt@mattryan.co>
 * @copyright  Copyright (c) 2016, Cap Web Solutions
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


/**
 * remove default sorting dropdown
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Change number or products per row
 */
if (!function_exists('_cws_loop_columns')) {
   	function cws_loop_columns() {
      if ( is_shop() ) return 5;   // 5 across on shop archive page displaying categories only
   		return 4; // 4 products per row
   	}
}
// add_filter('loop_shop_columns', 'cws_loop_columns');

/**
 * Change number or products per page
 */
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );


/**
 * Removes Catagory Counters
 */
function woo_remove_category_products_count() {
 return;
}
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );

/**
  * hide coupon field on cart or checkout page
  */
function cws_hide_coupon_field_on_cart( $enabled ) {
  if ( is_cart() || is_checkout()  ) {
    $enabled = false;
  }
  return $enabled;
}
// add_filter( 'woocommerce_coupons_enabled', 'cws_hide_coupon_field_on_cart' );
// add_filter( 'woocommerce_coupons_enabled', 'cws_hide_coupon_field_on_checkout' );


/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 * @link: https://docs.woocommerce.com/document/hide-other-shipping-methods-when-free-shipping-is-available/
 */
function cws_hide_shipping_when_free_is_available( $rates ) {
	$free = array();

	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}

	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'cws_hide_shipping_when_free_is_available', 100 );



/**
 * Let's turn off that Ship to a different address box!
 */
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false');

/**
 * Hide Add to Cart on front page
 */
 
add_action('init', 'cws_hide_add_cart_on_front');
 
function cws_hide_add_cart_on_front() { 
  if (is_home() || is_front_page() || is_archive()) {       
   remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
   remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
   // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
   // remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );  
  }
}