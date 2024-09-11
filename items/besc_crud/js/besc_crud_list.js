var bc_delete_dialog_phasing = 150;
var bc_row_to_be_deleted = false;

$(document).ready(function () {
  bc_bindListListeners(true);
  bc_bindPagingListeners(true);
  bc_bindFilterListeners(true);
  bc_fetch_info();
});

function bc_bindListListeners(toggle) {
  if (toggle) {
    $(".bc_delete_ok").click(function () {
      $.ajax({
        url: bc_delete_url + bc_row_to_be_deleted,
        type: "POST",
        dataType: "json",
        success: function (data) {
          if (data.success) {
            keyboardListeners(false);
            bc_refresh(bc_paging_active);
            $(".bc_delete_dialog").fadeOut(bc_delete_dialog_phasing);
          } else {
            showMessage("error", data.message);
          }
        },
      });
    });

    $(".bc_delete_cancel").click(function () {
      $(".bc_delete_dialog").fadeOut(bc_delete_dialog_phasing);
      bc_toggle_fade(false);
      keyboardListeners(false);
    });

    $(".bc_row_action.delete").click(function () {
      bc_row_to_be_deleted = $(this).attr("row_id");
      bc_toggle_fade(true);
      $(".bc_delete_dialog").fadeIn(bc_delete_dialog_phasing);
      keyboardListeners(true);
    });

    $(".bc_sortable").on("click", function () {
      bc_sorting($(this)); //$(this).toggleClass('bc_table_sort_asc');
    });

    $("#bc_filter_toggle").click(function () {
      $(this).toggleClass("active");
      $(".bc_paging_and_filtering").slideToggle();
    });
    bc_update_repo_images();
  } else {
    $(".bc_delete_ok").unbind("click");
    $(".bc_delete_cancel").unbind("click");
    $(".bc_row_action.delete").unbind("click");
    $("#bc_filter_toggle").unbind("click");
  }
}

function keyboardListeners(toggle) {
  if (toggle) {
    $(document).keyup(function (e) {
      if (e.keyCode === 13) $(".bc_delete_ok").click(); // enter
      if (e.keyCode === 27) $(".bc_delete_cancel").click(); // esc
    });
  } else {
    $(document).unbind("keyup");
  }
}

function bc_toggle_fade(toggle) {
  console.log('fade');
  if (toggle) $(".bc_fade").fadeIn(bc_delete_dialog_phasing);
  else $(".bc_fade").fadeOut(bc_delete_dialog_phasing);
}

function bc_update_repo_images() {
  $(".bc_td_repo_image").each(function () {
    var img_preview = $(this).find(".table_repo_image_preview");

    var repo_id = img_preview.attr("repo_id");
    var uploadpath = "/items/uploads/images/";
    if (repo_id != 0 && repo_id != "" && repo_id != undefined) {
      $.ajax({
        url: rootUrl + "/entities/Content/get_repo_image",
        data: {
          repo_id: repo_id,
        },
        method: "POST",
        dataType: "json",
        success: function (data) {
          var ret = data;
          console.log(ret.repo_item);
          if (ret.success) {
            img_preview.attr("src", rootUrl + uploadpath + ret.repo_item.fname);
          } else {
            console.log("Error while getting the image: " + repo_id);
          }
        },
      });
    }
  });
}

function bc_sorting(th) {
  if (th.hasClass("bc_table_sort_asc")) {
    th.removeClass("bc_table_sort_asc").addClass("bc_table_sort_desc");
  } else if (th.hasClass("bc_table_sort_desc")) {
    th.removeClass("bc_table_sort_desc").addClass("bc_table_sort_asc");
  } else {
    $(".bc_sortable").removeClass("bc_table_sort_asc").removeClass("bc_table_sort_desc");
    th.addClass("bc_table_sort_asc");
  }

  bc_refresh(0);
}

function bc_refresh(page) {

  if (page === undefined) page = bc_paging_active;


  $.ajax({

    url: bc_refresh_url,
    data: {
      page: page,
      filter: getFilterSettings(),
      sorting: getSorting(),
    },
    type: "GET",
    dataType: "json",

    beforeSend: function () {
      bc_toggle_fade(true);

      bc_bindListListeners(false);
      bc_bindPagingListeners(false);
      bc_bindFilterListeners(false);
      toggleSidebarListeners(false);
    },

    success: function (data) {

      if (data.success) {
        $("#bc_filter_toggle").remove();
        bc_toggle_fade(false);

        $("#bc_table_holder").replaceWith(data.data);
        $(".bc_paging_and_filtering").replaceWith(data.paging_and_filtering);

        $(".controlRight").replaceWith(data.pagination);

        bc_paging_active = $(".bc_current_page").attr("page");
      } else {
        showMessage("error", "ERROR!!!");
      }

      bc_bindPagingListeners(true);
      bc_bindListListeners(true);
      bc_bindFilterListeners(true);
      toggleSidebarListeners(true);
      select2Init();

    },
    error: function (jqXHR, textStatus, errorThrown) {
      showMessage("error", errorThrown);
    },

  });

}

