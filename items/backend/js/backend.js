var dragging = false;
var prevOffset, curOffset;
var login_check_timer = 60000;



$(document).ready(function () {
  lazy_load_start();
  toggleSidebarListeners(true);
  menuDown();
  addGlobalListeners();
  resetFilterButton();
    select2Init();


$('#csvFileUpload').on('change', function () {
  console.log('edit.js loaded');

  var file = this.files[0];
  var tableName = $(this).attr('tableName');
  var formData = new FormData();
  formData.append('file', file);

  $.ajax({
    url: rootUrl + 'entities/Content/csvToDb/' + tableName, // replace with your upload script
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      data = JSON.parse(data);

      if (data.success == true) {
        location.reload();
      } else {
        $('#csvUploadError').text(data.message);
      }
    },
  });
});

});

function resetFilterButton() {
  $('#js-resetFilterButton').on('click', function () {
    // Set all select elements to value 0
    $('select').val('0');

    // Reload the page
    bc_refresh();
  });
}

function select2Init() {

$('.bc_filter').find('select').select2();

  $selectorsClass = ['select-basic-single'];
  $selectorsIds = [];
  $selectorsClass.forEach((selectorClass) => {
    if ($("." + selectorClass).length > 0) {
      $("." + selectorClass).select2();
    }
  });

  $selectorsIds.forEach((selectorId) => {
    if ($("#" + selectorId).length > 0) {
      $("#" + selectorId).select2();
    }
  }
  );
}



function lazy_load_start() {

  if ($("#module_container span").length > 0) {

    if ($(".lazy").length > 0) {

      $(".lazy").Lazy({
        scrollDirection: "vertical",
        effect: "fadeIn",
        visibleOnly: true,
        threshold: 100,
        appendScroll: $('#repo_container'),
        onError: function (element) {

        },
        beforeLoad: function (element) {
          //  console.log(element);
        },
        afterLoad: function (element) {
          //  console.log("loaded");
        },
      });

    }
  }
}



