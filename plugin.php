<?php

namespace RomethemePlugin;

use RomeTheme;
use Rometheme\HeaderFooter\HeaderFooter;
use RomethemeKit\Autoloader;

class Plugin
{
    public static function register_autoloader()
    {
        require_once \RomeTheme::plugin_dir() . '/autoloader.php';
        Autoloader::run();
    }

    public static function load_header_footer()
    {
        require_once \RomeTheme::module_dir() . 'HeaderFooter/HeaderFooter.php';
        new HeaderFooter();
    }

    public static function register_widget($widgets_manager)
    {
        require_once(RomeTheme::widget_dir() . 'offcanvas-rometheme.php');
        require_once(RomeTheme::widget_dir() . 'search-rometheme.php');
        require_once(RomeTheme::widget_dir() . 'sitelogo-rometheme.php');
        require_once(RomeTheme::widget_dir() . 'header_info_rometheme.php');
        require_once(RomeTheme::widget_dir() . 'nav_menu.php');
        $widgets_manager->register(new \Offcanvas_Rometheme());
        $widgets_manager->register(new \Search_Rometheme());
        $widgets_manager->register(new \SiteLogo_Rometheme());
        $widgets_manager->register(new \HeaderInfo_Rometheme());
        $widgets_manager->register(new \Nav_Menu_Rometheme());
    }

    public static function register_widget_styles()
    {
        wp_register_style('rkit-offcanvas-style', \RomeTheme::widget_url() . 'assets/css/offcanvas.css');
        wp_register_style('rkit-navmenu-style', \RomeTheme::widget_url() . 'assets/css/navmenu.css');
        wp_register_style('rkit-headerinfo-style', \RomeTheme::widget_url() . 'assets/css/headerinfo.css');
        wp_register_style('navmenu-rkit-style', \RomeTheme::widget_url() . 'assets/css/rkit-navmenu.css');
        wp_register_style('rkit-search-style', \RomeTheme::widget_url() . 'assets/css/search.css');
    }

    public static function register_widget_scripts()
    {
        wp_register_script('rkit-offcanvas-script', \RomeTheme::widget_url() . 'assets/js/offcanvas.js');
        wp_register_script('rkit-navmenu-script', \RomeTheme::widget_url() . 'assets/js/navmenu.js');
        wp_register_script('navmenu-rkit-script', \RomeTheme::widget_url() . 'assets/js/rkit-navmenu.js');
    }

    public static function  add_elementor_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'romethemekit_header_footer',
            [
                'title' => esc_html__('Rometheme Header & Footer' , 'romethemekit-plugin')
            ]
        );
    }
}
