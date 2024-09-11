$(document).ready(function () {

  // search icon click
  $('.search_icon, #search_icon_mob, #search_icon_page, #search_icon2').click(
    function () {
      if ($('.mobileMarker:visible').length) {
        // console.log($(this).parent().find('.treat_input').val())
        if ($('.searchTextMob').val()) {
          var searchString = $('.searchTextMob').val();
        } else {
          var searchString = $('.searchTextDesktop2').val();
        }
      } else {
        if ($('.searchTextDesktop').val()) {
          var searchString = $('.searchTextDesktop').val();
        } else {
          var searchString = $('.searchTextDesktop2').val();
        }
      }

      // console.log($(this).parent().find('.treat_input').val())

      var input = searchString;
      var input_val = input.trim().toLowerCase();
      if (input_val != '') {
        $.ajax({
          type: 'POST',
          url: rootUrl + 'Frontend/search_save',
          data: {
            input_val: input_val,
          },
          success: function (data) {
            console.log('');
          },
        });
      }

      window.location.href = rootUrl + 'search/' + input_val;
    },
  );

  // using enter instead of click
  $('.js-keyupSearch').on('keyup', function () {
    var keycode = event.keyCode ? event.keyCode : event.which;

    // searching with enter btn
    if (keycode == '13') {
      if ($('.mobileMarker:visible').length) {
        $('#search_icon_mob').click();
      } else {
        $('#search_icon').click();
      }
    }
  });

  $('.searchTextDesktop').on('keyup', function () {
    var keycode = event.keyCode ? event.keyCode : event.which;

    // searching with enter btn
    if (keycode == '13') {
      if ($('.mobileMarker:visible').length) {
        $('#search_icon_mob').click();
      } else {
        $('#search_icon').click();
      }
    }
  });

  $('.searchTextDesktop2').on('keyup', function () {
    var keycode = event.keyCode ? event.keyCode : event.which;

    // searching with enter btn
    if (keycode == '13') {
      if ($('.mobileMarker:visible').length) {
        $('#search_icon2').click();
      } else {
        $('#search_icon2').click();
      }
    }
  });


  // clickin on tag element
    $('.tagElem').on('click', function () {
      var tag = $(this).html();
      if ($('.searchTextMob').is(':visible')) {
        $('.searchTextMob').val(tag);
        if ($('#search_icon_mob').is(':visible')) {
          $('#search_icon_mob').click();
        }
      } else if ($('.searchTextDesktop').is(':visible')) {
        $('.searchTextDesktop').val(tag);
        if ($('#search_icon').is(':visible')) {
          $('#search_icon').click();
        }
      } else if ($('.searchTextDesktop2').is(':visible')) {
        $('.searchTextDesktop2').val(tag);
        if ($('#search_icon2').is(':visible')) {
          $('#search_icon2').click();
        }
      }
    });
});