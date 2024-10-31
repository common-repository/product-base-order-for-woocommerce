<?php

namespace WPRealizer\ProductBaseOrderWC\Install;

/**
 * Installer class
 *
 * @since 1.0.0
 */
class Installer {

    /**
     * Prepare for install when activated plugin
     *
     * @since 1.0.0
     */
    public function prepare_install() {
        $this->update_version();
    }

    /**
     * Update plugin version
     *
     * @since 1.0.0
     */
    public function update_version() {
        update_option( 'wpr_product_base_order_wc_version', WPR_PRODUCT_BASE_ORDER_WC_VERSION );
    }
}
