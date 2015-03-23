<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.1.0
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Greenhouse_Job_Board
 * @subpackage Greenhouse_Job_Board/public
 * @author     Your Name <email@example.com>
 */
class Greenhouse_Job_Board_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $greenhouse_job_board    The ID of this plugin.
	 */
	private $greenhouse_job_board;

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
	 * @param      string    $greenhouse_job_board       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $greenhouse_job_board, $version ) {

		$this->greenhouse_job_board = $greenhouse_job_board;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Greenhouse_Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Greenhouse_Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'css/greenhouse-job-board-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Greenhouse_Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Greenhouse_Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->greenhouse_job_board, plugin_dir_url( __FILE__ ) . 'js/greenhouse-job-board-public.js', array( 'jquery' ), $this->version, false );

	}
	
	public function register_shortcodes() {
		add_shortcode( 'greenhouse', array( $this, 'greenhouse_shortcode_function') );
		// add_shortcode( 'anothershortcode', array( $this, 'another_shortcode_function') );
	}

	public function greenhouse_shortcode_function( $atts, $content = null ) {
		$options = get_option( 'greenhouse_job_board_settings' );
		
	    $atts = shortcode_atts( array(
	        'url_token' => $options['greenhouse_job_board_url_token'],
	        'api_key' => $options['greenhouse_job_board_api_key'],
	        // ...etc
	    ), $atts );
	    
		// $api_key = $atts['api_key'];
		
		$options  = '<div class="greenhouse-job-board">';
		// $options .= '<p>Greenhouse shortcode detected</p>';
		// $options .= '<p>API Key = ' . $api_key . '.</p>';
		// $options .= '<p>URL Token = ' . $atts['url_token'] . '.</p>';
		$options .= '<div class="all_jobs"><div class="jobs"></div></div>';
					//api call to get jobs with callback
		$options .= '<script type="text/javascript" src="https://api.greenhouse.io/v1/boards/' . $atts['url_token'] . '/embed/jobs?content=true&callback=greenhouse_jobs"></script>';
		$options .= '<div id="grnhse_app"></div>';
					//script for loading iframe
		$options .= '<script src="https://app.greenhouse.io/embed/job_board/js?for=' . $atts['url_token'] . '"></script>';
		$options .= '</div>';
		
		return $options;

		
	}
	
	
	//http://wpsettingsapi.jeroensormani.com/settings-generator
	function greenhouse_job_board_add_admin_menu(  ) { 
		add_options_page( 'Greenhouse Job Board Settings', 'Greenhouse Job Board Settings', 'manage_options', 'greenhouse_job_board', 'greenhouse_job_board_options_page' );
	}
	
	function greenhouse_job_board_settings_init(  ) { 
		register_setting( 'greenhouse_settings', 'greenhouse_job_board_settings' );

		add_settings_section(
			'greenhouse_job_board_greenhouse_settings_section', 
			__( 'Greenhouse Account', 'greenhouse_job_board' ), 
			'greenhouse_job_board_settings_section_callback', 
			'greenhouse_settings'
		);
		
		//url_token
		add_settings_field( 
			'greenhouse_job_board_url_token', 
			__( 'URL Token', 'greenhouse_job_board' ), 
			'greenhouse_job_board_url_token_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);

		add_settings_field( 
			'greenhouse_job_board_api_key', 
			__( 'API key', 'greenhouse_job_board' ), 
			'greenhouse_job_board_api_key_render', 
			'greenhouse_settings', 
			'greenhouse_job_board_greenhouse_settings_section' 
		);
	}


}