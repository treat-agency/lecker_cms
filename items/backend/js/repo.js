$(document).ready(function () {
  addGlobalListeners(true);
  dragAndDropSelectors();

  $('#close_repo_back').click(function () {
    console.log('clik');

    let totalImages = $('.selected_image').length;
    let updatedImages = 0;

    function goBackCallback() {
      updatedImages++;
      if (updatedImages === totalImages) {
        goBackOrToBackend();
      }
    }

    if (!$(this).attr('module_type')) {
      $('.selected_image').each(function (item, i) {
        var repo_id = $(this).attr('repo_id');
        console.log(i);
        var ordering = item + 1;
        var type = $(this).attr('type');
        var has_article = $(this).attr('has_article');

        updateRepoItem(has_article, type, entity_id, repo_id, goBackCallback);
      });
    } else {

      deletePreviousModuleImagesAndAddNewOnes(module_type, module_id, goBackCallback);
    }
  });

  function goBackOrToBackend() {
    var came_from = document.referrer;
    if (
      history.length == 1 ||
      came_from == '' ||
      !came_from.includes(rootUrl)
    ) {
      window.location.href = rootUrl + 'backend';
    } else {
      window.history.go(-1);
      return false;
    }
  }

  $('#repo_container').on('click', '.repoActionSave', function () {
    console.log('click');
    var form = $(this).parent().parent().parent().find('.repoEditHolder');

    console.log('click');
    var image_id = $(this).attr('item_id');
    var image_title = form.find('.repo_item_title').val();

    var image_title_en = form.find('.repo_item_title_en').val();
    var image_credits_text = form.find('.repo_item_credits').val();
    var image_credits_text_en = form.find('.repo_item_credits_en').val();

    $.ajax({
      url: rootUrl + 'entities/Repository/saveOneImage',
      data: {
        image_id: image_id,
        image_title: image_title,
        image_title_en: image_title_en,
        image_credits_text: image_credits_text,
        image_credits_text_en: image_credits_text_en,
        //gallery_items: gallery_items
      },
      method: 'POST',
      success: function (data) {
        var ret = $.parseJSON(data);

        if (ret.success) {
          window.location.reload();
        } else {
          alert('Error while saving');
        }
      },
    });
  });


});




