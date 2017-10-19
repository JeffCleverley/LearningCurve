jQuery(document).ready(function($) {

  function hiddenFooter() {

    var hiddenFootersHeight = ($(".hidden-footer").outerHeight());

    if (window.innerWidth >= 1024) {
      $(".site-container").addClass("added-hidden-footer-margin").css({
        'margin-bottom': hiddenFootersHeight + "px"
      });
    } else {
      $(".site-container").removeClass("added-hidden-footer-margin").css({
        'margin-bottom': "0"
      });
    }
  }

  hiddenFooter();

  $(window).resize(function() {
    hiddenFooter();
  });
});