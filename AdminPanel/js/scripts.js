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

$(document).on("change", "#categtory", function(){
  var id = $(this).val();
  $.ajax({
      type: "POST",
      dataType: "json",
      data: {categoryId: id},
      url: './handler/requestHandler.php', 
      success: function(res){
          let options = '';
          res.categories.forEach(cat => {
              options+=`
                  <option value='${cat["id"]}'>${cat["subCatName"]}</option>
              `;
          });
          $("#subcategtory").html(options);
      }
  });
});

$(document).ready(function(){
  
  $(document).on("click",".page-link", function(){
    var data = $(this).data("action");
    var totalrecords = +$("#totalrecords").text();
    var show = +$("#show-record").val();
    var search = $("#searchRec").parent().find("input").val();
    var page = 1;
    if(data=="left"){
      page = +$(".page-item.active").find(".page-link").text()-1;
      if(page<=0){ page=1; return; }
    }else if(data=="right"){
      page = +$(".page-item.active").find(".page-link").text()+1;
      if(page > Math.ceil(totalrecords/show)) { page=Math.ceil(totalrecords/show); return; }
    }else{
      page = $(this).text();
    }
    var url = document.URL.split("?")[0] +"?search="+search+"&page="+page+"&show="+show;
    window.location.href = url;
  });

  $(document).on("change","#show-record", function(){
    var page = 1;//$(".page-item.active").find(".page-link").text();
    var show = $(this).val();
    var search = $("#searchRec").parent().find("input").val();
    var url = document.URL.split("?")[0] +"?search="+search+"&page="+page+"&show="+show;
    window.location.href = url;
  });

  $(document).on("click", "#searchRec", function(){
    var search = $(this).parent().find("input").val();
    var page = $(".page-item.active").find(".page-link").text();
    var show = +$("#show-record").val();
    var url = document.URL.split("?")[0] +"?search="+search+"&page="+page+"&show="+show;
    window.location.href = url;
  });
});