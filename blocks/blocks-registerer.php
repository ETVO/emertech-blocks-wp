<?php
/**
 * Automatic PHP block initializer based on JSON files
 * 
 * @package Emertech Blocks Plugin
 */

use EmertechBlocksRegisterer as GlobalEmertechBlocksRegisterer;

/**
 * Emertech Blocks Registerer class
 * @since 2.0
 */
class EmertechBlocksRegisterer {

    private array $blocks = [];

    /**
     * Call core functions
     *
     * @since 2.0
     */
    public function __construct() {
        // Get all the blocks in the JSON file
        $this->set_blocks_from_JSON("blocks.json");
        // Register all blocks on init
        $this->register_blocks($this->get_blocks());
    }

    /**
     * Get blocks blocks from JSON file
     *
     * @param string $file_path
     * @since 2.0
     */
    public function set_blocks_from_JSON(string $file_path) {
        $content = file_get_contents(__DIR__ . '/' . $file_path);
        $blocksData = json_decode($content, true);
        $this->set_blocks($blocksData["blocks"]);
    }

    /**
     * Register an array of blocks and its children (recursively) 
     *
     * @param array $blocks
     * @param string $path_prefix
     * @since 2.0
     */
    public function register_blocks(array $blocks, string $path_prefix = "") {
        $dir = __DIR__ . '/';

        foreach($blocks as $block) {

            if(substr($path_prefix, -1) !== '/') $path_prefix .= '/';

            $path = $block["path"];
            
            $blockData = file_get_contents($dir . $path_prefix . $path . '/block.json');
            $blockData = json_decode($blockData, true);
            
            $slug = $blockData['slug'];
            $categ = $blockData['categ'];
            $render_callback = $blockData["renderCallback"];
            $children = $blockData["children"];

            $this->register_block($slug, $categ, $path_prefix . $path, $render_callback);

            if($children !== NULL && count($children) > 0) {
                $this->register_blocks($blockData["children"], $path_prefix . $path );
            }
        }
    }

    /**
     * Register an individual block
     *
     * @param string $slug
     * @param string $categ
     * @param string $path
     * @param string $render_callback
     * @since 2.0
     */
    private function register_block(string $slug, string $categ, string $path, string $render_callback = NULL) {
        $slug = str_replace('-', '_', $slug);

        if($render_callback === NULL)
            $render_callback = 'render_block_' . $slug;

        register_block_type(
            $categ . '/' . $slug,
            array(
                'render_callback' => $render_callback
            )
        );
        
        include __DIR__ . '/' . $path . '/block.php';
    }

    /**
     * Set blocks property
     *
     * @param array $array
     * @since 2.0
     */
    public function set_blocks(array $array) {
        $this->blocks = $array;
    }

    /**
     * Get blocks property
     *
     * @return array
     * @since 2.0
     */
    public function get_blocks(): array {
        return $this->blocks;
    }
}

new EmertechBlocksRegisterer();