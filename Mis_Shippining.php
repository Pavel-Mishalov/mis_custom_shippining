<?php
 
/**
 * Plugin Name: Mis метод доставки
 * Plugin URI: http://localhost
 * Description: Кастомный метод доставки для Woocommerce
 * Version: 1.0.0
 * Author: Pavel Mishalov
 * Author URI: http://localhost
 * Domain Path: /languages
 */
 
if ( ! defined( 'WPINC' ) ) {
 
    die;
 
}
 
/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    function mis_custom_shipping_method() {
        if ( ! class_exists( 'Mis_Custom_Shippining_method' ) )
        {
            class Mis_Custom_Shippining_method extends WC_Shipping_Method
            {

                public function __construct() {
                    $this->id                 = 'mis_custom_method';
                    $this->method_title       = 'Служба доставки по области';
                    $this->method_description = 'Настройка собственной службы доставки';
 
                    $this->availability = 'including';
                    $this->countries = array(
                        'RU',
                        'UA'
                        );
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : 'Собственная доставка';
            }

                function init()
                {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 
 
                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                function init_form_fields()
                { 
 
                    $this->form_fields = array(
 
                     'enabled' => array(
                          'title' => __( 'Выводить', 'misShip' ),
                          'type' => 'checkbox',
                          'description' => __( 'Включить данный метод в список доставки', 'misShip' ),
                          'default' => 'no'
                          ),
 
                     'title' => array(
                        'title' => __( 'Название', 'misShip' ),
                          'type' => 'text',
                          'description' => __( 'Введите название данного метода доставки', 'misShip' ),
                          'placeholder' => __( 'Введите название', 'misShip' ),
                          ),
 
                     'minCost' => array(
                        'title' => __( 'Минимальный заказ для доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите сумму заказа, с которой предоставляется доставка', 'misShip' ),
                          ),
 
                     'deliveryCost' => array(
                        'title' => __( 'Стоимость доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите стоимость для данной услуги доставки', 'misShip' ),
                          ),
 
                     'maxCost' => array(
                        'title' => __( 'Минимальный заказ для бесплатной доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите сумму заказа, с которой предоставляется бесплатная доставка', 'misShip' ),
                          ),
 
                     'state' => array(
                          'title' => __( 'Область доставки', 'misShip' ),
                          'type' => 'select',
                          'options' => array(
                                          'Московская'  => 'Московская',
                                          'Ленинградская' => 'Ленинградская'
                                          ),
                          'description' => __( 'Выберите область, по которой распространяется данная служба доставки', 'misShip' ),
                          ),
 
                     );
 
                }

                public function calculate_shipping( $package )
                {
                    
                    $totalCost = 0;
                    $deliveryCost = $this->settings['deliveryCost'];

                    foreach ($package['contents'] as $item_id => $value) {
                        $_product = $value['data'];
                        $totalCost += $_product->get_price() * $value['quantity'];
                    }

                    $minTotalCost = $this->settings['minCost'];
                    $maxTotalCost = $this->settings['maxCost'];

                    if( $maxTotalCost < $totalCost ){
                      $rate = array(
                          'id' => $this->id,
                          'label' => $this->title,
                          'cost' => 0
                      );
                      $this->add_rate( $rate );
                    }elseif( $maxTotalCost > $totalCost && $minTotalCost < $totalCost ){
                      $rate = array(
                          'id' => $this->id,
                          'label' => $this->title,
                          'cost' => $deliveryCost
                      );
   
                      $this->add_rate( $rate );
                    }
                }
            }
        }

        if ( ! class_exists( 'Mis_Custom_Shippining_method2' ) )
        {
            class Mis_Custom_Shippining_method2 extends WC_Shipping_Method
            {

                public function __construct() {
                    $this->id                 = 'mis_custom_method2';
                    $this->method_title       = 'Служба доставки по области';
                    $this->method_description = 'Настройка собственной службы доставки';
 
                    $this->availability = 'including';
                    $this->countries = array(
                        'RU',
                        'UA'
                        );
 
                    $this->init();
 
                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : 'Собственная доставка';
            }

                function init()
                {
                    $this->init_form_fields(); 
                    $this->init_settings(); 

                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                function init_form_fields()
                { 
 
                    $this->form_fields = array(
 
                     'enabled' => array(
                          'title' => __( 'Выводить', 'misShip' ),
                          'type' => 'checkbox',
                          'description' => __( 'Включить данный метод в список доставки', 'misShip' ),
                          'default' => 'no'
                          ),
 
                     'title' => array(
                        'title' => __( 'Название', 'misShip' ),
                          'type' => 'text',
                          'description' => __( 'Введите название данного метода доставки', 'misShip' ),
                          'placeholder' => __( 'Введите название', 'misShip' ),
                          ),
 
                     'minCost' => array(
                        'title' => __( 'Минимальный заказ для доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите сумму заказа, с которой предоставляется доставка', 'misShip' ),
                          ),
 
                     'deliveryCost' => array(
                        'title' => __( 'Стоимость доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите стоимость для данной услуги доставки', 'misShip' ),
                          ),
 
                     'maxCost' => array(
                        'title' => __( 'Минимальный заказ для бесплатной доставки', 'misShip' ),
                          'type' => 'number',
                          'description' => __( 'Введите сумму заказа, с которой предоставляется бесплатная доставка', 'misShip' ),
                          ),
 
                     'state' => array(
                          'title' => __( 'Область доставки', 'misShip' ),
                          'type' => 'select',
                          'options' => array(
                                          'Московская'  => 'Московская',
                                          'Ленинградская' => 'Ленинградская'
                                          ),
                          'description' => __( 'Выберите область, по которой распространяется данная служба доставки', 'misShip' ),
                          ),
 
                     );
 
                }

                public function calculate_shipping( $package )
                {
                    $totalCost = 0;
                    $deliveryCost = $this->settings['deliveryCost'];

                    foreach ($package['contents'] as $item_id => $value) {
                        $_product = $value['data'];
                        $totalCost += $_product->get_price() * $value['quantity'];
                    }

                    $minTotalCost = $this->settings['minCost'];
                    $maxTotalCost = $this->settings['maxCost'];

                    if( $maxTotalCost < $totalCost ){
                      $rate = array(
                          'id' => $this->id,
                          'label' => $this->title,
                          'cost' => 0
                      );
                      $this->add_rate( $rate );
                    }elseif( $maxTotalCost > $totalCost && $minTotalCost < $totalCost ){
                      $rate = array(
                          'id' => $this->id,
                          'label' => $this->title,
                          'cost' => $deliveryCost
                      );
   
                      $this->add_rate( $rate );
                    }
                }
            }
        }
    }
 
    add_action( 'woocommerce_shipping_init', 'mis_custom_shipping_method' );
 
    function add_mis_local_shipping_method( $methods ) {
        $methods[] = 'Mis_Custom_Shippining_method';
        $methods[] = 'Mis_Custom_Shippining_method2';
        return $methods;
    }
 
    add_filter( 'woocommerce_shipping_methods', 'add_mis_local_shipping_method' );
 
    function mis_shippining_validate_order( $posted )   {
 
        $packages = WC()->shipping->get_packages();
 
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
         
        if( is_array( $chosen_methods ) && in_array( 'mis_custom_method', $chosen_methods ) ) {
             
            foreach ( $packages as $i => $package ) {
 
                if ( $chosen_methods[ $i ] != "mis_custom_method" ) {
                             
                    continue;
                             
                }
                
                $Mis_Caustom_Shippining_method = new Mis_Custom_Shippining_method();
                $totalCostLimit = (int) $Mis_Custom_Shippining_method->settings['minCost'];
                $totalCost = 0;
 
                foreach ( $package['contents'] as $item_id => $values ){
                  $_product = $values['data'];
                  $totalCost += $_product->get_price() * $values['quantity'];
                }
                
                if( $totalCostLimit > $totalCost ) {
 
                        $message = sprintf( 'Просим прошения, для предоставления услуги "'.$Mis_Custom_Shippining_method->title.'" неибходимо сделать минимальный заказ на '.$totalCostLimit.' рублей' );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }

                }elseif( $package['destination']['state'] !== $Mis_Custom_Shippining_method->settings['state'] ){
 
                        $message = sprintf( 'Просим прошения, услуга "'.$Mis_Custom_Shippining_method->title.'" предоставляется только на области ' . $Mis_Custom_Shippining_method->settings['state'] );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }

                }
            }       
        }elseif( is_array( $chosen_methods ) && in_array( 'mis_custom_method2', $chosen_methods ) ) {
             
            foreach ( $packages as $i => $package ) {
 
                if ( $chosen_methods[ $i ] != "mis_custom_method2" ) {
                             
                    continue;
                             
                }
                
                $Mis_Custom_Shippining_method = new Mis_Custom_Shippining_method2();
                $totalCostLimit = (int) $Mis_Custom_Shippining_method->settings['minCost'];
                $totalCost = 0;
 
                foreach ( $package['contents'] as $item_id => $values ){
                  $_product = $values['data'];
                  $totalCost += $_product->get_price() * $values['quantity'];
                }
                
                if( $totalCostLimit > $totalCost ) {
 
                        $message = sprintf( 'Просим прошения, для предоставления услуги "'.$Mis_Custom_Shippining_method->title.'" неибходимо сделать минимальный заказ на '.$totalCostLimit.' рублей' );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }

                }elseif( $package['destination']['state'] !== $Mis_Custom_Shippining_method->settings['state'] ){
 
                        $message = sprintf( 'Просим прошения, услуга "'.$Mis_Custom_Shippining_method->title.'" предоставляется только на области ' . $Mis_Custom_Shippining_method->settings['state'] );
                             
                        $messageType = "error";
 
                        if( ! wc_has_notice( $message, $messageType ) ) {
                         
                            wc_add_notice( $message, $messageType );
                      
                        }

                }
            }       
        } 
    }
 
    add_action( 'woocommerce_review_order_before_cart_contents', 'mis_shippining_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'mis_shippining_validate_order' , 10 );
}