<?php

class Twitch_Player {

  const TWITCH_API_URL = 'https://api.twitch.tv/kraken/search/streams?query=Magic:%20The%20Gathering';
  const TWITCH_API_CLIENT_ID = '243x69xvxlj4lyk7juy2riu8ml30p4';
  const TWITCH_API_AUTH_TOKEN = 'gpnsx385cpzbw09jmt39ibo2arqiun';

  public function render_widget() {
    $json = self::query_api();
    $output = self::render($json);

    return $output;
  }

  private function render($json) {

    $streams = $json->streams;

    $html = "<div class='lr-twitch-wrapper'>"
          . "  <div class='lr-twitch-player'>";
    if ( !wp_is_mobile() ) {
      $html .= " <div class='lr-twitch-video'>"
            .  "   <iframe src='http://player.twitch.tv/?channel=" . $streams[0]->channel->name . "' height='349' width='620'"
            .  "            frameborder='0' scrolling='no' allowfullscreen='false'></iframe>"
            .  " </div>";
    }
    $html .= "   <div class='lr-channels'>";
    foreach ($streams as $key=>$stream) {
      $html .= "   <div class='lr-channel " . ($key == 0 && !wp_is_mobile() ? "active" : "") . "'>"
            .  "     <img src=" .$stream->preview->medium . " alt='Stream' />"
            .  "     <div class='lr-channel-description'>"
            .  "       <div class='lr-channel-user'>" . $stream->channel->name . "</div>"
            .  "       <div class='lr-channel-playing'>playing " . $stream->channel->game . "</div>"
            .  "       <div class='lr-channel-status'>" . $stream->channel->status . "</div>"
            .  "     </div>"
            .  "   </div>";
    }
    $html .= "   </div>"
          .  " </div>"
          .  "</div>";

    return $html;

  }

  private function query_api() {

    $url = self::TWITCH_API_URL;
    $client_id = self::TWITCH_API_CLIENT_ID;
    $auth_token = self::TWITCH_API_AUTH_TOKEN;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Accept: application/vnd.twitchtv.v5+json',
      'Client-ID: ' . $client_id,
      'Authorization: OAuth ' . $auth_token
    ));

    $data = curl_exec($ch);

    curl_close($ch);

    return json_decode($data);

  }


}