function addGlobalListeners() {


  $(window).resize(function () { });


  $("#items_search_field").on("keyup", function (e) {
    var search = $(this).val().toLowerCase();
    if (search != "") {
      $(".sidebar_menuitem").hide();
      $(".sidebar_menuitem").each(function () {
        var btn_val = $(this).children("a").html().toLowerCase();

        if (btn_val.includes(search)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    } else {
      $(".sidebar_menuitem").show();
    }
  });

  $(".video_play").click(function () {
    var video = $(this).parent().parent().find(".embed_holder video").get(0);
    video.play();
    $(this).hide();
    $(this).parent().find(".video_pause").show();
  });

  $(".video_pause").click(function () {
    var video = $(this).parent().parent().find(".embed_holder video").get(0);
    video.pause();
    $(this).hide();
    $(this).parent().find(".video_play").show();
  });

  $(".video_mute").click(function () {
    var video = $(this).parent().parent().find(".embed_holder video");
    video.prop("muted", true);
    //v = document.getElementById("current_video")
    //v.textTracks[0].mode = "showing";
    $(this).hide();
    $(this).parent().find(".video_unmute").show();
  });

  $(".video_unmute").click(function () {
    var video = $(this).parent().parent().find(".embed_holder video");
    video.prop("muted", false);
    //v = document.getElementById("current_video")
    //v.textTracks[0].mode = "hidden";

    $(this).hide();
    $(this).parent().find(".video_mute").show();
  });
}

function checkLoggedIn() {
  setInterval(function () {
    $.ajax({
      type: "POST",
      url: rootUrl + "Backend/checkLoggedin",
      data: {},
      success: function (data) {
        var json = $.parseJSON(data);

        if (!json.success) {
          window.alert("You have been logged out");
        }
      },
    });
  }, login_check_timer);
}

function mainDrag(toggle) {
  if (toggle) {
    $(".drag_item").draggable({
      containment: $("#drag_area"),
      start: draggingStart,
      stop: draggingStop,
      drag: draggingDrag,
    });

    $(".drag_item.no_overlap").droppable({
      greedy: true,
      over: function (e, ui) {
        ui.helper.offset((curOffset = prevOffset)).trigger("mouseup");
      },
      tolerance: "touch",
    });
  } else {
    $(".drag_item").draggable("destroy");
    $(".no_overlap").droppable("destroy");
  }
}

function draggingStart(event, ui) {
  dragging = true;
  $(ui.helper).addClass("noclick");
}

function draggingStop(event, ui) {
  setTimeout(function () {
    dragging = false;
  }, 100);

  if ($(this).draggable("option", "revert")) $(this).draggable("option", "revert", false);

  var elements = [];

  $(".drag_item").each(function (i, item) {
    var $this = $(item);

    if ($this.find(".drag_item").length < 1) {
      var new_item = {
        item_id: $this.attr("iid"),
        left: $this.position().left,
        top: $this.position().top,
        type: $this.attr("type"),
      };

      elements.push(new_item);
    }
  });

  $.ajax({
    type: "POST",
    url: rootUrl + "entities/Website/saveStartSetup",
    data: { items: elements },
    success: function (data) {
      var json = $.parseJSON(data);

      if (json.status == "success") {
      }
    },
  });
}

function draggingDrag(event, ui) {
  prevOffset = curOffset;
  curOffset = $.extend({}, ui.offset);
  return true;
}

function toggleSidebarListeners(toggle) {
  if (toggle) {
    $(".sidebar_headline").on("click", function () {
      var activesidebar = $('.sidebar_itemcontainer[menu="' + $(this).attr("menu") + '"]');
      if (!activesidebar.hasClass("open")) {
        $(".sidebar_itemcontainer").removeClass("open");
        activesidebar.addClass("open");
      } else activesidebar.removeClass("open");
    });

    $("#widget_btn").click(function () {
      $("#widget_overlay").show();
    });

    $("#quicklink_btn").click(function () {
      $("#quicklink_overlay").show();
    });

    $(".overlay_close").click(function () {
      $(this).parent().hide();
    });

    $(".icon_select_item").click(function () {
      $(".icon_select_item").removeClass("active");
      $(this).addClass("active");
    });

    $(".color_select_item").click(function () {
      $(".color_select_item").removeClass("active");
      $(this).addClass("active");
    });

    $("#category_select").on("change", function () {
      var cat = $(this).val();

      $(".sub_category").hide();
      $("#" + cat + "_select").show();
    });

    $("#category_select_quick").on("change", function () {
      var cat = $(this).val();

      $(".sub_category").hide();

      if (cat != "none") {
        $("#" + cat + "_select_quick").show();
      }
    });

    $("#add_widget").click(function () {
      var category = $("#category_select").val();
      var table = $("#" + category + "_select").val();
      var icon = $(".icon_select_item.active").attr("fname");
      var color = $(".color_select_item.active").attr("color");
      var note = $("#note").val();
      toggleSidebarListeners(false);
      $.ajax({
        url: rootUrl + "Backend/add_widget",
        data: {
          category: category,
          table: table,
          icon: icon,
          note: note,
          color: color,
        },
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);

          if (ret.success) {
            //alert('Save successful!');

            refreshWidgets();
          } else {
            alert("Error while saving");
          }
        },
      });
    });

    $(".widget_remove").click(function () {
      var wid = $(this).attr("wid");

      $.ajax({
        url: rootUrl + "Backend/remove_widget",
        data: {
          wid: wid,
        },
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);

          if (ret.success) {
            //alert('Remove successful!');
            toggleSidebarListeners(false);
            refreshWidgets();
          } else {
            alert("Error while saving");
          }
        },
      });
    });

    $("#add_quicklink").click(function () {
      var category = $("#category_select_quick").val();
      var table = $("#" + category + "_select_quick").val();
      var note = $("#" + category + "_select_quick option:selected").text();

      $.ajax({
        url: rootUrl + "Backend/add_quicklink",
        data: {
          category: category,
          table: table,
          note: note,
        },
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);

          if (ret.success) {
            alert("Save successful!");
          } else {
            alert("Error while saving");
          }
        },
      });
    });

    $(".delete_quicklink").click(function () {
      var elem = $(this).parent();
      var id = elem.attr("qid");

      $.ajax({
        url: rootUrl + "Backend/remove_quicklink",
        data: {
          id: id,
        },
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            elem.remove();
          } else {
            alert("Error while saving");
          }
        },
      });
    });

    $(".rest_password_view").click(function () {
      var iid = $(this).attr("iid");
      $("#yes_reset").attr("iid", iid);

      if ($(this).hasClass("front")) {
        $("#yes_reset").addClass("front");
      }

      $("#reset_overlay").fadeIn();
    });

    $("#no_reset").click(function () {
      $("#reset_overlay").hide();
    });

    $("#yes_reset").click(function () {
      $(this).hide();
      $("#reset_error").show();
      var id = $(this).attr("iid");
      var url = $(this).hasClass("front") ? "reset_password_front" : "reset_password";

      $.ajax({
        url: rootUrl + "entities/Users/" + url + "/" + id,
        data: {},
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            $("#reset_error").text("Password reset and email sent!");
            setTimeout(function () {
              $("#reset_overlay").hide();
              $("#reset_error").hide().text("Please wait...");
            }, 2000);
          } else {
            $("#reset_error").text("Sending failed, please try again!");
          }
        },
      });
    });
  } else {
    $(".sidebar_headline").off("click");
    $(".widget_remove").off("click");
    $("#add_widget").off("click");
    $(".category_select").off("change");
    $(".icon_select_item").off("click");
    $("#widget_btn").off("click");
    $("#quicklink_btn").off("click");
    $(".overlay_close").off("click");
  }
}

