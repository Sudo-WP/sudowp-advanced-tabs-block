<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

use SudoWP\AdvancedTabsBlock\Admin\Admin;
use SudoWP\AdvancedTabsBlock\Classes\BlockCategory;
use SudoWP\AdvancedTabsBlock\Classes\RegisterBlocks;
use SudoWP\AdvancedTabsBlock\Classes\EnqueueAssets;
use SudoWP\AdvancedTabsBlock\Classes\FontsLoader;
use SudoWP\AdvancedTabsBlock\Classes\PatternsCategory;
use SudoWP\AdvancedTabsBlock\Classes\BlockPatterns;

// Include files
require_once ATBS_DIR . '/includes/admin/admin.php';
require_once ATBS_DIR . '/includes/classes/block-category.php';
require_once ATBS_DIR . '/includes/classes/register-blocks.php';
require_once ATBS_DIR . '/includes/classes/enqueue-assets.php';
require_once ATBS_DIR . '/includes/classes/fonts-loader.php';
require_once ATBS_DIR . '/includes/classes/patterns-category.php';
require_once ATBS_DIR . '/includes/classes/block-patterns.php';

// Instantiate classes
Admin::instance();
BlockCategory::instance();
RegisterBlocks::instance();
EnqueueAssets::instance();
FontsLoader::instance();
PatternsCategory::instance();
BlockPatterns::instance();
