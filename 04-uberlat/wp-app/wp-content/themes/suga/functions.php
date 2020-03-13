<?php
define('SUGA_NAME', 'SUGA');

define('SUGA_LIBS', get_template_directory().'/library/');
define('SUGA_LIBS_ADMIN', SUGA_LIBS.'admin_panel/');

define('SUGA_FRAMEWORK', get_template_directory().'/framework/');

define('SUGA_INC', get_template_directory().'/inc/');
define('SUGA_INC_LIBS', SUGA_INC.'libs/');
define('SUGA_BLOCKS', SUGA_INC.'blocks/');
define('SUGA_MODULES', SUGA_INC.'/modules/');

define ('SUGA_TEMPLATES', SUGA_LIBS.'templates/');
define ('SUGA_AJAX', SUGA_LIBS.'/ajax/');
define ('SUGA_HEADER_TEMPLATES', SUGA_TEMPLATES.'header/');
define ('SUGA_FOOTER_TEMPLATES', SUGA_TEMPLATES.'footer/');
define ('SUGA_SINGLE_TEMPLATES', SUGA_TEMPLATES.'single/');

/**
 * Enqueue Style and Script Files Init Theme
 */
require_once (SUGA_INC.'bk_enqueue_scripts.php');
require_once (SUGA_INC.'bk_theme_settings.php');
require_once (SUGA_LIBS.'mega_menu.php');

/**
 * Add php library file.
 */
require_once (SUGA_LIBS.'core.php');
require_once (SUGA_LIBS.'mega_menu.php');
require_once (SUGA_LIBS.'custom_css.php');
require_once (SUGA_LIBS.'translation.php');
require_once (SUGA_INC.'bk_inc_files.php');