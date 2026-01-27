<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class BlockPatterns
{

    private static ?BlockPatterns $instance = null;

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
        add_action('init', [$this, 'register_patterns']);
    }

    /**
     * Register Patterns
     */
    public function register_patterns(): void
    {
        $patterns_list = ATBS_DIR . '/includes/patterns/patterns.php';

        if (file_exists($patterns_list)) {
            $patterns = require $patterns_list;

            if (!empty($patterns) && is_array($patterns)) {
                foreach ($patterns as $pattern) {
                    register_block_pattern(
                        $pattern['name'],
                        [
                            'title' => $pattern['title'],
                            'categories' => $pattern['categories'],
                            'content' => $pattern['content']
                        ]
                    );
                }
            }
        }
    }
}