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

    public $blocks = [];

    /**
     * Call core functions
     *
     * @since 1.1
     */
    public function __construct() {
        // Get all the blocks in the JSON file
        $this->set_blocks_from_JSON("blocks.json");
        // Register all blocks on init
        $this->register_blocks();
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
     * Register all blocks based on each JSON
     */
    public function register_blocks() {
        foreach($this->get_blocks() as $block) {
            $path = $block["path"];
            $blockData = file_get_contents(__DIR__ . '/' . $path . '/block.json');
            $blockData = json_decode($blockData, true);
            $slug = $blockData['slug'];
            $categ = $blockData['categ'];
            $styles = $blockData["styles"];

            $renderJSX = $blockData['render'] == "JSX";

            // if($renderJSX) continue;
            
            $render_callback = 'render_block_' . $slug;

            register_block_type(
                $categ . '/' . $slug,
                array(
                    'render_callback' => $render_callback,
                    // 'editor_style' => 'emertech-admin-bs',
                    // 'editor_script' => 'emertech-admin-bs-script'
                )
            );

            include __DIR__ . '/' . $path . '/block.php';
        }
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