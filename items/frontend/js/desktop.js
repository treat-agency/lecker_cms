
/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
|
*/


$('#form').on('submit', function (e) {
  // always at forms to prevent default
  e.preventDefault();
  var btn = $('.js-form_button');
  var form = $(this);

  console.log(form.serialize());
  btn.hide();

  $.ajax({
    type: 'POST',
    url: rootUrl + 'Frontend/form_processing',
    data: form.serialize(),
    success: function (data) {
      var json = JSON.parse(data);

      if (json.success == false) {
        btn.show();
      } else {
        $('#form').hide();
      }

      $('#form_message').html(json.text).show();
    },
  });
});




if (screen.width < 650) {
  var mvp = document.getElementById('vp');
  mvp.setAttribute('content', 'user-scalable=no,width=550');
}

$(document).ready(function () {
  addListeners();

  if ($('.editorialSlider').length > 0) {
    $('.js-example-basic-single').select2();
  }
  mark_scroll_position();

  // adjustImageRatio();

  $(window).resize(function () {
    // adjustImageRatio();
    calculateHeightOfCardImgs();
  });

  calculateHeightOfCardImgs();

  function calculateHeightOfCardImgs() {
    var cardWidth = $('.groupElemWrapper').width();
    console.log(cardWidth);
    var cardHeight = cardWidth;

    $('.groupElemImg').each(function () {
      $(this).height(cardHeight);
    });
    // $('.groupElemImg img').each(function() {
    //     $(this).height(cardHeight)
    // })
  }

  $('.collapsibleButton').click(function () {
    $(this).toggleClass('opened');
    $('.collapsibleContainer').slideToggle('opened');
  });
});

$(window).on('load', function () {
  mark_scroll_position();
});

// $(document).scroll(function () {
//   localStorage.setItem(window.location.href, $(document).scrollTop());
// });

// scroll back in category pages

function mark_scroll_position() {
  current_url = window.location.href;
  if (current_url.includes('/category/')) {
    var current_scroll = localStorage.getItem(current_url);
    if (current_scroll == null) {
      // scroll to random locationon certain page if no scroll info stored

      $('body').animate(
        {
          //  scrollTop: getRandomInt($(document).height()),
        },
        10,
      );
    } else {
      $(window).scrollTop(current_scroll);
    }
  }
}
// end scroll back in category pages

function reloadWithAttributes(pageNum, categoryTabId) {
  /*  $('body').animate({opacity:0},300, function(){
    //$('body').hide();
  });
  */
  setTimeout(function () {
    if (pageNum == undefined) {
      pageNum = 1;
    }

    if (categoryTabId == undefined) {
      categoryTabId = 0;
    }

    var search_text = $('#search_text').val();
    var year_start = $('#filter_start_year').val();
    var year_end = $('#filter_end_year').val();
    var period = $('.clickable_filter_item.current.active').attr('atr');
    var sort = $('.clickable_filter_item.sorting.active').attr('atr');

    var url = location.protocol + '//' + location.host + location.pathname;

    window.location.href =
      url +
      '?search_text=' +
      search_text +
      '&year_start=' +
      year_start +
      '&year_end=' +
      year_end +
      '&period=' +
      period +
      '&sort=' +
      sort;
  }, 350);
}

function reloadWithAttributesMembers(pageNum, categoryTabId) {
  /*  $('body').animate({opacity:0},300, function(){
    //$('body').hide();
  });
  */
  setTimeout(function () {
    if (pageNum == undefined) {
      pageNum = 1;
    }

    if (categoryTabId == undefined) {
      categoryTabId = 0;
    }

    var search_text = $('#search_text').val();
    /*  var year_start = $("#filter_start_year").val();
    var year_end = $("#filter_end_year").val();*/
    var member_start = $('#filter_start_member').val();
    var member_end = $('#filter_end_member').val();
    var active = $('#filter_member_active').val();
    var sort = $('.clickable_filter_item.sorting.active').attr('atr');
    var exhibited_in = $('#filter_exhibited_in').val();

    var url = location.protocol + '//' + location.host + location.pathname;

    window.location.href =
      url +
      '?search_text=' +
      search_text +
      '&exhibited_in=' +
      exhibited_in +
      /* "&birthday_start=" +
      year_start +
      "&birthday_end=" +
      year_end +*/
      '&member_start=' +
      member_start +
      '&member_end=' +
      member_end +
      /* "&active=" +
      active +*/
      '&sort=' +
      sort;
  }, 350);
}

