<?php

class Twitch_Channel {

  const TWITCH_API_URL = 'https://api.twitch.tv/kraken/channels/';
  const TWITCH_API_CLIENT_ID = '243x69xvxlj4lyk7juy2riu8ml30p4';

  private $channel_name;
  public $channel_data;

  public function __construct($channel_name) {

    $this->channel_name = $channel_name;
    $this->channel_data = self::query_api();

  }

  private function query_api() {

    $url = self::TWITCH_API_URL . $this->channel_name;
    $client_id = self::TWITCH_API_CLIENT_ID;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Client-ID: ' . $client_id
    ));

    $data = curl_exec($ch);

    curl_close($ch);

    return json_decode($data);

  }


}
