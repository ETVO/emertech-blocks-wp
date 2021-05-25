<?php
/**
 * Plugin Name: Emertech Custom Blocks
 * Description: Blocos de layout criados exclusivamente para o site da Emertech
 * Author: Estevão Rolim
 * Author URI: https://www.linkedin.com/in/estevaoprolim/
 * Version: 1.0
 * 
 * @package Emertech Blocks Plugin
 * @since 1.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core constants 
define("EMERTECH_PLUGIN_DIR", plugin_dir_path(__DIR__));
define("EMERTECH_PLUGIN_URL", plugins_url("emertech-blocks/"));
define("EMERTECH_PLUGIN_CLASS_NAME", "Emertech_Blocks_Plugin");

/** 
 * Emertech Blocks plugin class
*/
final class Emertech_Blocks_Plugin {

    /**
     * Add actions and filters, and call functions
     * @since 1.0
     */
    public function __construct() {

        $this->plugin_constants();
        
        // Initialize blocks PHP
        add_action('init', array(EMERTECH_PLUGIN_CLASS_NAME, 'plugin_setup'));

        // Enqueue scripts on init        
        add_action('wp_enqueue_scripts', array(EMERTECH_PLUGIN_CLASS_NAME, 'plugin_css'));
        add_action('wp_enqueue_scripts', array(EMERTECH_PLUGIN_CLASS_NAME, 'plugin_js'));

        add_action('admin_enqueue_scripts', array(EMERTECH_PLUGIN_CLASS_NAME, 'plugin_admin_css'));
        add_action('admin_enqueue_scripts', array(EMERTECH_PLUGIN_CLASS_NAME, 'plugin_admin_js'));

        // Filter to add custom block category
        add_filter( 'block_categories', array(EMERTECH_PLUGIN_CLASS_NAME, 'custom_blocks_category'), 10, 2);

        // $this->include_blocks();
    }

    /**
     * Define plugin core constants
     * 
     * @since 1.0
     */
    public function plugin_constants() {

        // JS and CSS paths
        define('EMERTECH_PLUGIN_JS_URL', EMERTECH_PLUGIN_URL . 'assets/js/');
        define('EMERTECH_PLUGIN_CSS_URL', EMERTECH_PLUGIN_URL . 'assets/css/');

        // Include paths
        define('EMERTECH_PLUGIN_INC_URL', EMERTECH_PLUGIN_URL . 'inc/');

        // Image paths
        define('EMERTECH_PLUGIN_IMG_URL', EMERTECH_PLUGIN_URL . 'assets/img/');
        
    }

    /**
	 * Include files
	 *
	 * @since 1.0.0oceanwp_has_setup
	 */
	public static function plugin_setup() {

		$dir = __DIR__;

		include $dir . '/blocks/blocks_registerer_class.php';
	}

    /**
     * Enqueue CSS
     * 
     * @since 1.0
     */
    public function plugin_css() {

        $dir = EMERTECH_PLUGIN_CSS_URL;

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
    public function plugin_js() {

        $dir = EMERTECH_PLUGIN_JS_URL;

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
    public function plugin_admin_css() {

        $dir = EMERTECH_PLUGIN_CSS_URL;

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
    public function plugin_admin_js() {

        $dir = EMERTECH_PLUGIN_JS_URL;

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
                'dirPath' => EMERTECH_PLUGIN_DIR,
                'dirUrl'  => EMERTECH_PLUGIN_URL,
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

    /**
     * Include Emertech Blocks Registerer class
     *
     * @since 1.0
     */
    public function include_blocks() {
        include __DIR__ . '/blocks/blocks_registerer_class.php';
    }
}

new Emertech_Blocks_Plugin();