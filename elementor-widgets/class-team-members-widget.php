<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class MTC_Team_Widget extends Widget_Base {

    public function get_name() {
        return 'mtc_team';
    }

    public function get_title() {
        return 'NRD Team Members';
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_count',
            [
                'label' => __('Number of Team Members', 'nrd-theme-companion'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 24,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'nrd-theme-companion'),
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '1' => __('1 Column', 'nrd-theme-companion'),
                    '2' => __('2 Columns', 'nrd-theme-companion'),
                    '3' => __('3 Columns', 'nrd-theme-companion'),
                    '4' => __('4 Columns', 'nrd-theme-companion'),
                    '6' => __('6 Columns', 'nrd-theme-companion'),
                ],
            ]
        );

        $this->add_control(
            'show_position',
            [
                'label' => __('Show Position', 'nrd-theme-companion'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'nrd-theme-companion'),
                'label_off' => __('Hide', 'nrd-theme-companion'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_social',
            [
                'label' => __('Show Social Links', 'nrd-theme-companion'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'nrd-theme-companion'),
                'label_off' => __('Hide', 'nrd-theme-companion'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'nrd-theme-companion'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'nrd-theme-companion'),
                'label_off' => __('Hide', 'nrd-theme-companion'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Card Style Section
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'label' => __('Background', 'nrd-theme-companion'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .team-member-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => __('Border', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'label' => __('Box Shadow', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-card',
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label' => __('Padding', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_margin',
            [
                'label' => __('Margin', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => __('Content Alignment', 'nrd-theme-companion'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'nrd-theme-companion'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'nrd-theme-companion'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'nrd-theme-companion'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .team-member-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style Section
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __('Image Size', 'nrd-theme-companion'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'nrd-theme-companion'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => __('Image Border', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-image img',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow',
                'label' => __('Image Shadow', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-image img',
            ]
        );

        $this->add_control(
            'image_spacing',
            [
                'label' => __('Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style Section
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('Title Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Typography', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-name',
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => __('Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Position Style Section
        $this->start_controls_section(
            'position_style_section',
            [
                'label' => __('Position Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => __('Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => __('Typography', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-position',
            ]
        );

        $this->add_control(
            'position_spacing',
            [
                'label' => __('Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Excerpt Style Section
        $this->start_controls_section(
            'excerpt_style_section',
            [
                'label' => __('Excerpt Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => __('Typography', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-excerpt',
            ]
        );

        $this->add_control(
            'excerpt_spacing',
            [
                'label' => __('Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Social Icons Style Section
        $this->start_controls_section(
            'social_style_section',
            [
                'label' => __('Social Icons Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'social_icon_size',
            [
                'label' => __('Icon Size', 'nrd-theme-companion'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_padding',
            [
                'label' => __('Icon Padding', 'nrd-theme-companion'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_spacing',
            [
                'label' => __('Icon Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('social_icon_tabs');

        $this->start_controls_tab(
            'social_icon_normal',
            [
                'label' => __('Normal', 'nrd-theme-companion'),
            ]
        );

        $this->add_control(
            'social_icon_color',
            [
                'label' => __('Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_bg_color',
            [
                'label' => __('Background Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'social_icon_hover',
            [
                'label' => __('Hover', 'nrd-theme-companion'),
            ]
        );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label' => __('Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_bg_color',
            [
                'label' => __('Background Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_border_color',
            [
                'label' => __('Border Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'social_icon_border',
                'label' => __('Border', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .team-member-social a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'social_icon_border_radius',
            [
                'label' => __('Border Radius', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'social_icons_spacing',
            [
                'label' => __('Container Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query([
            'post_type' => 'team',
            'posts_per_page' => $settings['post_count'],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ]);

        if ($query->have_posts()) {
            echo '<div class="team-members-grid columns-' . esc_attr($settings['columns']) . '">';
            
            while ($query->have_posts()) : $query->the_post();
                $position = get_post_meta(get_the_ID(), '_mtc_position', true);
                $linkedin = get_post_meta(get_the_ID(), '_mtc_linkedin_url', true);
                $twitter = get_post_meta(get_the_ID(), '_mtc_twitter_url', true);
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                
                <div class="team-member-card">
                    <?php if ($image_url) : ?>
                        <div class="team-member-image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="team-member-content">
                        <h3 class="team-member-name"><?php the_title(); ?></h3>
                        
                        <?php if ($settings['show_position'] === 'yes' && $position) : ?>
                            <div class="team-member-position"><?php echo esc_html($position); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_excerpt'] === 'yes' && has_excerpt()) : ?>
                            <div class="team-member-excerpt"><?php the_excerpt(); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_social'] === 'yes' && ($linkedin || $twitter)) : ?>
                            <div class="team-member-social">
                                <?php if ($linkedin) : ?>
                                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($twitter) : ?>
                                    <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
            <?php endwhile;
            
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No team members found.</p>';
        }
    }
}