<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin Name:       SudoWP Advanced Tabs Gutenberg Block
 * Description:       A custom Gutenberg Block to show content in tabs style. Security hardened and modernized.
 * Requires at least: 6.0
 * Requires PHP:      8.2
 * Version:           1.2.7
 * Author:            SudoWP
 * Author URI:        https://sudowp.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sudowp-advanced-tabs-block
 */

final class Plugin
{

    private static ?Plugin $instance = null;

    public const VERSION = '1.2.7';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_security_headers();
    }

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
     * Define the plugin constants
     */
    private function define_constants(): void
    {
        if (!defined('ATBS_VERSION')) {
            define('ATBS_VERSION', self::VERSION);
        }
        if (!defined('ATBS_URL')) {
            define('ATBS_URL', plugin_dir_url(__FILE__));
        }
        if (!defined('ATBS_DIR_PATH')) {
            define('ATBS_DIR_PATH', plugin_dir_path(__FILE__));
        }
        if (!defined('ATBS_DIR')) {
            define('ATBS_DIR', __DIR__);
        }
    }

    /**
     * Include the plugin files
     */
    private function includes(): void
    {
        if (file_exists(ATBS_DIR . '/includes/loader.php')) {
            require_once ATBS_DIR . '/includes/loader.php';
        }
    }

    /**
     * Initialize security headers
     * Adds security headers to admin pages for this plugin
     */
    private function init_security_headers(): void
    {
        add_action('send_headers', function() {
            // Only apply to our plugin's admin pages
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Just checking page parameter
            if (is_admin() && isset($_GET['page']) && sanitize_key($_GET['page']) === 'atbs-block') {
                // X-Content-Type-Options: prevent MIME type sniffing
                if (!headers_sent()) {
                    header('X-Content-Type-Options: nosniff');
                    
                    // X-Frame-Options: prevent clickjacking (allow same origin for iframe embeds)
                    header('X-Frame-Options: SAMEORIGIN');
                }
            }
        });
    }
}

Plugin::instance();