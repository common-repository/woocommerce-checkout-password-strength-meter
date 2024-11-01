<?php
/**
 * Plugin Name: WooCommerce - Checkout Password Strength Meter
 * Plugin URI: http://www.remicorson.com/woocommerce-checkout-password-strength-meter/
 * Description: Adds a password strength meter to the checkout process
 * Version: 1.0
 * Author: Remi Corson
 * Author URI: http://remicorson.com
 * Requires at least: 3.0
 * Tested up to: 3.6
 *
 * Text Domain: woo_strength_meter
 * Domain Path: /languages/
 *
 */
 
/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

if( !defined( 'WCPSM_BASE_FILE' ) )			define( 'WCPSM_BASE_FILE', __FILE__ );
if( !defined( 'WCPSM_BASE_DIR' ) ) 			define( 'WCPSM_BASE_DIR', dirname( WCPSM_BASE_FILE ) );
if( !defined( 'WCPSM_PLUGIN_URL' ) ) 		define( 'WCPSM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
if( !defined( 'WCPSM_PLUGIN_VERSION' ) ) 	define( 'WCPSM_PLUGIN_VERSION', '1.0' );

/*
|--------------------------------------------------------------------------
| APPLY ACTIONS & FILTERS IS WOOCOMMERCE IS ACTIVE
|--------------------------------------------------------------------------
*/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	/*
	|--------------------------------------------------------------------------
	| ACTIONS
	|--------------------------------------------------------------------------
	*/
	
	add_action( 'init', 'woo_strength_meter_textdomain' );
	add_action( 'posts_selection', 'woo_load_password_strength_meter' );

} // endif WooCommerce active


/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function woo_strength_meter_textdomain() {
	load_plugin_textdomain( 'woo_strength_meter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


/*
|--------------------------------------------------------------------------
| START PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/

/*
 * Loads javascript for password strength check
 *
 * Create custom javascript based on default "password-strength-meter"
 *
 */
function woo_load_password_strength_meter() {
	if( is_checkout() ) {
		wp_enqueue_script('password-strength-meter');
		add_action( 'woocommerce_after_checkout_registration_form', 'woo_add_password_strength_meter_field' );
		add_action( 'wp_enqueue_scripts', 'woo_password_strength_meter_scripts' );
	}
}

/*
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 */
function woo_password_strength_meter_scripts() {

	if( !is_admin() ) {
		
		// Scripts
		wp_enqueue_script( 'woo_password_strength_meter_scripts', WCPSM_PLUGIN_URL . 'assets/js/woo-checkout-password-strength-meter.js', array(), WCPSM_PLUGIN_VERSION );
		
		// Styles
		wp_enqueue_style( 'woo_password_strength_meter_styles', WCPSM_PLUGIN_URL . 'assets/css/style.css', array(), WCPSM_PLUGIN_VERSION );
		
		// Localization
		wp_localize_script( 'woo_password_strength_meter_scripts', 'wcpsm_vars', array( 
								'i18n_too_short' => __( 'Password Too Short', 'woo_strength_meter' ),
								'i18n_weak'      => __( 'Weak Password', 'woo_strength_meter' ),
								'i18n_good'      => __( 'Good Password', 'woo_strength_meter' ),
								'i18n_strong'    => __( 'Strong Password', 'woo_strength_meter' ),
								'i18n_mismatch'  => __( 'Mismatch', 'woo_strength_meter' )
							) );
		
	} // endif !is_admin()

}

/*
 * Register password strength meter field and custom CSS
 *
 * Adds a field to the checkout page
 *
 */
function woo_add_password_strength_meter_field() {

	echo '<div id="pass-strength-result" style="display: block;">' . __( 'Strength indicator', 'woo_strength_meter' ) . '</div>';
	
}

