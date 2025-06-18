<?php
/**
 * Elementor Widget: NRD Post Grid – fully responsive controls (v1.2)
 * ✔ Elementor 3.26+ compatible  ✔ CSS‑Grid  ✔ Fallback thumbnails
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color      as Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class MTC_Post_Grid_Widget extends Widget_Base {

	public function get_name()        { return 'mtc_post_grid'; }
	public function get_title()       { return __( 'NRD Post Grid', 'nrd-theme-companion' ); }
	public function get_icon()        { return 'eicon-posts-grid'; }
	public function get_categories()  { return [ 'general' ]; }

	/* ------------------------------------------------------------------ */
	/*  Controls (now responsive)                                         */
	/* ------------------------------------------------------------------ */

	protected function register_controls() {

		/* ---------- Content ----------- */
		$this->start_controls_section( 'content_section', [
			'label' => __( 'Content', 'nrd-theme-companion' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$post_type_opts = wp_list_pluck( get_post_types( [ 'public' => true ], 'objects' ), 'label', 'name' );
		$this->add_control( 'post_type', [
			'label'   => __( 'Post Type', 'nrd-theme-companion' ),
			'type'    => Controls_Manager::SELECT,
			'options' => $post_type_opts,
			'default' => 'post',
		] );

		// posts_per_page rarely needs per‑device variation, keep single value
		$this->add_control( 'posts_per_page', [
			'label'   => __( 'Number of Posts', 'nrd-theme-companion' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 6,
			'min'     => 1,
			'max'     => 50,
		] );

		$this->add_control( 'orderby', [
			'label'   => __( 'Order By', 'nrd-theme-companion' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'date'          => __( 'Date', 'nrd-theme-companion' ),
				'title'         => __( 'Title', 'nrd-theme-companion' ),
				'rand'          => __( 'Random', 'nrd-theme-companion' ),
				'menu_order'    => __( 'Menu Order', 'nrd-theme-companion' ),
				'modified'      => __( 'Last Modified', 'nrd-theme-companion' ),
				'comment_count' => __( 'Comment Count', 'nrd-theme-companion' ),
			],
			'default' => 'date',
		] );

		$this->add_control( 'order', [
			'label'   => __( 'Order', 'nrd-theme-companion' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [ 'asc' => __( 'Ascending', 'nrd-theme-companion' ), 'desc' => __( 'Descending', 'nrd-theme-companion' ) ],
			'default' => 'desc',
		] );

		/* --- Visibility toggles – responsive --- */
		foreach ( [ 'show_image' => __( 'Show Featured Image', 'nrd' ),
			'show_title'   => __( 'Show Title', 'nrd' ),
			'show_excerpt' => __( 'Show Excerpt', 'nrd' ),
			'show_read_more' => __( 'Show Read More', 'nrd' ),
			'show_date'    => __( 'Show Date', 'nrd' ),
		] as $key => $label ) {
			$this->add_responsive_control( $key, [
				'label'          => $label,
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => __( 'Show', 'nrd' ),
				'label_off'      => __( 'Hide', 'nrd' ),
				'return_value'   => 'yes',
				'default'        => 'yes',
			] );
		}

		// Image size (prefix: img) – not device‑specific as Elementor handles srcset
		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'img',
			'exclude'   => [ 'custom' ],
			'default'   => 'medium',
			'condition' => [ 'show_image' => 'yes' ],
		] );

		// Title tag
		$this->add_responsive_control( 'title_tag', [
			'label'   => __( 'Title HTML Tag', 'nrd' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array_combine( [ 'h1','h2','h3','h4','h5','h6','div','span','p' ], [ 'H1','H2','H3','H4','H5','H6','div','span','p' ] ),
			'default' => 'h3',
			'condition' => [ 'show_title' => 'yes' ],
		] );

		$this->add_control( 'excerpt_length', [
			'label'     => __( 'Excerpt Length', 'nrd' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 20,
			'condition' => [ 'show_excerpt' => 'yes' ],
		] );

		$this->add_control( 'read_more_text', [
			'label'     => __( 'Read More Text', 'nrd' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Read More', 'nrd-theme-companion' ),
			'condition' => [ 'show_read_more' => 'yes' ],
		] );

		$this->add_control( 'date_format', [
			'label'     => __( 'Date Format', 'nrd' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'F j, Y',
			'condition' => [ 'show_date' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- Grid Layout -------- */
		$this->start_controls_section( 'grid_section', [
			'label' => __( 'Grid Layout', 'nrd' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'columns', [
			'label'     => __( 'Columns', 'nrd' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => array_combine( range(1,6), range(1,6) ),
			'default'   => '3',
			'selectors' => [ '{{WRAPPER}} .mtc-post-grid' => 'display:grid;grid-template-columns:repeat({{VALUE}},1fr);' ],
		] );

		$this->add_responsive_control( 'gap', [
			'label'     => __( 'Gap', 'nrd' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 30 ],
			'selectors' => [ '{{WRAPPER}} .mtc-post-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/*  Render                                                            */
	/* ------------------------------------------------------------------ */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$query = new WP_Query( [
			'post_type'      => $settings['post_type'],
			'posts_per_page' => $settings['posts_per_page'],
			'orderby'        => $settings['orderby'],
			'order'          => strtoupper( $settings['order'] ),
		] );

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'nrd' ) . '</p>';
			return;
		}

		echo '<div class="mtc-post-grid">';

		while ( $query->have_posts() ) : $query->the_post();
			?>
            <div class="mtc-post-grid-item">
                <?php if ('yes' === $settings['show_image'] && has_post_thumbnail()) : ?>
                <div class="mtc-post-grid-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        // Get the thumbnail ID
                        $thumbnail_id = get_post_thumbnail_id();
                        
                        // First try Elementor's method with proper error handling
                        $image_html = '';
                        if (!empty($settings['thumbnail_size'])) {
                            $image_html = Group_Control_Image_Size::get_attachment_image_html([
                                'thumbnail' => [
                                    'id' => $thumbnail_id,
                                    'size' => $settings['thumbnail_size'],
                                    'image' => wp_get_attachment_image_src($thumbnail_id, $settings['thumbnail_size'])[0] ?? '',
                                ]
                            ], 'thumbnail', 'thumbnail');
                        }
                        
                        // Fallback to WordPress default if Elementor method fails
                        if (empty($image_html)) {
                            $image_html = wp_get_attachment_image(
                                $thumbnail_id,
                                $settings['thumbnail_size'] ?? 'medium',
                                false,
                                ['class' => 'mtc-post-grid-img']
                            );
                        }
                        
                        echo $image_html;
                        ?>
                    </a>
                </div>
                <?php endif; ?>

                <div class="mtc-post-grid-content">
                    <?php if ( $this->is_visible( $settings, 'show_title' ) ) : ?>
                    <<?php echo tag_escape( $settings['title_tag'] ); ?> class="mtc-post-grid-title"><a
                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </<?php echo tag_escape( $settings['title_tag'] ); ?>>
                    <?php endif; ?>

                    <?php if ( $this->is_visible( $settings, 'show_date' ) ) : ?>
                    <div class="mtc-post-grid-date"><?php echo esc_html( get_the_date( $settings['date_format'] ) ); ?></div>
                    <?php endif; ?>

                    <?php if ( $this->is_visible( $settings, 'show_excerpt' ) ) : ?>
                    <div class="mtc-post-grid-excerpt">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '...' ) ); ?></div>
                    <?php endif; ?>

                    <?php if ( $this->is_visible( $settings, 'show_read_more' ) ) : ?>
                    <a href="<?php the_permalink(); ?>"
                        class="mtc-post-grid-read-more"><?php echo esc_html( $settings['read_more_text'] ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
		endwhile;

		echo '</div>';
		wp_reset_postdata();
	}

	/* Helper – picks the right visibility flag for current breakpoint */
	private function is_visible( $settings, $key ) {
		// Elementor stores responsive values as array; fall back to desktop.
		$value = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
		if ( is_array( $value ) ) {
			$current = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoint_key();
			$value   = $value[ $current ] ?? $value['desktop'] ?? 'yes';
		}
		return 'yes' === $value || 'true' === $value;
	}

	protected function _content_template() {}
}