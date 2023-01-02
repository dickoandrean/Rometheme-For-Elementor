<?php

namespace Rometheme\HeaderFooter;

use RomeTheme;

class HeaderFooter
{

    public $dir;
    public $url;

    function __construct()
    {
        add_action('init', [$this, 'rometheme_header_post_type']);
        add_action('admin_menu', [$this, 'add_to_menu']);
        add_action('admin_footer', [$this, 'menu_ui']);
        $this->dir = dirname(__FILE__) . '/';
        $this->url = \RomeTheme::module_url() . 'HeaderFooter/';
        add_action('admin_enqueue_scripts', [$this, 'enqueue_style']);
        add_filter('single_template', array($this, 'load_canvas_template'));
        add_action("wp_ajax_updatepost", [$this, "updatepost"]);
        add_action("wp_ajax_nopriv_updatepost", [$this,  "updatepost"]);
        add_action("wp_ajax_addNewPost", [$this, "addNewPost"]);
        add_action("wp_ajax_nopriv_addNewPost", [$this, "addNewPost"]);
        add_action('wp', [$this, 'header_footer_template']);
    }

    public function header_footer_template()
    {
        if ($this->get_header_template()) {
            add_action('get_header', array($this, 'override_header_template'), 99);
            add_action('romethemekit_header', array($this, 'render_header'));
        }
        if ($this->get_footer_template()) {
            add_action('get_footer', array($this, 'override_footer_template'), 99);
            add_action('romethemekit_footer', array($this, 'render_footer'));
        }
    }

    function rometheme_header_post_type()
    {
        $labels = array(
            'name'               => esc_html__('Rometheme Templates', 'romethemekit-plugin'),
            'singular_name'      => esc_html__('Templates', 'romethemekit-plugin'),
            'menu_name'          => esc_html__('Header Footer', 'romethemekit-plugin'),
            'name_admin_bar'     => esc_html__('Header Footer', 'romethemekit-plugin'),
            'add_new'            => esc_html__('Add New', 'romethemekit-plugin'),
            'add_new_item'       => esc_html__('Add New Template', 'romethemekit-plugin'),
            'new_item'           => esc_html__('New Template', 'romethemekit-plugin'),
            'edit_item'          => esc_html__('Edit Template', 'romethemekit-plugin'),
            'view_item'          => esc_html__('View Template', 'romethemekit-plugin'),
            'all_items'          => esc_html__('All Templates', 'romethemekit-plugin'),
            'search_items'       => esc_html__('Search Templates', 'romethemekit-plugin'),
            'parent_item_colon'  => esc_html__('Parent Templates:', 'romethemekit-plugin'),
            'not_found'          => esc_html__('No Templates found.', 'romethemekit-plugin'),
            'not_found_in_trash' => esc_html__('No Templates found in Trash.', 'romethemekit-plugin'),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'rewrite'             => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'exclude_from_search' => true,
            'capability_type'     => 'page',
            'hierarchical'        => false,
            'supports'            => array('title', 'thumbnail', 'elementor'),
        );
        register_post_type('rometheme_template', $args);
    }

    function add_to_menu()
    {
        add_submenu_page(
            'romethemekit',
            esc_html('Header & Footer'),
            esc_html('Header & Footer'),
            'manage_options',
            'header-footer',
            [$this, 'headerfooter_call']
        );
    }

    function headerfooter_call()
    {
        require_once $this->dir . 'views/add_edit.php';
    }

    function menu_ui()
    {
        $screen = get_current_screen();
        if ($screen->id == 'rometheme-kit_page_header-footer') {
            require_once $this->dir . 'views/add_edit.php';
        }
        if ($screen->id == 'rometheme_template' and $screen->parent_base == 'edit') {
            require $this->dir . 'views/edit.php';
        }
    }

    function load_canvas_template($single_template)
    {

        global $post;

        if ('rometheme_template' == $post->post_type) {

            $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

            if (file_exists($elementor_2_0_canvas)) {
                return $elementor_2_0_canvas;
            } else {
                return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
            }
        }

        return $single_template;
    }

