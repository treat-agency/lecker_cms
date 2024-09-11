
var id_increment = 0;
var modules = [];
var active_module = null;
var sliderHandle = null;
var originalCK, translatedCK;

var parentModule, childModule, active_module, popupElem


$(document).ready(function () {

  initCloneModules()
  initEditSelected(); // allows editing multiple items at once
  toggleEditItemListeners(false);
  toggleEditItemListeners(true);
  toggleButtonListeners(true);
  igniteDragging();
  igniteCKEditor();
  // igniteSlider();
  igniteSelectors();
  initModules();
  fitPreviewImages();
  // tooltips();
});


function emptyPopupAndMessage(parentModule) {
  $('.newModuleParent').removeClass('activeParent')
  parentModule.find('.moduleEdit').removeClass('inverted')
  $('.crudInfo').show()
  $('.popup_edit').hide()

  $('.unsavedWarning').css('background-color', '#ffbdbd')
  $('.unsavedWarning').text('Unsaved changes!')
  $('.unsavedWarning').show()

}

function createModuleHelpers(that, thePopup) {

  $('.popup_edit').hide()
  $('.crudInfo').hide()
  $('.newModuleParent').find('.moduleEdit').removeClass('inverted')

  that.addClass('inverted')

  parentModule = that.closest('.newModuleParent')
  childModule = parentModule.find('.module')
  active_module = parentModule
  popupElem = $(thePopup)

  $('.newModuleParent').removeClass('activeParent')
  parentModule.addClass('activeParent')

}





function initCloneModules() {

  $('.bc_clone_cancel').click(function () {
    $('.bc_fade').hide();
    $('.bc_clone_dialog').hide();
  });

  $('.cloneModuleButton').click(function () {

    var pk_value = $(this).attr('pk_value');

    $('.bc_fade').show();
    $('.bc_clone_dialog').show();

    $('.bc_clone_really')
      .off('click')
      .on('click', function () {
        cloneItemModules(pk_value);
      });
  });

  function cloneItemModules(pk_value) {
    $.ajax({
      url: rootUrl + 'entities/Content/clone_item/' + pk_value,
      data: {},
      method: 'POST',
      success: function (data) {
        var ret = $.parseJSON(data);
        if (ret.success) {
          console.log('success');

          showMessage('success', ret.message);

          // go to back
          window.location.reload();
        } else {
          showMessage('error', ret.message);
        }
      },
    });
  }
}


//  edit multiple items at once

function initEditSelected() {
  $('.js-edit_selected_entities').on('click', function () {
    $('#js-entity_editor').show();
  });

  $('.js-edit_select_all').on('click', function () {

    // toggle class on this element to allSelected
    if ($(this).toggleClass('allSelected'))
    checkSelectAll();
  });

  function checkSelectAll() {
    if ($('.allSelected').length > 0) {

      $('.entitiesSelected').each(function () {
        $(this).prop('checked', true);
      });

      $('.js-edit_select_all').html('Deselect all')

    } else {
      $('.js-edit_select_all').html('Select all');
      $('.entitiesSelected').each(function () {
        $(this).prop('checked', false);
      });
    }
  }


  $('#close_popup').on('click', function () {
    $('#js-entity_editor').fadeOut('fast');
  });

  $('#js-edit_selected_button').on('click', function () {
    if ($('.entitiesSelected:checked').length > 0) {
      // INPUT
      // entities with articles
      let general_tag_add = $('#general_tag_add').val();
      let general_tag_delete = $('#general_tag_delete').val();
      let visible = $('.article_visible').is(':checked');

      // universal
      let deleted = $('.delete_entity_article').is(':checked');

      let errors = [];

      let ajaxCalls = []; // Array to hold all AJAX promises

      $('.entitiesSelected:checked').each(function () {
        // DATA TO IDENTIFY ENTITY AND ITEM

        // entities with articles
        let articleType = $(this).attr('articleType');
        let articleIds = $(this).attr('articleIds');

        // universal
        let table = $(this).attr('table');
        let pk = $(this).attr('pk');

        // Push each AJAX call into the ajaxCalls array
        ajaxCalls.push(
          $.ajax({
            type: 'POST',
            url: rootUrl + 'Backend/editSelected',
            data: {
              // IDENTIFIERS
              // entities with articles
              articleType,
              articleIds,
              // universal
              table,
              pk,

              // INPUT
              // entities with articles
              general_tag_add,
              general_tag_delete,
              visible,

              // universal
              deleted,
            },
            success: function (data) {
              var json = $.parseJSON(data);

              if (json.success) {
                console.log('items have been edited');
              } else {
                errors.push('error');
              }
            },
          }),
        );
      });

      // Use $.when() to wait for all AJAX calls to complete
      $.when.apply($, ajaxCalls).then(function () {
        if (errors.length > 0) {
          alert('error');
        } else {
          window.location.reload();
        }
      });
    }
  });
}



$(window).scroll(function () {
  if ($(this).scrollTop() >= 180) {
    // this refers to window
    $("#control_container").css({ position: "fixed", top: 20 });
    $("#item_container").css({ "margin-top": 160 });
  } else {
    $("#control_container").css({ position: "relative", top: "" });
    $("#item_container").css({ "margin-top": 0 });
  }
});

