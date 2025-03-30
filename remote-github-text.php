<?php

function fetch_github_html_cached($atts)
{
    $atts = shortcode_atts(
        array(
            'url' =>
                'https://raw.githubusercontent.com/Azzamean/remote-github-text/refs/heads/main/text.html', // USE THE RAW LINK ONLY
            'cache_time' => 3600 // 1 HOUR
        ),
        $atts,
        'github_html_cache'
    );

    if (empty($atts['url'])) {
        return 'Error: GitHub URL is required.';
    }

    $cache_key = 'github_html_' . md5($atts['url']);
    $cached_content = get_transient($cache_key);

    if ($cached_content !== false) {
        return $cached_content;
    }

    $response = wp_remote_get($atts['url']);

    if (is_wp_error($response)) {
        return 'Error fetching data from GitHub.';
    }

    $body = wp_remote_retrieve_body($response);

    if (empty($body)) {
        return 'No content retrieved from GitHub.';
    }

    $body = wp_kses_post($body);
    set_transient($cache_key, $body, intval($atts['cache_time']));
	
    //return '<div>' . esc_html($body) . '</div>';
    return $body;
}

add_shortcode('github_html', 'fetch_github_html_cached');