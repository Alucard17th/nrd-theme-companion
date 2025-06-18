<?php
/**
 * Register “Project” Custom Post Type + simple meta‑box
 * Pattern matches the earlier Testimonial CPT scaffold.
 */

// -----------------------------------------------------------------------------
// Register Project CPT
// -----------------------------------------------------------------------------
add_action( 'init', 'mtc_register_projects_cpt' );
function mtc_register_projects_cpt() {
	$labels = [
		'name'               => 'Projects',
		'singular_name'      => 'Project',
		'menu_name'          => 'Projects',
		'name_admin_bar'     => 'Project',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Project',
		'new_item'           => 'New Project',
		'edit_item'          => 'Edit Project',
		'view_item'          => 'View Project',
		'all_items'          => 'All Projects',
		'search_items'       => 'Search Projects',
		'not_found'          => 'No projects found.',
	];

	$args = [
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => false,
		'show_in_rest'       => true,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'rewrite'            => [ 'slug' => 'project' ],
	];

	register_post_type( 'project', $args );
}

// -----------------------------------------------------------------------------
// Meta‑box: Project Details (Client + URL)
// -----------------------------------------------------------------------------
add_action( 'add_meta_boxes', 'mtc_add_project_meta_boxes' );
function mtc_add_project_meta_boxes() {
	add_meta_box( 'mtc_project_meta', 'Project Details', 'mtc_render_project_meta_box', 'project', 'normal', 'high' );
}

function mtc_render_project_meta_box( $post ) {
	$client_name = get_post_meta( $post->ID, '_mtc_client_name', true );
	$project_url = get_post_meta( $post->ID, '_mtc_project_url', true );

	wp_nonce_field( 'mtc_save_project_meta', 'mtc_project_nonce' );
	?>
	<p>
		<label for="mtc_client_name"><strong>Client Name:</strong></label><br>
		<input type="text" name="mtc_client_name" id="mtc_client_name" value="<?php echo esc_attr( $client_name ); ?>" style="width:100%;" />
	</p>
	<p>
		<label for="mtc_project_url"><strong>Project URL:</strong></label><br>
		<input type="url" name="mtc_project_url" id="mtc_project_url" value="<?php echo esc_url( $project_url ); ?>" style="width:100%;" placeholder="https://example.com" />
	</p>
	<?php
}

// -----------------------------------------------------------------------------
// Save Meta‑box
// -----------------------------------------------------------------------------
add_action( 'save_post', 'mtc_save_project_meta' );
function mtc_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['mtc_project_nonce'] ) || ! wp_verify_nonce( $_POST['mtc_project_nonce'], 'mtc_save_project_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Client Name
	if ( isset( $_POST['mtc_client_name'] ) ) {
		update_post_meta( $post_id, '_mtc_client_name', sanitize_text_field( $_POST['mtc_client_name'] ) );
	}

	// Project URL
	if ( isset( $_POST['mtc_project_url'] ) ) {
		update_post_meta( $post_id, '_mtc_project_url', esc_url_raw( $_POST['mtc_project_url'] ) );
	}
}
