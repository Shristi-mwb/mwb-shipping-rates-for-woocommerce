<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shipping_rates_for_woocommerce
 * @subpackage Shipping_rates_for_woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Shipping_rates_for_woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function srfw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_shipping_rates_for_woocommerce_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-srfw-select2-css', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/shipping-rates-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-srfw-meterial-css', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-srfw-meterial-css2', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-srfw-meterial-lite', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-srfw-meterial-icons-css', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/shipping-rates-for-woocommerce-admin-global.css', array( 'mwb-srfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/shipping-rates-for-woocommerce-admin.scss', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-admin-min-css', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function srfw_admin_enqueue_scripts( $hook ) {

		
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_shipping_rates_for_woocommerce_menu' === $screen->id ) {
			wp_enqueue_script( 'mwb-srfw-select2', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/shipping-rates-for-woocommerce-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-srfw-metarial-js', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-srfw-metarial-js2', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-srfw-metarial-lite', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

			wp_register_script( $this->plugin_name . 'admin-js', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/shipping-rates-for-woocommerce-admin.js', array( 'jquery', 'mwb-srfw-select2', 'mwb-srfw-metarial-js', 'mwb-srfw-metarial-js2', 'mwb-srfw-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'srfw_admin_param',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'reloadurl' => admin_url( 'admin.php?page=shipping_rates_for_woocommerce_menu' ),
					'srfw_gen_tab_enable' => get_option( 'srfw_radio_switch_demo' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
		
		if ( isset( $screen->id ) && 'woocommerce_page_wc-settings' === $screen->id ) {
			wp_register_script( $this->plugin_name . 'srfw_admin-js', SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.js', array( 'jquery' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'srfw_admin-js',
				'srfw_shipping_param',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'reloadurl' => admin_url( 'admin.php?page=woocommerce_page_wc-settings' ),
					'shipping_nonce' => wp_create_nonce( 'mwb-shipping-nonce' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'srfw_admin-js' );
		}
	}

	/**
	 * Adding settings menu for shipping-rates-for-woocommerce.
	 *
	 * @since    1.0.0
	 */
	public function srfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', 'shipping-rates-for-woocommerce' ), __( 'MakeWebBetter', 'shipping-rates-for-woocommerce' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/MWB_Grey-01.svg', 15 );
			$srfw_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $srfw_menus ) && ! empty( $srfw_menus ) ) {
				foreach ( $srfw_menus as $srfw_key => $srfw_value ) {
					add_submenu_page( 'mwb-plugins', $srfw_value['name'], $srfw_value['name'], 'manage_options', $srfw_value['menu_link'], array( $srfw_value['instance'], $srfw_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_srfw_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * shipping-rates-for-woocommerce srfw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function srfw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'shipping-rates-for-woocommerce', 'shipping-rates-for-woocommerce' ),
			'slug'            => 'shipping_rates_for_woocommerce_menu',
			'menu_link'       => 'shipping_rates_for_woocommerce_menu',
			'instance'        => $this,
			'function'        => 'srfw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * shipping-rates-for-woocommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * Shipping-rates-for-woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function srfw_options_menu_html() {

		include_once SHIPPING_RATES_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/shipping-rates-for-woocommerce-admin-dashboard.php';
	}
 
	/**
	 * Shipping-rates-for-woocommerce Checked Default.
	 *
	 * @since    1.0.0
	 */
	public function srfw_shipping_coupon() {
		check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );
		update_option('default_shipping_check', 'true');
		wp_die();
		
	}

	/**
	 * Shipping-rates-for-woocommerce UnChecked Default 
	 *
	 * @since    1.0.0
	 */ 
	public function srfw_default_shipping_unchecked() {
		$mwb_data = isset(  $_COOKIE['default_check'] ) ? sanitize_key(  $_COOKIE['default_check'] ) : '';
		update_option('default_shipping_check', $mwb_data );
	}

	/**
	 * Shipping-rates-for-woocommerce Checked visibility
	 *
	 * @since    1.0.0
	 */
	public function srfw_visibility_shipping_checked() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );
	update_option('visibility_check', 'true');
	wp_die();
	}

	/**
	 * Shipping-rates-for-woocommerce unChecked visibility
	 *
	 * @since    1.0.0
	 */
	public function srfw_visibility_shipping_unchecked() {
	update_option('visibility_check', $_COOKIE['visibility_check']);
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
	$me[]   =$cat;
	update_option( 'product_categories', $me);
	wp_die();
	}

	/**
	 * Shipping-rates-for-woocommerce categories visibility
	 *
	 * @since    1.0.0
	 */
	public function fun_show_advance_field() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );
	$show_or_hide = !empty( $_POST['show'] ) ? sanitize_text_field( wp_unslash ( $_POST['show'] ) ) : '';
	update_option( 'advance_shipping_field', $show_or_hide );
	wp_die();
	}

	/**
	 * Shipping-rates-for-woocommerce setting visibility
	 *
	 * @since    1.0.0
	 */
	public function fun_hide_advance_field() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );
	$hide_or_show = !empty( $_POST['hide'] ) ? sanitize_text_field( wp_unslash ( $_POST['hide'] ) ) : '';
	update_option( 'advance_shipping_field', $hide_or_show );
	wp_die();
	}


	/**
	 * Shipping-rates-for-woocommerce setting visibility
	 *
	 * @since    1.0.0
	 */
	public function fun_show_free_field() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );	
	$show_or_hide_free_shipping = !empty( $_POST['show_free_shipping'] ) ? sanitize_text_field( wp_unslash ( $_POST['show_free_shipping'] ) ) : '';
	update_option( 'free_shipping_field', $show_or_hide_free_shipping );
	wp_die();
	}


	/**
	 * Shipping-rates-for-woocommerce setting visibility
	 *
	 * @since    1.0.0
	 */
	public function fun_hide_free_field() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );	
	$hide_or_show_free_shipping = !empty( $_POST['hide_free_shipping'] ) ? sanitize_text_field( wp_unslash ( $_POST['hide_free_shipping'] ) ) : '';
	update_option( 'free_shipping_field', $hide_or_show_free_shipping);
	wp_die();}

	/**
	 * Shipping-rates-for-woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $srfw_settings_template Settings fields.
	 */
	public function srfw_admin_template_settings_page( $srfw_settings_template ) {
		$srfw_settings_template = array(
			array(
				'title' => __( 'Text Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'text',
				'description'  => __( 'This is text field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_text_demo',
				'value' => '',
				'class' => 'srfw-text-class',
				'placeholder' => __( 'Text Demo', 'shipping-rates-for-woocommerce' ),
			),
			array(
				'title' => __( 'Number Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'number',
				'description'  => __( 'This is number field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_number_demo',
				'value' => '',
				'class' => 'srfw-number-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Password Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'password',
				'description'  => __( 'This is password field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_password_demo',
				'value' => '',
				'class' => 'srfw-password-class',
				'placeholder' => '',
			),
			array(
				'title' => __( 'Textarea Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'textarea',
				'description'  => __( 'This is textarea field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_textarea_demo',
				'value' => '',
				'class' => 'srfw-textarea-class',
				'rows' => '5',
				'cols' => '10',
				'placeholder' => __( 'Textarea Demo', 'shipping-rates-for-woocommerce' ),
			),
			array(
				'title' => __( 'Select Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'select',
				'description'  => __( 'This is select field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_select_demo',
				'value' => '',
				'class' => 'srfw-select-class',
				'placeholder' => __( 'Select Demo', 'shipping-rates-for-woocommerce' ),
				'options' => array(
					'' => __( 'Select option', 'shipping-rates-for-woocommerce' ),
					'INR' => __( 'Rs.', 'shipping-rates-for-woocommerce' ),
					'USD' => __( '$', 'shipping-rates-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Multiselect Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is multiselect field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_multiselect_demo',
				'value' => '',
				'class' => 'srfw-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options' => array(
					'default' => __( 'Select currency code from options', 'shipping-rates-for-woocommerce' ),
					'INR' => __( 'Rs.', 'shipping-rates-for-woocommerce' ),
					'USD' => __( '$', 'shipping-rates-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Checkbox Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is checkbox field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_checkbox_demo',
				'value' => '',
				'class' => 'srfw-checkbox-class',
				'placeholder' => __( 'Checkbox Demo', 'shipping-rates-for-woocommerce' ),
			),

			array(
				'title' => __( 'Radio Field Demo', 'shipping-rates-for-woocommerce' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_radio_demo',
				'value' => '',
				'class' => 'srfw-radio-class',
				'placeholder' => __( 'Radio Demo', 'shipping-rates-for-woocommerce' ),
				'options' => array(
					'yes' => __( 'YES', 'shipping-rates-for-woocommerce' ),
					'no' => __( 'NO', 'shipping-rates-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Enable', 'shipping-rates-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'This is switch field demo follow same structure for further use.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_radio_switch_demo',
				'value' => '',
				'class' => 'srfw-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'shipping-rates-for-woocommerce' ),
					'no' => __( 'NO', 'shipping-rates-for-woocommerce' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'srfw_button_demo',
				'button_text' => __( 'Button Demo', 'shipping-rates-for-woocommerce' ),
				'class' => 'srfw-button-class',
			),
		);
		return $srfw_settings_template;
	}


	/**
	 * Shipping-rates-for-woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $srfw_settings_general Settings fields.
	 */
	public function srfw_admin_general_settings_page( $srfw_settings_general ) {

		$srfw_settings_general = array(
			array(
				'title' => __( 'Enable Shipping Rates For Woocommerce', 'shipping-rates-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable plugin to start the functionality.', 'shipping-rates-for-woocommerce' ),
				'id'    => 'srfw_radio_switch_shipping',
				'value' => get_option( 'srfw_radio_switch_shipping' ),
				'class' => 'srfw-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'shipping-rates-for-woocommerce' ),
					'no' => __( 'NO', 'shipping-rates-for-woocommerce' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'srfw_button_save',
				'button_text' => __( 'Save Changes', 'shipping-rates-for-woocommerce' ),
				'class' => 'srfw-button-class',
			),
		);
		return $srfw_settings_general;
	}

	/**
	* Shipping-rates-for-woocommerce save tab settings.
	*
	* @since 1.0.0
	*/
	public function srfw_admin_save_tab_settings() {
		global $srfw_mwb_srfw_obj, $error_notice;
		if ( isset( $_POST['general_nonce'] ) ) {
			$general_form_nonce = sanitize_text_field( wp_unslash( $_POST['general_nonce'] ) );
			if ( wp_verify_nonce( $general_form_nonce, 'general-form-nonce' ) ) {
				if ( isset( $_POST['srfw_button_save'] ) ) {
			$mwb_srfw_gen_flag     = false;
			$srfw_genaral_settings = apply_filters( 'srfw_general_settings_array', array() );
			$srfw_button_index     = array_search( 'submit', array_column( $srfw_genaral_settings, 'type' ) , true );
					if ( isset( $srfw_button_index )) {
				$srfw_button_index = array_search( 'button', array_column( $srfw_genaral_settings, 'type' ) , true );
					}
					if ( isset( $srfw_button_index ) && '' !== $srfw_button_index ) {
				unset( $srfw_genaral_settings[$srfw_button_index] );
						if ( is_array( $srfw_genaral_settings ) && ! empty( $srfw_genaral_settings ) ) {
							foreach ( $srfw_genaral_settings as $srfw_genaral_setting ) {
								if ( isset( $srfw_genaral_setting['id'] ) && '' !== $srfw_genaral_setting['id'] ) {
									if ( isset( $_POST[$srfw_genaral_setting['id']] ) ) {
								update_option( $srfw_genaral_setting['id'], sanitize_text_field( wp_unslash($_POST[$srfw_genaral_setting['id']] ) ) );
									} else {
								update_option( $srfw_genaral_setting['id'], '' );
									}
								} else {
							$mwb_srfw_gen_flag = true;
								}
							}
						}
						if ( $mwb_srfw_gen_flag ) {
					$mwb_srfw_error_text = esc_html__( 'Id of some field is missing', 'shipping-rates-for-woocommerce' );
					$srfw_mwb_srfw_obj->mwb_srfw_plug_admin_notice( $mwb_srfw_error_text, 'error' );
						} else {
					$mwb_srfw_error_text = esc_html__( 'Settings saved !', 'shipping-rates-for-woocommerce' );
					$error_notice        = false;
								}
					}
				}
			}
		}
	}

	/**
	* Shipping-rates-for-woocommerce custom  shipping save  settings.
	*
	* @since 1.0.0
	*/
	public function expected_date_delivery_fun() {
	check_ajax_referer( 'mwb-shipping-nonce', 'srfw_ajax_nonce' );	
	$days = !empty( $_POST['expected_days'] ) ? sanitize_text_field( wp_unslash ( $_POST['expected_days'] ) ) : '';
	update_option('expected_days', $days);
	wp_die();
	}
}