<?php

class HeaderInfo_Rometheme extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'header-info';
    }

    public function get_title()
    {
        return 'RTM - Header Info';
    }
    public function get_icon()
    {
        return 'eicon-form-vertical';
    }
    public function get_categories()
    {
        return ['romethemekit_header_footer'];
    }
    public function get_keywords()
    {
        return ['header', 'info', 'header info', 'rometheme'];
    }
    public function get_style_depends()
    {
        return ['rkit-headerinfo-style'];
    }
    protected function register_controls()
    {
        $this->start_controls_section('content_section', [
            'label' => 'Header Info',
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);


        $headerinfogroup = new \Elementor\Repeater();
        $headerinfogroup->add_control(
            'rkit_headerinfo_icons',
            [
                'label'         => esc_html__('Icon', 'romethemekit-plugin'),
                'label_block'   => true,
                'type'          => \Elementor\Controls_Manager::ICONS,
                'default'       => [
                    'value'         => 'fas fa-map',
                    'library'       => 'fa-solid',
                ],

            ]
        );

        $headerinfogroup->add_control(
            'rkit_headerinfo_text',
            [
                'label' => esc_html__('Text', 'romethemekit-plugin'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Pekanbaru, Indonesia',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $headerinfogroup->add_control(
            'rkit_headerinfo_link',
            [
                'label' => esc_html__('Link', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('example: https://your-link.com', 'romethemekit-plugin'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'rkit_headerinfo_group',
            [
                'label' => esc_html__('Header Info', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $headerinfogroup->get_controls(),
                'default' => [
                    [
                        'rkit_headerinfo_text' => esc_html__('Pekanbaru, Indonesia', 'romethemekit-plugin'),
                    ],

                ],
                'title_field' => '{{{ rkit_headerinfo_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => esc_html__('Header Info', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control('headerinfo-margin', [
            'label' => esc_html__('Margin', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo' => 'margin : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->add_responsive_control('headerinfo-padding', [
            'label' => esc_html__('Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo' => 'padding : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);


        $this->add_control('headerinfo-row-gap', [
            'label' => esc_html__('Item Row Spacing', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'default' => [
                'size' => 10,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo' => 'row-gap : {{SIZE}}{{UNIT}}'
            ],
        ]);


        $this->add_control('headerinfo-column-gap', [
            'label' => esc_html__('Item Column Spacing', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'default' => [
                'size' => 10,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo' => 'column-gap : {{SIZE}}{{UNIT}}'
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text-typography',
                'selector' => '{{WRAPPER}} .rkit-headerinfo-text'
            ]
        );


        $this->add_responsive_control('headerinfo-list-padding', [
            'label' => esc_html__('Item Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'selectors' => [
                '{{WRAPPER}} .rkit-list-headerinfo' => 'padding : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->start_controls_tabs('text-controls');

        $this->start_controls_tab('text-control-normal', ['label' => esc_html__('Normal', 'romethemekit-plugin')]);
        $this->add_control('headerinfo-text-color', [
            'label' => esc_html__('Text Color', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo-text' => 'color : {{VALUE}}',
            ],
        ]);

        $this->add_control('headerinfo-list-background', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-list-headerinfo' => 'background-color: {{VALUE}}'
            ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('text-control-hover', ['label' => esc_html__('Hover', 'romethemekit-plugin')]);
        $this->add_control('hover-text-color', [
            'label' => 'Text Color',
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo-text:hover' => 'color : {{VALUE}}',
            ],
        ]);
        $this->add_control('headerinfo-hover-background', [
            'label' => esc_html__('Background', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-list-headerinfo:hover' => 'background-color: {{VALUE}}'
            ],
        ]);

        $this->end_controls_tab();



        $this->end_controls_tabs();

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Icon', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control('headerinfo-iconsize', [
            'label' => esc_html__('Icon Size', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'devices' => ['desktop', 'tablet', 'mobile'],
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo-icon' => 'font-size: {{SIZE}}{{UNIT}}'
            ],
        ]);

        $this->add_control('icon-spacing', [
            'label' => esc_html__('Icon Spacing','romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'devices' => ['desktop', 'tablet', 'mobile'],
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => ['min' => 0, 'max' => 1000],
                '%' => ['min' => 0, 'max' => 100],
                'em' => ['min' => 0, 'max' => 50],
                'rem' => ['min' => 0, 'max' => 50],
            ],
            'default' => [
                'size' => 10,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-list-headerinfo' => 'gap: {{SIZE}}{{UNIT}}'
            ],
        ]);

        $this->add_control('icon-headerinfo-color', [
            'label' => esc_html__('Icon Color' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-headerinfo-icon' => 'color : {{VALUE}}',
            ],
        ]);

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="rkit-headerinfo">';
        foreach ($settings['rkit_headerinfo_group'] as $key => $setting) {
            if (!empty($setting['rkit_headerinfo_link']['url'])) {
                $this->add_link_attributes('button-' . $key, $setting['rkit_headerinfo_link']);
            }
?>
            <div class="rkit-list-headerinfo" style="display: flex; flex-direction:row ; align-items:center">
                <div class="rkit-headerinfo-icon">
        <?php Elementor\Icons_Manager::render_icon($setting['rkit_headerinfo_icons'], ['aria-hidden' => 'true']);
            echo '</div><a class="rkit-headerinfo-text" style="border-bottom: none ; text-align:center" ' . $this->get_render_attribute_string('button-' . $key) . '> ' . esc_html__($setting['rkit_headerinfo_text'],'romethemekit-plugin') . '</a>
                </div>';
        }
        echo '</div>';
    }
}
