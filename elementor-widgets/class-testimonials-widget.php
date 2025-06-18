<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) exit;

class MTC_Testimonials_Widget extends Widget_Base {

    public function get_name() {
        return 'mtc_testimonials';
    }

    public function get_title() {
        return 'NRD Testimonials';
    }

    public function get_icon() {
        return 'eicon-star';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
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
                'label' => __('Number of Testimonials', 'nrd-theme-companion'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'nrd-theme-companion'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label' => __('Content Background', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => __('Arrows Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('Dots Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'nrd-theme-companion'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style Tab
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
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .testimonial-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => __('Image Border', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .testimonial-image img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow',
                'label' => __('Image Shadow', 'nrd-theme-companion'),
                'selector' => '{{WRAPPER}} .testimonial-image img',
            ]
        );

        $this->add_control(
            'image_spacing',
            [
                'label' => __('Spacing', 'nrd-theme-companion'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query([
            'post_type' => 'testimonial',
            'posts_per_page' => $settings['post_count']
        ]);

       if ( $query->have_posts() ) {
		$widget_id = 'mtc-swiper-' . $this->get_id();
		?>
		<div class="mtc-testimonials-swiper swiper" id="<?php echo esc_attr( $widget_id ); ?>">
			<div class="swiper-wrapper">
				<?php
				while ( $query->have_posts() ) : $query->the_post();
					$image_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
					?>
					<div class="swiper-slide testimonial-item">
						<div class="testimonial-image">
							<img src="<?php echo esc_url( $image_url ?: 'https://via.placeholder.com/150' ); ?>"
							     alt="<?php the_title_attribute(); ?>">
						</div>

						<h3 class="testimonial-title"><?php the_title(); ?></h3>
						<div class="testimonial-content"><?php the_content(); ?></div>
					</div>
				<?php endwhile; ?>
			</div>

			<!-- controls that are unique **inside** this container -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-pagination"></div>
		</div>
		<?php
		wp_reset_postdata();
	} else {
		echo '<p>' . esc_html__( 'No testimonials found.', 'text-domain' ) . '</p>';
	}
    }

    public function get_script_depends() {
        return [ 'swiper', 'mtc-testimonials-swiper' ];
    }

    public function get_style_depends() {
        return [ 'swiper', 'mtc-testimonials-swiper' ];
    }
}