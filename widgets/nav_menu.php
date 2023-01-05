<?php

class Nav_Menu_Rometheme extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'rtm-navmenu';
    }
    public function get_title()
    {
        return 'RTM - Nav Menu';
    }
    public function get_categories()
    {
        return ['romethemekit_header_footer'];
    }
    public function get_icon()
    {
        return 'eicon-nav-menu';
    }
    public function get_keywords()
    {
        return ['nav', 'menu', 'navmenu', 'rometheme'];
    }

    public function get_style_depends()
    {
        return ['navmenu-rkit-style'];
    }

    public function get_script_depends()
    {
        return ['navmenu-rkit-script'];
    }

    public function get_menus()
    {
        $list = [];
        $menus = wp_get_nav_menus();
        foreach ($menus as $menu) {
            $list[$menu->slug] = esc_html__($menu->name, 'romethemekit-plugin');
        }

        return $list;
    }

    function wp_get_menu_array($current_menu)
    {

        $array_menu = wp_get_nav_menu_items($current_menu);
        $menu = array();
        foreach ($array_menu as $m) {
            if (empty($m->menu_item_parent)) {
                $menu[$m->ID] = array();
                $menu[$m->ID]['ID']      =   $m->ID;
                $menu[$m->ID]['title']       =   $m->title;
                $menu[$m->ID]['url']         =   $m->url;
                $menu[$m->ID]['children']    =   array();
            }
        }
        $submenu = array();
        foreach ($array_menu as $m) {
            if ($m->menu_item_parent) {
                $submenu[$m->ID] = array();
                $submenu[$m->ID]['ID']       =   $m->ID;
                $submenu[$m->ID]['title']    =   $m->title;
                $submenu[$m->ID]['url']  =   $m->url;
                $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
            }
        }
        return $menu;
    }

    function check_active_menu($menu_item)
    {
        $actual_link = sanitize_url((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        if ($actual_link == $menu_item['url']) {
            return 'rkit-navmenu-active';
        }
        return '';
    }
    function text_check_active_menu($menu_item)
    {
        $actual_link = sanitize_url((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        if ($actual_link == $menu_item['url']) {
            return 'rkit-navmenu-activetext';
        }
        return 'text-menu';
    }


    protected function register_controls()
    {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Menu Settting', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('menu-select', [
            'label' => esc_html__('Menu Select', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => $this->get_menus()
        ]);

        $this->add_responsive_control('menu-position', [
            'label' => esc_html__('Menu Position', 'romethemekit-lugin'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'start' => 'Start',
                'center' => 'Center',
                'end' => 'End',
                'space-between' => 'Justified',
            ],
            'devices' => ['desktop'],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-breakpointTablet' => 'justify-content: {{VALUE}}',
                '{{WRAPPER}} .rkit-navmenu-breakpointMobile' => 'justify-content: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('menu-item-spacing', [
            'label' => esc_html__('Item Spacing', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000, 'step' => 1],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 25],
                'rem' => ['min' => 0, 'max' => 25],
            ],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'default' => [
                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-breakpointTablet' => 'gap: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .rkit-navmenu-breakpointMobile' => 'gap: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_control('breakpoint-responsive', [
            'label' => esc_html__('Responsive Breakpoint', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'Tablet' => 'Tablet',
                'Mobile' => 'Mobile',
            ],
            'default' => 'Tablet'
        ]);

        $this->end_controls_section();
        $this->start_controls_section('hamburger-content', [
            'label' => esc_html__('Hamburger Menu Setting', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]);

        $this->add_control('icon-open', [
            'label' => esc_html__('Icon Open', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-bars',
                'library' => 'fa-solid'
            ],
        ]);
        $this->add_control('icon-close', [
            'label' => esc_html__('Icon Close', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-chevron-up',
                'library' => 'fa-solid'
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('menu-wrapper-style', [
            'label' => esc_html__('Menu Wrapper', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control('menu-wrapper-padding', [
            'label' => esc_html__('Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-padding' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->add_responsive_control(
            'content_align',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__('Alignment', 'romethemekit-plugin'),
                'options' => [
                    'flex-start' => 'Start',
                    'center' => 'Center',
                    'flex-end' => 'End',
                    'normal' => 'Normal'
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 'center',
                'tablet_default' => 'normal',
                'mobile_default' => 'normal',
                'selectors' => [
                    '{{WRAPPER}} .rkit-navmenu-breakpointTablet' => 'align-items : {{VALUE}}',
                    '{{WRAPPER}} .rkit-navmenu-breakpointMobile' => 'align-items : {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Menu Wrapper Background', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control('menu-background', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-background' => 'background: {{VALUE}}'
            ]
        ]);

        $this->end_controls_section();

        $this->start_controls_section('menu_style', [
            'label' => esc_html__('Menu Style', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .rkit-navmenu-container'
            ]
        );

        $this->start_controls_tabs('menu-style-tab');

        $this->start_controls_tab('menu-normal', [
            'label' => esc_html__('Normal', 'romethemekit-plugin')
        ]);

        $this->add_responsive_control('menu-text-padding', [
            'label' => esc_html__('Text Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-text-padding' => 'padding: {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->add_responsive_control('menu-item-radius', [
            'label' => esc_html__('Item Border Radius', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .menu-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control('text-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .text-menu' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item-background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .menu-list-item',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item-border',
                'selector' => '{{WRAPPER}} .menu-list-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('menu-hover', [
            'label' => esc_html__('Hover', 'romethemekit-plugin')
        ]);

        $this->add_responsive_control('menu-text-paddinghover', [
            'label' => esc_html__('Text Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-text-padding:hover' => 'padding: {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);


        $this->add_control('text-hover-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .text-menu:hover' => 'color: {{VALUE}}',
            ],
        ]);


        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item-background-hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .menu-list-item:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item-border-hover',
                'selector' => '{{WRAPPER}} .menu-list-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('menu-active', ['label' => esc_html__('Active', 'romethemekit-plugin')]);

        $this->add_responsive_control('active-item-padding', [
            'label' => esc_html__('Item Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('active-item-margin', [
            'label' => esc_html__('Item Margin', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('active-item-radius', [
            'label' => esc_html__('Item Border Radius', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control('active-text-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-navmenu-activetext' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'active-item-background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .rkit-navmenu-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'active-item-border',
                'selector' => '{{WRAPPER}} .rkit-navmenu-active',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('submenu-style-setting', [
            'label' => esc_html__('Submenu Style', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_control('submenu-icon', [
            'label' => esc_html__('Submenu Icon', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-angle-down',
                'library' => 'fa-solid'
            ]
        ]);

        $this->add_responsive_control('submenu-icon-size' , [
            'label' => esc_html__('Submenu Icon Size' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' , '%' , 'em' , 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000 , 'step' => 1],
                '%' =>  ['min' => 0, 'max' => 100],
                'em' =>  ['min' => 0, 'max' => 30],
                'rem' =>  ['min' => 0, 'max' => 30],
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-submenu-icon' => 'font-size:{{SIZE}}{{UNIT}}' 
            ]
            ]);

        $this->add_responsive_control('submenu-width', [
            'label' => esc_html__('Width', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'rem', 'vw'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000, 'step' => 1],
                '%' =>  ['min' => 0, 'max' => 100, 'step' => 1],
                'rem' =>  ['min' => 0, 'max' => 50],
                'vw' =>  ['min' => 0, 'max' => 100, 'step' => 1],
            ],
            'default' => ['size' => 150, 'unit' => 'px'],
            'tablet_default' => ['size' => 100, 'unit' => '%'],
            'mobile_default' => ['size' => 100, 'unit' => '%'],
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-breakpointTablet' => 'width:{{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .rkit-dropdown-breakpointMobile' => 'width:{{SIZE}}{{UNIT}}',
            ]
        ]);

        $this->add_responsive_control(
            'subemenu-text_align',
            [
                'label' => esc_html__('Alignment', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => 'center',
                'tablet_default' => 'start',
                'mobile_default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rkit-dropdown-background' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control('submenu-padding', [
            'label' => esc_html__('Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'default' => [
                'top' => 10,
                'right' => 10,
                'bottom' => 10,
                'left' => 10,
                'unit' => 'px'
            ],
            'tablet_default' => [
                'top' => 5,
                'right' => 5,
                'bottom' => 5,
                'left' => 5,
                'unit' => 'px'
            ],
            'mobile_default' => [
                'top' => 5,
                'right' => 5,
                'bottom' => 5,
                'left' => 5,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown:hover .rkit-dropdown-breakpointTablet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                '{{WRAPPER}} .rkit-dropdown:hover .rkit-dropdown-breakpointMobile' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('submenu-radius', [
            'label' => esc_html__('Border Radius', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-breakpointTablet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                '{{WRAPPER}} .rkit-dropdown-breakpointMobile' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control(
            'bg-separator',
            [
                'label' => esc_html__('Background', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control('submenu-bgcolor', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#bfbfbf',
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-background' => 'background-color:{{VALUE}}'
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submenu-border',
                'selector' => '{{WRAPPER}} .rkit-dropdown-background',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('submenu-item-style', [
            'label' => esc_html__('Submenu Item Style', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_item_typography',
                'selector' => '{{WRAPPER}} .rkit-dropdown-background',
            ]
        );

        $this->add_responsive_control('item-padding', [
            'label' => esc_html__('Item Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-breakpointTablet a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                '{{WRAPPER}} .rkit-dropdown-breakpointMobile a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ]
        ]);

        $this->add_responsive_control('item-spacing', [
            'label' => esc_html__('Item Spacing', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 500, 'step' => 1],
                '%' => ['min' => 0, 'max' => 100, 'step' => 1],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-breakpointTablet' => 'gap: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .rkit-dropdown-breakpointMobile' => 'gap: {{SIZE}}{{UNIT}}',
            ]
        ]);

        $this->start_controls_tabs('submenu-tabs');

        $this->start_controls_tab('submenu-normal', ['label' => esc_html__('Normal', 'romethemekit-plugin')]);

        $this->add_responsive_control('submenu-text-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-background > a' => 'color: {{VALUE}}'
            ]
        ]);
        $this->add_responsive_control('submenu-bg-color', [
            'label' => esc_html__('Background Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-background > a' => 'background-color: {{VALUE}}'
            ]
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('submenu-hover', ['label' => esc_html__('Hover', 'romethemekit-plugin')]);


        $this->add_control('submenu-hover-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-background > a:hover' => 'color: {{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('submenu-hover-bgcolor', [
            'label' => esc_html__('Background Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-dropdown-background > a:hover' => 'background-color: {{VALUE}}'
            ]
        ]);


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('hamburger-style-setting', [
            'label' => esc_html__('Hamburger Style', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);


        $this->add_responsive_control('hamburger-position', [
            'label' => esc_html__('Menu Icon Alignment', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'start' => [
                    'title' => esc_html__('Start', 'romethemekit-plugin'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'romethemekit-plugin'),
                    'icon' => 'eicon-text-align-center',
                ],
                'end' => [
                    'title' => esc_html__('End', 'romethemekit-plugin'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'toggle' => true,
            'selectors' => [
                '{{WRAPPER}} .rkit-hamburger-container' => 'justify-content: {{VALUE}}',
            ],
        ]);


        $this->add_responsive_control('hamburger-icon-padding', [
            'label' => esc_html__('Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'default' => [
                'top' => 10,
                'right' => 10,
                'bottom' => 10,
                'left' => 10,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('hamburger-border-radius', [
            'label' => esc_html__('Border Radius', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger' => 'border-radius : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->add_responsive_control('hamburger-icon-size', [
            'label' => esc_html__('Icon Size', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 500, 'step' => 1],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger' => 'font-size:{{SIZE}}{{UNIT}}'
            ]
        ]);

        $this->start_controls_tabs('btn-hamburger');

        $this->start_controls_tab('btn-hamburger-normal', ['label' => 'Normal']);

        $this->add_responsive_control('btn-hamburger-bg', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffb901',
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger' => 'background-color:{{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('btn-hamburger-color', [
            'label' => esc_html__('Icon Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn-hamburger-border',
                'selector' => '{{WRAPPER}} .rkit-btn-hamburger',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('btn-hamburger-hover', ['label' => esc_html__('Hover', 'romethemekit-plugin')]);

        $this->add_responsive_control('btn-hamburger-hoverbg', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger:hover' => 'background-color:{{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('btn-hamburger-hovercolor', [
            'label' => esc_html__('Icon Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-btn-hamburger:hover' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn-hamburger-hoverborder',
                'selector' => '{{WRAPPER}} .rkit-btn-hamburger:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>

        <div class="rkit-navmenu-container" data-key="<?php echo esc_attr($this->get_id_int()) ?>" data-responsive-breakpoint="<?php echo esc_attr(($settings['breakpoint-responsive'] === 'Mobile') ? "767" : "1024" ) ?>">
            <div class="rkit-hamburger-background ">
                <div class="rkit-hamburger-container">
                    <button class=" rkit-btn-hamburger rkit-hamburger-breakpoint<?php echo esc_attr($settings['breakpoint-responsive']) ?> rkit-hamburger-menu<?php echo esc_attr($this->get_id_int()) ?>" onclick="show_menu(<?php echo esc_attr($this->get_id_int()) ?>)">
                        <div class="rkit-icon-open rkit-icon-open<?php echo esc_attr($this->get_id_int()) ?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['icon-open'], ['aria-hidden' => 'true']) ?>
                        </div>
                        <div class="rkit-icon-close rkit-icon-close<?php echo esc_attr($this->get_id_int() )?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['icon-close'], ['aria-hidden' => 'true']) ?>
                        </div>
                    </button>
                </div>
                <div class="rkit-navmenu-background rkit-navmenu-padding rkit-navmenu-breakpoint<?php echo esc_attr($settings['breakpoint-responsive']) ?> rkit-navmenu-menu<?php echo esc_attr($this->get_id_int() )?>">
                    <?php echo $this->render_raw(); ?>
                </div>
            </div>

        </div>
        <?php
    }
    protected function render_raw()
    {
        $settings = $this->get_settings_for_display();
        $menu_slug = $settings['menu-select'];
        $menu = wp_get_nav_menu_object($menu_slug);
        $current_menu = $menu->slug;
        $menu_parent = $this->wp_get_menu_array($current_menu);
        $id = $this->get_id_int();

        if (count($menu_parent) != 0) {
            foreach ($menu_parent as $key => $menu) {
                if (count($menu['children']) == 0) {
        ?>
                    <div class="menu-list-item rkit-text-padding <?php echo esc_attr($this->check_active_menu($menu)) ?>">
                        <a class="<?php echo esc_attr($this->text_check_active_menu($menu)) ?>" href="<?php echo esc_url($menu['url']) ?>"><?php echo esc_html__($menu['title'], 'romethemekit-plugin') ?></a>
                    </div>
                <?php
                } else {
                ?>
                    <div id="menu-parent-<?php $key ?>" class="rkit-dropdown menu-list-item <?php echo esc_attr($this->check_active_menu($menu)) ?>">
                        <div class="rkit-text-padding" style="display: flex ; justify-content:space-between ; align-items:center;">
                            <a class="<?php echo esc_attr($this->text_check_active_menu($menu)) ?>" href="<?php echo esc_url($menu['url']); ?>"><?php echo esc_html__($menu['title'], 'romethemekit-plugin') ?></a>
                            <a class="<?php echo esc_attr($this->text_check_active_menu($menu)) ?>" style="padding-inline:10px ;"><?php \Elementor\Icons_Manager::render_icon( $settings['submenu-icon'], [ 'aria-hidden' => 'true' , 'class' => 'rkit-submenu-icon' ] ); ?></a>
                        </div>
                        <div class="rkit-dropdown-background rkit-dropdown-breakpoint<?php echo esc_attr($settings['breakpoint-responsive']) ?> rkit-dropdown-content<?php echo esc_attr($id) ?>">
                            <?php
                            foreach ($menu['children'] as $key => $subitem) {
                            ?>
                                <a style="width:100%" href="<?php echo esc_url($subitem['url']) ?>"><?php echo esc_html__($subitem['title'], 'romethemekit-plugin') ?></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
}
