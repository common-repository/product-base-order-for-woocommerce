<?php

namespace WPRealizer\ProductBaseOrderWC;

/**
 * Assets class
 *
 * @since 1.0.0
 */
class Assets {

    /**
     * Assets class construct
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
    }

    /**
     * Admin register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        // JS
        wp_enqueue_script( 'product-base-order-wc-admin-scripts', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/js/product-base-order-wc-admin.js', array( 'jquery' ), WPR_PRODUCT_BASE_ORDER_WC_VERSION );

        // CSS
        wp_enqueue_style( 'product-base-order-wc-admin-styles', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/css/product-base-order-wc-admin.css', array(), WPR_PRODUCT_BASE_ORDER_WC_VERSION, 'all' );
    }

    /**
     * Frontend register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueue_frontend_scripts() {
        // JS
        wp_enqueue_script( 'product-base-order-wc-script', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/js/product-base-order-wc.js', array( 'jquery' ), WPR_PRODUCT_BASE_ORDER_WC_VERSION, true );
        wp_enqueue_script( 'product-base-order-wc-data-table', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/vendors/data-table/jquery.dataTables.js', array( 'jquery' ), WPR_PRODUCT_BASE_ORDER_WC_VERSION, true );

        // CSS
        wp_enqueue_style( 'product-base-order-wc-style', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/css/product-base-order-wc-style.css', array(), WPR_PRODUCT_BASE_ORDER_WC_VERSION, 'all' );
        wp_enqueue_style( 'product-base-order-wc-data-table', WPR_PRODUCT_BASE_ORDER_WC_ASSETS . '/vendors/data-table/jquery.dataTables.css', array(), WPR_PRODUCT_BASE_ORDER_WC_VERSION, 'all' );
    }
}
