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
    }

    protected function render() 
    {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query([
            'post_type' => 'testimonial',
            'posts_per_page' => $settings['post_count']
        ]);

        if ($query->have_posts()) {
            $widget_id = 'mtc-swiper-' . $this->get_id(); // Unique ID per widget
            ?>
            <div class="swiper mySwiper" id="<?php echo esc_attr($widget_id); ?>">
                <div class="swiper-wrapper">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        $name = get_post_meta(get_the_ID(), '_mtc_name', true);
                        $rating = intval(get_post_meta(get_the_ID(), '_mtc_rating', true));
                        $image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                        ?>
                        <div class="swiper-slide testimonial-item">
                            <?php if ($image): ?>
                                <div class="testimonial-image"><?php echo $image; ?></div>
                            <?php endif; ?>
                            <h3 class="testimonial-title"><?php the_title(); ?></h3>
                            <div class="testimonial-content"><?php the_content(); ?></div>
                            <?php if ($name): ?>
                                <p class="testimonial-name"><strong><?php echo esc_html($name); ?></strong></p>
                            <?php endif; ?>
                            <?php if ($rating): ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span style="color:<?php echo $i <= $rating ? '#facc15' : '#d1d5db'; ?>;">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <!-- Optional navigation -->
                <div class="swiper-pagination"></div>
            </div>

            <?php
            wp_reset_postdata();
        } else {
            echo '<p>No testimonials found.</p>';
        }
    }

}