function addGlobalListeners(toggle) {

  function lazy_load_start() {
    if ($('.lazy').length != 0) {
      $('.lazy').Lazy({
        // your configuration goes here
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        threshold: 1000,
        onError: function (element) { },
        afterLoad: function (element) {
          //console.log("loaded");
        },
      });
    }
  }



  $('#repo_overlay').scroll(function () {
    lazy_load_start();
  });

  if (toggle) {
    // styling
    setInterval(function () {
      $('#repo_content').css('top', $('#current').height());
    }, 100);
    $(window).resize(function () { });

    // end styling

    $('#current_image_holder').on('click', '.remove_upload', function () {

      var repo_item_id = $(this).parent().attr('repo_id');


      if (!$(this).hasClass('js-removeModuleRepo')) {
        console.log('nema')
        var type = $(this).attr('type');
        var has_article = $(this).attr('has_article');
        removeRepoItem(has_article, type, entity_id, repo_item_id);

      }

      var repo_item_id = $(this).parent().attr('repo_id');


      $('[data-id="' + repo_item_id + '"').removeClass('selected_item');
      $(this).parent().remove();
    });


    $('#repo_container').on('click', '.repo_item_select', function () {

      if ($(this).parent().hasClass('selected_item')) {
        return;
      }

      if (!$(this).hasClass('js-multipleSelect')) {
        $('.repo_item').removeClass('selected_item');
        $('#current_image_holder').empty();
      }

      $(this).parent().addClass('selected_item');



      var repo_item_id = $(this).attr('iid');
      var fname = $(this).attr('fname');

      if (!$(this).hasClass('js-moduleSelect')) {

        var type = $(this).attr('type');
        var has_article = $(this).attr('has_article');

        var prev_image =
          $('#current_image_holder').find('.selected_image').length ?? 0;
        var ordering = prev_image + 1;

        // var url = $(this).attr('url');
        var title = $(this).attr('title');
        saveRepoItem(
          has_article,
          type,
          entity_id,
          repo_item_id,
          ordering,
          fname,
          title,
        );


      } else {


        var ordering = $('#current_image_holder').find('.selected_image').length + 1;

        var elem =
          `<div class="selected_image" ordering="${ordering}" module_type="${module_type}"  module_item_id="${module_item_id}" module_id="${module_id}" repo_id="${repo_item_id}">` +
          `<div class="repoImgAndDesc">` +
          `<div class="repoCurrentImgWrapper">
            <img class="current_img" src=" ${rootUrl + 'items/uploads/images/thumbs/' + fname
          }" />
          </div>` +
          `<div class="repoDescriptionHolder">
            <textarea rows="4" cols="50"></textarea>
          </div>` +
          `</div>` +
          `<div class="remove_upload ui-rounded1 js-removeModuleRepo"
        has_article="" type="<?= $type ?>"
        >Remove</div>` +
          `</div>`;

        $('#current_image_holder').append(elem);

        dragAndDropSelectors();

      }

    });


    $('#repo_filters_toggle').click(function () {
      $(this).toggleClass('active');
      $('#repo_filters').slideToggle();
    });

    // $('.repo_item_crop').click(function () {
    //   var repo_item_id = $(this).attr('iid');
    //   var type = $(this).attr('type');
    //   var fname = $(this).attr('fname');
    //   var title = $(this).attr('title');
    //   var collection = $(this).attr('collection');
    //   var alt = $(this).attr('alt');
    //   var alt_en = $(this).attr('alt_en');
    //   var category = $(this).parent().attr('cid');

    //   $('#crop_img_holder img').attr(
    //     'src',
    //     rootUrl + 'items/uploads/images/' + fname,
    //   );
    //   $('#crop_image_btn').attr('title', title);
    //   $('#crop_image_btn').attr('type', type);
    //   $('#crop_image_btn').attr('fname', fname);
    //   $('#crop_image_btn').attr('alt', alt);
    //   $('#crop_image_btn').attr('alt_en', alt_en);
    //   $('#crop_image_btn').attr('cid', category);
    //   $('#crop_image_btn').attr('collection', collection);
    //   $('#crop_holder').fadeIn();

    //   ias = $('#crop_img_holder img').imgAreaSelect({
    //     x1: 0,
    //     y1: 0,
    //     x2: 278,
    //     y2: 200,
    //     w: 278,
    //     h: 200,
    //     aspectRatio: '278:200',
    //     minHeight: 200,
    //     minWidth: 278,
    //     maxWidth: 1112,
    //     maxHeight: 800,
    //     handles: true,
    //     instance: true,
    //     onSelectEnd: function (img, selection) {
    //       $('#image_selection_x1').val(selection.x1);
    //       $('#image_selection_y1').val(selection.y1);
    //       $('#image_selection_x2').val(selection.x2);
    //       $('#image_selection_y2').val(selection.y2);
    //       $('#image_selection_w').val(selection.w);
    //       $('#image_selection_h').val(selection.h);
    //     },
    //   });
    // });

    // $('#crop_cancel').click(function () {
    //   $('#crop_holder').hide();
    //   ias.setOptions({ hide: true });
    // });

    // $('#crop_image_btn').click(function () {
    //   var x1 = $('#image_selection_x1').val();
    //   var y1 = $('#image_selection_y1').val();
    //   var x2 = $('#image_selection_x2').val();
    //   var y2 = $('#image_selection_y2').val();
    //   var w = $('#image_selection_w').val();
    //   var h = $('#image_selection_h').val();
    //   var type = $(this).attr('type');
    //   var title = $(this).attr('title');
    //   var alt = $(this).attr('alt');
    //   var alt_en = $(this).attr('alt_en');
    //   var fname = $(this).attr('fname');
    //   var category = $(this).attr('cid');
    //   var collection = $(this).attr('collection');

    //   $.ajax({
    //     url: rootUrl + 'entities/Repository/crop_image',
    //     data: {
    //       x1: x1,
    //       x2: x2,
    //       y1: y1,
    //       y2: y2,
    //       h: h,
    //       w: w,
    //       title: title,
    //       type: type,
    //       alt: alt,
    //       alt_en: alt_en,
    //       category: category,
    //       fname: fname,
    //       collection: collection,
    //     },
    //     method: 'POST',
    //     success: function (data) {
    //       var ret = $.parseJSON(data);
    //       if (ret.success) {
    //         window.location.reload();
    //       } else {
    //       }
    //     },
    //   });

    //   $('#crop_holder').hide();
    // });


    // module special

    $('#repo_category_module').on('change', function () {
      var category_id = $(this).val();

      if (category_id == 0) {
        $('.repo_item').show();
      } else {
        $('.repo_item').each(function (i, item) {
          var cid = $(this).attr('cid');
          if (cid == category_id) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }
    });

    $('#search_icon_module').on('click', function () {
      var filter = $('#repo_name_search').val();
      if (filter == '') {
        $('.repo_item').show();
      } else {
        $('.repo_item').each(function (i, item) {
          var title = $(item).attr('data-title');
          var src = $(item).attr('data-filename');
          console.log(title);
          var inr = $(item).attr('inr');

          if (
            title.toLowerCase().indexOf(filter.toLowerCase()) >= 0 ||
            src.toLowerCase().indexOf(filter.toLowerCase()) >= 0
          ) {
            $(item).show();
          } else {
            $(item).hide();
          }
        });
      }
    });

    $('.js-resetFilter').on('click', function () {

      var currentUrl = window.location.href;

      if (currentUrl.includes('?')) {
        var baseUrl = currentUrl.split('?')[0];

        window.location.href = baseUrl;
      }
    });


    $('#repo_sort_module').on('change', function () {
      var type = $(this).val();
      var way = $('#repo_sort_type').val();

      if (type == 'id') {
        tinysort('div#repo_container>div', {
          attr: 'data-id',
          order: way,
        });
      } else {
        tinysort('div#repo_container>div', {
          attr: 'data-title',
          order: way,
        });
      }
    });

    $('#repo_sort_type_module').on('change', function () {
      var type = $('#repo_sort').val();
      var way = $(this).val();

      if (type == 'id') {
        tinysort('div#repo_container>div', {
          attr: 'data-id',
          order: way,
        });
      } else {
        tinysort('div#repo_container>div', {
          attr: 'data-title',
          order: way,
        });
      }
    });

    // repofilter
    $('#repo_category').on('change', function () {
      var Id = $(this).val();

      var key = 'category=';

      addRightParams(Id, key);
    });

    // repofilter
    $('#repo_tag').on('change', function () {
      var Id = $(this).val();
      // var category_id = $(this).val();

      var key = 'tag=';

      addRightParams(Id, key);

      // if (tag_id == 0) {
      //   $('.repo_item').show();
      // } else {
      //   $('.repo_item').each(function (i, item) {
      //     var tags = $(this).find('.image_repo_tag');
      //     if (tags.length == 0) {
      //       $(this).hide();
      //     }

      //     if (tags.length > 0) {
      //       for (let i = 0; i < tags.length; i++) {
      //         var repo_item = tags[i];
      //         // console.log(repo_item);
      //         var this_tag = $(repo_item).attr('tag');

      //         if (tag_id == this_tag) {
      //           $(this).show();
      //           break;
      //         } else {
      //           $(this).hide();
      //         }
      //       }
      //     }
      //   });
      // }
    });

    $('#repo_privacy_tag').on('change', function () {
      var tag_id = $(this).val();
      // var category_id = $(this).val();

      if (tag_id == 0) {
        $('.repo_item').show();
      } else {
        $('.repo_item').each(function (i, item) {
          var tags = $(this).find('.image_privacy_tag');
          if (tags.length == 0) {
            $(this).hide();
          }

          if (tags.length > 0) {
            for (let i = 0; i < tags.length; i++) {
              var repo_item = tags[i];
              // console.log(repo_item);
              var this_tag = $(repo_item).attr('tag');

              if (tag_id == this_tag) {
                $(this).show();
                break;
              } else {
                $(this).hide();
              }
            }
          }
        });
      }
    });

    $('#repo_proj').on('change', function () {
      var value = $(this).val();
      // var category_id = $(this).val();

      if (value == 0) {
        $('.repo_item').show();
      } else {
        $('.repo_item').each(function (i, item) {
          var property = $(this).attr('project');

          if (property == value) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }
    });

    // repofilter
    $('#repo_date_added').on('change', function () {
      var Id = $(this).val();

      var key = 'date_added=';

      addRightParams(Id, key);
    });

    $('#repo_date_taken').on('change', function () {
      var Id = $(this).val();

      var key = 'date_taken=';

      addRightParams(Id, key);
    });

    // $('#repo_tag').on('change', function () {
    //   var tag_id = $(this).val();
    //   if (tag_id == 0) {
    //     $('.repo_item').show();
    //   } else {
    //     $('.repo_item').each(function (i, item) {
    //       var img_tags = $(this).attr('img_tags').split(' ');
    //       for (let i = 0; i < img_tags.length; index++) {
    //         const tag = img_tags[i];
    //         if (tag == tag_id) {
    //           $(this).show();
    //         } else {
    //           $(this).hide();
    //         }
    //       }
    //     });
    //   }
    // });

    // $('#repo_sort').on('change', function () {
    //   var type = $(this).val();
    //   var way = $('#repo_sort_type').val();

    //   if (type == 'id') {
    //     tinysort('div#repo_container>div', {
    //       attr: 'data-id',
    //       order: way,
    //     });
    //   } else {
    //     tinysort('div#repo_container>div', {
    //       attr: 'data-title',
    //       order: way,
    //     });
    //   }
    // });

    $('#repo_sort_type').on('change', function () {
      var Id = $(this).val();
      var key = 'sort=';

      addRightParams(Id, key);

      // var type = $('#repo_sort').val();
      // var way = $(this).val();

      // if (type == 'id') {
      //   tinysort('div#repo_container>div', {
      //     attr: 'data-id',
      //     order: way,
      //   });
      // } else {
      //   tinysort('div#repo_container>div', {
      //     attr: 'data-title',
      //     order: way,
      //   });
      // }
    });

    // repofilter
    function addRightParams(id, key) {
      var query = key + id;

      const currentUrl = window.location.href;


      if (currentUrl.includes('?') && !currentUrl.includes(key)) {
        window.location.href = `${currentUrl}&${query}`;
      } else if (currentUrl.includes(key)) {

        // includes key already
        const baseUrl = currentUrl.split('?')[0];
        const params = currentUrl.split('?')[1];
        const urlParams = params.split('&');
        const newUrlParams = urlParams.map((param) => {
          if (param.includes(key)) {
            if (id != 0) {
              return query;
            }
          } else {
            return param;
          }
        }).filter((param) => param !== '' && param !== undefined);

        const newUrl = newUrlParams.join('&');
        let questionMark = newUrl != '' ? '?' : '';
        let moveHere = baseUrl + questionMark + newUrl;
        moveHere = moveHere.endsWith('&') || moveHere.endsWith('?') ? moveHere.slice(0, -1) : moveHere;

        window.location.href = baseUrl + questionMark + newUrl;
      } else {
        window.location.href = `${currentUrl}?${query}`;
      }
    }

    $('#search_icon').on('click', function () {
      var Id = $('#repo_name_search').val();

      var key = 'text=';

      addRightParams(Id, key);

      // console.log('ahoj');
      // var filter = $('#repo_name_search').val();
      // if (filter == '') {
      //   $('.repo_item').show();
      // } else {
      //   $('.repo_item').each(function (i, item) {
      //     var title = $(item).attr('data-title');
      //     var inr = $(item).attr('inr');

      //     if (title.toLowerCase().indexOf(filter.toLowerCase()) >= 0) {
      //       $(item).show();
      //     } else {
      //       $(item).hide();
      //     }
      //   });
      // }
    });

    $('#repo_name_search').on('change', function () {
      var filter = $(this).val();
      if (filter == '') {
        $('.repo_item').show();
      }
    });

    $('#repo_name_search').keypress(function (ev) {
      var keycode = ev.keyCode ? ev.keyCode : ev.which;
      if (keycode == '13') {
        $('#search_icon').click();
      }
    });

    $('#show_upload').on('click', function () {
      $('#repo_upload_overlay').show();
      $('#repo_upload_holder').fadeIn('fast');
      igniteCKEditorRepo();
    });

    $('#show_upload3').on('click', function () {
      $('#repo_upload_overlay').show();
      $('#repo_upload_holder').fadeIn('fast');
      // $('#image_tag').select2();

      igniteCKEditorRepo();
    });

    $('#show_edit_repo').on('click', function () {
      $('#repo_edit_overlay').show();
      $('#repo_edit_holder').fadeIn('fast');
      igniteCKEditorRepo();
    });

    $('#close_repo_upload').on('click', function () {
      $('#repo_upload_overlay').fadeOut('fast');
      $('#repo_upload_holder').fadeOut('fast');
    });

    $('#close_repo_upload2').on('click', function () {
      $('#repo_edit_overlay').fadeOut('fast');
      $('#repo_edit_holder').fadeOut('fast');
    });

    $('#repo_select_file').on('click', function () {
      $('#repo_image_input').click();
    });

    $('#repo_image_input').on('change', function () {

      var input = $(this).val().split('\\').pop();
      // $('#repo_upload_image_holder').find('img').remove();
      $('.noFilesSpan').hide()

      $('.repoTempWrapper').remove();
      var files_text = '';

      console.log(this.files)

      for (var i = 0; i < this.files.length; i++) {
        var file = this.files[i];
        // files_text += file.name + '<br>';

        (function (file) {
          var reader = new FileReader();
          reader.onload = function () {
            if (file.type === 'application/pdf') {
              var pdf_iframe = $('<iframe>');
              pdf_iframe
                .attr('src', this.result)
                .appendTo('#repo_upload_image_holder');

            } else {

              // if (i > 0) {

              let stream =
                `
                  <div class="repoTempWrapper">
                    <img class="repoTempImg" src="${this.result}">
                    <div class="repoTempName">${file.name}</div>
                  </div>
                  `

              $(stream).appendTo('#repo_upload_image_holder')

              // var new_img = $('<img>');
              // new_img
              //   .attr('src', this.result)
              //   .appendTo('#repo_upload_image_holder');

              // }

              // else {
              //   $('#repo_upload_image_holder')
              //     .find('img')
              //     .attr('src', this.result)
              //     .show();
              // }

            }
          };
          reader.readAsDataURL(file);
        })(file);
      }

      // $('#repo_selected_file').html(files_text);
    });

    $('#repo_customize').click(function () {
      var $this = $(this);
      $this.text('Updating...');

      var $ids = [];

      $('.activeSelect').each(function () {
        $ids.push($(this).closest('.repo_item').attr('data-id'));
      });

      let requests = $ids.map((id) => {
        let data = $('#repo_customize_form').serialize() + '&id=' + id;
        return $.ajax({
          type: 'POST',
          url: rootUrl + 'entities/Repository/customizeImage',
          data: data,
          success: function (data) {
            console.log(data);
          },
        });
      });

      Promise.all(requests).then(() => window.location.reload());


    });

    $('#repo_upload_image_progressive').click(function () {
      var $this = $(this);
      $this.hide();
      var uploadpath = '/items/uploads/images';
      var files = $('#repo_image_input').prop('files');
      var uploadsCompleted = 0;

      function uploadFiles(files, startIndex) {
        var counter = 0;
        var endIndex = Math.min(startIndex + 3, files.length);

        $('.barHolder').empty();

        // $("#repo_upload_overlay").fadeOut("fast");
        $('#repo_upload_holder').fadeOut('fast');
        $('.barHolder').fadeIn('fast');
        // $("#repo_upload_overlay").fadeIn("fast");

        // var completedUploads = 0; // Add this line;

        for (var index = startIndex; index < endIndex; index++) {
          console.log('uploading file ' + index + ' of ' + files.length);
          console.log('endIndex' + endIndex);
          var file = files[index];
          var xhr = new XMLHttpRequest();
          var fd = new FormData();
          fd.append('data', file);
          fd.append('filename', file.name);
          fd.append('uploadpath', uploadpath);
          fd.append('file_size', file.size);

          var progressElement =
            '<div class="uploadBar progressElement_' +
            index +
            '"><div class="fileName">' +
            file.name +
            '</div><div class="progressBarHolder"><div class="progressBar"></div></div></div > ';

          $('.barHolder').append(progressElement);

          xhr.addEventListener('load', function (e) {
            var ret = $.parseJSON(this.responseText);

            if (ret.success) {
              $('#repo_fname').val(ret.filename);
              var formData =
                $('#repo_image_form').serialize() +
                '&repo_fname_orig=' +
                ret.filename_orig;
              $.ajax({
                type: 'POST',
                url: rootUrl + 'entities/Repository/saveImage',
                data: formData,
                success: function (data) {
                  uploadsCompleted++;
                  counter++;
                  var json = $.parseJSON(data);
                  if (json.status == 'success') {
                    if (counter === endIndex - startIndex) {
                      if (uploadsCompleted < files.length) {
                        uploadFiles(files, endIndex);
                      } else {
                        setTimeout(function () {
                          $('#repo_selected_file').html('');
                          $('#repo_upload_image_holder').find('span').show();
                          $('#repo_upload_image_holder').find('img').remove();
                          $('.barHolder').html('Success!');
                          // $("#close_repo_upload").click();
                          // $("#repo_upload_overlay").fadeOut("fast");
                          $('#repo_upload_holder').fadeOut('fast');
                          $('.barHolder').fadeOut('fast');
                          $('body').append(`
                                      <div id="waiting_for_reload">
                                        Upload done, reloading the page, please wait.
                                      </div>`);
                          setTimeout(function () {
                            $('#waiting_for_reload').fadeIn('fast');
                            $('#repo_upload_overlay').fadeIn('fast');
                          }, 200);
                          window.location.reload();
                        }, 1000);
                      }
                    }
                  }
                },
              });
            } else {
              $('#upload_pending').hide();
              alert('Error while uploading');
            }
          });

          (function (index) {
            xhr.upload.addEventListener(
              'progress',
              function (evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  percentComplete = parseInt(percentComplete * 100);

                  $('.progressElement_' + index)
                    .find('.progressBar')
                    .css('width', percentComplete + '%');
                  $('.progressElement_' + index)
                    .find('.progressBar')
                    .html(percentComplete + '%');

                  if (percentComplete === 100) {
                    $('.progressElement_' + index).remove();

                    if (!$.trim($('.barHolder').html())) {
                      $('.barHolder').html('Loading...');
                    }

                  }
                }
              },
              false,
            );
          })(index);

          xhr.open('post', rootUrl + 'entities/Repository/upload_image');
          xhr.addEventListener('error', function (e) {
            console.log('error');
            console.log(e);
          });
          xhr.send(fd);
        }
      }
      // Start the upload
      uploadFiles(files, 0);
    });
      } else {
    $('#repo_upload_image').off('click');
    $('#show_upload').off('click');
    $('#repo_name_search').off('change');
    $('#search_icon').off('click');
    $('#repo_sort').off('change');
    $('#repo_category').off('change');
    $('#repo_item_select').off('click');
  }
}



    function selectImageListener() {
      $('.crud_tab_item[type="module_content"]').click();
      $('.repo_item').off('click');
      $('.repo_item').on('click', function () {
        $this = $(this).find('.repo_item_select');
        var iid = $this.attr('iid');
        var fname = $this.attr('fname');

        if (!$(this).hasClass('selected_item')) {
          var fullPath = rootUrl + 'items/uploads/images/' + fname;
          var desc =
            $this.attr('alt') != undefined
              ? $this.attr('alt')
              : $this.attr('title');
          desc = desc != 'undefined' ? desc : '';
          active_id = active_module.attr('module_id');

          var mod_id = active_module.attr('module_id');

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
            '<div class="gallery_popup_item" ordering="999" repo_id="' +
            iid +
            '" fname="' +
            fname +
            '">' +
            '<div class="gallery_item_remove">X</div>' +
            '<img style="width:120px;float:left;" src="' +
            fullPath +
            '" />' +
            '<div class="item_data_holder">' +
            '<label>Description:</label><br/>' +
            '<textarea  name="item_description" class="gallery_item_description">' +
            desc +
            '</textarea><br/>' +
            '<label>Link (full URL):</label>' +
            '<input type="text" name="item_link" class="gallery_item_link"></input>' +
            '</div>' +
            '</div>';

          $('#popup_edit_gallery_holder').append(elem);

          toggleGalleryListener(true);
          $this.addClass('selected');
          $(this).addClass('selected_item');
        } else {
          $('#popup_edit_gallery_holder')
            .find('.gallery_popup_item[repo_id="' + iid + '"]')
            .find('.gallery_item_remove')
            .click();
          $this.removeClass('selected');
          $(this).removeClass('selected_item');
        }

        $('#close_repo').addClass('selected_items');
      });
    }

    function igniteCKEditorRepo() {
      // CKEDITOR.replace('image_title_en', {
      //   height: 50,
      //   customConfig: 'config_repo.js',
      // });
      // CKEDITOR.replace('image_title_de', {
      //   height: 50,
      //   customConfig: 'config_repo.js',
      // });
      // CKEDITOR.replace('image_credits_text', {
      //   height: 50,
      //   customConfig: 'config_repo.js',
      // });
      // CKEDITOR.replace('image_credits_text_en', {
      //   height: 50,
      //   customConfig: 'config_repo.js',
      // });
      /* $("#image_title").ckeditor();
      $("#image_credits_text").ckeditor();
      $("#image_credits_text_en").ckeditor();*/
    }

    function removeRepoItem(has_article, type, entity_id, repo_item_id) {

      $.ajax({
        url: rootUrl + 'Backend/removeRepo',
        data: {
          type: type,
          has_article: has_article,
          repo_id: repo_item_id,
          entity_id: entity_id,
        },
        method: 'POST',
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            console.log('success');
          }
        },
      });
    }


function deletePreviousModuleImagesAndAddNewOnes(module_type, module_id, callback) {

      $.ajax({
        url: rootUrl + 'entities/Content/deletePreviousModuleImages',
        data: {
          module_type: module_type,
          module_id: module_id,
        },
        method: 'POST',
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
              $('.selected_image').each(function (item) {
                var repo_id = $(this).attr('repo_id');
                var description = $(this).find('textarea').val();
                var ordering = item + 1;

                updateModuleImages(
                  module_type,
                  module_item_id,
                  module_id,
                  repo_id,
                  ordering,
                  description,
                  callback,
                );
              });
          }
        },
      });
    }

    function updateModuleImages(
      module_type,
      module_item_id,
      module_id,
      repo_id,
      ordering,
      description,
      callback,
    ) {
      $.ajax({
        url: rootUrl + 'entities/Content/updateModuleImages',
        data: {
          module_type,
          module_item_id,
          repo_id: repo_id,
          module_id,
          ordering: ordering,
          description,
        },
        method: 'POST',
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            callback();
          }
        },
      });
    }


    function updateRepoItem(has_article, type, entity_id, repo_item_id, ordering, callback) {
      $.ajax({
        url: rootUrl + 'Backend/updateRepoItem',
        data: {
          type: type,
          repo_id: repo_item_id,
          entity_id: entity_id,
          ordering: ordering,
          has_article: has_article,
        },
        method: 'POST',
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            callback();
          }
        },
      });
    }

    function saveRepoItem(has_article, type, entity_id, repo_item_id, ordering, fname, title) {
      $.ajax({
        url: rootUrl + 'Backend/updatRepo',
        data: {
          type: type,
          repo_id: repo_item_id,
          entity_id: entity_id,
          ordering: ordering,
          has_article: has_article,
        },
        method: 'POST',
        success: function (data) {
          var ret = $.parseJSON(data);
          if (ret.success) {
            var elem =
              `<div class="selected_image" ordering="${ordering}" has_article="${has_article}"  type="${type}" entity_id="${entity_id}" repo_id="${repo_item_id}"><img class="current_img" src=" ${rootUrl + 'items/uploads/images/thumbs/' + fname
              }">` +
              // <div class="current_title">${title_de}</div>

              `<div class="remove_upload ui-rounded1">Remove</div>
        <div class="mosaic_tool up teaser_up"></div>
        <div class="mosaic_tool down teaser_down"></div>
        </div>`;

            $('#current_image_holder').append(elem);

            dragAndDropSelectors();



          }

          teaserMove();
        },
      });
    }
