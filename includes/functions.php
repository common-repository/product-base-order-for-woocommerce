<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get All orders IDs for a given product ID
 *
 * @param  integer  $product_id (required)
 * @param  array    $order_status (optional) Default is 'wc-completed'
 *
 * @return array
 */
function wpr_get_orders_ids_by_product_id( $product_id, $order_status = array( 'wc-on-hold', 'wc-pending', 'wc-completed', 'wc-processing' ) ) {
    global $wpdb;

    $results = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = %d", $product_id
        )
    );

    return $results;
}

/**
 * Get the value of a settings field
 *
 * @param string $option
 * @param string $section
 * @param string $default
 *
 * @return mixed
 */
function wpr_pbowc_get_option( $option, $section, $default = '' ) {
    $options = get_option( $section );

    if ( isset( $options[ $option ] ) ) {
        return $options[ $option ];
    }

    return $default;
}

/**
 * Get default columns list
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpr_pbowc_default_columns_list() {
    $default_columns = apply_filters(
        'wpr_pbowc_default_columns_list', [
            'order_id'        => __( 'Order#', 'product-base-order-wc' ),
            'product_name'    => __( 'Product', 'product-base-order-wc' ),
            'billing_name'    => __( 'Customer', 'product-base-order-wc' ),
            'billing_company' => __( 'Company', 'product-base-order-wc' ),
            'billing_address' => __( 'Address', 'product-base-order-wc' ),
            'billing_city'    => __( 'City', 'product-base-order-wc' ),
            'billing_email'   => __( 'Email', 'product-base-order-wc' ),
            'billing_phone'   => __( 'Phone', 'product-base-order-wc' ),
            'order_total'     => __( 'Total', 'product-base-order-wc' ),
            'order_discount'  => __( 'Discount', 'product-base-order-wc' ),
            'payment_method'  => __( 'Payment Method', 'product-base-order-wc' ),
            'order_shipping'  => __( 'Shipping', 'product-base-order-wc' ),
            'order_status'    => __( 'Status', 'product-base-order-wc' ),
            'order_date'      => __( 'Date', 'product-base-order-wc' ),
        ]
    );

    return $default_columns;
}

/**
 * Get default selected columns list
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpr_pbowc_default_selected_columns_list() {
    $default_columns = apply_filters(
        'wpr_pbowc_default_selected_columns_list', [
            'order_id',
            'product_name',
            'billing_name',
            'billing_address',
            'order_total',
            'order_status',
            'order_date',
        ]
    );

    return $default_columns;
}

/**
 * Get columns list with label
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpr_pbowc_get_columns_list_with_label( $default_columns ) {
    if ( empty( $default_columns ) && ! is_array( $default_columns ) ) {
        return;
    }

    $get_columns      = wpr_pbowc_default_columns_list();
    $original_columns = array();

    foreach ( $default_columns as $default_column ) {
        $original_columns[ $default_column ] = $get_columns[ $default_column ];
    }

    return $original_columns;
}

/**
 * Get the value of a settings field
 *
 * @param string $option
 * @param string $section
 * @param string $default
 *
 * @return mixed
 */
function wpr_pbowc_get_default_values_by_order( $order, $context = '' ) {
    if ( empty( $order ) ) {
        return;
    }

    $get_id             = $order->get_id();
    $item_count         = $order->get_item_count();
    $billing_email      = $order->get_billing_email();
    $billing_phone      = $order->get_billing_phone();
    $billing_first_name = $order->get_billing_first_name();
    $billing_last_name  = $order->get_billing_last_name();
    $billing_company    = $order->get_billing_company();
    $billing_address_1  = $order->get_billing_address_1();
    $billing_address_2  = $order->get_billing_address_2();
    $billing_city       = $order->get_billing_city();
    $billing_state      = $order->get_billing_state();
    $billing_postcode   = $order->get_billing_postcode();
    $billing_country    = $order->get_billing_country();
    $shipping_total     = $order->get_shipping_total();
    $total_discount     = $order->get_total_discount();
    $method_title       = $order->get_payment_method_title();

    // get order status
    $statuses     = wc_get_order_statuses();
    $order_status = isset( $statuses[ 'wc-' . wpr_product_base_order_wc_get_prop( $order, 'status' ) ] ) ? esc_html( $statuses[ 'wc-' . wpr_product_base_order_wc_get_prop( $order, 'status' ) ] ) : esc_html( wpr_product_base_order_wc_get_prop( $order, 'status' ) );

    // get order time
    $order_date = date_i18n( get_option( 'date_format' ), strtotime( wpr_product_base_order_wc_get_date_created( $order ) ) );

    // get order total
    // translators: %1$s: Item count, %2$s: symble, %3$s: Total
    $order_total = wp_kses_post( sprintf( _n( '%1$s%2$s for %3$s item', '%1$s%2$s for %3$s items', $item_count, 'product-base-order-wc' ), get_woocommerce_currency_symbol(), $order->get_total(), $item_count ) );

    $default_values = array(
        'order_id'        => $get_id,
        'product_name'    => wpr_pbowc_get_product_name_order( $order ),
        'billing_name'    => $billing_first_name,
        'billing_company' => $billing_company,
        'billing_address' => $billing_address_1,
        'billing_address' => $billing_address_1,
        'billing_city'    => $billing_city,
        'billing_email'   => $billing_email,
        'billing_phone'   => $billing_phone,
        'order_total'     => $order_total,
        'order_discount'  => get_woocommerce_currency_symbol() . $total_discount,
        'order_shipping'  => get_woocommerce_currency_symbol() . $shipping_total,
        'order_status'    => $order_status,
        'order_date'      => $order_date,
        'payment_method'  => $method_title,
    );

    if ( $context ) {
        return isset( $default_values[ $context ] ) ? $default_values[ $context ] : '';
    }

    return $default_values;
}

