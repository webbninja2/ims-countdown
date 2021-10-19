<?php
 /*
	Plugin Name: IMS Countdown
	Plugin URI: https://wordpress.org/plugins/ims-countdown/
	Description: IMS countdown allows you to display a countdown on your post or page. It help you to stay user in your site. 
	Author: AceWebx Team
	Author URI: http://acewebx.com
	Version: 1.3.1
 */
define('IMSC_FILE', __FILE__);
define('IMSC_PLUGIN_DIR', dirname(__FILE__));
define('IMSC_PLUGIN_URL', plugins_url('', __FILE__));
require_once IMSC_PLUGIN_DIR . '/config.php';


class Imsc{


	public function __construct() 
	{

		add_action( 'init', array($this, 'ims_install' )  );
		// Add Javascript and CSS for admin screens
        add_action('admin_enqueue_scripts', array($this,'enqueue_admin'));

        // Add Javascript and CSS for front-end display
        add_action('wp_enqueue_scripts', array($this,'enqueue'));
        
        // add js in footer 
        add_action( 'wp_footer', array($this,'footerjs' ) );

        // Add custom column
        add_filter('manage_edit-ims_countdown_columns', array($this,'admin_columns') );
        // Display custom column value
        add_action('manage_ims_countdown_posts_custom_column', array($this, 'admin_columns_values' ), 10, 2);
		

		add_shortcode('displayCountdowns', array($this, 'shortcode'));
	}


	/* ENQUEUE SCRIPTS AND STYLES for admin*/
    // Here you can add Javascript file and a CSS file for use on the editor 
    public function enqueue_admin() 
    {
    	// These two lines allow you to only load the files on the relevant screen, in this case, the editor for a "imsc_countdown" custom post type
    	$screen = get_current_screen();
    	if (!($screen->base == 'post' && $screen->post_type == 'ims_countdown')) return;

    	// Actual enqueues, note the files are in the js and css folders
    	wp_enqueue_style('admin-style', IMSC_PLUGIN_URL .'/css/admin.css');
		wp_enqueue_style('bootstrap-date-style', IMSC_PLUGIN_URL .'/css/jquery.datetimepicker.css');
		wp_enqueue_style('spectrum-style', IMSC_PLUGIN_URL .'/css/spectrum.css');
		wp_enqueue_script( 'datePicker-script', IMSC_PLUGIN_URL .'/js/jquery.datetimepicker.full.min.js' );
		wp_enqueue_script( 'spectrum-script', IMSC_PLUGIN_URL .'/js/spectrum.js');
		wp_enqueue_script( 'custom-script', IMSC_PLUGIN_URL .'/js/admin-custom.js');
    }

	public static function init() {
		

        
    }

    

    // This is an example of enqueuing a JavaScript file and a CSS file for use on the front end display
    public function enqueue() {
    	wp_enqueue_style( 'custom', IMSC_PLUGIN_URL .'/css/custom.css' );
		wp_enqueue_script( 'custom', IMSC_PLUGIN_URL .'/js/custom.js', array(), null, false);

    }

    public function footerjs() {
    	wp_enqueue_style( 'frontend-style', IMSC_PLUGIN_URL .'/css/frontend.css' );
		wp_enqueue_script( 'plugin-script', IMSC_PLUGIN_URL .'/js/jquery.plugin.js', array(), null, false);
		wp_enqueue_script( 'countdown-script', IMSC_PLUGIN_URL .'/js/jquery.countdown.js', array(), null, false);

    }

    function admin_columns($gallery_columns) {
	    $new_columns['cb'] = '<input type="checkbox" />';
	    $new_columns['title'] = _x('Countdown Name', 'column name');
	    $new_columns['shortcode'] = __('Shortcode');
	    $new_columns['date'] = _x('Date', 'column name');
	 
	    return $new_columns;
	}

	
	function admin_columns_values($column_name, $id) {
	    global $wpdb;
	    switch ($column_name) {
	    case 'shortcode':
	        echo "[displayCountdowns id=".$id."]";
	        break;
    	default:
	        break;
	    }
	}   


	// Get timezone

    public function get_timezone()
    {
    	return get_option('imsc_timezone');
    }




    function ims_install() 
    { 
    	// Add default timezone
    	add_option( 'imsc_timezone', 'Asia/Kolkata', '', 'yes' );

         $labels=array(  
			'name' 			=> 'IMS Countdown',
			'singular_name' => 'IMS Countdown',
			'add_new' 		=> 'Add New',
			'all_items' 	=> 'All Countdowns',
			'add_new_item' 	=> 'Add New',
			'edit_item' 	=> 'Edit Countdown',
			'new_item' 		=> 'New Countdown',
			'view_item' 	=> 'View Countdown',
			'search_items' 	=> 'Search Countdowns',
			'not_found' 	=> 'No Countdown found',
			'not_found_in_trash' => 'No Countdown found in trash',
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false, // it's not public, it shouldn't have it's own permalink, and so on
			'show_ui' 				=> true,  // you should be able to edit it in wp-admin
			'exclude_from_search' 	=> true,  // you should exclude it from search results
			'show_in_nav_menus' 	=> false,  // you shouldn't be able to add it to menus
			'has_archive' 			=> false,  // it shouldn't have archive page
			'publicly_queryable' 	=> true,
			'rewrite' 				=> false,  // it shouldn't have rewrite rules
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_icon'  			=> 'dashicons-clock',
			'supports' 				=> array('title', 'editor'),
		);

		register_post_type('ims_countdown',$args);	
    }


    function shortcode( $atts )
    {	
    	ob_start();
    	require IMSC_PLUGIN_DIR . '/shortcode/shortcode.php';
    	echo ob_get_clean();
    }

}



/**
   * Show row meta on the plugin screen.
   *
   * @param mixed $links Plugin Row Meta
   * @param mixed $file  Plugin Base file
   * @return  array
   */

function imsCountDown_rowMeta( $links, $file ) {

  if ( strpos( $file, 'imsCountdown.php' ) !== false ) 
  {
    $new_links = array(
            'imsAjaxCartCount_setting' => '<a href="edit.php?post_type=ims_countdown&page=imsc_countdown_settings">Settings</a>',
    );
    
    $links = array_merge( $links, $new_links );
  }
  
  return $links;
}
add_filter( 'plugin_row_meta', 'imsCountDown_rowMeta', 10, 2 );


// Create an instance of our class to kick off the whole thing
$IMSC = new Imsc();

 require_once IMSC_PLUGIN_DIR . '/custom_fields.php'; // Add custom fild for ims_countdown post type 
 require_once IMSC_PLUGIN_DIR . '/admin_settings.php';  // Create setting page for ims_countdown post type