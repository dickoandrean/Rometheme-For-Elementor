<?php

use Elementor\Conditions;

class Search_Rometheme extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'search';
    }

    public function get_title()
    {
        return 'RTM - Search';
    }

    public function get_icon()
    {
        return 'eicon-search';
    }

    public function get_categories()
    {
        return ['romethemekit_header_footer'];
    }

    public function get_style_depends()
    {
        return ['rkit-search-style'];
    }

    public function get_keywords()
    {
        return ['search', 'rometheme'];
    }

    public function register_controls()
    {
        $this->start_controls_section('search_setting', [
            'label' => esc_html__('Search Setting' , 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('search_icon', [
            'label' => esc_html__('Search Icon' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-search',
                'library' => 'fa-solid'
            ],
        ]);

        $this->add_control('search-position', [
            'label' => esc_html__('Search Button Position' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'start' => 'Start',
                'end' => 'End',
            ],
            'default' => 'end',
        ]);

        $this->end_controls_section();
        $this->start_controls_section('search-style', [
            'label' => esc_html__('Search Style Setting', 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(\Elementor\Group_Control_Border::get_type(), [
            'name' => 'Border',
            'selector' => '{{WRAPPER}} .rkit-search',
        ]);

        $this->add_control('search-borderradius', [
            'label' => esc_html__('Border Radius' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('button-background', [
            'label' => esc_html__('Button Background' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-search-button' => 'background-color : {{VALUE}}'
            ],
        ]);

        $this->add_control('searchicon-color', [
            'type' => \Elementor\Controls_Manager::COLOR,
            'label' => esc_html__('Icon Color' , 'romethemekit-plugin'),
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .rkit-search-button' => 'color : {{VALUE}}',
            ]
        ]);

        $this->add_responsive_control('searchicon-padding', [
            'label' => esc_html__('Icon Padding', 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-search-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_responsive_control('searchinput-padding', [
            'label' => esc_html__('Input Padding' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_responsive_control('searchicon-margin', [
            'label' => esc_html__('Icon Margin' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rkit-search-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->end_controls_section();


        $this->start_controls_section('search-input-setting', [
            'label' => esc_html__('Search Input Setting' , 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->start_controls_tabs('search-setting');
        $this->start_controls_tab('input-style', [
            'label' => esc_html__('Input' , 'romethemekit-plugin')
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .rkit-search-input',
            ]
        );

        $this->add_control('input-text-color', [
            'label' => esc_html__('Text Color' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .rkit-search-input' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_control('input-bgcolor', [
            'label' => esc_html__('Background Color' ,  'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ECECEC',
            'selectors' => [
                '{{WRAPPER}} .rkit-search-input' => 'background-color: {{VALUE}}'
            ]
        ]);

        $this->end_controls_tab();
        $this->start_controls_tab('placeholder-search-setting', [
            'label' => esc_html__('Placeholder' , 'romethemekit-plugin')
        ]);

        $this->add_control('input-placeholder', [
            'label' => esc_html__('Placeholder' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Search',
            'placeholder' => 'Type your Input Placeholder Here'
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'placeholder_typography',
                'selector' => '{{WRAPPER}} .rkit-search-input::placeholder',
            ]
        );

        $this->add_control('placeholder-color', [
            'label' => esc_html__('Placeholder Color' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#b0b0b0',
            'selectors' => [
                '{{WRAPPER}} .rkit-search-input::placeholder' => 'color:{{VALUE}}'
            ]
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('input-focus', ['label' => 'Focus']);

        $this->add_responsive_control('input-focus-bg', [
            'label' => esc_html__('Background' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rkit-search-input:focus' => 'background-color:{{VALUE}}'
            ]
        ]);
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => esc_html__('box-shadow-focus' , 'romethemekit-plugin'),
                'selector' => '{{WRAPPER}} .rkit-search-input:focus',
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
        <form action="<?php echo esc_url(get_home_url()) ?>" method="get">
            <div class="rkit-search" style="display: flex; flex-direction: <?php echo ($settings['search-position'] === 'end') ? 'row' : 'row-reverse'; ?> ; width:auto;">
                <input class="rkit-search-input" style="width:100% ; border:none ; border-radius:0px" type="text" name="s" id="s" placeholder="<?php echo esc_attr__($settings['input-placeholder'] , 'romethemekit-plugin' ); ?>">
                <button style="border: none; border-radius:0px;" class="rkit-search-button" type="submit"><?php \Elementor\Icons_Manager::render_icon($settings['search_icon'], ['aria-hidden' => 'true']); ?></button>
            </div>
        </form>
<?php
    }
}
