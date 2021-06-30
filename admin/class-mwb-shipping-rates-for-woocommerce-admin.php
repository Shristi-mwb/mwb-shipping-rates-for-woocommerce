<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_Shipping_Rates_For_Woocommerce
 * @subpackage Mwb_Shipping_Rates_For_Woocommerce/admin
 */
class Mwb_Shipping_Rates_For_Woocommerce_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since 1.0.0
     * @var   string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since 1.0.0
     * @var   string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     * @param string $hook The plugin page slug.
     */
    public function msrfw_admin_enqueue_styles( $hook )
    {
        $screen = get_current_screen();
        if (isset($screen->id) && 'makewebbetter_page_mwb_shipping_rates_for_woocommerce_menu' === $screen->id ) {

            wp_enqueue_style('mwb-msrfw-select2-css', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-shipping-rates-for-woocommerce-select2.css', array(), time(), 'all');

            wp_enqueue_style('mwb-msrfw-meterial-css', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all');
            wp_enqueue_style('mwb-msrfw-meterial-css2', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all');
            wp_enqueue_style('mwb-msrfw-meterial-lite', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all');

            wp_enqueue_style('mwb-msrfw-meterial-icons-css', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all');

            wp_enqueue_style($this->plugin_name . '-admin-global', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-shipping-rates-for-woocommerce-admin-global.css', array( 'mwb-msrfw-meterial-icons-css' ), time(), 'all');

            wp_enqueue_style($this->plugin_name, MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-shipping-rates-for-woocommerce-admin.scss', array(), $this->version, 'all');
            wp_enqueue_style('mwb-admin-min-css', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all');
            wp_enqueue_style('mwb-datatable-css', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables/media/css/jquery.dataTables.min.css', array(), $this->version, 'all');
        }

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     * @param string $hook The plugin page slug.
     */
    public function msrfw_admin_enqueue_scripts( $hook )
    {

        $screen = get_current_screen();
        if (isset($screen->id) && 'makewebbetter_page_mwb_shipping_rates_for_woocommerce_menu' === $screen->id ) {
            wp_enqueue_script('mwb-msrfw-select2', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-shipping-rates-for-woocommerce-select2.js', array( 'jquery' ), time(), false);
            
            wp_enqueue_script('mwb-msrfw-metarial-js', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false);
            wp_enqueue_script('mwb-msrfw-metarial-js2', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false);
            wp_enqueue_script('mwb-msrfw-metarial-lite', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false);
            wp_enqueue_script('mwb-msrfw-datatable', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables.net/js/jquery.dataTables.min.js', array(), time(), false);
            wp_enqueue_script('mwb-msrfw-datatable-btn', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables.net/buttons/dataTables.buttons.min.js', array(), time(), false);
            wp_enqueue_script('mwb-msrfw-datatable-btn-2', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/datatables.net/buttons/buttons.html5.min.js', array(), time(), false);
            wp_register_script($this->plugin_name . 'admin-js', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-shipping-rates-for-woocommerce-admin.js', array( 'jquery', 'mwb-msrfw-select2', 'mwb-msrfw-metarial-js', 'mwb-msrfw-metarial-js2', 'mwb-msrfw-metarial-lite' ), $this->version, false);
            wp_localize_script(
                $this->plugin_name . 'admin-js',
                'msrfw_admin_param',
                array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'reloadurl' => admin_url('admin.php?page=mwb_shipping_rates_for_woocommerce_menu'),
                'msrfw_gen_tab_enable' => get_option('msrfw_radio_switch_demo'),
                'msrfw_admin_param_location' => (admin_url('admin.php') . '?page=mwb_shipping_rates_for_woocommerce_menu&msrfw_tab=mwb-shipping-rates-for-woocommerce-general'),
                )
            );
            wp_enqueue_script($this->plugin_name . 'admin-js');
            wp_enqueue_script('mwb-admin-min-js', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.min.js', array(), time(), false);
        }

         // Admin JS For MWB Shipping Rates.
         wp_register_script( $this->plugin_name . 'srfw_admin-js', MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.js', array( 'jquery' ), $this->version, false );

         wp_localize_script(
             $this->plugin_name . 'srfw_admin-js',
             'srfw_shipping_param',
             array(
                 'ajaxurl' => admin_url( 'admin-ajax.php' ),
                 'shipping_nonce' => wp_create_nonce( 'mwb-shipping-nonce' ),
             )
         );

         wp_enqueue_script( $this->plugin_name . 'srfw_admin-js' );
    }

    /**
     * Adding settings menu for MWB Shipping Rates For WooCommerce.
     *
     * @since 1.0.0
     */
    public function msrfw_options_page()
    {
        global $submenu;
        if (empty($GLOBALS['admin_page_hooks']['mwb-plugins']) ) {
            add_menu_page(__('MakeWebBetter', 'mwb-shipping-rates-for-woocommerce'), __('MakeWebBetter', 'mwb-shipping-rates-for-woocommerce'), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/MWB_Grey-01.svg', 15);
            $msrfw_menus = 
            //desc - filter for trial.
            apply_filters('mwb_add_plugins_menus_array', array());
            if (is_array($msrfw_menus) && ! empty($msrfw_menus) ) {
                foreach ( $msrfw_menus as $msrfw_key => $msrfw_value ) {
                    add_submenu_page('mwb-plugins', $msrfw_value['name'], $msrfw_value['name'], 'manage_options', $msrfw_value['menu_link'], array( $msrfw_value['instance'], $msrfw_value['function'] ));
                }
            }
        }
    }

    /**
     * Removing default submenu of parent menu in backend dashboard
     *
     * @since 1.0.0
     */
    public function mwb_msrfw_remove_default_submenu()
    {
        global $submenu;
        if (is_array($submenu) && array_key_exists('mwb-plugins', $submenu) ) {
            if (isset($submenu['mwb-plugins'][0]) ) {
                unset($submenu['mwb-plugins'][0]);
            }
        }
    }


    /**
     * MWB Shipping Rates For WooCommerce msrfw_admin_submenu_page.
     *
     * @since 1.0.0
     * @param array $menus Marketplace menus.
     */
    public function msrfw_admin_submenu_page( $menus = array() )
    {
        $menus[] = array(
        'name'            => __('MWB Shipping Rates For WooCommerce', 'mwb-shipping-rates-for-woocommerce'),
        'slug'            => 'mwb_shipping_rates_for_woocommerce_menu',
        'menu_link'       => 'mwb_shipping_rates_for_woocommerce_menu',
        'instance'        => $this,
        'function'        => 'msrfw_options_menu_html',
        );
        return $menus;
    }

    /**
     * MWB Shipping Rates For WooCommerce mwb_plugins_listing_page.
     *
     * @since 1.0.0
     */
    public function mwb_plugins_listing_page()
    {
        $active_marketplaces = 
        //desc - filter for trial.
        apply_filters('mwb_add_plugins_menus_array', array());
        if (is_array($active_marketplaces) && ! empty($active_marketplaces) ) {
            include MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
        }
    }

    /**
     * MWB Shipping Rates For WooCommerce admin menu page.
     *
     * @since 1.0.0
     */
    public function msrfw_options_menu_html()
    {

        include_once MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-shipping-rates-for-woocommerce-admin-dashboard.php';
    }

	/**
	 * Shipping-rates-for-woocommerce categories visibility
	 *
	 * @since    1.0.0
	 */
	public function product_shipping_categories() {
        check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );	
            $me =array();
        $cat    = !empty( $_POST['cat'] ) ? sanitize_text_field( wp_unslash ( $_POST['cat'] ) ) : '';
        $me[]   = $cat;
        update_option( 'product_categories', $me);
        wp_die();
        }

    // /**
    //  * mwb_developer_admin_hooks_listing
    //  *
    //  * @return void
    //  */
    // public function mwb_developer_admin_hooks_listing()
    // {
    //     $admin_hooks = array();
    //     $val = self::mwb_developer_hooks_function(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/');
    //     if(!empty($val['hooks'])) {
    //         $admin_hooks[] = $val['hooks'];
    //         unset($val['hooks']);
    //     }
    //     $data = array();
    //     foreach( $val['files'] as $v ){
    //         if($v !== 'css' && $v !== 'js' && $v !== 'images') {
    //             $helo = self::mwb_developer_hooks_function(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/' . $v . '/');
    //             if(!empty($helo['hooks'])) {
    //                 $admin_hooks[] = $helo['hooks'];
    //                 unset($helo['hooks']);
    //             }
    //             if(! empty($helo)) {
    //                 $data[] = $helo;
    //             }
    //         }
    //     }
    //     return $admin_hooks;
    // }

    // /**
    //  * mwb_developer_public_hooks_listing
    //  */
    // public function mwb_developer_public_hooks_listing()
    // {

    //     $public_hooks = array();
    //     $val = self::mwb_developer_hooks_function(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'public/');
        
    //     if(!empty($val['hooks'])) {
    //         $public_hooks[] = $val['hooks'];
    //         unset($val['hooks']);
    //     }
    //     $data = array();
    //     foreach( $val['files'] as $v ){
    //         if($v !== 'css' && $v !== 'js' && $v !== 'images') {
    //             $helo = self::mwb_developer_hooks_function(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'public/' . $v . '/');
    //             if(! empty($helo['hooks']) ) {
    //                 $public_hooks[] = $helo['hooks'];
    //                 unset($helo['hooks']);
    //             }
    //             if(! empty($helo)) {
    //                 $data[] = $helo;
    //             }
    //         }
    //     }
    //     return $public_hooks;
    // }
    /**
     * mwb_developer_hooks_function
     */
    // public function mwb_developer_hooks_function( $path )
    // {
    //     $all_hooks = array();
    //     $scan = scandir($path);
    //     $response = array();
    //     foreach($scan as $file) {
    //         if (strpos($file, '.php') ) {
    //             $myfile = file($path . $file);
    //             foreach( $myfile as $key => $lines ){
    //                 if(preg_match("/do_action/i", $lines) && ! strpos($lines, 'str_replace') && ! strpos($lines, 'preg_match') ) {
    //                     $all_hooks[$key]['action_hook'] = $lines;
    //                     $all_hooks[$key]['desc'] = $myfile[$key-1];
    //                 }
    //                 if(preg_match("/apply_filters/i", $lines) && ! strpos($lines, 'str_replace') && ! strpos($lines, 'preg_match') ) {
    //                     $all_hooks[$key]['filter_hook'] = $lines;
    //                     $all_hooks[$key]['desc'] = $myfile[$key-1];
    //                 }
    //             }
    //         } else if(strpos($file, '.') == '' && strpos($file, '.') !== 0 ) {
    //             $response['files'][] = $file;
    //         }
    //     }
    //     if(! empty($all_hooks)) {
    //         $response['hooks'] = $all_hooks;
    //     }
    //     return $response;
    // }

    /**
     * MWB Shipping Rates For WooCommerce admin menu page.
     *
     * @since 1.0.0
     * @param array $msrfw_settings_general Settings fields.
     */
    public function msrfw_admin_general_settings_page( $msrfw_settings_general )
    {
        $msrfw_settings_general = array(
        array(
        'title' => __('Enable plugin', 'mwb-shipping-rates-for-woocommerce'),
        'type'  => 'radio-switch',
        'description'  => __('Enable plugin to start the functionality of the MWB Shipping Rates.', 'mwb-shipping-rates-for-woocommerce'),
        'id'    => 'msrfw_radio_switch_demo',
        'value' => get_option('msrfw_radio_switch_demo'),
        'class' => 'msrfw-radio-switch-class',
        'options' => array(
        'yes' => __('YES', 'mwb-shipping-rates-for-woocommerce'),
        'no' => __('NO', 'mwb-shipping-rates-for-woocommerce'),
        ),
        ),
        array(
        'type'  => 'button',
        'id'    => 'msrfw_button_demo',
        'button_text' => __('Save Change', 'mwb-shipping-rates-for-woocommerce'),
        'class' => 'msrfw-button-class',
        ),
        );
        return $msrfw_settings_general;
    }

    /**
     * MWB Shipping Rates For WooCommerce admin menu page.
     *
     * @since 1.0.0
     * @param array $msrfw_settings_template Settings fields.
     */
    // public function msrfw_admin_template_settings_page( $msrfw_settings_template )
    // {
    //     $msrfw_settings_template = array(
    //     array(
    //     'title' => __('Text Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'text',
    //     'description'  => __('This is text field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_text_demo',
    //     'value' => '',
    //     'class' => 'msrfw-text-class',
    //     'placeholder' => __('Text Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     array(
    //     'title' => __('Number Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'number',
    //     'description'  => __('This is number field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_number_demo',
    //     'value' => '',
    //     'class' => 'msrfw-number-class',
    //     'placeholder' => '',
    //     ),
    //     array(
    //     'title' => __('Password Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'password',
    //     'description'  => __('This is password field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_password_demo',
    //     'value' => '',
    //     'class' => 'msrfw-password-class',
    //     'placeholder' => '',
    //     ),
    //     array(
    //     'title' => __('Textarea Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'textarea',
    //     'description'  => __('This is textarea field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_textarea_demo',
    //     'value' => '',
    //     'class' => 'msrfw-textarea-class',
    //     'rows' => '5',
    //     'cols' => '10',
    //     'placeholder' => __('Textarea Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     array(
    //     'title' => __('Select Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'select',
    //     'description'  => __('This is select field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_select_demo',
    //     'value' => '',
    //     'class' => 'msrfw-select-class',
    //     'placeholder' => __('Select Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'options' => array(
    //                 '' => __('Select option', 'mwb-shipping-rates-for-woocommerce'),
    //                 'INR' => __('Rs.', 'mwb-shipping-rates-for-woocommerce'),
    //                 'USD' => __('$', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     ),
    //     array(
    //     'title' => __('Multiselect Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'multiselect',
    //     'description'  => __('This is multiselect field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_multiselect_demo',
    //     'value' => '',
    //     'class' => 'msrfw-multiselect-class mwb-defaut-multiselect',
    //     'placeholder' => '',
    //     'options' => array(
    //                 'default' => __('Select currency code from options', 'mwb-shipping-rates-for-woocommerce'),
    //                 'INR' => __('Rs.', 'mwb-shipping-rates-for-woocommerce'),
    //                 'USD' => __('$', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     ),
    //     array(
    //     'title' => __('Checkbox Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'checkbox',
    //     'description'  => __('This is checkbox field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_checkbox_demo',
    //     'value' => '',
    //     'class' => 'msrfw-checkbox-class',
    //     'placeholder' => __('Checkbox Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     ),

    //     array(
    //     'title' => __('Radio Field Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'radio',
    //     'description'  => __('This is radio field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_radio_demo',
    //     'value' => '',
    //     'class' => 'msrfw-radio-class',
    //     'placeholder' => __('Radio Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'options' => array(
    //                 'yes' => __('YES', 'mwb-shipping-rates-for-woocommerce'),
    //                 'no' => __('NO', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     ),
    //     array(
    //     'title' => __('Enable', 'mwb-shipping-rates-for-woocommerce'),
    //     'type'  => 'radio-switch',
    //     'description'  => __('This is switch field demo follow same structure for further use.', 'mwb-shipping-rates-for-woocommerce'),
    //     'id'    => 'msrfw_radio_switch_demo',
    //     'value' => '',
    //     'class' => 'msrfw-radio-switch-class',
    //     'options' => array(
    //                 'yes' => __('YES', 'mwb-shipping-rates-for-woocommerce'),
    //                 'no' => __('NO', 'mwb-shipping-rates-for-woocommerce'),
    //     ),
    //     ),

    //     array(
    //     'type'  => 'button',
    //     'id'    => 'msrfw_button_demo',
    //     'button_text' => __('Button Demo', 'mwb-shipping-rates-for-woocommerce'),
    //     'class' => 'msrfw-button-class',
    //     ),
    //     );
    //     return $msrfw_settings_template;
    // }

    /**
     * MWB Shipping Rates For WooCommerce save tab settings.
     *
     * @since 1.0.0
     */
    public function msrfw_admin_save_tab_settings()
    {
        global $msrfw_mwb_msrfw_obj;
        if (isset($_POST['msrfw_button_demo']) 
            && ( !empty($_POST['mwb_tabs_nonce']) 
            && wp_verify_nonce(sanitize_text_field($_POST['mwb_tabs_nonce']), 'admin_save_data') ) 
        ) {
            $mwb_msrfw_gen_flag     = false;
            $msrfw_genaral_settings = 
            //desc - filter for trial.
            apply_filters('msrfw_general_settings_array', array());
            $msrfw_button_index     = array_search('submit', array_column($msrfw_genaral_settings, 'type'));
            if (isset($msrfw_button_index) && ( null == $msrfw_button_index || '' == $msrfw_button_index ) ) {
                $msrfw_button_index = array_search('button', array_column($msrfw_genaral_settings, 'type'));
            }
            if (isset($msrfw_button_index) && '' !== $msrfw_button_index ) {
                unset($msrfw_genaral_settings[$msrfw_button_index]);
                if (is_array($msrfw_genaral_settings) && ! empty($msrfw_genaral_settings) ) {
                    foreach ( $msrfw_genaral_settings as $msrfw_genaral_setting ) {
                        if (isset($msrfw_genaral_setting['id']) && '' !== $msrfw_genaral_setting['id'] ) {
                            if (isset($_POST[$msrfw_genaral_setting['id']]) ) {
                                update_option($msrfw_genaral_setting['id'], is_array($_POST[$msrfw_genaral_setting['id']]) ? $this->mwb_sanitize_array($_POST[$msrfw_genaral_setting['id']]) : sanitize_text_field($_POST[$msrfw_genaral_setting['id']]));
                            } else {
                                update_option($msrfw_genaral_setting['id'], '');
                            }
                        } else {
                            $mwb_msrfw_gen_flag = true;
                        }
                    }
                }
                if ($mwb_msrfw_gen_flag ) {
                    $mwb_msrfw_error_text = esc_html__('Id of some field is missing', 'mwb-shipping-rates-for-woocommerce');
                    $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_admin_notice($mwb_msrfw_error_text, 'error');
                } else {
                    $mwb_msrfw_error_text = esc_html__('Settings saved !', 'mwb-shipping-rates-for-woocommerce');
                    $msrfw_mwb_msrfw_obj->mwb_msrfw_plug_admin_notice($mwb_msrfw_error_text, 'success');
                }
            }
        }
    }

    /**
     * sanitation for an array
     * 
     * @param $array
     *
     * @return array
     */
    public function mwb_sanitize_array( $mwb_input_array )
    {
        foreach ( $mwb_input_array as $key => $value ) {
            $key   = sanitize_text_field($key);
            $value = sanitize_text_field($value);
        }
        return $mwb_input_array;
    }

    /**
     * checking makewebbetter license on daily basis
     *
     * @since 1.0.0
     */

    // public function mwb_msrfw_check_license()
    // {

    //     $user_license_key = get_option('mwb_msrfw_license_key', '');

    //     $api_params = array(
    //     'slm_action'        => 'slm_check',
    //     'secret_key'        => MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_SPECIAL_SECRET_KEY,
    //     'license_key'       => $user_license_key,
    //     '_registered_domain' => $_SERVER['SERVER_NAME'],
    //     'item_reference'    => urlencode(MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_ITEM_REFERENCE),
    //     'product_reference' => 'MWBPK-2965',
    //     );

    //     $query = esc_url_raw(add_query_arg($api_params, MWB_SHIPPING_RATES_FOR_WOOCOMMERCE_LICENSE_SERVER_URL));

    //     // $ch = curl_init();
    //     // curl_setopt($ch, CURLOPT_URL, $query);
    //     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     // curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    //     // curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);

    //     // $mwb_response = curl_exec($ch);

    //     // curl_close($ch);

    //     // $license_data = json_decode($mwb_response);

    //     $mwb_response = wp_remote_get(
	// 		$query,
	// 		array(
	// 			'timeout' => 20,
	// 			'sslverify' => false,
	// 		)
	// 	);
	// 	$license_data = json_decode( wp_remote_retrieve_body( $mwb_response ) );

    //     if (isset($license_data->result) && 'success' === $license_data->result && isset($license_data->status) && 'active' === $license_data->status ) {

    //         update_option('mwb_msrfw_license_check', true);

    //     } else {

    //         delete_option('mwb_msrfw_license_check');
    //     }
    // }
}