/**
 * Get the product name
 *
 * @param string $option
 * @param string $section
 * @param string $default
 *
 * @return mixed
 */
function wpr_pbowc_get_product_name_order( $order ) {
    $line_items = $order->get_items( 'line_item' );

    foreach ( $line_items as $item_id => $item ) {
        $item_details = new \WC_Order_Item_Product( $item_id );
        $product_name = $item_details['name'];
        break;
    }

    return $product_name;
}

/**
 * Get order created date
 *
 * @since 2.5.7
 *
 * @param WC_Order $order
 *
 * @return String date
 */
function wpr_product_base_order_wc_get_date_created( $order ) {
    if ( version_compare( WC_VERSION, '2.7', '>' ) ) {
        return wc_format_datetime( $order->get_date_created(), get_option( 'date_format' ) . ', ' . get_option( 'time_format' ) );
    }

    return $order->order_date;
}

/**
 * Dynamically access new properties with backwards compatibility
 *
 * @since 2.5.7
 *
 * @param Object $object
 *
 * @param String $prop
 *
 * @param String $callback If the object is fetched using a different callback
 *
 * @return $prop
 */
function wpr_product_base_order_wc_get_prop( $object, $prop, $callback = false ) {
    if ( version_compare( WC_VERSION, '2.7', '>' ) ) {
        $fn_name = $callback ? $callback : 'get_' . $prop;
        return $object->$fn_name();
    }

    return $object->$prop;
}

/**
 * Get template part implementation for wedocs
 *
 * Looks at the theme directory first
 */
function wpr_product_base_order_wc_get_template_part( $slug, $name = '', $args = [] ) {
    $defaults = [
        'pro' => false,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $template = '';

    // Look in yourtheme/plugin-slug/slug-name.php and yourtheme/plugin-slug/slug.php
    $template = locate_template( [ wpr_product_base_order_wc()->template_path() . "{$slug}-{$name}.php", wpr_product_base_order_wc()->template_path() . "{$slug}.php" ] );

    /**
     * Change template directory path filter
     *
     * @since 1.0.0
     */
    $template_path = apply_filters( 'wpr_product_base_order_wc_set_template_path', wpr_product_base_order_wc()->plugin_path() . '/templates', $template, $args );

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( $template_path . "/{$slug}-{$name}.php" ) ) {
        $template = $template_path . "/{$slug}-{$name}.php";
    }

    if ( ! $template && ! $name && file_exists( $template_path . "/{$slug}.php" ) ) {
        $template = $template_path . "/{$slug}.php";
    }

    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters( 'wpr_product_base_order_wc_get_template_part', $template, $slug, $name );

    if ( $template ) {
        include $template;
    }
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param mixed  $template_name
 * @param array  $args          (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return void
 */
function wpr_product_base_order_wc_get_template( $template_name, $args = [], $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = wpr_product_base_order_wc_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', esc_html( $located ) ), '2.1' );

        return;
    }

    do_action( 'wpr_product_base_order_wc_before_template_part', $template_name, $template_path, $located, $args );

    include $located;

    do_action( 'wpr_product_base_order_wc_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @param mixed  $template_name
 * @param string $template_path (default: '')
 * @param string $default_path  (default: '')
 *
 * @return string
 */
function wpr_product_base_order_wc_locate_template( $template_name, $template_path = '', $default_path = '', $pro = false ) {
    if ( ! $template_path ) {
        $template_path = wpr_product_base_order_wc()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = wpr_product_base_order_wc()->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        [
            trailingslashit( $template_path ) . $template_name,
        ]
    );

    // Get default template
    if ( ! $template ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters( 'wpr_product_base_order_wc_locate_template', $template, $template_name, $template_path );
}
