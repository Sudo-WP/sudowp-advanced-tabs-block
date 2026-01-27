<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class PatternsCategory
{

    private static ?PatternsCategory $instance = null;

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
        add_action('init', [$this, 'register_patterns_category']);
    }

    /**
     * Register Patterns Category
     */
    public function register_patterns_category(): void
    {
        register_block_pattern_category(
            'atbs-patterns',
            [
                'label' => __('Tab Blocks', 'sudowp-advanced-tabs-block'),
            ]
        );
    }
}