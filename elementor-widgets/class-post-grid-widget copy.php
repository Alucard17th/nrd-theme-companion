<?php
/**
 * Elementor Widget: NRD Post Grid (refactored)
 * - Works with Elementor 3.26+ (new Scheme namespace)
 * - True CSS‑grid columns
 * - Correct image-size helper
 * - No noisy preview template
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MTC_Post_Grid_Widget extends Widget_Base {

	/* --------------------------------------------------------------------- */
	/*  Basic Info                                                            */
	/* --------------------------------------------------------------------- */

	public function get_name() {
		return 'mtc_post_grid';
	}

	public function get_title() {
		return __( 'NRD Post Grid', 'nrd-theme-companion' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	/* --------------------------------------------------------------------- */
	/*  Controls                                                              */
	/* --------------------------------------------------------------------- */

	protected function register_controls() {

		/* ---------------------- Content ------------------------------------ */
		$this->start_controls_section( 'content_section', [
			'label' => __( 'Content', 'nrd-theme-companion' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		// All public CPTs.
		$post_types        = get_post_types( [ 'public' => true ], 'objects' );
		$post_type_options = [];
		foreach ( $post_types as $pt ) {
			$post_type_options[ $pt->name ] = $pt->label;
		}

		$this->add_control( 'post_type', [
			'label'   => __( 'Post Type', 'nrd-theme-companion' ),
			'type'    => Controls_Manager::SELECT,
			'options' => $post_type_options,
			'default' => 'post',
		] );

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

		// ----- Switches & toggles ----- //
		$this->add_control( 'show_image', [
			'label'        => __( 'Show Featured Image', 'nrd-theme-companion' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'nrd-theme-companion' ),
			'label_off'    => __( 'Hide', 'nrd-theme-companion' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'exclude'   => [ 'custom' ],
            'include'   => [],
			'default'   => 'medium',
			'condition' => [ 'show_image' => 'yes' ],
		] );

		$this->add_control( 'show_title', [
			'label'        => __( 'Show Title', 'nrd-theme-companion' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'nrd-theme-companion' ),
			'label_off'    => __( 'Hide', 'nrd-theme-companion' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'title_tag', [
			'label'      => __( 'Title HTML Tag', 'nrd-theme-companion' ),
			'type'       => Controls_Manager::SELECT,
			'options'    => array_combine( [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ], [ 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'div', 'span', 'p' ] ),
			'default'    => 'h3',
			'condition'  => [ 'show_title' => 'yes' ],
		] );

		$this->add_control( 'show_excerpt', [
			'label'        => __( 'Show Excerpt', 'nrd-theme-companion' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'nrd-theme-companion' ),
			'label_off'    => __( 'Hide', 'nrd-theme-companion' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'excerpt_length', [
			'label'     => __( 'Excerpt Length', 'nrd-theme-companion' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 20,
			'condition' => [ 'show_excerpt' => 'yes' ],
		] );

		$this->add_control( 'show_read_more', [
			'label'        => __( 'Show Read More', 'nrd-theme-companion' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'nrd-theme-companion' ),
			'label_off'    => __( 'Hide', 'nrd-theme-companion' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'read_more_text', [
			'label'     => __( 'Read More Text', 'nrd-theme-companion' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Read More', 'nrd-theme-companion' ),
			'condition' => [ 'show_read_more' => 'yes' ],
		] );

		$this->add_control( 'show_date', [
			'label'        => __( 'Show Date', 'nrd-theme-companion' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'nrd-theme-companion' ),
			'label_off'    => __( 'Hide', 'nrd-theme-companion' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'date_format', [
			'label'     => __( 'Date Format', 'nrd-theme-companion' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'F j, Y',
			'condition' => [ 'show_date' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------------------- Grid Layout -------------------------------- */
		$this->start_controls_section( 'grid_section', [
			'label' => __( 'Grid Layout', 'nrd-theme-companion' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'columns', [
			'label'           => __( 'Columns', 'nrd-theme-companion' ),
			'type'            => Controls_Manager::SELECT,
			'options'         => array_combine( range( 1, 6 ), range( 1, 6 ) ),
			'default'         => '3',
			'tablet_default'  => '2',
			'mobile_default'  => '1',
			'selectors'       => [
				'{{WRAPPER}} .mtc-post-grid' => 'display:grid;grid-template-columns:repeat({{VALUE}},1fr);',
			],
		] );

		$this->add_control( 'gap', [
			'label'     => __( 'Gap Between Items', 'nrd-theme-companion' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'   => [ 'size' => 30 ],
			'selectors' => [ '{{WRAPPER}} .mtc-post-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* ---------------------- Style Section ------------------------------ */
		// (All other style controls remain unchanged – copy from original file)
		// --------------------------------------------------------------
	}

	/* --------------------------------------------------------------------- */
	/*  Front‑end Output                                                     */
	/* --------------------------------------------------------------------- */

	protected function render() {
		$settings = $this->get_settings_for_display();

		$query_args = [
			'post_type'      => $settings['post_type'],
			'posts_per_page' => $settings['posts_per_page'],
			'orderby'        => $settings['orderby'],
			'order'          => strtoupper( $settings['order'] ),
		];

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {

			$columns       = isset( $settings['columns'] ) ? (int) $settings['columns'] : 3;
			$columns_class = 'mtc-columns-' . $columns;
			?>
			<div class="mtc-post-grid <?php echo esc_attr( $columns_class ); ?>">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
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
							<?php if ( 'yes' === $settings['show_title'] ) : ?>
								<<?php echo tag_escape( $settings['title_tag'] ); ?> class="mtc-post-grid-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</<?php echo tag_escape( $settings['title_tag'] ); ?>>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_date'] ) : ?>
								<div class="mtc-post-grid-date"><?php echo esc_html( get_the_date( $settings['date_format'] ) ); ?></div>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
								<div class="mtc-post-grid-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '...' ) ); ?></div>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_read_more'] ) : ?>
								<a href="<?php the_permalink(); ?>" class="mtc-post-grid-read-more"><?php echo esc_html( $settings['read_more_text'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<?php
			wp_reset_postdata();
		} else {
			echo '<p>' . esc_html__( 'No posts found.', 'nrd-theme-companion' ) . '</p>';
		}
	}

	/* We intentionally leave _content_template() empty to avoid JS errors in
	   the live preview – Elementor will fall back to dummy markup. */

	protected function _content_template() {}
}
