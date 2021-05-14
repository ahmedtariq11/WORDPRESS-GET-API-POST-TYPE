
<?php

/**
 * Plugin Name: WordPress Quiz with React
 * Description: Quiz Plugin made by tutorial on ibenic.com
 * Plugin URI: https://ibenic.com
 */

if( ! defined( 'ABSPATH' ) ) {
    return;
}

class WPQR {

    public function includes() {
        include 'inc/class-wpqr-metaboxes.php';
        include 'inc/class-wpqr-rest-api.php';
    }

    /**
     * Load everything
     * @return void 
     */
    public function load() {} 
  
    /**
     * Load all CPTs
     * @return void 
     */
    public function load_cpts() {}
}

add_action( 'plugins_loaded', 'wpqr_load' );

/**
 * Loading our plugin
 * @return void 
 */
function wpqr_load() {
    $plugin = new WPQR();
    $plugin->includes();
    $plugin->load();
}
