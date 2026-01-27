<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class RegisterBlocks
{

    private static ?RegisterBlocks $instance = null;

    /**
     * Get instance
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', [$this, 'register_blocks']);
    }

    /**
     * Register Blocks
     */
    public function register_blocks(): void
    {
        $blocksFolder = ATBS_DIR . '/build/blocks';

        if (is_dir($blocksFolder)) {
            $contents = scandir($blocksFolder);

            if ($contents === false) {
                return;
            }

            $blocks = array_filter($contents, function ($item) use ($blocksFolder) {
                $itemPath = $blocksFolder . DIRECTORY_SEPARATOR . $item;
                return is_dir($itemPath) && !in_array($item, ['.', '..'], true);
            });

            foreach ($blocks as $block) {
                register_block_type(ATBS_DIR . '/build/blocks/' . $block);
            }
        }
    }
}
