<?php
/**
 * Plugin Name:       Multistep Checkout for Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/multistep-checkout-for-woocommerce-by-codeixer
 * Description:       Easily Add Multistep Options in Checkout Page.
 * Version:           1.0
 * Author:            Codeixer
 * Author URI:        http://codexier.com
 * Text Domain:       multistep-checkout
 * Tested up to: 5.0.1
 * WC tested up to: 3.5.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Check Condition For Woocommerce Active
 */
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ){
	add_action( 'admin_notices', 'ci_multistep_checkout_woocommerce_inactive_notice'  );
	return;
}

//---------------------------------------------------------------------
// Add setting API
//---------------------------------------------------------------------

require_once plugin_dir_path(__FILE__) . '/inc/class.settings-api.php';

//---------------------------------------------------------------------
// Plugin Options
//---------------------------------------------------------------------

require_once plugin_dir_path(__FILE__) . '/inc/options.php';

new ci_multistep_checkout_option_Settings_API();

function ci_multistep_checkout_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}


function ci_multistep_checkout_woocommerce_inactive_notice() {
	if ( current_user_can( 'activate_plugins' ) ) :
		if ( !class_exists( 'WooCommerce' ) ) :
			?>
			<div id="message" class="error">
				<p>
					<?php
					printf(
						__( '<strong><span>Multistep Checkout for WooCommerce</strong> requires WooCommerce to be activated to work.', 'multistep-checkout' )
						
					);
					?>
				</p>
			</div>		
			<?php
		endif;
	endif;
}




/**
 * Register the JS & CSS for the public-facing side of the site.
 *
 */
function ci_multistep_checkout_enqueue_files() {

	if(is_checkout()){

		//wp_enqueue_style( 'ci-c','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(),  '1.0' );
		wp_enqueue_style( 'ci-ttabs', plugin_dir_url( __FILE__ ) . 'assets/css/ttabs.css', array(),  '1.0' );
		wp_enqueue_style( 'ci-multistep-checout', plugin_dir_url( __FILE__ ) . 'assets/css/multistep-checkout.css', array(),  '1.0' );
		// Inline CSS
        $step_bg = ci_multistep_checkout_option( 'nav_item_bg','multistep_settings','#f7f7f7' );
        
        $step_text_color = ci_multistep_checkout_option( 'nav_item_text','multistep_settings','#d3d3d3' );
        $current_step = ci_multistep_checkout_option( 'current_step','multistep_settings','#d325ea' );
        $custom_css = "
                .ci_multistep .multistep-nav-tabs{
                        background: {$step_bg};
                        border-bottom: none;
                }
                .sw-theme-default > ul.step-anchor > li.done > a{
                	color:{$step_text_color} !important;
                }
				.sw-theme-default > ul.step-anchor > li.done > a::after{
					background:{$step_text_color};
				}
				.sw-theme-default > ul.step-anchor > li.active > a{
					color:{$current_step} !important;
				}
				.sw-theme-default > ul.step-anchor > li.active > a::after{
					background:{$current_step};
				}

                ";
        wp_add_inline_style( 'ci-multistep-checout', $custom_css );

		
		wp_enqueue_script( 'ci-ttabs-js', plugin_dir_url( __FILE__ ) . 'assets/js/ttabs.js', array( 'jquery' ),'1.0', true );
		wp_enqueue_script( 'ci-multistep-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/scripts.js', array( 'jquery' ),'1.0' );

		// Dynamic js data
		$multistep_style = ci_multistep_checkout_option( 'multistep_style','multistep_settings','' );
      
		$translation_array = array(
			'multistep_style' =>  $multistep_style,
			'login' => is_user_logged_in() 
			
		);
		wp_localize_script( 'ci-multistep-scripts', 'ci_multistep', $translation_array );
			}
		
}
	
	
add_action( 'wp_enqueue_scripts','ci_multistep_checkout_enqueue_files' );
	


add_action('plugins_loaded','after_ci_multistep_checkout_hooks');

function after_ci_multistep_checkout_hooks() {
	
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'ci_multistep_checkout_payment', 'woocommerce_checkout_payment', 20 );
}


/**
 * ci_multistep_checkout_form is override the checkout/form-checkout.php file
 *	
 */
 add_filter( 'wc_get_template', 'ci_multistep_checkout_form', 10, 5 );

function ci_multistep_checkout_form( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'checkout/form-checkout.php' == $template_name ) {
        $located = plugin_dir_path( __FILE__ ) . '/checkout/form-checkout-multistep.php';
    }
    
    return $located;
}