<?php

namespace WPRealizer\ProductBaseOrderWC;

/**
 * Assets class
 *
 * @since 1.0.0
 */
class ProductBaseOrder {

    /**
     * Assets class construct
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_shortcode( 'product_base_order_wc', [ $this, 'product_base_orders_render' ] );

        $position_product     = wpr_pbowc_get_option( 'position_for_single_product', 'wpr_pbowc_admin_settings_product_page', 'before_related_products' );
        $allow_single_product = wpr_pbowc_get_option( 'allow_for_single_product', 'wpr_pbowc_admin_settings_product_page', 'no' );

        if ( 'before_related_products' === $position_product && 'yes' === $allow_single_product ) {
            add_action( 'woocommerce_after_single_product_summary', [ $this, 'after_single_product' ], 10 );
        }

        if ( 'after_related_products' === $position_product && 'yes' === $allow_single_product ) {
            add_action( 'woocommerce_after_single_product', [ $this, 'after_single_product' ] );
        }
    }

    /**
     * Admin register scripts
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function product_base_orders_render( $atts ) {
        $logged_users_only = wpr_pbowc_get_option( 'allow_for_logged_users_only', 'wpr_pbowc_admin_settings_general', '' );

        if ( 'yes' === $logged_users_only && ! is_user_logged_in() && ! is_singular( 'product' ) ) {
            return;
        }

        if ( ! wpr_product_base_order_wc()->has_woocommerce() ) {
            return;
        }

        $main_title      = wpr_pbowc_get_option( 'main_title', 'wpr_pbowc_admin_settings_general', __( 'Recent Orders', 'product-base-order-wc' ) );
        $sub_title       = wpr_pbowc_get_option( 'sub_title', 'wpr_pbowc_admin_settings_general', '' );
        $p_main_title    = wpr_pbowc_get_option( 'main_title', 'wpr_pbowc_admin_settings_product_page', __( 'Recent Orders', 'product-base-order-wc' ) );
        $p_sub_title     = wpr_pbowc_get_option( 'sub_title', 'wpr_pbowc_admin_settings_product_page', '' );
        $general_columns = wpr_pbowc_get_option( 'allow_for_default_columns', 'wpr_pbowc_admin_settings_general', wpr_pbowc_default_selected_columns_list() );
        $product_columns = wpr_pbowc_get_option( 'allow_for_default_columns', 'wpr_pbowc_admin_settings_product_page', wpr_pbowc_default_selected_columns_list() );

        $default_columns = is_singular( 'product' ) ? $product_columns : $general_columns;
        $main_title      = is_singular( 'product' ) ? $p_main_title : $main_title;
        $sub_title       = is_singular( 'product' ) ? $p_sub_title : $sub_title;

        $get_atts_data = shortcode_atts(
            array(
                'title'                    => $main_title,
                'sub_title'                => $sub_title,
                'products'                 => 'all',
                'product_filter'           => 'yes',
                'category_filter'          => 'yes',
                'wc_default_data_columns'  => '',
                'custom_meta_data_columns' => '',
            ), $atts
        );

        $get_orders = get_posts(
            apply_filters(
                'product_base_order_wc_my_orders_query', array(
                    'numberposts' => -1,
                    'post_type'   => 'shop_order',
                    'post_status' => 'wc-publish',
                )
            )
        );

        $products_count     = 0;
        $filter_option      = false;
        $s_product_name     = '';
        $s_product_id       = isset( $_GET['product-id'] ) && sanitize_text_field( wp_unslash( $_GET['product-id'] ) ) !== 'all' ? sanitize_text_field( wp_unslash( $_GET['product-id'] ) ) : 0;
        $s_category_id      = isset( $_GET['category-id'] ) && sanitize_text_field( wp_unslash( $_GET['category-id'] ) ) !== 'all' ? sanitize_text_field( wp_unslash( $_GET['category-id'] ) ) : 0;
        $products_list      = $get_atts_data['products'];
        $main_title         = $get_atts_data['title'];
        $sub_title          = $get_atts_data['sub_title'];
        $filter_products    = array();
        $product_categories = array();

        if ( $products_list !== 'all' ) {
            $get_orders = array();

            if ( strpos( $products_list, ',' ) !== false ) {
                $product_ids = explode( ',', $get_atts_data['products'] );

                if ( is_array( $product_ids ) ) {
                    foreach ( $product_ids as $product_id ) {
                        $get_order  = wpr_get_orders_ids_by_product_id( (int) $product_id );
                        $get_orders = array_merge( $get_order, $get_orders );
                        $products_count++;
                    }
                }
            } else {
                $get_orders = wpr_get_orders_ids_by_product_id( (int) $products_list );
            }
        }

        if ( $s_product_id ) {
            $get_orders  = wpr_get_orders_ids_by_product_id( (int) $s_product_id );
            $get_product = wc_get_product( (int) $s_product_id );
            if ( $get_product ) {
                $s_product_name = $get_product->get_title();
            }
        }

        if ( 'yes' === $get_atts_data['product_filter'] && ( $products_count > 1 || 'all' === $get_atts_data['products'] ) ) {
            $filter_option = true;

            if ( 'all' === $get_atts_data['products'] ) {
                $p_query = new \WC_Product_Query(
                    array(
                        'status'  => 'publish',
                        'limit'   => -1,
                        'orderby' => 'name',
                        'order'   => 'DESC',
                    )
                );
                $products_lists = $p_query->get_products();

                foreach ( $products_lists as $product ) {
                    $filter_products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                    ];
                }
            } elseif ( strpos( $get_atts_data['products'], ',' ) !== false ) {
                $product_ids = explode( ',', $get_atts_data['products'] );

                if ( is_array( $product_ids ) ) {
                    foreach ( $product_ids as $product_id ) {
                        $get_product = wc_get_product( (int) $product_id );
                        if ( $get_product ) {
                            $filter_products[] = [
                                'id' => $product_id,
                                'name' => $get_product->get_title(),
                            ];
                        }
                    }
                }
            }
        }

        if ( 'yes' === $get_atts_data['category_filter'] ) {
            $filter_option = true;

            $cat_args = array(
                'orderby'    => 'name',
                'order'      => 'asc',
                'hide_empty' => true,
            );

            $product_categories = get_terms( 'product_cat', $cat_args );
        }

        ob_start();

        wpr_product_base_order_wc_get_template_part(
            'global-orders-list',
            '',
            array(
                'get_orders'         => $get_orders,
                'default_columns'    => wpr_pbowc_get_columns_list_with_label( $default_columns ),
                'filter_option'      => $filter_option,
                'filter_products'    => $filter_products,
                's_product_id'       => $s_product_id,
                's_product_name'     => $s_product_name,
                'product_categories' => $product_categories,
                'get_atts_data'      => $get_atts_data,
                's_category_id'      => $s_category_id,
                'main_title'         => $main_title,
                'sub_title'          => $sub_title,
                'statuses'           => wc_get_order_statuses(),
            )
        );

        return ob_get_clean();
    }

    /**
     * Order listing on single product page
     *
     * @since 1.0.0
     */
    public function after_single_product() {
        $logged_users_only = wpr_pbowc_get_option( 'allow_for_logged_users_only', 'wpr_pbowc_admin_settings_product_page', 'yes' );

        if ( 'yes' === $logged_users_only && ! is_user_logged_in() ) {
            return;
        }

        if ( ! is_singular( 'product' ) ) {
            return;
        }

        global $post;

        $product_id = $post->ID;

        echo do_shortcode( '[product_base_order_wc products="' . $product_id . '" product_filter="no" category_filter="no"]' );
    }
}