    function enqueue_style()
    {

        $screen = get_current_screen();
        if ($screen->id == 'rometheme-kit_page_header-footer' or $screen->id == 'rometheme_template') {
            wp_enqueue_style('style.css', \RomeTheme::plugin_url() . 'bootstrap/css/bootstrap.css');
            wp_enqueue_script('bootstrap.js', \RomeTheme::plugin_url() . 'bootstrap/js/bootstrap.min.js');
            wp_enqueue_style('style', $this->url . 'assets/css/style.css');
            wp_enqueue_script('js', $this->url . 'assets/js/style.js', null, false);
            wp_register_script('js', $this->url  . 'assets/js/style.js');
            wp_localize_script('js', 'rometheme_ajax_url', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
            wp_localize_script('js', 'rometheme_url', ['header_footer_url' =>  admin_url() . 'admin.php?page=header-footer']);
        }
    }

    function updatepost()
    {
        $data = [
            'ID' => sanitize_text_field($_POST['id']),
            'post_title' => sanitize_text_field($_POST['title']),
            'meta_input' => [
                'rometheme_template_type' => sanitize_text_field($_POST['type']),
                'rometheme_template_active' => (sanitize_text_field($_POST['active']) == null) ? 'false' : 'true'
            ]
        ];
        wp_update_post($data, false, true);
        exit;
    }

    public function addNewPost()
    {
        $data = [
            'post_author' => get_current_user_id(),
            'post_title' => sanitize_text_field($_POST['title']),
            'post_type' => 'rometheme_template',
            'post_status' => 'publish'
        ];
        $post_id = wp_insert_post($data);
        add_post_meta($post_id, 'rometheme_template_type', sanitize_text_field($_POST['type']));
        add_post_meta($post_id, 'rometheme_template_active', sanitize_text_field($_POST['active']));
    }

    public function get_header_template()
    {
        $args = [
            'post_type' => 'rometheme_template',
            'post_status' => 'publish',
            'meta_query' => [
                'relations' => 'AND',
                [
                    'key' => 'rometheme_template_type',
                    'value' => 'header'
                ],
                [
                    'key' => 'rometheme_template_active',
                    'value' => 'true'
                ]
            ]
        ];
        $header = get_posts($args);
        return $header;
    }

    function get_footer_template()
    {
        $args = [
            'post_type' => 'rometheme_template',
            'post_status' => 'publish',
            'meta_query' => [
                'relations' => 'AND',
                [
                    'key' => 'rometheme_template_type',
                    'value' => 'footer'
                ],
                [
                    'key' => 'rometheme_template_active',
                    'value' => 'true'
                ]
            ]
        ];
        $footer = get_posts($args);
        return $footer;
    }
    public function get_header_content($header_id)
    {
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($header_id, true);
    }

    public function get_footer_content($footer_id)
    {
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($footer_id, true);
    }

    public function override_header_template()
    {
        load_template($this->dir . 'templates/header_template.php');
        $templates   = array();
        $templates[] = 'header.php';
        remove_all_actions('wp_head');
        ob_start();
        locate_template($templates, true);
        ob_get_clean();
    }

    public function override_footer_template()
    {
        load_template($this->dir . 'templates/footer_template.php');
        $templates   = array();
        $templates[] = 'footer.php';
        remove_all_actions('wp_footer');
        ob_start();
        locate_template($templates, true);
        ob_get_clean();
    }

    public function render_header()
    {
        $headers = $this->get_header_template();

        foreach ($headers as $header) {
            $header_id = $header->ID;
        }

        $header_html = '<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">%s</header>';
        echo sprintf($header_html, $this->get_header_content($header_id));
    }

    public function render_footer()
    {
        $footers = $this->get_footer_template();
        foreach ($footers as $footer) {
            $footer_id = $footer->ID;
        }
        $footer_html = '<footer itemscope="itemscope" itemtype="https://schema.org/WPFooter">%s</footer>';
        echo sprintf($footer_html, $this->get_footer_content($footer_id));
    }
}