function addSorting() {
  $("#sorting_list").sortable({
    update: function (event, ui) {
      updateList();
    },
  });
}

function updateList() {
  var itemlist = [];

  $(".sorting_item").each(function (i, item) {
    var sid = $(this).attr("iid");
    var order = i;
    var new_item = { order: order, id: sid };

    itemlist.push(new_item);
  });

  $.ajax({
    url: rootUrl + "Backend/updateSorting",
    data: { items: itemlist },
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);
    },
  });
}

function addStartOrdering() {
  $("#sorting_list").sortable({
    update: function (event, ui) {
      updateStartList();
    },
  });
}

function updateStartList() {
  var itemlist = [];

  $(".sorting_item").each(function (i, item) {
    var sid = $(this).attr("iid");
    var order = i;
    var new_item = { order: order, id: sid };

    itemlist.push(new_item);
  });

  $.ajax({
    url: rootUrl + "Backend/updateStartOrder",
    data: { items: itemlist },
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);
    },
  });
}

function refreshWidgets() {
  $.ajax({
    url: rootUrl + "Backend/refresh_widgets",
    data: {},
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);

      $(".con_box").empty().append(ret.html);
      $("#widget_overlay").hide();
      toggleSidebarListeners(true);
    },
  });
}

function menuDown() {
  $('#menu_icon , .js-opener').on('click', function () {

    // if($('#menu').hasClass('active')) {
    //   // $('#sidebar,#side_menu_bg').fadeOut(300)
    //   $('#sidebar').toggleClass('inwindow')
    //   $('.overlayBlur').toggleClass('active')
    // } else {

      // $('#sidebar,#side_menu_bg').fadeIn(300)
      $('#sidebar').toggleClass('inwindow')
      $('.overlayBlur').toggleClass('active')
    // }
    // $('#sidebar').css('display', 'block');
  })

  // $("#menu_close").on("click", function () {
  //   // $('#sidebar').css('display', 'none');
  //   $("#sidebar,#side_menu_bg").fadeOut(300);
  //   $("#menu").removeClass("active");
  //   $('.overlayBlur').removeClass('active');
  // });

  $("#menu_icon2").on("click", function () {
    // $('#sidebar').css('display', 'none');
    $("#sidebar,#side_menu_bg").fadeOut(300);
  });
}

function openFilemanager(moduleType, moduleId) {
  $("#filemanPanel iframe").attr("src", rootUrl + "items/backend/fileman_custom/index.html?integration=custom" + "&module_type=" + moduleType + "&id=" + moduleId);
  $("#filemanPanel").dialog({
    width: parseInt($(window).width() * 0.8),
    height: parseInt($(window).height() * 0.8),
    modal: true,
  });
}

function closeFilemanager() {
  $("#filemanPanel").dialog("destroy");
}

function backendDialog(type, text, title) {
  switch (type) {
    case "success":
      var icon = '<span class="ui-icon ui-icon-info"></span>';
      break;
    case "alert":
      var icon = '<span class="ui-icon ui-icon-notice"></span>';
      break;
    case "error":
      var icon = '<span class="ui-icon ui-icon-alert"></span>';
      break;
    default:
      var icon = "";
      break;
  }

  $("<div></div>")
    .html(icon + text)
    .dialog({
      title: title,
      resizable: false,
      modal: true,
      dialogClass: "backendDialog",
      buttons: {
        Ok: function () {
          $(this).dialog("close").dialog("destroy");
        },
      },
    });
}
