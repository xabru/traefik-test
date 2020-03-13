<?php
if (!function_exists('bk_demo_config_options')) {
    function bk_demo_config_options(){
        $bk_theme_demos = array (
            BK_DEMO_1 => array (
                             'class' => BK_DEMO_1,
                             'title' => 'Suga (Main Demo)',
                             'img'   => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_1.'/screenshot.png',
                        ),
            BK_DEMO_2 => array (
                             'class' => BK_DEMO_2,
                             'title' => 'Abstract',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_2.'/screenshot.png',
                        ),
            
            BK_DEMO_3 => array (
                             'class' => BK_DEMO_3,
                             'title' => 'Rudens',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_3.'/screenshot.png',
                        ),
            
            BK_DEMO_4 => array (
                             'class' => BK_DEMO_4,
                             'title' => 'Archive',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_4.'/screenshot.png',
                        ),
            
            BK_DEMO_5 => array (
                             'class' => BK_DEMO_5,
                             'title' => 'Delicia',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_5.'/screenshot.png',
                        ),
            
            BK_DEMO_6 => array (
                             'class' => BK_DEMO_6,
                             'title' => 'Techno',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_6.'/screenshot.png',
                        ),
            
            BK_DEMO_7 => array (
                             'class' => BK_DEMO_7,
                             'title' => 'Stan',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_7.'/screenshot.png',
                        ),
            
            BK_DEMO_8 => array (
                             'class' => BK_DEMO_8,
                             'title' => 'Natura',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_8.'/screenshot.png',
                        ),
            BK_DEMO_9 => array (
                             'class' => BK_DEMO_9,
                             'title' => 'Ciria',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_9.'/screenshot.png',
                        ),
            BK_DEMO_10 => array (
                             'class' => BK_DEMO_10,
                             'title' => 'Hub',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_10.'/screenshot.png',
                        ),
                        /*
            BK_DEMO_11 => array (
                             'class' => BK_DEMO_11,
                             'title' => 'Sport Demo',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_11.'/screenshot.png',
                        ),
            BK_DEMO_12 => array (
                             'class' => BK_DEMO_12,
                             'title' => 'Crypto Demo',
                             'img' => BK_AD_PLUGIN_URL . 'demo_content/'.BK_DEMO_12.'/screenshot.png',
                        ),
                        */
        );        
        $import_source = array(
            BK_DEMO_1 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_1.'/theme_options.json',
            ),
            BK_DEMO_2 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_2.'/theme_options.json',
            ),
            BK_DEMO_3 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_3.'/theme_options.json',
            ),
            BK_DEMO_4 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_4.'/theme_options.json',
            ),
            BK_DEMO_5 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_5.'/theme_options.json',
            ),
            BK_DEMO_6 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_6.'/theme_options.json',
            ),
            BK_DEMO_7 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_7.'/theme_options.json',
            ),
            BK_DEMO_8 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_8.'/theme_options.json',
            ),
            BK_DEMO_9 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_9.'/theme_options.json',
            ),
            BK_DEMO_10 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_10.'/theme_options.json',
            ),
            /*
            BK_DEMO_11 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_11.'/theme_options.json',
            ),
            BK_DEMO_12 => array (
                'content'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/content.xml',
                'widgets'       => BK_AD_PLUGIN_DIR . 'demo_content/content_files/widgets.wie',
                'theme_options' => BK_AD_PLUGIN_DIR . 'demo_content/'.BK_DEMO_12.'/theme_options.json',
            ),
            */
        );
        wp_localize_script( 'bkadscript', 'import_source', $import_source );
        return $bk_theme_demos;        
    }        
}    