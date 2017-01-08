<?php

class Twitch_Player {

  const TWITCH_API_URL = 'https://api.twitch.tv/kraken/streams/followed';
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
    if ( empty($streams) ) {
      $html .= " <div class='lr-twitch-empty'>"
            .  "   <h2>There are no streams going on right now</h2>"
            .  "    <h5><a href='https://discordapp.com/invite/Eqmqe'>Join The Lunchroom</a> and start streaming to be shown here!</h5>"
            .  " </div>";
    } else {
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
      $html .= "   </div>";
    }
    $html .= " </div>"
          .  "</div>";

    return $html;

  }

  private function query_api() {

    $url = self::TWITCH_API_URL;
    $client_id = self::TWITCH_API_CLIENT_ID;
    $auth_token = self::TWITCH_API_AUTH_TOKEN;


    $args = array(
      'headers' => array(
        "Accept" => "application/vnd.twitchtv.v5+json",
        "Client-ID" => $client_id,
        "Authorization" => "OAuth ".$auth_token
      )
    );

    $response = wp_remote_get($url, $args);
    $response_body = wp_remote_retrieve_body($response);

    return json_decode($response_body);

  }

}
