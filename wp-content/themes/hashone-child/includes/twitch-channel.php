<?php

class Twitch_Channel {

  const TWITCH_API_URL = 'https://api.twitch.tv/kraken/channels/';
  const TWITCH_API_CLIENT_ID = '243x69xvxlj4lyk7juy2riu8ml30p4';

  private $channel_name;
  public $channel_data;

  public function __construct($channel_name) {

    $this->channel_name = $channel_name;
    $this->channel_data = self::get_data($channel_name);

  }

  private function get_data($channel_name) {

    $cache_id = "lr_channel_".$channel_name;
    $cache_data = get_transient($cache_id);
    
    if (!empty($cache_data)) {
      return $cache_data;
    } else {
      $response = self::query_api();
      $response_body = wp_remote_retrieve_body($response);
      $json_data = json_decode($response_body);

      if (self::is_response_valid($response)) {
        set_transient($cache_id, $json_data, self::get_transient_lifespan());
      }

      return $json_data;
    }

  }

  private function get_transient_lifespan() {
    if( is_super_admin() && WP_DEBUG ) {
      return 10;
    } else {
      return DAY_IN_SECONDS;
    }
  }

  private function is_response_valid($response) {

    if (is_wp_error($response)) {
      return false;
    }

    if (!isset($response['response']['code'])) {
      return false;
    } else {
      if ($response['response']['code'] != "200") {
        return false;
      }
    }

    return true;

  }

  private function query_api() {

    $url = self::TWITCH_API_URL . $this->channel_name;
    $client_id = self::TWITCH_API_CLIENT_ID;

    $args = array(
      'headers' => array("Client-ID" => $client_id)
    );

    $response = wp_remote_get($url, $args);

    return $response;

  }

}
