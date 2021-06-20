<?php
/**
 * Plugin Name: Emertech Custom Blocks
 * Description: Blocos de layout criados exclusivamente para o site da Emertech
 * Author: Estevão Rolim
 * Author URI: https://www.linkedin.com/in/estevaoprolim/
 * Version: 2.0
 * 
 * @package Emertech Blocks Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core constants 
define("EMERTECH_BLOCKS_DIR", plugin_dir_path(__DIR__) . "emertech-blocks/");
define("EMERTECH_BLOCKS_URL", plugins_url("emertech-blocks/"));
define("EMERTECH_BLOCKS_CLASS_NAME", "Emertech_Blocks_Plugin");

/** 
 * Emertech Blocks plugin class
*/
final class Emertech_Blocks_Plugin {

    /**
     * Add actions and filters, and call functions
     * 
     * @since 1.0
     */
    public function __construct() {

        $this->plugin_constants();
        
        // Initialize blocks PHP
        add_action('init', array(EMERTECH_BLOCKS_CLASS_NAME, 'plugin_setup'));

        // Enqueue scripts on init        
        add_action('wp_enqueue_scripts', array(EMERTECH_BLOCKS_CLASS_NAME, 'plugin_css'));
        add_action('wp_enqueue_scripts', array(EMERTECH_BLOCKS_CLASS_NAME, 'plugin_js'));

        add_action('admin_enqueue_scripts', array(EMERTECH_BLOCKS_CLASS_NAME, 'plugin_admin_css'));
        add_action('admin_enqueue_scripts', array(EMERTECH_BLOCKS_CLASS_NAME, 'plugin_admin_js'));

        // Filter to add custom block category
        add_filter( 'block_categories', array(EMERTECH_BLOCKS_CLASS_NAME, 'custom_blocks_category'), 10, 2);

        // $this->include_blocks();
    }

    /**
     * Define plugin core constants
     * 
     * @since 1.0
     */
    public static function plugin_constants() {

        // JS and CSS paths
        define('EMERTECH_BLOCKS_JS_URL', EMERTECH_BLOCKS_URL . 'assets/js/');
        define('EMERTECH_BLOCKS_CSS_URL', EMERTECH_BLOCKS_URL . 'assets/css/');

        // Include paths
        define('EMERTECH_BLOCKS_INC_DIR', EMERTECH_BLOCKS_DIR . 'blocks/');
        define('EMERTECH_BLOCKS_INC_URL', EMERTECH_BLOCKS_URL . 'blocks/');

        // Image paths
        define('EMERTECH_BLOCKS_IMG_URL', EMERTECH_BLOCKS_URL . 'assets/img/');
        
    }

    /**
	 * Include files
	 *
	 * @since 1.0
	 */
	public static function plugin_setup() {

		$dir = EMERTECH_BLOCKS_INC_DIR;

		include $dir . '/blocks-registerer.php';
	}

    /**
     * Enqueue CSS
     * 
     * @since 1.0
     */
    public static function plugin_css() {

        $dir = EMERTECH_BLOCKS_CSS_URL;

        // Registering the blocks.css for frontend + backend
        wp_enqueue_style(
            'emertech-blocks-front', 
            $dir . 'blocks.css',
            is_admin() ? array('wp-editor') : null,
            null
        );
    }

    /**
     * Enqueue JS
     * 
     * @since 1.0
     */
    public static function plugin_js() {

        $dir = EMERTECH_BLOCKS_JS_URL;

        // Registering the blocks.js file in the dist folder
        wp_enqueue_script(
            'emertech-blocks-front-scripts',
            $dir . 'front.js',
            array(),
            null,
            true
        );

    }

    /**
     * Enqueue CSS for admin
     * 
     * @since 1.0
     */
    public static function plugin_admin_css() {

        $dir = EMERTECH_BLOCKS_CSS_URL;

        // Registering the editor.css for backend
        wp_enqueue_style(
            'emertech-blocks-back', 
            $dir . 'editor.css',
            array('wp-edit-blocks'),
            null
        );
    }

    /**
     * Enqueue JS for admin
     * 
     * @since 1.0
     */
    public static function plugin_admin_js() {

        $dir = EMERTECH_BLOCKS_JS_URL;

        // Registering the blocks.js file in the dist folder
        wp_enqueue_script(
            'emertech-blocks-scripts',
            $dir . 'blocks.js',
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components'),
            null,
            true
        );

        // WP Localized globals. Use dynamic PHP data in JavaScript via global object (array).
        wp_localize_script(
            'emertech-blocks-scripts',
            'pluginGlobal',
            [
                'dirPath' => EMERTECH_BLOCKS_DIR,
                'dirUrl'  => EMERTECH_BLOCKS_URL,
                'homeUrl' => home_url(),
            ]
        );
    }

    /**
     * Add custom block category for WP page editor
     * 
     * @since 1.0
     */
    function custom_blocks_category($categories, $post) {
        return array_merge(
            array(
                array(
                    'slug' => 'emertechblock',
                    'title' => __("Emertech Custom Blocks", 'emertech')
                )
            ),
            $categories
        );
    }
}

new Emertech_Blocks_Plugin();