function nl2br(str, is_xhtml) {
  var breakTag = is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
  return (str + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1" + breakTag + "$2");
}

function initDatepicker() {
  $(".datetimepicker").datetimepicker({
    dateFormat: "yyyy-mm-dd",
    timeFormat: "HH:mm:ss",
  });
}

$(window).resize(function () {
  if (active_module != null) {
    // position_tools(active_module);
  }
});







function initModules() {


  $(".newModuleParent").each(function () {


    if ($(this).find('.module_text').length) {
      modules[$(this).attr('module_id')] = new_module_text($(this).attr('module_id'),$(this).parent())
      modules[$(this).attr('module_id')].text = $(this).html()
    }

    if ($(this).find('.module_collapsable').length) {
      modules[$(this).attr('module_id')] = new_module_collapsable($(this).attr('module_id'),$(this).parent())
      modules[$(this).attr('module_id')].text = $(this).html()
    }

    if ($(this).find('.module_video').length) {
      modules[$(this).attr('module_id')] = new_module_video($(this).attr('module_id'),$(this).parent())
    }

    if ($(this).find('.module_html').length) {
      modules[$(this).attr('module_id')] = new_module_html($(this).attr('module_id'),$(this).parent())
    }

    if ($(this).find('.module_marquee').length) {
      modules[$(this).attr("module_id")] = new_module_marquee($(this).attr("module_id"), $(this).parent());
      modules[$(this).attr("module_id")].text = $(this).html();
    }

    // if ($(this).find('.module_comment').length) {
    //   modules[$(this).attr("module_id")] = new_module_comment($(this).attr("module_id"), $(this).parent());
    //   modules[$(this).attr("module_id")].text = $(this).html();
    // }

    if ($(this).find('.module_events').length) {
      modules[$(this).attr("module_id")] = new_module_events($(this).attr("module_id"), $(this).parent());
      modules[$(this).attr("module_id")].text = $(this).html();
    }

    if ($(this).find('.module_sectiontitle').length) {
      modules[$(this).attr("module_id")] = new_module_sectiontitle($(this).attr("module_id"), $(this).parent());
      modules[$(this).attr("module_id")].text = $(this).html();
    }

    if ($(this).find('.module_hr').length) {
      modules[$(this).attr("module_id")] = new_module_hr($(this).attr("module_id"), $(this).parent());
      modules[$(this).attr("module_id")].text = $(this).html();
    }


    if ($(this).find('.module_ticket').length) {
    modules[$(this).attr("module_id")] = new_module_ticket($(this).attr("module_id"), $(this).parent());
    modules[$(this).attr("module_id")].text = $(this).html();
    }

    if ($(this).find('.module_news').length) {
    modules[$(this).attr("module_id")] = new_module_news($(this).attr("module_id"), $(this).parent());
    modules[$(this).attr("module_id")].text = $(this).html();
    }

    if ($(this).find('.module_dropdown').length) {
    modules[$(this).attr("module_id")] = new_module_dropdown($(this).attr("module_id"), $(this).parent());
    modules[$(this).attr("module_id")].text = $(this).find(".dropdown_module_content").html();
    modules[$(this).attr("module_id")].title = $(this).attr("title");
    }

    if ($(this).find('.module_download').length) {
    modules[$(this).attr("module_id")] = new_module_download($(this).attr("module_id"), $(this).parent());
    modules[$(this).attr("module_id")].text = $(this).attr("download_text");
    modules[$(this).attr("module_id")].fname = $(this).attr("download_fname");
    }

    if ($(this).find('.module_image').length) {
    modules[$(this).attr("module_id")] = new_module_image($(this).attr("module_id"), $(this).parent());
    modules[$(this).attr("module_id")].filename = $(this).find("img").attr("fname");
    }

    if ($(this).find('.module_gallery').length) {
    modules[$(this).attr("module_id")] = new_module_gallery($(this).attr("module_id"), $(this).parent());
    }

    if ($(this).find('.module_quote').length) {
      modules[$(this).attr("module_id")] = new_module_quote($(this).attr("module_id"), $(this).parent());
    }

    if ($(this).find('.module_download').length) {
      modules[$(this).attr("module_id")] = new_module_download($(this).attr("module_id"), $(this).parent());
    }

    if ($(this).find('.module_headline').length) {
      modules[$(this).attr("module_id")] = new_module_headline($(this).attr("module_id"), $(this).parent());
    }



    if ($(this).find('.module_pdf').length) {
      modules[$(this).attr("module_id")] = new_module_pdf($(this).attr("module_id"), $(this).parent());
      modules[$(this).attr("module_id")].filename = $(this).find(".module_pdf_name").text();
      modules[$(this).attr("module_id")].align = $(this).attr("align");
      modules[$(this).attr("module_id")].text = $(this).find(".module_pdf_text").text();
      modules[$(this).attr("module_id")].dl_type = $(this).attr("dl_type");
    }

    if ($(this).find('.module_start').length) {
      modules[$(this).attr('module_id')] = new_module_start(
        $(this).attr('module_id'),
        $(this).parent()
      )
      modules[$(this).attr('module_id')].filename = $(this).find('img').attr('fname')
      modules[$(this).attr('module_id')].description = $(this).find('img').attr('description')
      modules[$(this).attr('module_id')].title = $(this).find('img').attr('title')
      modules[$(this).attr('module_id')].img_credits = $(this).find('img').attr('img_credits')
      modules[$(this).attr('module_id')].subtitle = $(this).find('img').attr('sub_title')
    }

	  if ($(this).find('.module_related').length) {
      modules[$(this).attr("module_id")] = new_module_related($(this).attr("module_id"), $(this).parent());
    }


	  if ($(this).find('.module_column_start').length) {
      modules[$(this).attr('module_id')] = new_module_column_start(
        $(this).attr('module_id'),
        $(this).parent()
      )
    }

	  if ($(this).find('.module_column_end').length) {
      modules[$(this).attr('module_id')] = new_module_column_end(
        $(this).attr('module_id'),
        $(this).parent()
      )
    }


    if (id_increment <= parseInt($(this).attr("module_id")) + 1) id_increment = parseInt($(this).attr("module_id")) + 1;

    modules[$(this).attr("module_id")].init();

  });

  let inside = false;
  $('.newModuleParent').each(function() {
    let modType = $(this).attr('data-text')

    if(modType == "Column start module") {
      inside = true;
    } else if(modType == "Column end module") {
      inside = false;
    } else {
      if(inside) {
        $(this).addClass('insideColumn')
      }
    }
  })

  resize_col($("#col_left"));
}

function toggleButtonListeners(toggle) {

  if (toggle) {
    $("#artwork_artist").on("change", function () {
      var $this = $(this);
      var key = $this.val();

      if (key == 0) {
        $(".artwork_item").show();
      } else {
        $(".artwork_item").each(function (i, item) {
          var art_id = $(item).attr("artist_id");
          if (key == art_id) {
            $(item).show();
          } else {
            $(item).hide();
          }
        });
      }
    });

    $("#artwork_search_icon").on("click", function () {
      var filter = $("#artwork_name_search").val();

      if (filter == "") {
        $(".artwork_item").show();
      } else {
        $(".artwork_item").each(function (i, item) {
          var title = $(item).attr("data-title");

          if (title.toLowerCase().indexOf(filter.toLowerCase()) >= 0) {
            $(item).show();
          } else {
            $(item).hide();
          }
        });
      }
    });

    $("#artwork_name_search").on("change", function () {
      var filter = $(this).val();
      if (filter == "") {
        $(".artwork_item").show();
      }
    });

    $("#artwork_name_search").keypress(function (ev) {
      var keycode = ev.keyCode ? ev.keyCode : ev.which;
      if (keycode == "13") {
        $("#artwork_search_icon").click();
      }
    });

    $("#module_container .moduleMaker").click(function () {
      var $this = $(this);
      var topOff = 0;
      var parent = $("#col_left");

      if($this.attr('type') == 'column_start') {
        new_module('hr', parent, topOff);
        new_module('column_start', parent, topOff);
        new_module('column_end', parent, topOff);
        new_module('column_start', parent, topOff, true);
        new_module('column_end', parent, topOff);
        new_module('hr', parent, topOff);

      } else {
        new_module($this.attr("type"), parent, topOff);

      }

    });

    $(".crud_tab_item").click(function () {
      var tab = $(this).attr("type");

      if (tab == "module_content") {
        if ($('.crud_tab[type="' + tab + '"]').is(":visible")) {
          $(".crud_tab_item").removeClass("active");
          $(this).addClass("active");
          $(".popup_edit").hide();
          $(".crud_tab").hide();
          $('.crud_tab[type="' + tab + '"]').show();
        } else {
          if (active_module != null && !$('.crud_tab[type="' + tab + '"]').is(":visible")) {
            $(".crud_tab_item").removeClass("active");
            $(this).addClass("active");
            $(".popup_edit").hide();
            $(".crud_tab").hide();
            $('.crud_tab[type="' + tab + '"]').show();
            $(".mosaic_tool.edit").click();
          }
        }
      } else {
        $(".crud_tab_item").removeClass("active");
        $(this).addClass("active");
        $(".popup_edit").hide();
        $(".crud_tab").hide();
        $('.crud_tab[type="' + tab + '"]').show();
      }
    });


    $(".item_save").click(function () {
      if($('[type="attributes"').length){
        $('[type="attributes"').click();
      }

      // update unsaved warning 
          const date = new Date()
          const options = {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true,
          }
          let formattedDate = date.toLocaleString('en-US', options)

          // Add the appropriate suffix for the day
          const day = date.getDate()
          let daySuffix
          if (day > 3 && day < 21) daySuffix = 'th'
          switch (day % 10) {
            case 1:
              daySuffix = 'st'
              break
            case 2:
              daySuffix = 'nd'
              break
            case 3:
              daySuffix = 'rd'
              break
            default:
              daySuffix = 'th'
          }

          // Insert the day suffix into the formatted date
          formattedDate = formattedDate.replace(/(\d+),/, `$1${daySuffix},`)

          $('.unsavedWarning').html(`Last save: <br> ${formattedDate}`)
          $('.unsavedWarning').css('background-color', '#beffbf')

      saveItem();

    });



      $('.item_preview').click(function () {
        // var name = $(this).attr("name");
        $('input[name=col_pretty_url]').each(function () {
          // if ($(this).attr('name') == 'col_pretty_url') {
          window.open(rootUrl + $(this).val(), '_blank');
          // }
        });
      });

    $(".item_cancel").click(function () {


      var article_type_name = $(this).attr("article_type_name");


      window.location.href = rootUrl + 'entities/Content/' + article_type_name;
    });



    $(".item_detail_type_switch").on("click", function () {
      $(".item_detail_type_switch").removeClass("item_detail_type_active");
      $(this).addClass("item_detail_type_active");
      toggleDetailType(parseInt($(".item_detail_type_switch.item_detail_type_active").attr("detail_type")));
    });

    $("#cancel_translate").click(function () {
      $("#popup_translate_holder").hide();
    });

    $("#save_translate").click(function () {
      var new_text = $("#translate_translated").val();

      $("#popup_module_text").find("textarea").val(new_text);
      $("#popup_translate_holder").hide();
    });
  } else {
    $(".item_save").unbind("click");
    $(".item_cancel").unbind("click");
    $(".item_preview").unbind("click");
    $(".crud_tab_item").unbind("click");
    $("#module_container span").off("click");
  }
}

function toggleDetailType(detail_type) {
  switch (detail_type) {
    case 0: // IMAGE
      $("#item_detail_slider").hide();
      $("#item_detail_html").hide();
      $("#item_detailimg").show();
      $("#item_detailimg_credits").show();
      break;

    case 1: // HTML
      $("#item_detail_slider").hide();
      $("#item_detailimg").hide();
      $("#item_detailimg_credits").hide();
      $("#item_detail_html").show();
      break;

    case 2: // SLIDER
      $("#item_detailimg").hide();
      $("#item_detailimg_credits").hide();
      $("#item_detail_html").hide();
      $("#item_detail_slider").show();
      break;
  }
}

function saveItem() {

  return new Promise((resolve, reject) => {

    $('.unsavedWarning').html(`Saving ...`)
    $('.unsavedWarning').css('background-color', 'rgb(255 246 76)')

    var mods = [];
    for (var i = 0; i < id_increment; i++) {
      if (modules[i] !== undefined) {
        mods.push(modules[i].getSaveData());
      }
    }



    $.ajax({

      url: rootUrl + 'entities/Content/save_item',
      data: {
        id: $('#item_container').attr('item_id'),
        name: $('#item_headline').html(),
        modules: mods,
      },
      method: 'POST',

      success: function (data) {
        var ret = $.parseJSON(data);

        if (ret.success) {
          showMessage('success', 'Modules successfully updated')
          resolve(true)

          // for the save unsave info button
          // update unsaved warning
          const date = new Date()
          const options = {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true,
          }
          let formattedDate = date.toLocaleString('en-US', options)

          // Add the appropriate suffix for the day
          const day = date.getDate()
          let daySuffix
          if (day > 3 && day < 21) daySuffix = 'th'
          switch (day % 10) {
            case 1:
              daySuffix = 'st'
              break
            case 2:
              daySuffix = 'nd'
              break
            case 3:
              daySuffix = 'rd'
              break
            default:
              daySuffix = 'th'
          }

          // Insert the day suffix into the formatted date
          formattedDate = formattedDate.replace(/(\d+),/, `$1${daySuffix},`)

          $('.unsavedWarning').html(`Last save: <br> ${formattedDate}`)
          $('.unsavedWarning').css('background-color', 'rgb(165 255 166)')
        } else {
          showMessage(
            'error',
            'Something went wrong. Please contact your dev team to check error log.',
          );
          reject(false);
        }
      },
      error: function (error) {
        reject(error);
      },

    });

  });

}





function previewItem(name) {
 var mods = [];
  for (var i = 0; i < id_increment; i++) {
    if (modules[i] !== undefined) {
      mods.push(modules[i].getSaveData());
    }
  }

  var gallery_items = [];
  $("#gallery")
    .find(".gallery_item")
    .each(function () {
      gallery_items.push({ filename: $(this).attr("filename"), credits: br2nl($(this).find("div").html()) });
    });

  $.ajax({
    url: rootUrl + 'entities/Content/preview_item/'+$('#item_container').attr('item_id'),
  //  url: "https://hdgoe.at/preview_item/" + $("#item_container").attr("item_id"),
    data: {
      id: $("#item_container").attr("item_id"),
      name: $("#item_headline").html(),
      modules: mods,
      gallery_items: gallery_items,
    },
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);

      if (ret.success) {
        var w = window.open("about:blank");
        w.document.open();
        w.document.write(ret.html);
        w.document.close();
        /*$('#preview_content').empty().html(ret.html);
				$('#preview_overlay').show();
				toggleButtonListeners(true);*/
      } else {
        alert("Error");
      }
    },
  });
}

