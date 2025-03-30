<?php

function fetch_github_text($atts)
{
    $atts = shortcode_atts(
        array(
            'url' =>
                'https://raw.githubusercontent.com/Azzamean/remote-github-text/refs/heads/main/text.html' // USE THE RAW LINK ONLY
        ),
        $atts,
        'github_text'
    );

    if (empty($atts['url'])) {
        return 'GitHub URL is required.';
    }

    $response = wp_remote_get($atts['url']);
    if (is_wp_error($response)) {
        return 'Error fetching data from GitHub.';
    }
    $body = wp_remote_retrieve_body($response);
    if (empty($body)) {
        return 'No content retrieved from GitHub.';
    }
	
    //return '<div>' . esc_html($body) . '</div>';
    return wp_kses_post($body);
}

add_shortcode('github_text', 'fetch_github_text');