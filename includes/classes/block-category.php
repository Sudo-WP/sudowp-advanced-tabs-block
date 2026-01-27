<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class BlockCategory
{

    private static ?BlockCategory $instance = null;

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
        add_filter('block_categories_all', [$this, 'register_block_category'], 10, 2);
    }

    /**
     * Register Block Category
     */
    public function register_block_category(array $categories, $context): array
    {
        return array_merge(
            [
                [
                    'slug' => 'atbs-block',
                    'title' => __('Tabs Blocks', 'sudowp-advanced-tabs-block'),
                ],
            ],
            $categories
        );
    }
}