function reloadWithAttributesCalendar(pageNum, categoryTabId) {
  /*  $('body').animate({opacity:0},300, function(){
      //$('body').hide();
    });
    */
  setTimeout(function () {
    if (pageNum == undefined) {
      pageNum = 1;
    }

    if (categoryTabId == undefined) {
      categoryTabId = 0;
    }

    var search_text = $('#search_text').val();
    var year_start = $('#filter_start_year').val();
    var year_end = $('#filter_end_year').val();
    var sort = $('.clickable_filter_item.sorting.active').attr('atr');
    var category = $('#filter_category').val();

    var url = location.protocol + '//' + location.host + location.pathname;

    window.location.href =
      url +
      '?search_text=' +
      search_text +
      '&year_start=' +
      year_start +
      '&year_end=' +
      year_end +
      '&category=' +
      category +
      '&sort=' +
      sort;
  }, 350);
}

function addListeners() {
  $('.lang_btn').click(function () {
    var lang = $(this).attr('lang');
    $.ajax({
      type: 'POST',
      url: rootUrl + 'Frontend/change_lang',
      data: {
        lang: lang,
      },
      success: function (data) {
        location.reload();
      },
    });
  });

  $('#submit_filter').click(function () {
    reloadWithAttributes();
  });

  $('#submit_filter_calendar').click(function () {
    reloadWithAttributesCalendar();
  });

  $('#submit_members_filter').click(function () {
    reloadWithAttributesMembers();
  });

  $('#reset_filter').click(function () {
    var url = location.protocol + '//' + location.host + location.pathname;

    window.location.href = url;
  });

  $('.clickable_filter_item.current').click(function () {
    $('.clickable_filter_item.current').removeClass('active');
    $(this).addClass('active');
  });

  $('.clickable_filter_item.sorting').click(function () {
    $('.clickable_filter_item.sorting').removeClass('active');
    $(this).addClass('active');
  });

  $('#category_filter_title').click(function () {
    $(this).toggleClass('active');
    $('#filtering_inner_holder').slideToggle();
  });

  // cookies
   $(
     '#cookie_warning button, #data_cookies button, #cookie_overview button',
   ).click(function () {
     console.log('checked');
     var btn = $(this);
     if (btn.hasClass('cookieAcceptAll')) {
       $('#cookie_mark_check').prop('checked', true);
        $('#cookie_nec_check').prop('checked', true);

     }


     var cookie_mark = $('#cookie_mark_check').prop('checked');
     var cookie_warning = $('#cookie_nec_check').prop('checked');

     //document.cookie = "cookie_warning=1; expires=Thu, 18 Dec 2030 12:00:00 UTC; path=/;secure=true";
     btn.css('opacity', '0.5');
     $('#cookie_warning').fadeOut();
     $.ajax({
       type: 'POST',
       url: rootUrl + 'Frontend/saveCookie',
       data: {
         cookie_mark,
         cookie_warning,
       },
       success: function (data) {
         console.log('KJKJKJ');
         if ($('#cookie_warning').is(':visible')) {
           location.reload();
         } else {
           btn.css('opacity', '1');
           var succ_msg =
             lang == 0
               ? 'Cookie-Einstellungen gespeichert.'
               : 'Cookie settings saved.';
           $('#cookie_msg').text(succ_msg);
           setTimeout(function () {
             $('#cookie_msg').text('');
           }, 3000);
         }

         if (cookie_mark) {
           // add GA
           var ga =
             "<script async src='https://www.googletagmanager.com/gtag/js?id=G-4FBNE13SK2'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-4FBNE13SK2');</script>";
           //$("head").append(ga);
           console.log('added GA');
         }
         location.reload();
       },
     });
   });


  //** MENU

  $('#mobile_menu_right').on('click', function () {
    if ($('#overlay_bg').css('display') == 'none') {
      $('#overlay_bg').css('display', 'flex');
      $('body').addClass('noScroll');
    } else {
      $('#overlay_bg').hide();
      $('body').removeClass('noScroll');
    }
  });
  //** footer

  //** landing page

  $('.filterBarInput, .filterBarButton').on('click', function (e) {
    if (
      !$(e.target).hasClass('closeImg') &&
      !$(e.target).hasClass('filterElem')
    ) {
      $('.filterInputHolder').toggleClass('opened');
      $('.filterCollapse').toggleClass('opened');
    }
  });

  $('.elemVideoWrapper').on('click', function () {
    $(this).toggleClass('playing');
  });

  $('.selectElement').on('click', function () {
    // $(this).hide();
    $(this).addClass('hiddenTag');

    var text = $(this).text();
    var tid = $(this).attr('tid');
    $('.newFilterCollect').append(
      '<div class="filterElem" tid="' +
        tid +
        '">' +
        text +
        '<div class="filterElemClose">' +
        "<img class='closeImg' src=" +
        rootUrl +
        '/items/frontend/img/logo/close.svg alt="">' +
        '</div>' +
        '</div>',
    );

    console.log('selectelemtn', $('.selectElement').length);
    console.log('hidden', $('.hiddenTag').length);

    handleBorder();
  });

  // tags
  $('.filterBar .selectElement').on('click', function () {
    update_by_tags();
  });

  $('.filterBar').on('click', '.filterElemClose', function () {
    var tid = $(this).parent().attr('tid');
    $(this).parent().remove();
    // $(".selectElement[tid=" + tid + "]").show();
    $('.selectElement[tid=' + tid + ']').removeClass('hiddenTag');
    update_by_tags();

    handleBorder();
  });

  function handleBorder() {
    if ($('.selectElement').length === $('.hiddenTag').length) {
      $('.filterCollapse').css('border', 'none');
    } else {
      $('.filterCollapse').css('border', '1px solid black');
      $('.filterCollapse').css('border-top', 'none');
    }
  }

  // if (selected_tag) {
  //   $('.collapsibleContainer').slideToggle();
  //   $('.filterCollapsibleWrapper').toggleClass('opened');
  //   $('.filterBar .selectElement[tid=' + selected_tag + ']').click();
  // }

  //Timer
  $('.video_timer').each(function () {
    var timer = $(this);
    var timer_text = timer.find('.video_timer_text');
    var timer_bar = timer.find('.video_timer_bar');
    var bar_width = 80;

    var start_time = timer.attr('start_time').trim().replace(' ', 'T');
    var end_time = timer.attr('end_time').trim().replace(' ', 'T');

    setInterval(function () {
      // end date
      var countDownDate = new Date(end_time).getTime();
      var now = new Date().getTime();
      var distance = countDownDate - now;
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // start date
      if (start_time != '30') {
        var startDate = new Date(start_time).getTime();
        var start_end_distance = countDownDate - startDate;
        var start_days = Math.floor(start_end_distance / (1000 * 60 * 60 * 24));
        var start_hours = Math.floor(
          (start_end_distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
        );
        var start_minutes = Math.floor(
          (start_end_distance % (1000 * 60 * 60)) / (1000 * 60),
        );
        var start_seconds = Math.floor(
          (start_end_distance % (1000 * 60)) / 1000,
        );
      } else {
        var start_end_distance = 1296000000; // 14 days before
      }

      bar_width =
        days > 13
          ? 2
          : ((start_end_distance - distance) / start_end_distance) * 100;

      if (days > 0) {
        var txt = start_time == '30' ? ' DAYS TILL START' : ' DAYS LEFT';
        timer_text.text(days + 1 + txt);
      } else if (hours > 0) {
        var txt = start_time == '30' ? ' HOURS TILL START' : ' HOURS LEFT';
        timer_text.text(hours + 1 + txt);
      } else if (minutes > 0) {
        var txt = start_time == '30' ? ' MINUTES TILL START' : ' MINUTES LEFT';
        timer_text.text(minutes + 1 + txt);
      } else if (seconds > 0) {
        var txt = start_time == '30' ? ' SECONDS TILL START' : ' SECONDS LEFT';
        timer_text.text(seconds + 1 + txt);
      } else {
        bar_width = 100;
        var txt = start_time == '30' ? ' SECONDS TILL START' : ' SECONDS LEFT';
        timer_text.text(0 + txt);

        setTimeout(function () {
          location.reload();
        }, 2000);
      }

      // loading
      if (start_time == '30' && days > 0) {
        bar_width = days > 30 ? 2 : Math.floor(((30 - days) / 30) * 100);
      } else {
      }

      timer_bar.width(bar_width + '%');
    }, 1000);
  });
  $('.video_play').click(function () {
    var video = $(this).parent().parent().find('.embed_holder video').get(0);
    video.play();
    $(this).hide();
    $(this).parent().find('.video_pause').show();
  });

  $('.video_pause').click(function () {
    var video = $(this).parent().parent().find('.embed_holder video').get(0);
    video.pause();
    $(this).hide();
    $(this).parent().find('.video_play').show();
  });

  $('.video_mute').click(function () {
    var video = $(this).parent().parent().find('.embed_holder video');
    video.prop('muted', true);
    //v = document.getElementById("current_video")
    //v.textTracks[0].mode = "showing";
    $(this).hide();
    $(this).parent().find('.video_unmute').show();
  });

  $('.video_unmute').click(function () {
    var video = $(this).parent().parent().find('.embed_holder video');
    video.prop('muted', false);
    //v = document.getElementById("current_video")
    //v.textTracks[0].mode = "hidden";

    $(this).hide();
    $(this).parent().find('.video_mute').show();
  });

  //**** detail page

  // gallery module normal/slider
  var gc = 1;
  $('.gallery_item').each(function () {
    var gallery_container = $(this).parent().parent();
    if (!gallery_container.hasClass('gallery_slider_1')) {
      var img_container = $(this).parent();
      var img_width = $(this).width();
      var module_width = gallery_container.width();

      //console.log(img_container);

      if ((img_width * 100) / module_width >= 70) {
        img_container.addClass('gallery_full');
      } else {
        img_container.addClass('gallery_half');

        $('.last_uneven').removeClass('last_uneven');
        if (gc % 2 != 0) {
          img_container.addClass('last_uneven');
        }

        img_container.remove();
        gallery_container.append(img_container);
      }
      gc++;
    }
  });

  $('.gallery_container_1').each(function () {
    var container = $(this);

    var gallery = container.find('.gallery_slider_1');
    var images = gallery.find('a');

    var current_count_el = container.find('.current');
    var total_count = parseInt(container.find('.total').text());
    var arrow_right_id =
      '#' + container.find('.gallery_slider_nav_right').attr('id');
    var arrow_left_id =
      '#' + container.find('.gallery_slider_nav_left').attr('id');

    images.each(function (img) {
      var img_text = $(this).attr('data-title');
      $(this)
        .find('.gallery_item')
        .append('<div class="gallery_item_text">' + img_text + '</div>');
    });

    gallery.slick({
      dots: false,
      arrows: true,
      appendArrows: '#slider_arrows_container',
      nextArrow: arrow_right_id,
      prevArrow: arrow_left_id,
      draggable: true,
      rows: 1,
      infinite: false,
      adaptiveHeight: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
    });

    gallery.on('afterChange', function (event, slick, currentSlide, nextSlide) {
      current_count_el.text(currentSlide + 1);
    });
  });

  //***** category pages

  //***** end SKV ****/

  //******** stand alone functions and animation tools ********/

  // collapsable items
  $('.collapse_controler').click(function () {
    var filter_id = $(this).attr('controle');
    var arrow = $(this).find('.arrow');
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      arrow.removeClass('active');
      $('#' + filter_id).slideUp();
    } else {
      $(this).addClass('active');
      $(arrow).addClass('active');
      $('#' + filter_id).slideDown();
    }
  });

  $('div[collapse_default="closed"]').slideUp(0);
  $('div[collapse_default="open"]').each(function () {
    var id = $(this).attr('id');
    var controler = $('.collapse_controler[controle="' + id + '"]');
    var arrow = controler.find('.arrow');
    controler.addClass('active');
    $(arrow).addClass('active');
  });

  // activation
  $('.activation_controler').click(function () {
    var target = $(this).attr('activate');
    var sibling = $(this).attr('sibling');
    var arrow = $(this).find('.arrow');

    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      arrow.removeClass('active');
      $(target).removeClass('active');
      $(sibling).removeClass('active');
    } else {
      $(this).addClass('active');
      $(arrow).addClass('active');
      $(target).addClass('active');
      $(sibling).addClass('active');
    }
  });

  $('.slider_controler').click(function () {
    var target = $(this).attr('activate');
    $(this).toggleClass('active');
    $(target).slideToggle();
  });

  // overlays
  $('.overlay_trigger').click(function () {
    var target = $(this).attr('trigger');
    $('#' + target).fadeIn();
    $('#overlay_bg , #overlay_close').fadeIn().addClass('active_overlay');
  });

  // closing overlays
  $('#overlay_bg , #overlay_close').click(function () {
    //  reset overlay form after closing
    $('.overlay form').trigger('reset');
    $('.overlay .js-example-basic-single').select2();

    // general
    $('.overlay').fadeOut();
    $('#overlay_bg , #overlay_close').fadeOut().removeClass('active_overlay');
  });

  // scroll hock
  $('.scroll_hock').click(function () {
    var target = $('#' + $(this).attr('scroll_to'));
    target.css({
      'box-shadow': ' 0 0 80px 4px #8e8c8c',
      transform: 'scale(1.01)',
      'background-color': 'white',
      padding: '0 5px',
    });
    $([document.documentElement, document.body]).animate(
      {
        scrollTop: target.offset().top - 150,
      },
      1500,
      function () {
        target.css({
          transition: 'all 1s ease-in-out',
          'box-shadow': ' 0 0 0px 0px #8e8c8c',
          transform: 'scale(1.0)',
          'background-color': 'transparent',
          padding: '0',
        });
      },
    );
  });

  // right left scroll
  $('.side_scroll_icon').click(function () {
    var target = $(this).attr('scroll');
    var direction = $(this).attr('direction') == 'left' ? '-=' : '+=';
    $(target).animate({ scrollLeft: direction + $(target).width() }, 500);
  });

  // counter
  count();
  function count() {
    setTimeout(function () {
      $('.counter').each(function () {
        counter = $(this);
        count_items = $('.' + $(this).attr('count') + ':visible').length;
        counter.text('(' + count_items + ')');
      });
    }, 300);
  }

  // img frontend replace
  $('.img_replace').click(function () {
    var target = $('#' + $(this).attr('replace'));
    var img = $(this).attr('src');
    var replaced_img = target.attr('src');
    target.attr('src', img);
    $(this).attr('src', replaced_img);
  });

  $('.reload_btn').click(function () {
    setTimeout(function () {
      location.reload();
    }, 500);
  });

  // frontend search
  $('#tagFilterInput').on('keyup', function () {
    console.log('KJLKJLFKJ');
    var val = $(this).val().trim().toLowerCase();
    var target = $(this).attr('search');
    //console.log(val);
    if (val != '') {
      $(target).each(function () {
        var target_html = $(this).html().toLowerCase();
        if (target_html.includes(val)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    } else {
      $(target).show(0);
    }

    // var

    // if($('.selectElement').)
  });

  // // frontend search
  // $("#container").on("keyup", ".filterInput", function () {
  //   var val = $(this).val().trim().toLowerCase();
  //   var target = $(this).attr("search");
  //   //console.log("searching..");
  //   if (val != "") {
  //     //console.log("val");
  //     $(target).each(function () {
  //       //console.log("loop");
  //       var target_html = $(this).html().toLowerCase();
  //       if (target_html.includes(val)) {
  //         $(this).parent().show();
  //         // console.log("shown");
  //       } else {
  //         $(this).parent().hide();
  //         //console.log("hidden");
  //       }
  //     });
  //   } else {
  //     $(target).show(0);
  //   }
  // });

  //******** end stand alone functions ********/

  //********  forms ********/
  // log in and reset password
  $('#log_in_email, #log_in_password').on('keyup', function (event) {
    $(this).removeClass('err');
    $('#login_container .treat_error_msg').text('');
    var keycode = event.keyCode ? event.keyCode : event.which;
    if ($('#log_in_password:visible').length != 0) {
      if (keycode == '13') {
        $('#log_in_btn').click();
      }
    } else {
      if (keycode == '13') {
        $('#reset_password_btn').click();
      }
    }
  });

  $('#log_in_btn').click(function () {
    var email = $('#log_in_email').val().trim();
    var password = $('#log_in_password').val().trim();

    if (email != '') {
      $.ajax({
        type: 'POST',
        url: rootUrl + 'Frontend/user_login',
        data: {
          email: email,
          password: password,
        },

        success: function (data) {
          if (data == 'false') {
            $('#log_in_email').addClass('err');
            $('#log_in_password').addClass('err');
            $('#login_container .treat_error_msg')
              .text('This E-mail is not registered.')
              .addClass('err');
          } else if (data == 'password') {
            $('#log_in_password').addClass('err');
            $('#login_container .treat_error_msg')
              .text('Incorrect password.')
              .addClass('err');
          } else if (data == 'ok') {
            window.location.reload();
          } else {
            $('#log_in_password').addClass('err');
            $('#login_container .treat_error_msg')
              .text('sorry, this user is either expired or not registered.')
              .addClass('err');
            //console.log(data);
          }
        },
      });
    } else {
      $('#log_in_email').addClass('err');
      $('#login_container .treat_error_msg').text(
        'Please provide an E-mail to log in.',
      );
    }
  });

  // reset password
  // ToDo set emailing first
  $('#reset_password_btn').click(function () {
    if ($(this).hasClass('active')) {
      var email = $('#log_in_email').val().trim();
      if (email != '') {
        $.ajax({
          type: 'POST',
          url: rootUrl + 'Frontend/reset_password',
          data: {
            email: email,
          },

          success: function (data) {
            if (data == 'false') {
              $('.treat_error_msg')
                .text('If you were registered: e-mail sent.')
                .css('color', 'red');

              setTimeout(function () {
                $('.treat_error_msg').text('').css('color', '#a90000');
              }, 3000);
            } else if (data == 'true') {
              $('.treat_error_msg')
                .text('If you were registered: e-mail sent.')
                .css('color', 'green');

              setTimeout(function () {
                $('.treat_error_msg').text('').css('color', '#a90000');
              }, 2000);
            } else {
              //console.log(data);
            }
          },
        });
      } else {
        $('#log_in_email').addClass('err');
        $('#login_container .treat_error_msg').text(
          'Please provide an E-mail to reset the password.',
        );
      }
    } else {
      $(this).addClass('active treat_btn');
      $('#log_in_email').attr('placeholder', 'E-mail');
      $(this).text('Reset password');
      $('#log_in_password,#log_in_btn').hide();
    }
  });

  $('#reset_password_final_btn').click(function () {
    var password = $('#reset_password_field').val().trim();
    var password_repeat = $('#reset_password_r_field').val().trim();
    var user_id = $(this).attr('user_id');

    $.ajax({
      type: 'POST',
      url: rootUrl + 'Frontend/reset_password_final',
      data: {
        password: password,
        password_repeat: password_repeat,
        user_id: user_id,
      },

      success: function (data) {
        if (data.includes('true')) {
          $('#login_container .treat_error_msg')
            .text('Done! you can now log in .')
            .css('color', 'green');
          setTimeout(function () {
            window.location.href = rootUrl + 'backend';
          }, 2500);
        } else {
          $('#login_container .treat_error_msg').text(data);
        }
      },
    });
  });


  $('#reset_password_backend_btn').click(function () {
      var password = $('#reset_password_field').val().trim();
      var password_repeat = $('#reset_password_r_field').val().trim();
      var user_id = $(this).attr('user_id');

      $.ajax({
        type: 'POST',
        url: rootUrl + 'Frontend/reset_password_backend',
        data: {
          password: password,
          password_repeat: password_repeat,
          user_id: user_id,
        },

        success: function (data) {
          data = JSON.parse(data);
          if (data.success == true) {
            $('.treat_error_msg').text(data.message).css('color', 'green');

            setTimeout(function () {
              window.location.href = rootUrl + 'backend';
            }, 1500);
          } else {
            $('.treat_error_msg').text(data.message);
          }
        },
      });
    });

  // logout
  $('#logout_btn').click(function () {
    $.ajax({
      type: 'POST',
      url: rootUrl + 'Frontend/logout',
      data: {},

      success: function (data) {
        window.location.reload();
        //console.log(data);
      },
    });
  });
  // end log in and reset password

  $('.treat_input').on('keyup', function () {
    add_fields_titles();
  });

  function add_fields_titles() {
    $('.treat_input_container').each(function () {
      var input = $(this).find('.treat_input');
      var val = input.val().trim();
      var placeholder = input.attr('placeholder');

      if (val != '') {
        if (!$(this).hasClass('has_title')) {
          $(this).addClass('has_title');
          $(this).append(
            '<div class="treat_input_field_title semibold">' +
              placeholder +
              '</div>',
          );
        }
      } else {
        $(this).removeClass('has_title');
        $(this).find('.treat_input_field_title').remove();
      }
    });
  }
  add_fields_titles();

  //******** end forms ********/

  // lazy load the result images
  lazy_load_start();

  var lazy_int = setInterval(function () {
    lazy_load_start();
  }, 100);

  setTimeout(function () {
    clearInterval(lazy_int);
  }, 10000);

  function lazy_load_start() {
    if ($('.lazy').length != 0) {
      $('.lazy').Lazy({
        // your configuration goes here
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        threshold: 1000,
        onError: function (element) {},
        afterLoad: function (element) {
          //console.log("loaded");
        },
      });
    }
  }
}

// search LP tags

function update_by_tags() {
  if ($('.filterBarInput .filterElem').length > 0) {
    $('.filterBarInput .filterElem').each(function () {
      var val = $(this).text().trim().toLowerCase();
      var target = $('.groupElemWrapper');

      $(target).each(function () {
        var target_html = $(this).find('.groupElemCat').html().toLowerCase();
        if (target_html.includes(val)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

      $('.groupContainer').each(function () {
        var children = $(this).find('.groupElemWrapper:visible');
        if (children.length == 0) {
          $(this).hide();
        }
      });
    });
  } else {
    $('.groupElemWrapper').show();
    $('.groupContainer').show();
  }
}
