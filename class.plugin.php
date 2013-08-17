<?php
/*
Plugin class
*/
if ( ! class_exists( 'WPB_Docs' ) ) :
	class WPB_Docs {
	
	protected $version = '1.0.0';

	protected $plugin_slug = 'wpb_docs';

	protected static $instance = null;

	public function __construct() {

	// Add support for translations
	add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
	// Load public-facing style sheet and JavaScript.
	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
	}

	/**
	* Return an instance of this class.
	*
	* @since 1.0.0
	*
	* @return object A single instance of this class.
	*/
	public static function get_instance() {
	
	// If the single instance hasn't been set, set it now.
	if ( null == self::$instance ) {
	self::$instance = new self;
	}
	
	return self::$instance;
	}

	/**
	* Load the plugin text domain for translation.
	*
	* @since 1.0.0
	*/
	public function load_plugin_textdomain() {
	
	$domain = $this->plugin_slug;
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	
	load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}


	/**
	* Register and enqueue public-facing style sheet.
	*
	* @since 1.0.0
	*/
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/app.css', __FILE__ ), array(), $this->version );
	}
	

	/**
	* Register and enqueues public-facing JavaScript files.
	*
	* @since 1.0.0
	*/
	public function enqueue_scripts() {
		if(wp_script_is('jquery')) {
    	// do nothing
			} else {
    // insert jQuery
			wp_enqueue_script( 'jquery' );
		}
		wp_enqueue_script( $this->plugin_slug . '-plugins', plugins_url( 'assets/js/plugins.js', __FILE__ ), array( 'jquery' ), $this->version );
		wp_enqueue_script( $this->plugin_slug . '-main', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ), $this->version );
	}




}	



	
new WPB_Docs;

endif;