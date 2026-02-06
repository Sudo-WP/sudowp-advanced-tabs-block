<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Classes;

if (!defined('ABSPATH')) {
    exit;
}

class FontsLoader
{

    private static ?FontsLoader $instance = null;
    private array $all_fonts = [];

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
        add_action('wp_footer', [$this, 'fonts_loader']);
        add_action('admin_footer', [$this, 'fonts_loader']);
        add_action('atbs_render_block', [$this, 'font_generator']);
    }

    /**
     * Font generator.
     */
    public function font_generator(array $block): void
    {
        if (isset($block['attrs']) && is_array($block['attrs'])) {
            $attributes = $block['attrs'];
            foreach ($attributes as $key => $value) {
                if (!empty($value) && str_starts_with((string) $key, 'atbs_') && str_contains((string) $key, 'FontFamily')) {
                    // Sanitize font name - only allow alphanumeric, spaces, and hyphens
                    // Removed quotes to prevent CSS injection
                    $sanitized = sanitize_text_field((string) $value);
                    // Hyphen at the end of character class for clarity
                    $sanitized = preg_replace('/[^a-zA-Z0-9\s\-]/', '', $sanitized);
                    
                    if (!empty($sanitized)) {
                        $this->all_fonts[] = $sanitized;
                    }
                }
            }
        }
    }

    /**
     * Load fonts
     */
    public function fonts_loader(): void
    {
        if (!empty($this->all_fonts)) {

            $fonts = array_filter(array_unique($this->all_fonts));

            if (!empty($fonts)) {
                $system = [
                    'Arial',
                    'Tahoma',
                    'Verdana',
                    'Helvetica',
                    'Times New Roman',
                    'Trebuchet MS',
                    'Georgia',
                ];
                $gfonts = '';
                $gfonts_attr = ':100,200,300,400,500,600,700,800,900';
                foreach ($fonts as $font) {
                    if (!in_array($font, $system, true) && !empty($font)) {
                        // Sanitize and format for Google Fonts
                        $font_name = str_replace(' ', '+', trim($font));
                        $gfonts .= $font_name . $gfonts_attr . '|';
                    }
                }

                if (!empty($gfonts)) {
                    // Remove trailing pipe
                    $gfonts = rtrim($gfonts, '|');

                    $query_args = [
                        'family' => $gfonts,
                        'display' => 'swap',
                    ];

                    // Security: esc_url() prevents XSS vulnerability with add_query_arg
                    $fonts_url = esc_url(add_query_arg($query_args, 'https://fonts.googleapis.com/css'));

                    wp_register_style(
                        'atbs-fonts',
                        $fonts_url,
                        []
                    );
                    wp_enqueue_style('atbs-fonts');
                }

                // Reset
                $this->all_fonts = [];
            }
        }
    }
}