function saveItemContact() {
  var mods = [];
  for (var i = 0; i < id_increment; i++) {
    if (modules[i] !== undefined) {
      mods.push(modules[i].getSaveData());
    }
  }

  $.ajax({
    url: rootUrl + "entities/Content/save_item_contact",
    data: {
      id: $("#item_container").attr("item_id"),
      name: $("#item_headline").html(),
      modules: mods,
    },
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);

      if (ret.success) {
        alert("Save successful!");
        //window.location.href = rootUrl + 'entities/item/items';
      } else {
        alert("Error while saving");
      }
    },
  });
}

function saveItemCV() {
  var mods = [];
  for (var i = 0; i < id_increment; i++) {
    if (modules[i] !== undefined) {
      mods.push(modules[i].getSaveData());
    }
  }

  $.ajax({
    url: rootUrl + "entities/Content/save_item_cv",
    data: {
      id: $("#item_container").attr("item_id"),
      name: $("#item_headline").html(),
      modules: mods,
    },
    method: "POST",
    success: function (data) {
      var ret = $.parseJSON(data);

      if (ret.success) {
        alert("Save successful!");
        //window.location.href = rootUrl + 'entities/item/items';
      } else {
        alert("Error while saving");
      }
    },
  });
}


function igniteSelectors() {

  $('.bc_filtering').find('select').select2();

  // col_name="table"
  var selectors = [];

  selectors.forEach((selector) => {
    if($(selector).length > 0){
      $(selector).select2();
    }
  });



}

