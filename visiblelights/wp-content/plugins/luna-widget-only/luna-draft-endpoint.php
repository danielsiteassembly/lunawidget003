<?php
/**
 * Luna Draft Creation Endpoint
 * 
 * Adds a custom REST API endpoint for Luna to create WordPress draft posts
 * Part of the Luna Widget Only plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Luna draft creation endpoint
 */
add_action('rest_api_init', function () {
    register_rest_route('luna_widget/v1', '/create-draft', array(
        'methods' => 'POST',
        'permission_callback' => function () {
            // Check if user is logged in and can edit posts
            return is_user_logged_in() && current_user_can('edit_posts');
        },
        'callback' => function (WP_REST_Request $request) {
            try {
                $title = sanitize_text_field($request->get_param('title'));
                $content = wp_kses_post($request->get_param('content'));
                $categories = $request->get_param('categories') ?: array();
                $tags = $request->get_param('tags') ?: array();
                
                if (empty($title)) {
                    return new WP_REST_Response(array(
                        'error' => 'Title is required'
                    ), 400);
                }
                
                if (empty($content)) {
                    return new WP_REST_Response(array(
                        'error' => 'Content is required'
                    ), 400);
                }
                
                // Prepare post data
                $post_data = array(
                    'post_title' => $title,
                    'post_content' => $content,
                    'post_status' => 'draft',
                    'post_type' => 'post',
                    'post_author' => get_current_user_id(),
                );
                
                // Create the post
                $post_id = wp_insert_post($post_data);
                
                if (is_wp_error($post_id)) {
                    return new WP_REST_Response(array(
                        'error' => 'Failed to create post: ' . $post_id->get_error_message()
                    ), 500);
                }
                
                // Handle categories
                if (!empty($categories) && is_array($categories)) {
                    $category_ids = array();
                    foreach ($categories as $category_name) {
                        $category = get_category_by_slug(sanitize_title($category_name));
                        if ($category) {
                            $category_ids[] = $category->term_id;
                        } else {
                            // Create category if it doesn't exist
                            $new_category = wp_insert_category(array(
                                'cat_name' => $category_name,
                                'category_nicename' => sanitize_title($category_name)
                            ));
                            if (!is_wp_error($new_category)) {
                                $category_ids[] = $new_category;
                            }
                        }
                    }
                    if (!empty($category_ids)) {
                        wp_set_post_categories($post_id, $category_ids);
                    }
                }
                
                // Handle tags
                if (!empty($tags) && is_array($tags)) {
                    $tag_ids = array();
                    foreach ($tags as $tag_name) {
                        $tag = get_term_by('name', $tag_name, 'post_tag');
                        if ($tag) {
                            $tag_ids[] = $tag->term_id;
                        } else {
                            // Create tag if it doesn't exist
                            $new_tag = wp_insert_term($tag_name, 'post_tag');
                            if (!is_wp_error($new_tag)) {
                                $tag_ids[] = $new_tag['term_id'];
                            }
                        }
                    }
                    if (!empty($tag_ids)) {
                        wp_set_post_tags($post_id, $tag_ids);
                    }
                }
                
                // Get the created post data
                $post = get_post($post_id);
                $edit_link = get_edit_post_link($post_id);
                $view_link = get_permalink($post_id);
                
                return new WP_REST_Response(array(
                    'id' => $post_id,
                    'title' => $post->post_title,
                    'status' => $post->post_status,
                    'link' => $edit_link,
                    'view_link' => $view_link,
                    'message' => 'Draft post created successfully'
                ), 200);
                
            } catch (Exception $e) {
                return new WP_REST_Response(array(
                    'error' => 'Server error: ' . $e->getMessage()
                ), 500);
            }
        }
    ));
});

/**
 * Add CORS headers for the Luna endpoint
 */
add_action('rest_api_init', function () {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function ($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-WP-Nonce');
        return $value;
    });
});