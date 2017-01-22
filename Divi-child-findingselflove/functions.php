<?php
/**
 * Divi Child for Finding Selflove.
 *
 * This file adds custom functionality to the Elegant Themes Generic Divi Theme.
 *
 * @package Divi Child FindingSelflove
 * @author  Cap Web Solutions
 * @license GPL-2.0+
 * @link    http://capwebsolutions.com/
 */

/**
 * Modify the entry title text for blog module on front page and blog-home page
 *
 * Want to prefix the title with the contents of the custom field LWR   "LearnWatchRead"
 * if the field is populated.
 * format is <LWR content>: <uppercase entry title text>
 */

function cws_get_kne_lwr_title( $title ) {
   $title = get_post_meta($post->ID, 'lwr', true) . $title;
  var_dump($title);
	return $title;
}


/**
 * @snippet       Remove Product Tabs & Echo Long Description
 * @how-to        Watch tutorial @ http://businessbloomer.com/?p=19055
 * @sourcecode    http://businessbloomer.com/?p=19940
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 2.5.2
 */

// remove_action( 'woocommerce_after_single_product_summary' ,'woocommerce_output_product_data_tabs',10);

add_action( 'woocommerce_after_single_product_summary' ,'bbloomer_wc_output_long_description',10);
function bbloomer_wc_output_long_description() {
  ?>
  <div class="woocommerce-tabs"><?php the_content(); ?></div>
<?php
}

/**
 * @snippet       WooCommerce Hide Prices on the Shop Page
 * @how-to        Watch tutorial @ http://businessbloomer.com/?p=19055
 * @sourcecode    http://businessbloomer.com/?p=406
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 2.4.7
 */

// Remove prices
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );


// First, let's remove related products from their original position
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// Second, let's add a new tab

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
  $tabs['related_products'] = array(
    'title'     => __( 'Try it with', 'woocommerce' ),
    'priority'  => 50,
    'callback'  => 'woo_new_product_tab_content'
  );
  return $tabs;
}

// Third, let's put the related products inside

function woo_new_product_tab_content() {
  woocommerce_related_products();
}


// Move product tabs

// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );


/**
 * @snippet       WooCommerce  Show Product Custom Field in the Category Pages
 * @how-to        Watch tutorial @ http://businessbloomer.com/?p=19055
 * @sourcecode    http://businessbloomer.com/?p=17451
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 2.4.7
 */

// Add custom field to shop loop

// add_action( 'woocommerce_after_shop_loop_item_title', 'ins_woocommerce_product_excerpt', 35, 2);
if (!function_exists('ins_woocommerce_product_excerpt')) {
    function ins_woocommerce_product_excerpt() {
      global $post;
      if ( is_home() || is_shop() || is_product_category() || is_product_tag() ) {
        echo '<span class="excerpt">';
        echo get_post_meta( $post->ID, 'should_expect', true );
        echo '</span>';
      }
    }
}

/**
 * Playing around with single product pages
 */

/**
 * The do-action for cws_output_subtitle is called in the single-product template file.
 */
add_action( 'cws_output_subtitle', 'mycws_output_product_subtitle' );
function mycws_output_product_subtitle ( $my_text ) {
  echo '<div class="allura">' . $my_text . '</div>';
  return;
}

// add_action( 'woocommerce_product_thumbnails', 'cws_product_function_1');
function cws_product_function_1 ( ) {
  echo '<div class="quick">We can add some stuff here at YYY.</div>';
}
// add_action( 'woocommerce_product_meta_end', 'cws_product_function_2');
function cws_product_function_2 ( ) {
  echo '<div class="quick">We can add some stuff here at ZZZ.</div>';
}

// add_action( 'woocommerce_before_add_to_cart_form', 'cws_we_cover_areas');
function cws_we_cover_areas ( ) {
  $we_cover_areas = '<div><p class="quick kne-blue text-upper"> We cover 7 areas of focus in life</p><p class="quick kne-blue text-cap"> Community, meditation, movement, habits, Nutrition, & Declutter</p></div>';
  echo '<div class="quick">We can add some stuff here at XXX.</div>';
  echo $we_cover_areas;
}

/**
 * Adding Support for  CPT to Divi
 */
function cws_et_builder_post_types( $post_types ) {
    $post_types[] = 'cws_recipe';
    $post_types[] = 'product';
    // $post_types[] = 'ANOTHER_CPT_HERE';

    return $post_types;
}
add_filter( 'et_builder_post_types', 'cws_et_builder_post_types' );






// Show custom taxonomy (ie. Liturgical Season, Series)
//  terms for Sermon CPT single pages, archive page and Liturgical Season taxonomy term pages
add_filter( 'post_meta', 'cws_add_custom_sermon_post_meta' );
function cws_add_custom_sermon_post_meta( $post_meta ) {

  if ( is_singular( 'cws_recipe' ) || is_post_type_archive( 'cws_recipe' ) ||  is_tax( 'applicable-for' ) || is_tax( 'keyword' ) ) {
      $post_meta = '[post_terms taxonomy="applicable-for" before="Applicable For: "]<br>  [post_terms taxonomy="keyword" before="Keyword(s): "]';
  }
  return $post_meta;

}

/*
 * Ref: https://gist.github.com/lots0logs/d6e8ff16beec201eb3ec
 */

function cws_my_remove_default_et_pb_custom_search() {
  remove_action( 'pre_get_posts', 'et_pb_custom_search' );
  add_action( 'pre_get_posts', 'cws_my_et_pb_custom_search' );
}
add_action( 'wp_loaded', 'cws_my_remove_default_et_pb_custom_search' );

function cws_my_et_pb_custom_search( $query = false ) {
  if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_search ) {
    return;
  }
  if ( isset( $_GET['et_pb_searchform_submit'] ) ) {
    $postTypes = array();
    if ( ! isset($_GET['et_pb_include_posts'] ) && ! isset( $_GET['et_pb_include_pages'] ) ) $postTypes = array( 'post' );
    if ( isset( $_GET['et_pb_include_pages'] ) ) $postTypes = array( 'page' );
    if ( isset( $_GET['et_pb_include_posts'] ) ) $postTypes[] = 'post';
    
    /* BEGIN Add custom post types */
    $postTypes[] = 'cws_recipe';
    /* END Add custom post types */
    
    $query->set( 'post_type', $postTypes );
    if ( ! empty( $_GET['et_pb_search_cat'] ) ) {
      $categories_array = explode( ',', $_GET['et_pb_search_cat'] );
      $query->set( 'category__not_in', $categories_array );
    }
    if ( isset( $_GET['et-posts-count'] ) ) {
      $query->set( 'posts_per_page', (int) $_GET['et-posts-count'] );
    }
  }
}

/*
 * Custom widgets with "ACF Widget"
 */

class Example_Widget extends WP_Widget
{
  function Example_Widget() 
  {
    parent::WP_Widget(false, "Example Widget");
  }
 
  function update($new_instance, $old_instance) 
  {  
    return $new_instance;  
  }  
 
  function form($instance)
  {  
    $title = esc_attr($instance["title"]);  
    echo "<br />";
  }
 
  function widget($args, $instance) 
  {
    $widget_id = "widget_" . $args["widget_id"];
 
    // I like to put the HTML output for the actual widget in a seperate file
    // include(realpath(dirname(__FILE__)) . "/example_widget.php");
  }
}
// register_widget("Example_Widget");
// 
