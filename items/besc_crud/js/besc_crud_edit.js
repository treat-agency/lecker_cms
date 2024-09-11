
var bc_and_go_back = false;

$(document).ready(function () {


  if (typeof(bc_edit_or_add) != 'undefined' && bc_edit_or_add == 0) bc_bindAddListeners();
  else bc_bindEditListeners();

  bc_addMNRelationListeners();
  bc_addImageListeners();
  bc_addRepoImageListeners();
  //bc_addMultilineListeners();
  bc_addDatepickerListeners();
  bc_addComboboxListeners();
  bc_positionMNRelationSearchbox();
  bc_addFileListeners();
  bc_igniteCKEditor();
  bc_igniteColorpicker();
  // bc_igniteRepoText();
});

function bc_igniteColorpicker() {
  $('.bc_col_colorpicker input').each(function () {
    $(this).spectrum({
      preferredFormat: 'hex',
      showInput: $(this).attr('hexinput') == '1',
    });
  });
}

//CKEDITORstart

var ckeditors = [];

function bc_igniteCKEditor() {
  const editors = document.querySelectorAll('.bc_ck_editor');

  editors.forEach((el, i) => {

    ClassicEditor.create(el, {
      placeholder: el.getAttribute('placeholder'),
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
      .then((newEditor) => {
        ckeditors[i] = newEditor;
        newEditor.ui.view.editable.element.style.height =
          el.getAttribute('height');
      })
      .catch((error) => {
        console.error(error);
      });
  });

  const editorsrepo = document.querySelectorAll('.bc_ck_editorrepo');

  var id = 0;
  editorsrepo.forEach((el) => {
    id += 1;
    ClassicEditor.create(el, {
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
      .then((newEditor) => {
        id = newEditor;
      })
      .catch((error) => {
        console.error(error);
      });
  });
}

function bc_addComboboxListeners() {
  (function ($) {
    $.widget('custom.combobox', {
      _create: function () {
        this.wrapper = $('<span>')
          .addClass('custom-combobox')
          .insertAfter(this.element);

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },

      _createAutocomplete: function () {
        var selected = this.element.children(':selected'),
          value = selected.val() ? selected.text() : '';

        this.input = $('<input>')
          .appendTo(this.wrapper)
          .val(value)
          .attr('title', '')
          .addClass(
            'custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left',
          )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy(this, '_source'),
          })
          .tooltip({
            //tooltipClass: "ui-state-highlight"
          });

        this._on(this.input, {
          autocompleteselect: function (event, ui) {
            ui.item.option.selected = true;
            this._trigger('select', event, {
              item: ui.item.option,
            });
          },

          autocompletechange: '_removeIfInvalid',
        });
      },

      _createShowAllButton: function () {
        var input = this.input,
          wasOpen = false;

        $('<a>')
          .attr('tabIndex', -1)
          .attr('title', 'Show All Items')
          //.tooltip()
          .appendTo(this.wrapper)
          .button({
            icons: {
              primary: 'ui-icon-triangle-1-s',
            },
            text: false,
          })
          .removeClass('ui-corner-all')
          .addClass('custom-combobox-toggle ui-corner-right')
          .mousedown(function () {
            wasOpen = input.autocomplete('widget').is(':visible');
          })
          .click(function () {
            input.focus();

            // Close if already visible
            if (wasOpen) {
              return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete('search', '');
            $('.ui-autocomplete').css({
              width: 500,
              'max-height': $(window).height() * 0.5,
              'overflow-y': 'auto',
            });
          });
      },

      _source: function (request, response) {
        var matcher = new RegExp(
          $.ui.autocomplete.escapeRegex(request.term),
          'i',
        );
        response(
          this.element.children('option').map(function () {
            var text = $(this).text();
            if (this.value && (!request.term || matcher.test(text)))
              return {
                label: text,
                value: text,
                option: this,
              };
          }),
        );
        $('.ui-autocomplete').css({
          width: 500,
          'max-height': $(window).height() * 0.5,
          'overflow-y': 'auto',
        });
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
        this.element.children('option').each(function () {
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
        this.input.val('').attr('title', value + " didn't match any item");
        /*.tooltip( "open" )*/
        this.element.val('');
        this._delay(function () {
          this.input.tooltip('close').attr('title', '');
        }, 2500);
        this.input.autocomplete('instance').term = '';
      },

      _destroy: function () {
        this.wrapper.remove();
        this.element.show();
      },
    });
  })(jQuery);

  $('.bc_combobox').combobox();
}

function bc_bindAddListeners() {

      $('.bc_add').click(function () {
        console.log('aaa');
        bc_add();
      });


  $('.saveAndNextEntity').click(function () {
    $('.bc_add_entity_and_article').click();
  });




  $('.bc_add_continue').click(function () {
    bc_add(true); // if true it will load the page of article after saving
  });

    $('.bc_add_entity_and_article').click(function () {
      bc_add(false, true); // if true it will load the page of article after saving
    });

  $('.bc_add_cancel').click(function () {
    history.back();
    // window.location.href = bc_list_url;
  });

  $('#btn_dropdown').click(function () {
    $('.bc_edit_table.dropdown').slideToggle();
  });


}

function bc_unbindAddListeners() {
  $('.bc_add').unbind('click');
  $('.bc_add_and_go_back').unbind('click');
  $('.bc_add_cancel').unbind('click');
  $('#btn_dropdown').unbind('click');
}

function bc_bindEditListeners() {
  $('.bc_update').click(function () {
    bc_edit();
  });

  $('.js_delete_cancel').click(function () {
    $('.bc_fade').hide();
    $('.bc_delete_dialog').hide();
  });

  $('.js_delete_cancel_article').click(function () {
    $('.bc_fade').hide();
    $('.bc_delete_dialog_article').hide();
  });




$('.bc_remove').click(function () {
  var pk_value = $(this).attr('pk_value');
  console.log(pk_value);
  var table = $(this).attr('table');
  var article_type = $(this).attr('article_type');
  var db_name = $(this).attr('db_name');

  $('.bc_fade').show();
  $('.bc_delete_dialog').show();

  $('.js_delete_really')
    .off('click')
    .on('click', function () {
      removeAny(pk_value, table, article_type, db_name);
    });
});



  function removeAny(pk_value, table, article_type, db_name) {
    $.ajax({
      url: rootUrl + 'Backend/removeAny',
      data: {
        pk_value: pk_value,
        db_name: db_name,
        article_type: article_type,
        table: table,
      },
      method: 'POST',
      success: function (data) {
        var ret = $.parseJSON(data);
        if (ret.success) {
          console.log('success');

          showMessage('success', 'The item has been deleted.');

          var currentUrl = window.location.href;
          var parts = currentUrl.split(table);
          var back = parts[0] + table;

          // go to back
          window.location = back;
        }
      },
    });
  }



  $('.bc_update_and_go_back').click(function () {
    bc_and_go_back = true;
    bc_edit();
  });

  $('.bc_update_cancel').click(function () {
    window.location.href = bc_list_url;
  });

  $('#btn_dropdown').click(function () {
    $('.bc_edit_table.dropdown').slideToggle();
  });


  $('.deleteArticle').on('click', function () {

    var lang = $(this).attr('lang');

    var id = $(this).attr('item_id');

    $('.js_delete_really_article').attr({
      item_id: id,
      lang: lang,
    });

    $('.bc_fade').show();
    $('.bc_delete_dialog_article').show();

    $('#article_delete_dialog').text(
      'Are you sure you want to delete this article?',
    );

    if (lang == MAIN_LANGUAGE) {

      $('#article_delete_dialog').append(
        '<br><br>' + 'Please note: All other articles for this will be deleted.',
      );
    }


  });

  $('.js_delete_really').on('click', function () {
    removeAny(pk_value, table, article_type, db_name);
  });

  $('.js_delete_really_article').on('click', function () {
    var lang = $(this).attr('lang');
    var id = $(this).attr('item_id');

    removeArticle(lang, id);
  });

  function removeArticle(lang, id) {
    console.log(rootUrl);
    $.ajax({
      url: rootUrl + 'entities/Content/removeArticle',
      data: {
        lang: lang,
        id: id,
      },
      method: 'POST',
      success: function (data) {
        var ret = $.parseJSON(data);

        if (ret.success) {
          console.log('success');
          window.location.reload();
        }
      },
    });
  }
}



function bc_add(article_continue = false, and_create_article = false) {
  bc_unbindAddListeners();


  let article_type = '';
  if (and_create_article == true) {
     article_type = $('.bc_add_entity_and_article').attr('article_type');
  }

  let inputData = bc_getModifiedData();

  const ajaxSettings = {
    url: bc_validation_url + 'null',
    data: JSON.stringify(inputData),
    contentType: 'application/json; charset=utf-8',
    type: 'POST',
    dataType: 'json',
    success: function (data) {
      if (!data.success) {
        bc_validate_errors(data);
        bc_bindAddListeners();
      } else {
        const settings = {
          articleType: article_type,
        };
        $.ajax({
          url: bc_insert_url,
          data: JSON.stringify(inputData),

          contentType: 'application/json; charset=utf-8',
          type: 'POST',
          dataType: 'json',
          settings: settings, // pass the settings object to $.ajax()
          success: function (data) {
            if (data.success) {
              var newEntityId = data.new_id;

              var i = 0;

              // get edit url
              var currentUrl = window.location.href;
              firstPartURL = currentUrl.split('add')[0];
              var editURL = firstPartURL + 'edit/' + data.new_id;

              showMessage('success', data.message);

              if ($('.item_edit_table').length > 0) {
                processArticleSave(newEntityId, () => {
                  window.location.href = editURL;
                });
              } else {
                showMessage('success', data.message);
              }
            } else {
              showMessage('error', data.message);
            }
            bc_bindAddListeners();
          },
        });
      }
    },
  };

  $.ajax(ajaxSettings); // pass the settings object to $.ajax()
}

function processArticleSave(newEntityId, callback = false) {
  var promises = [];
  var languages = ['de', 'en'];

  languages.forEach(function (lang) {
    $('.item_edit_table[lang="' + lang + '"]').each(function () {
      var form = $(this);
      var promise = submitArticleForm(form, newEntityId);
      promises.push(promise);
    });
  });

  return Promise.all(promises)
    .then((responses) => {
      var error = responses.find((response) => !response.success);
      if (error) {
        showMessage('error', error.message);
      } else {
        showMessage('success', 'Articles and Entity saved');
        if (callback) {
          callback();
        } else {
          console.log('done');
          // Only reload the page when all AJAX calls have finished
          location.reload();
        }
      }
    })
    .catch((error) => {
      // There was an error with the AJAX request
      console.error('AJAX request error', error);
    });
}

function submitArticleForm(form, newEntityId) {
  return new Promise((resolve, reject) => {
    var formData =
      form.serialize() + '&entityId=' + encodeURIComponent(newEntityId);

    $.ajax({
      url: rootUrl + 'entities/Content/articlesGeneralSave', // replace with your processing URL
      type: 'post',
      data: formData,
      success: function (response) {
        // handle your response here
        var data = JSON.parse(response);

        console.log('resolved');
        resolve(data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        reject(errorThrown);
      },
    });
  });
}







function bc_edit() {

  let inputData = bc_getModifiedData();

  // console.log(inputData);
  // console.log(bc_edit_url + bc_pk_value);
  // return;
  $.ajax({
    url: bc_validation_url + bc_pk_value,
    data: JSON.stringify(inputData),
    contentType: 'application/json; charset=utf-8',
    type: 'POST',
    dataType: 'json',
    success: function (data) {
      if (!data.success) {
        bc_validate_errors(data);
      } else {
        $.ajax({
          url: bc_edit_url + bc_pk_value,
          data: JSON.stringify(inputData),
          contentType: 'application/json; charset=utf-8',
          type: 'POST',
          dataType: 'json',
          success: function (data) {
            if (data.success) {
              var newEntityId = bc_pk_value;

              if ($('.item_edit_table').length > 0) {
                processArticleSave(newEntityId);
              } else {
                showMessage('success', data.message);
              }
            } else {
              showMessage('error', data.message);
            }
          },
        });
      }
    },
  });
}

function bc_getModifiedData() {
  let data = bc_getData();
  // Find the object and update its value
  let obj = data.find((item) => item.name === 'pretty_url_entity');


  if (obj && $('.item_edit_table').length > 0) {
    let value = "";
    $('input[name="pretty_url"]').each(function () {
      value += $(this).val() + ',';

    }
    );
    value = value.slice(0, -1);
    obj.value = value;

  }


  return data;
}







function bc_resetData() {
  // text
  $('.bc_col_text').each(function () {
    $(this).find('input').val('');
  });

  //@ToDo add repo text

  // select
  $('.bc_col_select').each(function () {
    $(this).find('select option:first').attr('selected', 'selected');
  });

  // image upload
  $('.bc_col_image').each(function () {
    $(this).find('.bc_col_image_delete').click();
  });

  // hidden -- will be skipped

  // textarea
  $('.bc_col_multiline').each(function () {
    $(this).find('textarea').val('');
  });

  // colorpicker
  $('.bc_col_colorpicker').each(function () {
    $(this).find('input').val('#000000');
  });
}

function bc_getData() {
  var elements = [];

  // text
  $('.bc_edit_table')
    .find('.bc_col_text')
    .each(function () {
      if ($(this).is(':visible')) {
        elements.push({
          name: $(this).find('input').attr('name').replace('col_', ''),
          value: $(this).find('input').val(),
          type: 'text',
        });
      }
    });

  // repo text
  $('.bc_edit_table')
    .find('.bc_textarea_text')
    .each(function () {
      var el = $(this);
      var el_parent = $(this).parent().parent();
      var langs = el_parent.find('.bc_select_text option');

      var fields_parent = $(this).parent().parent();
      var column_name = fields_parent.attr('col_name');
      var table_name = fields_parent.attr('table_name');
      var row_id = fields_parent.attr('row_id');
      var text_phrases = [];
      if (row_id == 'add') {
        langs.each(function () {
          var lang = $(this).val();
          text_phrases.push({
            lang: lang,
            text: fields_parent.attr('lang_' + lang),
          });
        });

        elements.push({
          type: 'repo_text',
          name: column_name,
          value: '',
          column_name: column_name,
          table_name: table_name,
          row_id: row_id,
          text_phrases: text_phrases,
        });
      }
    });

  // select
  $('.bc_edit_table')
    .find('.bc_col_select')
    .each(function () {
      if ($(this).is(':visible')) {
        elements.push({
          name: $(this).find('select').attr('name').replace('col_', ''),
          value: $(this).find('select option:selected').attr('value'),
          type: 'select',
        });
      }
    });

  // image upload
  $('.bc_edit_table')
    .find('.bc_col_repo_image')
    .each(function () {
      elements.push({
        name: $(this).find('.bc_col_fname').attr('name').replace('col_', ''),
        value: $(this).find('.bc_col_fname').val(),
        type: 'image',
      });
    });

  $('.bc_edit_table')
    .find('.bc_col_image')
    .each(function () {
      elements.push({
        name: $(this).find('.bc_col_fname').attr('name').replace('col_', ''),
        value: $(this).find('.bc_col_fname').val(),
        type: 'image',
      });
    });

  // file upload
  $('.bc_edit_table')
    .find('.bc_col_file')
    .each(function () {
      elements.push({
        name: $(this).find('.bc_col_fname').attr('name').replace('col_', ''),
        value: $(this).find('.bc_col_fname').val(),
        type: 'image',
      });
    });

  // hidden
  $('.bc_edit_table')
    .find('.bc_col_hidden')
    .each(function () {
      elements.push({
        name: $(this).find('input').attr('name').replace('col_', ''),
        value: $(this).find('input').val(),
        type: 'hidden',
      });
    });

  // textarea
  $('.bc_edit_table')
    .find('.bc_col_multiline')
    .each(function () {
      elements.push({
        name: $(this).find('textarea').attr('name').replace('col_', ''),
        value: $(this).find('textarea').val(),
        type: 'multiline',
      });
    });

  // m_n_relation
  $('.bc_edit_table')
    .find('.bc_col_m_n')
    .each(function () {
      var selected = [];
      $(this)
        .find('.bc_m_n_sel')
        .each(function () {
          selected.push($(this).attr('n_id'));
        });

      elements.push({
        name: $(this).attr('m_n_relation_id'),
        relation_id: $(this).attr('m_n_relation_id'),
        selected: selected,
        type: 'm_n_relation',
      });
    });

  // url
  $('.bc_edit_table')
    .find('.bc_col_url')
    .each(function () {
      elements.push({
        name: $(this).find('input').attr('name').replace('col_', ''),
        value: $(this).find('input').val(),
        type: 'url',
      });
    });

  // date
  $('.bc_edit_table')
    .find('.bc_col_date')
    .each(function () {
      elements.push({
        name: $(this).find('input').attr('name').replace('col_', ''),
        value:
          $(this).find('input').val() == ''
            ? 'null'
            : $(this).find('input').val(),
        type: 'date',
      });
    });

  // datetime
  $('.bc_edit_table')
    .find('.bc_col_datetime')
    .each(function () {
      elements.push({
        name: $(this).find('input').attr('name').replace('col_', ''),
        value:
          $(this).find('input').val() == ''
            ? 'null'
            : $(this).find('input').val(),
        type: 'datetime',
      });
    });

  // combobox
  $('.bc_edit_table')
    .find('.bc_col_combobox')
    .each(function () {
      elements.push({
        name: $(this).find('select').attr('name').replace('col_', ''),
        value: $(this).find('select option:selected').attr('value'),
        type: 'combobox',
      });
    });

  // CKEDITOR
  $('.bc_edit_table')
    .find('.bc_col_ckeditor')
    .each(function (index) {
      var text = ckeditors[index].getData();

      elements.push({
        name: $(this).find('textarea').attr('name').replace('col_', ''),
        value: text,
        type: 'ckeditor',
      });
    });

  // colorpicker
  $('.bc_edit_table')
    .find('.bc_col_colorpicker')
    .each(function () {
      elements.push({
        name: $(this).find('input').attr('name').replace('col_', ''),
        value: $(this).find('input').val(),
        type: 'colorpicker',
      });
    });

  return elements;
}

function bc_addDatepickerListeners() {
  $('.bc_col_date').each(function () {
    $(this)
      .find('input')
      .datepicker({
        dateFormat: $(this).find('input').attr('format'),
        changeMonth: true,
        changeYear: true,
        /* buttonImage: rootUrl + "/items/besc_crud/img/calendar_icon.png",
        showOn: "button",
        buttonImageOnly: true, */
      })
      .on('keyup', function () {
        if (
          $(this)
            .val()
            .match(/^\d{4}-\d{2}-\d{2}$/) == null
        ) {
          $(this).css('box-shadow', '0px 0px 0px 1px red');
        } else {
          $(this).css('box-shadow', '0px 0px 0px 0px red');
        }
      });

    $(this)
      .find('.bc_col_date_calendar')
      .click(function () {
        $(this).parent().find('input').focus();
      });

    $(this)
      .find('.bc_col_date_reset')
      .click(function () {
        $(this).parent().find('input').datepicker('setDate', null);
      });
  });

  $('.bc_col_datetime').each(function () {
    $(this).find('input').datetimepicker({
      timeFormat: 'HH:mm',
      timeInput: true,
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      controlType: 'select',
      hourMin: 7,
      hourMax: 22,
      stepMinute: 5,
      /*  buttonImage: rootUrl + "/items/besc_crud/img/calendar_icon.png",
        showOn: "button",
        buttonImageOnly: true, */
    });

    $(this)
      .find('.bc_col_date_calendar')
      .click(function () {
        $(this).parent().find('input').focus();
      });

    $(this)
      .find('.bc_col_date_reset')
      .click(function () {
        $(this).parent().find('input').datetimepicker('setDate', null);
      });
  });
}

function bc_addMNRelationListeners() {
  $('.bc_m_n_sel').click(function () {
    bc_MNRelationClick($(this));
  });

  $('.bc_m_n_av').click(function () {
    bc_MNRelationClick($(this));
  });

  $('.bc_m_n_filterbox input[type="text"]').keyup(function () {
    bc_MNRelationFilter($(this).val(), $(this).parent().attr('parent'));
  });
}

function bc_MNRelationFilter(filter, parent) {
  $('.bc_m_n_' + parent).each(function () {
    if ($(this).text().toUpperCase().indexOf(filter.toUpperCase()) == -1)
      $(this).hide();
    else $(this).show();
  });
}

function bc_positionMNRelationSearchbox() {
  $('.bc_m_n_filterbox input[type="text"]').css({ width: '-=18px' });
}

function bc_MNRelationClick(element) {
  var clone = element.clone();
  clone.fadeOut(0);
  if (element.hasClass('bc_m_n_sel')) {
    element.removeClass('bc_m_n_sel');
    clone.removeClass('bc_m_n_sel');
    clone.addClass('bc_m_n_av');
    var target = element.parent().parent().find('.bc_m_n_avail');
  } else {
    element.removeClass('bc_m_n_av');
    clone.removeClass('bc_m_n_av');
    clone.addClass('bc_m_n_sel');
    var target = element.parent().parent().find('.bc_m_n_selected');
  }

  element.remove();
  target.append(clone);
  clone.click(function () {
    bc_MNRelationClick($(this));
  });
}

function bc_addFileListeners() {
  $('.bc_col_file_upload_btn').click(function () {
    $(this).parent().find('input[type="file"]').click();
  });

  $('.bc_col_file_file').change(function () {
    bc_uploadFileFile(
      $(this).attr('id'),
      $(this).attr('uploadpath'),
      this.files,
    );
  });

  $('.bc_col_file_delete').click(function () {
    bc_resetUpload($(this).parent());
    $(this).html('To confirm Deleting click "Save".');
  });
}

function bc_addImageListeners() {
  $('.bc_col_image_upload_btn').click(function () {
    $(this).parent().find('input[type="file"]').click();
  });

  $('.bc_col_image_file').change(function () {
    bc_uploadFile($(this).attr('id'), $(this).attr('uploadpath'), this.files);
  });

  $('.bc_col_image_delete').click(function () {
    bc_resetUpload($(this).parent());
  });
}

function bc_addRepoImageListeners() {

  $('.bc_col_repo_image .bc_open_repo').click(function () {
    var active_input = $(this).parent();
    var repo_id = active_input.find('.repo_image_field').val();

    var selected = [];
    selected.push(parseInt(repo_id));
    $('.repo_item').each(function () {
      var did = $(this).data('id');
      console.log($.inArray(did, selected));
      if ($.inArray(did, selected) !== -1) {
        $(this).addClass('selected_item');
      }
    });

    $('#repo_overlay').show();
    lazy_load_start();
    setInterval(function () {
      lazy_load_start();
    }, 300);

    $('#repo_type').val('edit_image');
    $('.repo_item').off('click');
    $('.repo_item').on('click', function () {
      if ($(this).hasClass('selected_item')) {
        $(this).removeClass('selected_item');
        active_input.find('.repo_image_field').val(0);
      } else {
        var iid = $(this).find('.repo_item_select').attr('iid');
        active_input.find('.repo_image_field').val(iid);
        closeRepo();
      }
      bc_update_repo_images();
    });
  });

  $('.bc_col_repo_image .bc_repo_image_delete').click(function () {
    $(this).parent().find('.repo_image_field').val(0);
    bc_update_repo_images();
  });

  bc_update_repo_images();
}

function bc_update_repo_images() {
  $('.bc_col_repo_image').each(function () {
    var repo_id = $(this).find('.repo_image_field').val();
    var img_preview = $(this).find('.bc_col_image_preview');
    var img_size = $(this).find('.bc_repo_image_size');
    var img_delete = $(this).find('.bc_repo_image_delete');
    var uploadpath = '/items/uploads/images/';

    if (repo_id == 0 || repo_id == '') {
      img_preview.addClass('no_repo_image').attr('src', '');
      img_size.html('');
      img_delete.hide();
    } else {
      img_preview.removeClass('no_repo_image');
      $.ajax({
        url: rootUrl + '/entities/Content/get_repo_image',
        data: {
          repo_id: repo_id,
        },
        method: 'POST',
        dataType: 'json',
        success: function (data) {
          var ret = data;

          if (ret.success) {
            img_preview.attr('src', rootUrl + uploadpath + ret.repo_item.fname);
            img_size.html(
              'Size: ' +
                img_preview[0].naturalWidth +
                'x' +
                img_preview[0].naturalHeight,
            );
            img_delete.show();
          } else {
            alert('Error while showing the image');
          }
        },
      });
    }
  });
}

function bc_uploadFile(element, u, files) {
  var elem = $('#' + element);
  var element_name = elem.attr('name').substr(4, elem.attr('name').length - 9);
  var uploadpath = u;
  var xhr = new XMLHttpRequest();
  var fd = new FormData();
  fd.append('data', files[0]);
  fd.append('filename', files[0].name);
  fd.append('element', element_name);

  xhr.addEventListener('load', function (e) {
    var ret = $.parseJSON(this.responseText);

    if (ret.success) {
      var col = $('#' + element).parent();

      if (col.attr('callback_after_upload') !== undefined) {
        window[col.attr('callback_after_upload')](
          ret.filename,
          uploadpath,
          element,
          result,
        );
      }

      if (ret.crop != null) {
        bc_cropUpload(
          ret.filename,
          uploadpath,
          element,
          element_name,
          ret.crop,
          ret.crop_type,
        );
      } else
        bc_updateImageElement(
          col,
          uploadpath,
          ret.filename,
          ret.fullpath,
          ret.size,
        );
    } else {
      show_message('error', 'Error while uploading!');
    }
  });

  xhr.open('post', bc_upload_url);
  xhr.send(fd);
}

function bc_uploadFileFile(element, u, files) {
  var elem = $('#' + element);
  var element_name = elem.attr('name').substr(4, elem.attr('name').length - 9);
  var uploadpath = u;
  var xhr = new XMLHttpRequest();
  var fd = new FormData();
  fd.append('data', files[0]);
  fd.append('filename', files[0].name);
  fd.append('element', element_name);

  xhr.addEventListener('load', function (e) {
    var ret = $.parseJSON(this.responseText);

    if (ret.success) {
      var col = $('#' + element).parent();

      if (col.attr('callback_after_upload') !== undefined) {
        window[col.attr('callback_after_upload')](
          ret.filename,
          uploadpath,
          element,
          result,
        );
      }

      if (ret.crop != null) {
        bc_cropUpload(
          ret.filename,
          uploadpath,
          element,
          element_name,
          ret.crop,
          ret.crop_type,
        );
      } else {
        bc_updateImageElement(col, uploadpath, ret.filename, ret.fullpath);
      }
    } else {
      show_message('error', 'Error while uploading!');
    }
  });

  xhr.open('post', bc_file_upload_url);
  xhr.send(fd);
}

function bc_updateImageElement(
  col,
  uploadpath,
  filename,
  fullpath,
  size = null,
) {
  col.find('.bc_col_image_upload_btn').fadeOut(150, function () {
    //col.find('.bc_col_image_preview').attr('src', rootUrl + '/' + uploadpath + filename);
    //col.find('a').attr('href', rootUrl + '/' + uploadpath + '/' + filename);
    col.find('.bc_col_image_preview').attr('src', fullpath);
    col.find('a').attr('href', fullpath);
    col.find('.bc_col_image_preview').fadeIn(150);
    col.find('.bc_col_image_delete').fadeIn(150);
    col.find('.bc_col_image_size').text(size);
    col.find('.bc_col_fname').val(filename);
  });

  col.find('.bc_col_file_upload_btn').fadeOut(150, function () {
    col.find('a').attr('href', rootUrl + '/' + uploadpath + filename);
    console.log(rootUrl + '/' + uploadpath + filename);
    col.find('.bc_col_image_preview').text(filename);
    col.find('.bc_col_image_preview').fadeIn(150);
    col.find('.bc_col_image_delete').fadeIn(150);
    col.find('.bc_col_image_size').text(size);
    col.find('.bc_col_fname').val(filename);
  });
}
function bc_updateFileElement(
  col,
  uploadpath,
  filename,
  fullpath,
  size = null,
) {
  col.find('.bc_col_file_upload_btn').fadeOut(150, function () {
    col.find('a').attr('href', fullpath);
    col.find('.bc_col_file_preview').fadeIn(150);
    col.find('.bc_col_file_delete').fadeIn(150);
    col.find('.bc_col_fname').val(filename);
  });
}

function bc_resetUpload(col) {
  col.find('.bc_col_fname').val('');
  col.find('.bc_col_image_delete').fadeOut(150);
  col.find('.bc_col_image_preview').fadeOut(150, function () {
    col.find('.bc_col_image_preview').attr('src', '');
    col.find('a').attr('src', '');
    col.find('.bc_col_image_upload_btn').fadeIn(150);
  });
}

/*function bc_addMultilineListeners()
{
	$('.bc_col_multiline_formatting_button').click(function()
	{
		addTags($(this).parent().parent(), $(this).attr('tag'));
	});
}

function addTags(multiline, tag)
{
	var ta = multiline.find('textarea');

	var sel = ta.getSelection();
	var text = ta.val();
	if(sel.start == sel.end)
	{
		var before = text.substring(0, sel.start);
		var after = text.substring(sel.start, text.length);

		var newtext = before + '<' + tag + '></' + tag + '>' + after;
	}
	else
	{
		var before = text.substring(0, sel.start);
		var after = text.substring(sel.end, text.length);
		var selection = text.substring(sel.start, sel.start + sel.length);
		var newtext = before + '<' + tag + '>' + selection + '</' + tag + '>' + after;
	}

	ta.val(newtext);
}*/

function bc_cropUpload(
  filename,
  uploadpath,
  element,
  elementname,
  cropoptions,
  type = 0,
) {
  var html =
    '<div id="bc_upload_crop"><img id="bc_upload_crop_img" src="' +
    rootUrl +
    uploadpath +
    filename +
    '" /><div id="bc_upload_crop_btn">CROP</div><div id="bc_upload_crop_cancel_btn">CONTINUE WITHOUT CROP</div></div><div id="bc_upload_crop_fade"></div>';
  $('body').append(html);

  var wWidth = $(document).width();
  var wHeight = $(document).height();
  var padding = 60;

  imagesLoaded($('#bc_upload_crop'), function () {
    var iWidth = $('#bc_upload_crop_img').get(0).naturalWidth;
    var iHeight = $('#bc_upload_crop_img').get(0).naturalHeight;
    var ratio = iWidth / iHeight;
    var cWidth = iWidth + padding;
    var cHeight = iHeight + padding + $('bc_#upload_crop_btn').height();

    if (cWidth > wWidth * 0.8) {
      iWidth = wWidth * 0.8 - padding;
      iHeight = iWidth / ratio;
      cWidth = iWidth + padding;
      cHeight = iHeight + padding;
    }

    if (cHeight > wHeight * 0.8) {
      iHeight = wHeight * 0.8 - padding - $('#bc_upload_crop_btn').height();
      iWidth = iHeight * ratio;
      cWidth = iWidth + padding;
      cHeight = iHeight + padding;
    }

    $('#bc_upload_crop').css({ left: 10, top: 10 });
    $('#bc_upload_crop_img').css({ width: iWidth, height: iHeight });

    var select_ratio =
      $('#bc_upload_crop_img').get(0).naturalWidth /
      parseInt($('#bc_upload_crop_img').css('width'));

    if (type == 'teaser') {
      areaselect = $('#bc_upload_crop_img').imgAreaSelect({
        aspectRatio: '320:210',
        handles: true,
        x1: 0,
        y1: 0,
        x2: 320 / select_ratio,
        y2: 210 / select_ratio,
        minWidth: 320 / select_ratio,
        minHeight: 210 / select_ratio,
        parent: '#bc_upload_crop',
        instance: true,
      });
    } else if (type == 'showcase') {
      areaselect = $('#bc_upload_crop_img').imgAreaSelect({
        aspectRatio: '800:420',
        handles: true,
        x1: 0,
        y1: 0,
        x2: 800 / select_ratio,
        y2: 420 / select_ratio,
        minWidth: 400 / select_ratio,
        minHeight: 210 / select_ratio,
        parent: '#bc_upload_crop',
        instance: true,
      });
    } else {
      areaselect = $('#bc_upload_crop_img').imgAreaSelect({
        aspectRatio: cropoptions.ratio,
        handles: true,
        x1: 0,
        y1: 0,
        x2: parseInt(cropoptions.minWidth) / select_ratio,
        y2: parseInt(cropoptions.minHeight) / select_ratio,
        minWidth: parseInt(cropoptions.minWidth) / select_ratio,
        minHeight: parseInt(cropoptions.minHeight) / select_ratio,
        parent: '#bc_upload_crop',
        instance: true,
      });
    }
  });

  $('#bc_upload_crop_btn').on('click', function () {
    $.ajax({
      url: bc_crop_url,
      data: {
        filename: filename,
        x1: areaselect.getSelection().x1,
        y1: areaselect.getSelection().y1,
        x2: areaselect.getSelection().x2,
        y2: areaselect.getSelection().y2,
        col: elementname,
        ratio:
          $('#bc_upload_crop_img').get(0).naturalWidth /
          parseInt($('#bc_upload_crop_img').css('width')),
      },
      method: 'POST',
      cache: false,
      dataType: 'json',
      success: function (data) {
        var ret = data;

        if (ret.success) {
          $('#bc_upload_crop_fade').remove();
          $('#bc_upload_crop').remove();
          var fname = ret.fname;
          var fullpath = rootUrl + uploadpath + fname;
          bc_updateImageElement(
            $('#' + element).parent(),
            uploadpath,
            fname,
            fullpath,
          );
        } else {
          alert('Error while cropping');
        }
      },
    });
  });

  $('#bc_upload_crop_cancel_btn').on('click', function () {
    $('#bc_upload_crop_fade').remove();
    $('#bc_upload_crop').remove();
    var fullpath = rootUrl + uploadpath + filename;
    bc_updateImageElement(
      $('#' + element).parent(),
      uploadpath,
      filename,
      fullpath,
    );
  });

  /*$('#bc_upload_crop_fade').on('click', function()
	{
		$('#bc_upload_crop_fade').remove();
		$('#bc_upload_crop').remove();
		bc_updateImageElement($('#' + element).parent(), uploadpath, filename);
	});*/
}

function bc_validate_errors(data) {
  var error_color = getCSS('background-color', 'bc_error_highlight');
  var scroll_to = 99999;

  for (var key in data.error_columns) {
    var new_scroll_to = bc_validate_error(data.error_columns[key], error_color);
    if (new_scroll_to < scroll_to) scroll_to = new_scroll_to;
  }

  $('.bc_edit_table').parent().scrollTop(scroll_to);
}

function bc_validate_error(data, error_color) {
  var col = $('.bc_column[col_name="' + data.name + '"]');
  col.animate({ 'background-color': error_color }, 150, 'swing', function () {
    col.find('.bc_error_text').text(data.error);
    col.find('input').css({ border: 'solid 2px ' + error_color });
    col.find('textarea').css({ border: 'solid 2px ' + error_color });
    col.find('select').css({ border: 'solid 2px ' + error_color });
    setTimeout(function () {
      col.animate({ 'background-color': '' }, 150, 'swing');
    }, 100);
  });

  return Math.abs(parseInt(col.position().top));
}

function getCSS(prop, fromClass) {
  var $inspector = $('<div>').css('display', 'none').addClass(fromClass);
  $('body').append($inspector); // add to DOM, in order to read the CSS property
  try {
    return $inspector.css(prop);
  } finally {
    $inspector.remove(); // and remove from DOM
  }
}

function setTimeoutMessageDisappear(message) {
  setTimeout(function () {
    message.click();
  }, bc_message_lingering);
}

// repo text
function bc_igniteRepoText() {
  $.ajax({
    url: rootUrl + '/entities/TextRepo/get_text_repo_info',
    data: {},
    success: function (data) {
      var ret = JSON.parse(data);

      var lang_select_html = ret.languages.map(function (lang) {
        return '<option value="' + lang.id + '">' + lang.name + '</option>';
      });

      $('.bc_col_repo_text').each(function () {
        var fields_parent = $(this).parent();
        var column_name = fields_parent.attr('col_name');
        var table_name = fields_parent.attr('table_name');
        var row_id = fields_parent.attr('row_id');

        var lang_select = fields_parent.find('.bc_select_text');
        lang_select.html(lang_select_html);
        fetch_repo_text(column_name, table_name, row_id, lang_select.val());
      });
    },
  });

  $('.bc_col_repo_text .bc_select_text').change(function () {
    var fields_parent = $(this).parent().parent();
    var column_name = fields_parent.attr('col_name');
    var table_name = fields_parent.attr('table_name');
    var lang = $(this).val();
    var row_id = fields_parent.attr('row_id');
    var text_elem = fields_parent.find('.bc_textarea_text');

    if (row_id == 'add') {
      text_elem.val(fields_parent.attr('lang_' + lang));
    } else {
      fetch_repo_text(column_name, table_name, row_id, lang);
    }
  });

  $('.bc_col_repo_text .bc_textarea_text').keyup(function () {
    var fields_parent = $(this).parent().parent();
    var column_name = fields_parent.attr('col_name');
    var table_name = fields_parent.attr('table_name');
    var row_id = fields_parent.attr('row_id');

    var lang = fields_parent.find('.bc_select_text').val();
    var text = $(this).val().trim();

    if (row_id == 'add') {
      fields_parent.attr('lang_' + lang, text);
    } else {
      update_repo_text(column_name, table_name, row_id, lang, text);
    }
  });

  function fetch_repo_text(column_name, table_name, row_id, lang) {
    $.ajax({
      type: 'POST',
      url: rootUrl + '/entities/TextRepo/get_text_repo_text',
      data: {
        column_name: column_name,
        table_name: table_name,
        row_id: row_id,
        lang: lang,
      },
      success: function (data) {
        var ret = JSON.parse(data);
        console.log(ret);
        var fields_parent = $(
          '.bc_column[col_name="' +
            column_name +
            '"][table_name="' +
            table_name +
            '"][row_id="' +
            row_id +
            '"]',
        );
        var text_input = fields_parent.find('.bc_textarea_text');
        text_input.val(ret.text_phrase);

        console.log(column_name, table_name, row_id);
      },
    });
  }

  function update_repo_text(column_name, table_name, row_id, lang, text) {
    $.ajax({
      type: 'POST',
      url: rootUrl + '/entities/TextRepo/set_text_repo_text',
      data: {
        column_name: column_name,
        table_name: table_name,
        row_id: row_id,
        lang: lang,
        text: text,
      },
      success: function (data) {
        var ret = JSON.parse(data);
        console.log(ret);
      },
    });
  }
}
