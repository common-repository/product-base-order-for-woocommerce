<?php

namespace WPRealizer\ProductBaseOrderWC\Admin;

/**
 * Settings Fields Class
 *
 * @since 1.0.0
 */
class SettingsFields {

    /**
     * Settings Sections
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function settings_sections() {
        $sections = [
            [
                'id'    => 'wpr_pbowc_admin_settings_general',
                'title' => __( 'General Options', 'product-base-order-wc' ),
                'icon'  => 'dashicons-admin-generic',
            ],
            [
                'id'    => 'wpr_pbowc_admin_settings_product_page',
                'title' => __( 'Product Page', 'product-base-order-wc' ),
                'icon'  => 'dashicons-archive',
            ],
            [
                'id'    => 'wpr_pbowc_admin_settings_shortcodes',
                'title' => __( 'Shortcodes', 'product-base-order-wc' ),
                'icon'  => 'dashicons-shortcode',
            ],
            [
                'id'    => 'wpr_pbowc_admin_settings_help',
                'title' => __( 'Help', 'product-base-order-wc' ),
                'icon'  => 'dashicons-editor-help',
            ],
        ];

        return apply_filters( 'product_base_order_wc_settings_sections', $sections );
    }

    /**
     * Settings fields
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function settings_fields() {
        $settings_fields = [
            'wpr_pbowc_admin_settings_general' => apply_filters(
                'product_base_order_wc_admin_settings_general', [
                    [
                        'name'    => 'allow_for_logged_users_only',
                        'label'   => __( 'Logged Users Only', 'product-base-order-wc' ),
                        'desc'    => __( 'Select <strong>Yes</strong> if you want to show the order listing table only for logged users.', 'product-base-order-wc' ),
                        'type'    => 'select',
                        'default' => 'no',
                        'options' => [
                            'yes' => __( 'Yes', 'product-base-order-wc' ),
                            'no'  => __( 'No', 'product-base-order-wc' ),
                        ],
                    ],
                    [
                        'name'  => 'main_title',
                        'label' => __( 'Default Title', 'product-base-order-wc' ),
                        'desc'  => __( 'This is default title will show on above order listing table for all uses shortcodes.', 'product-base-order-wc' ),
                        'default' => __( 'Recent Orders', 'product-base-order-wc' ),
                        'type'  => 'text',
                    ],
                    [
                        'name'  => 'sub_title',
                        'label' => __( 'Default Sub Title', 'product-base-order-wc' ),
                        'desc'  => __( 'This is default sub title will show on below of main title for all uses shortcodes.', 'product-base-order-wc' ),
                        'type'  => 'textarea',
                    ],
                    [
                        'name'    => 'allow_for_default_columns',
                        'label'   => __( 'Default Columns', 'product-base-order-wc' ),
                        'desc'    => __( 'Select which columns want to show on defaut columns on order listing table.', 'product-base-order-wc' ),
                        'type'    => 'multicheck',
                        'default' => wpr_pbowc_default_selected_columns_list(),
                        'options' => wpr_pbowc_default_columns_list(),
                    ],
                ]
            ),
            'wpr_pbowc_admin_settings_product_page' => apply_filters(
                'product_base_order_wc_admin_settings_product_page', [
                    [
                        'name'    => 'allow_for_single_product',
                        'label'   => __( 'Allow for Single Product', 'product-base-order-wc' ),
                        'desc'    => __( 'Select <strong>Yes</strong> if you want to show the order listing table on each single product page.', 'product-base-order-wc' ),
                        'type'    => 'select',
                        'default' => 'no',
                        'options' => [
                            'yes' => __( 'Yes', 'product-base-order-wc' ),
                            'no'  => __( 'No', 'product-base-order-wc' ),
                        ],
                    ],
                    [
                        'name'    => 'allow_for_logged_users_only',
                        'label'   => __( 'Logged Users Only', 'product-base-order-wc' ),
                        'desc'    => __( 'Select <strong>Yes</strong> if you want to show the order listing table only for logged users.', 'product-base-order-wc' ),
                        'type'    => 'select',
                        'default' => 'no',
                        'options' => [
                            'yes' => __( 'Yes', 'product-base-order-wc' ),
                            'no'  => __( 'No', 'product-base-order-wc' ),
                        ],
                    ],
                    [
                        'name'    => 'position_for_single_product',
                        'label'   => __( 'Select Position', 'product-base-order-wc' ),
                        'desc'    => __( 'Select <strong>position</strong> where want to show the order listing table on single product page.', 'product-base-order-wc' ),
                        'type'    => 'select',
                        'default' => 'before_related_products',
                        'options' => [
                            'before_related_products' => __( 'Before Related Products', 'product-base-order-wc' ),
                            'after_related_products'  => __( 'After Related Products', 'product-base-order-wc' ),
                        ],
                    ],
                    [
                        'name'    => 'main_title',
                        'label'   => __( 'Title', 'product-base-order-wc' ),
                        'desc'    => __( 'This title will show on above order listing table.', 'product-base-order-wc' ),
                        'default' => __( 'Recent Orders', 'product-base-order-wc' ),
                        'type'    => 'text',
                    ],
                    [
                        'name'  => 'sub_title',
                        'label' => __( 'Sub Title', 'product-base-order-wc' ),
                        'desc'  => __( 'This sub title will show on below of main title.', 'product-base-order-wc' ),
                        'type'  => 'textarea',
                    ],
                    [
                        'name'    => 'allow_for_default_columns',
                        'label'   => __( 'Default Columns', 'product-base-order-wc' ),
                        'desc'    => __( 'Select which columns want to show on defaut columns on order listing table.', 'product-base-order-wc' ),
                        'type'    => 'multicheck',
                        'default' => wpr_pbowc_default_selected_columns_list(),
                        'options' => wpr_pbowc_default_columns_list(),
                    ],
                ]
            ),
            'wpr_pbowc_admin_settings_shortcodes' => apply_filters(
                'product_base_order_wc_admin_settings_shortcodes', [
                    [
                        'name'  => 'global_shortcodes',
                        'label' => __( 'General', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_title_subtitle_shortcodes',
                        'label' => __( 'With Title and SubTitle', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc title="Recent Orders" sub_title="Here The Recent Orders List"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_all_products',
                        'label' => __( 'All Products', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc products="all"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_product_id_base',
                        'label' => __( 'Specefic Products', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc products="22,33,44,55,66,667"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_product_filter',
                        'label' => __( 'With Products Filter', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc product_filter="yes"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_not_product_filter',
                        'label' => __( 'Ignore Products Filter', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc product_filter="no"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_category_filter',
                        'label' => __( 'With Category Filter', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc category_filter="yes"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_not_category_filter',
                        'label' => __( 'Ignore Category Filter', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc category_filter="no"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_with_product_category_filter',
                        'label' => __( 'Products and Category Filter', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc product_filter="yes" category_filter="yes"]',
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_with_allow_columns',
                        'label' => __( 'Allow WC Default Columns', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc wc_default_data_columns="order_id|Order#, product_name|Product, billing_name|Name, billing_company|Company, billing_address|Address, billing_city|City, billing_email|Email, billing_phone|Phone, order_total|Total, order_discount|Discount, payment_method|Payment Method, order_shipping|Shipping, order_status|Status, order_date|Date"]',
                        'notes' => __( '<b>Notes:</b> <code>[ "field_key1|Title1, field_key2|Title2" ]</code> Here first values (field_key1, field_key2 ) is not changable, you can only change 2nd values (Title1, Title2) as you want.', 'product-base-order-wc' ),
                        'type'  => 'code',
                    ],
                    [
                        'name'  => 'global_shortcodes_with_custom_meta_data_columns',
                        'label' => __( 'Custom Meta Data Column', 'product-base-order-wc' ),
                        'desc'  => '[product_base_order_wc custom_meta_data_columns="meta_field_key1|Title1, meta_field_key2|Title2"]',
                        'notes' => __( '<b>Notes:</b> <code>[ "meta_field_key1|Title1, meta_field_key2|Title2" ]</code> Here first values (meta_field_key1, meta_field_key2 ) is should be same as database meta_key value, you can only change 2nd values (Title1, Title2) as you want.', 'product-base-order-wc' ),
                        'type'  => 'code',
                    ],
                ]
            ),
            'wpr_pbowc_admin_settings_help' => apply_filters(
                'product_base_order_wc_admin_settings_help', [
                    [
                        'name'  => 'need_help_link',
                        'label' => __( 'Need Help?', 'product-base-order-wc' ),
                        'desc'  => __( '<a target="_blank" href="https://www.wprealizer.com/contact-us/">Click here</a> to get support', 'product-base-order-wc' ),
                        'type'  => 'html',
                    ],
                ]
            ),
        ];

        return apply_filters( 'product_base_order_wc_settings_fields', $settings_fields );
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function settings_admin_init() {
        //register settings sections
        foreach ( wpr_product_base_order_wc()->setting_field->settings_sections() as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                add_option( $section['id'] );
            }

            if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
                $section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
                $callback = create_function( '', 'echo "' . str_replace( '"', '\"', $section['desc'] ) . '";' );
            } elseif ( isset( $section['callback'] ) ) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
        }

        //register settings fields
        foreach ( wpr_product_base_order_wc()->setting_field->settings_fields() as $section => $field ) {
            foreach ( $field as $option ) {
                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id'                => $option['name'],
                    'class'             => isset( $option['class'] ) ? $option['class'] : '',
                    'label_for'         => $args['label_for'] = "{$section}[{$option['name']}]",
                    'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
                    'notes'             => isset( $option['notes'] ) ? $option['notes'] : '',
                    'name'              => $option['label'],
                    'section'           => $section,
                    'size'              => isset( $option['size'] ) ? $option['size'] : null,
                    'options'           => isset( $option['options'] ) ? $option['options'] : '',
                    'std'               => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                    'type'              => $type,
                    'placeholder'       => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
                    'min'               => isset( $option['min'] ) ? $option['min'] : '',
                    'max'               => isset( $option['max'] ) ? $option['max'] : '',
                    'step'              => isset( $option['step'] ) ? $option['step'] : '',
                );

                add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], ( isset( $option['callback'] ) ? $option['callback'] : [ $this, 'callback_' . $type ] ), $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( wpr_product_base_order_wc()->setting_field->settings_sections() as $section ) {
            register_setting( $section['id'], $section['id'], wpr_product_base_order_wc()->setting_field->sanitize_options() );
        }
    }

    /**
     * Displays a text field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_text( $args ) {
        $value       = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a url field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_url( $args ) {
        callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return void
     */
    public function callback_number( $args ) {
        $value       = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'number';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $min         = empty( $args['min'] ) ? '' : ' min="' . $args['min'] . '"';
        $max         = empty( $args['max'] ) ? '' : ' max="' . $args['max'] . '"';
        $step        = empty( $args['max'] ) ? '' : ' step="' . $args['step'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_checkbox( $args ) {
        $value = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html  = '<fieldset>';
        $html  .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html  .= sprintf( '%1$s</label>', $args['desc'] );
        $html  .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_multicheck( $args ) {
        $value = wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $value = $value ? $value : array();
        $html  = '<fieldset>';
        $html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $checked = in_array( $key, $value, true ) ? $key : '0';
            $html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html    .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_radio( $args ) {
        $value = wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_select( $args ) {
        $value = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }

        $html .= sprintf( '</select>' );
        $html .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_textarea( $args ) {
        $value       = esc_textarea( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $size, $args['section'], $args['id'], $placeholder, $value );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html       .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string
     */
    public function callback_html( $args ) {
        echo wpr_product_base_order_wc()->setting_field->get_field_description( $args );
    }

    /**
     * Displays a textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string
     */
    public function callback_code( $args ) {
        echo wpr_product_base_order_wc()->setting_field->get_field_code_description( $args );
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_wysiwyg( $args ) {
        $value = wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '500px';

        echo '<div style="max-width: ' . $size . ';">';

        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10,
        );

        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        echo '</div>';

        echo wpr_product_base_order_wc()->setting_field->get_field_description( $args );
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_file( $args ) {
        $value = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id    = $args['section'] . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File', 'product-base-order-wc' );

        $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a password field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_password( $args ) {
        $value = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $html
     */
    public function callback_color( $args ) {
        $value = esc_attr( wpr_product_base_order_wc()->setting_field->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_description( $args );
        $html  .= wpr_product_base_order_wc()->setting_field->get_field_notes( $args );

        echo $html;
    }



    /**
     * Sanitize callback for Settings API
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function sanitize_options( $options = '' ) {
        if ( ! $options ) {
            return $options;
        }

        foreach ( $options as $option_slug => $option_value ) {
            $sanitize_callback = wpr_product_base_order_wc()->setting_field->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @since 1.0.0
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    public function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach ( wpr_product_base_order_wc()->setting_field->settings_fields() as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }


    /**
     * Get the value of a settings field
     *
     * @since 1.0.0
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    public function get_option( $option, $section, $default = '' ) {
        $options = get_option( $section );

        if ( isset( $options[ $option ] ) ) {
            return $options[ $option ];
        }

        return $default;
    }

    /**
     * Get field description for display
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $desc
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }

        return $desc;
    }

    /**
     * Get field description for display
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $desc
     */
    public function get_field_notes( $args ) {
        if ( ! empty( $args['notes'] ) ) {
            $desc = sprintf( '<i class="description">%s</i>', $args['notes'] );
        } else {
            $desc = '';
        }

        return $desc;
    }

    /**
     * Get field description for display
     *
     * @since 1.0.0
     *
     * @param array $args settings field args
     *
     * @return string $desc
     */
    public function get_field_code_description( $args ) {
        $desc = '';

        if ( ! empty( $args['desc'] ) ) {
            $desc .= sprintf( '<code class="code-description">%s</code>', $args['desc'] );
        }

        if ( ! empty( $args['notes'] ) ) {
            $desc .= sprintf( '<p class="notes-description"><i>%s</i></p>', $args['notes'] );
        }

        return $desc;
    }
}
