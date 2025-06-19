<?php
/**
 * Plugin Name: Nrd Theme Companion
 * Description: Adds extra features like Testimonials for Nrd Premium Theme.
 * Version: 1.0
 * Author: Noureddine Eddallal
 * Text Domain: nrd-theme-companion
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register Custom Post Type
require_once plugin_dir_path( __FILE__ ) . 'post-types/testimonials.php';
require_once plugin_dir_path( __FILE__ ) . 'post-types/projects.php';
require_once plugin_dir_path( __FILE__ ) . 'post-types/teams.php';

// Enqueue plugin styles
add_action('wp_enqueue_scripts', 'mtc_enqueue_plugin_styles');
function mtc_enqueue_plugin_styles() {
        wp_register_script(
		'mtc-testimonials-swiper',
		plugin_dir_url( __FILE__ ) . 'assets/js/testimonials.js',
		// [ 'elementor-frontend', 'swiper' ], // dependencies!
		'1.0.0',
		true
	);

        wp_enqueue_style(
            'mtc-testimonials-style',
            plugin_dir_url(__FILE__) . 'assets/css/testimonials.css',
            [],
            '1.0.0'
        );

        wp_enqueue_style(
            'mtc-team-style',
            plugin_dir_url(__FILE__) . 'assets/css/team.css',
            [],
            '1.0.0'
        );

        wp_enqueue_style(
            'mtc-form-style',
            plugin_dir_url(__FILE__) . 'assets/css/form.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'splide-js',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js',
            [],
            '11.0.0',
            true
        );

        wp_enqueue_style(
            'splide-css',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css',
            [],
            '11.0.0'
        );
}

// Load Elementor widget only if Elementor is active
add_action('elementor/widgets/widgets_registered', 'mtc_register_elementor_widgets');
function mtc_register_elementor_widgets($widgets_manager) {
    if (defined('ELEMENTOR_PATH')) {
        require_once plugin_dir_path(__FILE__) . 'elementor-widgets/class-testimonials-widget.php';
        $widgets_manager->register(new MTC_Testimonials_Widget());
        require_once plugin_dir_path(__FILE__) . 'elementor-widgets/class-post-grid-widget.php';
        $widgets_manager->register(new MTC_Post_Grid_Widget());
        require_once plugin_dir_path(__FILE__) . 'elementor-widgets/class-team-members-widget.php';
        $widgets_manager->register(new MTC_Team_Widget());
    }
}
