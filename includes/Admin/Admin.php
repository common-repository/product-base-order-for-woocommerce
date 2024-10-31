<?php

namespace WPRealizer\ProductBaseOrderWC\Admin;

/**
 * Admin Class
 *
 * @since 1.0.0
 */
class Admin {

    /**
     * Admin Class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_notices', [ $this, 'render_missing_woocommerce_notice' ] );
    }

    /**
     * Missing woocomerce notice
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render_missing_woocommerce_notice() {
        if ( ! get_transient( 'product_base_order_wc_missing_notice' ) ) {
            return;
        }

        if ( wpr_product_base_order_wc()->has_woocommerce() ) {
            return delete_transient( 'product_base_order_wc_missing_notice' );
        }

        $plugin_url = self_admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' );

        /* translators: %s: wc plugin url */
        $message = sprintf( __( 'Product Base Order for WooCommerce requires WooCommerce to be installed and active. You can activate <a href="%s">WooCommerce</a> here.', 'product-base-order-wc' ), $plugin_url );

        echo wp_kses_post( sprintf( '<div class="error"><p><strong>%1$s</strong></p></div>', $message ) );
    }
}
