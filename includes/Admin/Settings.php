<?php

namespace WPRealizer\ProductBaseOrderWC\Admin;

/**
 * Admin Setting Option Class
 *
 * @since 1.0.0
 */
class Settings {

    /**
     * Show navigation
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function show_navigation() {
        $html  = '<h2 class="nav-tab-wrapper">';
        $count = count( wpr_product_base_order_wc()->setting_field->settings_sections() );

        // don't show the navigation if only one section exists
        if ( 1 === $count ) {
            return;
        }

        foreach ( wpr_product_base_order_wc()->setting_field->settings_sections() as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab"><span class="dashicons %3$s"></span> %2$s</a>', $tab['id'], $tab['title'], ! empty( $tab['icon'] ) ? $tab['icon'] : '' );
        }

        $html .= '</h2>';

        echo $html;
    }

    /**
     * Get settings sections
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function get_settings_sections() {
        return wpr_product_base_order_wc()->setting_field->settings_sections();
    }

    /**
     * Get settings fields
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function get_settings_fields() {
        return wpr_product_base_order_wc()->setting_field->settings_fields();
    }

    /**
     * Get admin init
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function get_admin_init() {
        return wpr_product_base_order_wc()->setting_field->settings_admin_init();
    }

    /**
     * Show forms
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function show_forms() {
        $settings_fields = wpr_product_base_order_wc()->setting_field->settings_fields();
        ?>
        <div class="metabox-holder">
            <?php foreach ( wpr_product_base_order_wc()->setting_field->settings_sections() as $form ) { ?>
                <div id="<?php echo $form['id']; ?>" class="group" style="display: none;">
                    <form method="post" action="options.php">
                        <?php
                        do_action( 'wsa_form_top_' . $form['id'], $form );
                        settings_fields( $form['id'] );
                        do_settings_sections( $form['id'] );
                        do_action( 'wsa_form_bottom_' . $form['id'], $form );
                        if ( isset( $settings_fields[ $form['id'] ] ) ) :
                            ?>
                            <div style="padding-left: 10px">
                                <?php submit_button(); ?>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