function igniteCKEditor() {

      // requires $(#module_ + string) to exist and within module the editor is called same as string
      var module_ckeditors = ['text_editor', 'headline_editor', 'collapsable_editor']

      module_ckeditors.forEach((e) => {


        if($('#module_' + e).length > 0){
        ClassicEditor.create(document.querySelector('#module_' + e), {
          toolbar: ckeditor_toolbar,
          link: {
            decorators: {
              openInNewTab: {
                mode: 'manual',
                label: 'Open in a new tab',
                attributes: {
                  target: '_blank',
                  rel: 'noopener noreferrer',
                },
              },
            },
          },
        })
          .then((editor) => {
            window[e] = editor;
          })
          .catch((error) => {
            console.error(error);
          });
      }

      });


  }





function igniteDragging() {

 	if($("#module_container span").length > 0)
	{
	  $("#module_container span").draggable({
	    helper: "clone",
	    refreshPositions: true,
	  });

	  $(".col").droppable({
	    accept: "#module_container span",
	    drop: function (event, ui) {
	      var topOff = ui.offset.top;

	      new_module(ui.draggable.attr("type"), $(this), topOff);
	    },
	  });
	}

}

function new_module(module_type, parent, topOff, $rightColStart = false) {
  var new_module = null;


  if (module_names.includes(module_type)) {
    const functionName = `new_module_${module_type}`;
    if (typeof window[functionName] === "function") {
      modules[id_increment] = window[functionName](...(module_type === "column_start" ? [id_increment, parent, $rightColStart] : [id_increment, parent]));
    } else {
      console.warn(`Function ${functionName} does not exist.`);
    }
  } else {
    console.warn(`Module type ${module_type} is not recognized.`);
  }



  if (parent.find(".newModuleParent").length < 1) {
    parent.append(modules[id_increment].getPrototypeHTML());

  } else {

    var i = 0;
    parent.children(".newModuleParent").each(function () {
      if ($(this).offset().top >= topOff) {

        //compare
        var html = modules[id_increment].getPrototypeHTML();

        // old version
        // $(html).insertBefore($(this));

        // append below (has to be tested)
        parent.append(modules[id_increment].getPrototypeHTML())
        $("#item_container").scrollTop($("#item_container")[0].scrollHeight);

        i = 1;
        return false; //break loop
      }
    });

    if (i != 1) {
      parent.append(modules[id_increment].getPrototypeHTML());
    }

  }

  modules[id_increment].init();
  resize_col(parent);
  // position_tools();
  id_increment++;
}

function toggleScrollListeners(toggle) {
  if (toggle) {
    $("#content").scroll(function () {
      $("#control_container").css({ top: $("#content").scrollTop() + 100 });
    });
  } else {
    $("#content").unbind("scroll");
  }
}










