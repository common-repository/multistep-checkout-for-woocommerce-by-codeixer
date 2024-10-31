<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 *
 * @author 		Codeixer
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$multistep_style = ci_multistep_checkout_option( 'multistep_style','multistep_settings','progress_bar' );
?>

<div id="ci_multistep_checkout" class="ci_multistep ci_multistep_<?php echo esc_attr( $multistep_style );?>" style="opacity:0">
  
    <ul>
      <?php 
        $login_text = ci_multistep_checkout_option( 'login','multistep_text_settings','Login' );
        $coupon_text = ci_multistep_checkout_option( 'coupon','multistep_text_settings','Coupon' );
        $billing_text = ci_multistep_checkout_option( 'billing','multistep_text_settings','Billing');
        $shipping_text = ci_multistep_checkout_option( 'shipping','multistep_text_settings','Shipping');
        $order_text = ci_multistep_checkout_option( 'order','multistep_text_settings','Order');
        $payment_text = ci_multistep_checkout_option( 'payment','multistep_text_settings','Payment');


     
    if (! is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {

       
      ?>
        <li><a href="#step-1"><?php echo esc_html( $login_text ); ?> </a></li>
     <?php 

     }
   
      ?>
       
          <!-- <br /><small>This is step description</small> -->
        <li><a href="#step-2"><?php echo esc_html( $coupon_text ); ?></a></li>
        <li><a href="#step-3"><?php echo esc_html( $billing_text ); ?></a></li>
        <li><a href="#step-4"><?php echo esc_html( $shipping_text ); ?></a></li>
        <li><a href="#step-5"><?php echo esc_html( $order_text ); ?></a></li>
        <li><a href="#step-6"><?php echo esc_html( $payment_text ); ?></a></li>
    </ul> 
    <!-- - - - - Tab Content - - - - - -->
  
     <div>
       <?php 
      if (! is_user_logged_in()|| 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ){ ?>
       
        <div id="step-1" class="">
         
            <?php
            /**
             * Checkout login form
             */
            include plugin_dir_path( __FILE__ ) . '/form-login.php';
           ?>
        </div>
     <?php } ?>
       


       
         <div id="step-2" class="">
         	<?php
          	/**
			 * Form Cupon
			 */
          	include plugin_dir_path( __FILE__ ) . '/form-coupon.php';
			?>
              
        </div>
     
      <?php
      /**
			 * Form Checkout
			 */
          	include plugin_dir_path( __FILE__ ) . '/form-checkout.php';
          	
			?>

        
       
        </div>
</div>

   

</div> <!-- #ci-multistep-checkout-wrapper -->


<?php
