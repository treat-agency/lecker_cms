


 // repofilter and loading of images
$(document).ready(function () {

  updateCurrentCount();

  function updateCurrentCount() {
    console.log('call')
    $count = $('.repo_item').length;
    if ($count > $('.countRepoButton').text) {
      $count = $('.countRepoButton').text;
    }

    $('.currentRepoButton').text($count);
  }


  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

    // parameters to save
    let parametersArray = ['tag', 'date_added', 'date_taken', 'category', 'sort', 'text'];

    // set first length

    if (sessionStorage.getItem("repo_position") != null) {


      let button = $(".js-moreRepoElems");
      let buttonText = $(".js-moreRepoElems .textRepoButton");
      buttonText.text('loading...')

      lastElem = $('.repo_item').length
      number = sessionStorage.getItem('repo_position');

      let url = window.location.pathname.split("?").pop();
      // this is ausstellungsarchiv or exhibition-archive


    let dataObject = {};
      parametersArray.forEach((name) => {

      dataObject[name] = getUrlParameter(name);

    });


      dataObject['number'] = number;
      dataObject['lastElem'] = lastElem;

      var additionalParams = '';
      if (typeof type !== 'undefined' && type) {
        additionalParams += '/' + type;
        additionalParams += '/' + entity_id;
        additionalParams += '/' + has_article;
      }

      if (repoController === 'repo_module') {
        additionalParams = "";
        additionalParams += '/' + module_type;
        additionalParams += '/' + module_item_id;
        additionalParams += '/' + module_id;
      }


      $.ajax({
        type: 'POST',
        url:
          rootUrl +
          'entities/Content/'  + repoController + '/' +
          additionalParams,
        data: dataObject,
        success: function (data) {
          try {
            buttonText.text('load more');
            $('#repo_container').append(data);
          } catch (error) {
            console.error('An error occurred:', error);
          }
          updateCurrentCount();

          button.show();
          // lazy_load_images();

          updateCurrentCount();

          // $('.numberOfResults').html(newLength + ' <?= $this->lang->line('filter_results') ?>');
        },
      });

    }

    $(".js-moreRepoElems").click(function() {

      //hide the button and or show a loading something
      let button = $(this);
      let buttonText = $(".js-moreRepoElems .textRepoButton");

      buttonText.text('loading...')
      // button.hide();

    let parametersArray = ['tag', 'date_added', 'date_taken', 'category', 'sort', 'text'];

    let dataObject = {};
    parametersArray.forEach((name) => {

      dataObject[name] = getUrlParameter(name);

    });


      number = COUNT_LOADED_IMAGES;
      lastElem = $('.repo_item').length

      dataObject['number'] = number;
      dataObject['lastElem'] = lastElem;


      var repo_position = lastElem + number;

      sessionStorage.setItem('repo_position', repo_position);


      let url = window.location.pathname.split("?").pop();
      // this is ausstellungsarchiv or exhibition-archive

      var additionalParams = '';
      if (typeof type !== 'undefined' && type) {
        additionalParams += '/' + type;
        additionalParams += '/' + entity_id;
        additionalParams += '/' + has_article;
      }




      $.ajax({
        type: 'POST',
        url: rootUrl + 'entities/Content/' + repoController + '/' + additionalParams,
        data: dataObject,
        success: function (data) {
          try {
            buttonText.text('load more');
            $('#repo_container').append(data);
          } catch (error) {
            console.error('An error occurred:', error);
          }
          updateCurrentCount();

          button.show();
          // lazy_load_images();

          //
        },
      });
    });

    // on reaching scrolling bottom loads more
      let scrCont = $(document);

      $(document).scroll(function() {

        let whereAmI = scrCont.scrollTop() + $(window).height()
        let contHeight = scrCont.height()

        if( (contHeight - 100) < whereAmI ) {
          $(".js-moreRepoElems").click();
        }

      });



  // $('#image_tag').select2();
  $('#image_tag3').select2();
  $('#image_tag').select2();
  $('#image_tag2').select2();
  $('#image_tag2_remove').select2();
  $('#repo_category').select2();
  $('#repo_proj').select2();
  $('#repo_tag').select2();
  $('#repo_sort').select2();
  $('#repo_date_added').select2();
  $('#repo_sort_type').select2();

  $('#download_zip').on('click', function () {
    var srcs = [];
    $('.activeSelect').each(function () {
      var src = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find('.repo_img')
        .attr('img_path_full');

      srcs.push(src);
    });

    $.ajax({
      type: 'POST',
      url: rootUrl + 'Backend/zip',
      data: {
        srcs: JSON.stringify(srcs),
      },
      success: function (data) {
        var json = $.parseJSON(data);

        window.open(rootUrl + json.path, '_blank');
      },
    });
  });

  function selectorCheck() {
    $('#repo_container').on('click', '.selectRepo', function () {
      if ($(this).hasClass('activeSelect')) {
        $(this)
          .find('.checker_image')
          .attr('src', rootUrl + 'items/backend/img/checkboxOn.png');

        $(this).find('.checker_image').css('width', '27px');
      } else {
        // $(this).html('select')
        $(this)
          .find('.checker_image')
          .attr('src', rootUrl + 'items/backend/img/checkbox.png');

        $(this).find('.checker_image').css('width', '20px');
      }
    });
  }

  $('#repo_container').on('click', '.selectRepo', function () {
      $(this).toggleClass('activeSelect');

      selectorCheck();
  });

  $('.selectAllImages').on('click', function () {
    $(this).toggleClass('allSelected');

    if ($(this).hasClass('allSelected')) {
      $('.selectRepo').each(function () {
        if ($(this).is(':visible')) {
          $(this).addClass('activeSelect');
        }
      });
    } else {
      $('.selectRepo').each(function () {
        $(this).removeClass('activeSelect');
      });
    }

    selectorCheck();
  });

  $('.deselectImages').on('click', function () {
    $('.selectRepo').each(function () {
      $(this).removeClass('activeSelect');
      selectorCheck();
    });
  });

  $('#filterForRepo').on('click', function () {
    $('#repo_filters').toggleClass('activeFilter');

    if ($('#repo_filters').hasClass('activeFilter')) {
      $('#repo_filters').slideDown();
    } else {
      $('#repo_filters').slideUp();
    }
  });


  // display image
    var edit_timer;
  $('#repo_content').on('mouseenter click', '.repo_img', function() {
    clearTimeout(edit_timer);
    var item = $(this).parent();
    if (!item.hasClass('edit_item')) {
      console.log('add timer');
      edit_timer = setTimeout(function() {
        item.addClass('edit_item');
        console.log('edit_item');
      }, 2000);
    };

  });

  $('#repo_content').on('mouseleave', '.repo_img', function() {
    $('.edit_item').removeClass('edit_item');
    clearTimeout(edit_timer);
    console.log('remove timer');
  });



  // on reaching scrolling bottom loads more
  let repoContainer = $('#repo_container')
  repoContainer.scroll(function () {
    if (repoContainer.scrollTop() + repoContainer.height() + 5 > repoContainer[0].scrollHeight) {
      $('.js-moreRepoElems').click()
    }
  })


})