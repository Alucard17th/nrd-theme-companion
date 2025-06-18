<?php
/**
 * Register “Team” Custom Post Type + simple meta-box
 * Pattern matches the Project CPT scaffold.
 */

// -----------------------------------------------------------------------------
// Register Team CPT
// -----------------------------------------------------------------------------
add_action( 'init', 'mtc_register_team_cpt' );
function mtc_register_team_cpt() {
    $labels = [
        'name'               => 'Team Members',
        'singular_name'      => 'Team Member',
        'menu_name'          => 'Team',
        'name_admin_bar'     => 'Team Member',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Team Member',
        'new_item'           => 'New Team Member',
        'edit_item'          => 'Edit Team Member',
        'view_item'          => 'View Team Member',
        'all_items'          => 'All Team Members',
        'search_items'       => 'Search Team Members',
        'not_found'          => 'No team members found.',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false,
        'show_in_rest'       => true,
        'menu_position'      => 22, // Just below Projects
        'menu_icon'          => 'dashicons-groups',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'rewrite'            => [ 'slug' => 'team-member' ],
    ];

    register_post_type( 'team', $args );
}

// -----------------------------------------------------------------------------
// Meta-box: Team Member Details (Position + Social Links)
// -----------------------------------------------------------------------------
add_action( 'add_meta_boxes', 'mtc_add_team_meta_boxes' );
function mtc_add_team_meta_boxes() {
    add_meta_box( 'mtc_team_meta', 'Team Member Details', 'mtc_render_team_meta_box', 'team', 'normal', 'high' );
}

function mtc_render_team_meta_box( $post ) {
    $position = get_post_meta( $post->ID, '_mtc_position', true );
    $linkedin_url = get_post_meta( $post->ID, '_mtc_linkedin_url', true );
    $twitter_url = get_post_meta( $post->ID, '_mtc_twitter_url', true );

    wp_nonce_field( 'mtc_save_team_meta', 'mtc_team_nonce' );
    ?>
    <p>
        <label for="mtc_position"><strong>Position/Role:</strong></label><br>
        <input type="text" name="mtc_position" id="mtc_position" value="<?php echo esc_attr( $position ); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="mtc_linkedin_url"><strong>LinkedIn URL:</strong></label><br>
        <input type="url" name="mtc_linkedin_url" id="mtc_linkedin_url" value="<?php echo esc_url( $linkedin_url ); ?>" style="width:100%;" placeholder="https://linkedin.com/in/username" />
    </p>
    <p>
        <label for="mtc_twitter_url"><strong>Twitter URL:</strong></label><br>
        <input type="url" name="mtc_twitter_url" id="mtc_twitter_url" value="<?php echo esc_url( $twitter_url ); ?>" style="width:100%;" placeholder="https://twitter.com/username" />
    </p>
    <?php
}

// -----------------------------------------------------------------------------
// Save Meta-box
// -----------------------------------------------------------------------------
add_action( 'save_post', 'mtc_save_team_meta' );
function mtc_save_team_meta( $post_id ) {
    if ( ! isset( $_POST['mtc_team_nonce'] ) || ! wp_verify_nonce( $_POST['mtc_team_nonce'], 'mtc_save_team_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Position
    if ( isset( $_POST['mtc_position'] ) ) {
        update_post_meta( $post_id, '_mtc_position', sanitize_text_field( $_POST['mtc_position'] ) );
    }

    // LinkedIn URL
    if ( isset( $_POST['mtc_linkedin_url'] ) ) {
        update_post_meta( $post_id, '_mtc_linkedin_url', esc_url_raw( $_POST['mtc_linkedin_url'] ) );
    }

    // Twitter URL
    if ( isset( $_POST['mtc_twitter_url'] ) ) {
        update_post_meta( $post_id, '_mtc_twitter_url', esc_url_raw( $_POST['mtc_twitter_url'] ) );
    }
}