function nl2br(str, is_xhtml) {
  var breakTag = is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
  return (str + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1" + breakTag + "$2");
}

function br2nl(str) {
  return str.replace(/<br>/g, "\r");
}

function resize_col($col) {
  var min_height = 0;
  $col.find(".newModuleParent").each(function () {
    if (min_height < parseInt($(this).height()) + $(this).position().top + 2) min_height = parseInt($(this).height()) + $(this).position().top + 2;
  });

  if (min_height == 0) min_height = 40;

  $col.css({ "min-height": min_height });
  return min_height;
}

function closeRepo() {
  $("#close_repo").removeClass("selected_items");
  $("#repo_overlay").fadeOut(100);
  //$('.mosaic_tool.edit').click();

  //
  // $('.repo_item_select').removeClass("selected");
  $(".repo_item_select").parent().removeClass("selected_item");
}

function toggleEditItemListeners(toggle) {
  if (toggle) {
    $(".artwork_item").on("click", function () {
      $this = $(this).find(".artwork_item_select");
      var artwork_id = $this.attr("iid");
      var img = $this.attr("img");
      var title = $this.attr("title");

      if (!$(this).hasClass("selected_item")) {
        var fullPath = img;

        active_id = active_module.attr("module_id");

        var mod_id = active_module.attr("module_id");

        for (var i = 0; i < modules.length; i++) {
          if (modules[i] !== undefined) {
            if (modules[i].id == mod_id) {
              active_id = i;
              break;
            }
          }
        }

        toggleGalleryListener(false);
        var elem =
          '<div class="module_artwork_item" ordering="999" artwork_id="' +
          artwork_id +
          '">' +
          '<div class="gallery_item_remove">X</div>' +
          '<img style="width:120px;float:left;" src="' +
          fullPath +
          '" />' +
          '<div class="item_data_holder">' +
          "<div>" +
          title +
          "</div>" +
          "</div>" +
          "</div>";

        active_module.append(elem);

        toggleGalleryListener(true);
        $this.addClass("selected");
        $(this).addClass("selected_item");
      } else {
        active_module
          .find('.module_artwork_item[artwork_id="' + artwork_id + '"]')
          .find(".gallery_item_remove")
          .click();
        $this.removeClass("selected");
        $(this).removeClass("selected_item");
      }

      // position_tools(active_module);
    });

    $("#close_repo").on("click", function () {
      closeRepo();
    });

    $("#repo_category").on("change", function () {
      var category_id = $(this).val();

      if (category_id == 0) {
        $(".repo_item").show();
      } else {
        $(".repo_item").each(function (i, item) {
          var cid = $(this).attr("cid");
          if (cid == category_id) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }
    });

     $('#repo_tag_module').on('change', function () {
          var tag_id = $(this).val();
          // var category_id = $(this).val();

          if (tag_id == 0) {
            $('.repo_item').show();
          } else {
            $('.repo_item').each(function () {
              $(this).hide();
              var tags = $(this).attr('repo_tags');

              if (tags.includes(tag_id.toString())) {
                $(this).show();
              }
            });
          }
        });

    /********************************************************************************************
     * HEADLINE
     *********************************************************************************************/
    $("#item_headline").dblclick(function () {
      //	popup_edit_text($(this));
    });

    /********************************************************************************************
     * DETAIL HTML
     *********************************************************************************************/
    $("#item_detail_html").dblclick(function () {
      popup_edit_html($("#item_detail_html_content"));
    });

    /********************************************************************************************
     * DETAIL PHOTOCREDITS
     *********************************************************************************************/
    $("#item_detailimg_credits").dblclick(function () {
      popup_edit_text($(this));
    });

    /********************************************************************************************
     * HEADER
     *********************************************************************************************/
    $("#item_header").dblclick(function () {
      popup_edit_header($(this));
    });

    /********************************************************************************************
     * DETAILIMAGE
     *********************************************************************************************/
    $("#item_detailimg img").dblclick(function () {
      if ($(this).attr("filename") == "" || $(this).attr("filename") == "image_upload_placeholder.png") $(this).parent().find("input").click();
      else {
        $("#detail_img_dialog").dialog({
          modal: true,
          buttons: [
            {
              text: "Delete",
              click: function () {
                $("#item_detailimg img").attr("src", rootUrl + "items/uploads/detailimg/image_upload_placeholder.png");
                $("#item_detailimg img").attr("filename", "image_upload_placeholder.png");
                $(this).dialog("close");
              },
            },
            {
              text: "Upload new",
              click: function () {
                $(this).dialog("close");
                $("#item_detailimg img").parent().find("input").click();
              },
            },
          ],
        });
      }
    });

    $("#item_detailimg input").change(function () {
      var uploadpath = $(this).attr("uploadpath");
      var xhr = new XMLHttpRequest();
      var fd = new FormData();
      var files = this.files;

      fd.append("data", files[0]);
      fd.append("filename", files[0].name);
      fd.append("uploadpath", uploadpath);

      xhr.addEventListener("load", function (e) {
        var ret = $.parseJSON(this.responseText);

        if (ret.success) {
          $("#item_detailimg img").attr("src", rootUrl + $("#item_detailimg input").attr("uploadpath") + "/" + ret.filename);
          $("#item_detailimg img").attr("filename", ret.filename);
        } else {
          alert("Error while uploading");
        }
      });

      xhr.open("post", rootUrl + "entities/Content/upload_image");
      xhr.send(fd);
    });

    /********************************************************************************************
     * RELATED TAGS
     *********************************************************************************************/
    $("#item_rel_tags").dblclick(function () {
      popup_edit_rel_tags();
    });

    /********************************************************************************************
     * RELATED ITEMS
     *********************************************************************************************/
    $("#item_rel_items").dblclick(function () {
      popup_edit_rel_items();
    });

    /********************************************************************************************
     * GALLERY
     *********************************************************************************************/
    $("#gallery").dblclick(function () {
      popup_gallery();
    });

    /********************************************************************************************
     * GALLERY
     *********************************************************************************************/
    $("#item_detail_slider_overlay").dblclick(function () {
      popup_slider();
    });
  } else {
    $("#item_header").unbind("dblclick");
    $("#item_detailimg img").unbind("dblclick");
    $("#item_headline").unbind("dblclick");
    $("#item_rel_tags").unbind("dblclick");
    $(".artwork_item").unbind("click");
    $("#close_repo").unbind("click");
    $("#repo_category").unbind("change");
    $("#repo_tag_module").unbind("change");
  }
}

function popup_edit_html(text_element) {
  $("#popup_edit_html").find(".popup_cancel_button").unbind("click");
  $("#popup_edit_html").find(".popup_save_button").unbind("click");

  $("#popup_edit_html").find(".popup_edit_container.desktop textarea").val($("#item_detail_html_content").html());
  $("#popup_edit_html").find(".popup_edit_container.mobile textarea").val($("#item_detail_html_content_mobile").html());
  $("#popup_edit_html").show();

  $("#popup_edit_html")
    .find(".popup_save_button")
    .click(function () {
      $("#item_detail_html_content").html($("#popup_edit_html").find(".popup_edit_container.desktop textarea").val());
      $("#item_detail_html_content_mobile").html($("#popup_edit_html").find(".popup_edit_container.mobile textarea").val());
      $("#popup_edit_html").hide();
    });

  $("#popup_edit_html")
    .find(".popup_cancel_button")
    .click(function () {
      $("#popup_edit_html").hide();
    });
}

function popup_edit_text(text_element) {
  $("#popup_edit_text").find(".popup_cancel_button").unbind("click");
  $("#popup_edit_text").find(".popup_save_button").unbind("click");

  $("#popup_edit_text").find("textarea").val(text_element.text());
  $("#popup_edit_text").show();

  $("#popup_edit_text")
    .find(".popup_save_button")
    .click(function () {
      text_element.html(nl2br($("#popup_edit_text").find("textarea").val(), false));
      $("#popup_edit_text").hide();
    });

  $("#popup_edit_text")
    .find(".popup_cancel_button")
    .click(function () {
      $("#popup_edit_text").hide();
    });
}

function popup_edit_header(element) {
  var html = "";
  $("#item_header span").each(function () {
    if (html != "") html += "\n";
    html += $(this).html();
  });

  $("#popup_edit_text").find("textarea").val(html);

  $("#popup_edit_text").find(".popup_cancel_button").unbind("click");
  $("#popup_edit_text").find(".popup_save_button").unbind("click");

  $("#popup_edit_text").show();

  $("#popup_edit_text")
    .find(".popup_save_button")
    .click(function () {
      if ($("#popup_edit_text").find("textarea").val() != "") var lines = $("#popup_edit_text").find("textarea").val().split("\n");
      var html = "";
      if (lines !== undefined) {
        for (var i = 0; i < lines.length; i++) {
          html += '<span style="padding-right: ' + lines[i].length + 'px;">' + lines[i] + "</span>";
          if (i != lines.length - 1) {
            html += "<br/>";
          }
        }
      }

      $("#popup_edit_text").hide();
      element.html(html);
    });

  $("#popup_edit_text")
    .find(".popup_cancel_button")
    .click(function () {
      $("#popup_edit_text").hide();
    });
}

/*********************************************************************************************************************************************************************
 * RELATED TAGS
 **********************************************************************************************************************************************************************/
function popup_edit_rel_tags() {
  toggleRelatedMetatagsListeners(false);
  toggleRelatedMetatagSubListeners(false);

  $("#related_tags_selected").empty();
  $("#related_tags_metatags span").show();
  $("#item_rel_tags span").each(function () {
    $("#related_tags_selected").append('<span metatag_id="' + $(this).attr("metatag_id") + '" url="' + $(this).attr("url") + '">' + $(this).text() + "</span>");
    $('.related_tags_metatags span[metatag_id="' + $(this).attr("metatag_id") + '"]').hide();
  });

  toggleRelatedMetatagsListeners(true);
  toggleRelatedMetatagSubListeners(true);

  $("#popup_related_tags").show();
}

function toggleRelatedMetatagsListeners(toggle) {
  if (toggle) {
    $("#external_tag_add").on("click", function () {
      $("#related_tags_selected").append('<span metatag_id="null" url="' + $("#external_tag_url").val() + '">' + $("#external_tag_text").val() + "</span>");
      toggleRelatedMetatagSubListeners(false);
      toggleRelatedMetatagSubListeners(true);
    });

    $("#related_tags_category").change(function () {
      $(this).parent().find(".related_tags_metatags").hide();
      $(this)
        .parent()
        .find('.related_tags_metatags[category_id="' + $(this).val() + '"]')
        .show();
    });

    $(".related_tags_metatags span").on("click", function () {
      //$(this).clone(false).appendTo($('#related_tags_selected'));
      $("#related_tags_selected").append('<span metatag_id="' + $(this).attr("metatag_id") + '" url="null">' + $(this).text() + "</span>");
      $(this).hide();
      toggleRelatedMetatagSubListeners(false);
      toggleRelatedMetatagSubListeners(true);
    });

    $("#popup_related_tags")
      .find(".popup_save_button")
      .click(function () {
        $("#item_rel_tags").empty();
        $("#related_tags_selected span").each(function () {
          $("#item_rel_tags").append('<span metatag_id="' + $(this).attr("metatag_id") + '" url="' + $(this).attr("url") + '">' + $(this).text() + "</span>");
        });
        $("#popup_related_tags").hide();
      });

    $("#popup_related_tags")
      .find(".popup_cancel_button")
      .click(function () {
        $("#popup_related_tags").hide();
      });
  } else {
    $("#external_tag_add").off("click");
    $("#related_tags_category").unbind("change");
    $(".related_tags_metatags span").off("click");
    $("#popup_related_tags").find(".popup_cancel_button").unbind("click");
    $("#popup_related_tags").find(".popup_save_button").unbind("click");
  }
}

function toggleRelatedMetatagSubListeners(toggle) {
  if (toggle) {
    $("#related_tags_selected span").on("click", function () {
      $('.related_tags_metatags span[metatag_id="' + $(this).attr("metatag_id") + '"]').show();
      $(this).remove();
    });
  } else {
    $("#related_tags_selected span").off("click");
  }
}

/*********************************************************************************************************************************************************************
 * RELATED ITEMS
 **********************************************************************************************************************************************************************/
function popup_edit_rel_items() {
  toggleRelatedItemsListener(false);

  $("#related_items_selected").empty();
  $(".item_rel_item").each(function () {
    $("#related_items_selected").append(
      '<span item_id="' + $(this).attr("item_id") + '" filename="' + $(this).find("img").attr("filename") + '">' + $(this).find(".item_rel_item_name").text() + "</span>"
    );
  });

  toggleRelatedItemsListener(true);
  $("#popup_related_items").show();
}

function toggleRelatedItemsListener(toggle) {
  if (toggle) {
    $("#popup_related_items")
      .find(".popup_save_button")
      .click(function () {
        $("#item_rel_items").empty();
        $("#related_items_selected span").each(function () {
          $("#item_rel_items").append(
            '<div class="item_rel_item" item_id="' +
              $(this).attr("item_id") +
              '"><img src="' +
              rootUrl +
              "items/uploads/detailimg/" +
              $(this).attr("filename") +
              '" /><div class="item_rel_item_name unselectable">' +
              $(this).text() +
              "</div></div>"
          );
        });
        fitPreviewImages();
        $("#popup_related_items").hide();
      });

    $("#popup_related_items")
      .find(".popup_cancel_button")
      .click(function () {
        $("#popup_related_items").hide();
      });

    $("#related_items_category").change(function () {
      $("#popup_related_items").find(".related_items_metatags").hide();
      $("#popup_related_items")
        .find('.related_items_metatags[category_id="' + $(this).val() + '"]')
        .show();
    });

    $("#popup_related_items span").click(function () {
      if ($(this).parent().hasClass("related_items_metatags")) {
        $(this).clone(true).appendTo($("#related_items_tags_selected"));
        $(this).hide();
      } else {
        $('.related_items_metatags span[metatag_id="' + $(this).attr("metatag_id") + '"]').show();
        $(this).remove();
      }

      var metatags = [];
      $("#related_items_tags_selected span").each(function () {
        metatags.push($(this).attr("metatag_id"));
      });

      $.ajax({
        url: rootUrl + "entities/Item/getItemsPerMetatags",
        data: { metatags: metatags },
        method: "POST",
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            $("#related_items_itemlist").empty();
            for (var i = 0; i < ret.items.length; i++) {
              var style = "";
              if ($('#related_items_selected span[item_id="' + ret.items[i].id + '"]').length != 0) style = 'style="display: none;"';

              $("#related_items_itemlist").append("<span " + style + '  item_id="' + ret.items[i].id + '" filename="' + ret.items[i].detailimg + '">' + ret.items[i].name + "</span>");
            }

            $("#related_items_itemlist span, #related_items_selected span").unbind("click");
            $("#related_items_itemlist span, #related_items_selected span").click(function () {
              if ($(this).parent().attr("id") == "related_items_itemlist") {
                console.log("select");
                $(this).clone(true).appendTo("#related_items_selected");
                $(this).hide();
              } else {
                $('#related_items_itemlist span[item_id="' + $(this).attr("item_id") + '"]').show();
                $('#related_items_selected span[item_id="' + $(this).attr("item_id") + '"]').remove();
              }
            });
          } else {
            alert("Error while retrieving items");
          }
        },
      });
    });
  } else {
    $("#popup_related_items span").unbind("click");
    $("#related_items_category").unbind("change");
    $("#popup_related_items").find(".popup_cancel_button").unbind("click");
    $("#popup_related_items").find(".popup_save_button").unbind("click");
  }
}

/*********************************************************************************************************************************************************************
 * GALLERY
 **********************************************************************************************************************************************************************/
function popup_gallery() {
  toggleGalleryListener(false);

  $("#gallery_items").empty();
  $("#gallery")
    .find(".gallery_item")
    .each(function () {
      $("#gallery_items").append(
        '<div class="gallery_item" filename="' +
          $(this).attr("filename") +
          '"><img src="' +
          rootUrl +
          "items/uploads/gallery/" +
          $(this).attr("filename") +
          '" /><textarea>' +
          br2nl($(this).find("div").html()) +
          "</textarea></div>"
      );
    });

  $("#gallery_items")
    .find(".gallery_item img")
    .dblclick(function () {
      $(this).parent().remove();
    });

  $("#gallery_items").sortable();

  toggleGalleryListener(true);
  $("#popup_gallery").show();
}

/*function toggleGalleryListener(toggle)
{
	if(toggle)
	{
		$('#gallery_upload_button').click(function()
		{
			$('#gallery_upload_input').click();
		});

		$('#gallery_upload_input').change(function()
		{
			var uploadpath = 'items/uploads/gallery';
			var xhr = new XMLHttpRequest();
			var fd = new FormData;
			var files = this.files;

			fd.append('data', files[0]);
			fd.append('filename', files[0].name);
			fd.append('uploadpath', uploadpath);

			xhr.addEventListener('load', function(e)
			{
				var ret = $.parseJSON(this.responseText);

				if(ret.success)
				{
					html = '<div class="gallery_item" filename="' + ret.filename + '"><img src="' + rootUrl + 'items/uploads/gallery/' + ret.filename + '" /><textarea></textarea></div>';
					$('#gallery_items').append(html);

					$('#gallery_items').find('.gallery_item').unbind('dblclick');
					$('#gallery_items').find('.gallery_item').dblclick(function()
					{
						$(this).remove();
					});

					$('#gallery_items').sortable();
				}
				else
				{
					alert('Error while uploading');
				}
		    });

			xhr.open('post', rootUrl + 'entities/Website/upload_image');
			xhr.send(fd);

		});

		$('#popup_gallery').find('.popup_cancel_button').click(function()
		{
			$('#popup_gallery').hide();
		});

		$('#popup_gallery').find('.popup_save_button').click(function()
		{
			$('#gallery').empty();
			$('#gallery_items').find('.gallery_item').each(function()
			{
				$('#gallery').append('<div class="gallery_item" filename="' + $(this).attr('filename') + '"><img src="' + rootUrl + 'items/uploads/gallery/' + $(this).attr('filename') + '" /><div>' + nl2br($(this).find('textarea').val()) + '</div></div>');
			});
			fitPreviewImages();
			$('#popup_gallery').hide();
		});
	}
	else
	{
		$('#gallery_upload_input').unbind('change');
		$('#gallery_upload_button').unbind('click');
		$('#popup_gallery').find('.popup_cancel_button').unbind('click');
		$('#popup_gallery').find('.popup_save_button').unbind('click');
	}
}*/

/*********************************************************************************************************************************************************************
 * SLIDER
 **********************************************************************************************************************************************************************/
function popup_slider() {
  toggleSliderListener(false);

  $("#slider_items").empty();
  $("#item_detail_slider_content")
    .find(".slider_item_real")
    .each(function () {
      var clone = $(".slideritem_dummy").clone();
      clone.addClass("slider_item");
      clone.removeClass("slideritem_dummy");
      clone.attr("filename", $(this).attr("filename"));
      clone.children("img").attr("src", rootUrl + "items/uploads/slider/" + $(this).attr("filename"));
      clone.find("select").val($(this).attr("link_to_item"));
      clone.find(".slider_item_credits").val(br2nl($(this).find(".slider_credits").html()));

      var html = "";
      $(this)
        .find(".slider_text span")
        .each(function () {
          if (html != "") html += "\n";
          html += $(this).html();
        });

      clone.find(".slider_item_text").val(html);

      $("#slider_items").append(clone);
    });

  igniteCombobox();

  $("#slider_items")
    .find(".delete")
    .click(function () {
      $(this).parent().parent().remove();
    });

  $("#slider_interval").val(parseInt($("#item_detail_slider_content").attr("slider_interval")));

  $("#slider_items").sortable({
    handle: ".move",
  });

  toggleSliderListener(true);
  $("#popup_slider").show();
}

// function toggleSliderListener(toggle) {
//   if (toggle) {
//     $("#slider_upload_button").click(function () {
//       $("#slider_upload_input").click();
//     });

//     $("#slider_upload_input").change(function () {
//       var uploadpath = "items/uploads/slider";
//       var xhr = new XMLHttpRequest();
//       var fd = new FormData();
//       var files = this.files;

//       fd.append("data", files[0]);
//       fd.append("filename", files[0].name);
//       fd.append("uploadpath", uploadpath);

//       xhr.addEventListener("load", function (e) {
//         var ret = $.parseJSON(this.responseText);

//         if (ret.success) {
//           var clone = $(".slideritem_dummy").clone();
//           clone.addClass("slider_item");
//           clone.removeClass("slideritem_dummy");
//           clone.attr("filename", ret.filename);
//           clone.children("img").attr("src", rootUrl + "items/uploads/slider/" + ret.filename);

//           $("#slider_items").append(clone);

//           $("#slider_items").find(".delete").unbind("click");
//           $("#slider_items")
//             .find(".delete")
//             .click(function () {
//               $(this).parent().parent().remove();
//             });

//           $("#slider_items").sortable();
//         } else {
//           alert("Error while uploading");
//         }
//       });

//       xhr.open("post", rootUrl + "entities/Content/upload_image");
//       xhr.send(fd);
//     });

//     $("#popup_slider")
//       .find(".popup_cancel_button")
//       .click(function () {
//         $("#popup_slider").hide();
//       });

//     $("#popup_slider")
//       .find(".popup_save_button")
//       .click(function () {
//         $("#item_detail_slider_content").empty();
//         var i = 0;
//         $("#slider_items")
//           .find(".slider_item")
//           .each(function () {
//             var sliderhtml = '<div class="slider_item_real" filename="' + $(this).attr("filename") + '" link_to_item="' + $(this).find("select").val() + '" style="left: ' + i * 900 + 'px;" >';
//             sliderhtml += '<img src="' + rootUrl + "items/uploads/slider/" + $(this).attr("filename") + '" />';
//             sliderhtml += '<div class="slider_credits">' + nl2br($(this).find(".slider_item_credits").val()) + "</div>";

//             var lines = $(this).find(".slider_item_text").val().split("\n");
//             var html = "";
//             if (lines !== undefined) {
//               for (var j = 0; j < lines.length; j++) {
//                 html += '<span style="padding-right: ' + lines[j].length + 'px;">' + lines[j] + "</span>";
//                 if (j != lines.length - 1) {
//                   html += "<br/>";
//                 }
//               }
//             }
//             sliderhtml += '<div class="slider_text">' + html + "</div>";
//             sliderhtml += "</div>";

//             $("#item_detail_slider_content").append(sliderhtml);
//             i++;
//           });

//         $("#item_detail_slider_content").attr("slider_interval", $("#slider_interval").val());

//         igniteSlider();

//         $("#popup_slider").hide();
//       });
//   } else {
//     $("#slider_upload_input").unbind("change");
//     $("#slider_upload_button").unbind("click");
//     $("#popup_slider").find(".popup_cancel_button").unbind("click");
//     $("#popup_slider").find(".popup_save_button").unbind("click");
//   }
// }

// function igniteSlider() {
//   imagesLoaded($("#item_detail_slider_content"), function () {
//     clearInterval(sliderHandle);
//     var maxheight = 0;
//     $("#item_detail_slider_content")
//       .find(".slider_item_real")
//       .each(function () {
//         if (parseInt($(this).height()) > maxheight) maxheight = parseInt($(this).height());
//       });
//     $("#item_detail_slider_content").height(maxheight == 0 ? 16 : maxheight);

//     if ($("#item_detail_slider_content").attr("slider_interval") > 0) {
//       sliderHandle = setInterval(function () {
//         $(".slider_item_real").animate({ left: "-=900" }, function () {
//           $(".slider_item_real").each(function () {
//             if (parseInt($(this).css("left")) < 0) {
//               $(this).css({ left: 900 * ($(".slider_item_real").length - 1) });
//             }
//           });
//         });
//       }, $("#item_detail_slider_content").attr("slider_interval") * 1000);
//     }
//   });
// }

function igniteCombobox() {
  $(".combobox_dummy").scombobox({
    fullMatch: true,
    // when fullMatch is true
    // then highligh is also true by default
  });
}

function fitPreviewImages() {
  /*$('#gallery .gallery_item img, #item_rel_items .item_rel_item img').each(function()
	{
		fitImage($(this), $(this).get(0).naturalWidth, $(this).get(0).naturalHeight, $(this).parent().width(), $(this).parent().height());
	});*/
}

function fitImage(image, iWidth, iHeight, wWidth, wHeight) {
  var new_height = 0;
  var new_width = 0;

  var ratio = iWidth / iHeight;

  if (wWidth > wHeight) {
    new_height = wHeight;
    new_width = parseInt(wHeight * ratio);
    if (new_width < wWidth) {
      new_width = wWidth;
      new_height = parseInt(wWidth / ratio);
      left = 0;
      top = parseInt((new_height - wHeight) / -2);
    } else {
      top = 0;
      left = parseInt((new_width - wWidth) / -2);
    }
  } else {
    new_width = wWidth;
    new_height = parseInt(wWidth / ratio);
    if (new_height < wHeight) {
      new_height = wHeight;
      new_width = parseInt(wHeight * ratio);
      top = 0;
      left = parseInt((new_width - wWidth) / -2);
    } else {
      left = 0;
      top = parseInt((new_height - wHeight) / -2);
    }
  }

  image.css({ width: new_width, height: new_height, left: left, top: top });
}

$.widget("custom.combobox", {
  _create: function () {
    this.wrapper = $("<span>").addClass("custom-combobox").insertAfter(this.element);

    this.element.hide();
    this._createAutocomplete();
    this._createShowAllButton();
  },

  _createAutocomplete: function () {
    var selected = this.element.children(":selected"),
      value = selected.val() ? selected.text() : "";

    this.input = $("<input>")
      .appendTo(this.wrapper)
      .val(value)
      .attr("title", "")
      .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
      .autocomplete({
        delay: 0,
        minLength: 0,
        source: $.proxy(this, "_source"),
        appendTo: "#popup_slider",
      })
      .tooltip({
        classes: {
          "ui-tooltip": "ui-state-highlight",
        },
      });

    this._on(this.input, {
      autocompleteselect: function (event, ui) {
        ui.item.option.selected = true;
        this._trigger("select", event, {
          item: ui.item.option,
        });
      },

      autocompletechange: "_removeIfInvalid",
    });
  },

  _createShowAllButton: function () {
    var input = this.input,
      wasOpen = false;

    $("<a>")
      .attr("tabIndex", -1)
      .attr("title", "Show All Items")
      .tooltip()
      .appendTo(this.wrapper)
      .button({
        icons: {
          primary: "ui-icon-triangle-1-s",
        },
        text: false,
      })
      .removeClass("ui-corner-all")
      .addClass("custom-combobox-toggle ui-corner-right")
      .on("mousedown", function () {
        wasOpen = input.autocomplete("widget").is(":visible");
      })
      .on("click", function () {
        input.trigger("focus");

        // Close if already visible
        if (wasOpen) {
          return;
        }

        // Pass empty string as value to search for, displaying all results
        input.autocomplete("search", "");
      });
  },

  _source: function (request, response) {
    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
    response(
      this.element.children("option").map(function () {
        var text = $(this).text();
        if (this.value && (!request.term || matcher.test(text)))
          return {
            label: text,
            value: text,
            option: this,
          };
      })
    );
  },

  _removeIfInvalid: function (event, ui) {
    // Selected an item, nothing to do
    if (ui.item) {
      return;
    }

    // Search for a match (case-insensitive)
    var value = this.input.val(),
      valueLowerCase = value.toLowerCase(),
      valid = false;
    this.element.children("option").each(function () {
      if ($(this).text().toLowerCase() === valueLowerCase) {
        this.selected = valid = true;
        return false;
      }
    });

    // Found a match, nothing to do
    if (valid) {
      return;
    }

    // Remove invalid value
    this.input
      .val("")
      .attr("title", value + " didn't match any item")
      .tooltip("open");
    this.element.val("");
    this._delay(function () {
      this.input.tooltip("close").attr("title", "");
    }, 2500);
    this.input.autocomplete("instance").term = "";
  },

  _destroy: function () {
    this.wrapper.remove();
    this.element.show();
  },
});

function openFilemanager(moduleType, moduleId) {
  $("#filemanPanel iframe").attr("src", rootUrl + "fileman_custom/index.html?integration=custom" + "&module_type=" + moduleType + "&id=" + moduleId);
  $("#filemanPanel").dialog({
    width: parseInt($(window).width() * 0.8),
    height: parseInt($(window).height() * 0.8),
    modal: true,
  });
}

function closeFilemanager() {
  $("#filemanPanel").dialog("destroy");
}

function tooltips() {
  $("#module_container span").tooltip({
    track: true,
    tooltipClass: "ui-tooltip",
  });
  $("#button_container span").tooltip({
    track: true,
  });
}

function toggleRelatedListener(toggle) {

$('#module_related_type').on('change', function(){
      var type = $(this).val();

      // console.log(type);


       $('.relSelector').hide();
      $('.' + type + 'Selector').show()


});


  if (toggle) {
    $(".module_related_item_remove").click(function () {
      $(this).parent().remove();
    });




    $('.related_add_article_button').click(function(){
      toggleRelatedListener(false)
      var counter = $("#popup_edit_related_holder").find('.module_related_item').length;

      var next_i = parseInt(counter) + parseInt(1);
      var rel_id = $('#related_articles_select').val();
      var article_name = $('#related_articles_select option:selected').text();
      var type = "articles";
      var elem =  '<div style="position:relative" class="module_related_item ui-rounded1" ordering="' + next_i + '" rel_id="' + rel_id +'" type="' + type +'">' +
          '<div class="module_related_item_remove"></div>' +
          '<div class="item_data_holder_rel">' +article_name + '</div>' +
        "</div>";


       if(rel_id != 0 && rel_id !== null)
       {
         $("#popup_edit_related_holder").append(elem);
       }


      toggleRelatedListener(true)
      dragAndDropSelectors(); // making items sortable
    });

  } else {
    $(".module_related_item_remove").off("click");
    $('#module_related_type').off('change');
    $('.related_add_article_button').off('click');
  }
}

function toggleGalleryListener(toggle) {
  if (toggle) {
    $(".gallery_item_remove").click(function () {
      $(this).parent().remove();
    });
  } else {
    $(".gallery_item_remove").off("click");
  }
}

/*
$('#module_container span').on('mouseover',function(e){
		var $this = $(this);
		var title = $this.attr('title');

		var left = e.pageX + 10;
		var top = e.pageY - 100;
		 	$('#tooltip').text(title).css({top: top,left: left}).show();
	});

	$('#module_container span').on('mouseout',function(){
		$('#tooltip').hide();
	});
}
*/
