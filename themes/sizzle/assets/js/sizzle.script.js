/**
 * @file
 * Custom scripts for theme.
 */
(function ($) {
  // Sticky Nav.
  Drupal.behaviors.stickyNav = {
    attach: function(context, settings) {
      // Make navigation sticky.
      if (!$('.navbar').hasClass('waypoint-processed')) {
        var stickyNavigation = new Waypoint.Sticky({
          element: $('.navbar', context)[0]
        });
        $('.navbar').addClass('waypoint-processed')
      }
    }
  }
})(jQuery);
