<?php

if (!defined('ABSPATH')) exit;


function elfsight_google_maps_get_api_key(){
    return get_option('elfsight_google_maps_api_key', '');
}

$elfsight_google_maps_api_key = elfsight_google_maps_get_api_key();

if (is_array($elfsight_google_maps_config['settings']) && is_array($elfsight_google_maps_config['preferences'])) {
    array_push($elfsight_google_maps_config['settings']['properties'], array(
        'id' => 'apiKey',
        'name' => 'API key',
        'type' => 'hidden',
        'defaultValue' => $elfsight_google_maps_api_key
    ));
}

function elfsight_google_maps_shortcode_options_filter($options) {
    $apiKey = get_option('elfsight_google_maps_api_key', '');

    if (is_array($options)) {
        $options['apiKey'] = $apiKey;
    }

    return $options;
}
add_filter('elfsight_google_maps_shortcode_options', 'elfsight_google_maps_shortcode_options_filter');

function elfsight_google_maps_widget_options_filter($options_json) {
    $options = json_decode($options_json, true);

    if (is_array($options)) {
        unset($options['apiKey']);
    }

    return json_encode($options);
}
add_filter('elfsight_google_maps_widget_options', 'elfsight_google_maps_widget_options_filter');

function elfsight_google_maps_update_api_key() {
    if (!wp_verify_nonce($_REQUEST['nonce'], 'elfsight_google_maps_update_api_key_nonce')) {
        exit;
    }

    update_option('elfsight_google_maps_api_key', !empty($_REQUEST['api_key']) ? $_REQUEST['api_key'] : '');
}
add_action('wp_ajax_elfsight_google_maps_update_api_key', 'elfsight_google_maps_update_api_key');