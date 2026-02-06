<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class EnqueueAssets
{

    private static ?EnqueueAssets $instance = null;

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
        // generate dynamic style
        add_filter('render_block', [$this, 'generate_dynamic_style'], 10, 2);
        // enqueue editor assets
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_assets']);
        // block frontend assets
        add_action('enqueue_block_assets', [$this, 'enqueue_block_assets']);
    }

    /**
     * Enqueue Block Assets
     */
    public function enqueue_block_assets(): void
    {
        // bootstrap icons 
        wp_enqueue_style(
            'atbs-blocks-bootstrap-icons',
            ATBS_URL . 'assets/css/bootstrap-icons.min.css',
            [],
            ATBS_VERSION
        );
    }

    /**
     * Enqueue Editor Assets
     */
    public function enqueue_editor_assets(): void
    {
        $atbs_dependency_file = include_once ATBS_DIR_PATH . 'build/global/global.asset.php';

        if (is_array($atbs_dependency_file)) {
            wp_enqueue_script(
                'atbs-blocks-global-js',
                ATBS_URL . 'build/global/global.js',
                $atbs_dependency_file['dependencies'],
                $atbs_dependency_file['version'],
                true
            );
        }

        wp_enqueue_style(
            'atbs-blocks-controls-css',
            ATBS_URL . 'build/global/global.css',
            [],
            ATBS_VERSION
        );
    }

    /**
     * Register Dynamic Style
     */
    public function generate_dynamic_style(string $block_content, array $block): string
    {
        if (isset($block['blockName']) && str_contains($block['blockName'], 'atbs/')) {
            do_action('atbs_render_block', $block);
            if (isset($block['attrs']['blockStyle'])) {
                $style = $block['attrs']['blockStyle'];
                $handle = isset($block['attrs']['uniqueId']) ? $block['attrs']['uniqueId'] : 'atbs';

                // Sanitize handle
                $handle = sanitize_key($handle);

                // convert style array to string
                if (is_array($style)) {
                    $style = implode(' ', $style);
                }

                // Sanitize style: strip tags to prevent XSS
                $style = wp_strip_all_tags((string) $style);

                // Security: Remove potentially dangerous CSS properties and values
                $style = $this->sanitize_css($style);

                // minify style to remove extra space
                $style = preg_replace('/\s+/', ' ', $style);

                if (!empty($style)) {
                    wp_register_style(
                        $handle,
                        false
                    );
                    wp_enqueue_style($handle);
                    wp_add_inline_style($handle, $style);
                }
            }
        }
        return $block_content;
    }

    /**
     * Sanitize CSS to prevent injection attacks
     * 
     * @param string $css The CSS string to sanitize
     * @return string Sanitized CSS
     */
    private function sanitize_css(string $css): string
    {
        // Remove javascript: protocol
        $css = preg_replace('/javascript\s*:/i', '', $css);
        
        // Remove ALL data: URIs to prevent any encoding-based attacks
        // WordPress will regenerate safe ones if needed
        $css = preg_replace('/data:/i', '', $css);
        
        // Remove expression() which can execute JavaScript
        $css = preg_replace('/expression\s*\(/i', '', $css);
        
        // Remove -moz-binding which can load external XBL files
        $css = preg_replace('/-moz-binding\s*:/i', '', $css);
        
        // Remove behavior property (IE specific)
        $css = preg_replace('/behavior\s*:/i', '', $css);
        
        // Remove import to prevent loading external stylesheets
        $css = preg_replace('/@import/i', '', $css);
        
        return $css;
    }
}