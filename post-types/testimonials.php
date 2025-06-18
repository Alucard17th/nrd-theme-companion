<?php

// Register Testimonial CPT
add_action('init', 'mtc_register_testimonials_cpt');
function mtc_register_testimonials_cpt() {
    $labels = [
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'menu_name'          => 'Testimonials',
        'name_admin_bar'     => 'Testimonial',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Testimonial',
        'new_item'           => 'New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'view_item'          => 'View Testimonial',
        'all_items'          => 'All Testimonials',
        'search_items'       => 'Search Testimonials',
        'not_found'          => 'No testimonials found.',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false,
        'show_in_rest'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'rewrite'            => ['slug' => 'testimonial'],
    ];

    register_post_type('testimonial', $args);
}

// Add Meta Boxes
add_action('add_meta_boxes', 'mtc_add_testimonial_meta_boxes');
function mtc_add_testimonial_meta_boxes() {
    add_meta_box('mtc_testimonial_meta', 'Testimonial Details', 'mtc_render_testimonial_meta_box', 'testimonial', 'normal', 'high');
}

// Render Meta Box
function mtc_render_testimonial_meta_box($post) {
    $name = get_post_meta($post->ID, '_mtc_name', true);
    $rating = get_post_meta($post->ID, '_mtc_rating', true);
    wp_nonce_field('mtc_save_testimonial_meta', 'mtc_testimonial_nonce');
    ?>
    <p>
        <label for="mtc_name">Owner Name:</label><br>
        <input type="text" name="mtc_name" id="mtc_name" value="<?php echo esc_attr($name); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="mtc_rating">Rating (1–5):</label><br>
        <select name="mtc_rating" id="mtc_rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <?php
}

// Save Meta Box Data
add_action('save_post', 'mtc_save_testimonial_meta');
function mtc_save_testimonial_meta($post_id) {
    if (!isset($_POST['mtc_testimonial_nonce']) || !wp_verify_nonce($_POST['mtc_testimonial_nonce'], 'mtc_save_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['mtc_name'])) {
        update_post_meta($post_id, '_mtc_name', sanitize_text_field($_POST['mtc_name']));
    }

    if (isset($_POST['mtc_rating'])) {
        update_post_meta($post_id, '_mtc_rating', (int) $_POST['mtc_rating']);
    }
}
