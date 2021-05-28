<?php
/**
 * Import PHP initializing files for all blocks
 * 
 * @package Emertech Blocks Plugin
 * @since 1.1
 */

use EmertechBlocksRegisterer as GlobalEmertechBlocksRegisterer;

// include __DIR__ . "/hero/block.php";

class EmertechBlocksRegisterer {

    private $blocks = [];

    /**
     * Call core functions
     *
     * @since 1.1
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
     */
    public function set_blocks_from_JSON(string $file_path) {
        $content = file_get_contents(__DIR__ . '/' . $file_path);
        $blocksData = json_decode($content, true);
        $this->set_blocks($blocksData["blocks"]);
    }

    /**
     * Register an array of blocks' paths 
     *
     * @param array $blocks
     * @param string $path_prefix
     * @return void
     */
    public function register_blocks($blocks, $path_prefix = "") {
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
                
                // $blockData = file_get_contents($dir . $path_prefix . $path . $blockData["children"][0]["path"] . 'block.json');
                // $blockData = json_decode($blockData, true);

                // print_r($blockData);
                
                $this->register_blocks($blockData["children"], $path_prefix . $path );
            }
        }
    }

    /**
     * Register individual block type
     *
     * @param string $slug
     * @param string $categ
     * @param string $path
     * @param string $render_callback
     */
    private function register_block($slug, $categ, $path, $render_callback = NULL) {
        $slug = str_replace('-', '_', $slug);

        if($render_callback === NULL)
            $render_callback = 'render_block_' . $slug;

        register_block_type(
            $categ . '/' . $slug,
            array(
                'render_callback' => $render_callback,
                // 'editor_style' => 'emertech-admin-bs',
                // 'editor_script' => 'emertech-admin-bs-script'
            )
        );

        // echo __DIR__ . '/' . $path . '/block.php' . "\n"; #just for debugging
        // echo $render_callback . "\n"; #just for debugging
        
        include __DIR__ . '/' . $path . '/block.php';
    }

    /**
     * Set blocks array
     *
     * @param array $array
     * @since 1.1
     */
    public function set_blocks(array $array) {
        $this->blocks = $array;
    }

    public function get_blocks(): array {
        return $this->blocks;
    }
}

new EmertechBlocksRegisterer();