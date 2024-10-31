<?php if ( ! empty( $main_title ) || ! empty( $sub_title ) ) : ?>
    <div class="product-base-order-wc-product-title-area">
        <h2><?php echo esc_html( $main_title ); ?></h2>
        <p><?php echo esc_html( $sub_title ); ?></p>
    </div>
<?php endif; ?>

<?php if ( $filter_option ) : ?>
    <div class="product-base-order-wc-product-filter">
        <form action="" method="get">
            <?php if ( ! empty( $filter_products ) ) : ?>
                <label><?php esc_html_e( 'Filter By Product', 'product-base-order-wc' ); ?></label>
                <select name="product-id" class="form-control" onchange='if(this.value != 0) { this.form.submit(); }'>
                    <option value="all"><?php esc_html_e( 'All Products', 'product-base-order-wc' ); ?></option>
                    <?php foreach ( $filter_products as $product ) : ?>
                        <option value="<?php echo esc_attr( $product['id'] ); ?>" <?php echo selected( $product['id'], $s_product_id ); ?>><?php echo esc_html( $product['name'] ); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <?php if ( 'yes' === $get_atts_data['category_filter'] ) : ?>
                <label><?php esc_html_e( 'Filter By Category', 'product-base-order-wc' ); ?></label>
                <select name="category-id" class="form-control" onchange='if(this.value != 0) { this.form.submit(); }'>
                    <option value="all"><?php esc_html_e( 'All Categories', 'product-base-order-wc' ); ?></option>
                    <?php foreach ( $product_categories as $product_categorie ) : ?>
                        <option value="<?php echo esc_attr( $product_categorie->term_id ); ?>" <?php echo selected( $product_categorie->term_id, $s_category_id ); ?>><?php echo esc_html( $product_categorie->name ); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </form>
    </div>
<?php endif; ?>

