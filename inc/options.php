<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if (!class_exists('ci_multistep_checkout_option_Settings_API')):
    class ci_multistep_checkout_option_Settings_API {

        private $settings_api;

        public function __construct() {
            $this->settings_api = new WeDevs_Settings_API;

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
          

        }
     

        public function admin_init() {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            //initialize settings
            $this->settings_api->admin_init();
            /**
             * If not, return the standard settings
             **/

        }

        public function admin_menu() {
            // add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test',  );
            add_submenu_page('woocommerce', 'Multistep Checkout Settings', 'Multistep Checkout Settings', 'delete_posts', 'multistep_options', array($this, 'wpgs_plugin_page'));
        }

        public function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'multistep_settings',
                    'title' => __('Genarel Settings', 'multistep-checkout'),
                ),
                array(
                    'id'  => 'multistep_text_settings',
                    'title' => __('Text Settings','multistep-checkout')
                )

            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        public function get_settings_fields() {
            $settings_fields = array(
                'multistep_settings'   => array(
                   
                    array(
                        'name'    => 'nav_item_bg',
                        'label'   => __('Step Background', 'multistep-checkout'),
                        'desc'    => __('', 'multistep-checkout'),
                        'type'    => 'color',
                        'default' => '#ffffff',
                    ),
                    array(
                        'name'    => 'nav_item_text',
                        'label'   => __('Default Step Text Color', 'multistep-checkout'),
                        'desc'    => __('', 'multistep-checkout'),
                        'type'    => 'color',
                        'default' => '#444',
                    ),
                    array(
                        'name'    => 'current_step',
                        'label'   => __('Current Step Color', 'multistep-checkout'),
                        'desc'    => __('', 'multistep-checkout'),
                        'type'    => 'color',
                        'default' => '#444',
                    ),
                   
                    
                    array(
                        'name'    => 'multistep_style',
                        'label'   => __('Style', 'multistep-checkout'),
                        'desc'    => __('Default: Progress Bar', 'multistep-checkout'),
                        'type'    => 'select',
                        'default' => 'progress_bar',
                        'options' => array(
                            'progress_bar' => 'Progress Bar',
                            'text'  => 'Text Style',
                        ),
                    ),
 					           
                   
                    
                ),
                'multistep_text_settings' => array(
                     array(
                        'name'              => 'login',
                        'label'             => __('Login', 'multistep-checkout'),
                        'desc'              => __('Default: Login', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Login',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                     array(
                        'name'              => 'coupon',
                        'label'             => __('Coupon', 'multistep-checkout'),
                        'desc'              => __('Default: Coupon', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Coupon',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                     array(
                        'name'              => 'billing',
                        'label'             => __('Billing', 'multistep-checkout'),
                        'desc'              => __('Default: Billing', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Billing',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                     array(
                        'name'              => 'shipping',
                        'label'             => __('Shipping', 'multistep-checkout'),
                        'desc'              => __('Default: Shipping', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Shipping',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    
                     array(
                        'name'              => 'order',
                        'label'             => __('Order', 'multistep-checkout'),
                        'desc'              => __('Default: Order', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Order',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                     array(
                        'name'              => 'payment',
                        'label'             => __('Payment', 'multistep-checkout'),
                        'desc'              => __('Default: Payment', 'multistep-checkout'),

                        'type'              => 'text',
                        'default'           => 'Payment',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                )
            );

            return $settings_fields;
        }

        public function wpgs_plugin_page() {
            echo '<div class="wrap">';

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();

        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        public function get_pages() {
            $pages         = get_pages();
            $pages_options = array();
            if ($pages) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
endif;