function bc_bindPagingListeners(toggle) {

  if (toggle) {
    $('.bc_paging_page').click(function () {
      console.log("ppp", $(this))
      $(this).addClass('bc_current_page')
       .siblings()
        .removeClass('bc_current_page');

      bc_refresh($(this).attr('page'));
    });

    $('.bc_paging_button').click(function () {
      console.log($(this).attr('target'))
      bc_refresh($(this).attr('target'));
    });

  } else {
    $('.bc_paging_page').unbind('click');
    $('.bc_paging_button').unbind('click');
  }
}

// function bc_bindPagingListeners(toggle) {

//   console.log("bc_bindPagingListeners")

//   if (toggle) {

//     // $('.bc_paging_sites').on('click', '.bc_paging_page', function () {
//     //   // $(this)
//     //   //   .addClass('bc_current_page')
//     //   //   .siblings()
//     //   //   .removeClass('bc_current_page');

//     //   bc_refresh($(this).attr('page'));

//     // });


//     $(".bc_paging_button").click(function () {
//       bc_refresh($(this).attr("target"));
//     });

//   } else {
//     $(".bc_paging_page").unbind("click");
//     $(".bc_paging_button").unbind("click");
//   }
// }

function bc_bindFilterListeners(toggle) {
  console.log("bc_bindFilterListeners")
  if (toggle) {
    $(".bc_filter select").change(function () {
      bc_refresh(0);
    });

    $(".bc_filter input").keyup(function (e) {
      var code = e.which;
      if (code == 13) bc_refresh(0);
    });

    $(".bc_filter_reset").click(function () {
      $(".bc_filter input").val("");
      $(".bc_filter select").each(function () {
        $(this).find("option:selected").removeAttr("selected");
        $(this).val("null");
      });

      bc_refresh(0);
    });

    $(".bc_filter_search").click(function () {
      bc_refresh(0);
    });
  } else {
    $(".bc_filter select").unbind("change");
    $(".bc_filter input").unbind("keyup");
    $(".bc_filter_reset").unbind("click");
    $(".bc_filter_search").unbind("click");
  }
}

function getFilterSettings() {
  var bc_filter = [];

  $(".bc_filter").each(function () {
    switch ($(this).attr("type")) {
      case "select":
      case "combobox":
        bc_filter.push({
          name: $(this).find("select").attr("name"),
          value: $(this).find("select").val(),
          type: "select",
        });
        break;
      case "date":
        bc_filter.push({
          name: $(this).find("input").attr("name"),
          value: $(this).find("input").val(),
          type: $(this).attr("type"),
        });
        break;
      case "datetime":
        bc_filter.push({
          name: $(this).find("input").attr("name"),
          value: $(this).find("input").val(),
          type: $(this).attr("type"),
        });
        break;
      case "text":
      case "m_n_relation":
        bc_filter.push({
          name: $(this).find('select').attr('name'),
          value: $(this).find('select').val(),
          type: $(this).attr('type'),
        });
        break;
    }
  });


  return bc_filter;
}

function getSorting() {
  var col = $(".bc_table_sort_asc").length == 1 ? $(".bc_table_sort_asc") : $(".bc_table_sort_desc");

  if (col.length != 0) var ret = { col_id: col.attr("col"), direction: col.hasClass("bc_table_sort_asc") ? 0 : 1 };
  else var ret = {};

  return ret;
}

function bc_fetch_info() {
  // repo images

  // repo text
  $(".bc_td_repo_text").each(function () {
    var elem = $(this);
    var column_name = elem.attr("col_name");
    var table_name = elem.attr("table_name");
    var row_id = elem.attr("row_id");

    fetch_repo_text(column_name, table_name, row_id, 0);
  });
}


function fetch_repo_text(column_name, table_name, row_id) {
  $.ajax({
    type: "POST",
    url: rootUrl + "/entities/TextRepo/get_text_repo_text",
    data: {
      column_name: column_name,
      table_name: table_name,
      row_id: row_id,
      lang: -1,
    },
    success: function (data) {
      var ret = JSON.parse(data);
      console.log(ret,column_name, table_name, row_id);


      var text_elem = $('.bc_td_repo_text[col_name="' + column_name + '"][table_name="' + table_name + '"][row_id="' + row_id + '"]');
      text_elem.html(ret.text_phrase);
    },
  });
}