<?php if ( $get_orders ) : ?>
    <table id="product-base-order-wc-table-orders" class="shop_table my_account_orders table table-striped product-base-order-wc-table-order-list">
        <thead>
            <tr>
                <?php
                if ( ! empty( $get_atts_data['wc_default_data_columns'] ) ) {
                    $meta_fields = explode( ',', $get_atts_data['wc_default_data_columns'] );
                    if ( is_array( $meta_fields ) ) {
                        foreach ( $meta_fields as $meta_field ) {
                            $get_meta_field = explode( '|', $meta_field );
                            if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                                $meta_field_title = wc_clean( wp_unslash( $get_meta_field[1] ) );
                                ?>
                                    <th class="order-custom-fields"><span class="nobr"><?php echo esc_html( $meta_field_title ); ?></span></th>
                                <?php
                            }
                        }
                    } else {
                        $get_meta_field = explode( '|', $get_atts_data['wc_default_data_columns'] );
                        if ( is_array( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                            $meta_field_title = wc_clean( wp_unslash( $get_meta_field[1] ) );
                            ?>
                                <th class="order-custom-fields"><span class="nobr"><?php echo esc_html( $meta_field_title ); ?></span></th>
                            <?php
                        }
                    }
                } else {
                    foreach ( $default_columns as $column_key => $column_title ) {
                        ?>
                    <th class="order-custom-fields"><span class="nobr"><?php echo esc_html( $column_title ); ?></span></th>
                        <?php
                    }
                }
                ?>

                <?php
                if ( ! empty( $get_atts_data['custom_meta_data_columns'] ) ) {
                    $meta_fields = explode( ',', $get_atts_data['custom_meta_data_columns'] );
                    if ( is_array( $meta_fields ) ) {
                        foreach ( $meta_fields as $meta_field ) {
                            $get_meta_field = explode( '|', $meta_field );
                            if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                                $meta_field_title = wc_clean( wp_unslash( $get_meta_field[1] ) );
                                ?>
                                    <th class="order-custom-fields"><span class="nobr"><?php echo esc_html( $meta_field_title ); ?></span></th>
                                <?php
                            }
                        }
                    } else {
                        $get_meta_field = explode( '|', $get_atts_data['custom_meta_data_columns'] );
                        if ( is_array( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                            $meta_field_title = wc_clean( wp_unslash( $get_meta_field[1] ) );
                            ?>
                                <th class="order-custom-fields"><span class="nobr"><?php echo esc_html( $meta_field_title ); ?></span></th>
                            <?php
                        }
                    }
                }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ( $get_orders as $order_item ) {
            $get_order = new \WC_Order( $order_item );

            if ( empty( $get_order ) ) {
                return;
            }

            $get_id                  = $get_order->get_id();
            $line_items              = $get_order->get_items( 'line_item' );
            $product_name            = $s_product_name;
            $product_cats            = [];
            $default_meta_field_data = '';
            $custom_meta_field_data  = '';
            $allow_to_show           = 1;

            if ( ! empty( $get_atts_data['custom_meta_data_columns'] ) ) {
                $meta_fields = explode( ',', $get_atts_data['custom_meta_data_columns'] );
                if ( is_array( $meta_fields ) ) {
                    foreach ( $meta_fields as $meta_field ) {
                        $get_meta_field = explode( '|', $meta_field );

                        if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                            $meta_field_key   = wc_clean( wp_unslash( $get_meta_field[0] ) );
                            $custom_meta_field_data .= '<td class="order-custom-fields-data">' . esc_html( get_post_meta( $get_order->get_id(), $meta_field_key, true ) ) . '</td>';
                        }
                    }
                } else {
                    $get_meta_field = explode( '|', $get_atts_data['custom_meta_data_columns'] );
                    if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                        $meta_field_key   = wc_clean( wp_unslash( $get_meta_field[0] ) );
                        $custom_meta_field_data .= '<td class="order-custom-fields-data">' . esc_html( get_post_meta( $get_order->get_id(), $meta_field_key, true ) ) . '</td>';
                    }
                }
            }

            if ( empty( $s_product_name ) ) {
                foreach ( $line_items as $item_id => $item ) {
                    $item_details = new \WC_Order_Item_Product( $item_id );
                    $product_name = $item_details['name'];
                    $terms        = get_the_terms( $item_details['product_id'], 'product_cat' );

                    foreach ( $terms as $get_term ) {
                        $product_cats[] = $get_term->term_id;
                    }
                    break;
                }
            } else {
                $terms = get_the_terms( $s_product_id, 'product_cat' );

                foreach ( $terms as $get_term ) {
                    $product_cats[] = $get_term->term_id;
                }
            }

            if ( ! empty( $s_category_id ) && ! in_array( (int) $s_category_id, $product_cats, true ) ) {
                $allow_to_show = 0;
            }

            if ( $allow_to_show ) {
                if ( ! empty( $get_atts_data['wc_default_data_columns'] ) ) {
                    $meta_fields = explode( ',', $get_atts_data['wc_default_data_columns'] );

                    if ( is_array( $meta_fields ) ) {
                        foreach ( $meta_fields as $meta_field ) {
                            $get_meta_field = explode( '|', $meta_field );

                            if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                                $meta_field_key           = wc_clean( wp_unslash( $get_meta_field[0] ) );
                                $default_meta_field_data .= '<td class="order-default-fields-data">' . esc_html( wpr_pbowc_get_default_values_by_order( $get_order, $meta_field_key ) ) . '</td>';
                            }
                        }
                    } else {
                        $get_meta_field = explode( '|', $get_atts_data['wc_default_data_columns'] );

                        if ( isset( $get_meta_field[0] ) && isset( $get_meta_field[1] ) ) {
                            $meta_field_key           = wc_clean( wp_unslash( $get_meta_field[0] ) );
                            $default_meta_field_data .= '<td class="order-default-fields-data">' . esc_html( wpr_pbowc_get_default_values_by_order( $get_order, $meta_field_key ) ) . '</td>';
                        }
                    }
                    ?>
                            <tr class="order-list">
                            <?php echo $default_meta_field_data; ?>
                            <?php echo $custom_meta_field_data; ?>
                            </tr>
                    <?php } else { ?>
                        <tr class="order-list">
                            <?php foreach ( $default_columns as $column_key => $column_title ) : ?>
                                <td class="order-default-fields-data default-field-<?php echo esc_attr( $column_key ); ?>">
                                    <?php echo esc_html( wpr_pbowc_get_default_values_by_order( $get_order, $column_key ) ); ?>
                                </td>
                            <?php endforeach; ?>
                            <?php echo $custom_meta_field_data; ?>
                        </tr>
                    <?php
                    }
            }
        }
        ?>
        </tbody>
    </table>
<?php else : ?>
    <p class="product-base-order-wc-info"><?php esc_html_e( 'No orders found!', 'product-base-order-wc' ); ?></p>
<?php endif; ?>
