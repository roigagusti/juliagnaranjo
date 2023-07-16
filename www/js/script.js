/*
# Author: Aldasoro
# Template: Julia G. Naranjo
# Version: 2.0
# Copyright 2018 Aldasoro, inc.
# www: http://www.agustiroig.com


Taula de continguts
-------------------
1. Scroll to experience
*/

$(document).ready(function() {
  $(".scroll-link").click(function(e) {
      e.preventDefault();
      var target = $("#see-experience");
      $('html, body').animate({
          scrollTop: target.offset().top
      }, 1000);
  });
  $(".start-again").click(function(e) {
      e.preventDefault();
      var target = $("#top");
      $('html, body').animate({
          scrollTop: target.offset().top
      }, 1000);
  });
});