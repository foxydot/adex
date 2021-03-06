<?php
/*
Plugin Name: MSD Custom CPT
Description: Custom plugin for MSDLAB
Author: Catherine Sandrick
Version: 0.0.1
Author URI: http://msdlab.com
*/

if(!class_exists('WPAlchemy_MetaBox')){
    if(!include_once (WP_CONTENT_DIR.'/wpalchemy/MetaBox.php'))
	include_once (plugin_dir_path(__FILE__).'/lib/wpalchemy/MetaBox.php');
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    if(!include_once (WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php'))
	include_once (plugin_dir_path(__FILE__).'/lib/wpalchemy/MediaAccess.php');
}
$wpalchemy_media_access = new WPAlchemy_MediaAccess();
global $msd_custom;

/*
 * Pull in some stuff from other files
*/
if(!function_exists('requireDir')){
	function requireDir($dir){
		$dh = @opendir($dir);

		if (!$dh) {
			throw new Exception("Cannot open directory $dir");
		} else {
			while($file = readdir($dh)){
				$files[] = $file;
			}
			closedir($dh);
			sort($files); //ensure alpha order
			foreach($files AS $file){
				if ($file != '.' && $file != '..') {
					$requiredFile = $dir . DIRECTORY_SEPARATOR . $file;
					if ('.php' === substr($file, strlen($file) - 4)) {
						require_once $requiredFile;
					} elseif (is_dir($requiredFile)) {
						requireDir($requiredFile);
					}
				}
			}
		}
		unset($dh, $dir, $file, $requiredFile);
	}
}
if (!class_exists('MSDCustomCPT')) {
    class MSDCustomCPT {
    	//Properites
    	/**
    	 * @var string The plugin version
    	 */
    	var $version = '0.0.1';
    	
    	/**
    	 * @var string The options string name for this plugin
    	 */
    	var $optionsName = 'msd_custom_options';
    	
    	/**
    	 * @var string $nonce String used for nonce security
    	 */
    	var $nonce = 'msd_custom-update-options';
    	
    	/**
    	 * @var string $localizationDomain Domain used for localization
    	 */
    	var $localizationDomain = "msd_custom";
    	
    	/**
    	 * @var string $pluginurl The path to this plugin
    	 */
    	var $plugin_url = '';
    	/**
    	 * @var string $pluginurlpath The path to this plugin
    	 */
    	var $plugin_path = '';
    	
    	/**
    	 * @var array $options Stores the options for this plugin
    	 */
    	var $options = array();
        
        /**
         * @var bool $flushrules Weather or not to flush rewrite rules on activation.
         */
        var $flushrules = FALSE;
        
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        function MSDCustomCPT(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){
        	//"Constants" setup
        	$this->plugin_url = plugin_dir_url(__FILE__).'/';
        	$this->plugin_path = plugin_dir_path(__FILE__).'/';
        	//Initialize the options
        	$this->get_options();
        	//check requirements
        	register_activation_hook(__FILE__, array(&$this,'check_requirements'));
        	//get sub-packages
        	requireDir(plugin_dir_path(__FILE__).'/lib/inc');
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            
           
            //here are some examples to get started with
            if(class_exists('MSDLocationCPT')){
                $this->location_class = new MSDLocationCPT();
                $this->flushrules = TRUE;
            }
            if(class_exists('MSDEventCPT')){
                $this->event_class = new MSDEventCPT();
                $this->flushrules = TRUE;
            }
            if(class_exists('MSDProjectCPT')){
                $this->project_class = new MSDProjectCPT();
                $this->flushrules = TRUE;
            }
            if(class_exists('MSDClientCPT')){
                $this->client_class = new MSDClientCPT();
                $this->flushrules = TRUE;
            }
            if(class_exists('MSDTestimonialCPT')){
                $this->testimonial_class = new MSDTestimonialCPT();
                $this->flushrules = TRUE;
            }
            if($this->flushrules){
                register_activation_hook( __FILE__, create_function('','flush_rewrite_rules();') );
                register_deactivation_hook( __FILE__, create_function('','flush_rewrite_rules();') );
            }
        }

        /**
         * @desc Loads the options. Responsible for handling upgrades and default option values.
         * @return array
         */
        function check_options() {
        	$options = null;
        	if (!$options = get_option($this->optionsName)) {
        		// default options for a clean install
        		$options = array(
        				'version' => $this->version,
        				'reset' => true
        		);
        		update_option($this->optionsName, $options);
        	}
        	else {
        		// check for upgrades
        		if (isset($options['version'])) {
        			if ($options['version'] < $this->version) {
        				// post v1.0 upgrade logic goes here
        			}
        		}
        		else {
        			// pre v1.0 updates
        			if (isset($options['admin'])) {
        				unset($options['admin']);
        				$options['version'] = $this->version;
        				$options['reset'] = true;
        				update_option($this->optionsName, $options);
        			}
        		}
        	}
        	return $options;
        }
        
        /**
         * @desc Retrieves the plugin options from the database.
         */
        function get_options() {
        	$options = $this->check_options();
        	$this->options = $options;
        }
        /**
         * @desc Check to see if requirements are met
         */
        function check_requirements(){
        	
        }
        /**
         * @desc Checks to see if the given plugin is active.
         * @return boolean
         */
        function is_plugin_active($plugin) {
        	return in_array($plugin, (array) get_option('active_plugins', array()));
        }
        
        
        function custom_query( $query ) {
            if(!is_admin()){
                if($query->is_main_query() && $query->is_search){
                    $posttypes = $query->query_vars['post_type'];
                    $posttypes[] = 'page';
                    $posttypes[] = 'post';
                    $query->set( 'post_type', $posttypes );
                }
            }
        }   
        /***************************/
  } //End Class
} //End if class exists statement

//instantiate
$msd_custom = new MSDCustomCPT();