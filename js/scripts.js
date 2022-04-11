(function ($) {
  "use strict";
  var path = window.location.href;
  $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
    if (this.href === path) {
      $(this).addClass("active");
    }
  });
  $("#sidebarToggle").on("click", function (e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
  });
})(jQuery);
$(".check-all").click(function () {
  $(".check-item").prop("checked", $(this).prop("checked"));
}); //window.oncontextmenu=function(){return false;}
$(document).keydown(function (event) {
  if (event.keyCode == 123) {
    return false;
  } else if (
    (event.ctrlKey && event.shiftKey && event.keyCode == 73) ||
    (event.ctrlKey && event.shiftKey && event.keyCode == 74)
  ) {
    return false;
  }
});

$(document).ready(function(){
    setTimeout(function(){
        $(".alert").remove();
    }, 5000)
});