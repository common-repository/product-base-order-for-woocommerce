<?php
/**
 * Plugin Name: Product Base Order for WooCommerce
 * Plugin URI: https://wprealizer.com/wprealizer-plugins/product-base-order-for-woocommerce
 * Description: Product Base Order for WooCommerce
 * Version: 1.0.0
 * Author: WPRealizer
 * Author URI: https://wprealizer.com
 * Text Domain: product-base-order-wc
 * Domain Path: /languages/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/*
 * Copyright (c) 2021 WP Realizer (email: wprealizer@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product_Base_Order_WC final class
 *
 * @class Product_Base_Order_WC The class that holds the entire Product_Base_Order_WC plugin
 */
final class Product_Base_Order_WC {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Instance of self
     *
     * @var Product_Base_Order_WC
     */
    private static $instance = null;

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.6.0';

    /**
     * Holds various class instances
     *
     * @since 1.0.0
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Product_Base_Order_WC class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses add_action()
     */
    public function __construct() {
        require_once __DIR__ . '/vendor/autoload.php';

        // Define all constant
        $this->define_constant();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivation' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes the Product_Base_Order_WC() class
     *
     * Checks for an existing Product_Base_Order_WC() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 1.0.0
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     */
    public function activate() {
        if ( ! $this->has_woocommerce() ) {
            set_transient( 'product_base_order_wc_missing_notice', true );
            return false;
        }

        $installer = new \WPRealizer\ProductBaseOrderWC\Install\Installer();
        $installer->prepare_install();
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     *
     * @since 1.0.0
     */
    public function deactivation() {
        delete_transient( 'product_base_order_wc_missing_notice', true );
    }

    /**
     * Defined constant
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function define_constant() {
        define( 'WPR_PRODUCT_BASE_ORDER_WC_VERSION', $this->version );
        define( 'WPR_PRODUCT_BASE_ORDER_WC_FILE', __FILE__ );
        define( 'WPR_PRODUCT_BASE_ORDER_WC_DIR', __DIR__ );
        define( 'WPR_PRODUCT_BASE_ORDER_WC_PATH', dirname( WPR_PRODUCT_BASE_ORDER_WC_FILE ) );
        define( 'WPR_PRODUCT_BASE_ORDER_WC_ASSETS', plugins_url( '/assets', WPR_PRODUCT_BASE_ORDER_WC_FILE ) );
        define( 'WPR_PRODUCT_BASE_ORDER_WC_INC', WPR_PRODUCT_BASE_ORDER_WC_PATH . '/includes' );
    }

    /**
     * Load the plugin
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init_plugin() {
        //includes file
        $this->includes();

        // init actions and filter
        $this->init_hooks();

        do_action( 'product_base_order_wc_loaded', $this );
    }

    /**
     * Includes all files
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function includes() {
        require_once WPR_PRODUCT_BASE_ORDER_WC_INC . '/functions.php';
    }

    /**
     * Init all filters
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function init_hooks() {
        add_action( 'init', [ $this, 'localization_setup' ] );
        add_action( 'init', [ $this, 'init_classes' ] );
    }

    /**
     * Init all the classes
     *
     * @return void
     */
    public function init_classes() {
        if ( is_admin() ) {
            new \WPRealizer\ProductBaseOrderWC\Admin\Admin();
            new \WPRealizer\ProductBaseOrderWC\Admin\Menus();
        }
        new \WPRealizer\ProductBaseOrderWC\Assets();

        $this->container['product_base_order'] = new \WPRealizer\ProductBaseOrderWC\ProductBaseOrder();

        if ( is_admin() ) {
            $this->container['settings_options'] = new \WPRealizer\ProductBaseOrderWC\Admin\Settings();
            $this->container['setting_field']    = new \WPRealizer\ProductBaseOrderWC\Admin\SettingsFields();
        }
    }

    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php() {
        if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return apply_filters( 'product_base_order_wc_template_path', 'product-base-order-for-woocommerce/' );
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'product-base-order-wc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Check whether woocommerce is installed or not
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function has_woocommerce() {
        return class_exists( 'WooCommerce' );
    }
}

/**
 * Load WP Demo Plugin when all plugins loaded
 *
 * @return Product_Base_Order_WC
 */
function wpr_product_base_order_wc() {
    return Product_Base_Order_WC::init();
}

wpr_product_base_order_wc();
