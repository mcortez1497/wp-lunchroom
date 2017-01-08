jQuery(function($){

  var $ = jQuery;

  $("#wp-discord .lr-discord-toggle").on("click", function() {

    var widget = $("#wp-discord");

    widget.toggleClass("expanded");

    if (widget.hasClass("expanded")) {
      $(this).html("Show Less <i class='fa fa-chevron-up'></i>");
    } else {
      $(this).html("Show All <i class='fa fa-chevron-down'></i>");
    }

  });

});
