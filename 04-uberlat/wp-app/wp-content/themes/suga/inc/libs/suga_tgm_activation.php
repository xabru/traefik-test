<?php
/**
 * Load the TGM Plugin Activator class to notify the user
 * to install the Envato WordPress Toolkit Plugin
 */
require_once( get_template_directory() . '/inc/class-tgm-plugin-activation.php' );
function suga_tgmpa_register_toolkit() {
    // Specify the Envato Toolkit plugin
    $plugins = array(
        array(
            'name' => esc_html__('Classic Editor', 'suga'),
            'slug' => 'classic-editor',
            'img' => get_template_directory_uri() . '/images/plugins/classic-editor.png',
            'required' => '',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Redux Framework', 'suga'),
            'slug' => 'redux-framework',
            'img' => get_template_directory_uri() . '/images/plugins/Redux.jpg',
            'required' => true,
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('BKNinja Composer', 'suga'),
            'slug' => esc_html__('bkninja-composer', 'suga'),
            'img' => get_template_directory_uri() . '/images/plugins/bkninja-composer.jpg',
            'source' => get_template_directory() . '/plugins/bkninja-composer.zip',
            'required' => true,
            'version' => '2.2',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Social Login WordPress Plugin - AccessPress Social Login Lite', 'suga'),
            'slug' => 'accesspress-social-login-lite',
            'img' => get_template_directory_uri() . '/images/plugins/social-login.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Meta Box', 'suga'),
            'slug' => 'meta-box',
            'img' => get_template_directory_uri() . '/images/plugins/meta-box.jpg',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('MB Term Meta', 'suga'),
            'slug' => esc_html__('mb-term-meta', 'suga'),
            'img' => get_template_directory_uri() . '/images/plugins/Term-Meta.jpg',
            'source' => get_template_directory() . '/plugins/mb-term-meta.zip',
            'required' => true,
            'version' => '1.2.7',
            'external_url' => '',
        ),   
        array(
            'name' => esc_html__('Meta Box Conditional Logic', 'suga'),
            'slug' => esc_html__('meta-box-conditional-logic', 'suga'),
            'img' => get_template_directory_uri() . '/images/plugins/Conditional-Logic.jpg',
            'source' => get_template_directory() . '/plugins/meta-box-conditional-logic.zip',
            'required' => true,
            'version' => '1.6.7',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Suga Extension', 'suga'),
            'slug' => esc_html__('suga-extension', 'suga'),
            'img' => get_template_directory_uri() . '/images/plugins/suga-extension.png',
            'source' => get_template_directory() . '/plugins/suga-extension.zip',
            'version' => '1.0',
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Login With Ajax', 'suga'),
            'slug' => 'login-with-ajax',
            'img' => get_template_directory_uri() . '/images/plugins/login-with-ajax.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('MailChimp for WordPress', 'suga'),
            'slug' => 'mailchimp-for-wp',
            'img' => get_template_directory_uri() . '/images/plugins/mailchimp.jpg',
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Suga Sidebar Generator', 'suga'),
            'slug' => 'suga-sidebar-generator',
            'img' => get_template_directory_uri() . '/images/plugins/sidebar-generator.jpg',
            'source' => get_template_directory() . '/plugins/suga-sidebar-generator.zip',
            'version' => '1.0',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'suga'),
            'slug' => 'contact-form-7',
            'title' => esc_html__('Contact Form 7 - Optional', 'suga'),
            'img' => get_template_directory_uri() . '/images/plugins/contact-form-7.jpg',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => esc_html__('Suga Admin Panel', 'suga'),
            'slug' => 'suga-admin-panel',
            'title' => esc_html__('Suga Admin Panel - Optional', 'suga'),
            'source' => get_template_directory() . '/plugins/suga-admin-panel.zip',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
    );
     
    // Configuration of TGM
    $config = array(
        'domain'           => 'suga',
        'default_path'     => '',
        'menu'             => 'install-required-plugins',
        'has_notices'      => true,
        'is_automatic'     => true,
        'message'          => '',
        'strings'          => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'suga' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'suga' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'suga' ),
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'suga' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'suga' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'suga' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'suga' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'suga' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'suga' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'suga' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'suga' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'suga' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'suga' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'suga' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'suga' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'suga' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'suga' ),
            'nag_type'                        => 'updated'
        )
    );
    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'suga_tgmpa_register_toolkit' );