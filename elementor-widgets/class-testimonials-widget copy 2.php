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
                <div class="swiper mySwiper" id="<?php echo esc_attr( $widget_id ); ?>">
                    <div class="swiper-wrapper">
                        <?php while ( $query->have_posts() ) : $query->the_post(); 
                            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        ?>
                            <div class="swiper-slide testimonial-item">
                                <?php if ($image_url): ?>
                                    <div class="testimonial-image">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="testimonial-image">
                                        <img src="https://via.placeholder.com/150" alt="Placeholder Image">
                                    </div>
                                <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                <div><?php the_content(); ?></div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination"></div>
                </div>

        <?php
            wp_reset_postdata();
        } else {
            echo '<p>No testimonials found.</p>';
        }
    }

}