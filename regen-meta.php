<?php

require_once('wp-load.php');

if ( ! function_exists( 'wp_crop_image' ) ) {
    include( ABSPATH . 'wp-admin/includes/image.php' );
}

$attachments = get_posts(
[
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'fields' => 'ids',
    'meta_query' => [
        [
            'key' => '_wp_attachment_metadata',
            'compare' => 'NOT EXISTS'
        ]
    ]
]
);

foreach($attachments as $attachment_id)
{

    $url = get_attached_file($attachment_id);

    if (strpos($url, '.svg') !== false) continue;

    $attach_data = wp_generate_attachment_metadata($attachment_id, $url);
    wp_update_attachment_metadata( $attachment_id,  $attach_data );

}
