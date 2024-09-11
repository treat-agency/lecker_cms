$(document).ready(function () {
  addListeners();
});

function addListeners() {
  $(".sidebar_headline").click(function () {
    var filter_id = $(this).attr("menu");
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(".sidebar_itemcontainer[menu='" + filter_id + "']").slideUp();
      console.log(1);
    } else {
      $(this).addClass("active");
      $(".sidebar_itemcontainer[menu='" + filter_id + "']").slideDown();
    }
  });
}
