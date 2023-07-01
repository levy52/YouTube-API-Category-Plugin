<?php
/*
Plugin Name: YouTube API Category
Description: It retrieves the latest videos from a selected YouTube playlist and places them in the category description.
Version: 1.0
Author: Radosław Lewicki
Author URI: https://github.com/levy52
License: GPLv2 or later
*/

function youtube_settings_init() {
    register_setting(
        'youtube_settings',
        'youtube_api_key',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    add_settings_section(
        'youtube_settings_section',
        'YouTube API Settings',
        'youtube_settings_section_callback',
        'youtube-settings'
    );

    add_settings_field(
        'youtube_api_key_field',
        'API Key',
        'youtube_api_key_field_callback',
        'youtube-settings',
        'youtube_settings_section'
    );
}
add_action('admin_init', 'youtube_settings_init');

function youtube_settings_section_callback() {
    echo '<p>Enter your YouTube API key:</p>';
}

function youtube_api_key_field_callback() {
    echo '<input type="text" name="youtube_api_key" value="' . esc_attr(get_option('youtube_api_key', '')) . '" />';
}

function youtube_settings_page() {
    ?>
    <div class="wrap">
        <h1>YouTube API Settings</h1>
        <p>Use the following shortcode in your category description to display the YouTube playlist:</p>
        <code>[youtube_playlist playlist_id="YOUR_PLAYLIST_ID" max_results="3"] -- default max_results is 3.</code>
        <p>Replace <code>YOUR_PLAYLIST_ID</code> with the actual playlist ID you want to display.</p>
        <p>Insert your shortcode in the category description. Ready!</p>
        <p>For more information, visit the <a href="https://github.com/levy52" target="_blank">GitHub repository</a>.</p>
        <form method="post" action="options.php">
            <?php
            settings_fields('youtube_settings');
            do_settings_sections('youtube-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function custom_settings_page() {
    add_options_page(
        'YouTube API Settings',
        'YouTube API Settings',
        'manage_options',
        'youtube-settings',
        'youtube_settings_page'
    );
}
add_action('admin_menu', 'custom_settings_page');

function youtube_playlist_shortcode($atts) {
    $a = shortcode_atts( array(
        'max_results' => '',
        'playlist_id' => '',
        'api_key' => get_option('youtube_api_key', ''),
    ), $atts );

    $maxResults = $a['max_results'];
    $playlistId = $a['playlist_id'];
    $API_KEY = $a['api_key'];

    $apiError = 'Video not found!';

    try {
        $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$maxResults.'&playlistId='.$playlistId.'&key='.$API_KEY);
        if($apiData) {
            $videoList = json_decode($apiData);
        } else {
            throw new Exception('Invalid API key or playlist ID.');
        }
    } catch(Exception $e) {
        $apiError = $e->getMessage();
    }
    
    $output = '';
    $output .= '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'css/style.css', __FILE__ ) . '" />';

    if (!empty($videoList->items)) {
        $output .= '<div class="container youtube-videos-container">';
        $output .= '<div class="row">';
        
        foreach ($videoList->items as $item) {
            if (isset($item->snippet->resourceId->videoId)) {
                $output .= '<div class="video-wrapper col-12 col-md-4 col-lg-4">';
                $output .= '<iframe width="100%" height="250px" src="https://www.youtube.com/embed/'.$item->snippet->resourceId->videoId.'" frameborder="0" allowfullscreen></iframe>';
                $output .= '<h4>'.$item->snippet->title.'</h4>';
                $output .= '</div>';
            }
        }
        
        $output .= '</div>';
        $output .= '</div>';
    } else {
        $output .= '<p class="error">'. $apiError .'</p>';
    }
    
    return $output;
}
add_shortcode('youtube_playlist', 'youtube_playlist_shortcode');

