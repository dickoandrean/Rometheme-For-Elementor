<?php

class SiteLogo_Rometheme extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'site-logo';
    }

    public function get_title()
    {
        return 'RTM - Site Logo';
    }

    public function get_icon()
    {
        return 'eicon-header';
    }

    public function get_categories()
    {
        return ['romethemekit_header_footer'];
    }

    public function get_keywords()
    {
        return ['site', 'logo', 'rometheme'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('content-section', [
            'label' => esc_html__('Image' , 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => [],
                'include' => [],
                'default' => 'large',
            ]
        );


        $this->add_control(
            'website_link',
            [
                'label' => esc_html__('Link', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'romethemekit-plugin'),
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('style-setting', [
            'label' => esc_html__('Style Setting' , 'romethemekit-plugin'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__('Alignment', 'romethemekit-plugin'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'devices' => ['desktop' , 'tablet' , 'mobile'],
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'romethemekit-plugin'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rkit-image-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control('rkit-image-maxwidth' , [
            'label' => esc_html__('Max Width' , 'romethemekit-plugin'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px' , '%' , 'em' , 'rem'],
            'range' => [
                'px' => ['min' => 0 , 'max' => 1000 , 'step' => 1 ],
                '%' => ['min' => 0 , 'max' =>100],
                'em' => ['min' => 0 , 'max' => 50],
                'rem' => ['min' => 0 , 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .rkit-image > img' => 'max-width: {{SIZE}}{{UNIT}}'
            ] 
        ]);

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['website_link']['url'])) {
            $this->add_link_attributes('website_link', $settings['website_link']);
        }
?>
        <div class="rkit-image-container">
            <a class="rkit-image" <?php echo $this->get_render_attribute_string('website_link'); ?> style="text-decoration: none; border-bottom:none">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image'); ?>
            </a>
        </div>
<?php
    }
}
