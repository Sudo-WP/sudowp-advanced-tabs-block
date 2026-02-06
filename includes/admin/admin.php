<?php
declare(strict_types=1);

namespace SudoWP\AdvancedTabsBlock\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Admin
{

    private static ?Admin $instance = null;

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
        add_action('admin_menu', [$this, 'atbs_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'atbs_admin_assets']);
    }

    /**
     * Enqueue admin scripts
     */
    public function atbs_admin_assets(string $screen): void
    {
        if ($screen === 'settings_page_atbs-block') {
            wp_enqueue_style('atbs-admin-style', ATBS_URL . 'assets/css/admin.css', [], ATBS_VERSION, 'all');
            // JS
            wp_enqueue_script('atbs-admin-script', ATBS_URL . 'assets/js/admin.js', ['jquery'], ATBS_VERSION, true);
        }
    }

    /**
     * Add admin menu
     */
    public function atbs_admin_menu(): void
    {
        add_submenu_page(
            'options-general.php',
            __('Tabs Block', 'sudowp-advanced-tabs-block'),
            __('Tabs Block', 'sudowp-advanced-tabs-block'),
            'manage_options',
            'atbs-block',
            [$this, 'atbs_admin_page']
        );
    }

    /**
     * Admin page
     */
    public function atbs_admin_page(): void
    {
        ?>
        <div class="atbs__wrap">
            <div class="plugin_max_container">
                <div class="plugin__head_container">
                    <div class="plugin_head">
                        <h1 class="plugin_title">
                            <?php esc_html_e('Advanced Tabs Block', 'sudowp-advanced-tabs-block'); ?>
                        </h1>
                        <p class="plugin_description">
                            <?php esc_html_e('Advanced Tabs Block is a Gutenberg block plugin that allows you to showcase your content in tab style in Gutenberg Editor without any coding knowledge', 'sudowp-advanced-tabs-block'); ?>
                        </p>
                    </div>
                </div>
                <div class="plugin__body_container">
                    <div class="plugin_body">
                        <div class="tabs__panel_container">
                            <div class="tabs__titles">
                                <p class="tab__title active" data-tab="tab1">
                                    <?php esc_html_e('Help and Support', 'sudowp-advanced-tabs-block'); ?>
                                </p>
                                <p class="tab__title" data-tab="tab2">
                                    <?php esc_html_e('Changelog', 'sudowp-advanced-tabs-block'); ?>
                                </p>
                            </div>
                            <div class="tabs__container">
                                <div class="tabs__panels">
                                    <div class="tab__panel active" id="tab1">
                                        <div class="tab__panel_flex">
                                            <div class="tab__panel_left">
                                                <h3 class="video__title">
                                                    <?php esc_html_e('Video Tutorial', 'sudowp-advanced-tabs-block'); ?>
                                                </h3>
                                                <p class="video__description">
                                                    <?php esc_html_e('Watch the video tutorial to learn how to use the plugin. It will help you start your own design quickly.', 'sudowp-advanced-tabs-block'); ?>
                                                </p>
                                                <div class="video__container">
                                                    <iframe width="560" height="315"
                                                        src="https://www.youtube.com/embed/ZqCh5G-FMSU" 
                                                        title="<?php esc_attr_e('Advanced Tabs Block Tutorial Video', 'sudowp-advanced-tabs-block'); ?>"
                                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                        sandbox="allow-scripts allow-same-origin allow-presentation"
                                                        allowfullscreen 
                                                        style="border: 0;"></iframe>
                                                </div>
                                            </div>
                                            <div class="tab__panel_right">
                                                <div class="single__support_panel">
                                                    <h3 class="support__title">
                                                        <?php esc_html_e('Get Support', 'sudowp-advanced-tabs-block'); ?>
                                                    </h3>
                                                    <p class="support__description">
                                                        <?php esc_html_e('If you find any issue or have any suggestion, please let me know.', 'sudowp-advanced-tabs-block'); ?>
                                                    </p>
                                                    <a href="https://wordpress.org/support/plugin/advanced-tabs-block/"
                                                        class="support__link" target="_blank" rel="noopener noreferrer">
                                                        <?php esc_html_e('Support', 'sudowp-advanced-tabs-block'); ?>
                                                    </a>
                                                </div>
                                                <div class="single__support_panel">
                                                    <h3 class="support__title">
                                                        <?php esc_html_e('Spread Your Love', 'sudowp-advanced-tabs-block'); ?>
                                                    </h3>
                                                    <p class="support__description">
                                                        <?php esc_html_e('If you like this plugin, please share your opinion', 'sudowp-advanced-tabs-block'); ?>
                                                    </p>
                                                    <a href="https://wordpress.org/support/plugin/advanced-tabs-block/reviews/"
                                                        class="support__link" target="_blank" rel="noopener noreferrer">
                                                        <?php esc_html_e('Rate the Plugin', 'sudowp-advanced-tabs-block'); ?>
                                                    </a>
                                                </div>
                                                <div class="single__support_panel">
                                                    <h3 class="support__title">
                                                        <?php esc_html_e('Similar Blocks', 'sudowp-advanced-tabs-block'); ?>
                                                    </h3>
                                                    <p class="support__description">
                                                        <?php esc_html_e('Want to get more similar blocks, please visit my website', 'sudowp-advanced-tabs-block'); ?>
                                                    </p>
                                                    <a href="https://makegutenblock.com" class="support__link" target="_blank" rel="noopener noreferrer">
                                                        <?php esc_html_e('Visit my Website', 'sudowp-advanced-tabs-block'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom__block_request">
                                            <h3 class="custom__block_request_title">
                                                <?php esc_html_e('Need to Hire Me?', 'sudowp-advanced-tabs-block'); ?>
                                            </h3>
                                            <p class="custom__block_request_description">
                                                <?php esc_html_e('I am available for any freelance projects. Please feel free to share your project detail with me.', 'sudowp-advanced-tabs-block'); ?>
                                            </p>
                                            <div class="available__links">
                                                <a href="mailto:zbinsaifullah@gmail.com" class="available__link mail"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <?php esc_html_e('Send Email', 'sudowp-advanced-tabs-block'); ?>
                                                </a>
                                                <a href="https://makegutenblock.com/contact" class="available__link web"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <?php esc_html_e('Send Message', 'sudowp-advanced-tabs-block'); ?>
                                                </a>
                                                <a href="https://www.fiverr.com/devs_zak" class="available__link fiverr"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <?php esc_html_e('Fiverr', 'sudowp-advanced-tabs-block'); ?>
                                                </a>
                                                <a href="https://www.upwork.com/freelancers/~010af183b3205dc627"
                                                    class="available__link upwork" target="_blank" rel="noopener noreferrer">
                                                    <?php esc_html_e('UpWork', 'sudowp-advanced-tabs-block'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab__panel" id="tab2">
                                        <div class="change__log_head">
                                            <h3 class="change__log_title">
                                                <?php esc_html_e('Changelog', 'sudowp-advanced-tabs-block'); ?>
                                            </h3>
                                            <p class="change__log_description">
                                                <?php esc_html_e('This is the changelog of the plugin. You can see the changes in each version.', 'sudowp-advanced-tabs-block'); ?>
                                            </p>
                                            <div class="change__notes">
                                                <div class="single__note">
                                                    <span
                                                        class="info change__note"><?php esc_html_e('i', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="note__description"><?php esc_html_e('Info', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="single__note">
                                                    <span
                                                        class="feature change__note"><?php esc_html_e('N', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="note__description"><?php esc_html_e('New Feature', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="single__note">
                                                    <span
                                                        class="update change__note"><?php esc_html_e('U', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="note__description"><?php esc_html_e('Update', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="single__note">
                                                    <span
                                                        class="fixing change__note"><?php esc_html_e('F', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="note__description"><?php esc_html_e('Issue Fixing', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="change__log_body">
                                            <div class="single__log">
                                                <div class="plugin__info">
                                                    <span class="log__version">1.2.0</span>
                                                    <span class="log__date">2023-08-31</span>
                                                </div>
                                                <div class="log__description">
                                                    <span class="change__note info">i</span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('A major update', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span
                                                        class="feature change__note"><?php esc_html_e('N', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Tab Style is available in Editor also.', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span
                                                        class="feature change__note"><?php esc_html_e('N', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Adding Icons for Tab title.', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span
                                                        class="feature change__note"><?php esc_html_e('N', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('More Customization options.', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span
                                                        class="feature change__note"><?php esc_html_e('N', 'sudowp-advanced-tabs-block'); ?></span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Block Patterns are added.', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span class="change__note fixing">F</span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Fixing PHP errors', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                                <div class="log__description">
                                                    <span class="change__note update">U</span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Removing jquery and added only pure javascript', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                            </div>
                                            <div class="single__log">
                                                <div class="plugin__info">
                                                    <span class="log__version">1.0.0</span>
                                                    <span class="log__date">2022-08-11</span>
                                                </div>
                                                <div class="log__description">
                                                    <span class="change__note info">i</span>
                                                    <span
                                                        class="description__text"><?php esc_html_e('Initial Release', 'sudowp-advanced-tabs-block'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}


