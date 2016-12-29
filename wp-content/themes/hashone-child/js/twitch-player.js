jQuery(function($){

  var $ = jQuery;

  var setChannelsAsInactive = function() {
    $(".lr-channel.active").removeClass("active");
  };

  var setChannelAsActive = function(elem) {
    setChannelsAsInactive();

    $(elem).closest(".lr-channel").addClass("active");
  };

  var setTwitchChannel = function(channelName) {
    $(".lr-twitch-video").html("<iframe src='http://player.twitch.tv/?channel=" + channelName + "' height='349' width='620' frameborder='0' scrolling='no' allowfullscreen='false'></iframe>");
  };


  $(".lr-channel-user").on("click", function() {
    setChannelAsActive(this);
    var channelName = $(this)[0].innerText;
    setTwitchChannel(channelName);
  });

  $(".lr-channel img").on("click", function() {
    setChannelAsActive(this);
    var channelName = $(this).closest(".lr-channel").find(".lr-channel-user")[0].innerText;
    setTwitchChannel(channelName);
  });

});
