<?php
/**
 * soodacode Youtube APÌ Settings
 *
 * @package soodacode
 */

// Crear una página de opciones en el menú de administración de WordPress

function yt_get_cached_data($cache_key, $api_url, $cache_duration = 3600) {
    // Verifica si ya existe un dato en caché
    $cached_data = get_transient($cache_key);
    if ($cached_data !== false) {
        return $cached_data;
    }

    // Realiza la solicitud a la API
    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return 'Error retrieving data from YouTube API: ' . $response->get_error_message();
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    // Guarda los datos en caché
    set_transient($cache_key, $data, $cache_duration);

    return $data;
}


function yt_channel_settings_menu() {
    add_options_page(
        'YouTube Channel Settings', 
        'YouTube Channel', 
        'manage_options', 
        'yt-channel-settings', 
        'yt_channel_settings_page'
    );
}
add_action('admin_menu', 'yt_channel_settings_menu');

// Crear la página de configuración
function yt_channel_settings_page() {
    ?>
    <div class="wrap">
        <h1>YouTube Channel Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('yt_channel_settings_group');
            do_settings_sections('yt-channel-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Registrar la configuración
function yt_channel_settings_init() {
    register_setting('yt_channel_settings_group', 'yt_channel_url');
    register_setting('yt_channel_settings_group', 'yt_api_key');

    add_settings_section(
        'yt_channel_settings_section', 
        'YouTube Channel Details', 
        null, 
        'yt-channel-settings'
    );

    add_settings_field(
        'yt_channel_url', 
        'YouTube Channel URL', 
        'yt_channel_url_callback', 
        'yt-channel-settings', 
        'yt_channel_settings_section'
    );

    add_settings_field(
        'yt_api_key', 
        'YouTube API Key', 
        'yt_api_key_callback', 
        'yt-channel-settings', 
        'yt_channel_settings_section'
    );
}
add_action('admin_init', 'yt_channel_settings_init');

function yt_channel_url_callback() {
    $channel_url = get_option('yt_channel_url');
    echo '<input type="text" id="yt_channel_url" name="yt_channel_url" value="' . esc_attr($channel_url) . '" style="width: 100%;" />';
}

function yt_api_key_callback() {
    $api_key = get_option('yt_api_key');
    echo '<input type="text" id="yt_api_key" name="yt_api_key" value="' . esc_attr($api_key) . '" style="width: 100%;" />';
}

function yt_extract_channel_id($url) {
    // Use a regular expression to match various YouTube URL formats
    if (preg_match('/youtube\.com\/(?:channel\/|c\/|user\/|@)?([^\/\?\&]+)/', $url, $matches)) {
        $identifier = $matches[1];

        // If the identifier is a valid channel ID (starts with 'UC')
        if (strpos($identifier, 'UC') === 0) {
            return $identifier; // Return the ID directly
        } else {
            // For handles, usernames, or custom URLs
            $api_key = get_option('yt_api_key');
            $api_url = "https://www.googleapis.com/youtube/v3/search?part=id&type=channel&q={$identifier}&key={$api_key}";
            $response = wp_remote_get($api_url);
            if (is_wp_error($response)) {
                return null; // Return null if there's an error with the request
            }
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body);

            if (!empty($data->items)) {
                return $data->items[0]->id->channelId; // Return the channel ID
            }
        }
    }
    return null; // Return null if the ID cannot be extracted
}


function yt_latest_videos_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'count' => 3, // Número de videos a mostrar
        ), 
        $atts, 
        'yt_latest_videos'
    );

    $channel_url = get_option('yt_channel_url');
    $api_key = get_option('yt_api_key');
    $channel_id = yt_extract_channel_id($channel_url);

    if (!$channel_id || !$api_key) {
        return 'No se pudo obtener el ID del canal o falta la clave API.';
    }

    $max_results = intval($atts['count']);
    $api_url = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId={$channel_id}&maxResults={$max_results}&key={$api_key}";
    $data = yt_get_cached_data('yt_latest_videos_' . $channel_id, $api_url);

    if (isset($data->error)) {
        return 'YouTube API error: ' . esc_html($data->error->message);
    }

    if (!empty($data->items)) {
        $output = '<div class="yt-latest-videos">';
        foreach ($data->items as $item) {
            $video_id = $item->id->videoId;
            $title = $item->snippet->title;
            $thumbnail = $item->snippet->thumbnails->medium->url;
            $video_url = "https://www.youtube.com/watch?v=" . $video_id;

            $output .= '<div class="yt-video">';
            $output .= '<a href="' . esc_url($video_url) . '" target="_blank">';
            $output .= '<img src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';
            $output .= '<h3>' . esc_html($title) . '</h3>';
            $output .= '</a>';
            $output .= '</div>';
        }
        $output .= '</div>';
    } else {
        $output = 'No se encontraron videos.';
    }

    return $output;
}
add_shortcode('yt_latest_videos', 'yt_latest_videos_shortcode');

function yt_subscribe_button_shortcode() {
    $channel_url = get_option('yt_channel_url');
    $api_key = get_option('yt_api_key');
    $channel_id = yt_extract_channel_id($channel_url);

    if (!$channel_id || !$api_key) {
        return '<a href="https://www.youtube.com/channel/' . esc_attr($channel_id) . '?sub_confirmation=1" target="_blank">
                    <button class="follow">Subscribe now</button>
                </a>';
    }

    $api_url = "https://www.googleapis.com/youtube/v3/channels?part=statistics&id={$channel_id}&key={$api_key}";
    $data = yt_get_cached_data('yt_subscribe_button_' . $channel_id, $api_url);

    if (isset($data->error)) {
        // Mostrar solo el botón de suscripción en caso de error
        return '<a href="https://www.youtube.com/channel/' . esc_attr($channel_id) . '?sub_confirmation=1" target="_blank">
                    <button class="follow">Subscribe now</button>
                </a>';
    }

    if (!empty($data->items)) {
        $subscriber_count = $data->items[0]->statistics->subscriberCount;

        // Mostrar el número de suscriptores y el botón de suscripción
        $output = '<div class="social-text">';
        $output .= '<span class="social-number">' . esc_html(number_format($subscriber_count)) . '</span>';
        $output .= '<p class="social-type">Subscribers</p>';
        $output .= '</div>';
        $output .= '<a href="https://www.youtube.com/channel/' . esc_attr($channel_id) . '?sub_confirmation=1" target="_blank">';
        $output .= '<button class="follow">Subscribe now</button>';
        $output .= '</a>';

        return $output;
    } else {
        // Mostrar solo el botón de suscripción si no hay datos de suscriptores
        return '<a href="https://www.youtube.com/channel/' . esc_attr($channel_id) . '?sub_confirmation=1" target="_blank">
                    <button class="follow">Subscribe now</button>
                </a>';
    }
}
add_shortcode('yt_subscribe_button', 'yt_subscribe_button_shortcode');

