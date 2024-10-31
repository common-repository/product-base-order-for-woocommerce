<?php

namespace WPRealizer\ProductBaseOrderWC\Admin;

/**
 * Admin Menus Class
 *
 * @since  1.0.0
 */
class Menus {

    /**
     * Call Construct
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menus_render' ] );
        add_action( 'admin_init', [ $this, 'admin_init' ] );
    }

    /**
     * Admin menus render
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_menus_render() {
        global $submenu;

        $menu_slug     = 'product-base-order-wc';
        $menu_position = apply_filters( 'product_base_order_wc_admin_menu_position', 15 );
        $capability    = 'manage_options';

        $menu_pages[] = add_menu_page( __( 'Product Base Order', 'product-base-order-wc' ), __( 'Product Base Order', 'product-base-order-wc' ), $capability, $menu_slug, [ $this, 'settings_page' ], 'dashicons-feedback', $menu_position );

        $this->menu_pages[] = apply_filters( 'product_base_order_wc_admin_menu', $menu_pages, $menu_slug, $capability );
    }

    /**
     * Admin main page view
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_main_page_view() {
        do_action( 'product_base_order_wc_add_more_descriptions_top' );

        $headline = __( 'Product Base Order for WooCommerce', 'product-base-order-wc' );
        $tagsline = __( 'Shortcodes List:', 'product-base-order-wc' );
        ?>
        <div class="wrap">
            <h2><?php echo esc_html( $headline ); ?></h2>
            <h3><?php echo esc_html( $tagsline ); ?></h3>
            <div id="product-base-order-wc-shortcodes-area"> 
                <p>
                    <?php esc_html_e( 'Global Shortcode', 'product-base-order-wc' ); ?> : <code>[product_base_order_wc]</code>
                </p>
                <p>
                    <?php esc_html_e( 'All Products Base Shortcode', 'product-base-order-wc' ); ?> : <code>[product_base_order_wc products="all"]</code>
                </p>
                <p>
                    <?php esc_html_e( 'Specefic Products Base Shortcode', 'product-base-order-wc' ); ?> : <code>[product_base_order_wc products="22,33,44,55,66,667"]</code>
                </p>
                <p>
                    <?php esc_html_e( 'Filter Products Base Shortcode', 'product-base-order-wc' ); ?> : <code>[product_base_order_wc filter="yes"]</code>
                </p>
                <p>
                    <?php esc_html_e( 'Filter Products Base Shortcode', 'product-base-order-wc' ); ?> : <code>[product_base_order_wc filter="no"]</code>
                </p>
            </div>
        </div>
        <?php

        do_action( 'product_base_order_wc_add_more_descriptions_bottom' );
    }

    /**
     * Admin settings init
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function admin_init() {
        //set the settings
        wpr_product_base_order_wc()->settings_options->get_settings_sections();
        wpr_product_base_order_wc()->settings_options->get_settings_fields();

        //initialize settings
        wpr_product_base_order_wc()->settings_options->get_admin_init();
    }

    /**
     * Settings page
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function settings_page() {
        ?>
        <div class="wrap">
            <h2 style="margin-bottom: 15px;"><?php esc_html_e( 'Settings', 'product-base-order-wc' ); ?></h2>
            <div class="product-base-order-wc-settings-wrap">
                <?php
                settings_errors();

                wpr_product_base_order_wc()->settings_options->show_navigation();
                wpr_product_base_order_wc()->settings_options->show_forms();
                ?>
            </div>
        </div>
        <?php
    }
}

