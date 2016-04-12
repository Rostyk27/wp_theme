<?php

// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function woocleaner_css_and_js() {

    //remove generator meta tag
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
    remove_action('wp_head','wc_generator_tag');

    //first check that woo exists to prevent fatal errors
    if ( function_exists( 'is_woocommerce' ) ) {
        //dequeue scripts and styles
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            wp_dequeue_style( 'woocommerce-general' );
            wp_dequeue_style( 'woocommerce-layout' );
            wp_dequeue_style( 'woocommerce-smallscreen' );
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
        }
    }

}
add_action( 'wp_enqueue_scripts', 'woocleaner_css_and_js', 99 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
* WooCommerce Loop Product Thumbs
**/
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
    function woocommerce_template_loop_product_thumbnail() {
        echo woocommerce_get_product_thumbnail();
    }
}
/**
* WooCommerce Product Thumbnail
**/
//if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
//    function woocommerce_get_product_thumbnail( $size = 'large', $placeholder_width = 0, $placeholder_height = 0 ) {
//        global $post, $woocommerce;
//
//        $output = '';
//
//        if ( has_post_thumbnail() ) {
//            $output .= get_the_post_thumbnail( $post->ID, $size );
//        } else {
//            $output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="'.get_alt($post->ID).'" />';
//        }
//
//        return $output;
//    }
//}

function get_parent_terms($term) {
    if ($term->parent > 0) {
        $term = get_term_by("id", $term->parent, "product_cat");
        if ($term->parent > 0) {
            get_parent_terms($term);
        } else return $term;
    }
    else return $term;
}

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) { ob_start(); ?>
<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
<?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}

function plural_form($n, $forms) {
    return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
}

function woo_special_nav_class($classes, $item){
    if (( is_woocommerce() || is_product_category() || is_checkout() || is_checkout_pay_page() || is_cart() ) && get_post_meta( $item->ID, '_menu_item_object_id', true ) == SHOP_ID) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}

add_filter('nav_menu_css_class' , 'woo_special_nav_class' , 10 , 2);
